<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php $get_id = $_GET['edit']; ?>
<?php
	if(isset($_POST['add_staff']))
	{
		error_reporting(E_ALL);
		ini_set('display_errors', 1);		
	$fname=$_POST['firstname'];
	$lname=$_POST['lastname'];   
	$email=$_POST['email'];  
	$gender=$_POST['gender']; 
	$dob=$_POST['dob']; 
	$department=$_POST['department']; 
	$address=$_POST['address'];  
	$casual_leave=$_POST['casual_leave'];
	$sick_leave=$_POST['sick_leave'];
	$maternity_leave=$_POST['maternity_leave'];
	$privilage_leave=$_POST['privilage_leave'];
	$user_role=$_POST['user_role']; 
	$phonenumber=$_POST['phonenumber']; 
	$position_staff=$_POST['position_staff']; 
	$staff_id=$_POST['staff_id']; 

	$result = mysqli_query($conn,"update tblemployees set FirstName='$fname', LastName='$lname', EmailId='$email', Gender='$gender', Dob='$dob', Department='$department', Address='$address',SickLeave='$sick_leave',CasualLeave='$casual_leave',PrivilageLeave='$privilage_leave',MaternityLeave='$maternity_leave',role='$user_role', Phonenumber='$phonenumber', Position_Staff='$position_staff', Staff_ID='$staff_id' where emp_id='$get_id'         
		"); 		
	if ($result) {
     	echo "<script>alert('Record Successfully Updated');</script>";
     	echo "<script type='text/javascript'> document.location = 'staff.php'; </script>";
	} else{
		echo "<p>Error updating record: " . mysqli_error($conn) . "</p>";
   }
		
}

?>

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Staff Portal</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Staff Edit</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Edit Staff</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<div class="wizard-content">
						<form method="post" action="">
							<section>
								<?php
									$query = mysqli_query($conn,"select * from tblemployees where emp_id = '$get_id' ")or die(mysqli_error());
									$row = mysqli_fetch_array($query);
									?>

								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >First Name :</label>
											<input name="firstname" type="text" class="form-control wizard-required" required="true" autocomplete="off" value="<?php echo $row['FirstName']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >Last Name :</label>
											<input name="lastname" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['LastName']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Email Address :</label>
											<input name="email" type="email" class="form-control" required="true" autocomplete="off" value="<?php echo $row['EmailId']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<label >Staff Position :</label>
											<input name="position_staff" type="text" class="form-control wizard-required" required="true" autocomplete="off" value="<?php echo $row['Position_Staff'] ?>">
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
											<label >Staff ID :</label>
											<input name="staff_id" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['Staff_ID'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Password :</label>
											<input name="password" type="password" placeholder="**********" class="form-control" readonly required="true" autocomplete="off" value="<?php echo $row['Password']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Gender :</label>
											<select name="gender" class="custom-select form-control" required="true" autocomplete="off">
												<option value="<?php echo $row['Gender']; ?>"><?php echo $row['Gender']; ?></option>
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Phone Number :</label>
											<input name="phonenumber" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $row['Phonenumber']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Date Of Birth :</label>
											<input name="dob" type="text" class="form-control date-picker" required="true" autocomplete="off"value="<?php echo $row['Dob']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Address :</label>
											<input name="address" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $row['Address']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Department :</label>
											<select name="department" class="custom-select form-control" required="true" autocomplete="off">
												<?php
													$query_staff = mysqli_query($conn,"select * from tblemployees join  tbldepartments where emp_id = '$get_id'")or die(mysqli_error());
													$row_staff = mysqli_fetch_array($query_staff);
													
												 ?>
												<option value="<?php echo $row_staff['DepartmentShortName']; ?>"><?php echo $row_staff['DepartmentName']; ?></option>
													<?php
													$query = mysqli_query($conn,"select * from tbldepartments");
													while($row = mysqli_fetch_array($query)){
													
													?>
													<option value="<?php echo $row['DepartmentShortName']; ?>"><?php echo $row['DepartmentName']; ?></option>
													<?php } ?>
											</select>
										</div>
									</div>
								</div>

								<?php
									$query = mysqli_query($conn,"select * from tblemployees where emp_id = '$get_id' ")or die(mysqli_error());
									$new_row = mysqli_fetch_array($query);
									?>
								<div class="row">
								<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Casual Leave days :</label>
											<input name="casual_leave" type="number" class="form-control" required="true" autocomplete="off"value="<?php echo $new_row['CasualLeave']; ?>">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Sick Leave days :</label>
											<input name="sick_leave" type="number" class="form-control" required="true" autocomplete="off"value="<?php echo $new_row['SickLeave']; ?>">
										</div>
									</div>
                                    <div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Privilege Leave days :</label>
											<input name="privilage_leave" type="number" class="form-control" required="true" autocomplete="off"value="<?php echo $new_row['PrivilageLeave']; ?>">
										</div>
									</div>					
							    </div>

								<div class="row">
								<div id="maternity_leave_field" class="col-md-4 col-sm-12">
	                                       <div class="form-group">
		                                         <label>Maternity Leave Days:</label>
		                                         <input name="maternity_leave" type="number" class="form-control"  autocomplete="off" value="<?php echo $new_row['MaternityLeave']; ?>">
	                                        </div>
                                </div>

									
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>User Role :</label>
											<select name="user_role" class="custom-select form-control" required="true" autocomplete="off">
												<option value="<?php echo $new_row['role']; ?>"><?php echo $new_row['role']; ?></option>
												<option value="Admin">Admin</option>
												<option value="HOD">HOD</option>
												<option value="Staff">Staff</option>
											</select>
										</div>
									</div>

									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-primary" name="add_staff" id="add_staff" data-toggle="modal">Update&nbsp;Staff</button>
											</div>
										</div>
									</div>
								</div>
							</section>
						</form>
					</div>
				</div>

			</div>
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<script>
  document.addEventListener("DOMContentLoaded", function() {
    var genderSelect = document.querySelector('select[name="gender"]');
    var maternityLeaveField = document.getElementById("maternity_leave_field");

    function toggleMaternityLeaveField() {
      var selectedGender = genderSelect.value;
      if (selectedGender === "female") {
        maternityLeaveField.style.display = "block";
      } else {
        maternityLeaveField.style.display = "none";
      }
    }

    // Call the function initially
    toggleMaternityLeaveField();

    // Add event listener to the gender select field
    genderSelect.addEventListener("change", toggleMaternityLeaveField);
  });
</script>

	<!-- js -->
	<?php include('includes/scripts.php')?>
</body>
</html>