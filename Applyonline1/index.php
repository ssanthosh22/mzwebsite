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
$dob="";
$gender="";
$country="";
$district="";
$address="";
$phy="";
$chem="";
$math="";
$tot="";
$regno="";
$school="";
$community="";
$course="";
$response="";


if (isset($_POST['name'])&&isset($_POST['email'])&&isset($_POST['mobile'])&&isset($_POST['district'])&&isset($_POST['address']) && isset($_POST['course']))
{
$name=$_POST['name'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$gender=$_POST['gender'];
$dob=$_POST['dates'];
$district=$_POST['district'];
$address=$_POST['address'];
$phy=$_POST['phy'];
$chem=$_POST['chem'];
$math=$_POST['math'];
$tot=$_POST['total'];
$regno=$_POST['regno'];
$school=$_POST['school'];
$community=$_POST['community'];
$course=$_POST['course'];


//if($name!="" && $name!="0" && $email!="" && $email!="0" && $mobile!="" && $mobile!="0" && $dob!="" && $dob!="0" && $gender!="" && $gender!="0" && $country!="" && $country!="0" && $district!="" && $district!="0" && $address!="" && $address!="0" && $phy!="" && $phy!="0" && $chem!="" && $chem!="0" && $math!="" && $math!="0" && $tot!="" && $tot!="0" && $regno!="" && $regno!="0" && $school!="" && $school!="0" && $community!="" && $community!="0" && $course!="" && $course!="0")
	if($name!="" && $name!="0" && $email!="" && $email!="0" && $mobile!="" && $mobile!="0" && $course!="" && $course!="0" && $district!="" && $district!="0" && $address!="" && $address!="0")
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
$sql = "insert into directadmenquiry(`name`, `email`, `mobile`, `gender`, `address`, `district`, `country`, `phy`, `chem`, `math`, `tot`, `regno`, `school`, `community`, `course`, `dob`, `cdatetime`, `active`) values ('".$name."','".$email."','".$mobile."','".$gender."','".$address."','".$district."','".$country."','".$phy."','".$chem."','".$math."','".$tot."','".$regno."','".$school."','".$community."','".$course."','".$dob."',now(),'1')";
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

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <meta charset="UTF-8">
   
    <title>Mount Zion College of Engineering and Technology | Apply Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="Engineering College Admissions, Computer Science And Engineering, Electronics And Communication Engineering, Electrical And Electronics Engineering, Mechanical Engineering, Civil Engineering, UG, PG, Engineering Degree, AICTE, NAAC, NBA, BE, ME, Anna University, Engineering Degree, Mount Zion, MZCET, Mount Zion CET, Admissions">
<meta name="description" content="Approved by AICTE, Affiliated to Anna University and Accredited by NAAC with ‘B++’ grade , Recognised by UGC under section 2(f) & 12(B) of the UGC Act, 1956.">
   <!-- Global site tag (gtag.js) - Google Analytics -->


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
   
 <!--Google adv end-->
    
   <!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/montserrat-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- Main Style Css -->
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
	<style>
	  input[type="date"]:before {
    content: attr(placeholder) !important;
    color: #aaa;
    margin-right: 0.5em;
  }
  input[type="date"]:focus:before,
  input[type="date"]:valid:before {
    content: "";
  }
  

	</style>
	
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
jQuery( document ).ready(function($){
	$('myform').on('submit', function(){
		gtag_report_conversion('http://www.mzcet.in/Applyonline/index.php');
	});
});
</script>
<script src="https://www.google.com/recaptcha/api.js"></script>

</head>
<body class="form-v10">
    
	<div class="page-content">
		<div class="form-v10-content">
		<img src="admission2020.jpg" alt="" style="width: 80%;margin-left: 10%;margin-right: 10%;" />
			<form class="form-detail" action="index.php" method="post" id="myform">
			
				<div class="form-left">
					<h2>General Infomation</h2>
					
					
					<div class="form-row">
						<input type="text" name="name" class="input-text" id="name" placeholder="Name*" value="<?php (isset($_POST['name'])!="" ? $_POST['name'] : "");?>" required>
					</div>
					<div class="form-row">
							<input type="text" name="mobile" class="input-text" id="phone" pattern="[0-9]{10}" placeholder="Mobile Number*" value="<?php (isset($_POST['mobile'])!="" ? $_POST['mobile'] : "");?>" required>
					</div>
					<div class="form-row">
						<input type="text" name="email" id="your_email" class="input-text" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" value="<?php (isset($_POST['email'])!="" ? $_POST['email'] : "");?>" placeholder="Email Id*">
					</div>
					<div class="form-row">
						<input type="date" name="dates" class="input-text" id="dates" placeholder="Date of Birth" value="<?php (isset($_POST['dates'])!="" ? $_POST['dates'] : "");?>">
					</div>	
					<div class="form-row">
						<select id="gender" name="gender" >
						    <option class="option" value="">Select Gender</option>
						    <option class="option" value="1">Male</option>
						    <option class="option" value="2">Female</option>
						    <option class="option" value="3">Prefer Not to Say</option>
						</select>
						<span class="select-btn">
						  	<i class="zmdi zmdi-chevron-down"></i>
						</span>
					</div>
					
					<div class="form-row">
						<select name="course" required>
						    <option class="option" value="">Select Course*</option>
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
						<span class="select-btn">
						  	<i class="zmdi zmdi-chevron-down"></i>
						</span>
					</div>
			
					
					<div class="form-row">
						<select name="district" required>
						    <option class="option" value="">Select District*</option>
							<option class="option" value="999">Others</option>
						   <option class="option" value="1">ARIYALUR</option>
<option class="option" value="2">CHENNAI</option>
<option class="option" value="3">COIMBATORE</option>
<option class="option" value="4">CUDDALORE</option>
<option class="option" value="5">DHARMAPURI</option>
<option class="option" value="6">DINDIGUL</option>
<option class="option" value="7">ERODE</option>
<option class="option" value="8">KANCHIPURAM</option>
<option class="option" value="9">KANYAKUMARI</option>
<option class="option" value="10">KARUR</option>
<option class="option" value="11">KRISHNAGIRI</option>
<option class="option" value="12">MADURAI</option>
<option class="option" value="13">NAGAPATTINAM</option>
<option class="option" value="14">NAMAKKAL</option>
<option class="option" value="15">NILGIRIS</option>
<option class="option" value="16">PERAMBALUR</option>
<option class="option" value="17">PUDUKKOTTAI</option>
<option class="option" value="18">RAMANATHAPURAM</option>
<option class="option" value="19">SALEM</option>
<option class="option" value="20">SIVAGANGA</option>
<option class="option" value="21">THANJAVUR</option>
<option class="option" value="22">THENI</option>
<option class="option" value="23">TIRUCHIRAPPALLI</option>
<option class="option" value="24">TIRUNELVELI</option>
<option class="option" value="25">TIRUVALLUR</option>
<option class="option" value="26">TIRUVANNAMALAI</option>
<option class="option" value="27">TIRUVARUR</option>
<option class="option" value="28">TUTICORIN</option>
<option class="option" value="29">VELLORE</option>
<option class="option" value="30">VILLUPURAM</option>
<option class="option" value="31">VIRUDHUNAGAR</option>
<option class="option" value="611">TIRUPUR</option>

						</select>
						<span class="select-btn">
						  	<i class="zmdi zmdi-chevron-down"></i>
						</span>
					</div>
										
					<div class="form-row">
						<textarea name="address" class="input-text" id="address" placeholder="Address*" rows="5" required="" value="<?php (isset($_POST['address'])!="" ? $_POST['address'] : "");?>" style="width:-webkit-fill-available;"></textarea>
					</div>
					
					
							</div>
				<div class="form-right">
					<h2>Academic Information</h2>
					<div class="form-group">
						<div class="form-row form-row-1">
							<input type="number" name="phy" id="phy" class="input-text" placeholder="Physics Mark / 100" min="35" max="100" value="<?php (isset($_POST['phy'])!="" ? $_POST['phy'] : "");?>" >
						</div>
						<div class="form-row form-row-2">
							<input type="number" name="chem" id="chem" class="input-text" placeholder="Chemistry Mark / 100" min="35" max="100" value="<?php (isset($_POST['chem'])!="" ? $_POST['chem'] : "");?>" >
						</div>
					</div>
					<div class="form-group">
						<div class="form-row form-row-1">
							<input type="number" name="math" id="math" class="input-text" placeholder="Maths Mark  / 100" min="35" max="100" value="<?php (isset($_POST['math'])!="" ? $_POST['math'] : "");?>" >
						</div>
						<div class="form-row form-row-2">
							<input type="number" name="total" id="total" class="input-text" placeholder="Total Mark / 600" min="200" max="600" value="<?php (isset($_POST['total'])!="" ? $_POST['total'] : "");?>" >
						</div>
					</div>
					<div class="form-row">
						<input type="text" name="regno" class="input-text" id="regno" placeholder="Register Number" value="<?php (isset($_POST['regno'])!="" ? $_POST['regno'] : "");?>" >
					</div>	
					<div class="form-row">
						<input type="text" name="school" class="input-text" id="school" placeholder="School Name" value="<?php (isset($_POST['school'])!="" ? $_POST['school'] : "");?>" >
					</div>	
					<div class="form-row">
						<select name="community" >
						    <option class="option" value="">Select Community</option>
							<option class="option" value="999">Others</option>
						    <option class="option" value="1">BC</option>
<option class="option" value="2">MBC</option>
<option class="option" value="3">OC</option>
<option class="option" value="4">SC</option>
<option class="option" value="5">ST</option>
<option class="option" value="6">FC</option>
<option class="option" value="7">DNC</option>
<option class="option" value="8">SC (ARUNTHATHIYAR)</option>
<option class="option" value="9">BC (MUSLIMS)</option>
						</select>
						<span class="select-btn">
						  	<i class="zmdi zmdi-chevron-down"></i>
						</span>
					</div>
					
					<div class="form-row" style="text-align: -webkit-center;">
<span class="msg-error error" style="
    color: white;"></span><br />
<div id="recaptcha" class="g-recaptcha" data-sitekey="6LdzK6oZAAAAACV_ck85Q42IUxBFAJzJ-jKPXoaY"></div>
</div>
					
					<div class="form-row-last">
					<input type="submit" name="submit" id="btn-validate"  class="register" value="submit">
					
					</div>

				</div>
			</form>
		</div>
	</div>
	
</body>
</html>
