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

// --- Fetch all user reports ---
$stmt = $pdo->prepare("
    SELECT r.id, u.profile_pic, u.username, b.title, r.status, r.report_time, r.report_date
    FROM reports r
     JOIN users u ON r.user_id = u.id
    LEFT JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = ?
    ORDER BY r.report_date DESC, r.report_time DESC
");
$stmt->execute([$userId]);
$myReports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BNS Reports</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {font-family:Arial,Helvetica,sans-serif;background:#f5f5f5;margin:0;}
.user-avatar {width:28px;height:28px;border-radius:50%;margin-right:6px;vertical-align:middle;object-fit:cover;}
.layout {display:flex;flex-direction:column;height:100vh;}
.body-layout {display:flex;flex:1;}
.content {flex:1;padding:15px;overflow-y:auto;}
.toolbar {display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;}
.toolbar-left input {padding:6px 8px;border:1px solid #ccc;border-radius:4px;}
.toolbar-left select {padding:6px;border:1px solid #ccc;border-radius:4px;}
.report-header { display:flex; justify-content:space-between; align-items:center; padding:10px; background:#eee; border-bottom:1px solid #ccc; }
.report-header h3 { margin:0; }.add-btn {background:#009688;color:#fff;text-decoration:none;padding:8px 14px;border-radius:4px;font-size:14px;display:flex;align-items:center;gap:6px;}
.add-btn:hover {background:#00796b;}
.table-container {background:#fff;padding:10px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.1);}
table {width:100%;border-collapse:collapse;font-size:14px;}
th, td {padding:5px;text-align:left;border-bottom:1px solid #ddd;}
thead {background: #009688;color:#fff; cursor: pointer;}
.status-badge {padding:2px 8px;border-radius:12px;color:#fff;font-size:12px;}
.status-Pending {background:#00bcd4;}
.status-Approved {background:#4caf50;}
.status-Rejected {background:#f44336;}
.btn {padding:4px 8px;border:none;border-radius:4px;font-size:12px;cursor:pointer;color:#fff;text-decoration:none;}
.btn-view {background:#3498db;}
</style>
</head>
<body>
<div class="layout">
<?php include 'header.php'; ?>
<div class="body-layout">
<main class="content">
  <!-- ✅ Toolbar with live search & sort -->
  <div class="toolbar">
    <div class="toolbar-left">

      <input type="text" id="searchInput" placeholder="Search Reports...">
      <select id="sortSelect">
        <option value="new">New → Old</option>
        <option value="old">Old → New</option>
      </select>
    </div>
    <div class="toolbar-right">
      <a class="add-btn" href="add_report.php"><i class="fa fa-plus"></i> Add Report</a>
    </div>
  </div>
  <div class="report-header">
        <h3>Report</h3>
        <div class="pagination" id="pagination"></div>
    </div>
  <!-- ✅ Reports Table -->
  <div class="table-container">
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
  </div>

</main>
</div>
</div>

<!-- ✅ JS: Live Search + Sort -->
<script>
const searchInput = document.getElementById('searchInput');
const sortSelect = document.getElementById('sortSelect');
const tableBody = document.querySelector('#reportsTable tbody');
const rows = Array.from(tableBody.querySelectorAll('tr'));

function updateTable() {
    const filter = searchInput.value.toLowerCase();
    const sortOrder = sortSelect.value;

    // Filter rows
    let filteredRows = rows.filter(row => {
        return row.textContent.toLowerCase().includes(filter);
    });

    // Sort rows by date & time
    filteredRows.sort((a, b) => {
        const dateA = new Date(a.children[4].textContent + ' ' + a.children[3].textContent);
        const dateB = new Date(b.children[4].textContent + ' ' + b.children[3].textContent);
        return sortOrder === 'new' ? dateB - dateA : dateA - dateB;
    });

    // Clear table and re-append
    tableBody.innerHTML = '';
    filteredRows.forEach(row => tableBody.appendChild(row));
}

// Event listeners
searchInput.addEventListener('keyup', updateTable);
sortSelect.addEventListener('change', updateTable);
</script>
</body>
</html>
