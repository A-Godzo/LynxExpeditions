<?php $title = 'Destination'; require 'includes/header.php';
$s = db()->prepare('SELECT * FROM Destination WHERE Id=?'); $s->execute([(int)($_GET['id'] ?? 0)]); $d = $s->fetch();
if (!$d) require 'includes/not_found.php';
$title = $d['Name'];
$q = db()->prepare('SELECT e.*,c.Name Category FROM Expedition e JOIN Category c ON c.Id=e.CategoryId WHERE e.DestinationId=? AND e.IsActive=1 ORDER BY e.StartDate'); $q->execute([$d['Id']]); $rows = $q->fetchAll(); ?>
<section class="relative bg-ink text-bone"><img src="<?=img($d['Image'])?>" alt="<?=e($d['Name'])?>" class="absolute inset-0 w-full h-full object-cover opacity-55">
<div class="relative max-w-7xl mx-auto px-4 py-28 md:py-40"><p><?=e($d['Country'])?><?=$d['Region'] ? ', ' . e($d['Region']) : ''?></p><h1 class="font-display text-6xl md:text-8xl"><?=e($d['Name'])?></h1></div></section>
<div class="max-w-7xl mx-auto px-4 py-12 grid lg:grid-cols-3 gap-10">
  <div class="lg:col-span-2 max-w-prose"><h2 class="font-display text-3xl">About this destination</h2><p class="mt-3 whitespace-pre-line"><?=e($d['Description'])?></p></div>
  <aside class="space-y-6">
    <div class="bg-white border border-stone rounded-lg p-6"><h2 class="font-display text-2xl">Best time to visit</h2><p class="mt-2"><?=e($d['BestTimeToVisit'])?></p></div>
    <?php if (lines($d['TravelTips'])): ?><div class="bg-white border border-stone rounded-lg p-6"><h2 class="font-display text-2xl">Travel tips</h2><ul class="mt-2 list-disc pl-5 space-y-1"><?php foreach (lines($d['TravelTips']) as $t): ?><li><?=e($t)?></li><?php endforeach; ?></ul></div><?php endif; ?>
  </aside></div>
<section class="max-w-7xl mx-auto px-4"><h2 class="font-display text-4xl mb-6">Expeditions in <?=e($d['Name'])?></h2>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6"><?php foreach ($rows as $x) include 'includes/card.php'; ?></div>
<?php if (!$rows): ?><p>No expeditions are scheduled here right now. <a class="underline" href="expeditions.php">Browse all expeditions</a>.</p><?php endif; ?></section>
<?php require 'includes/footer.php'; ?>
