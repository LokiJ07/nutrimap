<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../db/config.php';

// Only CNO
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

// Fetch all reports for stats
$totalReportsStmt = $pdo->prepare("SELECT COUNT(*) FROM reports");
$totalReportsStmt->execute();
$totalReports = $totalReportsStmt->fetchColumn();

$approvedReportsStmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE status = 'Approved'");
$approvedReportsStmt->execute();
$approvedReports = $approvedReportsStmt->fetchColumn();

$pendingReportsStmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE status = 'Pending'");
$pendingReportsStmt->execute();
$pendingReportsCount = $pendingReportsStmt->fetchColumn();

// Fetch pending reports
$pendingListStmt = $pdo->prepare("
    SELECT 
        r.id,
        CONCAT(u.first_name, ' ', u.last_name) AS full_name,
        u.profile_pic,  -- optional if you have user images
        b.title,
        u.barangay,
        r.status,
        r.report_time,
        r.report_date
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    JOIN users u ON r.user_id = u.id
    WHERE r.status = 'Pending'
    ORDER BY r.report_date DESC, r.report_time DESC
    LIMIT 6
");
$pendingListStmt->execute();
$pendingReportsList = $pendingListStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CNO Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{font-family:Arial,Helvetica,sans-serif;margin:0;background:#f5f5f5;}
.container{max-width:1200px;margin:20px auto;padding:20px;}
.cards{display:flex;gap:15px;margin-bottom:20px;}
.card{flex:1;background:#009688;color:#fff;padding:20px;border-radius:4px;box-shadow:0 2px 6px rgba(0,0,0,0.1);}
.card h3{margin:0;font-size:18px;}
.card p{margin:10px 0 0;font-size:24px;font-weight:bold;}
  .card.total { background:#003d3c; }
  .card.approved { background:#006d6a; }
  .card.pending { background:#009688; }
.table-container{background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.1);}
table{width:100%;border-collapse:collapse;font-size:14px;}
th,td{padding:10px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#f1f1f1;}
.status-badge{padding:2px 8px;border-radius:12px;color:#fff;font-size:12px;}
.status-Pending{background:#00bcd4;}
.status-Approved{background:#4caf50;}
.status-Rejected{background:#f44336;}
.action-buttons form{display:inline;}
.btn{padding:4px 8px;border:none;border-radius:4px;font-size:12px;cursor:pointer;color:#fff;margin-right:4px;}
.btn-view{background:#3498db;}
.btn-approve{background:#2ecc71;}
.btn-reject{background:#dc3545;}
.user-avatar{width:28px;height:28px;border-radius:50%;margin-right:6px;vertical-align:middle;}
</style>
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="container">

<!-- Dashboard Cards -->
<div class="cards">
    <div class="card total">
        <h3>Total Reports</h3>
        <p><?= $totalReports ?></p>
    </div>
    <div class="card approved">
        <h3>Approved</h3>
        <p><?= $approvedReports ?></p>
    </div>
    <div class="card pending">
        <h3>Pending</h3>
        <p><?= $pendingReportsCount ?></p>
    </div>
</div>

<!-- Pending Reports Table -->
<div class="table-container">
    <h2>Pending Reports</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Title</th>
                <th>Barangay</th>
                <th>Status</th>
                <th>Time</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($pendingReportsList): ?>
            <?php foreach ($pendingReportsList as $report): ?>
            <tr>
                <td>
                    <?php if (!empty($report['profile_pic'])): ?>
                        <img src="<?= $report['profile_pic'] ?>" class="user-avatar" alt="Profile Picture">
                    <?php endif; ?>
                    <?= htmlspecialchars($report['full_name']) ?>
                </td>
                <td><?= htmlspecialchars($report['title']) ?></td>
                <td><?= htmlspecialchars($report['barangay']) ?></td>
                <td><span class="status-badge status-<?= $report['status'] ?>"><?= $report['status'] ?></span></td>
                <td><?= htmlspecialchars($report['report_time']) ?></td>
                <td><?= htmlspecialchars($report['report_date']) ?></td>
                <td class="action-buttons">
                    <a class="btn btn-view" href="view_report.php?id=<?= $report['id'] ?>">View</a>
                    <form action="update_status.php" method="post" style="display:inline;">
                        <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                        <button type="submit" name="approve" class="btn btn-approve">Approve</button>
                    </form>
                    <form action="update_status.php" method="post" style="display:inline;">
                        <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                        <button type="submit" name="reject" class="btn btn-reject">Reject</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" style="text-align:center;color:#888;">No pending reports</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</div>
</body>
</html>
