<?php $title='Home'; require 'includes/header.php';
$feat=db()->query("SELECT e.*,c.Name Category FROM Expedition e JOIN Category c ON c.Id=e.CategoryId WHERE IsActive=1 AND IsFeatured=1 ORDER BY StartDate LIMIT 3")->fetchAll(); ?>
<section class="relative bg-forest text-bone"><img src="assets/hero.jpg" alt="" class="absolute inset-0 w-full h-full object-cover opacity-50">
<div class="relative max-w-7xl mx-auto px-4 py-32 md:py-48"><h1 class="font-display text-6xl md:text-8xl leading-none">GO FURTHER.<br>EXPERIENCE MORE.</h1>
<p class="mt-6 max-w-xl text-lg">Carefully planned small-group expeditions from Skopje, up to five days long.</p>
<a href="expeditions.php" class="inline-block mt-8 bg-amber text-ink px-6 py-3 rounded font-semibold">Discover Our Expeditions</a></div></section>
<section class="max-w-7xl mx-auto px-4 mt-16"><h2 class="font-display text-4xl mb-6">Featured expeditions</h2>
<div class="grid md:grid-cols-3 gap-6"><?php foreach($feat as $x) include 'includes/card.php'; ?>
<?php if(!$feat): ?><p>No featured expeditions yet. Add one in the admin area.</p><?php endif; ?></div></section>
<?php require 'includes/footer.php'; ?>
