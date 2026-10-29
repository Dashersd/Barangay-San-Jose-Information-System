<?php
// settings.php - Comprehensive Admin Settings & System Control Center
// Barangay San Jose Web-Based Information System

session_start();
require_once __DIR__ . '/../db_connect.php';

// =========================================================================
// 1. AUTO-MIGRATION & SELF-HEALING SETUP
// =========================================================================

// Ensure activity_logs table exists
$conn->query("CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `action` VARCHAR(100) NOT NULL,
  `details` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

// Ensure users table exists
$conn->query("CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) DEFAULT 'admin',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

// Ensure barangay_information table exists
$conn->query("CREATE TABLE IF NOT EXISTS `barangay_information` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `barangay_name` VARCHAR(150) NOT NULL DEFAULT 'San Jose',
  `municipality` VARCHAR(150) NOT NULL DEFAULT 'Lapuyan',
  `province` VARCHAR(150) NOT NULL DEFAULT 'Zamboanga del Sur',
  `slogan` VARCHAR(255) DEFAULT 'Bayanihan • Serbisyong Totoo',
  `office_schedule` VARCHAR(255) DEFAULT 'Monday - Friday, 8:00 AM - 5:00 PM',
  `address` TEXT DEFAULT NULL,
  `mission` TEXT DEFAULT NULL,
  `vision` TEXT DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `logo_path` VARCHAR(255) DEFAULT 'assets/images/San Jose Logo 2.png',
  `official_email` VARCHAR(150) DEFAULT 'barangaysanjose.lapuyan@gmail.com',
  `main_contact` VARCHAR(50) DEFAULT '+63 912 345 6789',
  `police_hotline` VARCHAR(50) DEFAULT '166 / +63 998 598 7200',
  `fire_hotline` VARCHAR(50) DEFAULT '160 / +63 939 123 4567',
  `health_hotline` VARCHAR(50) DEFAULT '+63 920 987 6543',
  `tanod_hotline` VARCHAR(50) DEFAULT '+63 945 112 3344',
  `facebook_url` VARCHAR(255) DEFAULT 'https://facebook.com/BarangaySanJoseOfficial',
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

// Helper function to safely check and add missing columns
function ensureColumnExists($conn, $table, $column, $definition) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    $columnClean = preg_replace('/[^a-zA-Z0-9_]/', '', $column);
    $checkSql = "SHOW COLUMNS FROM `$table` LIKE '$columnClean'";
    $res = $conn->query($checkSql);
    if ($res && $res->num_rows === 0) {
        $conn->query("ALTER TABLE `$table` ADD COLUMN `$columnClean` $definition");
    }
}

// Columns to check for barangay_information
$columnsToCheck = [
    'barangay_name'   => "VARCHAR(150) NOT NULL DEFAULT 'San Jose'",
    'municipality'    => "VARCHAR(150) NOT NULL DEFAULT 'Lapuyan'",
    'province'        => "VARCHAR(150) NOT NULL DEFAULT 'Zamboanga del Sur'",
    'slogan'          => "VARCHAR(255) DEFAULT 'Bayanihan • Serbisyong Totoo'",
    'office_schedule' => "VARCHAR(255) DEFAULT 'Monday - Friday, 8:00 AM - 5:00 PM'",
    'address'         => "TEXT DEFAULT NULL",
    'mission'         => "TEXT DEFAULT NULL",
    'vision'          => "TEXT DEFAULT NULL",
    'description'     => "TEXT DEFAULT NULL",
    'logo_path'       => "VARCHAR(255) DEFAULT 'assets/images/San Jose Logo 2.png'",
    'official_email'  => "VARCHAR(150) DEFAULT 'barangaysanjose.lapuyan@gmail.com'",
    'main_contact'    => "VARCHAR(50) DEFAULT '+63 912 345 6789'",
    'police_hotline'  => "VARCHAR(50) DEFAULT '166 / +63 998 598 7200'",
    'fire_hotline'    => "VARCHAR(50) DEFAULT '160 / +63 939 123 4567'",
    'health_hotline'  => "VARCHAR(50) DEFAULT '+63 920 987 6543'",
    'tanod_hotline'   => "VARCHAR(50) DEFAULT '+63 945 112 3344'",
    'facebook_url'    => "VARCHAR(255) DEFAULT 'https://facebook.com/BarangaySanJoseOfficial'",
    'updated_at'      => "DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"
];

foreach ($columnsToCheck as $col => $def) {
    ensureColumnExists($conn, 'barangay_information', $col, $def);
}

// Auto-create hero_backgrounds table
$conn->query("CREATE TABLE IF NOT EXISTS `hero_backgrounds` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `image_path` VARCHAR(255) NOT NULL,
  `sort_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

// Ensure hero_slideshow_speed column exists in barangay_information
ensureColumnExists($conn, 'barangay_information', 'hero_slideshow_speed', "INT DEFAULT 5");

// Auto-seed barangay_information if 0 rows exist
$infoCountRes = $conn->query("SELECT COUNT(*) FROM `barangay_information`");
if ($infoCountRes && (int)$infoCountRes->fetch_row()[0] === 0) {
    $conn->query("INSERT INTO `barangay_information` (
        `id`, `barangay_name`, `municipality`, `province`, `slogan`, `office_schedule`,
        `address`, `mission`, `vision`, `description`, `logo_path`, `official_email`,
        `main_contact`, `police_hotline`, `fire_hotline`, `health_hotline`, `tanod_hotline`, `facebook_url`
    ) VALUES (
        1,
        'San Jose',
        'Lapuyan',
        'Zamboanga del Sur',
        'Bayanihan • Serbisyong Totoo',
        'Monday - Friday, 8:00 AM - 5:00 PM',
        'Barangay Hall, San Jose, Lapuyan, Zamboanga del Sur, 7037',
        'To deliver proactive, transparent, and compassionate public service while promoting community resilience, peace, and sustainable development.',
        'A peaceful, progressive, self-reliant, and united Barangay San Jose driven by empowered, healthy, and God-fearing citizens.',
        'Official administrative and public service portal of Barangay San Jose.',
        'assets/images/San Jose Logo 2.png',
        'barangaysanjose.lapuyan@gmail.com',
        '+63 912 345 6789',
        '166 / +63 998 598 7200',
        '160 / +63 939 123 4567',
        '+63 920 987 6543',
        '+63 945 112 3344',
        'https://facebook.com/BarangaySanJoseOfficial'
    )");
}

// Auto-seed default admin user if 0 users exist
$userCountRes = $conn->query("SELECT COUNT(*) FROM `users`");
if ($userCountRes && (int)$userCountRes->fetch_row()[0] === 0) {
    $defaultPass = password_hash('admin123', PASSWORD_DEFAULT);
    $seedUser = $conn->prepare("INSERT INTO `users` (`full_name`, `email`, `password`, `role`) VALUES (?, ?, ?, 'admin')");
    $seedName = "System Administrator";
    $seedEmail = "admin@sanjose.gov.ph";
    $seedUser->bind_param("sss", $seedName, $seedEmail, $defaultPass);
    $seedUser->execute();
    $seedUser->close();
}

// Helper function to record audit logs
function logActivity($conn, $action, $details, $userId = null) {
    if ($userId === null && isset($_SESSION['admin_id'])) {
        $userId = (int)$_SESSION['admin_id'];
    }
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    $ip = substr(trim($ip), 0, 45);

    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, details, ip_address, created_at) VALUES (?, ?, ?, ?, NOW())");
    if ($stmt) {
        $stmt->bind_param("isss", $userId, $action, $details, $ip);
        $stmt->execute();
        $stmt->close();
    }
}

// =========================================================================
// 2. ACTIVE ADMIN SESSION RESOLUTION
// =========================================================================
$adminUser = null;
if (isset($_SESSION['admin_id'])) {
    $uStmt = $conn->prepare("SELECT id, full_name, email, role, created_at FROM users WHERE id = ?");
    $uStmt->bind_param("i", $_SESSION['admin_id']);
    $uStmt->execute();
    $adminUser = $uStmt->get_result()->fetch_assoc();
    $uStmt->close();
}

if (!$adminUser) {
    // Fallback to first available admin
    $uRes = $conn->query("SELECT id, full_name, email, role, created_at FROM users WHERE role = 'admin' ORDER BY id ASC LIMIT 1");
    if ($uRes && $adminUser = $uRes->fetch_assoc()) {
        $_SESSION['admin_id'] = $adminUser['id'];
        $_SESSION['admin_name'] = $adminUser['full_name'];
        $_SESSION['admin_email'] = $adminUser['email'];
        $_SESSION['admin_role'] = $adminUser['role'];
    }
}

// =========================================================================
// 3. FORM ACTION HANDLERS (POST)
// =========================================================================

// Action 1: Save General Barangay Profile
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_general') {
    $barangay_name = trim($_POST['barangay_name'] ?? 'San Jose');
    $municipality = trim($_POST['municipality'] ?? 'Lapuyan');
    $province = trim($_POST['province'] ?? 'Zamboanga del Sur');
    $slogan = trim($_POST['slogan'] ?? '');
    $office_schedule = trim($_POST['office_schedule'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $mission = trim($_POST['mission'] ?? '');
    $vision = trim($_POST['vision'] ?? '');
    $description = trim($_POST['description'] ?? '');

    $newLogoPath = null;
    $uploadError = null;

    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['logo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExts = ['png', 'jpg', 'jpeg', 'webp', 'svg'];
        $allowedMimes = ['image/png', 'image/jpeg', 'image/pjpeg', 'image/webp', 'image/svg+xml'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (in_array($ext, $allowedExts) && (in_array($mime, $allowedMimes) || ($ext === 'svg' && strpos($mime, 'svg') !== false))) {
            if ($file['size'] <= 5 * 1024 * 1024) { // 5MB limit
                $uploadDir = dirname(__DIR__) . '/uploads/branding/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $safeName = 'barangay_logo_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $targetFile = $uploadDir . $safeName;
                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    $newLogoPath = 'uploads/branding/' . $safeName;
                } else {
                    $uploadError = 'Failed to move uploaded logo to the destination folder.';
                }
            } else {
                $uploadError = 'Logo file size exceeds the 5MB maximum limit.';
            }
        } else {
            $uploadError = 'Invalid image format. Supported formats: PNG, JPG, JPEG, WEBP, SVG.';
        }
    }

    if ($uploadError) {
        header("Location: settings.php?tab=profile&err=" . urlencode($uploadError));
        exit;
    }

    if ($newLogoPath) {
        $stmt = $conn->prepare("UPDATE barangay_information SET barangay_name=?, municipality=?, province=?, slogan=?, office_schedule=?, address=?, mission=?, vision=?, description=?, logo_path=? WHERE id = 1");
        $stmt->bind_param("ssssssssss", $barangay_name, $municipality, $province, $slogan, $office_schedule, $address, $mission, $vision, $description, $newLogoPath);
    } else {
        $stmt = $conn->prepare("UPDATE barangay_information SET barangay_name=?, municipality=?, province=?, slogan=?, office_schedule=?, address=?, mission=?, vision=?, description=? WHERE id = 1");
        $stmt->bind_param("sssssssss", $barangay_name, $municipality, $province, $slogan, $office_schedule, $address, $mission, $vision, $description);
    }

    if ($stmt->execute()) {
        $stmt->close();
        logActivity($conn, 'UPDATE_PROFILE', 'Updated Barangay profile and branding information');
        header("Location: settings.php?tab=profile&msg=general_saved");
        exit;
    } else {
        $err = $conn->error;
        $stmt->close();
        header("Location: settings.php?tab=profile&err=" . urlencode("Database error: " . $err));
        exit;
    }
}

// Action 2: Save Hotlines & Contacts
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_contacts') {
    $official_email = trim($_POST['official_email'] ?? '');
    $main_contact = trim($_POST['main_contact'] ?? '');
    $police_hotline = trim($_POST['police_hotline'] ?? '');
    $fire_hotline = trim($_POST['fire_hotline'] ?? '');
    $health_hotline = trim($_POST['health_hotline'] ?? '');
    $tanod_hotline = trim($_POST['tanod_hotline'] ?? '');
    $facebook_url = trim($_POST['facebook_url'] ?? '');

    $stmt = $conn->prepare("UPDATE barangay_information SET official_email=?, main_contact=?, police_hotline=?, fire_hotline=?, health_hotline=?, tanod_hotline=?, facebook_url=? WHERE id = 1");
    $stmt->bind_param("sssssss", $official_email, $main_contact, $police_hotline, $fire_hotline, $health_hotline, $tanod_hotline, $facebook_url);

    if ($stmt->execute()) {
        $stmt->close();
        logActivity($conn, 'UPDATE_CONTACTS', 'Updated emergency hotlines and official contacts');
        header("Location: settings.php?tab=contacts&msg=contacts_saved");
        exit;
    } else {
        $err = $conn->error;
        $stmt->close();
        header("Location: settings.php?tab=contacts&err=" . urlencode("Database error: " . $err));
        exit;
    }
}

// Action 3: Update Administrator Security & Credentials
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_admin_security') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $userId = $adminUser['id'] ?? 1;

    if (empty($full_name) || empty($email)) {
        header("Location: settings.php?tab=security&err=" . urlencode("Full name and email address are required fields."));
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: settings.php?tab=security&err=" . urlencode("Please provide a valid email address."));
        exit;
    }

    // Check email uniqueness against other users
    $chkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $chkStmt->bind_param("si", $email, $userId);
    $chkStmt->execute();
    if ($chkStmt->get_result()->num_rows > 0) {
        $chkStmt->close();
        header("Location: settings.php?tab=security&err=" . urlencode("The email address '$email' is already registered to another user account."));
        exit;
    }
    $chkStmt->close();

    if (!empty($new_password)) {
        if (strlen($new_password) < 6) {
            header("Location: settings.php?tab=security&err=" . urlencode("Password must be at least 6 characters in length."));
            exit;
        }
        if ($new_password !== $confirm_password) {
            header("Location: settings.php?tab=security&err=" . urlencode("The new password and confirmation password do not match."));
            exit;
        }

        $passwordHash = password_hash($new_password, PASSWORD_DEFAULT);
        $updStmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, password = ? WHERE id = ?");
        $updStmt->bind_param("sssi", $full_name, $email, $passwordHash, $userId);
        if ($updStmt->execute()) {
            $updStmt->close();
            $_SESSION['admin_name'] = $full_name;
            $_SESSION['admin_email'] = $email;
            logActivity($conn, 'UPDATE_SECURITY', "Updated administrator credentials and password for account $email", $userId);
            header("Location: settings.php?tab=security&msg=security_saved_with_password");
            exit;
        } else {
            $err = $conn->error;
            $updStmt->close();
            header("Location: settings.php?tab=security&err=" . urlencode("Failed to update credentials: " . $err));
            exit;
        }
    } else {
        $updStmt = $conn->prepare("UPDATE users SET full_name = ?, email = ? WHERE id = ?");
        $updStmt->bind_param("ssi", $full_name, $email, $userId);
        if ($updStmt->execute()) {
            $updStmt->close();
            $_SESSION['admin_name'] = $full_name;
            $_SESSION['admin_email'] = $email;
            logActivity($conn, 'UPDATE_SECURITY', "Updated administrator profile details for account $email", $userId);
            header("Location: settings.php?tab=security&msg=security_saved");
            exit;
        } else {
            $err = $conn->error;
            $updStmt->close();
            header("Location: settings.php?tab=security&err=" . urlencode("Failed to update credentials: " . $err));
            exit;
        }
    }
}

// Action 4: Clear Activity Logs
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'clear_logs') {
    $conn->query("TRUNCATE TABLE activity_logs");
    logActivity($conn, 'CLEAR_LOGS', 'Activity logs were cleared by administrator');
    header("Location: settings.php?tab=logs&msg=logs_cleared");
    exit;
}

// Action 5: Upload Hero Background Images & Save Slideshow Speed
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_hero_bg') {
    $speed = isset($_POST['hero_slideshow_speed']) ? intval($_POST['hero_slideshow_speed']) : 5;
    if (!in_array($speed, [3, 5])) $speed = 5;

    $conn->query("UPDATE barangay_information SET hero_slideshow_speed = $speed WHERE id = 1");

    $upload_dir = '../uploads/hero/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $uploaded_count = 0;
    if (isset($_FILES['hero_images']) && !empty($_FILES['hero_images']['name'][0])) {
        $total_files = count($_FILES['hero_images']['name']);
        for ($i = 0; $i < $total_files; $i++) {
            if ($_FILES['hero_images']['error'][$i] === UPLOAD_ERR_OK) {
                $orig_name = $_FILES['hero_images']['name'][$i];
                $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
                if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp'])) {
                    $filename = 'hero_' . time() . '_' . uniqid() . '.' . $ext;
                    $target = $upload_dir . $filename;
                    if (move_uploaded_file($_FILES['hero_images']['tmp_name'][$i], $target)) {
                        $db_path = 'uploads/hero/' . $filename;
                        $stmt = $conn->prepare("INSERT INTO hero_backgrounds (image_path) VALUES (?)");
                        $stmt->bind_param("s", $db_path);
                        $stmt->execute();
                        $stmt->close();
                        $uploaded_count++;
                    }
                }
            }
        }
    }

    if ($uploaded_count > 0) {
        logActivity($conn, 'Hero Slides Uploaded', "$uploaded_count background image(s) uploaded for hero section ($speed-second interval).");
        header("Location: settings.php?msg=hero_uploaded&count=$uploaded_count&tab=hero_bg");
        exit;
    } else {
        logActivity($conn, 'Hero Slideshow Settings Updated', "Slideshow interval set to $speed seconds.");
        header("Location: settings.php?msg=hero_speed_saved&tab=hero_bg");
        exit;
    }
}

// Action 6: Delete Hero Background Image
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_hero_bg') {
    $hero_id = intval($_POST['hero_id'] ?? 0);
    if ($hero_id > 0) {
        $stmt = $conn->prepare("SELECT image_path FROM hero_backgrounds WHERE id = ?");
        $stmt->bind_param("i", $hero_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $row = $res->fetch_assoc()) {
            $file = '../' . $row['image_path'];
            if (file_exists($file)) {
                @unlink($file);
            }
            $del_stmt = $conn->prepare("DELETE FROM hero_backgrounds WHERE id = ?");
            $del_stmt->bind_param("i", $hero_id);
            $del_stmt->execute();
            $del_stmt->close();
            logActivity($conn, 'Hero Slide Deleted', "Deleted hero background ID $hero_id");
        }
        $stmt->close();
    }
    header("Location: settings.php?msg=hero_deleted&tab=hero_bg");
    exit;
}

// =========================================================================
// 4. DATA RETRIEVAL FOR RENDERING
// =========================================================================

// Fetch barangay information
$infoQuery = $conn->query("SELECT * FROM barangay_information WHERE id = 1 LIMIT 1");
$info = $infoQuery ? $infoQuery->fetch_assoc() : [];

// Resolve logo path
$currentLogo = !empty($info['logo_path']) ? $info['logo_path'] : 'assets/images/San Jose Logo 2.png';
$displayLogo = (strpos($currentLogo, 'http') === 0 || strpos($currentLogo, '/') === 0) ? $currentLogo : '../' . $currentLogo;

// Fetch activity logs (latest 50)
$logs = [];
$logsRes = $conn->query("SELECT al.*, u.full_name AS user_name, u.email AS user_email 
    FROM activity_logs al 
    LEFT JOIN users u ON al.user_id = u.id 
    ORDER BY al.id DESC 
    LIMIT 50");
if ($logsRes) {
    while ($r = $logsRes->fetch_assoc()) {
        $logs[] = $r;
    }
}

// Fetch database stats for Tab 4
$tableRes = $conn->query("SHOW TABLES");
$tableCount = $tableRes ? $tableRes->num_rows : 0;

$lastBackupRes = $conn->query("SELECT created_at, details FROM activity_logs WHERE action = 'EXPORT_BACKUP' ORDER BY id DESC LIMIT 1");
$lastBackup = ($lastBackupRes && $lbRow = $lastBackupRes->fetch_assoc()) ? $lbRow : null;

// Unread chat badge count
$unreadChatCount = 0;
$urRes = $conn->query("SELECT COUNT(*) FROM chat_messages WHERE sender = 'user' AND is_read = 0");
if ($urRes) $unreadChatCount = (int)$urRes->fetch_row()[0];

// Flash messages
$msg = $_GET['msg'] ?? '';
$err = $_GET['err'] ?? '';
$activeTab = $_GET['tab'] ?? 'profile';
$active_tab = $activeTab;

// Fetch Hero Background Slides
$hero_slides = [];
$h_res = $conn->query("SELECT * FROM hero_backgrounds ORDER BY sort_order ASC, id ASC");
if ($h_res) {
    while ($h_row = $h_res->fetch_assoc()) {
        $hero_slides[] = $h_row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings & System Control Center - Barangay San Jose</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/dashboard.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/settings.css?v=<?= time() ?>">

    <style>
        /* Modern Government Settings & Control Center Styling (Barangay San Jose Blue & Navy Theme) */
        :root {
            --gov-navy: #0d2847;
            --gov-navy-hover: #091e36;
            --gov-blue: #1a73e8;
            --gov-blue-hover: #1557b0;
            --gov-blue-subtle: #e8f0fe;
            --gov-gold: #fbbf24;
            --slate-border: #e2e8f0;
            --slate-bg: #f8fafc;
            --slate-text-muted: #64748b;
            --slate-text-dark: #1e293b;
        }

        .settings-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 0 3rem;
        }

        /* Flash Message Banners */
        .settings-alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            animation: fadeIn 0.3s ease;
        }
        .settings-alert-success {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }
        .settings-alert-danger {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        .settings-alert .alert-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .settings-alert .alert-close {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            font-size: 1.25rem;
            line-height: 1;
            padding: 0;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        .settings-alert .alert-close:hover {
            opacity: 1;
        }

        /* 6-Tab Navigation Bar - Single Row Layout */
        .settings-tabs-wrapper {
            background: #ffffff;
            border: 1px solid var(--slate-border);
            border-radius: 12px;
            padding: 0.45rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 6px rgba(13, 40, 71, 0.04);
        }
        .settings-nav-tabs {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.35rem;
            list-style: none;
            margin: 0;
            padding: 0;
            overflow-x: auto;
            scrollbar-width: none;
        }
        .settings-nav-tabs::-webkit-scrollbar {
            display: none;
        }
        .settings-nav-item {
            flex: 1 1 auto;
            min-width: 0;
        }
        .settings-tab-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            width: 100%;
            padding: 0.75rem 0.7rem;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: var(--slate-text-muted);
            font-size: 0.84rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
            white-space: nowrap;
        }
        .settings-tab-btn i {
            font-size: 1rem;
            flex-shrink: 0;
        }
        .settings-tab-btn:hover {
            background-color: var(--gov-blue-subtle);
            color: var(--gov-blue);
        }
        .settings-tab-btn.active {
            background-color: var(--gov-navy);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(13, 40, 71, 0.25);
        }
        .settings-tab-btn.active i {
            color: var(--gov-gold);
        }

        /* Tab Content Panes */
        .settings-tab-pane {
            display: none;
            animation: fadeIn 0.25s ease;
        }
        .settings-tab-pane.active {
            display: block;
        }

        /* Card Section Styling */
        .settings-card {
            background: #ffffff;
            border: 1px solid var(--slate-border);
            border-radius: 14px;
            padding: 2rem;
            margin-bottom: 1.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
        }
        .settings-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .card-header-title {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }
        .card-header-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: var(--gov-blue-subtle);
            color: var(--gov-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }
        .card-header-title h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--slate-text-dark);
            margin: 0 0 0.2rem 0;
        }
        .card-header-title p {
            font-size: 0.88rem;
            color: var(--slate-text-muted);
            margin: 0;
        }

        /* Form Grid Layouts */
        .form-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }
        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }
        .form-full {
            grid-column: 1 / -1;
        }

        .form-group-custom {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
            margin-bottom: 1.25rem;
        }
        .form-label-custom {
            font-size: 0.88rem;
            font-weight: 600;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .form-label-custom span.req {
            color: #ef4444;
        }
        .form-control-custom {
            width: 100%;
            padding: 0.75rem 0.95rem;
            font-size: 0.95rem;
            color: #1e293b;
            background-color: #ffffff;
            border: 1px solid var(--slate-border);
            border-radius: 8px;
            transition: all 0.2s ease;
            box-sizing: border-box;
            font-family: inherit;
        }
        .form-control-custom:focus {
            outline: none;
            border-color: var(--gov-blue);
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.14);
        }
        textarea.form-control-custom {
            resize: vertical;
            min-height: 90px;
        }
        .form-hint {
            font-size: 0.78rem;
            color: var(--slate-text-muted);
            margin-top: 0.2rem;
        }

        /* Branding Logo Upload Area */
        .logo-uploader-card {
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 1.5rem;
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }
        .logo-preview-box {
            width: 110px;
            height: 110px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid var(--slate-border);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .logo-preview-box img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }
        .logo-uploader-actions {
            flex: 1;
        }
        .logo-uploader-actions h4 {
            margin: 0 0 0.35rem 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: #1e293b;
        }
        .logo-uploader-actions p {
            margin: 0 0 1rem 0;
            font-size: 0.85rem;
            color: var(--slate-text-muted);
        }
        .btn-upload-file {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.25rem;
            background: #ffffff;
            color: var(--gov-blue);
            border: 1px solid var(--gov-blue);
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-upload-file:hover {
            background: var(--gov-blue);
            color: #ffffff;
        }

        /* Password Eye Toggle Input */
        .password-input-group {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-input-group .form-control-custom {
            padding-right: 2.75rem;
        }
        .btn-toggle-eye {
            position: absolute;
            right: 0.75rem;
            background: none;
            border: none;
            color: var(--slate-text-muted);
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }
        .btn-toggle-eye:hover {
            color: var(--slate-text-dark);
        }

        /* Buttons */
        .btn-save-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.75rem;
            background: var(--gov-blue);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(26, 115, 232, 0.25);
        }
        .btn-save-primary:hover {
            background: var(--gov-blue-hover);
            transform: translateY(-1px);
        }
        .btn-danger-custom {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.25rem;
            background: #ef4444;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-danger-custom:hover {
            background: #dc2626;
        }
        .form-actions-bar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 1rem;
            padding-top: 1.25rem;
            margin-top: 1.5rem;
            border-top: 1px solid #f1f5f9;
        }

        /* Admin Security User Profile Badge */
        .admin-profile-badge-card {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #0d2847 0%, #1a73e8 100%);
            border-radius: 12px;
            color: #ffffff;
            margin-bottom: 2rem;
            box-shadow: 0 6px 15px rgba(13, 40, 71, 0.22);
        }
        .admin-badge-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid var(--gov-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: var(--gov-gold);
            flex-shrink: 0;
        }
        .admin-badge-info h4 {
            margin: 0 0 0.35rem 0;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }
        .admin-badge-info p {
            margin: 0 0 0.65rem 0;
            font-size: 0.92rem;
            color: rgba(255, 255, 255, 0.85);
        }
        .admin-badge-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .badge-pill-gold {
            background: rgba(251, 191, 36, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.4);
        }
        .badge-pill-emerald {
            background: rgba(56, 189, 248, 0.2);
            color: #bae6fd;
            border: 1px solid rgba(56, 189, 248, 0.4);
        }

        /* Tab 4: System Health Cards Grid */
        .system-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 2rem;
        }
        .sys-stat-card {
            background: #ffffff;
            border: 1px solid var(--slate-border);
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .sys-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.05);
        }
        .sys-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gov-blue);
        }
        .sys-stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--gov-blue-subtle);
            color: var(--gov-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        .sys-stat-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--slate-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.35rem;
        }
        .sys-stat-val {
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }
        .sys-stat-sub {
            font-size: 0.8rem;
            color: var(--gov-blue);
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-weight: 500;
        }

        /* Database Backup Box */
        .backup-action-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.75rem;
            background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%);
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            gap: 1.5rem;
        }
        .backup-box-text h4 {
            margin: 0 0 0.35rem 0;
            font-size: 1.15rem;
            font-weight: 700;
            color: #1e293b;
        }
        .backup-box-text p {
            margin: 0;
            font-size: 0.88rem;
            color: var(--slate-text-muted);
        }
        .btn-backup-download {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.9rem 1.65rem;
            background: #0d2847;
            color: #ffffff;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(13, 40, 71, 0.3);
            white-space: nowrap;
        }
        .btn-backup-download:hover {
            background: #091e35;
            transform: translateY(-2px);
            color: #fbbf24;
        }

        /* Tab 5: Audit Log Table */
        .audit-table-wrapper {
            overflow-x: auto;
            border: 1px solid var(--slate-border);
            border-radius: 10px;
        }
        .audit-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
            text-align: left;
        }
        .audit-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            padding: 0.9rem 1rem;
            border-bottom: 2px solid var(--slate-border);
            white-space: nowrap;
        }
        .audit-table td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }
        .audit-table tr:hover td {
            background-color: #fafbfc;
        }
        .log-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.65rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }
        .log-badge-profile { background: #dcfce7; color: #15803d; }
        .log-badge-contacts { background: #e0f2fe; color: #0369a1; }
        .log-badge-security { background: #f3e8ff; color: #7e22ce; }
        .log-badge-backup { background: #fef3c7; color: #b45309; }
        .log-badge-clear { background: #fee2e2; color: #b91c1c; }
        .log-badge-default { background: #f1f5f9; color: #475569; }

        .log-ip {
            font-family: monospace;
            background: #f1f5f9;
            padding: 0.2rem 0.45rem;
            border-radius: 4px;
            color: #475569;
            font-size: 0.82rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .system-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .form-grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .settings-nav-tabs {
                flex-direction: column;
            }
            .form-grid-2, .form-grid-3 {
                grid-template-columns: 1fr;
            }
            .system-stats-grid {
                grid-template-columns: 1fr;
            }
            .logo-uploader-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            .admin-profile-badge-card {
                flex-direction: column;
                text-align: center;
            }
            .admin-badge-pills {
                justify-content: center;
            }
            .backup-action-box {
                flex-direction: column;
                align-items: flex-start;
            }
            .settings-card {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>

    <div class="admin-layout">
        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <img src="../assets/images/San Jose Logo 2.png" alt="Barangay Logo">
                <h2>Admin Panel</h2>
            </div>
            <ul class="sidebar-nav">
                <li>
                    <a href="dashboard.php">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        </span>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="adminabout.php">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        </span>
                        About
                    </a>
                </li>
                <li class="admin-dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </span>
                        Officials
                        <svg class="chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                    <ul class="admin-dropdown-menu">
                        <li><a href="barangayofficial.php">Barangay Officials</a></li>
                        <li><a href="skofficials.php">SK Officials</a></li>
                    </ul>
                </li>
                <li class="admin-dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </span>
                        Spot Map
                        <svg class="chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                    <ul class="admin-dropdown-menu">
                        <li><a href="legends.php">Legends</a></li>
                        <li><a href="purok1.php">Purok 1</a></li>
                        <li><a href="purok2.php">Purok 2</a></li>
                        <li><a href="purok3.php">Purok 3</a></li>
                        <li><a href="purok4.php">Purok 4</a></li>
                    </ul>
                </li>
                <li class="admin-dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </span>
                        Household
                        <svg class="chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                    <ul class="admin-dropdown-menu">
                        <li><a href="resident1.php">Resident 1</a></li>
                        <li><a href="resident2.php">Resident 2</a></li>
                        <li><a href="resident3.php">Resident 3</a></li>
                        <li><a href="resident4.php">Resident 4</a></li>
                    </ul>
                </li>
                <li>
                    <a href="mediagallery.php">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </span>
                        Media Gallery
                    </a>
                </li>
                <li>
                    <a href="service.php">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        </span>
                        Services
                    </a>
                </li>
                <li>
                    <a href="announcement.php">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        </span>
                        Announcements
                    </a>
                </li>
                <li>
                    <a href="feedbackchat.php">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        </span>
                        Feedback Chat
                        <?php if ($unreadChatCount > 0): ?>
                            <span class="nav-badge"><?= $unreadChatCount ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li>
                    <a href="settings.php" class="active">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        </span>
                        Settings
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="nav-logout" onclick="return confirm('Are you sure you want to log out?');">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        </span>
                        Logout
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main">
            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-left">
                    <h1>Settings & System Control Center</h1>
                    <p>Manage community profile, official hotlines, administrative security, and database maintenance</p>
                </div>
                <div class="header-right-actions">
                    <span class="date-pill">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <?= date('l, M d, Y') ?>
                    </span>
                    <a href="../index.php" target="_blank" class="btn-public-site">
                        <span>View Public Portal</span>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </a>
                    <div class="header-user-profile">
                        <div class="user-text">
                            <span class="user-name"><?= htmlspecialchars($adminUser['full_name'] ?? 'System Admin') ?></span>
                            <span class="user-role"><?= htmlspecialchars(ucfirst($adminUser['role'] ?? 'Administrator')) ?></span>
                        </div>
                        <div class="user-avatar">
                            <?= strtoupper(substr($adminUser['full_name'] ?? 'A', 0, 1)) ?>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Settings Content Container -->
            <div class="admin-content">
                <div class="settings-container">

                    <!-- Flash Message Feedback Banners -->
                    <?php if ($msg === 'general_saved'): ?>
                        <div class="settings-alert settings-alert-success">
                            <div class="alert-content">
                                <i class="bi bi-check-circle-fill"></i>
                                <span><strong>Success!</strong> Barangay profile information and branding settings have been updated.</span>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
                        </div>
                    <?php elseif ($msg === 'contacts_saved'): ?>
                        <div class="settings-alert settings-alert-success">
                            <div class="alert-content">
                                <i class="bi bi-check-circle-fill"></i>
                                <span><strong>Success!</strong> Official contact numbers and emergency hotlines have been saved.</span>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
                        </div>
                    <?php elseif ($msg === 'security_saved'): ?>
                        <div class="settings-alert settings-alert-success">
                            <div class="alert-content">
                                <i class="bi bi-check-circle-fill"></i>
                                <span><strong>Success!</strong> Administrator profile name and login email updated successfully.</span>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
                        </div>
                    <?php elseif ($msg === 'security_saved_with_password'): ?>
                        <div class="settings-alert settings-alert-success">
                            <div class="alert-content">
                                <i class="bi bi-shield-check"></i>
                                <span><strong>Security Updated!</strong> Administrator credentials and password have been securely changed.</span>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
                        </div>
                    <?php elseif ($msg === 'logs_cleared'): ?>
                        <div class="settings-alert settings-alert-success">
                            <div class="alert-content">
                                <i class="bi bi-trash3-fill"></i>
                                <span><strong>Audit Trail Cleared:</strong> Activity logs have been truncated and a fresh audit entry created.</span>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
                        </div>
                    <?php elseif ($msg === 'hero_uploaded'): ?>
                        <div class="settings-alert settings-alert-success">
                            <div class="alert-content">
                                <i class="bi bi-check-circle-fill"></i>
                                <span><strong>Success!</strong> <?= (isset($_GET['count']) ? intval($_GET['count']) : '') ?> Hero background image(s) uploaded successfully!</span>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
                        </div>
                    <?php elseif ($msg === 'hero_speed_saved'): ?>
                        <div class="settings-alert settings-alert-success">
                            <div class="alert-content">
                                <i class="bi bi-check-circle-fill"></i>
                                <span><strong>Success!</strong> Hero slideshow settings updated successfully!</span>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
                        </div>
                    <?php elseif ($msg === 'hero_deleted'): ?>
                        <div class="settings-alert settings-alert-success">
                            <div class="alert-content">
                                <i class="bi bi-trash3-fill"></i>
                                <span><strong>Removed:</strong> Hero background image removed successfully!</span>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($err)): ?>
                        <div class="settings-alert settings-alert-danger">
                            <div class="alert-content">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span><strong>Notice:</strong> <?= htmlspecialchars($err) ?></span>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
                        </div>
                    <?php endif; ?>

                    <!-- 6-Tab Navigation Bar -->
                    <div class="settings-tabs-wrapper">
                        <ul class="settings-nav-tabs">
                            <li class="settings-nav-item">
                                <button type="button" class="settings-tab-btn <?= $activeTab === 'profile' ? 'active' : '' ?>" data-tab="profile">
                                    <i class="bi bi-building"></i>
                                    <span>Barangay Profile</span>
                                </button>
                            </li>
                            <li class="settings-nav-item">
                                <button type="button" class="settings-tab-btn tab-btn <?= $activeTab === 'hero_bg' ? 'active' : '' ?>" data-tab="hero_bg" onclick="switchTab('hero_bg', this)">
                                    <i class="bi bi-images"></i>
                                    <span>Hero Background</span>
                                </button>
                            </li>
                            <li class="settings-nav-item">
                                <button type="button" class="settings-tab-btn <?= $activeTab === 'contacts' ? 'active' : '' ?>" data-tab="contacts">
                                    <i class="bi bi-telephone-inbound"></i>
                                    <span>Hotlines & Contacts</span>
                                </button>
                            </li>
                            <li class="settings-nav-item">
                                <button type="button" class="settings-tab-btn <?= $activeTab === 'security' ? 'active' : '' ?>" data-tab="security">
                                    <i class="bi bi-shield-lock"></i>
                                    <span>Administrator Security</span>
                                </button>
                            </li>
                            <li class="settings-nav-item">
                                <button type="button" class="settings-tab-btn <?= $activeTab === 'health' ? 'active' : '' ?>" data-tab="health">
                                    <i class="bi bi-hdd-network"></i>
                                    <span>Database & System Health</span>
                                </button>
                            </li>
                            <li class="settings-nav-item">
                                <button type="button" class="settings-tab-btn <?= $activeTab === 'logs' ? 'active' : '' ?>" data-tab="logs">
                                    <i class="bi bi-journal-text"></i>
                                    <span>Activity Logs</span>
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 1: BARANGAY PROFILE -->
                    <!-- ========================================================= -->
                    <div class="settings-tab-pane <?= $activeTab === 'profile' ? 'active' : '' ?>" id="tab-profile">
                        <form action="settings.php?tab=profile" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="save_general">

                            <div class="settings-card">
                                <div class="settings-card-header">
                                    <div class="card-header-title">
                                        <div class="card-header-icon">
                                            <i class="bi bi-image"></i>
                                        </div>
                                        <div>
                                            <h3>Official Branding & Seal</h3>
                                            <p>Upload the official Barangay insignia displayed across citizen portals and documents</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Logo Uploader with Live Preview -->
                                <div class="logo-uploader-card">
                                    <div class="logo-preview-box">
                                        <img id="logoPreviewImg" src="<?= htmlspecialchars($displayLogo) ?>" alt="Barangay Logo">
                                    </div>
                                    <div class="logo-uploader-actions">
                                        <h4>Barangay Official Logo</h4>
                                        <p>Accepted formats: PNG, JPG, JPEG, WEBP, or SVG. Maximum file size: 5MB.</p>
                                        <label for="logoFileInput" class="btn-upload-file">
                                            <i class="bi bi-cloud-arrow-up"></i>
                                            <span>Choose New Logo</span>
                                        </label>
                                        <input type="file" id="logoFileInput" name="logo" accept=".png,.jpg,.jpeg,.webp,.svg" style="display: none;" onchange="previewLogo(event)">
                                        <span id="logoFileName" style="margin-left: 0.75rem; font-size: 0.85rem; color: #64748b;"></span>
                                    </div>
                                </div>

                                <div class="settings-card-header" style="margin-top: 1rem;">
                                    <div class="card-header-title">
                                        <div class="card-header-icon">
                                            <i class="bi bi-geo-alt"></i>
                                        </div>
                                        <div>
                                            <h3>Jurisdiction & General Information</h3>
                                            <p>Specify municipal affiliation, geographic location, and public office hours</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-grid-3">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Barangay Name <span class="req">*</span></label>
                                        <input type="text" name="barangay_name" class="form-control-custom" value="<?= htmlspecialchars($info['barangay_name'] ?? 'San Jose') ?>" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Municipality <span class="req">*</span></label>
                                        <input type="text" name="municipality" class="form-control-custom" value="<?= htmlspecialchars($info['municipality'] ?? 'Lapuyan') ?>" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Province <span class="req">*</span></label>
                                        <input type="text" name="province" class="form-control-custom" value="<?= htmlspecialchars($info['province'] ?? 'Zamboanga del Sur') ?>" required>
                                    </div>
                                </div>

                                <div class="form-grid-2">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Official Slogan / Tagline</label>
                                        <input type="text" name="slogan" class="form-control-custom" value="<?= htmlspecialchars($info['slogan'] ?? 'Bayanihan • Serbisyong Totoo') ?>" placeholder="e.g., Bayanihan • Serbisyong Totoo">
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Office Schedule & Public Hours</label>
                                        <input type="text" name="office_schedule" class="form-control-custom" value="<?= htmlspecialchars($info['office_schedule'] ?? 'Monday - Friday, 8:00 AM - 5:00 PM') ?>" placeholder="e.g., Monday - Friday, 8:00 AM - 5:00 PM">
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Physical Barangay Hall Address</label>
                                    <textarea name="address" class="form-control-custom" rows="2" placeholder="Complete address including street, landmark, and postal code"><?= htmlspecialchars($info['address'] ?? '') ?></textarea>
                                </div>

                                <div class="form-grid-2" style="margin-top: 1rem;">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Official Mission Statement</label>
                                        <textarea name="mission" class="form-control-custom" rows="4" placeholder="Enter barangay mission statement"><?= htmlspecialchars($info['mission'] ?? '') ?></textarea>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Official Vision Statement</label>
                                        <textarea name="vision" class="form-control-custom" rows="4" placeholder="Enter barangay vision statement"><?= htmlspecialchars($info['vision'] ?? '') ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">General Community Description</label>
                                    <textarea name="description" class="form-control-custom" rows="3" placeholder="Brief background, community identity, or portal introductory overview"><?= htmlspecialchars($info['description'] ?? '') ?></textarea>
                                </div>

                                <div class="form-actions-bar">
                                    <button type="submit" class="btn-save-primary">
                                        <i class="bi bi-floppy"></i>
                                        <span>Save Barangay Profile</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 1B: HERO BACKGROUND & SLIDESHOW -->
                    <!-- ========================================================= -->
                    <div id="tab-hero_bg" class="settings-tab-pane tab-pane <?= $active_tab === 'hero_bg' ? 'active' : '' ?>">
                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div class="card-header-title">
                                    <div class="card-header-icon">
                                        <i class="bi bi-images"></i>
                                    </div>
                                    <div>
                                        <h3 class="settings-card-title">Hero Background & Slideshow</h3>
                                        <p class="settings-card-subtitle">Manage the homepage hero background photo. If multiple photos are uploaded, they will automatically smooth crossfade in the background behind the static text.</p>
                                    </div>
                                </div>
                            </div>

                            <?php 
                            $slide_count = count($hero_slides);
                            $current_speed = intval($info['hero_slideshow_speed'] ?? 5);
                            if (!in_array($current_speed, [3, 5])) $current_speed = 5;
                            ?>
                            <div class="hero-status-pill <?= $slide_count > 1 ? 'status-multi' : ($slide_count === 1 ? 'status-single' : 'status-empty') ?>">
                                <?php if ($slide_count > 1): ?>
                                    <i class="bi bi-play-circle-fill"></i> <div><strong>Smooth Slideshow Active:</strong> <?= $slide_count ?> background images rotating every <?= $current_speed ?> seconds. The hero text remains static and unchanged.</div>
                                <?php elseif ($slide_count === 1): ?>
                                    <i class="bi bi-image"></i> <div><strong>Single Static Background:</strong> 1 custom background photo is currently active on the homepage hero section.</div>
                                <?php else: ?>
                                    <i class="bi bi-info-circle-fill"></i> <div><strong>Default Background:</strong> No custom photos uploaded yet. The homepage is currently displaying the default photo (<code>assets/images/Barangay Hall.png</code>).</div>
                                <?php endif; ?>
                            </div>

                            <form action="settings.php" method="POST" enctype="multipart/form-data" class="hero-upload-form">
                                <input type="hidden" name="action" value="upload_hero_bg">
                                <div class="form-row">
                                    <div class="form-group" style="flex: 2;">
                                        <label><i class="bi bi-cloud-arrow-up-fill"></i> Upload Background Photo(s)</label>
                                        <input type="file" name="hero_images[]" multiple accept="image/png, image/jpeg, image/jpg, image/webp" class="form-control" id="heroImagesInput" onchange="previewHeroUploads(this)">
                                        <span class="form-hint">You can select multiple photos at once. Supported formats: PNG, JPG, JPEG, WEBP. High-resolution landscape photos recommended.</span>
                                    </div>
                                    <div class="form-group" style="flex: 1;">
                                        <label><i class="bi bi-stopwatch"></i> Slideshow Speed</label>
                                        <select name="hero_slideshow_speed" class="form-control">
                                            <option value="3" <?= $current_speed === 3 ? 'selected' : '' ?>>3 Seconds (Fast)</option>
                                            <option value="5" <?= $current_speed === 5 ? 'selected' : '' ?>>5 Seconds (Recommended - Smooth)</option>
                                        </select>
                                        <span class="form-hint">Controls how long each background photo remains before smoothly crossfading to the next.</span>
                                    </div>
                                </div>

                                <div id="heroUploadPreview" class="hero-preview-row" style="display: none;"></div>

                                <button type="submit" class="btn-save-settings">
                                    <i class="bi bi-upload"></i> Save & Upload Backgrounds
                                </button>
                            </form>

                            <div class="hero-gallery-section" style="margin-top: 30px; padding-top: 25px; border-top: 1px solid #e2e8f0;">
                                <h4 class="hero-gallery-title" style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-collection"></i> Active Background Images (<?= $slide_count ?>)
                                </h4>
                                
                                <?php if ($slide_count === 0): ?>
                                    <div class="hero-empty-state" style="text-align: center; padding: 30px 20px; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; color: #64748b; max-width: 100%; box-sizing: border-box;">
                                        <div class="hero-default-preview" style="width: 100%; max-width: 320px; height: 160px; margin: 0 auto 16px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 1px solid #cbd5e1; background: #0f172a;">
                                            <img src="../assets/images/Barangay Hall.png" alt="Default Hero Image" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                        </div>
                                        <p style="margin: 0; font-size: 0.95rem; color: #334155;"><strong>Currently using the default Barangay San Jose background photo.</strong></p>
                                        <p style="margin: 5px 0 0; font-size: 0.85rem; color: #64748b;">Upload photos above to customize your homepage hero background or activate a smooth slideshow.</p>
                                    </div>
                                <?php else: ?>
                                    <div class="hero-grid">
                                        <?php foreach ($hero_slides as $index => $slide): ?>
                                            <div class="hero-card">
                                                <div class="hero-card-img-wrap" style="position: relative; width: 100%; height: 160px; background: #0f172a; overflow: hidden;">
                                                    <img src="../<?= htmlspecialchars($slide['image_path']) ?>" alt="Hero Slide <?= $index + 1 ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                                    <span class="hero-card-badge">Slide #<?= $index + 1 ?></span>
                                                </div>
                                                <div class="hero-card-footer">
                                                    <span class="hero-card-date"><i class="bi bi-calendar3"></i> <?= date('M d, Y', strtotime($slide['created_at'])) ?></span>
                                                    <form action="settings.php" method="POST" onsubmit="return confirm('Are you sure you want to remove this background image?');" style="margin: 0;">
                                                        <input type="hidden" name="action" value="delete_hero_bg">
                                                        <input type="hidden" name="hero_id" value="<?= $slide['id'] ?>">
                                                        <button type="submit" class="btn-delete-hero" title="Delete this image">
                                                            <i class="bi bi-trash3-fill"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 2: HOTLINES & CONTACTS -->
                    <!-- ========================================================= -->
                    <div class="settings-tab-pane <?= $activeTab === 'contacts' ? 'active' : '' ?>" id="tab-contacts">
                        <form action="settings.php?tab=contacts" method="POST">
                            <input type="hidden" name="action" value="save_contacts">

                            <div class="settings-card">
                                <div class="settings-card-header">
                                    <div class="card-header-title">
                                        <div class="card-header-icon">
                                            <i class="bi bi-shield-fill-exclamation"></i>
                                        </div>
                                        <div>
                                            <h3>Emergency Response Hotlines</h3>
                                            <p>Public emergency lines broadcast to community residents and spot map emergency markers</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-grid-2">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom"><i class="bi bi-shield-shaded" style="color: #0369a1;"></i> Philippine National Police (PNP)</label>
                                        <input type="text" name="police_hotline" class="form-control-custom" value="<?= htmlspecialchars($info['police_hotline'] ?? '166 / +63 998 598 7200') ?>" placeholder="e.g., 166 / +63 998 598 7200">
                                        <span class="form-hint">Local police station dispatch or regional mobile unit</span>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom"><i class="bi bi-fire" style="color: #dc2626;"></i> Bureau of Fire Protection (BFP)</label>
                                        <input type="text" name="fire_hotline" class="form-control-custom" value="<?= htmlspecialchars($info['fire_hotline'] ?? '160 / +63 939 123 4567') ?>" placeholder="e.g., 160 / +63 939 123 4567">
                                        <span class="form-hint">Emergency fire fighting and disaster rescue hotline</span>
                                    </div>
                                </div>

                                <div class="form-grid-2">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom"><i class="bi bi-hospital" style="color: #16a34a;"></i> Rural Health Unit / Health Center</label>
                                        <input type="text" name="health_hotline" class="form-control-custom" value="<?= htmlspecialchars($info['health_hotline'] ?? '+63 920 987 6543') ?>" placeholder="e.g., +63 920 987 6543">
                                        <span class="form-hint">Ambulance, health center medical triage and midwife on duty</span>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom"><i class="bi bi-person-badge" style="color: #0d2847;"></i> Barangay Tanod & Peace Corps</label>
                                        <input type="text" name="tanod_hotline" class="form-control-custom" value="<?= htmlspecialchars($info['tanod_hotline'] ?? '+63 945 112 3344') ?>" placeholder="e.g., +63 945 112 3344">
                                        <span class="form-hint">Barangay Security Desk and patrol dispatch contact</span>
                                    </div>
                                </div>

                                <div class="settings-card-header" style="margin-top: 1.5rem;">
                                    <div class="card-header-title">
                                        <div class="card-header-icon">
                                            <i class="bi bi-chat-left-dots"></i>
                                        </div>
                                        <div>
                                            <h3>Official Administrative & Online Channels</h3>
                                            <p>General public inquiries, citizen email reception, and official social media</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-grid-2">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom"><i class="bi bi-envelope-at"></i> Official Public Email</label>
                                        <input type="email" name="official_email" class="form-control-custom" value="<?= htmlspecialchars($info['official_email'] ?? 'barangaysanjose.lapuyan@gmail.com') ?>" placeholder="e.g., barangaysanjose.lapuyan@gmail.com">
                                        <span class="form-hint">Official contact inbox for government correspondence</span>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom"><i class="bi bi-telephone"></i> Barangay Hall Main Contact</label>
                                        <input type="text" name="main_contact" class="form-control-custom" value="<?= htmlspecialchars($info['main_contact'] ?? '+63 912 345 6789') ?>" placeholder="e.g., +63 912 345 6789">
                                        <span class="form-hint">Front desk landline or administrative mobile</span>
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom"><i class="bi bi-facebook" style="color: #1877f2;"></i> Official Facebook Page URL</label>
                                    <input type="url" name="facebook_url" class="form-control-custom" value="<?= htmlspecialchars($info['facebook_url'] ?? 'https://facebook.com/BarangaySanJoseOfficial') ?>" placeholder="https://facebook.com/BarangaySanJoseOfficial">
                                    <span class="form-hint">Community social media link for advisories and public announcements</span>
                                </div>

                                <div class="form-actions-bar">
                                    <button type="submit" class="btn-save-primary">
                                        <i class="bi bi-floppy"></i>
                                        <span>Save Hotlines & Contacts</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 3: ADMINISTRATOR SECURITY & CREDENTIALS -->
                    <!-- ========================================================= -->
                    <div class="settings-tab-pane <?= $activeTab === 'security' ? 'active' : '' ?>" id="tab-security">
                        <!-- Active Administrator Profile Badge Card -->
                        <div class="admin-profile-badge-card">
                            <div class="admin-badge-avatar">
                                <?= strtoupper(substr($adminUser['full_name'] ?? 'A', 0, 1)) ?>
                            </div>
                            <div class="admin-badge-info">
                                <h4><?= htmlspecialchars($adminUser['full_name'] ?? 'System Administrator') ?></h4>
                                <p><i class="bi bi-envelope"></i> <?= htmlspecialchars($adminUser['email'] ?? 'admin@sanjose.gov.ph') ?></p>
                                <div class="admin-badge-pills">
                                    <span class="badge-pill badge-pill-gold"><i class="bi bi-award"></i> <?= htmlspecialchars(ucfirst($adminUser['role'] ?? 'Administrator')) ?></span>
                                    <span class="badge-pill badge-pill-emerald"><i class="bi bi-shield-check"></i> Account Active & Verified</span>
                                    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #fff;"><i class="bi bi-clock-history"></i> ID #<?= (int)($adminUser['id'] ?? 1) ?></span>
                                </div>
                            </div>
                        </div>

                        <form action="settings.php?tab=security" method="POST">
                            <input type="hidden" name="action" value="update_admin_security">

                            <div class="settings-card">
                                <div class="settings-card-header">
                                    <div class="card-header-title">
                                        <div class="card-header-icon">
                                            <i class="bi bi-person-gear"></i>
                                        </div>
                                        <div>
                                            <h3>Administrator Profile</h3>
                                            <p>Update your personal administrator display name and login email address</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-grid-2">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Administrator Full Name <span class="req">*</span></label>
                                        <input type="text" name="full_name" class="form-control-custom" value="<?= htmlspecialchars($adminUser['full_name'] ?? 'System Administrator') ?>" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Login Email Address <span class="req">*</span></label>
                                        <input type="email" name="email" class="form-control-custom" value="<?= htmlspecialchars($adminUser['email'] ?? 'admin@sanjose.gov.ph') ?>" required>
                                        <span class="form-hint">Used for sign-in authentication and security notices</span>
                                    </div>
                                </div>

                                <div class="settings-card-header" style="margin-top: 1.5rem;">
                                    <div class="card-header-title">
                                        <div class="card-header-icon">
                                            <i class="bi bi-key"></i>
                                        </div>
                                        <div>
                                            <h3>Change Password</h3>
                                            <p>Leave blank if you do not wish to modify your current login password</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-grid-2">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">New Password</label>
                                        <div class="password-input-group">
                                            <input type="password" id="new_password" name="new_password" class="form-control-custom" placeholder="Minimum 6 characters" minlength="6" autocomplete="new-password">
                                            <button type="button" class="btn-toggle-eye" onclick="togglePasswordVisibility('new_password', this)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <span class="form-hint">At least 6 characters (letters, numbers, or symbols)</span>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Confirm New Password</label>
                                        <div class="password-input-group">
                                            <input type="password" id="confirm_password" name="confirm_password" class="form-control-custom" placeholder="Re-type new password" minlength="6" autocomplete="new-password">
                                            <button type="button" class="btn-toggle-eye" onclick="togglePasswordVisibility('confirm_password', this)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <span class="form-hint">Must match the new password above</span>
                                    </div>
                                </div>

                                <div class="form-actions-bar">
                                    <button type="submit" class="btn-save-primary">
                                        <i class="bi bi-shield-check"></i>
                                        <span>Update Security Credentials</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 4: DATABASE & SYSTEM HEALTH -->
                    <!-- ========================================================= -->
                    <div class="settings-tab-pane <?= $activeTab === 'health' ? 'active' : '' ?>" id="tab-health">
                        <!-- Stat Cards Grid -->
                        <div class="system-stats-grid">
                            <div class="sys-stat-card">
                                <div class="sys-stat-icon">
                                    <i class="bi bi-code-slash"></i>
                                </div>
                                <div class="sys-stat-label">PHP Environment</div>
                                <div class="sys-stat-val"><?= PHP_VERSION ?></div>
                                <div class="sys-stat-sub"><i class="bi bi-check-circle-fill"></i> Version 8.0+ Ready</div>
                            </div>
                            <div class="sys-stat-card">
                                <div class="sys-stat-icon">
                                    <i class="bi bi-database"></i>
                                </div>
                                <div class="sys-stat-label">Database Engine</div>
                                <div class="sys-stat-val">MySQL</div>
                                <div class="sys-stat-sub"><i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars(substr($conn->server_info, 0, 15)) ?></div>
                            </div>
                            <div class="sys-stat-card">
                                <div class="sys-stat-icon">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                </div>
                                <div class="sys-stat-label">Upload Max Size</div>
                                <div class="sys-stat-val"><?= ini_get('upload_max_filesize') ?></div>
                                <div class="sys-stat-sub"><i class="bi bi-info-circle"></i> Post Max: <?= ini_get('post_max_size') ?></div>
                            </div>
                            <div class="sys-stat-card">
                                <div class="sys-stat-icon">
                                    <i class="bi bi-cpu"></i>
                                </div>
                                <div class="sys-stat-label">Host OS & Platform</div>
                                <div class="sys-stat-val"><?= htmlspecialchars(php_uname('s')) ?></div>
                                <div class="sys-stat-sub"><i class="bi bi-check-circle-fill"></i> Memory: <?= ini_get('memory_limit') ?></div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div class="card-header-title">
                                    <div class="card-header-icon">
                                        <i class="bi bi-database-check"></i>
                                    </div>
                                    <div>
                                        <h3>Database Management & Automated Backup</h3>
                                        <p>Generate full SQL dumps of all system tables, citizen records, and administrative configurations</p>
                                    </div>
                                </div>
                            </div>

                            <div class="backup-action-box">
                                <div class="backup-box-text">
                                    <h4>Full System Database Snapshot (.sql)</h4>
                                    <p>Generates an instant, complete SQL backup with DROP TABLE, CREATE TABLE, and INSERT statements for all <?= (int)$tableCount ?> active tables.</p>
                                    <?php if ($lastBackup): ?>
                                        <p style="margin-top: 0.5rem; font-size: 0.82rem; color: #0284c7;">
                                            <i class="bi bi-clock-history"></i> Last export generated on: <strong><?= date('M d, Y h:i A', strtotime($lastBackup['created_at'])) ?></strong>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <a href="export_backup.php" class="btn-backup-download">
                                        <i class="bi bi-download"></i>
                                        <span>Download SQL Backup</span>
                                    </a>
                                </div>
                            </div>

                            <div style="margin-top: 1.75rem; padding: 1.25rem; background: #f8fafc; border-radius: 8px; border: 1px solid var(--slate-border);">
                                <h5 style="margin: 0 0 0.5rem 0; font-size: 0.95rem; font-weight: 700; color: #334155;">
                                    <i class="bi bi-shield-shaded" style="color: var(--gov-blue);"></i> Backup & Recovery Best Practices
                                </h5>
                                <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.85rem; color: #64748b; line-height: 1.6;">
                                    <li>Store exported <code>.sql</code> files in an encrypted or offline secure storage drive.</li>
                                    <li>Recommended backup frequency: Weekly during regular operations, and immediately before major system data migrations.</li>
                                    <li>The backup script automatically escapes special characters and records every download attempt in the audit log.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================================= -->
                    <!-- TAB 5: ACTIVITY LOGS & AUDIT TRAIL -->
                    <!-- ========================================================= -->
                    <div class="settings-tab-pane <?= $activeTab === 'logs' ? 'active' : '' ?>" id="tab-logs">
                        <div class="settings-card">
                            <div class="settings-card-header">
                                <div class="card-header-title">
                                    <div class="card-header-icon">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div>
                                        <h3>System Audit Trail & Activity Logs</h3>
                                        <p>Real-time audit log of administrative actions, profile updates, and maintenance events (Last 50 records)</p>
                                    </div>
                                </div>
                                <div>
                                    <form action="settings.php?tab=logs" method="POST" onsubmit="return confirm('Are you sure you want to clear all activity logs? This action will truncate the audit trail table and cannot be undone.');">
                                        <input type="hidden" name="action" value="clear_logs">
                                        <button type="submit" class="btn-danger-custom">
                                            <i class="bi bi-trash3"></i>
                                            <span>Clear Logs</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="audit-table-wrapper">
                                <table class="audit-table">
                                    <thead>
                                        <tr>
                                            <th>Timestamp</th>
                                            <th>Action</th>
                                            <th>Event Details</th>
                                            <th>Administrator</th>
                                            <th>IP Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($logs)): ?>
                                            <?php foreach ($logs as $log): ?>
                                                <?php
                                                    $actionBadgeClass = 'log-badge-default';
                                                    $act = strtoupper($log['action']);
                                                    if (strpos($act, 'PROFILE') !== false || strpos($act, 'HERO') !== false) $actionBadgeClass = 'log-badge-profile';
                                                    elseif (strpos($act, 'CONTACT') !== false) $actionBadgeClass = 'log-badge-contacts';
                                                    elseif (strpos($act, 'SECURITY') !== false) $actionBadgeClass = 'log-badge-security';
                                                    elseif (strpos($act, 'BACKUP') !== false) $actionBadgeClass = 'log-badge-backup';
                                                    elseif (strpos($act, 'CLEAR') !== false) $actionBadgeClass = 'log-badge-clear';
                                                ?>
                                                <tr>
                                                    <td style="white-space: nowrap; font-weight: 500;">
                                                        <i class="bi bi-calendar3" style="color: #94a3b8; margin-right: 0.35rem;"></i>
                                                        <?= date('Y-m-d H:i:s', strtotime($log['created_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <span class="log-badge <?= $actionBadgeClass ?>">
                                                            <?= htmlspecialchars($log['action']) ?>
                                                        </span>
                                                    </td>
                                                    <td><?= htmlspecialchars($log['details'] ?? 'No additional details') ?></td>
                                                    <td style="white-space: nowrap;">
                                                        <?= htmlspecialchars($log['user_name'] ?? 'System Admin') ?>
                                                    </td>
                                                    <td>
                                                        <span class="log-ip"><?= htmlspecialchars($log['ip_address'] ?? '127.0.0.1') ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" style="text-align: center; padding: 2.5rem; color: #94a3b8;">
                                                    <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                                    No activity logs recorded yet. System events will automatically appear here.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <!-- Client-side Scripts -->
    <script>
        // 1. Five-Tab Seamless Client-Side Switching with URL Preservation
        document.querySelectorAll('.settings-tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetTab = btn.getAttribute('data-tab');
                switchTab(targetTab);
            });
        });

        function switchTab(tabId, btnEl) {
            // Remove active from all buttons & panes
            document.querySelectorAll('.settings-tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.settings-tab-pane').forEach(p => p.classList.remove('active'));

            // Activate matching button
            const activeBtn = btnEl || document.querySelector(`.settings-tab-btn[data-tab="${tabId}"]`);
            if (activeBtn) activeBtn.classList.add('active');

            // Activate matching pane
            const activePane = document.getElementById(`tab-${tabId}`);
            if (activePane) activePane.classList.add('active');

            // Update URL query string without reloading page
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.replaceState({}, '', url);
        }

        // Live Upload Preview for Hero Background Images
        function previewHeroUploads(input) {
            const previewContainer = document.getElementById('heroUploadPreview');
            if (!previewContainer) return;
            previewContainer.innerHTML = '';
            if (input.files && input.files.length > 0) {
                previewContainer.style.display = 'flex';
                for (let i = 0; i < input.files.length; i++) {
                    const file = input.files[i];
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const thumb = document.createElement('div');
                        thumb.className = 'hero-thumb-preview';
                        thumb.innerHTML = '<img src="' + e.target.result + '" alt="Selected"><span class="thumb-name">' + file.name + '</span>';
                        previewContainer.appendChild(thumb);
                    };
                    reader.readAsDataURL(file);
                }
            } else {
                previewContainer.style.display = 'none';
            }
        }

        // Initialize active tab from URL query parameter on load
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const currentTab = urlParams.get('tab');
            if (currentTab && document.getElementById(`tab-${currentTab}`)) {
                switchTab(currentTab);
            }
        });

        // 2. Official Logo Live Preview
        function previewLogo(event) {
            const file = event.target.files[0];
            if (file) {
                // Update file name display
                document.getElementById('logoFileName').textContent = file.name;
                
                // Show live preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.getElementById('logoPreviewImg');
                    if (previewImg) {
                        previewImg.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        // 3. Password Visibility Toggle
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // 4. Dropdown Toggle for Admin Sidebar Menus
        document.querySelectorAll('.admin-dropdown > .dropdown-toggle').forEach(dropdown => {
            dropdown.addEventListener('click', function(e) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('open');
            });
        });
    </script>
</body>
</html>
