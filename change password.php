<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login page.html");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<script>
                alert('New passwords do not match.');
                window.location.href='account.php';
              </script>";
        exit();
    }

    if (strlen($new_password) < 6) {
        echo "<script>
                alert('New password must be at least 6 characters.');
                window.location.href='account.php';
              </script>";
        exit();
    }

    // Get current password from database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Check current password
    if (!password_verify($current_password, $hashed_password)) {
        echo "<script>
                alert('Current password is incorrect.');
                window.location.href='account.php';
              </script>";
        exit();
    }

    // Hash the new password
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password
    $updateStmt = $conn->prepare(
        "UPDATE users SET password = ? WHERE id = ?"
    );

    $updateStmt->bind_param(
        "si",
        $new_hashed_password,
        $user_id
    );

    if ($updateStmt->execute()) {

        echo "<script>
                alert('Password changed successfully!');
                window.location.href='account.php';
              </script>";

    } else {

        echo "<script>
                alert('Failed to change password. Please try again.');
                window.location.href='account.php';
              </script>";
    }

    $updateStmt->close();
    $conn->close();
}
?>