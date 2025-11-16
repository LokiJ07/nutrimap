<?php
require_once('../vendor/autoload.php'); // TCPDF

$reportHTML = $_POST['report_html'];

// TCPDF setup
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

// Remove large margins from TCPDF default header
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Render your HTML
$pdf->writeHTML($reportHTML, true, false, true, false, '');

// Output
$pdf->Output('barangay_report.pdf', 'I');
