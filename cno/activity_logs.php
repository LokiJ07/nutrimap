<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../db/config.php';

// ✅ Only CNO
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

// --- Pagination ---
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// --- Search & Sort ---
$search = $_GET['search'] ?? '';
$sortOpt = $_GET['sort'] ?? 'new';  // ’new’ default
// sortOpt can be: 'new', 'old', 'az', 'za'
$allowedSort = ['new', 'old', 'az', 'za'];
if (!in_array($sortOpt, $allowedSort)) {
    $sortOpt = 'new';
}

// Build ORDER BY clause
$orderClause = "ORDER BY al.created_at DESC";  // default new → old
if ($sortOpt === 'old') {
    $orderClause = "ORDER BY al.created_at ASC";
} elseif ($sortOpt === 'az') {
    $orderClause = "ORDER BY u.first_name ASC, u.last_name ASC";
} elseif ($sortOpt === 'za') {
    $orderClause = "ORDER BY u.first_name DESC, u.last_name DESC";
}

// --- Total rows for pagination (consider search)
$countSql = "
    SELECT COUNT(*) 
    FROM activity_logs al
    JOIN users u ON al.user_id = u.id
    WHERE 1=1
";
if ($search !== '') {
    $s = "%". $search ."%";
    $countSql .= " AND (
        u.first_name LIKE :search
        OR u.last_name LIKE :search
        OR al.action LIKE :search
        OR al.details LIKE :search
    )";
}
$countStmt = $pdo->prepare($countSql);
if ($search !== '') {
    $countStmt->bindValue(':search', $s, PDO::PARAM_STR);
}
$countStmt->execute();
$totalRows = $countStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);

// --- Fetch logs with sort, search, pagination ---
$sql = "
    SELECT al.id, al.action, al.details, al.created_at,
           u.first_name, u.last_name, u.user_type, u.barangay
    FROM activity_logs al
    JOIN users u ON al.user_id = u.id
    WHERE 1=1
";
if ($search !== '') {
    $sql .= " AND (
        u.first_name LIKE :search
        OR u.last_name LIKE :search
        OR al.action LIKE :search
        OR al.details LIKE :search
    )";
}
$sql .= " $orderClause LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
if ($search !== '') {
    $stmt->bindValue(':search', $s, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Activity Logs</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { font-family: Arial, Helvetica, sans-serif; background: #f5f5f5; margin: 0; }
    .layout { display: flex; flex-direction: column; height: 100vh; }
    .body-layout { display: flex; flex: 1; }
    .content { flex: 1; padding: 20px; overflow-y: auto; }
    .filters { display: flex; gap: 10px; align-items: center; margin-bottom: 15px; }
    .filters input { width: 250px; padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px; }
    .filters select { padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px; }
    .table-container { background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
    thead { background: #009688; color: #fff; }
    .pagination { margin-top: 15px; display: flex; justify-content: center; gap: 5px; }
    .pagination a { padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px; text-decoration: none; color: #333; }
    .pagination a.active { background: #009688; color: #fff; }
    .pagination a.disabled { color: #aaa; pointer-events: none; background: #f9f9f9; }
  </style>
</head>
<body>
  <div class="layout">
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <div class="body-layout">
      <main class="content">
        <h2>Activity Logs</h2>

        <div class="filters">
          <input type="text" id="logSearch" placeholder="Search logs...">
        <form method="get" style="margin:0;">
  <select name="sort" onchange="this.form.submit()">
    <option value="new" <?= $sortOpt === 'new' ? 'selected' : '' ?>>New → Old</option>
    <option value="old" <?= $sortOpt === 'old' ? 'selected' : '' ?>>Old → New</option>
    <option value="az" <?= $sortOpt === 'az' ? 'selected' : '' ?>>A → Z</option>
    <option value="za" <?= $sortOpt === 'za' ? 'selected' : '' ?>>Z → A</option>
  </select>
  <input type="hidden" name="page" value="<?= $page ?>">
</form>

        </div>

        <div class="table-container">
          <table id="logsTable">
            <thead>
              <tr>
                <th>Date & Time</th>
                <th>User</th>
                <th>Role</th>
                <th>Barangay</th>
                <th>Action</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($logs): ?>
                <?php foreach ($logs as $log): ?>
                  <tr>
                    <td><?= htmlspecialchars($log['created_at']) ?></td>
                    <td><?= htmlspecialchars($log['first_name'].' '.$log['last_name']) ?></td>
                    <td><?= htmlspecialchars($log['user_type']) ?></td>
                    <td><?= htmlspecialchars($log['barangay']) ?></td>
                    <td><?= htmlspecialchars($log['action']) ?></td>
                    <td><?= htmlspecialchars($log['details']) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="6" style="text-align:center;color:#888;">No logs found</td></tr>
              <?php endif; ?>
            </tbody>
          </table>

       <div class="pagination">
  <?php if ($page > 1): ?>
    <a href="?page=<?= $page-1 ?>&sort=<?= $sortOpt ?>">Prev</a>
  <?php endif; ?>
  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i ?>&sort=<?= $sortOpt ?>"
       class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
  <?php endfor; ?>
  <?php if ($page < $totalPages): ?>
    <a href="?page=<?= $page+1 ?>&sort=<?= $sortOpt ?>">Next</a>
  <?php endif; ?>
</div>

        </div>
      </main>
    </div>
  </div>

<script>
// Client-side filter (same as reports)
document.getElementById("logSearch").addEventListener("keyup", function() {
  let filter = this.value.toLowerCase();
  let rows = document.querySelectorAll("#logsTable tbody tr");
  rows.forEach(row => {
    let text = row.textContent.toLowerCase();
    row.style.display = text.includes(filter) ? "" : "none";
  });
});
</script>
</body>
</html>
