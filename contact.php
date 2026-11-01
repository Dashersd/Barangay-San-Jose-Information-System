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
    <link rel="stylesheet" href="assets/css/contact.css?v=<?= time() ?>">
    
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

                <!-- Right Side: Verified Gmail Resident Inquiry Form -->
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
                                    <option value="" disabled <?= empty($selectedService) ? 'selected' : '' ?>>Select service or subject</option>
                                    <?php
                                    $defaultServices = [
                                        'Barangay Clearance',
                                        'Certificate of Indigency',
                                        'Business Clearance',
                                        'Certificate of Residency',
                                        'General Inquiry / Feedback'
                                    ];
                                    $serviceOptions = [];
                                    if (!empty($activeServices)) {
                                        foreach ($activeServices as $srvItem) {
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
                                        $isSel = (strcasecmp($selectedService, $srvTitle) === 0);
                                    ?>
                                        <option value="<?= htmlspecialchars($srvTitle) ?>" <?= $isSel ? 'selected' : '' ?>>
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

        // 6-Digit Box Auto-Advance, Backspace, Paste, and Enter Key Handling
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

        // Step 1: Form Submit -> Send OTP
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

        // Step 2: Resend OTP
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

        // Step 3: Verify OTP & Save Inquiry
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
</body>

</html>





