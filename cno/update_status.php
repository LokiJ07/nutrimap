<?php
session_start();
require '../db/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!=='CNO') {
    echo json_encode(['error'=>'Unauthorized']);
    exit();
}

if(!isset($_POST['report_id'], $_POST['action'])){
    echo json_encode(['error'=>'Invalid request']);
    exit();
}

$id = (int)$_POST['report_id'];
$action = $_POST['action'];

if($action==='approve'){
    $stmt = $pdo->prepare("UPDATE reports SET status='Approved' WHERE id=:id");
    $stmt->execute(['id'=>$id]);
    echo json_encode(['status'=>'approved']);
} elseif($action==='reject'){
    $stmt = $pdo->prepare("UPDATE reports SET status='Rejected' WHERE id=:id");
    $stmt->execute(['id'=>$id]);
    echo json_encode(['status'=>'rejected']);
} else{
    echo json_encode(['error'=>'Unknown action']);
}

header("Location: cno_reports.php");
exit();