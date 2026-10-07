<?php $title = 'Services'; require 'includes/header.php';
$svc = [
 ['Expedition Planning', 'Every route, stop and time slot is worked out in advance, so you only have to show up. We test our trips before we sell them.', '<path d="M3 6l6-2 6 2 6-2v14l-6 2-6-2-6 2z"/><path d="M9 4v14M15 6v14"/>'],
 ['Accommodation', 'Clean, characterful places to sleep: mountain huts, family guesthouses and small city hotels, chosen for location and welcome.', '<path d="M3 19V6M3 13h18v6M21 13v-2a3 3 0 0 0-3-3h-7v5"/><circle cx="7" cy="10" r="1.6"/>'],
 ['Transportation', 'Comfortable transfers from our departure point and between stops, so nobody is left working out timetables.', '<rect x="4" y="4" width="16" height="12" rx="2"/><path d="M4 11h16M7 20v-4M17 20v-4"/>'],
 ['Local Guides', 'Guides who live in the region lead each trip and know the paths, the history and the best place for lunch.', '<circle cx="12" cy="12" r="9"/><path d="M15.5 8.5l-2 5-5 2 2-5z"/>'],
 ['Small-Group Travel', 'Groups are kept small, so you get time with the guide, flexibility on the trail and a group you can actually get to know.', '<circle cx="9" cy="8" r="3"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><circle cx="17" cy="9" r="2.5"/><path d="M16 14c3 0 5 2 5 5"/>'],
]; ?>
<div class="max-w-7xl mx-auto px-4 py-12"><h1 class="font-display text-5xl md:text-6xl">Services</h1>
<p class="mt-3 max-w-xl text-ink/75">Everything that goes into a Lynx expedition, handled by a small team that answers its own email.</p>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
<?php foreach ($svc as [$n, $t, $icon]): ?><article class="bg-white border border-stone rounded-lg p-7">
  <svg class="h-10 w-10 text-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?=$icon?></svg>
  <h2 class="font-display text-3xl mt-4"><?=e($n)?></h2><p class="mt-2 text-ink/75"><?=e($t)?></p></article><?php endforeach; ?>
<article class="bg-forest text-bone rounded-lg p-7 flex flex-col justify-between"><h2 class="font-display text-3xl">Ready to pick a trip?</h2><a href="expeditions.php" class="mt-6 inline-block bg-amber text-ink px-5 py-3 rounded font-semibold self-start">Discover Our Expeditions</a></article>
</div></div>
<?php require 'includes/footer.php'; ?>
