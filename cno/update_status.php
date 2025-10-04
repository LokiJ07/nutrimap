<?php
session_start();
require '../db/config.php';

if(!isset($_POST['report_id']) || !isset($_POST['action'])){
    echo json_encode(['error'=>'Missing data']);
    exit;
}

$report_id = $_POST['report_id'];
$action = $_POST['action'];

if(!in_array($action,['approve','reject'])){
    echo json_encode(['error'=>'Invalid action']);
    exit;
}

$status = $action==='approve' ? 'Approved' : 'Rejected';

$stmt = $pdo->prepare("UPDATE reports SET status=? WHERE id=?");
if($stmt->execute([$status, $report_id])){
    // If approved, insert notification
    if($action === 'approve') {
        // Fetch report owner/user_id
        $userStmt = $pdo->prepare("SELECT user_id FROM reports WHERE id = ?");
        $userStmt->execute([$report_id]);
        $report = $userStmt->fetch(PDO::FETCH_ASSOC);
        if ($report && isset($report['user_id'])) {
            $user_id = $report['user_id'];
            $message = "Your report has been approved!";
            $notifyStmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
            $notifyStmt->execute([$user_id, $message]);
        }
    }

    echo json_encode(['status'=>strtolower($status)]);
} else {
    echo json_encode(['error'=>'Failed to update report']);
}
?>