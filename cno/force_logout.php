<?php
session_start();
require '../db/config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "Unauthorized";
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo "Invalid request";
    exit();
}

$user_id = $_SESSION['user_id'];
$login_id = (int) $_GET['id'];

// Fetch the login record for that device/session
$stmt = $pdo->prepare("SELECT session_id, device_token, ip_address FROM login_history WHERE id = ? AND user_id = ?");
$stmt->execute([$login_id, $user_id]);
$login = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$login) {
    $_SESSION['flash_message'] = "Device not found.";
    header("Location: security.php");
    exit();
}

// Get the IP of the selected login
$target_ip = $login['ip_address'];
$target_session_id = $login['session_id'];
$target_device_token = $login['device_token'];

// ❌ Remove only that session or any session with same IP but different browser
$deleteStmt = $pdo->prepare("
    DELETE FROM login_history 
    WHERE user_id = ? 
    AND ip_address = ? 
    AND id != ?  -- optional: skip the one if you want to keep it?
");
$deleteStmt->execute([$user_id, $target_ip, $login_id]);

// Delete the selected session explicitly (just in case)
$deleteSelected = $pdo->prepare("DELETE FROM login_history WHERE id = ? AND user_id = ?");
$deleteSelected->execute([$login_id, $user_id]);

// Log the forced logout action
$log = $pdo->prepare("INSERT INTO activity_logs (user_id, action, created_at) VALUES (?, ?, NOW())");
$log->execute([$user_id, "Force logged out session(s) with IP: $target_ip"]);

// Redirect back
$_SESSION['flash_message'] = "Selected device/browser and all sessions with the same IP have been force logged out.";
header("Location: security.php");
exit();
?>