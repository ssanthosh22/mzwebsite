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
<html lang="en-US"><head>
<meta name="keywords" content="Engineering College Admissions, Computer Science And Engineering, Electronics And Communication Engineering, Electrical And Electronics Engineering, Mechanical Engineering, Civil Engineering, UG, PG, Engineering Degree, AICTE, NAAC, NBA, BE, ME, Anna University, Engineering Degree, Mount Zion, MZCET, Mount Zion CET, Admissions">
<meta name="description" content="Approved by AICTE, Affiliated to Anna University and Accredited by NAAC with ‘B++’ grade , Recognised by UGC under section 2(f) & 12(B) of the UGC Act, 1956.">
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-59498362-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-59498362-2');
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
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			
<article id="post-6374" class="post-6374 page type-page status-publish hentry">

	<div class="entry-head">
			</div>

	<div class="content-wrap">
		<div class="content-wrap-inner">

			<div class="entry-content">
				<p> <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
    <title>Admission | Mount Zion College of Engineering and Technology</title>
<script src="https://www.google.com/recaptcha/api.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/style.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700,800,900&#038;display=swap" rel="stylesheet">
<style>
.lblp{padding-left: 5px !important; padding-right: 5px !important;}.modal-body{padding: 0.6rem; margin-top: 5px;text-align: left;}.row.engProg {z-index: 10;position: relative;}.engProg .new {background: #05668c;padding: 20px !important;border: 1px solid #fff !important;outline: 8px solid #05668c !important;}h3 {font-size: 35px; text-align:center;}a:hover {color:#b8f9ed !important;}.img {width: 100%;margin-bottom: -7px;}.imgs {width: 100%;padding: 15px;margin-bottom: -17px;}.bgcolor {background-color: #05668c;}.site-footer {margin-top: -15px;}.imgf {background: #fff;}.img-align {border: 2px solid #05668c;padding: 28px;padding-top: 23px;		border-radius: 50px;height: 100px;width: 99px;inline-size: 100px;margin-top: 8px;}.Fac_Title {font-size: 16px;color: #05668c;padding-top: 13px;margin-left: 1px;}.Fac_Title_lib {font-size: 16px;color: #09c;margin-top: -11px;margin-left: 1px;}.Fac_Title_infa {	font-size: 16px;color: #09c;padding-top: 13px;margin-left: -17px;white-space: nowrap;}.list-unstyled {justify-content: center;display: flex;}.grid:hover{background-color:#4E9CA9}@media (max-width: 320px){.ftco-counter .text strong.number {font-size: 35px;}}.bg_Color{background-color :#05668c !important ;}@media (max-width: 768px){.mtb{margin-top: -15px;margin-bottom: -11px;margin-left: 50px;}}@media (max-width: 320px){.mtb{margin-top: -40px;}}.title_1 {background-color: #4E9CA9;color: #fff;
 padding: 9px 9px 9px 9px;}.modal-title{color: #fff;}.close{color: #fff; opacity: unset;}.modal{top: 43px;}@media (max-width: 425px){.modal-header h2{font-size: 1.5rem;}.modal-body{padding: 0.5rem;}.form-group {margin-bottom: 0.5rem;}.modal{top: 60px;}}@media (max-width: 425px){.ftco-navbar-light .navbar-nav {padding-bottom: 10px;margin-right:0px;padding-right: 186px;}} body{font-family: 'Montserrat', sans-serif;font-family: 'Montserrat', sans-serif;}.font_clr{color:#ffffff !important;}.vidwithxheght{width:100%;}
</style>
<header class="header_area">
<div class="main_menu">
<div class="container-fulid bgcolor">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar"> <a class="navbar-brand logo_h" target="_blank" href="https://mzcet.in/"> <img src="images/Awesome-Cycles-Logo.png" class="imgs" alt="logo MZCET" /> </a></p>
<div class="container d-flex align-items-center mtb">
<ul class="navbar-nav mr-auto">
        </ul>
<ul class="navbar-nav navbar-right">
<li class="nav-item"><a href="http://mzcet.in/" target="_blank" class="nav-link">Home</a></li>
</ul></div>
</nav></div>
</div>
</header>
<div id="slidershow">
<section class="ftco-section ftco-no-pt ftco-no-pb ftco-counter img" id="section-counter" data-stellar-background-ratio="0.5" style="overflow: hidden;">
<div class="container p2rem">
<div class="row">
<div class="col-md-8">
<div class="slider-item"> <img src="images/mzcettop.webp" alt="Engineering Admission" class="img"> </div>
</p></div>
<div class="col-md-4" style="background-color: #F9A442;">
<h4 class="mb-2 mt-2 ml21p">Admission Open 2020</h4>
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
<option class="option" value="16">M.E - CAD / CAM</option>
<option class="option" value="20">M.E - CAD / CAM - PART TIME</option>
<option class="option" value="5">M.E - COMMUNICATION SYSTEMS</option>
<option class="option" value="3">M.E - COMPUTER SCIENCE AND ENGINEERING</option>
<option class="option" value="19">M.E - COMPUTER SCIENCE AND ENGINEERING - PART TIME</option>
<option class="option" value="11">M.E - POWER ELECTRONICS AND DRIVES</option>
<option class="option" value="21">M.E - POWER ELECTRONICS AND DRIVES - PART TIME</option>
<option class="option" value="7">M.E - SOFTWARE ENGINEERING</option>
<option class="option" value="12">M.E - STRUCTURAL ENGINEERING</option>
<option class="option" value="14">M.E - STRUCTURAL ENGINEERING - PART TIME</option>
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
              <label class="col-sm-10 col-md-10 col-lg-10 control-label" for="conact"> Contact: <i class="fa fa-phone"></i> <a style="color: #007f00;" href="tel:7373344444">7373344444</a></label>
</div></div>

</form>
</div>
</div>
</div>
</section>
</div>
<section class="ftco-section">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8 text-center heading-section ftco-animate">
<h2 class="mb-1">Videos</h2>
</p></div>
</p></div>
<div class="row">
<div id="video1" class="col-md-4 col-sm-4 col-xs-12 ftco-animate"><iframe class="vidwithxheght mb-2 pb-2" src="https://www.youtube.com/embed/Nh5AWYMHu4A" frameborder="0" title="MZCET Campus" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
<div id="video2" class="col-md-4 col-sm-4 col-xs-12 ftco-animate"><iframe class="vidwithxheght mb-2 pb-2" src="https://www.youtube.com/embed/ZZiCHEE38ic" frameborder="0" title="MZCET Aerial View" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
<div id="video3" class="col-md-4 col-sm-4 col-xs-12 ftco-animate"><iframe class="vidwithxheght mb-2 pb-2" src="https://www.youtube.com/embed/_Q7eLUFM8V4" frameborder="0" title="MZCET" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
</p></div>
</p></div>
</section>
<section class="ftco-section">
<div class="container">
<div class="row justify-content-center mb-2 pb-2">
<div class="col-md-8 text-center heading-section ftco-animate">
<h2 class="mb-4 ">Best Placement</h2>
<h5>Best Place to get Top Placement</h5>
</p></div>
</p></div>
<div class="row">
<div class="col-md-3 col-xs-12 ftco-animate">
<div class="pricing-entry pb-3 text-center">
<h4 class="mb-1 title_1">89.25% Placement Record</h4>
<ul class="pb-1">
<li>Total No. Placed students till date : 2639.</li>
<li>420+ students so far got placement in 2020(Till March).</li>
<li>224 Placement Offers in Tier 1 Companies &#8211; 2020 Batch.</li>
<li>456 students placed in 2019.</li>
</ul></div>
</p></div>
<div class="col-md-3 col-xs-12 ftco-animate">
<div class="pricing-entry pb-5 text-center">
<h4 class="mb-2 title_1">Rs.11 Lakhs as Highest Salary</h4>
<ul>
<li>3.6 Lakhs as Average Salary<br/>
			Hackerearth (Rs.11 lakhs / Annum)<br/>
			TCS (Rs.7 lakhs / Annum)<br/>
			BYJU’S (Rs.7 lakhs / Annum)<br/>
			ZOHO (Rs.6.5 lakhs / Annum)<br/>
			MateLabs(Rs.6.5 lakhs / Annum)<br/>			
			Kaar (Rs. 5 lakhs / Annum)</li>
</ul></div>
</p></div>
<div class="col-md-3 col-xs-12 ftco-animate">
<div class="pricing-entry pb-3 active text-center">
<h4 class="mb-2 title_1">100+ Reputed recruiters </h4>
<ul>
<li>TCS Recruited 132 students of 2020 Batch.</li>
<li>Our Top recruiters are TCS, BYJU’S, Zoho, MateLabs, Virtusa, Kaar, Sopra Steria etc.</li>
<li>Campus Recruited by TCS From 1st Batch Onwards.</li>
<li>60+ On campus Interviews &#8211; 2020 Batch.</li>
</ul></div>
</p></div>
<div class="col-md-3 col-xs-12 ftco-animate">
<div class="pricing-entry pb-3 text-center">
<h4 class="mb-2 title_1">Practice for Top Companies</h4>
<ul>
<li>Company Specific Intensive training with leading training companies like FACE, SMART.</li>
<li>Tie-up with Skill Rack, Cocubes,etc for conduction of online assessment test.</li>
<li>50+ Placement Offers through Competitions.</li>
<li>50+ Industrial Tie-ups</li>
</ul></div>
</p></div>
</p></div>
</p></div>
</section>
<section class="ftco-section ftco-no-pt ftco-no-pb ftco-counter img" id="section-counter" style="background-image: url(images/bg_3.jpg);" data-stellar-background-ratio="0.5">
<div class="container">
<div class="row">
<div class="col-lg-12 bg-counter aside-stretch">
<h3 class="vr">About College Facts</h3>
<div class="row pt-2">
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"> <strong class="number" data-number="69" style="margin-top: 21px">0</strong> <span>University Gold Medalists and Ranks holders</span> </div>
</p></div>
</p></div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class ="mb-n4 pt-3 fa fa-rupee" style="font-size:25px;color:#4E9CA9"></div>
<div class="text pb-3"><strong class="number" data-number="2" style="margin-top: -25px";>0</strong></strong> <span>Lakhs Cash Prize won TCS-Inframind</span> </div>
</p></div>
</p></div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class ="mb-n4 pt-3 fa fa-rupee" style="font-size:25px;color:#4E9CA9"></div>
<div class="text pb-3"> <strong class="number" data-number="50000" style="margin-top: -25px";>0</strong> <span>Cash Prize won for ZOHO National level CliTrix Competition</span> </div>
</p></div>
</p></div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18  bg-light">
<div class="text pb-3"> <strong class="number" data-number="420" style="margin-top: 21px">0</strong> <span>+ students placed till date &#8211; 2020 Batch</span> </div>
</p></div>
</p></div>
</p></div>
<div class="row pt-3">
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"> <strong class="number" data-number="100" style="margin-top: 21px">0</strong><span>+ Reputed recruiters</span> </div>
</p></div>
</p></div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class ="mb-n4 pt-3 fa fa-rupee" style="font-size:25px;color:#4E9CA9"></div>
<div class="text pb-3"> <strong class="number" data-number="11" style="margin-top: -25px";>0</strong> <span>Lakhs per annum, Highest job offer</span> </div>
</p></div>
</p></div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"><strong class="number" data-number="275" style="margin-top: 21px">0</strong> <span>Research Publications</span> </div>
</p></div>
</p></div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"><strong class="number" data-number="500" style="margin-top: 21px">0</strong></strong> <span>Kw Solar Powered green campus</span> </div>
</p></div>
</p></div>
</p></div>
<div class="row pt-3">
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"> <strong class="number" data-number="707" style="margin-top: 21px">0</strong> <span>Students as benefited by Scholarship during 2018-19</span> </div>
</p></div>
</p></div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"> <strong class="number" data-number="14" style="margin-top: 21px">0</strong> <span>Center of Excellence</span> </div>
</p></div>
</p></div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"><strong class="number" data-number="50" style="margin-top: 21px">0</strong> <span>+Industrial Tie-ups</span> </div>
</p></div>
</p></div>
<div class="col-md-3 col-xs-6 d-flex justify-content-center counter-wrap ftco-animate">
<div class="block-18 bg-light">
<div class="text pb-3"><strong class="number" data-number="27" style="margin-top: 21px">0</strong></strong> <span>MoUs &#038; Industry Institute of Interaction</span> </div>
</p></div>
</p></div>
</p></div>
</p></div>
</p></div>
</p></div>
</section>
<section Class="pb-2">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<h2 class="text-center text-uppercase"><strong>Best Engineering Programs</strong></h2>
</p></div>
</p></div>
<div class="row mt-4 engProg">
<div class="col-xs-12 new col-sm-12 col-md-10 col-md-offset-1 text-center d-block mx-auto">
<div class="row">
<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<p><a href="http://www.mzcet.in/EEE/" target="_blank"><img src="images/eee.png" alt="Engineering Admission" /></a></p>
<h5 class="text-center"> <a href="http://www.mzcet.in/EEE/" target="_blank" style="color:white;"> Electrical and<br />
            Electronics Engineering<br />
            </a> </h5>
</p></div>
<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<p><a href="http://www.mzcet.in/ECE/" target="_blank"><img src="images/ece.png" alt="Engineering Admission" /></a></p>
<h5 class="text-center"> <a href="http://www.mzcet.in/ECE/" target="_blank" style="color:white;"> Electronics and<br />
            Communication
            Engineering </a> </h5>
</p></div>
<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<p><a href="http://www.mzcet.in/CSE/" target="_blank"><img src="images/cse.png" alt="Engineering Admission" /></a></p>
<h5 class="text-center"> <a href="http://www.mzcet.in/CSE/" target="_blank" style="color:white;"> Computer Science <br />
            and Engineering<br />
            </a> </h5>
</p></div>
<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<p><a href="#" target="_blank"><img src="images/it.png" alt="Engineering Admission" /></a></p>
<h5 class="text-center"> <a href="#" target="_blank" style="color:white;"> Information Technology<br />
            </a> </h5>
</p></div>
<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<p><a href="/departments/mech/" target="_blank"><img src="images/mech.png" alt="Engineering Admission" /></a></p>
<h5 class="text-center"> <a href="/departments/mech/" target="_blank" style="color:white;"> Mechanical
            Engineering<br />
            </a> </h5>
</p></div>
<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<p><a href="http://www.mzcet.in/CIVIL/" target="_blank"><img src="images/civil.png" alt="Engineering Admission" /></a></p>
<h5 class="text-center"> <a href="http://www.mzcet.in/CIVIL/" target="_blank" style="color:white;">Civil
            Engineering<br />
            </a> </h5>
</p></div>
<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<p><a href="#" target="_blank"><img alt="Robotics and Automation" src="images/Artboard1.png" /></a></p>
<h5 class="text-center"> <a href="#" target="_blank" style="color:white;">Robotics and Automation<br/>         
            </a> </h5>
</p></div>
<div class="col-xs-6 col-sm-12 col-md-3 mt-2">
<p><a href="#" target="_blank"><img src="images/it.png" alt="Engineering Admission" /></a></p>
<h5 class="text-center"><a href="#" target="_blank" style="color:white;">M.Tech </a></h5>
</p></div>
</p></div>
</p></div>
</p></div>
</section>
<section class="ftco-intro mt-5 py-2 mb-3" data-stellar-background-ratio="0.5" style="background-position: 50% -138.033px;">
<div class="overlay bg_Color"></div>
<div class="container-fulid">
<div class="row">
<div class="col-md-9 ml-5 pt-4">
<h2>Photos</h2>
</p></div>
<div class="col-md-2 pt-4 d-flex justify-content-center align-items-center">
<p class="mb-0"><a href="http://mzcet.in/photogallery.php" target="_blank" class="btn btn-secondary px-4 py-2" style="background-color: #05668c;">View</a></p>
</p></div>
</p></div>
</p></div>
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
<li>Accredited by NBA.</li>
<li>50 +Industrial Tie-ups.</li>
<li>14 Center of Excellence.</li>
<li>National Level Technical Symposium “MITILENCE” conducted on 2nd week of February, Every Year.</li>
<li>SCIMIT – a Mega Science Project Exhibition on 28th of February every year, as National Science Day celebration.</li>
<li>Only college in Puducherry to conducts ICSCAN – IEEE International Conference every year.</li>
</ul></div>
</p></div>
</p></div>
<div class="col-md-4 col-xs-12 d-flex services align-self-stretch p-3 ftco-animate fadeInUp ftco-animated">
<div class="media block-6 d-block">
<div class="icon d-flex justify-content-center align-items-center text-center"> <span class=""><img src="images/campus.png" alt="Engineering Admission" class="iconimg"></span> </div>
<div class="media-body p-2 mt-2">
<h3 class="heading text-center">Campus</h3>
<ul>
<li>Located in 60 acre Integrated Campus.</li>
<li>Hi-tech labs with 100 mbps hi-speed internet connection and free WIFI access.</li>
<li>500 KW Solar powered green campus.</li>
<li>Ultra-modern fitness center.</li>
<li>Air conditioned auditorium which can accommodate 1000 students.</li>
<li>24-hour ATM facility inside the college campus.</li>
</ul></div>
</p></div>
</p></div>
<div class="col-md-4 col-xs-12 d-flex services align-self-stretch p-3 ftco-animate fadeInUp ftco-animated">
<div class="media block-6 d-block">
<div class="icon d-flex justify-content-center align-items-center text-center"> <span class=""><img alt="Engineering Admission" src="images/university.png" class="iconimg"></span> </div>
<div class="media-body p-2 mt-2">
<h3 class="heading text-center">Achievement</h3>
<ul>
<li>Winner of SMART INDIA HACKATHON 2019 held at IIT, Kanpur 2019.</li>
<li>Winner of NDRF Competition by IEI India 2019.</li>
<li>Winner of ZOHO Cliq Trix 2018.</li>
<li>SALESFORCE 2018 – Outstanding Contributor &#038; Academic Partner Award.</li>
<li>Winner of TOP 5 “TATA Cruciable 2018”.</li>
<li>Winner of Puducherry YOUTH ICON Award 2017 Conducted by ICT Academy.</li>
<li>Winner of VIRTUSA NeuralHack 2017.</li>
<li>TOP 5 Winner of Testimony 2016 conducted by TCS.</li>
</ul></div>
</p></div>
</p></div>
</p></div>
</p></div>
</section>
<section class="ftco-intro">
<div class="overlay newcolor"></div>
<div class="container">
<div class="row">
<div class="col-md-9">
<h2>Study Abroad</h2>
<p class="mb-0">The main motto of this service is to deliver precise counselling and consistent assistance to aspiring students and professionals who has striving urge for their education at leading universities and colleges in overseas.</p>
</p></div>
<div class="col-md-3 d-flex align-items-center">
<p class="mb-0"><a href="#" target="_blank" class="btn btn-secondary px-4 py-3">Study Abroad</a></p>
</p></div>
</p></div>
</p></div>
</section>
<section class="ftco-section ftco-no-pt ftc-no-pb">
<div class="container">
<div class="col-md-12 text-center heading-section ftco-animate"> <span class="subheading"></span></p>
<h2 class="mt-4">Our Top Recruiters</h2>
</p></div>
<div class="row no-gutters">
<div class="col-md-12 wrap-about ftco-animate">
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img src="images/6.webp" alt="Engineering Admission" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img src="images/16.webp" class="img" alt="Engineering Admission"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/8.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/18.webp" class="img"> </span></div>
</p></div>
</p></div>
</p></div>
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/5.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/10.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/7.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/2.webp" class="img"> </span></div>
</p></div>
</p></div>
</p></div>
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/12.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/13.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/14.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/15.webp" class="img"> </span></div>
</p></div>
</p></div>
</p></div>
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/3.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/4.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/9.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/11.webp" class="img"> </span></div>
</p></div>
</p></div>
</p></div>
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/17.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/1.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/19.webp" class="img"> </span></div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
<div class="services-2 d-flex">
<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span><img alt="Engineering Admission" src="images/20.webp" class="img"> </span></div>
</p></div>
</p></div>
</p></div>
</p></div>
</p></div>
</p></div>
</section>
<section class="ftco-intro" data-stellar-background-ratio="0.5">
<div class="overlay"></div>
<div class="container">
<div class="row">
<div class="col-md-9">
<h2>Online Courses</h2>
<p class="mb-0"> We are training partners of online certificate courses. Python,C,C++ and Java online training provided by eProgram.</p>
</p></div>
<div class="col-md-3 d-flex align-items-center">
<p class="mb-0"><a href="#" target="_blank" class="btn btn-secondary px-4 py-3">eProgram.in</a></p>
</p></div>
</p></div>
</p></div>
</section>
<section class="ftco-section">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-9 text-center heading-section ftco-animate"> <span class="subheading"></span></p>
<h2 class="mb-4">Students Innovative Projects</h2>
<p>We are encouraging our students to learn and play a innovate ideas. Our students are demonstrating their project skills in the every semester. </p>
</p></div>
<div class="col-md-3 d-flex align-items-center">
<p class="mb-0"><a href="#" target="_blank" class="btn btn-secondary px-4 py-3">Technical Events</a></p>
</p></div>
</p></div>
</p></div>
</section>
<section class="bg-light ftco-section">
<div class="container">
<div class="text-center heading-section ftco-animate"> <span class="subheading"></span></p>
<h2 class="mb-0">Campus Facilities</h2>
</p></div>
<div class="row justify-content-center align-items-center text-center">
<div class="row ml-4 mr-4 justify-content-center align-items-center text-center">
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img src="images/library.png" class="imgf img-align" alt="Engineering Admission"></span> </div>
<div class="Fac_Title"><b>Library</b></div>
<div class="Fac_Title">Collection of 21464 books, in different subjects</div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img src="images/nss.png" class="imgf img-align" alt="Engineering Admission"></span> </div>
<div class="Fac_Title"><b>NSS</b></div>
<div class="Fac_Title">Organizing Blood donation Camp, every year</div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/hostel.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>Hostel</b></div>
<div class="Fac_Title">Separately for boys and girls with well furnished suite</div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/onlinepayments.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>Online Payment</b></div>
<div class="Fac_Title">Easy to make payment, pay student fees Online</div>
</p></div>
</p></div>
</p></div>
<div class="row ml-4 mr-4 justify-content-center align-items-center text-center">
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/Canteen.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>Canteen</b></div>
<div class="Fac_Title">Hygienic veg. and non Veg. foods and snacks with excellent quality</div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/Transports.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>Transports</b></div>
<div class="Fac_Title">From Puducherry, Cuddalore, Villupuram, Neyveli and Tindivanam</div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/sports.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>Sports</b></div>
<div class="Fac_Title">Sports facilities with indoor and outdoor games</div>
</p></div>
</p></div>
<div class="col-lg-3 col-md-3 col-sm-3 pt-4 col-xs-6 d-flex justify-content-center align-items-center text-center">
<div class="py-1">
<div class="justify-content-center align-items-center"> <span><img alt="Engineering Admission" src="images/atm.png" class="imgf img-align"></span> </div>
<div class="Fac_Title"><b>ATM</b></div>
<div class="Fac_Title">24-hour ATM facility inside the college campus</div>
</p></div>
</p></div>
</p></div>
</p></div>
</p></div>
</section>
<section class="ftco-section ftco-no-pt ftc-no-pb">
<div class="container">
<div class="col-md-12 text-center heading-section ftco-animate"> <span class="subheading"></span></p>
<h2 class="mb-2">Stay Connected</h2>
</p></div>
<div class="row no-gutters">
<div class="col-md-12 wrap-about ftco-animate">
<div class="row list-unstyled">
<ul class="ftco-footer-social list-unstyled float-md-left float-lft">
<li class="ftco-animate"><a href="#" target="_blank"><span><img alt="Engineering Admission" src="images/photo.png" alt="photo"></span></a></li>
<li class="ftco-animate"><a href="https://www.facebook.com/MountZionCET" target="_blank"><span><img alt="Engineering Admission" src="images/connect_facebook.png" alt="connect_facebook"></span></a></li>
<li class="ftco-animate"><a href="#" target="_blank"><span><img alt="Engineering Admission" src="images/youtube1.png" alt="Youtube"></span></a></li>
<li class="ftco-animate"><a href="#" target="_blank"><span><img alt="Engineering Admission" src="images/twitter1.png" alt="twitter"></span></a></li>
<li class="ftco-animate"><a href="https://www.instagram.com/mzcet.in/" target="_blank"><span><img alt="Engineering Admission" src="images/INSTA.png" alt="insta"></span></a></li>
<li class="ftco-animate"><a href="https://api.whatsapp.com/send?phone=917373344444&text=Admission%20Enquiry" target="_blank"><span><img alt="Engineering Admission" src="images/whatsapp.png" alt="whatsapp"></span></a></li>
<li class="ftco-animate fadeInUp ftco-animated"><a href="https://goo.gl/maps/Ji9a6K2pNirzfLt78" target="_blank"><span><img src="images/location.jpg" class="img-broder"></span></a></li>
</ul></div>
</p></div>
</p></div>
</p></div>
</section>
<p><script src="js/jquery.min.js"></script>
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
<script type="text/javascript">	$(window).on('load',function(){$("#myModal").modal('show');}); $('#myModal').modal({backdrop: 'static'})</script></p>
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
					© Copyright 2020 by <a href="http://www.mzcet.in/">MZCET</a>				</div><!-- .copyright -->
			
			 

  
    			
		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<a href="#page" class="scrollup" id="btn-scrollup"><i class="fa fa-angle-up"></i></a></body>
</html>