<?php
// export_backup.php - Database Backup Exporter
// Barangay San Jose Web-Based Information System

session_start();
require_once __DIR__ . '/../db_connect.php';

// Ensure activity_logs table exists if needed
$conn->query("CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `action` VARCHAR(100) NOT NULL,
  `details` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

// Determine client IP
$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
}
$ip = substr(trim($ip), 0, 45);

$userId = isset($_SESSION['admin_id']) ? (int)$_SESSION['admin_id'] : null;

// Filename format: database_backup_YYYY-MM-DD_Hms.sql
$filename = 'database_backup_' . date('Y-m-d_His') . '.sql';

// Log the download event to activity_logs
$logStmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, details, ip_address, created_at) VALUES (?, 'EXPORT_BACKUP', ?, ?, NOW())");
if ($logStmt) {
    $details = "Generated and downloaded full database SQL backup ($filename)";
    $logStmt->bind_param("iss", $userId, $details, $ip);
    $logStmt->execute();
    $logStmt->close();
}

// Set HTTP headers for file download
header('Content-Type: application/sql; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: private, must-revalidate, max-age=0, no-cache');
header('Pragma: no-cache');
header('Expires: 0');

// Generate SQL Dump output stream
$out = fopen('php://output', 'w');

// File Header
fwrite($out, "-- ========================================================\n");
fwrite($out, "-- Barangay San Jose Web-Based Information System\n");
fwrite($out, "-- Automated Database Backup & Dump\n");
fwrite($out, "-- Date & Time: " . date('Y-m-d H:i:s') . "\n");
fwrite($out, "-- Server Version: " . $conn->server_info . "\n");
fwrite($out, "-- PHP Version: " . PHP_VERSION . "\n");
fwrite($out, "-- ========================================================\n\n");

fwrite($out, "SET FOREIGN_KEY_CHECKS=0;\n");
fwrite($out, "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n");
fwrite($out, "SET time_zone = \"+00:00\";\n\n");

// Fetch all tables
$tables = [];
$result = $conn->query("SHOW TABLES");
if ($result) {
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }
}

foreach ($tables as $table) {
    fwrite($out, "-- --------------------------------------------------------\n");
    fwrite($out, "-- Table structure and data for `$table`\n");
    fwrite($out, "-- --------------------------------------------------------\n");
    fwrite($out, "DROP TABLE IF EXISTS `$table`;\n");

    // Fetch CREATE TABLE statement
    $createRes = $conn->query("SHOW CREATE TABLE `$table`");
    if ($createRes && $createRow = $createRes->fetch_row()) {
        fwrite($out, $createRow[1] . ";\n\n");
    }

    // Fetch Table Data
    $dataRes = $conn->query("SELECT * FROM `$table`");
    if ($dataRes && $dataRes->num_rows > 0) {
        // Fetch field names
        $fields = [];
        while ($field = $dataRes->fetch_field()) {
            $fields[] = "`" . $field->name . "`";
        }
        $fieldsList = implode(", ", $fields);

        // Fetch and write rows in batches of 100
        $batch = [];
        $batchCount = 0;

        while ($row = $dataRes->fetch_assoc()) {
            $values = [];
            foreach ($row as $val) {
                if ($val === null) {
                    $values[] = "NULL";
                } elseif (is_numeric($val) && !preg_match('/^0[0-9]+/', (string)$val)) {
                    $values[] = $val;
                } else {
                    $values[] = "'" . $conn->real_escape_string($val) . "'";
                }
            }
            $batch[] = "(" . implode(", ", $values) . ")";
            $batchCount++;

            if ($batchCount >= 100) {
                fwrite($out, "INSERT INTO `$table` ($fieldsList) VALUES\n" . implode(",\n", $batch) . ";\n");
                $batch = [];
                $batchCount = 0;
            }
        }

        if (!empty($batch)) {
            fwrite($out, "INSERT INTO `$table` ($fieldsList) VALUES\n" . implode(",\n", $batch) . ";\n");
        }
        fwrite($out, "\n");
    }
}

fwrite($out, "SET FOREIGN_KEY_CHECKS=1;\n");
fwrite($out, "-- Dump completed on " . date('Y-m-d H:i:s') . "\n");

fclose($out);
exit;
