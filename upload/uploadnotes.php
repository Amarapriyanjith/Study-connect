<?php
session_start();

require_once '../includes/config.php';

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: ../login page.php");
    exit();
}

$message = "";
$message_type = "";

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $topic = trim($_POST["topic"] ?? "");
    $course_level = trim($_POST["course_level"] ?? "");
    $description = trim($_POST["description"] ?? "");

    /* Check required fields */
    if (
        empty($title) ||
        empty($subject) ||
        empty($topic) ||
        empty($course_level) ||
        empty($_FILES["note_file"]["name"])
    ) {

        $message = "Please fill in all required fields.";
        $message_type = "error";

    } else {

        /* File information */
        $file_name = $_FILES["note_file"]["name"];
        $file_tmp = $_FILES["note_file"]["tmp_name"];
        $file_size = $_FILES["note_file"]["size"];

        /* Get file extension */
        $file_extension = strtolower(
            pathinfo($file_name, PATHINFO_EXTENSION)
        );

        /* Allow PDF only */
        if ($file_extension !== "pdf") {

            $message = "Only PDF files are allowed.";
            $message_type = "error";

        } elseif ($file_size > 10 * 1024 * 1024) {

            $message = "File size must be less than 10 MB.";
            $message_type = "error";

        } else {

            /* Create unique file name */
            $new_file_name = uniqid("note_", true) . ".pdf";

            /* Upload directory */
            $upload_directory = __DIR__ . "/uploads/";

            /* Create folder if it does not exist */
            if (!is_dir($upload_directory)) {
                mkdir($upload_directory, 0777, true);
            }

            /* Full upload path */
            $upload_path = $upload_directory . $new_file_name;


            /* Move uploaded file */
            if (move_uploaded_file($file_tmp, $upload_path)) {

                /* Prepare database query */
                $sql = $conn->prepare(
                    "INSERT INTO notes
                    (title, subject, topic, course_level, description, file_name, uploaded_by)
                    VALUES (?, ?, ?, ?, ?, ?, ?)"
                );

                if (!$sql) {

                    $message = "Database error: " . $conn->error;
                    $message_type = "error";

                    /* Delete uploaded file */
                    if (file_exists($upload_path)) {
                        unlink($upload_path);
                    }

                } else {

                    $sql->bind_param(
                        "ssssssi",
                        $title,
                        $subject,
                        $topic,
                        $course_level,
                        $description,
                        $new_file_name,
                        $user_id
                    );

                    /* Execute database query */
                    if ($sql->execute()) {

                        $message = "Note uploaded successfully!";
                        $message_type = "success";

                    } else {

                        $message = "Could not save note information.";
                        $message_type = "error";

                        /* Delete file if database insertion fails */
                        if (file_exists($upload_path)) {
                            unlink($upload_path);
                        }
                    }

                    $sql->close();
                }

            } else {

                /* File upload failed */
                $message = "Failed to upload the file.";
                $message_type = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Upload Notes</title>

    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/uploadnotes.css">


</head>

<body>

<header>

    <div class="navbar">

        <div class="logo">
            <img src="../photos/graduation-cap.png" alt="logo">

            <h2>Student Resource Hub</h2>
        </div>

        <div class="navbar-links">

            <ul>

                <li>
                    <a href="home.php">Home</a>
                </li>

                <li>
                    <a href="features.php">Features</a>
                </li>

                <li>
                    <a href="Browse Notes.php">Browse Notes</a>
                </li>

                <li>
                    <a href="about us.php">About</a>
                </li>

                <li>
                    <a href="contact.php">Contact</a>
                </li>

            </ul>

        </div>

    </div>

</header>


<section class="upload-section">

    <div class="upload-container">

        <?php if (!empty($message)): ?>

            <?php if ($message_type === "success"): ?>

                <div class="success-message">
                    ✓ <?php echo htmlspecialchars($message); ?>
                </div>

            <?php else: ?>

                <div class="error-message">
                    ! <?php echo htmlspecialchars($message); ?>
                </div>

            <?php endif; ?>

        <?php endif; ?>


        <h1>Upload Study Notes</h1>

        <p>
            Share your study materials with other students.
        </p>


        <form action="uploadnotes.php"
              method="POST"
              enctype="multipart/form-data">


            <div class="form-group">

                <label>Note Title</label>

                <input type="text"
                       name="title"
                       placeholder="Enter note title"
                       required>

            </div>


            <div class="form-group">

                <label>Subject</label>

                <select name="subject" required>

                    <option value="">Select Subject</option>

                    <option value="Mathematics">
                        Mathematics
                    </option>

                    <option value="Programming">
                        Programming
                    </option>

                    <option value="Business">
                        Business
                    </option>

                    <option value="Multimedia">
                        Multimedia
                    </option>

                    <option value="Networking">
                        Networking
                    </option>

                    <option value="Database">
                        Database
                    </option>

                    <option value="Statistics">
                        Statistics
                    </option>

                    <option value="Reverse Engineering">
                        Reverse Engineering
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Topic</label>

                <input type="text"
                       name="topic"
                       placeholder="Example: Introduction to C Programming"
                       required>

            </div>


            <div class="form-group">

                <label>Course Level</label>

                <select name="course_level" required>

                    <option value="">Select Course Level</option>

                    <option value="Undergraduate">
                        Undergraduate
                    </option>

                    <option value="Graduate">
                        Graduate
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Description</label>

                <textarea
                    name="description"
                    placeholder="Write a short description about the note..."
                ></textarea>

            </div>


            <div class="form-group">

                <label>Upload PDF</label>

                <div class="file-upload">

                    <input type="file"
                        id="note_file"
                        name="note_file"
                        accept=".pdf"
                        required>

                    <label for="note_file" class="file-label">
                        <span class="upload-icon">↑</span>
                        <span>Choose PDF File</span>
                    </label>

                    <span class="file-name" id="file-name">
                        No file chosen
                    </span>

                </div>

            </div>


            <button type="submit"
                    class="upload-btn">

                Upload Note

            </button>

        </form>

    </div>

</section>

<script>
    const fileInput = document.getElementById("note_file");
    const fileName = document.getElementById("file-name");

    fileInput.addEventListener("change", function () {

        if (this.files.length > 0) {
            fileName.textContent = this.files[0].name;
        } else {
            fileName.textContent = "No file chosen";
        }

    });
</script>


</body>

</html>