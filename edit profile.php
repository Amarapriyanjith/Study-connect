<?php
session_start();

require_once 'includes/config.php';

/* Check login */
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login page.php");
    exit();
}

/* Get current user */
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT fullname, email, username 
     FROM users 
     WHERE id = ?"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    session_destroy();
    header("Location: login page.php");
    exit();
}

$user = $result->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Profile - Study Connect</title>

    <link rel="stylesheet" href="css/account.css">
</head>

<body>

<section class="account-page">

    <div class="account-container">

        <h1>Edit Profile</h1>

        <div class="account-card">

            <form action="update profile.php" method="POST">

                <div class="profile-form-group">
                    <label for="fullname">Full Name</label>

                    <input
                        type="text"
                        id="fullname"
                        name="fullname"
                        value="<?php echo htmlspecialchars($user['fullname']); ?>"
                        required
                    >
                </div>

                <div class="profile-form-group">
                    <label for="email">Email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($user['email']); ?>"
                        required
                    >
                </div>

                <div class="profile-form-group">
                    <label for="username">Username</label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?php echo htmlspecialchars($user['username']); ?>"
                        required
                    >
                </div>

                <div class="profile-form-actions">

                    <button type="submit" class="edit-profile-btn">
                        Save Changes
                    </button>

                    <a href="account.php" class="cancel-btn">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</section>

</body>

</html>