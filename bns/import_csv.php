<?php
// import_csv.php
if (isset($_FILES['csv_file'])) {
    $fileTmpPath = $_FILES['csv_file']['tmp_name'];
    $csvData = array_map('str_getcsv', file($fileTmpPath));

    // Remove empty rows
    $csvData = array_filter($csvData, fn($row) => array_filter($row));

    // Skip header rows (assume first 5 rows are headers)
    $dataRows = array_slice($csvData, 5);

    // Helper function to get numeric value
    function getValue($row) {
        foreach ($row as $cell) {
            if (is_numeric($cell)) return $cell;
        }
        return '';
    }

    // Flatten numeric values
    $values = [];
    foreach ($dataRows as $row) {
        $val = getValue($row);
        if ($val !== '') $values[] = $val;
    }

    // Map CSV values to input names
    $inputMapping = [
        'ind1','ind2','ind3','ind4a','ind4b','ind5','ind6','ind7','ind7a',
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

    // Return JavaScript to fill the form
    echo "<script>\n";
    foreach ($inputMapping as $index => $inputName) {
        $value = $values[$index] ?? '';
        echo "let el = document.querySelector('[name=\"$inputName\"]'); if(el) el.value = '$value';\n";
    }
    echo "</script>";
}
?>
