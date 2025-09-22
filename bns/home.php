<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../db/config.php';

// ✅ Only allow BNS
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}
$userId = $_SESSION['user_id'];

// ✅ Total reports
$totalStmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = ?
");
$totalStmt->execute([$userId]);
$totalReports = $totalStmt->fetchColumn();

// ✅ Approved reports
$approvedStmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = ? AND r.status = 'Approved'
");
$approvedStmt->execute([$userId]);
$approvedReports = $approvedStmt->fetchColumn();

// ✅ Pending reports
$pendingStmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = ? AND r.status = 'Pending'
");
$pendingStmt->execute([$userId]);
$pendingReports = $pendingStmt->fetchColumn();

// ✅ Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$totalRowsStmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE user_id = ?");
$totalRowsStmt->execute([$userId]);
$totalRows = $totalRowsStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);

// ✅ Reports for main table
$stmt = $pdo->prepare("
    SELECT 
        r.id,
        b.title,
        b.barangay,
        r.status,
        r.report_time,
        r.report_date
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = :userId
    ORDER BY r.report_date DESC, r.report_time DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$myReports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BNS Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {font-family:Arial,Helvetica,sans-serif;background:#f5f5f5;}
.layout {display:flex;height:100vh;flex-direction:column;}
.body-layout {display:flex;flex:1;}
.sidebar {
    width:230px;background:#f9f9f9;border-right:1px solid #ccc;padding:15px;display:flex;flex-direction:column;
}
.myreports-header {font-weight:bold;margin-bottom:10px;}
.searchbox {margin-bottom:10px;}
.searchbox input {width:100%;box-sizing:border-box;padding:6px 10px;font-size:14px;border:1px solid #ccc;border-radius:4px;}
.content {flex:1;padding:10px;overflow-y:auto;}

/* Cards */
.dashboard-cards {display:flex;gap:20px;margin-bottom:10px;}
.card {
    flex:1;display:flex;align-items:center;gap:15px;
    padding:20px;border-radius:8px;color:#fff;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}
.card .icon {font-size:30px;}
.card-total {background:#003d3c;}
.card-approved {background:#006d6a;}
.card-pending {background:#009688;}

/* Table */
.table-container {background:#fff;padding:3px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.1);}
table {width:100%;border-collapse:collapse;font-size:14px;}
th,td {padding:10px;text-align:left;border-bottom:1px solid #ddd;}
thead {background:#009688;color:#fff;}
.status-badge {padding:2px 8px;border-radius:12px;color:#fff;font-size:12px;}
.status-Pending {background:#00bcd4;}
.status-Approved {background:#4caf50;}
.status-Rejected {background:#f44336;}
.btn {padding:4px 8px;border:none;border-radius:4px;font-size:12px;cursor:pointer;color:#fff;text-decoration:none;}
.btn-view {background:#3498db;}
.pagination {margin-top:15px;display:flex;justify-content:center;gap:5px;}
.pagination a {padding:6px 12px;border:1px solid #ccc;border-radius:4px;text-decoration:none;color:#333;}
.pagination a.active {background:#009688;color:#fff;}
</style>
</head>
<body>
<div class="layout">
  <?php include 'header.php'; ?>
  <?php include 'sidemenu.php'; ?>
  <div class="body-layout">
    <!-- ✅ Sidebar -->
    <aside class="sidebar">
      <div class="myreports-header">Search My Reports</div>
      <div class="searchbox">
        <input type="text" id="sidebarSearch" placeholder="Search my reports...">
      </div>
    </aside>

    <!-- ✅ Main Content -->
    <main class="content">
      <h2>Dashboard</h2>
      <div class="dashboard-cards">
        <div class="card card-total">
          <div class="icon"><i class="fa fa-file-alt"></i></div>
          <div>
            <h3>Total Reports: <?= $totalReports ?></h3>
          </div>
        </div>
        <div class="card card-approved">
          <div class="icon"><i class="fa fa-check-circle"></i></div>
          <div>
            <h3>Approved: <?= $approvedReports ?></h3>
          </div>
        </div>
        <div class="card card-pending">
          <div class="icon"><i class="fa fa-clock"></i></div>
          <div>
            <h3>Pending: <?= $pendingReports ?></h3>
          </div>
        </div>
      </div>

      <!-- ✅ Reports Table -->
      <div class="table-container">
        <h3>My Reports</h3>
        <table id="reportsTable">
          <thead>
            <tr>
              <th>Title</th>
              <th>Barangay</th>
              <th>Status</th>
              <th>Time</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php if ($myReports): ?>
            <?php foreach ($myReports as $r): ?>
            <tr>
              <td><?= htmlspecialchars($r['title']) ?></td>
              <td><?= htmlspecialchars($r['barangay']) ?></td>
              <td><span class="status-badge status-<?= $r['status'] ?>"><?= $r['status'] ?></span></td>
              <td><?= htmlspecialchars($r['report_time']) ?></td>
              <td><?= htmlspecialchars($r['report_date']) ?></td>
              <td><a class="btn btn-view" href="view_report.php?id=<?= $r['id'] ?>">View</a></td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="6" style="text-align:center;color:#888;">No reports found</td></tr>
          <?php endif; ?>
          </tbody>
        </table>

        <!-- ✅ Pagination -->
        <div class="pagination">
          <?php if ($page > 1): ?>
            <a href="?page=<?= $page-1 ?>">Prev</a>
          <?php endif; ?>
          <?php for ($i=1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
          <?php endfor; ?>
          <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page+1 ?>">Next</a>
          <?php endif; ?>
        </div>
      </div>
    </main>
  </div>
</div>

<script>
// ✅ Sidebar search filters the table
document.getElementById("sidebarSearch").addEventListener("keyup", function() {
  let filter = this.value.toLowerCase();
  let rows = document.querySelectorAll("#reportsTable tbody tr");
  rows.forEach(row => {
    let text = row.textContent.toLowerCase();
    row.style.display = text.includes(filter) ? "" : "none";
  });
});
</script>
</body>
</html>
