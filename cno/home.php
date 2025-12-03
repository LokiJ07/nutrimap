<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../db/config.php';

// Only CNO
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}
$userId = $_SESSION['user_id'];

// User stats
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalAdmins = $pdo->query("SELECT COUNT(*) FROM users WHERE user_type='CNO'")->fetchColumn();
$totalBNS = $pdo->query("SELECT COUNT(*) FROM users WHERE user_type='BNS'")->fetchColumn();

// Report stats
$totalReports = $pdo->query("
    SELECT COUNT(*) 
    FROM reports r 
    JOIN bns_reports b ON r.id = b.report_id 
    WHERE r.is_submitted = 1
      AND NOT EXISTS (
          SELECT 1 FROM report_archives a 
          WHERE a.report_id = r.id 
            AND (a.is_archived = 1 OR a.is_deleted = 1)
      )
")->fetchColumn();

$approvedReports = $pdo->query("
    SELECT COUNT(*) 
    FROM reports r 
    JOIN bns_reports b ON r.id = b.report_id 
    WHERE r.status = 'Approved'
      AND r.is_submitted = 1
      AND NOT EXISTS (
          SELECT 1 FROM report_archives a 
          WHERE a.report_id = r.id 
            AND (a.is_archived = 1 OR a.is_deleted = 1)
      )
")->fetchColumn();

$pendingReports = $pdo->query("
    SELECT COUNT(*) 
    FROM reports r 
    JOIN bns_reports b ON r.id = b.report_id 
    WHERE r.status = 'Pending'
      AND r.is_submitted = 1
      AND NOT EXISTS (
          SELECT 1 FROM report_archives a 
          WHERE a.report_id = r.id 
            AND (a.is_archived = 1 OR a.is_deleted = 1)
      )
")->fetchColumn();

$rejectedReports = $pdo->query("
    SELECT COUNT(*) 
    FROM reports r 
    JOIN bns_reports b ON r.id = b.report_id 
    WHERE r.status = 'Rejected'
      AND r.is_submitted = 1
      AND NOT EXISTS (
          SELECT 1 FROM report_archives a 
          WHERE a.report_id = r.id 
            AND (a.is_archived = 1 OR a.is_deleted = 1)
      )
")->fetchColumn();

// Barangay stats
$totalBarangays = $pdo->query("SELECT COUNT(DISTINCT barangay) FROM users WHERE barangay NOT IN ('CNO') AND barangay != ''")->fetchColumn();

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$totalRows = $pdo->query("
    SELECT COUNT(*) 
    FROM reports r
    LEFT JOIN report_archives a ON r.id = a.report_id 
        AND (a.is_deleted = 0 OR a.is_deleted IS NULL) 
        AND (a.is_archived = 0 OR a.is_archived IS NULL)
    WHERE r.status IN ('Pending','Rejected') 
      AND r.is_submitted = 1
")->fetchColumn();

$totalPages = ceil($totalRows / $limit);

// Reports for table
$stmt = $pdo->prepare("
    SELECT r.id, u.profile_pic, u.username AS full_name, u.barangay, b.title, r.status, r.report_time, r.report_date
    FROM reports r
    JOIN users u ON r.user_id = u.id
    JOIN bns_reports b ON r.id = b.report_id
    LEFT JOIN report_archives a ON r.id = a.report_id 
        AND (a.is_deleted = 0 OR a.is_deleted IS NULL) 
        AND (a.is_archived = 0 OR a.is_archived IS NULL)
    WHERE r.status IN ('Pending','Rejected', 'Approved') 
      AND r.is_submitted = 1
    ORDER BY r.report_date DESC, r.report_time DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$allReports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CNO | Dashboard</title>
<link rel="icon" type="image/png" href="../img/CNO_Logo.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
<div class="flex flex-col h-screen">
  <?php include 'header.php'; ?>

  <div class="flex flex-1 overflow-hidden">
    <!-- Main content -->
    <main class="flex-1 flex flex-col p-4 overflow-hidden">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Dashboard</h2>
        <input id="tableSearch" type="text" placeholder="Search Reports"  class="px-3 py-2 w-60 border border-gray-300 rounded focus:ring-1 focus:ring-teal-500 focus:outline-none">
      </div>

      <!-- Cards -->
<div class="flex flex-wrap gap-4 mb-6">
  <!-- Users Card -->
  <div class="flex-1 min-w-[220px] bg-[#064e3b] text-white rounded-lg shadow relative">
    <div class="flex items-center h-28 gap-4 p-5 rounded-lg shadow bg-[#003d3c] text-white">
      <div class="text-5xl mr-4 text-[#06adb3] cursor-pointer" onclick="window.location.href='users.php'">
        <i class="fa fa-users"></i>
      </div>
      <div>
        <h3 class="font-semibold text-2xl">Total Users: <?= $totalUsers ?></h3>
        <p class="text-lg">CNO: <?= $totalAdmins ?> | BNS: <?= $totalBNS ?></p>
      </div>
    </div>
  </div>

  <!-- Reports Card -->
  <div class="flex-1 min-w-[220px] bg-[#0c4a6e] text-white rounded-lg shadow relative cursor-pointer">
    <div class="flex items-center h-28 gap-4 p-5 rounded-lg shadow bg-[#0c4a6e] text-white">
      <div class="text-5xl mr-4 text-[#e0e0e0] cursor-pointer" onclick="window.location.href='cno_reports.php'">
        <i class="fa fa-file-alt"></i>
      </div>
      <div>
        <h3 class="font-semibold text-2xl">Total Reports: <?= $totalReports ?></h3>
        <p class="text-lg">Approved: <?= $approvedReports ?> | Pending: <?= $pendingReports ?> | Rejected: <?= $rejectedReports ?></p>
      </div>
    </div>
  </div>

  <!-- Barangays Card -->
  <div class="flex-1 min-w-[220px] bg-[#115e59] text-white rounded-lg shadow relative cursor-pointer">
    <div class="flex items-center h-28 gap-4 p-5 rounded-lg shadow bg-[#115e59] text-white">
      <div class="text-5xl mr-4 text-[#071d10] cursor-pointer" onclick="window.location.href='nutritional_map.php'">
        <i class="fa fa-map-marker-alt"></i>
      </div>
      <div>
        <h3 class="font-semibold text-2xl">Total Barangays: <?= $totalBarangays ?></h3>
      </div>
    </div>
  </div>
</div>
      <!-- Table -->
      <div class="flex-1 bg-white rounded shadow flex flex-col overflow-hidden">
        <div class="flex justify-between items-center py-3 px-4 font-bold border-b text-gray-700">
          <span>Reports</span>
          <a href="cno_reports.php" class="text-blue-700 text-sm hover:underline">View All</a>
        </div>
        <div class="flex-1 overflow-auto">
          <table id="reportsTable" class="w-full text-sm border-collapse">
            <thead class="bg-[#009688] text-white">
              <tr>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Title</th>
                <th class="px-4 py-2 text-left">Barangay</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Time</th>
                <th class="px-4 py-2 text-left">Date</th>
                <th class="px-4 py-2 text-left">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            <?php if($allReports): ?>
              <?php foreach($allReports as $r): ?>
              <tr class="reports-row">
                <td class="px-4 py-2 flex items-center">
                  <?php $pic = (!empty($r['profile_pic']) && file_exists("../uploads/".$r['profile_pic'])) ? $r['profile_pic'] : 'default.png'; ?>
                  <img src="../uploads/<?= $pic ?>" class="w-7 h-7 rounded-full mr-2 object-cover" alt="Profile">
                  <?= htmlspecialchars($r['full_name']) ?>
                </td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['title']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['barangay']) ?></td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 rounded-full text-white text-xs <?= $r['status']=='Pending'?'bg-cyan-500':($r['status']=='Approved'?'bg-green-500':'bg-red-500') ?>"><?= $r['status'] ?></span>
                </td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['report_time']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['report_date']) ?></td>
                <td class="px-4 py-2"><a href="view_report.php?id=<?= $r['id'] ?>" class="bg-blue-500 px-2 py-1 rounded text-white text-xs">View</a></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="7" class="px-4 py-2 text-center text-gray-400">No pending reports</td></tr>
            <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center items-center gap-2 py-3">
          <?php
            $maxLinks = 5;
            $start = max(1, $page - floor($maxLinks / 2));
            $end = min($totalPages, $start + $maxLinks - 1);
            if ($end - $start < $maxLinks - 1) $start = max(1, $end - $maxLinks + 1);
          ?>
          <?php if ($page>1): ?><a href="?page=<?= $page-1 ?>" class="px-3 py-1 border rounded">Prev</a><?php else:?><span class="px-3 py-1 border rounded text-gray-400 cursor-not-allowed">Prev</span><?php endif; ?>
          <?php if ($start>1): ?><a href="?page=1" class="px-3 py-1 border rounded">1</a><?php if($start>2):?><span class="px-2">...</span><?php endif;?><?php endif;?>
          <?php for($i=$start;$i<=$end;$i++): ?>
          <a href="?page=<?= $i ?>" class="px-3 py-1 border rounded <?= $i==$page?'bg-teal-500 text-white':'' ?>"><?= $i ?></a>
          <?php endfor; ?>
          <?php if($end<$totalPages):?><?php if($end<$totalPages-1):?><span class="px-2">...</span><?php endif;?><a href="?page=<?= $totalPages ?>" class="px-3 py-1 border rounded"><?= $totalPages ?></a><?php endif;?>
          <?php if($page<$totalPages):?><a href="?page=<?= $page+1 ?>" class="px-3 py-1 border rounded">Next</a><?php else:?><span class="px-3 py-1 border rounded text-gray-400 cursor-not-allowed">Next</span><?php endif;?>
        </div>
      </div>
    </main>
  </div>
</div>

<script>
// Table search
document.getElementById("tableSearch").addEventListener("keyup", function() {
  const filter = this.value.toLowerCase();
  document.querySelectorAll(".reports-row").forEach(row => {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(filter) ? "" : "none";
  });
});
</script>
</body>
</html>
