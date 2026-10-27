<?php
// Manage Services - Barangay San Jose Web Based Information System
require_once __DIR__ . '/../services_db.php';

// Handle Form Actions
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $action = $_POST['action'] ?? '';

    // File upload handler
    $handleUpload = function() {
        if (!isset($_FILES['serviceDocument']) || $_FILES['serviceDocument']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        $file = $_FILES['serviceDocument'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        if (!in_array($ext, $allowed)) {
            return false; // Invalid extension
        }
        $uploadDir = dirname(__DIR__) . '/uploads/documents/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = time() . '_' . uniqid() . '.' . $ext;
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return 'uploads/documents/' . $filename;
        }
        return false;
    };

    // 1. Add Service
    if ($action === 'add_service') {
        $docFilePath = null;
        if (isset($_FILES['serviceDocument']) && $_FILES['serviceDocument']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = $handleUpload();
            if ($uploadResult === false) {
                header("Location: service.php?msg=invalid_file");
                exit;
            }
            $docFilePath = $uploadResult;
        }

        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'requirements' => trim($_POST['requirements'] ?? ''),
            'document_file' => $docFilePath,
            'fee' => trim($_POST['fee'] ?? 'Free'),
            'processing_time' => trim($_POST['processing_time'] ?? 'Same Day'),
            'icon' => trim($_POST['icon'] ?? 'document'),
            'status' => $_POST['status'] ?? 'active',
            'btn_text' => trim($_POST['btn_text'] ?? 'Request Document'),
            'btn_link' => trim($_POST['btn_link'] ?? 'contact.php'),
            'display_order' => intval($_POST['display_order'] ?? 0)
        ];

        if (!empty($data['title'])) {
            add_service($conn, $data);
            header("Location: service.php?msg=created");
            exit;
        } else {
            if ($docFilePath) {
                delete_service_document_file($docFilePath);
            }
            header("Location: service.php?msg=empty_title");
            exit;
        }
    }

    // 2. Edit Service
    if ($action === 'edit_service') {
        $id = intval($_POST['service_id'] ?? 0);
        $curr = get_service_by_id($conn, $id);
        if (!$curr) {
            header("Location: service.php?msg=error");
            exit;
        }

        $removeDoc = ($_POST['removeDocument'] ?? '0') === '1';
        $docFilePath = $curr['document_file'] ?? null;

        // If admin requested removal of the existing document
        if ($removeDoc && !empty($docFilePath)) {
            delete_service_document_file($docFilePath);
            $docFilePath = null;
        }

        // If a new file is uploaded
        if (isset($_FILES['serviceDocument']) && $_FILES['serviceDocument']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = $handleUpload();
            if ($uploadResult === false) {
                header("Location: service.php?msg=invalid_file");
                exit;
            }
            // Remove old file when replacing
            if (!empty($docFilePath)) {
                delete_service_document_file($docFilePath);
            }
            $docFilePath = $uploadResult;
        }

        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'requirements' => trim($_POST['requirements'] ?? ''),
            'document_file' => $docFilePath,
            'fee' => trim($_POST['fee'] ?? 'Free'),
            'processing_time' => trim($_POST['processing_time'] ?? 'Same Day'),
            'icon' => trim($_POST['icon'] ?? 'document'),
            'status' => $_POST['status'] ?? 'active',
            'btn_text' => trim($_POST['btn_text'] ?? 'Request Document'),
            'btn_link' => trim($_POST['btn_link'] ?? 'contact.php'),
            'display_order' => intval($_POST['display_order'] ?? 0)
        ];

        if ($id > 0 && !empty($data['title'])) {
            update_service($conn, $id, $data);
            header("Location: service.php?msg=updated");
            exit;
        } else {
            header("Location: service.php?msg=error");
            exit;
        }
    }

    // 3. Delete Service
    if ($action === 'delete_service') {
        $id = intval($_POST['service_id'] ?? 0);
        if ($id > 0) {
            delete_service($conn, $id);
            header("Location: service.php?msg=deleted");
            exit;
        }
    }

    // 4. Toggle Status
    if ($action === 'toggle_status') {
        $id = intval($_POST['service_id'] ?? 0);
        if ($id > 0) {
            toggle_service_status($conn, $id);
            header("Location: service.php?msg=status_changed");
            exit;
        }
    }
}

// Fetch all services from DB
$services = get_all_services($conn);
$totalServices = count($services);
$activeCount = 0;
foreach ($services as $s) {
    if ($s['status'] === 'active') {
        $activeCount++;
    }
}
$inactiveCount = $totalServices - $activeCount;

// Flash messages
$msg = $_GET['msg'] ?? '';
$alert_text = '';
$alert_type = 'success';

if ($msg === 'created') $alert_text = 'Service added successfully and is now live!';
if ($msg === 'updated') $alert_text = 'Service details updated successfully!';
if ($msg === 'deleted') $alert_text = 'Service deleted successfully!';
if ($msg === 'status_changed') $alert_text = 'Service status toggled successfully!';
if ($msg === 'invalid_file') { $alert_text = 'Invalid document format. Allowed extensions: PDF, DOC, DOCX, JPG, JPEG, PNG.'; $alert_type = 'error'; }
if ($msg === 'empty_title') { $alert_text = 'Service title is required.'; $alert_type = 'error'; }
if ($msg === 'error') { $alert_text = 'An error occurred while saving the service.'; $alert_type = 'error'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services - Admin Panel</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="../assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/service.css?v=<?= time() ?>">
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
                    <a href="service.php" class="active">
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
                <h1>Manage Services</h1>
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

                <!-- Alert Message -->
                <?php if (!empty($alert_text)): ?>
                    <div class="alert-banner <?= $alert_type === 'error' ? 'alert-error' : 'alert-success' ?>">
                        <div class="alert-icon">
                            <?php if ($alert_type === 'error'): ?>
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <?php else: ?>
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            <?php endif; ?>
                        </div>
                        <span class="alert-text"><?= htmlspecialchars($alert_text) ?></span>
                        <button class="alert-dismiss" onclick="this.parentElement.remove();">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- Top Header & Action Buttons -->
                <div class="content-header d-flex justify-content-between align-items-center" style="margin-bottom: 1.5rem; background: #ffffff; padding: 1.25rem 1.75rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.04); flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h2 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #0f172a; letter-spacing: -0.01em;">Barangay Services Directory</h2>
                        <p style="margin: 0.35rem 0 0; color: #64748b; font-size: 0.92rem;">Control the documents and assistance programs displayed to residents on the public Services page.</p>
                    </div>
                    <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                        <a href="../services.php" target="_blank" class="btn-view-public" title="Preview public services page">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                            View Public Page
                        </a>
                        <button id="addServiceBtn" class="btn-primary" onclick="openAddServiceModal();">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            + Add New Service
                        </button>
                    </div>
                </div>

                <!-- KPI / Stats Summary Row -->
                <div class="services-stats-row">
                    <div class="service-stat-card">
                        <div class="stat-icon-wrapper stat-icon-total">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        </div>
                        <div class="stat-details">
                            <span class="stat-number"><?= $totalServices ?></span>
                            <span class="stat-label">Total Services</span>
                        </div>
                    </div>
                    <div class="service-stat-card">
                        <div class="stat-icon-wrapper stat-icon-active">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <div class="stat-details">
                            <span class="stat-number"><?= $activeCount ?></span>
                            <span class="stat-label">Active / Live Online</span>
                        </div>
                    </div>
                    <div class="service-stat-card">
                        <div class="stat-icon-wrapper stat-icon-inactive">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                        </div>
                        <div class="stat-details">
                            <span class="stat-number"><?= $inactiveCount ?></span>
                            <span class="stat-label">Inactive / Hidden</span>
                        </div>
                    </div>
                </div>

                <!-- Services Table Section -->
                <div class="section-panel">
                    <div class="panel-table-wrapper">
                        <table class="panel-table">
                            <thead>
                                <tr>
                                    <th style="width: 60px; text-align: center;">Icon</th>
                                    <th>Service Name &amp; Details</th>
                                    <th>Description</th>
                                    <th>Requirements</th>
                                    <th style="text-align: center;">Document File</th>
                                    <th style="text-align: center;">Order</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($services)): ?>
                                    <tr>
                                        <td colspan="8" class="empty-table-state">
                                            <div class="empty-state-icon-box">
                                                <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                            </div>
                                            <h3 style="margin: 0 0 0.5rem; font-size: 1.15rem; color: #0f172a; font-weight: 700;">No services found</h3>
                                            <p style="margin: 0 0 1.25rem; color: #64748b; font-size: 0.9rem;">Click "+ Add New Service" to create your first barangay service.</p>
                                            <button type="button" class="btn-primary" onclick="openAddServiceModal();">+ Add New Service</button>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($services as $srv): ?>
                                        <tr>
                                            <td class="service-icon-col">
                                                <div class="service-icon" title="Icon: <?= htmlspecialchars($srv['icon']) ?>">
                                                    <?= get_service_icon_svg($srv['icon'], 22, 22) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="service-main-cell">
                                                    <span class="service-title-text"><?= htmlspecialchars($srv['title']) ?></span>
                                                    <div class="service-chips">
                                                        <?php if (!empty($srv['fee'])): ?>
                                                             <span class="service-chip chip-fee" title="Service Fee">₱ <?= htmlspecialchars($srv['fee']) ?></span>
                                                        <?php endif; ?>
                                                        <?php if (!empty($srv['processing_time'])): ?>
                                                            <span class="service-chip chip-time" title="Processing Time">⏱ <?= htmlspecialchars($srv['processing_time']) ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="description-cell" title="<?= htmlspecialchars($srv['description']) ?>">
                                                <?= htmlspecialchars($srv['description']) ?>
                                            </td>
                                            <td class="reqs-cell">
                                                <?php if (!empty($srv['requirements'])): ?>
                                                    <span title="<?= htmlspecialchars($srv['requirements']) ?>"><?= htmlspecialchars($srv['requirements']) ?></span>
                                                <?php else: ?>
                                                    <span style="color: #cbd5e1; font-style: italic;">None specified</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php if (!empty($srv['document_file'])): ?>
                                                    <a href="../<?= htmlspecialchars($srv['document_file']) ?>" download target="_blank" class="badge badge-doc-file" title="Download <?= htmlspecialchars(basename($srv['document_file'])) ?>">
                                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 4px; vertical-align: -1px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                                        Ready File
                                                    </a>
                                                <?php else: ?>
                                                    <span style="color: #94a3b8; font-style: italic; font-size: 0.85rem;">No file</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="service-chip chip-order"><?= $srv['display_order'] ?></span>
                                            </td>
                                            <td style="text-align: center;">
                                                <form action="service.php" method="POST" style="margin: 0; display: inline;">
                                                    <input type="hidden" name="action" value="toggle_status">
                                                    <input type="hidden" name="service_id" value="<?= $srv['id'] ?>">
                                                    <button type="submit" class="badge <?= $srv['status'] === 'active' ? 'badge-active' : 'badge-inactive' ?>" title="Click to toggle status">
                                                        <span class="badge-dot"></span>
                                                        <?= ucfirst($srv['status']) ?>
                                                    </button>
                                                </form>
                                            </td>
                                            <td style="text-align: center;">
                                                <div class="action-buttons-wrap" style="justify-content: center;">
                                                    <button type="button" class="btn-action edit-btn" onclick='openEditServiceModal(<?= json_encode($srv, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>);'>
                                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                        Edit
                                                    </button>
                                                    <form action="service.php" method="POST" onsubmit="return confirm('Are you sure you want to delete service &quot;<?= htmlspecialchars(addslashes($srv['title'])) ?>&quot;?');" style="margin: 0; display: inline;">
                                                        <input type="hidden" name="action" value="delete_service">
                                                        <input type="hidden" name="service_id" value="<?= $srv['id'] ?>">
                                                        <button type="submit" class="btn-action delete-btn">
                                                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
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

    <!-- Unified Add / Edit Service Modal -->
    <div id="serviceModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#0d2847" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    <span id="modalHeaderTitle">Add New Service</span>
                </h2>
                <button type="button" class="modal-close" onclick="closeServiceModal();">&times;</button>
            </div>
            <form id="serviceForm" action="service.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="formAction" value="add_service">
                <input type="hidden" name="service_id" id="serviceId" value="">
                <input type="hidden" name="removeDocument" id="editRemoveDocument" value="0">

                <div class="modal-body custom-scrollbar">
                    <!-- Service Title -->
                    <div class="form-group">
                        <label for="serviceTitle">Service Name <span class="required-star">*</span></label>
                        <input type="text" id="serviceTitle" name="title" placeholder="e.g., Barangay Clearance, Certificate of Indigency" required class="form-control" autofocus>
                    </div>

                    <!-- Row: Icon & Status -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="serviceIcon">Service Icon <span class="required-star">*</span></label>
                            <select id="serviceIcon" name="icon" class="form-control" required>
                                <option value="document">📄 Document / Clearance</option>
                                <option value="home">🏠 Home / Indigency</option>
                                <option value="briefcase">💼 Business / Permit</option>
                                <option value="id-card">🪪 ID Card / Residency</option>
                                <option value="heart-pulse">❤️ Medical / Health</option>
                                <option value="shield">🛡️ Peace &amp; Order / Blotter</option>
                                <option value="users">👥 Community / Assistance</option>
                                <option value="award">🏆 Certificate / Award</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="serviceStatus">Status <span class="required-star">*</span></label>
                            <select id="serviceStatus" name="status" class="form-control" required>
                                <option value="active">Active (Visible to public)</option>
                                <option value="inactive">Inactive (Hidden)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row: Fee & Processing Time -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="serviceFee">Fee / Cost</label>
                            <input type="text" id="serviceFee" name="fee" placeholder="e.g., Free, ₱50.00, ₱100.00" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="serviceProcessingTime">Processing Time</label>
                            <input type="text" id="serviceProcessingTime" name="processing_time" placeholder="e.g., 15-30 Minutes, Same Day" class="form-control">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="serviceDescription">Description <span class="required-star">*</span></label>
                        <textarea id="serviceDescription" name="description" placeholder="Brief description of the service and its purpose..." rows="3" required class="form-control"></textarea>
                    </div>

                    <!-- Requirements -->
                    <div class="form-group">
                        <label for="serviceRequirements">Requirements (Optional)</label>
                        <textarea id="serviceRequirements" name="requirements" placeholder="e.g., Valid Government ID, Cedula, Purok Certification" rows="2" class="form-control"></textarea>
                        <small class="form-help">List the required documents or qualifications needed by the resident.</small>
                    </div>

                    <!-- Ready-Made Document Template Upload -->
                    <div class="form-group document-upload-group" style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 1.1rem; margin-bottom: 1.25rem;">
                        <label for="serviceDocumentInput" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; font-weight: 700; color: #1e293b;">
                            <span style="display: inline-flex; align-items: center; gap: 0.45rem;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#2563eb" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                                Attach Document Template (Ready-Made Form)
                            </span>
                            <span style="font-size: 0.75rem; font-weight: 600; color: #64748b; background: #e2e8f0; padding: 2px 8px; border-radius: 999px;">PDF, DOC, DOCX, JPG, PNG</span>
                        </label>

                        <!-- Existing Attached Document Preview Box -->
                        <div id="existingDocBox" style="display: none; align-items: center; justify-content: space-between; background: #ffffff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 0.75rem 1rem; margin-bottom: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 0.6rem; overflow: hidden;">
                                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#059669" stroke-width="2" style="flex-shrink: 0;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><polyline points="9 15 12 18 15 15"></polyline></svg>
                                <div style="display: flex; flex-direction: column; overflow: hidden;">
                                    <span id="existingDocName" style="font-size: 0.88rem; font-weight: 700; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 260px;">document.pdf</span>
                                    <a id="existingDocLink" href="#" target="_blank" download style="font-size: 0.8rem; color: #2563eb; text-decoration: underline; font-weight: 500;">Click to Download / View current file</a>
                                </div>
                            </div>
                            <button type="button" id="removeDocBtn" onclick="removeAttachedDocument();" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; border-radius: 6px; padding: 0.35rem 0.65rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem;">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                Remove File
                            </button>
                        </div>

                        <!-- File Input -->
                        <input type="file" name="serviceDocument" id="serviceDocumentInput" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="form-control" style="background: #ffffff; padding: 0.5rem 0.75rem;">
                        <small class="form-help" style="margin-top: 0.4rem; display: block; color: #64748b; font-size: 0.8rem;">
                            Upload a blank form/template. Citizens will be able to directly download or print this document from the public services page.
                        </small>
                    </div>

                    <!-- Row: Button Text & Link -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="serviceBtnText">Action Button Text</label>
                            <input type="text" id="serviceBtnText" name="btn_text" placeholder="e.g., Request Document" value="Request Document" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="serviceBtnLink">Button Destination URL</label>
                            <input type="text" id="serviceBtnLink" name="btn_link" placeholder="e.g., contact.php" value="contact.php" class="form-control">
                        </div>
                    </div>

                    <!-- Display Order -->
                    <div class="form-group">
                        <label for="serviceDisplayOrder">Display Order</label>
                        <input type="number" id="serviceDisplayOrder" name="display_order" placeholder="e.g., 1, 2, 3..." value="0" min="0" class="form-control">
                        <small class="form-help">Lower numbers appear first on the public services list.</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeServiceModal();">Cancel</button>
                    <button type="submit" id="saveServiceSubmitBtn" class="btn-primary">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Service
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/dashboard.js"></script>
    <script>
        const modal = document.getElementById('serviceModal');
        const form = document.getElementById('serviceForm');

        function openAddServiceModal() {
            form.reset();
            document.getElementById('formAction').value = 'add_service';
            document.getElementById('serviceId').value = '';
            document.getElementById('editRemoveDocument').value = '0';
            document.getElementById('serviceDocumentInput').value = '';
            document.getElementById('existingDocBox').style.display = 'none';
            document.getElementById('modalHeaderTitle').textContent = 'Add New Service';
            document.getElementById('saveServiceSubmitBtn').innerHTML = `
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Add Service
            `;
            document.getElementById('serviceBtnText').value = 'Request Document';
            document.getElementById('serviceBtnLink').value = 'contact.php';
            document.getElementById('serviceDisplayOrder').value = '<?= $totalServices + 1 ?>';
            modal.style.display = 'flex';
            setTimeout(() => document.getElementById('serviceTitle').focus(), 50);
        }

        function openEditServiceModal(service) {
            form.reset();
            document.getElementById('formAction').value = 'edit_service';
            document.getElementById('serviceId').value = service.id || '';
            document.getElementById('editRemoveDocument').value = '0';
            document.getElementById('serviceDocumentInput').value = '';
            document.getElementById('modalHeaderTitle').textContent = 'Edit Service';
            document.getElementById('saveServiceSubmitBtn').innerHTML = `
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Save Changes
            `;

            document.getElementById('serviceTitle').value = service.title || '';
            document.getElementById('serviceIcon').value = service.icon || 'document';
            document.getElementById('serviceStatus').value = service.status || 'active';
            document.getElementById('serviceFee').value = service.fee || '';
            document.getElementById('serviceProcessingTime').value = service.processing_time || '';
            document.getElementById('serviceDescription').value = service.description || '';
            document.getElementById('serviceRequirements').value = service.requirements || '';
            document.getElementById('serviceBtnText').value = service.btn_text || 'Request Document';
            document.getElementById('serviceBtnLink').value = service.btn_link || 'contact.php';
            document.getElementById('serviceDisplayOrder').value = service.display_order || '0';

            // Document Preview Handling
            const existingDocBox = document.getElementById('existingDocBox');
            const existingDocName = document.getElementById('existingDocName');
            const existingDocLink = document.getElementById('existingDocLink');

            if (service.document_file && service.document_file.trim() !== '') {
                const rawPath = service.document_file.trim();
                const parts = rawPath.split('/');
                const fname = parts[parts.length - 1];
                existingDocName.textContent = fname;
                existingDocLink.href = '../' + rawPath;
                existingDocBox.style.display = 'flex';
            } else {
                existingDocBox.style.display = 'none';
            }

            modal.style.display = 'flex';
            setTimeout(() => document.getElementById('serviceTitle').focus(), 50);
        }

        function removeAttachedDocument() {
            document.getElementById('editRemoveDocument').value = '1';
            document.getElementById('existingDocBox').style.display = 'none';
            document.getElementById('serviceDocumentInput').value = '';
        }

        // If user selects a new file, reset removeDocument flag
        document.getElementById('serviceDocumentInput').addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                document.getElementById('editRemoveDocument').value = '0';
            }
        });

        function closeServiceModal() {
            modal.style.display = 'none';
        }

        // Close on clicking backdrop
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeServiceModal();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.style.display === 'flex') {
                closeServiceModal();
            }
        });
    </script>
</body>
</html>
