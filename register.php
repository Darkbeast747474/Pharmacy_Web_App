<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "Db_Config.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if user already exists
    $check = $con->prepare("SELECT * FROM Admins WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {
        // Insert new admin
        $stmt = $con->prepare("INSERT INTO Admins (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful. Redirecting to login...'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error occurred while registering.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Admin</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="static/login.css">
</head>

<body>
    <video autoplay muted loop class="Video_BG">
        <source src="static/5998380-hd_1920_1080_30fps.mp4" type="video/mp4" />
        Your browser does not support the video tag.
    </video>
    <h1 class="pms"><i class="fa-solid fa-stethoscope"></i> <a href="index.php">PMS</a></h1>
    <div class="box">
        <form method="POST" action="">
            <h1>Register</h1>
            <div class="input_box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input_box">
            <input type="password" name="password" placeholder="Password" required id="password">
            <i class='bx bx-show-alt toggle-password' id="togglePassword" style="cursor:pointer;"></i>
            </div>
            <button type="submit" class="btn">Register</button>
            <p class="register-link">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle icon class
            this.classList.toggle('bx-show-alt');
            this.classList.toggle('bx-hide');
        });
    </script>

</body>

</html>