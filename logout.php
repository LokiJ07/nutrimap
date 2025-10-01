<?php
// logout.php
session_start();

// ✅ Log activity before destroying the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$user_id, "Logged out"]);
    } catch (PDOException $e) {
        // Optional: silently fail to avoid breaking logout
    }
}


session_unset();  // remove all session variables
session_destroy(); // destroy the session

// Redirect to login page
header("Location: index.php");
exit();
