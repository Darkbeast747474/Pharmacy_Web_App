<?php
require('fpdf/fpdf.php');
include 'Db_Config.php';

if (!isset($_GET['generate_invoice']) || empty($_GET['generate_invoice'])) {
    header("Location: invoice.php");
    die("Error: Sale ID is missing!");
}

$id = (int) $_GET['generate_invoice']; // Ensure ID is an integer

// Fetch sale details
$result = $con->query("SELECT s.id, m.name, s.quantity_sold, s.total_price, s.customer_name, s.date_sold, s.payment_method 
                      FROM sales_records s 
                      JOIN medications m ON s.medication_id = m.medication_id 
                      WHERE s.id = $id");

$sale = $result->fetch_assoc();

// Check if sale exists
if (!$sale) {
    header("Location: invoice.php");
    die("Error: Sale not found!");
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Pharmacy Invoice');
$pdf->Ln();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Customer: ' . $sale['customer_name']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Medicine: ' . $sale['name']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Quantity: ' . $sale['quantity_sold']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Total Price: ₹' . $sale['total_price']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Payment Method: ' . $sale['payment_method']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Date: ' . $sale['date_sold']);
$pdf->Output();
exit;
?>
