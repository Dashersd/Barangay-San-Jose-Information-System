<?php
session_start();

// Reset chat session after 1 day (86400 seconds)
if (isset($_SESSION['chat_start_time']) && (time() - $_SESSION['chat_start_time'] > 86400)) {
    unset($_SESSION['chat_token']);
    unset($_SESSION['chat_start_time']);
}

require_once __DIR__ . '/db_connect.php';

// Fetch latest gallery items for homepage showcase
$home_gallery_query = "SELECT m.*, f.folder_name 
                       FROM gallery_media m 
                       JOIN gallery_folders f ON m.folder_id = f.id 
                       ORDER BY m.uploaded_at DESC 
                       LIMIT 4";
$home_gallery_res = $conn->query($home_gallery_query);
$home_media_items = [];
if ($home_gallery_res) {
    while ($row = $home_gallery_res->fetch_assoc()) {
        $home_media_items[] = $row;
    }
}

// Fetch Barangay Captain data for Meet Our Leaders showcase from MySQL
require_once __DIR__ . '/officials_db.php';
$barangayList = get_barangay_officials_from_db($conn);
$captainOfficial = null;
if (is_array($barangayList)) {
    foreach ($barangayList as $item) {
        if (!empty($item['id']) && $item['id'] === 'captain') {
            $captainOfficial = $item;
            break;
        }
    }
}

// Fetch SK Chairman data for Meet Our Leaders showcase from MySQL
$skList = get_sk_officials_from_db($conn);
$skChairpersonOfficial = null;
if (is_array($skList)) {
    foreach ($skList as $item) {
        if (!empty($item['id']) && ($item['id'] === 'sk_chairperson' || $item['level'] == 1)) {
            $skChairpersonOfficial = $item;
            break;
        }
    }
}

// Fetch active services for homepage showcase and contact chat
require_once __DIR__ . '/services_db.php';
$all_active_services = get_all_services($conn, true);
$home_services = is_array($all_active_services) ? array_slice($all_active_services, 0, 4) : [];

// Fetch latest published announcements for homepage showcase
$home_announcements_query = "SELECT * FROM `announcements` WHERE `status` = 'Published' ORDER BY `event_date` DESC, `id` DESC LIMIT 3";
$home_announcements_res = $conn->query($home_announcements_query);
$home_announcements = [];
if ($home_announcements_res) {
    while ($row = $home_announcements_res->fetch_assoc()) {
        $home_announcements[] = $row;
    }
}

// Fetch Hero Background Slides & Slideshow Speed
$hero_slides = [];
$hero_speed = 5;
if (isset($conn) && !$conn->connect_error) {
    $b_check = $conn->query("SHOW TABLES LIKE 'barangay_information'");
    if ($b_check && $b_check->num_rows > 0) {
        $col_check = $conn->query("SHOW COLUMNS FROM `barangay_information` LIKE 'hero_slideshow_speed'");
        if ($col_check && $col_check->num_rows > 0) {
            $speed_res = $conn->query("SELECT hero_slideshow_speed FROM barangay_information LIMIT 1");
            if ($speed_res && $s_row = $speed_res->fetch_assoc()) {
                if (!empty($s_row['hero_slideshow_speed'])) {
                    $hero_speed = intval($s_row['hero_slideshow_speed']);
                    if (!in_array($hero_speed, [3, 5])) $hero_speed = 5;
                }
            }
        }
    }

    $h_check = $conn->query("SHOW TABLES LIKE 'hero_backgrounds'");
    if ($h_check && $h_check->num_rows > 0) {
        $h_res = $conn->query("SELECT * FROM hero_backgrounds WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
        if ($h_res) {
            while ($h_row = $h_res->fetch_assoc()) {
                if (file_exists(__DIR__ . '/' . $h_row['image_path'])) {
                    $hero_slides[] = $h_row['image_path'];
                }
            }
        }
    }
}
if (empty($hero_slides)) {
    $hero_slides[] = 'assets/images/Barangay Hall.png';
}

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

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/gallery.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/contact.css?v=<?= time() ?>">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
    .hero,
    .hero-section {
        position: relative !important;
        overflow: hidden !important;
        min-height: 80vh !important;
        display: flex !important;
        align-items: center !important;
        color: #ffffff !important;
        padding: 9.5rem 0 !important;
        background: #0d2847 !important;
    }

    @media (max-width: 991px) {
        .hero,
        .hero-section {
            padding: 6.5rem 0 4.5rem !important;
            min-height: 70vh !important;
        }
    }

    @media (max-width: 768px) {
        .hero,
        .hero-section {
            padding: 5rem 0 3.5rem !important;
            min-height: auto !important;
        }
    }

    @media (max-width: 480px) {
        .hero,
        .hero-section {
            padding: 4.25rem 0 3rem !important;
        }
    }

    .hero::before,
    .hero-section::before {
        display: none !important;
        content: none !important;
    }

    .hero-bg-container {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        z-index: 0 !important;
        overflow: hidden !important;
        pointer-events: none !important;
    }

    .hero-bg-slide {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background-position: center !important;
        background-size: cover !important;
        background-repeat: no-repeat !important;
        opacity: 0;
        transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        will-change: opacity !important;
    }

    .hero-bg-slide.active {
        opacity: 1 !important;
    }

    .hero-overlay {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: linear-gradient(90deg, rgba(13, 40, 71, 0.88) 0%, rgba(13, 40, 71, 0.68) 45%, rgba(0, 0, 0, 0.35) 100%) !important;
        z-index: 2 !important;
        pointer-events: none !important;
    }

    .hero-container {
        position: relative !important;
        z-index: 3 !important;
    }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="navbar-container">
            <!-- Logo & Brand -->
            <a href="index.php" class="navbar-brand">
                <img src="assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="navbar-logo">
                <img src="assets/images/Lapuyan Logo.png" alt="Municipality of Lapuyan Logo" class="navbar-logo">
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

            <!-- Mobile Hamburger Toggle Button -->
            <button type="button" class="navbar-mobile-toggle" id="btn-navbar-mobile-toggle" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-nav-drawer">
                <span class="hamburger-bar"></span>
                <span class="hamburger-bar"></span>
                <span class="hamburger-bar"></span>
            </button>
        </div>
    </nav>

    <!-- Mobile Navigation Drawer Backdrop -->
    <div class="mobile-nav-backdrop" id="mobile-nav-backdrop"></div>

    <!-- Mobile Navigation Drawer -->
    <aside class="mobile-nav-drawer" id="mobile-nav-drawer" aria-hidden="true">
        <div class="mobile-nav-header">
            <div class="mobile-nav-brand">
                <img src="assets/images/San Jose Logo 2.png" alt="Barangay Logo" class="mobile-nav-logo">
                <div class="mobile-nav-brand-text">
                    <div class="mobile-nav-title">Barangay San Jose</div>
                    <div class="mobile-nav-subtitle">Bayanihan &bull; Serbisyong Totoo</div>
                </div>
            </div>
            <button type="button" class="mobile-nav-close" id="btn-mobile-nav-close" aria-label="Close navigation">&times;</button>
        </div>

        <div class="mobile-nav-body">
            <ul class="mobile-nav-list">
                <li><a href="index.php" class="mobile-nav-link active"><i class="fas fa-home"></i> <span>Home</span></a></li>
                <li class="mobile-dropdown-item">
                    <button type="button" class="mobile-nav-link mobile-dropdown-toggle" id="btn-mobile-about-toggle" aria-expanded="false">
                        <span><i class="fas fa-info-circle"></i> <span>About Us</span></span>
                        <i class="fas fa-chevron-down mobile-dropdown-arrow"></i>
                    </button>
                    <div class="mobile-submenu" id="mobile-about-submenu">
                        <a href="about.php#history" class="mobile-sublink"><i class="fas fa-landmark"></i> <span>History</span></a>
                        <a href="vision.php" class="mobile-sublink"><i class="fas fa-eye"></i> <span>Vision</span></a>
                        <a href="mission.php" class="mobile-sublink"><i class="fas fa-bullseye"></i> <span>Mission</span></a>
                        <a href="officials.php" class="mobile-sublink"><i class="fas fa-users"></i> <span>Barangay Officials</span></a>
                        <a href="skofficials.php" class="mobile-sublink"><i class="fas fa-user-graduate"></i> <span>SK Officials</span></a>
                    </div>
                </li>
                <li><a href="announcement.php" class="mobile-nav-link"><i class="fas fa-bullhorn"></i> <span>Announcement</span></a></li>
                <li><a href="gallery.php" class="mobile-nav-link"><i class="fas fa-images"></i> <span>Gallery</span></a></li>
                <li><a href="spotmap.php" class="mobile-nav-link"><i class="fas fa-map-marked-alt"></i> <span>Spot Map</span></a></li>
                <li><a href="services.php" class="mobile-nav-link"><i class="fas fa-file-signature"></i> <span>Services</span></a></li>
                <li><a href="contact.php" class="mobile-nav-link"><i class="fas fa-envelope-open-text"></i> <span>Contact</span></a></li>
            </ul>
        </div>
    </aside>

    <!-- 1. Hero Section -->
    <section class="hero hero-section" id="hero-section" data-speed="<?= $hero_speed ?>">
        <div class="hero-bg-container">
            <?php foreach ($hero_slides as $i => $slide_path): ?>
                <div class="hero-bg-slide <?= $i === 0 ? 'active' : '' ?>" style="background-image: url('<?= htmlspecialchars($slide_path) ?>');"></div>
            <?php endforeach; ?>
        </div>

        <div class="hero-overlay"></div>

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

    <!-- 2. Officials Section -->
    <section class="officials-section">
        <div class="container officials-container">
            <div class="section-header text-center" data-aos="fade-up">
                <p class="section-eyebrow">BARANGAY OFFICIALS</p>
                <h2 class="section-heading-main">Meet Our <span class="highlight-text">Leaders</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">The dedicated officials working to serve the people of Barangay San Jose.</p>
            </div>
            
            <div class="officials-top-wrapper">
                <?php
                $captainName = $captainOfficial['name'] ?? 'Hon. Diego Logronio';
                $captainRole = $captainOfficial['role'] ?? 'Punong Barangay';
                $captainImage = !empty($captainOfficial['image']) ? $captainOfficial['image'] : 'assets/images/Barangay Official/captain.Diego Logronio.jpg';
                $captainQuote = !empty($captainOfficial['message']) ? $captainOfficial['message'] : 'Presiding officer of the Sangguniang Barangay, leading executive policies, community welfare programs, and peace and order in Barangay San Jose.';
                ?>
                <div class="captain-spotlight-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="captain-spotlight-img-col">
                        <img src="<?= htmlspecialchars($captainImage) ?>" alt="<?= htmlspecialchars($captainName) ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($captainName) ?>&background=random&size=350'">
                    </div>
                    <div class="captain-spotlight-info-col">
                        <span class="captain-spotlight-eyebrow">BARANGAY CAPTAIN</span>
                        <h3 class="captain-spotlight-title">Barangay Captain</h3>
                        <p class="captain-spotlight-quote">"<?= htmlspecialchars($captainQuote) ?>"</p>
                        <div class="captain-spotlight-action">
                            <a href="officials.php" class="btn btn-captain-action">View Barangay Officials &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. About Section (Full Width) -->
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
                <?php if (!empty($home_services)): ?>
                    <?php 
                    $srv_delay = 100;
                    foreach ($home_services as $srv): 
                    ?>
                        <div class="service-card" data-aos="fade-up" data-aos-delay="<?= $srv_delay ?>">
                            <div class="service-icon">
                                <?= get_service_icon_svg($srv['icon'] ?? 'document', 32, 32) ?>
                            </div>
                            <h3><?= htmlspecialchars($srv['title']) ?></h3>
                            <p><?= htmlspecialchars($srv['description']) ?></p>
                            <?php if (!empty($srv['fee'])): ?>
                                <div style="margin-top: 1rem;">
                                    <span style="display: inline-block; font-size: 0.8rem; font-weight: 700; color: #0284c7; background: #e0f2fe; padding: 0.25rem 0.75rem; border-radius: 99px;">
                                        Fee: <?= htmlspecialchars($srv['fee']) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <a href="services.php#service-<?= $srv['id'] ?>" class="service-card-btn">
                                View Service Details &rarr;
                            </a>
                        </div>
                    <?php 
                        $srv_delay += 100;
                    endforeach; 
                    ?>
                <?php else: ?>
                    <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <h3>Document Issuance</h3>
                        <p>Get your Barangay Clearance, Certificate of Indigency, and other important documents with ease.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="text-center" style="margin-top: 3rem;">
                <a href="services.php" class="btn btn-primary" style="border-radius: 99px; padding: 0.8rem 2rem; font-weight: 600; font-size: 1.05rem;">View all Services</a>
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
                <?php if (empty($home_announcements)): ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3.5rem 1.5rem; background: #ffffff; border-radius: var(--radius-md); box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px dashed #cbd5e1;">
                        <svg viewBox="0 0 24 24" width="44" height="44" fill="none" stroke="#94a3b8" stroke-width="1.75" style="margin-bottom: 12px; display: inline-block;"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        <h4 style="color: #334155; margin-bottom: 6px; font-weight: 700; font-size: 1.15rem;">No Published Announcements</h4>
                        <p style="color: #64748b; margin: 0; font-size: 0.95rem;">Check back soon for community news, schedules, and official notices.</p>
                    </div>
                <?php else: ?>
                    <?php 
                    $h_delay = 100;
                    foreach ($home_announcements as $ann): 
                        $month = date('M', strtotime($ann['event_date']));
                        $day = date('d', strtotime($ann['event_date']));
                    ?>
                        <div class="announcement-card" data-aos="fade-up" data-aos-delay="<?= $h_delay ?>">
                            <?php if (!empty($ann['cover_image'])): ?>
                                <a href="announcement.php#announcement-<?= $ann['id'] ?>" class="announcement-cover" title="<?= htmlspecialchars($ann['title']) ?>">
                                    <img src="<?= htmlspecialchars($ann['cover_image']) ?>" alt="<?= htmlspecialchars($ann['title']) ?>" loading="lazy">
                                </a>
                            <?php endif; ?>
                            <div class="announcement-body">
                                <div class="announcement-date">
                                    <span class="month"><?= htmlspecialchars($month) ?></span>
                                    <span class="day"><?= htmlspecialchars($day) ?></span>
                                </div>
                                <div class="announcement-content">
                                    <h3><?= htmlspecialchars($ann['title']) ?></h3>
                                    <ul class="announcement-4w">
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
                                    <div style="margin-top: auto; padding-top: 1rem;">
                                        <a href="announcement.php#announcement-<?= $ann['id'] ?>" class="read-more-link">Read Full Announcement &rarr;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                        $h_delay += 100;
                    endforeach; 
                    ?>
                <?php endif; ?>
            </div>
            
            <div class="text-center" style="margin-top: 3rem;">
                <a href="announcement.php" class="btn btn-outline">View All Announcements</a>
            </div>
        </div>
    </section>

    <!-- 6. Gallery Section -->
    <section id="gallery" class="gallery-section home-gallery-section">
        <div class="container gallery-container">
            <div class="section-header text-center" data-aos="fade-up">
                <p class="section-eyebrow">COMMUNITY IN ACTION</p>
                <h2 class="section-heading-main">Our <span class="highlight-text">Gallery</span></h2>
                <div class="heading-underline center-underline"></div>
                <p class="section-desc">Take a look at the latest events, activities, and programs organized for the residents of Barangay San Jose.</p>
            </div>
            
            <?php if (!empty($home_media_items)): ?>
                <div class="gallery-grid">
                    <?php foreach ($home_media_items as $index => $item): ?>
                        <div class="gallery-item-card" 
                             data-aos="zoom-in" 
                             data-aos-delay="<?= ($index % 4) * 100 ?>"
                             onclick="openHomeLightbox('<?= htmlspecialchars($item['file_path']) ?>', '<?= htmlspecialchars(addslashes($item['caption'])) ?>', '<?= htmlspecialchars(addslashes($item['folder_name'])) ?>', '<?= date('F d, Y', strtotime($item['uploaded_at'])) ?>')">
                            <div class="gallery-img-box">
                                <img src="<?= htmlspecialchars($item['file_path']) ?>" alt="<?= htmlspecialchars($item['caption']) ?>" loading="lazy" class="gallery-img">
                                <div class="gallery-item-overlay">
                                    <span class="gallery-category-pill"><?= htmlspecialchars($item['folder_name']) ?></span>
                                    <h4 class="gallery-item-title"><?= htmlspecialchars($item['caption']) ?></h4>
                                    <div class="gallery-item-bottom">
                                        <p class="gallery-item-meta">
                                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            <?= date('M d, Y', strtotime($item['uploaded_at'])) ?>
                                        </p>
                                        <span class="gallery-zoom-badge">
                                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                                            Preview
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="gallery-empty-state" data-aos="fade-up">
                    <div class="empty-icon-circle">
                        <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                    <h3>No Photos Uploaded Yet</h3>
                    <p>Community events and activities will be uploaded soon. Please check back later!</p>
                </div>
            <?php endif; ?>
            
            <div class="text-center" style="margin-top: 3.5rem;" data-aos="fade-up">
                <a href="gallery.php" class="btn btn-outline" style="border-radius: 999px; padding: 0.8rem 2.2rem; font-weight: 700;">View Full Gallery & Albums &rarr;</a>
            </div>
        </div>
    </section>

    <!-- 7. Spot Map Section -->
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
                        <a href="spotmap.php" class="btn-yellow">
                            View Full Map
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </a>
                    </div>
                    </div>

                <!-- Right Side: Map -->
                <div class="spot-map-frame" data-aos="fade-left">
                    <img src="assets/images/Map/Legend.png" alt="Barangay San Jose Map" style="width: 100%; height: 100%; object-fit: cover;">
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
                    

                </div>

                <!-- Right Side -->
                <div class="contact-home-right" data-aos="fade-left">
                    <!-- Inquiry Form Card -->
                    <div id="inquiry-form-card">
                        <span class="inquiry-card-header-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            Gmail OTP Verified Inquiry
                        </span>
                        <h2 class="contact-heading" style="margin-bottom: 0.35rem;">Send an Official Inquiry</h2>
                        <p class="inquiry-form-subtext">Verify your Gmail address with a 6-digit OTP code so our Barangay Administration can respond directly to your inbox. <strong>Please check both your Gmail Inbox and Spam/Junk folder</strong> for the verification code.</p>

                        <div id="inquiry-form-alert" class="inquiry-alert-banner"></div>

                        <form class="contact-form" id="resident-inquiry-form" action="#" method="POST">
                            <div class="form-group">
                                <label for="inquiry-name">Your Name <span style="color:#ef4444;">*</span></label>
                                <input type="text" id="inquiry-name" name="name" placeholder="Enter your full name" required>
                            </div>
                            <div class="form-group">
                                <label for="inquiry-email">Gmail / Email Address <span style="color:#ef4444;">*</span></label>
                                <input type="email" id="inquiry-email" name="email" placeholder="yourname@gmail.com" required>
                            </div>
                            <div class="form-group">
                                <label for="inquiry-service-type">Service Type / Subject <span style="color:#ef4444;">*</span></label>
                                <select id="inquiry-service-type" name="service_type" required>
                                    <option value="" disabled selected>Select service or subject</option>
                                    <?php
                                    $defaultServices = [
                                        'Barangay Clearance',
                                        'Certificate of Indigency',
                                        'Business Clearance',
                                        'Certificate of Residency',
                                        'General Inquiry / Feedback'
                                    ];
                                    $serviceOptions = [];
                                    if (!empty($all_active_services)) {
                                        foreach ($all_active_services as $srvItem) {
                                            if (!empty($srvItem['title']) && !in_array($srvItem['title'], $serviceOptions)) {
                                                $serviceOptions[] = $srvItem['title'];
                                            }
                                        }
                                    }
                                    foreach ($defaultServices as $defSrv) {
                                        if (!in_array($defSrv, $serviceOptions)) {
                                            $serviceOptions[] = $defSrv;
                                        }
                                    }
                                    foreach ($serviceOptions as $srvTitle):
                                    ?>
                                        <option value="<?= htmlspecialchars($srvTitle) ?>">
                                            <?= htmlspecialchars($srvTitle) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inquiry-message">Message / Request Details <span style="color:#ef4444;">*</span></label>
                                <textarea id="inquiry-message" name="message" rows="4" placeholder="How can Barangay San Jose assist you today?" required></textarea>
                            </div>
                            <button type="submit" id="btn-submit-inquiry" class="btn btn-primary contact-submit">
                                Verify Gmail &amp; Submit Inquiry &rarr;
                            </button>
                        </form>
                    </div>

                    <!-- Inquiry Confirmation Card (Shown after OTP Verification) -->
                    <div id="inquiry-success-card" style="display: none;">
                        <div class="inquiry-success-icon-circle">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <h3 class="inquiry-success-title">Inquiry Verified &amp; Submitted!</h3>
                        <p class="inquiry-success-desc">
                            Thank you, <strong id="success-resident-name">Resident</strong>. Your inquiry has been officially recorded in the Barangay San Jose Portal. Our officials will send their response directly to your verified Gmail:
                        </p>
                        <div>
                            <span class="verified-gmail-pill">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2.4"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>
                                <span id="success-verified-email">resident@gmail.com</span>
                            </span>
                        </div>
                        <button type="button" id="btn-send-another-inquiry" class="btn-send-another">
                            Send Another Inquiry
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pop-Up Gmail OTP Verification Modal -->
    <div id="gmail-otp-modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="gmail-otp-title">
        <div class="gmail-otp-modal-dialog">
            <button type="button" class="gmail-otp-close-btn" id="btn-modal-close-otp" title="Close verification">&times;</button>
            <div class="gmail-otp-shield-badge">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>
            </div>
            <h3 class="gmail-otp-modal-title" id="gmail-otp-title">Gmail OTP Verification</h3>
            <p class="gmail-otp-modal-subtitle">Enter the 6-digit verification code sent to your Gmail address (please check both your <strong>Gmail Inbox</strong> and <strong>Spam / Junk folder</strong>):</p>
            <div class="gmail-otp-target-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <span id="modal-otp-target-email">resident@gmail.com</span>
            </div>
            <div style="font-size: 0.78rem; color: #475569; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 0.5rem 0.75rem; margin-bottom: 0.85rem; line-height: 1.4;">
                💡 <strong>Didn't see the email?</strong> Check your <strong>Spam</strong>, <strong>Junk</strong>, or <strong>Promotions</strong> folder in Gmail, or wait 30 seconds and click <strong>Resend Code</strong>.
            </div>

            <div id="modal-otp-dev-hint" class="gmail-otp-dev-hint"></div>
            <div id="modal-otp-alert" class="gmail-otp-modal-alert"></div>

            <div class="gmail-otp-digits-row" id="gmail-otp-digits-row">
                <input type="text" inputmode="numeric" maxlength="1" class="gmail-otp-digit-box" data-idx="0" autocomplete="one-time-code" aria-label="Digit 1">
                <input type="text" inputmode="numeric" maxlength="1" class="gmail-otp-digit-box" data-idx="1" aria-label="Digit 2">
                <input type="text" inputmode="numeric" maxlength="1" class="gmail-otp-digit-box" data-idx="2" aria-label="Digit 3">
                <input type="text" inputmode="numeric" maxlength="1" class="gmail-otp-digit-box" data-idx="3" aria-label="Digit 4">
                <input type="text" inputmode="numeric" maxlength="1" class="gmail-otp-digit-box" data-idx="4" aria-label="Digit 5">
                <input type="text" inputmode="numeric" maxlength="1" class="gmail-otp-digit-box" data-idx="5" aria-label="Digit 6">
            </div>

            <div class="gmail-otp-countdown-bar">
                <span class="gmail-otp-timer-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    Expires in: <strong id="modal-otp-countdown">03:00</strong>
                </span>
                <button type="button" class="gmail-otp-resend-btn" id="btn-modal-resend-otp" disabled>Resend Code (30s)</button>
            </div>

            <button type="button" class="btn-verify-otp-submit" id="btn-modal-verify-otp">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Verify &amp; Submit Inquiry</span>
            </button>
        </div>
    </div>

    

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js?v=2"></script>
    <script>
    (function() {
        const form = document.getElementById('resident-inquiry-form');
        const formCard = document.getElementById('inquiry-form-card');
        const successCard = document.getElementById('inquiry-success-card');
        const formAlert = document.getElementById('inquiry-form-alert');
        const btnSubmit = document.getElementById('btn-submit-inquiry');

        const modalBackdrop = document.getElementById('gmail-otp-modal-backdrop');
        const btnCloseModal = document.getElementById('btn-modal-close-otp');
        const targetEmailEl = document.getElementById('modal-otp-target-email');
        const modalAlert = document.getElementById('modal-otp-alert');
        const modalDevHint = document.getElementById('modal-otp-dev-hint');
        const countdownEl = document.getElementById('modal-otp-countdown');
        const btnResend = document.getElementById('btn-modal-resend-otp');
        const btnVerify = document.getElementById('btn-modal-verify-otp');
        const digitBoxes = Array.from(document.querySelectorAll('.gmail-otp-digit-box'));

        let expiryTimer = null;
        let resendTimer = null;
        let remainingExpireSec = 180;
        let remainingResendSec = 30;

        function showFormAlert(msg, type) {
            if (!formAlert) return;
            formAlert.className = 'inquiry-alert-banner ' + (type || 'error');
            formAlert.textContent = msg;
            formAlert.style.display = 'flex';
        }

        function hideFormAlert() {
            if (!formAlert) return;
            formAlert.style.display = 'none';
        }

        function showModalAlert(msg, type) {
            if (!modalAlert) return;
            modalAlert.className = 'gmail-otp-modal-alert ' + (type || 'error');
            modalAlert.textContent = msg;
            modalAlert.style.display = 'block';
        }

        function hideModalAlert() {
            if (!modalAlert) return;
            modalAlert.style.display = 'none';
        }

        function formatMMSS(sec) {
            const m = Math.floor(Math.max(0, sec) / 60);
            const s = Math.max(0, sec) % 60;
            return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }

        function startOtpTimers(expireSeconds) {
            clearInterval(expiryTimer);
            clearInterval(resendTimer);

            remainingExpireSec = expireSeconds || 180;
            remainingResendSec = 30;

            countdownEl.textContent = formatMMSS(remainingExpireSec);
            btnResend.disabled = true;
            btnResend.textContent = `Resend Code (${remainingResendSec}s)`;

            expiryTimer = setInterval(() => {
                remainingExpireSec--;
                countdownEl.textContent = formatMMSS(remainingExpireSec);
                if (remainingExpireSec <= 0) {
                    clearInterval(expiryTimer);
                    showModalAlert('Verification code has expired. Please click "Resend Code" to receive a new 6-digit OTP.', 'error');
                }
            }, 1000);

            resendTimer = setInterval(() => {
                remainingResendSec--;
                if (remainingResendSec <= 0) {
                    clearInterval(resendTimer);
                    btnResend.disabled = false;
                    btnResend.textContent = 'Resend Code';
                } else {
                    btnResend.textContent = `Resend Code (${remainingResendSec}s)`;
                }
            }, 1000);
        }

        function openOtpModal(email, expiresIn, otpPreview) {
            targetEmailEl.textContent = email;
            hideModalAlert();
            if (otpPreview && modalDevHint) {
                modalDevHint.style.display = 'block';
                modalDevHint.innerHTML = '<strong>Instant Verification Code (SMTP Fallback):</strong> <span style="font-family:monospace;font-size:1.05rem;font-weight:800;letter-spacing:2px;color:#0d2847;">' + otpPreview + '</span><br><span style="font-size:0.74rem;color:#475569;">(If the email is not in your Gmail Inbox or Spam folder yet, you can use this code or configure the 16-digit Gmail App Password in Admin &rarr; Settings &rarr; Hotlines &amp; Contacts.)</span>';
            } else if (modalDevHint) {
                modalDevHint.style.display = 'none';
            }
            digitBoxes.forEach(b => {
                b.value = '';
                b.classList.remove('filled');
            });
            modalBackdrop.classList.add('active');
            startOtpTimers(expiresIn || 180);
            setTimeout(() => {
                if (digitBoxes[0]) digitBoxes[0].focus();
            }, 80);
        }

        function closeOtpModal() {
            modalBackdrop.classList.remove('active');
            clearInterval(expiryTimer);
            clearInterval(resendTimer);
        }

        digitBoxes.forEach((box, idx) => {
            box.addEventListener('input', (e) => {
                const val = e.target.value.replace(/[^0-9]/g, '');
                e.target.value = val ? val.charAt(val.length - 1) : '';
                if (e.target.value) {
                    e.target.classList.add('filled');
                    if (idx < digitBoxes.length - 1) {
                        digitBoxes[idx + 1].focus();
                    }
                } else {
                    e.target.classList.remove('filled');
                }
            });

            box.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace') {
                    if (!box.value && idx > 0) {
                        digitBoxes[idx - 1].value = '';
                        digitBoxes[idx - 1].classList.remove('filled');
                        digitBoxes[idx - 1].focus();
                        e.preventDefault();
                    } else {
                        box.classList.remove('filled');
                    }
                } else if (e.key === 'ArrowLeft' && idx > 0) {
                    digitBoxes[idx - 1].focus();
                    e.preventDefault();
                } else if (e.key === 'ArrowRight' && idx < digitBoxes.length - 1) {
                    digitBoxes[idx + 1].focus();
                    e.preventDefault();
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    submitOtpVerification();
                }
            });

            box.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                if (!pasted) return;
                for (let i = 0; i < digitBoxes.length; i++) {
                    digitBoxes[i].value = pasted[i] || '';
                    if (digitBoxes[i].value) {
                        digitBoxes[i].classList.add('filled');
                    } else {
                        digitBoxes[i].classList.remove('filled');
                    }
                }
                const nextFocusIdx = Math.min(pasted.length, digitBoxes.length - 1);
                digitBoxes[nextFocusIdx].focus();
            });
        });

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                hideFormAlert();

                const name = document.getElementById('inquiry-name').value.trim();
                const email = document.getElementById('inquiry-email').value.trim();
                const serviceType = document.getElementById('inquiry-service-type').value;
                const message = document.getElementById('inquiry-message').value.trim();

                if (!name || !email || !serviceType || !message) {
                    showFormAlert('Please fill out all required fields before submitting.', 'error');
                    return;
                }

                const origBtnHtml = btnSubmit.innerHTML;
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = 'Sending 6-Digit OTP to Gmail...';

                const fd = new FormData();
                fd.append('name', name);
                fd.append('email', email);
                fd.append('service_type', serviceType);
                fd.append('message', message);

                fetch('api/send_otp.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(res => {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = origBtnHtml;
                    if (res.status === 'success') {
                        openOtpModal(res.email || email, res.expires_in || 180, res.otp_preview || null);
                    } else {
                        showFormAlert(res.message || 'Unable to send verification code. Please try again.', 'error');
                    }
                })
                .catch(() => {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = origBtnHtml;
                    showFormAlert('Network error while connecting to verification server.', 'error');
                });
            });
        }

        if (btnResend) {
            btnResend.addEventListener('click', function() {
                if (btnResend.disabled) return;
                btnResend.disabled = true;
                btnResend.textContent = 'Sending...';
                hideModalAlert();

                const fd = new FormData();
                fd.append('action', 'resend');

                fetch('api/send_otp.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(res => {
                    if (res.status === 'success') {
                        showModalAlert('A fresh 6-digit verification code has been sent! Please check both your Gmail Inbox and Spam/Junk folder.', 'success');
                        if (res.otp_preview && modalDevHint) {
                            modalDevHint.style.display = 'block';
                            modalDevHint.innerHTML = '<strong>Instant Verification Code (SMTP Fallback):</strong> <span style="font-family:monospace;font-size:1.05rem;font-weight:800;letter-spacing:2px;color:#0d2847;">' + res.otp_preview + '</span>';
                        }
                        digitBoxes.forEach(b => { b.value = ''; b.classList.remove('filled'); });
                        digitBoxes[0].focus();
                        startOtpTimers(res.expires_in || 180);
                    } else {
                        btnResend.disabled = false;
                        btnResend.textContent = 'Resend Code';
                        showModalAlert(res.message || 'Could not resend code.', 'error');
                    }
                })
                .catch(() => {
                    btnResend.disabled = false;
                    btnResend.textContent = 'Resend Code';
                    showModalAlert('Network error while resending code.', 'error');
                });
            });
        }

        function submitOtpVerification() {
            const code = digitBoxes.map(b => b.value.trim()).join('');
            if (code.length !== 6) {
                showModalAlert('Please enter all 6 digits of your verification code.', 'error');
                return;
            }

            const origVerifyHtml = btnVerify.innerHTML;
            btnVerify.disabled = true;
            btnVerify.innerHTML = 'Verifying &amp; Submitting...';
            hideModalAlert();

            const fd = new FormData();
            fd.append('otp', code);

            fetch('api/verify_otp.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(res => {
                btnVerify.disabled = false;
                btnVerify.innerHTML = origVerifyHtml;
                if (res.status === 'success') {
                    closeOtpModal();
                    document.getElementById('success-resident-name').textContent = res.name || 'Resident';
                    document.getElementById('success-verified-email').textContent = res.email || '';
                    formCard.style.display = 'none';
                    successCard.style.display = 'block';
                    form.reset();
                } else {
                    showModalAlert(res.message || 'Invalid verification code.', 'error');
                }
            })
            .catch(() => {
                btnVerify.disabled = false;
                btnVerify.innerHTML = origVerifyHtml;
                showModalAlert('Network error while verifying OTP code.', 'error');
            });
        }

        if (btnVerify) {
            btnVerify.addEventListener('click', submitOtpVerification);
        }

        if (btnCloseModal) {
            btnCloseModal.addEventListener('click', closeOtpModal);
        }

        if (modalBackdrop) {
            modalBackdrop.addEventListener('click', function(e) {
                if (e.target === modalBackdrop) {
                    closeOtpModal();
                }
            });
        }

        const btnAnother = document.getElementById('btn-send-another-inquiry');
        if (btnAnother) {
            btnAnother.addEventListener('click', function() {
                successCard.style.display = 'none';
                formCard.style.display = 'block';
                hideFormAlert();
            });
        }
    })();
    </script>

    <!-- Home Gallery Lightbox Modal -->
    <div id="homeLightbox" class="public-lightbox-modal" style="display: none;" onclick="if(event.target === this) closeHomeLightbox();">
        <div class="public-lightbox-dialog">
            <button type="button" class="lightbox-close-btn" onclick="closeHomeLightbox()">&times;</button>
            <div class="lightbox-img-wrapper">
                <img id="homeLightboxImg" src="" alt="Enlarged gallery photo">
            </div>
            <div class="public-lightbox-footer">
                <div class="public-lightbox-details">
                    <span id="homeLightboxCategory" class="lightbox-tag"></span>
                    <h3 id="homeLightboxTitle"></h3>
                    <span id="homeLightboxDate" class="lightbox-date"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
    function openHomeLightbox(imgSrc, caption, category, uploadDate) {
        const modal = document.getElementById('homeLightbox');
        const img = document.getElementById('homeLightboxImg');
        const cat = document.getElementById('homeLightboxCategory');
        const title = document.getElementById('homeLightboxTitle');
        const date = document.getElementById('homeLightboxDate');

        if (modal && img) {
            img.src = imgSrc;
            cat.textContent = category || 'Barangay San Jose';
            title.textContent = caption || '';
            date.textContent = uploadDate || '';
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeHomeLightbox() {
        const modal = document.getElementById('homeLightbox');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeHomeLightbox();
        }
    });

    function initHeroBackgroundSlideshow() {
        const heroSection = document.getElementById('hero-section');
        if (!heroSection) return;
        const slides = Array.from(heroSection.querySelectorAll('.hero-bg-slide'));
        if (!slides || slides.length <= 1) return;

        const speedSeconds = parseInt(heroSection.getAttribute('data-speed'), 10) || 5;
        const intervalMs = Math.max(2, speedSeconds) * 1000;
        let currentIdx = 0;

        slides.forEach(function(s, i) {
            s.style.opacity = (i === 0) ? '1' : '0';
            s.style.zIndex = (i === 0) ? '1' : '0';
        });

        setInterval(function() {
            const prevIdx = currentIdx;
            currentIdx = (currentIdx + 1) % slides.length;

            const prevSlide = slides[prevIdx];
            const nextSlide = slides[currentIdx];

            nextSlide.style.zIndex = '2';
            nextSlide.style.opacity = '1';

            prevSlide.style.zIndex = '1';

            setTimeout(function() {
                prevSlide.style.opacity = '0';
                prevSlide.style.zIndex = '0';
                nextSlide.style.zIndex = '1';
            }, 1300);
        }, intervalMs);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroBackgroundSlideshow);
    } else {
        initHeroBackgroundSlideshow();
    }
    </script>
</body>

</html>











