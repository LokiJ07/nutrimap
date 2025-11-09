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

$userId = $_SESSION['user_id'];

// ✅ Step 1: Fetch user info
$stmtUser = $pdo->prepare("SELECT barangay, user_type FROM users WHERE id = ?");
$stmtUser->execute([$userId]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);
if (!$user) {
  die("User not found");
}

$barangay = $user['barangay'];
$userType = $user['user_type'];

// ✅ Step 2: Fetch all approved (non-archived) reports for this user
$stmtApproved = $pdo->prepare("
  SELECT r.id, r.report_date
  FROM reports r
  LEFT JOIN report_archives ra ON r.id = ra.report_id AND ra.is_archived = 1
  WHERE r.user_id = ? AND r.status = 'Approved' AND ra.id IS NULL
  ORDER BY r.report_date DESC
");
$stmtApproved->execute([$userId]);
$approvedReports = $stmtApproved->fetchAll(PDO::FETCH_ASSOC);

// ✅ Step 3: Auto-create a file for each year if there are approved reports
if ($approvedReports) {
  foreach ($approvedReports as $report) {
    $year = date('Y', strtotime($report['report_date']));
    $reportId = $report['id'];

    // Check if this year already has a file in bns_reports
    $checkStmt = $pdo->prepare("
      SELECT id FROM bns_reports WHERE year = ? AND barangay = ?
    ");
    $checkStmt->execute([$year, $barangay]);
    $existing = $checkStmt->fetch();

    // ✅ If not existing, create new file entry
    if (!$existing) {
      $insertStmt = $pdo->prepare("
        INSERT INTO bns_reports (report_id, barangay, year)
        VALUES (?, ?, ?)
      ");
      $insertStmt->execute([$reportId, $barangay, $year]);
    }
  }
}

// ✅ Step 4: Remove file if all reports for that year are archived
$stmtArchived = $pdo->prepare("
  SELECT ra.report_id, r.report_date
  FROM report_archives ra
  JOIN reports r ON ra.report_id = r.id
  WHERE ra.user_id = ? AND ra.is_archived = 1
");
$stmtArchived->execute([$userId]);
$archivedReports = $stmtArchived->fetchAll(PDO::FETCH_ASSOC);

if ($archivedReports) {
  foreach ($archivedReports as $archived) {
    $archivedYear = date('Y', strtotime($archived['report_date']));

    // Check if there are still non-archived approved reports for that year
    $checkRemaining = $pdo->prepare("
      SELECT COUNT(*) 
      FROM reports r
      LEFT JOIN report_archives ra ON r.id = ra.report_id AND ra.is_archived = 1
      WHERE r.user_id = ? AND r.status = 'Approved' 
      AND YEAR(r.report_date) = ? AND ra.id IS NULL
    ");
    $checkRemaining->execute([$userId, $archivedYear]);
    $remaining = $checkRemaining->fetchColumn();

    // ✅ If no approved non-archived reports remain, remove file
    if ($remaining == 0) {
      $deleteStmt = $pdo->prepare("
        DELETE FROM bns_reports WHERE barangay = ? AND year = ?
      ");
      $deleteStmt->execute([$barangay, $archivedYear]);
    }
  }
}

// ✅ Step 5: Fetch only files linked to non-archived approved reports
$stmtFiles = $pdo->prepare("
  SELECT 
    b.year,
    COUNT(r.id) AS total_reports,
    MAX(r.report_date) AS latest_date,
    MAX(r.id) AS latest_report_id
  FROM bns_reports b
  JOIN reports r ON b.report_id = r.id
  LEFT JOIN report_archives ra ON r.id = ra.report_id AND ra.is_archived = 1
  WHERE b.barangay = ? AND r.status = 'Approved' AND ra.id IS NULL
  GROUP BY b.year
  ORDER BY b.year DESC
");
$stmtFiles->execute([$barangay]);
$files = $stmtFiles->fetchAll(PDO::FETCH_ASSOC);

$fixedTitle = "Barangay Situational Analysis";
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

    .toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; }
    .toolbar-left input { padding:6px 8px; border:1px solid #ccc; border-radius:4px; width:220px; }
    .toolbar-right { display:flex; align-items:center; gap:10px; }
    .toolbar-right label { font-size:14px; color:#333; margin-right:4px; }
    .toolbar-right select { padding:6px; border:1px solid #ccc; border-radius:4px; }
    .add-btn { background:#009688; color:#fff; text-decoration:none; padding:8px 14px; border-radius:4px; font-size:14px; display:flex; align-items:center; gap:6px; }
    .add-btn:hover { background:#00796b; }

    h3.section-title { margin:0 0 10px 0; font-size:18px; }
    .file-list { display:flex; flex-direction:column; gap:10px; }
    .file-card { background:#fff; border:1px solid #ccc; border-radius:6px; padding:15px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 3px rgba(0,0,0,0.1); }
    .file-title { font-size:16px; color:#333; font-weight:600; }
    .file-meta { font-size:13px; color:#555; }
    .file-actions { display:flex; align-items:center; gap:10px; font-size:14px; }
    .file-link { color:#007bff; text-decoration:none; font-weight:500; }
    .file-link:hover { text-decoration:underline; }
  </style>
</head>
<body>
  <div class="layout">
    <?php include 'header.php'; ?>

    <div class="body-layout">
      <main class="content">
        <div class="toolbar">
          <div class="toolbar-left">
        <h3 class="section-title">Barangay Data</h3>
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


        <div class="file-list">
          <?php if ($files): ?>
            <?php foreach ($files as $f): ?>
              <div class="file-card">
                <div>
                  <div class="file-title"><?= htmlspecialchars($fixedTitle) ?></div>
                  <div class="file-meta">
                    <?= $f['total_reports'] ?> report(s) • Year: <?= $f['year'] ?> • Latest: <?= date("M j, Y", strtotime($f['latest_date'])) ?>
                  </div>
                </div>
                <div class="file-actions">
                  <a class="file-link" href="report/barangay_data.php?id=<?= $f['latest_report_id'] ?>">View</a>
                  <a class="file-link" href="./export_report.php?id=<?= $f['latest_report_id'] ?>">Export</a>
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
