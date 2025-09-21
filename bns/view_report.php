<?php
// view_report.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../db/config.php'; // PDO connection

// ✅ Require login & check CNO role
  if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}

$report_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($report_id <= 0) {
    die("Report not found!");
}

$stmt = $pdo->prepare("
    SELECT r.id AS reports_id, r.report_date, r.report_time, r.status,
           b.*
    FROM reports r
    LEFT JOIN bns_reports b ON b.report_id = r.id
    WHERE r.id = :id
    LIMIT 1
");
$stmt->execute(['id' => $report_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("Report not found!");
}

$has_bns = !is_null($row['report_id']);

function getBarangayLogo($barangay) {
    $logos = [
        'CNO' => 'CNO.png',
        'Amoros' => 'Amoros.png',
        'Bolisong' => 'Bolisong.png',
        'Cogon' => 'Cogon.png',
        'Himaya' => 'Himaya.png',
        'Hinigdaan' => 'Hinigdaan.png',
        'Kalabaylabay' => 'Kalabaylabay.png',
        'Molugan' => 'Molugan.png',
        'Pedro S. Baculio' => 'Pedro sa Baculio.png',
        'Pedro sa Baculio' => 'Pedro sa Baculio.png',
        'Poblacion' => 'Poblacion.png',
        'Quibonbon' => 'Quibonbon.png',
        'Sambulawan' => 'Sambulawan.png',
        'San Francisco de Asis' => 'San Francisco de Asis.png',
        'Sinaloc' => 'Sinaloc.png',
        'Taytay' => 'Taytay.png',
        'Ulaliman' => 'Ulaliman.png'
    ];
    return isset($logos[$barangay]) ? $logos[$barangay] : 'default.png';
}

function val($arr, $k, $fmt = null) {
    if (!isset($arr[$k]) || $arr[$k] === null || $arr[$k] === '') return '—';
    $v = $arr[$k];
    if ($fmt === 'int') return (int)$v;
    if ($fmt === 'pct') return number_format((float)$v, 2) . '%';
    if ($fmt === 'dec2') return number_format((float)$v, 2);
    return htmlspecialchars($v);
}

$barangay_logo = getBarangayLogo($row['barangay'] ?? '');
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
body{
  background:#f0f0f0;
  font-family:"Times New Roman",serif;
  font-size:12px;
  line-height:1.4
}
/* Layout wrapper */
.body-layout{
  display:flex;
  justify-content:center;
  padding:20px 0;
}
.container{
  max-width:1000px;
  width:100%;
  margin:0 auto;
}
/* Document like MS Word/Google Docs */
.document{
  background:#fff;
  width:21cm;          /* A4 width */
  min-height:33cm;     /* Long bond paper height */
  margin:0 auto 30px auto;
  padding:2.5cm;       /* page margins */
  box-shadow:0 0 8px rgba(0,0,0,0.15);
  position:relative;
  page-break-after:always;
}
@media print {
  body{background:#fff;}
  .document{
    box-shadow:none;
    margin:0;
    width:100%;
    min-height:auto;
    padding:2cm;
    page-break-after:always;
  }
}
/* Header inside paper */
.header-table{width:100%;border-collapse:collapse;margin-bottom:20px}
.header-table td{border:none;padding:4px 6px;vertical-align:middle}
.header-left{font-weight:bold;font-size:14px}
.header-logos{text-align:right}
.header-logos img{height:60px;margin-left:6px}
.report-info{text-align:center;margin-bottom:20px;font-size:12px}
table{width:100%;border-collapse:collapse;margin-bottom:15px}
th,td{border:1px solid #000;padding:6px 8px;text-align:left;font-size:12px;vertical-align:top}
th{background:#ddd}
.indent{padding-left:20px}
.page-number{text-align:right;font-size:12px;color:#555;margin-top:10px}
.notice{background:#fff3cd;padding:10px;border:1px solid #ffeeba;margin-bottom:15px}
</style>
</head>
<body>
<div class="layout">
<?php include 'header.php'; ?>
<div class="body-layout">
<div class="container">

<?php if (!$has_bns): ?>
<div class="notice">
<strong>Note:</strong> Report exists (ID: <?= htmlspecialchars($row['reports_id']) ?>) but no BNS data was found.
</div>
<?php endif; ?>

<!-- PAGE 1 -->
<div class="document">
<table class="header-table">
<tr>
<td class="header-left">BNS Form No. IC<br>Barangay Nutrition Profile</td>
<td class="header-logos">
<img src="../logos/barangays/<?= htmlspecialchars($barangay_logo) ?>" alt="Barangay Logo">
<img src="../logos/fixed/Seal_of_El_Salvador__Misamis_Oriental-removebg-preview.png">
<img src="../logos/fixed/National_Nutrition_Council__NNC_.svg-removebg-preview.png">
<img src="../logos/fixed/Bagong-Pilipinas-logo.png">
</td>
</tr>
</table>

<div class="report-info">
    <H3>BARANGAY SITUATIONAL ANALYSIS (BSA)</H3>				
<strong>Calendar Year:</strong> <?= $has_bns ? val($row,'year') : '—' ?> &nbsp;
<strong>Barangay:</strong> <?= val($row,'barangay') ?> &nbsp;
<strong>City:</strong> EL SALVADOR CITY &nbsp;
<strong>Province:</strong> MISAMIS ORIENTAL
</div>
<table>
<thead><tr><th>Indicator</th><th>Number / %</th></tr></thead>
<tbody>
<tr><td>1. Total Population</td><td><?= $has_bns ? val($row,'ind1','int') : '—' ?></td></tr>
<tr><td>2. Number of households</td><td><?= $has_bns ? val($row,'ind2','int') : '—' ?></td></tr>
<tr><td>3. Total number of families</td><td><?= $has_bns ? val($row,'ind3','int') : '—' ?></td></tr>
<tr><td>4. Total number of women who are:</td><td></td></tr>
<tr class="indent"><td>a. Pregnant</td><td><?= $has_bns ? val($row,'ind4a','int') : '—' ?></td></tr>
<tr class="indent"><td>b. Lactating</td><td><?= $has_bns ? val($row,'ind4b','int') : '—' ?></td></tr>
<tr><td>5. Households with preschool children (0-59 months)</td><td><?= $has_bns ? val($row,'ind5','int') : '—' ?></td></tr>
<tr><td>6. Actual population of preschool children (0-59 months)</td><td><?= $has_bns ? val($row,'ind6','int') : '—' ?></td></tr>
<tr><td>7a. % measured coverage (OPT Plus)</td><td><?= $has_bns ? val($row,'ind7a','dec2') : '—' ?></td></tr>
<tr><td>7b. Preschool children by Nutritional Status</td><td></td></tr>
<?php 
$nutri = ['Severely underweight','Underweight','Normal weight','Severely wasted','Wasted','Overweight','Obese','Severely stunted','Stunted'];
for ($i=1;$i<=9;$i++): ?>
<tr class="indent"><td><?= $i.') '.$nutri[$i-1] ?></td>
<td><?= $has_bns ? (val($row,"ind7b{$i}_no",'int').' / '.(isset($row["ind7b{$i}_pct"])?number_format((float)$row["ind7b{$i}_pct"],2).'%':'—')) : '—' ?></td></tr>
<?php endfor; ?>
<tr><td>8. Infants 0-5 months old</td><td><?= $has_bns ? val($row,'ind8','int') : '—' ?></td></tr>
<tr><td>9. Infants 6-11 months old</td><td><?= $has_bns ? val($row,'ind9','int') : '—' ?></td></tr>
<tr><td>10. Preschool children 0-23 months old</td><td><?= $has_bns ? val($row,'ind10','int') : '—' ?></td></tr>
<tr><td>11. Preschool children 12-59 months old</td><td><?= $has_bns ? val($row,'ind11','int') : '—' ?></td></tr>
<tr><td>12. Preschool children 24-59 months old</td><td><?= $has_bns ? val($row,'ind12','int') : '—' ?></td></tr>
<tr><td>13. Families with wasted/severely wasted preschool children</td><td><?= $has_bns ? val($row,'ind13','int') : '—' ?></td></tr>
<tr><td>14. Families with stunted/severely stunted preschool children</td><td><?= $has_bns ? val($row,'ind14','int') : '—' ?></td></tr>
<tr><td>15a. Day Care Centers (Public/Private)</td><td><?= $has_bns ? (val($row,'ind15a_public','int').' / '.val($row,'ind15a_private','int')) : '—' ?></td></tr>
<tr><td>15b. Elementary Schools (Public/Private)</td><td><?= $has_bns ? (val($row,'ind15b_public','int').' / '.val($row,'ind15b_private','int')) : '—' ?></td></tr>
</tbody>
</table>
<div class="page-number">Page 1</div>
</div>

<!-- PAGE 2 -->
<div class="document">
<table>
<tbody>
<tr><td>16. Kindergarten Enrolled</td><td><?= $has_bns ? val($row,'ind16','int') : '—' ?></td></tr>
<tr><td>17. School children (Grades 1-6)</td><td><?= $has_bns ? val($row,'ind17','int') : '—' ?></td></tr>
<tr><td>18. School children weighed (K-Gr. 6)</td><td><?= $has_bns ? val($row,'ind18','int') : '—' ?></td></tr>
<tr><td>19. % coverage measured</td><td><?= $has_bns ? (isset($row['ind19'])?number_format((float)$row['ind19'],2).'%':'—') : '—' ?></td></tr>
<tr><td>20. School children by Nutritional Status</td><td></td></tr>
<tr class="indent"><td>a. Severely Wasted</td><td><?= $has_bns ? (val($row,'ind20a_no','int').' / '.(isset($row['ind20a_pct'])?number_format((float)$row['ind20a_pct'],2).'%':'—')) : '—' ?></td></tr>
<tr class="indent"><td>b. Wasted</td><td><?= $has_bns ? (val($row,'ind20b_no','int').' / '.(isset($row['ind20b_pct'])?number_format((float)$row['ind20b_pct'],2).'%':'—')) : '—' ?></td></tr>
<tr class="indent"><td>c. Normal</td><td><?= $has_bns ? (val($row,'ind20c_no','int').' / '.(isset($row['ind20c_pct'])?number_format((float)$row['ind20c_pct'],2).'%':'—')) : '—' ?></td></tr>
<tr class="indent"><td>d. Overweight</td><td><?= $has_bns ? (val($row,'ind20d_no','int').' / '.(isset($row['ind20d_pct'])?number_format((float)$row['ind20d_pct'],2).'%':'—')) : '—' ?></td></tr>
<tr class="indent"><td>e. Obese</td><td><?= $has_bns ? (val($row,'ind20e_no','int').' / '.(isset($row['ind20e_pct'])?number_format((float)$row['ind20e_pct'],2).'%':'—')) : '—' ?></td></tr>
<tr><td>21. Exclusively breastfed 0-5 months</td><td><?= $has_bns ? val($row,'ind21','int') : '—' ?></td></tr>
<tr><td>22. Complementary foods at 6 months</td><td><?= $has_bns ? val($row,'ind22','int') : '—' ?></td></tr>
<tr><td>23. Households with wasted school children</td><td><?= $has_bns ? val($row,'ind23','int') : '—' ?></td></tr>
<tr><td>24. School children dewormed</td><td><?= $has_bns ? val($row,'ind24','int') : '—' ?></td></tr>
<tr><td>25. Fully immunized children</td><td><?= $has_bns ? val($row,'ind25','int') : '—' ?></td></tr>
<tr><td>26. Toilet facility by type</td><td></td></tr>
<?php for($i='a';$i<='d';$i++): ?>
<tr class="indent"><td><?= strtoupper($i) ?>. <?= ['Water-sealed','Antipolo','Open Pit/Shared','No Toilet'][ord($i)-97] ?></td>
<td><?= $has_bns ? (val($row,"ind26{$i}_no",'int').' / '.(isset($row["ind26{$i}_pct"])?number_format((float)$row["ind26{$i}_pct"],2).'%':'—')) : '—' ?></td></tr>
<?php endfor; ?>
<tr><td>27. Garbage disposal by type</td><td></td></tr>
<?php $g=['Barangay/City garbage','Own compost pit','Burning','Dumping']; 
$i='a'; foreach($g as $label): ?>
<tr class="indent"><td><?= $label ?></td>
<td><?= $has_bns ? (val($row,"ind27{$i}_no",'int').' / '.(isset($row["ind27{$i}_pct"])?number_format((float)$row["ind27{$i}_pct"],2).'%':'—')) : '—' ?></td></tr>
<?php $i++; endforeach; ?>
<tr><td>28. Water source by type</td><td></td></tr>
<?php $w=['Pipe water system','Well – Level II','Deep well (Level II)','Mineral water','Open shallow dug well'];
$i='a'; foreach($w as $label): ?>
<tr class="indent"><td><?= $label ?></td>
<td><?= $has_bns ? (val($row,"ind28{$i}_no",'int').' / '.(isset($row["ind28{$i}_pct"])?number_format((float)$row["ind28{$i}_pct"],2).'%':'—')) : '—' ?></td></tr>
<?php $i++; endforeach; ?>
<tr><td>29. Households with...</td><td></td></tr>
<?php $h=['Vegetable garden','Livestock/poultry','Combination garden & livestock','Fishponds','No garden'];
$i='a'; foreach($h as $label): ?>
<tr class="indent"><td><?= $label ?></td>
<td><?= $has_bns ? (val($row,"ind29{$i}_no",'int').' / '.(isset($row["ind29{$i}_pct"])?number_format((float)$row["ind29{$i}_pct"],2).'%':'—')) : '—' ?></td></tr>
<?php $i++; endforeach; ?>
</tbody>
</table>
<div class="page-number">Page 2</div>
</div>

<!-- PAGE 3 -->
<div class="document">
<table>
<tbody>
<tr><td>30. Type of dwelling unit</td><td></td></tr>
<?php $d=['Concrete','Semi concrete','Wooden house','Nipa bamboo house','Barong-barong']; 
$i='a'; foreach($d as $label): ?>
<tr class="indent"><td><?= $label ?></td>
<td><?= $has_bns ? (val($row,"ind30{$i}_no",'int').' / '.(isset($row["ind30{$i}_pct"])?number_format((float)$row["ind30{$i}_pct"],2).'%':'—')) : '—' ?></td></tr>
<?php $i++; endforeach; ?>
<tr><td>31. Households using iodized salt</td><td><?= $has_bns ? val($row,'ind31','int') : '—' ?></td></tr>
<tr><td>32. Total number of eateries/carinderia</td><td><?= $has_bns ? val($row,'ind32','int') : '—' ?></td></tr>
<tr><td>33. Total number of bakeries</td><td><?= $has_bns ? val($row,'ind33','int') : '—' ?></td></tr>
<tr><td>34. Total number of sari-sari stores</td><td><?= $has_bns ? val($row,'ind34','int') : '—' ?></td></tr>
<tr><td>35. Number of health and nutrition workers</td><td></td></tr>
<tr class="indent"><td>a. Barangay Nutrition Scholar</td>
    <td><?= $has_bns ? val($row,'ind35a','int') : '—' ?></td></tr>
<tr class="indent"><td>b. Barangay Health Worker</td>
    <td><?= $has_bns ? val($row,'ind35b','int') : '—' ?></td></tr>

<!-- Continue with Indicator 36 -->
<tr><td>36.  Total number of households beneficiaries of Pantawid Pamilyang Pilipino</td>
    <td><?= $has_bns ? val($row,'ind36','int') : '—' ?></td></tr>
</div>

</body>
</html>

