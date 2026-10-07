<?php $title = 'FAQ'; require 'includes/header.php';
$faq = [
 'Booking' => [
  ['How do I book an expedition?', 'Open an expedition, choose the number of travelers and send a booking request. We review it and confirm or decline, and you will see the update in your notifications and under My Trips.'],
  ['Do I need an account to book?', 'Yes. A free account lets us keep your requests, confirmations and notifications in one place.'],
  ['Can I cancel my booking?', 'Cancellations are handled by our team rather than through the website. Write to hello@lynxexpeditions.com and we will help.']],
 'Payments' => [
  ['Do I pay online when I book?', 'No. The website only takes booking requests. Payment is arranged separately with our team once your booking is confirmed.'],
  ['What is included in the price?', 'Each expedition page lists what is included and what is not. Check both lists before you request a booking.']],
 'Expeditions' => [
  ['How large are groups?', 'Small. Every expedition has a maximum group size shown on its page, and places are limited to that number.'],
  ['How difficult are expeditions?', 'Each trip is rated Easy, Moderate or Challenging. If you are unsure which suits you, ask us before booking.'],
  ['Where do expeditions depart from?', 'The departure location is listed on each expedition page. Most trips depart from Skopje.']],
 'Accounts' => [
  ['Can I save expeditions for later?', 'Yes. Use the heart on any expedition to save it, then find it under My Favorites.'],
  ['Can I write on the Lynx Journal?', 'Yes. Any registered user can publish a post, and it appears straight away.'],
  ['Can I review an expedition?', 'Yes, once you have a confirmed booking for it. You can leave one review per expedition.']],
]; $n = 0; ?>
<div class="max-w-3xl mx-auto px-4 py-14"><h1 class="font-display text-5xl md:text-6xl">Frequently asked questions</h1>
<?php foreach ($faq as $group => $items): ?><h2 class="font-display text-3xl mt-10 mb-2"><?=$group?></h2><div class="border-t border-stone">
<?php foreach ($items as [$q, $a]): $n++; ?><div class="acc-item border-b border-stone">
  <h3 class="font-sans"><button aria-expanded="false" aria-controls="faq<?=$n?>" class="w-full flex justify-between items-center gap-4 py-4 text-left font-semibold"><?=e($q)?><svg class="chev h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg></button></h3>
  <div id="faq<?=$n?>" class="acc-panel" role="region"><div><p class="pb-4 text-ink/80"><?=e($a)?></p></div></div></div><?php endforeach; ?></div><?php endforeach; ?>
<p class="mt-10">Still curious? <a class="underline" href="about.php#contact">Get in touch</a>.</p></div>
<?php require 'includes/footer.php'; ?>
