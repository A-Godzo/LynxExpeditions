<?php require 'includes/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: expeditions.php'); exit; }
check_csrf(); require_login();
$uid = user()['Id']; $eid = (int)($_POST['expedition_id'] ?? 0);
$ex = db()->prepare('SELECT Id FROM Expedition WHERE Id=?'); $ex->execute([$eid]);
if (!$ex->fetch()) { http_response_code(404); exit('Not found'); }
$del = db()->prepare('DELETE FROM Favorite WHERE UserId=? AND ExpeditionId=?'); $del->execute([$uid, $eid]);
$faved = false;
if (!$del->rowCount()) { db()->prepare('INSERT IGNORE INTO Favorite(UserId,ExpeditionId) VALUES(?,?)')->execute([$uid, $eid]); $faved = true; } // unique key za da nemat duplikati
if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch') { header('Content-Type: application/json'); echo json_encode(['favorited' => $faved]); exit; }
$back = $_POST['back'] ?? 'expeditions.php'; if (!preg_match('/^[\w\-.\/?=&%~]+$/', $back) || str_starts_with($back, '//')) $back = 'expeditions.php';
header('Location: ' . $back); exit;
