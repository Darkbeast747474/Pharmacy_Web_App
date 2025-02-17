<?php
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
    $medication_id = $_POST['medication_id'];
    $medication_name = $_POST['medication_name'];
    $generic_name = $_POST['generic_name'];
    $dosage = $_POST['dosage'];
    $manufacturer = $_POST['manufacturer'];
    $category = $_POST['category'];
    $expiry_date = $_POST['expiry_date'];
    $stock_quantity = $_POST['stock_quantity'];
    $unit_price = $_POST['unit_price'];

    // Update the medication data in the database
    $sql = "UPDATE medications 
            SET 
                medication_id = '$medication_id',
                name = '$medication_name', 
                generic_name = '$generic_name', 
                dosage = '$dosage', 
                manufacturer = '$manufacturer', 
                category = '$category', 
                expiry_date = '$expiry_date', 
                stock_quantity = '$stock_quantity', 
                unit_price = '$unit_price' 
            WHERE medication_id = $medication_id";

    if (mysqli_query($con, $sql)) {
        $success_message = "Medication updated successfully!";
        header("Location: manage_medications.php");
        exit();
    } else {
        $error_message = "Error in update procedure";
        header("Location: edit.php?id=$medication_id");
        exit();
    }
}

if (isset($_POST['delete'])) {
    include "Db_Config.php";
    $sql = "DELETE FROM medications WHERE medication_id = $medication_id";
    if (mysqli_query($con, $sql)) {
        $success_message = "Medication deleted successfully!";
        header("Location: manage_medications.php");
        exit();
    } else {
        $error_message = "Error in delete procedure";
        header("Location: edit.php?id=$medication_id");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Medication</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lexend+Giga:wght@100..900&family=Lexend:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Flex:opsz,wght@8..144,100..1000&family=Smooch+Sans:wght@100..900&display=swap');
        body {
            font-family: Arial, sans-serif;
            background-color: #291e3b;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
            color: white;
            font-family: "Smooch Sans", serif;
  font-optical-sizing: auto;
  font-weight: 800;
  font-size:50px;
  font-style: normal;
        }

        form {
            width: 60%;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form div {
            margin-bottom: 15px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            display: inline-block;
            padding: 15px 20px;
            /* margin: 10px 5px; */
           position: relative;
           left: 32%;
           margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bolder;

        }

        button[name="update"] {
            background-color: #4CAF50;
            color: white;
        }

        button[name="delete"] {
            background-color: #f44336;
            color: white;
        }

        button:hover {
            opacity: 0.9;
        }

        .success,
        .error {
            text-align: center;
            margin: 20px auto;
            padding: 10px;
            width: 50%;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .success {
            background-color: #4CAF50;
            color: white;
        }

        .error {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>

<body>

    <!-- <h2>Edit Medication</h2> -->
     <h1>Edit Medications</h1>

    <?php if (isset($success_message)): ?>
        <div class="success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div>
            <label for="medication_id">Medication ID:</label>
            <input type="number" name="medication_id" value="<?php echo $medication['medication_id']; ?>" required>
        </div>
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
        <button type="submit" name="update">Update Medication</button>
        <button type="submit" name="delete">Delete Medication</button>
    </form>

</body>

</html>