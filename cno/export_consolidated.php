<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../db/config.php';
require_once('../vendor/autoload.php');   // TCPDF

// ---------- Access Control ----------
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'CNO') {
    header("Location: ../login.php");
    exit();
}

// ---------- Helper ----------
function val(array $a, string $k, string $fmt = 'int'): string {
    if (!isset($a[$k]) || $a[$k] === '' || $a[$k] === null) return '—';
    if ($fmt === 'int')  return (string)(int)$a[$k];
    if ($fmt === 'pct')  return number_format((float)$a[$k], 2) . '%';
    if ($fmt === 'dec2') return number_format((float)$a[$k], 2);
    return htmlspecialchars((string)$a[$k]);
}

// ---------- Query Totals ----------
$base = [
 'ind1','ind2','ind3','ind4a','ind4b','ind5','ind6','ind7a','ind8','ind9',
 'ind10','ind11','ind12','ind13','ind14','ind16','ind17','ind18','ind19',
 'ind21','ind22','ind23','ind24','ind25','ind31','ind32','ind33','ind34','ind36'
];
$groups = [
 '7b'=>['ind7b1','ind7b2','ind7b3','ind7b4','ind7b5','ind7b6','ind7b7','ind7b8','ind7b9'],
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
if(!$totals) die('No data to export');

// ---------- PDF Setup ----------
$pdf = new TCPDF('P','mm','A4',true,'UTF-8',false);
$pdf->SetCreator('Nutrimap');
$pdf->SetAuthor('CNO');
$pdf->SetTitle('Consolidated Barangay Situation Analysis');
$pdf->SetMargins(10,15,10);
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('times','',11);

// ---------- Table Builder ----------
function makeTable(array $rows): string {
    $html  = '<table cellpadding="4" cellspacing="0" width="100%" style="border-collapse:collapse;">';
    $html .= '<thead><tr>'
          .  '<th width="33.4%" style="border:1px solid #000;background:#dcdcdc;font-weight:bold;text-align:left;">Indicator</th>'
          .  '<th width="33.3%" style="border:1px solid #000;background:#dcdcdc;font-weight:bold;text-align:center;">No.</th>'
          .  '<th width="33.3%" style="border:1px solid #000;background:#dcdcdc;font-weight:bold;text-align:center;">%</th>'
          .  '</tr></thead><tbody>';
    foreach ($rows as $r) {
        $indicator = $r[0];
        $no        = $r[1] ?? '—';
        $pct       = $r[2] ?? '';
        $html .= '<tr>';
        $html .= '<td style="border:1px solid #000;">'.$indicator.'</td>';
        if ($pct === '' || $pct === null) {
            $html .= '<td colspan="2" style="border:1px solid #000;text-align:center;">'.$no.'</td>';
        } else {
            $html .= '<td style="border:1px solid #000;text-align:center;">'.$no.'</td>';
            $html .= '<td style="border:1px solid #000;text-align:center;">'.$pct.'</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    return $html;
}

// ---------- Page 1 ----------
$pdf->AddPage();
$pdf->SetFont('times','B',14);
$pdf->Cell(0,0,'Consolidated Barangay Situation Analysis',0,1,'C');
$pdf->Ln(6);
$pdf->SetFont('times','',11);

$p1 = [
    ['Total Population', val($totals,'ind1')],
    ['Number of households', val($totals,'ind2')],
    ['Total number of families', val($totals,'ind3')],
    ['Women – Pregnant', val($totals,'ind4a')],
    ['Women – Lactating', val($totals,'ind4b')],
    ['Households with preschool children (0–59 mos.)', val($totals,'ind5')],
    ['Actual population of preschool children (0–59 mos.)', val($totals,'ind6')],
    ['Preschool children measured during OPT Plus', val($totals,'ind7a','dec2')],
    ['Percent measured coverage (OPT Plus)', val($totals,'ind7a','pct')]
];
$nutri = [
 'Severely underweight','Underweight','Normal weight','Severely wasted',
 'Wasted','Overweight','Obese','Severely stunted','Stunted'
];
for($i=1;$i<=9;$i++){
    $p1[] = [
        $nutri[$i-1],
        val($totals,"ind7b{$i}_no"),
        val($totals,"ind7b{$i}_pct",'pct')
    ];
}
$p1 = array_merge($p1, [
    ['Infants 0–5 months old', val($totals,'ind8')],
    ['Infants 6–11 months old', val($totals,'ind9')],
    ['Preschool children 0–23 months', val($totals,'ind10')],
    ['Preschool children 12–59 months', val($totals,'ind11')],
    ['Preschool children 24–59 months', val($totals,'ind12')],
    ['Families with wasted/severely wasted preschool children', val($totals,'ind13')],
    ['Families with stunted/severely stunted preschool children', val($totals,'ind14')]
]);
$pdf->writeHTML(makeTable($p1), true, false, false, false, '');

// ---------- Page 2 ----------
$pdf->AddPage();

$p2 = [];

// Day Care Centers – combined Public / Private
$p2[] = [
    'Day Care Centers – Public / Private', 
    val($totals,'ind15a_public'),
    val($totals,'ind15a_private','no')
];

// Elementary Schools – combined Public / Private
$p2[] = [
    'Elementary Schools – Public / Private', 
    val($totals,'ind15b_public'),
    val($totals,'ind15b_private','no')
];

// Other school indicators
$p2[] = ['Children enrolled in Kindergarten', val($totals,'ind16')];
$p2[] = ['School children (Grades 1–6)', val($totals,'ind17')];
$p2[] = ['School children weighed (K–Gr.6)', val($totals,'ind18')];
$p2[] = ['Percentage coverage of school children measured', val($totals,'ind19','pct')];

// Nutrition status of school children
foreach(['a'=>'Severely Wasted','b'=>'Wasted','c'=>'Normal','d'=>'Overweight','e'=>'Obese'] as $c=>$lbl){
    $p2[] = [$lbl, val($totals,"ind20{$c}_no"), val($totals,"ind20{$c}_pct",'pct')];
}

// Other indicators
$p2[] = ['0–5 months old children exclusively breastfed', val($totals,'ind21')];
$p2[] = ['Households with severely wasted and wasted school children', val($totals,'ind22')];
$p2[] = ['School children dewormed at start of school year', val($totals,'ind23')];
$p2[] = ['Fully immunized children', val($totals,'ind24')];

// Sanitation – separate types with No. and %
foreach(['a'=>'Water-sealed toilet','b'=>'Antipolo (Unsanitary Toilet)','c'=>'Open Pit/Shared','d'=>'No Toilet'] as $c=>$lbl){
    $p2[] = [$lbl, val($totals,"ind26{$c}_no"), val($totals,"ind26{$c}_pct",'pct')];
}

$pdf->writeHTML(makeTable($p2), true, false, false, false, '');

// ---------- Page 3 ----------
$pdf->AddPage();
$p3 = [];
foreach(['a'=>'Barangay/City garbage collection','b'=>'Own compost pit','c'=>'Burning','d'=>'Dumping'] as $c=>$lbl){
    $p3[] = [$lbl, val($totals,"ind27{$c}_no"), val($totals,"ind27{$c}_pct",'pct')];
}
foreach([
    'a'=>'Pipe water system','b'=>'Well – Level II',
    'c'=>'Deep well with communal source (Level II)',
    'd'=>'Mineral water / water dispensing stores',
    'e'=>'Open shallow dug well (Level I)'
] as $c=>$lbl){
    $p3[] = [$lbl, val($totals,"ind28{$c}_no"), val($totals,"ind28{$c}_pct",'pct')];
}
foreach([
    'a'=>'Vegetable garden','b'=>'Livestock/poultry',
    'c'=>'Combination vegetable garden & livestock/poultry',
    'd'=>'Fishponds','e'=>'No garden'
] as $c=>$lbl){
    $p3[] = [$lbl, val($totals,"ind29{$c}_no"), val($totals,"ind29{$c}_pct",'pct')];
}
foreach([
    'a'=>'Concrete','b'=>'Semi concrete','c'=>'Wooden house',
    'd'=>'Nipa bamboo house','e'=>'Barong-barong makeshift'
] as $c=>$lbl){
    $p3[] = [$lbl, val($totals,"ind30{$c}_no"), val($totals,"ind30{$c}_pct",'pct')];
}
$p3 = array_merge($p3, [
    ['Households using iodized salt', val($totals,'ind31')],
    ['Total number of eateries/carinderia', val($totals,'ind32')],
    ['Total number of bakeries', val($totals,'ind33')],
    ['Total number of sari-sari stores', val($totals,'ind34')],
    ['Barangay Nutrition Scholar', val($totals,'ind35a')],
    ['Barangay Health Worker', val($totals,'ind35b')],
    ['Households beneficiaries of Pantawid Pamilyang Pilipino', val($totals,'ind36')]
]);
$pdf->writeHTML(makeTable($p3), true, false, false, false, '');

// ---------- Output ----------
$pdf->Output('Consolidated_Barangay_Situation_Analysis.pdf','I');
