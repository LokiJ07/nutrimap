<?php
session_start();
require '../db/config.php';

// ✅ Require login
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

// Fetch consolidated reports per barangay (SUM all numeric fields)
try {
    // List of all numeric fields
    $fields_no_pct = [
        'ind1','ind2','ind3','ind4a','ind4b','ind5','ind6','ind7a',
        'ind8','ind9','ind10','ind11','ind12','ind13','ind14',
        'ind16','ind17','ind18','ind19','ind21','ind22','ind23','ind24','ind25','ind31','ind32','ind33','ind34','ind36'
    ];

    $fields_7b = ['ind7b1','ind7b2','ind7b3','ind7b4','ind7b5','ind7b6','ind7b7','ind7b8','ind7b9'];
    $fields_15 = ['ind15a','ind15b'];
    $fields_20 = ['ind20a','ind20b','ind20c','ind20d','ind20e'];
    $fields_26 = ['ind26a','ind26b','ind26c','ind26d'];
    $fields_27 = ['ind27a','ind27b','ind27c','ind27d'];
    $fields_28 = ['ind28a','ind28b','ind28c','ind28d','ind28e'];
    $fields_29 = ['ind29a','ind29b','ind29c','ind29d','ind29e'];
    $fields_30 = ['ind30a','ind30b','ind30c','ind30d','ind30e'];
    $fields_35 = ['ind35a','ind35b'];

    $select_parts = [];
    foreach($fields_no_pct as $f){
        $select_parts[] = "SUM(bns.$f) as $f";
    }
    // Subfields: each has _no and _pct
    foreach($fields_7b as $f){
        $select_parts[] = "SUM(bns.{$f}_no) as {$f}_no";
        $select_parts[] = "SUM(bns.{$f}_pct) as {$f}_pct";
    }
    foreach($fields_15 as $f){
        $select_parts[] = "SUM(bns.{$f}_public) as {$f}_public";
        $select_parts[] = "SUM(bns.{$f}_private) as {$f}_private";
    }
    foreach($fields_20 as $f){
        $select_parts[] = "SUM(bns.{$f}_no) as {$f}_no";
        $select_parts[] = "SUM(bns.{$f}_pct) as {$f}_pct";
    }
    foreach($fields_26 as $f){
        $select_parts[] = "SUM(bns.{$f}_no) as {$f}_no";
        $select_parts[] = "SUM(bns.{$f}_pct) as {$f}_pct";
    }
    foreach($fields_27 as $f){
        $select_parts[] = "SUM(bns.{$f}_no) as {$f}_no";
        $select_parts[] = "SUM(bns.{$f}_pct) as {$f}_pct";
    }
    foreach($fields_28 as $f){
        $select_parts[] = "SUM(bns.{$f}_no) as {$f}_no";
        $select_parts[] = "SUM(bns.{$f}_pct) as {$f}_pct";
    }
    foreach($fields_29 as $f){
        $select_parts[] = "SUM(bns.{$f}_no) as {$f}_no";
        $select_parts[] = "SUM(bns.{$f}_pct) as {$f}_pct";
    }
    foreach($fields_30 as $f){
        $select_parts[] = "SUM(bns.{$f}_no) as {$f}_no";
        $select_parts[] = "SUM(bns.{$f}_pct) as {$f}_pct";
    }
    foreach($fields_35 as $f){
        $select_parts[] = "SUM(bns.$f) as $f";
    }

    $sql = "
        SELECT bns.barangay, " . implode(", ", $select_parts) . "
        FROM bns_reports bns
        JOIN reports r ON bns.report_id = r.id
        WHERE r.status = 'approved'
        GROUP BY bns.barangay
        ORDER BY bns.barangay ASC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error fetching consolidated reports: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Consolidated Reports — CNO NutriMap</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body { margin:0; font-family: Arial, sans-serif; background:#f5f5f5; font-size:13px; }
.layout { display:flex; flex-direction:column; min-height:100vh; }
.body-layout { display:flex; flex:1; }
.content { flex:1; padding:15px; overflow-y:auto; position:relative; }
button, .btn { padding:6px 14px; border:none; border-radius:4px; font-size:13px; cursor:pointer; }
.back-btn { background:#ff5722; color:#fff; font-weight:bold; position:absolute; top:15px; right:15px; }
.report-wrapper { background:#fff; padding:20px; border-radius:6px; max-width:1400px; margin:auto; box-shadow:0 2px 8px rgba(0,0,0,0.1); margin-bottom:30px;}
table { width:100%; border-collapse:collapse; margin-bottom:10px; }
th, td { border:1px solid #ddd; padding:6px 8px; vertical-align:top; font-size:13px; }
.indent { padding-left:20px; }
.reports-label { font-size:18px; font-weight:bold; margin-bottom:15px; }
</style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="layout">
  <div class="body-layout">
    <main class="content">
      <a href="home.php" class="btn back-btn">Back</a>

      <?php foreach($reports as $report): ?>
      <div class="report-wrapper">
        <div class="reports-label"><?= htmlspecialchars($report['barangay']) ?> - Consolidated Report</div>

        <table>
          <tr><th>Indicator</th><th>Number</th><th>%</th></tr>

          <tr><td>1. Total Population</td><td><?= $report['ind1'] ?></td><td>-</td></tr>
          <tr><td>2. Number of households</td><td><?= $report['ind2'] ?></td><td>-</td></tr>
          <tr><td>3. Total number of families</td><td><?= $report['ind3'] ?></td><td>-</td></tr>
          <tr><td>4. Total number of women who are:</td><td colspan="2"></td></tr>
          <tr><td class="indent">a. Pregnant</td><td><?= $report['ind4a'] ?></td><td>-</td></tr>
          <tr><td class="indent">b. Lactating</td><td><?= $report['ind4b'] ?></td><td>-</td></tr>
          <tr><td>5. Total number of households with preschool children 0-59 months</td><td><?= $report['ind5'] ?></td><td>-</td></tr>
          <tr><td>6. Actual population of preschool children 0-59 months</td><td><?= $report['ind6'] ?></td><td>-</td></tr>
          <tr><td>7. Total number of preschool children 0-50 months old measured during OPT Plus</td><td colspan="2"></td></tr>
          <tr><td class="indent">7a. Percent (%) measured coverage (OPT Plus)</td><td><?= $report['ind7a'] ?></td><td>-</td></tr>
          <tr><td class="indent">7b. Number and percent (%) of preschool children according to Nutritional Status</td><td colspan="2"></td></tr>

          <?php
          $nutri_labels = ['1) Severely underweight','2) Underweight','3) Normal weight','4) Severely wasted','5) Wasted','6) Overweight','7) Obese','8) Severely stunted','9) Stunted'];
          foreach($nutri_labels as $i=>$label){
              $n=$i+1;
              echo "<tr><td class='indent'>$label</td><td>{$report["ind7b{$n}_no"]}</td><td>{$report["ind7b{$n}_pct"]}</td></tr>";
          }
          ?>

          <tr><td>8. Infants 0-5 months old</td><td><?= $report['ind8'] ?></td><td>-</td></tr>
          <tr><td>9. Infants 6-11 months old</td><td><?= $report['ind9'] ?></td><td>-</td></tr>
          <tr><td>10. Preschool children 0-23 months old</td><td><?= $report['ind10'] ?></td><td>-</td></tr>
          <tr><td>11. Preschool children 12-59 months old</td><td><?= $report['ind11'] ?></td><td>-</td></tr>
          <tr><td>12. Preschool children 24-59 months old</td><td><?= $report['ind12'] ?></td><td>-</td></tr>
          <tr><td>13. Families with wasted and severely wasted preschool children</td><td><?= $report['ind13'] ?></td><td>-</td></tr>
          <tr><td>14. Families with stunted and severely stunted preschool children</td><td><?= $report['ind14'] ?></td><td>-</td></tr>

          <tr><td>15. Educational Institutions</td><td colspan="2"></td></tr>
          <?php
          $edu_labels=['a) Number of Day Care Centers','b) Number of Elementary Schools'];
          foreach(['a','b'] as $i=>$letter){
              echo "<tr><td class='indent'>{$edu_labels[$i]}</td><td>{$report["ind15{$letter}_public"]}</td><td>{$report["ind15{$letter}_private"]}</td></tr>";
          }
          ?>

          <tr><td>16. Children enrolled in Kindergarten</td><td><?= $report['ind16'] ?></td><td>-</td></tr>
          <tr><td>17. School children (grades 1-6)</td><td><?= $report['ind17'] ?></td><td>-</td></tr>
          <tr><td>18. School children weighed at start of school year</td><td><?= $report['ind18'] ?></td><td>-</td></tr>
          <tr><td>19. Percentage (%) coverage of school children measured</td><td><?= $report['ind19'] ?></td><td>-</td></tr>

          <tr><td>20. Number and percent (%) of school children according to Nutritional Status</td><td colspan="2"></td></tr>
          <?php
          $school_labels=['a) Severely Wasted','b) Wasted','c) Normal','d) Overweight','e) Obese'];
          foreach(['a','b','c','d','e'] as $i=>$letter){
              echo "<tr><td class='indent'>{$school_labels[$i]}</td><td>{$report["ind20{$letter}_no"]}</td><td>{$report["ind20{$letter}_pct"]}</td></tr>";
          }
          ?>

          <!-- Indicators 21–36 -->
          <?php
          $indicator_labels = [
              21=>"0-5 months old children exclusively breastfed",
              22=>"Infants given complementary foods (6 months+)",
              23=>"Households with wasted school children",
              24=>"School children dewormed",
              25=>"Fully immunized children",
              26=>"Households, by type of toilet facility",
              27=>"Households, by type of garbage disposal",
              28=>"Household, by type of water source",
              29=>"Household with",
              30=>"Households according to type of dwelling unit",
              31=>"Total number of households using iodized salt",
              32=>"Total number of eateries/carenderia",
              33=>"Total number of bakeries",
              34=>"Total number of sari-sari stores",
              35=>"Number of health and nutrition workers:",
              36=>"Total number of households beneficiaries of Pantawid Pamilyang Pilipino"
          ];

          for($i=21;$i<=36;$i++){
              if(in_array($i,[26,27,28,29,30,35])) continue; // subfields handled separately
              echo "<tr><td>{$indicator_labels[$i]}</td><td>{$report["ind$i"]}</td><td>-</td></tr>";
          }

          // Subfields 26–30
          $subfields26=['a','b','c','d']; $subfields26_labels=['Water-sealed toilet','Antipolo (Unsanitary Toilet)','Open Pit/Shared','No Toilet'];
          foreach($subfields26 as $i=>$l){
              echo "<tr><td class='indent'>{$subfields26_labels[$i]}</td><td>{$report["ind26{$l}_no"]}</td><td>{$report["ind26{$l}_pct"]}</td></tr>";
          }

          $subfields27=['a','b','c','d']; $subfields27_labels=['Barangay/City garbage collection','Own compose pit','Burning','Dumping'];
          foreach($subfields27 as $i=>$l){
              echo "<tr><td class='indent'>{$subfields27_labels[$i]}</td><td>{$report["ind27{$l}_no"]}</td><td>{$report["ind27{$l}_pct"]}</td></tr>";
          }

          $subfields28=['a','b','c','d','e']; $subfields28_labels=['Pipe water system','Well – Level II','Deep well with topstand communal source water system (Level II)','Mineral water/water dispensing stores','Open shallow dug well (Level I)'];
          foreach($subfields28 as $i=>$l){
              echo "<tr><td class='indent'>{$subfields28_labels[$i]}</td><td>{$report["ind28{$l}_no"]}</td><td>{$report["ind28{$l}_pct"]}</td></tr>";
          }

          $subfields29=['a','b','c','d','e']; $subfields29_labels=['Vegetable garden','Livestock/poultry','Combination vegetable garden & livestock/poultry','Fishponds','No garden'];
          foreach($subfields29 as $i=>$l){
              echo "<tr><td class='indent'>{$subfields29_labels[$i]}</td><td>{$report["ind29{$l}_no"]}</td><td>{$report["ind29{$l}_pct"]}</td></tr>";
          }

          $subfields30=['a','b','c','d','e']; $subfields30_labels=['Concrete','Semi concrete','Wooden house','Nipa bamboo house','Barong-barong makeshift'];
          foreach($subfields30 as $i=>$l){
              echo "<tr><td class='indent'>{$subfields30_labels[$i]}</td><td>{$report["ind30{$l}_no"]}</td><td>{$report["ind30{$l}_pct"]}</td></tr>";
          }

          // Indicator 35
          $subfields35=['a','b']; $subfields35_labels=['Barangay Nutrition Scholar','Barangay Health Worker'];
          foreach($subfields35 as $i=>$l){
              echo "<tr><td class='indent'>{$subfields35_labels[$i]}</td><td>{$report["ind35{$l}"]}</td><td>-</td></tr>";
          }

          ?>
        </table>
      </div>
      <?php endforeach; ?>
    </main>
  </div>
</div>
</body>
</html>
