<?php $title = 'Write a Journal Post'; require 'includes/header.php'; require_login();
$err = ''; $t = $c = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf(); $t = trim($_POST['title'] ?? ''); $c = trim($_POST['content'] ?? '');
  if ($t === '' || $c === '') $err = 'Add a title and some content.';
  elseif (mb_strlen($t) > 200) $err = 'The title is too long (200 characters max).';
  elseif (mb_strlen($c) < 50) $err = 'Please write at least a few sentences (50 characters).';
  else { $slug = slugify($t); $chk = db()->prepare('SELECT COUNT(*) FROM JournalPost WHERE Slug=?'); $base = $slug; $i = 1;
    for (;;) { $chk->execute([$slug]); if (!$chk->fetchColumn()) break; $slug = $base . '-' . (++$i); }
    db()->prepare('INSERT INTO JournalPost(Title,Slug,Content,AuthorId) VALUES(?,?,?,?)')->execute([$t, $slug, $c, user()['Id']]);
    flash('Your post is now live in the Journal.'); go('article.php?slug=' . urlencode($slug)); } }
$f = 'mt-1 w-full border border-stone rounded px-3 py-2 bg-white'; ?>
<div class="max-w-3xl mx-auto px-4 py-14"><h1 class="font-display text-5xl">Write a Journal Post</h1>
<p class="mt-2 text-ink/70">Posts are published immediately and visible to everyone. Please keep them respectful and travel-related. See our <a class="underline" href="terms.php">Terms</a>.</p>
<?php if ($err): ?><p role="alert" class="mt-4 p-3 bg-red-100 text-red-900 rounded"><?=e($err)?></p><?php endif; ?>
<form method="post" class="mt-6 space-y-4"><?=csrf_field()?>
<label class="block text-sm">Title<input name="title" required maxlength="200" value="<?=e($t)?>" class="<?=$f?>"></label>
<label class="block text-sm">Your story<textarea name="content" rows="14" required class="<?=$f?>"><?=e($c)?></textarea></label>
<button class="bg-forest text-bone px-6 py-3 rounded font-semibold">Publish post</button></form></div>
<?php require 'includes/footer.php'; ?>
