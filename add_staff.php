<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
include 'Db_Config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = "INSERT INTO staff (admin_id,staff_id, name, email, phone ) 
            VALUES ('$admin_id','$staff_id', '$name', '$email', '$phone')";

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
            background-color: #291e3b;
            text-align: center;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        .container {
            width: 400px;
            margin: auto;
            background: #fff;
            padding: 20px;
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            height: 550px;
            position: relative;
            right: 70px;
            box-shadow: 0px 2px 3px white;
        }

        h1 {
            color: rgb(60, 61, 61);
        }

        input,
        select,
        button {
            width: 80%;
            padding: 10px;
            margin-top: 40px;

        }

        button {
            background: #007bff;
            color: white;
            cursor: pointer;
        }

        input {
            padding: 15px;
        }

        .submit {
            width: 70%;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            border: none;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 4px 6px rgba(0, 123, 255, 0.3);
            letter-spacing: 1px;
            position: relative;
            left: -1%;
            bottom: 10px;
        }

        .submit:hover {
            background: linear-gradient(135deg, #0056b3, #003d7a);
            box-shadow: 0px 6px 10px rgba(0, 85, 204, 0.5);
            transform: translateY(-2px);
        }

        .submit:active {
            transform: translateY(1px);
            box-shadow: 0px 2px 4px rgba(0, 85, 204, 0.3);
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
            <button type="submit" class="submit">Add Staff</button>
        </form>

        <?php if (isset($success_message)) echo "<p style='color:green;'>$success_message</p>"; ?>
        <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
    </div>
</body>

</html>
