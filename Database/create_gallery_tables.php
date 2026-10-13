<?php
require_once __DIR__ . '/../db_connect.php';

$sql_folders = "CREATE TABLE IF NOT EXISTS `gallery_folders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `folder_name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

if (!$conn->query($sql_folders)) {
    die("Error creating gallery_folders: " . $conn->error . "\n");
}

$sql_media = "CREATE TABLE IF NOT EXISTS `gallery_media` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `folder_id` INT(11) NOT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `caption` VARCHAR(255) DEFAULT NULL,
  `uploaded_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `folder_id` (`folder_id`),
  CONSTRAINT `fk_gallery_folder` FOREIGN KEY (`folder_id`) REFERENCES `gallery_folders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

if (!$conn->query($sql_media)) {
    die("Error creating gallery_media: " . $conn->error . "\n");
}

echo "Gallery tables verified / created successfully.\n";
