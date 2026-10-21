<?php
// Manage Media Gallery - Folder & Media Management
require_once __DIR__ . '/../db_connect.php';

// Ensure tables exist
$conn->query("CREATE TABLE IF NOT EXISTS `gallery_folders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `folder_name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

$conn->query("CREATE TABLE IF NOT EXISTS `gallery_media` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `folder_id` INT(11) NOT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `caption` VARCHAR(255) DEFAULT NULL,
  `uploaded_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `folder_id` (`folder_id`),
  CONSTRAINT `fk_gallery_folder` FOREIGN KEY (`folder_id`) REFERENCES `gallery_folders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

// Ensure upload directory exists
$upload_dir = __DIR__ . '/../assets/images/gallery/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // 1. Create Folder
    if ($action === 'create_folder') {
        $folder_name = trim($_POST['folder_name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (!empty($folder_name)) {
            $stmt = $conn->prepare("INSERT INTO gallery_folders (folder_name, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $folder_name, $description);
            $stmt->execute();
            $stmt->close();
            header("Location: mediagallery.php?msg=folder_created");
            exit;
        } else {
            header("Location: mediagallery.php?msg=empty_name");
            exit;
        }
    }

    // 2. Delete Folder
    if ($action === 'delete_folder') {
        $folder_id = intval($_POST['folder_id'] ?? 0);
        if ($folder_id > 0) {
            // Delete associated image files on disk
            $media_stmt = $conn->prepare("SELECT file_path FROM gallery_media WHERE folder_id = ?");
            $media_stmt->bind_param("i", $folder_id);
            $media_stmt->execute();
            $result = $media_stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $file_to_delete = __DIR__ . '/../' . $row['file_path'];
                if (file_exists($file_to_delete) && is_file($file_to_delete)) {
                    unlink($file_to_delete);
                }
            }
            $media_stmt->close();

            // Delete folder record (cascade removes media records)
            $del_stmt = $conn->prepare("DELETE FROM gallery_folders WHERE id = ?");
            $del_stmt->bind_param("i", $folder_id);
            $del_stmt->execute();
            $del_stmt->close();

            header("Location: mediagallery.php?msg=folder_deleted");
            exit;
        }
    }

    // 3. Upload Media into Folder
    if ($action === 'upload_media') {
        $folder_id = intval($_POST['folder_id'] ?? 0);
        $folder_select_val = $_POST['folder_id'] ?? '';
        $new_folder_name = trim($_POST['new_folder_name'] ?? '');
        $new_folder_desc = trim($_POST['new_folder_desc'] ?? '');
        $caption = trim($_POST['caption'] ?? '');

        // If creating a new folder on the fly
        if ($folder_select_val === 'new' || (!empty($new_folder_name) && $folder_id <= 0)) {
            if (!empty($new_folder_name)) {
                $nf_stmt = $conn->prepare("INSERT INTO gallery_folders (folder_name, description) VALUES (?, ?)");
                $nf_stmt->bind_param("ss", $new_folder_name, $new_folder_desc);
                if ($nf_stmt->execute()) {
                    $folder_id = $conn->insert_id;
                }
                $nf_stmt->close();
            } else {
                header("Location: mediagallery.php?msg=empty_name");
                exit;
            }
        }

        if ($folder_id <= 0) {
            header("Location: mediagallery.php?msg=no_folder");
            exit;
        }

        // Verify folder actually exists
        $chk_stmt = $conn->prepare("SELECT id FROM gallery_folders WHERE id = ?");
        $chk_stmt->bind_param("i", $folder_id);
        $chk_stmt->execute();
        $chk_res = $chk_stmt->get_result();
        if ($chk_res->num_rows === 0) {
            $chk_stmt->close();
            header("Location: mediagallery.php?msg=folder_not_found");
            exit;
        }
        $chk_stmt->close();

        if (isset($_FILES['media_files'])) {
            $files = $_FILES['media_files'];
            $file_count = is_array($files['name']) ? count($files['name']) : 0;
            $uploaded_count = 0;

            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            for ($i = 0; $i < $file_count; $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $original_name = basename($files['name'][$i]);
                    $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

                    if (in_array($ext, $allowed_exts)) {
                        $new_filename = time() . '_' . uniqid() . '.' . $ext;
                        $destination = $upload_dir . $new_filename;

                        if (move_uploaded_file($files['tmp_name'][$i], $destination)) {
                            $db_path = 'assets/images/gallery/' . $new_filename;
                            $img_caption = !empty($caption) ? $caption : pathinfo($original_name, PATHINFO_FILENAME);

                            $ins_stmt = $conn->prepare("INSERT INTO gallery_media (folder_id, file_name, file_path, caption) VALUES (?, ?, ?, ?)");
                            $ins_stmt->bind_param("isss", $folder_id, $original_name, $db_path, $img_caption);
                            $ins_stmt->execute();
                            $ins_stmt->close();
                            $uploaded_count++;
                        }
                    }
                }
            }

            if ($uploaded_count > 0) {
                header("Location: mediagallery.php?folder_id=" . $folder_id . "&msg=media_uploaded&count=" . $uploaded_count);
                exit;
            } else {
                header("Location: mediagallery.php?folder_id=" . $folder_id . "&msg=upload_failed");
                exit;
            }
        } else {
            header("Location: mediagallery.php?folder_id=" . $folder_id . "&msg=upload_failed");
            exit;
        }
    }

    // 4. Delete Individual Media
    if ($action === 'delete_media') {
        $media_id = intval($_POST['media_id'] ?? 0);
        $folder_id = intval($_POST['folder_id'] ?? 0);

        if ($media_id > 0) {
            $sel_stmt = $conn->prepare("SELECT file_path FROM gallery_media WHERE id = ?");
            $sel_stmt->bind_param("i", $media_id);
            $sel_stmt->execute();
            $res = $sel_stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $file_to_delete = __DIR__ . '/../' . $row['file_path'];
                if (file_exists($file_to_delete) && is_file($file_to_delete)) {
                    unlink($file_to_delete);
                }
            }
            $sel_stmt->close();

            $del_stmt = $conn->prepare("DELETE FROM gallery_media WHERE id = ?");
            $del_stmt->bind_param("i", $media_id);
            $del_stmt->execute();
            $del_stmt->close();

            header("Location: mediagallery.php?folder_id=" . $folder_id . "&msg=media_deleted");
            exit;
        }
    }
}

// Check Current View State
$active_folder_id = isset($_GET['folder_id']) ? intval($_GET['folder_id']) : 0;
$current_folder = null;
$folder_media = [];

// Always load all folders for dropdown selector in upload modal and root view
$folders_query = "SELECT f.*, COUNT(m.id) AS media_count 
                  FROM gallery_folders f 
                  LEFT JOIN gallery_media m ON f.id = m.folder_id 
                  GROUP BY f.id 
                  ORDER BY f.created_at DESC";
$folders_result = $conn->query($folders_query);
$all_folders = [];
if ($folders_result) {
    while ($row = $folders_result->fetch_assoc()) {
        $all_folders[] = $row;
    }
}

if ($active_folder_id > 0) {
    // Inner Folder View
    $f_stmt = $conn->prepare("SELECT * FROM gallery_folders WHERE id = ?");
    $f_stmt->bind_param("i", $active_folder_id);
    $f_stmt->execute();
    $f_res = $f_stmt->get_result();
    $current_folder = $f_res->fetch_assoc();
    $f_stmt->close();

    if ($current_folder) {
        $m_stmt = $conn->prepare("SELECT * FROM gallery_media WHERE folder_id = ? ORDER BY uploaded_at DESC");
        $m_stmt->bind_param("i", $active_folder_id);
        $m_stmt->execute();
        $m_res = $m_stmt->get_result();
        while ($row = $m_res->fetch_assoc()) {
            $folder_media[] = $row;
        }
        $m_stmt->close();
    } else {
        header("Location: mediagallery.php?msg=folder_not_found");
        exit;
    }
}

// Success & error message banner
$msg = $_GET['msg'] ?? '';
$alert_text = '';
$alert_type = 'success';

if ($msg === 'folder_created') $alert_text = 'Folder created successfully! You can now upload photos to it.';
if ($msg === 'folder_deleted') $alert_text = 'Folder and all contained photos have been deleted.';
if ($msg === 'empty_name') { $alert_text = 'Folder name cannot be blank.'; $alert_type = 'error'; }
if ($msg === 'no_folder') { $alert_text = 'Please select or create a destination folder for your images.'; $alert_type = 'error'; }
if ($msg === 'media_uploaded') {
    $count = intval($_GET['count'] ?? 1);
    $alert_text = $count . ($count > 1 ? ' photos uploaded successfully!' : ' photo uploaded successfully!');
}
if ($msg === 'media_deleted') $alert_text = 'Photo removed successfully.';
if ($msg === 'upload_failed') { $alert_text = 'Failed to upload images. Please make sure they are valid image files (JPG, PNG, WEBP, GIF).'; $alert_type = 'error'; }
if ($msg === 'folder_not_found') { $alert_text = 'The requested folder could not be found.'; $alert_type = 'error'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $current_folder ? htmlspecialchars($current_folder['folder_name']) . ' - ' : '' ?>Manage Media Gallery - Admin Panel</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="../assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Stylesheets with Cache Busting -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/mediagallery.css?v=<?= time() ?>">

    <!-- Embedded Core CSS (guarantees perfect rendering regardless of browser cache) -->
    <style>
        .folders-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)) !important;
            gap: 1.5rem !important;
            margin-top: 1rem !important;
        }
        .folder-card {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
            overflow: hidden !important;
        }
        .folder-card:hover {
            transform: translateY(-5px) !important;
            border-color: #f59e0b !important;
            box-shadow: 0 14px 28px -4px rgba(245, 158, 11, 0.12), 0 4px 8px -2px rgba(0, 0, 0, 0.05) !important;
        }
        .folder-card-body {
            padding: 1.5rem !important;
            display: flex !important;
            flex-direction: column !important;
            text-decoration: none !important;
            color: inherit !important;
            flex: 1 !important;
        }
        .folder-visual-icon {
            width: 58px !important;
            height: 58px !important;
            border-radius: 14px !important;
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%) !important;
            color: #d97706 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-bottom: 1.15rem !important;
            border: 1px solid #fde68a !important;
            transition: all 0.25s ease !important;
            box-shadow: 0 4px 10px rgba(217, 119, 6, 0.1) !important;
        }
        .folder-card:hover .folder-visual-icon {
            transform: scale(1.08) rotate(-2deg) !important;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important;
            box-shadow: 0 6px 14px rgba(217, 119, 6, 0.2) !important;
        }
        .folder-name {
            margin: 0 0 0.45rem 0 !important;
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            letter-spacing: -0.01em !important;
        }
        .folder-desc-text {
            margin: 0 0 1rem 0 !important;
            font-size: 0.88rem !important;
            color: #64748b !important;
            line-height: 1.5 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }
        .folder-meta-row {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            margin-top: auto !important;
            padding-top: 0.75rem !important;
            border-top: 1px dashed #f1f5f9 !important;
        }
        .folder-item-pill {
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.4rem !important;
            background: #f1f5f9 !important;
            color: #334155 !important;
            padding: 0.3rem 0.65rem !important;
            border-radius: 6px !important;
            font-size: 0.82rem !important;
            font-weight: 600 !important;
        }
        .folder-card-footer {
            padding: 0.85rem 1.5rem !important;
            border-top: 1px solid #f1f5f9 !important;
            background: #fafbfd !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }
        .btn-folder-open {
            font-size: 0.88rem !important;
            font-weight: 700 !important;
            color: #0d2847 !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.35rem !important;
            transition: all 0.15s ease !important;
        }
        .btn-folder-open:hover {
            color: #d97706 !important;
            transform: translateX(3px) !important;
        }
        .btn-action-create {
            background: linear-gradient(135deg, #0d2847 0%, #173b64 100%) !important;
            color: #ffffff !important;
            border: none !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 10px !important;
            font-size: 0.95rem !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            box-shadow: 0 4px 10px rgba(13, 40, 71, 0.2) !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }
        .btn-action-create:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 18px rgba(13, 40, 71, 0.28) !important;
        }
        .modal-overlay {
            display: none;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            background-color: rgba(15, 23, 42, 0.65) !important;
            backdrop-filter: blur(6px) !important;
            z-index: 99999 !important;
            justify-content: center !important;
            align-items: center !important;
            padding: 1.5rem !important;
            box-sizing: border-box !important;
        }
        .modal-content {
            background: #ffffff !important;
            border-radius: 16px !important;
            width: 100% !important;
            max-width: 520px !important;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25) !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }
        .btn-upload-quick {
            background: #fffbeb !important;
            border: 1px solid #fde68a !important;
            color: #d97706 !important;
            padding: 0.38rem 0.75rem !important;
            border-radius: 8px !important;
            font-size: 0.8rem !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.35rem !important;
            transition: all 0.2s ease !important;
        }
        .btn-upload-quick:hover {
            background: #fef3c7 !important;
            border-color: #f59e0b !important;
            color: #b45309 !important;
            transform: translateY(-1px) !important;
        }
        .image-preview-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(64px, 1fr)) !important;
            gap: 0.5rem !important;
            margin-top: 0.75rem !important;
            max-height: 150px !important;
            overflow-y: auto !important;
            padding: 0.5rem !important;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
        }
        .image-preview-item {
            aspect-ratio: 1 / 1 !important;
            border-radius: 6px !important;
            overflow: hidden !important;
            border: 1px solid #cbd5e1 !important;
            background: #ffffff !important;
            position: relative !important;
        }
        .image-preview-item img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            display: block !important;
        }
        .file-dropzone.drag-active {
            border-color: #d97706 !important;
            background: #fffbeb !important;
            transform: scale(1.01) !important;
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
                        <li><a href="legend_files.php">Legend Files</a></li>
                        <li><a href="resident1.php">Resident 1</a></li>
                        <li><a href="resident2.php">Resident 2</a></li>
                        <li><a href="resident3.php">Resident 3</a></li>
                        <li><a href="resident4.php">Resident 4</a></li>
                    </ul>
                </li>
                <li>
                    <a href="mediagallery.php" class="active">
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
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </span>
                        Contact
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        </span>
                        Settings
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <h1>Manage Media Gallery</h1>
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

                <?php if ($current_folder): ?>
                    <!-- ============================================== -->
                    <!-- VIEW 2: INSIDE A SPECIFIC FOLDER               -->
                    <!-- ============================================== -->
                    
                    <!-- Breadcrumbs & Navigation -->
                    <div class="gallery-nav-bar">
                        <div class="breadcrumbs">
                            <a href="mediagallery.php" class="breadcrumb-link">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                                Media Library
                            </a>
                            <span class="breadcrumb-separator">/</span>
                            <span class="breadcrumb-current"><?= htmlspecialchars($current_folder['folder_name']) ?></span>
                        </div>
                        <a href="mediagallery.php" class="btn btn-secondary-outline btn-back">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            Back to Folders
                        </a>
                    </div>

                    <!-- Inner Folder Header -->
                    <div class="folder-header-panel">
                        <div class="folder-title-box">
                            <div class="folder-header-icon">
                                <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor"><path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/></svg>
                            </div>
                            <div>
                                <h2 class="folder-header-title">
                                    <?= htmlspecialchars($current_folder['folder_name']) ?>
                                    <span class="badge-count"><?= count($folder_media) ?> <?= count($folder_media) === 1 ? 'Photo' : 'Photos' ?></span>
                                </h2>
                                <?php if (!empty($current_folder['description'])): ?>
                                    <p class="folder-header-desc"><?= htmlspecialchars($current_folder['description']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <button id="openUploadModalBtn" class="btn btn-action-create" onclick="openUploadModal(<?= $current_folder['id'] ?>);">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            + Upload Images
                        </button>
                    </div>

                    <!-- Media Items Grid -->
                    <div class="gallery-container">
                        <?php if (empty($folder_media)): ?>
                            <div class="empty-state-card">
                                <div class="empty-state-icon">
                                    <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                </div>
                                <h3>No images in this folder yet</h3>
                                <p>Start uploading photos to categorize and display them in the <?= htmlspecialchars($current_folder['folder_name']) ?> gallery.</p>
                                <button class="btn btn-action-create" onclick="openUploadModal(<?= $current_folder['id'] ?>);">
                                    + Upload First Photo
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="gallery-grid">
                                <?php foreach ($folder_media as $media): ?>
                                    <div class="media-card">
                                        <div class="media-thumb-wrapper" onclick="previewImage('<?= htmlspecialchars('../' . $media['file_path']) ?>', '<?= htmlspecialchars(addslashes($media['caption'] ?? $media['file_name'])) ?>')">
                                            <img src="../<?= htmlspecialchars($media['file_path']) ?>" alt="<?= htmlspecialchars($media['caption'] ?? 'Gallery image') ?>" loading="lazy" class="media-thumb-img">
                                            <div class="media-card-hover-overlay">
                                                <span class="preview-btn-tag">
                                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                                                    View
                                                </span>
                                            </div>
                                        </div>
                                        <div class="media-info">
                                            <span class="media-caption" title="<?= htmlspecialchars($media['caption'] ?? $media['file_name']) ?>">
                                                <?= htmlspecialchars($media['caption'] ?? $media['file_name']) ?>
                                            </span>
                                            <div class="media-card-actions">
                                                <small class="media-date"><?= date('M d, Y', strtotime($media['uploaded_at'])) ?></small>
                                                <form action="mediagallery.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');" style="margin: 0;">
                                                    <input type="hidden" name="action" value="delete_media">
                                                    <input type="hidden" name="media_id" value="<?= $media['id'] ?>">
                                                    <input type="hidden" name="folder_id" value="<?= $current_folder['id'] ?>">
                                                    <button type="submit" class="btn-icon-danger" title="Delete Image">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                <?php else: ?>
                    <!-- ============================================== -->
                    <!-- VIEW 1: ROOT FOLDERS OVERVIEW                  -->
                    <!-- ============================================== -->
                    <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 1.5rem; background: #ffffff; padding: 1.25rem 1.75rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.04); flex-wrap: wrap; gap: 1rem;">
                        <div class="content-header-title-box">
                            <h2>Media Categories & Folders</h2>
                            <p>Organize photos into folders (e.g., Meeting, Sports, Community Events).</p>
                        </div>
                        <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                            <button type="button" class="btn-action-create" onclick="openUploadModal();">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                + Upload Images
                            </button>
                            <button id="openFolderModalBtn" class="btn-action-create" onclick="openModal('createFolderModal');" style="background: #ffffff !important; color: #0d2847 !important; border: 1.5px solid #cbd5e1 !important; box-shadow: none !important;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>
                                + Create Folder
                            </button>
                        </div>
                    </div>

                    <div class="gallery-container">
                        <?php if (empty($all_folders)): ?>
                            <div class="empty-state-card">
                                <div class="empty-state-icon">
                                    <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="#d97706" stroke-width="1.8"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                                </div>
                                <h3>No Media Folders Yet</h3>
                                <p>Create your first category folder (e.g. "Meeting", "Sports Fest") to begin uploading and organizing community pictures.</p>
                                <button class="btn-action-create" onclick="openModal('createFolderModal');">
                                    + Create First Folder
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="folders-grid">
                                <?php foreach ($all_folders as $folder): ?>
                                    <div class="folder-card">
                                        <a href="mediagallery.php?folder_id=<?= $folder['id'] ?>" class="folder-card-body">
                                            <div class="folder-visual-icon">
                                                <svg viewBox="0 0 24 24" width="34" height="34" fill="currentColor"><path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/></svg>
                                            </div>
                                            <div class="folder-info-block">
                                                <h3 class="folder-name"><?= htmlspecialchars($folder['folder_name']) ?></h3>
                                                <?php if (!empty($folder['description'])): ?>
                                                    <p class="folder-desc-text"><?= htmlspecialchars($folder['description']) ?></p>
                                                <?php endif; ?>
                                                <div class="folder-meta-row">
                                                    <span class="folder-item-pill">
                                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                                        <?= $folder['media_count'] ?> <?= $folder['media_count'] == 1 ? 'Photo' : 'Photos' ?>
                                                    </span>
                                                    <span class="folder-date"><?= date('M d, Y', strtotime($folder['created_at'])) ?></span>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="folder-card-footer">
                                            <a href="mediagallery.php?folder_id=<?= $folder['id'] ?>" class="btn-folder-open">
                                                Open Album
                                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                            </a>
                                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                                <button type="button" class="btn-upload-quick" onclick="openUploadModal(<?= $folder['id'] ?>);" title="Add photos directly to <?= htmlspecialchars($folder['folder_name']) ?>">
                                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                                    <span>+ Add Photos</span>
                                                </button>
                                                <form action="mediagallery.php" method="POST" onsubmit="return confirm('Are you sure you want to delete folder &quot;<?= htmlspecialchars(addslashes($folder['folder_name'])) ?>&quot;? All photos inside this folder will also be deleted.');" style="margin: 0;">
                                                    <input type="hidden" name="action" value="delete_folder">
                                                    <input type="hidden" name="folder_id" value="<?= $folder['id'] ?>">
                                                    <button type="submit" class="btn-icon-danger" title="Delete Folder">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Create Folder Modal -->
                    <div id="createFolderModal" class="modal-overlay" style="display: none;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2>
                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="#d97706"><path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/></svg>
                                    Create New Folder
                                </h2>
                                <button type="button" class="modal-close" onclick="closeModal('createFolderModal')">&times;</button>
                            </div>
                            <form action="mediagallery.php" method="POST">
                                <input type="hidden" name="action" value="create_folder">
                                <div class="modal-body custom-scrollbar">
                                    <div class="form-group">
                                        <label for="folder_name">Folder / Category Name <span class="required-star">*</span></label>
                                        <input type="text" id="folder_name" name="folder_name" placeholder="e.g., Meeting, Sports, Fiesta 2026, Medical Mission" required class="form-control" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="folder_description">Description (Optional)</label>
                                        <textarea id="folder_description" name="description" rows="3" placeholder="Brief description of the photos inside this folder..." class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modal-cancel" onclick="closeModal('createFolderModal')">Cancel</button>
                                    <button type="submit" class="btn btn-action-create">Create Folder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </main>
    </div>

    <!-- Upload Media Modal (Universally available on both root and inner views) -->
    <div id="uploadMediaModal" class="modal-overlay" style="display: none;">
        <div class="modal-content" style="max-width: 560px !important;">
            <div class="modal-header">
                <h2>
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#0d2847" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    <span id="uploadModalTitle">Upload Images</span>
                </h2>
                <button type="button" class="modal-close" onclick="closeModal('uploadMediaModal')">&times;</button>
            </div>
            <form action="mediagallery.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="upload_media">
                
                <div class="modal-body custom-scrollbar">
                    <!-- Target Folder Selection -->
                    <div class="form-group">
                        <label for="upload_folder_id">Destination Folder <span class="required-star">*</span></label>
                        <select id="upload_folder_id" name="folder_id" class="form-control" required onchange="handleFolderSelectChange(this)">
                            <option value="">-- Select Target Folder --</option>
                            <?php foreach ($all_folders as $f_item): ?>
                                <option value="<?= $f_item['id'] ?>" <?= ($active_folder_id == $f_item['id']) ? 'selected' : '' ?>>
                                    📁 <?= htmlspecialchars($f_item['folder_name']) ?> (<?= $f_item['media_count'] ?> <?= $f_item['media_count'] == 1 ? 'photo' : 'photos' ?>)
                                </option>
                            <?php endforeach; ?>
                            <option value="new" <?= empty($all_folders) ? 'selected' : '' ?>>➕ Create New Folder...</option>
                        </select>
                        <small class="form-help">Choose which folder to add your pictures into, or create a new one.</small>
                    </div>

                    <!-- Conditional New Folder Input Block -->
                    <div id="newFolderFields" style="display: <?= empty($all_folders) ? 'block' : 'none' ?>; background: #fffbeb; border: 1.5px dashed #f59e0b; padding: 1.15rem; border-radius: 12px; margin-bottom: 0.5rem;">
                        <div style="font-weight: 700; color: #b45309; margin-bottom: 0.75rem; font-size: 0.9rem; display: flex; align-items: center; gap: 0.4rem;">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/></svg>
                            New Folder Information
                        </div>
                        <div class="form-group" style="margin-bottom: 0.75rem;">
                            <label for="modal_new_folder_name">Folder Name <span class="required-star">*</span></label>
                            <input type="text" id="modal_new_folder_name" name="new_folder_name" placeholder="e.g., Medical Mission 2026, Basketball League" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="modal_new_folder_desc">Folder Description (Optional)</label>
                            <input type="text" id="modal_new_folder_desc" name="new_folder_desc" placeholder="Brief details about photos in this folder..." class="form-control">
                        </div>
                    </div>

                    <!-- Multiple File Upload Dropzone -->
                    <div class="form-group">
                        <label for="media_files">Select Images <span class="required-star">*</span></label>
                        <div class="file-dropzone" id="fileDropzone" onclick="document.getElementById('media_files').click();">
                            <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="#d97706" stroke-width="1.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <p class="dropzone-text">Click to choose images or drag &amp; drop here</p>
                            <span class="dropzone-sub">You can select and upload multiple images at once (JPG, PNG, WEBP, GIF)</span>
                            <div id="selectedFilesCount" class="selected-files-indicator"></div>
                        </div>
                        <input type="file" id="media_files" name="media_files[]" accept="image/jpeg,image/png,image/gif,image/webp" multiple required style="display: none;" onchange="handleFileSelect(this)">
                        
                        <!-- Visual Preview Grid of Selected Images -->
                        <div id="imagePreviewContainer" class="image-preview-grid" style="display: none;"></div>
                    </div>

                    <!-- Caption Input -->
                    <div class="form-group">
                        <label for="caption">Caption / Title (Optional)</label>
                        <input type="text" id="caption" name="caption" placeholder="e.g., Highlights from community event" class="form-control">
                        <small class="form-help">Leave empty to use original image file names automatically.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal-cancel" onclick="closeModal('uploadMediaModal')">Cancel</button>
                    <button type="submit" class="btn btn-action-create">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        Upload Photos
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Lightbox Modal (Guaranteed hidden by default) -->
    <div id="imageLightboxModal" class="modal-overlay image-lightbox-overlay" style="display: none;" onclick="if(event.target === this) closeLightbox();">
        <div class="lightbox-container">
            <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
            <img id="lightboxImg" src="" alt="Enlarged Preview" class="lightbox-img">
            <div id="lightboxCaption" class="lightbox-caption"></div>
        </div>
    </div>

    <!-- Core Scripts -->
    <script src="js/dashboard.js"></script>
    <script>
        // Modal Handling
        function openModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = 'flex';
                const input = el.querySelector('input[type="text"]:not([style*="display: none"]):not([disabled]), select');
                if (input) setTimeout(() => input.focus(), 50);
            }
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        }

        // Open Upload Modal with optional target folder
        function openUploadModal(folderId) {
            const folderSelect = document.getElementById('upload_folder_id');
            const titleEl = document.getElementById('uploadModalTitle');

            if (folderSelect) {
                if (folderId) {
                    folderSelect.value = folderId;
                    const selectedOption = folderSelect.options[folderSelect.selectedIndex];
                    if (titleEl && selectedOption) {
                        titleEl.textContent = 'Upload Images to "' + selectedOption.text.replace(/📁|\(\d+\s*photos?\)/g, '').trim() + '"';
                    }
                } else {
                    if (titleEl) titleEl.textContent = 'Upload Images';
                    if (!folderSelect.value && folderSelect.options.length > 1) {
                        folderSelect.selectedIndex = 1;
                    }
                }
                handleFolderSelectChange(folderSelect);
            }

            openModal('uploadMediaModal');
        }

        // Toggle New Folder input fields in upload modal
        function handleFolderSelectChange(select) {
            const newFields = document.getElementById('newFolderFields');
            const newNameInput = document.getElementById('modal_new_folder_name');
            const titleEl = document.getElementById('uploadModalTitle');

            if (!newFields) return;

            if (select.value === 'new') {
                newFields.style.display = 'block';
                if (newNameInput) {
                    newNameInput.required = true;
                    setTimeout(() => newNameInput.focus(), 50);
                }
                if (titleEl) titleEl.textContent = 'Create Folder & Upload Images';
            } else {
                newFields.style.display = 'none';
                if (newNameInput) {
                    newNameInput.required = false;
                }
                if (titleEl && select.selectedIndex > 0) {
                    const optText = select.options[select.selectedIndex].text.replace(/📁|\(\d+\s*photos?\)/g, '').trim();
                    titleEl.textContent = 'Upload Images to "' + optText + '"';
                }
            }
        }

        // Dropzone file selection & preview handling
        function handleFileSelect(input) {
            const countEl = document.getElementById('selectedFilesCount');
            const previewContainer = document.getElementById('imagePreviewContainer');

            if (!input.files || input.files.length === 0) {
                if (countEl) { countEl.textContent = ''; countEl.style.display = 'none'; }
                if (previewContainer) { previewContainer.innerHTML = ''; previewContainer.style.display = 'none'; }
                return;
            }

            const count = input.files.length;
            if (countEl) {
                countEl.textContent = count === 1 ? `✓ Selected: 1 photo (${input.files[0].name})` : `✓ Selected: ${count} photos ready to upload`;
                countEl.style.display = 'block';
            }

            if (previewContainer) {
                previewContainer.innerHTML = '';
                previewContainer.style.display = 'grid';

                const maxPreviews = 16;
                const total = Math.min(count, maxPreviews);

                for (let i = 0; i < total; i++) {
                    const file = input.files[i];
                    if (file.type && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const item = document.createElement('div');
                            item.className = 'image-preview-item';
                            item.title = file.name;
                            item.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                            previewContainer.appendChild(item);
                        };
                        reader.readAsDataURL(file);
                    }
                }

                if (count > maxPreviews) {
                    const more = document.createElement('div');
                    more.className = 'image-preview-item';
                    more.style.display = 'flex';
                    more.style.alignItems = 'center';
                    more.style.justifyContent = 'center';
                    more.style.background = '#e2e8f0';
                    more.style.fontSize = '0.78rem';
                    more.style.fontWeight = '700';
                    more.style.color = '#475569';
                    more.textContent = `+${count - maxPreviews} more`;
                    previewContainer.appendChild(more);
                }
            }
        }

        // Drag and drop support on dropzone
        const dropzone = document.getElementById('fileDropzone');
        if (dropzone) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.add('drag-active');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.remove('drag-active');
                }, false);
            });

            dropzone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                if (dt && dt.files && dt.files.length > 0) {
                    const fileInput = document.getElementById('media_files');
                    if (fileInput) {
                        fileInput.files = dt.files;
                        handleFileSelect(fileInput);
                    }
                }
            }, false);
        }

        // Close modal on clicking backdrop
        window.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-overlay') && !e.target.classList.contains('image-lightbox-overlay')) {
                e.target.style.display = 'none';
            }
        });

        // Image Lightbox
        function previewImage(src, caption) {
            const modal = document.getElementById('imageLightboxModal');
            const img = document.getElementById('lightboxImg');
            const cap = document.getElementById('lightboxCaption');
            if (modal && img) {
                img.src = src;
                cap.textContent = caption || '';
                modal.style.display = 'flex';
            }
        }

        function closeLightbox() {
            const modal = document.getElementById('imageLightboxModal');
            if (modal) modal.style.display = 'none';
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLightbox();
                closeModal('createFolderModal');
                closeModal('uploadMediaModal');
            }
        });
    </script>
</body>
</html>
