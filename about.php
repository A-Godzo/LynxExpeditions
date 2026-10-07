<?php $title = 'About & Contact'; require 'includes/header.php';
$err = ''; $old = ['name' => user() ? full_name(user()) : '', 'email' => user()['Email'] ?? '', 'subject' => '', 'message' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf();
  $old = ['name' => trim($_POST['name'] ?? ''), 'email' => trim($_POST['email'] ?? ''), 'subject' => trim($_POST['subject'] ?? ''), 'message' => trim($_POST['message'] ?? '')];
  if (!empty($_POST['website'])) { flash('Thanks, your message has been sent.'); go('about.php#contact'); } // honeypot
  if (in_array('', $old, true)) $err = 'Please fill in every field.';
  elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $err = 'Enter a valid email address.';
  elseif (mb_strlen($old['name']) > 100 || mb_strlen($old['subject']) > 200 || mb_strlen($old['message']) > 4000) $err = 'One of the fields is too long.';
  else { db()->prepare('INSERT INTO ContactMessage(Name,Email,Subject,Message) VALUES(?,?,?,?)')->execute(array_values($old)); flash('Thanks, your message has been sent. We reply on weekdays.'); go('about.php#contact'); } }
$team = [['Nikola Todorov', 'Founder and Lead Guide', 'Nikola started Lynx after years guiding groups through the Balkan mountains. He still leads several trips every season.', 'marko'],
 ['Daniela Kralevska', 'Head of Expedition Planning', 'Daniela designs every itinerary and walks the routes herself before they go on sale.', 'ana'],
 ['Valentin Nikolovski', 'Local Guide Coordinator', 'Valentin works with the guides we hire in each region and makes sure every group is in good hands.', 'nikola'],
 ['Irina Miladinova', 'Bookings and Customer Support', 'Irina answers your questions, handles booking requests and keeps travelers informed before departure.', 'elena']];
$values = [['Adventure', 'We choose trips that get you outside and a little out of your routine.'], ['Trust', 'Clear information, honest descriptions and no surprises on the day.'], ['Respect', 'For the people who live in the places we visit and for the landscapes themselves.'], ['Connection', 'Good trips connect you with places, locals and the people beside you.'], ['Small Groups', 'Fewer travelers means better pace, better access and better conversations.']];
$why = [['Carefully Planned', 'Routes are scouted and timed before they are offered.'], ['Small Groups', 'Capped group sizes on every expedition.'], ['Meaningful Experiences', 'Local people, food and history, not just a checklist of sights.'], ['Trusted Support', 'A real team in Skopje you can write to before, and during, your trip.']];
$f = 'mt-1 w-full border border-stone rounded px-3 py-2 bg-white'; ?>
<section class="bg-forest text-bone"><div class="max-w-7xl mx-auto px-4 py-20"><h1 class="font-display text-5xl md:text-7xl">About &amp; Contact</h1>
<nav class="mt-6 flex flex-wrap gap-x-6 gap-y-2 text-sm" aria-label="On this page"><a class="underline" href="#story">Our Story</a><a class="underline" href="#values">Mission &amp; Values</a><a class="underline" href="#team">Our Team</a><a class="underline" href="#why">Why Lynx?</a><a class="underline" href="#contact">Contact</a></nav></div></section>
<section id="story" class="max-w-7xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-10"><h2 class="font-display text-5xl">Our Story</h2>
<div class="space-y-4 max-w-prose"><p>Lynx Expeditions was founded in 2021 in Skopje, North Macedonia. We started with a simple idea: meaningful travel should be accessible, and the best way to deliver it is through carefully planned small-group adventures.</p><p>Today we run short trips of up to five days across Europe and a few selected destinations beyond. Each one is built around a single, well-scouted plan, with local guides and a group small enough to feel like a team.</p></div></section>
<section id="values" class="bg-white border-y border-stone"><div class="max-w-7xl mx-auto px-4 py-16"><h2 class="font-display text-5xl">Our Mission &amp; Values</h2>
<p class="mt-3 text-xl max-w-2xl">Make meaningful exploration accessible through carefully planned small-group expeditions.</p>
<dl class="mt-10 grid sm:grid-cols-2 lg:grid-cols-5 gap-6"><?php foreach ($values as [$n, $t]): ?><div class="border-t-2 border-amber pt-3"><dt class="font-display text-2xl"><?=$n?></dt><dd class="text-sm mt-1 text-ink/75"><?=$t?></dd></div><?php endforeach; ?></dl></div></section>
<section id="team" class="max-w-7xl mx-auto px-4 py-16"><h2 class="font-display text-5xl">Our Team</h2>
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8"><?php foreach ($team as [$n, $r, $b, $k]): ?><article><img src="assets/team/<?=$k?>.jpg" onerror="this.onerror=null;this.src='assets/placeholder.jpg'" alt="Portrait of <?=e($n)?>" loading="lazy" class="aspect-[4/5] w-full object-cover rounded-lg bg-stone"><h3 class="font-display text-2xl mt-3"><?=e($n)?></h3><p class="text-sm font-semibold text-forest"><?=e($r)?></p><p class="text-sm mt-1 text-ink/75"><?=e($b)?></p></article><?php endforeach; ?></div></section>
<section id="why" class="bg-forest text-bone"><div class="max-w-7xl mx-auto px-4 py-16"><h2 class="font-display text-5xl">Why Lynx?</h2>
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-8"><?php foreach ($why as [$n, $t]): ?><div><h3 class="font-display text-2xl text-amber"><?=$n?></h3><p class="text-sm mt-1 text-bone/85"><?=$t?></p></div><?php endforeach; ?></div></div></section>
<section id="contact" class="max-w-7xl mx-auto px-4 py-16 grid lg:grid-cols-2 gap-12"><div><h2 class="font-display text-5xl">Contact</h2>
<address class="not-italic mt-5 space-y-1"><p class="font-semibold">Lynx Expeditions</p><p>Skopje, North Macedonia</p><p><a class="underline" href="mailto:hello@lynxexpeditions.com">hello@lynxexpeditions.com</a></p><p>Mon–Fri, 09:00–17:00</p></address></div>
<form method="post" action="about.php#contact" class="bg-white border border-stone rounded-lg p-6 space-y-4"><?=csrf_field()?>
<?php if ($err): ?><p role="alert" class="p-3 bg-red-100 text-red-900 rounded"><?=e($err)?></p><?php endif; ?>
<div class="hidden" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
<label class="block text-sm">Name<input name="name" required maxlength="100" value="<?=e($old['name'])?>" class="<?=$f?>"></label>
<label class="block text-sm">Email<input type="email" name="email" required value="<?=e($old['email'])?>" class="<?=$f?>"></label>
<label class="block text-sm">Subject<input name="subject" required maxlength="200" value="<?=e($old['subject'])?>" class="<?=$f?>"></label>
<label class="block text-sm">Message<textarea name="message" rows="5" required maxlength="4000" class="<?=$f?>"><?=e($old['message'])?></textarea></label>
<button class="bg-amber text-ink px-6 py-3 rounded font-semibold">Send message</button></form></section>
<?php require 'includes/footer.php'; ?>
