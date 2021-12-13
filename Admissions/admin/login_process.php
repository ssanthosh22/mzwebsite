<?php

session_start();
$db_host = "localhost";
$db_user = "mount_zion";
$db_pass = "mount_zion@123";
$db_name = "mount_zion";


$con =  mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(mysqli_connect_error()){
  echo 'connect to database failed';
}


$user_id = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);
error_reporting(0);
$query ="select * from admin_login  where  email='$user_id' and password='$password'";
$join=mysqli_query($con,$query);
$fetch=mysqli_fetch_object($join);

if ($fetch>0) 
{
	$_SESSION['email']=$fetch->email;

	  echo '<script>alert("Login Success.");window.location.assign("home.php");</script>';



	}
else{
	echo '<script>alert("User ID/Email ID or password is wrong.");window.location.assign("index.php");</script>';
}

?>