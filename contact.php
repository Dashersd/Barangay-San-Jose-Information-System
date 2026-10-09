<?php
session_start();

// Reset chat session after 1 day (86400 seconds)
if (isset($_SESSION['chat_start_time']) && (time() - $_SESSION['chat_start_time'] > 86400)) {
    unset($_SESSION['chat_token']);
    unset($_SESSION['chat_start_time']);
}
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
    <link rel="stylesheet" href="assets/css/style.css?v=2">
    <link rel="stylesheet" href="assets/css/contact.css">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
                            <select required>
                                <option value="" disabled selected>Select service</option>
                                <option value="clearance">Barangay Clearance</option>
                                <option value="indigency">Certificate of Indigency</option>
                                <option value="business">Business Clearance</option>
                                <option value="residency">Certificate of Residency</option>
                                <option value="other">Other Inquiry</option>
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

        function fetchUserMessages() {
            $.get('api/chat_fetch.php', function(res) {
                if(res.status === 'success') {
                    let html = '';
                    res.messages.forEach(msg => {
                        const isUser = msg.sender === 'user';
                        const align = isUser ? 'flex-end' : 'flex-start';
                        const bg = isUser ? 'var(--primary)' : '#e2e8f0';
                        const color = isUser ? '#fff' : '#1e293b';
                        const nameDisplay = isUser ? '' : '<strong style="display:block; margin-bottom:5px; font-size:0.85em;">Admin</strong>';
                        
                        html += `
                            <div style="align-self:${align}; max-width:80%;">
                                <div style="background:${bg}; color:${color}; padding:12px 16px; border-radius:12px; font-size:14px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
                                    ${nameDisplay}
                                    <p style="margin:0; line-height:1.4;">${msg.message}</p>
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





