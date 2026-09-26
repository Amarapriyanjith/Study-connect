<?php
session_start();

require_once 'includes/config.php';

/* Get selected subject */
$selected_subject = $_GET['subject'] ?? '';

/* If no subject is selected */
if (empty($selected_subject)) {
    header("Location: Browse Notes.php");
    exit();
}

/*PAGINATION SETTINGS*/

$notes_per_page = 8;

/* Get current page */
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($current_page < 1) {
    $current_page = 1;
}

/* Calculate starting record */
$offset = ($current_page - 1) * $notes_per_page;


/*COUNT TOTAL NOTES*/

$count_stmt = $conn->prepare(
    "SELECT COUNT(*) AS total
     FROM notes
     WHERE subject = ?"
);

$count_stmt->bind_param("s", $selected_subject);
$count_stmt->execute();

$count_result = $count_stmt->get_result();
$total_notes = $count_result->fetch_assoc()['total'];

$count_stmt->close();


/*CALCULATE TOTAL PAGES*/

$total_pages = ceil($total_notes / $notes_per_page);


/* If page is greater than total pages */
if ($total_pages > 0 && $current_page > $total_pages) {
    $current_page = $total_pages;
    $offset = ($current_page - 1) * $notes_per_page;
}


/*GET NOTES FOR CURRENT PAG*/

$stmt = $conn->prepare(
    "SELECT *
     FROM notes
     WHERE subject = ?
     ORDER BY id DESC
     LIMIT ? OFFSET ?"
);

$stmt->bind_param(
    "sii",
    $selected_subject,
    $notes_per_page,
    $offset
);

$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo htmlspecialchars($selected_subject); ?> Notes
    </title>

   
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/all notes.css">
    <link rel="stylesheet" href="css/footer.css">

</head>

<body>


<!--NAVIGATION BAR-->

<header>

    <div class="navbar">

        <div class="logo">

            <img
                src="photos/graduation-cap.png"
                alt="Student Resource Hub Logo"
            >

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


            <!-- Login / Account buttons -->

            <div class="navbar-buttons">

                <?php
                if (
                    isset($_SESSION['is_logged_in']) &&
                    $_SESSION['is_logged_in'] === true
                ):
                ?>

                    <a href="#">
                        <button id="signup">
                            Account
                        </button>
                    </a>

                    <a href="includes/logout.php"">
                        <button id="login">
                            Logout
                        </button>
                    </a>

                <?php else: ?>

                    <a href="login page.php">
                        <button id="signup">
                            Login
                        </button>
                    </a>

                    <a href="register.php">
                        <button id="login">
                            Register
                        </button>
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</header>



<!--ALL NOTES SECTION-->

<section class="all-notes-section">

    <div class="all-notes-container">


        <!-- Back button -->

        <a
            href="Browse Notes.php"
            class="back-btn"
        >
            ← Back to Browse Notes
        </a>


        <!-- Page heading -->

        <div class="all-notes-header">

            <h1>
                <?php
                echo htmlspecialchars($selected_subject);
                ?>
                Notes
            </h1>

            <p>
                Browse all study notes uploaded under
                <strong>
                    <?php
                    echo htmlspecialchars($selected_subject);
                    ?>
                </strong>
            </p>

        </div>



        <!--NOTES-->

        <?php if ($result->num_rows > 0): ?>

            <div class="notes-grid">

                <?php while ($note = $result->fetch_assoc()): ?>


                    <div class="note-card">


                        <!-- PDF icon -->

                        <div class="pdf-icon">
                            📄
                        </div>


                        <!-- Note title -->

                        <h3>

                            <?php
                            echo htmlspecialchars(
                                $note['title']
                            );
                            ?>

                        </h3>


                        <!-- Subject -->

                        <p class="note-subject">

                            <?php
                            echo htmlspecialchars(
                                $note['subject']
                            );
                            ?>

                        </p>


                        <!-- Topic -->

                        <p class="note-topic">

                            <strong>Topic:</strong>

                            <?php
                            echo htmlspecialchars(
                                $note['topic']
                            );
                            ?>

                        </p>


                        <!-- Course level -->

                        <span class="note-level">

                            <?php
                            echo htmlspecialchars(
                                $note['course_level']
                            );
                            ?>

                        </span>


                        <!-- Description -->

                        <?php
                        if (!empty($note['description'])):
                        ?>

                            <p class="note-description">

                                <?php
                                echo htmlspecialchars(
                                    $note['description']
                                );
                                ?>

                            </p>

                        <?php endif; ?>


                        <!-- View PDF button -->

                        <a
                            href="upload/uploads/<?php
                                echo htmlspecialchars(
                                    $note['file_name']
                                );
                            ?>"
                            target="_blank"
                            class="view-note-btn"
                        >
                            View PDF →
                        </a>


                    </div>


                <?php endwhile; ?>

            </div>


        <?php else: ?>


            <!-- No notes -->

            <div class="no-notes">

                <div class="no-notes-icon">
                    📄
                </div>

                <h2>
                    No Notes Found
                </h2>

                <p>
                    There are currently no notes uploaded
                    for this subject.
                </p>

                <a
                    href="Browse Notes.php"
                    class="back-to-browse"
                >
                    Back to Browse Notes
                </a>

            </div>


        <?php endif; ?>


    </div>

    <?php if ($total_pages > 1): ?>

<div class="pagination">

    <!-- Previous -->
    <?php if ($current_page > 1): ?>

        <a
            href="all notes.php?subject=<?php echo urlencode($selected_subject); ?>&page=<?php echo $current_page - 1; ?>"
            class="page-btn"
        >
            ← Previous
        </a>

    <?php endif; ?>


    <!-- Page Numbers -->
    <?php for ($page = 1; $page <= $total_pages; $page++): ?>

        <a
            href="all notes.php?subject=<?php echo urlencode($selected_subject); ?>&page=<?php echo $page; ?>"
            class="page-number <?php echo ($page == $current_page) ? 'active' : ''; ?>"
        >
            <?php echo $page; ?>
        </a>

    <?php endfor; ?>


    <!-- Next -->
    <?php if ($current_page < $total_pages): ?>

        <a
            href="all notes.php?subject=<?php echo urlencode($selected_subject); ?>&page=<?php echo $current_page + 1; ?>"
            class="page-btn"
        >
            Next →
        </a>

    <?php endif; ?>

</div>

<?php endif; ?>

</section>



<!-- FOOTER-->

<footer>

    <div class="footer-col">

        <h3>
            Student Resource Hub
        </h3>

        <p>
            A platform for students to discover,
            share and learn from quality resources.
        </p>

    </div>


    <div class="footer-col">

        <h3>
            Quick Links
        </h3>

        <a href="home.php">
            Home
        </a>

        <a href="Browse Notes.php">
            Browse Notes
        </a>

        <a href="upload/uploadnotes.php">
            Upload Notes
        </a>

        <a href="about us.php">
            About Us
        </a>

    </div>


    <div class="footer-col">

        <h3>
            Categories
        </h3>

        <a href="Browse Notes.php?subject=Computer Science">
            Computer Science
        </a>

        <a href="Browse Notes.php?subject=Mathematics">
            Mathematics
        </a>

        <a href="Browse Notes.php?subject=Engineering">
            Engineering
        </a>

        <a href="Browse Notes.php?subject=Science">
            Science
        </a>

    </div>

</footer>


</body>

</html>

<?php
$stmt->close();
?>