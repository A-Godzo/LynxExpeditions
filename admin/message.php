<?php $title = 'Message'; require __DIR__ . '/../includes/admin_header.php'; require __DIR__ . '/../includes/admin_ui.php';
$id = (int)($_GET['id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf(); db()->prepare('UPDATE ContactMessage SET IsRead=? WHERE Id=?')->execute([($_POST['read'] ?? '') === '1' ? 1 : 0, $id]); flash(($_POST['read'] ?? '') === '1' ? 'Marked as read.' : 'Marked as unread.'); go($_POST['read'] === '1' ? "message.php?id=$id" : 'messages.php'); }
$s = db()->prepare('SELECT * FROM ContactMessage WHERE Id=?'); $s->execute([$id]); $m = $s->fetch();
if (!$m) { flash('Message not found.', 'err'); go('messages.php'); }
if (!$m['IsRead']) { db()->prepare('UPDATE ContactMessage SET IsRead=1 WHERE Id=?')->execute([$id]); $m['IsRead'] = 1; } // opening a message marks it read ?>
<a href="messages.php" class="text-sm underline">Back to messages</a>
<article class="<?=$card?> mt-3 p-6 max-w-3xl"><h1 class="font-display text-4xl"><?=e($m['Subject'])?></h1>
<p class="mt-2 text-sm text-ink/60">From <?=e($m['Name'])?> (<a class="underline" href="mailto:<?=e($m['Email'])?>?subject=<?=rawurlencode('Re: ' . $m['Subject'])?>"><?=e($m['Email'])?></a>), <?=fmt_date($m['SubmittedAt'], 'j M Y, H:i')?></p>
<p class="mt-5 whitespace-pre-line leading-7"><?=e($m['Message'])?></p>
<div class="mt-6 flex gap-3"><a class="<?=$btn?>" href="mailto:<?=e($m['Email'])?>?subject=<?=rawurlencode('Re: ' . $m['Subject'])?>">Reply by email</a>
<form method="post"><?=csrf_field()?><input type="hidden" name="read" value="0"><button class="<?=$btn2?>">Mark as unread</button></form></div></article>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
