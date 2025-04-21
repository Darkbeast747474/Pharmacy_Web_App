<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include 'Db_Config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staff_id'])) {
    $staff_id = $con->real_escape_string($_POST['staff_id']);

    $delete = $con->query("DELETE FROM staff WHERE staff_id = '$staff_id'");

    if ($delete) {
        header("Location: staff_list.php"); 
    } else {
        echo "Error deleting staff: " . $con->error;
    }
} else {
    echo "Invalid request.";
}
?>
