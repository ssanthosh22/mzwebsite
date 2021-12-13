<?php
include 'connection.php';
if(isset($_POST['login']))
{
  $name=$_POST['loginid'];
  $key=md5($_POST['password']);
  $type = $_POST['type'];
  if($type == 1){
  $log=mysqli_query($con,"SELECT * FROM alumni WHERE login='" .$name ."' AND password='" .$key ."'") or die(mysqli_error($con));    
  }
  if($type == 2){
  $log=mysqli_query($con,"SELECT * FROM user WHERE username='" .$name ."' AND password='" .$key ."'") or die(mysqli_error($con));    
  }
  $num=mysqli_fetch_array($log);
  if($num>0)
  {
    $_SESSION['id']=$num['id'];
    if($type == 1){
    $_SESSION['name']=$num['login'];
  }
    if($type == 2){
    $_SESSION['name']=$num['username'];
  }
    $_SESSION['type']=$type;
    header('location: login.php');
  }
  else 
  {
    echo '<script> alert("Incorrect Username/ Password")</script>';
}
}
if(isset($_POST['submit']))
{
  $query = mysqli_query($con,"INSERT INTO `alumni`(`name`, `spr`, `gender`, `dob`, `year`, `regno`, `course`, `fname`, `mname`, `fcontact`, `mcontact`, `email`, `fb`, `email2`, `contact`, `address`, `city`, `state`, `country`, `login`, `password`) VALUES ('".$_POST['name']."','".$_POST['spr']."','".$_POST['gender']."','".$_POST['dob']."','".$_POST['year']."','".$_POST['reg']."','".$_POST['course']."','".$_POST['fname']."','".$_POST['mname']."','".$_POST['fcontact']."','".$_POST['mcontact']."','".$_POST['email']."','".$_POST['fb']."','".$_POST['email2']."','".$_POST['mobile']."','".$_POST['address']."','".$_POST['city']."','".$_POST['state']."','".$_POST['country']."','".$_POST['loginid']."','student')") or die(mysqli_error($con));

    echo '<script> alert("New Alumni Added!!")</script>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>MZ Alumini Portal</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">


  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/dataTables.bootstrap.min.css"> 



  <link href="assets/css/style.css" rel="stylesheet">

<style type="text/css">
  .paginate_button{
  display: inline !important;
padding: 5px 10px !important;
border: 1px solid !important;
margin: 1%;
}
</style>
</head>

<body>


  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container">
      <div class="header-container d-flex align-items-center">
        <div class="logo mr-auto">
          <h1 class="text-light"><a href="index.html"><img src="logo.png"/><span>MZ Alumni Portal</span></a></h1>

        </div>

        <nav class="nav-menu d-none d-lg-block">
          <ul>
            <li class="active"><a href="index.php#header">Home</a></li>
            <li><a href="index.php#about">About</a></li>
            <li><a href="index.php#cta">Activities</a></li>
            <li><a href="index.php#portfolio">Gallery</a></li>
            <li><a href="index.php#testimonials">Testimonials</a></li>

            <li><a href="#contact">Contact</a></li>
            <?php
            if(!isset($_SESSION['id']))
            { ?>
              <li class="get-started"><a href="#0">Login</a></li>
              <?php } else{
              ?>
              <li><a href="#0"><?=$_SESSION['name']?></a></li>
              <li><a href="logout.php">Logout</a></li>
              <?php }
              ?>
            </ul>
          </nav>
        </div>
      </div>
    </header>

    <?php
if(!isset($_SESSION['id']))
{
?>
    <section id="contact" class="contact">
      <div style="height: 60px;">
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-6" data-aos="fade-right">
            <div class="section-title">
              <h2>Alumni Portal</h2>
              <p> <strong>Stay Connect</strong></p>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100" style="min-height: 200px;"><div class="section-title">
            <h2>Login</h2>
          </div>
          <form action="" method="post" class="php-email-form mt-4">
            <div class="form-row">
              <div class="col-md-12 form-group">
                <input type="text" class="form-control" name="loginid" placeholder="Your Login Id" required autocomplete="off" />
              </div>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="password" id="subject" placeholder="Your Password" required />
            </div>
            <div class="form-group">
              <select class="form-control" name="type" required>
                <option value="">-- Select Type --</option>
                <option value="1">Student</option>
                <option value="2">Staff</option>
              </select>

            </div>
            <div class="mb-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div>
            </div>
            <div class="text-center"><button type="submit" name="login">Login</button></div>
          </form>
        </div>
      </div>

    </div>
  </section>

<?php }
else{
  if($_SESSION['type'] == 2){?>

    <section id="contact" class="contact">
      <div style="height: 60px;">
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-12" data-aos="fade-right">
            <div class="section-title">
              <h2>Add New Alumini</h2>
            </div>

          <form action="" method="post" class="php-email-form mt-4">
            <div class="form-row">
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="name" placeholder="Name" required autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="loginid" placeholder="Login Id" required autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="spr" placeholder="SPR No" required autocomplete="off" />
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4 form-group">
                <select name="gender" required class="form-control">
                  <option value="">-- SELECT GENDER --</option>
                  <option value="M">Male</option>
                  <option value="F">Fe-Male</option>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="dob" placeholder="DOB" required autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="year" placeholder="Year" required autocomplete="off" />
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="reg" placeholder="Reg No" required autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="course" placeholder="Course" required autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="fname" placeholder="Father's Name" required autocomplete="off" />
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="fcontact" placeholder="Father's Contact" required autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="mname" placeholder="Mother's Name" required autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="mcontact" placeholder="Mother's Contact" autocomplete="off" />
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4 form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="email" class="form-control" name="email2" placeholder="Secondary Email" autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="fb" placeholder="Facebook" autocomplete="off" />
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="mobile" placeholder="Mobile" required autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="address" placeholder="Address" required autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="city" placeholder="City" required autocomplete="off" />
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="state" placeholder="State" required autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="country" placeholder="Country" autocomplete="off" />
              </div>
              <div class="col-md-4 form-group">
                <button type="submit" name="submit">Add New Alumni</button>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </section>
<?php  }
  ?>

    <section id="contact" class="contact">
      <div style="height: 60px;">
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-12" data-aos="fade-right">
            <div class="section-title">
              <h2>Alumni Info</h2>
            </div>

          <div class="table-responsive">
<table id="myTable" class="table">
  <thead><tr>
<th>Sno</th>
<th>name</th>
<th> SPR No</th>
<th> Gender</th>
<th> DOB</th>
<th> year</th>
<th> Reg no</th>
<th> course</th>
<th> Father's Name</th>
<th> Mother's Name</th>
<th> Father's contact</th>
<th> Mother's contact</th>
<th> Email</th>
<th> fb</th>
<th> Secondary Email</th>
<th> Mobile</th>
<th> Address</th>
<th> City</th>
<th> State</th>
<th> Country</th>
  </tr>
</thead>
  <tbody>
    <?php
    $count=1;
    $qu = mysqli_query($con, "SELECT * FROM `alumni`") or die(mysqli_error($con));
    while($row = mysqli_fetch_array($qu)){
    ?><tr>
    
<td><?=$count?></td>
<td><?=$row['name']?></td>
<td><?=$row['spr']?></td>
<td><?=$row['gender']?></td>
<td><?=$row['dob']?></td>
<td><?=$row['year']?></td>
<td><?=$row['regno']?></td>
<td><?=$row['course']?></td>
<td><?=$row['fname']?></td>
<td><?=$row['mname']?></td>
<td><?=$row['fcontact']?></td>
<td><?=$row['mcontact']?></td>
<td><?=$row['email']?></td>
<td><?=$row['fb']?></td>
<td><?=$row['email2']?></td>
<td><?=$row['contact']?></td>
<td><?=$row['address']?></td>
<td><?=$row['city']?></td>
<td><?=$row['state']?></td>
<td><?=$row['country']?></td>
  </tr>
<?php 
$count++;
}
?>
</tbody>
</table>
</div>
          </div>
      </div>

    </div>
  </section>
<?php }
?>

</main>


<footer id="footer">


  <div class="container d-md-flex py-4">

    <div class="mr-md-auto text-center text-md-left">
      <div class="copyright">
        &copy; Copyright <strong><span>MZCET</span></strong>. All Rights Reserved
      </div>
      <div class="credits">

        Designed by <a href="http://www.mzcet.in/default.php" target="_blank">MZCET</a>
      </div>
    </div>
    <div class="social-links text-center text-md-right pt-3 pt-md-0">
      <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
      <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
      <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
      <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
      <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
    </div>
  </div>
</footer>

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->
<script src="assets/vendor/counterup/counterup.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<!-- <script src="assets/vendor/venobox/venobox.min.js"></script> -->
<script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>

<script src="assets/js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
    $('#myTable').DataTable();
} );
        $('#myTable').DataTable( {
    select: {
        style: 'single'
    }
} );
    </script>
</body>

</html>