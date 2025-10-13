<?php
session_start();
require '../db/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$msg = "";

// Handle form actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $archivedId = (int)($_POST['id'] ?? 0);

    try {
        if ($action === 'restore' && $archivedId) {
            $pdo->beginTransaction();
            $pdo->prepare("
                INSERT INTO reports (id, user_id, report_time, report_date, status)
                SELECT report_id, :user_id, report_time, report_date, status
                FROM bns_reports_archive
                WHERE archived_id = :aid
            ")->execute([':user_id' => $_SESSION['user_id'], ':aid' => $archivedId]);
            $pdo->prepare("INSERT INTO bns_reports SELECT * FROM bns_reports_archive WHERE archived_id = :aid")
                ->execute([':aid' => $archivedId]);
            $pdo->prepare("DELETE FROM bns_reports_archive WHERE archived_id = :aid")->execute([':aid' => $archivedId]);
            $pdo->commit();
            $msg = "✅ Report restored successfully.";
        } elseif ($action === 'delete' && $archivedId) {
            $pdo->prepare("DELETE FROM bns_reports_archive WHERE archived_id = :aid")->execute([':aid' => $archivedId]);
            $msg = "🗑️ Report deleted permanently.";
        } elseif ($action === 'delete_all') {
            $pdo->exec("DELETE FROM bns_reports_archive");
            $msg = "🗑️ All archived reports deleted permanently.";
        }
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $msg = "❌ Error: " . $e->getMessage();
    }
}

// Fetch all archived reports
$archives = $pdo->query("
    SELECT archived_id, report_id, title, barangay, year, archived_at
    FROM bns_reports_archive
")->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Archived BNS Reports</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{font-family:Arial,sans-serif;background:#f5f5f5;margin:0;}
.container{max-width:1200px;margin:20px auto;padding:20px;background:#fff;border-radius:8px;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th,td{padding:10px;border-bottom:1px solid #ddd;text-align:left;cursor:default;}
button{padding:6px 10px;margin:0 3px;border:none;border-radius:4px;cursor:pointer;}
.btn-restore{background:#27ae60;color:#fff;}
.btn-delete{background:#e74c3c;color:#fff;}
.btn-delete-all{background:#c0392b;color:#fff;margin-bottom:10px;}
.message{padding:10px;margin-bottom:10px;border-radius:4px;background:#e8f4e8;color:#2c662d;}
input[type="text"]{padding:6px;border:1px solid #ccc;border-radius:4px;width:250px;margin-bottom:10px;}
form.inline{display:inline;}
.sort-select{padding:6px;border:1px solid #ccc;border-radius:4px;margin-left:10px;}
</style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
    <h1>Archived BNS Reports</h1>

    <?php if($msg): ?>
        <div class="message"><?=htmlspecialchars($msg)?></div>
    <?php endif; ?>

    <!-- ✅ Live Search + Live Sort -->
    <div style="margin-bottom:10px;">
        <input type="text" id="searchInput" placeholder="Search archived reports by title or barangay">
        Sort by:
        <select id="sortSelect" class="sort-select">
            <option value="desc">Newest first</option>
            <option value="asc">Oldest first</option>
        </select>
    </div>

    <!-- Delete All -->
    <form method="post" onsubmit="return confirm('Delete all archived reports permanently?');">
        <input type="hidden" name="action" value="delete_all">
        <button type="submit" class="btn-delete-all">Delete All</button>
    </form>

    <table id="archivesTable">
        <thead>
            <tr>
                <th>Archive ID</th>
                <th>Report ID</th>
                <th>Title</th>
                <th>Barangay</th>
                <th>Year</th>
                <th>Archived At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if($archives): foreach($archives as $a): ?>
            <tr>
                <td><?=htmlspecialchars($a['archived_id'])?></td>
                <td><?=htmlspecialchars($a['report_id'])?></td>
                <td><?=htmlspecialchars($a['title'])?></td>
                <td><?=htmlspecialchars($a['barangay'])?></td>
                <td><?=htmlspecialchars($a['year'])?></td>
                <td><?=htmlspecialchars($a['archived_at'])?></td>
                <td>
                    <form method="post" class="inline">
                        <input type="hidden" name="id" value="<?= (int)$a['archived_id'] ?>">
                        <input type="hidden" name="action" value="restore">
                        <button class="btn-restore">Restore</button>
                    </form>
                    <form method="post" class="inline" onsubmit="return confirm('Delete permanently?');">
                        <input type="hidden" name="id" value="<?= (int)$a['archived_id'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button class="btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="7" style="text-align:center;color:#888;">No archived reports found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
// ✅ Live search
const searchInput = document.getElementById('searchInput');
const sortSelect = document.getElementById('sortSelect');
const tableBody = document.querySelector('#archivesTable tbody');

function filterAndSort() {
    const filter = searchInput.value.toLowerCase();
    const rows = Array.from(tableBody.querySelectorAll('tr'));

    // Filter
    let filteredRows = rows.filter(row => row.textContent.toLowerCase().includes(filter));

    // Sort by Archived At column
    const asc = sortSelect.value === 'asc';
    filteredRows.sort((a, b) => {
        const dateA = new Date(a.cells[5].textContent);
        const dateB = new Date(b.cells[5].textContent);
        return asc ? dateA - dateB : dateB - dateA;
    });

    // Re-render table
    tableBody.innerHTML = '';
    filteredRows.forEach(row => tableBody.appendChild(row));
}

searchInput.addEventListener('input', filterAndSort);
sortSelect.addEventListener('change', filterAndSort);
</script>

</body>
</html>
