<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $houseNumber = $_POST['houseNumber'] ?? '';
    $husbandName = $_POST['husbandName'] ?? '';
    $spouseName = $_POST['spouseName'] ?? '';
    $markerWidth = $_POST['markerWidth'] ?? '40';
    $markerHeight = $_POST['markerHeight'] ?? '40';
    $topPosition = $_POST['topPosition'] ?? '50.00';
    $leftPosition = $_POST['leftPosition'] ?? '50.00';
    $dateAdded = date('Y-m-d H:i:s');

    // Handle file uploads
    $houseImagePath = '';
    if (isset($_FILES['houseImage']) && $_FILES['houseImage']['error'] === UPLOAD_ERR_OK) {
        $houseImageName = time() . '_' . basename($_FILES['houseImage']['name']);
        $targetDir = '../assets/images/households/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        move_uploaded_file($_FILES['houseImage']['tmp_name'], $targetDir . $houseImageName);
        $houseImagePath = 'assets/images/households/' . $houseImageName;
    }

    $markerImagePath = '';
    if (isset($_FILES['markerImage']) && $_FILES['markerImage']['error'] === UPLOAD_ERR_OK) {
        $markerImageName = time() . '_' . basename($_FILES['markerImage']['name']);
        $targetDir = '../assets/images/markers/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        move_uploaded_file($_FILES['markerImage']['tmp_name'], $targetDir . $markerImageName);
        $markerImagePath = 'assets/images/markers/' . $markerImageName;
    }

    require_once '../db_connect.php';

    $stmt = $conn->prepare("INSERT INTO purok4_locations (legend_id, house_number, husband_name, spouse_name, house_image, marker_image, marker_width, marker_height, top_position, left_position) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $legend_id = 1; // Assuming default to Household
    $stmt->bind_param("isssssiidd", $legend_id, $houseNumber, $husbandName, $spouseName, $houseImagePath, $markerImagePath, $markerWidth, $markerHeight, $topPosition, $leftPosition);
    $stmt->execute();
    $stmt->close();
    
    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Legends - Admin Panel</title>

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
    <link rel="stylesheet" href="css/legends_v2.css">
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
                        <li><a href="purok4.php" class="active">Purok 4</a></li>
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
                <h1>Manage Legends</h1>
                <div class="header-user-profile">
                    <div class="user-text">
                        <span class="user-name">System Admin</span>
                        <span class="user-role">Administrator</span>
                    </div>
                    <div class="user-avatar">A</div>
                </div>
            </header>

            <!-- Content Area -->
            <!-- Content Area -->
            <div class="admin-content">
                                <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                    <div style="background-color: #d1fae5; color: #065f46; padding: 12px 16px; margin-bottom: 20px; border-radius: 6px; border-left: 4px solid #10b981; display: flex; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 10px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <strong>Success!</strong>&nbsp; Household marker has been successfully saved to the map.
                    </div>
                <?php endif; ?>
                
                <div class="content-header">
                    <h2>Add House to Map</h2>
                    <p>Upload a marker, add members, and drag the icon to save to the map</p>
                </div>

                                <div class="map-preview-area" id="mapPreviewArea" style="position: relative; display: inline-block; width: 100%;">
                    <img src="../assets/images/Purok/Purok 4.jpg" alt="Map Background" class="map-preview-image" style="width: 100%; display: block;">
                    
                    <?php
                    require_once '../db_connect.php';
                    $result = $conn->query("SELECT * FROM purok4_locations");
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            if (!empty($row['marker_image'])) {
                                $top = htmlspecialchars($row['top_position']);
                                $left = htmlspecialchars($row['left_position']);
                                $width = htmlspecialchars($row['marker_width']);
                                $height = htmlspecialchars($row['marker_height']);
                                $src = htmlspecialchars($row['marker_image']);
                                $title = htmlspecialchars($row['house_number'] . " - " . $row['husband_name']);
                                echo "<img src='../$src' style='position: absolute; top: {$top}%; left: {$left}%; width: {$width}px; height: {$height}px; transform: translate(-50%, -50%); z-index: 10; cursor: pointer;' alt='Marker' title='$title'>";
                            }
                        }
                    }
                    ?>
                </div>

                <form action="" method="POST" enctype="multipart/form-data" class="legend-form">
                    
                    <div class="form-group">
                        <label for="houseNumber">House Number</label>
                        <input type="text" id="houseNumber" name="houseNumber" class="form-control" placeholder="e.g. 123">
                    </div>
                    <div class="form-group">
                        <label>Household Name</label>
                        <div class="form-row" style="display: flex; gap: 15px;">
                            <div class="form-col" style="flex: 1;">
                                <input type="text" name="husbandName" class="form-control" placeholder="Name of the Husband (e.g. Juan Dela Cruz)">
                            </div>
                            <div class="form-col" style="flex: 1;">
                                <input type="text" name="spouseName" class="form-control" placeholder="Name of the Spouse (Maiden) (e.g. Maria Santos)">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="houseImage">House Image (Actual Photo)</label>
                        <input type="file" id="houseImage" name="houseImage" class="form-control" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="markerImage">Marker Image (Icon shown on map)</label>
                        <input type="file" id="markerImage" name="markerImage" class="form-control" accept="image/*">
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <label for="markerWidth">Marker Width (px)</label>
                            <input type="number" id="markerWidth" name="markerWidth" class="form-control" value="40">
                        </div>
                        <div class="form-col">
                            <label for="markerHeight">Marker Height (px)</label>
                            <input type="number" id="markerHeight" name="markerHeight" class="form-control" value="40">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <label for="topPosition">Top position (%)</label>
                            <input type="number" id="topPosition" name="topPosition" class="form-control" value="50.00" step="0.01">
                        </div>
                        <div class="form-col">
                            <label for="leftPosition">Left position (%)</label>
                            <input type="number" id="leftPosition" name="leftPosition" class="form-control" value="50.00" step="0.01">
                        </div>
                    </div>

                    <button type="submit" class="btn-save-map">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save to Map
                    </button>
                </form>

            </div>
        </main>
    </div>

    <script src="js/dashboard.js"></script>
    <script src="js/map-marker-preview.js"></script>
</body>
</html>







