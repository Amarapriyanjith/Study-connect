<?php
session_start();
require_once 'includes/config.php';

/*CHECK IF USER IS LOGGED IN*/

if (!isset($_SESSION['user_id'])) {
    header("Location: login page.html");
    exit();
}

$user_id = $_SESSION['user_id'];


/*GET USER INFORMATION*/

$stmt = $conn->prepare("
    SELECT fullname, email, username
    FROM users
    WHERE id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    $fullname = $user['fullname'];
    $email = $user['email'];
    $username = $user['username'];

} else {

    session_destroy();
    header("Location: login page.html");
    exit();
}

$stmt->close();


/*GET NOTES UPLOADED BY CURRENT USER*/

$my_notes = $conn->prepare("
    SELECT id, title, subject, topic, course_level, description, file_name
    FROM notes
    WHERE uploaded_by = ?
    ORDER BY id DESC
");

$my_notes->bind_param("i", $user_id);
$my_notes->execute();

$my_notes_result = $my_notes->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Account - Study Connect</title>

    <link rel="stylesheet" href="css/account.css">
</head>

<body>

    <section class="account-page">

        <div class="account-container">

            <h1>My Account</h1>

            <div class="account-card">

                <div class="profile-section">

                    <div class="profile-icon">
                        👤
                    </div>

                    <h2>
                        <?php echo htmlspecialchars($fullname); ?>
                    </h2>

                    <div class="profile-details">

                        <div class="profile-row">
                            <strong>Full Name:</strong>
                            <span>
                                <?php echo htmlspecialchars($fullname); ?>
                            </span>
                        </div>

                        <div class="profile-row">
                            <strong>Email:</strong>
                            <span>
                                <?php echo htmlspecialchars($email); ?>
                            </span>
                        </div>

                        <div class="profile-row">
                            <strong>Username:</strong>
                            <span>
                                <?php echo htmlspecialchars($username); ?>
                            </span>
                        </div>

                    </div>

                    <a href="update profile.php" class="edit-profile-btn">
                        Edit Profile
                    </a>

                </div>


                <!-- Change Password Section -->
                <div class="change-password-section">

                    <h2>Change Password</h2>

                    <form action="change password.php" method="POST">

                        <label for="current_password">
                            Current Password
                        </label>

                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            required
                        >


                        <label for="new_password">
                            New Password
                        </label>

                        <input
                            type="password"
                            id="new_password"
                            name="new_password"
                            required
                        >


                        <label for="confirm_password">
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            required
                        >


                        <button type="submit">
                            Change Password
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </section>

    <!-- My Uploaded Notes Section -->
<section class="my-notes-section">

    <div class="my-notes-container">

        <h2>My Uploaded Notes</h2>

        <p class="my-notes-subtitle">
            Notes you have uploaded to Student Resource Hub
        </p>

        <?php if ($my_notes_result->num_rows > 0): ?>

            <div class="my-notes-grid">

                <?php while ($note = $my_notes_result->fetch_assoc()): ?>

                    <div class="my-note-card">

                        <div class="my-note-icon">
                            📄
                        </div>

                        <h3>
                            <?php echo htmlspecialchars($note['title']); ?>
                        </h3>

                        <p>
                            <strong>Subject:</strong>
                            <?php echo htmlspecialchars($note['subject']); ?>
                        </p>

                        <p>
                            <strong>Topic:</strong>
                            <?php echo htmlspecialchars($note['topic']); ?>
                        </p>

                        <p>
                            <strong>Level:</strong>
                            <?php echo htmlspecialchars($note['course_level']); ?>
                        </p>

                        <?php if (!empty($note['description'])): ?>

                            <p class="my-note-description">
                                <?php echo htmlspecialchars($note['description']); ?>
                            </p>

                        <?php endif; ?>

                            <a
                                href="upload/uploads/<?php echo htmlspecialchars($note['file_name']); ?>"
                                target="_blank"
                                class="note-button"
                            >
                                View PDF →
                            </a>

                            <a
                                href="delete_note.php?id=<?php echo $note['id']; ?>"
                                class="delete-note-button"
                                onclick="return confirm('Are you sure you want to delete this note?');"
                            >
                                Delete
                            </a>

                    </div>

                <?php endwhile; ?>

            </div>

        <?php else: ?>

            <div class="no-notes">

                <div class="no-notes-icon">
                    📄
                </div>

                <h3>No Notes Uploaded Yet</h3>

                <p>
                    You haven't uploaded any study notes yet.
                </p>

                <a href="upload/uploadnotes.php" class="upload-my-note-btn">
                    Upload Notes
                </a>

            </div>

        <?php endif; ?>

    </div>

</section>

</body>
</html>