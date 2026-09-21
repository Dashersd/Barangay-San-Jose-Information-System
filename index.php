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
    <link rel="stylesheet" href="assets/css/gallery.css">
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
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="about.php">About Us</a></li>
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
                <p class="hero-subtitle">WELCOME TO</p>
                <h1 class="hero-title">BARANGAY SAN JOSE</h1>
                <p class="hero-desc">A progressive and united community working together<br>for a safer, healthier, and more prosperous San Jose.</p>
                <a href="about.php" class="btn btn-hero">
                    Learn More About Us &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 2. About Section (Full Width) -->
    <section class="about-section">
        <div class="container about-section-container">
            <!-- Image Side -->
            <div class="about-section-image">
                <img src="assets/images/image.png" alt="About Barangay San Jose">
            </div>
            <!-- Text Side -->
            <div class="about-section-text">
                <p class="about-eyebrow">WHO WE ARE</p>
                <h2 class="about-section-heading">About <span class="highlight-text">Barangay San Jose</span></h2>
                <div class="about-section-underline"></div>
                <p class="about-section-desc">Barangay San Jose is a vibrant and united community committed to providing quality public service, promoting peace and order, and creating a sustainable and progressive future for all its residents.</p>
                <p class="about-section-desc">Our barangay is home to thousands of families who work hand-in-hand with local leaders to build a safer, healthier, and more prosperous community. Through bayanihan, transparency, and genuine service, we strive to uplift the lives of every San Jose resident.</p>
                <a href="about.php" class="btn btn-blue">
                    Read More About Us &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 3. Officials Section -->
    <section class="officials-section">
        <div class="container officials-container">
            <div class="section-header text-center">
                <p class="section-eyebrow">BARANGAY OFFICIALS</p>
                <h2 class="section-heading-main">Meet Our <span class="highlight-text">Leaders</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">The dedicated officials working to serve the people of Barangay San Jose.</p>
            </div>
            
            <div class="officials-top-wrapper">
                <div class="official-card captain-card">
                    <div class="official-image-wrapper">
                        <img src="assets/images/default-avatar.png" alt="Hon. Juan Dela Cruz" onerror="this.src='https://ui-avatars.com/api/?name=Juan+Dela+Cruz&background=random&size=250'">
                        <div class="role-badge">Punong Barangay</div>
                    </div>
                    <div class="official-details">
                        <h3 class="official-name">Hon. Juan Dela Cruz</h3>
                        <p class="official-title">Barangay Captain</p>
                        <p class="official-quote">"Committed to providing transparent and dedicated public service for the betterment of every resident in Barangay San Jose."</p>
                    </div>
                </div>

                <div class="official-card captain-card">
                    <div class="official-image-wrapper">
                        <img src="assets/images/default-avatar.png" alt="Hon. Mark Reyes" onerror="this.src='https://ui-avatars.com/api/?name=Mark+Reyes&background=random&size=250'">
                        <div class="role-badge">SK Chairman</div>
                    </div>
                    <div class="official-details">
                        <h3 class="official-name">Hon. Mark Reyes</h3>
                        <p class="official-title">Sangguniang Kabataan Chairman</p>
                        <p class="official-quote">"Empowering the youth of Barangay San Jose through active participation in sports, education, and community development."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Services Section -->
    <section class="services-section">
        <div class="container services-container">
            <div class="section-header text-center">
                <p class="section-eyebrow">WHAT WE OFFER</p>
                <h2 class="section-heading-main">Barangay <span class="highlight-text">Services</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">Accessible and efficient services dedicated to the welfare of our residents.</p>
            </div>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <h3>Document Issuance</h3>
                    <p>Get your Barangay Clearance, Certificate of Indigency, and other important documents with ease.</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                    </div>
                    <h3>Health Center</h3>
                    <p>Free consultations, vaccinations, and maternal care services for every San Jose resident.</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <h3>Peace & Order</h3>
                    <p>File a blotter or request assistance from our active Barangay Tanods who patrol 24/7.</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <h3>Community Programs</h3>
                    <p>Participate in livelihood seminars, youth sports leagues, and regular clean-up drives.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Announcements Section -->
    <section class="announcements-section">
        <div class="container announcements-container">
            <div class="section-header text-center">
                <p class="section-eyebrow">STAY UPDATED</p>
                <h2 class="section-heading-main">Latest <span class="highlight-text">Announcements</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">Keep track of upcoming events, meetings, and important notices in our barangay.</p>
            </div>
            
            <div class="announcements-grid">
                <div class="announcement-card">
                    <div class="announcement-date">
                        <span class="month">OCT</span>
                        <span class="day">15</span>
                    </div>
                    <div class="announcement-content">
                        <h3>General Assembly Meeting</h3>
                        <ul class="announcement-4w">
                            <li><strong>What:</strong> General Assembly Meeting</li>
                            <li><strong>When:</strong> 9:00 AM, October 15</li>
                            <li><strong>Why:</strong> Discuss infrastructure projects & budgets.</li>
                            <li><strong>Who:</strong> All Barangay Residents</li>
                        </ul>
                    </div>
                </div>

                <div class="announcement-card">
                    <div class="announcement-date">
                        <span class="month">OCT</span>
                        <span class="day">22</span>
                    </div>
                    <div class="announcement-content">
                        <h3>Free Medical & Dental Mission</h3>
                        <ul class="announcement-4w">
                            <li><strong>What:</strong> Free Medical & Dental Mission</li>
                            <li><strong>When:</strong> 8:00 AM, October 22</li>
                            <li><strong>Why:</strong> Offer free checkups and medicines.</li>
                            <li><strong>Who:</strong> Senior Citizens and Children</li>
                        </ul>
                    </div>
                </div>

                <div class="announcement-card">
                    <div class="announcement-date">
                        <span class="month">NOV</span>
                        <span class="day">01</span>
                    </div>
                    <div class="announcement-content">
                        <h3>Undas 2025 Traffic Advisory</h3>
                        <ul class="announcement-4w">
                            <li><strong>What:</strong> Undas 2025 Traffic Advisory</li>
                            <li><strong>When:</strong> All Day, November 01</li>
                            <li><strong>Why:</strong> Road closures and rerouting for Undas.</li>
                            <li><strong>Who:</strong> All Motorists and Residents</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="text-center" style="margin-top: 3rem;">
                <a href="announcement.php" class="btn btn-outline">View All Announcements</a>
            </div>
        </div>
    </section>

    <!-- 6. Gallery Section -->
    <section id="gallery" class="gallery-section">
        <div class="container gallery-container">
            <div class="section-header text-center">
                <p class="section-eyebrow">COMMUNITY IN ACTION</p>
                <h2 class="section-heading-main">Our <span class="highlight-text">Gallery</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">Take a look at the latest events, activities, and programs organized for the residents of Barangay San Jose.</p>
            </div>
            
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
            
            <div class="text-center" style="margin-top: 3rem;">
                <a href="gallery.php" class="btn btn-outline">View Full Gallery</a>
            </div>
        </div>
    </section>


    <!-- 7. Spot Map Section -->
    <section id="spot-map" class="spot-map-section">
        <div class="container">
            <div class="section-header text-center" style="margin-bottom: 3rem;">
                <p class="section-eyebrow">OUR JURISDICTION</p>
                <h2 class="section-heading-main">Barangay <span class="highlight-text">Spot Map</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">Explore the geographical layout, puroks, and key landmarks of our community.</p>
            </div>
            
            <div class="spot-map-container-split">
                <!-- Left Side: Content -->
                <div class="spot-map-content">
                    <div class="spot-map-header">
                        <span class="eyebrow-text">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            EXPLORE
                        </span>
                        <h2>Barangay Spot Map</h2>
                        <p>Navigate our community with ease. View important landmarks, territorial boundaries, purok zones, and key public facilities throughout Barangay San Jose.</p>
                        <a href="#" class="btn-yellow">
                            View Full Map
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </a>
                    </div>

                    <div class="puroks-section">
                        <h3>THE 4 PUROKS</h3>
                        <div class="purok-grid">
                            <div class="purok-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                Purok 1
                            </div>
                            <div class="purok-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                Purok 2
                            </div>
                            <div class="purok-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                Purok 3
                            </div>
                            <div class="purok-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                Purok 4
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Map -->
                <div class="spot-map-frame">
                    <iframe src="https://maps.google.com/maps?q=San%20Jose,%20Lapuyan,%20Zamboanga%20del%20Sur&t=&z=14&ie=UTF8&iwloc=&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>

</body>

</html>







