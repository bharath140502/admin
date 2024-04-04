<?php
require '../includes/config.php'; // Update the path accordingly
require '../vendor/autoload.php'; // Include the PhpSpreadsheet library

$con = mysqli_connect('localhost', 'root', 'Bepl123$', 'aci_leave'); // Update the connection details accordingly

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Check for selected date range
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $fromDate = $_GET['from_date'];
    $toDate = $_GET['to_date'];

    $sql = "SELECT attendee.Emp_Id, attendee.Employee_Name, tblemployees.Department, attendee.First_In, attendee.Last_Out, attendee.Date
            FROM attendee 
            JOIN tblemployees ON attendee.Emp_Id = tblemployees.Staff_ID 
            WHERE attendee.Date >= '$fromDate' AND attendee.Date <= '$toDate'";
} else {
    // No date range selected, fetch all records
    $sql = "SELECT attendee.Emp_Id, attendee.Employee_Name, tblemployees.Department, attendee.First_In, attendee.Last_Out, attendee.Date
            FROM attendee 
            JOIN tblemployees ON attendee.Emp_Id = tblemployees.Staff_ID";
}

$result = mysqli_query($con, $sql);

// Create a new Spreadsheet object
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers
$sheet->setCellValue('A1', 'Employee ID');
$sheet->setCellValue('B1', 'Employee Name');
$sheet->setCellValue('C1', 'Department');
$sheet->setCellValue('D1', 'Login Time');
$sheet->setCellValue('E1', 'Logout Time');
$sheet->setCellValue('F1', 'Date');

// Populate the spreadsheet with data
$rowIndex = 2;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowIndex, $row['Emp_Id']);
    $sheet->setCellValue('B' . $rowIndex, $row['Employee_Name']);
    $sheet->setCellValue('C' . $rowIndex, $row['Department']);
    $sheet->setCellValue('D' . $rowIndex, $row['First_In']);
    $sheet->setCellValue('E' . $rowIndex, $row['Last_Out']);
    $sheet->setCellValue('F' . $rowIndex, $row['Date']);
    $rowIndex++;
}

// Create a writer for XLS format
$xlsWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);

// Set appropriate headers for download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="attendance_report.xls"');
header('Cache-Control: max-age=0');

// Write the spreadsheet to the output
$xlsWriter->save('php://output');
