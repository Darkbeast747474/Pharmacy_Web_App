<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

include "Db_Config.php";

if (isset($_POST['submit'])) {
    $medication_id = $_POST['medication_id'];
    $medication_name = $_POST['medication_name'];
    $generic_name = $_POST['generic_name'];
    $dosage = $_POST['dosage'];
    $manufacturer = $_POST['manufacturer'];
    $category = $_POST['category'];
    $expiry_date = $_POST['expiry_date'];
    $stock_quantity = $_POST['stock_quantity'];
    $unit_price = $_POST['unit_price'];

    $sql = "INSERT INTO medications (medication_id,name, generic_name, dosage, manufacturer, category, expiry_date, stock_quantity, unit_price) 
            VALUES ($medication_id,'$medication_name', '$generic_name', '$dosage', '$manufacturer', '$category', '$expiry_date', '$stock_quantity', '$unit_price')";

    if (mysqli_query($con, $sql)) {
        $success_message = "Medication added successfully!";
    } else {
        $error_message = "Error While Adding Medication ";
    }
}

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
                    <label for="medication_name">Medication ID:</label>
                    <input type="number" name="medication_id" required>
                </div>
                <div>
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
                    <input type="number" name="unit_price" required>
                </div>
                <button class="submit" type="submit" name="submit">Add Medication</button>
            </form>
        </div>

        <div class="med_list">
            <h2 class="mlist">Medication List</h2>

            <table>
                <thead>
                    <tr>
                        <th>Medication ID</th>
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
                                <td><?php echo $medication['medication_id']; ?></td>
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
        </div>
    </div>

</body>

</html>