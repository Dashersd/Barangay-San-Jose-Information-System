<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../db_connect.php';

$res = $conn->query("UPDATE chat_messages SET is_read = 1 WHERE sender = 'user' AND is_read = 0");

if ($res) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
?>
