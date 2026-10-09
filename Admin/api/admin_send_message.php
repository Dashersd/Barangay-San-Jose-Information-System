<?php
header('Content-Type: application/json');
include '../../db_connect.php';

$session_id = isset($_POST['session_id']) ? (int)$_POST['session_id'] : 0;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if ($session_id === 0 || empty($message)) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO chat_messages (session_id, sender, message) VALUES (?, 'admin', ?)");
$stmt->bind_param("is", $session_id, $message);
if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
