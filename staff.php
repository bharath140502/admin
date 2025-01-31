<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php
if (isset($_GET['delete'])) {
	$delete = $_GET['delete'];
	$sql = "DELETE FROM tblemployees where emp_id = ".$delete;
	$result = mysqli_query($conn, $sql);
	if ($result) {
		echo "<script>alert('Staff deleted Successfully');</script>";
     	echo "<script type='text/javascript'> document.location = 'staff.php'; </script>";
		
	}
}

?>

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="title pb-20">
				<h2 class="h3 mb-0">Administrative Breakdown</h2>
			</div>
			<div class="row pb-10">
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$sql = "SELECT emp_id from tblemployees";
						$query = $dbh -> prepare($sql);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$empcount=$query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($empcount);?></div>
								<div class="font-14 text-secondary weight-500">Total Employees</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php 
						 $query_reg_staff = mysqli_query($conn,"select * from tblemployees where role = 'Staff' ")or die(mysqli_error());
						 $count_reg_staff = mysqli_num_rows($query_reg_staff);
						 ?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo htmlentities($count_reg_staff); ?></div>
								<div class="font-14 text-secondary weight-500">Staffs</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#09cc06"><span class="icon-copy fa fa-hourglass"></span></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php 
						 $query_reg_hod = mysqli_query($conn,"select * from tblemployees where role = 'HOD' ")or die(mysqli_error());
						 $count_reg_hod = mysqli_num_rows($query_reg_hod);
						 ?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($count_reg_hod); ?></div>
								<div class="font-14 text-secondary weight-500">Department Heads</div>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy fa fa-hourglass-end" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php 
						 $query_reg_admin = mysqli_query($conn,"select * from tblemployees where role = '$session_role' ")or die(mysqli_error());
						 $count_reg_admin = mysqli_num_rows($query_reg_admin);
						 ?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($count_reg_admin); ?></div>
								<div class="font-14 text-secondary weight-500">Administrators</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#ff5b5b"><i class="icon-copy fa fa-hourglass-o" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="text-blue h4">ALL EMPLOYEES</h2>
    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus">FULL NAME</th>
                    <th>EMAIL</th>
                    <th>DEPARTMENT</th>
                    <th>POSITION</th>
                    <th>AVAILABLE LEAVE</th>
                    <th>AVAILED LEAVE</th>
                    <th class="datatable-nosort">ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $teacher_query = mysqli_query($conn, "SELECT * FROM tblemployees LEFT JOIN tbldepartments ON tblemployees.Department = tbldepartments.DepartmentShortName") or die(mysqli_error());
                while ($row = mysqli_fetch_array($teacher_query)) {
                    $id = $row['emp_id'];

                    // Retrieve leave values
                    $sickLeave = $row['SickLeave'];
                    $privilegeLeave = $row['PrivilageLeave'];
                    $casualLeave = $row['CasualLeave'];

                    // Calculate available leaves
                    $availableLeaves = $sickLeave + $privilegeLeave + $casualLeave;

                    // Retrieve employee ID
                    $employeeId = $row['emp_id'];

                    // Fetch availed leaves for the employee from the tblleave table
                    $query = "SELECT SUM(RequestedDays) AS availed_leaves FROM tblleave WHERE empid = $employeeId AND  regremarks = 1 GROUP BY empid";
                    $result = mysqli_query($conn, $query);
                    $row_leave = mysqli_fetch_assoc($result);

                    // Retrieve availed leaves count
                    $availedLeaves = ($row_leave) ? $row_leave['availed_leaves'] : 0;
                ?>
                    <tr>
                        <td class="table-plus">
                            <div class="name-avatar d-flex align-items-center">
                                <div class="avatar mr-2 flex-shrink-0">
                                    <img src="<?php echo (!empty($row['location'])) ? '../uploads/' . $row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
                                </div>
                                <div class="txt">
                                    <div class="weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $row['EmailId']; ?></td>
                        <td><?php echo $row['Department']; ?></td>
                        <td><?php echo $row['Position_Staff']; ?></td>
						<td><?php echo $availableLeaves; ?></td>
                        <td><?php echo $availedLeaves; ?></td>
                        <!-- <td><?php echo $availableLeaves; ?></td>
                        <td>
                            <?php
                            // Fetch individual availed leaves for the employee
                            $query_individual = "SELECT SUM(RequestedDays) AS individual_availed_leaves FROM tblleave WHERE empid = $employeeId AND (hodremarks = 1 OR regremarks = 1)";
                            $result_individual = mysqli_query($conn, $query_individual);
                            $row_individual = mysqli_fetch_assoc($result_individual);

                            // Retrieve individual availed leaves count
                            $individualAvailedLeaves = ($row_individual) ? $row_individual['individual_availed_leaves'] : 0;

                            echo $individualAvailedLeaves;
                            ?>
                        </td> -->
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <a class="dropdown-item" href="edit_staff.php?edit=<?php echo $row['emp_id']; ?>"><i class="dw dw-edit2"></i> Edit</a>
                                    <a class="dropdown-item" href="staff.php?delete=<?php echo $row['emp_id']; ?>"><i class="dw dw-delete-3"></i> Delete</a>
                                </div>
                            </div>
                        </td>
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
	<script src="../vendors/scripts/core.js"></script>
	<script src="../vendors/scripts/script.min.js"></script>
	<script src="../vendors/scripts/process.js"></script>
	<script src="../vendors/scripts/layout-settings.js"></script>
	<script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

	<!-- buttons for Export datatable -->
	<script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
	<script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
	<script src="../src/plugins/datatables/js/vfs_fonts.js"></script>
	
	<script src="../vendors/scripts/datatable-setting.js"></script></body>

	<!-- <?php include('includes/scripts.php')?> -->
</body>
</html>