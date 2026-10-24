<?php require_once 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spot Map - Barangay San Jose</title>
    
    <!-- Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="assets/images/San Jose Logo 2.png">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/spotmap.css?v=<?= time() ?>">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="navbar-container">
            <!-- Logo & Brand -->
            <div class="navbar-brand">
                <img src="assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="navbar-logo">
                <img src="assets/images/Lapuyan Logo.png" alt="Municipality of Lapuyan Logo" class="navbar-logo">
                <div class="brand-text">
                    <span class="brand-title">BARANGAY SAN JOSE</span>
                    <span class="brand-subtitle">Bayanihan &bull; Serbisyong Totoo</span>
                </div>
            </div>

            <!-- Desktop Links -->
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="nav-link">About Us <i class="fas fa-chevron-down" style="font-size: 0.8em; margin-left: 5px;"></i></a>
                    <div class="dropdown-content">
                        <a href="about.php#history">History</a>
                        <a href="vision.php">Vision</a>
                        <a href="mission.php">Mission</a>
                        <a href="officials.php">Barangay Officials</a>
                        <a href="skofficials.php">SK Officials</a>
                    </div>
                </li>
                <li><a href="announcement.php">Announcement</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="spotmap.php" class="active">Spot Map</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <!-- Right Side: Admin Login -->
            <div class="navbar-right">
                <a href="Admin/login.php" class="admin-login-link">Admin Login</a>
            </div>
        </div>
    </nav>

    <!-- 1. Hero Section -->
    <section class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <p class="hero-subtitle" data-aos="fade-up">SPOT MAP</p>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">BARANGAY SAN JOSE</h1>
                <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">Overview and geographical layout of Barangay San Jose.</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <section class="spotmap-section">
            <div class="container sm-layout-container">
                <!-- Left Column: Cards -->
                <div class="sm-sidebar">
                    
                    <!-- Map Legend Card -->
                    <div class="sm-card" data-aos="fade-right">
                        <div class="sm-card-header">
                            <div class="sm-badge-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                EXPLORE
                            </div>
                            <h2 class="sm-card-title">Barangay Spot Map</h2>
                        </div>
                        
                        <div class="sm-legend-section">
                            <h3 class="sm-legend-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#fdb913" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                                Map Legend
                            </h3>
                            
                            <div class="sm-legend-grid">
                                <?php
                                $mapLegends = [];
                                if (isset($conn) && $conn) {
                                    $legendRes = $conn->query("SELECT * FROM legends WHERE status = 'Active' ORDER BY display_order ASC, id ASC");
                                    if ($legendRes && $legendRes->num_rows > 0) {
                                        while ($lRow = $legendRes->fetch_assoc()) {
                                            $mapLegends[] = $lRow;
                                        }
                                    }
                                }
                                if (empty($mapLegends)) {
                                    $jsonLegendFile = __DIR__ . '/Admin/data/legends.json';
                                    if (file_exists($jsonLegendFile)) {
                                        $decoded = json_decode(file_get_contents($jsonLegendFile), true);
                                        if (is_array($decoded) && !empty($decoded)) {
                                            foreach ($decoded as $dItem) {
                                                if (($dItem['status'] ?? 'Active') === 'Active') {
                                                    $mapLegends[] = $dItem;
                                                }
                                            }
                                        }
                                    }
                                }

                                if (empty($mapLegends)): ?>
                                    <div class="sm-no-legends" style="grid-column: 1 / -1; padding: 14px 8px; text-align: center; color: #94a3b8; font-size: 0.85rem; font-style: italic;">
                                        No map legends added yet.
                                    </div>
                                <?php else:
                                    foreach ($mapLegends as $legendItem):
                                        $lId = intval($legendItem['id'] ?? 0);
                                        $legName = htmlspecialchars($legendItem['category_name'] ?? 'Legend');
                                        $iconSrc = $legendItem['icon_path'] ?? '';
                                        $iconType = $legendItem['icon_type'] ?? '';
                                        $iconColor = htmlspecialchars($legendItem['color'] ?? '#004b93');
                                ?>
                                <div class="sm-legend-item" title="<?= $legName ?>" onclick="highlightLandmark(<?= $lId ?>)" style="cursor: pointer;">
                                    <span class="sm-icon-bg">
                                        <?php if (!empty($iconType)): ?>
                                            <i class="bi <?= htmlspecialchars($iconType) ?>" style="color: <?= $iconColor ?>; font-size: 15px;"></i>
                                        <?php elseif (!empty($iconSrc) && (file_exists($iconSrc) || file_exists(__DIR__ . '/' . $iconSrc))): ?>
                                            <img src="<?= htmlspecialchars($iconSrc) ?>" alt="<?= $legName ?>" class="sm-legend-img">
                                        <?php else: ?>
                                            <svg viewBox="0 0 24 24" fill="none" stroke="<?= $iconColor ?>" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
                                        <?php endif; ?>
                                    </span>
                                    <span class="sm-legend-name"><?= $legName ?></span>
                                </div>
                                <?php endforeach;
                                endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Puroks Card -->
                    <div class="sm-card" data-aos="fade-right" data-aos-delay="100">
                        <div class="sm-card-header">
                            <h3 class="sm-legend-title" style="margin-bottom: 20px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#fdb913" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                4 Puroks of Barangay San Jose
                            </h3>
                            
                            <button type="button" class="sm-btn" onclick="showAerialMap()" style="margin-bottom: 12px; cursor: pointer;" title="View Aerial Spot Map with 4 Purok Pins">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                View Aerial Map (4 Puroks)
                            </button>
                            <div class="sm-purok-grid">
                                <span class="sm-purok-badge" data-image="assets/images/Purok/Purok 1.jpg" onclick="changeMap(this)">Purok 1</span>
                                <span class="sm-purok-badge" data-image="assets/images/Purok/Purok 2.jpg" onclick="changeMap(this)">Purok 2</span>
                                <span class="sm-purok-badge" data-image="assets/images/Purok/Purok 3.jpg" onclick="changeMap(this)">Purok 3</span>
                                <span class="sm-purok-badge" data-image="assets/images/Purok/Purok 4.jpg" onclick="changeMap(this)">Purok 4</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Map Image -->
                <div class="sm-map-content" data-aos="zoom-in">
                    <div class="sm-map-image-wrapper">
                        <button class="sm-overview-btn sm-floating-btn" onclick="resetMap()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            Overview Map
                        </button>
                        <!-- Initial image is Philippines.png -->
                        <img src="assets/images/Map/Philippines.png" alt="Barangay Spot Map" id="mainMapImage" onerror="this.src='https://placehold.co/1200x800/e2e8f0/64748b?text=Spot+Map+Image'" style="cursor: default;">
                        
                        <!-- Pin on Philippines Map pointing to San Jose / Zamboanga del Sur (Mindanao) -->
                        <div class="map-pin" id="philippinesPin" title="Click to view Barangay San Jose" style="left: 56%; top: 78%; display: flex;">
                            <svg viewBox="0 0 24 24" fill="#ef4444" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3" fill="#ffffff"></circle>
                            </svg>
                            <div class="pin-pulse"></div>
                        </div>

                        <!-- Pin on Mindanao Map -->
                        <div class="map-pin" id="mindanaoPin" title="Click to view Zamboanga del Sur" style="left: 58.3%; top: 67%; display: none;">
                            <svg viewBox="0 0 24 24" fill="#ef4444" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3" fill="#ffffff"></circle>
                            </svg>
                            <div class="pin-pulse"></div>
                        </div>

                        <!-- Pin on Zamboanga del Sur Map (Lapuyan text) -->
                        <div class="map-pin" id="lapuyanPin" title="Click to view Lapuyan" style="left: 56.7%; top: 61.3%; display: none;">
                            <svg viewBox="0 0 24 24" fill="#ef4444" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3" fill="#ffffff"></circle>
                            </svg>
                            <div class="pin-pulse"></div>
                        </div>

                        <!-- Pin on Lapuyan Map (Lapuyan text) -->
                        <div class="map-pin" id="lapuyanGifPin" title="Click to view Barangay San Jose" style="left: 54%; top: 49%; display: none;">
                            <svg viewBox="0 0 24 24" fill="#ef4444" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3" fill="#ffffff"></circle>
                            </svg>
                            <div class="pin-pulse"></div>
                        </div>

                        <div class="map-pin" id="sanJosePin" title="Click to view San Jose Satellite Map" style="display: none;">
                            <svg viewBox="0 0 24 24" fill="#ef4444" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3" fill="#ffffff"></circle>
                            </svg>
                            <div class="pin-pulse"></div>
                        </div>

                        <!-- 4 Purok Pins Layer on Legend (Aerial View) Map -->
                        <div id="purokPinsContainer" class="purok-pins-container" style="display: none;">
                            <div class="purok-map-pin" id="purokPin1" data-image="assets/images/Purok/Purok 1.jpg" data-purok="1" style="top: 26%; left: 30%;" title="Click to view Purok 1" role="button" tabindex="0">
                                <div class="purok-pin-tooltip">Explore Purok 1</div>
                                <div class="purok-pin-badge">
                                    <svg viewBox="0 0 24 24" fill="#fdb913" width="15" height="15"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                    <span>Purok 1</span>
                                </div>
                                <div class="purok-pin-pointer"></div>
                                <div class="purok-pin-dot">
                                    <div class="purok-pin-pulse"></div>
                                </div>
                            </div>

                            <div class="purok-map-pin" id="purokPin2" data-image="assets/images/Purok/Purok 2.jpg" data-purok="2" style="top: 52%; left: 42%;" title="Click to view Purok 2" role="button" tabindex="0">
                                <div class="purok-pin-tooltip">Explore Purok 2</div>
                                <div class="purok-pin-badge">
                                    <svg viewBox="0 0 24 24" fill="#fdb913" width="15" height="15"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                    <span>Purok 2</span>
                                </div>
                                <div class="purok-pin-pointer"></div>
                                <div class="purok-pin-dot">
                                    <div class="purok-pin-pulse"></div>
                                </div>
                            </div>

                            <div class="purok-map-pin" id="purokPin3" data-image="assets/images/Purok/Purok 3.jpg" data-purok="3" style="top: 52%; left: 58%;" title="Click to view Purok 3" role="button" tabindex="0">
                                <div class="purok-pin-tooltip">Explore Purok 3</div>
                                <div class="purok-pin-badge">
                                    <svg viewBox="0 0 24 24" fill="#fdb913" width="15" height="15"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                    <span>Purok 3</span>
                                </div>
                                <div class="purok-pin-pointer"></div>
                                <div class="purok-pin-dot">
                                    <div class="purok-pin-pulse"></div>
                                </div>
                            </div>

                            <div class="purok-map-pin" id="purokPin4" data-image="assets/images/Purok/Purok 4.jpg" data-purok="4" style="top: 48%; left: 74%;" title="Click to view Purok 4" role="button" tabindex="0">
                                <div class="purok-pin-tooltip">Explore Purok 4</div>
                                <div class="purok-pin-badge">
                                    <svg viewBox="0 0 24 24" fill="#fdb913" width="15" height="15"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                    <span>Purok 4</span>
                                </div>
                                <div class="purok-pin-pointer"></div>
                                <div class="purok-pin-dot">
                                    <div class="purok-pin-pulse"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Landmark Pins Layer on Legend (Aerial View) Map (From Admin Legends) -->
                        <div id="landmarkPinsContainer" class="landmark-pins-container" style="display: none;">
                            <?php foreach ($mapLegends as $legItem): ?>
                                <?php 
                                    if (($legItem['status'] ?? 'Active') === 'Inactive') continue;
                                    $lId = intval($legItem['id'] ?? 0);
                                    $lName = htmlspecialchars($legItem['category_name'] ?? '');
                                    $lTop = floatval($legItem['top_pos'] ?? 50.0);
                                    $lLeft = floatval($legItem['left_pos'] ?? 50.0);
                                    $lColor = htmlspecialchars($legItem['color'] ?? '#6366f1');
                                    $lIcon = htmlspecialchars($legItem['icon_type'] ?? 'bi-building-fill');
                                    $lPhoto = !empty($legItem['photo']) ? htmlspecialchars($legItem['photo']) : '';
                                    $lDesc = !empty($legItem['description']) ? htmlspecialchars($legItem['description']) : '';
                                ?>
                                <div class="sm-landmark-pin" 
                                     id="landmarkPin_<?= $lId ?>"
                                     style="top: <?= $lTop ?>%; left: <?= $lLeft ?>%;"
                                     title="<?= $lName ?>"
                                     data-id="<?= $lId ?>"
                                     data-name="<?= $lName ?>"
                                     data-photo="<?= $lPhoto ?>"
                                     data-desc="<?= $lDesc ?>"
                                     data-color="<?= $lColor ?>"
                                     onclick="openLandmarkModal(this)">
                                    <div class="sm-landmark-pill">
                                        <span><?= $lName ?></span>
                                    </div>
                                    <div class="sm-landmark-icon-wrap" style="background-color: <?= $lColor ?>;">
                                        <i class="bi <?= $lIcon ?>"></i>
                                    </div>
                                    <div class="sm-landmark-dot" style="background-color: <?= $lColor ?>;">
                                        <div class="sm-landmark-pulse" style="background-color: <?= $lColor ?>;"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Markers Layers -->
                        <div id="markers-purok1" class="purok-markers" style="display: none;">
                            <?php
                            if(isset($conn)){
                                $res1 = $conn->query("SELECT * FROM purok1_locations");
                                if($res1){
                                    while($row = $res1->fetch_assoc()){
                                        if(!empty($row['marker_image'])){
                                            echo "<img class='house-marker' data-image='".htmlspecialchars($row['house_image'])."' data-house='".htmlspecialchars($row['house_number'])."' data-husband='".htmlspecialchars($row['husband_name'])."' data-spouse='".htmlspecialchars($row['spouse_name'])."' data-children='".htmlspecialchars($row['children'] ?? '[]', ENT_QUOTES)."' src='".htmlspecialchars($row['marker_image'])."' style='position: absolute; top: {$row['top_position']}%; left: {$row['left_position']}%; width: {$row['marker_width']}px; height: {$row['marker_height']}px; transform: translate(-50%, -50%); z-index: 10; cursor: pointer;' alt='Marker' title='House {$row['house_number']} - {$row['husband_name']}'>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        
                        <div id="markers-purok2" class="purok-markers" style="display: none;">
                            <?php
                            if(isset($conn)){
                                $res2 = $conn->query("SELECT * FROM purok2_locations");
                                if($res2){
                                    while($row = $res2->fetch_assoc()){
                                        if(!empty($row['marker_image'])){
                                            echo "<img class='house-marker' data-image='".htmlspecialchars($row['house_image'])."' data-house='".htmlspecialchars($row['house_number'])."' data-husband='".htmlspecialchars($row['husband_name'])."' data-spouse='".htmlspecialchars($row['spouse_name'])."' data-children='".htmlspecialchars($row['children'] ?? '[]', ENT_QUOTES)."' src='".htmlspecialchars($row['marker_image'])."' style='position: absolute; top: {$row['top_position']}%; left: {$row['left_position']}%; width: {$row['marker_width']}px; height: {$row['marker_height']}px; transform: translate(-50%, -50%); z-index: 10; cursor: pointer;' alt='Marker' title='House {$row['house_number']} - {$row['husband_name']}'>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>

                        <div id="markers-purok3" class="purok-markers" style="display: none;">
                            <?php
                            if(isset($conn)){
                                $res3 = $conn->query("SELECT * FROM purok3_locations");
                                if($res3){
                                    while($row = $res3->fetch_assoc()){
                                        if(!empty($row['marker_image'])){
                                            echo "<img class='house-marker' data-image='".htmlspecialchars($row['house_image'])."' data-house='".htmlspecialchars($row['house_number'])."' data-husband='".htmlspecialchars($row['husband_name'])."' data-spouse='".htmlspecialchars($row['spouse_name'])."' data-children='".htmlspecialchars($row['children'] ?? '[]', ENT_QUOTES)."' src='".htmlspecialchars($row['marker_image'])."' style='position: absolute; top: {$row['top_position']}%; left: {$row['left_position']}%; width: {$row['marker_width']}px; height: {$row['marker_height']}px; transform: translate(-50%, -50%); z-index: 10; cursor: pointer;' alt='Marker' title='House {$row['house_number']} - {$row['husband_name']}'>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>

                        <div id="markers-purok4" class="purok-markers" style="display: none;">
                            <?php
                            if(isset($conn)){
                                $res4 = $conn->query("SELECT * FROM purok4_locations");
                                if($res4){
                                    while($row = $res4->fetch_assoc()){
                                        if(!empty($row['marker_image'])){
                                            echo "<img class='house-marker' data-image='".htmlspecialchars($row['house_image'])."' data-house='".htmlspecialchars($row['house_number'])."' data-husband='".htmlspecialchars($row['husband_name'])."' data-spouse='".htmlspecialchars($row['spouse_name'])."' data-children='".htmlspecialchars($row['children'] ?? '[]', ENT_QUOTES)."' src='".htmlspecialchars($row['marker_image'])."' style='position: absolute; top: {$row['top_position']}%; left: {$row['left_position']}%; width: {$row['marker_width']}px; height: {$row['marker_height']}px; transform: translate(-50%, -50%); z-index: 10; cursor: pointer;' alt='Marker' title='House {$row['house_number']} - {$row['husband_name']}'>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Household Details Modal -->
        <div class="household-modal-overlay" id="householdModal">
            <div class="household-modal-box">
                <span class="household-modal-close" onclick="document.getElementById('householdModal').style.display='none'">&times;</span>
                <h3 class="household-modal-title">Household Details</h3>
                <p class="household-modal-subtitle">Barangay San Jose</p>
                
                <div class="household-modal-img-container">
                    <img src="" id="modalHouseImage" alt="Household Image" onerror="this.src='https://placehold.co/400x400/e2e8f0/64748b?text=No+Photo'">
                </div>
                
                <div class="household-modal-details">
                    <div class="hm-row">
                        <span class="hm-label">House Number</span>
                        <span class="hm-value" id="modalHouseNumber"></span>
                    </div>
                    <div class="hm-row">
                        <span class="hm-label">Husband/Head</span>
                        <span class="hm-value" id="modalHusbandName"></span>
                    </div>
                    <div class="hm-row">
                        <span class="hm-label">Spouse Name</span>
                        <span class="hm-value" id="modalSpouseName"></span>
                    </div>
                    <div class="hm-col" id="modalChildrenRow">
                        <span class="hm-label">Children</span>
                        <div class="hm-value" id="modalChildrenList"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Landmark Photo / Details Modal -->
        <div id="landmarkModal" class="landmark-modal-overlay" style="display: none;" onclick="closeLandmarkModal(event)">
            <div class="landmark-modal-dialog" onclick="event.stopPropagation()">
                <span class="landmark-modal-close" onclick="closeLandmarkModal()">&times;</span>
                <div class="landmark-modal-header">
                    <div class="landmark-modal-badge" id="lmBadgeWrap">
                        <i id="lmBadgeIcon" class="bi bi-building-fill"></i>
                    </div>
                    <div>
                        <h3 class="landmark-modal-title" id="lmTitle">Landmark Details</h3>
                        <span class="landmark-modal-subtitle">Barangay San Jose, Lapuyan</span>
                    </div>
                </div>
                
                <div class="landmark-modal-photo-wrap" id="lmPhotoContainer" style="display: none;">
                    <img src="" id="lmPhotoImg" alt="Landmark Photo">
                </div>
                
                <div class="landmark-modal-body">
                    <p id="lmDesc" style="color: #475569; font-size: 0.9rem; line-height: 1.5; margin: 0;"></p>
                </div>
            </div>
        </div>

        <!-- Script to handle pin and badge clicks -->
        <script src="assets/js/spotmap.js?v=<?= time() ?>"></script>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-container">
                <!-- Left Side: Logo & Brand -->
                <div class="footer-brand">
                    <img src="assets/images/San Jose Logo 2.png" alt="Barangay San Jose Logo" class="footer-logo">
                    <img src="assets/images/Lapuyan Logo.png" alt="Municipality of Lapuyan Logo" class="footer-logo">
                    <div class="footer-brand-text">
                        <h2>BARANGAY<br>SAN JOSE</h2>
                        <p>Bayanihan &bull; Serbisyong Totoo</p>
                    </div>
                </div>

                <!-- Right Side: Links -->
                <div class="footer-links-wrapper">
                    <a href="index.php">HOME</a>
                    <a href="about.php">ABOUT US</a>
                    <a href="about.php#history">HISTORY</a>
                    <a href="vision.php">VISION</a>
                    <a href="mission.php">MISSION</a>
                    <a href="officials.php">OFFICIALS</a>
                    <a href="skofficials.php">SK OFFICIALS</a>
                    <a href="announcement.php">ANNOUNCEMENTS</a>
                    <a href="gallery.php">GALLERY</a>
                    <a href="spotmap.php">SPOT MAP</a>
                    <a href="services.php">SERVICES</a>
                    <a href="contact.php">CONTACT US</a>
                </div>
            </div>

            <!-- Divider & Bottom Section -->
            <div class="footer-bottom">
                <hr class="footer-divider">
                
                <!-- Social Icons -->
                <div class="footer-socials">
                    <a href="#" class="social-icon" aria-label="Facebook">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    </a>
                    <a href="#" class="social-icon" aria-label="Twitter">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                    </a>
                    <a href="#" class="social-icon" aria-label="Email">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </a>
                </div>
                
                <p class="footer-copyright">&copy; Copyright. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- JavaScript -->
    <script src="assets/js/main.js?v=2"></script>

</body>
</html>
