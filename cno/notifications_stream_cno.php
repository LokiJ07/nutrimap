<?php
// notifications_stream_cno.php
session_start();
require 'db/config.php';
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

$lastId = isset($_GET['lastId']) ? (int)$_GET['lastId'] : 0;

while (true) {
    $stmt = $pdo->prepare("SELECT MAX(id) as max_id FROM notifications");
    $stmt->execute();
    $maxId = (int)$stmt->fetch(PDO::FETCH_ASSOC)['max_id'];

    if($maxId > $lastId){
        echo "data: new_notification\n\n";
        ob_flush();
        flush();
        $lastId = $maxId;
    }
    sleep(3);
}
