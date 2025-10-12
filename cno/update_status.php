<?php
session_start();
require '../db/config.php';

// 🛑 Check inputs
if (!isset($_POST['report_id']) || !isset($_POST['action'])) {
    echo json_encode(['error' => 'Missing data']);
    exit;
}

$report_id = $_POST['report_id'];
$action = strtolower(trim($_POST['action'])); // normalize the action input

// 🛑 Validate action
if (!in_array($action, ['approve', 'reject'])) {
    echo json_encode(['error' => 'Invalid action']);
    exit;
}

// 🟩 Set status based on action
$status = ($action === 'approve') ? 'Approved' : 'Rejected';

// 🟩 Update report status
$stmt = $pdo->prepare("UPDATE reports SET status = ? WHERE id = ?");
if ($stmt->execute([$status, $report_id])) {

    // 🟦 Fetch user_id of the report owner
    $userStmt = $pdo->prepare("SELECT user_id FROM reports WHERE id = ?");
    $userStmt->execute([$report_id]);
    $report = $userStmt->fetch(PDO::FETCH_ASSOC);

    if ($report && isset($report['user_id'])) {
        $user_id = $report['user_id'];

        // 🟢 Set message based on action
        if ($action === 'approve') {
            $message = "Your report has been approved!";
        } else {
            $message = "Your report has been rejected.";
        }

        // 🟢 Insert the notification
        $notifyStmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
        $notifyStmt->execute([$user_id, $message]);
    }

    // 🟢 Return response to frontend
    echo json_encode(['status' => $status, 'message' => $message]);
} else {
    echo json_encode(['error' => 'Failed to update report']);
}
?>
