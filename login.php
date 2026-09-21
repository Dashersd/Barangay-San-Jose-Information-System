<?php
// Barangay San Jose Web-Based Information System - Login
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Barangay San Jose Information System</title>
    
    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Base CSS & Modular Login CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">
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
    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="auth-icon-badge">
                <img src="assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="auth-badge-logo">
            </div>
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to access your Barangay San Jose resident portal and services.</p>
        </div>

        <!-- Login Form -->
        <form id="loginForm" class="auth-form" method="POST" action="login.php" onsubmit="handleLogin(event)">
            <!-- Username / Email Field -->
            <div class="form-group">
                <label for="username" class="form-label">Email or Username</label>
                <div class="input-wrapper">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-control" 
                        placeholder="e.g., juan.delacruz@example.com" 
                        required 
                        autocomplete="username"
                    >
                </div>
            </div>

            <!-- Password Field -->
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
                        placeholder="Enter your password" 
                        required 
                        autocomplete="current-password"
                    >
                    <button type="button" class="toggle-password-btn" id="togglePasswordBtn" title="Toggle password visibility" aria-label="Toggle password visibility">
                        <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Options Row -->
            <div class="auth-options">
                <label class="remember-me">
                    <input type="checkbox" id="rememberMe" name="rememberMe">
                    <span>Remember me</span>
                </label>
                <a href="javascript:void(0)" class="forgot-password-link" onclick="alert('Password reset feature will be available soon. Please contact your barangay hall.')">
                    Forgot password?
                </a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit" id="submitBtn">
                Sign In
            </button>
        </form>

        <!-- Footer -->
        <div class="auth-footer">
            <span>Don't have an account yet?</span>
            <a href="register.php">Register</a>
        </div>
    </div>
</main>

<script>
    // Password visibility toggle
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    toggleBtn.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        
        if (isPassword) {
            eyeIcon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            `;
        } else {
            eyeIcon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
        }
    });

    // Form submission demonstration
    function handleLogin(event) {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const submitBtn = document.getElementById('submitBtn');
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Signing in...';
        
        setTimeout(() => {
            alert(`Welcome, ${username}! Login demo authenticated successfully.`);
            submitBtn.disabled = false;
            submitBtn.textContent = 'Sign In';
        }, 600);
    }
</script>

</body>
</html>
