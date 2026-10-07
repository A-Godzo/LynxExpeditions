<?php $title = 'Messages'; require __DIR__ . '/../includes/admin_header.php'; require __DIR__ . '/../includes/admin_ui.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf(); db()->prepare('UPDATE ContactMessage SET IsRead=? WHERE Id=?')->execute([($_POST['read'] ?? '') === '1' ? 1 : 0, (int)($_POST['id'] ?? 0)]); go('messages.php' . (($_GET['filter'] ?? '') === 'unread' ? '?filter=unread' : '')); }
$unreadOnly = ($_GET['filter'] ?? '') === 'unread'; $where = $unreadOnly ? 'WHERE IsRead=0' : '';
[$page, $off, $pages] = paginate((int)db()->query("SELECT COUNT(*) FROM ContactMessage $where")->fetchColumn(), 20);
$rows = db()->query("SELECT * FROM ContactMessage $where ORDER BY SubmittedAt DESC,Id DESC LIMIT 20 OFFSET $off")->fetchAll(); ?>
<h1 class="font-display text-4xl">Messages</h1>
<nav class="mt-4 flex gap-2" aria-label="Filter"><a href="messages.php" class="px-3 py-1.5 rounded text-sm <?=!$unreadOnly ? 'bg-forest text-bone' : 'bg-white border border-stone'?>">All</a><a href="messages.php?filter=unread" class="px-3 py-1.5 rounded text-sm <?=$unreadOnly ? 'bg-forest text-bone' : 'bg-white border border-stone'?>">Unread</a></nav>
<div class="<?=$card?> mt-5 overflow-x-auto"><table class="w-full"><thead><tr><th class="<?=$th?>">From</th><th class="<?=$th?>">Subject</th><th class="<?=$th?>">Received</th><th class="<?=$th?>"></th></tr></thead><tbody>
<?php foreach ($rows as $m): ?><tr class="border-t border-stone <?=$m['IsRead'] ? '' : 'bg-amber/10 font-semibold'?>"><td class="<?=$td?>"><?=e($m['Name'])?><br><span class="font-normal text-ink/60"><?=e($m['Email'])?></span></td><td class="<?=$td?>"><a class="underline" href="message.php?id=<?=$m['Id']?>"><?=e($m['Subject'])?></a></td><td class="<?=$td?> whitespace-nowrap font-normal"><?=fmt_date($m['SubmittedAt'], 'j M Y, H:i')?></td>
<td class="<?=$td?> whitespace-nowrap font-normal"><a class="<?=$btn2?>" href="message.php?id=<?=$m['Id']?>">Open</a>
<form method="post" class="inline"><?=csrf_field()?><input type="hidden" name="id" value="<?=$m['Id']?>"><input type="hidden" name="read" value="<?=$m['IsRead'] ? 0 : 1?>"><button class="<?=$btn2?>"><?=$m['IsRead'] ? 'Mark unread' : 'Mark read'?></button></form></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="4" class="<?=$td?>">No messages.</td></tr><?php endif; ?></tbody></table></div><?=pager($page, $pages)?>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
