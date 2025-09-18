<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php'; // Adjust path if needed

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';          // SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'aditya.gupin1950@gmail.com';    // Your SMTP username
    $mail->Password   = 'jrehsbhvkmjoajgb';       // Your SMTP password or app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                     // Encryption (tls or ssl)
    $mail->Port       = 587;                        // SMTP port

    // Recipients
    $mail->setFrom('aditya.gupin1950@gmail.com', 'Your Name');
    $mail->addAddress('support@canprosys.com', 'Recipient Name'); // Add a recipient

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = '<b>This is a test email sent locally with PHPMailer!</b>';
    $mail->AltBody = 'This is a test email sent locally with PHPMailer!';

    $mail->send();
    echo "Message has been sent successfully";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
