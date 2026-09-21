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
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/about.css">
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

            <!-- Right Side: Login -->
        <div class="navbar-right">
            <a href="login.php" class="btn btn-primary" style="padding: 0.6rem 1.5rem; font-size: 0.95rem;">Login</a>
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
                    <div class="vmh-bg-illustration history-bg"></div>
                </div>
            </div>

        </div>
    </main>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>

</body>

</html>
