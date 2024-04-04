<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php $get_id = $_GET['edit']; ?>

<?php 
	 if (isset($_GET['delete'])) {
		$attendance_id = $_GET['delete'];
		$sql = "DELETE FROM attendee WHERE id = '$attendance_id'";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			echo "<script>alert('Employee attendance history deleted successfully');</script>";
			echo "<script type='text/javascript'> document.location = 'Attendenance.php'; </script>";
		} else {
			die(mysqli_error($conn));
		}
	}
?>

<?php
 if(isset($_POST['edit']))
{
	$id = $_POST['id'];
	$employee_ID=$_POST['Emp_Id'];
	$employee_name=$_POST['Employee_Name'];
	$login_time=$_POST['First_In'];
	$logout_time=$_POST['Last_Out'];
	$date=date('Y/m/d', strtotime($_POST['Date']));

    $result = mysqli_query($conn,"update attendee set id = '$id', Emp_Id = '$employee_ID' , Employee_Name ='$employee_name', First_In ='$login_time', Last_Out ='$logout_time',Date = '$date' where id = '$get_id' ");
    if ($result) {
     	echo "<script>alert('Record Successfully Updated');</script>";
     	echo "<script type='text/javascript'> document.location = 'Attendenance.php'; </script>";
	} else{
	  die(mysqli_error($conn));
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
								<h2 class="mb-30 h4">Edit Attendance Details</h2>
								<section>
									<?php
									$query = mysqli_query($conn,"SELECT * from attendee where id = '$get_id'")or die(mysqli_error($conn));
									$row = mysqli_fetch_array($query);
									?>

									<form name="save" method="post">
									<div class="row"> 
										<div class="col-md-12">
											<div class="form-group">
												<label >ID</label>
												<input name="id" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['id']; ?>">
											</div>
										</div>
									</div>	
									<div class="row"> 
										<div class="col-md-12">
											<div class="form-group">
												<label >Employee ID</label>
												<input name="Emp_Id" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['Emp_Id']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Employee Name</label>
												<input name="Employee_Name" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:uppercase" value="<?php echo $row['Employee_Name']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Login Time</label>
												<input name="First_In" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:uppercase" value="<?php echo $row['First_In']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Logout Time</label>
												<input name="Last_Out" type="text" class="form-control" required="true" autocomplete="off" style="text-transform:uppercase" value="<?php echo $row['Last_Out']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
                                            <label>Date</label>
												<input name="Date" class="form-control" type="date" value="<?php echo $row['Date']; ?>">
											</div>
										</div>
									</div>
									<div class="col-sm-12 text-right">
										<div class="dropdown">
										   <input class="btn btn-primary" type="submit" value="UPDATE" name="edit" id="edit">
									    </div>
									</div>
								   </form>
							    </section>
							</div>
						</div>
						
						<div class="col-lg-8 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<h2 class="mb-30 h4">Employee List</h2>
								<div class="pb-20">
									<table class="data-table table stripe hover nowrap">
										<thead>
										<tr>
			
											<th class="table-plus">Employee ID</th>
											<th>Employee NAME</th>
											<th>Login Time</th>
											<th>Logout Time</th>
											<th>Date</th>
											<th>ID</th>
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
											    <td><?php echo htmlentities($result->Emp_Id);?></td>
	                                            <td><?php echo htmlentities($result->Employee_Name);?></td>
	                                            <td><?php echo htmlentities($result->First_In);?></td>
	                                            <td><?php echo htmlentities($result->Last_Out);?></td>
												<td><?php echo htmlentities($result->Date);?></td>
												<td><?php echo htmlentities($result->id);?></td>
												<td>
													<div class="table-actions">
													<a href="attendance_edit.php?delete=<?php echo htmlentities($result->id);?>" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
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