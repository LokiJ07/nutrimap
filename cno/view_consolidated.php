<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../db/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

/* Helper for clean display */
function val($a,$k,$fmt='int'){
    if(!isset($a[$k])||$a[$k]==='') return '—';
    if($fmt==='int')  return (int)$a[$k];
    if($fmt==='pct')  return number_format((float)$a[$k],2).'%';
    if($fmt==='dec2') return number_format((float)$a[$k],2);
    return htmlspecialchars($a[$k]);
}

/* Build SUM query (latest approved report per barangay) */
$base = [
 'ind1','ind2','ind3','ind4a','ind4b','ind5','ind6','ind7a','ind8','ind9',
 'ind10','ind11','ind12','ind13','ind14','ind16','ind17','ind18','ind19',
 'ind21','ind22','ind23','ind24','ind25','ind31','ind32','ind33','ind34','ind36'
];
$groups = [
 '7b' => ['ind7b1','ind7b2','ind7b3','ind7b4','ind7b5','ind7b6','ind7b7','ind7b8','ind7b9'],
 '20'=>['ind20a','ind20b','ind20c','ind20d','ind20e'],
 '26'=>['ind26a','ind26b','ind26c','ind26d'],
 '27'=>['ind27a','ind27b','ind27c','ind27d'],
 '28'=>['ind28a','ind28b','ind28c','ind28d','ind28e'],
 '29'=>['ind29a','ind29b','ind29c','ind29d','ind29e'],
 '30'=>['ind30a','ind30b','ind30c','ind30d','ind30e']
];
$sel=[];
foreach($base as $f) $sel[]="SUM(bns.$f) AS $f";
foreach($groups as $arr){
    foreach($arr as $f){
        $sel[]="SUM(bns.{$f}_no)  AS {$f}_no";
        $sel[]="SUM(bns.{$f}_pct) AS {$f}_pct";
    }
}
$sel[]="SUM(bns.ind15a_public)  AS ind15a_public";
$sel[]="SUM(bns.ind15a_private) AS ind15a_private";
$sel[]="SUM(bns.ind15b_public)  AS ind15b_public";
$sel[]="SUM(bns.ind15b_private) AS ind15b_private";
$sel[]="SUM(bns.ind35a) AS ind35a";
$sel[]="SUM(bns.ind35b) AS ind35b";

$sql="
SELECT ".implode(',', $sel)."
FROM bns_reports bns
JOIN reports r ON bns.report_id = r.id
WHERE r.status='approved'
AND bns.id IN (
    SELECT MAX(br2.id)
    FROM bns_reports br2
    JOIN reports r2 ON r2.id = br2.report_id
    WHERE r2.status='approved'
    GROUP BY br2.barangay
)";
$totals = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Consolidated Barangay Situation Analysis – Grand Totals</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{background:#fafafa;font-family:"Times New Roman",serif;font-size:14px;margin:0}
.container{max-width:900px;margin:0 auto;padding:20px}
h2{text-align:center;margin:0 0 20px}
table{width:100%;border-collapse:collapse;margin-bottom:20px;table-layout:fixed}
td{border:1px solid #000;padding:6px 8px;text-align:center;word-wrap:break-word}
 .ind{border:1px solid #000;padding:6px 8px;text-align:left;word-wrap:break-word}
th{background:#ddd; border:1px solid #000;padding:6px 8px;text-align:left;word-wrap:break-word} 
.indent td:first-child{padding-left:20px}
.number-cell{display:flex;justify-content:space-between}
.number-cell div{flex:1;text-align:center;border-left:1px solid #000}
.number-cell div:first-child{border-left:none}
@media print{.page-break{page-break-after:always}}
</style>
</head>
<body>

<div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
    <div>
    <!-- ✅ Fixed Edit button link -->
      <a href="javascript:history.back()" 
         style="background:#6c757d;color:#fff;padding:6px 12px;border-radius:4px;text-decoration:none;">
         <i class="fa fa-arrow-left"></i> Back
      </a>
    </div>
</div>
<h2>Consolidated Barangay Situation Analysis<br>Grand Total of Latest Approved Reports</h2>

<!-- ================= PAGE 1 ================= -->
<table>
<thead><tr><th style="width:70%">Indicator</th><td class="number-cell"><div>No.</div></td></tr></thead>
<tbody>
<tr><td class="ind">Total Population</td><td><?=val($totals,'ind1')?></td></tr>
<tr><td class="ind">Number of households</td><td><?=val($totals,'ind2')?></td></tr>
<tr><td class="ind">Total number of families</td><td><?=val($totals,'ind3')?></td></tr>
<tr><td class="ind">Total number of women who are:</td><td></td></tr>
<tr class="indent"><td class="ind">Pregnant</td><td><?=val($totals,'ind4a')?></td></tr>
<tr class="indent"><td class="ind">Lactating</td><td><?=val($totals,'ind4b')?></td></tr>
<tr><td class="ind">Total households with preschool children aged 0–59 months</td><td><?=val($totals,'ind5')?></td></tr>
<tr><td class="ind">Actual population of preschool children 0–59 months</td><td><?=val($totals,'ind6')?></td></tr>
<tr><td class="ind">Total preschool children 0–50 months measured during OPT Plus</td><td><?=val($totals,'ind7a','dec2')?></td></tr>
<tr><td class="ind">Percent (%) measured coverage (OPT Plus)</td><td><?=val($totals,'ind7a','dec2')?>%</td></tr>
<tr><td class="ind">Number and percent (%) of preschool children according to Nutritional Status</td>
    <td class="number-cell"><div>No.</div><div>%</div></td></tr>
<?php $nutri=['Severely underweight','Underweight','Normal weight','Severely wasted','Wasted','Overweight','Obese','Severely stunted','Stunted'];
for($i=1;$i<=9;$i++): ?>
<tr class="indent">
  <td class="ind"><?=$nutri[$i-1]?></td>
  <td class="number-cell">
    <div><?=val($totals,"ind7b{$i}_no")?></div>
    <div><?=val($totals,"ind7b{$i}_pct",'pct')?></div>
  </td>
</tr>
<?php endfor; ?>
<tr><td class="ind">Total number of infants 0–5 months old</td><td><?=val($totals,'ind8')?></td></tr>
<tr><td class="ind">Total number of infants 6–11 months old</td><td><?=val($totals,'ind9')?></td></tr>
<tr><td class="ind">Total preschool children 0–23 months old</td><td><?=val($totals,'ind10')?></td></tr>
<tr><td class="ind">Total preschool children 12–59 months old</td><td><?=val($totals,'ind11')?></td></tr>
<tr><td class="ind">Total preschool children 24–59 months old</td><td><?=val($totals,'ind12')?></td></tr>
<tr><td class="ind">Total families with wasted &amp; severely wasted preschool children</td><td><?=val($totals,'ind13')?></td></tr>
<tr><td class="ind">Total families with stunted &amp; severely stunted preschool children</td><td><?=val($totals,'ind14')?></td></tr>
</tbody>
</table>

<div class="page-break"></div>

<!-- ================= PAGE 2 ================= -->
<table>
<thead><tr><th style="width:70%"></th><td class="number-cell"><div>.</div></td></tr></thead>
<tbody>
<tr class="indent"><td class="ind">Total number of Educational Institutions</td><td></td></tr>
<tr class="indent"><td class="ind">Number of Day Care Centers – Public / Private</td>
  <td class="number-cell"><div><?=val($totals,'ind15a_public')?></div><div><?=val($totals,'ind15a_private')?></div></td></tr>
<tr><td class="ind">Number of Elementary Schools – Public / Private</td>
  <td class="number-cell"><div><?=val($totals,'ind15b_public')?></div><div><?=val($totals,'ind15b_private')?></div></td></tr>
<tr><td class="ind">Total number of children enrolled in Kindergarten (DepEd supervised)</td><td><?=val($totals,'ind16')?></td></tr>
<tr><td class="ind">Total number of school children (Grades 1–6)</td><td><?=val($totals,'ind17')?></td></tr>
<tr><td class="ind">Total number of school children weighed at the start of the school year (K–Gr.6)</td><td><?=val($totals,'ind18')?></td></tr>
<tr><td class="ind">Percentage (%) coverage of school children measured</td><td><?=val($totals,'ind19','dec2')?>%</td></tr>
<tr><td class="ind">Number and percent (%) of school children according to Nutritional Status</td>
    <td class="number-cell"><div>No.</div><div>%</div></td></tr>
<?php foreach(['a'=>'Severely Wasted','b'=>'Wasted','c'=>'Normal','d'=>'Overweight','e'=>'Obese'] as $c=>$lbl): ?>
<tr class="indent">
  <td class="ind"><?=$lbl?></td>
  <td class="number-cell">
    <div><?=val($totals,"ind20{$c}_no")?></div>
    <div><?=val($totals,"ind20{$c}_pct",'pct')?></div>
  </td>
</tr>
<?php endforeach; ?>
<tr><td class="ind">0–5 months old children exclusively breastfed</td><td><?=val($totals,'ind21')?></td></tr>
<tr><td class="ind">Households with severely wasted and wasted school children</td><td><?=val($totals,'ind22')?></td></tr>
<tr><td class="ind">School children dewormed at start of school year</td><td><?=val($totals,'ind23')?></td></tr>
<tr><td class="ind">Fully immunized children</td><td><?=val($totals,'ind24')?></td></tr>
<tr><td class="ind">Households by type of toilet facility:</td><td class="number-cell"><div>No.</div><div>%</div></td></tr>
<?php foreach(['a'=>'Water-sealed toilet','b'=>'Antipolo (Unsanitary Toilet)','c'=>'Open Pit/Shared','d'=>'No Toilet'] as $c=>$lbl): ?>
<tr class="indent">
  <td class="ind"><?=$lbl?></td>
  <td class="number-cell">
    <div><?=val($totals,"ind26{$c}_no")?></div>
    <div><?=val($totals,"ind26{$c}_pct",'pct')?></div>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<div class="page-break"></div>

<!-- ================= PAGE 3 ================= -->
<table>
<thead><tr><th style="width:70%"></th><td class="number-cell"><div>.</div></td></tr></thead>
<tbody>
<tr><td class="ind">Households by type of garbage disposal:</td><td class="number-cell"><div>No.</div><div>%</div></td></tr>
<?php foreach(['a'=>'Barangay/City garbage collection','b'=>'Own compose pit','c'=>'Burning','d'=>'Dumping'] as $c=>$lbl): ?>
<tr class="indent">
  <td class="ind"><?=$lbl?></td>
  <td class="number-cell">
    <div><?=val($totals,"ind27{$c}_no")?></div>
    <div><?=val($totals,"ind27{$c}_pct",'pct')?></div>
  </td>
</tr>
<?php endforeach; ?>
<tr><td class="ind">Households by type of water source:</td><td class="number-cell"><div>No.</div><div>%</div></td></tr>
<?php foreach(['a'=>'Pipe water system','b'=>'Well – Level II','c'=>'Deep well with topstand communal source water system (Level II)','d'=>'Mineral water/water dispensing stores','e'=>'Open shallow dug well (Level I)'] as $c=>$lbl): ?>
<tr class="indent">
  <td class="ind"><?=$lbl?></td>
  <td class="number-cell">
    <div><?=val($totals,"ind28{$c}_no")?></div>
    <div><?=val($totals,"ind28{$c}_pct",'pct')?></div>
  </td>
</tr>
<?php endforeach; ?>
<tr><td class="ind">Household with:</td><td class="number-cell"><div>No.</div><div>%</div></td></tr>
<?php foreach(['a'=>'Vegetable garden','b'=>'Livestock/poultry','c'=>'Combination vegetable garden & livestock/poultry','d'=>'Fishponds','e'=>'No garden'] as $c=>$lbl): ?>
<tr class="indent">
  <td class="ind"><?=$lbl?></td>
  <td class="number-cell">
    <div><?=val($totals,"ind29{$c}_no")?></div>
    <div><?=val($totals,"ind29{$c}_pct",'pct')?></div>
  </td>
</tr>
<?php endforeach; ?>
<tr><td class="ind">Households according to type of dwelling unit</td><td class="number-cell"><div>No.</div><div>%</div></td></tr>
<?php foreach(['a'=>'Concrete','b'=>'Semi concrete','c'=>'Wooden house','d'=>'Nipa bamboo house','e'=>'Barong-barong makeshift'] as $c=>$lbl): ?>
<tr class="indent">
  <td class="ind"><?=$lbl?></td>
  <td class="number-cell">
    <div><?=val($totals,"ind30{$c}_no")?></div>
    <div><?=val($totals,"ind30{$c}_pct",'pct')?></div>
  </td>
</tr>
<?php endforeach; ?>
<tr><td class="ind">Total number of households using iodized salt</td><td><?=val($totals,'ind31')?></td></tr>
<tr><td class="ind">Total number of eateries/carenderia</td><td><?=val($totals,'ind32')?></td></tr>
<tr><td class="ind">Total number of bakeries</td><td><?=val($totals,'ind33')?></td></tr>
<tr><td class="ind">Total number of sari-sari stores</td><td><?=val($totals,'ind34')?></td></tr>
<tr><td class="ind">Number of health and nutrition workers:</td><td></td></tr>
<tr class="indent"><td class="ind">Barangay Nutrition Scholar</td><td><?=val($totals,'ind35a')?></td></tr>
<tr class="indent"><td class="ind">Barangay Health Worker</td><td><?=val($totals,'ind35b')?></td></tr>
<tr><td class="ind">Total number of households beneficiaries of Pantawid Pamilyang Pilipino</td><td><?=val($totals,'ind36')?></td></tr>
</tbody>
</table>
</div>
</body>
</html>
