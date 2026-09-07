<?php
session_start(); // Start the session to check if user is logged in

require_once 'includes/config.php';

$message_sent = false;
$error_message = "";


// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get form data
    $full_name = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");


    // Check empty fields
    if (
        empty($full_name) ||
        empty($email) ||
        empty($subject) ||
        empty($message)
    ) {

        $error_message = "Please fill in all fields.";

    }


    // Check email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error_message = "Please enter a valid email address.";

    }


    // Save message
    else {

        $sql = $conn->prepare(
            "INSERT INTO messages
            (full_name, email, subject, message)
            VALUES (?, ?, ?, ?)"
        );


        $sql->bind_param(
            "ssss",
            $full_name,
            $email,
            $subject,
            $message
        );


        if ($sql->execute()) {

            $message_sent = true;

        } else {

            $error_message = "Message could not be sent.";

        }


        $sql->close();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactt</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/contact.css">
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
              <a href="#"
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

 <!--Hero section-->
<section class="hero1">
    <div class="hero-text">
        <h1>Contact Us</h1>
        <p>we’d love to hear from you. Send us a message and we’ll get back to you as soon as possible.</p>
    </div>
    <div class="hero-img">
        <img src="photos/pngtree-contact-us-icons-merged-into-composite-image-photo-image_29628458.jpg" alt="Hero section image" width="400px">
    </div>
</section>


 <!--Contavt form section-->

 <?php if ($message_sent): ?>

    <div class="success-message">
        Message sent successfully!
    </div>

<?php endif; ?>


<?php if (!empty($error_message)): ?>

    <div class="error-message">
        <?php echo htmlspecialchars($error_message); ?>
    </div>

<?php endif; ?>

<section class="contact-section">
     <div class="contact-form">

        <h2>Send Us a Message</h2>

    <form action="contact.php" method="POST">

        <label>Full Name</label>
        <input type="text" name="full_name" placeholder="Your Name" required>

        <label>Email Address</label>
        <input type="email" name="email" placeholder="Enter Your Email" required>

        <label>Subject</label>
        <select required>
            <option>Programming</option>
            <option>Mathematics</option>
            <option>Business</option>
            <option>Multimedia</option>
            <option>Networking</option>
            <option>Database</option>
        </select>

        <label>Message</label>
        <textarea name="message" placeholder="Write your message..." required></textarea>

        <button type="submit">Send Message</button>

    </form>

    </div>
</section>

<!--Footer-->
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

        <a href="home.php">Home</a>
        <a href="Browse Notes.php">Browse Notes</a>
        <a href="#">Upload Notes</a>
        <a href="about us.php">About Us</a>

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
        nav_menu_icon.src = "photos/menu.svg";
    }else{
        navbar_links.style.display = "block";
        nav_menu_icon.src = "photos/cancel.svg";
        nav_menu_icon.style.width = "35px"
        
    }
})

</script>

    
</body>
</html>