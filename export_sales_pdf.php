<?php
session_start();
if(!isset($_SESSION['username']))
{
    header("Location: login.php");
}
require('fpdf/fpdf.php');
include 'Db_Config.php';

$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

// Fetch sales data
$sql = "SELECT date_sold, SUM(total_price) AS total_sales FROM sales_records 
        WHERE date_sold BETWEEN '$start_date' AND '$end_date' 
        GROUP BY date_sold ORDER BY date_sold DESC";
$result = $con->query($sql);

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Sales Report', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, "From: $start_date To: $end_date", 0, 1, 'C');
$pdf->Ln(10);

// Table headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Date', 1);
$pdf->Cell(60, 10, 'Total Sales (₹)', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
$grand_total = 0;
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(50, 10, $row['date_sold'], 1);
    $pdf->Cell(60, 10, '₹' . number_format($row['total_sales'], 2), 1);
    $pdf->Ln();
    $grand_total += $row['total_sales'];
}

// Grand Total
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Total Sales', 1);
$pdf->Cell(60, 10, '₹' . number_format($grand_total, 2), 1);

$pdf->Output();
?>
