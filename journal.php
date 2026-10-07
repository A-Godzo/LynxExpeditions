<?php $title = 'The Lynx Journal'; require 'includes/header.php';
$per = 10; $total = (int)db()->query('SELECT COUNT(*) FROM JournalPost')->fetchColumn(); [$page, $off, $pages] = paginate($total, $per);
$posts = db()->query("SELECT p.*,u.FirstName,u.LastName FROM JournalPost p JOIN User u ON u.Id=p.AuthorId ORDER BY p.PublishedAt DESC,p.Id DESC LIMIT $per OFFSET $off")->fetchAll(); ?>
<div class="max-w-4xl mx-auto px-4 py-14">
  <div class="flex flex-wrap items-end justify-between gap-4"><div><h1 class="font-display text-6xl md:text-7xl">The Lynx Journal</h1><p class="mt-3 text-ink/75 max-w-lg">Stories, tips and trail notes from the people who travel with us.</p></div>
  <a href="journal_new.php" class="bg-amber text-ink px-5 py-3 rounded font-semibold">Write a Journal Post</a></div>
  <div class="mt-12 divide-y divide-stone border-t border-stone">
  <?php foreach ($posts as $p): ?>
    <article class="py-8"><h2 class="font-display text-4xl md:text-5xl"><a class="hover:text-forest" href="article.php?slug=<?=e($p['Slug'])?>"><?=e($p['Title'])?></a></h2>
    <p class="mt-2 text-sm text-ink/60">By <?=e(full_name($p))?>, <time datetime="<?=e($p['PublishedAt'])?>"><?=fmt_date($p['PublishedAt'])?></time></p>
    <p class="mt-3 text-lg max-w-prose"><?=e(excerpt($p['Content']))?></p>
    <a class="mt-3 inline-block text-sm font-semibold underline decoration-amber decoration-2 underline-offset-4" href="article.php?slug=<?=e($p['Slug'])?>">Read the full post</a></article>
  <?php endforeach; if (!$posts): ?><p class="py-8">No posts yet. Be the first to write one.</p><?php endif; ?></div>
  <?=pager($page, $pages)?></div>
<?php require 'includes/footer.php'; ?>
