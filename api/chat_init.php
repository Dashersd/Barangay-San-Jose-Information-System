<?php
session_start();
header('Content-Type: application/json');
include '../db_connect.php';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$service = isset($_POST['service']) ? trim($_POST['service']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if(empty($name) || empty($service) || empty($message)) {
    echo json_encode(["status" => "error", "message" => "All fields required"]);
    exit;
}

$session_token = bin2hex(random_bytes(16));
$_SESSION['chat_token'] = $session_token;
$_SESSION['chat_start_time'] = time();

$stmt = $conn->prepare("INSERT INTO chat_sessions (user_name, service_type, session_token) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $service, $session_token);
if($stmt->execute()){
    $session_id = $stmt->insert_id;
    $stmt2 = $conn->prepare("INSERT INTO chat_messages (session_id, sender, message) VALUES (?, 'user', ?)");
    $stmt2->bind_param("is", $session_id, $message);
    $stmt2->execute();
    
    echo json_encode(["status" => "success", "token" => $session_token]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
