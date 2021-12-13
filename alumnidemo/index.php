<?php
include 'connection.php';
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


  <link href="assets/css/style.css" rel="stylesheet">
<style type="text/css">
  .tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons that are used to open the tab content */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
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
            <li class="active"><a href="#header">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="activities.html" target="_blank">Activities</a></li>
            <li><a href="#portfolio">Gallery</a></li>
            <li><a href="#testimonials">Testimonials</a></li>
			
            <li><a href="#contact">Contact</a></li>
<?php
            if(!isset($_SESSION['id']))
            { ?>
              <li class="get-started"><a href="login.php">Login</a></li>
              <?php } else{
              ?>
              <li><a href="login.php"><?=$_SESSION['name']?></a></li>
              <li><a href="logout.php">Logout</a></li>
              <?php }
              ?>

            
          </ul>
        </nav>
      </div>
    </div>
  </header>

  
  <section id="hero" class="d-flex align-items-center">
    <div class="container text-center position-relative" data-aos="fade-in" data-aos-delay="200">
      <h1>"Connect Today Transform Tomorrow"</h1>
      <h2>Mount Zion College of Engineering and Technology</h2>
      <div style="height: 100px"></div>
	<h5 style="color:white;">Our alumni in various reputed companies around the globe</h5>
  <div style="height: 100px"></div>
    </div>
  </section>

  <main id="main">

  

    <section id="clients" class="clients">
	
      <div class="container">

        <div class="row">

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center" data-aos="zoom-in" data-aos-delay="100">
            <img src="assets/img/clients/client-1.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center" data-aos="zoom-in" data-aos-delay="200">
            <img src="assets/img/clients/client-2.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center" data-aos="zoom-in" data-aos-delay="300">
            <img src="assets/img/clients/client-3.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center" data-aos="zoom-in" data-aos-delay="400">
            <img src="assets/img/clients/client-4.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center" data-aos="zoom-in" data-aos-delay="500">
            <img src="assets/img/clients/client-5.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center" data-aos="zoom-in" data-aos-delay="600">
            <img src="assets/img/clients/client-6.png" class="img-fluid" alt="">
          </div>

        </div>

      </div>
    </section>

   
    <section id="about" class="about">
      <div class="container">

        <div class="row content">
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
            <h2>Alumni Association Objectives</h2>
            <h3 style=" text-align: justify;">Ensuring and facilitating the continual bonding of our alumni is one of the main objectives of our Alumni Association. It brings together a wealth of talented and capable professionals who share their expertise and experience, and brainstorm on the prospective avenues</h3>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0" data-aos="fade-left" data-aos-delay="200">
           
            <ul>
              <li><i class="ri-check-double-line"></i> To provide good interaction between the former students and the college through periodical meetings, project consultancy, placement activities and guest lectures / seminar thereby making the alumni to be a part of developmental activities, taking place in the college.</li>
              <li><i class="ri-check-double-line"></i>To maintain a continuing and life long relationship among the students, faculty and Alma matter.</li>
              <li><i class="ri-check-double-line"></i> To strengthen the cooperation and coordination with industries.</li>
			<li><i class="ri-check-double-line"></i>  To enhance placement opportunities for juniors.</li>
			<li><i class="ri-check-double-line"></i>To organize frequent alumni meets to develop the bonding between Alumni and the institution every year.</li>
			<li><i class="ri-check-double-line"></i>To suggest modifications and up gradation, updating of curriculum to meet the industrial needs.</li>
            </ul>
            
          </div>
        </div>

      </div>
    </section>

 
    <section id="counts" class="counts">
      <div class="container">

        <div class="row counters">

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">2</span>
            <p>Decades</p>
          </div>


          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">12,000</span>
            <p>Alumni</p>
          </div>
             <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">12</span>
            <p>Countries</p>
          </div>

          
          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">130</span>
            <p>Companies</p>
          </div>

        </div>

      </div>
    </section>
<!-- 
      <section id="cta" class="cta">
      <div class="container">

        <div class="text-center" data-aos="zoom-in" style="color:white;">
          <h3>Activities</h3>
<div class="tab">
  <button class="tablinks" onclick="openCity(event, '1')" style="width:50%">2019 Batch</button>
  <button class="tablinks" onclick="openCity(event, '2')"style="width:50%">2020 Batch</button>
</div>

<div id="1" class="tabcontent">
  <table class="table" style="width: 100%; color:#ddd;">
                <tr>
                  <th>S.No</th>
                  <th>Date</th>
                  <th>Name of the Programme</th>
                  <th>Batch</th>
                  <th>Detail of Resource Person</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>09-08-19</td>
                  <td>PLC and Scope of Electrical engineering</td>
                  <td>2008-12 EEE</td>
                  <td>C. Tharariqazis,<br>Lead Engineer Projects, Schneider Electric, Chennai</td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>18-10-19</td>
                  <td>Modern Day Construction Practices</td>
                  <td>2010-14 CIVIL</td>
                  <td>K. Haleeth Raja,<br>Site Executive, Hyundai Const Pvt Ltd, AP</td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>18-10-19</td>
                  <td>Industrial Practices on Construction</td>
                  <td>2010-14 CIVIL</td>
                  <td>P. Mohanraj,<br>Planning Engineer, Hyundai Const Pvt Ltd, AP</td>
                </tr>
                <tr>
                  <td>4.</td>
                  <td>24-10-19</td>
                  <td>Modern Technology</td>
                  <td>2006-10 CSE</td>
                  <td>Joseph Rajan Prince, <br>Senior Statistical Programmer, Pfizer, Chaennai.</td>
                </tr>
                <tr>
                  <td>5.</td>
                  <td>29-10-19</td>
                  <td>How to crack job in Mechanical core industries</td>
                  <td>2006-10 EEE</td>
                  <td>Mrs.Anjelin Diana, <br>Freelance writer, Consultant, Nasadiya Technologies, Author, Amazon Kindle India.</td>
                </tr>
                <tr>
                  <td>6.</td>
                  <td>01-11-19</td>
                  <td>How to crack job in Mechanical core industries</td>
                  <td>2008-12 AERO</td>
                  <td>R. Jeswin Kumar, <br>Senior Design Engineer, SIKA Aerospace & Defence, Bangalore.</td>
                </tr>
                <tr>
                  <td>7.</td>
                  <td>22-3-20</td>
                  <td>Advanced technology in construction work</td>
                  <td>2010-14 CIVIL</td>
                  <td>S.Udhayakumar,<br>ATAT.1 engineering private limited, Singapore</td>
                </tr>
                <tr>
                  <td>8.</td>
                  <td>29-4-20</td>
                  <td>React Js.</td>
                  <td>2012-16 CSE</td>
                  <td>Vipin Paul Software Developer, Bridge connectivity solutions (BCS), Delhi</td>
                </tr>
                <tr>
                  <td>9.</td>
                  <td>8/5/2020</td>
                  <td>Alumni Interaction: A Bird eye view on Automotive.</td>
                  <td>2012-16 ECE</td>
                  <td>A.Siva, <br>Software Engineer, Nexteer Automotive, Bangalore.</td>
                </tr>
                <tr>
                  <td>10.</td>
                  <td>18-5-20</td>
                  <td>Construction of  Windmill Turbine Foundation</td>
                  <td>2010-14 CIVIL</td>
                  <td>S.M. Berose Nickson, <br>Senior Engg, Siemens Gamesa Renewable energy</td>
                </tr>
                <tr>
                  <td>11.</td>
                  <td>18-5-20</td>
                  <td>Analytics in Digital Banking</td>
                  <td>2006-10 CSE</td>
                  <td>S. Kavin, <br>Manager, Standard Chartered GBS, Bangalore</td>
                </tr>
                <tr>
                  <td>12.</td>
                  <td>20-5-20</td>
                  <td>Javascript and Node Js  
                  </td>
                  <td>2010-14 CSE </td>
                  <td>Satheesh Natarajan <br>Full Stack Developer, Kloud9 technologies, Bangalore</td>
                </tr>
                <tr>
                  <td>13.</td>
                  <td>21-5-20</td>
                  <td>C#.Net  
                  </td>
                  <td>2007-11 CSE </td>
                  <td>T. Akshaya,<br>Senior Software Engineer, Scientific Games, Bangalore</td>
                </tr>
                <tr>
                  <td>14.</td>
                  <td>22-5-20</td>
                  <td>Devops  
                  </td>
                  <td>2008-12 CSE </td>
                  <td>S. Maruthupandian, <br>Devops Consultant, Intellect Design Arena Ltd, Chennai</td>
                </tr>
                <tr>
                  <td>15.</td>
                  <td>27-5-20</td>
                  <td>Product Development 
                  </td>
                  <td>2007-11 IT   </td>
                  <td>Allan M W Das, <br>CEO, Hummingtec Pvt Ltd.,Pune.</td>
                </tr>
                <tr>
                  <td>16.</td>
                  <td>27-5-20</td>
                  <td>Openshift 
                  </td>
                  <td>2008-12 CSE  </td>
                  <td>S. Maruthupandian, <br>Devops Consultant, Intellect Design Arena Ltd, Chennai.</td>
                </tr>
                <tr>
                  <td>17.</td>
                  <td>27-5-20</td>
                  <td>Recent Trends in IIoT and AI- 
                  </td>
                  <td>2013-17 ECE </td>
                  <td>S. Rajalakshmi, <br>Team Lead-IoT and AI, EinNel Technologies, Chennai</td>
                </tr>
                <tr>
                  <td>18.</td>
                  <td>27-5-20</td>
                  <td>Freelance Business ideas for Creative people  
                  </td>
                  <td>2006-10 EEE </td>
                  <td>L.Angelin Diana , <br>Free lancer , Nasadiya Technologies, Bangalore</td>
                </tr>
                <tr>
                  <td>19.</td>
                  <td>28-5-20</td>
                  <td>Construction Ethics 
                  </td>
                  <td>2013-17 CIVIL </td>
                  <td>Er. M. Mahendran,<br>Kalyani Builders, Propreietor, Karaikudi.</td>
                </tr>
                <tr>
                  <td>20.</td>
                  <td>28-5-20</td>
                  <td>Ionic Framework 
                  </td>
                  <td>2011-15 CSE </td>
                  <td>V. Samraj,<br>Software Engineer, Aceolution pvt Ltd.,</td>
                </tr>
                <tr>
                  <td>21.</td>
                  <td>29-5-20</td>
                  <td>Deep Dive into Javascript 
                  </td>
                  <td>2012 – 2016 CSE</td>
                  <td>  R.  Manirathnam, <br>Software Engineer, TNQ Technologies, Chennai.</td>
                </tr>
              </table>
</div>

<div id="2" class="tabcontent">
  <table class="table" style="width: 100%; color:#ddd;">
                <tr>
                  <th>S.No</th>
                  <th>Date</th>
                  <th>Name of the Programme</th>
                  <th>Batch</th>
                  <th>Detail of Resource Person</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>2/6/2020</td>
                  <td>Andriod </td>
                  <td>2012 – 2016</td>
                  <td>CSE  G. Raguram, <br>Andriod developer, ipot Technologies, Chennai</td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>3/6/2020</td>
                  <td>Importance of Quality Department in Construction. </td>
                  <td>2010-14 CIVIL</td>
                  <td>M.J Aravinthan, <br>Senior Engineer, Salarpuria Sattva, Banglore.</td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>4/6/2020</td>
                  <td>C# and .NET </td>
                  <td>2012 –16 CSE</td>
                  <td>D. Lalitha, <br>Trainee Programmer, Par3 Software Solutions Pvt Ltd., Chennai,</td>
                </tr>
                <tr>
                  <td>4.</td>
                  <td>5/6/2020</td>
                  <td>Technology used in Automation Industries -  </td>
                  <td>2002-06 ECE</td>
                  <td>K. Annamalai, <br>Delivery Head,Bahwan Cybertek LLC,Oman.</td>
                </tr>
                <tr>
                  <td>5.</td>
                  <td>11/6/2020</td>
                  <td>Webinar on Cyber security,  </td>
                  <td>2012-16 CSE</td>
                  <td>MD. Krishna Sathiya Narayana, <br>Technology Specialist, DELL EMC Corporation, Bangalore.</td>
                </tr>
                <tr>
                  <td>6.</td>
                  <td>12/6/2020</td>
                  <td>Webinar on Bigdata, </td>
                  <td>2010 – 14</td>
                  <td>CSE  Nithin Sreedhar, <br>Senior Software Engineer, Mphasis, Chennai</td>
                </tr>
                <tr>
                  <td>7.</td>
                  <td>15-6-20</td>
                  <td>Application of Building Codes in RCC, </td>
                  <td>2010-14 CIVIL</td>
                  <td>Er.A. Haleeth Raja, <br>Senior Site Engineer, Hyundai Engineering Co, Ltd., Andhra Pradesh.</td>
                </tr>
                <tr>
                  <td>8.</td>
                  <td>24-6-20</td>
                  <td>Automation Testing in Web Applications and Mobile Applications, </td>
                  <td>2008-12 CSE</td>
                  <td>P. Angeleena Elfeda,<br>
                  </tr>
                  <tr>
                    <td>9.</td>
                    <td>29-6-20</td>
                    <td>Alumni Interaction - Construction Technology needs and priorities,  </td>
                    <td>2012-16 CIVIL</td>
                    <td>Er.A.Prabhu, <br>Proprietor, AP Builders, Aranthangi.</td>
                  </tr>
                  <tr>
                    <td>10.</td>
                    <td>30-6-20</td>
                    <td>RPA - Automation Anywhere,  </td>
                    <td>2013-17 CSE</td>
                    <td>Umayal Chidambaram, <br>Salesforce Developer, Thryve Digital, Chennai.</td>
                  </tr>
                  <tr>
                    <td>11.</td>
                    <td>7/7/2020</td>
                    <td>Zend Framework, </td>
                    <td>2013-17 CSE</td>
                    <td>C. Selvameenal, <br>Senior PHP Developer, Raga Designers, Chennai.</td>
                  </tr>
                  <tr>
                    <td>12.</td>
                    <td>15-7-20</td>
                    <td>Digital Transformation in IT Industry,  </td>
                    <td>2001-05 ECE</td>
                    <td>R. Vasudevan, <br>Consultant, HCL Technologies, Chennai.</td>
                  </tr>
                  <tr>
                    <td>13.</td>
                    <td>17-7-20</td>
                    <td>Empowering in the Phase of Transformation,  </td>
                    <td>2007-11 CSE</td>
                    <td>S. Jude Isaac Benjamin, <br>Senior Software Engineer, Legato Health Technologies, Bangalore</td>
                  </tr>
                  <tr>
                    <td>14.</td>
                    <td>22-7-20</td>
                    <td>iOS Development,  </td>
                    <td>2010-14 CSE</td>
                    <td>M. Mohamed Jaleel Nazir, <br>Lead iOS Developer, Glynk, Bangalore.</td>
                  </tr>
                  <tr>
                    <td>15.</td>
                    <td>26-8-20</td>
                    <td>Big Data  </td>
                    <td>2010-14 CSE</td>
                    <td>Nithin Sreedhar, <br>Senior Software Engineer, Mphasis, Chennai</td>
                  </tr>
                  <tr>
                    <td>16.</td>
                    <td>16-10-20</td>
                    <td>Construction Technology</td>
                    <td></td>
                    <td>Ishwarya,</td>
                  </tr>
                  <tr>
                    <td>17.</td>
                    <td>19-10-20</td>
                    <td>3D Modeling </td>
                    <td>2012-16 MECH</td>
                    <td>S. Selvam, 
                    </td>
                  </tr>
                </table>
</div>

              
        </div>

      </div>
    </section>
 -->
  
 
    <section id="portfolio" class="portfolio">
      <div class="container">

        <div class="section-title" data-aos="fade-left">
          <h2>Gallery</h2>
          <p>Sometimes all it takes is a familiar smell or a certain taste to evoke an old memory, making you feel like you are back in time in that moment where it was created. Below you will find Unforgettable Memory to remind you of those good times we all hold inside our hearts.</p>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-app">2009</li>
              <li data-filter=".filter-card">2010</li>
              <li data-filter=".filter-web">2011</li>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-1.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 1</h4>
                <p>App</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-1.jpg" data-gall="portfolioGallery" class="venobox" title="App 1"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-2.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Web 3</h4>
                <p>Web</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-2.jpg" data-gall="portfolioGallery" class="venobox" title="Web 3"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-3.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 2</h4>
                <p>App</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-3.jpg" data-gall="portfolioGallery" class="venobox" title="App 2"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-4.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Card 2</h4>
                <p>Card</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-4.jpg" data-gall="portfolioGallery" class="venobox" title="Card 2"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-5.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Web 2</h4>
                <p>Web</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-5.jpg" data-gall="portfolioGallery" class="venobox" title="Web 2"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-6.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 3</h4>
                <p>App</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-6.jpg" data-gall="portfolioGallery" class="venobox" title="App 3"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-7.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Card 1</h4>
                <p>Card</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-7.jpg" data-gall="portfolioGallery" class="venobox" title="Card 1"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-8.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Card 3</h4>
                <p>Card</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-8.jpg" data-gall="portfolioGallery" class="venobox" title="Card 3"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-9.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Web 3</h4>
                <p>Web</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-9.jpg" data-gall="portfolioGallery" class="venobox" title="Web 3"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>

   
    <section id="testimonials" class="testimonials section-bg">
      <div class="container">

        <div class="row">
          <div class="col-lg-4">
            <div class="section-title" data-aos="fade-right">
              <h2>Testimonials</h2>
              <p>Testimonials describe what has been and are a promise of what is to come</p>
            </div>
          </div>
          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
            <div class="owl-carousel testimonials-carousel">

              <div class="testimonial-item">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                   Demonstrated my tact...
One of the most hardest thing to do in life is to start. This college brought me to change my world for sure. The way of teaching and guiding kindled my zeal to learn programming in a smart way. Thanks to my ever inspiring mentors who guided me to follow the path clearly.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>                </p>
                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Mr. Satheesh Natarajan</h3>
                <h4>Full Stack Developer</h4>
              </div>

              <div class="testimonial-item">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
            
MZCET has done a splendid job by inculcating the ability to learn and build a strong foundation in acquiring knowledge. The learner centric environment not only trained me in academics but also helped to update the current developments. I must thank all my professors for shaping me as a better technocrat
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>                </p>
                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                <h3>Mr. Kavin.S</h3>
                <h4>Standard Chartered </h4>
              </div>

              <div class="testimonial-item">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  
MZCET gave a great opportunity for students like me to broaden the knowledge beyond . It gave me an opportunity to learn several things. I have received great support from faculty, The friendly attitude of the faculty and their willingness to always offer a helping hand has made me feel a part of the MZCET family. 

                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>                </p>
                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                <h3>Vipin Paul
</h3>
                <h4>Software Developer</h4>
              </div>

              <div class="testimonial-item">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                It was an enriching experience for me to learn my core subjects thoroughly a MZCET. I thank my Professors who encouraged me to learn and explore the subjects as much as i can. This endeavor made me to shine and achieve new heights in my professional career.<br>

                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>                </p>
                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                <h3>Mr. Manirethinam R</h3>
                <h4>Software Engineer</h4>
              </div>

              <div class="testimonial-item">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                 I am grateful to Mount Zion College of Engineering and Technology - both the faculty and the Training & Placement Department. It provided me a great learning experience. The exposure moulded me as a better man to face the challenges of the corporate world.<br>

                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>                </p>
                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                <h3>Krishna Sathiya Narayana MD</h3>
                <h4>Technology Specialist</h4>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

   
   
    <section id="contact" class="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-4" data-aos="fade-right">
            <div class="section-title">
              <h2>Contact</h2>
              <p> <strong>Mount Zion College of Engineering and Technology </strong> <br>
			  Lena Vilakku, Pilivalam P.O, Thirumayam Tk,<br>
Pudukkottai Dt - 622507<br>
Tamil Nadu, INDIA </p>
            </div>
          </div>

          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
   
           
            <div class="row">
              <div class="col-lg-6 mt-4">
                <div class="info">
                  <i class="icofont-envelope"></i>
                  <h4>Email:</h4>
                  <p>info@mzcet.in</p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="info w-100 mt-4">
                  <i class="icofont-phone"></i>
                  <h4>Call:</h4>
                  <p>+91 9659173000 </p>
                </div>
              </div>
            </div>

            <form action="forms/contact.php" method="post" role="form" class="php-email-form mt-4">
              <div class="form-row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                  <div class="validate"></div>
                </div>
                <div class="col-md-6 form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>
        </div>

      </div>
    </section>

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
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>


  <script src="assets/js/main.js"></script>
<script>
  function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
</body>

</html>