<?php $title = 'Reviews'; require __DIR__ . '/../includes/admin_header.php'; require __DIR__ . '/../includes/admin_ui.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf(); db()->prepare('DELETE FROM Review WHERE Id=?')->execute([(int)($_POST['id'] ?? 0)]); flash('Review deleted.'); go('reviews.php'); }
[$page, $off, $pages] = paginate((int)db()->query('SELECT COUNT(*) FROM Review')->fetchColumn(), 20);
$rows = db()->query("SELECT r.*,u.FirstName,u.LastName,e.Name FROM Review r JOIN User u ON u.Id=r.UserId JOIN Expedition e ON e.Id=r.ExpeditionId ORDER BY r.CreatedAt DESC,r.Id DESC LIMIT 20 OFFSET $off")->fetchAll(); ?>
<h1 class="font-display text-4xl">Reviews</h1>
<div class="<?=$card?> mt-6 overflow-x-auto"><table class="w-full"><thead><tr><th class="<?=$th?>">Expedition</th><th class="<?=$th?>">Author</th><th class="<?=$th?>">Rating</th><th class="<?=$th?>">Comment</th><th class="<?=$th?>">Date</th><th class="<?=$th?>"></th></tr></thead><tbody>
<?php foreach ($rows as $r): ?><tr class="border-t border-stone"><td class="<?=$td?>"><?=e($r['Name'])?></td><td class="<?=$td?>"><?=e(full_name($r))?></td><td class="<?=$td?> whitespace-nowrap"><?=stars((int)$r['Rating'])?></td><td class="<?=$td?> max-w-md whitespace-pre-line"><?=e($r['Comment'])?></td><td class="<?=$td?> whitespace-nowrap"><?=fmt_date($r['CreatedAt'])?></td>
<td class="<?=$td?>"><form method="post" onsubmit="return confirm('Delete this review?')"><?=csrf_field()?><input type="hidden" name="id" value="<?=$r['Id']?>"><button class="<?=$danger?>">Delete</button></form></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="6" class="<?=$td?>">No reviews yet.</td></tr><?php endif; ?></tbody></table></div><?=pager($page, $pages)?>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
