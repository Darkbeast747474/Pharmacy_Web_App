<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="static/Dashboard.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <h1>Admin Dashboard</h1>
    <hr>
    <div class="dashboard-container">
        <div class="dashboard-card">
            <i class="fas fa-user-md"></i>
            <h5>Total Pharmacists</h5>
            <p id="total_pharmacists"></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-hospital"></i>
            <h5>Total Medical Companies</h5>
            <p id="total_medical_companies"></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-pills"></i>
            <h5>Total Medicines</h5>
            <p id="total_medicines"></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-rupee-sign"></i>
            <h5>Today's Sale</h5>
            <p id="todays_sale"></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-chart-line"></i>
            <h5>Yesterday's Sale</h5>
            <p id="yesterdays_sale"></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-wallet"></i>
            <h5>Last 7 Days Sale</h5>
            <p id="last_seven_days_sale"></p>
        </div>
        <div class="dashboard-card full-width">
            <i class="fas fa-dollar-sign"></i>
            <h2>Total Sale</h2>

        </div>
    </div>


</body>

</html>