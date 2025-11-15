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
$currentSession = session_id();

// 🔹 Check if current session is still valid in login_history
$stmt = $pdo->prepare("SELECT id FROM login_history WHERE user_id = ? AND session_id = ?");
$stmt->execute([$userId, $currentSession]);
$sessionExists = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sessionExists) {
    // ❌ Session no longer valid → force logout
    session_unset();
    session_destroy();
    header("Location: ../login.php?message=Session expired or logged in elsewhere");
    exit();
}

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

// ✅ Rejected reports
$rejectedStmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = ? AND r.status = 'Rejected'
");
$rejectedStmt->execute([$userId]);
$rejectedReports = $rejectedStmt->fetchColumn();

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
    SELECT r.id, u.profile_pic, u.username, b.title, r.status, r.report_time, r.report_date
    FROM reports r
    JOIN users u ON r.user_id = u.id
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = :userId AND r.status = 'Pending'
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
<title>BNS | Dashboard</title>
<link rel="icon" type="image/png" href="../img/CNO_Logo.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  background: #f5f5f5;
  margin: 0;
  padding: 0;
  overflow: hidden; /* ❌ Prevent body scroll */
}

/* Overall Layout */
.layout {
  display: flex;
  flex-direction: column;
  height: 100vh;
}

.body-layout {
  display: flex;
  flex: 1;
  overflow: hidden; /* ✅ Prevent internal scroll */
}

/* Sidebar */
.sidebar {
    width:230px;background:#f9f9f9;border-right:1px solid #ccc;padding:15px;display:flex;flex-direction:column;
    height:100px; /* Fix height */
}
.sidebar h3 { font-size:16px; margin-bottom:10px; color:#009688; font-weight:600; }
.sidebar input { width:210px; padding:8px; margin-bottom:10px; border:1px solid #ccc; border-radius:4px; }
.sidebar ul { list-style:none; padding:0; margin:0;}
.sidebar li { padding:6px 0; cursor:pointer; color:#333; }
.sidebar li:hover { color:#009688; }
.sidebar .showmore { font-size:14px; color:#009688; cursor:pointer; text-decoration:underline; border:none; background:none; padding:5px 0; }

/* Main content */
.content {
  flex: 1;
  display: flex;
  flex-direction: column;
  padding: 15px;
  overflow: hidden; /* ✅ Prevent main scroll */
}

/* Cards Section */
.dashboard-cards {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 15px;
}
.card {
  flex: 1 1 200px;
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 20px;
  border-radius: 8px;
  color: #fff;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.card .icon {
  font-size: 30px;
}
.card-total { background: #003d3c; }
.card-approved { background: #006d6a; }
.card-pending { background: #009688; }
.card-rejected { background: #f44336; }

/* Table Section */
.table-container {
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  flex: 1;
  overflow: hidden; /* ✅ Keeps clean edge */
}
.table-container h3 {
  padding: 10px 15px;
  background: #009688;
  color: #fff;
  border-radius: 8px 8px 0 0;
  margin: 0;
  font-size: 16px;
}
.table-wrapper {
  flex: 1;
  overflow-y: auto; /* ✅ Only the table scrolls if too long */
}
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}
th, td {
  padding: 6px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}
thead {
  background: #009688;
  color: #fff;
}
.status-badge {
  padding: 2px 8px;
  border-radius: 12px;
  color: #fff;
  font-size: 12px;
}
.status-Pending { background: #00bcd4; }
.status-Approved { background: #4caf50; }
.status-Rejected { background: #f44336; }

.btn {
  padding: 4px 8px;
  border: none;
  border-radius: 4px;
  font-size: 12px;
  cursor: pointer;
  color: #fff;
  text-decoration: none;
}
.btn-view { background: #3498db; }

.pagination {
  padding: 10px;
  display: flex;
  justify-content: center;
  gap: 5px;
  border-top: 1px solid #eee;
  background: #fafafa;
}
.pagination a {
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  text-decoration: none;
  color: #333;
}
.pagination a.active {
  background: #009688;
  color: #fff;
}

.user-avatar {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  margin-right: 6px;
  vertical-align: middle;
  object-fit: cover;
}

</style>
</head>
<body>
<div class="layout">
  <?php include 'header.php'; ?>
  <?php include 'sidemenu.php'; ?>
  <div class="body-layout">
    <!-- ✅ Sidebar -->
    <aside class="sidebar">
      <h3>Approved Reports</h3>
      <input type="text" placeholder="Search..." id="sidebarSearch">

      <ul id="sidebarList">
        <?php
      $approvedReportsListStmt = $pdo->prepare("
    SELECT r.id, b.title, u.username
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    JOIN users u ON r.user_id = u.id
    WHERE r.status = 'Approved'
    ORDER BY r.report_date DESC, r.report_time DESC
    LIMIT 5
");
        $approvedReportsListStmt->execute();
        $approvedReportsList = $approvedReportsListStmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($approvedReportsList)):
          foreach($approvedReportsList as $a): ?>
            <li onclick="window.location.href='view_report.php?id=<?= $a['id'] ?>'">
              <?= htmlspecialchars($a['username']) ?>
              ---
              <?= htmlspecialchars($a['title']) ?>
            </li>
          <?php endforeach;
        else: ?>
          <li style="color:#999;">No approved reports</li>
        <?php endif; ?>
      </ul>

      <button class="showmore" onclick="window.location.href='report_history.php'">Show more</button>
    </aside>

    <!-- ✅ Main Content -->
    <main class="content">
      <h2>Dashboard</h2>
<div class="dashboard-cards">
  <div class="card card-total">
    <div class="icon"><i class="fa fa-file-alt"></i></div>
    <div><h3>Total Reports: <?= $totalReports ?></h3></div>
  </div>

  <div class="card card-approved">
    <div class="icon"><i class="fa fa-check-circle"></i></div>
    <div><h3>Approved: <?= $approvedReports ?></h3></div>
  </div>

  <div class="card card-pending">
    <div class="icon"><i class="fa fa-clock"></i></div>
    <div><h3>Pending: <?= $pendingReports ?></h3></div>
  </div>

  <!-- ✅ NEW Rejected Card -->
  <div class="card card-rejected">
    <div class="icon"><i class="fa fa-times-circle"></i></div>
    <div><h3>Rejected: <?= $rejectedReports ?></h3></div>
  </div>
</div>


      <!-- ✅ Reports Table -->
      <div class="table-container">
        <div style="display: flex; justify-content: space-between; align-items: center;  padding: 10px 5px; background: white; color: #000000ff; border-radius: 8px 8px 0 0; font-size: large;">
  <span style="font-weight: bold;">My Approved Reports</span>
  <a href="reports.php" style="color: #000f96ff; text-decoration: none; font-size: 14px;">View All</a>
</div>

           <div class="table-wrapper">
        <table id="reportsTable">
          <thead>
            <tr>
              <th>User</th>
              <th>Title</th>
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
              <td>
              <?php if (!empty($r['profile_pic']) && file_exists("../uploads/".$r['profile_pic'])): ?>
                  <img src="../uploads/<?= htmlspecialchars($r['profile_pic']) ?>" class="user-avatar" alt="Profile">
                <?php else: ?>
                  <img src="../uploads/default.png" class="user-avatar" alt="Default">
                <?php endif; ?>  
              <?= htmlspecialchars($r['username']) ?></td>
              <td><?= htmlspecialchars($r['title']) ?></td>
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
      </div>
    </main>
  </div>
</div>

<script>
// ✅ Sidebar search filters approved reports in sidebar
document.getElementById("sidebarSearch").addEventListener("keyup", function() {
  const filter = this.value.toLowerCase();
  const items = document.querySelectorAll("#sidebarList li");
  items.forEach(item => {
    const text = item.textContent.toLowerCase();
    item.style.display = text.includes(filter) || filter === "" ? "" : "none";
  });
});
</script>
</body>
</html>
