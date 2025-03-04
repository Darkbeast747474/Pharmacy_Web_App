<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
include 'Db_Config.php';

// Fetch medicines for dropdown
$medicines = $con->query("SELECT medication_id, name, unit_price, stock_quantity FROM medications");

// Fetch staff members for dropdown
$staff_members = $con->query("SELECT staff_id, name FROM staff");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];
    $medication_id = $_POST['medication_id'];
    $quantity = $_POST['quantity'];
    $customer_name = $_POST['customer_name'];
    $payment_method = $_POST['payment_method'];

    // Fetch price and stock of selected medicine
    $result = $con->query("SELECT unit_price, stock_quantity FROM medications WHERE medication_id = $medication_id");
    $medicine = $result->fetch_assoc();

    if ($medicine['stock_quantity'] >= $quantity) {
        $total_price = $medicine['unit_price'] * $quantity;
        $new_stock_quantity = $medicine['stock_quantity'] - $quantity;

        // Insert into sales_records
        $sql = "INSERT INTO sales_records (medication_id, staff_id, quantity_sold, total_price, customer_name, payment_method) 
                VALUES ('$medication_id', '$staff_id', '$quantity', '$total_price', '$customer_name', '$payment_method')";

        // Update stock quantity in medications table
        $update_stock_sql = "UPDATE medications SET stock_quantity = '$new_stock_quantity' WHERE medication_id = '$medication_id'";

        // Update staff total sales
        $update_staff_sales_sql = "UPDATE staff SET total_sales = total_sales + '$total_price' WHERE staff_id = '$staff_id'";

        if (mysqli_query($con, $sql) && mysqli_query($con, $update_stock_sql) && mysqli_query($con, $update_staff_sales_sql)) {
            $success_message = "Sale recorded, stock updated, and staff sales updated successfully!";
        } else {
            $error_message = "Error while recording sale, updating stock, or updating staff sales.";
        }
    } else {
        $error_message = "Insufficient stock for this medication.";
    }
}

if (isset($_GET['generate_invoice'])) {
    $id = $_GET['generate_invoice'];
    header("Location: export_sales_invoice.php?generate_invoice=$id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Sales Management</title>
    <link rel="stylesheet" href="static/invoice.css">
</head>

<body>
    <div class="container">
        <h1>Record Sale</h1>
        <form method="post">
            <label>Staff:</label>
            <select name="staff_id">
                <?php while ($row = $staff_members->fetch_assoc()) { ?>
                    <option value="<?= $row['staff_id'] ?>">
                        <?= $row['name'] ?> (ID: <?= $row['staff_id'] ?>)
                    </option>
                <?php } ?>
            </select><br>

            <label>Medicine:</label>
            <select name="medication_id">
                <?php while ($row = $medicines->fetch_assoc()) { ?>
                    <option value="<?= $row['medication_id'] ?>">
                        <?= $row['name'] ?> - ₹<?= $row['unit_price'] ?> (Stock: <?= $row['stock_quantity'] ?>)
                    </option>
                <?php } ?>
            </select><br>

            <label>Quantity:</label>
            <input type="number" name="quantity" required><br>

            <label>Customer Name:</label>
            <input type="text" name="customer_name"><br>

            <label>Payment Method:</label>
            <select name="payment_method">
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="UPI">UPI</option>
            </select><br>
            <button type="submit">Record Sale</button>

        </form>

        <?php if (isset($success_message)) { ?>
            <p class="message success">
                <?= $success_message ?>
                <a href="?generate_invoice=<?= $con->insert_id ?>" style="color: #007bff;">Generate Invoice</a>
            </p>
        <?php } ?>

        <?php if (isset($error_message)) { ?>
            <p class="message error">
                <?= $error_message ?>
            </p>
        <?php } ?>
    </div>
</body>

</html>
