<?php
header('Content-Type: application/json');
include '../../db_connect.php';

$session_id = isset($_GET['session_id']) ? (int)$_GET['session_id'] : 0;

if ($session_id === 0) {
    echo json_encode(["status" => "error", "message" => "Invalid session ID"]);
    exit;
}

$stmt = $conn->prepare("SELECT sender, message, DATE_FORMAT(created_at, '%h:%i %p') as time 
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
