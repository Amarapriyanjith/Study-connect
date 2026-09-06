<?php
session_start(); // Start the session to check if user is logged in
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/about us.css">
    
</head>
<body>
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
              <a href="#"
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
            <a href="login page.html"><button id="signup">Login</button></a>
            <a href="register.html"><button id="login">Register</button></a>
          </div>
        </div>
        <div class="menu-icon">
          <img src="photos/menu.svg" alt="menu" id="menu-icon" />
        </div>
      </div>
</header>
    <section class="hero2">
        <div class="topics">
            <h2>About Student Resource Hub</h2>
            <p>Helping students discover,</p>
            <p>share and learn together.</p>

            <div class="button">
                <a href="Browse Notes.php" class="btn">Browse Notes</a>
                <a href="contact.html" class="btn">Contact Us</a>
            </div>
        </div>
        
        <div class="topics-image">
            <img src="photos/topic image.jpg" alt="image">
        </div>


    </section>

<section class="story">

    <h2>Our Story</h2>

    <div class="story-container">

        <div class="story-image">
            <img src="photos/OUT STORY.jpg" alt="Students studying">
        </div>

        <div class="story-content">

            <p>
                Student Resource Hub was created with one simple goal:
                to make learning easier and more accessible for every
                student.
            </p>

            <p>
                We noticed that students often struggle to find quality
                study materials and share notes with classmates.
                Our platform helps students upload, browse and download
                educational resources in one place.
            </p>

            <a href="features.php" class="btn">
                Explore Resources
            </a>

        </div>

    </div>

</section>

<section class="mission">

    <h2>Our Mission</h2>

    <div class="mission-container">

        <div class="card">

            <img src="photos/book.jpg" alt="book">

            <h3>Quality Learning</h3>

            <p>
                Provide reliable educational resources for every student.
            </p>

        </div>

        <div class="card">

            <img src="photos/handshake.jpg" alt="handshake">

            <h3>Community</h3>

            <p>
                Encourage collaboration and knowledge sharing.
            </p>

        </div>

        <div class="card">

            <img src="photos/cap.jpg" alt="cap">

            <h3>Innovation</h3>

            <p>
                Use technology to improve the learning experience.
            </p>

        </div>

    </div>

</section>
<section class="why-us">

    <h2>Why Choose Us?</h2>

    <div class="features-grid">

        <div class="feature-card">
            <img src="photos/save.jpg" alt="upload">
            <h3>Upload Notes</h3>
            <p>Share study materials with other students.</p>
        </div>

        <div class="feature-card">
            <img src="photos/search.png" alt="search">
            <h3>Easy Search</h3>
            <p>Quickly find notes and learning resources.</p>
        </div>

        <div class="feature-card">
            <img src="photos/star1.png"quality content">
            <h3>Quality Content</h3>
            <p>Helpful and reliable educational materials.</p>
        </div>

        <div class="feature-card">
            <img src="photos/responsive.jpg" alt="responsive">
            <h3>Responsive</h3>
            <p>Works smoothly on desktop, tablet, and mobile.</p>
        </div>

    </div>

</section>     
<section class="team">

    <h2>Meet Our Team</h2>

    <div class="team-container">

        <div class="member">

            <img src="photos/member 1.jpeg" alt="Member">

            <h3>Team Member 1</h3>

            <p>Developer</p>

        </div>

        <div class="member">

            <img src="photos/member 2.jpeg" alt="Member">

            <h3>Team Member 2</h3>

            <p>Developer</p>

        </div>

</section>
<section class="cta">

    <h2>Join Our Learning Community</h2>

    <p>
        Start exploring resources, upload your notes, and learn together.
    </p>

    <a href="#" class="btn">Get Started</a>

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

        <a href="home.html">Home</a>
        <a href="Browse Notes.html">Browse Notes</a>
        <a href="#">Upload Notes</a>
        <a href="about us.html">About Us</a>

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