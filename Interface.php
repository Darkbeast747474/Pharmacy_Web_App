<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="static/Interface.css">
    <title>Document</title>
</head>

<body>

    <nav class="navbar">
        <h1><i class="fa-solid fa-stethoscope"></i>PMS</h1>
        <ul class="nav_list">
            <div>
                <li><a class="nav_elements active" href="#" onclick="load('Dashboard.php',this)"><i class="fas fa-tv"></i> Dashboard</a></li>
                <li><a  class="nav_elements" href="#" onclick="load('invoice.php',this)"><i class="fa-solid fa-magnifying-glass"></i>Invoice</a></li>
            </div><br>
            <div>
                <p>Medicine</p>
                <li><a class="nav_elements"  href="#" onclick="load('manage_medications.php',this)"><i class="fa-solid fa-pills"></i>ManageMedicine</a></li>
            </div><br>
            <div>
                <p>Pharmacist</p>
                <li><a class="nav_elements"  href="#" onclick="load('',this)"><i class="fa-solid fa-user"></i>AddPharmacist</a></li>
                <li><a class="nav_elements"  href="#" onclick="load('',this)"><i class="fa-solid fa-briefcase"></i>ManagePharmacist</a></li>
            </div><br>
            <div>
                <p>Reports</p>
                <li><a class="nav_elements"  href="#" onclick="load('',this)"><i class="fa-solid fa-chart-simple"></i>StackReports</a></li>
                <li><a class="nav_elements"  href="#" onclick="load('sales_report.php',this)"><i class="fa-solid fa-receipt"></i>SalesReports</a></li>
            </div>
            <div>
                <div class="logout">
                    <form action="logout.php" method="post">
                        <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </div>
            </div>
        </ul>
    </nav>
    <iframe class="contents" id="content" src="Dashboard.php" frameborder="0"></iframe>
</body>

<script>
    function load(url, element) {
    document.getElementById("content").src = url;

    // Remove 'active' class from all elements
    document.querySelectorAll(".nav_list a").forEach((element) => {
        element.classList.remove("active");
    });

    // Add 'active' class to the clicked element
    element.classList.add("active");
}
</script>

</html>