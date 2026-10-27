<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../db_connect.php';

$session_id = isset($_POST['session_id']) ? (int)$_POST['session_id'] : 0;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$attachment_file = null;
$attachment_name = null;

if ($session_id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid session"]);
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
    $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

    if (!in_array($ext, $allowed)) {
        echo json_encode(["status" => "error", "message" => "Invalid file type. Allowed: PDF, DOC, DOCX, JPG, PNG."]);
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

$stmt = $conn->prepare("INSERT INTO chat_messages (session_id, sender, message, attachment_file, attachment_name) VALUES (?, 'admin', ?, ?, ?)");
$stmt->bind_param("isss", $session_id, $message, $attachment_file, $attachment_name);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "attachment_file" => $attachment_file,
        "attachment_name" => $attachment_name
    ]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
?>
