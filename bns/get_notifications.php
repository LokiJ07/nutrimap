<?php
session_start();
require '../db/config.php';

if (!isset($_SESSION['user_id'])) {
    if (isset($_GET['count_unread'])) {
        echo json_encode(['totalUnread' => 0]);
        exit;
    } elseif (isset($_GET['latest_id'])) {
        echo json_encode(['latestId' => 0]);
        exit;
    } else {
        echo json_encode(['totalCount' => 0, 'totalUnread' => 0, 'notifications' => []]);
        exit;
    }
}

$userId = $_SESSION['user_id'];

// Handle latest ID only
if (isset($_GET['latest_id']) && $_GET['latest_id'] == 1) {
    $stmt = $pdo->prepare("SELECT COALESCE(MAX(id), 0) AS latestId FROM notifications WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['latestId' => (int)$row['latestId']]);
    exit;
}

// Handle unread count only
if (isset($_GET['count_unread']) && $_GET['count_unread'] == 1) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND read_status = 0");
    $stmt->execute([':user_id' => $userId]);
    echo json_encode(['totalUnread' => $stmt->fetchColumn()]);
    exit;
}

// Total count query
$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :user_id");
$stmtCount->execute([':user_id' => $userId]);
$totalCount = $stmtCount->fetchColumn();

// Unread count
$stmtUnread = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND read_status = 0");
$stmtUnread->execute([':user_id' => $userId]);
$totalUnread = $stmtUnread->fetchColumn();

// Pagination params
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$size = isset($_GET['size']) ? intval($_GET['size']) : 5;
$offset = ($page - 1) * $size;
$unreadOnly = isset($_GET['unread_only']) && $_GET['unread_only'] == 1;

// Base query for notifications
$whereClause = "WHERE user_id = :user_id";
$params = [':user_id' => $userId];
if ($unreadOnly) {
    $whereClause .= " AND read_status = 0";
    $totalCount = $totalUnread; // Override total for unread filter
}

$stmt = $pdo->prepare("
    SELECT id, message, 
           DATE_FORMAT(date, '%Y-%m-%d %H:%i:%s') AS date,
           read_status 
    FROM notifications 
    $whereClause 
    ORDER BY date DESC 
    LIMIT :size OFFSET :offset
");
$params[':size'] = $size;
$params[':offset'] = $offset;
$stmt->execute($params);

$notifications = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $notifications[] = [
        'id' => $row['id'],
        'message' => $row['message'],
        'date' => $row['date'],
        'read' => (bool)$row['read_status']
    ];
}

echo json_encode([
    'totalCount' => $totalCount,
    'totalUnread' => $totalUnread,
    'notifications' => $notifications
]);
?>