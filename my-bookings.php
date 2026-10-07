<?php $title = 'My Trips'; require 'includes/header.php'; require_login();
$s = db()->prepare('SELECT b.*,e.Name,e.StartDate,e.EndDate FROM Booking b JOIN Expedition e ON e.Id=b.ExpeditionId WHERE b.UserId=? ORDER BY b.BookingDate DESC,b.Id DESC'); $s->execute([user()['Id']]); $rows = $s->fetchAll(); $acct = 'trips'; ?>
<div class="max-w-7xl mx-auto px-4 py-12"><h1 class="font-display text-5xl">My Trips</h1>
<div class="mt-8 flex flex-col md:flex-row gap-8"><?php include 'includes/account_nav.php'; ?>
<div class="flex-1"><?php if (!$rows): ?><p>You have no booking requests yet. <a class="underline" href="expeditions.php">Browse expeditions</a>.</p><?php else: ?>
<div class="space-y-4"><?php foreach ($rows as $b): ?><article class="bg-white border border-stone rounded-lg p-5 flex flex-wrap items-center justify-between gap-4">
  <div><p class="text-sm text-ink/60">Booking #<?=$b['Id']?>, requested <?=fmt_date($b['BookingDate'])?></p><h2 class="font-display text-3xl"><?=e($b['Name'])?></h2>
  <p class="text-sm"><?=fmt_date($b['StartDate'])?> to <?=fmt_date($b['EndDate'])?>, <?=$b['NumberOfTravelers']?> traveler<?=$b['NumberOfTravelers'] > 1 ? 's' : ''?></p></div>
  <div class="flex items-center gap-4"><?=badge($b['Status'])?><a class="text-sm font-semibold underline decoration-amber decoration-2 underline-offset-4" href="booking.php?id=<?=$b['Id']?>">Booking details</a></div></article><?php endforeach; ?></div><?php endif; ?></div></div></div>
<?php require 'includes/footer.php'; ?>
