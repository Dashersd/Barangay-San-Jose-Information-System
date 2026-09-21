<?php
// Barangay San Jose Web-Based Information System
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay San Jose Web-Based Information System</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <nav class="navbar">
        <div class="navbar-container">
            <!-- Logo & Brand -->
            <a href="index.php" class="navbar-brand">
                <img src="assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="navbar-logo">
                <div class="brand-text">
                    <span class="brand-title">BARANGAY SAN JOSE</span>
                    <span class="brand-subtitle">Bayanihan &bull; Serbisyong Totoo &bull; Mas Maunlad na San Jose</span>
                </div>
            </a>

            <!-- Desktop Links -->
            <ul class="navbar-links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="officials.php">Officials</a></li>
                <li><a href="javascript:void(0)">Gallery</a></li>
                <li><a href="javascript:void(0)" style="cursor: default; pointer-events: none;">Spot Map</a></li>
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
                <p class="hero-subtitle">WELCOME TO</p>
                <h1 class="hero-title">BARANGAY SAN JOSE</h1>
                <p class="hero-desc">A progressive and united community working together<br>for a safer, healthier, and more prosperous San Jose.</p>
                <a href="about.php" class="btn btn-hero">
                    Learn More About Us &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 2. Features Overview Section -->
    <section class="features-overview">
        <div class="container features-container">
            <!-- Column 1: About Us -->
            <div class="feature-col about-col">
                <div class="about-content" style="display: flex; gap: 1rem; align-items: flex-start;">
                    <div class="about-text" style="flex: 1.15; padding-right: 0.2rem;">
                        <h2 class="section-heading" style="margin: 0 0 0.2rem 0; color: #0f172a; font-size: 1.3rem; font-weight: 800;">About Us</h2>
                        <div class="heading-underline" style="margin-bottom: 1rem; height: 2px; width: 35px; background-color: #475569;"></div>
                        <p style="font-size: 0.78rem; line-height: 1.6; color: #334155; margin-bottom: 1.2rem;">Barangay San Jose is a vibrant and united community committed to providing quality public service, promoting peace and order, and creating a sustainable and progressive future for all its residents.</p>
                        <a href="about.php" class="btn btn-dark-blue" style="padding: 0.5rem 1.1rem; font-size: 0.75rem; border-radius: 50px; background-color: #0f172a; color: #ffffff; font-weight: 600;">Read More &rarr;</a>
                    </div>
                    <div class="about-image" style="flex: 0.85;">
                        <img src="assets/images/image.png" alt="About Barangay San Jose" style="width: 100%; aspect-ratio: 1 / 1.05; object-fit: cover; border-radius: 10px;">
                    </div>
                </div>
            </div>

            <!-- Column 2: Barangay Officials -->
            <div class="feature-col officials-col card-white">
                <h2 class="section-heading">Barangay Officials</h2>
                <div class="heading-underline"></div>
                <p class="subtitle">Meet the dedicated leaders of Barangay San Jose.</p>
                <a href="javascript:void(0)" class="btn btn-blue-sm">View All Officials &rarr;</a>
                
                <div class="officials-grid">
                    <div class="official-main">
                        <img src="assets/images/default-avatar.png" alt="Hon. Juan Dela Cruz" onerror="this.src='https://ui-avatars.com/api/?name=Juan+Dela+Cruz&background=random'">
                        <div class="official-info">
                            <h4>Hon. Juan Dela Cruz</h4>
                            <span>Punong Barangay</span>
                        </div>
                    </div>
                    <div class="officials-sub">
                        <div class="official-item">
                            <img src="assets/images/default-avatar.png" alt="Hon. Maria Santos" onerror="this.src='https://ui-avatars.com/api/?name=Maria+Santos&background=random'">
                            <div class="official-info">
                                <h5>Hon. Maria Santos</h5>
                                <span>Kagawad</span>
                            </div>
                        </div>
                        <div class="official-item">
                            <img src="assets/images/default-avatar.png" alt="Hon. Pedro Reyes" onerror="this.src='https://ui-avatars.com/api/?name=Pedro+Reyes&background=random'">
                            <div class="official-info">
                                <h5>Hon. Pedro Reyes</h5>
                                <span>Kagawad</span>
                            </div>
                        </div>
                        <div class="official-item">
                            <img src="assets/images/default-avatar.png" alt="Hon. Ana Villanueva" onerror="this.src='https://ui-avatars.com/api/?name=Ana+Villanueva&background=random'">
                            <div class="official-info">
                                <h5>Hon. Ana Villanueva</h5>
                                <span>Kagawad</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 3: Latest Announcements -->
            <div class="feature-col announcements-col card-white">
                <div class="announcements-header">
                    <h2 class="section-heading">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5L6 9H2V15H6L11 19V5Z"></path><path d="M19.07 4.93A10 10 0 0 1 19.07 19.07"></path><path d="M15.54 8.46A5 5 0 0 1 15.54 15.54"></path></svg>
                        Latest Announcements
                    </h2>
                    <a href="javascript:void(0)" class="view-all-link">View All &rarr;</a>
                </div>
                
                <div class="announcements-list">
                    <div class="announcement-item">
                        <div class="announcement-date">
                            <span class="month">JUL</span>
                            <span class="day">10</span>
                        </div>
                        <div class="announcement-content">
                            <h4>Barangay Assembly Meeting</h4>
                            <p>All residents are invited to attend the Barangay Assembly Meeting on July 15, 2025 at 9:00 AM at the Barangay Hall.</p>
                        </div>
                    </div>
                    <div class="announcement-item">
                        <div class="announcement-date">
                            <span class="month">JUL</span>
                            <span class="day">05</span>
                        </div>
                        <div class="announcement-content">
                            <h4>Free Medical Mission</h4>
                            <p>A free medical mission will be held on July 12, 2025 at the Barangay Multi-Purpose Center. See you there!</p>
                        </div>
                    </div>
                    <div class="announcement-item">
                        <div class="announcement-date">
                            <span class="month">JUN</span>
                            <span class="day">28</span>
                        </div>
                        <div class="announcement-content">
                            <h4>Clean and Green Program</h4>
                            <p>Let's work together for a cleaner and greener Barangay San Jose. Join us on July 5, 2025.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>

</body>

</html>
