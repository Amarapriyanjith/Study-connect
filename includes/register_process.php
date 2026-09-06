<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve inputs matching register.html names
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['pwd'];
    $confirm_password = $_POST['pwdrepeat'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.location.href='../register.html';</script>";
        exit();
    }

    // Check if email or username already exists in the database
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $checkStmt->bind_param("ss", $email, $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "<script>alert('Email or Username already exists. Please choose another.'); window.location.href='../register.html';</script>";
        $checkStmt->close();
        exit();
    }
    $checkStmt->close();

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $insertStmt = $conn->prepare("INSERT INTO users (fullname, email, username, password) VALUES (?, ?, ?, ?)");
    $insertStmt->bind_param("ssss", $fullname, $email, $username, $hashed_password);

    if ($insertStmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='../login page.html';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.location.href='../register.html';</script>";
    }

    $insertStmt->close();
    $conn->close();
}
?>