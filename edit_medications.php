<?php

session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include "Db_Config.php";

if (isset($_GET['id'])) {
    $medication_id = $_GET['id'];

    // Fetch the medication details from the database
    $sql = "SELECT * FROM medications WHERE medication_id = '$medication_id' ";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $medication = mysqli_fetch_assoc($result);
    } else {
        // Handle the case where the medication ID is not found
        header("Location: manage_medications.php");
        exit();
    }
} else {
    // Handle the case where the medication ID is not provided
    header("Location: manage_medications.php");
    exit();
}

if (isset($_POST['update'])) {
    $medication_name = $_POST['medication_name'];
    $generic_name = $_POST['generic_name'];
    $dosage = $_POST['dosage'];
    $manufacturer = $_POST['manufacturer'];
    $category = $_POST['category'];
    $expiry_date = $_POST['expiry_date'];
    $stock_quantity = $_POST['stock_quantity'];
    $unit_price = $_POST['unit_price'];

    // Update the medication data in the database
    $sql = "UPDATE medications SET 
                name = '$medication_name', 
                generic_name = '$generic_name', 
                dosage = '$dosage', 
                manufacturer = '$manufacturer', 
                category = '$category', 
                expiry_date = '$expiry_date', 
                stock_quantity = '$stock_quantity', 
                unit_price = '$unit_price' WHERE medication_id = '$medication_id' ";

    if (mysqli_query($con, $sql)) {
        $success_message = "Medication updated successfully!";
        header("Location: manage_medications.php");
        exit();
    } else {
        $error_message = "Error in update procedure";
        header("Location: edit_medications.php?id=$medication_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Medication</title>
    <link rel="stylesheet" href="static/edit_med.css">
</head>

<body>

    <h1>Edit Medications</h1>

    <?php if (isset($success_message)): ?>
        <div class="success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div>
            <label for="medication_name">Medication Name:</label>
            <input type="text" name="medication_name" value="<?php echo $medication['name']; ?>" required>
        </div>
        <div>
            <label for="generic_name">Generic Name:</label>
            <input type="text" name="generic_name" value="<?php echo $medication['generic_name']; ?>">
        </div>
        <div>
            <label for="dosage">Dosage:</label>
            <input type="text" name="dosage" value="<?php echo $medication['dosage']; ?>">
        </div>
        <div>
            <label for="manufacturer">Manufacturer:</label>
            <input type="text" name="manufacturer" value="<?php echo $medication['manufacturer']; ?>">
        </div>
        <div>
            <label for="category">Category:</label>
            <input type="text" name="category" value="<?php echo $medication['category']; ?>">
        </div>
        <div>
            <label for="expiry_date">Expiry Date:</label>
            <input type="date" name="expiry_date" value="<?php echo $medication['expiry_date']; ?>" required>
        </div>
        <div>
            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" name="stock_quantity" value="<?php echo $medication['stock_quantity']; ?>" required>
        </div>
        <div>
            <label for="unit_price">Unit Price:</label>
            <input type="text" name="unit_price" value="<?php echo $medication['unit_price']; ?>" required>
        </div>
        <button type="submit" name="update" class="submit">Update Medication</button>


    </form>

</body>

</html>