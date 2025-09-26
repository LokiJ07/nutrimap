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
    echo json_encode(['status'=>strtolower($status)]);
} else {
    echo json_encode(['error'=>'Failed to update report']);
}
?>
