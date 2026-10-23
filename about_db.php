<?php
// about_db.php - Central MySQL management for Barangay About Us, Vision, and Mission
require_once __DIR__ . '/db_connect.php';

/**
 * Ensure MySQL table for About Us exists and has default seed data
 */
function init_about_table($conn) {
    if (!$conn || $conn->connect_error) {
        return;
    }

    $createTableSql = "CREATE TABLE IF NOT EXISTS `barangay_about` (
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `image_path` VARCHAR(255) NOT NULL DEFAULT 'assets/images/Barangay Hall.png',
        `history` LONGTEXT NOT NULL,
        `vision` TEXT NOT NULL,
        `mission` TEXT NOT NULL,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $conn->query($createTableSql);

    // Check if table is empty
    $res = $conn->query("SELECT COUNT(*) AS total FROM `barangay_about`");
    $count = $res ? (int)$res->fetch_assoc()['total'] : 0;

    if ($count === 0) {
        $defaultHistory = "Maruing once under the jurisdiction of Margosatubig, before it was declared as a Municipality in 1964 during the time of late Diosdado Macapagal and then reverted into Barangay in 1965. According to the Subanen leaders of Elders, the term Maruing came from two[2] Subanen words \"MARU\" which means bad odor and \"DUWING\" a Subanen word a term for gigantic wild boar having fangs that grew out rares from his mouth because of the incredible strength. According to the story, a Subanen hunter went to the forest looking for wild animals. Using his spear the hunter was able to hit a wild boar or the DUWING but unluckily failed to catch it. Thus, the hunter kept on looking the animal until found a very nice place where two rivers meet creating a big river before it proceeds to the sea. Because he did not find the wild boar but instead the beautiful place, he went home and reported to his co-villagers about a beautiful place where they could establish their community because of its strategic location and abundance of water.\n\nAfter few days, the hunter and his community decided to visit the said beautiful place and there they observed \"MARU\" or bad odor where they believed to be the \"DUWING\" that escaped from hunting. Since they do not know the name of the place, they combined the two words of MARU and DUWING and they called the place Marwing. It was only changed to MARUING during the time of Barangay Captain Lorenzo Bugao.\n\nBarangay Maruing is the home of the Subanen, one of the 18 major tribes of the Lumad in Mindanao. The first Subanen families who inhabited the place were the families of Mangangot, Balabad, Bugao and Hupa and the first chinesse families were Pula, Wasing and Costan whom later killed by bandits. From the Muslim tribes, it was the families of Manopod who went and settle first in Maruing.\n\nBased on the record, of the Municipal Planning Development Office of Lapuyan, Zamboanga del Sur, Maruing was created into Barangay on January 17, 1958 by Virtue of Republic Act 226 from from being a Sitio of once Barangay Lapuyan, which was under the Municipality of Margosatubig. Even before the formal creation of Barangay Maruing, the American Government had already appointed a Teniente del Barrio or Chief Executive aside from the traditional political set-up of Datu System, which is headed by Datu Sapalao. In fact, there were times that Datu Sapalao was also appointed as Teniente del Barrio, particularly Datu Sapalao Consing Bugao in 1930's and Datu Sapalao Mandag Humoa in 1940's.\n\nThe second Teniente del Barrio or Barrio at Large after Maruing was fully recognized as a Barangay was Tere Mangangot who served from 1958-1961. His councillors include Ajerol Arip, John Banagan, Tumandio Lesayao, Tumindeg Tahupis, and Tumanghis Antay. During his term, they constructed a bridged at the center of Barangay and they actively participated the clean and green Revolution Program of the National Government. In 1961, Timuay Tumindeg Tahupis, member of the Tribal Leaders of Maruing succeeded Tere Mangangot until 1964. He continued the projects of his predecessor and led in developing the sports activities and competitions with other municipalities.";

        $defaultVision = "Usa ka malinawon, mauswagon, ug empowered nga barangay diin ang mga residente nagkinabuhi nga nagkahiusa adunay aksesa sa batakang serbisyo, ug aktibong miapil sa malungtarong kalambuan.";

        $defaultMission = "Sa paghatag ug epiktibo, transparent ug maka-katawhang pagdumala nga nagpalambo sa kalinaw ug kahusay, naghatod ug kalidad nga mga serbisyong publiko, nagapalipod sa kinaiyahan, ug nagpalambo sa kaayohan sa matag residente pinaagi sa aktibong partisipasyon sa kumonidad ug matinud-anong liderato.";

        $defaultImage = "assets/images/Barangay Hall.png";

        $stmt = $conn->prepare("INSERT INTO `barangay_about` (`id`, `image_path`, `history`, `vision`, `mission`) VALUES (1, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $defaultImage, $defaultHistory, $defaultVision, $defaultMission);
            $stmt->execute();
            $stmt->close();
        }
    }
}

/**
 * Get About Us data with fallback values
 */
function get_about_info($conn) {
    $fallback = [
        'id' => 1,
        'image_path' => 'assets/images/Barangay Hall.png',
        'history' => "Maruing once under the jurisdiction of Margosatubig...",
        'vision' => "Usa ka malinawon, mauswagon, ug empowered nga barangay diin ang mga residente nagkinabuhi nga nagkahiusa adunay aksesa sa batakang serbisyo, ug aktibong miapil sa malungtarong kalambuan.",
        'mission' => "Sa paghatag ug epiktibo, transparent ug maka-katawhang pagdumala nga nagpalambo sa kalinaw ug kahusay, naghatod ug kalidad nga mga serbisyong publiko, nagapalipod sa kinaiyahan, ug nagpalambo sa kaayohan sa matag residente pinaagi sa aktibong partisipasyon sa kumonidad ug matinud-anong liderato.",
        'updated_at' => date('Y-m-d H:i:s')
    ];

    if (!$conn || $conn->connect_error) {
        return $fallback;
    }

    init_about_table($conn);

    $sql = "SELECT * FROM `barangay_about` ORDER BY `id` ASC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        if (empty($data['image_path'])) {
            $data['image_path'] = 'assets/images/Barangay Hall.png';
        }
        return $data;
    }

    return $fallback;
}

/**
 * Update About Us, Vision, Mission, and optional Image
 */
function update_about_info($conn, $history, $vision, $mission, $image_path = null) {
    if (!$conn || $conn->connect_error) {
        return false;
    }

    init_about_table($conn);

    // Check if record exists
    $check = $conn->query("SELECT id, image_path FROM `barangay_about` ORDER BY id ASC LIMIT 1");
    if ($check && $check->num_rows > 0) {
        $row = $check->fetch_assoc();
        $id = (int)$row['id'];

        if ($image_path !== null && trim($image_path) !== '') {
            $stmt = $conn->prepare("UPDATE `barangay_about` SET `history` = ?, `vision` = ?, `mission` = ?, `image_path` = ?, `updated_at` = NOW() WHERE `id` = ?");
            if ($stmt) {
                $stmt->bind_param("ssssi", $history, $vision, $mission, $image_path, $id);
                $res = $stmt->execute();
                $stmt->close();
                return $res;
            }
        } else {
            $stmt = $conn->prepare("UPDATE `barangay_about` SET `history` = ?, `vision` = ?, `mission` = ?, `updated_at` = NOW() WHERE `id` = ?");
            if ($stmt) {
                $stmt->bind_param("sssi", $history, $vision, $mission, $id);
                $res = $stmt->execute();
                $stmt->close();
                return $res;
            }
        }
    } else {
        // Insert new record if none existed
        $img = ($image_path !== null && trim($image_path) !== '') ? $image_path : 'assets/images/Barangay Hall.png';
        $stmt = $conn->prepare("INSERT INTO `barangay_about` (`image_path`, `history`, `vision`, `mission`) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $img, $history, $vision, $mission);
            $res = $stmt->execute();
            $stmt->close();
            return $res;
        }
    }

    return false;
}
