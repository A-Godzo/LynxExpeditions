<?php $title = 'My Account'; require 'includes/header.php'; require_login();
$uid = (int)user()['Id']; $err = $pwerr = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf();
  if (($_POST['action'] ?? '') === 'profile') {
    $fn = trim($_POST['first'] ?? ''); $ln = trim($_POST['last'] ?? ''); $em = strtolower(trim($_POST['email'] ?? ''));
    if (!$fn || !$ln || !filter_var($em, FILTER_VALIDATE_EMAIL)) $err = 'Fill in all fields with a valid email.';
    else { try { db()->prepare('UPDATE User SET FirstName=?,LastName=?,Email=? WHERE Id=?')->execute([$fn, $ln, $em, $uid]);
      $_SESSION['user']['FirstName'] = $fn; $_SESSION['user']['LastName'] = $ln; $_SESSION['user']['Email'] = $em; flash('Profile updated.'); go('account.php'); }
      catch (PDOException $ex) { $err = 'That email is already used by another account.'; } }
  } elseif (($_POST['action'] ?? '') === 'password') {
    $s = db()->prepare('SELECT PasswordHash FROM User WHERE Id=?'); $s->execute([$uid]); $h = $s->fetchColumn(); $new = $_POST['new'] ?? '';
    if (!password_verify($_POST['current'] ?? '', $h)) $pwerr = 'Your current password is incorrect.';
    elseif (strlen($new) < 8) $pwerr = 'Use a new password of at least 8 characters.';
    elseif ($new !== ($_POST['confirm'] ?? '')) $pwerr = 'The new passwords do not match.';
    else { db()->prepare('UPDATE User SET PasswordHash=? WHERE Id=?')->execute([password_hash($new, PASSWORD_DEFAULT), $uid]); session_regenerate_id(true); flash('Password changed.'); go('account.php'); } } }
$q = db()->prepare("SELECT b.*,e.Name,e.StartDate,e.EndDate,e.FeaturedImage FROM Booking b JOIN Expedition e ON e.Id=b.ExpeditionId WHERE b.UserId=? AND b.Status='Confirmed' AND e.StartDate>=CURDATE() ORDER BY e.StartDate LIMIT 1"); $q->execute([$uid]); $next = $q->fetch();
$cnt = function ($sql) use ($uid) { $s = db()->prepare($sql); $s->execute([$uid]); return (int)$s->fetchColumn(); };
$pending = $cnt("SELECT COUNT(*) FROM Booking WHERE UserId=? AND Status='Pending'"); $favs = $cnt('SELECT COUNT(*) FROM Favorite WHERE UserId=?');
$c = 'mt-1 w-full border border-stone rounded px-3 py-2 bg-white'; $acct = 'account'; $u = user(); ?>
<div class="max-w-7xl mx-auto px-4 py-12"><h1 class="font-display text-5xl">Hello, <?=e($u['FirstName'])?></h1>
<div class="mt-8 flex flex-col md:flex-row gap-8"><?php include 'includes/account_nav.php'; ?>
<div class="flex-1 space-y-8">
  <section aria-labelledby="nt"><h2 id="nt" class="font-display text-3xl">Next trip</h2>
  <?php if ($next): ?><a href="booking.php?id=<?=$next['Id']?>" class="mt-3 flex gap-4 bg-white border border-stone rounded-lg overflow-hidden hover:shadow-md transition"><img src="<?=img($next['FeaturedImage'])?>" alt="" class="w-32 sm:w-48 object-cover"><div class="p-4"><p class="font-display text-3xl"><?=e($next['Name'])?></p><p class="text-sm mt-1"><?=fmt_date($next['StartDate'])?> to <?=fmt_date($next['EndDate'])?>, <?=$next['NumberOfTravelers']?> traveler<?=$next['NumberOfTravelers'] > 1 ? 's' : ''?></p><p class="mt-2"><?=badge($next['Status'])?></p></div></a>
  <?php else: ?><p class="mt-3 text-ink/70">No confirmed upcoming trip yet. <a class="underline" href="expeditions.php">Find an expedition</a>.</p><?php endif; ?>
  <p class="mt-4 text-sm text-ink/70"><?=$pending?> pending request<?=$pending == 1 ? '' : 's'?>, <?=$favs?> saved expedition<?=$favs == 1 ? '' : 's'?>, <?=$unread?> unread notification<?=$unread == 1 ? '' : 's'?>.</p></section>
  <section class="bg-white border border-stone rounded-lg p-6 max-w-lg"><h2 class="font-display text-3xl">Profile</h2>
  <?php if ($err): ?><p role="alert" class="mt-3 p-3 bg-red-100 text-red-900 rounded"><?=e($err)?></p><?php endif; ?>
  <form method="post" class="mt-4 space-y-3"><?=csrf_field()?><input type="hidden" name="action" value="profile">
  <label class="block text-sm">First name<input name="first" required value="<?=e($u['FirstName'])?>" class="<?=$c?>"></label>
  <label class="block text-sm">Last name<input name="last" required value="<?=e($u['LastName'])?>" class="<?=$c?>"></label>
  <label class="block text-sm">Email<input type="email" name="email" required value="<?=e($u['Email'])?>" class="<?=$c?>"></label>
  <button class="bg-forest text-bone px-5 py-2 rounded font-semibold">Save profile</button></form></section>
  <section class="bg-white border border-stone rounded-lg p-6 max-w-lg"><h2 class="font-display text-3xl">Change password</h2>
  <?php if ($pwerr): ?><p role="alert" class="mt-3 p-3 bg-red-100 text-red-900 rounded"><?=e($pwerr)?></p><?php endif; ?>
  <form method="post" class="mt-4 space-y-3"><?=csrf_field()?><input type="hidden" name="action" value="password">
  <label class="block text-sm">Current password<input type="password" name="current" required autocomplete="current-password" class="<?=$c?>"></label>
  <label class="block text-sm">New password<input type="password" name="new" required minlength="8" autocomplete="new-password" class="<?=$c?>"></label>
  <label class="block text-sm">Confirm new password<input type="password" name="confirm" required autocomplete="new-password" class="<?=$c?>"></label>
  <button class="bg-forest text-bone px-5 py-2 rounded font-semibold">Change password</button></form></section>
</div></div></div>
<?php require 'includes/footer.php'; ?>
