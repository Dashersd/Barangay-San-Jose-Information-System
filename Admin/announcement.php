<?php
// Manage Announcements - Admin Panel
require_once '../db_connect.php';

$uploadDir = '../assets/images/announcements/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $deleteId = intval($_POST['delete_id'] ?? 0);
    if ($deleteId > 0) {
        // Fetch image to delete from disk
        $imgStmt = $conn->prepare("SELECT cover_image FROM announcements WHERE id = ?");
        $imgStmt->bind_param("i", $deleteId);
        $imgStmt->execute();
        $imgRes = $imgStmt->get_result()->fetch_assoc();
        $imgStmt->close();

        if (!empty($imgRes['cover_image']) && file_exists('../' . $imgRes['cover_image'])) {
            @unlink('../' . $imgRes['cover_image']);
        }

        $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();
        $stmt->close();

        header("Location: announcement.php?deleted=1");
        exit;
    }
}

// Handle Add Announcement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = trim($_POST['title'] ?? '');
    $eventDate = $_POST['event_date'] ?? date('Y-m-d');
    $whoTarget = trim($_POST['who_target'] ?? '');
    $whenTime = trim($_POST['when_time'] ?? '');
    $whatDesc = trim($_POST['what_desc'] ?? '');
    $whyDesc = trim($_POST['why_desc'] ?? '');
    $extraDesc = trim($_POST['extra_desc'] ?? '');
    $status = in_array($_POST['status'] ?? '', ['Published', 'Draft']) ? $_POST['status'] : 'Published';

    $coverImagePath = null;
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($ext, $allowed)) {
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($_FILES['cover_image']['name']));
            if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $fileName)) {
                $coverImagePath = 'assets/images/announcements/' . $fileName;
            }
        }
    }

    if (!empty($title)) {
        $stmt = $conn->prepare("INSERT INTO announcements (title, event_date, who_target, when_time, what_desc, why_desc, extra_desc, cover_image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $title, $eventDate, $whoTarget, $whenTime, $whatDesc, $whyDesc, $extraDesc, $coverImagePath, $status);
        $stmt->execute();
        $stmt->close();

        header("Location: announcement.php?added=1");
        exit;
    }
}

// Handle Edit Announcement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $editId = intval($_POST['edit_id'] ?? 0);
    $title = trim($_POST['edit_title'] ?? '');
    $eventDate = $_POST['edit_event_date'] ?? date('Y-m-d');
    $whoTarget = trim($_POST['edit_who_target'] ?? '');
    $whenTime = trim($_POST['edit_when_time'] ?? '');
    $whatDesc = trim($_POST['edit_what_desc'] ?? '');
    $whyDesc = trim($_POST['edit_why_desc'] ?? '');
    $extraDesc = trim($_POST['edit_extra_desc'] ?? '');
    $status = in_array($_POST['edit_status'] ?? '', ['Published', 'Draft']) ? $_POST['edit_status'] : 'Published';

    if ($editId > 0 && !empty($title)) {
        $updateQuery = "UPDATE announcements SET title=?, event_date=?, who_target=?, when_time=?, what_desc=?, why_desc=?, extra_desc=?, status=?";
        $params = [$title, $eventDate, $whoTarget, $whenTime, $whatDesc, $whyDesc, $extraDesc, $status];
        $types = "ssssssss";

        // Check if new image was uploaded
        if (isset($_FILES['edit_cover_image']) && $_FILES['edit_cover_image']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['edit_cover_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            if (in_array($ext, $allowed)) {
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($_FILES['edit_cover_image']['name']));
                if (move_uploaded_file($_FILES['edit_cover_image']['tmp_name'], $uploadDir . $fileName)) {
                    $newPath = 'assets/images/announcements/' . $fileName;
                    $updateQuery .= ", cover_image=?";
                    $params[] = $newPath;
                    $types .= "s";
                }
            }
        }

        $updateQuery .= " WHERE id=?";
        $params[] = $editId;
        $types .= "i";

        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->close();

        header("Location: announcement.php?updated=1");
        exit;
    }
}

// Fetch all announcements
$announcements = [];
$res = $conn->query("SELECT * FROM announcements ORDER BY event_date DESC, id DESC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $announcements[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements - Admin Panel</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="../assets/images/San Jose Logo 2.png">
    <link rel="icon" type="image/png" href="../assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/service.css"> <!-- Modal styles -->
    <link rel="stylesheet" href="css/announcement.css?v=<?= time() ?>">
    <style>
        .badge-draft {
            background-color: #f1f5f9;
            color: #64748b;
            border: 1px solid #cbd5e1;
        }
        .announcement-thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 6px;
            background: #f1f5f9;
            display: inline-block;
        }
        .thumb-placeholder {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #e2e8f0;
            color: #64748b;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Modal Window & Scrollable Body Fix */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }
        .modal-overlay.show {
            display: flex !important;
        }
        .modal-content {
            background: #ffffff !important;
            width: 100% !important;
            max-width: 620px !important;
            max-height: calc(100vh - 40px) !important;
            border-radius: 12px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            margin: auto !important;
        }
        .modal-content form {
            display: flex !important;
            flex-direction: column !important;
            flex: 1 !important;
            min-height: 0 !important;
            overflow: hidden !important;
            margin: 0 !important;
        }
        .modal-header {
            flex-shrink: 0 !important;
            padding: 16px 24px !important;
            border-bottom: 1px solid #e2e8f0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #ffffff !important;
        }
        .modal-header h2 {
            margin: 0 !important;
            font-size: 1.25rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
        }
        .modal-close {
            width: 32px !important;
            height: 32px !important;
            border-radius: 6px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: none !important;
            background: #f1f5f9 !important;
            color: #64748b !important;
            font-size: 1.25rem !important;
            cursor: pointer !important;
            line-height: 1 !important;
        }
        .modal-close:hover {
            background: #fee2e2 !important;
            color: #ef4444 !important;
        }
        .modal-body {
            flex: 1 1 auto !important;
            min-height: 0 !important;
            overflow-y: auto !important;
            padding: 20px 24px !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 16px !important;
            box-sizing: border-box !important;
        }
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }
        .modal-body::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .modal-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }
        .modal-footer {
            flex-shrink: 0 !important;
            padding: 14px 24px !important;
            border-top: 1px solid #e2e8f0 !important;
            background: #f8fafc !important;
            display: flex !important;
            justify-content: flex-end !important;
            align-items: center !important;
            gap: 12px !important;
        }
        .modal-footer .btn {
            padding: 9px 18px !important;
            border-radius: 6px !important;
            font-size: 0.925rem !important;
            font-weight: 600 !important;
            cursor: pointer !important;
        }
        .modal-footer .btn-secondary {
            background: #ffffff !important;
            color: #475569 !important;
            border: 1px solid #cbd5e1 !important;
        }
        .modal-footer .btn-secondary:hover {
            background: #f1f5f9 !important;
        }
        .modal-footer .btn-primary {
            background: #0f766e !important;
            color: #ffffff !important;
            border: none !important;
        }
        .modal-footer .btn-primary:hover {
            background: #115e59 !important;
        }
        .form-row {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 16px !important;
            width: 100% !important;
        }
        @media (max-width: 580px) {
            .form-row {
                grid-template-columns: 1fr !important;
            }
        }
        .form-group {
            display: flex !important;
            flex-direction: column !important;
            gap: 6px !important;
            width: 100% !important;
        }
        .form-group label {
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            margin: 0 !important;
        }
        .form-control {
            width: 100% !important;
            padding: 9px 12px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 6px !important;
            font-size: 0.925rem !important;
            color: #0f172a !important;
            background: #ffffff !important;
            box-sizing: border-box !important;
        }
        .form-control:focus {
            border-color: #0f766e !important;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15) !important;
            outline: none !important;
        }
        textarea.form-control {
            min-height: 70px !important;
            resize: vertical !important;
        }
    </style>
</head>
<body>

    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <img src="../assets/images/San Jose Logo 2.png" alt="Logo">
                <h2 style="color: #fbbf24;">Admin Panel</h2>
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
                    <a href="announcement.php" class="active">
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
                <h1>Manage Announcements</h1>
                <div class="header-user-profile">
                    <div class="user-text">
                        <span class="user-name">System Admin</span>
                        <span class="user-role">Administrator</span>
                    </div>
                    <div class="user-avatar">A</div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="admin-content">

                <?php if (isset($_GET['added']) && $_GET['added'] == 1): ?>
                    <div style="background-color: #d1fae5; color: #065f46; padding: 12px 16px; margin-bottom: 20px; border-radius: 6px; border-left: 4px solid #10b981; display: flex; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 10px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <strong>Success!</strong>&nbsp; New announcement has been successfully published.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
                    <div style="background-color: #d1fae5; color: #065f46; padding: 12px 16px; margin-bottom: 20px; border-radius: 6px; border-left: 4px solid #10b981; display: flex; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 10px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <strong>Success!</strong>&nbsp; Announcement details have been updated.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
                    <div style="background-color: #fee2e2; color: #991b1b; padding: 12px 16px; margin-bottom: 20px; border-radius: 6px; border-left: 4px solid #ef4444; display: flex; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 10px;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        <strong>Deleted!</strong>&nbsp; Announcement has been removed.
                    </div>
                <?php endif; ?>

                <div class="content-header d-flex justify-content-between align-items-center" style="margin-bottom: 1.5rem;">
                    <h2 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text, #1C1917);">Announcements & Updates</h2>
                    <button id="addAnnouncementBtn" class="btn btn-primary" style="display: flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; padding: 0.6rem 1.2rem; border-radius: 6px; font-weight: 600;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Add New Announcement
                    </button>
                </div>

                <div class="section-panel">
                    <div class="panel-table-wrapper">
                        <table class="panel-table">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>What / Who</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($announcements)): ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 30px; color: #94a3b8;">
                                            No announcements found. Click "Add New Announcement" to post your first update.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($announcements as $row): ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($row['cover_image'])): ?>
                                                <img src="../<?= htmlspecialchars($row['cover_image']) ?>" alt="Cover" class="announcement-thumb">
                                            <?php else: ?>
                                                <div class="thumb-placeholder">None</div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="date-cell">
                                            <strong><?= date('M d, Y', strtotime($row['event_date'])) ?></strong>
                                            <?php if (!empty($row['when_time'])): ?>
                                                <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                                                    <?= htmlspecialchars($row['when_time']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong><?= htmlspecialchars($row['title']) ?></strong></td>
                                        <td class="description-cell" title="<?= htmlspecialchars(($row['what_desc'] ?? '') . ' | ' . ($row['who_target'] ?? '')) ?>">
                                            <?= htmlspecialchars(!empty($row['what_desc']) ? $row['what_desc'] : ($row['why_desc'] ?? 'No summary available')) ?>
                                            <?php if (!empty($row['who_target'])): ?>
                                                <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                                                    For: <?= htmlspecialchars($row['who_target']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] === 'Published'): ?>
                                                <span class="badge badge-active">Published</span>
                                            <?php else: ?>
                                                <span class="badge badge-draft">Draft</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn-action edit-btn edit-announcement-btn"
                                                data-id="<?= htmlspecialchars($row['id']) ?>"
                                                data-title="<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>"
                                                data-date="<?= htmlspecialchars($row['event_date']) ?>"
                                                data-who="<?= htmlspecialchars($row['who_target'] ?? '', ENT_QUOTES) ?>"
                                                data-when="<?= htmlspecialchars($row['when_time'] ?? '', ENT_QUOTES) ?>"
                                                data-what="<?= htmlspecialchars($row['what_desc'] ?? '', ENT_QUOTES) ?>"
                                                data-why="<?= htmlspecialchars($row['why_desc'] ?? '', ENT_QUOTES) ?>"
                                                data-extra="<?= htmlspecialchars($row['extra_desc'] ?? '', ENT_QUOTES) ?>"
                                                data-status="<?= htmlspecialchars($row['status']) ?>"
                                                style="border: none; cursor: pointer;">
                                                Edit
                                            </button>
                                            <form method="POST" action="" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="delete_id" value="<?= htmlspecialchars($row['id']) ?>">
                                                <button type="submit" class="btn-action delete-btn" style="border: none; cursor: pointer;">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Add Announcement Modal -->
    <div id="announcementModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Announcement</h2>
                <button type="button" class="modal-close">&times;</button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="modal-body custom-scrollbar">
                    <div class="form-group">
                        <label>Announcement Title *</label>
                        <input type="text" name="title" required placeholder="e.g., Upcoming Medical Mission" class="form-control">
                    </div>

                    <div class="form-row">
                        <div class="form-group half-width">
                            <label>Event Date *</label>
                            <input type="date" name="event_date" required value="<?= date('Y-m-d') ?>" class="form-control">
                        </div>
                        <div class="form-group half-width">
                            <label>When / Time Details</label>
                            <input type="text" name="when_time" placeholder="e.g., 9:00 AM - 12:00 PM" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Cover Image (Optional)</label>
                        <input type="file" name="cover_image" accept="image/*" class="form-control file-input">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group half-width">
                            <label>Who (Target Audience)</label>
                            <input type="text" name="who_target" placeholder="e.g., All residents of Barangay San Jose" class="form-control">
                        </div>
                        <div class="form-group half-width">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="Published" selected>Published</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>What (Subject / Activity)</label>
                        <input type="text" name="what_desc" placeholder="e.g., Free Medical & Dental Check-ups" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Why (Purpose)</label>
                        <textarea name="why_desc" placeholder="e.g., To provide accessible healthcare services to those in need." rows="2" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Additional Details / Instructions</label>
                        <textarea name="extra_desc" placeholder="e.g., Please bring a valid ID and PhilHealth card if available." rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal-cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary">Publish Announcement</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Announcement Modal -->
    <div id="editAnnouncementModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Announcement</h2>
                <button type="button" class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="edit_id" id="edit_id">
                <div class="modal-body custom-scrollbar">
                    <div class="form-group">
                        <label>Announcement Title *</label>
                        <input type="text" name="edit_title" id="edit_title" required class="form-control">
                    </div>

                    <div class="form-row">
                        <div class="form-group half-width">
                            <label>Event Date *</label>
                            <input type="date" name="edit_event_date" id="edit_event_date" required class="form-control">
                        </div>
                        <div class="form-group half-width">
                            <label>When / Time Details</label>
                            <input type="text" name="edit_when_time" id="edit_when_time" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Change Cover Image (Optional)</label>
                        <input type="file" name="edit_cover_image" accept="image/*" class="form-control file-input">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group half-width">
                            <label>Who (Target Audience)</label>
                            <input type="text" name="edit_who_target" id="edit_who_target" class="form-control">
                        </div>
                        <div class="form-group half-width">
                            <label>Status</label>
                            <select name="edit_status" id="edit_status" class="form-control">
                                <option value="Published">Published</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>What (Subject / Activity)</label>
                        <input type="text" name="edit_what_desc" id="edit_what_desc" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Why (Purpose)</label>
                        <textarea name="edit_why_desc" id="edit_why_desc" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Additional Details / Instructions</label>
                        <textarea name="edit_extra_desc" id="edit_extra_desc" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/dashboard.js"></script>
    <script>
    function closeEditModal() {
        const modal = document.getElementById('editAnnouncementModal');
        if (modal) modal.classList.remove('show');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const editBtns = document.querySelectorAll('.edit-announcement-btn');
        const editModal = document.getElementById('editAnnouncementModal');

        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_id').value = this.getAttribute('data-id');
                document.getElementById('edit_title').value = this.getAttribute('data-title');
                document.getElementById('edit_event_date').value = this.getAttribute('data-date');
                document.getElementById('edit_when_time').value = this.getAttribute('data-when');
                document.getElementById('edit_who_target').value = this.getAttribute('data-who');
                document.getElementById('edit_what_desc').value = this.getAttribute('data-what');
                document.getElementById('edit_why_desc').value = this.getAttribute('data-why');
                document.getElementById('edit_extra_desc').value = this.getAttribute('data-extra');
                document.getElementById('edit_status').value = this.getAttribute('data-status');

                if (editModal) {
                    editModal.classList.add('show');
                }
            });
        });

        if (editModal) {
            editModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeEditModal();
                }
            });
        }
    });
    </script>
</body>
</html>
