<?php
// Barangay San Jose Web-Based Information System - Register
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Barangay San Jose Information System</title>
    
    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Base & Auth CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <!-- Brand & Logo -->
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
            <li><a href="about.php">About Us</a></li>
                            <li class="dropdown">
                    <a href="javascript:void(0)" class="nav-link">Officials</a>
                    <div class="dropdown-content">
                        <a href="officials.php">Barangay Officials</a>
                        <a href="skofficials.php">SK Officials</a>
                    </div>
                </li>
            <li><a href="announcement.php">Announcement</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="index.php#spot-map">Spot Map</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>

        <!-- Right Side: Login -->
        <div class="navbar-right">
            <a href="login.php" class="btn btn-primary" style="padding: 0.6rem 1.5rem; font-size: 0.95rem;">Login</a>
        </div>
    </div>
</nav>

<!-- Auth Content Wrapper -->
<main class="auth-wrapper">
    <div class="auth-card auth-card-register">
        <!-- Header -->
        <div class="auth-header">
            <div class="auth-icon-badge">
                <img src="assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="auth-badge-logo">
            </div>
            <h1 class="auth-title">Create an Account</h1>
            <p class="auth-subtitle">Register for the Barangay San Jose resident portal to access document requests and services.</p>
        </div>

        <!-- Registration Form -->
        <form id="registerForm" class="auth-form" method="POST" action="register.php" onsubmit="handleRegister(event)">
            
            <!-- First Name & Last Name (2-Col) -->
            <div class="auth-grid-2">
                <div class="form-group">
                    <label for="firstName" class="form-label">First Name</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <input 
                            type="text" 
                            id="firstName" 
                            name="firstName" 
                            class="form-control" 
                            placeholder="e.g., Juan" 
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="lastName" class="form-label">Last Name</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <input 
                            type="text" 
                            id="lastName" 
                            name="lastName" 
                            class="form-control" 
                            placeholder="e.g., Dela Cruz" 
                            required
                        >
                    </div>
                </div>
            </div>

            <!-- Email & Phone Number (2-Col) -->
            <div class="auth-grid-2">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </svg>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control" 
                            placeholder="e.g., juan@example.com" 
                            required 
                            autocomplete="email"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Contact Number</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            class="form-control" 
                            placeholder="09XX-XXX-XXXX" 
                            required
                        >
                    </div>
                </div>
            </div>

            <!-- Purok / Zone Field -->
            <div class="form-group">
                <label for="purok" class="form-label">Purok / Zone</label>
                <div class="input-wrapper">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <select id="purok" name="purok" class="form-control" required>
                        <option value="" disabled selected>Select your Purok in Barangay San Jose</option>
                        <option value="purok-1">Purok 1</option>
                        <option value="purok-2">Purok 2</option>
                        <option value="purok-3">Purok 3</option>
                        <option value="purok-4">Purok 4</option>
                        <option value="purok-5">Purok 5</option>
                        <option value="purok-6">Purok 6</option>
                        <option value="purok-7">Purok 7</option>
                    </select>
                </div>
            </div>

            <!-- Password & Confirm Password (2-Col) -->
            <div class="auth-grid-2">
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control" 
                            placeholder="Create password" 
                            required 
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-password-btn" id="togglePasswordBtn" title="Toggle password visibility" aria-label="Toggle password visibility">
                            <svg id="eyeIcon1" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                        </svg>
                        <input 
                            type="password" 
                            id="confirmPassword" 
                            name="confirmPassword" 
                            class="form-control" 
                            placeholder="Confirm password" 
                            required 
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-password-btn" id="toggleConfirmPasswordBtn" title="Toggle confirm password visibility" aria-label="Toggle confirm password visibility">
                            <svg id="eyeIcon2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Terms & Conditions -->
            <label class="terms-wrapper">
                <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
                <span>I agree to the <a href="javascript:void(0)" onclick="alert('Barangay San Jose terms and data privacy policy comply with the Data Privacy Act of 2012.')">Terms of Service</a> and <a href="javascript:void(0)" onclick="alert('Your personal information will be protected and used strictly for legitimate barangay public services.')">Privacy Policy</a>.</span>
            </label>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit" id="submitBtn">
                Create Account
            </button>
        </form>

        <!-- Footer -->
        <div class="auth-footer">
            <span>Already have an account?</span>
            <a href="login.php">Sign In</a>
        </div>
    </div>
</main>

<script>
    // Password visibility toggle for Password field
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('password');
    const eyeIcon1 = document.getElementById('eyeIcon1');

    togglePasswordBtn.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        
        if (isPassword) {
            eyeIcon1.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            `;
        } else {
            eyeIcon1.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
        }
    });

    // Password visibility toggle for Confirm Password field
    const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPasswordBtn');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const eyeIcon2 = document.getElementById('eyeIcon2');

    toggleConfirmPasswordBtn.addEventListener('click', () => {
        const isPassword = confirmPasswordInput.type === 'password';
        confirmPasswordInput.type = isPassword ? 'text' : 'password';
        
        if (isPassword) {
            eyeIcon2.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            `;
        } else {
            eyeIcon2.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
        }
    });

    // Form submission handling & validation
    function handleRegister(event) {
        event.preventDefault();
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        const firstName = document.getElementById('firstName').value;
        const submitBtn = document.getElementById('submitBtn');

        if (password !== confirmPassword) {
            alert('Passwords do not match. Please verify your password.');
            confirmPasswordInput.focus();
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Creating Account...';

        setTimeout(() => {
            alert(`Account created successfully for ${firstName}! You can now sign in.`);
            window.location.href = 'login.php';
        }, 700);
    }
</script>

</body>
</html>
