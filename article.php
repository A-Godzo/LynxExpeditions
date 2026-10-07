<?php $title = 'Journal'; require 'includes/header.php';
$s = db()->prepare('SELECT p.*,u.FirstName,u.LastName FROM JournalPost p JOIN User u ON u.Id=p.AuthorId WHERE p.Slug=?'); $s->execute([$_GET['slug'] ?? '']); $p = $s->fetch();
if (!$p) require 'includes/not_found.php';
$title = $p['Title']; ?>
<article class="max-w-3xl mx-auto px-4 py-16">
  <a href="journal.php" class="text-sm underline">Back to the Journal</a>
  <h1 class="font-display text-5xl md:text-7xl mt-6"><?=e($p['Title'])?></h1>
  <p class="mt-4 text-ink/60">By <?=e(full_name($p))?>, <time datetime="<?=e($p['PublishedAt'])?>"><?=fmt_date($p['PublishedAt'], 'j F Y')?></time></p>
  <div class="mt-10 text-lg leading-8 space-y-5 max-w-prose"><?php foreach (preg_split('/\R{2,}/', trim($p['Content'])) as $para): ?><p><?=nl2br(e($para))?></p><?php endforeach; ?></div>
</article>
<?php require 'includes/footer.php'; ?>
