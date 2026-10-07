<?php $title = 'Notifications'; require 'includes/header.php'; require_login(); $uid = (int)user()['Id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf();
  if (($_POST['action'] ?? '') === 'all') db()->prepare('UPDATE Notification SET IsRead=1 WHERE UserId=?')->execute([$uid]);
  else db()->prepare('UPDATE Notification SET IsRead=1 WHERE Id=? AND UserId=?')->execute([(int)($_POST['id'] ?? 0), $uid]);
  go('notifications.php'); }
$s = db()->prepare('SELECT * FROM Notification WHERE UserId=? ORDER BY CreatedAt DESC,Id DESC LIMIT 100'); $s->execute([$uid]); $rows = $s->fetchAll(); $acct = 'notes'; ?>
<div class="max-w-7xl mx-auto px-4 py-12"><h1 class="font-display text-5xl">Notifications</h1>
<div class="mt-8 flex flex-col md:flex-row gap-8"><?php include 'includes/account_nav.php'; ?>
<div class="flex-1 max-w-2xl"><?php if ($unread): ?><form method="post" class="mb-4"><?=csrf_field()?><input type="hidden" name="action" value="all"><button class="text-sm underline">Mark all as read</button></form><?php endif; ?>
<?php if (!$rows): ?><p>No notifications yet. We will tell you here when a booking status changes.</p><?php endif; ?>
<ul class="space-y-3"><?php foreach ($rows as $n): ?><li class="flex items-start justify-between gap-4 rounded-lg p-4 border <?=$n['IsRead'] ? 'bg-white border-stone' : 'bg-amber/15 border-amber'?>">
  <div><?php if (!$n['IsRead']): ?><span class="inline-block bg-amber text-ink text-xs font-bold px-2 rounded mr-2">New</span><?php endif; ?><?=e($n['Message'])?><p class="text-xs text-ink/60 mt-1"><?=fmt_date($n['CreatedAt'], 'j M Y, H:i')?></p></div>
  <?php if (!$n['IsRead']): ?><form method="post"><?=csrf_field()?><input type="hidden" name="id" value="<?=$n['Id']?>"><button class="text-sm underline whitespace-nowrap">Mark read</button></form><?php endif; ?></li><?php endforeach; ?></ul>
<p class="mt-6 text-sm"><a class="underline" href="my-bookings.php">Go to My Trips</a></p></div></div></div>
<?php require 'includes/footer.php'; ?>
