<?php
header('Content-Type: application/json');
require '../db/config.php'; // adjust if needed

// 1. Load base GeoJSON
$geojsonPath = __DIR__ . '/barangay_boundary.geojson';
if (!file_exists($geojsonPath)) {
    http_response_code(500);
    echo json_encode(["error" => "GeoJSON not found"]);
    exit;
}
$geojson = json_decode(file_get_contents($geojsonPath), true);

// 2. Query all approved reports (including year)
$sql = "SELECT 
            b.barangay,
            b.year,
            b.ind7b1_pct, b.ind7b2_pct, b.ind7b3_pct,
            b.ind7b4_pct, b.ind7b5_pct, b.ind7b6_pct,
            b.ind7b7_pct, b.ind7b8_pct, b.ind7b9_pct
        FROM bns_reports b
        JOIN reports r ON b.report_id = r.id
        WHERE r.status = 'approved'";
$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Group data by barangay and year
$lookup = [];
foreach ($data as $row) {
    $b = strtoupper(trim($row['barangay']));
    $y = $row['year'];
    if (!isset($lookup[$b])) $lookup[$b] = [];
    $lookup[$b][$y] = $row;
}

// 4. Create new GeoJSON features — one per (barangay, year)
$newFeatures = [];
foreach ($geojson['features'] as $feature) {
    $bName = strtoupper(trim($feature['properties']['BARANGAY']));
    if (isset($lookup[$bName])) {
        foreach ($lookup[$bName] as $year => $vals) {
            $newFeature = $feature; // copy geometry
            foreach ($vals as $key => $val) {
                if ($key !== 'barangay') {
                    $newFeature['properties'][strtoupper($key)] = $val;
                }
            }
            $newFeature['properties']['YEAR'] = $year;
            $newFeatures[] = $newFeature;
        }
    } else {
        // Barangay with no approved data
        $feature['properties']['NO_APPROVED_DATA'] = true;
        $newFeatures[] = $feature;
    }
}

// 5. Replace original features
$geojson['features'] = $newFeatures;

// 6. Output
echo json_encode($geojson);
?>
