<?php
// Test script to send a static email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

try {
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.mail.yahoo.com'; // Yahoo's SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'lacasadelcangrejo@yahoo.com'; // Your Yahoo email
    $mail->Password = 'your_app_password'; // Your Yahoo App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('lacasadelcangrejo@yahoo.com', 'La Casa del Cangrejo');
    $mail->addAddress('lacasadelcangrejo@yahoo.com'); // Recipient email

    // Content
    $mail->isHTML(false);
    $mail->Subject = "Test Email from PHP Script";
    $mail->Body = "This is a test email to confirm SMTP functionality.";

    $mail->send();
    echo "Email sent successfully.";
} catch (Exception $e) {
    echo "Failed to send email. Error: " . $mail->ErrorInfo;
}
?>
