<?php 
error_reporting(0);
$db_host = "localhost";
$db_user = "mzcetin1_admissions";
$db_pass = "zion@3908";
$db_name = "mzcetin1_mdir";

$con =  mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(mysqli_connect_error()){
  echo 'connect to database failed';
}
?>


<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Mount zion College </title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- External Css -->
  <link rel="stylesheet" href="assets/css/line-awesome.min.css">

  <!-- Custom Css --> 
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/theme-1.css">

  <!-- Fonts -->
  <link href="assets/css2.css?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

  <!-- Favicon -->
  <link rel="icon" href="images/favicon.png">
  <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="images/icon-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="images/icon-114x114.png">
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="style.css">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>

  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
</script>

  <script src="http://code.jquery.com/jquery-1.7.2.js"></script>


  <style>
  
  .banner_images{
      width: 100%;
      height:600px;
      object-fit: fill;
  }
  
  @media only screen and (max-width: 768px) {
      .banner_images{
          height: 300px;
      }
      
  }
  
    * {box-sizing: border-box;}

    img {vertical-align: middle;}

    /* Slideshow container */
    .slideshow-container {
      max-width: 100%;
      position: relative;

      margin: auto;
    }

    /* Caption text */
    .text {
      color: #f2f2f2;
      font-size: 15px;
      padding: 8px 12px;
      position: absolute;
      bottom: 8px;
      width: 100%;
      text-align: center;
    }

    /* Number text (1/3 etc) */
    .numbertext {
      color: #f2f2f2;
      font-size: 12px;
      padding: 8px 12px;
      position: absolute;
      top: 0;
    }

    /* The dots/bullets/indicators */
    .dot {
      height: 15px;
      width: 15px;
      margin: 0 2px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.6s ease;
    }

    .active {
      background-color: #717171;
    }

    /* Fading animation */
    .fade {
      -webkit-animation-name: fade;
      -webkit-animation-duration: 1.5s;
      animation-name: fade;
      animation-duration: 1.5s;
    }

    @-webkit-keyframes fade {
      from {opacity: .4} 
      to {opacity: 1}
    }

    @keyframes fade {
      from {opacity: .4} 
      to {opacity: 1}
    }

    /* On smaller screens, decrease text size */
    @media only screen and (max-width: 300px) {
      .text {font-size: 11px}
    }
  </style>

</head>






<body>



  <div class="ugf-main-wrap ugf-bg">

   <div class="slideshow-container">

  <?php 
                      $query2=mysqli_query($con,"SELECT * from banner order by id desc limit 3");
                      while($row1=mysqli_fetch_array($query2))  
                      {


                        ?>




    <div class="mySlides fade">
      
      <img src="images/<?php echo $row1['banner_image'];?>" class="banner_images">

    </div>
    <?php
  }
  ?>

  </div>
  <br>

  <div style="text-align:center">
    <span class="dot"></span> 
    <span class="dot"></span> 
    <span class="dot"></span> 
  </div>

  <script>
    var slideIndex = 0;
    showSlides();

    function showSlides() {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
      }
      slideIndex++;
      if (slideIndex > slides.length) {slideIndex = 1}    
        for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}
</script>


      <div class="col">
        <div class="ugf-container">
          <div class="content-wrap">


  <div class="ugf-form-block-header">
    <h1>Personal Details</h1>

  </div>

  <div class="ugf-input-block">
    <form  method="post">
      <div class="form-group">
        <input type="name" class="form-control" id="inputText" placeholder="Full Name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required name="f_name">
      </div>
      <div class="form-group">

        <input type="email" class="form-control" id="inputMail1" placeholder="Email Address (optional)" name="email" >
      </div>





      <div class="form-group pass-block">
        <input type="text" class="form-control" id="inputPass" placeholder="Mobile Number"  onkeypress='return event.charCode >= 48 && event.charCode <= 57' minlength="10" maxlength="10"  required name="mobile">
      </div>


      <div class="form-group ">


        <select class="form-control" name="group" required >
          <option value="" selected hidden  disabled>Select  12th Studied Group</option>
          <option value="arts">Arts</option>
          <option value="science">Science</option>





        </select> 

      </div>




      <div class="form-group">
        <select class="form-control" name="district" required>
          <option value="" selected hidden Disabled >District </option>
          <option value="Ariyalur">Ariyalur</option>
          <option value="Chengalpattu">Chengalpattu</option>
          <option value="Chennai">Chennai</option>
          <option value="Coimbatore">Coimbatore</option>
          <option value="Cuddalore">Cuddalore</option>
          <option value="Dharmapuri">Dharmapuri</option>
          <option value="Dindigul">Dindigul</option>
          <option value="Erode">Erode</option>
          <option value="Kallakurichi">Kallakurichi</option>
          <option value="Kanchipuram">Kanchipuram</option>
          <option value="Kanyakumari">Kanyakumari</option>
          <option value="Karur">Karur</option>
          <option value="Krishnagiri">Krishnagiri</option>
          <option value="Madurai">Madurai</option>
          <option value="Nagapattinam">Nagapattinam</option>
          <option value="Namakkal">Namakkal</option>
          <option value="Nilgiris">Nilgiris</option>
          <option value="Perambalur">Perambalur</option>
          <option value="Pudukkottai">Pudukkottai</option>
          <option value="Ramanathapuram">Ramanathapuram</option>
          <option value="Ranipet">Ranipet</option>
          <option value="Salem">Salem</option>
          <option value="Sivaganga">Sivaganga</option>
          <option value="Tenkasi">Tenkasi</option>
          <option value="Thanjavur">Thanjavur</option>
          <option value="Theni">Theni</option>
          <option value="Thoothukudi">Thoothukudi (Tuticorin)</option>
          <option value="Tiruchirappalli">Tiruchirappalli</option>
          <option value="Tirunelveli">Tirunelveli</option>
          <option value="Tirupathur">Tirupathur</option>
          <option value="Tiruppur">Tiruppur</option>
          <option value="Tiruvallur">Tiruvallur</option>
          <option value="Tiruvannamalai">Tiruvannamalai</option>
          <option value="Tiruvarur">Tiruvarur</option>
          <option value="Vellore">Vellore</option>
          <option value="Viluppuram">Viluppuram</option>
          <option value="Virudhunagar">Virudhunagar</option>



        </select>
      </div>






      
      <div class="form-group ">


        <select class="form-control" name="intrest" required>
          <option value="" selected hidden Disabled > Intrested Courses</option>
          <option value="B.E (Civil Engineering)">B.E (Civil Engineering)</option>
          <option value="B.E (Computer Science and Engineering)">B.E (Computer Science and Engineering)</option>
          <option value=">B.E (Electrical and Electronics Engineering )">B.E (Electrical and Electronics Engineering )</option>
          <option value=">B.E (Electronics and Communication Engineering)">B.E (Electronics and Communication Engineering)</option>
          <option value="B.E (Mechanical Engineering)">B.E (Mechanical Engineering)</option>
          <option value="M.E (Computer Science and Engineering)">M.E (Computer Science and Engineering)</option>
          <option value="M.E (Communcation System)">M.E (Communcation System)</option>
          <option value="M.E (Power Electronics)">M.E (Power Electronics)</option>
          <option value="M.E (Structural Engineering)">M.E (Structural Engineering)</option>
          <option value="Ph.D (Computer Science and Engineering)">Ph.D (Computer Science and Engineering)</option>
          <option value="Ph.D (Electronics and Communication Engineering)">Ph.D (Electronics and Communication Engineering)</option>



        </select> 

      </div>

      <button type="submit" class="btn" name="vaccine">Register </button>

    </form>

</div>
</div>
  </div>

</div>

</div>




<script>
  function getAge(dob) { return ~~((new Date()-new Date(dob))/(31556952000)) }
  $("dob").val()
  $('#date').change(function(){
    $('#age').val(getAge($(this).val()));
  });

</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script src="js/custom.js"></script>

</body>
</html>


<?php






if(isset($_POST['vaccine']))
{





 date_default_timezone_set("Asia/Colombo");
 $date=date('Y-m-d');

 $name=$_POST['f_name'];
 $email=$_POST['email'];
 $mobile=$_POST['mobile'];
 $group=$_POST['group'];
 $intrest=$_POST['intrest'];
 $dis=$_POST['district'];


 $characters = '123456789';
 $charactersLength = strlen($characters);
 $randomString = '';
 for ($i = 0; $i < 6; $i++) {
  $randomString .= $characters[rand(0, $charactersLength - 1)];
}
$random_id='MOU'.$randomString;



if(!empty($email))

{
 $insert=mysqli_query($con,"insert into registers (`name`,`email`,`mobile`,`12th_group`,`intrest_department`,`district`,`user_id`,`register_date`) values('$name','$email','$mobile','$group','$intrest','$dis','$random_id','$date')");


 if(!empty($insert))
 {

   echo '<script type="text/javascript">window.alert("Successfully Registered ")</script>';
   echo '<script type="text/javascript">  window.location = "success.php";</script>';

 }
 else{
  echo '<script>alert("Something Went Wrong..Please Try Again");</script>';
}

}



else

{
 $insert=mysqli_query($con,"insert into registers (`name`,`mobile`,`12th_group`,`intrest_department`,`district`,`user_id`,`register_date`) values('$name','$mobile','$group','$intrest','$dis','$random_id','$date')");


 if(!empty($insert))
 {

   echo '<script type="text/javascript">window.alert("Successfully Registered ")</script>';
   echo '<script type="text/javascript">  window.location = "success.php";</script>';

 }
 else{
  echo '<script>alert("Something Went Wrong..Please Try Again");</script>';
}

}




}

?>
