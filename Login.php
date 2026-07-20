<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    
    <div class="form-container">
        <h1>Login</h1>
            <form action ="#" method="POST">

                <!--Email field-->
                <div>
                    <label for ="Email">Email Address:</label>
                    <input type ="email"id="email" name="email" required autocomplete="username" placeholder="you@example.com">
                </div>
                <!--Password field-->

                <div>
                    <label for="  Password">Password:</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="......................">

                </div>
                
                <!-- Remember Me & Forgot Password -->
                <div class="action">
                    <label style="display:flex;align-items:center;gap:0.5rem;>
                    <input type="checkbox" name="remember_me">Remember me </label>
                    <a href="#">Forget Password</a>
                </div>
                <!-- Submit Button -->
                    <button type="submit">Sign In</button>
            </form>
</div>
</body>
</html>