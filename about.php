<?php
// Barangay San Jose Web-Based Information System - About Us
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn about the history, vision, mission, and civic heritage of Barangay San Jose in Lapuyan, Zamboanga del Sur.">
    <title>About Us | Barangay San Jose Information System</title>

    <!-- Favicon / Tab Logo -->
        

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/style.css?v=2">
    <link rel="stylesheet" href="assets/css/about.css?v=2">
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-container">
            <!-- Logo & Brand -->
            <a href="index.php" class="navbar-brand">
                <img src="assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="navbar-logo">
                <div class="brand-text">
                    <span class="brand-title">BARANGAY SAN JOSE</span>
                    <span class="brand-subtitle">Bayanihan &bull; Serbisyong Totoo</span>
                </div>
            </a>

            <!-- Desktop Links -->
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php" class="active">About Us</a></li>
                                <li class="dropdown">
                    <a href="javascript:void(0)" class="nav-link">Officials</a>
                    <div class="dropdown-content">
                        <a href="officials.php">Barangay Officials</a>
                        <a href="skofficials.php">SK Officials</a>
                    </div>
                </li>
                <li><a href="announcement.php">Announcement</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="index.php#spot-map">Spot Map</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <!-- Right Side: Admin Login -->
            <div class="navbar-right">
                <a href="Admin/login.php" class="admin-login-link">Admin Login</a>
            </div>
        </div>
    </nav>

    <!-- 1. Hero Section -->
    <section class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <p class="hero-subtitle">ABOUT US</p>
                <h1 class="hero-title">BARANGAY SAN JOSE</h1>
                <p class="hero-desc">A progressive and united community working together<br>for a safer, healthier, and more prosperous San Jose.</p>
            </div>
        </div>
    </section>

    <!-- 2. Main Content Section -->
    <main class="about-main-section">
        <div class="container about-container-new">
            
            <!-- Intro Section -->
            <div class="about-intro">
                <div class="heading-underline-blue"></div>
                <h2 class="about-section-heading">About Barangay San Jose</h2>
                <p class="about-section-desc">Barangay San Jose is a vibrant and united community committed to providing quality public service, promoting peace and order, and creating a sustainable and progressive future for all its residents.<br>Through the Bayanihan spirit, we strive for a safer, healthier, and more prosperous San Jose.</p>
            </div>

            <!-- Vision, Mission, History Cards -->
            <div class="vmh-grid">
                <!-- Vision Card -->
                <div class="vmh-card">
                    <div class="vmh-header">
                        <div class="vmh-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        </div>
                        <h3 class="vmh-title">Our Vision</h3>
                    </div>
                    <div class="vmh-underline"></div>
                    <div class="vmh-bg-illustration vision-bg"></div>
                </div>

                <!-- Mission Card -->
                <div class="vmh-card">
                    <div class="vmh-header">
                        <div class="vmh-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <h3 class="vmh-title">Our Mission</h3>
                    </div>
                    <div class="vmh-underline"></div>
                    <div class="vmh-bg-illustration mission-bg"></div>
                </div>

                <!-- History Card -->
                <div class="vmh-card">
                    <div class="vmh-header">
                        <div class="vmh-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M4 21V7l8-4 8 4v14"/><path d="M9 21v-6h6v6"/><path d="M8 10h.01"/><path d="M16 10h.01"/></svg>
                        </div>
                        <h3 class="vmh-title">Our History</h3>
                    </div>
                    <div class="vmh-underline"></div>
                    <div class="vmh-text-wrapper">
                        <p class="vmh-text">
                            Barangay San Jose is once a "Forest". It Became sitio Dumihat of Barangay Dumara. The 1st Family who discover the Place and decided to live was Mr. TEMOTEO DELUNA and Mrs.EULOGEIA DELUNA. In year 1951, there was a group of strange people name APO Company who cut the trees. The family decided to make a farm to plant corn vegetables, and other plants to be eaten and sold in the future generation . they encourage other people to live with them in this place to make it a sitio before to start they the plan, the family decided to meet Datu lumok Imbing , datu n the subanen tribe to ask ,to ask permission ,year 1953, the family donated a lot to create a building for catholic religion, in march 1956, the building was erected a senior san jose chapel, a name before the celebration of patron Senior san jose In year 1957, Lapuyan become a Municipality by the Mayor coco sia. on November 20,1965 , the Municipal Mayor declared that sitio dumihat will become a barangay san jose name before the catholic church and that's the month of celebration every year. Later, the Subanen Tribe came to live in the Barangay and until the Subanen and Bisaya Tribe are living together in this place
                        </p>
                    </div>
                    <div class="vmh-bg-illustration history-bg"></div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer Section -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-container">
                <!-- Left Side: Logo & Brand -->
                <div class="footer-brand">
                    <img src="assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="footer-logo">
                    <div class="footer-brand-text">
                        <h2>BARANGAY<br>SAN JOSE</h2>
                        <p>Bayanihan &bull; Serbisyong Totoo</p>
                    </div>
                </div>

                <!-- Right Side: Links -->
                <div class="footer-links-wrapper">
                    <a href="index.php">HOME</a>
                    <a href="about.php">ABOUT US</a>
                    <a href="officials.php">OFFICIALS</a>
                    <a href="announcement.php">ANNOUNCEMENTS</a>
                    <a href="gallery.php">GALLERY</a>
                    <a href="index.php#spot-map">SPOT MAP</a>
                    <a href="contact.php">CONTACT US</a>
                </div>
            </div>

            <!-- Divider & Bottom Section -->
            <div class="footer-bottom">
                <hr class="footer-divider">
                
                <!-- Social Icons -->
                <div class="footer-socials">
                    <a href="#" class="social-icon" aria-label="Facebook">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    </a>
                    <a href="#" class="social-icon" aria-label="Twitter">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                    </a>
                    <a href="#" class="social-icon" aria-label="Email">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </a>
                </div>
                
                <p class="footer-copyright">&copy; Copyright. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="assets/js/main.js?v=2"></script>

</body>

</html>




