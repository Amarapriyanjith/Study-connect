<?php
session_start(); // Start the session to check if user is logged in
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="css/login and register.css">
    
</head>
<body>
    <section class="register">

    <div class="register-container">

        <!-- Tabs -->
        <div class="tabs">

            <button onclick="location.href='login page.php'">
                Login
            </button>

            <button class="active">
                Register
            </button>

        </div>

        <!-- Register Form -->
        <form action="includes/register_process.php" method="POST">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text"
                       name="fullname"
                       placeholder="Enter your full name"
                       required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email"
                       name="email"
                       placeholder="Enter your email"
                       required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text"
                       name="username"
                       placeholder="Choose a username"
                       required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password"
                       name="pwd"
                       placeholder="Create a password"
                       required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password"
                       name="pwdrepeat"
                       placeholder="Confirm your password"
                       required>
            </div>

            <div class="remember">
                <label>
                    <input type="checkbox" required>
                    I agree to the Terms & Conditions
                </label>
            </div>

            <button type="submit" class="register-btn">
                Create Account
            </button>

        </form>

        <!-- Divider -->
        <div class="divider">
            <span>or register with</span>
        </div>

        <!-- Social Buttons -->
        <div class="social-login">

            <button class="google">
                <img src="photos/googlr.png" alt="Google">
                Google
            </button>

            <button class="facebook">
                <img src="photos/facebook.png" alt="Facebook">
                Facebook
            </button>

        </div>

        <p class="signup">
            Already have an account?
            <a href="login page.html">Login</a>
        </p>

    </div>

</section>
<!-- Live Availability Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const usernameInput = document.querySelector("input[name='username']");
    const emailInput = document.querySelector("input[name='email']");
    const submitBtn = document.querySelector(".register-btn");

    // Create small text spans for showing messages live
    function createMessageElement(inputElement) {
        let msg = document.createElement("small");
        msg.style.display = "block";
        msg.style.marginTop = "5px";
        inputElement.parentNode.appendChild(msg);
        return msg;
    }

    const usernameMsg = createMessageElement(usernameInput);
    const emailMsg = createMessageElement(emailInput);

    let isUsernameAvailable = true;
    let isEmailAvailable = true;

    function checkAvailability(type, value, messageElement, callback) {
        if (value.trim() === "") {
            messageElement.textContent = "";
            callback(true);
            return;
        }

        let formData = new FormData();
        formData.append(type, value);

        fetch("includes/check_availability.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "taken") {
                messageElement.textContent = `${type === 'username' ? 'Username' : 'Email'} is already taken!`;
                messageElement.style.color = "red";
                callback(false);
            } else {
                messageElement.textContent = `${type === 'username' ? 'Username' : 'Email'} is available.`;
                messageElement.style.color = "green";
                callback(true);
            }
            toggleSubmitButton();
        });
    }

    function toggleSubmitButton() {
        if (isUsernameAvailable && isEmailAvailable) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = "1";
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = "0.5";
        }
    }

    usernameInput.addEventListener("input", function() {
        checkAvailability("username", this.value, usernameMsg, function(status) {
            isUsernameAvailable = status;
        });
    });

    emailInput.addEventListener("input", function() {
        checkAvailability("email", this.value, emailMsg, function(status) {
            isEmailAvailable = status;
        });
    });
});
</script>        
    
    
</body>
</html>