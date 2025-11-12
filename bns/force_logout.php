<?php
session_start();
require '../db/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: security.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$login_id = (int) $_GET['id'];

// ✅ Fetch session ID and device token of that login
$stmt = $pdo->prepare("SELECT session_id, device_token FROM login_history WHERE id = ? AND user_id = ?");
$stmt->execute([$login_id, $user_id]);
$login = $stmt->fetch(PDO::FETCH_ASSOC);

if ($login) {
    $sessionId = $login['session_id'];
    $deviceToken = $login['device_token'];

    // Delete login history
    $delete = $pdo->prepare("DELETE FROM login_history WHERE id = ? AND user_id = ?");
    $delete->execute([$login_id, $user_id]);

    // Remove PHP session file (if accessible)
    $sessionPath = session_save_path() ?: sys_get_temp_dir();
    $sessionFile = rtrim($sessionPath, '/') . "/sess_" . $sessionId;
    if (file_exists($sessionFile)) {
        @unlink($sessionFile);
    }

    // Clear current session and force OTP on next login
    $clearSession = $pdo->prepare("UPDATE users SET current_session = NULL, otp_verified = 0 WHERE id = ?");
    $clearSession->execute([$user_id]);

    // Remove this device token association
    $removeDevice = $pdo->prepare("DELETE FROM login_history WHERE device_token = ? AND user_id = ?");
    $removeDevice->execute([$deviceToken, $user_id]);

    // Log activity
    $log = $pdo->prepare("INSERT INTO activity_logs (user_id, action, created_at) VALUES (?, ?, NOW())");
    $log->execute([$user_id, 'Force logged out another device']);

    // Flash message
    $_SESSION['flash_message'] = "Device successfully logged out.";

    // Redirect back to security page
    header("Location: security.php");
    exit();
} else {
    $_SESSION['flash_message'] = "Device not found.";
    header("Location: security.php");
    exit();
}
