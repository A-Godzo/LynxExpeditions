<?php $title = 'Journal'; require __DIR__ . '/../includes/admin_header.php'; require __DIR__ . '/../includes/admin_ui.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf(); db()->prepare('DELETE FROM JournalPost WHERE Id=?')->execute([(int)($_POST['id'] ?? 0)]); flash('Post deleted.'); go('journal.php'); }
[$page, $off, $pages] = paginate((int)db()->query('SELECT COUNT(*) FROM JournalPost')->fetchColumn(), 20);
$rows = db()->query("SELECT p.*,u.FirstName,u.LastName FROM JournalPost p JOIN User u ON u.Id=p.AuthorId ORDER BY p.PublishedAt DESC,p.Id DESC LIMIT 20 OFFSET $off")->fetchAll(); ?>
<h1 class="font-display text-4xl">Journal</h1>
<div class="<?=$card?> mt-6 overflow-x-auto"><table class="w-full"><thead><tr><th class="<?=$th?>">Title</th><th class="<?=$th?>">Author</th><th class="<?=$th?>">Published</th><th class="<?=$th?>"></th></tr></thead><tbody>
<?php foreach ($rows as $p): ?><tr class="border-t border-stone"><td class="<?=$td?>"><a class="font-semibold underline" href="journal_view.php?id=<?=$p['Id']?>"><?=e($p['Title'])?></a></td><td class="<?=$td?>"><?=e(full_name($p))?></td><td class="<?=$td?> whitespace-nowrap"><?=fmt_date($p['PublishedAt'])?></td>
<td class="<?=$td?> whitespace-nowrap"><a class="<?=$btn2?>" href="journal_view.php?id=<?=$p['Id']?>">Open</a> <form method="post" class="inline" onsubmit="return confirm('Delete this post?')"><?=csrf_field()?><input type="hidden" name="id" value="<?=$p['Id']?>"><button class="<?=$danger?>">Delete</button></form></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="4" class="<?=$td?>">No posts yet.</td></tr><?php endif; ?></tbody></table></div><?=pager($page, $pages)?>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
