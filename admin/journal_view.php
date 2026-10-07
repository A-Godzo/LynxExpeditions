<?php $title = 'Journal post'; require __DIR__ . '/../includes/admin_header.php'; require __DIR__ . '/../includes/admin_ui.php';
$id = (int)($_GET['id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf(); db()->prepare('DELETE FROM JournalPost WHERE Id=?')->execute([$id]); flash('Post deleted.'); go('journal.php'); }
$s = db()->prepare('SELECT p.*,u.FirstName,u.LastName,u.Email FROM JournalPost p JOIN User u ON u.Id=p.AuthorId WHERE p.Id=?'); $s->execute([$id]); $p = $s->fetch();
if (!$p) { flash('Post not found.', 'err'); go('journal.php'); } ?>
<a href="journal.php" class="text-sm underline">Back to journal</a>
<article class="<?=$card?> mt-3 p-6 max-w-3xl"><h1 class="font-display text-4xl"><?=e($p['Title'])?></h1>
<p class="mt-2 text-sm text-ink/60">By <?=e(full_name($p))?> (<?=e($p['Email'])?>), <?=fmt_date($p['PublishedAt'], 'j M Y, H:i')?></p>
<p class="mt-5 whitespace-pre-line leading-7"><?=e($p['Content'])?></p>
<div class="mt-6 flex gap-3"><a class="<?=$btn2?>" href="../article.php?slug=<?=e($p['Slug'])?>">View on site</a>
<form method="post" onsubmit="return confirm('Delete this post?')"><?=csrf_field()?><button class="<?=$danger?>">Delete post</button></form></div></article>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
