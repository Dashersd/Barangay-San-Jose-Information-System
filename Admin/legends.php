<?php
// Manage Map Legends & Landmark Pins - Admin Panel
require_once __DIR__ . '/../db_connect.php';

$legendDir = __DIR__ . '/../assets/images/Legend/';
if (!is_dir($legendDir)) {
    mkdir($legendDir, 0777, true);
}
$photoDir = __DIR__ . '/../assets/images/households/';
if (!is_dir($photoDir)) {
    mkdir($photoDir, 0777, true);
}

$jsonFileLegends = __DIR__ . '/data/legends.json';

// Helper to sync legends JSON
function syncLegendsJsonFile($conn, $filePath) {
    if ($conn) {
        $res = $conn->query("SELECT * FROM legends ORDER BY display_order ASC, id ASC");
        if ($res) {
            $items = [];
            while ($row = $res->fetch_assoc()) {
                $items[] = $row;
            }
            @file_put_contents($filePath, json_encode($items, JSON_PRETTY_PRINT));
        }
    }
}

// -------------------------------------------------------------
// POST HANDLERS
// -------------------------------------------------------------
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $action = $_POST['action'] ?? '';

    // SAVE / UPDATE LEGEND & PIN
    if ($action === 'save_legend') {
        $legendId = intval($_POST['legend_id'] ?? 0);
        $categoryName = trim($_POST['category_name'] ?? '');
        $color = trim($_POST['color'] ?? '#6366f1');
        if (!preg_match('/^#[a-fA-F0-9]{3,6}$/', $color)) {
            $color = '#6366f1';
        }
        $iconType = trim($_POST['icon_type'] ?? 'bi-building-fill');
        $iconSource = $_POST['icon_source'] ?? 'preset';
        $topPos = floatval($_POST['top_pos'] ?? 50.0);
        $leftPos = floatval($_POST['left_pos'] ?? 50.0);
        $width = intval($_POST['width'] ?? 40);
        if ($width <= 0) $width = 40;
        $height = intval($_POST['height'] ?? 40);
        if ($height <= 0) $height = 40;
        $displayOrder = intval($_POST['display_order'] ?? 1);
        $status = in_array($_POST['status'] ?? '', ['Active', 'Inactive']) ? $_POST['status'] : 'Active';

        if (!empty($categoryName)) {
            // Handle Landmark Photo upload
            $photoPath = null;
            if (isset($_FILES['landmark_photo']) && $_FILES['landmark_photo']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['landmark_photo']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (in_array($ext, $allowed)) {
                    $cleanName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($_FILES['landmark_photo']['name']));
                    $photoFileName = 'landmark_' . time() . '_' . $cleanName;
                    if (move_uploaded_file($_FILES['landmark_photo']['tmp_name'], $photoDir . $photoFileName)) {
                        $photoPath = 'assets/images/households/' . $photoFileName;
                    }
                }
            }

            // Handle Custom Icon upload if source is upload
            $customIconPath = null;
            if ($iconSource === 'upload' && isset($_FILES['custom_icon']) && $_FILES['custom_icon']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['custom_icon']['name'], PATHINFO_EXTENSION));
                $allowed = ['png', 'jpg', 'jpeg', 'svg', 'webp'];
                if (in_array($ext, $allowed)) {
                    $cleanName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($_FILES['custom_icon']['name']));
                    $iconFileName = 'icon_' . time() . '_' . $cleanName;
                    if (move_uploaded_file($_FILES['custom_icon']['tmp_name'], $legendDir . $iconFileName)) {
                        $customIconPath = 'assets/images/Legend/' . $iconFileName;
                    }
                }
            }

            if ($conn) {
                if ($legendId > 0) {
                    // Update existing
                    $updateSql = "UPDATE legends SET category_name = ?, color = ?, icon_type = ?, top_pos = ?, left_pos = ?, width = ?, height = ?, display_order = ?, status = ?";
                    $params = [$categoryName, $color, $iconType, $topPos, $leftPos, $width, $height, $displayOrder, $status];
                    $types = "sssddiiis";

                    if ($photoPath !== null) {
                        $updateSql .= ", photo = ?";
                        $params[] = $photoPath;
                        $types .= "s";
                    }
                    if ($customIconPath !== null) {
                        $updateSql .= ", icon_path = ?";
                        $params[] = $customIconPath;
                        $types .= "s";
                    }

                    $updateSql .= " WHERE id = ?";
                    $params[] = $legendId;
                    $types .= "i";

                    $stmt = $conn->prepare($updateSql);
                    $stmt->bind_param($types, ...$params);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    // Insert new
                    $iconFinal = $customIconPath ? $customIconPath : 'assets/images/Legend/hall.svg';
                    $stmt = $conn->prepare("INSERT INTO legends (category_name, icon_path, color, icon_type, top_pos, left_pos, width, height, display_order, status, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssddiiiss", $categoryName, $iconFinal, $color, $iconType, $topPos, $leftPos, $width, $height, $displayOrder, $status, $photoPath);
                    $stmt->execute();
                    $stmt->close();
                }

                syncLegendsJsonFile($conn, $jsonFileLegends);
            }

            header("Location: legends.php?msg=saved");
            exit;
        } else {
            header("Location: legends.php?err=name_required");
            exit;
        }
    }

    // TOGGLE STATUS
    if ($action === 'toggle_status') {
        $toggleId = intval($_POST['toggle_id'] ?? 0);
        if ($toggleId > 0 && $conn) {
            $stmt = $conn->prepare("UPDATE legends SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = ?");
            $stmt->bind_param("i", $toggleId);
            $stmt->execute();
            $stmt->close();
            syncLegendsJsonFile($conn, $jsonFileLegends);
            header("Location: legends.php?msg=status_updated");
            exit;
        }
    }

    // DELETE LEGEND
    if ($action === 'delete_legend') {
        $deleteId = intval($_POST['delete_id'] ?? 0);
        if ($deleteId > 0 && $conn) {
            $stmt = $conn->prepare("DELETE FROM legends WHERE id = ?");
            $stmt->bind_param("i", $deleteId);
            $stmt->execute();
            $stmt->close();
            syncLegendsJsonFile($conn, $jsonFileLegends);
            header("Location: legends.php?msg=deleted");
            exit;
        }
    }
}

// -------------------------------------------------------------
// FETCH ALL LEGENDS
// -------------------------------------------------------------
$legends = [];
if ($conn) {
    $res = $conn->query("SELECT * FROM legends ORDER BY display_order ASC, id ASC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $legends[] = $row;
        }
    }
}
if (empty($legends) && file_exists($jsonFileLegends)) {
    $legends = json_decode(file_get_contents($jsonFileLegends), true) ?: [];
}

$nextOrder = count($legends) + 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Legends & Map Pins - Admin Panel</title>

    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="../assets/images/San Jose Logo 2.png">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="css/dashboard.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/legends_v2.css">

    <style>
        /* ========================================================
           AERIAL MAP STYLING & PIN POSITIONING
        ======================================================== */
        .aerial-map-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
            margin-bottom: 24px;
            position: relative;
        }
        .map-interactive-container {
            position: relative;
            width: 100%;
            user-select: none;
            overflow: hidden;
            cursor: crosshair;
            background: #0f172a;
        }
        .map-interactive-container img.aerial-map-img {
            width: 100%;
            height: auto;
            display: block;
            pointer-events: none;
        }
        .aerial-map-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            background: rgba(6, 78, 59, 0.88);
            backdrop-filter: blur(4px);
            color: #ecfdf5;
            border: 1px solid rgba(16, 185, 129, 0.4);
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 0.825rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 30;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            pointer-events: none;
        }

        /* Saved Map Pins */
        .map-pin {
            position: absolute;
            transform: translate(-50%, -100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 20;
            cursor: pointer;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .map-pin:hover {
            transform: translate(-50%, -105%) scale(1.12);
            z-index: 40;
        }
        .map-pin-pill {
            background: #ffffff;
            color: #0f172a;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.28);
            white-space: nowrap;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 4px;
            border: 1px solid rgba(0,0,0,0.06);
        }
        .map-pin-icon-wrap {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(0,0,0,0.35);
            border: 2px solid #ffffff;
            transition: all 0.2s ease;
        }
        .map-pin-icon-wrap i {
            font-size: 15px;
        }

        /* Pulsing "New Landmark" Pin */
        .pulsing-marker {
            position: absolute;
            transform: translate(-50%, -100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 25;
            cursor: grab;
            transition: none;
        }
        .pulsing-marker:active {
            cursor: grabbing;
        }
        .pulsing-marker-pill {
            background: #0f172a;
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.35);
            white-space: nowrap;
            margin-bottom: 4px;
        }
        .pulsing-marker-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #6366f1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.5);
            border: 2.5px solid #ffffff;
            position: relative;
        }
        .pulsing-marker-icon-wrap::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border-radius: 50%;
            border: 2px solid #6366f1;
            animation: pulseWave 1.8s infinite ease-out;
            pointer-events: none;
        }
        @keyframes pulseWave {
            0% { transform: scale(1); opacity: 0.9; }
            100% { transform: scale(2.2); opacity: 0; }
        }

        /* ========================================================
           ADD LEGEND & MAP PIN FORM (3-COLUMN SECTION)
        ======================================================== */
        .form-section-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            margin-bottom: 24px;
        }
        .form-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 14px;
            border-bottom: 1px solid #f1f5f9;
        }
        .form-main-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: #064e3b;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }
        .form-main-title i {
            color: #f59e0b;
            font-size: 1.35rem;
        }
        .form-header-hint {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .three-column-grid {
            display: grid;
            grid-template-columns: 1fr 1.15fr 1fr;
            gap: 28px;
            align-items: start;
        }
        @media (max-width: 1100px) {
            .three-column-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 768px) {
            .three-column-grid {
                grid-template-columns: 1fr;
            }
        }

        .col-step-title {
            font-size: 0.88rem;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .col-step-title i {
            color: #f59e0b;
            font-size: 1rem;
        }

        /* Photo Upload Box */
        .photo-upload-container {
            border: 1.5px dashed #38bdf8;
            background: #f0f9ff;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 16px;
        }
        .photo-upload-title {
            font-size: 0.825rem;
            font-weight: 700;
            color: #0284c7;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .photo-upload-container input[type="file"] {
            width: 100%;
            font-size: 0.825rem;
            color: #475569;
        }
        .photo-upload-hint {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 6px;
            line-height: 1.3;
        }

        /* Color Selection */
        .color-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
        .color-preview-box {
            width: 44px;
            height: 38px;
            border-radius: 8px;
            background-color: #6366f1;
            border: 1px solid #cbd5e1;
            flex-shrink: 0;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.15);
        }
        .color-dots-list {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .color-dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 1px #cbd5e1;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .color-dot:hover {
            transform: scale(1.15);
        }
        .color-dot.active {
            transform: scale(1.2);
            box-shadow: 0 0 0 2px #0f172a;
        }

        /* Icon Presets Grid */
        .preset-tabs-bar {
            display: flex;
            gap: 6px;
            margin-bottom: 14px;
            background: #f1f5f9;
            padding: 3px;
            border-radius: 8px;
        }
        .preset-tab-btn {
            flex: 1;
            padding: 7px 12px;
            font-size: 0.825rem;
            font-weight: 700;
            color: #64748b;
            background: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .preset-tab-btn.active {
            background: #ffffff;
            color: #0f172a;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }

        .icons-scroll-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            max-height: 190px;
            overflow-y: auto;
            padding-right: 4px;
            margin-bottom: 16px;
        }
        .icons-scroll-grid::-webkit-scrollbar {
            width: 5px;
        }
        .icons-scroll-grid::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }

        .icon-card {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #ffffff;
            padding: 10px 4px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }
        .icon-card:hover {
            border-color: #cbd5e1;
            background-color: #f8fafc;
        }
        .icon-card.active {
            border-color: #10b981;
            background-color: #ecfdf5;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }
        .icon-card i {
            font-size: 1.25rem;
            color: #0f172a;
        }
        .icon-card.active i {
            color: #065f46;
        }
        .icon-card span {
            font-size: 0.72rem;
            font-weight: 600;
            color: #475569;
        }

        /* Spot Map Legend Preview Box */
        .spot-map-legend-preview-box {
            border: 1.5px dashed #cbd5e1;
            border-radius: 10px;
            background: #f8fafc;
            padding: 14px;
        }
        .spot-map-legend-preview-title {
            font-size: 0.78rem;
            font-weight: 800;
            color: #065f46;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
        }
        .preview-legend-pill {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .preview-legend-pill i {
            font-size: 1.1rem;
            color: #6366f1;
        }
        .preview-legend-pill span {
            font-size: 0.9rem;
            font-weight: 600;
            color: #0f172a;
        }

        /* Placement Inputs */
        .side-inputs-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }
        .field-subtext {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 4px;
            display: block;
        }

        .btn-save-legend-pin {
            width: 100%;
            background-color: #064e3b;
            color: #ffffff;
            border: none;
            padding: 13px 18px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 18px;
            box-shadow: 0 2px 6px rgba(6, 78, 59, 0.25);
        }
        .btn-save-legend-pin:hover {
            background-color: #047857;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(6, 78, 59, 0.35);
        }

        /* ========================================================
           ACTIVE LEGENDS & PINS TABLE (IMAGE 3)
        ======================================================== */
        .table-section-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            margin-bottom: 24px;
        }
        .table-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #064e3b;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }
        .table-title i {
            font-size: 1.25rem;
        }

        .active-legends-table {
            width: 100%;
            border-collapse: collapse;
        }
        .active-legends-table th {
            text-align: left;
            font-size: 0.78rem;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 14px;
            border-bottom: 1px solid #e2e8f0;
        }
        .active-legends-table td {
            padding: 14px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 0.9rem;
            color: #0f172a;
        }
        .active-legends-table tr:hover td {
            background-color: #f8fafc;
        }

        .table-icon-badge {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .table-thumb-photo {
            width: 44px;
            height: 34px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #cbd5e1;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .table-thumb-photo:hover {
            transform: scale(1.15);
        }

        .status-pill {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
        }
        .status-pill.active {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-pill.inactive {
            background-color: #f1f5f9;
            color: #64748b;
        }

        .table-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
            margin-right: 4px;
            font-size: 0.85rem;
        }
        .table-action-btn:hover {
            background-color: #e2e8f0;
            color: #0f172a;
        }
        .table-action-btn.edit:hover {
            background-color: #e0f2fe;
            color: #0284c7;
        }
        .table-action-btn.view:hover {
            background-color: #e0e7ff;
            color: #4f46e5;
        }
        .table-action-btn.delete:hover {
            background-color: #fee2e2;
            color: #ef4444;
        }

        /* Photo Viewer Modal */
        .photo-viewer-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(3px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .photo-viewer-modal.show {
            display: flex;
        }
        .photo-viewer-content {
            background: #ffffff;
            border-radius: 12px;
            max-width: 600px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            animation: modalFade 0.2s ease-out;
        }
        @keyframes modalFade {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
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
                        <li><a href="legends.php" class="active">Legends</a></li>
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
                <h1>Manage Spot Map Legends & Pins</h1>
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

                <!-- Alert Feedback -->
                <?php if (isset($_GET['msg']) && $_GET['msg'] === 'saved'): ?>
                    <div style="background-color: #d1fae5; color: #065f46; padding: 12px 18px; margin-bottom: 20px; border-radius: 8px; border-left: 4px solid #10b981; display: flex; align-items: center; gap: 10px; font-weight: 600;">
                        <i class="bi bi-check-circle-fill" style="font-size: 1.2rem;"></i>
                        Map legend and pin have been saved successfully! Live on public spot map.
                    </div>
                <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
                    <div style="background-color: #d1fae5; color: #065f46; padding: 12px 18px; margin-bottom: 20px; border-radius: 8px; border-left: 4px solid #10b981; display: flex; align-items: center; gap: 10px; font-weight: 600;">
                        <i class="bi bi-trash-fill" style="font-size: 1.2rem;"></i>
                        Legend has been removed successfully.
                    </div>
                <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'status_updated'): ?>
                    <div style="background-color: #d1fae5; color: #065f46; padding: 12px 18px; margin-bottom: 20px; border-radius: 8px; border-left: 4px solid #10b981; display: flex; align-items: center; gap: 10px; font-weight: 600;">
                        <i class="bi bi-arrow-repeat" style="font-size: 1.2rem;"></i>
                        Legend status has been updated.
                    </div>
                <?php elseif (isset($_GET['err'])): ?>
                    <div style="background-color: #fee2e2; color: #991b1b; padding: 12px 18px; margin-bottom: 20px; border-radius: 8px; border-left: 4px solid #ef4444; display: flex; align-items: center; gap: 10px; font-weight: 600;">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.2rem;"></i>
                        Please provide a valid landmark name.
                    </div>
                <?php endif; ?>

                <!-- ========================================================
                     SECTION 1: AERIAL MAP VIEW (IMAGE 1 REFERENCE)
                ======================================================== -->
                <div class="aerial-map-card">
                    <div class="map-interactive-container" id="aerialMapContainer">
                        <!-- Top Floating Green Banner -->
                        <div class="aerial-map-badge">
                            <i class="bi bi-geo-alt-fill" style="color: #fbbf24;"></i>
                            Aerial Map View &bull; Drag the pulsing marker or click anywhere to position. Click saved pins to view landmark photo!
                        </div>

                        <!-- Aerial Map Image -->
                        <img src="../assets/images/Map/Legend.png" alt="Barangay San Jose Aerial Map" class="aerial-map-img" id="aerialMapImage">

                        <!-- Saved Pins on Map -->
                        <?php foreach ($legends as $leg): ?>
                            <?php 
                                $pinName = htmlspecialchars($leg['category_name'] ?? '');
                                $pinTop = floatval($leg['top_pos'] ?? 50.0);
                                $pinLeft = floatval($leg['left_pos'] ?? 50.0);
                                $pinColor = htmlspecialchars($leg['color'] ?? '#6366f1');
                                $pinIcon = htmlspecialchars($leg['icon_type'] ?? 'bi-building-fill');
                                $pinPhoto = htmlspecialchars($leg['photo'] ?? '');
                                $pinStatus = $leg['status'] ?? 'Active';
                                if ($pinStatus === 'Inactive') continue;
                            ?>
                            <div class="map-pin" 
                                 id="mapPin_<?= $leg['id'] ?>"
                                 style="top: <?= $pinTop ?>%; left: <?= $pinLeft ?>%;" 
                                 title="<?= $pinName ?>"
                                 onclick='handlePinClick(<?= json_encode($leg) ?>)'>
                                <div class="map-pin-pill">
                                    <span><?= $pinName ?></span>
                                </div>
                                <div class="map-pin-icon-wrap" style="background-color: <?= $pinColor ?>;">
                                    <i class="bi <?= $pinIcon ?>"></i>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Draggable Pulsing Marker ("New Landmark") -->
                        <div class="pulsing-marker" id="pulsingMarker" style="top: 50.00%; left: 50.00%;">
                            <div class="pulsing-marker-pill" id="markerLabel">New Landmark</div>
                            <div class="pulsing-marker-icon-wrap" id="markerIconWrap">
                                <i class="bi bi-building-fill" id="markerIcon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================================
                     SECTION 2: ADD LEGEND & MAP PIN FORM (IMAGE 2 REFERENCE)
                ======================================================== -->
                <div class="form-section-card">
                    <div class="form-header-bar">
                        <h2 class="form-main-title">
                            <i class="bi bi-plus-circle-fill"></i>
                            <span id="formTitleText">Add Legend & Map Pin</span>
                        </h2>
                        <span class="form-header-hint">
                            <i class="bi bi-arrow-up-left"></i>
                            Drag marker on map above or enter coordinates below
                        </span>
                    </div>

                    <form action="legends.php" method="POST" enctype="multipart/form-data" id="legendPinForm">
                        <input type="hidden" name="action" value="save_legend">
                        <input type="hidden" name="legend_id" id="legend_id" value="">
                        <input type="hidden" name="icon_type" id="icon_type" value="bi-building-fill">
                        <input type="hidden" name="icon_source" id="icon_source" value="preset">

                        <div class="three-column-grid">

                            <!-- COLUMN 1: 1. LANDMARK DETAILS -->
                            <div>
                                <div class="col-step-title">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    1. Landmark Details
                                </div>

                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label for="category_name" style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                        Legend / Landmark Name <span style="color: #ef4444;">*</span>
                                    </label>
                                    <input type="text" id="category_name" name="category_name" class="form-control" placeholder="e.g., Barangay Hall, Evacuation Center" required oninput="updateLivePreview()">
                                    <span class="field-subtext">Shown in Spot Map Legend and marker tooltip.</span>
                                </div>

                                <!-- Photo Upload Box -->
                                <div class="photo-upload-container">
                                    <div class="photo-upload-title">
                                        <i class="bi bi-camera-fill"></i>
                                        Landmark Photo (Shown on Click)
                                    </div>
                                    <input type="file" id="landmark_photo" name="landmark_photo" accept="image/*">
                                    <div class="photo-upload-hint">
                                        Actual building photo. Pops up when user clicks icon on map or legend.
                                    </div>
                                    <div id="existingPhotoIndicator" style="display: none; margin-top: 8px; font-size: 0.78rem; color: #0284c7; font-weight: 600;">
                                        <i class="bi bi-image"></i> Current photo saved. Choose new file to replace.
                                    </div>
                                </div>

                                <!-- Icon & Pin Color -->
                                <div class="form-group">
                                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                        Icon & Pin Color
                                    </label>
                                    <div class="color-row">
                                        <div class="color-preview-box" id="colorPreviewBox"></div>
                                        <input type="text" id="colorInput" name="color" class="form-control" value="#6366f1" style="font-family: monospace; font-weight: 700; max-width: 120px;" oninput="handleManualColor(this.value)">
                                    </div>
                                    <div class="color-dots-list">
                                        <div class="color-dot active" style="background-color: #6366f1;" onclick="selectColor('#6366f1', this)" title="Indigo"></div>
                                        <div class="color-dot" style="background-color: #10b981;" onclick="selectColor('#10b981', this)" title="Emerald"></div>
                                        <div class="color-dot" style="background-color: #f59e0b;" onclick="selectColor('#f59e0b', this)" title="Amber"></div>
                                        <div class="color-dot" style="background-color: #ef4444;" onclick="selectColor('#ef4444', this)" title="Coral Red"></div>
                                        <div class="color-dot" style="background-color: #64748b;" onclick="selectColor('#64748b', this)" title="Slate"></div>
                                        <div class="color-dot" style="background-color: #0ea5e9;" onclick="selectColor('#0ea5e9', this)" title="Sky Blue"></div>
                                        <div class="color-dot" style="background-color: #8b5cf6;" onclick="selectColor('#8b5cf6', this)" title="Violet"></div>
                                        <div class="color-dot" style="background-color: #064e3b;" onclick="selectColor('#064e3b', this)" title="Forest Green"></div>
                                        <div class="color-dot" style="background-color: #f97316;" onclick="selectColor('#f97316', this)" title="Orange"></div>
                                        <div class="color-dot" style="background-color: #0d9488;" onclick="selectColor('#0d9488', this)" title="Teal"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- COLUMN 2: 2. ICON SELECTION & PREVIEW -->
                            <div>
                                <div class="col-step-title">
                                    <i class="bi bi-palette-fill"></i>
                                    2. Icon Selection & Preview
                                </div>

                                <div class="preset-tabs-bar">
                                    <button type="button" class="preset-tab-btn active" id="tabPresetsBtn" onclick="switchIconTab('preset')">
                                        <i class="bi bi-grid-3x3-gap-fill"></i> Presets
                                    </button>
                                    <button type="button" class="preset-tab-btn" id="tabUploadBtn" onclick="switchIconTab('upload')">
                                        <i class="bi bi-cloud-arrow-up-fill"></i> Upload Icon
                                    </button>
                                </div>

                                <!-- Presets Grid -->
                                <div id="presetsGridContainer">
                                    <div class="icons-scroll-grid">
                                        <div class="icon-card active" onclick="selectPresetIcon('bi-building-fill', 'Hall', this)">
                                            <i class="bi bi-building-fill"></i>
                                            <span>Hall</span>
                                        </div>
                                        <div class="icon-card" onclick="selectPresetIcon('bi-book-half', 'School', this)">
                                            <i class="bi bi-book-half"></i>
                                            <span>School</span>
                                        </div>
                                        <div class="icon-card" onclick="selectPresetIcon('bi-dribbble', 'Court', this)">
                                            <i class="bi bi-dribbble"></i>
                                            <span>Court</span>
                                        </div>
                                        <div class="icon-card" onclick="selectPresetIcon('bi-heart-pulse-fill', 'Health', this)">
                                            <i class="bi bi-heart-pulse-fill"></i>
                                            <span>Health</span>
                                        </div>
                                        <div class="icon-card" onclick="selectPresetIcon('bi-geo-alt-fill', 'Pin', this)">
                                            <i class="bi bi-geo-alt-fill"></i>
                                            <span>Pin</span>
                                        </div>
                                        <div class="icon-card" onclick="selectPresetIcon('bi-house-door-fill', 'House', this)">
                                            <i class="bi bi-house-door-fill"></i>
                                            <span>House</span>
                                        </div>
                                        <div class="icon-card" onclick="selectPresetIcon('bi-hospital-fill', 'Hospital', this)">
                                            <i class="bi bi-hospital-fill"></i>
                                            <span>Hospital</span>
                                        </div>
                                        <div class="icon-card" onclick="selectPresetIcon('bi-shop', 'Store', this)">
                                            <i class="bi bi-shop"></i>
                                            <span>Store</span>
                                        </div>
                                        <div class="icon-card" onclick="selectPresetIcon('bi-bank', 'Church', this)">
                                            <i class="bi bi-bank"></i>
                                            <span>Church</span>
                                        </div>
                                        <div class="icon-card" onclick="selectPresetIcon('bi-shield-shaded', 'Police', this)">
                                            <i class="bi bi-shield-shaded"></i>
                                            <span>Police</span>
                                        </div>
                                        <div class="icon-card" onclick="selectPresetIcon('bi-fire', 'Fire', this)">
                                            <i class="bi bi-fire"></i>
                                            <span>Fire</span>
                                        </div>
                                        <div class="icon-card" onclick="selectPresetIcon('bi-tree-fill', 'Park', this)">
                                            <i class="bi bi-tree-fill"></i>
                                            <span>Park</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload Custom Icon Box -->
                                <div id="uploadIconContainer" style="display: none; margin-bottom: 16px;">
                                    <div class="form-group">
                                        <label for="custom_icon" style="display: block; font-size: 0.825rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                                            Select Icon Image (PNG, SVG, JPG)
                                        </label>
                                        <input type="file" id="custom_icon" name="custom_icon" class="form-control" accept="image/png,image/svg+xml,image/jpeg,image/webp">
                                        <span class="field-subtext">Square icon with transparent background recommended.</span>
                                    </div>
                                </div>

                                <!-- Spot Map Legend Preview -->
                                <div class="spot-map-legend-preview-box">
                                    <div class="spot-map-legend-preview-title">
                                        <i class="bi bi-eye-fill"></i>
                                        Spot Map Legend Preview
                                    </div>
                                    <div class="preview-legend-pill">
                                        <i class="bi bi-building-fill" id="previewIconEl" style="color: #6366f1;"></i>
                                        <span id="previewNameEl">Barangay Hall</span>
                                    </div>
                                </div>
                            </div>

                            <!-- COLUMN 3: 3. PLACEMENT & SAVE -->
                            <div>
                                <div class="col-step-title">
                                    <i class="bi bi-pin-map-fill"></i>
                                    3. Placement & Save
                                </div>

                                <!-- Top & Left -->
                                <div class="side-inputs-row">
                                    <div>
                                        <label for="topPosInput" style="display: block; font-size: 0.825rem; font-weight: 700; color: #334155; margin-bottom: 5px;">Top (%)</label>
                                        <input type="number" step="0.01" id="topPosInput" name="top_pos" class="form-control" value="50.00" oninput="handleManualPos()">
                                    </div>
                                    <div>
                                        <label for="leftPosInput" style="display: block; font-size: 0.825rem; font-weight: 700; color: #334155; margin-bottom: 5px;">Left (%)</label>
                                        <input type="number" step="0.01" id="leftPosInput" name="left_pos" class="form-control" value="50.00" oninput="handleManualPos()">
                                    </div>
                                </div>
                                <span class="field-subtext" style="margin-top: -6px; margin-bottom: 14px;">
                                    <i class="bi bi-stars" style="color: #10b981;"></i> Auto-updates when you drag marker on map.
                                </span>

                                <!-- Width & Height -->
                                <div class="side-inputs-row">
                                    <div>
                                        <label for="widthInput" style="display: block; font-size: 0.825rem; font-weight: 700; color: #334155; margin-bottom: 5px;">Width (px)</label>
                                        <input type="number" id="widthInput" name="width" class="form-control" value="40">
                                    </div>
                                    <div>
                                        <label for="heightInput" style="display: block; font-size: 0.825rem; font-weight: 700; color: #334155; margin-bottom: 5px;">Height (px)</label>
                                        <input type="number" id="heightInput" name="height" class="form-control" value="40">
                                    </div>
                                </div>

                                <!-- Order & Status -->
                                <div class="side-inputs-row">
                                    <div>
                                        <label for="orderInput" style="display: block; font-size: 0.825rem; font-weight: 700; color: #334155; margin-bottom: 5px;">Order</label>
                                        <input type="number" id="orderInput" name="display_order" class="form-control" value="<?= $nextOrder ?>">
                                    </div>
                                    <div>
                                        <label for="statusInput" style="display: block; font-size: 0.825rem; font-weight: 700; color: #334155; margin-bottom: 5px;">Status</label>
                                        <select id="statusInput" name="status" class="form-control" style="font-weight: 600;">
                                            <option value="Active" selected>Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <button type="submit" class="btn-save-legend-pin" id="btnSubmitForm">
                                    <i class="bi bi-floppy-fill"></i>
                                    Save Legend & Pin to Map
                                </button>
                                
                                <button type="button" id="btnCancelEdit" onclick="resetFormToNew()" style="display: none; width: 100%; margin-top: 8px; background: #ffffff; border: 1px solid #cbd5e1; color: #475569; padding: 10px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                    Cancel Edit
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- ========================================================
                     SECTION 3: ACTIVE MAP LEGENDS & PINS (IMAGE 3 REFERENCE)
                ======================================================== -->
                <div class="table-section-card">
                    <h2 class="table-title">
                        <i class="bi bi-stack"></i>
                        Active Map Legends & Pins (<?= count($legends) ?>)
                    </h2>

                    <div style="overflow-x: auto;">
                        <table class="active-legends-table">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th style="width: 70px;">Icon</th>
                                    <th style="width: 90px;">Photo</th>
                                    <th>Legend Name</th>
                                    <th>Position (%)</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 140px; text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($legends)): ?>
                                    <?php $idx = 1; foreach ($legends as $l): ?>
                                        <?php 
                                            $lId = intval($l['id']);
                                            $lName = htmlspecialchars($l['category_name'] ?? '');
                                            $lIcon = htmlspecialchars($l['icon_type'] ?? 'bi-building-fill');
                                            $lColor = htmlspecialchars($l['color'] ?? '#6366f1');
                                            $lTop = number_format(floatval($l['top_pos'] ?? 50), 1);
                                            $lLeft = number_format(floatval($l['left_pos'] ?? 50), 1);
                                            $lPhoto = $l['photo'] ?? '';
                                            $lPhotoFull = !empty($lPhoto) ? ('../' . $lPhoto) : '';
                                            $lStatus = $l['status'] ?? 'Active';
                                        ?>
                                        <tr id="tableRow_<?= $lId ?>">
                                            <td style="color: #64748b; font-weight: 700;"><?= $idx++ ?></td>
                                            <td>
                                                <div class="table-icon-badge" style="color: <?= $lColor ?>;">
                                                    <i class="bi <?= $lIcon ?>"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if (!empty($lPhoto) && file_exists($lPhotoFull)): ?>
                                                    <img src="<?= htmlspecialchars($lPhotoFull) ?>" alt="<?= $lName ?>" class="table-thumb-photo" onclick="viewPhotoModal('<?= htmlspecialchars($lPhotoFull) ?>', '<?= addslashes($lName) ?>')" title="Click to view photo">
                                                <?php else: ?>
                                                    <span style="color: #94a3b8; font-style: italic; font-size: 0.825rem;">No photo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div style="font-weight: 700; color: #0f172a; margin-bottom: 2px;"><?= $lName ?></div>
                                                <div style="font-size: 0.75rem; color: #64748b; font-family: monospace;"><?= $lIcon ?></div>
                                            </td>
                                            <td>
                                                <span style="color: #2563eb; font-weight: 600; font-family: monospace;">
                                                    <?= $lTop ?>%, <?= $lLeft ?>%
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-pill <?= strtolower($lStatus) ?>">
                                                    <?= htmlspecialchars($lStatus) ?>
                                                </span>
                                            </td>
                                            <td style="text-align: right; white-space: nowrap;">
                                                <!-- Locate Pin Button -->
                                                <button type="button" class="table-action-btn view" title="Locate on Map" onclick="locatePinOnMap(<?= $l['id'] ?>)">
                                                    <i class="bi bi-geo-alt"></i>
                                                </button>

                                                <!-- Edit Button -->
                                                <button type="button" class="table-action-btn edit" title="Edit Legend & Pin" onclick='editLegend(<?= json_encode($l) ?>)'>
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <!-- Toggle Status Button -->
                                                <form action="legends.php" method="POST" style="display: inline-block;">
                                                    <input type="hidden" name="action" value="toggle_status">
                                                    <input type="hidden" name="toggle_id" value="<?= $lId ?>">
                                                    <button type="submit" class="table-action-btn" title="Toggle Status (Active/Inactive)">
                                                        <i class="bi <?= $lStatus === 'Active' ? 'bi-eye' : 'bi-eye-slash' ?>"></i>
                                                    </button>
                                                </form>

                                                <!-- Delete Button -->
                                                <form action="legends.php" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to remove \'<?= addslashes($lName) ?>\'?');">
                                                    <input type="hidden" name="action" value="delete_legend">
                                                    <input type="hidden" name="delete_id" value="<?= $lId ?>">
                                                    <button type="submit" class="table-action-btn delete" title="Delete Legend">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center; color: #94a3b8; padding: 24px;">No legends configured. Add one above!</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Landmark Photo Viewer Modal -->
    <div id="photoViewerModal" class="photo-viewer-modal" onclick="closePhotoModal(event)">
        <div class="photo-viewer-content" onclick="event.stopPropagation()">
            <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                <h3 id="photoModalTitle" style="margin: 0; font-size: 1.1rem; color: #0f172a; font-weight: 700;">Landmark Photo</h3>
                <button type="button" onclick="closePhotoModal()" style="border: none; background: none; font-size: 1.3rem; cursor: pointer; color: #64748b;">&times;</button>
            </div>
            <div style="padding: 14px; text-align: center; background: #0f172a;">
                <img id="photoModalImg" src="" alt="Landmark Photo" style="max-width: 100%; max-height: 450px; border-radius: 8px; object-fit: contain;">
            </div>
        </div>
    </div>

    <script src="js/dashboard.js?v=<?= time() ?>"></script>
    <script>
        // State variables
        let currentColor = '#6366f1';
        let currentIconClass = 'bi-building-fill';

        // Initialize Map Click & Drag Listeners
        const mapContainer = document.getElementById('aerialMapContainer');
        const pulsingMarker = document.getElementById('pulsingMarker');
        const topPosInput = document.getElementById('topPosInput');
        const leftPosInput = document.getElementById('leftPosInput');

        let isDragging = false;

        function setMarkerPosition(topPercent, leftPercent) {
            topPercent = Math.max(0, Math.min(100, topPercent));
            leftPercent = Math.max(0, Math.min(100, leftPercent));

            pulsingMarker.style.top = topPercent.toFixed(2) + '%';
            pulsingMarker.style.left = leftPercent.toFixed(2) + '%';

            topPosInput.value = topPercent.toFixed(2);
            leftPosInput.value = leftPercent.toFixed(2);
        }

        // Map Click to Place
        mapContainer.addEventListener('click', function(e) {
            if (e.target.closest('.map-pin')) return; // Ignore clicks on saved pins
            const rect = mapContainer.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const clickY = e.clientY - rect.top;

            const leftPercent = (clickX / rect.width) * 100;
            const topPercent = (clickY / rect.height) * 100;

            setMarkerPosition(topPercent, leftPercent);
        });

        // Dragging the pulsing pin
        pulsingMarker.addEventListener('mousedown', function(e) {
            e.stopPropagation();
            isDragging = true;
            document.body.style.userSelect = 'none';
        });

        window.addEventListener('mousemove', function(e) {
            if (!isDragging) return;
            const rect = mapContainer.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;

            const leftPercent = (mouseX / rect.width) * 100;
            const topPercent = (mouseY / rect.height) * 100;

            setMarkerPosition(topPercent, leftPercent);
        });

        window.addEventListener('mouseup', function() {
            if (isDragging) {
                isDragging = false;
                document.body.style.userSelect = '';
            }
        });

        // Color selection
        function selectColor(hex, element) {
            currentColor = hex;
            document.getElementById('colorInput').value = hex;
            document.getElementById('colorPreviewBox').style.backgroundColor = hex;
            document.getElementById('markerIconWrap').style.backgroundColor = hex;
            document.getElementById('previewIconEl').style.color = hex;

            document.querySelectorAll('.color-dot').forEach(d => d.classList.remove('active'));
            if (element) element.classList.add('active');
        }

        function handleManualColor(hex) {
            if (hex.startsWith('#') && (hex.length === 4 || hex.length === 7)) {
                currentColor = hex;
                document.getElementById('colorPreviewBox').style.backgroundColor = hex;
                document.getElementById('markerIconWrap').style.backgroundColor = hex;
                document.getElementById('previewIconEl').style.color = hex;
            }
        }

        function handleManualPos() {
            const topVal = parseFloat(topPosInput.value) || 50;
            const leftVal = parseFloat(leftPosInput.value) || 50;
            pulsingMarker.style.top = topVal.toFixed(2) + '%';
            pulsingMarker.style.left = leftVal.toFixed(2) + '%';
        }

        // Icon Presets
        function selectPresetIcon(iconClass, label, cardEl) {
            currentIconClass = iconClass;
            document.getElementById('icon_type').value = iconClass;

            // Update Card Active State
            document.querySelectorAll('.icon-card').forEach(c => c.classList.remove('active'));
            if (cardEl) cardEl.classList.add('active');

            // Update Map Pulsing Icon
            const markerIcon = document.getElementById('markerIcon');
            markerIcon.className = 'bi ' + iconClass;

            // Update Preview Box
            const previewIcon = document.getElementById('previewIconEl');
            previewIcon.className = 'bi ' + iconClass;
        }

        function switchIconTab(tab) {
            document.getElementById('icon_source').value = tab;
            const presetsSec = document.getElementById('presetsGridContainer');
            const uploadSec = document.getElementById('uploadIconContainer');
            const tabPresetsBtn = document.getElementById('tabPresetsBtn');
            const tabUploadBtn = document.getElementById('tabUploadBtn');

            if (tab === 'preset') {
                presetsSec.style.display = 'block';
                uploadSec.style.display = 'none';
                tabPresetsBtn.classList.add('active');
                tabUploadBtn.classList.remove('active');
            } else {
                presetsSec.style.display = 'none';
                uploadSec.style.display = 'block';
                tabUploadBtn.classList.add('active');
                tabPresetsBtn.classList.remove('active');
            }
        }

        function updateLivePreview() {
            const val = document.getElementById('category_name').value.trim();
            const previewName = document.getElementById('previewNameEl');
            const markerLabel = document.getElementById('markerLabel');
            
            previewName.textContent = val || 'Barangay Hall';
            markerLabel.textContent = val || 'New Landmark';
        }

        // Saved Pin click
        function handlePinClick(legend) {
            if (legend.photo) {
                viewPhotoModal('../' + legend.photo, legend.category_name);
            }
            editLegend(legend);
        }

        // Edit function
        function editLegend(legend) {
            document.getElementById('legend_id').value = legend.id;
            document.getElementById('category_name').value = legend.category_name || '';
            document.getElementById('orderInput').value = legend.display_order || '1';
            document.getElementById('statusInput').value = legend.status || 'Active';
            document.getElementById('widthInput').value = legend.width || '40';
            document.getElementById('heightInput').value = legend.height || '40';

            // Coordinates
            const topVal = parseFloat(legend.top_pos) || 50;
            const leftVal = parseFloat(legend.left_pos) || 50;
            setMarkerPosition(topVal, leftVal);

            // Color
            const col = legend.color || '#6366f1';
            selectColor(col);

            // Icon
            const iconClass = legend.icon_type || 'bi-building-fill';
            const matchingCard = Array.from(document.querySelectorAll('.icon-card')).find(c => c.querySelector('i').classList.contains(iconClass));
            selectPresetIcon(iconClass, legend.category_name, matchingCard);

            // Photo indicator
            const photoInd = document.getElementById('existingPhotoIndicator');
            if (legend.photo) {
                photoInd.style.display = 'block';
            } else {
                photoInd.style.display = 'none';
            }

            // Update UI state
            document.getElementById('formTitleText').textContent = 'Edit Legend: ' + legend.category_name;
            document.getElementById('btnSubmitForm').innerHTML = '<i class="bi bi-floppy-fill"></i> Update Legend & Pin';
            document.getElementById('btnCancelEdit').style.display = 'block';

            updateLivePreview();

            // Smooth scroll to form
            document.getElementById('legendPinForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function resetFormToNew() {
            document.getElementById('legend_id').value = '';
            document.getElementById('category_name').value = '';
            document.getElementById('orderInput').value = '<?= $nextOrder ?>';
            document.getElementById('statusInput').value = 'Active';
            document.getElementById('formTitleText').textContent = 'Add Legend & Map Pin';
            document.getElementById('btnSubmitForm').innerHTML = '<i class="bi bi-floppy-fill"></i> Save Legend & Pin to Map';
            document.getElementById('btnCancelEdit').style.display = 'none';
            document.getElementById('existingPhotoIndicator').style.display = 'none';

            selectColor('#6366f1');
            selectPresetIcon('bi-building-fill', 'Hall', document.querySelector('.icon-card'));
            updateLivePreview();
        }

        function locatePinOnMap(id) {
            const pin = document.getElementById('mapPin_' + id);
            if (pin) {
                pin.scrollIntoView({ behavior: 'smooth', block: 'center' });
                pin.style.transform = 'translate(-50%, -120%) scale(1.35)';
                setTimeout(() => {
                    pin.style.transform = '';
                }, 1200);
            }
        }

        // Photo Modal
        function viewPhotoModal(src, title) {
            document.getElementById('photoModalImg').src = src;
            document.getElementById('photoModalTitle').textContent = title + ' - Photo';
            document.getElementById('photoViewerModal').classList.add('show');
        }
        function closePhotoModal(e) {
            document.getElementById('photoViewerModal').classList.remove('show');
        }
    </script>
</body>
</html>
