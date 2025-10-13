<?php
// mark_as_read_cno.php
session_start();
require 'db/config.php';

$userId = $_SESSION['user_id'] ?? 0;
if(!$userId){
    echo json_encode(['status'=>'error', 'message'=>'Unauthorized']);
    exit;
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['id'])){
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE notifications SET read=1 WHERE id=:id");
        $stmt->execute([':id'=>$id]);
    } else {
        // mark all
        $stmt = $pdo->query("UPDATE notifications SET read=1");
    }
    echo json_encode(['status'=>'success']);
}
