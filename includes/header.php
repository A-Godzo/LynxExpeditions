<?php
ob_start(); // lets pages redirect after including the header
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/logo.php';
$cur = basename($_SERVER['SCRIPT_NAME']);
$navCats = db()->query('SELECT Id,Name FROM Category ORDER BY Id')->fetchAll();
$unread = unread_count();
$lk = fn($file, $label, $match = null) => '<a href="' . $file . '" class="px-3 py-2 text-sm font-medium hover:text-amber ' . (in_array($cur, (array)($match ?? $file)) ? 'text-amber' : '') . '"' . (in_array($cur, (array)($match ?? $file)) ? ' aria-current="page"' : '') . '>' . $label . '</a>';
?><!doctype html>
<html lang="en"><head><?php require __DIR__ . '/head.php'; ?></head>
<body class="min-h-screen flex flex-col">
<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-amber focus:text-ink focus:p-3">Skip to content</a>
<header class="sticky top-0 z-40 bg-ink text-bone logo-on-dark border-b border-white/10">
  <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between gap-4">
    <a href="index.php" aria-label="Lynx Expeditions home"><?=logo_full()?></a>
    <nav class="hidden lg:flex items-center" aria-label="Main">
      <?=$lk('index.php', 'Home')?>
      <div class="relative">
        <button data-toggle="dd-exp" data-dropdown aria-expanded="false" aria-haspopup="true" class="px-3 py-2 text-sm font-medium hover:text-amber <?=in_array($cur, ['expeditions.php', 'expedition.php']) ? 'text-amber' : ''?>">Expeditions <span aria-hidden="true">&#9662;</span></button>
        <div id="dd-exp" data-dropdown-panel class="hidden absolute left-0 top-full mt-1 w-56 bg-white text-ink rounded-lg shadow-lg border border-stone py-2">
          <a class="block px-4 py-2 text-sm hover:bg-bone" href="expeditions.php">All Expeditions</a>
          <?php foreach ($navCats as $c): ?><a class="block px-4 py-2 text-sm hover:bg-bone" href="expeditions.php?category=<?=$c['Id']?>"><?=e($c['Name'])?></a><?php endforeach; ?>
        </div>
      </div>
      <?=$lk('destinations.php', 'Destinations', ['destinations.php', 'destination.php'])?>
      <?=$lk('services.php', 'Services')?>
      <?=$lk('about.php', 'About &amp; Contact')?>
      <?=$lk('journal.php', 'The Lynx Journal', ['journal.php', 'article.php', 'journal_new.php'])?>
      <?=$lk('faq.php', 'FAQ')?>
    </nav>
    <div class="flex items-center gap-2">
      <?php if (user()): ?>
        <div class="relative hidden lg:block">
          <button data-toggle="dd-acct" data-dropdown aria-expanded="false" aria-haspopup="true" class="px-3 py-2 text-sm font-medium border border-white/25 rounded hover:border-amber">
            <?=e(user()['FirstName'])?><?php if ($unread): ?> <span class="ml-1 bg-amber text-ink rounded-full px-2 text-xs font-bold" aria-label="<?=$unread?> unread notifications"><?=$unread?></span><?php endif; ?>
          </button>
          <div id="dd-acct" data-dropdown-panel class="hidden absolute right-0 top-full mt-1 w-56 bg-white text-ink rounded-lg shadow-lg border border-stone py-2">
            <a class="block px-4 py-2 text-sm hover:bg-bone" href="account.php">My Account</a>
            <a class="block px-4 py-2 text-sm hover:bg-bone" href="my-bookings.php">My Trips</a>
            <a class="block px-4 py-2 text-sm hover:bg-bone" href="favorites.php">My Favorites</a>
            <a class="block px-4 py-2 text-sm hover:bg-bone" href="notifications.php">Notifications<?=$unread ? " ($unread)" : ''?></a>
            <a class="block px-4 py-2 text-sm hover:bg-bone border-t border-stone mt-1" href="logout.php">Log out</a>
          </div>
        </div>
      <?php else: ?>
        <a href="auth.php" class="hidden lg:inline px-3 py-2 text-sm font-medium hover:text-amber">Log in</a>
        <a href="auth.php?mode=register" class="hidden lg:inline bg-amber text-ink px-4 py-2 rounded text-sm font-semibold">Register</a>
      <?php endif; ?>
      <button data-toggle="mobile-menu" aria-expanded="false" aria-controls="mobile-menu" class="lg:hidden p-2 border border-white/25 rounded" aria-label="Menu">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg></button>
    </div>
  </div>
  <nav id="mobile-menu" class="hidden lg:hidden border-t border-white/10 px-4 py-3 space-y-1" aria-label="Mobile">
    <a class="block py-2" href="index.php">Home</a>
    <a class="block py-2" href="expeditions.php">All Expeditions</a>
    <?php foreach ($navCats as $c): ?><a class="block py-2 pl-4 text-bone/80" href="expeditions.php?category=<?=$c['Id']?>"><?=e($c['Name'])?></a><?php endforeach; ?>
    <a class="block py-2" href="destinations.php">Destinations</a><a class="block py-2" href="services.php">Services</a>
    <a class="block py-2" href="about.php">About &amp; Contact</a><a class="block py-2" href="journal.php">The Lynx Journal</a><a class="block py-2" href="faq.php">FAQ</a>
    <div class="border-t border-white/10 pt-2">
    <?php if (user()): ?>
      <a class="block py-2" href="account.php">My Account</a><a class="block py-2" href="my-bookings.php">My Trips</a><a class="block py-2" href="favorites.php">My Favorites</a>
      <a class="block py-2" href="notifications.php">Notifications<?=$unread ? " ($unread)" : ''?></a><a class="block py-2" href="logout.php">Log out</a>
    <?php else: ?><a class="block py-2" href="auth.php">Log in</a><a class="block py-2" href="auth.php?mode=register">Register</a><?php endif; ?>
    </div>
  </nav>
</header>
<main id="main" class="flex-1">
<?php foreach (take_flashes() as [$t, $m]): ?><div role="status" class="max-w-7xl mx-auto mt-4 mx-4 px-4"><p class="p-3 rounded <?=$t === 'err' ? 'bg-red-100 text-red-900' : 'bg-forest text-bone'?>"><?=e($m)?></p></div><?php endforeach; ?>
