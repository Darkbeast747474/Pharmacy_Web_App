<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'Db_Config.php';

// Fetch total staff count
$staff_result = $con->query("SELECT COUNT(*) AS total_staff FROM staff");
$staff = $staff_result->fetch_assoc()['total_staff'];

// Fetch total manufacturing companies
$companies_result = $con->query("SELECT COUNT(DISTINCT  manufacturer) AS total_companies FROM medications");
$companies = $companies_result->fetch_assoc()['total_companies'];

// Fetch total medicines count
$medicines_result = $con->query("SELECT COUNT(*) AS total_medicines FROM medications");
$medicines = $medicines_result->fetch_assoc()['total_medicines'];

// Fetch today's sales
$todays_sales_result = $con->query("SELECT SUM(total_price) AS todays_sales FROM sales_records WHERE DATE(date_sold) = CURDATE()");
$todays_sales = $todays_sales_result->fetch_assoc()['todays_sales'] ?? 0;

// Fetch yesterday's sales
$yesterdays_sales_result = $con->query("SELECT SUM(total_price) AS yesterdays_sales FROM sales_records WHERE DATE(date_sold) = CURDATE() - INTERVAL 1 DAY");
$yesterdays_sales = $yesterdays_sales_result->fetch_assoc()['yesterdays_sales'] ?? 0;

// Fetch last 7 days' sales
$last_seven_days_sales_result = $con->query("SELECT SUM(total_price) AS last_seven_days_sales FROM sales_records WHERE date_sold >= CURDATE() - INTERVAL 7 DAY");
$last_seven_days_sales = $last_seven_days_sales_result->fetch_assoc()['last_seven_days_sales'] ?? 0;

// Fetch total sales revenue
$total_sales_result = $con->query("SELECT SUM(total_price) AS total_sales FROM sales_records");
$total_sales = $total_sales_result->fetch_assoc()['total_sales'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="static/Dashboard.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <h1>Admin Dashboard</h1>
    <hr>
    <div class="dashboard-container">
        <div class="dashboard-card">
            <i class="fas fa-user-md"></i>
            <h5>Total Staff</h5>
            <p><?= $staff ?></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-hospital"></i>
            <h5>Total Manufacturing Companies</h5>
            <p><?= $companies ?></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-pills"></i>
            <h5>Total Types of Medicines</h5>
            <p><?= $medicines ?></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-rupee-sign"></i>
            <h5>Today's Sale</h5>
            <p>₹<?= number_format($todays_sales, 2) ?></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-chart-line"></i>
            <h5>Yesterday's Sale</h5>
            <p>₹<?= number_format($yesterdays_sales, 2) ?></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-wallet"></i>
            <h5>Last 7 Days Sale</h5>
            <p>₹<?= number_format($last_seven_days_sales, 2) ?></p>
        </div>
        <div class="dashboard-card full-width">
            <i class="fas fa-dollar-sign"></i>
            <h2>Total Sale: ₹<?= number_format($total_sales, 2) ?></h2>
        </div>
    </div>
</body>

</html>