<?php
session_start();

error_reporting(0);
$db_host = "localhost";
$db_user = "mzcetin1_admissions";
$db_pass = "zion@3908";
$db_name = "mzcetin1_mdir";

error_reporting(0);

$con =  mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(mysqli_connect_error()){
	echo 'connect to database failed';

}



$email = $_SESSION['email'];


if(empty($email))
{
	header('Location:index.php');

}
else{




	if(isset($_POST['edit']))
	{

		
		$id=$_POST['id'];
		$name=$_POST['name'];
		$email=$_POST['email'];
		$group=$_POST['gr'];
		$mobile=$_POST['mobile'];
		$intrest=$_POST['in'];
		$district=$_POST['dis'];









		$query = mysqli_query($con,"update registers set name='$name',email='$email',mobile='$mobile',12th_group='$group',district='$district',intrest_department='$intrest'  where id='$id'");


		if(!empty($query))
		{
			echo '<script>alert("Updated Sucessfully");</script>';



		}

	}


	if(isset($_POST['re']))
	{

		
		$id=$_POST['userid'];
		$name=$_POST['username'];
		$remarks=$_POST['remark'];
		

		$insert=mysqli_query($con,"insert into remarks (`user_id`,`user_name`,`remarks`) values('$id','$name','$remarks')");


		

		if(!empty($insert))
		{
			echo '<script>alert("Updated Sucessfully");</script>';



		}

	}




	?>


	<!doctype html>
	<html lang="en">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--favicon-->
		<link rel="icon" href="assets/images/apple1.jpg" type="image/png">
		<!--plugins-->
		<link href="assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css" rel="stylesheet">
		<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
		<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
		<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
		<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet">
		<!-- loader-->
		<link href="assets/css/pace.min.css" rel="stylesheet">
		<script src="assets/js/pace.min.js"></script>
		<!-- Bootstrap CSS -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/css2.css?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
		<link href="assets/css/app.css" rel="stylesheet">
		<link href="assets/css/icons.css" rel="stylesheet">
		
		<title>Mountzion College</title>
	</head>

	<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
	</script>

	<body class="bg-theme bg-theme1">
		<!--wrapper-->
		<div class="wrapper">


			<!--sidebar wrapper -->
			<div class="sidebar-wrapper" data-simplebar="true">
				<div class="sidebar-header">
					<div>
						<img src="../images/3.jpeg" class="logo-icon" alt="logo icon">
					</div>
					<div>
						<h4 class="logo-text">MOUNTZION</h4>
					</div>
					<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
					</div>
				</div>
				<!--navigation-->
				<ul class="metismenu" id="menu">
					
					
				</ul>
				<!--end navigation-->
			</div>
			<!--end sidebar wrapper -->
			<!--start header -->
			<header>
				<div class="topbar d-flex align-items-center">
					<nav class="navbar navbar-expand">
						<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
						</div>
						
						<div class="top-menu ms-auto">
						<!-- <ul class="navbar-nav align-items-center">
							<li class="nav-item mobile-search-icon">
								<a class="nav-link" href="#">	<i class='bx bx-search'></i>
								</a>
							</li>
							
							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">7</span>
									<i class='bx bx-bell'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Notifications</p>
											<p class="msg-header-clear ms-auto">Marks all as read</p>
										</div>
									</a>
									<div class="header-notifications-list">
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-group"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Customers<span class="msg-time float-end">14 Sec
													ago</span></h6>
													<p class="msg-info">5 new user registered</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-cart-alt"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Orders <span class="msg-time float-end">2 min
													ago</span></h6>
													<p class="msg-info">You have recived new orders</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-file"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">24 PDF File<span class="msg-time float-end">19 min
													ago</span></h6>
													<p class="msg-info">The pdf files generated</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-send"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Time Response <span class="msg-time float-end">28 min
													ago</span></h6>
													<p class="msg-info">5.1 min avarage time response</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-home-circle"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Product Approved <span class="msg-time float-end">2 hrs ago</span></h6>
													<p class="msg-info">Your new product has approved</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-message-detail"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Comments <span class="msg-time float-end">4 hrs
													ago</span></h6>
													<p class="msg-info">New customer comments recived</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class='bx bx-check-square'></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Your item is shipped <span class="msg-time float-end">5 hrs
													ago</span></h6>
													<p class="msg-info">Successfully shipped your item</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class='bx bx-user-pin'></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New 24 authors<span class="msg-time float-end">1 day
													ago</span></h6>
													<p class="msg-info">24 new authors joined last week</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class='bx bx-door-open'></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Defense Alerts <span class="msg-time float-end">2 weeks
													ago</span></h6>
													<p class="msg-info">45% less alerts last 4 weeks</p>
												</div>
											</div>
										</a>
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer">View All Notifications</div>
									</a>
								</div>
							</li>
							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">8</span>
									<i class='bx bx-comment'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Messages</p>
											<p class="msg-header-clear ms-auto">Marks all as read</p>
										</div>
									</a>
									<div class="header-message-list">
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="assets/images/avatars/avatar-1.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Daisy Anderson <span class="msg-time float-end">5 sec
													ago</span></h6>
													<p class="msg-info">The standard chunk of lorem</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="assets/images/avatars/avatar-2.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Althea Cabardo <span class="msg-time float-end">14
													sec ago</span></h6>
													<p class="msg-info">Many desktop publishing packages</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="assets/images/avatars/avatar-3.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Oscar Garner <span class="msg-time float-end">8 min
													ago</span></h6>
													<p class="msg-info">Various versions have evolved over</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="assets/images/avatars/avatar-4.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Katherine Pechon <span class="msg-time float-end">15
													min ago</span></h6>
													<p class="msg-info">Making this the first true generator</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="assets/images/avatars/avatar-5.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Amelia Doe <span class="msg-time float-end">22 min
													ago</span></h6>
													<p class="msg-info">Duis aute irure dolor in reprehenderit</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="assets/images/avatars/avatar-6.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Cristina Jhons <span class="msg-time float-end">2 hrs
													ago</span></h6>
													<p class="msg-info">The passage is attributed to an unknown</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="assets/images/avatars/avatar-7.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">James Caviness <span class="msg-time float-end">4 hrs
													ago</span></h6>
													<p class="msg-info">The point of using Lorem</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="assets/images/avatars/avatar-8.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Peter Costanzo <span class="msg-time float-end">6 hrs
													ago</span></h6>
													<p class="msg-info">It was popularised in the 1960s</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="a_assets/images/avatars/avatar-9.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">David Buckley <span class="msg-time float-end">2 hrs
													ago</span></h6>
													<p class="msg-info">Various versions have evolved over</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="assets/images/avatars/avatar-10.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Thomas Wheeler <span class="msg-time float-end">2 days
													ago</span></h6>
													<p class="msg-info">If you are going to use a passage</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="assets/images/avatars/avatar-11.png" class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Johnny Seitz <span class="msg-time float-end">5 days
													ago</span></h6>
													<p class="msg-info">All the Lorem Ipsum generators</p>
												</div>
											</div>
										</a>
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer">View All Messages</div>
									</a>
								</div>
							</li>
						</ul> -->
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="assets/images/images.jpg" class="user-img" alt="user avatar">
							<div class="user-info ps-3">
								<p class="user-name mb-0">Mountzion</p>
								<p class="designattion mb-0"></p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">


							

							
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item" href="logout.php"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<!--end header --><body class="bg-theme bg-theme1">
			<!--wrapper-->
			<div class="wrapper">
				<!--sidebar wrapper -->

				<!--end header -->
				<!--start page wrapper -->
				<div class="page-wrapper">
					<div class="page-content">

						<!--breadcrumb-->
						<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
							<a href="home.php"><div class="breadcrumb-title pe-3">Registered users</div>
								<div class="ps-3">
									<nav aria-label="breadcrumb">
										<ol class="breadcrumb mb-0 p-0">
											
											<a href="add_banner.php">Add Banner</a>
										</ol>
									</nav>
								</div>

							</div>
							<!--end breadcrumb-->







							<!-- <h6 class="mb-0 text-uppercase">Registers </h6> -->
							<hr>

							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table id="example2" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th>Sno</th>
													<th>Register Date</th>										
													<th>User Id</th>
													<th>Name</th>
													<th>Email</th>
													<th>Mobile</th>
													<th>Group</th>
													<th>District</th>
													
													
													<th>Intrested_Department</th>
													<th>Edit</th>
													<th>Remarks </th>




												</tr>
											</thead>
											<tbody>

												<?php
												$i=1;
												$query2=mysqli_query($con,"SELECT * from registers order by id desc");
												while($row1=mysqli_fetch_array($query2))  
												{


													?>




													<tr >
														<td>
															<?php echo $i;?>
														</td>
														<td>
															<?php echo $row1['register_date'];?>
														</td>
														<td>
															
															<?php echo $row1['user_id'];?>
														</td>

														<td>
															






															<div class="btn-group">
																<button type="button" class="btn btn-light"><?php echo $row1['name'];?></button>
																<button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">	<span class="visually-hidden">Toggle Dropdown</span>
																</button>
																
																<ul class="dropdown-menu">
																	<?php
																	$lo=$row1['user_id'];
																	$q=1;
																	$new=mysqli_query($con,"SELECT * from remarks where user_id='$lo' order by id desc");
																	while($row=mysqli_fetch_array($new))  
																	{
																		
																		
																		?>



																		<li><a class="dropdown-item" href="#"><?php echo $q;?>.<?php echo $row['remarks'];?></a>
																		</li>
																		
																		
																		
																		<?php 
																		$q++;
																	}
																	?>

																</ul>

																
															</div>
														</td>
														<td>
															<?php echo $row1['email'];?>
														</td>
														<td>
															<?php echo $row1['mobile'] ;?>
														</td>
														<td>
															<?php echo $row1['12th_group'];?>
														</td>
														<td>
															<?php echo $row1['district'];?>
														</td>



														<td>
															<?php echo $row1['intrest_department'];?>
														</td>

														
														

														<td>
															<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row1['id'];?>">Edit</button>
															<!-- Modal -->
															<div class="modal fade" id="exampleModal<?php echo $row1['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
																<div class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
																			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																		</div>
																		<form method="post">
																			<div class="modal-body">
																				<lable for="name" >Name</lable>
																				<input type="text" class="form-control" name="name" value="<?php echo $row1['name'];?>">
																				<lable for="name" >Email</lable>
																				<input type="text" class="form-control" name="email" value="<?php echo $row1['email'];?>" >
																				<lable for="name" >Mobile</lable>
																				<input type="text" class="form-control"  name="mobile" value="<?php echo $row1['mobile'];?>">
																				
																				
																				
																				
																				<lable for="name" >Group</lable>
																				<input type="text" class="form-control"  name="gr" value="<?php echo $row1['12th_group'];?>">
																				<lable for="name" >District</lable>
																				
																				<input type="text" class="form-control"  name="dis" value="<?php echo $row1['district'];?>">
																				<lable for="name" >Intrested Department</lable>
																				
																				<input type="text" class="form-control"  name="in" value="<?php echo $row1['intrest_department'];?>">











																				<input type="hidden" class="form-control" name="id" value="<?php echo  $row1['id'];?>">
																				

																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
																				<button type="submit" class="btn btn-primary" name="edit">Save changes</button>
																			</div>
																		</form>
																	</div>
																</div>
															</div>
														</td>




														<td>
															<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal123<?php echo $row1['id'];?>">Remarks</button>
															<!-- Modal -->
															<div class="modal fade" id="exampleModal123<?php echo $row1['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
																<div class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
																			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																		</div>
																		<form method="post" enctype="multipart/form-data">

																			<div class="modal-body">
																				<lable for="name" >User Name</lable>
																				
																				
																				<input type="text" class="form-control" name="name" value="<?php echo  $row1['name'];?>" disabled>
																				

																			</div>
																			<div class="modal-body">
																				<lable for="name" >Remark</lable>
																				
																				<textarea required rows="2" name="remark" class="form-control"></textarea>

																				<input type="hidden" class="form-control" name="userid" value="<?php echo  $row1['user_id'];?>">
																				<input type="hidden" class="form-control" name="username" value="<?php echo  $row1['name'];?>">
																				

																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
																				<button type="submit" class="btn btn-primary" name="re">Save changes</button>
																			</div>
																		</form>
																	</div>
																</div>
															</div>
														</td>
														





													</tr>
													<?php $i++;
												} ?>

											</tbody>

										</table>
									</div>
								</div>
							</div>









						</div>
					</div>
					<!--end page wrapper -->
					<!--start overlay-->
					<div class="overlay toggle-icon"></div>
					<!--end overlay-->
					<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
					<!--End Back To Top Button-->
					<footer class="page-footer">
						<p class="mb-0">Copyright © 2021. All right reserved.</p>
					</footer>
				</div>
				<!--end wrapper-->
				<!--start switcher-->
				<!-- <div class="switcher-wrapper">
					<div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
					</div>
					<div class="switcher-body">
						<div class="d-flex align-items-center">
							<h5 class="mb-0 text-uppercase">Theme Customizer</h5>
							<button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
						</div>
						<hr>
						<p class="mb-0">Gaussian Texture</p>
						<hr>

						<ul class="switcher">
							<li id="theme1"></li>
							<li id="theme2"></li>
							<li id="theme3"></li>
							<li id="theme4"></li>
							<li id="theme5"></li>
							<li id="theme6"></li>
						</ul>
						<hr>
						<p class="mb-0">Gradient Background</p>
						<hr>

						<ul class="switcher">
							<li id="theme7"></li>
							<li id="theme8"></li>
							<li id="theme9"></li>
							<li id="theme10"></li>
							<li id="theme11"></li>
							<li id="theme12"></li>
							<li id="theme13"></li>
							<li id="theme14"></li>
							<li id="theme15"></li>
						</ul>
					</div>
				</div> -->
				<!--end switcher-->
				<!-- Bootstrap JS -->
				<script src="assets/js/bootstrap.bundle.min.js"></script>
				<!--plugins-->
				<script src="assets/js/jquery.min.js"></script>
				<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
				<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
				<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
				<script src="assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js"></script>
				<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
				<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
				<script>
					$(document).ready(function() {
						$('#example').DataTable();
					} );
				</script>
				<script>
					$(document).ready(function() {
						var table = $('#example2').DataTable( {
							lengthChange: false,
							buttons: [ 'copy', 'excel', 'pdf', 'print']
						} );

						table.buttons().container()
						.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
					} );
				</script>
				<script>
					$(document).ready(function () {
						$('#image-uploadify').imageuploadify();
					})
				</script>
				<!--app JS-->
				<script src="assets/js/app.js"></script>
			</body>

			</html>
			<?php
		}
		?>