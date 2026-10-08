<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spot Map - Barangay San Jose</title>
    
    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=2">
    <link rel="stylesheet" href="assets/css/spotmap.css">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
                <li class="dropdown">
                    <a href="javascript:void(0)" class="nav-link">About Us <i class="fas fa-chevron-down" style="font-size: 0.8em; margin-left: 5px;"></i></a>
                    <div class="dropdown-content">
                        <a href="about.php#history">History</a>
                        <a href="vision.php">Vision</a>
                        <a href="mission.php">Mission</a>
                        <a href="officials.php">Barangay Officials</a>
                        <a href="skofficials.php">SK Officials</a>
                    </div>
                </li>
                <li><a href="announcement.php">Announcement</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="spotmap.php" class="active">Spot Map</a></li>
                <li><a href="services.php">Services</a></li>
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
                <p class="hero-subtitle" data-aos="fade-up">SPOT MAP</p>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">BARANGAY SAN JOSE</h1>
                <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">Overview and geographical layout of Barangay San Jose.</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <section class="spotmap-section">
            <div class="container sm-layout-container">
                <!-- Left Column: Cards -->
                <div class="sm-sidebar">
                    
                    <!-- Map Legend Card -->
                    <div class="sm-card" data-aos="fade-right">
                        <div class="sm-card-header">
                            <div class="sm-badge-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                EXPLORE
                            </div>
                            <h2 class="sm-card-title">Barangay Spot Map</h2>
                        </div>
                        
                        <div class="sm-legend-section">
                            <h3 class="sm-legend-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#fdb913" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                                Map Legend
                            </h3>
                            
                            <div class="sm-legend-grid">
                                <div class="sm-legend-item">
                                    <span class="sm-icon-bg"><svg viewBox="0 0 24 24" fill="none" stroke="#004b93" stroke-width="2"><path d="M3 21V9l9-7 9 7v12M9 21v-9h6v9"/></svg></span>
                                    Barangay Hall
                                </div>
                                <div class="sm-legend-item">
                                    <span class="sm-icon-bg"><svg viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></span>
                                    School
                                </div>
                                <div class="sm-legend-item">
                                    <span class="sm-icon-bg"><svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2v20M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></span>
                                    Court
                                </div>
                                <div class="sm-legend-item">
                                    <span class="sm-icon-bg"><svg viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></span>
                                    Health Center
                                </div>
                                <div class="sm-legend-item">
                                    <span class="sm-icon-bg"><svg viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg></span>
                                    Other Landmarks
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Puroks Card -->
                    <div class="sm-card" data-aos="fade-right" data-aos-delay="100">
                        <div class="sm-card-header">
                            <h3 class="sm-legend-title" style="margin-bottom: 20px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#fdb913" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                4 Puroks of Barangay San Jose
                            </h3>
                            
                            <div class="sm-purok-grid">
                                <span class="sm-purok-badge" data-image="assets/images/Purok/Purok 1.jpg" onclick="changeMap(this)">Purok 1</span>
                                <span class="sm-purok-badge" data-image="assets/images/Purok/Purok 2.jpg" onclick="changeMap(this)">Purok 2</span>
                                <span class="sm-purok-badge" data-image="assets/images/Purok/Purok 3.jpg" onclick="changeMap(this)">Purok 3</span>
                                <span class="sm-purok-badge" data-image="assets/images/Purok/Purok 4.jpg" onclick="changeMap(this)">Purok 4</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Map Image -->
                <div class="sm-map-content" data-aos="zoom-in">
                    <div class="sm-map-image-wrapper">
                        <button class="sm-overview-btn sm-floating-btn" onclick="resetMap()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            Overview Map
                        </button>
                        <!-- Initial image is Philippines.png -->
                        <img src="assets/images/Map/Philippines.png" alt="Barangay Spot Map" id="mainMapImage" onerror="this.src='https://placehold.co/1200x800/e2e8f0/64748b?text=Spot+Map+Image'" style="cursor: pointer;">
                        
                        <!-- Interactive Pin on San Jose -->
                        <div class="map-pin" id="sanJosePin" title="Click to view San Jose Satellite Map" style="display: none;">
                            <svg viewBox="0 0 24 24" fill="#ef4444" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3" fill="#ffffff"></circle>
                            </svg>
                            <div class="pin-pulse"></div>
                            <span class="pin-label">San Jose</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Script to handle pin and badge clicks -->
        <script src="assets/js/spotmap.js"></script>
    </main>

    <!-- Footer -->
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
                    <a href="services.php">SERVICES</a>
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

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- JavaScript -->
    <script src="assets/js/main.js?v=2"></script>

</body>
</html>
