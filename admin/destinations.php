<?php $title = 'Destinations'; require __DIR__ . '/../includes/admin_header.php'; require __DIR__ . '/../includes/admin_ui.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf(); $id = (int)($_POST['id'] ?? 0);
  $s = db()->prepare('SELECT Image FROM Destination WHERE Id=?'); $s->execute([$id]); $img = $s->fetchColumn();
  try { db()->prepare('DELETE FROM Destination WHERE Id=?')->execute([$id]); remove_local_image($img ?: null); flash('Destination deleted.'); }
  catch (PDOException $ex) { flash('This destination still has expeditions. Move or delete them first.', 'err'); }
  go('destinations.php'); }
$rows = db()->query('SELECT d.*,(SELECT COUNT(*) FROM Expedition e WHERE e.DestinationId=d.Id) n FROM Destination d ORDER BY d.Name')->fetchAll(); ?>
<div class="flex justify-between items-center"><h1 class="font-display text-4xl">Destinations</h1><a href="destination_form.php" class="<?=$btn?>">New destination</a></div>
<div class="<?=$card?> mt-6 overflow-x-auto"><table class="w-full"><thead><tr><th class="<?=$th?>">Name</th><th class="<?=$th?>">Country</th><th class="<?=$th?>">Region</th><th class="<?=$th?>">Expeditions</th><th class="<?=$th?>"></th></tr></thead><tbody>
<?php foreach ($rows as $d): ?><tr class="border-t border-stone"><td class="<?=$td?> font-semibold"><?=e($d['Name'])?></td><td class="<?=$td?>"><?=e($d['Country'])?></td><td class="<?=$td?>"><?=e($d['Region'])?></td><td class="<?=$td?>"><?=$d['n']?></td>
<td class="<?=$td?> whitespace-nowrap"><a class="<?=$btn2?>" href="destination_form.php?id=<?=$d['Id']?>">Edit</a>
<form method="post" class="inline" onsubmit="return confirm('Delete this destination?')"><?=csrf_field()?><input type="hidden" name="id" value="<?=$d['Id']?>"><button class="<?=$danger?>">Delete</button></form></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="5" class="<?=$td?>">No destinations yet.</td></tr><?php endif; ?></tbody></table></div>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
