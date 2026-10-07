<?php /* Expedition card. Expects $x (Expedition row plus Category name). */
$eid = (int)$x['Id']; $faved = in_array($eid, fav_ids(), true); ?>
<article class="relative flex flex-col bg-white border border-stone rounded-lg overflow-hidden transition duration-200 hover:-translate-y-1 hover:shadow-lg">
  <a href="expedition.php?id=<?=$eid?>" class="block aspect-[4/3] overflow-hidden bg-stone"><img src="<?=img($x['FeaturedImage'])?>" alt="<?=e($x['Name'])?>" loading="lazy" class="w-full h-full object-cover"></a>
  <span class="absolute top-3 left-3 bg-ink/80 text-bone text-xs font-semibold px-3 py-1 rounded-full"><?=e($x['Category'])?></span>
  <?php if (user()): ?>
  <form method="post" action="favorite.php" class="fav-form absolute top-3 right-3"><?=csrf_field()?><input type="hidden" name="expedition_id" value="<?=$eid?>"><input type="hidden" name="back" value="<?=e($_SERVER['REQUEST_URI'])?>">
    <button class="fav-btn h-10 w-10 grid place-items-center rounded-full bg-white/90 text-ink" aria-pressed="<?=$faved ? 'true' : 'false'?>" aria-label="<?=$faved ? 'Remove from favorites' : 'Save to favorites'?>"><svg class="h-5 w-5" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true"><path d="M12 21s-7-4.5-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 6C19 16.5 12 21 12 21z"/></svg></button></form>
  <?php else: ?>
  <a href="auth.php?next=<?=urlencode($_SERVER['REQUEST_URI'])?>" class="absolute top-3 right-3 h-10 w-10 grid place-items-center rounded-full bg-white/90 text-ink" aria-label="Log in to save to favorites"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 21s-7-4.5-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 6C19 16.5 12 21 12 21z"/></svg></a>
  <?php endif; ?>
  <div class="p-5 flex flex-col flex-1">
    <h3 class="font-display text-3xl"><a href="expedition.php?id=<?=$eid?>" class="hover:text-forest"><?=e($x['Name'])?></a></h3>
    <p class="mt-2 text-sm text-ink/75 flex-1"><?=e($x['ShortDescription'])?></p>
    <p class="mt-4 text-sm text-ink/70"><?=$x['DurationDays']?> day<?=$x['DurationDays'] > 1 ? 's' : ''?>, <?=e($x['Difficulty'])?>, departs <?=fmt_date($x['StartDate'], 'j M Y')?></p>
    <div class="mt-3 flex items-center justify-between"><span class="font-display text-3xl">€<?=number_format($x['Price'], 0)?></span><a href="expedition.php?id=<?=$eid?>" class="text-sm font-semibold underline decoration-amber decoration-2 underline-offset-4">View details</a></div>
  </div>
</article>
