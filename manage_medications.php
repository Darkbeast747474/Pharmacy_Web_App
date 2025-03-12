<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

include "Db_Config.php";

$sql = "SELECT * FROM medications";
$result = mysqli_query($con, $sql);
$medications = array();

while ($row = mysqli_fetch_assoc($result)) {
    $medications[] = $row;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Medications</title>
    <link rel="stylesheet" href="static/med.css">
</head>

<body>
    <div class="container">
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
                                    <form action="edit_medications.php" method="get">
                                        <input type="hidden" name="id" value="<?php echo $medication['medication_id']; ?>">
                                        <button class="edit" type="submit">Edit</button>
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