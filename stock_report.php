<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'Db_Config.php';

// Fetch all medicines
$medications_result = $con->query("
    SELECT name, category, stock_quantity, expiry_date
    FROM medications
");

$low_stock_threshold = 10;
$soon_expiring_days = 30;
$today = date('Y-m-d');

$expiring_medicines = [];
$expired_medicines = [];
$low_stock_medicines = [];
$medicine_types = [];

// Categorize medicines
while ($row = $medications_result->fetch_assoc()) {
    // Expiring soon
    if (strtotime($row['expiry_date']) <= strtotime("+$soon_expiring_days days")) {
        if (strtotime($row['expiry_date']) <= strtotime($today)) {
            $expired_medicines[] = $row;
        } else {
            $expiring_medicines[] = $row;
        }
    }
    // Low stock
    if ($row['stock_quantity'] < $low_stock_threshold) {
        $low_stock_medicines[] = $row;
    }
    // Group by type
    $medicine_types[$row['category']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Report</title>
    <link rel="stylesheet" href="static/stock_report.css">
</head>

<body>
    <div class="container">
        <h1>Stock Report</h1>

        <!-- Expired Medicines -->
        <?php if (count($expired_medicines) > 0) { ?>
            <h2 class="section-title">🟠 Expired Medicines</h2>
            <table border="1">
                <tr>
                    <th>Medicine Name</th>
                    <th>Category</th>
                    <th>Stock Quantity</th>
                    <th>Expiry Date</th>
                </tr>
                <?php foreach ($expired_medicines as $med) { ?>
                    <tr>
                        <td><?= $med['name'] ?></td>
                        <td><?= $med['category'] ?></td>
                        <td><?= $med['stock_quantity'] ?></td>
                        <td class="expiring"><?= $med['expiry_date'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>

        <!-- Expiring Medicines -->
        <?php if (count($expiring_medicines) > 0) { ?>
            <h2 class="section-title">🟠 Expiring Medicines (Next 30 Days)</h2>
            <table border="1">
                <tr>
                    <th>Medicine Name</th>
                    <th>Category</th>
                    <th>Stock Quantity</th>
                    <th>Expiry Date</th>
                </tr>
                <?php foreach ($expiring_medicines as $med) { ?>
                    <tr>
                        <td><?= $med['name'] ?></td>
                        <td><?= $med['category'] ?></td>
                        <td><?= $med['stock_quantity'] ?></td>
                        <td class="expiring"><?= $med['expiry_date'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>

        <!-- Low Stock Medicines -->
        <?php if (count($low_stock_medicines) > 0) { ?>
            <h2 class="section-title">🔴 Low Stock Medicines (Below <?= $low_stock_threshold ?> Units)</h2>
            <table border="1">
                <tr>
                    <th>Medicine Name</th>
                    <th>Type</th>
                    <th>Stock Quantity</th>
                </tr>
                <?php foreach ($low_stock_medicines as $med) { ?>
                    <tr>
                        <td><?= $med['name'] ?></td>
                        <td><?= $med['category'] ?></td>
                        <td class="low-stock"><?= $med['stock_quantity'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>

        <!-- Medicines by Type -->
        <?php if (count($medicine_types) > 0) { ?>
            <h2 class="section-title">📋 Medicines Categorized by Type</h2>
            <?php foreach ($medicine_types as $type => $med_list) { ?>
                <h3 class="type-header"><?= $type ?></h3>
                <table border="1">
                    <tr>
                        <th>Medicine Name</th>
                        <th>Stock Quantity</th>
                        <th>Expiry Date</th>
                    </tr>
                    <?php foreach ($med_list as $med) { ?>
                        <tr>
                            <td><?= $med['name'] ?></td>
                            <td><?= $med['stock_quantity'] ?></td>
                            <td><?= $med['expiry_date'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        <?php } ?>
    </div>
</body>

</html>