<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
 if(isset($_POST['add']))
{
	 $employee_ID=$_POST['Emp_Id'];
	 $employee_name=$_POST['Employee_Name'];
	 $login_time=$_POST['First_In'];
	 $logout_time=$_POST['Last_Out'];
	 $date=date('Y/m/d', strtotime($_POST['Date']));
	

     $query = mysqli_query($conn,"select * from attendee where Emp_Id = '$employee_ID' and Date = '$date'")or die(mysqli_error());
	 $count = mysqli_num_rows($query);
     
     if ($count > 0){ 
     	echo "<script>alert('Attendance details already exists');</script>";
      }
      else{
        $query = mysqli_query($conn,"insert into attendee (Emp_Id, Employee_Name, First_In, Last_Out, Date)
  		 values ('$employee_ID', '$employee_name','$login_time','$logout_time', '$date')      
		") or die(mysqli_error()); 

		if ($query) {
			echo "<script>alert('Employee Attendance Added Successfully');</script>";
			echo "<script type='text/javascript'> document.location = 'Attendenance.php'; </script>";
		}
    }

}

?>
<body>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Employee List </h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
										<li class="breadcrumb-item active" aria-current="page">Attendenance Module</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<h2 class="mb-30 h4">Add Attendenance</h2>
								<section>
									<form name="save" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label >Employee ID</label>
												<input name="Emp_Id" type="text" class="form-control" required="true" autocomplete="off">
											</div>
										</div>
									</div>
                                    <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Employee Name</label>
												<input name="Employee_Name" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:uppercase">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>login time</label>
												<input name="First_In" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:uppercase">
											</div>
										</div>
									</div>
                                    <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>logout time</label>
												<input name="Last_Out" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:uppercase">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
                                                <label>Date</label>
												<input name="Date" class="form-control" type="date">
											</div>
										</div>
									</div>

									<div class="col-sm-12 text-right">
										<div class="dropdown">
										   <input class="btn btn-primary" type="submit" value="SUBMIT" name="add" id="add">
									    </div>
									</div>
								   </form>
							    </section>
							</div>
						</div>
						
						<div class="col-lg-8 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<h2 class="mb-30 h4">Attendenance List</h2>
								<div class="pb-20">
									<table class="data-table table stripe hover nowrap">
										<thead>
										<tr><th class="table-plus">ID</th>
											<th>Employee ID</th>
											<th>Employee_Name</th>
											<th>login time</th>
											<th>logout time</th>
											<th>Date</th>
											<th class="datatable-nosort">ACTION</th>
										</tr>
										</thead>
										<tbody>
										<?php $sql = "SELECT * from attendee";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>  

											<tr>
											    <td><?php echo htmlentities($result->id);?></td>
	                                            <td><?php echo htmlentities($result->Emp_Id);?></td>
	                                            <td><?php echo htmlentities($result->Employee_Name);?></td>
												<td><?php echo htmlentities($result->First_In);?></td>
	                                            <td><?php echo htmlentities($result->Last_Out);?></td>
												<td><?php echo htmlentities($result->Date);?></td>
												<td>
												<div class="table-actions">
														<a href="attendance_edit.php?edit=<?php echo htmlentities($result->id);?>" data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
													</div>	
												</td>
											</tr>

											<?php $cnt++;} }?>  

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>