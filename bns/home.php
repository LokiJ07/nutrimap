<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../db/config.php'; // adjust path if needed

// ✅ Current user
  if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}
$userId = $_SESSION['user_id'];   // <— add this line
// ✅ Total reports
$totalStmt = $pdo->prepare("SELECT COUNT(*) 
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = ?");
$totalStmt->execute([$userId]);
$totalReports = $totalStmt->fetchColumn();

// ✅ Approved reports
$approvedStmt = $pdo->prepare("SELECT COUNT(*) 
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = ? AND r.status = 'Approved'");
$approvedStmt->execute([$userId]);
$approvedReports = $approvedStmt->fetchColumn();

// ✅ Pending reports
$pendingStmt = $pdo->prepare("SELECT COUNT(*) 
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = ? AND r.status = 'Pending'");
$pendingStmt->execute([$userId]);
$pendingReports = $pendingStmt->fetchColumn();

// ✅ Approved reports list (My Reports sidebar)
$approvedListStmt = $pdo->prepare("SELECT r.id, b.title 
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = ? AND r.status = 'Approved'
    ORDER BY r.report_date DESC
    LIMIT 5");
$approvedListStmt->execute([$userId]);
$approvedReportsList = $approvedListStmt->fetchAll();

// ✅ Pending reports list (main panel)
$pendingListStmt = $pdo->prepare("SELECT r.id, b.title, b.barangay, r.status, r.report_time, r.report_date
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.user_id = ? AND r.status = 'Pending'
    ORDER BY r.report_date DESC
    LIMIT 5");
$pendingListStmt->execute([$userId]);
$pendingReportsList = $pendingListStmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>CNO NutriMap — Dashboard</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
  body {
    margin:0;
    font-family: Arial, Helvetica, sans-serif;
    background:#f5f5f5;
  }
  .layout {
    display:flex;
    height:100vh;
    flex-direction:column;
  }
  .body-layout {
    display:flex;
    flex:1;
  }
  .sidebar {
    width:250px;
    background:#f9f9f9;
    border-right:1px solid #ccc;
    padding:15px;
    display:flex;
    flex-direction:column;
  }
  .myreports-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
    font-weight:bold;
  }
  .new-btn {
    background:#009688;
    color:white;
    border:none;
    padding:4px 10px;
    border-radius:4px;
    cursor:pointer;
    font-size:13px;
    display:flex;
    align-items:center;
  }
  .new-btn i { margin-right:5px; }
  .sidebar .searchbox {
    margin-bottom:20px;
  }
  .sidebar .searchbox input {
    width:91%;
    padding:6px 10px;
  }
  .showmore {
    margin-top:auto;
    font-size:14px;
    color:#333;
    cursor:pointer;
  }
  .content {
    flex:1;
    padding:15px;
    display:flex;
    flex-direction:column;
  }
  .content h2 {
    margin:0 0 15px 0;
    font-size:18px;
  }
  .cards {
    display:flex;
    gap:15px;
    margin-bottom:20px;
  }
  .card {
    flex:1;
    color:white;
    padding:15px;
    border-radius:4px;
    cursor:pointer;
  }
  .card .title { font-size:14px; }
  .card .number { font-size:20px; font-weight:bold; }
  .card.total { background:#003d3c; }
  .card.approved { background:#006d6a; }
  .card.pending { background:#009688; }
  .panel {
    background:white;
    border:1px solid #ccc;
    border-radius:4px;
    padding:15px;
    flex:1;
    display:flex;
    flex-direction:column;
  }
  .panel-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
  }
  .panel-header h3 { margin:0; font-size:16px; }
  .view-all {
    background:white;
    border:1px solid #999;
    padding:4px 10px;
    font-size:14px;
    border-radius:4px;
    cursor:pointer;
  }
  table {
    width:100%;
    border-collapse:collapse;
    font-size:14px;
  }
  th {
    text-align:left;
    padding:8px;
    font-weight:bold;
    border-bottom:1px solid #ccc;
  }
  tbody tr { height:35px; border-bottom:1px solid #eee; }
  tbody td { padding:8px; color:#555; }
  </style>
</head>
<body>
  <div class="layout">
    <?php include 'header.php'; ?>

    <div class="body-layout">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="myreports-header">
          <span>My reports</span>
          <button class="new-btn" id="newBtn"><i class="fa fa-plus"></i> New</button>
        </div>
        <div class="searchbox">
          <input type="text" placeholder="Find a report...">
        </div>
        <ul>
          <?php foreach ($approvedReportsList as $report): ?>
            <li><?= htmlspecialchars($report['title']) ?></li>
          <?php endforeach; ?>
        </ul>
        <div class="showmore" id="showMoreBtn" onclick="window.location.href='report_history.php'">Show more:</div>
      </aside>

      <!-- Main -->
      <main class="content">

      <?php if (isset($_SESSION['success'])): ?>
      <div id="successMessage" style="background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border-radius: 5px;">
          <?= $_SESSION['success']; unset($_SESSION['success']); ?>
      </div>

      <script>
        setTimeout(() => {
          const msg = document.getElementById('successMessage');
          if (msg) {
            msg.style.transition = 'opacity 1s';
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 1000);
          }
        }, 20000);
      </script>
      <?php endif; ?>

      <h2>Dashboard</h2>
      <div class="cards">
        <div class="card total" id="totalCard">
          <div class="title">Total Reports:</div>
          <div class="number"><?= $totalReports ?></div>
        </div>
        <div class="card approved" id="approvedCard">
          <div class="title">Approved:</div>
          <div class="number"><?= $approvedReports ?></div>
        </div>
        <div class="card pending" id="pendingCard">
          <div class="title">Pending:</div>
          <div class="number"><?= $pendingReports ?></div>
        </div>
      </div>

      <div class="panel">
        <div class="panel-header">
          <h3>Pending Reports</h3>
          <button class="view-all" id="viewAllBtn" onclick="window.location.href='reports.php'">View All</button>
        </div>
        <table>
          <thead>
            <tr>
              <th>Title</th>
              <th>Barangay</th>
              <th>Status</th>
              <th>Time</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pendingReportsList as $report): ?>
              <tr>
                <td><?= htmlspecialchars($report['title']) ?></td>
                <td><?= htmlspecialchars($report['barangay']) ?></td>
                <td><?= htmlspecialchars($report['status']) ?></td>
                <td><?= htmlspecialchars($report['report_time']) ?></td>
                <td><?= htmlspecialchars($report['report_date']) ?></td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($pendingReportsList)): ?>
              <tr><td colspan="5" style="text-align:center;color:#999;">No pending reports</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      </main>
    </div>
  </div>
</body>
</html>
