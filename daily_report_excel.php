<?php
// TEMP DEV: show all errors while debugging (remove on production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoloader check
$autoload = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    die("Composer autoload not found. Run `composer require phpoffice/phpspreadsheet` in " . __DIR__);
}
require $autoload;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// ========================
// Database connection
// ========================
$servername = "srv1445.hstgr.io";
$username   = "u450081634_canprosys";
$password   = "Aarav@2871#";
$dbname     = "u450081634_canprosys";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

// =========================
// Fetch leads (last 24 hrs)
// =========================
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
    // Nothing to report — still create an empty spreadsheet if you want, or exit.
    echo "No leads in last 24 hours.\n";
    $conn->close();
    exit;
}

// =========================
// Create spreadsheet
// =========================
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$headers = [
    "Full Name",
    "Phone Number",
    "Email",
    "Service",
    "Location",
    "Best Date",
    "Best Time",
    "Message",
    "Submitted On"
];

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

// =========================
// Prepare writer and save
// Use __DIR__ so path works locally and on Hostinger
// =========================
$filename = "Daily_Leads_Report_" . date("Y-m-d") . ".xlsx";
$savePath = __DIR__ . DIRECTORY_SEPARATOR . $filename;

// Instantiate writer safely
try {
    $writer = new Xlsx($spreadsheet);
} catch (\Throwable $e) {
    // If instantiation failed, give a useful message
    die("Failed to instantiate Xlsx writer: " . $e->getMessage());
}

// Save wrapped in try/catch to capture permission/path errors
try {
    $writer->save($savePath);
} catch (\Throwable $e) {
    die("Could not save Excel file to '{$savePath}': " . $e->getMessage());
}

// =========================
// Send email with attachment
// =========================
$to = "aditya.gupin1950@gmail.com";
$subject = "Daily Leads Report – " . date("Y-m-d");
$message = "Attached is your daily leads report.";
$from = "no-reply@yourdomain.com";

$fileContent = file_get_contents($savePath);
if ($fileContent === false) {
    die("Failed to read saved file for email attachment.");
}
$encoded = chunk_split(base64_encode($fileContent));
$boundary = md5(time());

$headers = "From: {$from}\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";

$body  = "--{$boundary}\r\n";
$body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
$body .= "{$message}\r\n\r\n";

$body .= "--{$boundary}\r\n";
$body .= "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; name=\"{$filename}\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n";
$body .= "Content-Disposition: attachment; filename=\"{$filename}\"\r\n\r\n";
$body .= $encoded . "\r\n";
$body .= "--{$boundary}--\r\n";

if (!mail($to, $subject, $body, $headers)) {
    echo "Warning: mail() returned false. File saved at: {$savePath}\n";
} else {
    echo "Excel saved and emailed successfully. File: {$savePath}\n";
}


$conn->close();
