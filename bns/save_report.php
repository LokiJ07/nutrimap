<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../db/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$barangay = $_SESSION['barangay']; // barangay auto-filled
$year = $_POST['year'] ?? null;

$stmt = $pdo->prepare("INSERT INTO barangay_bns_reports (barangay, year) VALUES (?, ?)");
$stmt->execute([$barangay, $year]);

echo "Report saved for Barangay: " . htmlspecialchars($barangay);
