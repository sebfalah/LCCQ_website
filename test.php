<?php
$to = "lacasadelcangrejo@yahoo.com";
$subject = "Test Email";
$message = "This is a test email to verify mail() is working.";
$headers = "From: no-reply@lacasadelcangrejo.com\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully.";
} else {
    echo "Email failed to send.";
}
?>
