<?php

// =====================

// DATABASE CONNECTION

// =====================

$servername = "localhost";

$username   = "u450081634_canprosys";

$password   = "Aarav@2871#";

$dbname     = "u450081634_canprosys";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {

    die("DB Connection failed: " . $conn->connect_error);
}

// =====================

// FETCH LEADS (LAST 24 HOURS)

// =====================

$query = "

SELECT *

FROM leads

WHERE created_at >= NOW() - INTERVAL 1 DAY

ORDER BY created_at DESC

";

$result = $conn->query($query);

// =====================

// CREATE EXCEL FILE

// =====================

require 'vendor/autoload.php'; // PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

// Header row

$headers = ["ID", "Full Name", "Phone", "Email", "Subject", "Location", "Date", "Time", "Message", "Created At"];

$col = 1;

foreach ($headers as $header) {

    // convert numeric column index to letter (A, B, C, ...) and set by A1 coordinate
    $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . '1';
    $sheet->setCellValue($cell, $header);

    $col++;
}

// Fill rows

$rowIndex = 2;

while ($row = $result->fetch_assoc()) {

    $sheet->setCellValue("A$rowIndex", $row['id']);

    $sheet->setCellValue("B$rowIndex", $row['full_name']);

    $sheet->setCellValue("C$rowIndex", $row['phone_number']);

    $sheet->setCellValue("D$rowIndex", $row['email']);

    $sheet->setCellValue("E$rowIndex", $row['subject']);

    $sheet->setCellValue("F$rowIndex", $row['location']);

    $sheet->setCellValue("G$rowIndex", $row['best_date_to_call']);

    $sheet->setCellValue("H$rowIndex", $row['best_time_to_call']);

    $sheet->setCellValue("I$rowIndex", $row['message']);

    $sheet->setCellValue("J$rowIndex", $row['created_at']);

    $rowIndex++;
}

$filename = "daily_leads_report_" . date("Y-m-d") . ".xlsx";

$filepath = __DIR__ . "/$filename";

$writer = new Xlsx($spreadsheet);

$writer->save($filepath);

// =====================

// SEND EMAIL WITH mail()

// =====================

// ADMIN EMAIL

$to = "aditya.gupin1950@gmail.com"; // UPDATE THIS

$subject = "Daily Leads Report - " . date("Y-m-d");

$message = "Attached is the leads report for the past 24 hours.";

// READ FILE CONTENT

$file_data = file_get_contents($filepath);

$file_data_base64 = chunk_split(base64_encode($file_data));

// MIME BOUNDARY ( REQUIRED )

$separator = md5(time());

$eol = "\r\n";

// HEADERS

$headers  = "From: no-reply@yourdomain.com" . $eol;

$headers .= "MIME-Version: 1.0" . $eol;

$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;

// MESSAGE BODY

$body  = "--" . $separator . $eol;

$body .= "Content-Type: text/plain; charset=\"utf-8\"" . $eol;

$body .= "Content-Transfer-Encoding: 7bit" . $eol . $eol;

$body .= $message . $eol;

// ATTACHMENT SECTION

$body .= "--" . $separator . $eol;

$body .= "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; name=\"" . $filename . "\"" . $eol;

$body .= "Content-Transfer-Encoding: base64" . $eol;

$body .= "Content-Disposition: attachment; filename=\"" . $filename . "\"" . $eol . $eol;

$body .= $file_data_base64 . $eol;

$body .= "--" . $separator . "--";

// SEND EMAIL

mail($to, $subject, $body, $headers);

echo "Email sent to $to with the leads report.";

$conn->close();
