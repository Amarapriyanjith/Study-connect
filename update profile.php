<?php
session_start();

require_once 'includes/config.php';

/* Check if user is logged in */
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login page.php");
    exit();
}

/* Only allow POST requests */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: edit profile.php");
    exit();
}

/* Get user ID from session */
$user_id = $_SESSION['user_id'];

/* Get submitted information */
$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$username = trim($_POST['username'] ?? '');

/* Validate fields */
if (empty($fullname) || empty($email) || empty($username)) {
    echo "<script>
        alert('Please fill in all fields.');
        window.location.href='edit profile.php';
    </script>";
    exit();
}

/* Validate email */
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>
        alert('Please enter a valid email address.');
        window.location.href='edit profile.php';
    </script>";
    exit();
}

/* Check if email or username is already used by another user */
$checkStmt = $conn->prepare(
    "SELECT id FROM users 
     WHERE (email = ? OR username = ?) 
     AND id != ?"
);

$checkStmt->bind_param(
    "ssi",
    $email,
    $username,
    $user_id
);

$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {

    $checkStmt->close();

    echo "<script>
        alert('Email or username is already being used by another account.');
        window.location.href='edit_profile.php';
    </script>";

    exit();
}

$checkStmt->close();

/* Update user information */
$updateStmt = $conn->prepare(
    "UPDATE users 
     SET fullname = ?, email = ?, username = ?
     WHERE id = ?"
);

$updateStmt->bind_param(
    "sssi",
    $fullname,
    $email,
    $username,
    $user_id
);

if ($updateStmt->execute()) {

    /* Update session information */
    $_SESSION['fullname'] = $fullname;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;
    $_SESSION['user'] = $username;

    $updateStmt->close();
    $conn->close();

    header("Location: account.php?updated=success");
    exit();

} else {

    $updateStmt->close();
    $conn->close();

    echo "<script>
        alert('Could not update your profile. Please try again.');
        window.location.href='edit profile.php';
    </script>";

    exit();
}
?>