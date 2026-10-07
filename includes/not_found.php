<?php /* Renders the branded 404 and stops. Include after header.php. */
http_response_code(404); ?>
<section class="bg-forest text-bone logo-on-dark"><div class="max-w-3xl mx-auto px-4 py-28 text-center">
  <?=logo_mark('h-14 w-14 mx-auto')?>
  <h1 class="font-display text-5xl md:text-7xl mt-6">Looks like you've wandered off the trail.</h1>
  <p class="mt-4 text-bone/80">The page you were looking for doesn't exist or has moved.</p>
  <a href="index.php" class="inline-block mt-8 bg-amber text-ink px-6 py-3 rounded font-semibold">Back to Home</a></div></section>
<?php require __DIR__ . '/footer.php'; exit;
