<?php
header('Content-Type: application/json');
include '../../db_connect.php'; // Adjusted for Admin/api

$sql = "SELECT s.id, s.user_name, s.service_type, 
        (SELECT message FROM chat_messages WHERE session_id = s.id ORDER BY created_at DESC LIMIT 1) as last_msg,
        (SELECT DATE_FORMAT(created_at, '%h:%i %p') FROM chat_messages WHERE session_id = s.id ORDER BY created_at DESC LIMIT 1) as time
        FROM chat_sessions s 
        ORDER BY s.created_at DESC";

$result = $conn->query($sql);
$sessions = [];
if ($result) {
    while($row = $result->fetch_assoc()){
        $sessions[] = $row;
    }
}
echo json_encode(["status" => "success", "sessions" => $sessions]);
?>
