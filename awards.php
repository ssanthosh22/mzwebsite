<!DOCTYPE html>

<!--[if IE 7]>
<html class="ie ie7" lang="en-US">
<![endif]-->

<!--[if IE 8]>
<html class="ie ie8" lang="en-US">
<![endif]-->

<!--[if IE 9]>
<html class="ie ie9" lang="en-US">
<![endif]-->

<!--[if !(IE 7) | !(IE 8) | !(IE 9)  ]><!-->
<html lang="en-US">
<!--<![endif]-->

<head>
<title>Mount Zion College of Engineering and Technology</title>
<meta charset="UTF-8" />
<link rel="shortcut icon" href="images/favicon.ico" title="Favicon"/>
<meta name="viewport" content="width=device-width" />

 <link href="css/bootstrap.min.css" rel="stylesheet">

 
<script src="js/jquery-3.1.1.min.js"/>
<script src="js/bootstrap.min.js"></script>


   
<script type="text/javascript">
function loadPage(href)
{
var xmlhttp = new XMLHttpRequest();
xmlhttp.open("GET", href, false);
xmlhttp.send();
return xmlhttp.responseText;
}
function loadnews()
{
document.getElementById('awards').innerHTML = loadPage('awards.txt');

 jQuery(document).ready(function($) {
  $('#awards').flexslider({
    animation: "fade",
    controlNav: true,
    keyboardNav: true,
    pauseOnHover: true,
    touch: true, 
    start: function(slider) {
      $('ol.flex-control-thumbs li img.flex-active').parent('li').addClass('active');
    }
    });
});
}
window.onload = loadnews;
</script>
</head>

<body>
<div class="flexslider"  style="position: relative; min-height: 135px; overflow: hidden;">
<div id="awards" class="slides">

</div>
</div>     
</body>