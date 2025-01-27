<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Login</title>
    <link rel="stylesheet" href="static/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="box">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <h1>Admin</h1>
            <div class="input_box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input_box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bx-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <div id="loginForm"></div>
    </div>
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
        $_SESSION['username'] = $username;
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