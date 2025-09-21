<?php
session_start();
require '../db/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['report_id'])) {
    $id = (int)$_POST['report_id'];
    if (isset($_POST['approve'])) {
        $stmt = $pdo->prepare("UPDATE reports SET status = 'Approved' WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['success'] = "Report approved successfully.";
    } elseif (isset($_POST['reject'])) {
        $stmt = $pdo->prepare("UPDATE reports SET status = 'Rejected' WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['success'] = "Report rejected successfully.";
    }
}

header("Location: cno_reports.php");
exit();
