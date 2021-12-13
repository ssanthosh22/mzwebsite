<?php
$host = 'localhost';
$user = 'mzcetin1_alumini';
$pass = 'mzcetin1_alumini@123';
$db = 'mzcetin1_alumini';

// $host = 'localhost';
// $user = 'root';
// $pass = '';
// $db = 'alumni';

$con=mysqli_connect($host,$user,$pass) or die(mysqli_error($con));
mysqli_select_db($con, $db) or die(mysqli_error($con));
date_default_timezone_set("Asia/kolkata");
session_start();
?>