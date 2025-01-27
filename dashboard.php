<?php
include "Db_Config.php";

// Calculate date ranges for past 1 day and 7 days
$today = date("Y-m-d");
$one_day_ago = date("Y-m-d", strtotime("-1 day"));
$seven_days_ago = date("Y-m-d", strtotime("-7 days"));

// Calculate total sales for the past 1 day
$sql_sales_1day = "SELECT SUM(total_amount) as total_sales 
                   FROM sales 
                   WHERE sale_date >= '$one_day_ago' AND sale_date <= '$today'";
$result_sales_1day = mysqli_query($con, $sql_sales_1day);
$row_sales_1day = mysqli_fetch_assoc($result_sales_1day);
$total_sales_1day = $row_sales_1day['total_sales'];

// Calculate total sales for the past 7 days
$sql_sales_7days = "SELECT SUM(total_amount) as total_sales 
                   FROM sales 
                   WHERE sale_date >= '$seven_days_ago' AND sale_date <= '$today'";
$result_sales_7days = mysqli_query($con, $sql_sales_7days);
$row_sales_7days = mysqli_fetch_assoc($result_sales_7days);
$total_sales_7days = $row_sales_7days['total_sales'];

// Get low stock medications
$sql_low_stock = "SELECT * FROM medications WHERE stock_quantity < 10"; // Adjust threshold as needed
$result_low_stock = mysqli_query($con, $sql_low_stock);
$low_stock_medications = mysqli_fetch_all($result_low_stock, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Dashboard</title>
    <link rel="stylesheet" href="static/Dashboard.css">
</head>
<body>

    <h1>Pharmacy Dashboard</h1>

    <div class="dashboard-section">
        <h2>Sales Summary</h2>
        <ul>
            <li>Total Sales (Past 1 Day): <?php echo number_format($total_sales_1day, 2); ?></li>
            <li>Total Sales (Past 7 Days): <?php echo number_format($total_sales_7days, 2); ?></li>
        </ul>
    </div>

    <div class="dashboard-section">
        <h2>Low Stock Medications</h2>
        <?php if (count($low_stock_medications) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Medication Name</th>
                        <th>Stock Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($low_stock_medications as $medication): ?>
                        <tr>
                            <td><?php echo $medication['name']; ?></td>
                            <td><?php echo $medication['stock_quantity']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No medications with low stock.</p>
        <?php endif; ?>
    </div>

</body>
</html>