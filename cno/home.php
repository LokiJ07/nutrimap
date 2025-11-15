<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../db/config.php';

// ✅ Only CNO
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}
$userId = $_SESSION['user_id'];

// ✅ User stats
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalAdmins = $pdo->query("SELECT COUNT(*) FROM users WHERE user_type='CNO'")->fetchColumn();
$totalBNS = $pdo->query("SELECT COUNT(*) FROM users WHERE user_type='BNS'")->fetchColumn();

// ✅ Report stats
$totalReports = $pdo->query("SELECT COUNT(*) FROM reports")->fetchColumn();
$approvedReports = $pdo->query("SELECT COUNT(*) FROM reports WHERE status='Approved'")->fetchColumn();
$pendingReports = $pdo->query("SELECT COUNT(*) FROM reports WHERE status='Pending'")->fetchColumn();
$rejectedReports = $pdo->query("SELECT COUNT(*) FROM reports WHERE status='Rejected'")->fetchColumn();

// ✅ Barangay stats
$totalBarangaysStmt = $pdo->query("SELECT COUNT(DISTINCT barangay) FROM users WHERE barangay NOT IN ('CNO') AND barangay != ''");
$totalBarangays = $totalBarangaysStmt->fetchColumn();

// ✅ Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$totalRows = $pdo->query("SELECT COUNT(*) FROM reports WHERE status='Pending'")->fetchColumn();
$totalPages = ceil($totalRows / $limit);

// ✅ Reports for main table (Only Pending Reports)
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
    WHERE r.status = 'Pending'
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
<title>CNO | Dashboard</title>
<link rel="icon" type="image/png" href="../img/CNO_Logo.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  body {
  font-family: Arial, Helvetica, sans-serif;
  background: #f5f5f5;
  margin: 0;
  padding: 0;
  height: 100vh;
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
  overflow: hidden; /* main container does not scroll */
}

/* Sidebar */
.sidebar {
  width: 230px;
  background: #f9f9f9;
  border-right: 1px solid #ccc;
  padding: 15px;
  display: flex;
  flex-direction: column;
  overflow-y: auto; /* scroll if content overflows */
  height: 100%; /* fill available space */
}
.sidebar h3 { font-size:16px; margin-bottom:10px; color:#009688; font-weight:600; }
.sidebar input { width: 210px; padding:8px; margin-bottom:10px; border:1px solid #ccc; border-radius:4px; }
.sidebar ul { list-style:none; padding:0; margin:0; } 
.sidebar li { padding:6px 0; cursor:pointer; color:#333; }
.sidebar li:hover { color:#009688; }
.sidebar .showmore { font-size:14px; color:#009688; cursor:pointer; text-decoration:underline; border:none; background:none; padding:5px 0; }

/* Cards Section */
.dashboard-cards {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 15px;
}
.card {
  flex: 1 1 250px;
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 20px;
  border-radius: 8px;
  color: #fff;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.card .icon { font-size: 30px; cursor: pointer; }
.card-users { background: #064e3b; }
.card-reports { background: #0c4a6e; }
.card-barangays { background: #115e59; }
.card-barangays button, .card-users button { margin-top: 0px; background: #fff; color: #115e59; border: none; padding:6px 10px; border-radius:4px; cursor:pointer; }

/* Main Content */
.content {
  flex: 1;
  padding: 10px;
  display: flex;
  flex-direction: column;
  overflow: hidden; /* prevent main scroll */
}

/* Table Section */
.table-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 15px;
  background: #ffffff;
  border-radius: 8px 8px 0 0;
  font-size: 16px;
  font-weight: bold;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.table-header a {
  text-decoration: none;
  font-size: 14px;
  color: #000f96ff;
  font-weight: normal;
}

.table-header a:hover {
  text-decoration: underline;
}

.table-container {
  flex: 1;
  background: #fff;
  border-radius: 8px;
  padding: 10px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}
.table-container h3 {
  margin: 0 0 10px 0;
  font-size: 16px;
  color: #009688;
}
.table-container a {
  float: right;
  text-decoration: none;
  color: blue;
  margin-bottom: 5px;
}
.table-wrapper {
  flex: 1;
  overflow-y: auto; /* table scrolls if too long */
}
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}
th, td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}
thead { background: #009688; color: #fff; }
.status-badge { padding: 2px 8px; border-radius: 12px; color: #fff; font-size: 12px; }
.status-Pending { background: #00bcd4; }
.status-Approved { background: #4caf50; }
.status-Rejected { background: #f44336; }
.user-avatar { width:28px; height:28px; border-radius:50%; margin-right:6px; vertical-align:middle; object-fit:cover; }

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

/* Pagination */
.pagination {
  margin-top:12px;
  margin-bottom:5px;
  display:flex;
  justify-content:center;
  gap:6px;
}
.pagination span { padding:6px 10px; color:#888; }
.pagination a {
  padding:6px 12px;
  border:1px solid #ccc;
  border-radius:4px;
  text-decoration:none;
  color:#333;
}
.pagination a.active { background:#009688; color:#fff; }
.pagination a.disabled { pointer-events:none; opacity:0.5; }
</style>
</head>
<body>
<div class="layout">
  <?php include 'header.php'; ?>

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
        <div class="card card-users">
          <div onclick="window.location.href='users.php'" style="cursor:pointer; font-size:32px; color: #06adb3ff;">
            <i class="fa fa-users"></i>
          </div>
          <div>
            <h3>Total Users: <?= $totalUsers ?></h3>
            <p>CNO: <?= $totalAdmins ?> | BNS: <?= $totalBNS ?></p>
          </div>
        </div>

        <div class="card card-reports">
          <div onclick="window.location.href='cno_reports.php'" style="cursor:pointer; font-size:32px; color:#e0e0e0ff;">
            <i class="fa fa-file-alt"></i>
          </div>
          <div>
            <h3>Total Reports: <?= $totalReports ?></h3>
            <p>Approved: <?= $approvedReports ?> | Pending: <?= $pendingReports ?> | Rejected: <?= $rejectedReports ?></p>
          </div>
        </div>

        <div class="card card-barangays">
          <div onclick="window.location.href='nutritional_map.php'" style="cursor:pointer; font-size:32px; color:#071d10ff;">
            <i class="fa fa-map-marker-alt"></i>
          </div>
          <div>
            <h3>Total Barangays: <?= $totalBarangays ?></h3>
          </div>
        </div>
      </div>

      <!-- ✅ Reports Table (Pending Only) -->
      <div class="table-container">
        <div class="table-header">
          <span>All Pending Reports</span>
          <a href="cno_reports.php">View All</a>
        </div>
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
          <?php if($allReports): ?>
            <?php foreach($allReports as $r): ?>
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
            <tr><td colspan="7" style="text-align:center;color:#888;">No pending reports</td></tr>
          <?php endif; ?>
          </tbody>
        </table>

        <!-- ✅ Pagination -->
       <div class="pagination">
<?php
  $maxLinks = 5;
  $start = max(1, $page - floor($maxLinks / 2));
  $end = min($totalPages, $start + $maxLinks - 1);
  if ($end - $start < $maxLinks - 1) { $start = max(1, $end - $maxLinks + 1); }
?>
<?php if ($page > 1): ?><a href="?page=<?= $page-1 ?>">Prev</a><?php else: ?><a class="disabled">Prev</a><?php endif; ?>
<?php if ($start > 1): ?><a href="?page=1">1</a><?php if ($start > 2): ?><span>...</span><?php endif; ?><?php endif; ?>
<?php for ($i=$start;$i<=$end;$i++): ?>
<a href="?page=<?= $i ?>" class="<?= $i==$page?'active':'' ?>"><?= $i ?></a>
<?php endfor; ?>
<?php if ($end<$totalPages): ?><?php if ($end<$totalPages-1): ?><span>...</span><?php endif; ?><a href="?page=<?= $totalPages ?>"><?= $totalPages ?></a><?php endif; ?>
<?php if ($page<$totalPages): ?><a href="?page=<?= $page+1 ?>">Next</a><?php else: ?><a class="disabled">Next</a><?php endif; ?>
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
