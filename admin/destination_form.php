<?php $title = 'Destination'; require __DIR__ . '/../includes/admin_header.php'; require __DIR__ . '/../includes/admin_ui.php';
$id = (int)($_GET['id'] ?? 0); $d = null;
if ($id) { $s = db()->prepare('SELECT * FROM Destination WHERE Id=?'); $s->execute([$id]); $d = $s->fetch(); if (!$d) { flash('Destination not found.', 'err'); go('destinations.php'); } }
$keys = ['Name', 'Country', 'Region', 'Description', 'BestTimeToVisit', 'TravelTips', 'Image']; $v = $d ?: array_fill_keys($keys, ''); $errs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf();
  foreach (['Name', 'Country', 'Region', 'Description', 'BestTimeToVisit', 'TravelTips'] as $k) $v[$k] = trim($_POST[$k] ?? '');
  if ($v['Name'] === '' || $v['Country'] === '') $errs[] = 'Name and country are required.';
  if (mb_strlen($v['Name']) > 100 || mb_strlen($v['Country']) > 80 || mb_strlen($v['Region']) > 80 || mb_strlen($v['BestTimeToVisit']) > 120) $errs[] = 'One of the fields is too long.';
  $old = $d['Image'] ?? ''; $img = $old;
  if (!$errs) { try { if ($up = store_image($_FILES['image'] ?? ['error' => UPLOAD_ERR_NO_FILE])) $img = $up; elseif ($ref = safe_image_ref($_POST['Image'] ?? '')) $img = $ref; elseif (trim($_POST['Image'] ?? '') !== '') $errs[] = 'The image path must start with https://, assets/ or uploads/.'; } catch (RuntimeException $ex) { $errs[] = $ex->getMessage(); } }
  if (!$errs) { $p = [$v['Name'], $v['Country'], $v['Region'], $v['Description'], $img, $v['BestTimeToVisit'], $v['TravelTips']];
    if ($d) { db()->prepare('UPDATE Destination SET Name=?,Country=?,Region=?,Description=?,Image=?,BestTimeToVisit=?,TravelTips=? WHERE Id=?')->execute([...$p, $id]); if ($old !== $img) remove_local_image($old); }
    else db()->prepare('INSERT INTO Destination(Name,Country,Region,Description,Image,BestTimeToVisit,TravelTips) VALUES(?,?,?,?,?,?,?)')->execute($p);
    flash('Destination saved.'); go('destinations.php'); }
  $v['Image'] = $old; }
$lbl = 'block text-sm font-medium'; ?>
<a href="destinations.php" class="text-sm underline">Back to destinations</a><h1 class="font-display text-4xl mt-1"><?=$d ? 'Edit destination' : 'New destination'?></h1>
<?php if ($errs): ?><div role="alert" class="mt-4 p-3 bg-red-100 text-red-900 rounded"><ul class="list-disc pl-5"><?php foreach ($errs as $er): ?><li><?=e($er)?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" enctype="multipart/form-data" class="<?=$card?> mt-6 p-6 grid md:grid-cols-2 gap-5 max-w-4xl"><?=csrf_field()?>
<label class="<?=$lbl?>">Name<input name="Name" required maxlength="100" value="<?=e($v['Name'])?>" class="<?=$input?>"></label>
<label class="<?=$lbl?>">Country<input name="Country" required maxlength="80" value="<?=e($v['Country'])?>" class="<?=$input?>"></label>
<label class="<?=$lbl?> md:col-span-2">Region<input name="Region" maxlength="80" value="<?=e($v['Region'])?>" class="<?=$input?>"></label>
<label class="<?=$lbl?> md:col-span-2">Description<textarea name="Description" rows="6" class="<?=$input?>"><?=e($v['Description'])?></textarea></label>
<label class="<?=$lbl?> md:col-span-2">Best time to visit<input name="BestTimeToVisit" maxlength="120" value="<?=e($v['BestTimeToVisit'])?>" class="<?=$input?>"></label>
<label class="<?=$lbl?> md:col-span-2">Travel tips (one tip per line)<textarea name="TravelTips" rows="5" class="<?=$input?>"><?=e($v['TravelTips'])?></textarea></label>
<fieldset class="md:col-span-2 border border-stone rounded p-4"><legend class="text-sm font-medium px-1">Image</legend>
<?php if ($v['Image']): ?><img src="<?=img($v['Image'])?>" alt="Current destination image" class="h-28 rounded mb-3"><?php endif; ?>
<label class="<?=$lbl?>">Upload (JPG, PNG or WebP, max 5 MB)<input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="mt-1 block text-sm"></label>
<label class="<?=$lbl?> mt-3">Or image path / URL<input name="Image" value="<?=e($v['Image'])?>" class="<?=$input?>"></label></fieldset>
<div class="md:col-span-2"><button class="<?=$btn?>">Save destination</button></div></form>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
