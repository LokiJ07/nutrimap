<?php
// barangay_data.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../db/config.php';

// ✅ Require login
  if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}

// --- Fetch approved reports ---
$stmt = $pdo->prepare("
    SELECT r.id, r.report_date, b.title
    FROM reports r
    JOIN bns_reports b ON b.report_id = r.id
    WHERE r.status = 'Approved'
    ORDER BY r.report_date DESC
");
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>CNO NutriMap — Barangay Reports</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { margin:0; font-family: Arial, Helvetica, sans-serif; background:#f5f5f5; }
    .layout { display:flex; height:100vh; flex-direction:column; }
    .body-layout { flex:1; display:flex; }
    .content { flex:1; padding:15px; display:flex; flex-direction:column; }

    /* ✅ Toolbar */
    .toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; }
    .toolbar-left input { padding:6px 8px; border:1px solid #ccc; border-radius:4px; width:220px; }
    .toolbar-right { display:flex; align-items:center; gap:10px; }
    .toolbar-right label { font-size:14px; color:#333; margin-right:4px; }
    .toolbar-right select { padding:6px; border:1px solid #ccc; border-radius:4px; }
    .add-btn { background:#009688; color:#fff; text-decoration:none; padding:8px 14px; border-radius:4px; font-size:14px; display:flex; align-items:center; gap:6px; }
    .add-btn:hover { background:#00796b; }

    /* ✅ Report List */
    h3.section-title { margin:0 0 10px 0; font-size:18px; }
    .report-list { display:flex; flex-direction:column; gap:8px; }
    .report-card { background:#fff; border:1px solid #ccc; border-radius:4px; padding:12px 15px; display:flex; justify-content:space-between; align-items:center; }
    .report-title { font-size:15px; color:#333; font-weight:500; }
    .report-actions { display:flex; align-items:center; gap:15px; font-size:14px; }
    .report-date { color:#555; }
    .export-link { color:#007bff; text-decoration:none; font-weight:500; }
    .export-link:hover { text-decoration:underline; }
  </style>
</head>
<body>
  <div class="layout">
    <?php include 'header.php'; ?>

    <div class="body-layout">
      <main class="content">
        <!-- ✅ Toolbar -->
        <div class="toolbar">
          <div class="toolbar-left">
            <input type="text" placeholder="Search">
          </div>
          <div class="toolbar-right">
            <label for="sort">Sort by:</label>
            <select id="sort">
              <option value="new">New → Old</option>
              <option value="az">A → Z</option>
            </select>
            <a class="add-btn" href="add_report.php"><i class="fa fa-plus"></i> Add Report</a>
          </div>
        </div>

        <!-- ✅ Report List -->
        <h3 class="section-title">Barangay Data</h3>
        <div class="report-list">
          <?php if ($reports): ?>
            <?php foreach ($reports as $r): ?>
              <div class="report-card">
                <div class="report-title"><?= htmlspecialchars($r['title']) ?></div>
                <div class="report-actions">
                  <div class="report-date"><?= date("n-j-Y", strtotime($r['report_date'])) ?></div>
                  <a class="export-link" href="export_report.php?id=<?= $r['id'] ?>">Export</a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="color:#888;">No approved reports found</p>
          <?php endif; ?>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
