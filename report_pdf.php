<?php
    include('../includes/session.php');
    include('../includes/config.php');
    require_once('../TCPDF-main/tcpdf.php');

    $did = intval($_GET['leave_id']);
    $sql = "SELECT tblleave.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId, tblemployees.Department, tblemployees.Av_leave,tblemployees.Position_Staff,tblemployees.Staff_ID,tblleave.LeaveType,tblleave.ToDate,tblleave.FromDate,tblleave.PostingDate,tblleave.RequestedDays,tblleave.DaysOutstand,tblleave.WorkCovered,tblleave.HodRemarks,tblleave.RegRemarks,tblleave.HodDate,tblleave.RegDate,tblleave.num_days,tblleave.StartTime,tblleave.EndTime from tblleave join tblemployees on tblleave.empid=tblemployees.emp_id where tblleave.id='$did'";
    $query = mysqli_query($conn, $sql) or die(mysqli_error());

    // Create new PDF document
    class PDF extends TCPDF
    {
        public function Header()
        {
            // Add Company Logo Image
            $this->Image('../vendors/images/BEPL-logo.png', 10, 10, 30);
            
            // Add Company Name as Heading
            $this->SetFont('dejavusans', 'B', 16);
            $this->Cell(0, 10, 'BHORUKA EXTRUSION PVT LTD', 0, 1, 'C');
            
            // Add Gate Pass Heading
            $this->SetFont('dejavusans', 'B', 14);
            $this->Cell(0, 10, 'Gate Pass for Personal Work', 0, 1, 'C');
            
            $this->Ln(5);
        }
        
        public function Body($data)
        {
            $this->SetFont('dejavusans', '', 12);
            $this->Cell(0, 10, 'To Security Office                                                                                   Date:'. $data['FromDate'], 0, 1);

            $this->Cell(0, 10, 'Please Permit me:  ' . $data['FirstName'] . ' ' . $data['LastName'], 0, 1);
            $this->Cell(0, 10, 'Employee ID: ' . $data['Staff_ID'] . '                                                           Dept: ' . $data['Department'], 0, 1);
            $this->Cell(0, 10, 'to go out From: ' . $data['StartTime'] . ' Hrs                                                To: ' . $data['EndTime'].' Hrs', 0, 1);
            $this->Cell(0, 10, 'Reason: ' . $data['WorkCovered'], 0, 1);
            $this->Cell(0, 10, 'Approved on :'. $data['HodDate'], 0, 1);
            $this->Cell(0, 10, '....................................................................................................................................', 0, 1);
			
			$this->SetFont('dejavusans', 'B', 12); // Set font to bold
			$this->Cell(0, 10, 'Security Use Only', 0, 1, 'C');
			$this->Ln(2); // Adjust the spacing as needed
			$this->SetFont('dejavusans', '', 12); // Reset font to normal

            $this->Cell(0, 10, 'Time Out:......................Hrs.                             Signature Of Security: .......................', 0, 1);
            $this->Cell(0, 10, 'Time In:.......................Hrs.', 0, 1);
        }
    }

    // Create PDF instance
    $pdf = new PDF('p', 'mm', 'A4', true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('BEPL LEAVE SYSTEM');
    $pdf->SetTitle('Gate Pass for Personal Work');
    $pdf->SetSubject('');
    $pdf->SetKeywords('');

    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Add a page
    $pdf->AddPage();

    // Fetch data from the query result
    while ($row = mysqli_fetch_array($query)) {
        $data = array(
            'FirstName' => $row['FirstName'],
            'LastName' => $row['LastName'],
            'Staff_ID' => $row['Staff_ID'],
			'Department' => $row['Department'],
			'StartTime' => $row['StartTime'],
			'EndTime' => $row['EndTime'],
            'Position_Staff' => $row['Position_Staff'],
            'FromDate' => $row['FromDate'],
            'ToDate' => $row['ToDate'],
			'HodDate' => $row['HodDate'],
            'WorkCovered' => $row['WorkCovered']
            // Add more data fields as needed
        );

        // Call the Body function to populate the PDF content
        $pdf->Body($data);
    }

    // Output the PDF to the browser
    $pdf->Output('gate_pass.pdf', 'I');
?>
