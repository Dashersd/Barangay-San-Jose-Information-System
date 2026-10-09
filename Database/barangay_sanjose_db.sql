-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2026 at 03:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barangay_sanjose_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `legends`
--

CREATE TABLE `legends` (
  `id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `icon_path` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `legends`
--

INSERT INTO `legends` (`id`, `category_name`, `icon_path`, `description`) VALUES
(1, 'Household', 'assets/images/markers/house_icon.png', NULL),
(2, 'Barangay Hall', 'assets/images/markers/hall_icon.png', NULL),
(3, 'Chapel', 'assets/images/markers/chapel_icon.png', NULL),
(4, 'Sari-Sari Store', 'assets/images/markers/store_icon.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purok1_locations`
--

CREATE TABLE `purok1_locations` (
  `id` int(11) NOT NULL,
  `legend_id` int(11) DEFAULT NULL,
  `house_number` varchar(50) DEFAULT NULL,
  `husband_name` varchar(100) DEFAULT NULL,
  `spouse_name` varchar(100) DEFAULT NULL,
  `house_image` varchar(255) DEFAULT NULL,
  `marker_image` varchar(255) DEFAULT NULL,
  `marker_width` int(11) DEFAULT 40,
  `marker_height` int(11) DEFAULT 40,
  `top_position` decimal(5,2) DEFAULT NULL,
  `left_position` decimal(5,2) DEFAULT NULL,
  `date_added` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purok1_locations`
--

INSERT INTO `purok1_locations` (`id`, `legend_id`, `house_number`, `husband_name`, `spouse_name`, `house_image`, `marker_image`, `marker_width`, `marker_height`, `top_position`, `left_position`, `date_added`) VALUES
(1, 1, '231', 'dale', 'Imbing', 'assets/images/households/1791426187_ChatGPT Image Oct 3, 2026, 09_25_09 AM.png', 'assets/images/markers/1791426187_images.jpg', 40, 40, 51.50, 25.33, '2026-10-08 10:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `purok2_locations`
--

CREATE TABLE `purok2_locations` (
  `id` int(11) NOT NULL,
  `legend_id` int(11) DEFAULT NULL,
  `house_number` varchar(50) DEFAULT NULL,
  `husband_name` varchar(100) DEFAULT NULL,
  `spouse_name` varchar(100) DEFAULT NULL,
  `house_image` varchar(255) DEFAULT NULL,
  `marker_image` varchar(255) DEFAULT NULL,
  `marker_width` int(11) DEFAULT 40,
  `marker_height` int(11) DEFAULT 40,
  `top_position` decimal(5,2) DEFAULT NULL,
  `left_position` decimal(5,2) DEFAULT NULL,
  `date_added` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purok2_locations`
--

INSERT INTO `purok2_locations` (`id`, `legend_id`, `house_number`, `husband_name`, `spouse_name`, `house_image`, `marker_image`, `marker_width`, `marker_height`, `top_position`, `left_position`, `date_added`) VALUES
(1, 1, '786', 'gsds', 'sdgs', 'assets/images/households/1791426372_ChatGPT Image Oct 2, 2026, 06_37_01 PM.png', 'assets/images/markers/1791426372_images.jpg', 40, 40, 76.92, 28.56, '2026-10-08 10:26:12');

-- --------------------------------------------------------

--
-- Table structure for table `purok3_locations`
--

CREATE TABLE `purok3_locations` (
  `id` int(11) NOT NULL,
  `legend_id` int(11) DEFAULT NULL,
  `house_number` varchar(50) DEFAULT NULL,
  `husband_name` varchar(100) DEFAULT NULL,
  `spouse_name` varchar(100) DEFAULT NULL,
  `house_image` varchar(255) DEFAULT NULL,
  `marker_image` varchar(255) DEFAULT NULL,
  `marker_width` int(11) DEFAULT 40,
  `marker_height` int(11) DEFAULT 40,
  `top_position` decimal(5,2) DEFAULT NULL,
  `left_position` decimal(5,2) DEFAULT NULL,
  `date_added` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purok3_locations`
--

INSERT INTO `purok3_locations` (`id`, `legend_id`, `house_number`, `husband_name`, `spouse_name`, `house_image`, `marker_image`, `marker_width`, `marker_height`, `top_position`, `left_position`, `date_added`) VALUES
(1, 1, '57', 'bdf', 'gmgm', 'assets/images/households/1791426393_36439455-e53f-44ce-8631-fda74e72f4b3.jpg', 'assets/images/markers/1791426393_images.jpg', 40, 40, 37.14, 21.09, '2026-10-08 10:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `purok4_locations`
--

CREATE TABLE `purok4_locations` (
  `id` int(11) NOT NULL,
  `legend_id` int(11) DEFAULT NULL,
  `house_number` varchar(50) DEFAULT NULL,
  `husband_name` varchar(100) DEFAULT NULL,
  `spouse_name` varchar(100) DEFAULT NULL,
  `house_image` varchar(255) DEFAULT NULL,
  `marker_image` varchar(255) DEFAULT NULL,
  `marker_width` int(11) DEFAULT 40,
  `marker_height` int(11) DEFAULT 40,
  `top_position` decimal(5,2) DEFAULT NULL,
  `left_position` decimal(5,2) DEFAULT NULL,
  `date_added` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purok4_locations`
--

INSERT INTO `purok4_locations` (`id`, `legend_id`, `house_number`, `husband_name`, `spouse_name`, `house_image`, `marker_image`, `marker_width`, `marker_height`, `top_position`, `left_position`, `date_added`) VALUES
(1, 1, '7967', 'gjfjgf', 'dsf', 'assets/images/households/1791426431_47559266-57c8-49e7-ab96-4ee5e587d365.jpg', 'assets/images/markers/1791426431_images.jpg', 40, 40, 22.29, 28.04, '2026-10-08 10:27:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `legends`
--
ALTER TABLE `legends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purok1_locations`
--
ALTER TABLE `purok1_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legend_id` (`legend_id`);

--
-- Indexes for table `purok2_locations`
--
ALTER TABLE `purok2_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legend_id` (`legend_id`);

--
-- Indexes for table `purok3_locations`
--
ALTER TABLE `purok3_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legend_id` (`legend_id`);

--
-- Indexes for table `purok4_locations`
--
ALTER TABLE `purok4_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legend_id` (`legend_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `legends`
--
ALTER TABLE `legends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purok1_locations`
--
ALTER TABLE `purok1_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purok2_locations`
--
ALTER TABLE `purok2_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purok3_locations`
--
ALTER TABLE `purok3_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purok4_locations`
--
ALTER TABLE `purok4_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purok1_locations`
--
ALTER TABLE `purok1_locations`
  ADD CONSTRAINT `purok1_locations_ibfk_1` FOREIGN KEY (`legend_id`) REFERENCES `legends` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purok2_locations`
--
ALTER TABLE `purok2_locations`
  ADD CONSTRAINT `purok2_locations_ibfk_1` FOREIGN KEY (`legend_id`) REFERENCES `legends` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purok3_locations`
--
ALTER TABLE `purok3_locations`
  ADD CONSTRAINT `purok3_locations_ibfk_1` FOREIGN KEY (`legend_id`) REFERENCES `legends` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purok4_locations`
--
ALTER TABLE `purok4_locations`
  ADD CONSTRAINT `purok4_locations_ibfk_1` FOREIGN KEY (`legend_id`) REFERENCES `legends` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
