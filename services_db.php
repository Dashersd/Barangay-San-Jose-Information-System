<?php
// services_db.php - Central database management for Barangay Services
require_once __DIR__ . '/db_connect.php';

/**
 * Ensure `services` table exists and contains initial default services if empty
 */
function init_services_table($conn) {
    if (!$conn || $conn->connect_error) {
        return;
    }

    $tableSql = "CREATE TABLE IF NOT EXISTS `services` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `title` VARCHAR(150) NOT NULL,
        `description` TEXT NOT NULL,
        `requirements` TEXT DEFAULT NULL,
        `fee` VARCHAR(100) DEFAULT 'Free',
        `processing_time` VARCHAR(100) DEFAULT 'Same Day',
        `icon` VARCHAR(50) NOT NULL DEFAULT 'document',
        `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
        `btn_text` VARCHAR(50) DEFAULT 'Request Document',
        `btn_link` VARCHAR(255) DEFAULT 'contact.php',
        `display_order` INT(11) NOT NULL DEFAULT 0,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $conn->query($tableSql);

    // Check if table is empty; if so, seed the default services from Barangay San Jose
    $checkRes = $conn->query("SELECT COUNT(*) AS total FROM `services`");
    $count = $checkRes ? (int)$checkRes->fetch_assoc()['total'] : 0;

    if ($count === 0) {
        $defaultServices = [
            [
                'title' => 'Barangay Clearance',
                'description' => 'Request a Barangay Clearance for employment, banking, or other legal purposes. Essential for verifying your residency and good standing.',
                'requirements' => '1 Valid Government-issued ID, Cedula (Community Tax Certificate)',
                'fee' => '₱50.00',
                'processing_time' => '15-30 Minutes',
                'icon' => 'document',
                'status' => 'active',
                'btn_text' => 'Request Document',
                'btn_link' => 'contact.php',
                'display_order' => 1
            ],
            [
                'title' => 'Certificate of Indigency',
                'description' => 'Obtain a Certificate of Indigency to avail of government assistance, scholarships, and medical support programs.',
                'requirements' => 'Certificate from Purok Leader / Case Study Report',
                'fee' => 'Free',
                'processing_time' => 'Same Day',
                'icon' => 'home',
                'status' => 'active',
                'btn_text' => 'Request Document',
                'btn_link' => 'contact.php',
                'display_order' => 2
            ],
            [
                'title' => 'Business Clearance',
                'description' => 'Required for all new and renewing businesses operating within the barangay jurisdiction prior to Mayor\'s permit application.',
                'requirements' => 'DTI/SEC Registration, Lease Contract or Proof of Property Ownership',
                'fee' => '₱200.00',
                'processing_time' => '1-2 Business Days',
                'icon' => 'briefcase',
                'status' => 'active',
                'btn_text' => 'Request Document',
                'btn_link' => 'contact.php',
                'display_order' => 3
            ],
            [
                'title' => 'Certificate of Residency',
                'description' => 'Proof of your residency within the barangay. Often required for school enrollments, ID applications, and other local transactions.',
                'requirements' => '1 Valid ID with current address, Barangay Clearance',
                'fee' => '₱50.00',
                'processing_time' => 'Same Day',
                'icon' => 'id-card',
                'status' => 'active',
                'btn_text' => 'Request Document',
                'btn_link' => 'contact.php',
                'display_order' => 4
            ]
        ];

        $insStmt = $conn->prepare("INSERT INTO `services` 
            (`title`, `description`, `requirements`, `fee`, `processing_time`, `icon`, `status`, `btn_text`, `btn_link`, `display_order`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($insStmt) {
            foreach ($defaultServices as $srv) {
                $insStmt->bind_param(
                    "sssssssssi",
                    $srv['title'],
                    $srv['description'],
                    $srv['requirements'],
                    $srv['fee'],
                    $srv['processing_time'],
                    $srv['icon'],
                    $srv['status'],
                    $srv['btn_text'],
                    $srv['btn_link'],
                    $srv['display_order']
                );
                $insStmt->execute();
            }
            $insStmt->close();
        }
    }
}

// Always ensure table is created/ready when file is included
init_services_table($conn);

/**
 * Fetch all services
 * @param mysqli $conn
 * @param bool $activeOnly If true, returns only active services
 * @return array
 */
function get_all_services($conn, $activeOnly = false) {
    $services = [];
    if (!$conn || $conn->connect_error) return $services;

    $sql = "SELECT * FROM `services`";
    if ($activeOnly) {
        $sql .= " WHERE `status` = 'active'";
    }
    $sql .= " ORDER BY `display_order` ASC, `id` ASC";

    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
    }
    return $services;
}

/**
 * Fetch single service by ID
 */
function get_service_by_id($conn, $id) {
    if (!$conn || $conn->connect_error) return null;

    $stmt = $conn->prepare("SELECT * FROM `services` WHERE `id` = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $service = $res->fetch_assoc();
    $stmt->close();
    return $service;
}

/**
 * Add a new service
 */
function add_service($conn, $data) {
    if (!$conn || $conn->connect_error) return false;

    $title = trim($data['title'] ?? '');
    $desc = trim($data['description'] ?? '');
    $reqs = trim($data['requirements'] ?? '');
    $fee = trim($data['fee'] ?? 'Free');
    $time = trim($data['processing_time'] ?? 'Same Day');
    $icon = trim($data['icon'] ?? 'document');
    $status = ($data['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';
    $btnText = trim($data['btn_text'] ?? 'Request Document');
    $btnLink = trim($data['btn_link'] ?? 'contact.php');
    $order = intval($data['display_order'] ?? 0);

    if (empty($title)) return false;

    $stmt = $conn->prepare("INSERT INTO `services` 
        (`title`, `description`, `requirements`, `fee`, `processing_time`, `icon`, `status`, `btn_text`, `btn_link`, `display_order`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) return false;

    $stmt->bind_param("sssssssssi", $title, $desc, $reqs, $fee, $time, $icon, $status, $btnText, $btnLink, $order);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

/**
 * Update an existing service
 */
function update_service($conn, $id, $data) {
    if (!$conn || $conn->connect_error) return false;

    $id = intval($id);
    if ($id <= 0) return false;

    $title = trim($data['title'] ?? '');
    $desc = trim($data['description'] ?? '');
    $reqs = trim($data['requirements'] ?? '');
    $fee = trim($data['fee'] ?? 'Free');
    $time = trim($data['processing_time'] ?? 'Same Day');
    $icon = trim($data['icon'] ?? 'document');
    $status = ($data['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';
    $btnText = trim($data['btn_text'] ?? 'Request Document');
    $btnLink = trim($data['btn_link'] ?? 'contact.php');
    $order = intval($data['display_order'] ?? 0);

    if (empty($title)) return false;

    $stmt = $conn->prepare("UPDATE `services` SET 
        `title` = ?, 
        `description` = ?, 
        `requirements` = ?, 
        `fee` = ?, 
        `processing_time` = ?, 
        `icon` = ?, 
        `status` = ?, 
        `btn_text` = ?, 
        `btn_link` = ?, 
        `display_order` = ?
        WHERE `id` = ?");

    if (!$stmt) return false;

    $stmt->bind_param("sssssssssii", $title, $desc, $reqs, $fee, $time, $icon, $status, $btnText, $btnLink, $order, $id);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

/**
 * Delete a service
 */
function delete_service($conn, $id) {
    if (!$conn || $conn->connect_error) return false;

    $id = intval($id);
    if ($id <= 0) return false;

    $stmt = $conn->prepare("DELETE FROM `services` WHERE `id` = ?");
    if (!$stmt) return false;

    $stmt->bind_param("i", $id);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

/**
 * Toggle status of a service (active <-> inactive)
 */
function toggle_service_status($conn, $id) {
    if (!$conn || $conn->connect_error) return false;

    $id = intval($id);
    if ($id <= 0) return false;

    $service = get_service_by_id($conn, $id);
    if (!$service) return false;

    $newStatus = ($service['status'] === 'active') ? 'inactive' : 'active';

    $stmt = $conn->prepare("UPDATE `services` SET `status` = ? WHERE `id` = ?");
    if (!$stmt) return false;

    $stmt->bind_param("si", $newStatus, $id);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

/**
 * Get clean SVG icon markup for a given icon key
 */
function get_service_icon_svg($icon, $width = 24, $height = 24) {
    switch (strtolower(trim($icon))) {
        case 'home':
        case 'indigency':
            return '<svg width="'.$width.'" height="'.$height.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline><path d="M12 15a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path></svg>';

        case 'briefcase':
        case 'business':
            return '<svg width="'.$width.'" height="'.$height.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>';

        case 'id-card':
        case 'residency':
            return '<svg width="'.$width.'" height="'.$height.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line><circle cx="12" cy="15" r="2"></circle></svg>';

        case 'heart-pulse':
        case 'health':
        case 'medical':
            return '<svg width="'.$width.'" height="'.$height.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';

        case 'shield':
        case 'peace':
        case 'security':
            return '<svg width="'.$width.'" height="'.$height.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>';

        case 'users':
        case 'community':
            return '<svg width="'.$width.'" height="'.$height.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>';

        case 'award':
            return '<svg width="'.$width.'" height="'.$height.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>';

        case 'document':
        case 'clearance':
        case 'certificate':
        default:
            return '<svg width="'.$width.'" height="'.$height.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>';
    }
}
