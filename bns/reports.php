<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../db/config.php'; 

// ✅ Require login & check CNO role
  if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}

// --- Pagination setup ---
$limit = 10; // reports per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$user_id = $_SESSION['user_id']; // current logged-in user

// --- Fetch user reports with pagination ---
$stmt = $pdo->prepare("
    SELECT r.id, r.report_time, r.report_date, r.status, b.title, b.barangay
    FROM reports r
    LEFT JOIN bns_reports b ON b.report_id = r.id
    WHERE r.user_id = :user_id
    ORDER BY r.report_date DESC, r.report_time DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Count total reports for logged-in user ---
$totalStmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE user_id = :user_id");
$totalStmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$totalStmt->execute();
$totalReports = $totalStmt->fetchColumn();
$totalPages = ceil($totalReports / $limit);

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>CNO NutriMap — Reports</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { margin:0; font-family: Arial, Helvetica, sans-serif; background:#f5f5f5; }
    .layout { display:flex; height:100vh; flex-direction:column; }
    .body-layout { flex:1; display:flex; }
    .content { flex:1; padding:15px; display:flex; flex-direction:column; }
    .toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
    .toolbar-left input { padding:6px 8px; border:1px solid #ccc; border-radius:4px; width:220px; }
    .toolbar-right { display:flex; align-items:center; gap:10px; }
    .toolbar-right label { font-size:14px; color:#333; margin-right:4px; }
    .toolbar-right select { padding:6px; border:1px solid #ccc; border-radius:4px; }
    .add-btn { background:#009688; color:#fff; text-decoration:none; padding:8px 14px; border-radius:4px; font-size:14px; display:flex; align-items:center; gap:6px; }
    .add-btn:hover { background:#00796b; }

    .report-panel { background:#fff; border:1px solid #ccc; border-radius:4px; flex:1; display:flex; flex-direction:column; }
    .report-header { display:flex; justify-content:space-between; align-items:center; padding:10px; background:#eee; border-bottom:1px solid #ccc; }
    .report-header h3 { margin:0; }
    .pagination { display:flex; align-items:center; gap:6px; }
    .pagination a { border:1px solid #ccc; background:#fff; padding:5px 10px; cursor:pointer; border-radius:4px; font-size:14px; text-decoration:none; color:#333; }
    .pagination a.active { background:#009688; color:#fff; border:none; }

    table { width:100%; border-collapse:collapse; font-size:14px; }
    th, td { text-align:left; padding:10px; border-bottom:1px solid #eee; }
    th { background:#f5f5f5; font-weight:bold; }
    .status { padding:3px 8px; border-radius:10px; font-size:12px; color:#fff; }
    .status.Pending { background:#ffc107; color:#000; }
    .status.Approved { background:#28a745; }
    .status.Rejected { background:#dc3545; }
    .actions button { border:none; padding:5px 10px; border-radius:4px; cursor:pointer; font-size:12px; margin-right:4px; color:#fff; }
    .actions .view { background:#007bff; }
    .actions .edit { background:#28a745; }
    .actions .delete { background:#dc3545; }
  </style>
</head>
<body>
  <div class="layout">
    <?php include 'header.php'; ?>

    <div class="body-layout">
      <main class="content">
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

        <div class="report-panel">
          <div class="report-header">
            <h3>Reports</h3>
            <div class="pagination">
              <a href="?page=<?= max(1, $page-1) ?>">Prev</a>
              <?php for ($i=1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $i==$page ? 'active':'' ?>"><?= $i ?></a>
              <?php endfor; ?>
              <a href="?page=<?= min($totalPages, $page+1) ?>">Next</a>
            </div>
          </div>

          <table>
            <thead>
              <tr>
                <th>Title</th>
                <th>Barangay</th>
                <th>Status</th>
                <th>Time</th>
                <th>Date</th>    
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($reports): ?>
                <?php foreach ($reports as $r): ?>
                  <tr>
                    <td><?= htmlspecialchars($r['title'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($r['barangay'] ?? '-') ?></td>
                    <td><span class="status <?= htmlspecialchars($r['status']) ?>"><?= htmlspecialchars($r['status']) ?></span></td>
                    <td><?= date("h:i a", strtotime($r['report_time'])) ?></td>
                    <td><?= date("m/d/Y", strtotime($r['report_date'])) ?></td>
                    <td class="actions">
                      <a href="view_report.php?id=<?= $r['id'] ?>" class="view"><i class="fa fa-eye"></i> View</a>
                      <a href="edit_report.php?id=<?= $r['id'] ?>" class="edit"><i class="fa fa-edit"></i> Edit</a>
                      <a href="delete_report.php?id=<?= $r['id'] ?>" class="delete" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="7" style="text-align:center; color:#888;">No reports available</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
