<?php $title = 'Expeditions'; require __DIR__ . '/../includes/admin_header.php'; require __DIR__ . '/../includes/admin_ui.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf(); $id = (int)($_POST['id'] ?? 0); $a = $_POST['action'] ?? '';
  if ($a === 'active' || $a === 'featured') { $col = $a === 'active' ? 'IsActive' : 'IsFeatured'; db()->prepare("UPDATE Expedition SET $col = 1 - $col WHERE Id=?")->execute([$id]); flash('Expedition updated.'); }
  elseif ($a === 'delete') {
    $ph = db()->prepare('SELECT Image FROM ExpeditionPhoto WHERE ExpeditionId=?'); $ph->execute([$id]); $imgs = $ph->fetchAll(PDO::FETCH_COLUMN);
    $fi = db()->prepare('SELECT FeaturedImage FROM Expedition WHERE Id=?'); $fi->execute([$id]); $feat = $fi->fetchColumn();
    try { db()->prepare('DELETE FROM Expedition WHERE Id=?')->execute([$id]); foreach ($imgs as $i) remove_local_image($i); remove_local_image($feat ?: null); flash('Expedition deleted.'); }
    catch (PDOException $ex) { flash('This expedition has bookings and cannot be deleted. Mark it inactive instead.', 'err'); } }
  go('expeditions.php'); }
$rows = db()->query('SELECT e.*,c.Name Category,d.Name Destination FROM Expedition e JOIN Category c ON c.Id=e.CategoryId JOIN Destination d ON d.Id=e.DestinationId ORDER BY e.StartDate DESC')->fetchAll(); ?>
<div class="flex justify-between items-center"><h1 class="font-display text-4xl">Expeditions</h1><a href="expedition_form.php" class="<?=$btn?>">New expedition</a></div>
<div class="<?=$card?> mt-6 overflow-x-auto"><table class="w-full"><thead><tr><th class="<?=$th?>">Expedition</th><th class="<?=$th?>">Dates</th><th class="<?=$th?>">Booked</th><th class="<?=$th?>">Price</th><th class="<?=$th?>">Active</th><th class="<?=$th?>">Featured</th><th class="<?=$th?>"></th></tr></thead><tbody>
<?php foreach ($rows as $x): $bk = booked_travelers((int)$x['Id']); ?><tr class="border-t border-stone">
<td class="<?=$td?>"><a class="font-semibold underline" href="expedition_form.php?id=<?=$x['Id']?>"><?=e($x['Name'])?></a><br><span class="text-ink/60"><?=e($x['Category'])?>, <?=e($x['Destination'])?></span></td>
<td class="<?=$td?> whitespace-nowrap"><?=fmt_date($x['StartDate'])?><br><span class="text-ink/60">to <?=fmt_date($x['EndDate'])?></span></td>
<td class="<?=$td?>"><?=$bk?> / <?=$x['MaxGroupSize']?></td><td class="<?=$td?>">€<?=number_format($x['Price'], 0)?></td>
<?php foreach (['active' => 'IsActive', 'featured' => 'IsFeatured'] as $act => $col): ?><td class="<?=$td?>"><form method="post"><?=csrf_field()?><input type="hidden" name="id" value="<?=$x['Id']?>"><input type="hidden" name="action" value="<?=$act?>"><button class="<?=$btn2?> <?=$x[$col] ? 'bg-forest text-bone hover:bg-forest' : ''?>" aria-label="Toggle <?=$act?> for <?=e($x['Name'])?>"><?=$x[$col] ? 'Yes' : 'No'?></button></form></td><?php endforeach; ?>
<td class="<?=$td?> whitespace-nowrap"><a class="<?=$btn2?>" href="expedition_form.php?id=<?=$x['Id']?>">Edit</a>
<form method="post" class="inline" onsubmit="return confirm('Delete this expedition and its photos and reviews?')"><?=csrf_field()?><input type="hidden" name="id" value="<?=$x['Id']?>"><input type="hidden" name="action" value="delete"><button class="<?=$danger?>">Delete</button></form></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="7" class="<?=$td?>">No expeditions yet.</td></tr><?php endif; ?></tbody></table></div>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
