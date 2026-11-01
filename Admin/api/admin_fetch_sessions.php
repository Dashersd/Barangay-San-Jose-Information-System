<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../db_connect.php';

function formatRelativeInquiryTime($datetimeStr) {
    if (empty($datetimeStr)) return '';
    $ts = strtotime($datetimeStr);
    if (!$ts) return '';
    $diff = time() - $ts;
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . 'm ago';
    if ($diff < 86400) return floor($diff / 3600) . 'h ago';
    if ($diff < 604800) return floor($diff / 86400) . 'd ago';
    return date('M d', $ts);
}

// Fetch distinct inquiry threads from feedback_chats ordered by latest activity
$sql = "SELECT 
            t.thread_id,
            t.thread_id AS id,
            (SELECT sender_name FROM feedback_chats WHERE thread_id = t.thread_id ORDER BY id ASC LIMIT 1) AS sender_name,
            (SELECT email FROM feedback_chats WHERE thread_id = t.thread_id AND email IS NOT NULL AND email != '' ORDER BY id ASC LIMIT 1) AS email,
            (SELECT service_type FROM feedback_chats WHERE thread_id = t.thread_id ORDER BY id ASC LIMIT 1) AS service_type,
            (SELECT message FROM feedback_chats WHERE thread_id = t.thread_id ORDER BY id DESC LIMIT 1) AS last_msg,
            (SELECT DATE_FORMAT(created_at, '%h:%i %p') FROM feedback_chats WHERE thread_id = t.thread_id ORDER BY id DESC LIMIT 1) AS time,
            (SELECT id FROM feedback_chats WHERE thread_id = t.thread_id ORDER BY id DESC LIMIT 1) AS last_msg_id,
            (SELECT sender_type FROM feedback_chats WHERE thread_id = t.thread_id ORDER BY id DESC LIMIT 1) AS last_sender,
            (SELECT COUNT(*) FROM feedback_chats WHERE thread_id = t.thread_id AND sender_type = 'user' AND is_read = 0) AS unread_count,
            t.last_activity,
            t.first_created AS created_at
        FROM (
            SELECT thread_id, MAX(created_at) AS last_activity, MIN(created_at) AS first_created, MAX(id) AS max_id
            FROM feedback_chats
            GROUP BY thread_id
        ) t
        ORDER BY t.last_activity DESC, t.max_id DESC";

$result = $conn->query($sql);
$sessions = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['unread_count'] = (int)$row['unread_count'];
        $row['user_name'] = $row['sender_name'] ?: 'Resident';
        $row['sender_name'] = $row['user_name'];
        $row['email'] = $row['email'] ?: '';
        $row['service_type'] = $row['service_type'] ?: 'General Inquiry';
        $row['relative_time'] = formatRelativeInquiryTime($row['last_activity']);
        $sessions[] = $row;
    }
}

// Total unread user messages count
$unreadRes = $conn->query("SELECT COUNT(*) AS total_unread FROM feedback_chats WHERE sender_type = 'user' AND is_read = 0");
$total_unread = 0;
if ($unreadRes && $uRow = $unreadRes->fetch_assoc()) {
    $total_unread = (int)$uRow['total_unread'];
}

// Latest incoming user message across the entire system
$latestMsgRes = $conn->query("SELECT id, thread_id, thread_id AS session_id, sender_name, sender_name AS user_name, email, service_type, message, DATE_FORMAT(created_at, '%h:%i %p') AS time
                              FROM feedback_chats
                              WHERE sender_type = 'user'
                              ORDER BY id DESC LIMIT 1");
$latest_message = ($latestMsgRes && $latestMsgRes->num_rows > 0) ? $latestMsgRes->fetch_assoc() : null;

// List of unread sender notifications for the bell dropdown
$notifSql = "SELECT id AS msg_id, thread_id, thread_id AS session_id, sender_name, sender_name AS user_name, email, service_type, message, DATE_FORMAT(created_at, '%h:%i %p') AS time, created_at
             FROM feedback_chats
             WHERE sender_type = 'user' AND is_read = 0
             ORDER BY id DESC LIMIT 12";
$notifRes = $conn->query($notifSql);
$notifications = [];
if ($notifRes) {
    while ($nRow = $notifRes->fetch_assoc()) {
        $nRow['relative_time'] = formatRelativeInquiryTime($nRow['created_at']);
        $notifications[] = $nRow;
    }
}

echo json_encode([
    "status" => "success",
    "sessions" => $sessions,
    "threads" => $sessions,
    "total_unread" => $total_unread,
    "latest_message" => $latest_message,
    "notifications" => $notifications
]);
?>
