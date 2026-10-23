<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../db_connect.php';

$session_id = isset($_GET['session_id']) ? (int)$_GET['session_id'] : 0;

if ($session_id === 0) {
    echo json_encode(["status" => "error", "message" => "Invalid session ID"]);
    exit;
}

// Mark all user messages for this session as read
$upd = $conn->prepare("UPDATE chat_messages SET is_read = 1 WHERE session_id = ? AND sender = 'user' AND is_read = 0");
if ($upd) {
    $upd->bind_param("i", $session_id);
    $upd->execute();
}

$stmt = $conn->prepare("SELECT id, sender, message, DATE_FORMAT(created_at, '%h:%i %p') as time 
                        FROM chat_messages 
                        WHERE session_id = ? 
                        ORDER BY created_at ASC");
$stmt->bind_param("i", $session_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while($row = $result->fetch_assoc()){
    $messages[] = $row;
}
echo json_encode(["status" => "success", "messages" => $messages]);
?>
