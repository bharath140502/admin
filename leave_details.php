<?php error_reporting(0);?>
<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
	// code for update the read notification status
	$isread=1;
	$did=intval($_GET['leaveid']);  
	date_default_timezone_set('Asia/Kolkata');
	$admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
	$sql="update tblleave set IsRead=:isread where id=:did";
	$query = $dbh->prepare($sql);
	$query->bindParam(':isread',$isread,PDO::PARAM_STR);
	$query->bindParam(':did',$did,PDO::PARAM_STR);
	$query->execute();

	// code for action taken on leave
	if (isset($_POST['update'])) {
		$did = intval($_GET['leaveid']);
		$status = $_POST['status'];
		$num_days = $_POST['num_days'];
	
		date_default_timezone_set('Asia/Kolkata');
		$admremarkdate = date('Y-m-d ', strtotime("now"));
	
		if ($status === '2') {
			$sql = "UPDATE tblleave SET RegRemarks=:status, RegDate=:admremarkdate WHERE id=:did";
	
			$query = $dbh->prepare($sql);
			$query->bindParam(':status', $status, PDO::PARAM_STR);
			$query->bindParam(':admremarkdate', $admremarkdate, PDO::PARAM_STR);
			$query->bindParam(':did', $did, PDO::PARAM_STR);
			$query->execute();
			echo "<script>alert('Leave rejected Successfully');</script>";
		}
		 elseif ($status === '1') {
			$result = mysqli_query($conn, "UPDATE tblleave, tblemployees SET tblleave.RegRemarks='$status', tblleave.RegDate='$admremarkdate', tblleave.DaysOutstand='$av_leave', tblemployees.Av_leave='$av_leave' WHERE tblleave.empid = tblemployees.emp_id AND tblleave.id='$did'");
	
			if ($result) {
				echo "<script>alert('Leave approved Successfully');</script>";
			} else {
				die(mysqli_error());
			}
		}
	}

		// date_default_timezone_set('Asia/Kolkata');
		// $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));

		// $sql="update tblleaves set AdminRemark=:description,Status=:status,AdminRemarkDate=:admremarkdate where id=:did";

		// $query = $dbh->prepare($sql);
		// $query->bindParam(':description',$description,PDO::PARAM_STR);
		// $query->bindParam(':status',$status,PDO::PARAM_STR);
		// $query->bindParam(':admremarkdate',$admremarkdate,PDO::PARAM_STR);
		// $query->bindParam(':did',$did,PDO::PARAM_STR);
		// $query->execute();
		// echo "<script>alert('Leave updated Successfully');</script>";

?>

<style>
	input[type="text"]
	{
	    font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
	}

	.btn-outline:hover {
	  color: #fff;
	  background-color: #524d7d;
	  border-color: #524d7d; 
	}

	textarea { 
		font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
	}

	textarea.text_area{
        height: 8em;
        font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
      }

	</style>

<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>LEAVE DETAILS</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Leave</li>
								</ol>
							</nav>
						</div>
						<!-- <div class="col-md-6 col-sm-12 text-right">
							<div class="dropdown show">
								<a class="btn btn-primary" href="outpass_pdf.php?leave_id=<?php echo $_GET['leaveid'] ?>">
									Generate Report
								</a>
							</div>
						</div> -->
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Leave Details</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<form method="post" action="">

						<?php 
						if(!isset($_GET['leaveid']) && empty($_GET['leaveid'])){
							header('Location: admin_dashboard.php');
						}
						else {
						
						$lid=intval($_GET['leaveid']);
						$sql = "SELECT tblleave.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_leave,tblemployees.Position_Staff,tblemployees.Staff_ID,tblleave.LeaveType,tblleave.ToDate,tblleave.FromDate,tblleave.PostingDate,tblleave.RequestedDays,tblleave.DaysOutstand,tblleave.WorkCovered,tblleave.HodRemarks,tblleave.RegRemarks,tblleave.HodDate,tblleave.RegDate,tblleave.num_days from tblleave join tblemployees on tblleave.empid=tblemployees.emp_id where tblleave.id=:lid";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':lid',$lid,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$cnt=1;
						if($query->rowCount() > 0)
						{
						foreach($results as $result)
						{         
						?>  

						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Full Name</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->FirstName." ".$result->LastName);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Employee Position</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->Position_Staff);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Employee ID</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->Staff_ID);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Phone Number</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->Phonenumber);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Leave Type</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->LeaveType);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Applied Date</b></label>
									<?php
                                          $postingDate = date("d-m-Y", strtotime($result->PostingDate));
                                    ?>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($postingDate);?>">
								</div>
							</div>

							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Requested Number of Days</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly name="num_days" value="<?php echo htmlentities($result->num_days);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Number Days still outstanding</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly name="av_leave" value="<?php echo htmlentities($result->DaysOutstand);?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label style="font-size:16px;"><b>Leave Period</b></label>
									<?php
                                      $fromDate = date("d-m-Y", strtotime($result->FromDate));
                                      $toDate = date("d-m-Y", strtotime($result->ToDate));
                                  ?>
                                  <input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="From <?php echo htmlentities($fromDate); ?> to <?php echo htmlentities($toDate); ?>">
									
								</div>
							</div>

						</div>
						<div class="form-group row">
								<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Email Address</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->EmailId);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Gender</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->Gender);?>">
								</div>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-md-6 col-sm-12">
							    <div class="form-group">
									<label style="font-size:16px;"><b>Date For HOD's Action</b></label>
									<?php
									if ($result->HodDate==""): ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
									<?php else: ?>
									  <div class="avatar mr-2 flex-shrink-0">
									  <?php
                                          $hodDate = date("d-m-Y", strtotime($result->HodDate));
                                    ?>
										<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($hodDate); ?>">
									  </div>
									<?php endif ?>
							    </div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Date For HR Action</b></label>
									<?php
									if ($result->RegDate==""): ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
									<?php else: ?>
									  <div class="avatar mr-2 flex-shrink-0">
									  <?php
                                          $regDate = date("d-m-Y", strtotime($result->RegDate));
                                    ?>
										<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($regDate); ?>">
									  </div>
									<?php endif ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Leave Status From HOD</b></label>
									<?php $stats=$result->HodRemarks;?>
									<?php
									if ($stats==1): ?>
									  <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
									<?php
									 elseif ($stats==2): ?>
									  <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Rejected"; ?>">
									  <?php
									else: ?>
									  <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
									<?php endif ?>
								</div>
							</div>

							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Leave Status From HR</b></label>
									<?php $ad_stats=$result->RegRemarks;?>
									<?php
									if ($ad_stats==1): ?>
									  <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
									<?php
									 elseif ($ad_stats==2): ?>
									  <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Rejected"; ?>">
									  <?php
									else: ?>
									  <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
									<?php endif ?>
								</div>
							</div>

							<?php 
							if(($stats==1 AND $ad_stats==0) OR ($stats==1 AND $ad_stats==0) OR ($stats==1 AND $ad_stats==2))
							  {

							 ?>
							<div class="col-md-4">
								<div class="form-group">
									<label style="font-size:16px;"><b></b></label>
									<div class="modal-footer justify-content-center">
										<button class="btn btn-primary" id="action_take" data-toggle="modal" data-target="#success-modal">Take&nbsp;Action</button>
									</div>
								</div>
							</div>

							<form name="adminaction" method="post">
  								<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-body text-center font-18">
												<h4 class="mb-20">Leave take action</h4>
												<select name="status" required class="custom-select form-control">
													<option value="">Choose your option</option>
				                                          <option value="1">Approved</option>
				                                          <option value="2">Rejected</option>
												</select>
											</div>
											<div class="modal-footer justify-content-center">
												<input type="submit" class="btn btn-primary" name="update" value="Submit">
											</div>
										</div>
									</div>
								</div>
  							</form>

							 <?php }?> 
						</div>

						<?php $cnt++;} } }?>
					</form>
				</div>

			</div>
			
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>