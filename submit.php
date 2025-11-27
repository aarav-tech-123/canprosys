<?php
// ===================
//  DATABASE SETTINGS
// ===================
$servername = "localhost";
$username   = "u450081634_canprosys";
$password   = "Aarav@2871#";
$dbname     = "u450081634_canprosys";

// DB Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// ========================
//  PROCESS FORM SUBMISSION
// ========================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // =============== reCAPTCHA CHECK ===============
    $recaptcha_secret = "6Ld29s0rAAAAALA0SDvjS8cFk9DZ6gXTAwkqx-Yx";  // Replace with your secret key
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $verify = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response"
    );
    $captcha_success = json_decode($verify);

    if ($captcha_success->success == false) {
        die("reCAPTCHA validation failed. Please try again.");
    }

    // =============== SANITIZE FIELDS ===============
    $name     = trim($_POST['name']);
    $phone    = trim($_POST['phone']);
    $email    = trim($_POST['email']);
    $subject  = trim($_POST['subject']);
    $location = trim($_POST['location']);
    $date     = trim($_POST['date']);
    $time     = trim($_POST['time']);
    $message  = trim($_POST['message']);

    // =============== VALIDATION ====================
    if (empty($name) || empty($phone) || empty($email) || empty($location) || empty($message)) {
        die("All required fields must be filled.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (!preg_match("/^[0-9]{8,15}$/", $phone)) {
        die("Invalid phone number.");
    }

    // =============== INSERT INTO DATABASE ============
    $stmt = $conn->prepare("INSERT INTO leads 
        (full_name, phone_number, email, subject, location, best_date_to_call, best_time_to_call, message)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssss", $name, $phone, $email, $subject, $location, $date, $time, $message);

    if ($stmt->execute()) {

        // ===========================
        //  EMAIL NOTIFICATION SYSTEM
        // ===========================

        // Admin email address
        $admin_email = "support@canprosys.com";   // 👈 UPDATE THIS

        // Email to Admin
        $admin_subject = "New Lead Received – $name";
        $admin_message = "
A new lead has been submitted:

Name: $name
Phone: $phone
Email: $email
Service: $subject
Location: $location
Preferred Date: $date
Preferred Time: $time

Message:
$message

Submitted on: " . date("Y-m-d H:i:s");

        $admin_headers = "From: no-reply@yourdomain.com";

        mail($admin_email, $admin_subject, $admin_message, $admin_headers);

        // ===========================
        //  OPTIONAL: Email to User
        // ===========================
        $user_subject = "Thank You for Contacting Us";
        $user_message = "Hi $name,\n\nThank you for reaching out. We received your request and our team will contact you shortly.\n\nRegards,\nCanprosys Consultants Inc.";

        $user_headers = "From: no-reply@yourdomain.com";

        mail($email, $user_subject, $user_message, $user_headers);

        // Redirect to thank-you page
        header("Location: thankyou.html");
        exit();
    } else {
        echo "Database Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
