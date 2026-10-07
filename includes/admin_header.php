<?php
define('IN_ADMIN', true);
ob_start();
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/logo.php';
require_login(); require_admin(); // server-side check on every admin request
$cur = basename($_SERVER['SCRIPT_NAME']);
$pendingN = (int)db()->query("SELECT COUNT(*) FROM Booking WHERE Status='Pending'")->fetchColumn();
$unreadN = (int)db()->query('SELECT COUNT(*) FROM ContactMessage WHERE IsRead=0')->fetchColumn();
$nav = [['index.php', 'Dashboard', ['index.php'], 0], ['expeditions.php', 'Expeditions', ['expeditions.php', 'expedition_form.php'], 0], ['destinations.php', 'Destinations', ['destinations.php', 'destination_form.php'], 0],
  ['bookings.php', 'Bookings', ['bookings.php', 'booking.php'], $pendingN], ['reviews.php', 'Reviews', ['reviews.php'], 0], ['journal.php', 'Journal', ['journal.php', 'journal_view.php'], 0], ['messages.php', 'Messages', ['messages.php', 'message.php'], $unreadN]];
?><!doctype html><html lang="en"><head><?php $title = ($title ?? 'Admin') . ' (Admin)'; require __DIR__ . '/head.php'; ?><meta name="robots" content="noindex"></head>
<body class="bg-[#EEF0EC] text-ink min-h-screen md:flex">
<aside class="md:w-60 shrink-0 bg-ink text-bone logo-on-dark md:min-h-screen">
  <div class="flex items-center justify-between px-5 h-16 border-b border-white/10"><a href="index.php" aria-label="Admin dashboard"><?=logo_full()?></a>
    <button data-toggle="admin-nav" aria-expanded="false" class="md:hidden border border-white/25 rounded px-3 py-1 text-sm">Menu</button></div>
  <nav id="admin-nav" class="hidden md:block px-3 py-4 space-y-1" aria-label="Admin">
    <?php foreach ($nav as [$href, $label, $m, $n]): $on = in_array($cur, $m); ?>
      <a href="<?=$href?>" <?=$on ? 'aria-current="page"' : ''?> class="flex justify-between items-center px-3 py-2 rounded text-sm font-medium <?=$on ? 'bg-amber text-ink' : 'hover:bg-white/10'?>"><?=$label?><?php if ($n): ?><span class="text-xs rounded-full px-2 <?=$on ? 'bg-ink text-bone' : 'bg-amber text-ink'?>"><?=$n?></span><?php endif; ?></a>
    <?php endforeach; ?>
    <div class="border-t border-white/10 mt-4 pt-4 text-sm space-y-1"><a class="block px-3 py-2 hover:text-amber" href="../index.php">View public site</a><a class="block px-3 py-2 hover:text-amber" href="../logout.php">Log out</a></div>
  </nav>
</aside>
<main id="main" class="flex-1 min-w-0 p-5 md:p-8">
<?php foreach (take_flashes() as [$t, $m]): ?><p role="status" class="mb-4 p-3 rounded <?=$t === 'err' ? 'bg-red-100 text-red-900' : 'bg-forest text-bone'?>"><?=e($m)?></p><?php endforeach; ?>
