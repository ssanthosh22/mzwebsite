<?php

if(isset($_POST['submit'])){
	$captcha;
		if(isset($_POST['g-recaptcha-response'])){
            $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
			echo 'captcha fail';
            
            exit;
        }
		
		
        
$name="";
$email="";
$mobile="";
$city="";
$course="";
$fathername="";


if (isset($_POST['name'])&&isset($_POST['email'])&&isset($_POST['mobile'])&&isset($_POST['city'])&&isset($_POST['course']) && isset($_POST['fathername']))
{
$name=$_POST['name'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$city=$_POST['city'];
$course=$_POST['course'];
$fathername=$_POST['fathername'];

//if($name!="" && $name!="0" && $email!="" && $email!="0" && $mobile!="" && $mobile!="0" && $dob!="" && $dob!="0" && $gender!="" && $gender!="0" && $country!="" && $country!="0" && $district!="" && $district!="0" && $address!="" && $address!="0" && $phy!="" && $phy!="0" && $chem!="" && $chem!="0" && $math!="" && $math!="0" && $tot!="" && $tot!="0" && $regno!="" && $regno!="0" && $school!="" && $school!="0" && $community!="" && $community!="0" && $course!="" && $course!="0")
	if($name!="" && $name!="0" && $email!="" && $email!="0" && $mobile!="" && $mobile!="0" && $course!="" && $course!="0" && $city!="" && $city!="0" && $fathername!="" && $fathername!="0")
{
$servername = 'www.mzcet.in';
$username = "mzcetin1_usermzcet";
$password = "super_user*mzcet";
$dbname = "mzcetin1_mzcet";
 $conn = mysqli_connect($servername, $username, $password, $dbname);
/* Check connection */
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "insert into directadmenquiry(`name`, `email`, `mobile`, `district`, `course`, `fathername`, `cdatetime`, `active`) values ('".$name."','".$email."','".$mobile."','".$city."','".$course."','".$fathername."',now(),'1')";
if (!mysqli_query($conn,$sql)) {
	//echo '<script language="javascript">';
//echo 'alert("Critical Error !"' .mysqli_error($con) .')';
//echo '</script>';
  echo("Error description: " . mysqli_error($conn));
}else{
	
	  /// mail  start	

$to      = $email; // Send email to our user
$subject = 'MZCET | Web Enquiry'; // Give the email a subject 
$message = 'Dear '.$name.',
 
Thank you for registering with us. We will get back to you soon...

Name - '.$name.', eMail - '.$email.', Mobile - '.$mobile.' .'; // Our message above including the link
                     
$headers = 'From:donotreply@mzcet.in' . "\r\n"; // Set from headers
$headers .= 'Cc: vigneshc1593@gmail.com' . "\r\n";


mail($to, $subject, $message, $headers); // Send our email
	
	
/// mail end	

	  /// mail  start	

	  switch ($course) {
case "10":
$response="B.E - CIVIL ENGINEERING";
break;
case "2":
$response="B.E - COMPUTER SCIENCE AND ENGINEERING";
break;
case "9":
$response="B.E - ELECTRICAL AND ELECTRONICS ENGINEERING";
break;
case "4":
$response="B.E - ELECTRONICS AND COMMUNICATION ENGINEERING";
break;
case "6":
$response="B.E - MECHANICAL ENGINEERING";
break;
case "16":
$response="M.E - CAD / CAM";
break;
case "20":
$response="M.E - CAD / CAM - PART TIME";
break;
case "5":
$response="M.E - COMMUNICATION SYSTEMS";
break;
case "3":
$response="M.E - COMPUTER SCIENCE AND ENGINEERING";
break;
case "19":
$response="M.E - COMPUTER SCIENCE AND ENGINEERING - PART TIME";
break;
case "11":
$response="M.E - POWER ELECTRONICS AND DRIVES";
break;
case "21":
$response="M.E - POWER ELECTRONICS AND DRIVES - PART TIME";
break;
case "7":
$response="M.E - SOFTWARE ENGINEERING";
break;
case "12":
$response="M.E - STRUCTURAL ENGINEERING";
break;
case "14":
$response="M.E - STRUCTURAL ENGINEERING - PART TIME";
break;
case "22":
$response="PH.D - COMPUTER SCIENCE AND ENGINEERING";
break;
case "24":
$response="PH.D - ELECTRONICS AND COMMUNICATION ENGINEERING";
break;
  default:
    $response="";	
	
}
//$to      = 'vignesh@mountzion.ac.in'; // Send email to our user
$to      = 'admin@mountzion.ac.in'; // Send email to our user
$subject = 'MZCET | Web Enquiry'; // Give the email a subject 
$message = 'Enquiry Details,
 
 

Name - '.$name.', eMail - '.$email.', Mobile - '.$mobile.', Course - '.$response.' .'; // Our message above including the link
                     
$headers = 'From:donotreply@mzcet.in' . "\r\n"; // Set from headers
$headers .= 'Cc: vigneshc1593@gmail.com' . "\r\n";
$headers .= 'Cc: hodece@mountzion.ac.in' . "\r\n";
$headers .= 'Cc: hodmech@mountzion.ac.in' . "\r\n";
$headers .= 'Cc: hodcse@mountzion.ac.in' . "\r\n";
mail($to, $subject, $message, $headers); // Send our email
	
	
/// mail end	

	echo '<script language="javascript">';
echo 'alert("Application Submitted !")';
echo '</script>';
echo '<script>document.location = "http://www.mzcet.in/"</script>';
}

}else{
echo '<script language="javascript">';
echo 'alert("Enter valid value !")';
echo '</script>';
}
}else{
echo '<script language="javascript">';
echo 'alert("Enter valid values !")';
echo '</script>';
}

}
?>

<!DOCTYPE html> 
<html lang="en-US">
<head>
<title>Admission Enquiry Form | Mount Zion College of Engineering and Technology</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="Engineering College Admissions, Computer Science And Engineering, Electronics And Communication Engineering, Electrical And Electronics Engineering, Mechanical Engineering, Civil Engineering, UG, PG, Engineering Degree, AICTE, NAAC, NBA, BE, ME, Anna University, Engineering Degree, Mount Zion, MZCET, Mount Zion CET, Admissions">
<meta name="description" content="For Admission Enquiry, Visit http://www.mzcet.in/Applyonline/ Contact 7373344444">
<meta property="og:title" content="Admission Enquiry Form  - Top Engineering college in India" />
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/style.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700,800,900&#038;display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="favicon.ico">
<link rel="shortcut icon" type="image/png" href="favicon.ico">

<style>
.lblp{padding-left: 5px !important; padding-right: 5px !important;}.modal-body{padding: 0.6rem; margin-top: 5px;text-align: left;}.row.engProg {z-index: 10;position: relative;}.engProg .new {background: #05668c;padding: 20px !important;border: 1px solid #fff !important;outline: 8px solid #05668c !important;}h3 {font-size: 35px; text-align:center;}a:hover {color:#b8f9ed !important;}.img {width: 100%;margin-bottom: -7px;}.imgs {width: 100%;padding: 15px;margin-bottom: -17px;}.bgcolor {background-color: #05668c;}.site-footer {margin-top: -15px;}.imgf {background: #fff;}.img-align {border: 2px solid #05668c;padding: 28px;padding-top: 23px;		border-radius: 50px;height: 100px;width: 99px;inline-size: 100px;margin-top: 8px;}.Fac_Title {font-size: 16px;color: #05668c;padding-top: 13px;margin-left: 1px;}.Fac_Title_lib {font-size: 16px;color: #09c;margin-top: -11px;margin-left: 1px;}.Fac_Title_infa {	font-size: 16px;color: #09c;padding-top: 13px;margin-left: -17px;white-space: nowrap;}.list-unstyled {justify-content: center;display: flex;}.grid:hover{background-color:#4E9CA9}@media (max-width: 320px){.ftco-counter .text strong.number {font-size: 35px;}}.bg_Color{background-color :#05668c !important ;}@media (max-width: 768px){.mtb{margin-top: -15px;margin-bottom: -11px;margin-left: 50px;}}@media (max-width: 320px){.mtb{margin-top: -40px;}}.title_1 {background-color: #4E9CA9;color: #fff;
 padding: 9px 9px 9px 9px;}.modal-title{color: #fff;}.close{color: #fff; opacity: unset;}.modal{top: 43px;}@media (max-width: 425px){.modal-header h2{font-size: 1.5rem;}.modal-body{padding: 0.5rem;}.form-group {margin-bottom: 0.5rem;}.modal{top: 60px;}}@media (max-width: 425px){.ftco-navbar-light .navbar-nav {padding-bottom: 10px;margin-right:0px;padding-right: 186px;}} body{font-family: 'Montserrat', sans-serif;font-family: 'Montserrat', sans-serif;}.font_clr{color:#ffffff !important;}.vidwithxheght{width:100%;}
</style>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-59498362-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-59498362-1');
  gtag('config', 'AW-801669436');  
</script>

<script>
   
   
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-801669436/PnohCJje9dUBELyCov4C',
      'event_callback': callback
  });
  return false;
}

</script>
   
 <script>
jQuery( document ).ready(function($){
	$('myform').on('submit', function(){
		gtag_report_conversion('http://www.mzcet.in/Applyonline/index.php');
	});
});
</script>



<!--START Placement scrolling-->

<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}
</script>
<script type="text/javascript">
(function($) {
	$(function() {
		$("#scroller").simplyScroll();
	});
})(jQuery);

</script>
<link href="../slider-stuff/thumbs2.css" rel="stylesheet" />
<link href="../slider-stuff/thumbnail-slider.css" rel="stylesheet" type="text/css" />
<script src="../slider-stuff/thumbnail-slider.js" type="text/javascript"></script>


<!--END  Placement scrolling-->



</head>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			
<article id="post-6374" class="post-6374 page type-page status-publish hentry">

	<div class="entry-head">
			</div>

	<div class="content-wrap">
		<div class="content-wrap-inner">

			<div class="entry-content">
			
    
    
    

<header class="header_area">
<div class="main_menu">
<div class="container-fulid bgcolor">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar"> <a class="navbar-brand logo_h" target="_blank" href="https://mzcet.in/"> <img src="images/Awesome-Cycles-Logo.png" class="imgs" alt="logo MZCET" /> </a>
<div class="container d-flex align-items-center mtb">
<ul class="navbar-nav mr-auto">      </ul>
<ul class="navbar-nav navbar-right">
<li class="nav-item"><a href="http://mzcet.in/" target="_blank" class="nav-link">Home</a></li>
</ul></div>
</nav></div>
</div>






<div id="slidershow">
<section class="ftco-section ftco-no-pt ftco-no-pb ftco-counter img" id="section-counter" data-stellar-background-ratio="0.5" style="overflow: hidden;">
<div class="container p2rem">
<div class="row">
<div class="col-md-4" style="background-color: #05668c;">
<h1 class="mb-2 mt-2 ml21p">Admission Open 2021</h1>
<form id="myform" action="index.php" class="form-horizontal" method="post" name="Admissionmenu">
            <input id="Admissionmenu" name="Admissionmenu" type="hidden" value="Admissionmenu" />
<div class="mt-3 row">
<div class="col-sm-12 col-md-12 col-lg-12">
                <input id="name" class="form-control" name="name" type="text" placeholder="Enter Name *" required pattern="^[a-zA-Z]+\s?[a-zA-Z]+$" title="Name is required, dot not allowed" />
              </div>
</div>
<div class="mt-3 row">
<div class="col-sm-12 col-md-12 col-lg-12">
                <input id="fathername" class="form-control" name="fathername" type="text" placeholder="Enter Father Name *" required pattern="^[a-zA-Z]+\s?[a-zA-Z]+$" title="Father Name is required, dot not allowed" />
              </div>
</div>
<div class="mt-3 row">
<div class="col-sm-12 col-md-12 col-lg-12">
                <select id="course" class="form-control" name="course" required=""><option selected="selected" value="">Select Course *</option>
				<option class="option" value="10">B.E - CIVIL ENGINEERING</option>
<option class="option" value="2">B.E - COMPUTER SCIENCE AND ENGINEERING</option>
<option class="option" value="9">B.E - ELECTRICAL AND ELECTRONICS ENGINEERING</option>
<option class="option" value="4">B.E - ELECTRONICS AND COMMUNICATION ENGINEERING</option>
<option class="option" value="6">B.E - MECHANICAL ENGINEERING</option>
<!--<option class="option" value="16">M.E - CAD / CAM</option>-->
<!--<option class="option" value="20">M.E - CAD / CAM - PART TIME</option>-->
<option class="option" value="5">M.E - COMMUNICATION SYSTEMS</option>
<option class="option" value="3">M.E - COMPUTER SCIENCE AND ENGINEERING</option>
<!--<option class="option" value="19">M.E - COMPUTER SCIENCE AND ENGINEERING - PART TIME</option>-->
<option class="option" value="11">M.E - POWER ELECTRONICS AND DRIVES</option>
<!--<option class="option" value="21">M.E - POWER ELECTRONICS AND DRIVES - PART TIME</option>-->
<!--<option class="option" value="7">M.E - SOFTWARE ENGINEERING</option>-->
<option class="option" value="12">M.E - STRUCTURAL ENGINEERING</option>
<!--<option class="option" value="14">M.E - STRUCTURAL ENGINEERING - PART TIME</option>-->
<option class="option" value="22">PH.D - COMPUTER SCIENCE AND ENGINEERING</option>
<option class="option" value="24">PH.D - ELECTRONICS AND COMMUNICATION ENGINEERING</option>
				</select>
              </div>
</div>
<div class="mt-3 row">
<div class="col-sm-12 col-md-12 col-lg-12">
                <input id="email" class="form-control" name="email" type="email" placeholder="Enter Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Enter valid email id" required="" />
              </div>
</div>
<div class="mt-3 row">
<div class="col-sm-12 col-md-12 col-lg-12">
                <input id="city" class="form-control" name="city" type="text" placeholder="Enter Your Location *" required pattern="^[a-zA-Z]+\s?[a-zA-Z]+$" title="Place is required, dot not allowed" />
              </div>
</div>
<div class="mt-3 row">
<div class="col-sm-12 col-md-12 col-lg-12">
                <input id="mobile" class="form-control" name="mobile" type="text" pattern="[0-9]{10}" title="Enter valid mobile no." placeholder="Mobile Number *" required />
              </div>
</div>
<div class="mt-2 row">
<div class="col-sm-12 col-md-12 col-lg-12">
            <input type="checkbox" name="Agree" value="1" id="Agree" checked="checked" disabled class="widget_input">
            <span>I agree to receive the admission related messages.</span>
           </div>
</div>
<div class="mt-2 row">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="form-row" style="text-align: -webkit-center;">
<span class="msg-error error" style="
    color: white;"></span><br />
<div id="recaptcha" class="g-recaptcha" data-sitekey="6LdzK6oZAAAAACV_ck85Q42IUxBFAJzJ-jKPXoaY"></div>
</div>
</div></div>
<div class="mt-2 row">
<div class="col-sm-8 col-md-8 col-lg-8 mt-2">
                <button id="submit" value="submit" class="btn btn-primary col-sm-6" name="submit" type="submit">Submit</button>				
              </div>
</div>
<div class="mt-2 row">
<div class="col-sm-8 col-md-8 col-lg-8 mt-2">
              <label class="col-sm-10 col-md-10 col-lg-10 control-label" for="conact"> Contact: <i class="fa fa-phone"></i> <a style="color: black;" href="tel:7373344444">7373344444</a></label>
</div></div>

</form>
</div>
<div class="col-md-8">
<div class="slider-item"> <img src="images/mzcettop.webp" alt="Engineering Admission" class="img"> </div>
</div>
</div>
<br><br>
Admissions for the Academic Year 2021-22 are in Progress.<br>

In order to help us reach you, we request you kindly fill up this form.

Our Admissions team will be in touch with you, we will connect with you over the phone during the COVID-19 Pandemic Lockdown phase and will help you with your queries and admission process.
<br>
Please reach out to us by Phone on the following numbers.
<br>
+91- 7373344444
<br>
+91- 9659173000
<div class="row" style="
    margin-left: 10%;
    margin-right: 10%;
">
    
<div class="slider-item"> <img src="images/mzcet2.webp" alt="Engineering Admission" class="img"> </div>    
</div>
</div>
</section>
</div>
<section class="ftco-section">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8 text-center heading-section ftco-animate">
<h2 class="mb-1">Videos</h2>
</div>
</div>
<div class="row">
<div id="video1" class="col-md-4 col-sm-4 col-xs-12 ftco-animate"><iframe class="vidwithxheght mb-2 pb-2" src="https://www.youtube.com/embed/Nh5AWYMHu4A" frameborder="0" title="MZCET Campus" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
<div id="video2" class="col-md-4 col-sm-4 col-xs-12 ftco-animate"><iframe class="vidwithxheght mb-2 pb-2" src="https://www.youtube.com/embed/ZZiCHEE38ic" frameborder="0" title="MZCET Aerial View" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
<div id="video3" class="col-md-4 col-sm-4 col-xs-12 ftco-animate"><iframe class="vidwithxheght mb-2 pb-2" src="https://www.youtube.com/embed/_Q7eLUFM8V4" frameborder="0" title="MZCET" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
</div>
</div>
</section>

<section class="ftco-section ftco-no-pt ftco-no-pb ftco-counter img" id="section-counter" style="background-image: url(images/bg_3.jpg);" data-stellar-background-ratio="0.5">
<div class="container">
<div class="row">
<div class="col-lg-12 bg-counter aside-stretch">
<h3 class="vr">College Facts</h3>
<div class="row pt-2">
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"> <strong class="number" data-number="50" style="margin-top: 21px">0</strong> <span>+ University Gold Medalists and Ranks holders</span> </div>
</div>
</div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class ="mb-n4 pt-3 fa fa-rupee" style="font-size:25px;color:#4E9CA9"></div>
<div class="text pb-3"><strong class="number" data-number="200000" style="margin-top: -25px";>0</strong></strong> <span> Cash Prize won in Smart India Hackathon, eYantra</span> </div>
</div>
</div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class ="mb-n4 pt-3 fa fa-rupee" style="font-size:25px;color:#4E9CA9"></div>
<div class="text pb-3"> <strong class="number" data-number="50000" style="margin-top: -25px";>0</strong> <span>Cash Prize won for Vishwakarma Award, etc</span> </div>
</div>
</div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18  bg-light">
<div class="text pb-3"> <strong class="number" data-number="100" style="margin-top: 21px">0</strong> <span>% Placement &#8211; 2019 Batch</span> </div>
</div>
</div>
</div>
<div class="row pt-3">
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"> <strong class="number" data-number="110" style="margin-top: 21px">0</strong><span>+ Reputed Recruiters</span> </div>
</div>
</div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">

<div class="text pb-3"> <strong class="number" data-number="40" style="margin-top: 21px";>0</strong> <span>Value Added Programmes</span> </div>
</div>
</div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"><strong class="number" data-number="700" style="margin-top: 21px">0</strong> <span>+ Webinars</span> </div>
</div>
</div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"><strong class="number" data-number="100" style="margin-top: 21px">0</strong></strong> <span> Mbps hi-speed internet powered Hi-tech labs.</span> </div>
</div>
</div>
</div>
<div class="row pt-3">
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"> <strong class="number" data-number="25" style="margin-top: 21px">0</strong> <span>Industries Visited and 5360 Industrial visit participation</span> </div>
</div>
</div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"> <strong class="number" data-number="615" style="margin-top: 21px">0</strong> <span>Awards/Medals won in sports activities</span> </div>
</div>
</div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"><strong class="number" data-number="22" style="margin-top: 21px">0</strong> <span>Extension activites and 1129 Students participated </span> </div>
</div>
</div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"><strong class="number" data-number="2550" style="margin-top: 21px">0</strong></strong> <span>Internships/In-plant Training</span> </div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<section Class="pb-2">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<h2 class="text-center text-uppercase"><strong>Engineering Programs</strong></h2>
</div>
</div>
<div class="row mt-4 engProg">
<div class="col-xs-12 new col-sm-12 col-md-10 col-md-offset-1 text-center d-block mx-auto">
<div class="row">
    <div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<a href="http://www.mzcet.in/CIVIL/" target="_blank"><img src="images/civil.png" alt="B.E. Civil Engineering Admission" /></a>
<h5 class="text-center"> <a href="http://www.mzcet.in/CIVIL/" target="_blank" style="color:white;">B.E. Civil
            Engineering<br />
            </a> </h5>
</div>
    <div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<a href="http://www.mzcet.in/CSE/" target="_blank"><img src="images/cse.png" alt="B.E. Computer Science Engineering Admission" /></a>
<h5 class="text-center"> <a href="http://www.mzcet.in/CSE/" target="_blank" style="color:white;"> B.E. Computer Science <br />
            and Engineering<br />
            </a> </h5>
</div>
<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<a href="http://www.mzcet.in/ECE/" target="_blank"><img src="images/ece.png" alt="Engineering Admission" /></a>
<h5 class="text-center"> <a href="http://www.mzcet.in/ECE/" target="_blank" style="color:white;"> B.E. Electronics and<br />
            Communication
            Engineering </a> </h5>
</div>

<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<a href="http://www.mzcet.in/EEE/" target="_blank"><img src="images/eee.png" alt="Engineering Admission" /></a>
<h5 class="text-center"> <a href="http://www.mzcet.in/EEE/" target="_blank" style="color:white;"> B.E. Electrical and<br />
            Electronics Engineering<br />
            </a> </h5>
</div>


<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<a href="/departments/mech/" target="_blank"><img src="images/mech.png" alt="B.E. Mechanical
            Engineering Engineering Admission" /></a>
<h5 class="text-center"> <a href="/departments/mech/" target="_blank" style="color:white;">B.E. Mechanical
            Engineering<br />
            </a> </h5>
</div>


<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<a href="#" target="_blank"><img src="images/ece.png" alt="M.E. Communication Systems" /></a>
<h5 class="text-center"><a href="http://www.mzcet.in/ECE/" target="_blank" style="color:white;">M.E. Communication Systems </a></h5>
</div>

<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<a href="#" target="_blank"><img src="images/it1.png" alt="M.E. Computer Science and Engineering Admission" /></a>
<h5 class="text-center"> <a href="http://www.mzcet.in/CSE/" target="_blank" style="color:white;"> M.E. Computer Science and Engineering  <br />
            </a> </h5>
</div>
<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<a href="#" target="_blank"><img alt="M.E. Power Electronics and Drives Admissions" src="images/Artboard1.png" /></a>
<h5 class="text-center"> <a href="http://www.mzcet.in/EEE/" target="_blank" style="color:white;">M.E. Power Electronics and Drives <br/>         
            </a> </h5>
</div>
<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<a href="#" target="_blank"><img src="images/it.png" alt="M.E. Structural Engineering Admission" /></a>
<h5 class="text-center"><a href="http://www.mzcet.in/CIVIL/" target="_blank" style="color:white;">M.E. Structural Engineering </a></h5>
</div>

<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<a href="#" target="_blank"><img src="images/cse.png" alt="Ph.D - Computer Science and Engineering" /></a>
<h5 class="text-center"><a href="http://www.mzcet.in/CSE/" target="_blank" style="color:white;">Ph.D. - Computer Science and Engineering </a></h5>
</div>

<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<a href="#" target="_blank"><img src="images/ece.png" alt="Ph.D - Electronics and Communication Engineering" /></a>
<h5 class="text-center"><a href="http://www.mzcet.in/ECE/" target="_blank" style="color:white;">Ph.D. - Electronics and Communication Engineering</a></h5>
</div>



</div>
</div>
</div>
</section>
<section class="ftco-intro mt-5 py-2 mb-3" data-stellar-background-ratio="0.5" style="background-position: 50% -138.033px;">
<div class="overlay bg_Color"></div>
<div class="container-fulid">
<div class="row">
<div class="col-md-9 ml-5 pt-4">
<h2>Photos</h2>
</div>
<div class="col-md-2 pt-4 d-flex justify-content-center align-items-center">
<p class="mb-0"><a href="https://moodle.mzcet.in/photogallery/photo.php" target="_blank" class="btn btn-secondary px-4 py-2" style="background-color: #05668c;">View</a>
</div>
</div>
</div>
</section>
<section class="ftco-services mt-5 ftco-no-pb">
<div class="container">
<div class="row no-gutters">
<div class="col-md-4 col-xs-12 d-flex services align-self-stretch p-3 ftco-animate fadeInUp ftco-animated">
<div class="media block-6 d-block ">
<div class="icon d-flex justify-content-center align-items-center text-center"> <span class=""><img src="images/light-bulb.png" class="iconimg"></span> </div>
<div class="media-body p-2 mt-2">
<h3 class="heading text-center">Academics</h3>
<ul>
<li>Accredited by NAAC with B++.</li>
<li>Permanent affiliation for all UG courses</li>
<li>30 MoUs & Tie-ups including foreign Universities</li>
<li>National Level Technical Symposium conducted every year</li>
<li>TNSCST funded students projects</li>
</ul></div>
</div>
</div>
<div class="col-md-4 col-xs-12 d-flex services align-self-stretch p-3 ftco-animate fadeInUp ftco-animated">
<div class="media block-6 d-block">
<div class="icon d-flex justify-content-center align-items-center text-center"> <span class=""><img src="images/campus.png" alt="Engineering Admission" class="iconimg"></span> </div>
<div class="media-body p-2 mt-2">
<h3 class="heading text-center">Campus</h3>
<ul>
<li>Located in 100 acre Integrated Campus</li>
<li>100% Smart Classroom facility</li>
<li>Hi-tech labs with 300 mbps hi-speed internet connection and free WIFI access</li>
<li>Ultra-modern fitness centre</li>
<li>Air conditioned auditorium which can accommodate 500+ students</li>
<li>24-hour ATM facility inside the college campus</li>
</ul></div>
</div>
</div>
<div class="col-md-4 col-xs-12 d-flex services align-self-stretch p-3 ftco-animate fadeInUp ftco-animated">
<div class="media block-6 d-block">
<div class="icon d-flex justify-content-center align-items-center text-center"> <span class=""><img alt="Engineering Admission" src="images/university.png" class="iconimg"></span> </div>
<div class="media-body p-2 mt-2">
<h3 class="heading text-center">Achievement</h3>
<ul>
<li>Winner of SMART INDIA HACKATHON 2019 held at IIT, Kanpur 2019</li>
<li>Winner of SMART INDIA HACKATHON 2020</li>
<li>Winner of eYantra</li>
<li>Winner of Vishwakarma Award</li>
<li>Best EDC Award</li>
<li>Best NSS Unit Award</li>
<li>Best CSI Student Branch Award</li>
</ul></div>
</div>
</div>
</div>
</div>
</section>
<br>

<section class="ftco-intro">
<div class="overlay newcolor"></div>
<div class="container">
<div class="row">
<div class="col-md-12">
<h2>Testimonial</h2>
<p class="mb-0">
    <!-- Slideshow container -->
<div class="slideshow-container">

  <!-- Full-width slides/quotes -->
  <div class="mySlides">
    <q>'Demonstrated my tact' One of the most hardest thing to do in life is to start. This college brought me to change my world for sure. The way of teaching and guiding kindled my zeal to learn programming in a smart way. Thanks to my ever inspiring mentors who guided me to follow the path clearly.</q>
    <p class="author"><img class="round" src="images/satheesh.jpg" alt="Testimonial" style="width:100px"><br> Er. Satheesh Natarajan,<br> B.E. CSE (2011-2015)<br>Full Stack Developer, Kloud9 Technologies, Bangalore.
  </div>
  <div class="mySlides">
    <q>'My knowledge and confidence had been boosted after came here. I thank all the faculty of civil engineering as they were very much helpful and supportive.</q>
    <p class="author"><img class="round" src="images/BEROSENICKSON.jpg" alt="Testimonial" style="width:100px"><br> Er. Berose Nikson <br> B.E. CIVIL (2010-2014)<br>Senior Engineer, Siemens Gamesa Renewable Energy, Chennai. </div>
  <div class="mySlides">
    <q>It was an enriching experience for me to learn my core subjects thoroughly at MZCET. I thank my Professors who encouraged me to learn and explore the subjects as much as I can. This endeavor made me to shine and achieve new heights in my professional career </q>
    <p class="author"><img class="round" src="images/manirethinam.jpg" alt="Testimonial" style="width:100px"><br> Er. Manirethinam .R,<br> B.E. CSE (2012-2016)<br> Software Engineer, TNQ Technologies, Chennai.
  </div>
<div class="mySlides">
    <q>“It was my childhood dream to be a Civil Engineer. Utilizing god grace… I’m here as I wish… MZCET where  I structured myself a good civil professionally. The best professors of MZCET to zeal our self and also they made me here I am making buildings… </q>
    <p class="author"><img class="round" src="images/UDHAYA KUMAR.jpg" alt="Testimonial" style="width:100px"><br> Er. Udhaya Kumar .S <br>B.E. CIVIL (2010-2014) <br>Site Engineer, ATAT.1 PTE LIMITED, Singapore.
  </div>
  <div class="mySlides">
    <q>The best thing about my college was that I was surrounded by a team of supporting professors and group of friends, I was most passionate about. They were very friendly and relaxed. This atmosphere enabled me to rectify my mistakes and challenged myself to work even harder and made me, what I am today. </q>
    <p class="author"><img class="round" src="images/Maruthupandian.jpg" alt="Testimonial" style="width:100px"><br> Er.  Maruthupandian .S <br>B.E. CSE (2008-2012) <br>Devops Consultant, Intellect Design Arena Ltd, Chennai.
  </div>
<div class="mySlides">
    <q>MZCET has done a splendid job by inculcating the ability in me to learn and build a strong foundation in acquiring knowledge. The learner centric environment not only trained me in academics but also helped me to update the current developments. Exposure to international tech and innovation symposiums inspired me to expand my abilities both physically and mentally. I must thank all my lecturers and professors for shaping me as a better technocrat.</q>
    <p class="author"><img class="round" src="images/kavin.jpg" alt="Testimonial" style="width:100px"><br> Er. Kavin S. <br>B.E. CSE [2006-2010 Batch] <br>Standard Chartered GBS, Bangalore.
  </div>
<div class="mySlides">
    <q>MZCET gave a great opportunity for students like me to broaden their knowledge beyond their field of study (learning, fun, culture, literature and many such life changing activities). Studying at MZCET brought an added value to my life. It gave me an opportunity to learn several things. I have received great support from faculty, The friendly attitude of the faculty and their willingness to always offer a helping hand has made me feel a part of the MZCET family. The four years I spent at MZCET were splendid and has helped me to grow better professionally and personally. I am thankful to MZCET for providing a platform to enhance my skills and an opportunity to showcase them through various contests/platforms. The skills I have gained in my Bachelors have equipped me to accomplish my professional goals.</q>
    <p class="author"><img class="round" src="images/Vipin Paul.jpg" alt="Testimonial" style="width:100px"><br> Er. Vipin Paul<br> B.E. CSE 2013-2017 Batch]<br> Software Developer, Bridge Connectivity Solutions Pvt.Ltd (BCS), Delhi 
  </div>

  <!-- Next/prev buttons -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>

<!-- Dots/bullets/indicators -->
<div class="dot-container">
  <span class="dot" onclick="currentSlide(1)"></span>
  <span class="dot" onclick="currentSlide(2)"></span>
  <span class="dot" onclick="currentSlide(3)"></span>
  <span class="dot" onclick="currentSlide(4)"></span>
  <span class="dot" onclick="currentSlide(5)"></span>
  <span class="dot" onclick="currentSlide(6)"></span>
</div>
    
<script>
var slideIndex = 1;
showSlides(slideIndex);
var myVar = setInterval(calcslides, 10000);

function calcslides() {
  showSlides(slideIndex += 1);
}

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}
</script>
   
    
    
    
</div>

</div>
</div>
</section>

<!-- Placement Scrolling-->

<section class="ftco-section ftco-no-pt ftc-no-pb">
<div class="container">
    
    <!-- PARTNERS -->   
    	<div id="thumbnail-slider">
			
			
                <div class="inner">
		               <div class="margin">
					   <div class="col-lg-12">

              <h3><strong><center>Top Recruiters</center></strong></h3>
			  <br>
			  <ul>
                        <li>
                            <a class="thumb" href="../images/clogo.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/clogo12.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/clogo2.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/clogo3.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/clogo4.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/clogo5.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/clogo6.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/clogo7.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/clogo8.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/clogo9.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/clogo10.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/clogo11.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/1.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/2.png"></a>
                        </li>
                        <!--<li>
                            <a class="thumb" href="../images/logo/3.png"></a>
                        </li>-->
                        <li>
                            <a class="thumb" href="../images/logo/4.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/5.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/6.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/7.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/8.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/9.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/10.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/11.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/12.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/14.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/15.png"></a>
                        </li>
                         <li>
                            <a class="thumb" href="../images/logo/16.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/18.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/19.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/20.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/21.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/22.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/23.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/24.png"></a>
                        </li>
                        <li>
                            <a class="thumb" href="../images/logo/25.png"></a>
                        </li>

                        
                    </ul>
					
					</div>
					</div>
					</div>
					
			   </div>
    
    
    <!-- PARTNERS -->   
    
</div>
</section>
<section class="ftco-intro" data-stellar-background-ratio="0.5">
<div class="overlay"></div>
<div class="container">
<div class="row">
<div class="col-md-9">
<h2>Online Courses</h2>
<p class="mb-0"> Python, C, C++, Java ,... 
</div>
<div class="col-md-3 d-flex align-items-center">
<p class="mb-0"><a href="http://moodle.mzcet.in/moodle/" target="_blank" class="btn btn-secondary px-4 py-3">moodle - Online Learning Platform</a>
</div>
</div>
</div>
</section>
<section class="ftco-section">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-9 text-center heading-section ftco-animate"> <span class="subheading"></span>
<h2 class="mb-4">Students Innovative Projects</h2>
<p>We are encouraging our students to learn and play a innovate ideas. Our students are demonstrating their project skills in the every semester.</P>
</div>
<div class="col-md-3 d-flex align-items-center">
<p class="mb-0"><a href="http://moodle.mzcet.in/photogallery/index.php/?sfpg=MjAyMC0wMS0wMyBFeGhpYml0aW9uIEN1bSBEZW1vLyoqYTk2OWIxNzVkYTE3MDNmM2Y1MjY0NzBmOWVmNTc5MjhmZWU2NWRiMGVjYTRlMWMzOWFlZTcyOWU3OTViMWI2Nw" target="_blank" class="btn btn-secondary px-4 py-3">Technical Events</a>
</div>
</div>
</div>
</section>
<section class="bg-light ftco-section">
<div class="container">
<div class="text-center heading-section ftco-animate"> <span class="subheading"></span>
<h2 class="mb-0">Campus Facilities</h2>
</div>
<div class="row justify-content-center align-items-center text-center">
<div class="row ml-4 mr-4 justify-content-center align-items-center text-center">
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img src="images/library.png" class="imgf img-align" alt="Engineering Admission"></span> </div>
<div class="Fac_Title"><b>Library</b></div>
<div class="Fac_Title">Collection of 10000+ books, in different subjects</div>
</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img src="images/nss.png" class="imgf img-align" alt="Engineering Admission"></span> </div>
<div class="Fac_Title"><b>Classroom</b></div>
<div class="Fac_Title">Smart classroom facilities and modern laboratories with the latest equipment.</div>
</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/hostel.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>Hostel</b></div>
<div class="Fac_Title">Separately for boys and girls with well furnished suite</div>
</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/onlinepayments.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>Online Payment</b></div>
<div class="Fac_Title">Easy to make payment, pay student fees Online</div>
</div>
</div>
</div>
<div class="row ml-4 mr-4 justify-content-center align-items-center text-center">
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/Canteen.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>Canteen</b></div>
<div class="Fac_Title">Hygienic veg. and non Veg. foods and snacks with excellent quality</div>
</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/Transports.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>Transport</b></div>
<div class="Fac_Title">From Pudukkottai, Karaikudi, Thiruppathur, Singampunari, Aranthangi, Ponnamaravathi and Gandarvakottai.</div>
</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/sports.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>Sports</b></div>
<div class="Fac_Title">Full-fledged sports and games facilities (Indoor/Outdoor).<br> Only engineering college in the district to win the most prizes in athletics and games repeatedly at the zonal level.</div>
</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/atm.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>ATM</b></div>
<div class="Fac_Title">24-hour ATM facility inside the college campus</div>
</div>
</div>
</div>
</div>
</div>
</section>
<section class="ftco-section ftco-no-pt ftc-no-pb">
<div class="container">
<div class="col-md-12 text-center heading-section ftco-animate"> <span class="subheading"></span>
<h2 class="mb-2">Stay Connected</h2>
</div>
<div class="row no-gutters">
<div class="col-md-12 wrap-about ftco-animate">
<div class="row list-unstyled">
<ul class="ftco-footer-social list-unstyled float-md-left float-lft">

<li class="ftco-animate"><a href="https://www.facebook.com/MountZionCET" target="_blank"><span><img alt="Engineering Admission" src="images/connect_facebook.png" alt="connect_facebook"></span></a></li>
<li class="ftco-animate"><a href="https://www.youtube.com/c/MzcetInMZ" target="_blank"><span><img alt="Engineering Admission" src="images/youtube1.png" alt="Youtube"></span></a></li>
<li class="ftco-animate"><a href="https://www.instagram.com/MountZionCET/" target="_blank"><span><img alt="Engineering Admission" src="images/INSTA.png" alt="insta"></span></a></li>
<li class="ftco-animate"><a href="https://api.whatsapp.com/send?phone=917373344444&text=Admission%20Enquiry" target="_blank"><span><img alt="Engineering Admission" src="images/whatsapp.png" alt="whatsapp"></span></a></li>
<li class="ftco-animate fadeInUp ftco-animated"><a href="https://goo.gl/maps/Ji9a6K2pNirzfLt78" target="_blank"><span><img src="images/location.jpg" class="img-broder"></span></a></li>
<li class="ftco-animate fadeInUp ftco-animated"><a href="https://t.me/joinchat/LFwaF0Qr0Lw2MmNl" target="_blank"><span><img src="images/telegram.png" class="img-broder"></span></a></li>
</ul></div>
<br>
</div>
</div>
</div>
</section>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/scrollax.min.js"></script>
<script src="js/main.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript">	$(window).on('load',function(){$("#myModal").modal('show');}); $('#myModal').modal({backdrop: 'static'})</script>




			</div><!-- .entry-content -->

					</div>
	</div>

</article><!-- #post-## -->
		</main><!-- #main -->
	</div><!-- #primary -->

</div><!-- .inner-wrapper --></div><!-- .container --></div><!-- #content -->
	
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
										<div class="copyright">
					© Copyright 2021 by <a href="http://www.mzcet.in/">MZCET</a>				</div><!-- .copyright -->
			
			 

  
    			
		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<a href="#page" class="scrollup" id="btn-scrollup"><i class="fa fa-angle-up"></i></a></body>
</html>