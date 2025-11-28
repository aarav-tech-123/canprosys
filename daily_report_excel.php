<?php
// =========================
// DAILY LEADS REPORT SCRIPT
// =========================

// TEMP DEV: show all errors (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// -------------------------
// Composer autoload
// -------------------------
$autoload = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    die("Composer autoload not found. Run `composer require phpoffice/phpspreadsheet phpmailer/phpmailer`");
}
require $autoload;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// -------------------------
// Database connection
// -------------------------
$servername = "localhost";
$username   = "u450081634_canprosys";
$password   = "Aarav@2871#";
$dbname     = "u450081634_canprosys";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

// -------------------------
// Fetch leads (last 24 hrs)
// -------------------------
$query = "
    SELECT full_name, phone_number, email, subject, location,
           best_date_to_call, best_time_to_call, message, created_at
    FROM leads
    WHERE created_at >= NOW() - INTERVAL 1 DAY
    ORDER BY created_at DESC
";
$result = $conn->query($query);
if ($result === false) {
    die("DB query error: " . $conn->error);
}

if ($result->num_rows === 0) {
    echo "No leads in the last 24 hours.\n";
    $conn->close();
    exit;
}

// -------------------------
// Create Excel spreadsheet
// -------------------------
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$headers = ["Full Name", "Phone Number", "Email", "Service", "Location", "Best Date", "Best Time", "Message", "Submitted On"];
$col = 'A';
foreach ($headers as $h) {
    $sheet->setCellValue($col . '1', $h);
    $col++;
}

$rowNum = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue("A{$rowNum}", $row['full_name']);
    $sheet->setCellValue("B{$rowNum}", $row['phone_number']);
    $sheet->setCellValue("C{$rowNum}", $row['email']);
    $sheet->setCellValue("D{$rowNum}", $row['subject']);
    $sheet->setCellValue("E{$rowNum}", $row['location']);
    $sheet->setCellValue("F{$rowNum}", $row['best_date_to_call']);
    $sheet->setCellValue("G{$rowNum}", $row['best_time_to_call']);
    $sheet->setCellValue("H{$rowNum}", $row['message']);
    $sheet->setCellValue("I{$rowNum}", $row['created_at']);
    $rowNum++;
}

// -------------------------
// Save Excel file
// -------------------------
$filename = "Daily_Leads_Report_" . date("Y-m-d") . ".xlsx";
$savePath = __DIR__ . DIRECTORY_SEPARATOR . $filename;

try {
    $writer = new Xlsx($spreadsheet);
    $writer->save($savePath);
} catch (\Throwable $e) {
    die("Could not save Excel file: " . $e->getMessage());
}

// -------------------------
// Send Email via Gmail SMTP
// -------------------------
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'aditya.gupin1950@gmail.com';  // Your Gmail
    $mail->Password   = 'jrehsbhvkmjoajgb';            // Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('aditya.gupin1950@gmail.com', 'Canprosys Reports');
    $mail->addAddress('support@canprosys.com', 'Support Team');

    // Attachment
    $mail->addAttachment($savePath, $filename);

    // Content
    $mail->isHTML(true);
    $mail->Subject = "Daily Leads Report – " . date("Y-m-d");
    $mail->Body    = "<b>Attached is your daily leads report.</b>";
    $mail->AltBody = "Attached is your daily leads report.";

    $mail->send();
    echo "Excel saved and email sent successfully. File: {$savePath}\n";
} catch (Exception $e) {
    echo "Email could not be sent. PHPMailer Error: {$mail->ErrorInfo}\n";
}

$conn->close();
