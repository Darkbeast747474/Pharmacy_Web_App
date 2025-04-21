<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

include 'Db_Config.php';
$staff = $con->query("SELECT * FROM staff Where admin_id = '$admin_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #291e3b;
        }

        .container {
            width: 800px;
            margin: auto;
            margin-top: 50px;
            color: #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: rgb(61, 61, 62);
            color: white;
        }

        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Staff Members</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date Joined</th>
                <th>Total Sales</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $staff->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['staff_id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['date_joined'] ?></td>
                    <td><?= $row['total_sales'] ?></td>
                    <td>
                        <form method="POST" action="delete_staff.php" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                            <input type="hidden" name="staff_id" value="<?= $row['staff_id'] ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>