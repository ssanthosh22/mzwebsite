<?php
$host = 'localhost';
$user = 'mzcetin1_alumni';
$pass = 'mzcetin1_alumni@123';
$db = 'mzcetin1_alumni';

$con=mysqli_connect($host,$user,$pass) or die(mysqli_error($con));
mysqli_select_db($con, $db) or die(mysqli_error($con));
date_default_timezone_set("Asia/kolkata");
session_start();
?>