<?php
	// Include necessary files
	include('../includes/session.php');
	include('../includes/config.php');
	require_once('../TCPDF-main/tcpdf.php');
	require_once('PHPExcel/PHPExcel.php');

	$did = intval($_GET['leave_id']);
	$sql = "SELECT tblleave.id as lid, tblemployees.FirstName, tblemployees.LastName, tblemployees.emp_id, tblemployees.Gender, tblemployees.Phonenumber, tblemployees.EmailId, tblemployees.Av_leave, tblemployees.Position_Staff, tblemployees.Staff_ID, tblleave.LeaveType, tblleave.ToDate, tblleave.FromDate, tblleave.PostingDate, tblleave.RequestedDays, tblleave.DaysOutstand, tblleave.Sign, tblleave.WorkCovered, tblleave.HodRemarks, tblleave.RegRemarks, tblleave.HodSign, tblleave.RegSign, tblleave.HodDate, tblleave.RegDate, tblleave.num_days FROM tblleave JOIN tblemployees ON tblleave.empid = tblemployees.emp_id WHERE tblleave.id = '$did'";
	$query = mysqli_query($conn, $sql) or die(mysqli_error());

	// Create a new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set column headers
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'First Name')
		->setCellValue('B1', 'Last Name')
		->setCellValue('C1', 'Position')
		->setCellValue('D1', 'Staff ID')
		->setCellValue('E1', 'Number of Days')
		->setCellValue('F1', 'Outstanding')
		->setCellValue('G1', 'Start Date')
		->setCellValue('H1', 'End Date')
		->setCellValue('I1', 'Staff Signature')
		->setCellValue('J1', 'Posted Date')
		->setCellValue('K1', 'HOD Signature')
		->setCellValue('L1', 'HOD Date')
		->setCellValue('M1', 'Reg Signature')
		->setCellValue('N1', 'Reg Date')
		->setCellValue('O1', 'Work Covered')
		->setCellValue('P1', 'Date Resumed');

	// Set row counter
	$row = 2;

	while ($data = mysqli_fetch_array($query)) {
		// Retrieve data from the database
		$firstname = $data['FirstName'];
		$lastname = $data['LastName'];
		$position = $data['Position_Staff'];
		$staff_id = $data['Staff_ID'];
		$num_days = $data['num_days'];
		$outstanding = $data['DaysOutstand'];
		$start_date = $data['FromDate'];
		$end_date = $data['ToDate'];
		$staff_signature = $data['Sign'];
		$posted = $data['PostingDate'];
		$hod_sign = $data['HodSign'];
		$hod_date = $data['HodDate'];
		$reg_sign = $data['RegSign'];
		$reg_date = $data['RegDate'];
		$work_cover = $data['WorkCovered'];
		$date_resume = $data['ToDate'];

		// Set cell values
		$objPHPExcel->getActiveSheet()
			->setCellValue('A' . $row, $firstname)
			->setCellValue('B' . $row, $lastname)
			->setCellValue('C' . $row, $position)
			->setCellValue('D' . $row, $staff_id)
			->setCellValue('E' . $row, $num_days)
			->setCellValue('F' . $row, $outstanding)
			->setCellValue('G' . $row, $start_date)
			->setCellValue('H' . $row, $end_date)
			->setCellValue('I' . $row, $staff_signature)
			->setCellValue('J' . $row, $posted)
			->setCellValue('K' . $row, $hod_sign)
			->setCellValue('L' . $row, $hod_date)
			->setCellValue('M' . $row, $reg_sign)
			->setCellValue('N' . $row, $reg_date)
			->setCellValue('O' . $row, $work_cover)
			->setCellValue('P' . $row, $date_resume);

		$row++;
	}

	// Set active sheet index
	$objPHPExcel->setActiveSheetIndex(0);

	// Save Excel file
	$filename = 'leave_data.xlsx';
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save($filename);

	// Provide the file as a download
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="' . $filename . '"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	exit;
?>
