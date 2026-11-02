<?php
// Determine environment (Local XAMPP vs InfinityFree / Live Hosting)
$httpHost = $_SERVER['HTTP_HOST'] ?? '';
$isLiveHost = !empty($httpHost) && strpos($httpHost, 'localhost') === false && strpos($httpHost, '127.0.0.1') === false;

if ($isLiveHost) {
    // =========================================================================
    // INFINITYFREE / PRODUCTION DATABASE CONFIGURATION
    // You can find these details in your InfinityFree Client Area -> Control Panel -> MySQL Databases:
    // =========================================================================
    $servername = getenv('DB_HOST') ?: "sqlXXX.infinityfree.com";             // Replace with your MySQL Hostname (e.g. sql100.infinityfree.com or sql200.byetcluster.com)
    $username   = getenv('DB_USER') ?: "if0_XXXXXXXX";                        // Replace with your InfinityFree MySQL Username (e.g. if0_38123456)
    $password   = getenv('DB_PASS') ?: "your_vpanel_password";                // Replace with your InfinityFree Account / vPanel Password
    $dbname     = getenv('DB_NAME') ?: "if0_XXXXXXXX_barangay_sanjose_db";    // Replace with your InfinityFree MySQL Database Name
} else {
    // =========================================================================
    // LOCAL XAMPP ENVIRONMENT CONFIGURATION
    // =========================================================================
    $servername = "localhost";
    $username   = "root"; // Default XAMPP username
    $password   = "";     // Default XAMPP password is empty
    $dbname     = "barangay_sanjose_db";
}

// Optional external override file (e.g. db_config.php) if present
if (file_exists(__DIR__ . '/db_config.php')) {
    include __DIR__ . '/db_config.php';
}

// Create connection with resilient error handling
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception($conn->connect_error);
    }

    // Automatically ensure the feedback_chats table exists
    $conn->query("CREATE TABLE IF NOT EXISTS `feedback_chats` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `thread_id` VARCHAR(100) NOT NULL,
      `sender_name` VARCHAR(255) NOT NULL,
      `email` VARCHAR(150) DEFAULT NULL,
      `service_type` VARCHAR(150) DEFAULT 'General Inquiry',
      `sender_type` ENUM('user', 'admin') NOT NULL DEFAULT 'user',
      `message` TEXT NOT NULL,
      `file_attachment` VARCHAR(255) DEFAULT NULL,
      `file_name` VARCHAR(255) DEFAULT NULL,
      `is_read` TINYINT(1) DEFAULT 0,
      `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      INDEX `idx_thread_id` (`thread_id`),
      INDEX `idx_sender_type_read` (`sender_type`, `is_read`),
      INDEX `idx_created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    // One-time migration of any legacy chat_sessions / chat_messages into feedback_chats
    $fcCheck = $conn->query("SELECT COUNT(*) FROM `feedback_chats`");
    if ($fcCheck && (int)$fcCheck->fetch_row()[0] === 0) {
        $csExists = $conn->query("SHOW TABLES LIKE 'chat_sessions'");
        $cmExists = $conn->query("SHOW TABLES LIKE 'chat_messages'");
        if ($csExists && $csExists->num_rows > 0 && $cmExists && $cmExists->num_rows > 0) {
            $conn->query("INSERT INTO `feedback_chats` (`thread_id`, `sender_name`, `email`, `service_type`, `sender_type`, `message`, `file_attachment`, `file_name`, `is_read`, `created_at`)
                SELECT CONCAT('thread_', s.id), s.user_name, NULL, COALESCE(s.service_type, 'General Inquiry'),
                       CASE WHEN m.sender = 'admin' THEN 'admin' ELSE 'user' END,
                       COALESCE(m.message, ''), m.attachment_file, m.attachment_name,
                       COALESCE(m.is_read, 0), COALESCE(m.created_at, s.created_at)
                FROM `chat_messages` m
                JOIN `chat_sessions` s ON m.session_id = s.id
                ORDER BY m.id ASC");
        }
    }
} catch (Throwable $e) {
    if ($isLiveHost) {
        $errorMessage = "<p style='margin: 12px 0; font-size: 15px; line-height: 1.6;'>Could not connect to the remote MySQL database on <strong>InfinityFree</strong>.</p>
        <div style='margin: 14px 0; padding: 14px; background: #fff; border: 1px solid #fed7aa; border-radius: 8px; font-size: 13.5px; color: #9a3412;'>
            <strong>Quick Setup Instructions for InfinityFree:</strong>
            <ol style='margin: 8px 0 0 18px; padding: 0;'>
                <li>Open your <strong>InfinityFree Client Area</strong> &rarr; Click your Account &rarr; Click <strong>MySQL Databases</strong>.</li>
                <li>Note your <strong>MySQL Hostname</strong> (e.g. <code>sqlXXX.infinityfree.com</code>), <strong>MySQL Username</strong> (e.g. <code>if0_XXXXXXXX</code>), and database name.</li>
                <li>Open <code>db_connect.php</code> (or create a <code>db_config.php</code> file) on your host with those credentials.</li>
                <li>Open <strong>phpMyAdmin</strong> from your InfinityFree control panel and import <code>Database/barangay_sanjose_db.sql</code>.</li>
            </ol>
        </div>";
    } else {
        $errorMessage = "<p style='margin: 12px 0; font-size: 15px; line-height: 1.5;'>Could not connect to MySQL. Please open your <strong>XAMPP Control Panel</strong> and ensure the <strong>MySQL</strong> module is running (click <strong>Start</strong> next to MySQL).</p>";
    }

    die("<div style='font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif; max-width: 680px; margin: 50px auto; padding: 28px; border: 1px solid #fecaca; background: #fef2f2; border-radius: 12px; color: #991b1b; box-shadow: 0 4px 6px rgba(0,0,0,0.05);'>
        <h3 style='margin-top: 0; display: flex; align-items: center; gap: 8px;'>
            <svg width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2'><circle cx='12' cy='12' r='10'></circle><line x1='12' y1='8' x2='12' y2='12'></line><line x1='12' y1='16' x2='12.01' y2='16'></line></svg>
            Database Connection Error
        </h3>
        $errorMessage
        <div style='margin-top: 16px; padding: 12px; background: #ffffff; border: 1px solid #fee2e2; border-radius: 6px; font-size: 13px; color: #7f1d1d; word-break: break-all;'>
            <strong>Details:</strong> " . htmlspecialchars($e->getMessage()) . "
        </div>
    </div>");
}
?>
