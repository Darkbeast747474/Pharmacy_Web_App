<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

include 'Db_Config.php';

$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// Validate inputs
if (!$start_date || !$end_date) {
    die("Start date and end date are required.");
}

// Fetch sales data
$sql = "SELECT date_sold, SUM(total_price) AS total_sales 
        FROM sales_records 
        WHERE date_sold BETWEEN '$start_date' AND '$end_date' AND admin_id = '$admin_id'
        GROUP BY date_sold 
        ORDER BY date_sold DESC";

$result = $con->query($sql);

$rows = [];
$grand_total = 0;
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
    $grand_total += $row['total_sales'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f4f4f4;
        }

        .report-container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #ccc;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #1e71cf;
        }

        .date-range {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: #1e71cf;
            color: white;
        }

        tfoot td {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .print-btn {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            background-color: #1e71cf;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
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

<div class="report-container">
    <h2>Sales Report</h2>
    <div class="date-range">From: <?php echo $start_date; ?> To: <?php echo $end_date; ?></div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Sales (₹)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?php echo $row['date_sold']; ?></td>
                    <td>₹<?php echo number_format($row['total_sales'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td>Total Sales</td>
                <td>₹<?php echo number_format($grand_total, 2); ?></td>
            </tr>
        </tfoot>
    </table>

    <button onclick="window.print()" class="print-btn">Print Report</button>
</div>

</body>
</html>
