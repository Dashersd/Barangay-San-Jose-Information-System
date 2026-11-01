<?php
/**
 * Step 3: Verify 6-Digit Gmail OTP & Save Resident Inquiry to feedback_chats
 * Barangay San Jose Web-Based Information System
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../db_connect.php';

$submittedOtp = preg_replace('/[^0-9]/', '', $_POST['otp'] ?? '');

if (strlen($submittedOtp) !== 6) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Please enter the complete 6-digit verification code.'
    ]);
    exit;
}

if (empty($_SESSION['pending_otp_inquiry'])) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Your verification session has expired or was not found. Please submit your inquiry again.'
    ]);
    exit;
}

$pending = $_SESSION['pending_otp_inquiry'];

if (time() > (int)($pending['expires_at'] ?? 0)) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'This 6-digit OTP code has expired (3-minute limit). Please click "Resend Code" to get a new one.'
    ]);
    exit;
}

if (!hash_equals((string)$pending['otp'], $submittedOtp)) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Invalid verification code. Please check the 6-digit code sent to your Gmail and try again.'
    ]);
    exit;
}

// OTP Verified -> Insert into feedback_chats
$sender_name  = $pending['name'];
$email        = $pending['email'];
$service_type = $pending['service_type'] ?: 'General Inquiry';
$message      = $pending['message'];
$thread_id    = 'inq_' . date('YmdHis') . '_' . bin2hex(random_bytes(4));

$stmt = $conn->prepare("INSERT INTO `feedback_chats` (`thread_id`, `sender_name`, `email`, `service_type`, `sender_type`, `message`, `is_read`) VALUES (?, ?, ?, ?, 'user', ?, 0)");
if (!$stmt) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error while saving inquiry: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("sssss", $thread_id, $sender_name, $email, $service_type, $message);
if ($stmt->execute()) {
    $insertId = $stmt->insert_id;
    $stmt->close();

    // Clear pending OTP session
    unset($_SESSION['pending_otp_inquiry']);

    echo json_encode([
        'status'       => 'success',
        'message'      => 'Your Gmail address has been verified and your inquiry has been sent to Barangay San Jose!',
        'id'           => $insertId,
        'thread_id'    => $thread_id,
        'name'         => $sender_name,
        'email'        => $email,
        'service_type' => $service_type
    ]);
} else {
    $err = $stmt->error;
    $stmt->close();
    echo json_encode([
        'status'  => 'error',
        'message' => 'Failed to save inquiry: ' . $err
    ]);
}

