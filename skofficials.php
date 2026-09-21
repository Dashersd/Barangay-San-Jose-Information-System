<?php
// Barangay San Jose Web-Based Information System - Officials
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Meet the dedicated leaders of Barangay San Jose.">
    <title>Officials | Barangay San Jose Information System</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skofficials.css">
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
                <li><a href="about.php">About Us</a></li>
                                <li class="dropdown">
                    <a href="javascript:void(0)" class="nav-link active">Officials</a>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <p class="hero-subtitle">SK OFFICIALS</p>
                <h1 class="hero-title">BARANGAY SAN JOSE</h1>
                <p class="hero-desc">The dedicated leaders who work together to ensure the progress,<br>peace, and well-being of our community.</p>
            </div>
        </div>
    </section>

    <!-- Officials Content -->
    <section class="officials-page-bg">
        <div class="officials-container">
            <!-- Top Section -->
            <div class="officials-top">
                <div class="officials-header-text">
                    <h1 class="officials-heading">Sangguniang Kabataan (SK) Officials</h1>
                    <p class="officials-subtext">The SK officials are dedicated youth leaders who work together to empower the youth of Barangay San Jose.</p>
                </div>
                
                <div class="captain-card">
                    <img src="assets/images/default-avatar.png" alt="Juan Dela Cruz" class="captain-img" onerror="this.src='https://ui-avatars.com/api/?name=Mark+Reyes&background=random&color=fff&size=130'">
                    <div class="captain-info">
                        <span class="badge-blue">SK Chairperson</span>
                        <h2 class="captain-name">Mark Reyes</h2>
                        <div class="captain-role">SK Chairperson</div>
                        <p class="captain-quote">"Empowering the youth of Barangay San Jose."</p>
                    </div>
                </div>
            </div>

            <!-- Middle Row -->
            <div class="officials-row">
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Ms. Liza Santos" onerror="this.src='https://ui-avatars.com/api/?name=Liza+Santos&background=random&color=fff'">
                    <span class="badge-blue" style="background-color: #0ea5e9;">Secretary</span>
                    <h4>Ms. Liza Santos</h4>
                    <p>SK Secretary</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Mr. Antonio Luna" onerror="this.src='https://ui-avatars.com/api/?name=Antonio+Luna&background=random&color=fff'">
                    <span class="badge-blue" style="background-color: #10b981;">Treasurer</span>
                    <h4>Mr. Antonio Luna</h4>
                    <p>SK Treasurer</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Ana Villanueva" onerror="this.src='https://ui-avatars.com/api/?name=Ana+Villanueva&background=random&color=fff'">
                    <span class="badge-blue">SK Kagawad</span>
                    <h4>Ana Villanueva</h4>
                    <p>SK Kagawad</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Luis Garcia" onerror="this.src='https://ui-avatars.com/api/?name=Luis+Garcia&background=random&color=fff'">
                    <span class="badge-blue">SK Kagawad</span>
                    <h4>Luis Garcia</h4>
                    <p>SK Kagawad</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Maria Santos" onerror="this.src='https://ui-avatars.com/api/?name=Maria+Santos&background=random&color=fff'">
                    <span class="badge-blue">SK Kagawad</span>
                    <h4>Maria Santos</h4>
                    <p>SK Kagawad</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Juanito Perez" onerror="this.src='https://ui-avatars.com/api/?name=Juanito+Perez&background=random&color=fff'">
                    <span class="badge-blue">SK Kagawad</span>
                    <h4>Juanito Perez</h4>
                    <p>SK Kagawad</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Elena Cruz" onerror="this.src='https://ui-avatars.com/api/?name=Elena+Cruz&background=random&color=fff'">
                    <span class="badge-blue">SK Kagawad</span>
                    <h4>Elena Cruz</h4>
                    <p>SK Kagawad</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Ricardo Gomez" onerror="this.src='https://ui-avatars.com/api/?name=Ricardo+Gomez&background=random&color=fff'">
                    <span class="badge-blue">SK Kagawad</span>
                    <h4>Ricardo Gomez</h4>
                    <p>SK Kagawad</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Pedro Reyes" onerror="this.src='https://ui-avatars.com/api/?name=Pedro+Reyes&background=random&color=fff'">
                    <span class="badge-blue">SK Kagawad</span>
                    <h4>Pedro Reyes</h4>
                    <p>SK Kagawad</p>
                </div>
            </div>



        </div>
    </section>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>

</body>

</html>


