<?php
session_start();
require '../../db/config.php';

// ✅ Activity log function
function logActivity($pdo, $user_id, $action) {
    $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action) VALUES (?, ?)");
    $stmt->execute([$user_id, $action]);
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request");
}

$reportId = (int) $_GET['id'];

// 🔹 Update report status back to Pending (or Approved if needed)
$updateStmt = $pdo->prepare("UPDATE reports SET status = 'Pending' WHERE id = ?");
$updateStmt->execute([$reportId]);

// ✅ Log the activity (only if user is logged in)
if (isset($_SESSION['user_id'])) {
    logActivity($pdo, $_SESSION['user_id'], "Restored report ID: $reportId");
}

// 🔹 Redirect back to main reports page
header("Location: ../archive.php?msg=restored");
exit();