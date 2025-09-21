<?php
header('Content-Type: application/json');
require '../db/config.php'; // adjust if your db_connect.php is in another folder

// 1. Load base GeoJSON (same directory)
$geojsonPath = __DIR__ . '/barangay_boundary.geojson';
if (!file_exists($geojsonPath)) {
    http_response_code(500);
    echo json_encode(["error" => "GeoJSON not found"]);
    exit;
}
$geojson = json_decode(file_get_contents($geojsonPath), true);

// 2. Query approved reports
$sql = "SELECT b.barangay,
               b.ind7b1_pct, b.ind7b2_pct, b.ind7b3_pct,
               b.ind7b4_pct, b.ind7b5_pct, b.ind7b6_pct,
               b.ind7b7_pct, b.ind7b8_pct, b.ind7b9_pct
        FROM bns_reports b
        JOIN reports r ON b.report_id = r.id
        WHERE r.status = 'approved'";
$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Convert DB rows into lookup (uppercase barangay name)
$lookup = [];
foreach ($data as $row) {
    $lookup[strtoupper(trim($row['barangay']))] = $row;
}

// 4. Merge into GeoJSON
foreach ($geojson['features'] as &$feature) {
    $bName = strtoupper(trim($feature['properties']['BARANGAY']));

    if (isset($lookup[$bName])) {
        foreach ($lookup[$bName] as $key => $val) {
            if ($key !== 'barangay') {
                $feature['properties'][strtoupper($key)] = $val;
            }
        }
    } else {
        $feature['properties']['NO_APPROVED_DATA'] = true;
    }
}

// 5. Return updated GeoJSON
echo json_encode($geojson);
