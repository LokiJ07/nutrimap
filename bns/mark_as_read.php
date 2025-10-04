<?php
session_start();
require '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE notifications SET read_status = 1 WHERE id = :id AND user_id = :user_id");
    $stmt->execute([':id' => $id, ':user_id' => $_SESSION['user_id']]);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>