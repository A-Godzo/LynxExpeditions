<?php $title = 'My Favorites'; require 'includes/header.php'; require_login();
$s = db()->prepare('SELECT e.*,c.Name Category FROM Favorite f JOIN Expedition e ON e.Id=f.ExpeditionId JOIN Category c ON c.Id=e.CategoryId WHERE f.UserId=? AND e.IsActive=1 ORDER BY f.CreatedAt DESC'); $s->execute([user()['Id']]); $rows = $s->fetchAll(); $acct = 'favs'; ?>
<div class="max-w-7xl mx-auto px-4 py-12"><h1 class="font-display text-5xl">My Favorites</h1>
<div class="mt-8 flex flex-col md:flex-row gap-8"><?php include 'includes/account_nav.php'; ?>
<div class="flex-1"><?php if (!$rows): ?><p>Nothing saved yet. Tap the heart on an expedition to keep it here. <a class="underline" href="expeditions.php">Browse expeditions</a>.</p><?php endif; ?>
<div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6"><?php foreach ($rows as $x) include 'includes/card.php'; ?></div></div></div></div>
<?php require 'includes/footer.php'; ?>
