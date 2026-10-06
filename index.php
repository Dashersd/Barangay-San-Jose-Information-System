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
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=2">
    <link rel="stylesheet" href="assets/css/gallery.css">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
                <li><a href="spotmap.php">Spot Map</a></li>
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
                <p class="hero-subtitle" data-aos="fade-up">WELCOME TO</p>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">BARANGAY SAN JOSE</h1>
                <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">A progressive and united community working together<br>for a safer, healthier, and more prosperous San Jose.</p>
                <a href="about.php" class="btn btn-hero" data-aos="fade-up" data-aos-delay="300">
                    Learn More About Us &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 2. About Section (Full Width) -->
    <section class="about-section">
        <div class="container about-section-container">
            <!-- Image Side -->
            <div class="about-section-image" data-aos="fade-right">
                <img src="assets/images/Barangay Hall.png" alt="About Barangay San Jose">
            </div>
            <!-- Text Side -->
            <div class="about-section-text" data-aos="fade-left">
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
            <div class="section-header text-center" data-aos="fade-up">
                <p class="section-eyebrow">BARANGAY OFFICIALS</p>
                <h2 class="section-heading-main">Meet Our <span class="highlight-text">Leaders</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">The dedicated officials working to serve the people of Barangay San Jose.</p>
            </div>
            
            <div class="officials-top-wrapper">
                <div class="official-card captain-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="official-image-wrapper">
                        <img src="assets/images/Barangay Official/captain.Diego Logronio.jpg" alt="Hon. Diego Logronio" onerror="this.src='https://ui-avatars.com/api/?name=Diego+Logronio&background=random&size=250'">
                        <div class="role-badge">Punong Barangay</div>
                    </div>
                    <div class="official-details">
                        <h3 class="official-name">Hon. Diego Logronio</h3>
                        <p class="official-title">Barangay Captain</p>
                        <p class="official-quote">"Committed to providing transparent and dedicated public service for the betterment of every resident in Barangay San Jose."</p>
                        <div class="official-action" style="margin-top: 20px; text-align: center;">
                            <a href="officials.php" class="btn btn-primary">View Barangay Officials</a>
                        </div>
                    </div>
                </div>

                <div class="official-card captain-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="official-image-wrapper">
                        <img src="assets/images/SK Official/sk chairperson artem mamac.jpg" alt="Hon. Artem Macmac" onerror="this.src='https://ui-avatars.com/api/?name=Artem+Macmac&background=random&size=250'">
                        <div class="role-badge">SK Chairman</div>
                    </div>
                    <div class="official-details">
                        <h3 class="official-name">Hon. Artem Macmac</h3>
                        <p class="official-title">Sangguniang Kabataan Chairman</p>
                        <p class="official-quote">"Empowering the youth of Barangay San Jose through active participation in sports, education, and community development."</p>
                        <div class="official-action" style="margin-top: 20px; text-align: center;">
                            <a href="skofficials.php" class="btn btn-primary">View SK Officials</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Services Section -->
    <section class="services-section">
        <div class="container services-container">
            <div class="section-header text-center" data-aos="fade-up">
                <p class="section-eyebrow">WHAT WE OFFER</p>
                <h2 class="section-heading-main">Barangay <span class="highlight-text">Services</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">Accessible and efficient services dedicated to the welfare of our residents.</p>
            </div>
            
            <div class="services-grid">
                <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <h3>Document Issuance</h3>
                    <p>Get your Barangay Clearance, Certificate of Indigency, and other important documents with ease.</p>
                </div>
                
                <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                    </div>
                    <h3>Health Center</h3>
                    <p>Free consultations, vaccinations, and maternal care services for every San Jose resident.</p>
                </div>
                
                <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <h3>Peace & Order</h3>
                    <p>File a blotter or request assistance from our active Barangay Tanods who patrol 24/7.</p>
                </div>
                
                <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <h3>Community Programs</h3>
                    <p>Participate in livelihood seminars, youth sports leagues, and regular clean-up drives.</p>
                </div>
                </div>
              <div class="text-center" style="margin-top: 3rem;">
                  <a href="Admin/service.php" class="btn btn-primary" style="border-radius: 99px; padding: 0.8rem 2rem; font-weight: 600; font-size: 1.05rem;">View all Service</a>
              </div>
          </div>
      </section>

      <!-- 5. Announcements Section -->
    <section class="announcements-section">
        <div class="container announcements-container">
            <div class="section-header text-center" data-aos="fade-up">
                <p class="section-eyebrow">STAY UPDATED</p>
                <h2 class="section-heading-main">Latest <span class="highlight-text">Announcements</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">Keep track of upcoming events, meetings, and important notices in our barangay.</p>
            </div>
            
            <div class="announcements-grid">
                <div class="announcement-card" data-aos="fade-up" data-aos-delay="100">
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

                <div class="announcement-card" data-aos="fade-up" data-aos-delay="200">
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

                <div class="announcement-card" data-aos="fade-up" data-aos-delay="300">
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
            <div class="section-header text-center" data-aos="fade-up">
                <p class="section-eyebrow">COMMUNITY IN ACTION</p>
                <h2 class="section-heading-main">Our <span class="highlight-text">Gallery</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">Take a look at the latest events, activities, and programs organized for the residents of Barangay San Jose.</p>
            </div>
            
            <div class="gallery-grid">
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                    <img src="assets/images/gallery_community_event_1789988183333.jpg" alt="Community Event">
                    <div class="gallery-overlay">
                        <h4>Community Fiesta</h4>
                        <p>Celebrating together</p>
                    </div>
                </div>
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                    <img src="assets/images/gallery_clean_up_1789988204683.jpg" alt="Clean Up Drive">
                    <div class="gallery-overlay">
                        <h4>Clean Up Drive</h4>
                        <p>Keeping our barangay green</p>
                    </div>
                </div>
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                    <img src="assets/images/gallery_sports_league_1789988228547.jpg" alt="Sports League">
                    <div class="gallery-overlay">
                        <h4>SK Basketball League</h4>
                        <p>Youth sports program</p>
                    </div>
                </div>
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
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
    </section>    <!-- 7. Spot Map Section -->
    <section id="spot-map" class="spot-map-section">
        <div class="container">
            <div class="section-header text-center" style="margin-bottom: 3rem;" data-aos="fade-up">
                <p class="section-eyebrow">OUR JURISDICTION</p>
                <h2 class="section-heading-main">Barangay <span class="highlight-text">Spot Map</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">Explore the geographical layout, puroks, and key landmarks of our community.</p>
            </div>
            
            <div class="spot-map-container-split">
                <!-- Left Side: Content -->
                <div class="spot-map-content" data-aos="fade-right">
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
                    </div>

                <!-- Right Side: Map -->
                <div class="spot-map-frame" data-aos="fade-left">
                    <img src="assets/images/Map/ChatGPT Image Oct 6, 2026, 08_49_30 AM.png" alt="Barangay San Jose Map" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    </section>

    



    <!-- 6.5. Contact Home Section -->
    <section id="contact-home" class="contact-home-section">
        <div class="container contact-home-container">
            <div class="contact-home-card">
                <!-- Left Side -->
                <div class="contact-home-left" data-aos="fade-right">
                    <h2 class="contact-heading">Get in touch</h2>
                    <p class="contact-desc">Reach out to our barangay office for public inquiries, government assistance, and community concerns.</p>
                    
                    <div class="contact-info-list">
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 0-18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            </div>
                            <div class="contact-text">
                                <h4>Head Office</h4>
                                <p>Barangay San Jose Hall<br>San Jose, Municipality</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c2 0 3 1 3 3v10c0 2-1 3-3 3H4c-2 0-3-1-3-3V7c0-2 1-3 3-3z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            </div>
                            <div class="contact-text">
                                <h4>Email Us</h4>
                                <p>support@sanjose.gov.ph<br>info@sanjose.gov.ph</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            </div>
                            <div class="contact-text">
                                <h4>Call Us</h4>
                                <p>Phone: 09XX-XXX-XXXX<br>Tanod: 09XX-XXX-XXXX</p>
                            </div>
                        </div>
                    </div>

                    <hr class="contact-divider">

                    <h4 class="social-heading">Follow our social media</h4>
                    <div class="contact-socials">
                        <a href="#" class="social-circle" aria-label="Facebook">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        </a>
                        <a href="#" class="social-circle" aria-label="Instagram">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                        <a href="#" class="social-circle" aria-label="Twitter">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                        </a>
                        <a href="#" class="social-circle" aria-label="YouTube">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.42a2.78 2.78 0 0 0-1.94 2C1 8.17 1 12 1 12s0 3.83.46 5.58a2.78 2.78 0 0 0 1.94 2C5.12 20 12 20 12 20s6.88 0 8.6-.42a2.78 2.78 0 0 0 1.94-2C23 15.83 23 12 23 12s0-3.83-.46-5.58z"></path><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"></polygon></svg>
                        </a>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="contact-home-right" data-aos="fade-left">
                    <h2 class="contact-heading">Send us a message</h2>
                    <form class="contact-form" action="#" method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label>Service Type</label>
                                <select required>
                                    <option value="" disabled selected>Select service</option>
                                    <option value="clearance">Barangay Clearance</option>
                                    <option value="indigency">Certificate of Indigency</option>
                                    <option value="business">Business Clearance</option>
                                    <option value="residency">Certificate of Residency</option>
                                    <option value="other">Other Inquiry</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" placeholder="Phone" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea rows="4" placeholder="Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary contact-submit">SEND</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Footer Section -->
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











