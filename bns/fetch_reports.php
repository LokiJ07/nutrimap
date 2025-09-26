<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../db/config.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') exit('Unauthorized');

$user_id = $_SESSION['user_id'];
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page-1)*$limit;
$search = trim($_GET['search'] ?? '');
$sort = ($_GET['sort'] ?? 'new')==='old'?'ASC':'DESC';

// Fetch reports
$whereClause = '';
$params = [':user_id'=>$user_id];
if($search){
    $whereClause = "AND (b.title LIKE :search OR b.barangay LIKE :search)";
    $params[':search'] = "%$search%";
}

$stmt = $pdo->prepare("
    SELECT r.id, r.report_time, r.report_date, r.status, b.title, b.barangay
    FROM reports r
    LEFT JOIN bns_reports b ON b.report_id = r.id
    WHERE r.user_id = :user_id
    $whereClause
    ORDER BY r.report_date $sort, r.report_time $sort
    LIMIT :limit OFFSET :offset
");

foreach($params as $k=>$v){
    $stmt->bindValue($k,$v,is_int($v)?PDO::PARAM_INT:PDO::PARAM_STR);
}
$stmt->bindValue(':limit',$limit,PDO::PARAM_INT);
$stmt->bindValue(':offset',$offset,PDO::PARAM_INT);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count total
$totalStmt = $pdo->prepare("
    SELECT COUNT(*) FROM reports r
    LEFT JOIN bns_reports b ON b.report_id = r.id
    WHERE r.user_id = :user_id $whereClause
");
foreach($params as $k=>$v){
    $totalStmt->bindValue($k,$v,is_int($v)?PDO::PARAM_INT:PDO::PARAM_STR);
}
$totalStmt->execute();
$totalReports = $totalStmt->fetchColumn();
$totalPages = ceil($totalReports/$limit);

// --- Output table ---
?>
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
<?php if($reports): foreach($reports as $r): ?>
<tr>
<td><?= htmlspecialchars($r['title']??'-') ?></td>
<td><?= htmlspecialchars($r['barangay']??'-') ?></td>
<td><span class="status <?= htmlspecialchars($r['status']) ?>"><?= htmlspecialchars($r['status']) ?></span></td>
<td><?= date("h:i a",strtotime($r['report_time'])) ?></td>
<td><?= date("m/d/Y",strtotime($r['report_date'])) ?></td>
<td class="actions">
<button onclick="window.location.href='view_report.php?id=<?= $r['id'] ?>'" class="view"><i class="fa fa-eye"></i> View</button>
<button onclick="window.location.href='edit_report.php?id=<?= $r['id'] ?>'" class="edit"><i class="fa fa-edit"></i> Edit</button>
<form action="archive_report.php" method="post" style="display:inline;" onsubmit="return confirm('Move this report to archive?');">
<input type="hidden" name="report_id" value="<?= $r['id'] ?>">
<button type="submit" class="delete"><i class="fa fa-archive"></i> Archive</button>
</form>
</td>
</tr>
<?php endforeach; else: ?>
<tr><td colspan="7" style="text-align:center;color:#888;">No reports found</td></tr>
<?php endif; ?>
</tbody>
</table>

<div class="pagination">
<?php if($totalPages>1): ?>
<a href="#" class="ajax-page" data-page="<?= max(1,$page-1) ?>">Prev</a>
<?php for($i=1;$i<=$totalPages;$i++): ?>
<a href="#" class="ajax-page" data-page="<?= $i ?>" <?= $i==$page?'style="background:#009688;color:#fff"':'' ?>><?= $i ?></a>
<?php endfor; ?>
<a href="#" class="ajax-page" data-page="<?= min($totalPages,$page+1) ?>">Next</a>
<?php endif; ?>
</div>
