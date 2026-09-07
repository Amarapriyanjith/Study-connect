<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Match inputs with the names used in your login page.php (uname and pwd)
    $username = trim($_POST['uname']);
    $password = $_POST['pwd'];

    // Search by username
    $stmt = $conn->prepare("SELECT id, fullname, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $fullname, $db_username, $hashed_password);
        $stmt->fetch();

        // Verify password securely
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['username'] = $db_username;
            $_SESSION['user'] = $db_username;
            $_SESSION['is_logged_in'] = true;   // <-- add this

            header("Location: ../home.php");
            exit();
        } else {
            // Password is wrong
            echo "<script>alert('Invalid Password!'); window.location.href='../login page.php';</script>";
            exit();
        }
    } else {
        // No account found with this username
        echo "<script>alert('No account found with this username.'); window.location.href='../login page.php';</script>";
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>