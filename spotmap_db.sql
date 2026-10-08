CREATE DATABASE IF NOT EXISTS barangay_sanjose_db;
USE barangay_sanjose_db;

CREATE TABLE IF NOT EXISTS puroks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE IF NOT EXISTS legends (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL,
    icon_path VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE IF NOT EXISTS purok1_locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    legend_id INT,
    house_number VARCHAR(50),
    husband_name VARCHAR(100),
    spouse_name VARCHAR(100),
    house_image VARCHAR(255),
    marker_image VARCHAR(255),
    marker_width INT DEFAULT 40,
    marker_height INT DEFAULT 40,
    top_position DECIMAL(5,2),
    left_position DECIMAL(5,2),
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (legend_id) REFERENCES legends(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS purok2_locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    legend_id INT,
    house_number VARCHAR(50),
    husband_name VARCHAR(100),
    spouse_name VARCHAR(100),
    house_image VARCHAR(255),
    marker_image VARCHAR(255),
    marker_width INT DEFAULT 40,
    marker_height INT DEFAULT 40,
    top_position DECIMAL(5,2),
    left_position DECIMAL(5,2),
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (legend_id) REFERENCES legends(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS purok3_locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    legend_id INT,
    house_number VARCHAR(50),
    husband_name VARCHAR(100),
    spouse_name VARCHAR(100),
    house_image VARCHAR(255),
    marker_image VARCHAR(255),
    marker_width INT DEFAULT 40,
    marker_height INT DEFAULT 40,
    top_position DECIMAL(5,2),
    left_position DECIMAL(5,2),
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (legend_id) REFERENCES legends(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS purok4_locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    legend_id INT,
    house_number VARCHAR(50),
    husband_name VARCHAR(100),
    spouse_name VARCHAR(100),
    house_image VARCHAR(255),
    marker_image VARCHAR(255),
    marker_width INT DEFAULT 40,
    marker_height INT DEFAULT 40,
    top_position DECIMAL(5,2),
    left_position DECIMAL(5,2),
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (legend_id) REFERENCES legends(id) ON DELETE SET NULL
);

-- Insert default Puroks
INSERT IGNORE INTO puroks (id, name, description) VALUES 
(1, 'Purok 1', 'Purok 1 Area'),
(2, 'Purok 2', 'Purok 2 Area'),
(3, 'Purok 3', 'Purok 3 Area'),
(4, 'Purok 4', 'Purok 4 Area');

-- Insert default legends (you can modify the paths)
INSERT IGNORE INTO legends (id, category_name, icon_path) VALUES 
(1, 'Household', 'assets/images/markers/house_icon.png'),
(2, 'Barangay Hall', 'assets/images/markers/hall_icon.png'),
(3, 'Chapel', 'assets/images/markers/chapel_icon.png'),
(4, 'Sari-Sari Store', 'assets/images/markers/store_icon.png');
