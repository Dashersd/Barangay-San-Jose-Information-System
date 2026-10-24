<?php
// Public Gallery Page - Barangay San Jose
require_once __DIR__ . '/db_connect.php';

// Fetch all folders with photo count
$folders_query = "SELECT f.*, COUNT(m.id) AS media_count 
                  FROM gallery_folders f 
                  LEFT JOIN gallery_media m ON f.id = m.folder_id 
                  GROUP BY f.id 
                  ORDER BY f.folder_name ASC";
$folders_res = $conn->query($folders_query);
$folders = [];
if ($folders_res) {
    while ($row = $folders_res->fetch_assoc()) {
        $folders[] = $row;
    }
}

// Fetch all uploaded gallery media joined with folder title
$media_query = "SELECT m.*, f.folder_name 
                FROM gallery_media m 
                JOIN gallery_folders f ON m.folder_id = f.id 
                ORDER BY m.uploaded_at DESC";
$media_res = $conn->query($media_query);
$media_items = [];
if ($media_res) {
    while ($row = $media_res->fetch_assoc()) {
        $media_items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Barangay San Jose</title>
    
    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/gallery.css?v=<?= time() ?>">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
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
                <li><a href="gallery.php" class="active">Gallery</a></li>
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
                <p class="hero-subtitle" data-aos="fade-up">GALLERY & ALBUMS</p>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">BARANGAY SAN JOSE</h1>
                <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">Explore community gatherings, youth activities, health missions, and official projects captured through our lens.</p>
            </div>
        </div>
    </section>

    <!-- 2. Gallery Section -->
    <section id="gallery" class="gallery-section">
        <div class="container gallery-container">
            
            <!-- Category Filter Tabs (Style 1) -->
            <div class="gallery-filter-wrapper" data-aos="fade-up">
                <div class="gallery-filter-tabs">
                    <button type="button" class="filter-tab-btn active" data-filter="all">
                        <span class="tab-label">All Photos</span>
                        <span class="tab-badge"><?= count($media_items) ?></span>
                    </button>
                    <?php foreach ($folders as $folder): ?>
                        <button type="button" class="filter-tab-btn" data-filter="folder-<?= $folder['id'] ?>">
                            <span class="tab-label"><?= htmlspecialchars($folder['folder_name']) ?></span>
                            <span class="tab-badge"><?= $folder['media_count'] ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Photos Grid -->
            <?php if (empty($media_items)): ?>
                <div class="gallery-empty-state" data-aos="fade-up">
                    <div class="empty-icon-circle">
                        <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                    <h3>No Photos Uploaded Yet</h3>
                    <p>Community events and activities will be uploaded soon. Please check back later!</p>
                </div>
            <?php else: ?>
                <div class="gallery-grid" id="publicGalleryGrid">
                    <?php foreach ($media_items as $index => $item): ?>
                        <div class="gallery-item-card" 
                             data-category="folder-<?= $item['folder_id'] ?>" 
                             data-aos="zoom-in" 
                             data-aos-delay="<?= ($index % 4) * 100 ?>"
                             onclick="openGalleryLightbox('<?= htmlspecialchars($item['file_path']) ?>', '<?= htmlspecialchars(addslashes($item['caption'])) ?>', '<?= htmlspecialchars(addslashes($item['folder_name'])) ?>', '<?= date('F d, Y', strtotime($item['uploaded_at'])) ?>')">
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

                <!-- Empty State shown if filtered category has 0 photos -->
                <div id="noPhotosInCategory" class="gallery-empty-state" style="display: none;">
                    <div class="empty-icon-circle">
                        <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                    <h3>No Photos in This Category</h3>
                    <p>There are no uploaded pictures under this specific folder yet.</p>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- Public Image Lightbox Modal -->
    <div id="publicLightbox" class="public-lightbox-modal" style="display: none;" onclick="if(event.target === this) closeGalleryLightbox();">
        <div class="public-lightbox-dialog">
            <button type="button" class="lightbox-close-btn" onclick="closeGalleryLightbox()">&times;</button>
            <div class="lightbox-img-wrapper">
                <img id="publicLightboxImg" src="" alt="Enlarged photo view">
            </div>
            <div class="public-lightbox-footer">
                <div class="public-lightbox-details">
                    <span id="publicLightboxCategory" class="lightbox-tag"></span>
                    <h3 id="publicLightboxTitle"></h3>
                    <span id="publicLightboxDate" class="lightbox-date"></span>
                </div>
            </div>
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
    <script>
        // Category Filter Handling (Style 1)
        document.addEventListener('DOMContentLoaded', () => {
            const filterBtns = document.querySelectorAll('.filter-tab-btn');
            const items = document.querySelectorAll('.gallery-item-card');
            const noPhotosMsg = document.getElementById('noPhotosInCategory');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Update active button state
                    filterBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    const targetFilter = btn.getAttribute('data-filter');
                    let visibleCount = 0;

                    items.forEach(item => {
                        const itemCat = item.getAttribute('data-category');
                        if (targetFilter === 'all' || itemCat === targetFilter) {
                            item.style.display = 'block';
                            visibleCount++;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Toggle empty state if filtered category has 0 items
                    if (noPhotosMsg) {
                        noPhotosMsg.style.display = (visibleCount === 0) ? 'block' : 'none';
                    }

                    // Refresh AOS animations
                    if (window.AOS) {
                        AOS.refresh();
                    }
                });
            });
        });

        // Lightbox Functions
        function openGalleryLightbox(imgSrc, caption, category, uploadDate) {
            const modal = document.getElementById('publicLightbox');
            const img = document.getElementById('publicLightboxImg');
            const cat = document.getElementById('publicLightboxCategory');
            const title = document.getElementById('publicLightboxTitle');
            const date = document.getElementById('publicLightboxDate');

            if (modal && img) {
                img.src = imgSrc;
                cat.textContent = category || 'Barangay San Jose';
                title.textContent = caption || '';
                date.textContent = uploadDate || '';
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden'; // Prevent background scroll
            }
        }

        function closeGalleryLightbox() {
            const modal = document.getElementById('publicLightbox');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeGalleryLightbox();
            }
        });
    </script>
</body>
</html>
