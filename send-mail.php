<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. reCAPTCHA Validation
    $secretKey = "6Ld29s0rAAAAALA0SDvjS8cFk9DZ6gXTAwkqx-Yx"; // Replace with your secret key from Google reCAPTCHA
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];

    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
    $response = file_get_contents($verifyUrl);
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        die("Verification failed. Please go back and confirm you are not a robot.");
    }

    // 2. Collect Form Data
    $name     = htmlspecialchars($_POST['name']);
    $email    = htmlspecialchars($_POST['email']);
    $phone    = htmlspecialchars($_POST['Phone']);
    $subject  = htmlspecialchars($_POST['subject']);
    $location = htmlspecialchars($_POST['location']);
    $date     = htmlspecialchars($_POST['date']);
    $time     = htmlspecialchars($_POST['time']);
    $message  = htmlspecialchars($_POST['message']);

    // 3. Prepare Email
    $to      = "support@canprosys.com"; // Replace with your email
    $mailSubject = "New Contact Form Submission: $subject";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $mailBody = "
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

    // 4. Send Email
    if (mail($to, $mailSubject, $mailBody, $headers)) {
        echo "Thank you, your request has been submitted successfully!";
    } else {
        echo "Sorry, something went wrong. Please try again.";
    }
} else {
    echo "Invalid Request.";
}
?>
