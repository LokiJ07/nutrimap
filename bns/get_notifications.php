<?php
session_start();
require '../db/config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['totalCount' => 0, 'notifications' => []]);
    exit;
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$size = isset($_GET['size']) ? intval($_GET['size']) : 5;
$offset = ($page - 1) * $size;

// Count total notifications
$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :user_id");
$stmtCount->execute([':user_id' => $_SESSION['user_id']]);
$totalCount = $stmtCount->fetchColumn();

// Fetch paginated notifications
$stmt = $pdo->prepare("SELECT id, message, date, read_status FROM notifications WHERE user_id = :user_id ORDER BY date DESC LIMIT :limit OFFSET :offset");
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->bindParam(':limit', $size, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

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
    'notifications' => $notifications
]);
?>