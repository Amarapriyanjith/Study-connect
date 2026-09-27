<?php
session_start(); // Start the session to check if user is logged in
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/login and register.css">
    
</head>
<body>
    
        <div class="login-container">

    <!-- Login/Register Tabs -->

    <div class="tabs">

        <button class="active">Login</button>

        <button onclick="location.href='register.php'">
            Register
        </button>

    </div>

    <!-- Login Form -->

    <form action="includes/login.php" method="POST">

        <div class="form-group">

            <label>User Name:</label>

            <input type="text" name="uname" placeholder="Enter your Username" required>

        </div>

        <div class="form-group">

            <div class="password-title">

                <label>Password:</label>
                

                <a href="#">Forgot Password?</a>

            </div>
            <input type="password" name="pwd" placeholder="Enter your password" required>



        </div>

        <div class="remember">

            <label>

                <input type="checkbox">

                Remember me

            </label>

        </div>

        <button type="submit" name="submit" class="login-btn">
            Login
        </button>

    </form>

    <!-- Divider -->

    <!-- Register -->

    <p class="signup">

        Don't have an Account?

        <a href="register.php">
            Register
        </a>

    </p>

</div>
    
    
</body>
</html>