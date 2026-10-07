<?php $title = 'Destinations'; require 'includes/header.php';
$rows = db()->query('SELECT d.*,(SELECT COUNT(*) FROM Expedition e WHERE e.DestinationId=d.Id AND e.IsActive=1) n FROM Destination d ORDER BY d.Name')->fetchAll(); ?>
<div class="max-w-7xl mx-auto px-4 py-12"><h1 class="font-display text-5xl md:text-6xl">Destinations</h1>
<p class="mt-3 max-w-xl text-ink/75">Countries and regions we know well, and the small-group trips we run there.</p>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
<?php foreach ($rows as $d): ?>
<a href="destination.php?id=<?=$d['Id']?>" class="group relative block aspect-[4/5] overflow-hidden rounded-lg bg-forest text-bone">
  <img src="<?=img($d['Image'])?>" alt="<?=e($d['Name'])?>" loading="lazy" class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-105">
  <div class="absolute inset-0 bg-gradient-to-t from-ink/85 via-ink/10 to-transparent"></div>
  <div class="absolute bottom-0 p-6"><h2 class="font-display text-4xl"><?=e($d['Name'])?></h2><p class="text-sm"><?=e($d['Country'])?><?=$d['Region'] ? ', ' . e($d['Region']) : ''?></p><p class="mt-2 text-sm text-amber"><?=$d['n']?> expedition<?=$d['n'] == 1 ? '' : 's'?></p></div>
</a>
<?php endforeach; if (!$rows): ?><p>No destinations yet.</p><?php endif; ?></div></div>
<?php require 'includes/footer.php'; ?>
