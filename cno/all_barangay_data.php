<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../db/config.php';

// ✅ Only CNO
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

// ✅ Consolidated report (latest report per BNS, no duplicates)
$consolidatedStmt = $pdo->query("
    SELECT r.id, r.report_date
    FROM reports r
    WHERE r.id IN (
        SELECT MAX(r2.id)
        FROM reports r2
        GROUP BY r2.user_id
    )
    ORDER BY r.report_date DESC
    LIMIT 1
");
$consolidated = $consolidatedStmt->fetch(PDO::FETCH_ASSOC);

// ✅ Latest report per barangay
$barangayStmt = $pdo->query("
    SELECT MAX(r.id) AS report_id, b.barangay, MAX(r.report_date) AS latest_date
    FROM reports r
    JOIN bns_reports b ON r.id = b.report_id
    GROUP BY r.user_id, b.barangay
    ORDER BY b.barangay ASC
");
$barangayReports = $barangayStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CNO - Health and Nutrition Data</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:0;}
.container {max-width:10000px; margin:20px auto; background:#fff; padding:20px; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1);}
h1 {margin-top:0;}
.list-item {display:flex; justify-content:space-between; align-items:center; padding:12px 15px; border:1px solid #ddd; border-radius:4px; margin-bottom:10px; background:#fafafa;}
.list-item strong {font-size:15px;}
.actions {display:flex; align-items:center; gap:15px;}
.actions span {color:#555; font-size:13px;}
.actions a {color:#007bff; text-decoration:none; font-weight:bold;}
.actions a:hover {text-decoration:underline;}
.filters {display:flex; gap:10px; margin:15px 0;}
.filters input, .filters select {padding:6px 10px; border:1px solid #ccc; border-radius:4px;}
</style>
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<div class="container">
  <h1>Health and Nutrition Data</h1>

  <!-- ✅ Consolidated Report -->
  <div class="list-item">
    <strong><a href="view_consolidated.php">Consolidated Health and Nutrition Data</a></strong>
    <div class="actions">
      <span><?= $consolidated ? htmlspecialchars($consolidated['report_date']) : '-' ?></span>
      <a href="export_consolidated.php" target="_blank">Export PDF</a>
    </div>
  </div>

  <!-- ✅ Filters -->
  <div class="filters">
    <input type="text" id="search" placeholder="Search">
    <select id="barangayFilter">
      <option value="">All</option>
      <?php foreach ($barangayReports as $r): ?>
        <option value="<?= htmlspecialchars($r['barangay']) ?>"><?= htmlspecialchars($r['barangay']) ?></option>
      <?php endforeach; ?>
    </select>
    <select id="sortBy">
      <option value="name">Sort by: Barangay</option>
      <option value="date">Sort by: Date</option>
    </select>
  </div>

  <!-- ✅ Barangay Reports -->
  <div id="reportList">
    <?php foreach ($barangayReports as $r): ?>
      <div class="list-item" data-barangay="<?= htmlspecialchars($r['barangay']) ?>">
        <strong>
            <?= htmlspecialchars($r['barangay']) ?> Health and Nutrition Data
          </a>
        </strong>
        <div class="actions">
          <span><?= htmlspecialchars($r['latest_date']) ?></span>
          <a href="export_barangay.php?id=<?= urlencode($r['report_id']) ?>" target="_blank">Export PDF</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
// ✅ Search + Filter + Sort
const searchInput = document.getElementById('search');
const filterSelect = document.getElementById('barangayFilter');
const sortSelect = document.getElementById('sortBy');
const reportList = document.getElementById('reportList');

function filterReports() {
  const search = searchInput.value.toLowerCase();
  const filter = filterSelect.value;
  const reports = Array.from(reportList.children);

  reports.forEach(r => {
    const text = r.textContent.toLowerCase();
    const barangay = r.dataset.barangay;
    let visible = true;
    if (search && !text.includes(search)) visible = false;
    if (filter && barangay !== filter) visible = false;
    r.style.display = visible ? 'flex' : 'none';
  });

  if (sortSelect.value === 'date') {
    reports.sort((a,b) => {
      const da = new Date(a.querySelector('.actions span').textContent);
      const db = new Date(b.querySelector('.actions span').textContent);
      return db - da;
    }).forEach(r => reportList.appendChild(r));
  } else {
    reports.sort((a,b) => a.dataset.barangay.localeCompare(b.dataset.barangay))
           .forEach(r => reportList.appendChild(r));
  }
}

searchInput.addEventListener('keyup', filterReports);
filterSelect.addEventListener('change', filterReports);
sortSelect.addEventListener('change', filterReports);
</script>
</body>
</html>