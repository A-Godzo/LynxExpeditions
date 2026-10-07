<?php $title='Log in'; require 'includes/header.php'; $err=''; $mode=($_GET['mode']??'login');
$next=$_GET['next']??''; if($next===''||!preg_match('/^[\w\-.\/?=&%~]+$/',$next)||str_starts_with($next,'//')) $next=null;
if($_SERVER['REQUEST_METHOD']==='POST'){ check_csrf(); $em=strtolower(trim($_POST['email']??'')); $pw=$_POST['password']??'';
 if($_POST['mode']==='register'){ $fn=trim($_POST['first']??''); $ln=trim($_POST['last']??'');
  if(!$fn||!$ln||!filter_var($em,FILTER_VALIDATE_EMAIL)) $err='Fill in all fields with a valid email.';
  elseif(strlen($pw)<8) $err='Use a password of at least 8 characters.'; elseif($pw!==($_POST['confirm']??'')) $err='Passwords do not match.';
  else { try { db()->prepare("INSERT INTO User(FirstName,LastName,Email,PasswordHash,Role) VALUES(?,?,?,?, 'Customer')")->execute([$fn,$ln,$em,password_hash($pw,PASSWORD_DEFAULT)]); $mode='login'; $err='Account created. Log in below.'; } catch(PDOException $ex){ $err='That email is already registered.'; } } }
 else { $s=db()->prepare('SELECT * FROM User WHERE Email=?'); $s->execute([$em]); $u=$s->fetch();
  if($u&&password_verify($pw,$u['PasswordHash'])){ session_regenerate_id(true); unset($u['PasswordHash']); $_SESSION['user']=$u;
   if(!empty($_POST['remember'])) setcookie(session_name(),session_id(),['expires'=>time()+60*60*24*30,'path'=>'/','httponly'=>true,'samesite'=>'Lax']);
   header('Location: '.($next ?? ($u['Role']==='Admin'?'admin/index.php':'index.php'))); exit; } $err='Email or password is incorrect.'; } }
$c='mt-1 w-full border border-stone rounded px-3 py-2 bg-white'; ?>
<div class="max-w-md mx-auto px-4 py-16"><h1 class="font-display text-5xl"><?=$mode==='register'?'Create account':'Log in'?></h1>
<?php if($err): ?><p role="alert" class="mt-4 p-3 bg-stone rounded"><?=e($err)?></p><?php endif; ?>
<form method="post" class="mt-6 space-y-4"><?=csrf_field()?><input type="hidden" name="mode" value="<?=e($mode)?>">
<?php if($mode==='register'): ?><label class="block text-sm">First name<input name="first" required class="<?=$c?>"></label><label class="block text-sm">Last name<input name="last" required class="<?=$c?>"></label><?php endif; ?>
<label class="block text-sm">Email<input type="email" name="email" required class="<?=$c?>"></label>
<label class="block text-sm">Password<input type="password" name="password" required class="<?=$c?>"></label>
<?php if($mode==='register'): ?><label class="block text-sm">Confirm password<input type="password" name="confirm" required class="<?=$c?>"></label>
<?php else: ?><label class="flex gap-2 text-sm"><input type="checkbox" name="remember"> Remember me</label><?php endif; ?>
<button class="w-full bg-forest text-bone px-4 py-3 rounded font-semibold"><?=$mode==='register'?'Create account':'Log in'?></button></form>
<p class="mt-4 text-sm"><?php if($mode==='register'): ?>Have an account? <a class="underline" href="auth.php">Log in</a><?php else: ?>New to Lynx? <a class="underline" href="auth.php?mode=register">Register</a><?php endif; ?></p></div>
<?php require 'includes/footer.php'; ?>
