<?php $title='Expeditions'; require 'includes/header.php';
$w=['e.IsActive=1']; $p=[];
if(($q=trim($_GET['q']??''))!==''){ $w[]='(e.Name LIKE ? OR e.ShortDescription LIKE ?)'; $p[]="%$q%"; $p[]="%$q%"; }
foreach(['category'=>'e.CategoryId','destination'=>'e.DestinationId','difficulty'=>'e.Difficulty','duration'=>'e.DurationDays','month'=>'MONTH(e.StartDate)'] as $k=>$col){ if(($_GET[$k]??'')!==''){ $w[]="$col=?"; $p[]=$_GET[$k]; } }
if(($_GET['max_price']??'')!==''){ $w[]='e.Price<=?'; $p[]=(float)$_GET['max_price']; }
$s=db()->prepare('SELECT e.*,c.Name Category FROM Expedition e JOIN Category c ON c.Id=e.CategoryId WHERE '.implode(' AND ',$w).' ORDER BY e.StartDate'); $s->execute($p); $rows=$s->fetchAll();
$cats=db()->query('SELECT * FROM Category')->fetchAll(); $dests=db()->query('SELECT Id,Name FROM Destination ORDER BY Name')->fetchAll();
function sel($k,$v){ return ($_GET[$k]??'')==$v?'selected':''; }
$f='border border-stone rounded px-3 py-2 bg-white text-sm'; ?>
<div class="max-w-7xl mx-auto px-4 py-12"><h1 class="font-display text-5xl">Expeditions</h1>
<form method="get" class="mt-6 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3">
<label class="col-span-2"><span class="sr-only">Search</span><input name="q" value="<?=e($q)?>" placeholder="Search expeditions" class="<?=$f?> w-full"></label>
<select name="category" aria-label="Category" class="<?=$f?>"><option value="">Category</option><?php foreach($cats as $c): ?><option value="<?=$c['Id']?>" <?=sel('category',$c['Id'])?>><?=e($c['Name'])?></option><?php endforeach; ?></select>
<select name="destination" aria-label="Destination" class="<?=$f?>"><option value="">Destination</option><?php foreach($dests as $d): ?><option value="<?=$d['Id']?>" <?=sel('destination',$d['Id'])?>><?=e($d['Name'])?></option><?php endforeach; ?></select>
<select name="duration" aria-label="Duration" class="<?=$f?>"><option value="">Duration</option><?php for($i=1;$i<=5;$i++): ?><option value="<?=$i?>" <?=sel('duration',$i)?>><?=$i?> day<?=$i>1?'s':''?></option><?php endfor; ?></select>
<select name="difficulty" aria-label="Difficulty" class="<?=$f?>"><option value="">Difficulty</option><?php foreach(['Easy','Moderate','Challenging'] as $d): ?><option <?=sel('difficulty',$d)?>><?=$d?></option><?php endforeach; ?></select>
<input name="max_price" type="number" min="0" placeholder="Max €" value="<?=e($_GET['max_price']??'')?>" aria-label="Maximum price" class="<?=$f?>">
<select name="month" aria-label="Departure month" class="<?=$f?>"><option value="">Month</option><?php for($m=1;$m<=12;$m++): ?><option value="<?=$m?>" <?=sel('month',$m)?>><?=date('F',mktime(0,0,0,$m,1))?></option><?php endfor; ?></select>
<button class="bg-forest text-bone rounded px-4 py-2 col-span-2 md:col-span-4 lg:col-span-8 lg:w-40">Apply filters</button></form>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10"><?php foreach($rows as $x) include 'includes/card.php'; ?></div>
<?php if(!$rows): ?><p class="mt-10">No expeditions match these filters. Try removing one.</p><?php endif; ?></div>
<?php require 'includes/footer.php'; ?>
