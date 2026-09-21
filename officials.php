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
    <link rel="stylesheet" href="assets/css/officials.css">
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
                    <span class="brand-subtitle">Bayanihan &bull; Serbisyong Totoo &bull; Mas Maunlad na San Jose</span>
                </div>
            </a>

            <!-- Desktop Links -->
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="officials.php" class="active">Officials</a></li>
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

    <!-- Officials Content -->
    <section class="officials-page-bg">
        <div class="officials-container">
            <!-- Top Section -->
            <div class="officials-top">
                <div class="officials-header-text">
                    <h1 class="officials-heading">Barangay Officials</h1>
                    <p class="officials-subtext">The Barangay San Jose officials are dedicated leaders who work together to ensure the progress, peace, and well-being of our community.</p>
                </div>
                
                <div class="captain-card">
                    <img src="assets/images/default-avatar.png" alt="Hon. Juan Dela Cruz" class="captain-img" onerror="this.src='https://ui-avatars.com/api/?name=Juan+Dela+Cruz&background=random&color=fff&size=130'">
                    <div class="captain-info">
                        <span class="badge-blue">Barangay Captain</span>
                        <h2 class="captain-name">Hon. Juan Dela Cruz</h2>
                        <div class="captain-role">Punong Barangay</div>
                        <p class="captain-quote">"Serbisyong totoo para sa mas maunlad na San Jose."</p>
                    </div>
                </div>
            </div>

            <!-- Middle Row -->
            <div class="officials-row">
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Hon. Maria Santos" onerror="this.src='https://ui-avatars.com/api/?name=Maria+Santos&background=random&color=fff'">
                    <span class="badge-blue">Kagawad</span>
                    <h4>Hon. Maria Santos</h4>
                    <p>Kagawad</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Hon. Pedro Reyes" onerror="this.src='https://ui-avatars.com/api/?name=Pedro+Reyes&background=random&color=fff'">
                    <span class="badge-blue">Kagawad</span>
                    <h4>Hon. Pedro Reyes</h4>
                    <p>Kagawad</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Hon. Ana Villanueva" onerror="this.src='https://ui-avatars.com/api/?name=Ana+Villanueva&background=random&color=fff'">
                    <span class="badge-blue">Kagawad</span>
                    <h4>Hon. Ana Villanueva</h4>
                    <p>Kagawad</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Hon. Luis Garcia" onerror="this.src='https://ui-avatars.com/api/?name=Luis+Garcia&background=random&color=fff'">
                    <span class="badge-blue">Kagawad</span>
                    <h4>Hon. Luis Garcia</h4>
                    <p>Kagawad</p>
                </div>
                <div class="official-card">
                    <img src="assets/images/default-avatar.png" alt="Ms. Liza Santos" onerror="this.src='https://ui-avatars.com/api/?name=Liza+Santos&background=random&color=fff'">
                    <span class="badge-blue" style="background-color: #0ea5e9;">Secretary</span>
                    <h4>Ms. Liza Santos</h4>
                    <p>Barangay Secretary</p>
                </div>
            </div>

            <!-- Bottom Row -->
            <div class="footer-cards">
                <div class="footer-card">
                    <div class="footer-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <div class="footer-card-content">
                        <h4>Sangguniang Barangay Members</h4>
                        <p>Work together for a more progressive and peaceful Barangay San Jose.</p>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="btn-view-all">View All Officials &rarr;</a>
                    </div>
                </div>
                
                <div class="footer-card">
                    <div class="footer-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
                            <line x1="4" y1="22" x2="4" y2="15"></line>
                        </svg>
                    </div>
                    <div class="footer-card-content">
                        <h4>Our Commitment</h4>
                        <p>Transparent governance, responsive service, and a united community.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>

</body>

</html>
