<?php $title = 'Expedition'; require __DIR__ . '/../includes/admin_header.php'; require __DIR__ . '/../includes/admin_ui.php';
$id = (int)($_GET['id'] ?? 0); $x = null;
if ($id) { $s = db()->prepare('SELECT * FROM Expedition WHERE Id=?'); $s->execute([$id]); $x = $s->fetch(); if (!$x) { flash('Expedition not found.', 'err'); go('expeditions.php'); } }
$cats = db()->query('SELECT Id,Name FROM Category ORDER BY Id')->fetchAll(); $dests = db()->query('SELECT Id,Name FROM Destination ORDER BY Name')->fetchAll();
$fields = ['Name', 'ShortDescription', 'Description', 'Itinerary', 'Included', 'NotIncluded', 'Price', 'MaxGroupSize', 'Difficulty', 'DepartureLocation', 'StartDate', 'EndDate', 'CategoryId', 'DestinationId', 'FeaturedImage'];
$v = $x ?: array_fill_keys($fields, ''); if (!$x) { $v += ['IsFeatured' => 0, 'IsActive' => 1]; $v['Difficulty'] = 'Easy'; $v['DepartureLocation'] = 'Skopje'; }
$errs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') { check_csrf(); $act = $_POST['action'] ?? 'save';
  if ($act === 'remove_photo' && $id) {
    $p = db()->prepare('SELECT Image FROM ExpeditionPhoto WHERE Id=? AND ExpeditionId=?'); $p->execute([(int)$_POST['photo_id'], $id]); $img = $p->fetchColumn();
    if ($img !== false) { db()->prepare('DELETE FROM ExpeditionPhoto WHERE Id=?')->execute([(int)$_POST['photo_id']]); remove_local_image($img); flash('Photo removed.'); }
    go('expedition_form.php?id=' . $id . '#gallery');
  } elseif ($act === 'add_photos' && $id) {
    try { $n = 0; foreach (uploaded_files('photos') as $f) { if ($path = store_image($f)) { db()->prepare('INSERT INTO ExpeditionPhoto(ExpeditionId,Image) VALUES(?,?)')->execute([$id, $path]); $n++; } }
      if ($u = safe_image_ref($_POST['photo_url'] ?? '')) { db()->prepare('INSERT INTO ExpeditionPhoto(ExpeditionId,Image) VALUES(?,?)')->execute([$id, $u]); $n++; }
      flash($n ? "$n photo(s) added." : 'No photo selected.', $n ? 'ok' : 'err'); }
    catch (RuntimeException $ex) { flash($ex->getMessage(), 'err'); }
    go('expedition_form.php?id=' . $id . '#gallery');
  } else {
    foreach (['Name', 'ShortDescription', 'Description', 'Itinerary', 'Included', 'NotIncluded', 'Difficulty', 'DepartureLocation', 'StartDate', 'EndDate'] as $k) $v[$k] = trim($_POST[$k] ?? '');
    $v['Price'] = $_POST['Price'] ?? ''; $v['MaxGroupSize'] = $_POST['MaxGroupSize'] ?? ''; $v['CategoryId'] = (int)($_POST['CategoryId'] ?? 0); $v['DestinationId'] = (int)($_POST['DestinationId'] ?? 0);
    $v['IsFeatured'] = isset($_POST['IsFeatured']) ? 1 : 0; $v['IsActive'] = isset($_POST['IsActive']) ? 1 : 0;
    if ($v['Name'] === '' || mb_strlen($v['Name']) > 150) $errs[] = 'Enter a name (150 characters max).';
    if (mb_strlen($v['ShortDescription']) > 255) $errs[] = 'The short description must be 255 characters or fewer.';
    if (!is_numeric($v['Price']) || $v['Price'] < 0 || $v['Price'] > 999999) $errs[] = 'Enter a valid price.';
    if (!ctype_digit((string)$v['MaxGroupSize']) || (int)$v['MaxGroupSize'] < 1 || (int)$v['MaxGroupSize'] > 500) $errs[] = 'Enter a valid group size.';
    if (!in_array($v['Difficulty'], ['Easy', 'Moderate', 'Challenging'], true)) $errs[] = 'Choose a difficulty.';
    $d1 = DateTime::createFromFormat('Y-m-d', $v['StartDate']); $d2 = DateTime::createFromFormat('Y-m-d', $v['EndDate']); $days = 0;
    if (!$d1 || !$d2) $errs[] = 'Enter valid start and end dates.'; else { $days = (int)$d1->diff($d2)->format('%r%a') + 1; if ($days < 1) $errs[] = 'The end date cannot be before the start date.'; elseif ($days > 5) $errs[] = 'Expeditions can last at most 5 days.'; }
    if (!in_array($v['CategoryId'], array_column($cats, 'Id')) || !in_array($v['DestinationId'], array_column($dests, 'Id'))) $errs[] = 'Choose a category and a destination.';
    if ($x && ctype_digit((string)$v['MaxGroupSize']) && (int)$v['MaxGroupSize'] < booked_travelers($id)) $errs[] = 'The group size cannot be lower than the ' . booked_travelers($id) . ' travelers already booked or pending.';
    $old = $x['FeaturedImage'] ?? ''; $img = $old;
    if (!$errs) { try { if ($up = store_image($_FILES['featured'] ?? ['error' => UPLOAD_ERR_NO_FILE])) $img = $up; elseif ($ref = safe_image_ref($_POST['FeaturedImage'] ?? '')) $img = $ref; elseif (trim($_POST['FeaturedImage'] ?? '') !== '') $errs[] = 'The image path must start with https://, assets/ or uploads/.'; }
      catch (RuntimeException $ex) { $errs[] = $ex->getMessage(); } }
    if (!$errs) {
      $p = [$v['Name'], $v['ShortDescription'], $v['Description'], $v['Itinerary'], $v['Included'], $v['NotIncluded'], $v['Price'], $days, $v['Difficulty'], (int)$v['MaxGroupSize'], $v['DepartureLocation'], $img, $v['StartDate'], $v['EndDate'], $v['CategoryId'], $v['DestinationId'], $v['IsFeatured'], $v['IsActive']];
      if ($x) { db()->prepare('UPDATE Expedition SET Name=?,ShortDescription=?,Description=?,Itinerary=?,Included=?,NotIncluded=?,Price=?,DurationDays=?,Difficulty=?,MaxGroupSize=?,DepartureLocation=?,FeaturedImage=?,StartDate=?,EndDate=?,CategoryId=?,DestinationId=?,IsFeatured=?,IsActive=? WHERE Id=?')->execute([...$p, $id]);
        if ($old !== $img) remove_local_image($old); flash('Expedition saved.'); go('expedition_form.php?id=' . $id); }
      db()->prepare('INSERT INTO Expedition(Name,ShortDescription,Description,Itinerary,Included,NotIncluded,Price,DurationDays,Difficulty,MaxGroupSize,DepartureLocation,FeaturedImage,StartDate,EndDate,CategoryId,DestinationId,IsFeatured,IsActive) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)')->execute($p);
      flash('Expedition created. You can now add gallery photos.'); go('expedition_form.php?id=' . db()->lastInsertId()); } } }
$photos = []; if ($id) { $q = db()->prepare('SELECT * FROM ExpeditionPhoto WHERE ExpeditionId=? ORDER BY Id'); $q->execute([$id]); $photos = $q->fetchAll(); }
$lbl = 'block text-sm font-medium'; ?>
<a href="expeditions.php" class="text-sm underline">Back to expeditions</a>
<h1 class="font-display text-4xl mt-1"><?=$x ? 'Edit expedition' : 'New expedition'?></h1>
<?php if ($errs): ?><div role="alert" class="mt-4 p-3 bg-red-100 text-red-900 rounded"><ul class="list-disc pl-5"><?php foreach ($errs as $er): ?><li><?=e($er)?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" enctype="multipart/form-data" class="<?=$card?> mt-6 p-6 grid md:grid-cols-2 gap-5 max-w-5xl"><?=csrf_field()?><input type="hidden" name="action" value="save">
<label class="<?=$lbl?> md:col-span-2">Name<input name="Name" required maxlength="150" value="<?=e($v['Name'])?>" class="<?=$input?>"></label>
<label class="<?=$lbl?> md:col-span-2">Short description (shown on cards)<input name="ShortDescription" maxlength="255" value="<?=e($v['ShortDescription'])?>" class="<?=$input?>"></label>
<label class="<?=$lbl?> md:col-span-2">Description<textarea name="Description" rows="6" class="<?=$input?>"><?=e($v['Description'])?></textarea></label>
<label class="<?=$lbl?> md:col-span-2">Itinerary (one line per stop or day, e.g. "Day 1: Arrival and welcome dinner")<textarea name="Itinerary" rows="6" class="<?=$input?>"><?=e($v['Itinerary'])?></textarea></label>
<label class="<?=$lbl?>">Included (one item per line)<textarea name="Included" rows="5" class="<?=$input?>"><?=e($v['Included'])?></textarea></label>
<label class="<?=$lbl?>">Not included (one item per line)<textarea name="NotIncluded" rows="5" class="<?=$input?>"><?=e($v['NotIncluded'])?></textarea></label>
<label class="<?=$lbl?>">Category<select name="CategoryId" required class="<?=$input?>"><option value="">Choose…</option><?php foreach ($cats as $c): ?><option value="<?=$c['Id']?>" <?=$v['CategoryId'] == $c['Id'] ? 'selected' : ''?>><?=e($c['Name'])?></option><?php endforeach; ?></select></label>
<label class="<?=$lbl?>">Destination<select name="DestinationId" required class="<?=$input?>"><option value="">Choose…</option><?php foreach ($dests as $d): ?><option value="<?=$d['Id']?>" <?=$v['DestinationId'] == $d['Id'] ? 'selected' : ''?>><?=e($d['Name'])?></option><?php endforeach; ?></select></label>
<label class="<?=$lbl?>">Start date<input type="date" name="StartDate" required value="<?=e($v['StartDate'])?>" class="<?=$input?>"></label>
<label class="<?=$lbl?>">End date (duration is calculated, max 5 days)<input type="date" name="EndDate" required value="<?=e($v['EndDate'])?>" class="<?=$input?>"></label>
<label class="<?=$lbl?>">Price per person (€)<input type="number" name="Price" min="0" step="0.01" required value="<?=e($v['Price'])?>" class="<?=$input?>"></label>
<label class="<?=$lbl?>">Capacity (max group size)<input type="number" name="MaxGroupSize" min="1" required value="<?=e($v['MaxGroupSize'])?>" class="<?=$input?>"></label>
<label class="<?=$lbl?>">Difficulty<select name="Difficulty" class="<?=$input?>"><?php foreach (['Easy', 'Moderate', 'Challenging'] as $d): ?><option <?=$v['Difficulty'] === $d ? 'selected' : ''?>><?=$d?></option><?php endforeach; ?></select></label>
<label class="<?=$lbl?>">Departure location<input name="DepartureLocation" maxlength="120" value="<?=e($v['DepartureLocation'])?>" class="<?=$input?>"></label>
<fieldset class="md:col-span-2 border border-stone rounded p-4"><legend class="text-sm font-medium px-1">Featured image</legend>
<?php if ($v['FeaturedImage']): ?><img src="<?=img($v['FeaturedImage'])?>" alt="Current featured image" class="h-28 rounded mb-3"><?php endif; ?>
<label class="<?=$lbl?>">Upload (JPG, PNG or WebP, max 5 MB)<input type="file" name="featured" accept="image/jpeg,image/png,image/webp" class="mt-1 block text-sm"></label>
<label class="<?=$lbl?> mt-3">Or image path / URL<input name="FeaturedImage" value="<?=e($v['FeaturedImage'])?>" placeholder="assets/photos/example.jpg" class="<?=$input?>"></label></fieldset>
<div class="md:col-span-2 flex flex-wrap gap-6 text-sm"><label class="flex items-center gap-2"><input type="checkbox" name="IsActive" <?=$v['IsActive'] ? 'checked' : ''?>> Active (visible on the site)</label><label class="flex items-center gap-2"><input type="checkbox" name="IsFeatured" <?=$v['IsFeatured'] ? 'checked' : ''?>> Featured on the homepage</label></div>
<div class="md:col-span-2"><button class="<?=$btn?>">Save expedition</button></div></form>

<section id="gallery" class="<?=$card?> mt-8 p-6 max-w-5xl"><h2 class="font-display text-3xl">Gallery</h2>
<?php if (!$x): ?><p class="mt-2 text-sm text-ink/70">Save the expedition first, then add gallery photos here.</p><?php else: ?>
<div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4"><?php foreach ($photos as $p): ?><figure><img src="<?=img($p['Image'])?>" alt="Gallery photo" class="aspect-[4/3] w-full object-cover rounded">
<form method="post" class="mt-2" onsubmit="return confirm('Remove this photo?')"><?=csrf_field()?><input type="hidden" name="action" value="remove_photo"><input type="hidden" name="photo_id" value="<?=$p['Id']?>"><button class="<?=$danger?>">Remove</button></form></figure><?php endforeach; ?>
<?php if (!$photos): ?><p class="text-sm text-ink/70 col-span-full">No gallery photos yet.</p><?php endif; ?></div>
<form method="post" enctype="multipart/form-data" class="mt-6 space-y-3"><?=csrf_field()?><input type="hidden" name="action" value="add_photos">
<label class="<?=$lbl?>">Upload photos (you can select several)<input type="file" name="photos[]" multiple accept="image/jpeg,image/png,image/webp" class="mt-1 block text-sm"></label>
<label class="<?=$lbl?>">Or add one image path / URL<input name="photo_url" placeholder="assets/photos/example.jpg" class="<?=$input?>"></label>
<button class="<?=$btn?>">Add photos</button></form><?php endif; ?></section>
<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
