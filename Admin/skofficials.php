<?php
// Manage SK Officials
require_once __DIR__ . '/../officials_db.php';

// Handle edit SK official form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_official') {
    $officialId = $_POST['official_id'] ?? '';
    $officialName = trim($_POST['official_name'] ?? '');
    $officialRole = trim($_POST['official_role'] ?? '');
    $officialMessage = trim($_POST['official_message'] ?? '');
    $newImagePath = null;

    // Handle photo upload
    if (isset($_FILES['official_photo']) && $_FILES['official_photo']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['official_photo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($ext, $allowed)) {
            $newFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($_FILES['official_photo']['name']));
            $targetDir = dirname(__DIR__) . '/assets/images/SK Official/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            if (move_uploaded_file($_FILES['official_photo']['tmp_name'], $targetDir . $newFileName)) {
                $newImagePath = 'assets/images/SK Official/' . $newFileName;
            }
        }
    }

    if ($officialId !== '') {
        update_sk_official_in_db($conn, $officialId, $officialName, $officialRole, $officialMessage, $newImagePath);
        header("Location: skofficials.php?success=1");
        exit;
    }
}

// Load current SK officials data from MySQL database (with JSON fallback)
$officials = get_sk_officials_from_db($conn);

// Organize by levels
$chairperson = null;
$level2 = [];
$kagawads = [];

foreach ($officials as $off) {
    if ($off['id'] === 'sk_chairperson' || $off['level'] == 1) {
        $chairperson = $off;
    } elseif ($off['id'] === 'sk_secretary' || $off['id'] === 'sk_treasurer' || $off['level'] == 2) {
        $level2[] = $off;
    } else {
        $kagawads[] = $off;
    }
}

// Split 7 SK Kagawads: 3 on Row 1 and 4 on Row 2 (matches layout)
$kagawadsRow1 = array_slice($kagawads, 0, 3);
$kagawadsRow2 = array_slice($kagawads, 3, 4);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage SK Officials - Admin Panel</title>

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
    <link rel="stylesheet" href="css/skofficials.css?v=<?= time() ?>">
</head>
<body>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert-toast" id="successToast">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
        <span>SK Official updated successfully!</span>
    </div>
    <script>
        setTimeout(function() {
            var toast = document.getElementById('successToast');
            if (toast) toast.style.display = 'none';
        }, 3500);
    </script>
    <?php endif; ?>

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
                    <a href="javascript:void(0)" class="dropdown-toggle open">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </span>
                        Officials
                        <svg class="chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                    <ul class="admin-dropdown-menu show">
                        <li><a href="barangayofficial.php">Barangay Officials</a></li>
                        <li><a href="skofficials.php" class="active">SK Officials</a></li>
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
                <h1>Manage SK Officials</h1>
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
                <div class="content-header d-flex justify-content-between align-items-center" style="margin-bottom: 1.5rem;">
                    <div>
                        <h2 style="margin: 0; font-size: 1.25rem;">SK Officials Roster</h2>
                        <p style="margin: 0; color: #6B7280; font-size: 0.85rem;">Edit or update Sangguniang Kabataan officials from the public roster.</p>
                    </div>
                </div>

                <div class="org-chart-container">
                    <!-- Level 1: SK Chairperson -->
                    <?php if ($chairperson): ?>
                    <div class="org-level">
                        <div class="official-card">
                            <div class="official-image-container">
                                <?php if (!empty($chairperson['image']) && file_exists('../' . $chairperson['image'])): ?>
                                    <img src="../<?= htmlspecialchars($chairperson['image']) ?>" alt="<?= htmlspecialchars($chairperson['name']) ?>" class="official-card-img">
                                <?php else: ?>
                                    <span class="official-placeholder-text">Photo</span>
                                <?php endif; ?>
                                <div class="official-name-pill"><?= htmlspecialchars($chairperson['name'] ?: 'Name') ?></div>
                            </div>
                            <div class="official-title"><?= htmlspecialchars($chairperson['role']) ?></div>
                            <button type="button" class="btn-edit-official" onclick="openEditOfficialModal(this)"
                                data-id="<?= htmlspecialchars($chairperson['id']) ?>"
                                data-name="<?= htmlspecialchars($chairperson['name']) ?>"
                                data-role="<?= htmlspecialchars($chairperson['role']) ?>"
                                data-message="<?= htmlspecialchars($chairperson['message'] ?? '') ?>"
                                data-image="<?= htmlspecialchars($chairperson['image'] ?? '') ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Level 2: SK Secretary & Treasurer -->
                    <?php if (!empty($level2)): ?>
                    <div class="org-level">
                        <?php foreach ($level2 as $off): ?>
                        <div class="official-card">
                            <div class="official-image-container">
                                <?php if (!empty($off['image']) && file_exists('../' . $off['image'])): ?>
                                    <img src="../<?= htmlspecialchars($off['image']) ?>" alt="<?= htmlspecialchars($off['name']) ?>" class="official-card-img">
                                <?php else: ?>
                                    <span class="official-placeholder-text">Photo</span>
                                <?php endif; ?>
                                <div class="official-name-pill"><?= htmlspecialchars($off['name'] ?: 'Name') ?></div>
                            </div>
                            <div class="official-title"><?= htmlspecialchars($off['role']) ?></div>
                            <button type="button" class="btn-edit-official" onclick="openEditOfficialModal(this)"
                                data-id="<?= htmlspecialchars($off['id']) ?>"
                                data-name="<?= htmlspecialchars($off['name']) ?>"
                                data-role="<?= htmlspecialchars($off['role']) ?>"
                                data-message="<?= htmlspecialchars($off['message'] ?? '') ?>"
                                data-image="<?= htmlspecialchars($off['image'] ?? '') ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                                <span>Edit</span>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Level 3: SK Kagawads Row 1 (3 items - SK Kagawad 1, 2, 3) -->
                    <?php if (!empty($kagawadsRow1)): ?>
                    <div class="org-level">
                        <?php foreach ($kagawadsRow1 as $off): ?>
                        <div class="official-card">
                            <div class="official-image-container">
                                <?php if (!empty($off['image']) && file_exists('../' . $off['image'])): ?>
                                    <img src="../<?= htmlspecialchars($off['image']) ?>" alt="<?= htmlspecialchars($off['name']) ?>" class="official-card-img">
                                <?php else: ?>
                                    <span class="official-placeholder-text">Photo</span>
                                <?php endif; ?>
                                <div class="official-name-pill"><?= htmlspecialchars($off['name'] ?: 'Name') ?></div>
                            </div>
                            <div class="official-title"><?= htmlspecialchars($off['role']) ?></div>
                            <button type="button" class="btn-edit-official" onclick="openEditOfficialModal(this)"
                                data-id="<?= htmlspecialchars($off['id']) ?>"
                                data-name="<?= htmlspecialchars($off['name']) ?>"
                                data-role="<?= htmlspecialchars($off['role']) ?>"
                                data-message="<?= htmlspecialchars($off['message'] ?? '') ?>"
                                data-image="<?= htmlspecialchars($off['image'] ?? '') ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                                <span>Edit</span>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Level 4: SK Kagawads Row 2 (4 items - SK Kagawad 4, 5, 6, 7) -->
                    <?php if (!empty($kagawadsRow2)): ?>
                    <div class="org-level">
                        <?php foreach ($kagawadsRow2 as $off): ?>
                        <div class="official-card">
                            <div class="official-image-container">
                                <?php if (!empty($off['image']) && file_exists('../' . $off['image'])): ?>
                                    <img src="../<?= htmlspecialchars($off['image']) ?>" alt="<?= htmlspecialchars($off['name']) ?>" class="official-card-img">
                                <?php else: ?>
                                    <span class="official-placeholder-text">Photo</span>
                                <?php endif; ?>
                                <div class="official-name-pill"><?= htmlspecialchars($off['name'] ?: 'Name') ?></div>
                            </div>
                            <div class="official-title"><?= htmlspecialchars($off['role']) ?></div>
                            <button type="button" class="btn-edit-official" onclick="openEditOfficialModal(this)"
                                data-id="<?= htmlspecialchars($off['id']) ?>"
                                data-name="<?= htmlspecialchars($off['name']) ?>"
                                data-role="<?= htmlspecialchars($off['role']) ?>"
                                data-message="<?= htmlspecialchars($off['message'] ?? '') ?>"
                                data-image="<?= htmlspecialchars($off['image'] ?? '') ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                                <span>Edit</span>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </main>
    </div>

    <!-- Edit SK Official Modal (Matches Reference Design) -->
    <div id="editOfficialModal" class="official-modal-overlay">
        <div class="official-modal-dialog">
            <div class="official-modal-header">
                <h3 class="official-modal-title">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <span>Edit SK Official</span>
                </h3>
                <button type="button" class="official-modal-close" id="modalCloseBtn" onclick="closeEditOfficialModal()" aria-label="Close">&times;</button>
            </div>
            
            <form action="skofficials.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_official">
                <input type="hidden" name="official_id" id="modalOfficialId" value="">

                <div class="official-modal-body">
                    <!-- Dashed container with Photo Preview and Change Photo button -->
                    <div class="photo-upload-container">
                        <div class="photo-preview-wrapper">
                            <img id="modalPhotoPreview" src="../assets/images/San Jose Logo 2.png" alt="Official Photo">
                        </div>
                        <button type="button" class="btn-change-photo" id="btnChangePhoto">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                <circle cx="12" cy="13" r="4"></circle>
                            </svg>
                            <span>Change Photo</span>
                        </button>
                        <input type="file" id="modalPhotoInput" name="official_photo" accept="image/*" style="display: none;">
                    </div>

                    <!-- Official Full Name -->
                    <div class="modal-form-group">
                        <label class="modal-label" for="modalOfficialName">Official Full Name</label>
                        <input type="text" id="modalOfficialName" name="official_name" class="modal-input" placeholder="e.g. Hon. Artem Macmac" required>
                    </div>

                    <!-- Role / Position -->
                    <div class="modal-form-group">
                        <label class="modal-label" for="modalOfficialRole">Role / Position</label>
                        <input type="text" id="modalOfficialRole" name="official_role" class="modal-input" placeholder="e.g. SK CHAIRPERSON" required>
                    </div>

                    <!-- Official Message (Only for SK Chairperson; hidden for other SK officials) -->
                    <div class="modal-form-group" id="modalMessageGroup" style="display: none;">
                        <label class="modal-label" for="modalOfficialMessage" id="modalMessageLabel">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span id="modalMessageLabelText">SK CHAIRPERSON'S MESSAGE</span>
                        </label>
                        <textarea id="modalOfficialMessage" name="official_message" rows="4" class="modal-textarea" placeholder="Enter message..."></textarea>
                        <div class="modal-helper-text" id="modalMessageHelp">
                            <span>&#9432;</span>
                            <span id="modalMessageHelpText">This message is displayed for the SK Chairperson on the public website.</span>
                        </div>
                    </div>
                </div>

                <div class="official-modal-footer">
                    <button type="button" class="btn-modal-cancel" id="btnModalCancel" onclick="closeEditOfficialModal()">Cancel</button>
                    <button type="submit" class="btn-modal-save" id="btnModalSave">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>SAVE CHANGES</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/dashboard.js"></script>
    <script>
    // Global function to open modal with SK official data
    window.openEditOfficialModal = function (btn) {
        const modal = document.getElementById('editOfficialModal');
        if (!modal) return;

        const id = btn.getAttribute('data-id') || '';
        const name = btn.getAttribute('data-name') || '';
        const role = btn.getAttribute('data-role') || '';
        const message = btn.getAttribute('data-message') || '';
        const image = btn.getAttribute('data-image') || '';

        const officialIdInput = document.getElementById('modalOfficialId');
        const officialNameInput = document.getElementById('modalOfficialName');
        const officialRoleInput = document.getElementById('modalOfficialRole');
        const officialMessageInput = document.getElementById('modalOfficialMessage');
        const photoPreview = document.getElementById('modalPhotoPreview');
        const modalMessageGroup = document.getElementById('modalMessageGroup');
        const modalMessageLabelText = document.getElementById('modalMessageLabelText');
        const modalMessageHelpText = document.getElementById('modalMessageHelpText');

        if (officialIdInput) officialIdInput.value = id;
        if (officialNameInput) officialNameInput.value = name;
        if (officialRoleInput) officialRoleInput.value = role;
        if (officialMessageInput) officialMessageInput.value = message;

        // Set photo preview
        if (photoPreview) {
            if (image) {
                photoPreview.src = image.startsWith('../') ? image : ('../' + image);
            } else {
                photoPreview.src = '../assets/images/San Jose Logo 2.png';
            }
        }

        // Only the SK Chairperson / Chairman has the message textbox; completely hide for all other SK officials
        const isChairperson = (id === 'sk_chairperson' || role.toLowerCase().includes('chairperson') || role.toLowerCase().includes('chairman'));
        if (modalMessageGroup) {
            if (isChairperson) {
                modalMessageGroup.style.display = 'block';
                if (modalMessageLabelText) modalMessageLabelText.textContent = "SK CHAIRPERSON'S MESSAGE";
                if (modalMessageHelpText) modalMessageHelpText.textContent = "This message is displayed for the SK Chairperson on the public website.";
            } else {
                modalMessageGroup.style.display = 'none';
            }
        }

        // Show modal
        modal.style.display = 'flex';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    };

    // Global function to close modal
    window.closeEditOfficialModal = function () {
        const modal = document.getElementById('editOfficialModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
        const photoInput = document.getElementById('modalPhotoInput');
        if (photoInput) photoInput.value = '';
    };

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('editOfficialModal');
        const modalCloseBtn = document.getElementById('modalCloseBtn');
        const btnModalCancel = document.getElementById('btnModalCancel');
        const editBtns = document.querySelectorAll('.btn-edit-official');
        
        const photoInput = document.getElementById('modalPhotoInput');
        const btnChangePhoto = document.getElementById('btnChangePhoto');
        const photoPreview = document.getElementById('modalPhotoPreview');

        editBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                window.openEditOfficialModal(this);
            });
        });

        if (modalCloseBtn) modalCloseBtn.addEventListener('click', window.closeEditOfficialModal);
        if (btnModalCancel) btnModalCancel.addEventListener('click', window.closeEditOfficialModal);

        // Click outside modal content to close
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    window.closeEditOfficialModal();
                }
            });
        }

        // ESC key to close
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                window.closeEditOfficialModal();
            }
        });

        // Change Photo button click
        if (btnChangePhoto && photoInput) {
            btnChangePhoto.addEventListener('click', function () {
                photoInput.click();
            });

            // Instant image preview
            photoInput.addEventListener('change', function () {
                if (this.files && this.files[0] && photoPreview) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        photoPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
    </script>
</body>
</html>
