<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = htmlspecialchars($_POST['name']);
    $email    = htmlspecialchars($_POST['email']);
    $phone    = htmlspecialchars($_POST['Phone']);
    $subject  = htmlspecialchars($_POST['subject']);
    $location = htmlspecialchars($_POST['location']);
    $date     = htmlspecialchars($_POST['date']);
    $time     = htmlspecialchars($_POST['time']);
    $message  = htmlspecialchars($_POST['message']);

    // Recipient email (your Hostinger email)
    $to = "abhishekranjansrivastava19@gmail.com";

    // Subject line
    $mail_subject = "New Contact Request: " . $subject;

    // Email body
    $body = "
        <h2>New Contact Request</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Service:</strong> {$subject}</p>
        <p><strong>Location:</strong> {$location}</p>
        <p><strong>Date:</strong> {$date}</p>
        <p><strong>Time:</strong> {$time}</p>
        <p><strong>Message:</strong><br>{$message}</p>
    ";

    // Headers
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // IMPORTANT: Use your Hostinger email as sender
    $headers .= "From: Website Contact abhishekranjansrivastava19@gmail.com" . "\r\n";
    $headers .= "Reply-To: {$email}" . "\r\n";

    if (mail($to, $mail_subject, $body, $headers)) {
        echo "success";
    } else {
        echo "failed";
    }
}
?>
