
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

// 🔹 Permanently delete the report from reports table
$delStmt = $pdo->prepare("DELETE FROM reports WHERE id = ?");
$delStmt->execute([$reportId]);

// 🔹 Optional: delete related bns_reports data if exists
$delBns = $pdo->prepare("DELETE FROM bns_reports WHERE report_id = ?");
$delBns->execute([$reportId]);

// ✅ Log the activity (only if user is logged in)
if (isset($_SESSION['user_id'])) {
    logActivity($pdo, $_SESSION['user_id'], "Deleted report ID: $reportId");
}

// 🔹 Redirect back to archive page
header("Location: ../archive_report.php?msg=deleted");
exit();
