<?php
/**
 * Gmail SMTP Configuration & Native Socket Mailer
 * Barangay San Jose Web-Based Information System
 */

$SMTP_CONFIG = [
    'smtp_host'  => 'smtp.gmail.com',
    'smtp_port'  => 587, // 587 (STARTTLS) or 465 (SSL)
    'smtp_user'  => getenv('GMAIL_SMTP_USER') ?: 'mugiw200@gmail.com',
    'smtp_pass'  => getenv('GMAIL_SMTP_APP_PASSWORD') ?: 'kxjd umjr jiob vqmj', // 16-char Google App Password for mugiw200@gmail.com
    'from_email' => getenv('GMAIL_SMTP_USER') ?: 'mugiw200@gmail.com',
    'from_name'  => 'Barangay San Jose Official Portal'
];

// Dynamically load Gmail SMTP credentials from barangay_information if configured in Admin Settings
if (isset($conn) && !$conn->connect_error) {
    $colCheck = $conn->query("SHOW COLUMNS FROM `barangay_information` LIKE 'smtp_app_password'");
    if ($colCheck && $colCheck->num_rows > 0) {
        $smtpRes = $conn->query("SELECT smtp_email, smtp_app_password FROM barangay_information WHERE id = 1 LIMIT 1");
        if ($smtpRes && $smtpRow = $smtpRes->fetch_assoc()) {
            if (!empty(trim($smtpRow['smtp_email'] ?? ''))) {
                $SMTP_CONFIG['smtp_user']  = trim($smtpRow['smtp_email']);
                $SMTP_CONFIG['from_email'] = trim($smtpRow['smtp_email']);
            }
            if (!empty(trim($smtpRow['smtp_app_password'] ?? ''))) {
                $SMTP_CONFIG['smtp_pass'] = trim($smtpRow['smtp_app_password']);
            }
        }
    }
}

/**
 * Send a formatted 6-digit OTP verification email via Gmail SMTP (587 STARTTLS / 465 SSL)
 */
function sendGmailOtpEmail($toEmail, $toName, $otpCode, $serviceType = 'General Inquiry') {
    global $SMTP_CONFIG;

    $host      = $SMTP_CONFIG['smtp_host'] ?? 'smtp.gmail.com';
    $user      = $SMTP_CONFIG['smtp_user'] ?? 'mugiw200@gmail.com';
    $pass      = str_replace(' ', '', trim($SMTP_CONFIG['smtp_pass'] ?? ''));
    $fromEmail = $SMTP_CONFIG['from_email'] ?? $user;
    $fromName  = $SMTP_CONFIG['from_name'] ?? 'Barangay San Jose Official Portal';

    $safeName    = htmlspecialchars($toName ?: 'Resident', ENT_QUOTES, 'UTF-8');
    $safeService = htmlspecialchars($serviceType ?: 'General Inquiry', ENT_QUOTES, 'UTF-8');
    $safeOtp     = htmlspecialchars($otpCode, ENT_QUOTES, 'UTF-8');
    $subject     = "[$otpCode] Barangay San Jose - Gmail OTP Verification Code";

    $htmlBody = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Gmail OTP Verification - Barangay San Jose</title>
    </head>
    <body style='margin:0;padding:0;background-color:#f1f5f9;font-family:Inter,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Arial,sans-serif;'>
        <table width='100%' cellpadding='0' cellspacing='0' style='background-color:#f1f5f9;padding:32px 16px;'>
            <tr>
                <td align='center'>
                    <table width='100%' style='max-width:520px;background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 25px rgba(13,40,71,0.08);border:1px solid #e2e8f0;'>
                        <tr>
                            <td style='background:linear-gradient(135deg,#0d2847 0%,#1a73e8 100%);padding:28px 24px;text-align:center;color:#ffffff;'>
                                <div style='font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#fbbf24;margin-bottom:6px;'>Official Resident Verification</div>
                                <h1 style='margin:0;font-size:22px;font-weight:800;letter-spacing:-0.01em;color:#ffffff;'>BARANGAY SAN JOSE</h1>
                                <p style='margin:4px 0 0;font-size:13px;color:rgba(255,255,255,0.85);'>Lapuyan, Zamboanga del Sur</p>
                            </td>
                        </tr>
                        <tr>
                            <td style='padding:28px 28px 24px;color:#1e293b;'>
                                <p style='margin:0 0 12px;font-size:15px;'>Good day, <strong>{$safeName}</strong>!</p>
                                <p style='margin:0 0 20px;font-size:14px;line-height:1.6;color:#475569;'>
                                    To verify your Gmail address and submit your inquiry regarding <strong style='color:#0d2847;'>{$safeService}</strong>, please enter the 6-digit verification code below:
                                </p>
                                <div style='background:#f8fafc;border:2px dashed #1a73e8;border-radius:12px;padding:20px;text-align:center;margin:0 0 20px;'>
                                    <div style='font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#64748b;margin-bottom:6px;'>Your 6-Digit Verification Code</div>
                                    <div style='font-size:34px;font-weight:800;letter-spacing:8px;color:#0d2847;font-family:monospace;'>{$safeOtp}</div>
                                </div>
                                <p style='margin:0 0 8px;font-size:13px;color:#64748b;text-align:center;'>
                                    ⏱ This code will expire in <strong>3 minutes</strong>.
                                </p>
                                <p style='margin:0 0 8px;font-size:12px;color:#0d2847;text-align:center;background:#eff6ff;padding:8px 12px;border-radius:8px;'>
                                    📬 <strong>Note:</strong> Please check both your <strong>Gmail Primary Inbox</strong> and your <strong>Spam / Junk folder</strong>.
                                </p>
                                <p style='margin:0;font-size:12px;color:#94a3b8;text-align:center;'>
                                    If you did not initiate this inquiry on the Barangay San Jose portal, you may safely ignore this email.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style='background:#f8fafc;border-top:1px solid #e2e8f0;padding:16px 24px;text-align:center;font-size:12px;color:#64748b;'>
                                &copy; " . date('Y') . " Barangay San Jose Web-Based Information System &bull; Bayanihan &bull; Serbisyong Totoo
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>";

    // Attempt SMTP connection (try 587 STARTTLS first, then 465 SSL)
    $portsToTry = [
        ['port' => 587, 'protocol' => 'tcp', 'starttls' => true],
        ['port' => 465, 'protocol' => 'ssl', 'starttls' => false]
    ];

    $lastError = '';
    foreach ($portsToTry as $attempt) {
        $res = smtpRawSend($host, $attempt['port'], $attempt['protocol'], $attempt['starttls'], $user, $pass, $fromEmail, $fromName, $toEmail, $toName, $subject, $htmlBody);
        if ($res['success']) {
            return ['sent' => true, 'method' => 'smtp_' . $attempt['port']];
        }
        $lastError = $res['error'];
    }

    // Fallback: try PHP mail() if configured in php.ini
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: {$fromName} <{$fromEmail}>\r\n";
    $headers .= "Reply-To: {$fromEmail}\r\n";
    $mailSent = @mail($toEmail, $subject, $htmlBody, $headers);

    return [
        'sent'  => (bool)$mailSent,
        'error' => $lastError
    ];
}

/**
 * Low-level RFC SMTP sender supporting STARTTLS (587) and SSL (465)
 */
function smtpRawSend($host, $port, $protocol, $useStartTls, $user, $pass, $fromEmail, $fromName, $toEmail, $toName, $subject, $htmlBody) {
    if (empty($user) || empty($pass)) {
        return ['success' => false, 'error' => 'SMTP credentials not set'];
    }

    $remote = ($protocol === 'ssl' ? 'ssl://' : 'tcp://') . $host . ':' . $port;
    $context = stream_context_create([
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        ]
    ]);

    $fp = @stream_socket_client($remote, $errno, $errstr, 8, STREAM_CLIENT_CONNECT, $context);
    if (!$fp) {
        return ['success' => false, 'error' => "Connection failed ($errno): $errstr"];
    }
    stream_set_timeout($fp, 8);

    $readResponse = function() use ($fp) {
        $data = '';
        while ($str = fgets($fp, 515)) {
            $data .= $str;
            if (substr($str, 3, 1) === ' ') break;
        }
        return $data;
    };

    $sendCmd = function($cmd) use ($fp, $readResponse) {
        fwrite($fp, $cmd . "\r\n");
        return $readResponse();
    };

    $greeting = $readResponse();
    if (strpos($greeting, '220') !== 0) {
        fclose($fp);
        return ['success' => false, 'error' => "Invalid greeting: $greeting"];
    }

    $ehlo = $sendCmd("EHLO localhost");
    if ($useStartTls) {
        $tlsResp = $sendCmd("STARTTLS");
        if (strpos($tlsResp, '220') !== 0) {
            fclose($fp);
            return ['success' => false, 'error' => "STARTTLS failed: $tlsResp"];
        }
        if (!@stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            fclose($fp);
            return ['success' => false, 'error' => "TLS negotiation failed"];
        }
        $ehlo = $sendCmd("EHLO localhost");
    }

    $authResp = $sendCmd("AUTH LOGIN");
    if (strpos($authResp, '334') !== 0) {
        fclose($fp);
        return ['success' => false, 'error' => "AUTH LOGIN rejected: $authResp"];
    }

    $userResp = $sendCmd(base64_encode($user));
    if (strpos($userResp, '334') !== 0) {
        fclose($fp);
        return ['success' => false, 'error' => "Username rejected: $userResp"];
    }

    $passResp = $sendCmd(base64_encode($pass));
    if (strpos($passResp, '235') !== 0) {
        fclose($fp);
        return ['success' => false, 'error' => "SMTP authentication failed: $passResp"];
    }

    $sendCmd("MAIL FROM:<{$fromEmail}>");
    $rcptResp = $sendCmd("RCPT TO:<{$toEmail}>");
    if (strpos($rcptResp, '250') !== 0 && strpos($rcptResp, '251') !== 0) {
        fclose($fp);
        return ['success' => false, 'error' => "RCPT TO failed: $rcptResp"];
    }

    $dataResp = $sendCmd("DATA");
    if (strpos($dataResp, '354') !== 0) {
        fclose($fp);
        return ['success' => false, 'error' => "DATA command failed: $dataResp"];
    }

    $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $encodedFrom    = '=?UTF-8?B?' . base64_encode($fromName) . "?= <{$fromEmail}>";
    $headers = [
        "Date: " . date('r'),
        "From: {$encodedFrom}",
        "To: <{$toEmail}>",
        "Subject: {$encodedSubject}",
        "MIME-Version: 1.0",
        "Content-Type: text/html; charset=UTF-8",
        "Content-Transfer-Encoding: base64"
    ];

    $rawMessage = implode("\r\n", $headers) . "\r\n\r\n" . chunk_split(base64_encode($htmlBody)) . "\r\n.";
    $msgResp = $sendCmd($rawMessage);
    $sendCmd("QUIT");
    fclose($fp);

    if (strpos($msgResp, '250') === 0) {
        return ['success' => true, 'error' => ''];
    }
    return ['success' => false, 'error' => "Send failed: $msgResp"];
}

return $SMTP_CONFIG;

