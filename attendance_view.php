<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">

			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h4>ATTENDANCE DETAILS</h4>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Attendance</li>
							</ol>
						</nav>
					</div>
					<div class="col-md-6 col-sm-12 text-right">
						<div class="dropdown show">
							<a class="btn btn-primary" href="xls.php?leave_id=<?php echo $_GET['leaveid'] ?>">
								Generate Report
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="card-box mb-30">
				<div class="pb-20">
				<form method="GET" action="">
    <label for="from_date">From Date:</label>
    <input type="date" id="from_date" name="from_date">
    <label for="to_date">To Date:</label>
    <input type="date" id="to_date" name="to_date">
    <button type="submit" class="btn btn-primary">Show Details</button>
</form>

					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th>Employee ID</th>
								<th class="table-plus">EMPLOYEE NAME</th>
								<th>DEPARTMENT</th>
								<th>LOGIN TIME</th>
								<th>LOGOUT TIME</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
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
							

							while ($row = mysqli_fetch_array($teacher_query)) {
								$id = $row['Emp_Id'];
							?>
								<tr>
									<td><?php echo $row['Emp_Id']; ?></td>
									<td class="table-plus">
										<div class="name-avatar d-flex align-items-center">
											<div class="avatar mr-2 flex-shrink-0">
												<img src="<?php echo (!empty($row['location'])) ? '../uploads/' . $row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
											</div>
											<div class="txt">
												<div class="weight-600"><?php echo $row['Employee_Name']; ?></div>
											</div>
										</div>
									</td>
									<td><?php echo $row['Department']; ?></td>
									<td><?php echo $row['First_In']; ?></td>
									<td><?php echo $row['Last_Out']; ?></td>
									<td><?php echo $row['Date']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>
