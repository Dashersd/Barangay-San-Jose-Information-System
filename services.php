<?php
// Barangay San Jose Web-Based Information System - Services
require_once __DIR__ . '/services_db.php';

// Fetch active services from the database
$services = get_all_services($conn, true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Services offered by Barangay San Jose">
    <title>Services | Barangay San Jose Information System</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">
        
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/services.css?v=<?= time() ?>">
    
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
                <li><a href="services.php" class="active">Services</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <!-- Right Side: Admin Login -->
            <div class="navbar-right">
                <a href="Admin/login.php" class="admin-login-link">Admin Login</a>
            </div>
        </div>
    </nav>

    <!-- 1. Hero Section for Services -->
    <section class="hero hero-services">
        <div class="container hero-container">
            <div class="hero-content">
                <p class="hero-subtitle" data-aos="fade-up">BARANGAY SAN JOSE</p>
                <h1 class="hero-title" style="font-size: 3.5rem;" data-aos="fade-up" data-aos-delay="100">SERVICES</h1>
                <p class="hero-desc" style="margin-bottom: 0;" data-aos="fade-up" data-aos-delay="200">Providing essential documents and assistance for all residents.</p>
            </div>
        </div>
    </section>

    <!-- 2. Services Content Section -->
    <main class="services-page-section">
        <div class="container services-page-container">
            
            <div class="services-cards-grid">
                <?php if (empty($services)): ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3.5rem 1.5rem; background: #ffffff; border-radius: 16px; border: 2px dashed #cbd5e1; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                        <div style="width: 60px; height: 60px; margin: 0 auto 1rem; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        </div>
                        <h3 style="color: #0f172a; margin-bottom: 0.5rem; font-size: 1.25rem; font-weight: 700;">No Services Listed Currently</h3>
                        <p style="color: #64748b; max-width: 450px; margin: 0 auto;">Please check back soon or visit our Barangay Hall during regular office hours for inquiries.</p>
                    </div>
                <?php else: ?>
                    <?php $delay = 100; ?>
                    <?php foreach ($services as $srv): ?>
                        <div class="srv-card" id="service-<?= $srv['id'] ?>" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                            <div class="srv-icon-wrapper">
                                <?= get_service_icon_svg($srv['icon'], 28, 28) ?>
                            </div>
                            <h3 class="srv-title"><?= htmlspecialchars($srv['title']) ?></h3>
                            <p class="srv-desc"><?= htmlspecialchars($srv['description']) ?></p>
                            
                            <?php if (!empty($srv['fee']) || !empty($srv['processing_time']) || !empty($srv['requirements'])): ?>
                                <div class="srv-details-box">
                                    <?php if (!empty($srv['fee']) || !empty($srv['processing_time'])): ?>
                                        <div class="srv-badges-row">
                                            <?php if (!empty($srv['fee'])): ?>
                                                <span class="srv-badge srv-badge-fee">Fee: <?= htmlspecialchars($srv['fee']) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($srv['processing_time'])): ?>
                                                <span class="srv-badge srv-badge-time">Time: <?= htmlspecialchars($srv['processing_time']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($srv['requirements'])): ?>
                                        <div class="srv-reqs-preview" title="<?= htmlspecialchars($srv['requirements']) ?>">
                                            <strong>Requirements:</strong> <?= htmlspecialchars($srv['requirements']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php 
                            $btnLink = !empty($srv['btn_link']) ? $srv['btn_link'] : 'contact.php';
                            if ($btnLink === 'contact.php') {
                                $btnLink .= '?service=' . urlencode($srv['title']);
                            }
                            ?>
                            <div class="srv-card-actions">
                                <button type="button" class="btn-service btn-service-details" onclick='openServiceDetailsModal(<?= json_encode($srv, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                    View Details
                                </button>
                                <?php if (!empty($srv['document_file'])): ?>
                                    <a href="<?= htmlspecialchars($srv['document_file']) ?>" download class="btn-service btn-service-download" title="Download Form Template">
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                        Download Form
                                    </a>
                                <?php endif; ?>
                                <a href="<?= htmlspecialchars($btnLink) ?>" class="btn-service btn-service-primary">
                                    <?= !empty($srv['btn_text']) ? htmlspecialchars($srv['btn_text']) : 'Request Document' ?> &rarr;
                                </a>
                            </div>
                        </div>
                        <?php $delay += 100; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </main>

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

    <!-- Service Details Modal -->
    <div id="serviceDetailsModal" class="public-service-modal-overlay" style="display: none;" onclick="if(event.target === this) closeServiceDetailsModal();">
        <div class="public-service-modal-box">
            <!-- Modal Header -->
            <div class="modal-service-header">
                <div class="modal-service-brand">
                    <div class="modal-service-icon" id="modalServiceIcon">
                        <!-- SVG injected via JS -->
                    </div>
                    <div>
                        <span class="modal-service-kicker">Barangay San Jose &bull; Public Service</span>
                        <h2 class="modal-service-title" id="modalServiceTitle">Service Title</h2>
                    </div>
                </div>
                <button type="button" class="modal-service-close" onclick="closeServiceDetailsModal();" aria-label="Close modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-service-body custom-scrollbar">
                <!-- Info Chips (Fee & Time) -->
                <div class="modal-service-meta" id="modalServiceMeta">
                    <div class="meta-chip meta-fee" id="modalServiceFeeChip">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        <span id="modalServiceFee">Free</span>
                    </div>
                    <div class="meta-chip meta-time" id="modalServiceTimeChip">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span id="modalServiceTime">Same Day</span>
                    </div>
                </div>

                <!-- Ready-Made Document Available Banner -->
                <div id="modalDocumentBanner" class="ready-doc-banner" style="display: none;">
                    <div class="ready-doc-header">
                        <div class="ready-doc-icon-wrap">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#059669" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <div class="ready-doc-text">
                            <span class="ready-doc-badge">Official Template Ready</span>
                            <h4 class="ready-doc-heading">Ready-Made Document Available</h4>
                            <p class="ready-doc-desc">You can directly download or print this ready-to-fill form prior to visiting the Barangay Hall.</p>
                            <span class="ready-doc-file-tag" id="modalDocFileName">document.pdf</span>
                        </div>
                    </div>
                    <div class="ready-doc-actions">
                        <a id="modalDocDownloadLink" href="#" download class="btn-ready-action btn-ready-download">
                            <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            Download
                        </a>
                        <button type="button" id="modalDocPrintBtn" class="btn-ready-action btn-ready-print" onclick="printAttachedDocument();">
                            <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            Print
                        </button>
                    </div>
                </div>

                <!-- Description -->
                <div class="modal-service-section">
                    <h4 class="section-subheading">About this Service</h4>
                    <p class="section-paragraph" id="modalServiceDescription"></p>
                </div>

                <!-- Requirements -->
                <div class="modal-service-section" id="modalRequirementsSection">
                    <h4 class="section-subheading">Requirements to Bring</h4>
                    <div class="requirements-box">
                        <ul class="requirements-list" id="modalServiceRequirements"></ul>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-service-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeServiceDetailsModal();">Close</button>
                <a id="modalServiceRequestBtn" href="contact.php" class="btn-modal-primary">
                    <span id="modalServiceRequestBtnText">Request Document</span> &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- JavaScript -->
    <script src="assets/js/main.js?v=2"></script>
    <script>
        let currentServiceDocUrl = '';

        function openServiceDetailsModal(service) {
            if (!service) return;

            document.getElementById('modalServiceTitle').textContent = service.title || 'Barangay Service';
            document.getElementById('modalServiceDescription').textContent = service.description || '';
            
            // Icon
            const iconWrapper = document.getElementById('modalServiceIcon');
            iconWrapper.innerHTML = getIconSvgForPublic(service.icon);

            // Meta chips
            const feeChip = document.getElementById('modalServiceFeeChip');
            const feeText = document.getElementById('modalServiceFee');
            if (service.fee && service.fee.trim() !== '') {
                feeText.textContent = 'Fee: ' + service.fee;
                feeChip.style.display = 'inline-flex';
            } else {
                feeChip.style.display = 'none';
            }

            const timeChip = document.getElementById('modalServiceTimeChip');
            const timeText = document.getElementById('modalServiceTime');
            if (service.processing_time && service.processing_time.trim() !== '') {
                timeText.textContent = 'Processing: ' + service.processing_time;
                timeChip.style.display = 'inline-flex';
            } else {
                timeChip.style.display = 'none';
            }

            // Requirements
            const reqSection = document.getElementById('modalRequirementsSection');
            const reqList = document.getElementById('modalServiceRequirements');
            reqList.innerHTML = '';
            if (service.requirements && service.requirements.trim() !== '') {
                reqSection.style.display = 'block';
                const parts = service.requirements.split(/[,;\n]+/).map(s => s.trim()).filter(Boolean);
                if (parts.length > 0) {
                    parts.forEach(req => {
                        const li = document.createElement('li');
                        li.innerHTML = '<span class="req-check">✓</span> <span>' + escapeHtml(req) + '</span>';
                        reqList.appendChild(li);
                    });
                } else {
                    const li = document.createElement('li');
                    li.textContent = service.requirements;
                    reqList.appendChild(li);
                }
            } else {
                reqSection.style.display = 'none';
            }

            // Document Banner
            const docBanner = document.getElementById('modalDocumentBanner');
            const docFileName = document.getElementById('modalDocFileName');
            const docDownloadLink = document.getElementById('modalDocDownloadLink');

            if (service.document_file && service.document_file.trim() !== '') {
                currentServiceDocUrl = service.document_file.trim();
                docDownloadLink.href = currentServiceDocUrl;
                const fname = currentServiceDocUrl.split('/').pop();
                docFileName.textContent = fname;
                docBanner.style.display = 'block';
            } else {
                currentServiceDocUrl = '';
                docBanner.style.display = 'none';
            }

            // Request Link
            let btnLink = service.btn_link || 'contact.php';
            if (btnLink === 'contact.php') {
                btnLink += '?service=' + encodeURIComponent(service.title || '');
            }
            document.getElementById('modalServiceRequestBtn').href = btnLink;
            document.getElementById('modalServiceRequestBtnText').textContent = service.btn_text || 'Request Document';

            // Show modal
            document.getElementById('serviceDetailsModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeServiceDetailsModal() {
            document.getElementById('serviceDetailsModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        function printAttachedDocument() {
            if (!currentServiceDocUrl) return;
            const url = currentServiceDocUrl;
            const cleanUrl = url.split('?')[0];
            const ext = cleanUrl.split('.').pop().toLowerCase();

            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                // Open new window with image and auto-print
                const printWin = window.open('', '_blank');
                if (printWin) {
                    printWin.document.write(`
                        <!DOCTYPE html>
                        <html>
                        <head>
                            <meta charset="utf-8">
                            <title>Print Document - Barangay San Jose</title>
                            <style>
                                body { margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; background: #fff; font-family: sans-serif; }
                                img { max-width: 100%; height: auto; display: block; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                                @media print {
                                    body { padding: 0; }
                                    img { width: 100%; max-height: 100%; box-shadow: none; }
                                }
                            </style>
                        </head>
                        <body>
                            <img src="${url}" onload="setTimeout(function(){ window.focus(); window.print(); }, 300);" onerror="alert('Failed to load image for printing.');" />
                        </body>
                        </html>
                    `);
                    printWin.document.close();
                } else {
                    alert('Popup blocked! Please allow popups for this site to print the document.');
                }
            } else if (ext === 'pdf') {
                // For PDF: open in a new window/tab and trigger print
                const printWin = window.open(url, '_blank');
                if (printWin) {
                    printWin.focus();
                    try {
                        printWin.onload = function() {
                            setTimeout(() => {
                                try { printWin.print(); } catch(e) {}
                            }, 500);
                        };
                    } catch(e) {}
                } else {
                    alert('Popup blocked! Please allow popups for this site to print the document.');
                }
            } else {
                // For Word (.doc, .docx): download and notify
                const link = document.createElement('a');
                link.href = url;
                link.download = '';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                alert('This template has been downloaded. You can now open and print it from your device.');
            }
        }

        function getIconSvgForPublic(icon) {
            switch ((icon || '').toLowerCase()) {
                case 'home':
                case 'indigency':
                    return '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>';
                case 'briefcase':
                case 'business':
                    return '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>';
                case 'id-card':
                case 'residency':
                    return '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>';
                case 'heart-pulse':
                case 'health':
                case 'medical':
                    return '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';
                case 'shield':
                case 'peace':
                    return '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>';
                case 'users':
                case 'community':
                    return '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>';
                case 'award':
                    return '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>';
                default:
                    return '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>';
            }
        }

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeServiceDetailsModal();
            }
        });
    </script>

</body>

</html>
