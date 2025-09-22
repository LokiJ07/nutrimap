  <?php
  session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

  require '../db/config.php';
  // ✅ Require login
  if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'BNS') {
    header("Location: ../login.php");
    exit();
}

  $barangay = $_SESSION['barangay']; // auto-fill from session
  $year = date('Y'); // default year
  $user_id = $_SESSION['user_id'];

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $title = trim($_POST['title']); // report title from form
      $year = $_POST['year'] ?? $year; // optional year from form
      $barangay = $_POST['barangay'] ?? $barangay;

          if ($title === '') {
        die("Error: Title cannot be empty!");
    }
      try {
          // Start transaction to ensure both inserts succeed
          $pdo->beginTransaction();

          // 1️⃣ Insert into reports table
          $stmt = $pdo->prepare("
              INSERT INTO reports (user_id, report_time, report_date)
              VALUES (:user_id, :report_time, :report_date)
          ");
          $stmt->execute([
              ':user_id' => $user_id,
              ':report_time' => date('H:i:s'),
              ':report_date' => date('Y-m-d')
          ]);
          // Get the inserted report ID
          $report_id = $pdo->lastInsertId();

          // 2️⃣ Prepare data for bns_reports
          $fields = [
              'report_id', 'barangay', 'year', 'title',
              'ind1','ind2','ind3','ind4a','ind4b','ind5','ind6','ind7a',
              'ind7b1_no','ind7b1_pct','ind7b2_no','ind7b2_pct','ind7b3_no','ind7b3_pct',
              'ind7b4_no','ind7b4_pct','ind7b5_no','ind7b5_pct','ind7b6_no','ind7b6_pct',
              'ind7b7_no','ind7b7_pct','ind7b8_no','ind7b8_pct','ind7b9_no','ind7b9_pct',
              'ind8','ind9','ind10','ind11','ind12','ind13','ind14',
              'ind15a_public','ind15a_private','ind15b_public','ind15b_private',
              'ind16','ind17','ind18','ind19',
              'ind20a_no','ind20a_pct','ind20b_no','ind20b_pct','ind20c_no','ind20c_pct',
              'ind20d_no','ind20d_pct','ind20e_no','ind20e_pct',
              'ind21','ind22','ind23','ind24','ind25',
              'ind26a_no','ind26a_pct','ind26b_no','ind26b_pct','ind26c_no','ind26c_pct','ind26d_no','ind26d_pct',
              'ind27a_no','ind27a_pct','ind27b_no','ind27b_pct','ind27c_no','ind27c_pct','ind27d_no','ind27d_pct',
              'ind28a_no','ind28a_pct','ind28b_no','ind28b_pct','ind28c_no','ind28c_pct','ind28d_no','ind28d_pct','ind28e_no','ind28e_pct',
              'ind29a_no','ind29a_pct','ind29b_no','ind29b_pct','ind29c_no','ind29c_pct','ind29d_no','ind29d_pct','ind29e_no','ind29e_pct',
              'ind30a_no','ind30a_pct','ind30b_no','ind30b_pct','ind30c_no','ind30c_pct','ind30d_no','ind30d_pct','ind30e_no','ind30e_pct',
              'ind31','ind32','ind33','ind34',
              'ind35a','ind35b',
              'ind36'
          ];

          $placeholders = [];
          $params = [];

          foreach ($fields as $f) {
              $placeholders[] = ':' . $f;

              // report_id is from $report_id, others from POST
              if ($f === 'report_id') {
                  $params[':' . $f] = $report_id;
} elseif ($f === 'barangay') {
    $params[':' . $f] = $barangay;
} elseif ($f === 'year') {
    $params[':' . $f] = $year;
} elseif ($f === 'title') {
    $params[':' . $f] = $title;
}
 else {
                  $params[':' . $f] = $_POST[$f] ?? null;
              }
          }

          // Prepare and execute insert
          $sql = "INSERT INTO bns_reports (" . implode(',', $fields) . ") 
                  VALUES (" . implode(',', $placeholders) . ")";
          $stmt2 = $pdo->prepare($sql);
          $stmt2->execute($params);

          // Commit transaction
          $pdo->commit();

          // ✅ Redirect with success message
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
  body { margin:0; font-family: Arial, sans-serif; background:#f5f5f5; font-size:13px; }
  .layout { display:flex; flex-direction:column; min-height:100vh; }
  .body-layout { display:flex; flex:1; }
  .content { flex:1; padding:15px; overflow-y:auto; position:relative; }
  button, .btn { padding:6px 14px; border:none; border-radius:4px; font-size:13px; cursor:pointer; }
  .submit-btn { background:#009688; color:#fff; }
  .back-btn { background:#ff5722; color:#fff; font-weight:bold; position:absolute; top:15px; right:15px; }
  .form-wrapper { background:#fff; padding:20px; border-radius:6px; max-width:900px; margin:auto; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
  .form-section { margin-bottom:40px; }
  .form-section h3 { text-align:center; margin-bottom:20px; }
  table { width:100%; border-collapse:collapse; margin-bottom:20px; }
  th, td { border:1px solid #ddd; padding:6px 8px; vertical-align:top; }
  input[type="text"], input[type="number"] { width:100%; padding:4px; font-size:13px; box-sizing:border-box; }
  .success { background:#d4edda; color:#155724; padding:10px; border-radius:4px; margin-bottom:15px; text-align:center; }
  .indent { padding-left:20px; }
  .nested-table { width:100%; border:none; border-collapse:collapse; }
  .nested-table td { border:none; padding:2px 4px; }
  .form-bottom { display:flex; justify-content:flex-end; margin-top:20px; }
  .reports-label { font-size:22px; font-weight:bold; margin-bottom:15px; text-align:left; }

  </style>
  </head>
  <body>
     <?php include 'header.php'; ?>
    <div class="layout">
     
      <div class="body-layout">
        <main class="content">
          <a href="reports.php" class="btn back-btn">Back</a>

<div class="reports-label" style="display:flex; align-items:center; gap:10px;">
    <div style="font-weight:bold; font-size:22px;">Reports</div>
    <div style="display:flex; align-items:center; gap:5px;">
        <label for="report-title" style="font-size:14px; font-weight:normal;">Title:</label>
        <input type="text" id="report-title" name="title" placeholder="Enter report title"
              style="padding:4px 6px; font-size:14px; height:28px; width:250px;">
    </div>
</div>

          <?php if (!empty($success)): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
          <?php endif; ?>


    <div class="form-wrapper">

  <form method="post" onsubmit="copyTitle()">
    <input type="hidden" id="hidden-title" name="title">

    <form method="post"><div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">

      <!-- Left: Titles -->
      <div style="text-align:left;">
        <h2 style="margin:0; font-size:15px;">BNS Form No. IC</h2>
        <h3 style="margin:0; font-size:15px;">Barangay Nutrition Profile</h3>
      </div>

      <!-- Right: Logos -->
      <div style="display:flex; align-items:center; gap:15px;">
        <!-- Dynamic Barangay Logo -->
        <img src="../logos/barangays/<?= strtolower(str_replace(' ', '_', $barangay)) ?>.png" 
            alt="<?= htmlspecialchars($barangay) ?> Logo" 
            style="height:100px;">

        <!-- Fixed Logos -->
        <img src="../logos/fixed/Seal_of_El_Salvador__Misamis_Oriental-removebg-preview.png" alt="Logo 1" style="height:100px;">
        <img src="../logos/fixed/National_Nutrition_Council__NNC_.svg-removebg-preview.png" alt="Logo 2" style="height:100px;">
        <img src="../logos/fixed/Bagong-Pilipinas-logo.png" alt="Logo 3" style="height:100px;">
      </div>
    </div>

    <h3 style="text-align:center; margin:0 0 15px 0;">BARANGAY SITUATIONAL ANALYSIS (BSA)</h3>
    <h3 style="text-align:center; margin:0;"  ><strong>Calendar Year</strong> 
      <input type="number" name="year" value="2025" style="width:80px;"> &nbsp;&nbsp;</h3>


    <div style="text-align:center; margin-bottom:20px; font-size:14px;">
      <strong>Barangay:</strong> 
      <input type="text" name="barangay" value="<?= htmlspecialchars($barangay) ?>" readonly style="width:200px;"> &nbsp;&nbsp;
      <strong>City/Municipality:</strong> EL SALVADOR CITY &nbsp;&nbsp;
      <strong>Province:</strong> MISAMIS ORIENTAL
    </div>


          <!-- Full Indicators Form -->
          <div class="form-section">
            <h3>Indicators</h3>
            <table>
              <tr><th>Indicator</th><th>Number</th></tr>

              <tr><td>1. Total Population</td><td><input type="number" name="ind1"></td></tr>
              <tr><td>2. Number of households</td><td><input type="number" name="ind2"></td></tr>
              <tr><td>3. Total number of families</td><td><input type="number" name="ind3"></td></tr>
              <tr><td>4. Total number of women who are:</td><td></td></tr>
              <tr><td class="indent">a. Pregnant</td><td><input type="number" name="ind4a"></td></tr>
              <tr><td class="indent">b. Lactating</td><td><input type="number" name="ind4b"></td></tr>

              <tr><td>5. Total number of households with preschool children 0-59 months</td><td><input type="number" name="ind5"></td></tr>
              <tr><td>6. Actual population of preschool children 0-59 months</td><td><input type="number" name="ind6"></td></tr>
              <tr><td>7. Total number of preschool children 0-50 months old measured during OPT Plus</td><td></td></tr>
              <tr><td>7a. Percent (%) measured coverage (OPT Plus)</td><td><input type="number" step="0.01" name="ind7a"></td></tr>
  <tr>
    <td>7b. Number and percent (%) of preschool children according to Nutritional Status</td>
    <td style="display:flex; gap:10px; font-weight:bold;">
      <span style="flex:1; text-align:center;">No.</span>
      <span style="flex:1; text-align:center;">%</span>
    </td>
  </tr>

  <?php
  $nutri = [
      '1) Severely underweight',
      '2) Underweight',
      '3) Normal weight',
      '4) Severely wasted',
      '5) Wasted',
      '6) Overweight',
      '7) Obese',
      '8) Severely stunted',
      '9) Stunted'
  ];

  foreach($nutri as $i => $name) {
      $n = $i + 1;
      echo "<tr>
              <td style='width:60%;'>$name</td>
              <td style='display:flex; gap:10px;'>
                  <input type='number' name='ind7b{$n}_no' placeholder='No' style='flex:1;'>
                  <input type='number' step='0.01' name='ind7b{$n}_pct' placeholder='%' style='flex:1;'>
              </td>
            </tr>";
  }
  ?>

  <!-- All other table rows remain unchanged -->
              <tr><td>8. Infants 0-5 months old</td><td><input type="number" name="ind8"></td></tr>
              <tr><td>9. Infants 6-11 months old</td><td><input type="number" name="ind9"></td></tr>
              <tr><td>10. Preschool children 0-23 months old</td><td><input type="number" name="ind10"></td></tr>
              <tr><td>11. Preschool children 12-59 months old</td><td><input type="number" name="ind11"></td></tr>
              <tr><td>12. Preschool children 24-59 months old</td><td><input type="number" name="ind12"></td></tr>

              <tr><td>13. Families with wasted and severely wasted preschool children</td><td><input type="number" name="ind13"></td></tr>
              <tr><td>14. Families with stunted and severely stunted preschool children</td><td><input type="number" name="ind14"></td></tr>

  <tr>
    <td>15. Educational Institutions</td>
    <td style="display:flex; gap:10px; font-weight:bold;">
      <span style="flex:1; text-align:center;">Public</span>
      <span style="flex:1; text-align:center;">Private</span>
    </td>
  <?php
  $edu = [
      'a) Number of Day Care Centers',
      'b) Number of Elementary Schools'
  ];

  foreach($edu as $i => $name) {
      $n = chr(97 + $i); // a, b
      echo "<tr>
              <td style='width:60%;'>$name</td>
              <td style='display:flex; gap:10px;'>
                  <input type='number' name='ind15{$n}_public' placeholder='Public' style='flex:1; text-align:center;'>
                  <input type='number' name='ind15{$n}_private' placeholder='Private' style='flex:1; text-align:center;'>
              </td>
            </tr>";
  }
  ?>

              <tr><td>16. Children enrolled in Kindergarten</td><td><input type="number" name="ind16"></td></tr>
              <tr><td>17. School children (grades 1-6)</td><td><input type="number" name="ind17"></td></tr>
              <tr><td>18. School children weighed at start of school year</td><td><input type="number" name="ind18"></td></tr>
              <tr><td>19. Percentage (%) coverage of school children measured</td><td><input type="number" step="0.01" name="ind19"></td></tr>
  <tr>
    <td>20. Number and percent (%) of school children according to Nutritional Status</td>
    <td style="display:flex; gap:10px; font-weight:bold;">
      <span style="flex:1; text-align:center;">No.</span>
      <span style="flex:1; text-align:center;">%</span>
    </td>
  </tr>
  <?php
  $school = [
      'a) Severely Wasted',
      'b) Wasted',
      'c) Normal',
      'd) Overweight',
      'e) Obese'
  ];

  foreach($school as $i => $name) {
      $n = chr(97 + $i); 
      echo "<tr>
              <td style='width:60%;'>$name</td>
              <td style='display:flex; gap:10px;'>
                  <input type='number' name='ind20{$n}_no' placeholder='No' style='flex:1;'>
                  <input type='number' step='0.01' name='ind20{$n}_pct' placeholder='%' style='flex:1;'>
              </td>
            </tr>";
  }
  ?>


              <tr><td>21. 0-5 months old children exclusively breastfed</td><td><input type="number" name="ind21"></td></tr>
              <tr><td>22. Infants given complementary foods (6 months+)</td><td><input type="number" name="ind22"></td></tr>
              <tr><td>23. Households with wasted school children</td><td><input type="number" name="ind23"></td></tr>
              <tr><td>24. School children dewormed</td><td><input type="number" name="ind24"></td></tr>
              <tr><td>25. Fully immunized children</td><td><input type="number" name="ind25"></td></tr>
  <tr>
    <td>26. Households, by type of toilet facility</td>
    <td style="display:flex; gap:10px; font-weight:bold;">
      <span style="flex:1; text-align:center;">No.</span>
      <span style="flex:1; text-align:center;">%</span>
    </td>
  </tr><?php
  $toilet = [
      'a) Water-sealed toilet',
      'b) Antipolo (Unsanitary Toilet)',
      'c) Open Pit/Shared',
      'd) No Toilet'
  ];

  foreach($toilet as $i => $name) {
      $n = chr(97 + $i); 
      echo "<tr>
              <td style='width:60%;'>$name</td>
              <td style='display:flex; gap:10px;'>
                  <input type='number' name='ind26{$n}_no' placeholder='No' style='flex:1;'>
                  <input type='number' step='0.01' name='ind26{$n}_pct' placeholder='%' style='flex:1;'>
              </td>
            </tr>";
  }
  ?>
  <tr>
    <td>27. Households, by type of garbage disposal</td>
    <td style="display:flex; gap:10px; font-weight:bold;">
      <span style="flex:1; text-align:center;">No.</span>
      <span style="flex:1; text-align:center;">%</span>
    </td>
  </tr>
  <?php
  $garbage_types = [
      'a) Barangay/City garbage collection',
      'b) Own compose pit',
      'c) Burning',
      'd) Dumping'
  ];

  foreach($garbage_types as $i => $name) {
      $n = chr(97 + $i);
      echo "<tr>
              <td style='width:60%;'>$name</td>
              <td style='display:flex; gap:10px;'>
                  <input type='number' name='ind27{$n}_no' placeholder='No' style='flex:1;'>
                  <input type='number' step='0.01' name='ind27{$n}_pct' placeholder='%' style='flex:1;'>
              </td>
            </tr>";
  }
  ?>

  <tr>
    <td>28. Household, by type of water source</td>
    <td style="display:flex; gap:10px; font-weight:bold;">
      <span style="flex:1; text-align:center;">No.</span>
      <span style="flex:1; text-align:center;">%</span>
    </td>
  </tr>
              <?php
  $water_sources = [
      'a) Pipe water system',
      'b) Well – Level II',
      'c) Deep well with topstand communal source water system (Level II)',
      'd) Mineral water/water dispensing stores',
      'e) Open shallow dug well (Level I)'
  ];

  foreach($water_sources as $i => $name) {
      $n = chr(97 + $i); 
      echo "<tr>
              <td style='width:60%;'>$name</td>
              <td style='display:flex; gap:10px;'>
                  <input type='number' name='ind28{$n}_no' placeholder='No' style='flex:1;'>
                  <input type='number' step='0.01' name='ind28{$n}_pct' placeholder='%' style='flex:1;'>
              </td>
            </tr>";
  }
  ?>

  <tr>
    <td>29. Household with</td>
    <td style="display:flex; gap:10px; font-weight:bold;">
      <span style="flex:1; text-align:center;">No.</span>
      <span style="flex:1; text-align:center;">%</span>
    </td>
  </tr>
  <?php
  $household_items = [
      'a) Vegetable garden',
      'b) Livestock/poultry',
      'c) Combination vegetable garden & livestock/poultry',
      'd) Fishponds',
      'e) No garden'
  ];
  foreach($household_items as $i => $name) {
      $n = chr(97 + $i);
      echo "<tr>
              <td style='width:60%;'>$name</td>
              <td style='display:flex; gap:10px;'>
                  <input type='number' name='ind29{$n}_no' placeholder='No' style='flex:1;'>
                  <input type='number' step='0.01' name='ind29{$n}_pct' placeholder='%' style='flex:1;'>
              </td>
            </tr>";
  }
  ?>

  <tr>
    <td>30. Households according to type of dwelling unit:</td>
    <td style="display:flex; gap:10px; font-weight:bold;">
      <span style="flex:1; text-align:center;">No.</span>
      <span style="flex:1; text-align:center;">%</span>
    </td>
  <?php
  $dwelling_types = [
      'a) Concrete',
      'b) Semi concrete',
      'c) Wooden house',
      'd) Nipa bamboo house',
      'e) Barong-barong makeshift'
  ];
  foreach($dwelling_types as $i => $name) {
      $n = chr(97 + $i);
      echo "<tr>
              <td style='width:60%;'>$name</td>
              <td style='display:flex; gap:10px;'>
                  <input type='number' name='ind30{$n}_no' placeholder='No' style='flex:1;'>
                  <input type='number' step='0.01' name='ind30{$n}_pct' placeholder='%' style='flex:1;'>
              </td>
            </tr>";
  }
  ?>

  <tr><td>31. Total number of households using iodized salt</td><td><input type="number" name="ind31"></td></tr>
  <tr><td>32. Total number of eateries/carenderia</td><td><input type="number" name="ind32"></td></tr>
  <tr><td>33. Total number of bakeries</td><td><input type="number" name="ind33"></td></tr>
  <tr><td>34. Total number of sari-sari stores</td><td><input type="number" name="ind34"></td></tr>


  <tr><td>35. Number of health and nutrition workers:</td><td></td></tr>
  <?php
  $health_workers = [
      'a) Barangay Nutrition Scholar',
      'b) Barangay Health Worker'
  ];
  foreach($health_workers as $i => $name) {
      $n = chr(97 + $i);
      echo "<tr>
              <td style='width:60%;'>$name</td>
              <td style='display:flex; gap:10px;'>
                  <input type='number' name='ind35{$n}' placeholder='No' style='flex:1;'>
              </td>
            </tr>";
  }
  ?>
  <tr><td>36. Total number of households beneficiaries of Pantawid Pamilyang Pilipino</td><td><input type="number" name="ind36"></td></tr>


            </table>
          </div>
      <!-- all your form fields here (unchanged) -->

      <div class="form-bottom">
        <button type="submit" class="submit-btn">Submit</button>
      </div>
    </form>
  </div>

  <script>
function copyTitle() {
    document.getElementById('hidden-title').value = 
        document.getElementById('report-title').value;
}
  </script>

        </main>
      </div>
    </div>
  </body>
  </html>
