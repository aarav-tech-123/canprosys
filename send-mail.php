<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. reCAPTCHA verification
    $secretKey = "6Ld29s0rAAAAALA0SDvjS8cFk9DZ6gXTAwkqx-Yx"; // <-- Replace with your real secret key
    $responseKey = $_POST['g-recaptcha-response'] ?? '';
    $userIP = $_SERVER['REMOTE_ADDR'];

    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
    $response = file_get_contents($verifyUrl);
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        die("❌ Verification failed. Please check the reCAPTCHA.");
    }

    // 2. Collect form data
    $name     = htmlspecialchars($_POST['name'] ?? '');
    $email    = htmlspecialchars($_POST['email'] ?? '');
    $phone    = htmlspecialchars($_POST['Phone'] ?? '');
    $subject  = htmlspecialchars($_POST['subject'] ?? '');
    $location = htmlspecialchars($_POST['location'] ?? '');
    $date     = htmlspecialchars($_POST['date'] ?? '');
    $time     = htmlspecialchars($_POST['time'] ?? '');
    $message  = htmlspecialchars($_POST['message'] ?? '');

    // 3. Setup PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'aditya.gupin1950@gmail.com'; 
        $mail->Password   = 'jrehsbhvkmjoajgb'; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('aditya.gupin1950@gmail.com', 'Website Contact Form');
        $mail->addAddress('support@canprosys.com', 'Support Team');

        // 4. Email content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission: $subject";
        $mail->Body    = "
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Service Requested:</strong> $subject</p>
            <p><strong>Location:</strong> $location</p>
            <p><strong>Date:</strong> $date</p>
            <p><strong>Time:</strong> $time</p>
            <p><strong>Message:</strong><br>$message</p>
        ";
        $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\nService: $subject\nLocation: $location\nDate: $date\nTime: $time\nMessage: $message";

        $mail->send();
        echo "✅ Your message has been sent successfully!";
    } catch (Exception $e) {
        echo "❌ Message could not be sent. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "❌ Invalid Request.";
}
?>
