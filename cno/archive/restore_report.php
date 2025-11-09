<?php
session_start();
require '../../db/config.php';

// ✅ Activity log function
function logActivity($pdo, $user_id, $action) {
    $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action) VALUES (?, ?)");
    $stmt->execute([$user_id, $action]);
}

// ✅ Require login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type']; // 'BNS' or 'CNO'
$reportId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($reportId <= 0) {
    die("Invalid request");
}

// 🔹 Check if archive record exists for this user
$check = $pdo->prepare("
    SELECT * FROM report_archives
    WHERE report_id = :rid AND user_id = :uid AND user_type = :utype
");
$check->execute([
    'rid' => $reportId,
    'uid' => $user_id,
    'utype' => $user_type
]);
$archive = $check->fetch();

if ($archive) {
    // 🔹 Restore the report for this user only
    $update = $pdo->prepare("
        UPDATE report_archives
        SET is_archived = 0,
            is_deleted = 0,
            archived_at = NULL,
            deleted_at = NULL
        WHERE report_id = :rid AND user_id = :uid AND user_type = :utype
    ");
    $update->execute([
        'rid' => $reportId,
        'uid' => $user_id,
        'utype' => $user_type
    ]);

    // 🔹 Restore report status to its previous state
    $getPrevStatus = $pdo->prepare("SELECT prev_status FROM reports WHERE id = :rid");
    $getPrevStatus->execute([':rid' => $reportId]);
    $prevStatus = $getPrevStatus->fetchColumn();

    if ($prevStatus) {
        $restoreReport = $pdo->prepare("
            UPDATE reports 
            SET status = :prev_status, prev_status = NULL
            WHERE id = :rid
        ");
        $restoreReport->execute([
            ':prev_status' => $prevStatus,
            ':rid' => $reportId
        ]);
    }
} else {
    // 🔹 If no record yet, create one marked as active (not archived)
    $insert = $pdo->prepare("
        INSERT INTO report_archives (report_id, user_id, user_type, is_archived, is_deleted)
        VALUES (:rid, :uid, :utype, 0, 0)
    ");
    $insert->execute([
        'rid' => $reportId,
        'uid' => $user_id,
        'utype' => $user_type
    ]);
}

// ✅ Log the restore activity
logActivity($pdo, $user_id, "Restored report (ID: $reportId) from archive");

// 🔹 Redirect back to reports page instead of archive
header("Location: ../archive.php?msg=restored");
exit();
?>
