<?php
session_start();
require '../db/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: security.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$login_id = (int) $_GET['id'];

// ✅ Fetch the specific login record
$stmt = $pdo->prepare("SELECT session_id, device_token FROM login_history WHERE id = ? AND user_id = ?");
$stmt->execute([$login_id, $user_id]);
$login = $stmt->fetch(PDO::FETCH_ASSOC);

if ($login) {
    $sessionId = $login['session_id'];
    $deviceToken = $login['device_token'];

    // ✅ Delete only this specific login record (the clicked device)
    $delete = $pdo->prepare("DELETE FROM login_history WHERE id = ? AND user_id = ?");
    $delete->execute([$login_id, $user_id]);

    // ✅ Remove PHP session file (end session)
    $sessionPath = session_save_path() ?: sys_get_temp_dir();
    $sessionFile = rtrim($sessionPath, '/') . "/sess_" . $sessionId;
    if (file_exists($sessionFile)) {
        @unlink($sessionFile);
    }

    // ✅ (Optional) also remove this token from cookies/trusted list if stored elsewhere
    // Example: $pdo->prepare("DELETE FROM trusted_devices WHERE device_token = ? AND user_id = ?")->execute([$deviceToken, $user_id]);

    // ✅ Log the activity
    $log = $pdo->prepare("INSERT INTO activity_logs (user_id, action, created_at) VALUES (?, ?, NOW())");
    $log->execute([$user_id, 'Force logged out a specific device']);

    // ✅ Flash message and redirect
    $_SESSION['flash_message'] = "Selected device has been force logged out.";
    header("Location: security.php");
    exit();
} else {
    $_SESSION['flash_message'] = "Device not found.";
    header("Location: security.php");
    exit();
}
?>
