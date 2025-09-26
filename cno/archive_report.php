<?php
/*******************************************************
 * archived_reports.php  –  ALL-IN-ONE
 * -----------------------------------------------------
 * • Lists all archived BNS reports.
 * • Restores a report back to bns_reports.
 * • Permanently deletes an archived report.
 *******************************************************/
session_start();
require '../db/config.php';   // adjust the path if needed

// ✅ 1. Security: only CNO can access
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

// ✅ 2. Handle Actions (restore / delete) in the same file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id     = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id > 0 && in_array($action, ['restore','delete'], true)) {
        try {
            if ($action === 'restore') {
                $pdo->beginTransaction();
                // NOTE: include all columns you need to restore
                $pdo->exec("
                    INSERT INTO bns_reports
                    SELECT report_id, barangay, year, title,
                           ind1, ind2, ind3
                           -- add all other columns here!
                    FROM bns_reports_archive
                    WHERE archived_id = {$id}
                ");
                $pdo->exec("DELETE FROM bns_reports_archive WHERE archived_id = {$id}");
                $pdo->commit();
                $msg = "Report restored successfully.";
            }
            elseif ($action === 'delete') {
                $stmt = $pdo->prepare("DELETE FROM bns_reports_archive WHERE archived_id = ?");
                $stmt->execute([$id]);
                $msg = "Report permanently deleted.";
            }
        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $msg = "Error: " . $e->getMessage();
        }
    } else {
        $msg = "Invalid action or ID.";
    }
}

// ✅ 3. Fetch all archived reports to display
$stmt = $pdo->query("
    SELECT archived_id, report_id, barangay, year, title, archived_at
    FROM bns_reports_archive
    ORDER BY archived_at DESC
");
$archives = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Archived BNS Reports</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{font-family:Arial,Helvetica,sans-serif;background:#f5f5f5;margin:0;}
.container{max-width:1200px;margin:20px auto;padding:20px;background:#fff;border-radius:8px;box-shadow:0 0 6px rgba(0,0,0,.1);}
h1{margin-top:0;}
table{width:100%;border-collapse:collapse;margin-top:20px;font-size:14px;}
th,td{padding:10px;border-bottom:1px solid #ddd;text-align:left;}
button{padding:6px 10px;margin:0 3px;border:none;border-radius:4px;cursor:pointer;}
.btn-restore{background:#27ae60;color:#fff;}
.btn-delete{background:#e74c3c;color:#fff;}
.message{padding:10px;margin-bottom:10px;border-radius:4px;background:#e8f4e8;color:#2c662d;}
</style>
</head>
<body>
    <?php include 'header.php';?>
    <?php include 'sidebar.php';?>
<div class="container">
    <h1>Archived BNS Reports</h1>

    <?php if (!empty($msg)): ?>
      <div class="message"><?= htmlspecialchars($msg) ?></div>
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
        <?php if ($archives): ?>
            <?php foreach ($archives as $a): ?>
            <tr>
                <td><?= htmlspecialchars($a['archived_id']) ?></td>
                <td><?= htmlspecialchars($a['report_id']) ?></td>
                <td><?= htmlspecialchars($a['title']) ?></td>
                <td><?= htmlspecialchars($a['barangay']) ?></td>
                <td><?= htmlspecialchars($a['year']) ?></td>
                <td><?= htmlspecialchars($a['archived_at']) ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $a['archived_id'] ?>">
                        <input type="hidden" name="action" value="restore">
                        <button class="btn-restore" type="submit">Restore</button>
                    </form>
                    <form method="post" style="display:inline;" 
                          onsubmit="return confirm('Permanently delete this record?');">
                        <input type="hidden" name="id" value="<?= $a['archived_id'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button class="btn-delete" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" style="text-align:center;color:#888;">No archived reports</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
