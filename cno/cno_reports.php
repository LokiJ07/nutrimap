<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../db/config.php';

// Only allow CNO
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? '';

// Fetch Pending Reports
$stmt = $pdo->prepare("
    SELECT 
        r.id,
        b.title,
        u.first_name,
        u.last_name,
        u.barangay,
        r.status,
        r.report_time,
        r.report_date
    FROM reports r
    JOIN bns_reports b ON b.report_id = r.id
    JOIN users u ON r.user_id = u.id
    WHERE r.status = 'Pending'
    ORDER BY r.report_date DESC, r.report_time DESC
");
$stmt->execute();
$pendingReports = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Approved Reports
$stmt = $pdo->prepare("
    SELECT 
        r.id,
        b.title,
        u.first_name,
        u.last_name,
        u.barangay,
        r.status,
        r.report_time,
        r.report_date
    FROM reports r
    JOIN bns_reports b ON b.report_id = r.id
    JOIN users u ON r.user_id = u.id
    WHERE r.status = 'Approved'
    ORDER BY r.report_date DESC, r.report_time DESC
");
$stmt->execute();
$approvedReports = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch barangays for filter
$barangays = $pdo->query("SELECT DISTINCT barangay FROM users ORDER BY barangay ASC")->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <title>CNO Reports</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f9fafb;
    }
    main {
      padding: 1.5rem;
    }
    .container {
      max-width: 72rem;
      margin: 0 auto;
      background: white;
      padding: 1.5rem;
      border-radius: 0.5rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    h1 {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }
    .tab-buttons {
      display: flex;
      border-bottom: 1px solid #d1d5db;
      margin-bottom: 1rem;
    }
    .tab-button {
      padding: 0.5rem 1rem;
      cursor: pointer;
      border: none;
      background: none;
      color: #374151;
    }
    .tab-button.active {
      font-weight: 600;
      border-bottom: 2px solid #2563eb;
      color: #2563eb;
    }
    .filters {
      display: flex;
      gap: 1rem;
      margin-bottom: 1rem;
      align-items: center;
    }
    select {
      padding: 0.25rem 0.75rem;
      border: 1px solid #d1d5db;
      border-radius: 0.375rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    thead {
      background: #f9fafb;
    }
    th, td {
      padding: 0.75rem;
      text-align: left;
      font-size: 0.875rem;
      border: 1px solid #e5e7eb;
    }
    th {
      text-transform: uppercase;
      font-weight: 600;
      font-size: 0.75rem;
      color: #6b7280;
    }
    td {
      color: #374151;
    }
    .approve-button {
      color: #16a34a;
      background: #dcfce7;
      border-radius: 0.375rem;
      padding: 0.25rem 0.75rem;
      border: none;
      cursor: pointer;
    }
    .approve-button:hover {
      background: #bbf7d0;
    }
    .decline-button {
      color: #dc2626;
      background: #fee2e2;
      border-radius: 0.375rem;
      padding: 0.25rem 0.75rem;
      border: none;
      cursor: pointer;
    }
    .decline-button:hover {
      background: #fecaca;
    }
    #message-box {
      margin-top: 1rem;
      font-weight: bold;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      display: none;
    }
    .hidden { display: none; }
  </style>
</head>
<body>

<?php include 'header.php'; ?>
<?php include 'sidebar.php';?>

<main>
  <div class="container">
    <h1>Reports</h1>

    <div class="tab-buttons">
      <button id="pending-tab" class="tab-button active">Pending Reports</button>
      <button id="approved-tab" class="tab-button">Approved Reports</button>
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

    <!-- Pending Table -->
    <div id="pending-table">
      <table>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Barangay</th>
            <th>Report Title</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="pending-reports-table-body">
          <?php foreach($pendingReports as $row): ?>
          <tr class="pending-row" 
              data-id="<?= $row['id'] ?>" 
              data-barangay="<?= $row['barangay'] ?>" 
              data-timestamp="<?= $row['report_date'].' '.$row['report_time'] ?>">
            <td><?= htmlspecialchars($row['first_name'].' '.$row['last_name']) ?></td>
            <td><?= htmlspecialchars($row['barangay']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['report_date']) ?></td>
            <td><?= htmlspecialchars($row['report_time']) ?></td>
            <td class="pending-status"><?= ucfirst($row['status']) ?></td>
            <td>
              <button class="approve-button">Approve</button>
              <button class="decline-button">Decline</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Approved Table -->
    <div id="approved-table" class="hidden">
      <table>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Barangay</th>
            <th>Report Title</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="approved-reports-table-body">
          <?php foreach($approvedReports as $row): ?>
          <tr 
              data-barangay="<?= $row['barangay'] ?>" 
              data-timestamp="<?= $row['report_date'].' '.$row['report_time'] ?>">
            <td><?= htmlspecialchars($row['first_name'].' '.$row['last_name']) ?></td>
            <td><?= htmlspecialchars($row['barangay']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['report_date']) ?></td>
            <td><?= htmlspecialchars($row['report_time']) ?></td>
            <td>Approved</td>
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
const pendingTable = document.getElementById('pending-table');
const approvedTable = document.getElementById('approved-table');
const messageBox = document.getElementById('message-box');

const barangayFilter = document.getElementById('barangayFilter');
const sortFilter = document.getElementById('sortFilter');

function showTemporaryMessage(message, success = true) {
  messageBox.textContent = message;
  messageBox.style.display = 'block';
  messageBox.style.backgroundColor = success ? '#16a34a' : '#dc2626';
  setTimeout(()=>{ messageBox.style.display='none'; }, 3000);
}

pendingTab.addEventListener('click', () => {
  pendingTab.classList.add('active'); approvedTab.classList.remove('active');
  pendingTable.classList.remove('hidden'); approvedTable.classList.add('hidden');
});
approvedTab.addEventListener('click', () => {
  approvedTab.classList.add('active'); pendingTab.classList.remove('active');
  approvedTable.classList.remove('hidden'); pendingTable.classList.add('hidden');
});

document.getElementById('pending-reports-table-body').addEventListener('click', (e) => {
  const row = e.target.closest('tr');
  const reportId = row.dataset.id;
  if(e.target.classList.contains('approve-button') || e.target.classList.contains('decline-button')) {
    const action = e.target.classList.contains('approve-button') ? 'approve' : 'decline';
    fetch('update_report_status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `report_id=${reportId}&action=${action}`
    })
    .then(res => res.json())
    .then(data => {
      if(data.status === 'approved'){
        row.querySelector('.pending-status').textContent = 'Approved';
        row.querySelector('td:last-child').remove();
        document.getElementById('approved-reports-table-body').appendChild(row);
        showTemporaryMessage('Report approved.', true);
      } else if(data.status === 'declined'){
        row.querySelector('.pending-status').textContent = 'Declined';
        row.querySelector('td:last-child').remove();
        showTemporaryMessage('Report declined.', false);
      }
    });
  }
});

function applyFilters() {
  ['pending-reports-table-body', 'approved-reports-table-body'].forEach(tableId => {
    const tbody = document.getElementById(tableId);
    let rows = Array.from(tbody.querySelectorAll('tr'));

    rows.forEach(row => {
      row.style.display = (barangayFilter.value === '' || row.dataset.barangay === barangayFilter.value) ? '' : 'none';
    });

    const visibleRows = rows.filter(r => r.style.display !== 'none');
    const sortOption = sortFilter.value;
    if(sortOption){
      visibleRows.sort((a,b)=>{
        if(sortOption.startsWith('name')){
          const nameA = a.cells[0].textContent.toLowerCase();
          const nameB = b.cells[0].textContent.toLowerCase();
          return sortOption === 'name-asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
        } else if(sortOption.startsWith('time')){
          const timeA = new Date(a.dataset.timestamp).getTime();
          const timeB = new Date(b.dataset.timestamp).getTime();
          return sortOption === 'time-new' ? timeB - timeA : timeA - timeB;
        }
      });
      visibleRows.forEach(row => tbody.appendChild(row));
    }
  });
}

barangayFilter.addEventListener('change', applyFilters);
sortFilter.addEventListener('change', applyFilters);
</script>
</body>
</html>
