<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is empty
$dbname = "barangay_sanjose_db";

// Create connection with resilient error handling
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception($conn->connect_error);
    }
} catch (Throwable $e) {
    die("<div style='font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif; max-width: 640px; margin: 50px auto; padding: 28px; border: 1px solid #fecaca; background: #fef2f2; border-radius: 12px; color: #991b1b; box-shadow: 0 4px 6px rgba(0,0,0,0.05);'>
        <h3 style='margin-top: 0; display: flex; align-items: center; gap: 8px;'>
            <svg width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2'><circle cx='12' cy='12' r='10'></circle><line x1='12' y1='8' x2='12' y2='12'></line><line x1='12' y1='16' x2='12.01' y2='16'></line></svg>
            Database Connection Error
        </h3>
        <p style='margin: 12px 0; font-size: 15px; line-height: 1.5;'>Could not connect to MySQL. Please open your <strong>XAMPP Control Panel</strong> and ensure the <strong>MySQL</strong> module is running (click <strong>Start</strong> next to MySQL).</p>
        <div style='margin-top: 16px; padding: 12px; background: #ffffff; border: 1px solid #fee2e2; border-radius: 6px; font-size: 13px; color: #7f1d1d; word-break: break-all;'>
            <strong>Details:</strong> " . htmlspecialchars($e->getMessage()) . "
        </div>
    </div>");
}
?>
