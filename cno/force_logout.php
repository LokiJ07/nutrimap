<?php
session_start();
require '../db/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request");
}

$user_id = $_SESSION['user_id'];
$login_id = (int) $_GET['id'];

// ✅ Get the session ID of that login entry
$stmt = $pdo->prepare("SELECT session_id FROM login_history WHERE id = ? AND user_id = ?");
$stmt->execute([$login_id, $user_id]);
$login = $stmt->fetch(PDO::FETCH_ASSOC);

if ($login) {
    $sessionId = $login['session_id'];

    // ✅ Completely remove this device from login history
    $delete = $pdo->prepare("DELETE FROM login_history WHERE id = ? AND user_id = ?");
    $delete->execute([$login_id, $user_id]);

    // ✅ Destroy session file ONLY for that device/session
    $sessionFile = session_save_path() . "/sess_" . $sessionId;
    if (file_exists($sessionFile)) {
        @unlink($sessionFile);
    }
}

// ✅ Go back to security page
header("Location: security.php");
exit;
