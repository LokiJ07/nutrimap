<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../db/config.php';

// Only allow CNO
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

// Fetch all pending reports
$stmt = $pdo->prepare("
    SELECT 
        r.id,
        b.title,
        u.first_name,
        u.last_name,
        u.barangay,
        r.status,
        r.report_time,
        r.report_date
    FROM reports r
    JOIN bns_reports b ON b.report_id = r.id
    JOIN users u ON r.user_id = u.id
    WHERE r.status = 'Pending'
    ORDER BY r.report_date DESC, r.report_time DESC
");
$stmt->execute();
$pendingReports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>CNO - Pending Reports</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{font-family:Arial,Helvetica,sans-serif;margin:0;background:#f5f5f5;}
.container{max-width:1200px;margin:20px auto;padding:20px;background:#fff;border-radius:6px;box-shadow:0 0 6px rgba(0,0,0,.1);}
h1{margin-top:0}
table{width:100%;border-collapse:collapse;margin-top:20px;font-size:14px;}
th,td{padding:10px;border-bottom:1px solid #ddd;text-align:left;}
.action-buttons form{display:inline;}
.btn{padding:5px 10px;border:none;border-radius:4px;cursor:pointer;font-size:13px;}
.btn-view{background:#3498db;color:#fff;}
.btn-approve{background:#2ecc71;color:#fff;}
.btn-reject{background:#dc3545;color:#fff;}
.success-msg{background:#d4edda;color:#155724;padding:10px;border-radius:5px;margin-bottom:15px;}
</style>
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="container">

<?php if (!empty($_SESSION['success'])): ?>
  <div class="success-msg"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<h1>Pending Reports</h1>
<table>
  <thead>
    <tr>
      <th>Reporter</th>
      <th>Title</th>
      <th>Barangay</th>
      <th>Status</th>
      <th>Time</th>
      <th>Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <?php if ($pendingReports): ?>
    <?php foreach ($pendingReports as $report): ?>
      <tr>
        <td><?= htmlspecialchars($report['first_name'] . ' ' . $report['last_name']) ?></td>
        <td><?= htmlspecialchars($report['title']) ?></td>
        <td><?= htmlspecialchars($report['barangay']) ?></td>
        <td><?= htmlspecialchars($report['status']) ?></td>
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
</body>
</html>
