<?php
session_start();
require '../db/config.php';

  // ✅ Require login
  if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}

// ✅ Activity log function
function logActivity($pdo, $user_id, $action) {
    $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action) VALUES (?, ?)");
    $stmt->execute([$user_id, $action]);
}

// Validate report ID
$reportId = $_GET['id'] ?? 0;
if (!is_numeric($reportId) || $reportId <= 0) {
    die("Invalid report ID");
}

// Fetch report and BNS data
$stmt = $pdo->prepare("
    SELECT r.*, b.*, u.barangay AS user_barangay 
    FROM reports r 
    LEFT JOIN bns_reports b ON r.id = b.report_id 
    LEFT JOIN users u ON u.id = r.user_id
    WHERE r.id = :id
");
$stmt->execute(['id' => $reportId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("Report not found");
}

// Check if BNS data exists
$has_bns = !empty($row['id']);

// ✅ Function to map barangay name to logo
function getBarangayLogo($barangay) {
    $map = [
        'cno' => 'CNO.png',
        'amoros' => 'Amoros.png',
        'bolisong' => 'Bolisong.png',
        'cogon' => 'Cogon.png',
        'himaya' => 'Himaya.png',
        'hinigdaan' => 'Hinigdaan.png',
        'kalabaylabay' => 'Kalabaylabay.png',
        'molugan' => 'Molugan.png',
        'pedro s. baculio' => 'Pedro_sa_Baculio.png',
        'pedro sa baculio' => 'Pedro_sa_Baculio.png',
        'poblacion' => 'Poblacion.png',
        'quibonbon' => 'Quibonbon.png',
        'sambulawan' => 'Sambulawan.png',
        'calongonan' => 'Calongonan.png',
        'sinaloc' => 'Sinaloc.png',
        'taytay' => 'Taytay.png',
        'ulaliman' => 'Ulaliman.png'
    ];

    $key = strtolower(trim($barangay ?? ''));
    $file = $map[$key] ?? 'default.png';

    // Check if file exists
    $path = __DIR__ . '/../logos/barangays/' . $file;
    if (!file_exists($path)) {
        $file = 'default.png';
    }

    return $file;
}

// ✅ Determine barangay logo
$barangay_name = $has_bns ? ($row['barangay'] ?? $row['user_barangay']) : '';
$barangay_logo = getBarangayLogo($barangay_name);

// ✅ Log activity: viewing the report
if (isset($_SESSION['user_id'])) {
    $reportTitle = $row['title'] ?? "Untitled Report";
    logActivity($pdo, $_SESSION['user_id'], "Viewed report (ID: $reportId, Title: $reportTitle)");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View BNS Report — CNO NutriMap</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{background:#f0f0f0;font-family:"Times New Roman",serif;font-size:12px;line-height:1.4}
.body-layout{display:flex;justify-content:center;padding:20px 0;}
.container{max-width:1000px;width:100%;margin:0 auto;}
.document{background:#fff;width:21cm;min-height:33cm;margin:0 auto 30px auto;padding:2.5cm;box-shadow:0 0 8px rgba(0,0,0,0.15);position:relative;page-break-after:always;}
@media print {body{background:#fff;}.document{box-shadow:none;margin:0;width:100%;min-height:auto;padding:2cm;}}
.header-table{width:100%;border-collapse:collapse;margin-bottom:20px}
.header-table td{border:none;padding:4px 6px;vertical-align:middle}
.header-left{font-weight:bold;font-size:14px}
.header-logos {display:flex;justify-content:flex-start;align-items:center;gap:10px;}
.header-logos img {height:75px;display:block;}
.report-info{text-align:center;margin-bottom:20px;font-size:12px}
table{width:100%;border-collapse:collapse;margin-bottom:15px;table-layout:fixed}
th,td{border:1px solid #000;padding:6px 8px;text-align:left;font-size:12px;vertical-align:top}
th{background:#ddd}
.indent{padding-left:20px}
table td:nth-child(2), table th:nth-child(2){width:180px;text-align:center;}
.number-cell{display:flex;justify-content:space-between;text-align:center;}
.number-cell div{flex:1;padding:4px;border-left:1px solid #000;}
.number-cell div:first-child{border-left:none;}
.page-number{text-align:right;font-size:12px;color:#555;margin-top:10px}
.notice{background:#fff3cd;padding:10px;border:1px solid #ffeeba;margin-bottom:15px}
.reports-label{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;}
.reports-label .title-input{display:flex;align-items:center;gap:5px;}
.reports-label input[type=text]{padding:4px 6px;font-size:14px;height:28px;width:250px;}
.button-group{display:flex;justify-content:flex-end;margin-top:20px;}
.button-group button{padding:10px 20px;font-size:14px;cursor:pointer;}
.button-save{background:#4CAF50;color:#fff;border:none;}
.button-cancel{text-decoration:none;color:#000;padding:10px 20px;font-size:14px;border:1px solid #ccc;}
.top-right-button{align-self:flex-start;}
</style>
<script>
function copyTitle() {
    const title = document.getElementById('report-title').value;
    document.getElementById('hidden-title').value = title;
}
</script>
</head>
<body>
<div class="layout">
<?php include 'header.php'; ?>
<?php include 'sidemenu.php'; ?>
<div class="body-layout">
<div class="container">

<?php if (!$has_bns): ?>
<div class="notice">
<strong>Note:</strong> Report exists (ID: <?= htmlspecialchars($row['id']) ?>) but no BNS data was found.
</div>
<?php endif; ?>

<!-- Single Form for All Pages -->
<form action="update_report.php" method="post" onsubmit="copyTitle()">
    <input type="hidden" name="report_id" value="<?= $reportId ?>">
    <input type="hidden" id="hidden-title" name="title">

    <!-- Editable Title + Cancel Button -->
    <div class="reports-label">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="font-weight:bold; font-size:22px;">Reports</div>
            <div class="title-input">
                <label for="report-title" style="font-size:14px; font-weight:normal;">Title:</label>
                <input type="text" id="report-title" name="title_display" placeholder="Enter report title"
                       value="<?= isset($row['title']) ? htmlspecialchars($row['title']) : '' ?>">
            </div>
        </div>
        <a href="report_history.php" class="button-cancel top-right-button">Cancel</a>
    </div>

    <!-- PAGE 1 -->
    <div class="document">
        <table class="header-table">
        <tr>
            <td class="header-left">BNS Form No. IC<br>Barangay Nutrition Profile</td>
            <td class="header-logos">
                <img src="../logos/barangays/<?= urlencode($barangay_logo) ?>" alt="Barangay Logo">
                <img src="../logos/fixed/Seal_of_El_Salvador__Misamis_Oriental-removebg-preview.png">
                <img src="../logos/fixed/National_Nutrition_Council__NNC_.svg-removebg-preview.png">
                <img src="../logos/fixed/Bagong-Pilipinas-logo.png">
            </td>
        </tr>
        </table>

        <div class="report-info">
            <h3>BARANGAY SITUATIONAL ANALYSIS (BSA)</h3>
            <strong>Calendar Year:</strong> 
            <input type="number" name="year" value="<?= $has_bns ? htmlspecialchars($row['year']) : '' ?>" style="width:100px;"> &nbsp;
            <strong>Barangay:</strong> 
            <input type="text" name="barangay" value="<?= $has_bns ? htmlspecialchars($row['barangay']) : '' ?>" style="width:150px;"> &nbsp;
            <strong>City:</strong> EL SALVADOR CITY &nbsp;
            <strong>Province:</strong> MISAMIS ORIENTAL
        </div>

        <table>
        <thead>
            <tr><th>Indicator</th><th>Number / %</th></tr>
        </thead>
        <tbody>
    <tr><td>1. Total Population</td>
        <td><input type="number" name="ind1" value="<?= $has_bns ? htmlspecialchars($row['ind1']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>2. Number of households</td>
        <td><input type="number" name="ind2" value="<?= $has_bns ? htmlspecialchars($row['ind2']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>3. Total number of families</td>
        <td><input type="number" name="ind3" value="<?= $has_bns ? htmlspecialchars($row['ind3']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>4. Total number of women who are:</td><td></td></tr>
    <tr class="indent"><td>a. Pregnant</td>
        <td><input type="number" name="ind4a" value="<?= $has_bns ? htmlspecialchars($row['ind4a']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr class="indent"><td>b. Lactating</td>
        <td><input type="number" name="ind4b" value="<?= $has_bns ? htmlspecialchars($row['ind4b']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>5. Households with preschool children (0-59 months)</td>
        <td><input type="number" name="ind5" value="<?= $has_bns ? htmlspecialchars($row['ind5']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>6. Actual population of preschool children (0-59 months)</td>
        <td><input type="number" name="ind6" value="<?= $has_bns ? htmlspecialchars($row['ind6']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>7. Total number of preschool children 0-50 months old measured during OPT Plus</td><td></td></tr>
    <tr><td>a. Percent (%) measured coverage (OPT Plus)</td>
        <td><input type="text" name="ind7a" value="<?= $has_bns ? htmlspecialchars($row['ind7a']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>b. Preschool children by Nutritional Status</td>
        <td class="number-cell"><div>No.</div><div>%</div></td>
    </tr>
    <?php 
    $nutri = ['Severely underweight','Underweight','Normal weight','Severely wasted','Wasted','Overweight','Obese','Severely stunted','Stunted'];
    for ($i=1;$i<=9;$i++): ?>
    <tr class="indent">
        <td><?= $i.') '.$nutri[$i-1] ?></td>
        <td class="number-cell">
            <div><input type="number" name="ind7b<?= $i ?>_no" value="<?= $has_bns ? htmlspecialchars($row["ind7b{$i}_no"]) : '' ?>" style="width:70px;"></div>
            <div><input type="text" name="ind7b<?= $i ?>_pct" value="<?= $has_bns ? htmlspecialchars($row["ind7b{$i}_pct"]) : '' ?>" style="width:70px;"></div>
        </td>
    </tr>
    <?php endfor; ?>
    <tr><td>8. Infants 0-5 months old</td>
        <td><input type="number" name="ind8" value="<?= $has_bns ? htmlspecialchars($row['ind8']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>9. Infants 6-11 months old</td>
        <td><input type="number" name="ind9" value="<?= $has_bns ? htmlspecialchars($row['ind9']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>10. Preschool children 0-23 months old</td>
        <td><input type="number" name="ind10" value="<?= $has_bns ? htmlspecialchars($row['ind10']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>11. Preschool children 12-59 months old</td>
        <td><input type="number" name="ind11" value="<?= $has_bns ? htmlspecialchars($row['ind11']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>12. Preschool children 24-59 months old</td>
        <td><input type="number" name="ind12" value="<?= $has_bns ? htmlspecialchars($row['ind12']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>13. Families with wasted/severely wasted preschool children</td>
        <td><input type="number" name="ind13" value="<?= $has_bns ? htmlspecialchars($row['ind13']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>14. Families with stunted/severely stunted preschool children</td>
        <td><input type="number" name="ind14" value="<?= $has_bns ? htmlspecialchars($row['ind14']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr>
        <td>15. Total number of Educational Institution</td>
        <td class="number-cell"><div>Public</div><div>Private</div></td>
    </tr>
    <tr>
        <td>a. Day Care Centers (Public/Private)</td>
        <td class="number-cell">
            <div><input type="number" name="ind15a_public" value="<?= $has_bns ? htmlspecialchars($row['ind15a_public']) : '' ?>" style="width:70px;"></div>
            <div><input type="number" name="ind15a_private" value="<?= $has_bns ? htmlspecialchars($row['ind15a_private']) : '' ?>" style="width:70px;"></div>
        </td>
    </tr>
    <tr>
        <td>b. Elementary Schools (Public/Private)</td>
        <td class="number-cell">
            <div><input type="number" name="ind15b_public" value="<?= $has_bns ? htmlspecialchars($row['ind15b_public']) : '' ?>" style="width:70px;"></div>
            <div><input type="number" name="ind15b_private" value="<?= $has_bns ? htmlspecialchars($row['ind15b_private']) : '' ?>" style="width:70px;"></div>
        </td>
    </tr>
        </tbody>
        </table>
        <div class="page-number">Page 1</div>
    </div>

    <!-- PAGE 2 -->
    <div class="document">
        <table>
        <tbody>
 <tr><td>16. Kindergarten Enrolled</td>
        <td><input type="number" name="ind16" value="<?= $has_bns ? htmlspecialchars($row['ind16']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>17. School children (Grades 1-6)</td>
        <td><input type="number" name="ind17" value="<?= $has_bns ? htmlspecialchars($row['ind17']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>18. School children weighed (K-Gr. 6)</td>
        <td><input type="number" name="ind18" value="<?= $has_bns ? htmlspecialchars($row['ind18']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>19. % coverage measured</td>
        <td><input type="text" name="ind19" value="<?= $has_bns ? htmlspecialchars($row['ind19']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr>
      <td>20. School children by Nutritional Status</td>
      <td class="number-cell"><div>No.</div><div>%</div></td>
    </tr>
    <?php 
    $nutri20 = ['a. Severely Wasted','b. Wasted','c. Normal','d. Overweight','e. Obese'];
    foreach($nutri20 as $key => $label): 
        $letter = chr(97 + $key); // a,b,c...
    ?>
    <tr class="indent">
        <td><?= $label ?></td>
        <td class="number-cell">
            <div><input type="number" name="ind20<?= $letter ?>_no" value="<?= $has_bns ? htmlspecialchars($row["ind20{$letter}_no"]) : '' ?>" style="width:70px;"></div>
            <div><input type="text" name="ind20<?= $letter ?>_pct" value="<?= $has_bns ? htmlspecialchars($row["ind20{$letter}_pct"]) : '' ?>" style="width:70px;"></div>
        </td>
    </tr>
    <?php endforeach; ?>

    <tr><td>21. Exclusively breastfed 0-5 months</td>
        <td><input type="number" name="ind21" value="<?= $has_bns ? htmlspecialchars($row['ind21']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>22. Complementary foods at 6 months</td>
        <td><input type="number" name="ind22" value="<?= $has_bns ? htmlspecialchars($row['ind22']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>23. Households with wasted school children</td>
        <td><input type="number" name="ind23" value="<?= $has_bns ? htmlspecialchars($row['ind23']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>24. School children dewormed</td>
        <td><input type="number" name="ind24" value="<?= $has_bns ? htmlspecialchars($row['ind24']) : '' ?>" style="width:100px;"></td>
    </tr>
    <tr><td>25. Fully immunized children</td>
        <td><input type="number" name="ind25" value="<?= $has_bns ? htmlspecialchars($row['ind25']) : '' ?>" style="width:100px;"></td>
    </tr>

    <tr>
      <td>26. Toilet facility by type</td>
      <td class="number-cell"><div>No.</div><div>%</div></td>
    </tr>
    <?php 
    $toilet = ['a. Water-sealed','b. Antipolo','c. Open Pit/Shared','d. No Toilet'];
    $i='a';
    foreach($toilet as $label): ?>
    <tr class="indent">
      <td><?= $label ?></td>
      <td class="number-cell">
        <div><input type="number" name="ind26<?= $i ?>_no" value="<?= $has_bns ? htmlspecialchars($row["ind26{$i}_no"]) : '' ?>" style="width:70px;"></div>
        <div><input type="text" name="ind26<?= $i ?>_pct" value="<?= $has_bns ? htmlspecialchars($row["ind26{$i}_pct"]) : '' ?>" style="width:70px;"></div>
      </td>
    </tr>
    <?php $i++; endforeach; ?>

    <tr>
      <td>27. Garbage disposal by type:</td>
      <td class="number-cell"><div>No.</div><div>%</div></td>
    </tr>
    <?php 
    $garbage = ['a. Barangay/City garbage','b. Own compost pit','c. Burning','d. Dumping'];
    $i='a';
    foreach($garbage as $label): ?>
    <tr class="indent">
      <td><?= $label ?></td>
      <td class="number-cell">
        <div><input type="number" name="ind27<?= $i ?>_no" value="<?= $has_bns ? htmlspecialchars($row["ind27{$i}_no"]) : '' ?>" style="width:70px;"></div>
        <div><input type="text" name="ind27<?= $i ?>_pct" value="<?= $has_bns ? htmlspecialchars($row["ind27{$i}_pct"]) : '' ?>" style="width:70px;"></div>
      </td>
    </tr>
    <?php $i++; endforeach; ?>

    <tr>
      <td>28. Water source by type:</td>
      <td class="number-cell"><div>No.</div><div>%</div></td>
    </tr>
    <?php 
    $water = ['a. Pipe water system','b. Well – Level II','c. Deep well (Level II)','d. Mineral water','e. Open shallow dug well'];
    $i='a';
    foreach($water as $label): ?>
    <tr class="indent">
      <td><?= $label ?></td>
      <td class="number-cell">
        <div><input type="number" name="ind28<?= $i ?>_no" value="<?= $has_bns ? htmlspecialchars($row["ind28{$i}_no"]) : '' ?>" style="width:70px;"></div>
        <div><input type="text" name="ind28<?= $i ?>_pct" value="<?= $has_bns ? htmlspecialchars($row["ind28{$i}_pct"]) : '' ?>" style="width:70px;"></div>
      </td>
    </tr>
    <?php $i++; endforeach; ?>

    <tr>
      <td>29. Households with:</td>
      <td class="number-cell"><div>No.</div><div>%</div></td>
    </tr>
    <?php 
    $household = ['a. Vegetable garden','b. Livestock/poultry','c. Combination garden & livestock','d. Fishponds','e. No garden'];
    $i='a';
    foreach($household as $label): ?>
    <tr class="indent">
      <td><?= $label ?></td>
      <td class="number-cell">
        <div><input type="number" name="ind29<?= $i ?>_no" value="<?= $has_bns ? htmlspecialchars($row["ind29{$i}_no"]) : '' ?>" style="width:70px;"></div>
        <div><input type="text" name="ind29<?= $i ?>_pct" value="<?= $has_bns ? htmlspecialchars($row["ind29{$i}_pct"]) : '' ?>" style="width:70px;"></div>
      </td>
    </tr>
    <?php $i++; endforeach; ?>
        </tbody>
        </table>
        <div class="page-number">Page 2</div>
    </div>

    <!-- PAGE 3 -->
    <div class="document">
        <table>
  <colgroup>
    <col style="width: auto;">
    <col style="width: 180px;"> 
  </colgroup>
        <tbody>
    <tr>
      <td>30. Type of dwelling unit</td>
      <td class="number-cell"><div>No.</div><div>%</div></td>
    </tr>
    <?php 
    $d=['a. Concrete','b. Semi concrete','c. Wooden house','d. Nipa bamboo house','e. Barong-barong']; 
    $i='a'; 
    foreach($d as $label): ?>
    <tr class="indent">
      <td><?= $label ?></td>
      <td class="number-cell">
        <div>
            <input type="number" name="ind30<?= $i ?>_no" 
                   value="<?= $has_bns ? htmlspecialchars($row["ind30{$i}_no"]) : '' ?>" style="width:70px;">
        </div>
        <div>
            <input type="text" name="ind30<?= $i ?>_pct" 
                   value="<?= $has_bns ? htmlspecialchars($row["ind30{$i}_pct"]) : '' ?>" style="width:70px;">
        </div>
      </td>
    </tr>
    <?php $i++; endforeach; ?>

    <tr>
      <td>31. Households using iodized salt</td>
      <td>
        <input type="number" name="ind31" value="<?= $has_bns ? htmlspecialchars($row['ind31']) : '' ?>" style="width:100px;">
      </td>
    </tr>
    <tr>
      <td>32. Total number of eateries/carinderia</td>
      <td>
        <input type="number" name="ind32" value="<?= $has_bns ? htmlspecialchars($row['ind32']) : '' ?>" style="width:100px;">
      </td>
    </tr>
    <tr>
      <td>33. Total number of bakeries</td>
      <td>
        <input type="number" name="ind33" value="<?= $has_bns ? htmlspecialchars($row['ind33']) : '' ?>" style="width:100px;">
      </td>
    </tr>
    <tr>
      <td>34. Total number of sari-sari stores</td>
      <td>
        <input type="number" name="ind34" value="<?= $has_bns ? htmlspecialchars($row['ind34']) : '' ?>" style="width:100px;">
      </td>
    </tr>
    <tr>
      <td>35. Number of health and nutrition workers</td>
      <td></td>
    </tr>
    <tr class="indent">
      <td>a. Barangay Nutrition Scholar</td>
      <td>
        <input type="number" name="ind35a" value="<?= $has_bns ? htmlspecialchars($row['ind35a']) : '' ?>" style="width:100px;">
      </td>
    </tr>
    <tr class="indent">
      <td>b. Barangay Health Worker</td>
      <td>
        <input type="number" name="ind35b" value="<?= $has_bns ? htmlspecialchars($row['ind35b']) : '' ?>" style="width:100px;">
      </td>
    </tr>
    <tr>
      <td>36. Total number of households beneficiaries of Pantawid Pamilyang Pilipino</td>
      <td>
        <input type="number" name="ind36" value="<?= $has_bns ? htmlspecialchars($row['ind36']) : '' ?>" style="width:100px;">
      </td>
    </tr>
        </tbody>
        </table>

        <div class="button-group">
            <button type="submit" class="button-save">Updates</button>
        </div>

        <div class="page-number">Page 3</div>
    </div>

</form>
</div>
</div>
</body>
</html>