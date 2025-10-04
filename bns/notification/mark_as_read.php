<?php
// mark_as_read.php

// Your database connection
// $pdo = new PDO(...);

session_start();
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = intval($_POST['id']);

  $stmt = $pdo->prepare("UPDATE notifications SET read = 1 WHERE id = :id AND user_id = :user_id");
  $stmt->execute([':id' => $id, ':user_id' => $userId]);

  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error']);
}
?>