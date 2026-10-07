<?php $title='Expedition'; require 'includes/header.php';
$s=db()->prepare('SELECT e.*,c.Name Category,d.Name Destination FROM Expedition e JOIN Category c ON c.Id=e.CategoryId JOIN Destination d ON d.Id=e.DestinationId WHERE e.Id=? AND e.IsActive=1'); $s->execute([(int)($_GET['id']??0)]); $x=$s->fetch();
if(!$x){ require 'includes/not_found.php'; }
$msg=$err=''; $id=(int)$x['Id'];
if($_SERVER['REQUEST_METHOD']==='POST'){ check_csrf(); require_login();
 $n=(int)($_POST['travelers']??0); $note=trim($_POST['message']??'');
 if($x['StartDate']<=date('Y-m-d')) $err='This expedition has already departed.'; elseif($n<1) $err='Enter at least one traveler.'; elseif(empty($_POST['terms'])) $err='Accept the Terms & Conditions to continue.';
 else { $pdo=db(); $pdo->beginTransaction();
  $pdo->prepare('SELECT Id FROM Expedition WHERE Id=? FOR UPDATE')->execute([$id]);
  $left=$x['MaxGroupSize']-booked_travelers($id);
  if($n>$left){ $err="Only $left place(s) left on this expedition."; $pdo->rollBack(); }
  else { $pdo->prepare('INSERT INTO Booking(UserId,ExpeditionId,NumberOfTravelers,CustomerMessage) VALUES(?,?,?,?)')->execute([user()['Id'],$id,$n,$note]); $bid=$pdo->lastInsertId(); $pdo->commit(); $msg="Request received. Your booking ID is #$bid and its status is Pending."; } } }
$left=max(0,$x['MaxGroupSize']-booked_travelers($id)); $departed=$x['StartDate']<=date('Y-m-d');
$photos=db()->prepare('SELECT Image FROM ExpeditionPhoto WHERE ExpeditionId=? ORDER BY Id'); $photos->execute([$id]); $photos=$photos->fetchAll();
$revs=db()->prepare('SELECT r.*,u.FirstName,u.LastName FROM Review r JOIN User u ON u.Id=r.UserId WHERE r.ExpeditionId=? ORDER BY r.CreatedAt DESC'); $revs->execute([$id]); $revs=$revs->fetchAll();
$avg=$revs?array_sum(array_column($revs,'Rating'))/count($revs):0;
$faved=in_array($id,fav_ids(),true); $canReview=user()&&can_review((int)user()['Id'],$id); ?>
<section class="relative bg-ink text-bone"><img src="<?=img($x['FeaturedImage'])?>" alt="<?=e($x['Name'])?>" class="absolute inset-0 w-full h-full object-cover opacity-50">
<div class="relative max-w-7xl mx-auto px-4 py-28"><p><?=e($x['Category'])?>, <?=e($x['Destination'])?></p><h1 class="font-display text-6xl md:text-7xl"><?=e($x['Name'])?></h1>
<p class="mt-3"><?=$x['DurationDays']?> days, <?=e($x['Difficulty'])?>, <?=e($x['StartDate'])?> to <?=e($x['EndDate'])?>, €<?=number_format($x['Price'],0)?> per person</p>
<?php if($revs): ?><p class="mt-2"><?=stars((int)round($avg))?> <span class="text-sm"><?=number_format($avg,1)?> (<?=count($revs)?> review<?=count($revs)>1?'s':''?>)</span></p><?php endif; ?>
<div class="mt-6 flex flex-wrap gap-3"><a href="#book" class="bg-amber text-ink px-6 py-3 rounded font-semibold">Request to Book</a>
<?php if(user()): ?><form method="post" action="favorite.php" class="fav-form"><?=csrf_field()?><input type="hidden" name="expedition_id" value="<?=$id?>"><input type="hidden" name="back" value="<?=e($_SERVER['REQUEST_URI'])?>"><button class="fav-btn inline-flex items-center gap-2 border border-bone/50 px-5 py-3 rounded" aria-pressed="<?=$faved?'true':'false'?>"><svg class="h-5 w-5" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true"><path d="M12 21s-7-4.5-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 6C19 16.5 12 21 12 21z"/></svg>Favorite</button></form>
<?php else: ?><a href="auth.php?next=<?=urlencode($_SERVER['REQUEST_URI'])?>" class="border border-bone/50 px-5 py-3 rounded">Log in to favorite</a><?php endif; ?></div></section>
<div class="max-w-7xl mx-auto px-4 py-12 grid lg:grid-cols-3 gap-10">
<div class="lg:col-span-2 space-y-10 max-w-prose">
<section><h2 class="font-display text-3xl">Overview</h2><p class="mt-3 whitespace-pre-line"><?=e($x['Description'])?></p></section>
<section><h2 class="font-display text-3xl">Itinerary</h2><ol class="mt-4 border-l-2 border-amber pl-6 space-y-4"><?php foreach(array_filter(array_map('trim',explode("\n",$x['Itinerary']))) as $line): ?><li><?=e($line)?></li><?php endforeach; ?></ol></section>
<section class="grid sm:grid-cols-2 gap-6"><div><h2 class="font-display text-2xl">Included</h2><ul class="mt-2 list-disc pl-5"><?php foreach(array_filter(array_map('trim',explode("\n",$x['Included']))) as $i): ?><li><?=e($i)?></li><?php endforeach; ?></ul></div>
<div><h2 class="font-display text-2xl">Not included</h2><ul class="mt-2 list-disc pl-5"><?php foreach(array_filter(array_map('trim',explode("\n",$x['NotIncluded']))) as $i): ?><li><?=e($i)?></li><?php endforeach; ?></ul></div></section>
<?php if($photos): ?><section><h2 class="font-display text-3xl">Gallery</h2><div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-3"><?php foreach($photos as $p): ?><img src="<?=img($p['Image'])?>" alt="<?=e($x['Name'])?> photo" loading="lazy" class="aspect-[4/3] w-full object-cover rounded"><?php endforeach; ?></div></section><?php endif; ?>
<section id="reviews"><h2 class="font-display text-3xl">Reviews</h2>
<?php if(!$revs): ?><p class="mt-3 text-ink/70">No reviews yet.</p><?php endif; ?>
<?php foreach($revs as $r): ?><article class="mt-4 border-t border-stone pt-4"><p><?=stars((int)$r['Rating'])?></p><p class="mt-1 whitespace-pre-line"><?=e($r['Comment'])?></p><p class="mt-1 text-sm text-ink/60"><?=e($r['FirstName'].' '.mb_substr($r['LastName'],0,1).'.')?>, <?=fmt_date($r['CreatedAt'])?></p></article><?php endforeach; ?>
<?php if($canReview): ?><form method="post" action="review.php" class="mt-6 bg-white border border-stone rounded-lg p-5 space-y-3"><?=csrf_field()?><input type="hidden" name="expedition_id" value="<?=$id?>"><h3 class="font-display text-2xl">Write a review</h3>
<label class="block text-sm">Rating<select name="rating" required class="mt-1 block border border-stone rounded px-3 py-2"><?php for($i=5;$i>=1;$i--): ?><option value="<?=$i?>"><?=$i?> star<?=$i>1?'s':''?></option><?php endfor; ?></select></label>
<label class="block text-sm">Your review<textarea name="comment" rows="4" required maxlength="2000" class="mt-1 w-full border border-stone rounded px-3 py-2"></textarea></label>
<button class="bg-forest text-bone px-5 py-2 rounded font-semibold">Post review</button></form><?php endif; ?></section>
</div>
<aside id="book" class="bg-white border border-stone rounded-lg p-6 h-fit"><h2 class="font-display text-3xl">Request to book</h2><p class="text-sm mt-1"><?=$left?> of <?=$x['MaxGroupSize']?> places left. No payment is taken online.</p>
<?php if($msg): ?><p role="status" class="mt-4 p-3 bg-forest text-bone rounded"><?=e($msg)?></p><?php endif; ?>
<?php if($err): ?><p role="alert" class="mt-4 p-3 bg-red-100 text-red-900 rounded"><?=e($err)?></p><?php endif; ?>
<?php if(!user()): ?><a href="auth.php?next=<?=urlencode($_SERVER['REQUEST_URI'])?>" class="block mt-4 text-center bg-amber px-4 py-3 rounded font-semibold">Log in to request</a>
<?php elseif($departed): ?><p class="mt-4 font-semibold">This expedition has already departed.</p>
<?php elseif($left>0): ?><form method="post" class="mt-4 space-y-3"><?=csrf_field()?>
<label class="block text-sm">Number of travelers<input type="number" name="travelers" min="1" max="<?=$left?>" required class="mt-1 w-full border border-stone rounded px-3 py-2"></label>
<label class="block text-sm">Message (optional)<textarea name="message" rows="3" class="mt-1 w-full border border-stone rounded px-3 py-2"></textarea></label>
<label class="flex gap-2 text-sm"><input type="checkbox" name="terms" required> I accept the Terms &amp; Conditions</label>
<button class="w-full bg-amber px-4 py-3 rounded font-semibold">Request to Book</button></form>
<?php else: ?><p class="mt-4 font-semibold">This expedition is full.</p><?php endif; ?></aside></div>
<?php require 'includes/footer.php'; ?>
