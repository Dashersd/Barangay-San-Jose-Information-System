<?php
// Admin Dashboard - Barangay San Jose Web-Based Information System
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../db_connect.php';

// Resolve authenticated administrator display
$adminName = $_SESSION['admin_name'] ?? 'System Admin';
$adminRole = ucfirst($_SESSION['admin_role'] ?? 'Administrator');
$adminAvatar = strtoupper(substr($adminName, 0, 1));

// 1. KPI Counts
// Households
$p1Count = 0; $p2Count = 0; $p3Count = 0; $p4Count = 0;
$res = $conn->query("SELECT COUNT(*) FROM purok1_locations"); if ($res) $p1Count = (int)$res->fetch_row()[0];
$res = $conn->query("SELECT COUNT(*) FROM purok2_locations"); if ($res) $p2Count = (int)$res->fetch_row()[0];
$res = $conn->query("SELECT COUNT(*) FROM purok3_locations"); if ($res) $p3Count = (int)$res->fetch_row()[0];
$res = $conn->query("SELECT COUNT(*) FROM purok4_locations"); if ($res) $p4Count = (int)$res->fetch_row()[0];
$totalHouseholds = $p1Count + $p2Count + $p3Count + $p4Count;

// Inquiries / Chat Sessions
$totalInquiries = 0;
$res = $conn->query("SELECT COUNT(*) FROM chat_sessions");
if ($res) $totalInquiries = (int)$res->fetch_row()[0];

// Announcements
$totalAnnouncements = 0;
$res = $conn->query("SELECT COUNT(*) FROM announcements WHERE status = 'Published'");
if ($res) $totalAnnouncements = (int)$res->fetch_row()[0];

// Services
$totalServices = 0;
$res = $conn->query("SELECT COUNT(*) FROM services WHERE status = 'active'");
if ($res) $totalServices = (int)$res->fetch_row()[0];

// Officials
$barangayOfficialsCount = 0;
$skOfficialsCount = 0;
$res = $conn->query("SELECT COUNT(*) FROM barangay_officials"); if ($res) $barangayOfficialsCount = (int)$res->fetch_row()[0];
$res = $conn->query("SELECT COUNT(*) FROM sk_officials"); if ($res) $skOfficialsCount = (int)$res->fetch_row()[0];
$totalOfficials = $barangayOfficialsCount + $skOfficialsCount;

// 2. Recent Citizen Inquiries
$recentInquiries = [];
$unreadChatCount = 0;
$urRes = $conn->query("SELECT COUNT(*) FROM chat_messages WHERE sender = 'user' AND is_read = 0");
if ($urRes) $unreadChatCount = (int)$urRes->fetch_row()[0];

$inqQuery = "SELECT cs.id, cs.user_name, cs.service_type, cs.status, cs.created_at,
    COALESCE((SELECT cm.message FROM chat_messages cm WHERE cm.session_id = cs.id ORDER BY cm.id DESC LIMIT 1), 'No messages yet') AS last_msg,
    COALESCE((SELECT cm.created_at FROM chat_messages cm WHERE cm.session_id = cs.id ORDER BY cm.id DESC LIMIT 1), cs.created_at) AS last_time,
    (SELECT COUNT(*) FROM chat_messages cm WHERE cm.session_id = cs.id AND cm.sender = 'user' AND cm.is_read = 0) AS unread_count
    FROM chat_sessions cs 
    ORDER BY last_time DESC 
    LIMIT 4";
$inqRes = $conn->query($inqQuery);
if ($inqRes) {
    while ($row = $inqRes->fetch_assoc()) {
        $recentInquiries[] = $row;
    }
}

// 3. Recent Announcements
$recentAnnouncements = [];
$annQuery = "SELECT id, title, event_date, who_target, status, created_at FROM announcements ORDER BY id DESC LIMIT 3";
$annRes = $conn->query($annQuery);
if ($annRes) {
    while ($row = $annRes->fetch_assoc()) {
        $recentAnnouncements[] = $row;
    }
}

// 4. Recent Media Gallery Uploads
$recentMedia = [];
$mediaQuery = "SELECT gm.id, gm.file_path, gm.caption, COALESCE(gf.folder_name, 'General') AS folder_name 
    FROM gallery_media gm 
    LEFT JOIN gallery_folders gf ON gm.folder_id = gf.id 
    ORDER BY gm.id DESC 
    LIMIT 4";
$mediaRes = $conn->query($mediaQuery);
if ($mediaRes) {
    while ($row = $mediaRes->fetch_assoc()) {
        $recentMedia[] = $row;
    }
}

// 5. Core Officials on Duty
$coreOfficials = [];
// Captain
$capRes = $conn->query("SELECT name, role, image FROM barangay_officials WHERE id = 'captain' OR level = 1 LIMIT 1");
if ($capRes && $cap = $capRes->fetch_assoc()) {
    $coreOfficials[] = [
        'name' => $cap['name'],
        'role' => 'Punong Barangay',
        'image' => !empty($cap['image']) ? '../' . $cap['image'] : '../assets/images/San Jose Logo 2.png',
        'link' => 'barangayofficial.php'
    ];
}
// Secretary
$secRes = $conn->query("SELECT name, role, image FROM barangay_officials WHERE id = 'secretary' LIMIT 1");
if ($secRes && $sec = $secRes->fetch_assoc()) {
    $coreOfficials[] = [
        'name' => $sec['name'],
        'role' => 'Barangay Secretary',
        'image' => !empty($sec['image']) ? '../' . $sec['image'] : '../assets/images/San Jose Logo 2.png',
        'link' => 'barangayofficial.php'
    ];
}
// Treasurer
$treRes = $conn->query("SELECT name, role, image FROM barangay_officials WHERE id = 'treasurer' LIMIT 1");
if ($treRes && $tre = $treRes->fetch_assoc()) {
    $coreOfficials[] = [
        'name' => $tre['name'],
        'role' => 'Barangay Treasurer',
        'image' => !empty($tre['image']) ? '../' . $tre['image'] : '../assets/images/San Jose Logo 2.png',
        'link' => 'barangayofficial.php'
    ];
}
// SK Chairperson
$skRes = $conn->query("SELECT name, role, image FROM sk_officials WHERE id = 'sk_chairperson' OR level = 1 LIMIT 1");
if ($skRes && $sk = $skRes->fetch_assoc()) {
    $coreOfficials[] = [
        'name' => $sk['name'],
        'role' => 'SK Chairperson',
        'image' => !empty($sk['image']) ? '../' . $sk['image'] : '../assets/images/San Jose Logo 2.png',
        'link' => 'skofficials.php'
    ];
}

// Purok percentage helper
$p1Pct = $totalHouseholds > 0 ? round(($p1Count / $totalHouseholds) * 100) : 0;
$p2Pct = $totalHouseholds > 0 ? round(($p2Count / $totalHouseholds) * 100) : 0;
$p3Pct = $totalHouseholds > 0 ? round(($p3Count / $totalHouseholds) * 100) : 0;
$p4Pct = $totalHouseholds > 0 ? round(($p4Count / $totalHouseholds) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Barangay San Jose</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="../assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/dashboard.css?v=<?= time() ?>">
</head>
<body>

    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <img src="../assets/images/San Jose Logo 2.png" alt="Barangay Logo">
                <h2>Admin Panel</h2>
            </div>
            <ul class="sidebar-nav">
                <li>
                    <a href="dashboard.php" class="active">
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
                    <a href="settings.php">
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

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-left">
                    <h1>Dashboard Overview</h1>
                    <p>Community administration and real-time public service metrics</p>
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
                            <span class="user-name"><?= htmlspecialchars($adminName) ?></span>
                            <span class="user-role"><?= htmlspecialchars($adminRole) ?></span>
                        </div>
                        <div class="user-avatar"><?= htmlspecialchars($adminAvatar) ?></div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="admin-content">



                <!-- 2. Top 5 Real-Time KPI Stat Cards -->
                <div class="kpi-stats-grid">
                    <a href="resident1.php" class="kpi-card households">
                        <div class="kpi-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </div>
                        <div class="kpi-data">
                            <span class="kpi-number"><?= $totalHouseholds ?></span>
                            <span class="kpi-title">Mapped Households</span>
                            <span class="kpi-subtext">Across Purok 1 to 4</span>
                        </div>
                    </a>

                    <a href="feedbackchat.php" class="kpi-card inquiries">
                        <div class="kpi-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        </div>
                        <div class="kpi-data">
                            <span class="kpi-number"><?= $totalInquiries ?></span>
                            <span class="kpi-title">Resident Inquiries</span>
                            <span class="kpi-subtext"><?= $unreadChatCount > 0 ? "<strong style='color:#dc2626;'>{$unreadChatCount} new unread</strong>" : "All inquiries answered" ?></span>
                        </div>
                    </a>

                    <a href="announcement.php" class="kpi-card announcements">
                        <div class="kpi-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        </div>
                        <div class="kpi-data">
                            <span class="kpi-number"><?= $totalAnnouncements ?></span>
                            <span class="kpi-title">Announcements</span>
                            <span class="kpi-subtext">Published on portal</span>
                        </div>
                    </a>

                    <a href="service.php" class="kpi-card services">
                        <div class="kpi-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        </div>
                        <div class="kpi-data">
                            <span class="kpi-number"><?= $totalServices ?></span>
                            <span class="kpi-title">Public Services</span>
                            <span class="kpi-subtext">Clearance, indigent, etc.</span>
                        </div>
                    </a>

                    <a href="barangayofficial.php" class="kpi-card officials">
                        <div class="kpi-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <div class="kpi-data">
                            <span class="kpi-number"><?= $totalOfficials ?></span>
                            <span class="kpi-title">Community Leaders</span>
                            <span class="kpi-subtext"><?= $barangayOfficialsCount ?> Barangay + <?= $skOfficialsCount ?> SK</span>
                        </div>
                    </a>
                </div>

                <!-- 3. Main Dashboard Grid (2 Columns: 65% / 35%) -->
                <div class="dashboard-main-grid">
                    
                    <!-- Left Column -->
                    <div class="grid-col-left">

                        <!-- Panel 1: Live Citizen Inquiries -->
                        <div class="dashboard-panel">
                            <div class="panel-header">
                                <div class="panel-title-area">
                                    <h2>Recent Citizen Inquiries</h2>
                                    <span class="panel-count-badge"><?= count($recentInquiries) ?> Latest</span>
                                </div>
                                <a href="feedbackchat.php" class="panel-link-action">
                                    Open Chat Room &rarr;
                                </a>
                            </div>

                            <div class="table-responsive">
                                <?php if (!empty($recentInquiries)): ?>
                                    <table class="modern-table">
                                        <thead>
                                            <tr>
                                                <th>Citizen</th>
                                                <th>Service</th>
                                                <th>Latest Message</th>
                                                <th>Date &amp; Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentInquiries as $inq): 
                                                $initial = strtoupper(substr($inq['user_name'] ?? 'U', 0, 1));
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="user-cell">
                                                            <div class="user-init-avatar"><?= htmlspecialchars($initial) ?></div>
                                                            <div>
                                                                <strong><?= htmlspecialchars($inq['user_name']) ?></strong>
                                                                <?php if (!empty($inq['unread_count']) && (int)$inq['unread_count'] > 0): ?>
                                                                    <span style="display:inline-block; margin-left:6px; background:#ef4444; color:#fff; font-size:0.68rem; font-weight:800; padding:1px 6px; border-radius:999px;">New</span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="service-pill"><?= htmlspecialchars($inq['service_type'] ?? 'General') ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="message-preview-text" title="<?= htmlspecialchars($inq['last_msg']) ?>">
                                                            <?= htmlspecialchars($inq['last_msg']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="time-muted"><?= date('M d, g:i A', strtotime($inq['last_time'])) ?></span>
                                                    </td>
                                                    <td>
                                                        <a href="feedbackchat.php" class="btn-table-action">
                                                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                                            Reply
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <div class="empty-data-hint">No citizen inquiries logged yet.</div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Panel 2: Latest Announcements -->
                        <div class="dashboard-panel">
                            <div class="panel-header">
                                <div class="panel-title-area">
                                    <h2>Latest Barangay Announcements</h2>
                                    <span class="panel-count-badge"><?= count($recentAnnouncements) ?> Active</span>
                                </div>
                                <a href="announcement.php" class="panel-link-action">
                                    Manage All &rarr;
                                </a>
                            </div>

                            <div class="announcements-list">
                                <?php if (!empty($recentAnnouncements)): ?>
                                    <?php foreach ($recentAnnouncements as $ann): ?>
                                        <div class="announcement-row-card">
                                            <div class="ann-info">
                                                <h4 class="ann-title-text"><?= htmlspecialchars($ann['title']) ?></h4>
                                                <div class="ann-meta-tags">
                                                    <span>Target: <strong><?= htmlspecialchars($ann['who_target'] ?? 'All Residents') ?></strong></span>
                                                    <span>&bull;</span>
                                                    <span>Date: <strong><?= date('M d, Y', strtotime($ann['event_date'])) ?></strong></span>
                                                    <span class="ann-status-pill <?= strtolower($ann['status']) === 'published' ? 'published' : 'draft' ?>">
                                                        <?= htmlspecialchars($ann['status']) ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <a href="announcement.php" class="btn-table-action">
                                                View / Edit
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="empty-data-hint">No announcements published yet.</div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Panel 3: Media Gallery Highlights -->
                        <div class="dashboard-panel">
                            <div class="panel-header">
                                <div class="panel-title-area">
                                    <h2>Recent Media Gallery Highlights</h2>
                                    <span class="panel-count-badge">Live Photos</span>
                                </div>
                                <a href="mediagallery.php" class="panel-link-action">
                                    Open Gallery &rarr;
                                </a>
                            </div>

                            <div class="gallery-showcase-grid">
                                <?php if (!empty($recentMedia)): ?>
                                    <?php foreach ($recentMedia as $photo): ?>
                                        <a href="mediagallery.php" class="gallery-thumb-item">
                                            <img src="../<?= htmlspecialchars($photo['file_path']) ?>" alt="<?= htmlspecialchars($photo['caption'] ?? 'Photo') ?>" onerror="this.src='../assets/images/San Jose.png'">
                                            <div class="gallery-thumb-overlay">
                                                <span class="gallery-thumb-caption"><?= htmlspecialchars($photo['caption'] ?: $photo['folder_name']) ?></span>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="empty-data-hint">No gallery media uploaded yet.</div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div class="grid-col-right">

                        <!-- Widget 1: Household Mapping by Purok -->
                        <div class="dashboard-panel">
                            <div class="panel-header">
                                <div class="panel-title-area">
                                    <h2>Household Distribution</h2>
                                </div>
                                <a href="legends.php" class="panel-link-action">
                                    Map &rarr;
                                </a>
                            </div>

                            <div class="purok-bars-list">
                                <div class="purok-bar-item">
                                    <div class="purok-bar-header">
                                        <a href="resident1.php" class="purok-name" style="text-decoration:none;">
                                            <span>Purok 1</span>
                                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                        </a>
                                        <span class="purok-count"><?= $p1Count ?> (<?= $p1Pct ?>%)</span>
                                    </div>
                                    <div class="purok-track">
                                        <div class="purok-fill p1" style="width: <?= max($p1Pct, 6) ?>%;"></div>
                                    </div>
                                </div>

                                <div class="purok-bar-item">
                                    <div class="purok-bar-header">
                                        <a href="resident2.php" class="purok-name" style="text-decoration:none;">
                                            <span>Purok 2</span>
                                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                        </a>
                                        <span class="purok-count"><?= $p2Count ?> (<?= $p2Pct ?>%)</span>
                                    </div>
                                    <div class="purok-track">
                                        <div class="purok-fill p2" style="width: <?= max($p2Pct, 6) ?>%;"></div>
                                    </div>
                                </div>

                                <div class="purok-bar-item">
                                    <div class="purok-bar-header">
                                        <a href="resident3.php" class="purok-name" style="text-decoration:none;">
                                            <span>Purok 3</span>
                                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                        </a>
                                        <span class="purok-count"><?= $p3Count ?> (<?= $p3Pct ?>%)</span>
                                    </div>
                                    <div class="purok-track">
                                        <div class="purok-fill p3" style="width: <?= max($p3Pct, 6) ?>%;"></div>
                                    </div>
                                </div>

                                <div class="purok-bar-item">
                                    <div class="purok-bar-header">
                                        <a href="resident4.php" class="purok-name" style="text-decoration:none;">
                                            <span>Purok 4</span>
                                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                        </a>
                                        <span class="purok-count"><?= $p4Count ?> (<?= $p4Pct ?>%)</span>
                                    </div>
                                    <div class="purok-track">
                                        <div class="purok-fill p4" style="width: <?= max($p4Pct, 6) ?>%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Widget 2: Core Leadership on Duty -->
                        <div class="dashboard-panel">
                            <div class="panel-header">
                                <div class="panel-title-area">
                                    <h2>Leadership Roster</h2>
                                </div>
                                <a href="barangayofficial.php" class="panel-link-action">
                                    Manage &rarr;
                                </a>
                            </div>

                            <div class="leadership-roster-list">
                                <?php foreach ($coreOfficials as $official): ?>
                                    <div class="leader-item-card">
                                        <div class="leader-photo-wrap">
                                            <img src="<?= htmlspecialchars($official['image']) ?>" alt="<?= htmlspecialchars($official['name']) ?>" onerror="this.src='../assets/images/San Jose Logo 2.png'">
                                        </div>
                                        <div class="leader-details">
                                            <span class="leader-role-tag"><?= htmlspecialchars($official['role']) ?></span>
                                            <strong class="leader-name-text"><?= htmlspecialchars($official['name']) ?></strong>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>



                    </div>

                </div>

            </div>
        </main>
    </div>

    <script src="js/dashboard.js?v=<?= time() ?>"></script>
</body>
</html>
