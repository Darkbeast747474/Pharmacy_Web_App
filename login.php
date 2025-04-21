<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Login</title>
    <link rel="stylesheet" href="static/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>

<video autoplay muted loop class="Video_BG">
    <source src="static/5998380-hd_1920_1080_30fps.mp4" type="video/mp4" />
    Your browser does not support the video tag.
  </video>
  <h1 class="pms"><i class="fa-solid fa-stethoscope"></i> <a href="index.php">PMS</a></h1>
    <div class="box">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <h1>Admin</h1>
            <div class="input_box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input_box">
                <input type="password" name="password" placeholder="Password" required id="password">
                <i class='bx bx-show-alt toggle-password' id="togglePassword" style="cursor:pointer;"></i>
            </div>
            <button type="submit" class="btn">Login</button>
            <p class="register-link">Don't have an account? <a href="register.php">Register</a></p>
        </form>
        <div id="loginForm"></div>
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

<?php
if ($_REQUEST) {
    include "Db_Config.php";

    $un = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = "SELECT * FROM Admins WHERE username = '$un' AND password ='$pass'";
    $result = $con->query($stmt);

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['username'] = $un;
        header("Location: Interface.php");
        exit();
    } else {
        $script = <<<EOF
        <script> 
        const errorParagraph = document.createElement('p');
        errorParagraph.classList.add('error-message');
        errorParagraph.textContent = "Invalid username or password. Please try again.";
        const form = document.getElementById('loginForm');
        form.appendChild(errorParagraph);
        </script>
        EOF;
        echo $script;
    }
}
?>