<?php
require '../db/config.php';
require_once('../vendor/autoload.php'); // TCPDF autoload

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request");
}

$reportId = intval($_GET['id']);

// ✅ Fetch report data
$stmt = $pdo->prepare("
    SELECT u.first_name, u.last_name, u.barangay, r.report_date, r.report_time,
           b.ind7b1_pct, b.ind7b2_pct, b.ind7b3_pct, b.ind7b4_pct, b.ind7b5_pct,
           b.ind7b6_pct, b.ind7b7_pct, b.ind7b8_pct, b.ind7b9_pct
    FROM reports r
    JOIN users u ON r.user_id = u.id
    JOIN bns_reports b ON r.id = b.report_id
    WHERE r.id = ?
");
$stmt->execute([$reportId]);
$report = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$report) {
    die("Report not found");
}

// ✅ Start TCPDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("CNO System");
$pdf->SetTitle("Health and Nutrition Report - " . $report['barangay']);
$pdf->SetMargins(15, 20, 15);
$pdf->AddPage();

// ✅ Header
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, "Health and Nutrition Report", 0, 1, 'C');
$pdf->Ln(5);

// ✅ Report Info
$pdf->SetFont('helvetica', '', 12);
$pdf->MultiCell(0, 6, "Barangay: " . $report['barangay'], 0, 'L');
$pdf->MultiCell(0, 6, "Reporter: " . $report['first_name'] . " " . $report['last_name'], 0, 'L');
$pdf->MultiCell(0, 6, "Date: " . $report['report_date'] . " " . $report['report_time'], 0, 'L');
$pdf->Ln(5);

// ✅ Indicators Table
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(90, 8, "Indicator", 1, 0, 'C');
$pdf->Cell(50, 8, "Percentage (%)", 1, 1, 'C');

$pdf->SetFont('helvetica', '', 12);

$indicators = [
    "Underweight Children 0-5 yrs" => $report['ind7b1_pct'],
    "Severely Underweight Children" => $report['ind7b2_pct'],
    "Overweight Children" => $report['ind7b3_pct'],
    "Wasted Children" => $report['ind7b4_pct'],
    "Severely Wasted Children" => $report['ind7b5_pct'],
    "Stunted Children" => $report['ind7b6_pct'],
    "Severely Stunted Children" => $report['ind7b7_pct'],
    "Normal Nutritional Status" => $report['ind7b8_pct'],
    "Overweight & Obese" => $report['ind7b9_pct'],
];

foreach ($indicators as $label => $value) {
    $pdf->Cell(90, 8, $label, 1, 0, 'L');
    $pdf->Cell(50, 8, $value . "%", 1, 1, 'C');
}

// ✅ Output
$pdf->Output("Report_" . $report['barangay'] . ".pdf", "I");
