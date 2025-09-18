<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php'; // Adjust path if needed

$mail = new PHPMailer(true);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $secretKey = "6Ld29s0rAAAAALA0SDvjS8cFk9DZ6gXTAwkqx-Yx"; // Replace with your secret key from Google reCAPTCHA
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];

    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
    $response = file_get_contents($verifyUrl);
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        die("Verification failed. Please go back and confirm you are not a robot.");
    }
    // Collect form fields safely
    $name     = htmlspecialchars($_POST['name']);
    $email    = htmlspecialchars($_POST['email']);
    $phone    = htmlspecialchars($_POST['Phone']);
    $subject  = htmlspecialchars($_POST['subject']);
    $location = htmlspecialchars($_POST['location']);
    $date     = htmlspecialchars($_POST['date']);
    $time     = htmlspecialchars($_POST['time']);
    $message  = htmlspecialchars($_POST['message']);

    // Your recipient email (must be on same domain for Hostinger mail())
    $to = "support@canprosys.com";  // <-- change this to your email

    // Subject of email
    $mail_subject = "New Contact Request: $subject";

    // Email body
    $body  = "You have received a new contact request:\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Service: $subject\n";
    $body .= "Location: $location\n";
    $body .= "Preferred Date: $date\n";
    $body .= "Preferred Time: $time\n";
    $body .= "Message:\n$message\n";

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
        $mail->setFrom('aditya.gupin1950@gmail.com', $name);
        $mail->addAddress($to, 'Recipient Name'); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = $mail_subject;
        $mail->Body    = $body;
        $mail->AltBody = 'This is a test email sent locally with PHPMailer!';

        $mail->send();
        echo "Message has been sent successfully";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }



} else {
    echo "invalid";
}

