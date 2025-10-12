<?php
session_start();
require '../db/config.php';

// Only allow CNO
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

// Fetch Pending Reports
$pendingStmt = $pdo->prepare("
    SELECT r.id, b.title, u.first_name, u.last_name, u.barangay, r.status, r.report_time, r.report_date
    FROM reports r
    JOIN bns_reports b ON b.report_id = r.id
    JOIN users u ON r.user_id = u.id
    WHERE r.status='Pending'
    ORDER BY r.report_date DESC, r.report_time DESC
");
$pendingStmt->execute();
$pendingReports = $pendingStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Approved Reports
$approvedStmt = $pdo->prepare("
    SELECT r.id, b.title, u.first_name, u.last_name, u.barangay, r.status, r.report_time, r.report_date
    FROM reports r
    JOIN bns_reports b ON b.report_id = r.id
    JOIN users u ON r.user_id = u.id
    WHERE r.status='Approved'
    ORDER BY r.report_date DESC, r.report_time DESC
");
$approvedStmt->execute();
$approvedReports = $approvedStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Rejected Reports
$rejectedStmt = $pdo->prepare("
    SELECT r.id, b.title, u.first_name, u.last_name, u.barangay, r.status, r.report_time, r.report_date
    FROM reports r
    JOIN bns_reports b ON b.report_id = r.id
    JOIN users u ON r.user_id = u.id
    WHERE r.status='Rejected'
    ORDER BY r.report_date DESC, r.report_time DESC
");
$rejectedStmt->execute();
$rejectedReports = $rejectedStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch barangays for filter
$barangays = $pdo->query("SELECT DISTINCT barangay FROM users ORDER BY barangay ASC")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CNO Reports</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{font-family:Arial,sans-serif;margin:0;background:#f9fafb;}
main{padding:1.5rem;}
.container{max-width:72rem;margin:0 auto;background:#fff;padding:1.5rem;border-radius:.5rem;box-shadow:0 1px 3px rgba(0,0,0,.1);}
h1{font-size:1.5rem;font-weight:bold;margin-bottom:1rem;}
.tab-buttons{display:flex;border-bottom:1px solid #d1d5db;margin-bottom:1rem;}
.tab-button{padding:.5rem 1rem;cursor:pointer;border:none;background:none;color:#374151;}
.tab-button.active{font-weight:600;border-bottom:2px solid #2563eb;color:#2563eb;}
.filters{display:flex;gap:1rem;margin-bottom:1rem;align-items:center;}
select{padding:.25rem .75rem;border:1px solid #d1d5db;border-radius:.375rem;}
table{width:100%;border-collapse:collapse;}
thead{background:#f9fafb;}
th,td{padding:1rem;text-align:left;font-size:.875rem;border:1px solid #e5e7eb;}
th{text-transform:uppercase;font-weight:600;font-size:.75rem;color:#6b7280;}
td{color:#374151;}
.btn {padding:4px 8px;border:none;border-radius:4px;font-size:12px;cursor:pointer;color:#fff;text-decoration:none;}
.btn-view {background:#3498db;}
.approve-button{color: #01af41ff;background:#dcfce7;border-radius:.375rem;padding:.25rem .75rem;border:none;cursor:pointer;}
.approve-button:hover{background: #bbf7d0;}
.decline-button{color:#dc2626;background:#fee2e2;border-radius:.375rem;padding:.25rem .75rem;border:none;cursor:pointer;}
#message-box{margin-top:1rem;font-weight:bold;padding:.5rem 1rem;border-radius:.375rem;display:none;}
.hidden{display:none;}
</style>
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<main>
<div class="container">
<h1>Reports</h1>

<div class="tab-buttons">
    <button id="pending-tab" class="tab-button active">Pending</button>
    <button id="approved-tab" class="tab-button">Approved</button>
    <button id="rejected-tab" class="tab-button">Rejected</button>
</div>

<div class="filters">
    <select id="barangayFilter">
        <option value="">All Barangays</option>
        <?php foreach($barangays as $b): ?>
        <option value="<?= htmlspecialchars($b) ?>"><?= htmlspecialchars($b) ?></option>
        <?php endforeach; ?>
    </select>
    <select id="sortFilter">
        <option value="">Sort By</option>
        <option value="name-asc">Name A-Z</option>
        <option value="name-desc">Name Z-A</option>
        <option value="time-new">Time New-Old</option>
        <option value="time-old">Time Old-New</option>
    </select>
</div>

<div id="pending-table">
    <table>
        <thead>
        <tr>
            <th>Full Name</th>
            <th>Barangay</th>
            <th>Title</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="pending-reports-table-body">
        <?php foreach($pendingReports as $r): ?>
        <tr data-id="<?= $r['id'] ?>" data-barangay="<?= $r['barangay'] ?>" data-timestamp="<?= $r['report_date'].' '.$r['report_time'] ?>">
            <td><?= htmlspecialchars($r['first_name'].' '.$r['last_name']) ?></td>
            <td><?= htmlspecialchars($r['barangay']) ?></td>
            <td><?= htmlspecialchars($r['title']) ?></td>
            <td><?= htmlspecialchars($r['report_date']) ?></td>
            <td><?= htmlspecialchars($r['report_time']) ?></td>
            <td class="status"><?= ucfirst($r['status']) ?></td>
            <td>
                <button class="approve-button">Approve</button>
                <button class="decline-button">Decline</button>
                <a class="btn btn-view" href="view_report.php?id=<?= $r['id'] ?>">View</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="approved-table" class="hidden">
    <table>
        <thead>
        <tr>
            <th>Full Name</th>
            <th>Barangay</th>
            <th>Title</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody id="approved-reports-table-body">
        <?php foreach($approvedReports as $r): ?>
        <tr data-barangay="<?= $r['barangay'] ?>" data-timestamp="<?= $r['report_date'].' '.$r['report_time'] ?>">
            <td><?= htmlspecialchars($r['first_name'].' '.$r['last_name']) ?></td>
            <td><?= htmlspecialchars($r['barangay']) ?></td>
            <td><?= htmlspecialchars($r['title']) ?></td>
            <td><?= htmlspecialchars($r['report_date']) ?></td>
            <td><?= htmlspecialchars($r['report_time']) ?></td>
            <td><?= ucfirst($r['status']) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="rejected-table" class="hidden">
    <table>
        <thead>
        <tr>
            <th>Full Name</th>
            <th>Barangay</th>
            <th>Title</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody id="rejected-reports-table-body">
        <?php foreach($rejectedReports as $r): ?>
        <tr data-barangay="<?= $r['barangay'] ?>" data-timestamp="<?= $r['report_date'].' '.$r['report_time'] ?>">
            <td><?= htmlspecialchars($r['first_name'].' '.$r['last_name']) ?></td>
            <td><?= htmlspecialchars($r['barangay']) ?></td>
            <td><?= htmlspecialchars($r['title']) ?></td>
            <td><?= htmlspecialchars($r['report_date']) ?></td>
            <td><?= htmlspecialchars($r['report_time']) ?></td>
            <td><?= ucfirst($r['status']) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="message-box"></div>
</div>
</main>

<script>
const pendingTab = document.getElementById('pending-tab');
const approvedTab = document.getElementById('approved-tab');
const rejectedTab = document.getElementById('rejected-tab');
const pendingTable = document.getElementById('pending-table');
const approvedTable = document.getElementById('approved-table');
const rejectedTable = document.getElementById('rejected-table');
const messageBox = document.getElementById('message-box');
const barangayFilter = document.getElementById('barangayFilter');
const sortFilter = document.getElementById('sortFilter');

function showMessage(msg, success=true){
    messageBox.textContent = msg;
    messageBox.style.display='block';
    messageBox.style.backgroundColor = success ? '#16a34a' : '#dc2626';
    messageBox.style.color='#fff';
    setTimeout(()=>{messageBox.style.display='none';},3000);
}

// Tabs
pendingTab.addEventListener('click', ()=>{
    pendingTab.classList.add('active'); approvedTab.classList.remove('active'); rejectedTab.classList.remove('active');
    pendingTable.classList.remove('hidden'); approvedTable.classList.add('hidden'); rejectedTable.classList.add('hidden');
});
approvedTab.addEventListener('click', ()=>{
    approvedTab.classList.add('active'); pendingTab.classList.remove('active'); rejectedTab.classList.remove('active');
    approvedTable.classList.remove('hidden'); pendingTable.classList.add('hidden'); rejectedTable.classList.add('hidden');
});
rejectedTab.addEventListener('click', ()=>{
    rejectedTab.classList.add('active'); pendingTab.classList.remove('active'); approvedTab.classList.remove('active');
    rejectedTable.classList.remove('hidden'); pendingTable.classList.add('hidden'); approvedTable.classList.add('hidden');
});

// Approve/Decline Buttons
document.getElementById('pending-reports-table-body').addEventListener('click', function(e){
    const btn = e.target.closest('button');
    if(!btn) return;
    const row = btn.closest('tr');
    const reportId = row.dataset.id;
    if(!reportId) return;

    const action = btn.classList.contains('approve-button') ? 'approve' :
                   btn.classList.contains('decline-button') ? 'reject' : null;
    if(!action) return;

    fetch('update_status.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`report_id=${reportId}&action=${action}`
    })
    .then(r=>r.json())
.then(data => {
    console.log('Server Response:', data); // Debug line — optional
    if (data.error) {
        showMessage(data.error, false);
        return;
    }

    // Normalize status (Approved/Rejected)
    const status = (data.status || '').toLowerCase();

    if (status === 'approved') {
        row.querySelector('.status').textContent = 'Approved';
        row.querySelector('td:last-child').remove();
        document.getElementById('approved-reports-table-body').appendChild(row);
        showMessage('Report approved', true);
    } 
    else if (status === 'rejected') {
        row.querySelector('.status').textContent = 'Rejected';
        row.querySelector('td:last-child').remove();
        document.getElementById('rejected-reports-table-body').appendChild(row);
        showMessage('Report rejected', false);
    } 
    else {
        console.error('Unexpected response:', data);
        showMessage('Unexpected server response', false);
    }
})
.catch(err => {
    console.error('Fetch error:', err);
    showMessage('Network error', false);
});

});

// Filters & Sorting
function applyFilters(){
    ['pending-reports-table-body','approved-reports-table-body','rejected-reports-table-body'].forEach(tid=>{
        const tbody = document.getElementById(tid);
        const rows = Array.from(tbody.querySelectorAll('tr'));
        rows.forEach(r=>{
            r.style.display = (barangayFilter.value==='' || r.dataset.barangay===barangayFilter.value)?'':'none';
        });
        const visible = rows.filter(r=>r.style.display!=='none');
        const sortOption = sortFilter.value;
        if(sortOption){
            visible.sort((a,b)=>{
                if(sortOption.startsWith('name')){
                    const nameA=a.cells[0].textContent.toLowerCase();
                    const nameB=b.cells[0].textContent.toLowerCase();
                    return sortOption==='name-asc'?nameA.localeCompare(nameB):nameB.localeCompare(nameA);
                } else if(sortOption.startsWith('time')){
                    const timeA = new Date(a.dataset.timestamp).getTime();
                    const timeB = new Date(b.dataset.timestamp).getTime();
                    return sortOption==='time-new'?timeB-timeA:timeA-timeB;
                }
            });
            visible.forEach(r=>tbody.appendChild(r));
        }
    });
}
barangayFilter.addEventListener('change', applyFilters);
sortFilter.addEventListener('change', applyFilters);
</script>
</body>
</html>
