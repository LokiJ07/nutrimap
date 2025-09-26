<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../db/config.php';

// ✅ Only CNO
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

// ✅ User stats
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalAdmins = $pdo->query("SELECT COUNT(*) FROM users WHERE user_type='CNO'")->fetchColumn();
$totalBNS = $pdo->query("SELECT COUNT(*) FROM users WHERE user_type='BNS'")->fetchColumn();

// ✅ Report stats
$totalReports = $pdo->query("SELECT COUNT(*) FROM reports")->fetchColumn();
$approvedReports = $pdo->query("SELECT COUNT(*) FROM reports WHERE status='Approved'")->fetchColumn();
$pendingReports = $pdo->query("SELECT COUNT(*) FROM reports WHERE status='Pending'")->fetchColumn();

// ✅ Barangay stats
$totalBarangaysStmt = $pdo->query("SELECT COUNT(DISTINCT barangay) FROM users WHERE barangay NOT IN ('CNO') AND barangay != ''");
$totalBarangays = $totalBarangaysStmt->fetchColumn();

// ✅ Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$totalRows = $pdo->query("SELECT COUNT(*) FROM reports")->fetchColumn();
$totalPages = ceil($totalRows / $limit);

// ✅ Reports for main table
$stmt = $pdo->prepare("
    SELECT 
        r.id,
        CONCAT(u.first_name, ' ', u.last_name) AS full_name,
        u.profile_pic,
        b.title,
        u.barangay,
        r.status,
        r.report_time,
        r.report_date
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    JOIN users u ON r.user_id = u.id
    ORDER BY r.report_date DESC, r.report_time DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$allReports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CNO Dashboard</title>
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
.card-users {background:#064e3b;}
.card-reports {background:#0c4a6e;}
.card-barangays {background:#115e59;}
.card-barangays button {
    margin-top:8px;background:#fff;color:#115e59;
    border:none;padding:6px 10px;border-radius:4px;cursor:pointer;
}

/* Table */
.table-container {background:#fff;padding:3px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.1);}
table {width:100%;border-collapse:collapse;font-size:14px;}
th,td {padding:10px;text-align:left;border-bottom:1px solid #ddd;}
thead {background:#009688;color:#fff;}
.status-badge {padding:2px 8px;border-radius:12px;color:#fff;font-size:12px;}
.status-Pending {background:#00bcd4;}
.status-Approved {background:#4caf50;}
.status-Rejected {background:#f44336;}
.user-avatar {width:28px;height:28px;border-radius:50%;margin-right:6px;vertical-align:middle;object-fit:cover;}
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
  <?php include 'sidebar.php'; ?>
  <div class="body-layout">
    <!-- ✅ Sidebar -->
    <aside class="sidebar">
      <div class="myreports-header">Search Reports</div>
      <div class="searchbox">
        <input type="text" id="sidebarSearch" placeholder="Search all reports...">
      </div>
    </aside>

    <!-- ✅ Main Content -->
    <main class="content">
      <h2>Dashboard</h2>
      <div class="dashboard-cards">
        <div class="card card-users">
          <div class="icon"><i class="fa fa-users"></i></div>
          <div>
            <h3>Total Users: <?= $totalUsers ?></h3>
            <p>CNO: <?= $totalAdmins ?> | BNS: <?= $totalBNS ?></p>
          </div>
        </div>
        <div class="card card-reports">
          <div class="icon"><i class="fa fa-file-alt"></i></div>
          <div>
            <h3>Total Reports: <?= $totalReports ?></h3>
            <p>Approved: <?= $approvedReports ?> | Pending: <?= $pendingReports ?></p>
          </div>
        </div>
        <div class="card card-barangays">
          <div class="icon"><i class="fa fa-map-marker-alt"></i></div>
          <div>
            <h3>Total Barangays: <?= $totalBarangays ?></h3>
            <button onclick="window.location.href='nutritional_map.php'">View Map</button>
          </div>
        </div>
      </div>

      <!-- ✅ Reports Table -->
      <div class="table-container">
        <h3>All Reports</h3>
        <table id="reportsTable">
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
          <?php if ($allReports): ?>
            <?php foreach ($allReports as $r): ?>
            <tr>
              <td>
                <?php if (!empty($r['profile_pic']) && file_exists("../uploads/".$r['profile_pic'])): ?>
                  <img src="../uploads/<?= htmlspecialchars($r['profile_pic']) ?>" class="user-avatar" alt="Profile">
                <?php else: ?>
                  <img src="../uploads/default.png" class="user-avatar" alt="Default">
                <?php endif; ?>
                <?= htmlspecialchars($r['full_name']) ?>
              </td>
              <td><?= htmlspecialchars($r['title']) ?></td>
              <td><?= htmlspecialchars($r['barangay']) ?></td>
              <td><span class="status-badge status-<?= $r['status'] ?>"><?= $r['status'] ?></span></td>
              <td><?= htmlspecialchars($r['report_time']) ?></td>
              <td><?= htmlspecialchars($r['report_date']) ?></td>
              <td><a class="btn btn-view" href="view_report.php?id=<?= $r['id'] ?>">View</a></td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="7" style="text-align:center;color:#888;">No reports found</td></tr>
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
