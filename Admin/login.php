<?php
// Barangay San Jose Web-Based Information System - Admin Login
session_start();
require_once __DIR__ . '/../db_connect.php';

// If already logged in, redirect straight to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$errorMsg = '';
$prefilledUsername = $_COOKIE['remember_admin_email'] ?? '';

// Process Login Form Submission
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['rememberMe']);

    if (empty($username) || empty($password)) {
        $errorMsg = "Please enter both email/username and password.";
    } else {
        // Query users table for matching email or name
        $stmt = $conn->prepare("SELECT id, full_name, email, password, role FROM users WHERE email = ? OR full_name = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param("ss", $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($user = $result->fetch_assoc()) {
                // Verify password (supports bcrypt hash and seamless legacy plain-text fallback)
                $isValidPassword = false;
                if (password_verify($password, $user['password'])) {
                    $isValidPassword = true;
                } elseif ($password === $user['password']) {
                    // Auto-hash legacy plain text password
                    $isValidPassword = true;
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $upd = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    if ($upd) {
                        $upd->bind_param("si", $newHash, $user['id']);
                        $upd->execute();
                        $upd->close();
                    }
                }

                if ($isValidPassword) {
                    // Session security & fixation protection
                    session_regenerate_id(true);

                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = (int)$user['id'];
                    $_SESSION['admin_name'] = $user['full_name'];
                    $_SESSION['admin_email'] = $user['email'];
                    $_SESSION['admin_role'] = $user['role'];

                    // Remember Me Cookie (30 days)
                    if ($rememberMe) {
                        setcookie('remember_admin_email', $user['email'], time() + (86400 * 30), "/");
                    } else {
                        setcookie('remember_admin_email', '', time() - 3600, "/");
                    }

                    // Record login event in activity_logs
                    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
                    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
                    }
                    $ip = substr(trim($ip), 0, 45);

                    $logStmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, details, ip_address, created_at) VALUES (?, 'LOGIN', ?, ?, NOW())");
                    if ($logStmt) {
                        $details = "Administrator logged in: " . $user['email'];
                        $logStmt->bind_param("iss", $user['id'], $details, $ip);
                        $logStmt->execute();
                        $logStmt->close();
                    }

                    $stmt->close();
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $errorMsg = "Invalid credentials. The password you entered is incorrect.";
                }
            } else {
                $errorMsg = "No administrator account found with that email or username.";
            }
            $stmt->close();
        } else {
            $errorMsg = "Database error. Please try again later.";
        }
    }
    $prefilledUsername = $username;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Barangay San Jose Information System</title>
    
    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="../assets/images/San Jose Logo 2.png">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Base CSS & Modular Login CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/login.css">

    <style>
        .login-alert {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 1.25rem;
            animation: fadeIn 0.3s ease;
        }
        .login-alert-danger {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        .login-alert-success {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        .login-alert svg {
            flex-shrink: 0;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <!-- Brand & Logo -->
        <div class="navbar-brand">
            <img src="../assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="navbar-logo">
            <img src="../assets/images/Lapuyan Logo.png" alt="Municipality of Lapuyan Logo" class="navbar-logo">
            <div class="brand-text">
                <span class="brand-title">BARANGAY SAN JOSE</span>
                <span class="brand-subtitle">Bayanihan &bull; Serbisyong Totoo</span>
            </div>
        </div>

        <!-- Desktop Links -->
        <ul class="navbar-links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../about.php">About Us</a></li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="nav-link">Officials</a>
                <div class="dropdown-content">
                    <a href="../officials.php">Barangay Officials</a>
                    <a href="../skofficials.php">SK Officials</a>
                </div>
            </li>
            <li><a href="../announcement.php">Announcement</a></li>
            <li><a href="../gallery.php">Gallery</a></li>
            <li><a href="../index.php#spot-map">Spot Map</a></li>
            <li><a href="../contact.php">Contact</a></li>
        </ul>
        <!-- Right Side: Admin Login -->
        <div class="navbar-right">
            <a href="login.php" class="admin-login-link">Admin Login</a>
        </div>
    </div>
</nav>

<!-- Auth Content Wrapper -->
<main class="auth-wrapper">
    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="auth-icon-badge">
                <img src="../assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="auth-badge-logo">
            </div>
            <h1 class="auth-title">Admin Portal</h1>
            <p class="auth-subtitle">Sign in with your administrator account to access system control.</p>
        </div>

        <!-- Alerts -->
        <?php if (!empty($errorMsg)): ?>
            <div class="login-alert login-alert-danger">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <span><?= htmlspecialchars($errorMsg) ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['logged_out'])): ?>
            <div class="login-alert login-alert-success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>You have been logged out successfully.</span>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form id="loginForm" class="auth-form" method="POST" action="login.php">
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
                        placeholder="e.g., admin@gmail.com" 
                        value="<?= htmlspecialchars($prefilledUsername) ?>"
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
                    <input type="checkbox" id="rememberMe" name="rememberMe" <?= !empty($_COOKIE['remember_admin_email']) ? 'checked' : '' ?>>
                    <span>Remember me</span>
                </label>
                <a href="javascript:void(0)" class="forgot-password-link" onclick="alert('Password reset feature: Please contact your barangay IT administrator or use the Admin Settings Center to update security credentials.')">
                    Forgot password?
                </a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit" id="submitBtn">
                Sign In
            </button>
        </form>
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

    // Form submission feedback
    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', function() {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Authenticating...';
    });
</script>

</body>
</html>
