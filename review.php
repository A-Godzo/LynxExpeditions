<?php require 'includes/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: expeditions.php'); exit; }
check_csrf(); require_login();
$eid = (int)($_POST['expedition_id'] ?? 0); $rating = (int)($_POST['rating'] ?? 0); $comment = trim($_POST['comment'] ?? '');
$back = 'expedition.php?id=' . $eid . '#reviews';
if ($rating < 1 || $rating > 5 || $comment === '' || mb_strlen($comment) > 2000) { flash('Choose a rating and write a short comment (max 2000 characters).', 'err'); go($back); }
if (!can_review((int)user()['Id'], $eid)) { flash('You can review an expedition once, after a confirmed booking.', 'err'); go($back); }
try { db()->prepare('INSERT INTO Review(UserId,ExpeditionId,Rating,Comment) VALUES(?,?,?,?)')->execute([user()['Id'], $eid, $rating, $comment]); flash('Thanks, your review is now public.'); }
catch (PDOException $ex) { flash('You have already reviewed this expedition.', 'err'); }
go($back);
