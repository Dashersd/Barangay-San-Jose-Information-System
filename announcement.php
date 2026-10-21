<?php
// Barangay San Jose Web-Based Information System - Announcements Page
require_once 'db_connect.php';

$announcements = [];
$res = $conn->query("SELECT * FROM announcements WHERE status = 'Published' ORDER BY event_date DESC, id DESC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $announcements[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | Barangay San Jose</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=2">
    <link rel="stylesheet" href="assets/css/announcement.css">
    
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
                <li><a href="announcement.php" class="active">Announcement</a></li>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <p class="hero-subtitle" data-aos="fade-up">BARANGAY SAN JOSE</p>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">ANNOUNCEMENTS</h1>
                <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">Stay informed about the latest news, events, and important notices in our community.</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="announcement-page-content">
        <div class="container">
            <div class="announcement-list">
                <?php if (empty($announcements)): ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: white; border-radius: var(--radius-md); box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="#94a3b8" stroke-width="1.5" style="margin-bottom: 15px; display: inline-block;"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        <h3 style="color: #334155; margin-bottom: 8px;">No Announcements Yet</h3>
                        <p style="color: #64748b; margin: 0;">Please check back soon for community news, schedules, and official notices.</p>
                    </div>
                <?php else: ?>
                    <?php 
                    $delay = 100;
                    foreach ($announcements as $ann): 
                        $month = date('M', strtotime($ann['event_date']));
                        $day = date('d', strtotime($ann['event_date']));
                    ?>
                        <article class="announcement-detail-card" id="announcement-<?= $ann['id'] ?>" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                            <?php if (!empty($ann['cover_image'])): ?>
                                <div class="ad-cover-img" style="margin: -2.5rem -2.5rem 1.5rem -2.5rem; overflow: hidden; border-radius: var(--radius-md) var(--radius-md) 0 0; max-height: 220px;">
                                    <img src="<?= htmlspecialchars($ann['cover_image']) ?>" alt="<?= htmlspecialchars($ann['title']) ?>" style="width: 100%; height: 220px; object-fit: cover; display: block;">
                                </div>
                            <?php endif; ?>
                            <div class="ad-date">
                                <span class="month"><?= htmlspecialchars($month) ?></span>
                                <span class="day"><?= htmlspecialchars($day) ?></span>
                            </div>
                            <div class="ad-content">
                                <h2><?= htmlspecialchars($ann['title']) ?></h2>
                                <ul class="ad-4w">
                                    <?php if (!empty($ann['what_desc'])): ?>
                                        <li><strong>What:</strong> <?= htmlspecialchars($ann['what_desc']) ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($ann['when_time'])): ?>
                                        <li><strong>When:</strong> <?= htmlspecialchars($ann['when_time']) ?></li>
                                    <?php else: ?>
                                        <li><strong>When:</strong> <?= date('F d, Y', strtotime($ann['event_date'])) ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($ann['why_desc'])): ?>
                                        <li><strong>Why:</strong> <?= htmlspecialchars($ann['why_desc']) ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($ann['who_target'])): ?>
                                        <li><strong>Who:</strong> <?= htmlspecialchars($ann['who_target']) ?></li>
                                    <?php endif; ?>
                                </ul>
                                <?php if (!empty($ann['extra_desc'])): ?>
                                    <div class="ad-extra-desc">
                                        <p><?= nl2br(htmlspecialchars($ann['extra_desc'])) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php 
                        $delay += 100;
                    endforeach; 
                    ?>
                <?php endif; ?>
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





