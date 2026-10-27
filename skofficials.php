<?php
// Barangay San Jose Web-Based Information System - SK Officials
require_once __DIR__ . '/officials_db.php';

$skOfficialsList = get_sk_officials_from_db($conn);
$skOfficials = [];
if (is_array($skOfficialsList)) {
    foreach ($skOfficialsList as $item) {
        if (!empty($item['id'])) {
            $skOfficials[$item['id']] = $item;
        }
    }
}
$chairperson = $skOfficials['sk_chairperson'] ?? null;
$secretary = $skOfficials['sk_secretary'] ?? null;
$treasurer = $skOfficials['sk_treasurer'] ?? null;
$kagawad1 = $skOfficials['sk_kagawad_1'] ?? null;
$kagawad2 = $skOfficials['sk_kagawad_2'] ?? null;
$kagawad3 = $skOfficials['sk_kagawad_3'] ?? null;
$kagawad4 = $skOfficials['sk_kagawad_4'] ?? null;
$kagawad5 = $skOfficials['sk_kagawad_5'] ?? null;
$kagawad6 = $skOfficials['sk_kagawad_6'] ?? null;
$kagawad7 = $skOfficials['sk_kagawad_7'] ?? null;
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
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/skofficials.css">
    <link rel="stylesheet" href="assets/css/org-chart.css">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-container">
            <!-- Logo & Brand -->
            <div class="navbar-brand">
                <img src="assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="navbar-logo">
                <img src="assets/images/Lapuyan Logo.png" alt="Municipality of Lapuyan Logo" class="navbar-logo">
                <div class="brand-text">
                    <span class="brand-title">BARANGAY SAN JOSE</span>
                    <span class="brand-subtitle">Bayanihan &bull; Serbisyong Totoo</span>
                </div>
            </div>

            <!-- Desktop Links -->
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="nav-link active">About Us <i class="fas fa-chevron-down" style="font-size: 0.8em; margin-left: 5px;"></i></a>
                    <div class="dropdown-content">
                        <a href="about.php#history">History</a>
                        <a href="vision.php">Vision</a>
                        <a href="mission.php">Mission</a>
                        <a href="officials.php">Barangay Officials</a>
                        <a href="skofficials.php" class="active">SK Officials</a>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <p class="hero-subtitle" data-aos="fade-up">SK OFFICIALS</p>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">BARANGAY SAN JOSE</h1>
                <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">The dedicated leaders who work together to ensure the progress,<br>peace, and well-being of our community.</p>
            </div>
        </div>
    </section>

    <!-- Officials Content (Org Chart Layout) -->
    <section class="org-chart-container">
        
        <!-- Level 1: Executive Leadership -->
        <div class="org-section-header" data-aos="fade-up">
            <h2 class="org-section-title">SK Executive Leadership</h2>
            <p class="org-section-subtitle">Head of the Sangguniang Kabataan</p>
            <div class="org-divider"></div>
        </div>

        <div class="org-level">
            <div class="org-card-wide" data-aos="fade-up" data-aos-delay="100">
                <div class="org-avatar-wide">
                    <?php if (!empty($chairperson['image']) && file_exists($chairperson['image'])): ?>
                        <img src="<?= htmlspecialchars($chairperson['image']) ?>" alt="<?= htmlspecialchars($chairperson['name'] ?? 'Hon. Artem Macmac') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <?php endif; ?>
                </div>
                <div class="org-info-wide">
                    <h3 class="org-name-wide"><?= htmlspecialchars($chairperson['name'] ?? 'Hon. Artem Macmac') ?></h3>
                    <p class="org-role-wide"><?= htmlspecialchars($chairperson['role'] ?? 'SK Chairperson') ?></p>
                    <p class="org-desc-wide"><?= htmlspecialchars($chairperson['message'] ?? 'Presiding officer of the Sangguniang Kabataan, leading youth empowerment and community development programs in Barangay San Jose.') ?></p>
                </div>
            </div>
        </div>

        <!-- Level 2: SK Officers -->
        <div class="org-section-header" style="margin-top: 50px;" data-aos="fade-up">
            <h2 class="org-section-title">SK Officers</h2>
            <p class="org-section-subtitle">SK Secretary & Treasurer</p>
            <div class="org-divider"></div>
        </div>

        <div class="org-level">
            <div class="org-card" data-aos="fade-up" data-aos-delay="100">
                <div class="org-avatar">
                    <?php if (!empty($secretary['image']) && file_exists($secretary['image'])): ?>
                        <img src="<?= htmlspecialchars($secretary['image']) ?>" alt="<?= htmlspecialchars($secretary['name'] ?? 'Ms. Liza Santos') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <?php endif; ?>
                </div>
                <h3 class="org-name"><?= htmlspecialchars($secretary['name'] ?? 'Ms. Liza Santos') ?></h3>
                <p class="org-role"><?= htmlspecialchars($secretary['role'] ?? 'SK Secretary') ?></p>
            </div>
            
            <div class="org-card" data-aos="fade-up" data-aos-delay="200">
                <div class="org-avatar">
                    <?php if (!empty($treasurer['image']) && file_exists($treasurer['image'])): ?>
                        <img src="<?= htmlspecialchars($treasurer['image']) ?>" alt="<?= htmlspecialchars($treasurer['name'] ?? 'Mr. Antonio Luna') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <?php endif; ?>
                </div>
                <h3 class="org-name"><?= htmlspecialchars($treasurer['name'] ?? 'Mr. Antonio Luna') ?></h3>
                <p class="org-role"><?= htmlspecialchars($treasurer['role'] ?? 'SK Treasurer') ?></p>
            </div>
        </div>

        <!-- Level 3: SK Members -->
        <div class="org-section-header" style="margin-top: 50px;" data-aos="fade-up">
            <h2 class="org-section-title">SK Kagawads</h2>
            <p class="org-section-subtitle">Committee Chairpersons</p>
            <div class="org-divider"></div>
        </div>

        <div class="org-level">
            <div class="org-card" data-aos="fade-up" data-aos-delay="100">
                <div class="org-avatar">
                    <?php if (!empty($kagawad1['image']) && file_exists($kagawad1['image'])): ?>
                        <img src="<?= htmlspecialchars($kagawad1['image']) ?>" alt="<?= htmlspecialchars($kagawad1['name'] ?? 'Hon. Ana Villanueva') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <?php endif; ?>
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad1['name'] ?? 'Hon. Ana Villanueva') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad1['role'] ?? 'SK Kagawad 1') ?></p>
            </div>

            <div class="org-card" data-aos="fade-up" data-aos-delay="200">
                <div class="org-avatar">
                    <?php if (!empty($kagawad2['image']) && file_exists($kagawad2['image'])): ?>
                        <img src="<?= htmlspecialchars($kagawad2['image']) ?>" alt="<?= htmlspecialchars($kagawad2['name'] ?? 'Hon. Luis Garcia') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <?php endif; ?>
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad2['name'] ?? 'Hon. Luis Garcia') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad2['role'] ?? 'SK Kagawad 2') ?></p>
            </div>

            <div class="org-card" data-aos="fade-up" data-aos-delay="300">
                <div class="org-avatar">
                    <?php if (!empty($kagawad3['image']) && file_exists($kagawad3['image'])): ?>
                        <img src="<?= htmlspecialchars($kagawad3['image']) ?>" alt="<?= htmlspecialchars($kagawad3['name'] ?? 'Hon. Maria Santos') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <?php endif; ?>
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad3['name'] ?? 'Hon. Maria Santos') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad3['role'] ?? 'SK Kagawad 3') ?></p>
            </div>
        </div>

        <div class="org-level">
            <div class="org-card" data-aos="fade-up" data-aos-delay="100">
                <div class="org-avatar">
                    <?php if (!empty($kagawad4['image']) && file_exists($kagawad4['image'])): ?>
                        <img src="<?= htmlspecialchars($kagawad4['image']) ?>" alt="<?= htmlspecialchars($kagawad4['name'] ?? 'Hon. Juanito Perez') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <?php endif; ?>
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad4['name'] ?? 'Hon. Juanito Perez') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad4['role'] ?? 'SK Kagawad 4') ?></p>
            </div>

            <div class="org-card" data-aos="fade-up" data-aos-delay="200">
                <div class="org-avatar">
                    <?php if (!empty($kagawad5['image']) && file_exists($kagawad5['image'])): ?>
                        <img src="<?= htmlspecialchars($kagawad5['image']) ?>" alt="<?= htmlspecialchars($kagawad5['name'] ?? 'Hon. Elena Cruz') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <?php endif; ?>
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad5['name'] ?? 'Hon. Elena Cruz') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad5['role'] ?? 'SK Kagawad 5') ?></p>
            </div>

            <div class="org-card" data-aos="fade-up" data-aos-delay="300">
                <div class="org-avatar">
                    <?php if (!empty($kagawad6['image']) && file_exists($kagawad6['image'])): ?>
                        <img src="<?= htmlspecialchars($kagawad6['image']) ?>" alt="<?= htmlspecialchars($kagawad6['name'] ?? 'Hon. Ricardo Gomez') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <?php endif; ?>
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad6['name'] ?? 'Hon. Ricardo Gomez') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad6['role'] ?? 'SK Kagawad 6') ?></p>
            </div>

            <div class="org-card" data-aos="fade-up" data-aos-delay="400">
                <div class="org-avatar">
                    <?php if (!empty($kagawad7['image']) && file_exists($kagawad7['image'])): ?>
                        <img src="<?= htmlspecialchars($kagawad7['image']) ?>" alt="<?= htmlspecialchars($kagawad7['name'] ?? 'Hon. Pedro Reyes') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <?php endif; ?>
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad7['name'] ?? 'Hon. Pedro Reyes') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad7['role'] ?? 'SK Kagawad 7') ?></p>
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
                    <img src="assets/images/Lapuyan Logo.png" alt="Municipality of Lapuyan Logo" class="footer-logo">
                    <div class="footer-brand-text">
                        <h2>BARANGAY<br>SAN JOSE</h2>
                        <p>Bayanihan &bull; Serbisyong Totoo</p>
                    </div>
                </div>

                <!-- Right Side: Links -->
                <div class="footer-links-wrapper">
                    <a href="index.php">HOME</a>
                    <a href="about.php">ABOUT US</a>
                    <a href="about.php#history">HISTORY</a>
                    <a href="vision.php">VISION</a>
                    <a href="mission.php">MISSION</a>
                    <a href="officials.php">OFFICIALS</a>
                    <a href="skofficials.php">SK OFFICIALS</a>
                    <a href="announcement.php">ANNOUNCEMENTS</a>
                    <a href="gallery.php">GALLERY</a>
                    <a href="spotmap.php">SPOT MAP</a>
                    <a href="services.php">SERVICES</a>
                    <a href="contact.php">CONTACT US</a>
                </div>
            </div>

            <!-- Divider & Bottom Section -->
            <div class="footer-bottom">
                <hr class="footer-divider">
                
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







