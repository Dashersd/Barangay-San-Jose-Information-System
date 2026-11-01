<?php
/**
 * Step 1: Dispatch 6-Digit Gmail OTP for Resident Inquiry
 * Barangay San Jose Web-Based Information System
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../db_connect.php';
require_once __DIR__ . '/smtp_config.php';

$action = trim($_POST['action'] ?? 'send');

// Handle OTP Resend Request
if ($action === 'resend') {
    if (empty($_SESSION['pending_otp_inquiry'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'No pending inquiry found. Please fill out and submit the inquiry form again.'
        ]);
        exit;
    }

    $pending = $_SESSION['pending_otp_inquiry'];
    $elapsed = time() - (int)($pending['last_sent_at'] ?? 0);
    if ($elapsed < 28) {
        $wait = 30 - $elapsed;
        echo json_encode([
            'status'  => 'error',
            'message' => "Please wait {$wait} seconds before requesting a new code."
        ]);
        exit;
    }

    $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $_SESSION['pending_otp_inquiry']['otp']          = $otp;
    $_SESSION['pending_otp_inquiry']['expires_at']   = time() + 180; // 3 minutes
    $_SESSION['pending_otp_inquiry']['last_sent_at'] = time();

    $mailResult = sendGmailOtpEmail(
        $pending['email'],
        $pending['name'],
        $otp,
        $pending['service_type']
    );

    echo json_encode([
        'status'     => 'success',
        'message'    => 'A new 6-digit verification code has been dispatched to ' . $pending['email'],
        'email'      => $pending['email'],
        'expires_in' => 180,
        'mail_sent'  => $mailResult['sent'],
        'otp_preview'=> $mailResult['sent'] ? null : $otp
    ]);
    exit;
}

// Standard Initial Inquiry Submission -> Generate & Send OTP
$name         = trim($_POST['name'] ?? $_POST['sender_name'] ?? '');
$email        = trim($_POST['email'] ?? '');
$service_type = trim($_POST['service_type'] ?? $_POST['service'] ?? 'General Inquiry');
$message      = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Please complete all required fields (Name, Gmail Address, Service Type, and Message).'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Please enter a valid Gmail or email address.'
    ]);
    exit;
}

if ($service_type === '') {
    $service_type = 'General Inquiry / Feedback';
}

$otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);

$_SESSION['pending_otp_inquiry'] = [
    'name'         => $name,
    'email'        => $email,
    'service_type' => $service_type,
    'message'      => $message,
    'otp'          => $otp,
    'expires_at'   => time() + 180, // 3 minutes (180 seconds)
    'last_sent_at' => time()
];

$mailResult = sendGmailOtpEmail($email, $name, $otp, $service_type);

echo json_encode([
    'status'      => 'success',
    'message'     => 'Verification code sent to ' . $email,
    'email'       => $email,
    'expires_in'  => 180,
    'mail_sent'   => $mailResult['sent'],
    'otp_preview' => $mailResult['sent'] ? null : $otp
]);

