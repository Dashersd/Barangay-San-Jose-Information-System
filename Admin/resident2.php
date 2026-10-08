<?php
require_once '../db_connect.php';

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $deleteId = $_POST['delete_id'] ?? '';
    if ($deleteId) {
        $stmt = $conn->prepare("DELETE FROM purok2_locations WHERE id = ?");
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1");
        exit;
    }
}

// Handle Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $editId = $_POST['edit_id'] ?? '';
    $houseNumber = $_POST['edit_houseNumber'] ?? '';
    $husbandName = $_POST['edit_husbandName'] ?? '';
    $spouseName = $_POST['edit_spouseName'] ?? '';
    
    $updateQuery = "UPDATE purok2_locations SET house_number=?, husband_name=?, spouse_name=?";
    $params = [$houseNumber, $husbandName, $spouseName];
    $types = "sss";
    
    if (isset($_FILES['edit_houseImage']) && $_FILES['edit_houseImage']['error'] === UPLOAD_ERR_OK) {
        $houseImageName = time() . '_' . basename($_FILES['edit_houseImage']['name']);
        $targetDir = '../assets/images/households/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        move_uploaded_file($_FILES['edit_houseImage']['tmp_name'], $targetDir . $houseImageName);
        $houseImagePath = 'assets/images/households/' . $houseImageName;
        
        $updateQuery .= ", house_image=?";
        $params[] = $houseImagePath;
        $types .= "s";
    }
    
    $updateQuery .= " WHERE id=?";
    $params[] = $editId;
    $types .= "i";
    
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param($types, ...$params);
    if ($stmt->execute()) {
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF'] . "?edited=1");
        exit;
    }
}

// Fetch all records
$records = [];
$result = $conn->query("SELECT * FROM purok2_locations ORDER BY id DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $records[] = [
            'id' => $row['id'],
            'houseNumber' => $row['house_number'],
            'husbandName' => $row['husband_name'],
            'spouseName' => $row['spouse_name'],
            'houseImage' => $row['house_image'],
            'markerImage' => $row['marker_image'],
            'dateAdded' => $row['date_added']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident 2 - Barangay San Jose</title>

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
    <link rel="stylesheet" href="css/resident2.css">
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
                        <li><a href="resident2.php" class="active">Resident 2</a></li>
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
                <h1>Households</h1>
                <div class="header-user-profile">
                    <div class="user-text">
                        <span class="user-name">System Admin</span>
                        <span class="user-role">Administrator</span>
                    </div>
                    <div class="user-avatar">A</div>
                </div>
            </header>

            <div class="admin-content">
                                <?php if (isset($_GET['edited']) && $_GET['edited'] == 1): ?>
                    <div style="background-color: #d1fae5; color: #065f46; padding: 12px 16px; margin-bottom: 20px; border-radius: 6px; border-left: 4px solid #10b981; display: flex; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 10px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <strong>Success!</strong>&nbsp; Record details have been successfully updated.
                    </div>
                <?php endif; ?>
                
                <div class="records-header">
                    <h2>Resident 2 Records</h2>
                </div>
                
                <div class="records-card">
                    <table class="records-table">
                        <thead>
                            <tr>
                                <th>House Image</th>
                                <th>House Number</th>
                                <th>Husband Name</th>
                                <th>Spouse Name</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                                                <tbody>
                            <?php if (empty($records)): ?>
                            <tr>
                                <td colspan="6" class="no-records">No records found.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($records as $record): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($record['houseImage'])): ?>
                                            <img src="../<?= htmlspecialchars($record['houseImage']) ?>" alt="House" style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        <?php else: ?>
                                            <span style="color: #94a3b8; font-style: italic;">No image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($record['houseNumber'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($record['husbandName'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($record['spouseName'] ?? '') ?></td>
                                    <td><?= date('M d, Y', strtotime($record['dateAdded'])) ?></td>
                                    <td>
                                        <button type="button" class="btn-action edit-btn" style="padding: 5px 10px; background: #0f766e; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 5px;" 
                                            data-id="<?= htmlspecialchars($record['id']) ?>"
                                            data-house="<?= htmlspecialchars($record['houseNumber'] ?? '') ?>"
                                            data-husband="<?= htmlspecialchars($record['husbandName'] ?? '') ?>"
                                            data-spouse="<?= htmlspecialchars($record['spouseName'] ?? '') ?>">
                                            Edit
                                        </button>
                                        <form method="POST" action="" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="delete_id" value="<?= htmlspecialchars($record['id']) ?>">
                                            <button type="submit" class="btn-action" style="padding: 5px 10px; background: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="js/dashboard.js"></script>
<!-- Edit Modal -->
    <div id="editModal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div class="modal-content" style="background: white; padding: 30px; border-radius: 8px; width: 100%; max-width: 500px;">
            <h2 style="margin-top: 0; margin-bottom: 20px; color: #1e293b;">Edit Record Details</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="edit_id" id="edit_id">
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; color: #475569;">House Number</label>
                    <input type="text" name="edit_houseNumber" id="edit_houseNumber" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; color: #475569;">Husband Name</label>
                    <input type="text" name="edit_husbandName" id="edit_husbandName" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; color: #475569;">Spouse Name (Maiden)</label>
                    <input type="text" name="edit_spouseName" id="edit_spouseName" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 5px; color: #475569;">Update House Image (Optional)</label>
                    <input type="file" name="edit_houseImage" class="form-control" accept="image/*" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <button type="submit" style="padding: 12px; background: #0f766e; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 16px;">Save Changes</button>
                    <button type="button" onclick="document.getElementById('editModal').style.display='none'" style="padding: 12px; background: #e2e8f0; color: #475569; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 16px;">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtns = document.querySelectorAll('.edit-btn');
        const editModal = document.getElementById('editModal');
        
        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_id').value = this.getAttribute('data-id');
                document.getElementById('edit_houseNumber').value = this.getAttribute('data-house');
                document.getElementById('edit_husbandName').value = this.getAttribute('data-husband');
                document.getElementById('edit_spouseName').value = this.getAttribute('data-spouse');
                editModal.style.display = 'flex';
            });
        });
        
        // Close modal when clicking outside
        if (editModal) {
            editModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        }
    });
    </script>
</body>
</html>

