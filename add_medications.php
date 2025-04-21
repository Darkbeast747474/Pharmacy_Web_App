<?php 
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

include "Db_Config.php";

if (isset($_POST['submit'])) {
    $medication_name = $_POST['medication_name'];
    $generic_name = $_POST['generic_name'];
    $dosage = $_POST['dosage'];
    $manufacturer = $_POST['manufacturer'];
    $category = $_POST['category'];
    $expiry_date = $_POST['expiry_date'];
    $stock_quantity = $_POST['stock_quantity'];
    $unit_price = $_POST['unit_price'];

    $sql = "INSERT INTO medications (admin_id,name, generic_name, dosage, manufacturer, category, expiry_date, stock_quantity, unit_price) 
            VALUES ($admin_id,'$medication_name', '$generic_name', '$dosage', '$manufacturer', '$category', '$expiry_date', '$stock_quantity', '$unit_price')";

    if (mysqli_query($con, $sql)) {
        $success_message = "Medication added successfully!";
    } else {
        $error_message = "Error While Adding Medication ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/addmed.css">
</head>
<body>
<?php if (isset($success_message)): ?>
        <div class="success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <h2 class="ad">Add New Medication</h2>
<div class="container">
    <div class="med_add">
        <form method="post" action="">
            <div>
                <label for="medication_name">Medication Name:</label>
                <input type="text" name="medication_name" required>
            </div>
            <div>
                <label for="generic_name">Generic Name:</label>
                <input type="text" name="generic_name">
            </div>
            <div>
                <label for="dosage">Dosage:</label>
                <input type="text" name="dosage">
            </div>
            <div>
                <label for="manufacturer">Manufacturer:</label>
                <input type="text" name="manufacturer">
            </div>
            <div>
                <label for="category">Category:</label>
                <input type="text" name="category">
            </div>
            <div>
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" name="expiry_date" required>
            </div>
            <div>
                <label for="stock_quantity">Stock Quantity:</label>
                <input type="number" name="stock_quantity" required>
            </div>
            <div>
                <label for="unit_price">Unit Price:</label>
                <input type="number" name="unit_price" required>
            </div>
            <div class="form-submit-wrapper">
                <button class="submit" type="submit" name="submit">Add Medication</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>