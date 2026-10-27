<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../services_db.php';

$sql = "SELECT id, title, document_file FROM `services` WHERE `document_file` IS NOT NULL AND `document_file` != '' AND `status` = 'active' ORDER BY `display_order` ASC, `title` ASC";
$res = $conn->query($sql);
$forms = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $forms[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'file_path' => $row['document_file'],
            'file_name' => basename($row['document_file'])
        ];
    }
}
echo json_encode(["status" => "success", "forms" => $forms]);
?>
