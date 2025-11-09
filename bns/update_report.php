<?php
session_start();
require '../db/config.php';
require_once '../otp/mailer.php'; // ✅ include mailer

// ✅ Require login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$reportId = $_POST['report_id'] ?? 0;
if (!is_numeric($reportId) || $reportId <= 0) {
    die("Invalid report ID");
}

$userId = $_SESSION['user_id'];

// ✅ Activity log function
function logActivity($pdo, $user_id, $action, $details = null) {
    $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $action, $details]);
}

try {
    $pdo->beginTransaction();

    // 1️⃣ Fetch old report and bns_report
    $stmt = $pdo->prepare("SELECT * FROM reports WHERE id = :id");
    $stmt->execute(['id' => $reportId]);
    $oldReport = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$oldReport) throw new Exception("Report not found");

    $stmt = $pdo->prepare("SELECT * FROM bns_reports WHERE report_id = :report_id");
    $stmt->execute(['report_id' => $reportId]);
    $oldBns = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$oldBns) throw new Exception("BNS data not found");

    // 2️⃣ Create new pending report
    $stmt = $pdo->prepare("
        INSERT INTO reports (user_id, report_time, report_date, status) 
        VALUES (:user_id, :report_time, :report_date, 'Pending')
    ");
    $stmt->execute([
        'user_id' => $userId,
        'report_time' => date('H:i:s'),
        'report_date' => date('Y-m-d')
    ]);
    $newReportId = $pdo->lastInsertId();

    // 3️⃣ Prepare new BNS data
    $bnsFields = $oldBns;

    // Overwrite with submitted values
    foreach ($_POST as $key => $value) {
        if ($key !== 'report_id' && $key !== 'title_display') {
            $bnsFields[$key] = $value;
        }
    }

    // Force correct values
    $bnsFields['report_id'] = $newReportId;
    $bnsFields['title'] = $_POST['title'] ?? ($oldBns['title'] ?? '');

    // Remove auto fields
    unset($bnsFields['id']);

    // ✅ Build SQL dynamically with correct placeholders
    $columns = array_keys($bnsFields);
    $placeholders = array_map(fn($c) => ':' . $c, $columns);
    $sql = "INSERT INTO bns_reports (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";

    // Ensure array keys have `:` prefix
    $params = [];
    foreach ($bnsFields as $col => $val) {
        $params[":" . $col] = $val;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // 🔔 Set prev_status = NULL so CNO receives notification
    $stmt = $pdo->prepare("UPDATE reports SET prev_status = NULL WHERE id = :id");
    $stmt->execute(['id' => $newReportId]);

    $pdo->commit();

    // ✅ Log activity
    logActivity(
        $pdo,
        $userId,
        "Updated report (cloned as Pending)",
        "Old Report ID: $reportId → New Report ID: $newReportId"
    );

    header("Location: report_history.php?id=$newReportId&msg=Report updated as Pending");
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
