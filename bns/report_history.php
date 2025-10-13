<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../db/config.php'; 

// ✅ Require login as BNS
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// --- Handle archive action ---
if (isset($_GET['archive_id']) && is_numeric($_GET['archive_id'])) {
    $reportId = (int)$_GET['archive_id'];

    // ✅ Use correct variable name
    $stmt = $pdo->prepare("UPDATE reports SET prev_status = status, status = 'Archived' WHERE id = ? AND user_id = ?");
    $stmt->execute([$reportId, $user_id]);

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// --- Fetch ALL approved reports (no LIMIT/OFFSET since JS will paginate) ---
$stmt = $pdo->prepare("
    SELECT r.*, u.username, u.profile_pic, b.title
    FROM reports r
    JOIN users u ON r.user_id = u.id
    LEFT JOIN bns_reports b ON b.report_id = r.id
    WHERE r.status = 'Approved' AND r.user_id = :user_id
    ORDER BY r.report_date DESC, r.report_time DESC
");
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>NutriMap — Approved Reports</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body { margin:0; font-family: Arial, Helvetica, sans-serif; background:#f5f5f5; }
.layout { display:flex; height:100vh; flex-direction:column; }
.body-layout { flex:1; display:flex; }
.content { flex:1; padding:15px; display:flex; flex-direction:column; }
.toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; gap:10px; flex-wrap:wrap; }
.toolbar-left input, .toolbar-left select { padding:6px; border:1px solid #ccc; border-radius:4px; }
.toolbar-right a.add-btn {
    background:#009688; color:#fff; text-decoration:none; padding:8px 14px;
    border-radius:4px; font-size:14px; display:flex; align-items:center; gap:6px;
}
.add-btn:hover { background:#00796b; }

.report-panel { background:#fff; border:1px solid #ccc; border-radius:4px; flex:1; display:flex; flex-direction:column; min-height:0; }
.report-panel table { width:100%; border-collapse:collapse; font-size:14px; }
th, td { text-align:left; padding:6px; border-bottom:1px solid #eee; }
th { background:#009688; color:#fff; }
.user-avatar { width:28px; height:28px; border-radius:50%; margin-right:6px; object-fit:cover; vertical-align:middle; }
.status { padding:3px 8px; border-radius:10px; font-size:12px; color:#fff; background:#009688; }
.actions { white-space:nowrap; }
.actions button, .actions a {
    border:none; padding:5px 10px; border-radius:4px; cursor:pointer;
    font-size:12px; margin-right:4px; color:#fff; display:inline-flex; align-items:center; gap:4px; text-decoration:none;
}
.actions .view { background:#007bff; }
.actions .edit { background:#ffc107; color:#000; }
.actions .archive { background:#6c757d; }

.pagination { display:flex; gap:6px; margin-top:10px; flex-wrap:wrap; }
.pagination a {
    border:1px solid #ccc; background:#fff; padding:5px 10px;
    border-radius:4px; text-decoration:none; color:#333; font-size:14px;
}
.pagination a.active { background:#009688; color:#fff; border:none; }
</style>
</head>
<body>
<div class="layout">
<?php include 'header.php'; ?>
<div class="body-layout">
<main class="content">

<div class="toolbar">
  <div class="toolbar-left">
    <input type="text" id="searchInput" placeholder="Search Reports...">
    <select id="sortSelect">
      <option value="new">New → Old</option>
      <option value="old">Old → New</option>
      <option value="az">A → Z</option>
      <option value="za">Z → A</option>
    </select>
    <select id="limitSelect">
      <option value="5">5</option>
      <option value="10" selected>10</option>
      <option value="20">20</option>
    </select>
  </div>
  <div class="toolbar-right">
    <a class="add-btn" href="add_report.php"><i class="fa fa-plus"></i> Add Report</a>
  </div>
</div>

<div class="report-panel">
  <table id="reportsTable">
    <thead>
      <tr>
        <th>User</th>
        <th>Title</th>
        <th>Time</th>
        <th>Date</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($reports): ?>
        <?php foreach ($reports as $r): ?>
          <tr>
            <td>
              <?php if (!empty($r['profile_pic']) && file_exists("../uploads/".$r['profile_pic'])): ?>
                <img src="../uploads/<?= htmlspecialchars($r['profile_pic']) ?>" class="user-avatar">
              <?php else: ?>
                <img src="../uploads/default.png" class="user-avatar">
              <?php endif; ?>
              <?= htmlspecialchars($r['username']) ?>
            </td>
            <td><?= htmlspecialchars($r['title']) ?></td>
            <td><?= date("h:i a", strtotime($r['report_time'])) ?></td>
            <td><?= date("m/d/Y", strtotime($r['report_date'])) ?></td>
            <td><span class="status"><?= htmlspecialchars($r['status']) ?></span></td>
            <td class="actions">
              <button class="view" onclick="window.location.href='view_report.php?id=<?= $r['id'] ?>'"><i class="fa fa-eye"></i> View</button>
              <button class="edit" onclick="window.location.href='edit_report.php?id=<?= $r['id'] ?>'"><i class="fa fa-edit"></i> Edit</button>
              <a href="?archive_id=<?= $r['id'] ?>" class="archive" onclick="return confirm('Archive this approved report?');"><i class="fa fa-archive"></i> Archive</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6" style="text-align:center;color:#888;">No approved reports found</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <div class="pagination" id="pagination"></div>
</div>

</main>
</div>
</div>

<script>
// ✅ JS PAGINATION + SEARCH + SORT
const table = document.getElementById('reportsTable');
const tbody = table.querySelector('tbody');
let rows = Array.from(tbody.querySelectorAll('tr'));
const searchInput = document.getElementById('searchInput');
const sortSelect = document.getElementById('sortSelect');
const limitSelect = document.getElementById('limitSelect');
const paginationDiv = document.getElementById('pagination');

let filteredRows = [...rows];
let currentPage = 1;
let perPage = parseInt(limitSelect.value);

function renderTable() {
  tbody.innerHTML = '';
  let start = (currentPage - 1) * perPage;
  let end = start + perPage;
  filteredRows.slice(start, end).forEach(row => tbody.appendChild(row));
  renderPagination();
}

function renderPagination() {
  paginationDiv.innerHTML = '';
  let totalPages = Math.ceil(filteredRows.length / perPage);
  for (let i = 1; i <= totalPages; i++) {
    const a = document.createElement('a');
    a.href = "#";
    a.textContent = i;
    if (i === currentPage) a.classList.add('active');
    a.addEventListener('click', e => {
      e.preventDefault();
      currentPage = i;
      renderTable();
    });
    paginationDiv.appendChild(a);
  }
}

function filterSort() {
  const search = searchInput.value.toLowerCase();
  filteredRows = rows.filter(row => row.textContent.toLowerCase().includes(search));

  const sort = sortSelect.value;
  filteredRows.sort((a, b) => {
    if (sort === 'new') return new Date(b.cells[3].textContent) - new Date(a.cells[3].textContent);
    if (sort === 'old') return new Date(a.cells[3].textContent) - new Date(b.cells[3].textContent);
    if (sort === 'az') return a.cells[1].textContent.localeCompare(b.cells[1].textContent);
    if (sort === 'za') return b.cells[1].textContent.localeCompare(a.cells[1].textContent);
  });

  currentPage = 1;
  renderTable();
}

searchInput.addEventListener('input', filterSort);
sortSelect.addEventListener('change', filterSort);
limitSelect.addEventListener('change', () => {
  perPage = parseInt(limitSelect.value);
  currentPage = 1;
  renderTable();
});

// ✅ Initial render
renderTable();
</script>
</body>
</html>
