<?php
header('Content-Type: application/json');
require '../db/config.php';

// 1. Load base GeoJSON
$geojsonPath = __DIR__ . '/barangay_boundary.geojson';
if (!file_exists($geojsonPath)) {
    http_response_code(500);
    echo json_encode(["error" => "GeoJSON not found"]);
    exit;
}
$geojson = json_decode(file_get_contents($geojsonPath), true);

// 2. Query - year from bns_reports, month from reports.report_date
// LPAD ensures month is always 2 digits (e.g. 01, 02) so period sorts correctly alphabetically
// AVG handles the edge case where a barangay has multiple rows for the same period
// NULL guards prevent broken period values from reaching the JS slider
$sql = "SELECT 
            b.barangay,
            b.year,
            MONTH(r.report_date) AS month_num,
            DATE_FORMAT(
                CONCAT(b.year, '-', LPAD(MONTH(r.report_date), 2, '0'), '-01'),
                '%Y-%m'
            ) AS period,
            AVG(b.ind9b1_pct) AS ind9b1_pct,
            AVG(b.ind9b2_pct) AS ind9b2_pct,
            AVG(b.ind9b3_pct) AS ind9b3_pct,
            AVG(b.ind9b4_pct) AS ind9b4_pct,
            AVG(b.ind9b5_pct) AS ind9b5_pct,
            AVG(b.ind9b6_pct) AS ind9b6_pct,
            AVG(b.ind9b7_pct) AS ind9b7_pct,
            AVG(b.ind9b8_pct) AS ind9b8_pct,
            AVG(b.ind9b9_pct) AS ind9b9_pct
        FROM bns_reports b
        JOIN reports r ON b.report_id = r.id
        WHERE r.status = 'approved'
          AND b.year IS NOT NULL
          AND r.report_date IS NOT NULL
        GROUP BY b.barangay, b.year, MONTH(r.report_date)
        ORDER BY b.year ASC, MONTH(r.report_date) ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Get all unique periods for slider
$allPeriods = [];
foreach ($data as $row) {
    $period = $row['period'];
    if ($period && !in_array($period, $allPeriods)) {
        $allPeriods[] = $period;
    }
}
sort($allPeriods);

// 4. Define merged indicators
// Each key is what JS will use; the value is the list of raw columns to sum
$mergedIndicators = [
    'UNDERWEIGHT'     => ['IND9B1_PCT', 'IND9B2_PCT'],
    'NORMAL'          => ['IND9B3_PCT'],
    'WASTED'          => ['IND9B4_PCT', 'IND9B5_PCT'],
    'OVERWEIGHT_OBESE'=> ['IND9B6_PCT', 'IND9B7_PCT'],
    'STUNTED'         => ['IND9B8_PCT', 'IND9B9_PCT']
];

// 5. Group data by barangay and period — one entry per (barangay, period)
$lookup = [];
foreach ($data as $row) {
    $b      = strtoupper(trim($row['barangay']));
    $period = $row['period'];
    $key    = $b . '|' . $period;

    // Convert all keys to uppercase for consistency
    $rowUpper = [];
    foreach ($row as $k => $v) {
        $rowUpper[strtoupper($k)] = $v;
    }

    // Compute merged indicator values by summing their component columns
    foreach ($mergedIndicators as $mergedKey => $fields) {
        $sum = 0;
        foreach ($fields as $f) {
            if (isset($rowUpper[$f]) && $rowUpper[$f] !== null) {
                $sum += floatval($rowUpper[$f]);
            }
        }
        $rowUpper[$mergedKey] = round($sum, 4);
    }

    $rowUpper['YEAR']      = $row['year'];
    $rowUpper['MONTH_NUM'] = $row['month_num'];
    $rowUpper['PERIOD']    = $period;

    // GROUP BY in SQL already ensures one row per (barangay, period)
    // so this assignment is safe and will not silently overwrite
    $lookup[$key] = $rowUpper;
}

// 6. Create new GeoJSON features — one per (barangay, period)
// Barangays with no approved data are included once with NO_APPROVED_DATA flag
$newFeatures = [];
foreach ($geojson['features'] as $feature) {
    $bName   = strtoupper(trim($feature['properties']['BARANGAY']));
    $hasData = false;

    foreach ($allPeriods as $period) {
        $key = $bName . '|' . $period;
        if (isset($lookup[$key])) {
            $hasData      = true;
            $newFeature   = $feature;
            $vals         = $lookup[$key];

            foreach ($vals as $propKey => $propVal) {
                // BARANGAY and PERIOD are already on the feature; skip to avoid override
                if ($propKey !== 'BARANGAY') {
                    $newFeature['properties'][$propKey] = $propVal;
                }
            }
            $newFeature['properties']['PERIOD'] = $period;
            $newFeatures[] = $newFeature;
        }
    }

    // Barangay exists in boundary file but has no approved data at all
    if (!$hasData) {
        $feature['properties']['NO_APPROVED_DATA'] = true;
        $newFeatures[] = $feature;
    }
}

// 7. Get min and max period for slider initialization
$minPeriod = !empty($allPeriods) ? $allPeriods[0]                        : null;
$maxPeriod = !empty($allPeriods) ? $allPeriods[count($allPeriods) - 1]   : null;

// 8. Output
echo json_encode([
    'type'       => 'FeatureCollection',
    'features'   => $newFeatures,
    'allPeriods' => $allPeriods,
    'minPeriod'  => $minPeriod,
    'maxPeriod'  => $maxPeriod
]);
?>