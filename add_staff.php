<?php
session_start();
if(!isset($_SESSION['username']))
{
    header("Location: login.php");
}
include 'Db_Config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = "INSERT INTO staff (staff_id, name, email, phone ) 
            VALUES ('$staff_id', '$name', '$email', '$phone')";

    if ($con->query($sql) === TRUE) {
        $success_message = "Staff member added successfully!";
    } else {
        $error_message = "Error: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Staff</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            text-align: center;
        }

        .container {
            width: 400px;
            margin: auto;
            background: #fff;
            padding: 20px;
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #007bff;
        }

        input,
        select,
        button {
            width: 80%;
            padding: 10px;
            margin-top: 10px;
        }

        button {
            background: #007bff;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Staff Member</h1>
        <form method="POST">
            <input type="text" name="id" placeholder="Staff ID" required>
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <button type="submit">Add Staff</button>
        </form>

        <?php if (isset($success_message)) echo "<p style='color:green;'>$success_message</p>"; ?>
        <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
    </div>
</body>

</html>