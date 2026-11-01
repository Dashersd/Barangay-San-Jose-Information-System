<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../db_connect.php';

$thread_id = '';
if (!empty($_POST['thread_id'])) {
    $thread_id = trim($_POST['thread_id']);
} elseif (!empty($_POST['session_id'])) {
    $thread_id = trim($_POST['session_id']);
}

$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$attachment_file = null;
$attachment_name = null;

if ($thread_id === '') {
    echo json_encode(["status" => "error", "message" => "Invalid thread ID"]);
    exit;
}

// 1. Check if a pre-existing service template was chosen
if (!empty($_POST['service_doc_path'])) {
    $cleanPath = str_replace(['../', '..\\'], '', trim($_POST['service_doc_path']));
    $fullTest = dirname(dirname(__DIR__)) . '/' . ltrim($cleanPath, '/\\');
    if (is_file($fullTest)) {
        $attachment_file = ltrim($cleanPath, '/\\');
        $attachment_name = !empty($_POST['service_doc_name'])
            ? trim($_POST['service_doc_name'])
            : basename($attachment_file);
    }
}

// 2. Check if a document file was uploaded
if (isset($_FILES['chatDocument']) && $_FILES['chatDocument']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['chatDocument'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $allowed)) {
        echo json_encode(["status" => "error", "message" => "Invalid file type. Allowed: PDF, DOC, DOCX, JPG, PNG, WEBP."]);
        exit;
    }

    $uploadDir = dirname(dirname(__DIR__)) . '/uploads/documents/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filename = time() . '_' . uniqid() . '.' . $ext;
    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $attachment_file = 'uploads/documents/' . $filename;
        $attachment_name = pathinfo($file['name'], PATHINFO_BASENAME);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save uploaded document."]);
        exit;
    }
}

// Must have either message or attachment
if (empty($message) && empty($attachment_file)) {
    echo json_encode(["status" => "error", "message" => "Please enter a message or attach a document."]);
    exit;
}

if (empty($message) && !empty($attachment_name)) {
    $message = "Sent a document: " . $attachment_name;
}

// Look up resident thread info so thread metadata remains consistent
$sender_name = 'Barangay San Jose Admin';
$email = null;
$service_type = 'General Inquiry';

$metaStmt = $conn->prepare("SELECT sender_name, email, service_type FROM feedback_chats WHERE thread_id = ? ORDER BY id ASC LIMIT 1");
if ($metaStmt) {
    $metaStmt->bind_param("s", $thread_id);
    $metaStmt->execute();
    $metaRes = $metaStmt->get_result();
    if ($metaRow = $metaRes->fetch_assoc()) {
        $sender_name = $metaRow['sender_name'] ?: 'Resident';
        $email = $metaRow['email'];
        $service_type = $metaRow['service_type'] ?: 'General Inquiry';
    }
    $metaStmt->close();
}

$stmt = $conn->prepare("INSERT INTO feedback_chats (thread_id, sender_name, email, service_type, sender_type, message, file_attachment, file_name, is_read) VALUES (?, ?, ?, ?, 'admin', ?, ?, ?, 1)");
$stmt->bind_param("sssssss", $thread_id, $sender_name, $email, $service_type, $message, $attachment_file, $attachment_name);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "attachment_file" => $attachment_file,
        "attachment_name" => $attachment_name
    ]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
$stmt->close();
?>
