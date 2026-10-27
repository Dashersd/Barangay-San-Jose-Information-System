<?php
// Barangay San Jose Web-Based Information System - Officials
require_once __DIR__ . '/officials_db.php';

$officialsList = get_barangay_officials_from_db($conn);
$officials = [];
if (is_array($officialsList)) {
    foreach ($officialsList as $item) {
        if (!empty($item['id'])) {
            $officials[$item['id']] = $item;
        }
    }
}
$captain = $officials['captain'] ?? null;
$secretary = $officials['secretary'] ?? null;
$treasurer = $officials['treasurer'] ?? null;
$kagawad1 = $officials['kagawad_1'] ?? null;
$kagawad2 = $officials['kagawad_2'] ?? null;
$kagawad3 = $officials['kagawad_3'] ?? null;
$kagawad4 = $officials['kagawad_4'] ?? null;
$kagawad5 = $officials['kagawad_5'] ?? null;
$kagawad6 = $officials['kagawad_6'] ?? null;
$kagawad7 = $officials['kagawad_7'] ?? null;
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
    <link rel="stylesheet" href="assets/css/officials.css">
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
                        <a href="officials.php" class="active">Barangay Officials</a>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <p class="hero-subtitle" data-aos="fade-up">OFFICIALS</p>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">BARANGAY SAN JOSE</h1>
                <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">The dedicated leaders who work together to ensure the progress,<br>peace, and well-being of our community.</p>
            </div>
        </div>
    </section>

    <!-- Officials Content (Org Chart Layout) -->
    <section class="org-chart-container">
        
        <!-- Level 1: Executive Leadership -->
        <div class="org-section-header" data-aos="fade-up">
            <h2 class="org-section-title">Executive Leadership</h2>
            <p class="org-section-subtitle">Head of the Barangay Government</p>
            <div class="org-divider"></div>
        </div>

        <div class="org-level">
            <div class="org-card-wide" data-aos="fade-up" data-aos-delay="100">
                <div class="org-avatar-wide">
                    <img src="<?= htmlspecialchars($captain['image'] ?? 'assets/images/Barangay Official/captain.Diego Logronio.jpg') ?>" alt="<?= htmlspecialchars($captain['name'] ?? 'Hon. Diego Logronio') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
                <div class="org-info-wide">
                    <h3 class="org-name-wide"><?= htmlspecialchars($captain['name'] ?? 'Hon. Diego Logronio') ?></h3>
                    <p class="org-role-wide"><?= htmlspecialchars($captain['role'] ?? 'Punong Barangay') ?></p>
                    <p class="org-desc-wide"><?= htmlspecialchars($captain['message'] ?? 'Presiding officer of the Sangguniang Barangay, leading executive policies, community welfare programs, and peace and order in Barangay San Jose.') ?></p>
                </div>
            </div>
        </div>

        <!-- Level 2: Sangguniang Barangay Members -->
        <div class="org-section-header" style="margin-top: 50px;" data-aos="fade-up">
            <h2 class="org-section-title">Sangguniang Barangay Members</h2>
            <p class="org-section-subtitle">Barangay Kagawads & Committee Chairpersons</p>
            <div class="org-divider"></div>
        </div>

        <div class="org-level">
            <div class="org-card" data-aos="fade-up" data-aos-delay="100">
                <div class="org-avatar">
                    <img src="<?= htmlspecialchars($secretary['image'] ?? 'assets/images/Barangay Official/secretary michelle deluna.jpg') ?>" alt="<?= htmlspecialchars($secretary['name'] ?? 'Hon. Michelle Deluna') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
                <h3 class="org-name"><?= htmlspecialchars($secretary['name'] ?? 'Hon. Michelle Deluna') ?></h3>
                <p class="org-role"><?= htmlspecialchars($secretary['role'] ?? 'Barangay Secretary') ?></p>
            </div>
            
            <div class="org-card" data-aos="fade-up" data-aos-delay="200">
                <div class="org-avatar">
                    <img src="<?= htmlspecialchars($treasurer['image'] ?? 'assets/images/Barangay Official/treasurer alfredo alasaas.jpg') ?>" alt="<?= htmlspecialchars($treasurer['name'] ?? 'Hon. Alfredo Alasaas') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
                <h3 class="org-name"><?= htmlspecialchars($treasurer['name'] ?? 'Hon. Alfredo Alasaas') ?></h3>
                <p class="org-role"><?= htmlspecialchars($treasurer['role'] ?? 'Barangay Treasurer') ?></p>
            </div>
        </div>

        <div class="org-level">
            <div class="org-card" data-aos="fade-up" data-aos-delay="100">
                <div class="org-avatar">
                    <img src="<?= htmlspecialchars($kagawad1['image'] ?? 'assets/images/Barangay Official/1.Fedelina Thundas.jpg') ?>" alt="<?= htmlspecialchars($kagawad1['name'] ?? 'Hon. Fedelina Thundas') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad1['name'] ?? 'Hon. Fedelina Thundas') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad1['role'] ?? 'Barangay Kagawad 1') ?></p>
            </div>

            <div class="org-card" data-aos="fade-up" data-aos-delay="200">
                <div class="org-avatar">
                    <img src="<?= htmlspecialchars($kagawad2['image'] ?? 'assets/images/Barangay Official/2 Mario godines.jpg') ?>" alt="<?= htmlspecialchars($kagawad2['name'] ?? 'Hon. Mario Godines') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad2['name'] ?? 'Hon. Mario Godines') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad2['role'] ?? 'Barangay Kagawad 2') ?></p>
            </div>

            <div class="org-card" data-aos="fade-up" data-aos-delay="300">
                <div class="org-avatar">
                    <img src="<?= htmlspecialchars($kagawad3['image'] ?? 'assets/images/Barangay Official/3 jennifer dolen.jpg') ?>" alt="<?= htmlspecialchars($kagawad3['name'] ?? 'Hon. Jennifer Dolen') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad3['name'] ?? 'Hon. Jennifer Dolen') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad3['role'] ?? 'Barangay Kagawad 3') ?></p>
            </div>
        </div>

        <div class="org-level">
            <div class="org-card" data-aos="fade-up" data-aos-delay="100">
                <div class="org-avatar">
                    <img src="<?= htmlspecialchars($kagawad4['image'] ?? 'assets/images/Barangay Official/4 calixto mamac.jpg') ?>" alt="<?= htmlspecialchars($kagawad4['name'] ?? 'Hon. Calixto Mamac') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad4['name'] ?? 'Hon. Calixto Mamac') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad4['role'] ?? 'Barangay Kagawad 4') ?></p>
            </div>

            <div class="org-card" data-aos="fade-up" data-aos-delay="200">
                <div class="org-avatar">
                    <img src="<?= htmlspecialchars($kagawad5['image'] ?? 'assets/images/Barangay Official/5 rodrigo godinez.jpg') ?>" alt="<?= htmlspecialchars($kagawad5['name'] ?? 'Hon. Rodrigo Godinez') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad5['name'] ?? 'Hon. Rodrigo Godinez') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad5['role'] ?? 'Barangay Kagawad 5') ?></p>
            </div>

            <div class="org-card" data-aos="fade-up" data-aos-delay="300">
                <div class="org-avatar">
                    <img src="<?= htmlspecialchars($kagawad6['image'] ?? 'assets/images/Barangay Official/6 rodelio besirel.jpg') ?>" alt="<?= htmlspecialchars($kagawad6['name'] ?? 'Hon. Rodelio Basirel') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad6['name'] ?? 'Hon. Rodelio Basirel') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad6['role'] ?? 'Barangay Kagawad 6') ?></p>
            </div>

            <div class="org-card" data-aos="fade-up" data-aos-delay="400">
                <div class="org-avatar">
                    <img src="<?= htmlspecialchars($kagawad7['image'] ?? 'assets/images/Barangay Official/7 jimmy daligdig.jpg') ?>" alt="<?= htmlspecialchars($kagawad7['name'] ?? 'Hon. Jimmy Daligdig') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
                <h3 class="org-name"><?= htmlspecialchars($kagawad7['name'] ?? 'Hon. Jimmy Daligdig') ?></h3>
                <p class="org-role"><?= htmlspecialchars($kagawad7['role'] ?? 'Barangay Kagawad 7') ?></p>
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





