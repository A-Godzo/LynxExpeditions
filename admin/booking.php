<?php $title = 'Booking'; require __DIR__ . '/../includes/admin_header.php'; require __DIR__ . '/../includes/admin_ui.php';
$id = (int)($_GET['id'] ?? 0);
$load = function () use ($id) { $s = db()->prepare('SELECT b.*,u.FirstName,u.LastName,u.Email,e.Name,e.MaxGroupSize,e.StartDate,e.EndDate FROM Booking b JOIN User u ON u.Id=b.UserId JOIN Expedition e ON e.Id=b.ExpeditionId WHERE b.Id=?'); $s->execute([$id]); return $s->fetch(); };
$b = $load(); if (!$b) { flash('Booking not found.', 'err'); go('bookings.php'); }
$allowed = ['Pending' => ['Confirmed', 'Rejected', 'Cancelled'], 'Confirmed' => ['Cancelled']][$b['Status']] ?? []; // Rejected and Cancelled are final
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf(); $msg = trim($_POST['admin_message'] ?? ''); $new = $_POST['status'] ?? '';
  if (mb_strlen($msg) > 2000) { flash('The message is too long.', 'err'); go("booking.php?id=$id"); }
  if ($new !== '' && $new !== $b['Status']) {
    if (!in_array($new, $allowed, true)) { flash('That status change is not allowed.', 'err'); go("booking.php?id=$id"); }
    $pdo = db(); $pdo->beginTransaction();
    $pdo->prepare('UPDATE Booking SET Status=?,AdminMessage=? WHERE Id=?')->execute([$new, $msg ?: null, $id]);
    $text = ['Confirmed' => 'has been confirmed', 'Rejected' => 'could not be accepted', 'Cancelled' => 'has been cancelled'][$new];
    notify((int)$b['UserId'], "Your booking #$id for {$b['Name']} $text." . ($msg ? ' Message from Lynx: ' . $msg : ''));
    $pdo->commit(); flash("Booking marked as $new and the customer was notified.");
  } else { db()->prepare('UPDATE Booking SET AdminMessage=? WHERE Id=?')->execute([$msg ?: null, $id]); flash('Message saved.'); }
  go("booking.php?id=$id"); }
$left = $b['MaxGroupSize'] - booked_travelers((int)$b['ExpeditionId']); ?>
<a href="bookings.php" class="text-sm underline">Back to bookings</a>
<div class="flex items-center gap-4 mt-1"><h1 class="font-display text-4xl">Booking #<?=$b['Id']?></h1><?=badge($b['Status'])?></div>
<div class="mt-6 grid lg:grid-cols-2 gap-6 max-w-5xl">
<section class="<?=$card?> p-6"><h2 class="font-display text-2xl">Details</h2><dl class="mt-3 space-y-2 text-sm">
<div><dt class="text-ink/60">Customer</dt><dd><?=e(full_name($b))?>, <a class="underline" href="mailto:<?=e($b['Email'])?>?subject=<?=rawurlencode('Your Lynx booking #' . $b['Id'])?>"><?=e($b['Email'])?></a></dd></div>
<div><dt class="text-ink/60">Expedition</dt><dd><?=e($b['Name'])?>, <?=fmt_date($b['StartDate'])?> to <?=fmt_date($b['EndDate'])?></dd></div>
<div><dt class="text-ink/60">Travelers</dt><dd><?=$b['NumberOfTravelers']?></dd></div>
<div><dt class="text-ink/60">Places left on this expedition</dt><dd><?=max(0, $left)?> of <?=$b['MaxGroupSize']?> (pending and confirmed requests included)</dd></div>
<div><dt class="text-ink/60">Requested</dt><dd><?=fmt_date($b['BookingDate'], 'j M Y, H:i')?></dd></div>
<div><dt class="text-ink/60">Customer message</dt><dd class="whitespace-pre-line"><?=$b['CustomerMessage'] ? e($b['CustomerMessage']) : 'None'?></dd></div></dl></section>
<section class="<?=$card?> p-6"><h2 class="font-display text-2xl">Respond</h2>
<form method="post" class="mt-3 space-y-3"><?=csrf_field()?>
<label class="block text-sm font-medium">Message to customer (shown on their booking and in the notification)<textarea name="admin_message" rows="4" class="<?=$input?>"><?=e($b['AdminMessage'])?></textarea></label>
<div class="flex flex-wrap gap-2">
<?php $cls = ['Confirmed' => $btn, 'Rejected' => $danger, 'Cancelled' => $danger]; foreach ($allowed as $s): ?><button name="status" value="<?=$s?>" class="<?=$cls[$s]?>" <?=$s !== 'Confirmed' ? "onclick=\"return confirm('Mark this booking as $s?')\"" : ''?>><?=$s === 'Confirmed' ? 'Confirm' : ($s === 'Rejected' ? 'Reject' : 'Cancel booking')?></button><?php endforeach; ?>
<button name="status" value="" class="<?=$btn2?>">Save message only</button></div>
<?php if (!$allowed): ?><p class="text-sm text-ink/60">This booking is <?=strtolower($b['Status'])?> and its status can no longer change.</p><?php endif; ?></form></section></div>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
