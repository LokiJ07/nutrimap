<?php
session_start();
require '../db/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$msg = '';

// Columns of bns_reports (exclude id)
$allCols = [
    'report_id','barangay','year','title',
    'ind1','ind2','ind3','ind4a','ind4b','ind5','ind6',
    'ind7a','ind7b1_no','ind7b1_pct','ind7b2_no','ind7b2_pct',
    'ind7b3_no','ind7b3_pct','ind7b4_no','ind7b4_pct',
    'ind7b5_no','ind7b5_pct','ind7b6_no','ind7b6_pct',
    'ind7b7_no','ind7b7_pct','ind7b8_no','ind7b8_pct',
    'ind7b9_no','ind7b9_pct','ind8','ind9','ind10','ind11','ind12','ind13','ind14',
    'ind15a_public','ind15a_private','ind15b_public','ind15b_private',
    'ind16','ind17','ind18','ind19',
    'ind20a_no','ind20a_pct','ind20b_no','ind20b_pct',
    'ind20c_no','ind20c_pct','ind20d_no','ind20d_pct',
    'ind20e_no','ind20e_pct','ind21','ind22','ind23','ind24','ind25',
    'ind26a_no','ind26a_pct','ind26b_no','ind26b_pct',
    'ind26c_no','ind26c_pct','ind26d_no','ind26d_pct',
    'ind27a_no','ind27a_pct','ind27b_no','ind27b_pct',
    'ind27c_no','ind27c_pct','ind27d_no','ind27d_pct',
    'ind28a_no','ind28a_pct','ind28b_no','ind28b_pct',
    'ind28c_no','ind28c_pct','ind28d_no','ind28d_pct',
    'ind28e_no','ind28e_pct',
    'ind29a_no','ind29a_pct','ind29b_no','ind29b_pct',
    'ind29c_no','ind29c_pct','ind29d_no','ind29d_pct',
    'ind29e_no','ind29e_pct',
    'ind30a_no','ind30a_pct','ind30b_no','ind30b_pct',
    'ind30c_no','ind30c_pct','ind30d_no','ind30d_pct',
    'ind30e_no','ind30e_pct',
    'ind31','ind32','ind33','ind34','ind35a','ind35b','ind36'
];

// Function to quote column names
function quoteCols(array $cols){
    return implode(',', array_map(fn($c)=>"`$c`",$cols));
}

// --- Handle restore or delete ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $archivedId = (int)($_POST['id'] ?? 0);

    if ($archivedId && in_array($action, ['restore','delete'], true)) {
        try {
            if ($action === 'restore') {
                $pdo->beginTransaction();

                // 1️⃣ Get archived report data
                $archived = $pdo->prepare("SELECT * FROM bns_reports_archive WHERE archived_id=:aid");
                $archived->execute([':aid'=>$archivedId]);
                $row = $archived->fetch(PDO::FETCH_ASSOC);
                if (!$row) throw new Exception("Archived report not found.");

                // 2️⃣ Restore main report first
                $pdo->prepare("
                    INSERT INTO reports (id, user_id, report_time, report_date, status)
                    VALUES (:id, :user_id, :report_time, :report_date, :status)
                ")->execute([
                    ':id' => $row['report_id'],
                    ':user_id' => $_SESSION['user_id'],
                    ':report_time' => $row['report_time'] ?? date('H:i:s'),
                    ':report_date' => $row['report_date'] ?? date('Y-m-d'),
                    ':status' => $row['status'] ?? 'Pending'
                ]);

                // 3️⃣ Restore bns_reports
                $cols = quoteCols($allCols);
                $placeholders = implode(',', array_map(fn($c)=>":$c",$allCols));
                $stmtInsert = $pdo->prepare("INSERT INTO bns_reports ($cols) VALUES ($placeholders)");
                $bind = [];
                foreach ($allCols as $c) $bind[":$c"] = $row[$c] ?? null;
                $stmtInsert->execute($bind);

                // 4️⃣ Delete from archive
                $pdo->prepare("DELETE FROM bns_reports_archive WHERE archived_id=:aid")
                    ->execute([':aid'=>$archivedId]);

                $pdo->commit();
                $msg = "Report restored successfully.";
            } else {
                $pdo->prepare("DELETE FROM bns_reports_archive WHERE archived_id=:aid")
                    ->execute([':aid'=>$archivedId]);
                $msg = "Report permanently deleted.";
            }
        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $msg = "Error: ".$e->getMessage();
        }
    } else {
        $msg = "Invalid request.";
    }
}

// --- Fetch archived reports ---
$archives = $pdo->query("
    SELECT archived_id, report_id, title, barangay, year, archived_at
    FROM bns_reports_archive
    ORDER BY archived_at DESC
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
th,td{padding:10px;border-bottom:1px solid #ddd;text-align:left;}
button{padding:6px 10px;margin:0 3px;border:none;border-radius:4px;cursor:pointer;}
.btn-restore{background:#27ae60;color:#fff;}
.btn-delete{background:#e74c3c;color:#fff;}
.message{padding:10px;margin-bottom:10px;border-radius:4px;background:#e8f4e8;color:#2c662d;}
</style>
</head>
<body>
     <?php include 'header.php'; ?>
     <?php include 'sidemenu.php'; ?>
<div class="container">
    <h1>Archived BNS Reports</h1>
    <?php if($msg): ?>
        <div class="message"><?=htmlspecialchars($msg)?></div>
    <?php endif; ?>
    <table>
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
                    <form method="post" style="display:inline">
                        <input type="hidden" name="id" value="<?= (int)$a['archived_id'] ?>">
                        <input type="hidden" name="action" value="restore">
                        <button class="btn-restore">Restore</button>
                    </form>
                    <form method="post" style="display:inline" onsubmit="return confirm('Delete permanently?');">
                        <input type="hidden" name="id" value="<?= (int)$a['archived_id'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button class="btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="7" style="text-align:center;color:#888;">No archived reports</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
