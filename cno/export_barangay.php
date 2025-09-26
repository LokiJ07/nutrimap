<?php
require '../db/config.php';
require_once('../vendor/autoload.php'); // TCPDF autoload

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid request");

$reportId = intval($_GET['id']);

$stmt = $pdo->prepare("
    SELECT r.*, b.*
    FROM reports r
    LEFT JOIN bns_reports b ON r.id = b.report_id
    WHERE r.id = ?
");
$stmt->execute([$reportId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) die("Report not found");

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("CNO System");
$pdf->SetTitle("BNS Report - " . $row['barangay']);
$pdf->SetMargins(15, 20, 15);
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, "Barangay Nutrition Status Report", 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('helvetica', '', 12);

function val($arr,$k,$fmt=null){
    if(!isset($arr[$k]) || $arr[$k]===null || $arr[$k]==='') return '—';
    $v = $arr[$k];
    if($fmt==='int') return (int)$v;
    if($fmt==='pct') return number_format((float)$v,2).'%';
    if($fmt==='dec2') return number_format((float)$v,2);
    return htmlspecialchars($v);
}

$pdf->SetFont('helvetica','B',12);
$pdf->Cell(130,8,'Indicator',1,0,'L');
$pdf->Cell(50,8,'Number / %',1,1,'C');
$pdf->SetFont('helvetica','',12);

$indicators = [
    ['label'=>'1. Total Population','key'=>'ind1','pct'=>false],
    ['label'=>'2. Number of households','key'=>'ind2','pct'=>false],
    ['label'=>'3. Total number of families','key'=>'ind3','pct'=>false],
    ['label'=>'4a. Pregnant','key'=>'ind4a','pct'=>false],
    ['label'=>'4b. Lactating','key'=>'ind4b','pct'=>false],
    ['label'=>'5. Households with preschool children','key'=>'ind5','pct'=>false],
    ['label'=>'6. Actual population of preschool children (0-59 months)','key'=>'ind6','pct'=>false],
    ['label'=>'7a. % measured coverage (OPT Plus)','key'=>'ind7a','pct'=>false],
    // 7b Nutritional Status
    ['label'=>'7b1. Severely underweight','key'=>'ind7b1_no','sub'=>'ind7b1_pct','pct'=>true],
    ['label'=>'7b2. Underweight','key'=>'ind7b2_no','sub'=>'ind7b2_pct','pct'=>true],
    ['label'=>'7b3. Overweight','key'=>'ind7b3_no','sub'=>'ind7b3_pct','pct'=>true],
    ['label'=>'7b4. Wasted','key'=>'ind7b4_no','sub'=>'ind7b4_pct','pct'=>true],
    ['label'=>'7b5. Severely Wasted','key'=>'ind7b5_no','sub'=>'ind7b5_pct','pct'=>true],
    ['label'=>'7b6. Stunted','key'=>'ind7b6_no','sub'=>'ind7b6_pct','pct'=>true],
    ['label'=>'7b7. Severely Stunted','key'=>'ind7b7_no','sub'=>'ind7b7_pct','pct'=>true],
    ['label'=>'7b8. Normal Nutritional Status','key'=>'ind7b8_no','sub'=>'ind7b8_pct','pct'=>true],
    ['label'=>'7b9. Obese','key'=>'ind7b9_no','sub'=>'ind7b9_pct','pct'=>true],
    ['label'=>'8. Infants 0-5 months old','key'=>'ind8','pct'=>false],
    ['label'=>'9. Infants 6-11 months old','key'=>'ind9','pct'=>false],
    ['label'=>'10. Preschool children 0-23 months old','key'=>'ind10','pct'=>false],
    ['label'=>'11. Preschool children 12-59 months old','key'=>'ind11','pct'=>false],
    ['label'=>'12. Preschool children 24-59 months old','key'=>'ind12','pct'=>false],
    ['label'=>'13. Families with wasted/severely wasted preschool children','key'=>'ind13','pct'=>false],
    ['label'=>'14. Families with stunted/severely stunted preschool children','key'=>'ind14','pct'=>false],
    ['label'=>'15a. Day Care Centers (Public/Private)','keys'=>['ind15a_public','ind15a_private'],'pct'=>false],
    ['label'=>'15b. Elementary Schools (Public/Private)','keys'=>['ind15b_public','ind15b_private'],'pct'=>false],
    ['label'=>'16. Kindergarten Enrolled','key'=>'ind16','pct'=>false],
    ['label'=>'17. School children (Grades 1-6)','key'=>'ind17','pct'=>false],
    ['label'=>'18. School children weighed (K-Gr. 6)','key'=>'ind18','pct'=>false],
    ['label'=>'19. % coverage measured','key'=>'ind19','pct'=>true],
    ['label'=>'20a. Severely Wasted','key'=>'ind20a_no','sub'=>'ind20a_pct','pct'=>true],
    ['label'=>'20b. Wasted','key'=>'ind20b_no','sub'=>'ind20b_pct','pct'=>true],
    ['label'=>'20c. Normal','key'=>'ind20c_no','sub'=>'ind20c_pct','pct'=>true],
    ['label'=>'20d. Overweight','key'=>'ind20d_no','sub'=>'ind20d_pct','pct'=>true],
    ['label'=>'20e. Obese','key'=>'ind20e_no','sub'=>'ind20e_pct','pct'=>true],
    ['label'=>'21. Exclusively breastfed 0-5 months','key'=>'ind21','pct'=>false],
    ['label'=>'22. Complementary foods at 6 months','key'=>'ind22','pct'=>false],
    ['label'=>'23. Households with wasted school children','key'=>'ind23','pct'=>false],
    ['label'=>'24. School children dewormed','key'=>'ind24','pct'=>false],
    ['label'=>'25. Fully immunized children','key'=>'ind25','pct'=>false],
    ['label'=>'26a. Water-sealed toilet','key'=>'ind26a_no','sub'=>'ind26a_pct','pct'=>true],
    ['label'=>'26b. Antipolo toilet','key'=>'ind26b_no','sub'=>'ind26b_pct','pct'=>true],
    ['label'=>'26c. Open Pit/Shared toilet','key'=>'ind26c_no','sub'=>'ind26c_pct','pct'=>true],
    ['label'=>'26d. No Toilet','key'=>'ind26d_no','sub'=>'ind26d_pct','pct'=>true],
    ['label'=>'27a. Barangay/City garbage','key'=>'ind27a_no','sub'=>'ind27a_pct','pct'=>true],
    ['label'=>'27b. Own compost pit','key'=>'ind27b_no','sub'=>'ind27b_pct','pct'=>true],
    ['label'=>'27c. Burning','key'=>'ind27c_no','sub'=>'ind27c_pct','pct'=>true],
    ['label'=>'27d. Dumping','key'=>'ind27d_no','sub'=>'ind27d_pct','pct'=>true],
    ['label'=>'28a. Pipe water system','key'=>'ind28a_no','sub'=>'ind28a_pct','pct'=>true],
    ['label'=>'28b. Well – Level II','key'=>'ind28b_no','sub'=>'ind28b_pct','pct'=>true],
    ['label'=>'28c. Deep well (Level II)','key'=>'ind28c_no','sub'=>'ind28c_pct','pct'=>true],
    ['label'=>'28d. Mineral water','key'=>'ind28d_no','sub'=>'ind28d_pct','pct'=>true],
    ['label'=>'28e. Open shallow dug well','key'=>'ind28e_no','sub'=>'ind28e_pct','pct'=>true],
    ['label'=>'29a. Vegetable garden','key'=>'ind29a_no','sub'=>'ind29a_pct','pct'=>true],
    ['label'=>'29b. Livestock/poultry','key'=>'ind29b_no','sub'=>'ind29b_pct','pct'=>true],
    ['label'=>'29c. Combination garden & livestock','key'=>'ind29c_no','sub'=>'ind29c_pct','pct'=>true],
    ['label'=>'29d. Fishponds','key'=>'ind29d_no','sub'=>'ind29d_pct','pct'=>true],
    ['label'=>'29e. No garden','key'=>'ind29e_no','sub'=>'ind29e_pct','pct'=>true],
    ['label'=>'30a. Concrete','key'=>'ind30a_no','sub'=>'ind30a_pct','pct'=>true],
    ['label'=>'30b. Semi concrete','key'=>'ind30b_no','sub'=>'ind30b_pct','pct'=>true],
    ['label'=>'30c. Wooden house','key'=>'ind30c_no','sub'=>'ind30c_pct','pct'=>true],
    ['label'=>'30d. Nipa bamboo house','key'=>'ind30d_no','sub'=>'ind30d_pct','pct'=>true],
    ['label'=>'30e. Barong-barong','key'=>'ind30e_no','sub'=>'ind30e_pct','pct'=>true],
    ['label'=>'31. Households using iodized salt','key'=>'ind31','pct'=>false],
    ['label'=>'32. Total number of eateries/carinderia','key'=>'ind32','pct'=>false],
    ['label'=>'33. Total number of bakeries','key'=>'ind33','pct'=>false],
    ['label'=>'34. Total number of sari-sari stores','key'=>'ind34','pct'=>false],
    ['label'=>'35a. Barangay Nutrition Scholar','key'=>'ind35a','pct'=>false],
    ['label'=>'35b. Barangay Health Worker','key'=>'ind35b','pct'=>false],
    ['label'=>'36. Total households beneficiaries of Pantawid Pamilyang Pilipino','key'=>'ind36','pct'=>false],
];

foreach($indicators as $ind){
    $pdf->Cell(130,6,$ind['label'],1);
    if(isset($ind['keys'])){
        $val = val($row,$ind['keys'][0],'int').' / '.val($row,$ind['keys'][1],'int');
    } elseif(isset($ind['sub']) && $ind['pct']){
        $val = val($row,$ind['key'],'int').' / '.val($row,$ind['sub'],'pct');
    } elseif($ind['pct']){
        $val = isset($row[$ind['key']]) ? number_format((float)$row[$ind['key']],2).'%' : '—';
    } else {
        $val = val($row,$ind['key'],'int');
    }
    $pdf->Cell(50,6,$val,1,1,'C');
}

$pdf->Output("BNS_Report_".$row['barangay'].".pdf","I");
?>
