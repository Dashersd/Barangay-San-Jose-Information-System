<?php
session_start();
header('Content-Type: application/json');
include '../db_connect.php';

$token = $_SESSION['chat_token'] ?? '';
if(empty($token)) {
    echo json_encode(["status" => "error", "message" => "No active session"]);
    exit;
}

$stmt = $conn->prepare("SELECT m.sender, m.message, DATE_FORMAT(m.created_at, '%h:%i %p') as time 
                        FROM chat_messages m 
                        JOIN chat_sessions s ON m.session_id = s.id 
                        WHERE s.session_token = ? 
                        ORDER BY m.created_at ASC");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while($row = $result->fetch_assoc()){
    $messages[] = $row;
}
echo json_encode(["status" => "success", "messages" => $messages]);
?>
