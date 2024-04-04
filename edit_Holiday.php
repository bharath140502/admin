<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php $get_id = $_GET['edit']; ?>
<?php 
	 if (isset($_GET['delete'])) {
		$holiday_id = $_GET['delete'];
		$sql = "DELETE FROM tblholiday where id = ".$holiday_id;
		$result = mysqli_query($conn, $sql);
		if ($result) {
			echo "<script>alert('Holiday deleted Successfully');</script>";
     		echo "<script type='text/javascript'> document.location = 'Holiday.php'; </script>";
			
		}
	}
?>

<?php
 if(isset($_POST['edit']))
{
	 $holidayname=$_POST['HolidayName'];
     $date=date('d-m-Y', strtotime($_POST['Date']));
     $type=$_POST['type'];

    $result = mysqli_query($conn,"update tblholiday set HolidayName = '$holidayname' , Date ='$date', type ='$type' where id = '$get_id' ");
    if ($result) {
     	echo "<script>alert('Holiday Successfully Updated');</script>";
     	echo "<script type='text/javascript'> document.location = 'Holiday.php'; </script>";
	} else{
	  die(mysqli_error());
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
									<h4>Holiday List</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
										<li class="breadcrumb-item active" aria-current="page">Edit Holiday</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
							<div class="card-box pd-30 pt-10 height-100-p">
								<h2 class="mb-30 h4">Edit Holiday</h2>
								<section>
									<?php
									$query = mysqli_query($conn,"SELECT * from tblholiday where id = '$get_id'")or die(mysqli_error());
									$row = mysqli_fetch_array($query);
									?>

									<form name="save" method="post">
									<div class="row"> 
										<div class="col-md-12">
											<div class="form-group">
												<label >Holiday Name</label>
												<input name="HolidayName" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $row['HolidayName']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
                                            <label>Date</label>
												<input name="Date" class="form-control" type="date" required="true" autocomplete="off" value="<?php echo $row['Date']; ?>">
											</div>
										</div>
									</div>
                                    <div class="row">
										<div class="col-md-12">
											<div class="form-group">
                                            <label>Type</label>
											<select name="type" class="custom-select form-control" required="true" autocomplete="off">
												<option value="<?php echo $row['type']; ?>"><?php echo $row['type']; ?></option>
												<option value="National">National</option>
												<option value="Festival">Festival</option>
                                                <option value="Optional">Optional</option>
											</select>
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
								<h2 class="mb-30 h4">Holiday List</h2>
								<div class="pb-20">
									<table class="data-table table stripe hover nowrap">
										<thead>
										<tr>
											<th>Sl no.</th>
											<th class="table-plus">Holiday Name</th>
											<th>Date</th>
                                            <th>Type</th>
											<th class="datatable-nosort">Action</th>
										</tr>
										</thead>
										<tbody>

											<?php $sql = "SELECT * from tblholiday";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>  

											<tr>
												<td> <?php echo htmlentities($cnt);?></td>
	                                            <td><?php echo htmlentities($result->HolidayName);?></td>
	                                            <td><?php echo htmlentities($result->Date);?></td>
                                                <td><?php echo htmlentities($result->type);?></td>
												<td>
													<div class="table-actions">
														<a href="Holiday.php?delete=<?php echo htmlentities($result->id);?>" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
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