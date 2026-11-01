<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../db_connect.php';

$thread_id = '';
if (!empty($_GET['thread_id'])) {
    $thread_id = trim($_GET['thread_id']);
} elseif (!empty($_GET['session_id'])) {
    $thread_id = trim($_GET['session_id']);
}

if ($thread_id === '') {
    echo json_encode(["status" => "error", "message" => "Invalid thread ID"]);
    exit;
}

// Mark all user messages for this thread as read
$upd = $conn->prepare("UPDATE feedback_chats SET is_read = 1 WHERE thread_id = ? AND sender_type = 'user' AND is_read = 0");
if ($upd) {
    $upd->bind_param("s", $thread_id);
    $upd->execute();
    $upd->close();
}

$stmt = $conn->prepare("SELECT id, thread_id, sender_name, email, service_type, sender_type, sender_type AS sender, message, file_attachment, file_name, file_attachment AS attachment_file, file_name AS attachment_name, DATE_FORMAT(created_at, '%h:%i %p') AS time, created_at
                        FROM feedback_chats
                        WHERE thread_id = ?
                        ORDER BY id ASC");
$stmt->bind_param("s", $thread_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
$threadMeta = [
    'thread_id' => $thread_id,
    'sender_name' => 'Resident',
    'email' => '',
    'service_type' => 'General Inquiry'
];

$first = true;
while ($row = $result->fetch_assoc()) {
    if ($first) {
        $threadMeta['sender_name'] = $row['sender_name'] ?: 'Resident';
        $threadMeta['service_type'] = $row['service_type'] ?: 'General Inquiry';
        $first = false;
    }
    if (empty($threadMeta['email']) && !empty($row['email'])) {
        $threadMeta['email'] = $row['email'];
    }
    $messages[] = $row;
}
$stmt->close();

echo json_encode([
    "status" => "success",
    "thread" => $threadMeta,
    "messages" => $messages
]);
?>
