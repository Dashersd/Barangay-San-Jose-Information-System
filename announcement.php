<?php
// Barangay San Jose Web-Based Information System - Announcements Page
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | Barangay San Jose</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/announcement.css">
</head>

<body>

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
                <li><a href="about.php">About Us</a></li>
                                <li class="dropdown">
                    <a href="javascript:void(0)" class="nav-link">Officials</a>
                    <div class="dropdown-content">
                        <a href="officials.php">Barangay Officials</a>
                        <a href="skofficials.php">SK Officials</a>
                    </div>
                </li>
                <li><a href="announcement.php" class="active">Announcement</a></li>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <p class="hero-subtitle">BARANGAY SAN JOSE</p>
                <h1 class="hero-title">ANNOUNCEMENTS</h1>
                <p class="hero-desc">Stay informed about the latest news, events, and important notices in our community.</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="announcement-page-content">
        <div class="container">
            <div class="announcement-list">
                
                <!-- Announcement 1 -->
                <article class="announcement-detail-card">
                    <div class="ad-date">
                        <span class="month">OCT</span>
                        <span class="day">15</span>
                    </div>
                    <div class="ad-content">
                        <h2>General Assembly Meeting</h2>
                        <ul class="ad-4w">
                            <li><strong>What:</strong> Bi-annual General Assembly Meeting</li>
                            <li><strong>When:</strong> October 15, 2025 at 9:00 AM</li>
                            <li><strong>Why:</strong> To discuss upcoming infrastructure projects and budget allocations.</li>
                            <li><strong>Who:</strong> All residents of Barangay San Jose</li>
                        </ul>
                        <div class="ad-extra-desc">
                            <p>We highly encourage at least one representative per household to attend this important assembly. Your voice and feedback are essential as we plan for the community's future developments.</p>
                        </div>
                    </div>
                </article>

                <!-- Announcement 2 -->
                <article class="announcement-detail-card">
                    <div class="ad-date">
                        <span class="month">OCT</span>
                        <span class="day">22</span>
                    </div>
                    <div class="ad-content">
                        <h2>Free Medical & Dental Mission</h2>
                        <ul class="ad-4w">
                            <li><strong>What:</strong> Free Medical and Dental Checkups</li>
                            <li><strong>When:</strong> October 22, 2025 starting at 8:00 AM</li>
                            <li><strong>Why:</strong> To provide accessible healthcare services to those in need.</li>
                            <li><strong>Who:</strong> Priority for Senior Citizens and Children</li>
                        </ul>
                        <div class="ad-extra-desc">
                            <p>In partnership with the City Health Office and volunteer doctors, we will be providing free checkups, basic tooth extractions, and essential medicines. Please bring your valid ID and PhilHealth card if available.</p>
                        </div>
                    </div>
                </article>

                <!-- Announcement 3 -->
                <article class="announcement-detail-card">
                    <div class="ad-date">
                        <span class="month">NOV</span>
                        <span class="day">01</span>
                    </div>
                    <div class="ad-content">
                        <h2>Undas 2025 Traffic Advisory</h2>
                        <ul class="ad-4w">
                            <li><strong>What:</strong> Temporary Road Closures and Rerouting</li>
                            <li><strong>When:</strong> November 01, 2025 (All Day)</li>
                            <li><strong>Why:</strong> To manage the expected high volume of traffic heading to the public cemetery.</li>
                            <li><strong>Who:</strong> All Motorists and Residents</li>
                        </ul>
                        <div class="ad-extra-desc">
                            <p>Please be advised that Main Avenue will be strictly one-way leading towards the cemetery. Expect heavy traffic. Barangay Tanods and City Traffic Enforcers will be deployed to guide motorists.</p>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>

</body>
</html>
