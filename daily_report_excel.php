<?php
// Load Composer autoloader
require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// ========================
//  DATABASE CONNECTION
// ========================
$servername = "localhost";
$username   = "u450081634_canprosys";
$password   = "Aarav@2871#";
$dbname     = "u450081634_canprosys";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// =========================
// FETCH LEADS (last 24 hrs)
// =========================
$query = "
    SELECT full_name, phone_number, email, subject, location,
        best_date_to_call, best_time_to_call, message, created_at
    FROM leads
    WHERE created_at >= NOW() - INTERVAL 1 DAY
    ORDER BY created_at DESC
";

$result = $conn->query($query);

// =========================
// CREATE SPREADSHEET
// =========================
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Headers
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

$column = "A";
foreach ($headers as $header) {
    $sheet->setCellValue($column . "1", $header);
    $column++;
}

$rowNum = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue("A$rowNum", $row['full_name']);
    $sheet->setCellValue("B$rowNum", $row['phone_number']);
    $sheet->setCellValue("C$rowNum", $row['email']);
    $sheet->setCellValue("D$rowNum", $row['subject']);
    $sheet->setCellValue("E$rowNum", $row['location']);
    $sheet->setCellValue("F$rowNum", $row['best_date_to_call']);
    $sheet->setCellValue("G$rowNum", $row['best_time_to_call']);
    $sheet->setCellValue("H$rowNum", $row['message']);
    $sheet->setCellValue("I$rowNum", $row['created_at']);
    $rowNum++;
}

// =========================
// Save Excel in public_html
// =========================
$filename = "/home/u450081634/public_html/Daily_Leads_Report_" . date("Y-m-d") . ".xlsx";
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

// =========================
// Email Report (attachment)
// =========================
$to = "aditya.gupin1950@gmail.com";
$subject = "Daily Leads Report – " . date("Y-m-d");
$message = "Attached is your daily leads report.";
$headers = "From: no-reply@canprosys.com";

$fileContent = file_get_contents($filename);
$encoded = chunk_split(base64_encode($fileContent));
$boundary = md5(time());

$headers .= "\r\nMIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

$body  = "--$boundary\r\n";
$body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
$body .= "$message\r\n\r\n";

$body .= "--$boundary\r\n";
$body .= "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; name=\"Daily_Leads_Report.xlsx\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n";
$body .= "Content-Disposition: attachment; filename=\"Daily_Leads_Report.xlsx\"\r\n\r\n";
$body .= "$encoded\r\n";
$body .= "--$boundary--";

mail($to, $subject, $body, $headers);

echo "Excel daily report sent successfully.";
