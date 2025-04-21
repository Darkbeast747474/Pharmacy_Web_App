<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
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
    <div class="hamburger" onclick="toggleNavbar()">
        &#9776;
    </div>

    <nav class="navbar">
        <h1><i class="fa-solid fa-stethoscope"></i>PMS</h1>
        <ul class="nav_list">
            <div>
                <li><a class="nav_elements active" href="#" onclick="load(event,'Dashboard.php',this)"><i class="fas fa-tv"></i> Dashboard</a></li>
                <li><a class="nav_elements" href="#" onclick="load(event,'invoice.php',this)"><i class="fa-solid fa-magnifying-glass"></i>Invoice</a></li>
            </div><br>
            <div>
                <p>Medicine</p>
                <li><a class="nav_elements" href="#" onclick="load(event,'add_medications.php',this)"><i class="fa-solid fa-pills"></i>Add Medicine</a></li>
                <li><a class="nav_elements" href="#" onclick="load(event,'manage_medications.php',this)"><i class="fa-solid fa-house-medical"></i>Manage Medicine</a></li>
            </div><br>
            <div>
                <p>Staff</p>
                <li><a class="nav_elements" href="#" onclick="load(event,'add_staff.php',this)"><i class="fa-solid fa-user"></i>Add Staff</a></li>
                <li><a class="nav_elements" href="#" onclick="load(event, 'staff_list.php',this)"><i class="fa-solid fa-briefcase"></i>Manage Staff</a></li>
            </div><br>
            <div>
                <p>Reports</p>
                <li><a class="nav_elements" href="#" onclick="load(event, 'stock_report.php',this)"><i class="fa-solid fa-chart-simple"></i>Stock Reports</a></li>
                <li><a class="nav_elements" href="#" onclick="load(event, 'sales_report.php',this)"><i class="fa-solid fa-receipt"></i>Sales Reports</a></li>
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
    function load(event, url, clickedElement) {
        event.preventDefault();

        document.getElementById("content").src = url;

        document.querySelectorAll(".nav_list a").forEach((navLink) => {
            navLink.classList.remove("active");
        });

        clickedElement.classList.add("active");
    }



    function toggleNavbar() {
        const navbar = document.querySelector(".navbar");
        navbar.classList.toggle("collapsed");

        const content = document.getElementById("content");
        if (navbar.classList.contains("collapsed")) {
            content.style.left = "60px";
        } else {
            content.style.left = "240px";
        }
    }
</script>

</html>