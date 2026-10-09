<?php
session_start();
header('Content-Type: application/json');
include '../db_connect.php';

$token = $_SESSION['chat_token'] ?? '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if(empty($token) || empty($message)) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$stmt = $conn->prepare("SELECT id FROM chat_sessions WHERE session_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();
if($row = $res->fetch_assoc()){
    $session_id = $row['id'];
    $stmt2 = $conn->prepare("INSERT INTO chat_messages (session_id, sender, message) VALUES (?, 'user', ?)");
    $stmt2->bind_param("is", $session_id, $message);
    if($stmt2->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Session not found"]);
}
?>
