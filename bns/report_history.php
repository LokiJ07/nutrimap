<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../db/config.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}

// --- Pagination setup ---
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // reports per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$user_id = $_SESSION['user_id']; // current logged-in user

$stmt = $pdo->prepare("
    SELECT r.*, u.username, u.profile_pic, b.title
    FROM reports r
    JOIN users u ON r.user_id = u.id
    LEFT JOIN bns_reports b ON b.report_id = r.id
    WHERE r.status = 'Approved' AND r.user_id = :user_id
    ORDER BY r.report_date DESC, r.report_time DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Count total approved reports ---
$totalStmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE status = 'Approved' AND user_id = :user_id");
$totalStmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$totalStmt->execute();
$totalReports = $totalStmt->fetchColumn();
$totalPages = ceil($totalReports / $limit);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>CNO NutriMap — Approved Reports</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body { margin:0; font-family: Arial, Helvetica, sans-serif; background:#f5f5f5; }
.layout { display:flex; height:100vh; flex-direction:column; }
.body-layout { flex:1; display:flex; }
.content { flex:1; padding:15px; display:flex; flex-direction:column; }
.toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; gap:10px; flex-wrap:wrap; }
.toolbar-left select{padding:6px;border:1px solid #ccc;border-radius:4px;}
.toolbar-left input {padding:6px;border:1px solid #ccc;border-radius:4px;}
.toolbar-right { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.toolbar-right label { font-size:14px; color:#333; margin-right:4px; }
.toolbar-right select { padding:6px; border:1px solid #ccc; border-radius:4px; }

.add-btn { background:#009688; color:#fff; text-decoration:none; padding:8px 14px; border-radius:4px; font-size:14px; display:flex; align-items:center; gap:6px; }
.add-btn:hover { background:#00796b; }

.report-panel {
    background:#fff;
    border:1px solid #ccc;
    border-radius:4px;
    flex:1;                /* occupy full vertical space */
    display:flex;
    flex-direction:column;
    min-height:0;          /* allows child flex scroll */
}

.report-panel table {
    width:100%;
    border-collapse:collapse;
    font-size:14px;
    flex:1;
}

.report-panel thead {
    flex-shrink:0;         /* header stays fixed height */
}

.report-panel tbody {
    display:block;
    flex:1;
    overflow-y:auto;       /* scroll inside table body */
}

.report-panel thead,
.report-panel tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;    /* consistent column widths */
}
.report-header { display:flex; justify-content:space-between; align-items:center; padding:8px; background:#eee; border-bottom:1px solid #ccc; }
.report-header h3 { margin:0; }
.pagination { display:flex; align-items:center; gap:6px; flex-wrap:wrap; margin-top:10px; }
.pagination a { border:1px solid #ccc; background:#fff; padding:5px 10px; cursor:pointer; border-radius:4px; font-size:14px; text-decoration:none; color:#333; }
.pagination a.active { background:#009688; color:#fff; border:none; }
.user-avatar {width:28px;height:28px;border-radius:50%;margin-right:6px;vertical-align:middle;object-fit:cover;}
table { width:100%; border-collapse:collapse; font-size:14px; margin-top:5px; }
th, td { text-align:left; padding:5px; border-bottom:1px solid #eee; }
th { background: #009688; color:#fff; cursor:pointer; }
.status { padding:3px 8px; border-radius:10px; font-size:12px; color:#fff; background:#009688; }
.actions button {
    border:none;
    padding:5px 10px;
    border-radius:4px;
    cursor:pointer;
    font-size:12px;
    margin-right:4px;
    color:#fff;
    display:inline-flex;     /* keep icon+text inline */
    align-items:center;
    gap:4px;                 /* spacing between icon/text */
}
.actions {
    white-space: nowrap;     /* prevents line break */
}
.actions .view { background:#007bff; }
.actions .delete { background:#dc3545; }
.actions .edit { background:#ffc107; color:#000; }
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
    </div>
<!--
        <label for="limitSelect">Per page:</label>
        <select id="limitSelect">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select> -->
    <div class="toolbar-right">
        <a class="add-btn" href="add_report.php"><i class="fa fa-plus"></i> Add Report</a>
    </div>
</div>

<div class="report-panel">
    <div class="report-header">
        <h3>Report History</h3>
        <div class="pagination" id="pagination"></div>
    </div>

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
                  <img src="../uploads/<?= htmlspecialchars($r['profile_pic']) ?>" class="user-avatar" alt="Profile">
                <?php else: ?>
                  <img src="../uploads/default.png" class="user-avatar" alt="Default">
                <?php endif; ?>
                            <?= htmlspecialchars($r['username']) ?></td>
                        <td><?= htmlspecialchars($r['title']) ?></td>
                        <td><?= date("h:i a", strtotime($r['report_time'])) ?></td>
                        <td><?= date("m/d/Y", strtotime($r['report_date'])) ?></td>
                        <td><span class="status"><?= htmlspecialchars($r['status']) ?></span></td>
                        <td class="actions">
                            <button class="view" onclick="window.location.href='view_report.php?id=<?= $r['id'] ?>'"><i class="fa fa-eye"></i> View</button>
                            <button class="edit" onclick="window.location.href='edit_report.php?id=<?= $r['id'] ?>'"><i class="fa fa-edit"></i> Edit</button>
                            <button class="delete" onclick="if(confirm('Move this report to archive?')) window.location.href='archive_report.php?id=<?= $r['id'] ?>'"><i class="fa fa-archive"></i> Archive</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;color:#888;">No approved reports available</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</main>
</div>
</div>

<script>
// --- Live Search, Sort, Pagination ---
let table = document.getElementById('reportsTable');
let tbody = table.querySelector('tbody');
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
        let a = document.createElement('a');
        a.href = "#";
        a.textContent = i;
        if (i === currentPage) a.classList.add('active');
        a.addEventListener('click', (e)=>{
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
    filteredRows.sort((a,b)=>{
        if (sort==='new') {
            return new Date(b.cells[3].textContent) - new Date(a.cells[3].textContent);
        } else if (sort==='old') {
            return new Date(a.cells[3].textContent) - new Date(b.cells[3].textContent);
        } else if (sort==='az') {
            return a.cells[1].textContent.localeCompare(b.cells[1].textContent);
        } else if (sort==='za') {
            return b.cells[1].textContent.localeCompare(a.cells[1].textContent);
        }
    });

    currentPage = 1;
    renderTable();
}

searchInput.addEventListener('input', filterSort);
sortSelect.addEventListener('change', filterSort);
limitSelect.addEventListener('change', ()=>{
    perPage = parseInt(limitSelect.value);
    currentPage = 1;
    renderTable();
});

// Initial render
renderTable();
</script>
</body>
</html>
