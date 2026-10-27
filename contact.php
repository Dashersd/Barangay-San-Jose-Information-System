<?php
session_start();

// Reset chat session after 1 day (86400 seconds)
if (isset($_SESSION['chat_start_time']) && (time() - $_SESSION['chat_start_time'] > 86400)) {
    unset($_SESSION['chat_token']);
    unset($_SESSION['chat_start_time']);
}

require_once __DIR__ . '/services_db.php';
$activeServices = get_all_services($conn, true);
$selectedService = isset($_GET['service']) ? trim($_GET['service']) : '';
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
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/contact.css">
    
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
                    <a href="about.php" class="nav-link">About Us</a>
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
                <li><a href="contact.php" class="active">Contact</a></li>
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
                <p class="hero-subtitle" data-aos="fade-up">CONTACT US</p>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">BARANGAY SAN JOSE</h1>
                <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">We are here to serve. Reach out to our barangay office for public inquiries,<br>government assistance, document services, and 24/7 community safety hotlines.</p>
            </div>
        </div>
    </section>

    <!-- 2. Main Content Section -->
    <main class="contact-home-section">
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
                    <h2 class="contact-heading">Start a Live Chat</h2>
                    <?php $has_chat = isset($_SESSION['chat_token']) && !empty($_SESSION['chat_token']); ?>
                    <form class="contact-form" id="live-chat-form" action="#" method="POST" style="<?php echo $has_chat ? 'display:none;' : ''; ?>">
                        <div class="form-group">
                            <label>Your Name</label>
                            <input type="text" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label>Service Type</label>
                            <select name="service" required>
                                <option value="" disabled <?= empty($selectedService) ? 'selected' : '' ?>>Select service</option>
                                <?php if (!empty($activeServices)): ?>
                                    <?php foreach ($activeServices as $srvItem): ?>
                                        <?php 
                                        $isSel = (strcasecmp($selectedService, $srvItem['title']) === 0 || strcasecmp($selectedService, (string)$srvItem['id']) === 0);
                                        ?>
                                        <option value="<?= htmlspecialchars($srvItem['title']) ?>" <?= $isSel ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($srvItem['title']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="Barangay Clearance">Barangay Clearance</option>
                                    <option value="Certificate of Indigency">Certificate of Indigency</option>
                                    <option value="Business Clearance">Business Clearance</option>
                                    <option value="Certificate of Residency">Certificate of Residency</option>
                                <?php endif; ?>
                                <option value="Other Inquiry" <?= (strcasecmp($selectedService, 'Other Inquiry') === 0) ? 'selected' : '' ?>>Other Inquiry</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Initial Message</label>
                            <textarea rows="4" placeholder="How can we help you?" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary contact-submit">START CHAT</button>
                    </form>

                    <!-- Chat UI (Hidden Initially) -->
                    <div id="live-chat-ui" style="<?php echo $has_chat ? '' : 'display:none;'; ?> border:1px solid #e2e8f0; border-radius:12px; background:#f8fafc; overflow:hidden;">
                        <div id="user-chat-messages" style="height: 300px; overflow-y:auto; padding:20px; display:flex; flex-direction:column; gap:10px;">
                            <!-- Messages -->
                        </div>
                        <div style="display:flex; border-top:1px solid #e2e8f0; padding:15px; background:#fff;">
                            <input type="text" id="user-chat-input" placeholder="Type a message..." style="flex:1; border:1px solid #cbd5e1; border-radius:8px; padding:10px 15px; margin-right:10px; outline:none; font-family:inherit;">
                            <button id="user-chat-send" class="btn btn-primary" style="padding:10px 20px; border-radius:8px;">SEND</button>
                        </div>
                    </div>
                </div>
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

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js?v=2"></script>
    <script>
    $(document).ready(function() {
        let chatPolling;
        
        // If chat is already active on load
        if ($('#live-chat-ui').is(':visible')) {
            $('.contact-heading').text("Live Chat Support");
            fetchUserMessages();
            chatPolling = setInterval(fetchUserMessages, 3000);
        }

        $('#live-chat-form').on('submit', function(e) {
            e.preventDefault();
            
            const name = $(this).find('input[type="text"]').eq(0).val();
            const service = $(this).find('select').val();
            const message = $(this).find('textarea').val();

            $.post('api/chat_init.php', {name: name, service: service, message: message}, function(res) {
                if(res.status === 'success') {
                    $('#live-chat-form').hide();
                    $('.contact-heading').text("Live Chat Support");
                    $('#live-chat-ui').fadeIn();
                    
                    fetchUserMessages();
                    chatPolling = setInterval(fetchUserMessages, 3000);
                }
            });
        });

        function getPublicChatFileMeta(ext) {
            ext = (ext || '').toLowerCase();
            if (ext === 'pdf') {
                return {
                    badge: 'PDF Document',
                    bg: '#fee2e2',
                    icon: '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#ef4444" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>'
                };
            }
            if (ext === 'doc' || ext === 'docx') {
                return {
                    badge: 'Word Document',
                    bg: '#dbeafe',
                    icon: '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#2563eb" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>'
                };
            }
            if (ext === 'jpg' || ext === 'jpeg' || ext === 'png') {
                return {
                    badge: 'Image Document',
                    bg: '#dcfce7',
                    icon: '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#059669" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>'
                };
            }
            return {
                badge: 'Official Document',
                bg: '#f1f5f9',
                icon: '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#64748b" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>'
            };
        }

        function renderPublicChatDocCard(filePath, fileName) {
            if (!filePath) return '';
            const ext = filePath.split('.').pop().toLowerCase();
            const meta = getPublicChatFileMeta(ext);
            const rawName = fileName || filePath.split('/').pop();
            const safeName = $('<div>').text(rawName).html();
            const cleanUrl = filePath.replace(/^\/+/, '');

            return `
                <div class="chat-doc-card">
                    <div class="chat-doc-main">
                        <div class="chat-doc-icon" style="background:${meta.bg};">
                            ${meta.icon}
                        </div>
                        <div class="chat-doc-info">
                            <span class="chat-doc-title" title="${safeName}">${safeName}</span>
                            <span class="chat-doc-badge">${meta.badge}</span>
                        </div>
                    </div>
                    <div class="chat-doc-actions">
                        <a href="${cleanUrl}" download="${safeName}" class="btn-chat-doc-dl" target="_blank">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            Download
                        </a>
                        <button type="button" class="btn-chat-doc-print" onclick="printCitizenChatDoc('${cleanUrl}', '${ext}')">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            Print
                        </button>
                    </div>
                </div>
            `;
        }

        window.printCitizenChatDoc = function(fileUrl, ext) {
            ext = (ext || '').toLowerCase();
            if (ext === 'pdf') {
                const printWindow = window.open(fileUrl, '_blank');
                if (printWindow) {
                    printWindow.onload = function() {
                        try { printWindow.print(); } catch(e) {}
                    };
                }
            } else if (['jpg', 'jpeg', 'png', 'webp'].includes(ext)) {
                const printWindow = window.open('', '_blank');
                if (printWindow) {
                    printWindow.document.write(`
                        <html>
                            <head><title>Print Document</title><style>body{margin:0;display:flex;align-items:center;justify-content:center;background:#fff;} img{max-width:98vw;max-height:98vh;object-fit:contain;}</style></head>
                            <body onload="window.print();">
                                <img src="${fileUrl}" alt="Print Preview" />
                            </body>
                        </html>
                    `);
                    printWindow.document.close();
                }
            } else {
                alert('For Word/Office documents (.doc, .docx), please download the file to open and print.');
                const tempLink = document.createElement('a');
                tempLink.href = fileUrl;
                tempLink.download = '';
                document.body.appendChild(tempLink);
                tempLink.click();
                document.body.removeChild(tempLink);
            }
        };

        function fetchUserMessages() {
            $.get('api/chat_fetch.php', function(res) {
                if(res.status === 'success') {
                    let html = '';
                    res.messages.forEach(msg => {
                        const isUser = msg.sender === 'user';
                        const align = isUser ? 'flex-end' : 'flex-start';
                        const bg = isUser ? 'var(--primary)' : '#f8fafc';
                        const color = isUser ? '#fff' : '#1e293b';
                        const borderStyle = isUser ? 'none' : '1px solid #e2e8f0';
                        const nameDisplay = isUser ? '' : '<strong style="display:block; margin-bottom:5px; font-size:0.85em; color:#0f172a;">Barangay San Jose Official</strong>';
                        const safeMsg = msg.message ? $('<div>').text(msg.message).html().replace(/\n/g, '<br>') : '';
                        const docCard = msg.attachment_file ? renderPublicChatDocCard(msg.attachment_file, msg.attachment_name) : '';
                        
                        html += `
                            <div style="align-self:${align}; max-width:85%;">
                                <div style="background:${bg}; color:${color}; border:${borderStyle}; padding:12px 16px; border-radius:12px; font-size:14px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
                                    ${nameDisplay}
                                    ${safeMsg ? `<p style="margin:0; line-height:1.4;">${safeMsg}</p>` : ''}
                                    ${docCard}
                                    <span style="display:block; text-align:right; font-size:0.75em; margin-top:8px; opacity:0.8;">${msg.time}</span>
                                </div>
                            </div>
                        `;
                    });
                    $('#user-chat-messages').html(html);
                    $('#user-chat-messages').scrollTop($('#user-chat-messages')[0].scrollHeight);
                }
            });
        }

        $('#user-chat-send').on('click', function() {
            const msg = $('#user-chat-input').val();
            if(msg.trim() === '') return;
            
            $.post('api/chat_send.php', {message: msg}, function(res) {
                if(res.status === 'success') {
                    $('#user-chat-input').val('');
                    fetchUserMessages();
                }
            });
        });
        
        $('#user-chat-input').keypress(function(e) {
            if(e.which == 13) {
                $('#user-chat-send').click();
            }
        });
    });
    </script>
</body>

</html>





