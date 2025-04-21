<?php

session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
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
                      WHERE s.id = $id AND s.admin_id = '$admin_id'");

$sale = $result->fetch_assoc();

// Check if sale exists
if (!$sale) {
    header("Location: invoice.php");
    die("Error: Sale not found!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?php echo $sale['id']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f5f5f5;
        }

        .invoice-box {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            line-height: 1.6;
            text-align: left;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td {
            padding: 8px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            background-color: #f0f0f0;
            width: 40%;
        }

        .print-btn {
            display: block;
            margin: 30px auto 0 auto;
            padding: 10px 20px;
            background-color: #1e71cf;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .print-btn:hover {
            background-color: #4991e5;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <h2>Pharmacy Invoice</h2>
    <table>
        <tr>
            <td class="label">Invoice ID</td>
            <td>#<?php echo $sale['id']; ?></td>
        </tr>
        <tr>
            <td class="label">Customer Name</td>
            <td><?php echo $sale['customer_name']; ?></td>
        </tr>
        <tr>
            <td class="label">Medicine</td>
            <td><?php echo $sale['name']; ?></td>
        </tr>
        <tr>
            <td class="label">Quantity</td>
            <td><?php echo $sale['quantity_sold']; ?></td>
        </tr>
        <tr>
            <td class="label">Total Price</td>
            <td>₹<?php echo number_format($sale['total_price'], 2); ?></td>
        </tr>
        <tr>
            <td class="label">Payment Method</td>
            <td><?php echo $sale['payment_method']; ?></td>
        </tr>
        <tr>
            <td class="label">Date</td>
            <td><?php echo $sale['date_sold']; ?></td>
        </tr>
    </table>

    <button onclick="window.print()" class="print-btn">Print</button>
</div>

</body>
</html>
