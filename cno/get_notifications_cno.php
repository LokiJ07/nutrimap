<?php
// get_notifications_cno.php
session_start();
require 'db/config.php'; // your PDO connection

$userId = $_SESSION['user_id'] ?? 0;
if(!$userId) {
    echo json_encode(['notifications'=>[], 'totalCount'=>0, 'totalUnread'=>0]);
    exit;
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$size = isset($_GET['size']) ? (int)$_GET['size'] : 5;
$offset = ($page-1)*$size;

$unreadOnly = isset($_GET['unread_only']) ? true : false;

// Total unread
$stmtUnread = $pdo->query("SELECT COUNT(*) as cnt FROM notifications");
$totalUnread = $stmtUnread->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0;

// Total notifications
$stmtTotal = $pdo->query("SELECT COUNT(*) as cnt FROM notifications");
$totalCount = $stmtTotal->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0;

// Fetch notifications with user barangay
$sql = "SELECT n.id, n.message, n.date, n.read, u.barangay
        FROM notifications n
        JOIN users u ON n.user_id = u.id
        " . ($unreadOnly ? "WHERE n.read=0" : "") . "
        ORDER BY n.id DESC
        LIMIT :size OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':size', $size, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'notifications' => $notifications,
    'totalCount' => (int)$totalCount,
    'totalUnread' => (int)$totalUnread
]);
