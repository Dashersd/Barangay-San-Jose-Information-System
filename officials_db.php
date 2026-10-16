<?php
// officials_db.php - Central MySQL management for Barangay & SK Officials
require_once __DIR__ . '/db_connect.php';

/**
 * Ensure MySQL tables exist and have initial seed data
 */
function init_officials_tables($conn) {
    if (!$conn || $conn->connect_error) return;

    // 1. Table for Barangay Officials
    $conn->query("CREATE TABLE IF NOT EXISTS `barangay_officials` (
        `id` VARCHAR(50) NOT NULL PRIMARY KEY,
        `level` INT(11) NOT NULL DEFAULT 3,
        `role` VARCHAR(100) NOT NULL,
        `name` VARCHAR(150) NOT NULL,
        `image` VARCHAR(255) DEFAULT '',
        `message` TEXT DEFAULT NULL,
        `display_order` INT(11) NOT NULL DEFAULT 0,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    // Check if barangay_officials is empty, seed if so
    $res = $conn->query("SELECT COUNT(*) AS total FROM `barangay_officials`");
    $count = $res ? (int)$res->fetch_assoc()['total'] : 0;
    if ($count === 0) {
        $jsonFile = __DIR__ . '/Admin/data/barangay_officials.json';
        $defaultData = [
            ['id' => 'captain', 'level' => 1, 'role' => 'BARANGAY CAPTAIN', 'name' => 'Hon. Diego Logronio', 'image' => 'assets/images/Barangay Official/captain.Diego Logronio.jpg', 'message' => 'To our residents, partners, and every member of our community, thank you for your trust, cooperation, and unwavering support. At Barangay San Jose, we remain committed to delivering honest and transparent public service.'],
            ['id' => 'secretary', 'level' => 2, 'role' => 'BARANGAY SECRETARY', 'name' => 'Hon. Michelle Deluna', 'image' => 'assets/images/Barangay Official/secretary michelle deluna.jpg', 'message' => ''],
            ['id' => 'treasurer', 'level' => 2, 'role' => 'BARANGAY TREASURER', 'name' => 'Hon. Alfredo Alasaas', 'image' => 'assets/images/Barangay Official/treasurer alfredo alasaas.jpg', 'message' => ''],
            ['id' => 'kagawad_1', 'level' => 3, 'role' => 'BARANGAY KAGAWAD 1', 'name' => 'Hon. Fedelina Thundas', 'image' => 'assets/images/Barangay Official/1.Fedelina Thundas.jpg', 'message' => ''],
            ['id' => 'kagawad_2', 'level' => 3, 'role' => 'BARANGAY KAGAWAD 2', 'name' => 'Hon. Mario Godines', 'image' => 'assets/images/Barangay Official/2 Mario godines.jpg', 'message' => ''],
            ['id' => 'kagawad_3', 'level' => 3, 'role' => 'BARANGAY KAGAWAD 3', 'name' => 'Hon. Jennifer Dolen', 'image' => 'assets/images/Barangay Official/3 jennifer dolen.jpg', 'message' => ''],
            ['id' => 'kagawad_4', 'level' => 3, 'role' => 'BARANGAY KAGAWAD 4', 'name' => 'Hon. Calixto Mamac', 'image' => 'assets/images/Barangay Official/4 calixto mamac.jpg', 'message' => ''],
            ['id' => 'kagawad_5', 'level' => 3, 'role' => 'BARANGAY KAGAWAD 5', 'name' => 'Hon. Rodrigo Godinez', 'image' => 'assets/images/Barangay Official/5 rodrigo godinez.jpg', 'message' => ''],
            ['id' => 'kagawad_6', 'level' => 3, 'role' => 'BARANGAY KAGAWAD 6', 'name' => 'Hon. Rodelio Basirel', 'image' => 'assets/images/Barangay Official/6 rodelio besirel.jpg', 'message' => ''],
            ['id' => 'kagawad_7', 'level' => 3, 'role' => 'BARANGAY KAGAWAD 7', 'name' => 'Hon. Jimmy Daligdig', 'image' => 'assets/images/Barangay Official/7 jimmy daligdig.jpg', 'message' => '']
        ];
        if (file_exists($jsonFile)) {
            $fromFile = json_decode(file_get_contents($jsonFile), true);
            if (is_array($fromFile) && count($fromFile) > 0) {
                $defaultData = $fromFile;
            }
        }
        $stmt = $conn->prepare("INSERT INTO `barangay_officials` (`id`, `level`, `role`, `name`, `image`, `message`, `display_order`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $order = 1;
            foreach ($defaultData as $item) {
                $id = $item['id'];
                $level = (int)($item['level'] ?? 3);
                $role = $item['role'] ?? '';
                $name = $item['name'] ?? '';
                $image = $item['image'] ?? '';
                $message = $item['message'] ?? '';
                $stmt->bind_param("sissssi", $id, $level, $role, $name, $image, $message, $order);
                $stmt->execute();
                $order++;
            }
            $stmt->close();
        }
    }

    // 2. Table for SK Officials
    $conn->query("CREATE TABLE IF NOT EXISTS `sk_officials` (
        `id` VARCHAR(50) NOT NULL PRIMARY KEY,
        `level` INT(11) NOT NULL DEFAULT 3,
        `role` VARCHAR(100) NOT NULL,
        `name` VARCHAR(150) NOT NULL,
        `image` VARCHAR(255) DEFAULT '',
        `message` TEXT DEFAULT NULL,
        `display_order` INT(11) NOT NULL DEFAULT 0,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    // Check if sk_officials is empty, seed if so
    $resSK = $conn->query("SELECT COUNT(*) AS total FROM `sk_officials`");
    $countSK = $resSK ? (int)$resSK->fetch_assoc()['total'] : 0;
    if ($countSK === 0) {
        $jsonSKFile = __DIR__ . '/Admin/data/sk_officials.json';
        $defaultSKData = [
            ['id' => 'sk_chairperson', 'level' => 1, 'role' => 'SK CHAIRPERSON', 'name' => 'Hon. Artem Macmac', 'image' => 'assets/images/SK Official/sk chairperson artem mamac.jpg', 'message' => 'Empowering the youth of Barangay San Jose through active participation in sports, education, and community development.'],
            ['id' => 'sk_secretary', 'level' => 2, 'role' => 'SK SECRETARY', 'name' => 'Ms. Liza Santos', 'image' => '', 'message' => ''],
            ['id' => 'sk_treasurer', 'level' => 2, 'role' => 'SK TREASURER', 'name' => 'Mr. Antonio Luna', 'image' => '', 'message' => ''],
            ['id' => 'sk_kagawad_1', 'level' => 3, 'role' => 'SK KAGAWAD 1', 'name' => 'Hon. Ana Villanueva', 'image' => '', 'message' => ''],
            ['id' => 'sk_kagawad_2', 'level' => 3, 'role' => 'SK KAGAWAD 2', 'name' => 'Hon. Luis Garcia', 'image' => '', 'message' => ''],
            ['id' => 'sk_kagawad_3', 'level' => 3, 'role' => 'SK KAGAWAD 3', 'name' => 'Hon. Maria Santos', 'image' => '', 'message' => ''],
            ['id' => 'sk_kagawad_4', 'level' => 3, 'role' => 'SK KAGAWAD 4', 'name' => 'Hon. Juanito Perez', 'image' => '', 'message' => ''],
            ['id' => 'sk_kagawad_5', 'level' => 3, 'role' => 'SK KAGAWAD 5', 'name' => 'Hon. Elena Cruz', 'image' => '', 'message' => ''],
            ['id' => 'sk_kagawad_6', 'level' => 3, 'role' => 'SK KAGAWAD 6', 'name' => 'Hon. Ricardo Gomez', 'image' => '', 'message' => ''],
            ['id' => 'sk_kagawad_7', 'level' => 3, 'role' => 'SK KAGAWAD 7', 'name' => 'Hon. Pedro Reyes', 'image' => '', 'message' => '']
        ];
        if (file_exists($jsonSKFile)) {
            $fromFile = json_decode(file_get_contents($jsonSKFile), true);
            if (is_array($fromFile) && count($fromFile) > 0) {
                $defaultSKData = $fromFile;
            }
        }
        $stmtSK = $conn->prepare("INSERT INTO `sk_officials` (`id`, `level`, `role`, `name`, `image`, `message`, `display_order`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmtSK) {
            $order = 1;
            foreach ($defaultSKData as $item) {
                $id = $item['id'];
                $level = (int)($item['level'] ?? 3);
                $role = $item['role'] ?? '';
                $name = $item['name'] ?? '';
                $image = $item['image'] ?? '';
                $message = $item['message'] ?? '';
                $stmtSK->bind_param("sissssi", $id, $level, $role, $name, $image, $message, $order);
                $stmtSK->execute();
                $order++;
            }
            $stmtSK->close();
        }
    }
}

// Ensure tables exist and are initialized
init_officials_tables($conn);

/**
 * Fetch all Barangay Officials from MySQL (ordered by display_order, level)
 */
function get_barangay_officials_from_db($conn) {
    $officials = [];
    if ($conn && !$conn->connect_error) {
        $query = "SELECT * FROM `barangay_officials` ORDER BY `display_order` ASC, `level` ASC";
        if ($res = $conn->query($query)) {
            while ($row = $res->fetch_assoc()) {
                $officials[] = $row;
            }
        }
    }
    // Fallback to JSON if DB query returned nothing
    if (empty($officials)) {
        $jsonFile = __DIR__ . '/Admin/data/barangay_officials.json';
        if (file_exists($jsonFile)) {
            $officials = json_decode(file_get_contents($jsonFile), true) ?: [];
        }
    }
    return $officials;
}

/**
 * Update a Barangay Official in MySQL and sync to JSON
 */
function update_barangay_official_in_db($conn, $id, $name, $role, $message, $image = null) {
    $success = false;
    if ($conn && !$conn->connect_error) {
        if ($image !== null && $image !== '') {
            $stmt = $conn->prepare("UPDATE `barangay_officials` SET `name` = ?, `role` = ?, `message` = ?, `image` = ? WHERE `id` = ?");
            if ($stmt) {
                $stmt->bind_param("sssss", $name, $role, $message, $image, $id);
                $success = $stmt->execute();
                $stmt->close();
            }
        } else {
            $stmt = $conn->prepare("UPDATE `barangay_officials` SET `name` = ?, `role` = ?, `message` = ? WHERE `id` = ?");
            if ($stmt) {
                $stmt->bind_param("ssss", $name, $role, $message, $id);
                $success = $stmt->execute();
                $stmt->close();
            }
        }
    }

    // Also sync to JSON file as fallback
    $all = get_barangay_officials_from_db($conn);
    $jsonFile = __DIR__ . '/Admin/data/barangay_officials.json';
    @file_put_contents($jsonFile, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    return $success;
}

/**
 * Fetch all SK Officials from MySQL (ordered by display_order, level)
 */
function get_sk_officials_from_db($conn) {
    $officials = [];
    if ($conn && !$conn->connect_error) {
        $query = "SELECT * FROM `sk_officials` ORDER BY `display_order` ASC, `level` ASC";
        if ($res = $conn->query($query)) {
            while ($row = $res->fetch_assoc()) {
                $officials[] = $row;
            }
        }
    }
    // Fallback to JSON if DB query returned nothing
    if (empty($officials)) {
        $jsonFile = __DIR__ . '/Admin/data/sk_officials.json';
        if (file_exists($jsonFile)) {
            $officials = json_decode(file_get_contents($jsonFile), true) ?: [];
        }
    }
    return $officials;
}

/**
 * Update an SK Official in MySQL and sync to JSON
 */
function update_sk_official_in_db($conn, $id, $name, $role, $message, $image = null) {
    $success = false;
    if ($conn && !$conn->connect_error) {
        if ($image !== null && $image !== '') {
            $stmt = $conn->prepare("UPDATE `sk_officials` SET `name` = ?, `role` = ?, `message` = ?, `image` = ? WHERE `id` = ?");
            if ($stmt) {
                $stmt->bind_param("sssss", $name, $role, $message, $image, $id);
                $success = $stmt->execute();
                $stmt->close();
            }
        } else {
            $stmt = $conn->prepare("UPDATE `sk_officials` SET `name` = ?, `role` = ?, `message` = ? WHERE `id` = ?");
            if ($stmt) {
                $stmt->bind_param("ssss", $name, $role, $message, $id);
                $success = $stmt->execute();
                $stmt->close();
            }
        }
    }

    // Also sync to JSON file as fallback
    $all = get_sk_officials_from_db($conn);
    $jsonFile = __DIR__ . '/Admin/data/sk_officials.json';
    @file_put_contents($jsonFile, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    return $success;
}
