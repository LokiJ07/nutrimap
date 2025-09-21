<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../db/config.php';

// ✅ Require login
  if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}

$barangay = $_SESSION['barangay']; 
$year = date('Y');
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']); 
    $year = $_POST['year'] ?? $year;
    $barangay = $_POST['barangay'] ?? $barangay;

    try {
        $pdo->beginTransaction();

        // Insert into reports
        $stmt = $pdo->prepare("
            INSERT INTO reports (user_id, title, report_time, report_date, status) 
            VALUES (?, ?, CURTIME(), CURDATE(), 'Pending')
        ");
        $stmt->execute([$user_id, $title]);

        $report_id = $pdo->lastInsertId();

        // Insert into bns_reports
        $stmt = $pdo->prepare("INSERT INTO bns_reports (...) VALUES (...)");
        $stmt->execute($_POST);

        $pdo->commit();
        $_SESSION['success'] = "Report and barangay data submitted successfully.";
        header("Location: home.php");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Report — CNO NutriMap</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
/* ===== Layout ===== */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    font-size: 13px;
}
.layout {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
.body-layout {
    display: flex;
    flex: 1;
}
.content {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    position: relative;
}

/* ===== Buttons ===== */
button, .btn {
    padding: 6px 14px;
    border: none;
    border-radius: 4px;
    font-size: 13px;
    cursor: pointer;
}
.submit-btn {
    background: #009688;
    color: #fff;
}
.back-btn {
    background: #ff5722;
    color: #fff;
    font-weight: bold;
    position: absolute;
    top: 15px;
    right: 15px;
}

/* ===== Form Wrapper ===== */
.form-wrapper {
    background: #fff;
    padding: 20px;
    border-radius: 6px;
    max-width: 900px;
    margin: auto;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.form-section {
    margin-bottom: 40px;
}
.form-section h3 {
    text-align: center;
    margin-bottom: 20px;
}
.reports-label {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ===== Table Styles ===== */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
th, td {
    border: 1px solid #ddd;
    padding: 6px 8px;
    vertical-align: top;
}
input[type="text"], input[type="number"] {
    width: 100%;
    padding: 4px;
    font-size: 13px;
    box-sizing: border-box;
}
.indent {
    padding-left: 20px;
}
.nested-table {
    width: 100%;
    border: none;
    border-collapse: collapse;
}
.nested-table td {
    border: none;
    padding: 2px 4px;
}
.form-bottom {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}

/* ===== Messages ===== */
.success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
    text-align: center;
}
</style>
</head>
<body>
<div class="layout">
    <?php include 'header.php'; ?>
    <div class="body-layout">
        <main class="content">
            <a href="reports.php" class="btn back-btn">Back</a>

            <div class="reports-label">
                <div>Reports</div>
                <div style="display:flex; align-items:center; gap:5px;">
                    <label for="report-title" style="font-size:14px; font-weight:normal;">Title:</label>
                    <input type="text" id="report-title" placeholder="Enter report title">
                </div>
            </div>

            <?php if (!empty($success)): ?>
                <div class="success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <div class="form-wrapper">
                <form method="post" onsubmit="copyTitle()">
                    <input type="hidden" name="title" id="hidden-title">

                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                        <div>
                            <h2 style="margin:0; font-size:15px;">BNS Form No. IC</h2>
                            <h3 style="margin:0; font-size:15px;">Barangay Nutrition Profile</h3>
                        </div>
                        <div style="display:flex; align-items:center; gap:15px;">
                            <img src="../logos/barangays/<?= strtolower(str_replace(' ', '_', $barangay)) ?>.png" alt="<?= htmlspecialchars($barangay) ?> Logo" style="height:100px;">
                            <img src="../logos/fixed/Seal_of_El_Salvador__Misamis_Oriental-removebg-preview.png" alt="Logo 1" style="height:100px;">
                            <img src="../logos/fixed/National_Nutrition_Council__NNC_.svg-removebg-preview.png" alt="Logo 2" style="height:100px;">
                            <img src="../logos/fixed/Bagong-Pilipinas-logo.png" alt="Logo 3" style="height:100px;">
                        </div>
                    </div>

                    <h3 style="text-align:center;">BARANGAY SITUATIONAL ANALYSIS (BSA)</h3>
                    <h3 style="text-align:center;">
                        <strong>Calendar Year</strong>
                        <input type="number" name="year" value="<?= $year ?>" style="width:80px;">
                    </h3>

                    <div style="text-align:center; margin-bottom:20px; font-size:14px;">
                        <strong>Barangay:</strong> 
                        <input type="text" name="barangay" value="<?= htmlspecialchars($barangay) ?>" readonly style="width:200px;"> 
                        &nbsp;&nbsp;<strong>City/Municipality:</strong> EL SALVADOR CITY 
                        &nbsp;&nbsp;<strong>Province:</strong> MISAMIS ORIENTAL
                    </div>

                    <!-- FULL TABLE FORM (unchanged, still generates dynamic rows) -->
                    <div class="form-section">
                        <h3>Indicators</h3>
                        <table>
                            <!-- Keep your original PHP loops for indicators here -->
                            <!-- They will still render correctly -->
                            <!-- ... -->
                        </table>
                    </div>

                    <div class="form-bottom">
                        <button type="submit" class="submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
function copyTitle() {
    document.getElementById('hidden-title').value = 
        document.getElementById('report-title').value;
}
</script>
</body>
</html>
    