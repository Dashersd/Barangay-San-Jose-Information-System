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
                <p class="hero-subtitle">SPOT MAP</p>
                <h1 class="hero-title">BARANGAY SAN JOSE</h1>
                <p class="hero-desc">Overview and geographical layout of Barangay San Jose.</p>
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
                    <div class="sm-card">
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
                    <div class="sm-card">
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
                <div class="sm-map-content">
                    <div class="sm-map-image-wrapper">
                        <button class="sm-overview-btn sm-floating-btn" onclick="resetMap()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            Overview Map
                        </button>
                        <!-- Initial image is san jose.png -->
                        <img src="assets/images/Map/san jose.png" alt="Barangay Spot Map" id="mainMapImage" onerror="this.src='https://placehold.co/1200x800/e2e8f0/64748b?text=Spot+Map+Image'">
                        
                        <!-- Interactive Pin on San Jose -->
                        <div class="map-pin" id="sanJosePin" title="Click to view San Jose Satellite Map">
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
        <script>
            // Global function to reset map to default
            function resetMap() {
                var mainImage = document.getElementById('mainMapImage');
                var pin = document.getElementById('sanJosePin');
                
                if (mainImage) {
                    mainImage.src = 'assets/images/Map/san jose.png';
                    if (pin) {
                        pin.style.display = 'block';
                    }
                }
            }

            // Global function to change map on Purok click
            function changeMap(element) {
                var newSrc = element.getAttribute('data-image');
                var mainImage = document.getElementById('mainMapImage');
                var pin = document.getElementById('sanJosePin');
                
                if (newSrc && mainImage) {
                    mainImage.src = newSrc;
                    if (pin) {
                        pin.style.display = 'none';
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const pin = document.getElementById('sanJosePin');
                const mainImage = document.getElementById('mainMapImage');

                // Handle Pin Click
                if (pin && mainImage) {
                    pin.addEventListener('click', function() {
                        // Change the image source to dont_change_or_and_anything_20260930103702.jpg
                        mainImage.src = 'assets/images/Map/dont_change_or_and_anything_20260930103702.jpg';
                        // Optionally hide the pin after click
                        pin.style.display = 'none';
                    });
                }
            });
        </script>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container footer-container">
            <div class="footer-bottom">
                <div class="footer-logo-wrap">
                    <img src="assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="footer-logo">
                    <div class="footer-brand">
                        <h4>Barangay San Jose</h4>
                        <p>Bayanihan &bull; Serbisyong Totoo</p>
                    </div>
                </div>
                
                <p class="footer-copyright">&copy; Copyright. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="assets/js/main.js?v=2"></script>

</body>
</html>
