<?php
include "Db_Config.php";

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $medication_name = $_POST['medication_name'];
    $generic_name = $_POST['generic_name'];
    $dosage = $_POST['dosage'];
    $manufacturer = $_POST['manufacturer'];
    $category = $_POST['category'];
    $expiry_date = $_POST['expiry_date'];
    $stock_quantity = $_POST['stock_quantity'];
    $unit_price = $_POST['unit_price'];

    // Insert medication data into the database
    $sql = "INSERT INTO medications (name, generic_name, dosage, manufacturer, category, expiry_date, stock_quantity, unit_price) 
            VALUES ('$medication_name', '$generic_name', '$dosage', '$manufacturer', '$category', '$expiry_date', '$stock_quantity', '$unit_price')";

    if (mysqli_query($con, $sql)) {
        $success_message = "Medication added successfully!";
    } else {
        $error_message = "Error: " . mysqli_error($con);
    }
}

// Fetch existing medications from the database
$sql = "SELECT * FROM medications";
$result = mysqli_query($con, $sql);
$medications = array();

while ($row = mysqli_fetch_assoc($result)) {
    $medications[] = $row;
}
function redirect_to_edit($medication_id)
{
    if (isset($_POST["edit"])) {
        header("Location: edit_medications.php?id=$medication_id"); 
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Medications</title>
    <link rel="stylesheet" href="static/med.css">
</head>

<body>

    <h1>Manage Medications</h1>

    <?php if (isset($success_message)): ?>
        <div class="success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <!-- <h2>Add New Medication</h2> -->
    <form method="post" action="">
        <div >
            <label for="medication_name">Medication Name:</label>
            <input type="text" name="medication_name" required>
        </div>
        <div id="m">
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
            <input type="text" name="unit_price" required>
        </div>
        
        <button type="submit" name="submit">Add Medication</button>
    </form> 

    <h3>Medication List</h3>
    <table class="med_list">
        <thead>
            <tr>
                <th>Medication Name</th>
                <th>Generic Name</th>
                <th>Dosage</th>
                <th>Manufacturer</th>
                <th>Category</th>
                <th>Expiry Date</th>
                <th>Stock Quantity</th>
                <th>Unit Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($medications) > 0): ?>
                <?php foreach ($medications as $medication): ?>
                    <tr>
                        <td><?php echo $medication['name']; ?></td>
                        <td><?php echo $medication['generic_name']; ?></td>
                        <td><?php echo $medication['dosage']; ?></td>
                        <td><?php echo $medication['manufacturer']; ?></td>
                        <td><?php echo $medication['category']; ?></td>
                        <td><?php echo $medication['expiry_date']; ?></td>
                        <td><?php echo $medication['stock_quantity']; ?></td>
                        <td><?php echo $medication['unit_price']; ?></td>
                        <td>
                            <form action="<?php redirect_to_edit($medication['medication_id']); ?>" method="post">
                                <button type="submit" name="edit">Edit</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No medications found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>