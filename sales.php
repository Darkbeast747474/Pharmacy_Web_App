<?php
session_start();
if(!isset($_SESSION['username']))
{
    header("Location: login.php");
}
include 'Db_Config.php';

// Fetch medicines for dropdown
$medicines = $con->query("SELECT medication_id, name, unit_price, stock_quantity FROM medications");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $sql = "INSERT INTO sales_records (medication_id, quantity_sold, total_price, customer_name, payment_method) 
                VALUES ('$medication_id', '$quantity', '$total_price', '$customer_name', '$payment_method')";

        // Update stock quantity in medications table
        $update_stock_sql = "UPDATE medications SET stock_quantity = '$new_stock_quantity' WHERE medication_id = '$medication_id'";

        if (mysqli_query($con, $sql) && mysqli_query($con, $update_stock_sql)) {
            $success_message = "Sale recorded and stock updated successfully!";
        } else {
            $error_message = "Error while recording sale or updating stock.";
        }
    } else {
        $error_message = "Insufficient stock for this medication.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Sales Management</title>
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Lexend+Giga:wght@100..900&family=Lexend:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Flex:opsz,wght@8..144,100..1000&family=Smooch+Sans:wght@100..900&display=swap');
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:#291e3b;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        h1 {
            
            text-align: center;
            color: #007bff;
            font-family: "Smooch Sans", serif;
  font-optical-sizing: auto;
  font-weight: 800;
  font-size:50px;
  font-style: normal;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        select,
        /* input, */
        button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input
        {
            width: 94%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
            font-family: "Smooch Sans", serif;
  font-optical-sizing: auto;
  font-weight: 700;
 font-size: 25px;
  font-style: normal;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Record Sale</h1>
        <form method="post">
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

            <button type="submit">Add Sale</button>
        </form>

        <?php if (isset($success_message)) { ?>
            <p class="message success">
                <?= $success_message ?>
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