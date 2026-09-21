<?php
// Barangay San Jose Web-Based Information System - Contact Us
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact Barangay San Jose office, emergency hotlines, and public assistance in Lapuyan, Zamboanga del Sur.">
    <title>Contact Us | Barangay San Jose Information System</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/contact.css">
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
                    <a href="javascript:void(0)" class="nav-link">Officials</a>
                    <div class="dropdown-content">
                        <a href="officials.php">Barangay Officials</a>
                        <a href="skofficials.php">SK Officials</a>
                    </div>
                </li>
                <li><a href="announcement.php">Announcement</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="index.php#spot-map">Spot Map</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
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
                <p class="hero-subtitle">CONTACT US</p>
                <h1 class="hero-title">BARANGAY SAN JOSE</h1>
                <p class="hero-desc">We are here to serve. Reach out to our barangay office for public inquiries,<br>government assistance, document services, and 24/7 community safety hotlines.</p>
            </div>
        </div>
    </section>

    <!-- 2. Main Content Section -->
    <main class="contact-main-section">
        <div class="container">
            <div class="contact-content-wrapper">

                <!-- Quick Info Cards (2 Columns) -->
                <div class="contact-info-grid">
                    
                    <!-- Card 1: Barangay Hall -->
                    <div class="contact-info-card">
                        <div class="contact-card-icon-box">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="16" height="20" x="4" y="2" rx="2" ry="2"/>
                                <path d="M9 22v-4h6v4"/>
                                <path d="M8 6h.01"/>
                                <path d="M16 6h.01"/>
                                <path d="M12 6h.01"/>
                                <path d="M12 10h.01"/>
                                <path d="M12 14h.01"/>
                                <path d="M16 10h.01"/>
                                <path d="M16 14h.01"/>
                                <path d="M8 10h.01"/>
                                <path d="M8 14h.01"/>
                            </svg>
                        </div>
                        <h2 class="contact-card-title">Barangay Hall</h2>
                        <div class="contact-card-content">
                            <p><strong>Barangay San Jose Hall</strong></p>
                            <p>Poblacion San Jose, Lapuyan</p>
                            <p>Zamboanga del Sur, 7037</p>
                        </div>
                    </div>

                    <!-- Card 2: Emergency & Hotlines -->
                    <div class="contact-info-card">
                        <div class="contact-card-icon-box">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                        </div>
                        <h2 class="contact-card-title">Hotlines & Emergency</h2>
                        <div class="contact-card-content">
                            <p><strong>Office Desk:</strong> (062) 925-2011</p>
                            <p><strong>Tanod Patrol (24/7):</strong> 0912-345-6789</p>
                            <p><strong>Health Station:</strong> 0998-765-4321</p>
                            <p><strong>MDRRMO / Police:</strong> 911 / 117</p>
                        </div>
                    </div>

                </div>

                <!-- Operating Schedule -->
                <div class="contact-schedule-wrapper">
                    <div class="contact-schedule-card">
                        <div class="contact-section-header">
                            <div class="contact-section-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="contact-section-title">Office Operating Hours</h3>
                                <span class="contact-section-subtitle">Barangay Hall Services</span>
                            </div>
                        </div>

                        <p class="schedule-description">
                            Our administrative staff and council members are ready to assist residents with clearances, certificates, inquiries, and public transactions during standard government hours.
                        </p>

                        <ul class="schedule-list">
                            <li class="schedule-item active-schedule">
                                <span class="schedule-day">Monday – Friday</span>
                                <span class="schedule-hours">8:00 AM – 5:00 PM</span>
                            </li>
                            <li class="schedule-item">
                                <span class="schedule-day">Saturday & Sunday</span>
                                <span class="schedule-hours">Closed (Duty Tanod Only)</span>
                            </li>
                            <li class="schedule-item">
                                <span class="schedule-day">Public & National Holidays</span>
                                <span class="schedule-hours">Emergency Hotline Active</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>

</body>

</html>
