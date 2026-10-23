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
-- --------------------------------------------------------

--
-- Table structure for table `gallery_folders`
--

CREATE TABLE `gallery_folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_media`
--

CREATE TABLE `gallery_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `folder_id` (`folder_id`),
  CONSTRAINT `fk_gallery_folder` FOREIGN KEY (`folder_id`) REFERENCES `gallery_folders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangay_officials`
--

CREATE TABLE IF NOT EXISTS `barangay_officials` (
  `id` varchar(50) NOT NULL,
  `level` int(11) NOT NULL DEFAULT 3,
  `role` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `image` varchar(255) DEFAULT '',
  `message` text DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_officials`
--

INSERT INTO `barangay_officials` (`id`, `level`, `role`, `name`, `image`, `message`, `display_order`) VALUES
('captain', 1, 'BARANGAY CAPTAIN', 'Hon. Diego Logronio', 'assets/images/Barangay Official/captain.Diego Logronio.jpg', 'To our residents, partners, and every member of our community, thank you for your trust, cooperation, and unwavering support. At Barangay San Jose, we remain committed to delivering honest and transparent public service.', 1),
('secretary', 2, 'BARANGAY SECRETARY', 'Hon. Michelle Deluna', 'assets/images/Barangay Official/secretary michelle deluna.jpg', '', 2),
('treasurer', 2, 'BARANGAY TREASURER', 'Hon. Alfredo Alasaas', 'assets/images/Barangay Official/treasurer alfredo alasaas.jpg', '', 3),
('kagawad_1', 3, 'BARANGAY KAGAWAD 1', 'Hon. Fedelina Thundas', 'assets/images/Barangay Official/1.Fedelina Thundas.jpg', '', 4),
('kagawad_2', 3, 'BARANGAY KAGAWAD 2', 'Hon. Mario Godines', 'assets/images/Barangay Official/2 Mario godines.jpg', '', 5),
('kagawad_3', 3, 'BARANGAY KAGAWAD 3', 'Hon. Jennifer Dolen', 'assets/images/Barangay Official/3 jennifer dolen.jpg', '', 6),
('kagawad_4', 3, 'BARANGAY KAGAWAD 4', 'Hon. Calixto Mamac', 'assets/images/Barangay Official/4 calixto mamac.jpg', '', 7),
('kagawad_5', 3, 'BARANGAY KAGAWAD 5', 'Hon. Rodrigo Godinez', 'assets/images/Barangay Official/5 rodrigo godinez.jpg', '', 8),
('kagawad_6', 3, 'BARANGAY KAGAWAD 6', 'Hon. Rodelio Basirel', 'assets/images/Barangay Official/6 rodelio besirel.jpg', '', 9),
('kagawad_7', 3, 'BARANGAY KAGAWAD 7', 'Hon. Jimmy Daligdig', 'assets/images/Barangay Official/7 jimmy daligdig.jpg', '', 10)
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `role`=VALUES(`role`), `image`=VALUES(`image`), `message`=VALUES(`message`), `display_order`=VALUES(`display_order`);

-- --------------------------------------------------------

--
-- Table structure for table `sk_officials`
--

CREATE TABLE IF NOT EXISTS `sk_officials` (
  `id` varchar(50) NOT NULL,
  `level` int(11) NOT NULL DEFAULT 3,
  `role` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `image` varchar(255) DEFAULT '',
  `message` text DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_officials`
--

INSERT INTO `sk_officials` (`id`, `level`, `role`, `name`, `image`, `message`, `display_order`) VALUES
('sk_chairperson', 1, 'SK CHAIRPERSON', 'Hon. Artem Macmac', 'assets/images/SK Official/sk chairperson artem mamac.jpg', 'Empowering the youth of Barangay San Jose through active participation in sports, education, and community development.', 1),
('sk_secretary', 2, 'SK SECRETARY', 'Ms. Liza Santos', '', '', 2),
('sk_treasurer', 2, 'SK TREASURER', 'Mr. Antonio Luna', '', '', 3),
('sk_kagawad_1', 3, 'SK KAGAWAD 1', 'Hon. Ana Villanueva', '', '', 4),
('sk_kagawad_2', 3, 'SK KAGAWAD 2', 'Hon. Luis Garcia', '', '', 5),
('sk_kagawad_3', 3, 'SK KAGAWAD 3', 'Hon. Maria Santos', '', '', 6),
('sk_kagawad_4', 3, 'SK KAGAWAD 4', 'Hon. Juanito Perez', '', '', 7),
('sk_kagawad_5', 3, 'SK KAGAWAD 5', 'Hon. Elena Cruz', '', '', 8),
('sk_kagawad_6', 3, 'SK KAGAWAD 6', 'Hon. Ricardo Gomez', '', '', 9),
('sk_kagawad_7', 3, 'SK KAGAWAD 7', 'Hon. Pedro Reyes', '', '', 10)
-- --------------------------------------------------------

--
-- Table structure for table `barangay_about`
--

CREATE TABLE IF NOT EXISTS `barangay_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) NOT NULL DEFAULT 'assets/images/Barangay Hall.png',
  `history` longtext NOT NULL,
  `vision` text NOT NULL,
  `mission` text NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_about`
--

INSERT INTO `barangay_about` (`id`, `image_path`, `history`, `vision`, `mission`) VALUES
(1, 'assets/images/Barangay Hall.png', 'Maruing once under the jurisdiction of Margosatubig, before it was declared as a Municipality in 1964 during the time of late Diosdado Macapagal and then reverted into Barangay in 1965. According to the Subanen leaders of Elders, the term Maruing came from two[2] Subanen words \"MARU\" which means bad odor and \"DUWING\" a Subanen word a term for gigantic wild boar having fangs that grew out rares from his mouth because of the incredible strength. According to the story, a Subanen hunter went to the forest looking for wild animals. Using his spear the hunter was able to hit a wild boar or the DUWING but unluckily failed to catch it. Thus, the hunter kept on looking the animal until found a very nice place where two rivers meet creating a big river before it proceeds to the sea. Because he did not find the wild boar but instead the beautiful place, he went home and reported to his co-villagers about a beautiful place where they could establish their community because of its strategic location and abundance of water.\r\n\r\nAfter few days, the hunter and his community decided to visit the said beautiful place and there they observed \"MARU\" or bad odor where they believed to be the \"DUWING\" that escaped from hunting. Since they do not know the name of the place, they combined the two words of MARU and DUWING and they called the place Marwing. It was only changed to MARUING during the time of Barangay Captain Lorenzo Bugao.\r\n\r\nBarangay Maruing is the home of the Subanen, one of the 18 major tribes of the Lumad in Mindanao. The first Subanen families who inhabited the place were the families of Mangangot, Balabad, Bugao and Hupa and the first chinesse families were Pula, Wasing and Costan whom later killed by bandits. From the Muslim tribes, it was the families of Manopod who went and settle first in Maruing.\r\n\r\nBased on the record, of the Municipal Planning Development Office of Lapuyan, Zamboanga del Sur, Maruing was created into Barangay on January 17, 1958 by Virtue of Republic Act 226 from from being a Sitio of once Barangay Lapuyan, which was under the Municipality of Margosatubig. Even before the formal creation of Barangay Maruing, the American Government had already appointed a Teniente del Barrio or Chief Executive aside from the traditional political set-up of Datu System, which is headed by Datu Sapalao. In fact, there were times that Datu Sapalao was also appointed as Teniente del Barrio, particularly Datu Sapalao Consing Bugao in 1930\'s and Datu Sapalao Mandag Humoa in 1940\'s.\r\n\r\nThe second Teniente del Barrio or Barrio at Large after Maruing was fully recognized as a Barangay was Tere Mangangot who served from 1958-1961. His councillors include Ajerol Arip, John Banagan, Tumandio Lesayao, Tumindeg Tahupis, and Tumanghis Antay. During his term, they constructed a bridged at the center of Barangay and they actively participated the clean and green Revolution Program of the National Government. In 1961, Timuay Tumindeg Tahupis, member of the Tribal Leaders of Maruing succeeded Tere Mangangot until 1964. He continued the projects of his predecessor and led in developing the sports activities and competitions with other municipalities.', 'Usa ka malinawon, mauswagon, ug empowered nga barangay diin ang mga residente nagkinabuhi nga nagkahiusa adunay aksesa sa batakang serbisyo, ug aktibong miapil sa malungtarong kalambuan.', 'Sa paghatag ug epiktibo, transparent ug maka-katawhang pagdumala nga nagpalambo sa kalinaw ug kahusay, naghatod ug kalidad nga mga serbisyong publiko, nagapalipod sa kinaiyahan, ug nagpalambo sa kaayohan sa matag residente pinaagi sa aktibong partisipasyon sa kumonidad ug matinud-anong liderato.')
ON DUPLICATE KEY UPDATE `image_path`=VALUES(`image_path`), `history`=VALUES(`history`), `vision`=VALUES(`vision`), `mission`=VALUES(`mission`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
