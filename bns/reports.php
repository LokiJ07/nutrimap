<?php
session_start();
require '../db/config.php'; 

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ✅ Only allow BNS
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}
$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type']; // BNS or CNO

function logActivity($pdo, $user_id, $action) {
    $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action) VALUES (?, ?)");
    $stmt->execute([$user_id, $action]);
}

/* ✅ Handle archive */
if (isset($_POST['archive_id']) && is_numeric($_POST['archive_id'])) {
    $reportId = (int)$_POST['archive_id'];
    $check = $pdo->prepare("
        SELECT * FROM report_archives 
        WHERE report_id = :rid AND user_id = :uid AND user_type = :utype
    ");
    $check->execute([':rid'=>$reportId, ':uid'=>$userId, ':utype'=>$userType]);
    $archive = $check->fetch();

    if ($archive) {
        $update = $pdo->prepare("
            UPDATE report_archives 
            SET is_archived = 1, is_deleted = 0, archived_at = NOW()
            WHERE report_id = :rid AND user_id = :uid AND user_type = :utype
        ");
        $update->execute([':rid'=>$reportId, ':uid'=>$userId, ':utype'=>$userType]);
    } else {
        $insert = $pdo->prepare("
            INSERT INTO report_archives (report_id, user_id, user_type, is_archived, is_deleted, archived_at)
            VALUES (:rid, :uid, :utype, 1, 0, NOW())
        ");
        $insert->execute([':rid'=>$reportId, ':uid'=>$userId, ':utype'=>$userType]);
    }

    logActivity($pdo, $userId, "Archived report (ID: $reportId) as $userType");
    echo json_encode(['success'=>true]);
    exit();
}

/* ✅ Handle submit/unsubmit */
if (isset($_POST['submit_action']) && isset($_POST['report_id'])) {
    $reportId = (int)$_POST['report_id'];
    $action = $_POST['submit_action'];

    if ($action === 'submit') {
        $stmt = $pdo->prepare("UPDATE reports SET is_submitted = 1 WHERE id = :id");
        $stmt->execute([':id' => $reportId]);
        logActivity($pdo, $userId, "Submitted report ID $reportId");
        echo json_encode(['success'=>true, 'new_state'=>'submitted']);
        exit();
    } elseif ($action === 'unsubmit') {
        $stmt = $pdo->prepare("UPDATE reports SET is_submitted = 0 WHERE id = :id");
        $stmt->execute([':id' => $reportId]);
        logActivity($pdo, $userId, "Unsubmitted report ID $reportId");
        echo json_encode(['success'=>true, 'new_state'=>'unsubmitted']);
        exit();
    }
}

/* --- Pagination --- */
$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

/* ✅ Search Filter */
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchSQL = '';
if ($search !== '') {
    $searchSQL = " AND b.title LIKE :search ";
}

/* ✅ Fetch reports */
if ($userType === 'BNS') {
    $stmt = $pdo->prepare("
        SELECT r.id, r.report_time, r.report_date, r.status, r.is_submitted,
               u.username,
               b.title AS report_title,
               b.barangay
        FROM reports r
        JOIN users u ON r.user_id = u.id
        LEFT JOIN bns_reports b ON b.report_id = r.id
        LEFT JOIN report_archives a 
          ON a.report_id = r.id 
          AND a.user_id = :user_id 
          AND a.user_type = :user_type
        WHERE r.user_id = :user_id2
          AND (r.status = 'Pending' OR r.status = 'Rejected')
          AND (a.is_deleted = 0 OR a.is_deleted IS NULL)
          AND (a.is_archived = 0 OR a.is_archived IS NULL)
          $searchSQL
        ORDER BY r.report_date DESC, r.report_time DESC
        LIMIT :limit OFFSET :offset
    ");
} else {
    $stmt = $pdo->prepare("
        SELECT r.id, r.report_time, r.report_date, r.status, r.is_submitted,
               u.username,
               b.title AS report_title,
               b.barangay
        FROM reports r
        JOIN users u ON r.user_id = u.id
        LEFT JOIN bns_reports b ON b.report_id = r.id
        LEFT JOIN report_archives a 
          ON a.report_id = r.id 
          AND a.user_id = :user_id 
          AND a.user_type = :user_type
        WHERE r.status IN ('Pending', 'Rejected')
          AND r.is_submitted = 1
          AND (a.is_deleted = 0 OR a.is_deleted IS NULL)
          AND (a.is_archived = 0 OR a.is_archived IS NULL)
          $searchSQL
        ORDER BY r.report_date DESC, r.report_time DESC
        LIMIT :limit OFFSET :offset
    ");
}

$stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
$stmt->bindValue(':user_type', $userType, PDO::PARAM_STR);
if ($userType === 'BNS') {
    $stmt->bindValue(':user_id2', $userId, PDO::PARAM_INT);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
if ($search !== '') {
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
}
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ✅ Count total */
if ($userType === 'BNS') {
    $totalStmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM reports r
        LEFT JOIN bns_reports b ON b.report_id = r.id
        LEFT JOIN report_archives a 
          ON a.report_id = r.id 
          AND a.user_id = ? 
          AND a.user_type = ?
        WHERE r.user_id = ?
          AND (r.status = 'Pending' OR r.status = 'Rejected')
          AND (a.is_deleted = 0 OR a.is_deleted IS NULL)
          AND (a.is_archived = 0 OR a.is_archived IS NULL)
          " . ($search !== '' ? "AND b.title LIKE ?" : "") . "
    ");
    $params = [$userId, $userType, $userId];
    if ($search !== '') $params[] = "%$search%";
    $totalStmt->execute($params);
} else {
    $totalStmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM reports r
        LEFT JOIN bns_reports b ON b.report_id = r.id
        LEFT JOIN report_archives a 
          ON a.report_id = r.id 
          AND a.user_id = ? 
          AND a.user_type = ?
        WHERE r.status IN ('Pending', 'Rejected')
          AND r.is_submitted = 1
          AND (a.is_deleted = 0 OR a.is_deleted IS NULL)
          AND (a.is_archived = 0 OR a.is_archived IS NULL)
          " . ($search !== '' ? "AND b.title LIKE ?" : "") . "
    ");
    $params = [$userId, $userType];
    if ($search !== '') $params[] = "%$search%";
    $totalStmt->execute($params);
}
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
.status.Archived { background:#6c757d; }
.actions a { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border-radius:20px; font-size:13px; font-weight:500; text-decoration:none; color:#fff; transition:all 0.3s ease; }
.actions .view { background:#007bff; }
.actions .view:hover { background:#0056b3; }
.actions .edit { background:#28a745; }
.actions .edit:hover { background:#1e7e34; }
.actions .delete { background:#dc3545; }
.actions .delete:hover { background:#a71d2a; }
</style>
<script>
function archiveReport(reportId) {
  if (confirm('Are you sure you want to move this report to Archive?')) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "reports.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if(xhr.readyState === 4 && xhr.status === 200){
        const response = JSON.parse(xhr.responseText);
        if(response.success){
          const row = document.getElementById('report-' + reportId);
          if(row) row.remove();
        } else alert('Failed to archive report');
      }
    };
    xhr.send("archive_id=" + reportId);
  }
}

function toggleSubmit(reportId, action) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "reports.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if(xhr.readyState === 4 && xhr.status === 200){
      try {
        const res = JSON.parse(xhr.responseText);
        if(res.success){
          const btnCell = document.querySelector(`#report-${reportId} .actions`);
          if(res.new_state === 'submitted') {
            btnCell.innerHTML = `
              <a href="view_report.php?id=${reportId}" class="view"><i class="fa fa-eye"></i> View</a>
              <a href="#" class="delete" onclick="toggleSubmit(${reportId},'unsubmit')"><i class="fa fa-undo"></i> Unsubmit</a>
            `;
          } else {
            btnCell.innerHTML = `
              <a href="view_report.php?id=${reportId}" class="view"><i class="fa fa-eye"></i> View</a>
              <a href="report/edit_report.php?id=${reportId}" class="edit"><i class="fa fa-edit"></i> Edit</a>
              <a href="#" class="delete" onclick="archiveReport(${reportId})"><i class="fa fa-archive"></i> Archive</a>
              <a href="#" class="delete" style="background:#009688" onclick="toggleSubmit(${reportId},'submit')"><i class="fa fa-paper-plane"></i> Submit</a>
            `;
          }
        }
      } catch(e) { console.error('Invalid response', e); }
    }
  };
  xhr.send("report_id=" + reportId + "&submit_action=" + action);
}
</script>
</head>
<body>
<div class="layout">
<?php include 'header.php'; ?>

<div class="body-layout">
<main class="content">


<div class="toolbar">
  <div class="toolbar-left">
<form method="get" style="display:inline;">
  <input type="text" name="search" placeholder="Search Title" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
  <input type="hidden" name="page" value="1">
</form>

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
  <?php
    // ✅ Only show up to 5 page numbers
    $maxVisible = 5;
    $startPage = max(1, $page - floor($maxVisible / 2));
    $endPage = min($totalPages, $startPage + $maxVisible - 1);
    if ($endPage - $startPage + 1 < $maxVisible) {
        $startPage = max(1, $endPage - $maxVisible + 1);
    }
    
    if ($startPage > 1) {
        echo '<a href="?page=1">1</a>';
        if ($startPage > 2) echo '<span>...</span>';
    }

    for ($i=$startPage; $i <= $endPage; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= $i==$page ? 'active':'' ?>"><?= $i ?></a>
    <?php endfor;

    if ($endPage < $totalPages) {
        if ($endPage < $totalPages - 1) echo '<span>...</span>';
        echo '<a href="?page='.$totalPages.'">'.$totalPages.'</a>';
    }
  ?>
  <a href="?page=<?= min($totalPages, $page+1) ?>">Next</a>
</div>
</div>

<table>
<thead>
<tr>
  <th>User</th>
  <th>Title</th>
  <th>Barangay</th>
  <th>Time</th>
  <th>Date</th>
  <th>Status</th>
  <th>Actions</th>
</tr>
</thead>
<tbody>
<?php if ($reports): ?>
  <?php foreach ($reports as $r): ?>
    <tr id="report-<?= $r['id'] ?>">
      <td><?= htmlspecialchars($r['username']) ?></td>
      <td><?= htmlspecialchars($r['report_title'] ?? '-') ?></td>
      <td><?= htmlspecialchars($r['barangay'] ?? '-') ?></td>
      <td><?= date("h:i a", strtotime($r['report_time'])) ?></td>
      <td><?= date("m/d/Y", strtotime($r['report_date'])) ?></td>
      <td><span class="status <?= htmlspecialchars($r['status']) ?>"><?= htmlspecialchars($r['status']) ?></span></td>
      <td class="actions">
        <a href="view_report.php?id=<?= $r['id'] ?>" class="view"><i class="fa fa-eye"></i> View</a>
        <?php if ($userType === 'BNS'): ?>
          <?php if ($r['is_submitted'] == 1): ?>
            <a href="#" class="delete" onclick="toggleSubmit(<?= $r['id'] ?>,'unsubmit')"><i class="fa fa-undo"></i> Unsubmit</a>
          <?php else: ?>
            <a href="report/edit_report.php?id=<?= $r['id'] ?>" class="edit"><i class="fa fa-edit"></i> Edit</a>
            <a href="#" class="delete" onclick="archiveReport(<?= $r['id'] ?>)"><i class="fa fa-archive"></i> Archive</a>
            <a href="#" class="delete" style="background:#009688" onclick="toggleSubmit(<?= $r['id'] ?>,'submit')"><i class="fa fa-paper-plane"></i> Submit</a>
          <?php endif; ?>
        <?php endif; ?>
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
