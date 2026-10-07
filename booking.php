<?php $title = 'Booking details'; require 'includes/header.php'; require_login();
$s = db()->prepare('SELECT b.*,e.Name,e.StartDate,e.EndDate,e.Price,e.DepartureLocation,e.DurationDays FROM Booking b JOIN Expedition e ON e.Id=b.ExpeditionId WHERE b.Id=? AND b.UserId=?');
$s->execute([(int)($_GET['id'] ?? 0), user()['Id']]); $b = $s->fetch(); // only the owner can see a booking
if (!$b) require 'includes/not_found.php';
$canReview = can_review((int)user()['Id'], (int)$b['ExpeditionId']); $acct = 'trips'; ?>
<div class="max-w-7xl mx-auto px-4 py-12"><a href="my-bookings.php" class="text-sm underline">Back to My Trips</a><h1 class="font-display text-5xl mt-2">Booking #<?=$b['Id']?></h1>
<div class="mt-8 flex flex-col md:flex-row gap-8"><?php include 'includes/account_nav.php'; ?>
<div class="flex-1 max-w-2xl space-y-6">
<div class="bg-white border border-stone rounded-lg p-6"><div class="flex justify-between items-start gap-4"><h2 class="font-display text-3xl"><?=e($b['Name'])?></h2><?=badge($b['Status'])?></div>
<dl class="mt-4 grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
<div><dt class="text-ink/60">Dates</dt><dd><?=fmt_date($b['StartDate'])?> to <?=fmt_date($b['EndDate'])?> (<?=$b['DurationDays']?> days)</dd></div>
<div><dt class="text-ink/60">Departure</dt><dd><?=e($b['DepartureLocation'])?></dd></div>
<div><dt class="text-ink/60">Travelers</dt><dd><?=$b['NumberOfTravelers']?></dd></div>
<div><dt class="text-ink/60">Price per person</dt><dd>€<?=number_format($b['Price'], 0)?>, paid separately</dd></div>
<div><dt class="text-ink/60">Requested on</dt><dd><?=fmt_date($b['BookingDate'], 'j M Y, H:i')?></dd></div></dl></div>
<?php if ($b['CustomerMessage']): ?><div class="bg-white border border-stone rounded-lg p-6"><h3 class="font-display text-2xl">Your message</h3><p class="mt-2 whitespace-pre-line"><?=e($b['CustomerMessage'])?></p></div><?php endif; ?>
<?php if ($b['AdminMessage']): ?><div class="bg-forest text-bone rounded-lg p-6"><h3 class="font-display text-2xl">Message from Lynx</h3><p class="mt-2 whitespace-pre-line"><?=e($b['AdminMessage'])?></p></div><?php endif; ?>
<p class="text-sm text-ink/70">Need to change or cancel? Bookings can only be cancelled by our team, so please <a class="underline" href="about.php#contact">contact us</a>.</p>
<p><a class="underline" href="expedition.php?id=<?=$b['ExpeditionId']?>">View expedition</a><?php if ($canReview): ?> &middot; <a class="underline font-semibold" href="expedition.php?id=<?=$b['ExpeditionId']?>#reviews">Write a review</a><?php endif; ?></p>
</div></div></div>
<?php require 'includes/footer.php'; ?>
