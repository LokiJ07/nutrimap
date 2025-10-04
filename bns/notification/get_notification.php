<?php
// get_notifications.php

  require '../../db/config.php';

session_start();
$userId = $_SESSION['user_id']; // or your method of user identification

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$size = isset($_GET['size']) ? intval($_GET['size']) : 5;
$offset = ($page - 1) * $size;

// Get total notifications count
$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :user_id");
$stmtCount->execute([':user_id' => $userId]);
$totalCount = $stmtCount->fetchColumn();

// Get notifications for current page
$stmt = $pdo->prepare("SELECT id, message, date, read_status FROM notifications WHERE user_id = :user_id ORDER BY date DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
$stmt->bindValue(':limit', $size, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
  'notifications' => $notifications,
  'totalCount' => intval($totalCount)
]);
?>