<?php
session_start();

require_once 'includes/config.php';
$uploadSuccess = isset($_GET['upload']) && $_GET['upload'] === 'success';

/* Search */
$search = trim($_GET['q'] ?? '');

/* Filters */
$selected_subject = $_GET['subject'] ?? '';
$selected_level = $_GET['course_level'] ?? '';

/* Base query */
$sql = "SELECT * FROM notes WHERE 1=1";

$params = [];
$types = "";

/* Search */
if (!empty($search)) {

    $sql .= " AND (title LIKE ? OR subject LIKE ? OR topic LIKE ?)";

    $searchTerm = "%" . $search . "%";

    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;

    $types .= "sss";
}

/* Subject filter */
if (!empty($selected_subject)) {

    $sql .= " AND subject = ?";

    $params[] = $selected_subject;

    $types .= "s";
}

/* Course level filter */
if (!empty($selected_level)) {

    $sql .= " AND course_level = ?";

    $params[] = $selected_level;

    $types .= "s";
}

$sql .= " ORDER BY id DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Notes</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/browse_note.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    
</head>
<body>


  <!--Navigation Bar-->

    <header>
      <div class="navbar">
        <div class="logo">
        <img src="photos/graduation-cap.png" alt="logo">
        <h2>Student Resource Hub</h2>
        </div>
        <div class="navbar-links" id="navbar-links">
          <ul>
            <li>
              <a href="home.php"
                >Home</a
              >
            </li>
            <li>
              <a href="features.php"
                >Features</a
              >
            </li>
            
            <li>
              <a href="Browse Notes.php"
                >Browse Notes</a
              >
            </li>
            <li>
              <a href="about us.php"
                >About</a
              >
            </li>
            <li>
              <a href="contact.php"
                >Contact</a
              >
            </li>
          </ul>
    <div class="navbar-buttons">
    <?php 
    if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true): 
    ?>
        <a href="#"><button id="signup">Account</button></a>
        <a href="includes/logout.php"><button id="login">Logout</button></a>
    <?php else: ?>
        <a href="login page.php"><button id="signup">Login</button></a>
        <a href="register.php"><button id="login">Register</button></a>
    <?php endif; ?>
    </div>
        </div>
        <div class="menu-icon">
          <img src="photos/menu.svg" alt="menu" id="menu-icon" />
        </div>
      </div>
    </header>



<section>
        <div class="hero">
        <h1>Explore Detailed Study Notes</h1>
        <p class="one">Find the resources you need for your subjects and topics.</p><br>



  <!-- search bar create -->
  <form class="search-box" action="Browse Notes.php" method="GET">
  <input 
    type="search" 
    name="q" 
    placeholder="Search for notes, subject, topics..." 
    aria-label="Search for notes, subject, topics"
  >
  <button type="submit" aria-label="Submit Search">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="11" cy="11" r="8"></circle>
      <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
  </button>
</form>
    </div>
</section>



<!-- Make Filter bar -->
<button class="filter-btn" onclick="toggleFilter()">
    ☰ Filters
</button>
<div class="filter-main">
 <aside class="filter-sidebar">
    <h3 class="filter-title">Filter By</h3>

<!-- Section 1: Subject -->
<div class="filter-group">
    <div class="filter-header">
        <span>Subject</span>
    </div>

    <div class="filter-content">

        <label class="checkbox-container">
            <input 
                type="checkbox"
                onclick="filterSubject('Mathematics')"
                <?php echo ($selected_subject === 'Mathematics') ? 'checked' : ''; ?>
            >
            <span class="checkmark"></span>
            Mathematics
        </label>

        <label class="checkbox-container">
            <input 
                type="checkbox"
                onclick="filterSubject('Programming')"
                <?php echo ($selected_subject === 'Programming') ? 'checked' : ''; ?>
            >
            <span class="checkmark"></span>
            Programming
        </label>

        <label class="checkbox-container">
            <input 
                type="checkbox"
                onclick="filterSubject('Business')"
                <?php echo ($selected_subject === 'Business') ? 'checked' : ''; ?>
            >
            <span class="checkmark"></span>
            Business
        </label>

        <label class="checkbox-container">
            <input 
                type="checkbox"
                onclick="filterSubject('Multimedia')"
                <?php echo ($selected_subject === 'Multimedia') ? 'checked' : ''; ?>
            >
            <span class="checkmark"></span>
            Multimedia
        </label>

        <label class="checkbox-container">
            <input 
                type="checkbox"
                onclick="filterSubject('Networking')"
                <?php echo ($selected_subject === 'Networking') ? 'checked' : ''; ?>
            >
            <span class="checkmark"></span>
            Networking
        </label>

        <label class="checkbox-container">
            <input 
                type="checkbox"
                onclick="filterSubject('Database')"
                <?php echo ($selected_subject === 'Database') ? 'checked' : ''; ?>
            >
            <span class="checkmark"></span>
            Database
        </label>

        <label class="checkbox-container">
            <input 
                type="checkbox"
                onclick="filterSubject('Statistics')"
                <?php echo ($selected_subject === 'Statistics') ? 'checked' : ''; ?>
            >
            Statistics
        </label>

        <label class="checkbox-container">
            <input 
                type="checkbox"
                onclick="filterSubject('Reverse Engineering')"
                <?php echo ($selected_subject === 'Reverse Engineering') ? 'checked' : ''; ?>
            >
            Reverse Engineering
        </label>

    </div>
</div>

<!-- Section 2: Course Level -->
<div class="filter-group">

    <div class="filter-header">
        <span>Course Level</span>
    </div>

    <div class="filter-content">

        <label class="checkbox-container">
            <input
                type="checkbox"
                onclick="filterLevel('Undergraduate')"
                <?php echo ($selected_level === 'Undergraduate') ? 'checked' : ''; ?>
            >
            <span class="checkmark"></span>
            Undergraduate
        </label>

        <label class="checkbox-container">
            <input
                type="checkbox"
                onclick="filterLevel('Graduate')"
                <?php echo ($selected_level === 'Graduate') ? 'checked' : ''; ?>
            >
            <span class="checkmark"></span>
            Graduate
        </label>

    </div>

</div>
        <a href="Browse Notes.php" class="clear-filter">Clear Filters</a>
</aside>

<?php if (!empty($search)): ?>

    <?php if ($uploadSuccess): ?>

    <div class="upload-success-message">
        Note uploaded successfully!
    </div>

<?php endif; ?>

    <!-- Search Results -->
    <section class="search-results-section">

        <h2>Search Results</h2>

        <div class="notes-grid">

            <?php if ($result->num_rows > 0): ?>

            <?php while ($row = $result->fetch_assoc()): ?>

                <div class="note-card">

                    <h3>
                        <?php echo htmlspecialchars($row['title']); ?>
                    </h3>

                    <p>
                        <strong>Subject:</strong>
                        <?php echo htmlspecialchars($row['subject']); ?>
                    </p>

                    <p>
                        <strong>Topic:</strong>
                        <?php echo htmlspecialchars($row['topic']); ?>
                    </p>

                    <p>
                        <strong>Level:</strong>
                        <?php echo htmlspecialchars($row['course_level']); ?>
                    </p>

                    <a
                        href="upload/uploads/<?php echo htmlspecialchars($row['file_name']); ?>"
                        target="_blank"
                        class="view-pdf-btn"
                    >
                        View PDF →
                    </a>

                </div>

            <?php endwhile; ?>

            <?php else: ?>

                <div class="no-results">
                    <h3>No notes found</h3>
                    <p>
                        No notes matched your search.
                        Try another title, subject, or topic.
                    </p>
                </div>

            <?php endif; ?>

        </div>

    </section>

<?php else: ?>

<!-- Subject and note button create section -->

<section class="home">
    <main class="cards-grid">
        <div class="cards">
          <div class="img blue">
              <img src="photos/maths.png" alt="Maths" width="50px">
          </div>
          <a href="Browse Notes.php?subject=Mathematics">
              <h2>Mathematics</h2>
          </a>
        </div>

      <div class="cards">
          <div class="img yellow">
              <img src="photos/web-programming.png" alt="Programming" width="50px">
          </div>
          <a href="Browse Notes.php?subject=Programming">
              <h2>Programming</h2>
          </a>
      </div>

      <div class="cards">
          <div class="img green">
              <img src="photos/business.png" alt="Business" width="50px">
          </div>
          <a href="Browse Notes.php?subject=Business">
              <h2>Business</h2>
          </a>
      </div>

      <div class="cards">
          <div class="img purple">
              <img src="photos/multi media.png" alt="Multimedia" width="50px">
          </div>
          <a href="Browse Notes.php?subject=Multimedia">
              <h2>Multimedia</h2>
          </a>
      </div>

      <div class="cards">
          <div class="img blue">
              <img src="photos/networking.png" alt="Networking" width="50px">
          </div>
          <a href="Browse Notes.php?subject=Networking">
              <h2>Networking</h2>
          </a>
      </div>

      <div class="cards">
          <div class="img yellow">
              <img src="photos/database-file.png" alt="Database" width="50px">
          </div>
          <a href="Browse Notes.php?subject=Database">
              <h2>Database</h2>
          </a>
      </div>

      <div class="cards">
          <div class="img green">
              <img src="photos/Statistic.png" alt="Statistics" width="50px">
          </div>
          <a href="Browse Notes.php?subject=Statistics">
              <h2>Statistics</h2>
          </a>
      </div>

      <div class="cards">
          <div class="img purple">
              <img src="photos/Reverse Engineering.png" alt="Reverse Engineering" width="50px">
          </div>
          <a href="Browse Notes.php?subject=Reverse Engineering">
              <h2>Reverse Engineering</h2>
          </a>
      </div>
            

</main>
</div>
</section>

<?php endif; ?>
</div>

<!-- Latest Study Notes -->
<?php if (!empty($selected_subject)): ?>

    <section class="latest-notes">

        <div class="latest-container">

            <h2>Latest Study Notes</h2>

            <p>
                Latest notes for
                <strong><?php echo htmlspecialchars($selected_subject); ?></strong>
            </p>

            <div class="notes-grid">

                <?php if ($result && $result->num_rows > 0): ?>

                    <?php while ($note = $result->fetch_assoc()): ?>

                        <div class="note-card">

                            <h3>
                                <?php echo htmlspecialchars($note['title']); ?>
                            </h3>

                            <p>
                                <?php echo htmlspecialchars($note['subject']); ?>
                            </p>

                            <p>
                                <?php echo htmlspecialchars($note['topic']); ?>
                            </p>

                            <span>
                                <?php echo htmlspecialchars($note['course_level']); ?>
                            </span>

                            <br><br>

                            <a
                                href="upload/uploads/<?php echo htmlspecialchars($note['file_name']); ?>"
                                target="_blank"
                                class="view-note-btn"
                            >
                                View PDF →
                            </a>

                        </div>

                    <?php endwhile; ?>

                <?php else: ?>

                    <p>
                        No study notes available for
                        <?php echo htmlspecialchars($selected_subject); ?>.
                    </p>

                <?php endif; ?>

            </div>

                 <div class="view-all-container">
                     <a href="all notes.php?subject=<?php echo urlencode($selected_subject); ?>" class="view-all-btn">
                        View All <?php echo htmlspecialchars($selected_subject); ?> Notes →
                     </a>
                 </div>
            
            
            

        </div>

    </section>

<?php endif; ?>

<!-- Upload Notes Section -->
<section class="upload-notes-section">

    <div class="upload-notes-content">

        <div class="upload-notes-icon">
            📚
        </div>

        <div class="upload-notes-text">
            <h2>Share Your Study Notes</h2>

            <p>
                Help other students by sharing your useful study materials
                and notes with the Student Resource Hub community.
            </p>

            <div class="upload-notes-features">
                <span>✓ Easy to Upload</span>
                <span>✓ Share with Students</span>
                <span>✓ PDF Support</span>
            </div>
        </div>

        <div class="upload-notes-button">
            <a href="upload/uploadnotes.php">
                <button>
                    Upload Notes
                    <span>→</span>
                </button>
            </a>
        </div>

    </div>

</section>


<footer>

    <div class="footer-col">

        <h3>Student Resource Hub</h3>

        <p>
            A platform for students to discover,
            share and learn from quality resources.
        </p>

    </div>



    <div class="footer-col">

        <h3>Quick Links</h3>

        <a href="#">Home</a>
        <a href="#">Browse Notes</a>
        <a href="#">Upload Notes</a>
        <a href="#">About Us</a>

    </div>



    <div class="footer-col">

        <h3>Categories</h3>

        <a href="#">Computer Science</a>
        <a href="#">Mathematics</a>
        <a href="#">Engineering</a>
        <a href="#">Science</a>

    </div>



    <div class="footer-col">

        <h3>Newsletter</h3>

        <input type="email" placeholder="Enter your email">

        <button>Subscribe</button>

    </div>

</footer>


<script>

const nav_menu_icon = document.getElementById("menu-icon");
const navbar_links = document.getElementById("navbar-links");

nav_menu_icon.addEventListener("click",()=>{
    
    if(navbar_links.style.display == "block"){
        navbar_links.style.display = "none";
        nav_menu_icon.src = "photos/menu.svg";/*navigation button logo smart phone size page*/
    }else{
        navbar_links.style.display = "block";
        nav_menu_icon.src = "photos/cancel.svg";
        nav_menu_icon.style.width = "35px"
        
    }
})

</script>


<script>
function toggleFilter(){
    document.querySelector(".filter-sidebar").classList.toggle("show");
}

function filterSubject(subject) {
    const url = new URL(window.location.href);

    url.searchParams.set("subject", subject);
    url.searchParams.delete("topic");
    url.searchParams.delete("course_level");

    window.location.href = url.toString();
}

function filterLevel(level) {
    const url = new URL(window.location.href);

    url.searchParams.set("course_level", level);

    window.location.href = url.toString();
}
</script>

</body>
</html>