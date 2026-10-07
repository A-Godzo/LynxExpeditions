<?php $title = 'Dashboard'; require __DIR__ . '/../includes/admin_header.php'; require __DIR__ . '/../includes/admin_ui.php';
$one = fn($sql) => (int)db()->query($sql)->fetchColumn();
$stats = [['Active expeditions', $one('SELECT COUNT(*) FROM Expedition WHERE IsActive=1'), 'expeditions.php'], ['Pending bookings', $pendingN, 'bookings.php?status=Pending'], ['Unread messages', $unreadN, 'messages.php?filter=unread']];
$bookings = db()->query('SELECT b.*,u.FirstName,u.LastName,e.Name FROM Booking b JOIN User u ON u.Id=b.UserId JOIN Expedition e ON e.Id=b.ExpeditionId ORDER BY b.BookingDate DESC,b.Id DESC LIMIT 6')->fetchAll();
$posts = db()->query('SELECT p.*,u.FirstName,u.LastName FROM JournalPost p JOIN User u ON u.Id=p.AuthorId ORDER BY p.PublishedAt DESC,p.Id DESC LIMIT 5')->fetchAll(); ?>
<h1 class="font-display text-4xl">Dashboard</h1>
<div class="mt-6 grid sm:grid-cols-3 gap-4"><?php foreach ($stats as [$l, $n, $h]): ?><a href="<?=$h?>" class="<?=$card?> p-5 hover:shadow-md transition"><p class="text-sm text-ink/60"><?=$l?></p><p class="font-display text-5xl mt-1"><?=$n?></p></a><?php endforeach; ?></div>
<div class="mt-8 grid xl:grid-cols-3 gap-6">
<section class="<?=$card?> xl:col-span-2 overflow-x-auto"><div class="flex justify-between items-center p-4"><h2 class="font-display text-2xl">Recent bookings</h2><a class="text-sm underline" href="bookings.php">All bookings</a></div>
<table class="w-full"><thead><tr><th class="<?=$th?>">ID</th><th class="<?=$th?>">Customer</th><th class="<?=$th?>">Expedition</th><th class="<?=$th?>">Travelers</th><th class="<?=$th?>">Status</th></tr></thead><tbody>
<?php foreach ($bookings as $b): ?><tr class="border-t border-stone"><td class="<?=$td?>"><a class="underline" href="booking.php?id=<?=$b['Id']?>">#<?=$b['Id']?></a></td><td class="<?=$td?>"><?=e(full_name($b))?></td><td class="<?=$td?>"><?=e($b['Name'])?></td><td class="<?=$td?>"><?=$b['NumberOfTravelers']?></td><td class="<?=$td?>"><?=badge($b['Status'])?></td></tr><?php endforeach; ?>
<?php if (!$bookings): ?><tr><td colspan="5" class="<?=$td?>">No bookings yet.</td></tr><?php endif; ?></tbody></table></section>
<section class="<?=$card?> p-4"><div class="flex justify-between items-center"><h2 class="font-display text-2xl">Recent Journal posts</h2><a class="text-sm underline" href="journal.php">All</a></div>
<ul class="mt-3 divide-y divide-stone"><?php foreach ($posts as $p): ?><li class="py-3 text-sm"><a class="font-semibold underline" href="journal_view.php?id=<?=$p['Id']?>"><?=e($p['Title'])?></a><br><span class="text-ink/60"><?=e(full_name($p))?>, <?=fmt_date($p['PublishedAt'])?></span></li><?php endforeach; if (!$posts): ?><li class="py-3 text-sm">No posts yet.</li><?php endif; ?></ul></section></div>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
