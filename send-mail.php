<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Email headers
    $headers  = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send mail
    if (mail($to, $mail_subject, $body, $headers)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid";
}
?>
