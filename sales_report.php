<?php
include 'Db_Config.php';

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // Default: First day of current month
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); // Default: Today's date

// Fetch sales records grouped by date
$sql = "SELECT date_sold, SUM(total_price) AS total_sales FROM sales_records 
        WHERE date_sold BETWEEN '$start_date' AND '$end_date' 
        GROUP BY date_sold ORDER BY date_sold DESC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" href="static/sales_report.css">
</head>

<body>

    <div class="container">
        <h1>Sales Report</h1>
        <form method="GET">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" value="<?= $start_date ?>" required>

            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" value="<?= $end_date ?>" required>

            <button type="submit">Filter</button>
        </form>

        <table>
            <tr>
                <th>Date</th>
                <th>Total Sales (₹)</th>
            </tr>
            <?php
            $grand_total = 0;
            while ($row = $result->fetch_assoc()) {
                $grand_total += $row['total_sales'];
            ?>
                <tr>
                    <td><?= $row['date_sold'] ?></td>
                    <td>₹<?= number_format($row['total_sales'], 2) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Total Sales (₹)</th>
                <th>₹<?= number_format($grand_total, 2) ?></th>
            </tr>
        </table>

        <br>
        <form action="export_sales_pdf.php" method="GET">
            <input type="hidden" name="start_date" value="<?= $start_date ?>">
            <input type="hidden" name="end_date" value="<?= $end_date ?>">
            <button type="submit">Download PDF</button>
        </form>
    </div>

</body>

</html>