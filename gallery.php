<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Barangay San Jose</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/gallery.css">
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
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
                <li><a href="announcement.php">Announcement</a></li>
                <li><a href="gallery.php" class="active">Gallery</a></li>
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
                <p class="hero-subtitle">GALLERY</p>
                <h1 class="hero-title">BARANGAY SAN JOSE</h1>
                <p class="hero-desc">Take a look at the latest events, activities, and programs organized for the residents of our community.</p>
            </div>
        </div>
    </section>

    <!-- 2. Gallery Section -->
    <section id="gallery" class="gallery-section">
        <div class="container gallery-container">
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="assets/images/gallery_community_event_1789988183333.jpg" alt="Community Event">
                    <div class="gallery-overlay">
                        <h4>Community Fiesta</h4>
                        <p>Celebrating together</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="assets/images/gallery_clean_up_1789988204683.jpg" alt="Clean Up Drive">
                    <div class="gallery-overlay">
                        <h4>Clean Up Drive</h4>
                        <p>Keeping our barangay green</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="assets/images/gallery_sports_league_1789988228547.jpg" alt="Sports League">
                    <div class="gallery-overlay">
                        <h4>SK Basketball League</h4>
                        <p>Youth sports program</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="assets/images/San Jose.png" alt="Barangay Hall">
                    <div class="gallery-overlay">
                        <h4>Barangay Hall</h4>
                        <p>Heart of our community</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>

</body>
</html>
