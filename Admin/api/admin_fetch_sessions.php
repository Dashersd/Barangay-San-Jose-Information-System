<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../db_connect.php';

// Ensure is_read column exists in chat_messages table
$checkCol = $conn->query("SHOW COLUMNS FROM chat_messages LIKE 'is_read'");
if ($checkCol && $checkCol->num_rows == 0) {
    $conn->query("ALTER TABLE chat_messages ADD COLUMN is_read TINYINT(1) NOT NULL DEFAULT 0");
}


// Fetch sessions ordered by latest activity (newest message first)
$sql = "SELECT s.id, s.user_name, s.service_type, s.created_at,
        (SELECT message FROM chat_messages WHERE session_id = s.id ORDER BY id DESC LIMIT 1) as last_msg,
        (SELECT DATE_FORMAT(created_at, '%h:%i %p') FROM chat_messages WHERE session_id = s.id ORDER BY id DESC LIMIT 1) as time,
        (SELECT id FROM chat_messages WHERE session_id = s.id ORDER BY id DESC LIMIT 1) as last_msg_id,
        (SELECT sender FROM chat_messages WHERE session_id = s.id ORDER BY id DESC LIMIT 1) as last_sender,
        (SELECT COUNT(*) FROM chat_messages WHERE session_id = s.id AND sender = 'user' AND is_read = 0) as unread_count,
        COALESCE((SELECT created_at FROM chat_messages WHERE session_id = s.id ORDER BY id DESC LIMIT 1), s.created_at) as last_activity
        FROM chat_sessions s 
        ORDER BY last_activity DESC";

$result = $conn->query($sql);
$sessions = [];
if ($result) {
    while($row = $result->fetch_assoc()){
        $row['unread_count'] = (int)$row['unread_count'];
        $sessions[] = $row;
    }
}

// Total unread user messages count
$unreadRes = $conn->query("SELECT COUNT(*) as total_unread FROM chat_messages WHERE sender = 'user' AND is_read = 0");
$total_unread = 0;
if ($unreadRes && $uRow = $unreadRes->fetch_assoc()) {
    $total_unread = (int)$uRow['total_unread'];
}

// Latest incoming user message across the entire system
$latestMsgRes = $conn->query("SELECT m.id, m.session_id, m.message, DATE_FORMAT(m.created_at, '%h:%i %p') as time, s.user_name, s.service_type 
                              FROM chat_messages m 
                              JOIN chat_sessions s ON m.session_id = s.id 
                              WHERE m.sender = 'user' 
                              ORDER BY m.id DESC LIMIT 1");
$latest_message = ($latestMsgRes && $latestMsgRes->num_rows > 0) ? $latestMsgRes->fetch_assoc() : null;

// List of unread sender notifications for the bell dropdown
$notifSql = "SELECT s.id as session_id, s.user_name, s.service_type, m.message, DATE_FORMAT(m.created_at, '%h:%i %p') as time, m.id as msg_id
             FROM chat_messages m
             JOIN chat_sessions s ON m.session_id = s.id
             WHERE m.sender = 'user' AND m.is_read = 0
             ORDER BY m.id DESC LIMIT 10";
$notifRes = $conn->query($notifSql);
$notifications = [];
if ($notifRes) {
    while($nRow = $notifRes->fetch_assoc()){
        $notifications[] = $nRow;
    }
}

echo json_encode([
    "status" => "success",
    "sessions" => $sessions,
    "total_unread" => $total_unread,
    "latest_message" => $latest_message,
    "notifications" => $notifications
]);
?>
