<?php
/* Lynx Expeditions: shared bootstrap (DB, session, auth, CSRF, helpers). */
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', '2592000'); // kolku "Remember me" pamtit
session_start();

const DB_DSN = 'mysql:host=localhost;dbname=lynx;charset=utf8mb4', DB_USER = 'root', DB_PASS = '';

define('ROOT', defined('IN_ADMIN') ? '../' : '');

if (!function_exists('mb_strlen')) { function mb_strlen($s) { return preg_match_all('/./su', (string)$s); } }
if (!function_exists('mb_substr')) { function mb_substr($s, $start, $len = null) { preg_match_all('/./su', (string)$s, $m); return implode('', array_slice($m[0], $start, $len)); } }

/* ---------- Databaza ---------- */
function db(): PDO { static $p; return $p ??= new PDO(DB_DSN, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]); }

/* ---------- Output / auth / CSRF ---------- */
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function user(): ?array { return $_SESSION['user'] ?? null; }
function require_login(): void { if (!user()) { header('Location: ' . ROOT . 'auth.php?next=' . urlencode($_SERVER['REQUEST_URI'])); exit; } }
function require_admin(): void { if ((user()['Role'] ?? '') !== 'Admin') { http_response_code(403); exit('Forbidden'); } }
function csrf(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(16)); }
function csrf_field(): string { return '<input type="hidden" name="csrf" value="' . csrf() . '">'; }
function check_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(400); exit('Invalid request'); } }

/* ---------- Logika ---------- */
/** broj na patnici sproti slobodni mesta */
function booked_travelers(int $id): int { $s = db()->prepare("SELECT COALESCE(SUM(NumberOfTravelers),0) FROM Booking WHERE ExpeditionId=? AND Status IN('Pending','Confirmed')"); $s->execute([$id]); return (int)$s->fetchColumn(); }
/** Za review samo posle od ko ce e prifaten */
function can_review(int $uid, int $eid): bool {
  $s = db()->prepare("SELECT (SELECT COUNT(*) FROM Booking WHERE UserId=? AND ExpeditionId=? AND Status='Confirmed') > 0 AND (SELECT COUNT(*) FROM Review WHERE UserId=? AND ExpeditionId=?) = 0");
  $s->execute([$uid, $eid, $uid, $eid]); return (bool)$s->fetchColumn();
}
function notify(int $uid, string $msg): void { db()->prepare('INSERT INTO Notification(UserId,Message) VALUES(?,?)')->execute([$uid, mb_substr($msg, 0, 255)]); }
function unread_count(): int { if (!user()) return 0; $s = db()->prepare('SELECT COUNT(*) FROM Notification WHERE UserId=? AND IsRead=0'); $s->execute([user()['Id']]); return (int)$s->fetchColumn(); }
function fav_ids(): array {
  static $ids; if ($ids === null) { $ids = []; if (user()) { $s = db()->prepare('SELECT ExpeditionId FROM Favorite WHERE UserId=?'); $s->execute([user()['Id']]); $ids = array_map('intval', $s->fetchAll(PDO::FETCH_COLUMN)); } }
  return $ids;
}

function img(?string $p): string { $p = $p ?: 'assets/placeholder.jpg'; if (!preg_match('~^(https?:)?//|^/~', $p)) $p = ROOT . $p; return e($p); }
function go(string $url): void { header('Location: ' . $url); exit; }
function flash(string $msg, string $type = 'ok'): void { $_SESSION['flash'][] = [$type, $msg]; }
function take_flashes(): array { $f = $_SESSION['flash'] ?? []; unset($_SESSION['flash']); return $f; }
function fmt_date($d, string $f = 'j M Y'): string { return $d ? date($f, strtotime($d)) : ''; }
function full_name(array $r, string $fn = 'FirstName', string $ln = 'LastName'): string { return trim($r[$fn] . ' ' . $r[$ln]); }
function stars(int $n): string { return '<span class="text-amber" role="img" aria-label="' . $n . ' out of 5">' . str_repeat('★', $n) . '<span class="text-stone">' . str_repeat('★', 5 - $n) . '</span></span>'; }
function lines(?string $t): array { return array_values(array_filter(array_map('trim', explode("\n", (string)$t)), fn($l) => $l !== '')); }
function excerpt(string $t, int $n = 220): string { $t = trim(preg_replace('/\s+/', ' ', $t)); return mb_strlen($t) > $n ? rtrim(mb_substr($t, 0, $n)) . '…' : $t; }
function badge(string $s): string {
  $c = ['Pending' => 'bg-amber/25 text-ink', 'Confirmed' => 'bg-forest text-bone', 'Rejected' => 'bg-red-100 text-red-900', 'Cancelled' => 'bg-stone text-ink'][$s] ?? 'bg-stone text-ink';
  return '<span class="inline-block rounded-full px-3 py-1 text-xs font-semibold ' . $c . '">' . e($s) . '</span>';
}
function slugify(string $t): string {
  $t = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $t) ?: $t), '-'));
  return $t !== '' ? substr($t, 0, 120) : 'post';
}
function paginate(int $total, int $per = 15): array { $pages = max(1, (int)ceil($total / $per)); $page = min($pages, max(1, (int)($_GET['page'] ?? 1))); return [$page, ($page - 1) * $per, $pages]; }
function pager(int $page, int $pages): string {
  if ($pages < 2) return '';
  $link = fn($p, $t) => '<a class="px-4 py-2 border border-stone rounded bg-white hover:bg-stone" href="?' . e(http_build_query(array_merge($_GET, ['page' => $p]))) . '">' . $t . '</a>';
  return '<nav class="mt-8 flex items-center gap-3 text-sm" aria-label="Pagination">' . ($page > 1 ? $link($page - 1, 'Newer') : '') . '<span>Page ' . $page . ' of ' . $pages . '</span>' . ($page < $pages ? $link($page + 1, 'Older') : '') . '</nav>';
}

/* ---------- Image handling ko ce spustat adminon ---------- */
function store_image(array $f): ?string {
  if (($f['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
  if ($f['error'] !== UPLOAD_ERR_OK || $f['size'] > 5 * 1024 * 1024) throw new RuntimeException('Image upload failed or is larger than 5 MB.');
  $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name'])] ?? null;
  if (!$ext) throw new RuntimeException('Only JPG, PNG or WebP images are allowed.');
  $dir = dirname(__DIR__) . '/uploads/'; if (!is_dir($dir)) mkdir($dir, 0755, true);
  $name = bin2hex(random_bytes(10)) . '.' . $ext;
  if (!move_uploaded_file($f['tmp_name'], $dir . $name)) throw new RuntimeException('Could not save the uploaded image.');
  return 'uploads/' . $name;
}
function uploaded_files(string $field): array { // normalises $_FILES for single or multiple inputs
  $f = $_FILES[$field] ?? null; if (!$f) return [];
  if (!is_array($f['name'])) return [$f];
  $out = []; foreach ($f['name'] as $i => $_) $out[] = ['name' => $f['name'][$i], 'tmp_name' => $f['tmp_name'][$i], 'error' => $f['error'][$i], 'size' => $f['size'][$i]];
  return $out;
}
function safe_image_ref(string $s): ?string { $s = trim($s); return ($s !== '' && !str_contains($s, '..') && preg_match('~^(https://|assets/|uploads/)~', $s)) ? $s : null; }
function remove_local_image(?string $p): void { if ($p && str_starts_with($p, 'uploads/') && !str_contains($p, '..')) @unlink(dirname(__DIR__) . '/' . $p); }
