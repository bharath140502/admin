<?php
include('includes/header.php');
include('../includes/session.php');
require 'vendor/autoload.php'; // Include PhpSpreadsheet autoload

// ...

if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $fromDate = $_GET['from_date'];
    $toDate = $_GET['to_date'];

    $teacher_query = mysqli_query($conn, "SELECT attendee.Emp_Id, attendee.Employee_Name, tblemployees.Department, attendee.First_In, attendee.Last_Out, attendee.Date 
        FROM attendee JOIN tblemployees ON attendee.Emp_Id = tblemployees.Staff_ID 
        WHERE attendee.Date >= '$fromDate' AND attendee.Date <= '$toDate'") or die(mysqli_error());
} else {
    // If no date range is specified, show all attendance records
    $teacher_query = mysqli_query($conn, "SELECT attendee.Emp_Id, attendee.Employee_Name, tblemployees.Department, attendee.First_In, attendee.Last_Out, attendee.Date FROM attendee JOIN tblemployees ON attendee.Emp_Id = tblemployees.Staff_ID") or die(mysqli_error());
}

// Create a new PhpSpreadsheet instance
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers
$sheet->setCellValue('A1', 'Employee ID');
$sheet->setCellValue('B1', 'Employee Name');
$sheet->setCellValue('C1', 'Department');
$sheet->setCellValue('D1', 'Login Time');
$sheet->setCellValue('E1', 'Logout Time');
$sheet->setCellValue('F1', 'Date');

$row = 2; // Start from row 2 for data

while ($row_data = mysqli_fetch_array($teacher_query)) {
    $sheet->setCellValue('A' . $row, $row_data['Emp_Id']);
    $sheet->setCellValue('B' . $row, $row_data['Employee_Name']);
    $sheet->setCellValue('C' . $row, $row_data['Department']);
    $sheet->setCellValue('D' . $row, $row_data['First_In']);
    $sheet->setCellValue('E' . $row, $row_data['Last_Out']);
    $sheet->setCellValue('F' . $row, $row_data['Date']);
    $row++;
}

// Save the Excel file
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$report_filename = 'attendance_report.xlsx'; // You can change the filename if needed
$writer->save($report_filename);

// Redirect to download the generated Excel file
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$report_filename\"");
readfile($report_filename);
unlink($report_filename); // Delete the file after downloading
exit();
?>
