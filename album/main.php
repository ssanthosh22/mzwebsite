<?php
/****************************************/
/* (c) 2005 Patrik Jakab                */
/*    phpAlbum.net                      */
/*Licence info: GNU/GPL                 */
/* see file LICENSE                     */
/****************************************/

/****************************************/
/*      Constants                       */
/****************************************/
/*
  these are only default values, need not to be changed here because of
  possibility to change it in setup
*/
$phpalbum_version="0.4.1.16";
define("PHPALBUM_APP","OK");  // if this is setted to DEMO then only superuser can change something in setup.
								// should be used only for demos i.e. on phpAlbum.net demo page. for normal access use some other value.
			

if ( file_exists("config.php")){
    include("config.php");	
}else{
    echo "<html><body>";
    echo "<table width=\"100%\"><tr><td align=\"center\"><table  ><tr  valign=\"top\"><td bgcolor=\"#FFDDDD\" width=700 align=left>";
    echo "<b> Welcome to phpAlbum $phpalbum_version</b><br>";
    echo " You have to edit config_change_it.php and rename it to config.php.<br>";
    echo " You have to define data directory, because of security issues it is recommended that this is not data/ but";
    echo " something like \"data_Ab6Lkj88KJ/\"";
    echo "<td></tr></table></td></tr></table>";
    generate_footer();
    return;
}

if ( !is_dir($data_dir)){
    echo "<html><body>";
    echo "<table width=\"100%\"><tr><td align=\"center\"><table  ><tr  valign=\"top\"><td bgcolor=\"#FFDDDD\" width=700 align=left>";
    echo "<b> Welcome to phpAlbum $phpalbum_version</b><br>";
    echo "Please check your config.php file, the directory <b>$data_dir</b> does not exist <br>";
    echo "<td></tr></table></td></tr></table>";
    generate_footer();
    return;
}
if ( !check_writable($data_dir)){
    echo "<html><body>";
    echo "<table width=\"100%\"><tr><td align=\"center\"><table  ><tr  valign=\"top\"><td bgcolor=\"#FFDDDD\" width=700 align=left>";
    echo "<b> Welcome to phpAlbum $phpalbum_version</b><br>";
    echo "Your data directory $data_dir is not writable <br>";
    echo "Please change the rights on this directory so php can write in it. (UNIX: CHMOD 777, WINDOWS: setup rights)";
    echo "<td></tr></table></td></tr></table>";
    generate_footer();
    return;
}

$pa_setup=Array();
$pa_quality=Array();
$pa_theme=Array();
$pa_lang=Array();
$pa_color_map=Array();
$pa_keywords=Array();
$themes_dir="themes/";
$site_engine="phptemplate";
$act_dir_sorting="default";
/*   header buffering   */
$sent_header=Array();

/*testing for modules*/
if(function_exists("ftp_login")){
	$ftp_support=true;
}else{
	$ftp_support=false;
}

if(function_exists("mb_get_info")){
	$mbstring=true;
	$_mb_info=mb_get_info('all');
	if(isset($_mb_info['internal_encoding'])){
		$int_encoding=$_mb_info['internal_encoding'];
	}else{
		$int_encoding='ISO-8859-1';//default
	}
}else{
	$mbstring=false;
}

//error_reporting(E_WARNING | E_ERROR);
$old_error_handler = set_error_handler("userErrorHandler");
//time limit
@set_time_limit(0);

function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
   global $data_dir,$pa_setup;
   

   // timestamp for the error entry
if(isset($pa_setup['error_logging_enabled'])){
if($pa_setup['error_logging_enabled']=="true"){
   $dt = date("y/m/d H:i:s");

   // define an assoc array of error string
   // in reality the only entries we should
   // consider are E_WARNING, E_NOTICE, E_USER_ERROR,
   // E_USER_WARNING and E_USER_NOTICE
   $errortype = array (
               E_ERROR          => "Error",
               E_WARNING        => "Warning",
               E_PARSE          => "Parsing Error",
               E_NOTICE          => "Notice",
               E_CORE_ERROR      => "Core Error",
               E_CORE_WARNING    => "Core Warning",
               E_COMPILE_ERROR  => "Compile Error",
               E_COMPILE_WARNING => "Compile Warning",
               E_USER_ERROR      => "User Error",
               E_USER_WARNING    => "User Warning",
               E_USER_NOTICE    => "User Notice"
               );
   // set of errors for which a var trace will be saved
   //$user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
   if($errno==E_NOTICE){
   	return;
   }
   if(defined("E_STRICT")){
	   if($errno==E_STRICT){
	   	return;
	   }
   }
   $err = "\$phpalbum_Errors[]= Array(\"datetime\" => \"$dt\",";
   $err .= "\"errornum\" => \"$errno\",";
   $err .= "\"errortype\" => \"".$errortype[$errno]."\",";
   $err .= "\"errormsg\" => \"$errmsg\",";
   $err .= "\"scriptname\" => \"$filename\",";
   $err .= "\"scriptlinenum\" => \"$linenum\"";
   $err .= ");";
   if(file_exists($data_dir."error.log")){
	   if(filesize($data_dir."error.log")>1024*1024*2){
	   		unlink($data_dir."error.log");
	   }
   }
   if(substr($errmsg,0,6)!="unlink"){
	   //ignore unlink errors - not important as it can happen
	   $ff=fopen($data_dir."error.log","a");
	   fwrite($ff,"<? ".$err." ?>\n");
	   fclose($ff);
   }
}}
}
function pa_readfile($path){
	/*fixed bug where if readfile disabled phpAlbum doesn't work*/
	if(!function_exists("readfile")){
		$file=fopen($path,"rb");
		$doc=fread($file,filesize($path));
		fclose($file);
		echo $doc;
	}else{
		readfile($path);
	}
}

function conv_out($string){
	global $pa_setup,$mbstring,$pa_lang;
	if($mbstring){
	   return mb_convert_encoding($string,$pa_lang["character_set"]);
	}else{
		return $string;
	}
}
function prepit($text){
	//prepare text from db to be in input type="text" 
	return str_replace('"','&quot;',$text);
}
function prepdb($text){
	//adding slash for all but "
	$ret=addslashes($text);
	$ret=str_replace('\"','"',$ret);
	return $ret;
}
function conv_in($string){
	global $pa_setup,$int_encoding,$mbstring,$pa_lang;
	if($mbstring){
		return mb_convert_encoding($string,$int_encoding,$pa_lang["character_set"]);
	}else{
		return $string;
	}
}
function conv_out_header ($string){
	global $pa_setup,$mbstring,$pa_lang;
	if($mbstring){
		return mb_encode_mimeheader($string,$pa_lang["character_set"]);
	}else{
		return $string;
	}
}
function send_header($text){
	global $sent_header;
	header($text);
	$sent_header[]=$text; /*store for later use*/
}
function store_header($file_name){
	global $sent_header;
	if(is_array($sent_header)){
		$f=fopen($file_name,"w");
		foreach($sent_header as $header){
				fwrite($f,$header."\n");
		}
		fclose($f);
	}
}
function resend_header($file_name){
	$file=file($file_name);
	foreach($file as $line){
		header(substr($line,0,strlen($line)-1));
	}
}
function sent_header(){
	global $sent_header;
	if(sizeof($sent_header)>0){
		return true;
	}else{
		return false;
	}
}
/*assertion*/


/****************************************/
/*      Functions                       */
/****************************************/

function UnsharpMask($img, $amount, $radius,$threshold)    {

////////////////////////////////////////////////////////////////////////////////////////////////
////
////          Unsharp Mask for PHP - version 2.0
////
////    Unsharp mask algorithm by Torstein H?nsi 2003-06.
////             thoensi_at_netcom_dot_no.
////               Please leave this notice.
////
///////////////////////////////////////////////////////////////////////////////////////////////


    // $img is an image that is already created within php using
    // imgcreatetruecolor. No url! $img must be a truecolor image.

    // Attempt to calibrate the parameters to Photoshop:
    if ($amount > 500)    $amount = 500;
    $amount = $amount * 0.016;
    if ($radius > 50)    $radius = 50;
    $radius = $radius * 2;
    
    $radius = abs(round($radius));     // Only integers make sense.
    if ($radius == 0) return $img;
    $w = imagesx($img); $h = imagesy($img);
    $imgBlur = imagecreatetruecolor($w, $h);
    

    // Gaussian blur matrix:
    //                        
    //    1    2    1        
    //    2    4    2        
    //    1    2    1        
    //                        
    //////////////////////////////////////////////////
    
    imagecopy($imgBlur, $img, 0, 0, 0, 0, $w, $h); // background    
    
    for ($i = 0; $i < $radius; $i++)    {
        
        if (function_exists('imageconvolution')) { // PHP >= 5.1
            $matrix = array(
                array( 1, 2, 1 ),
                array( 2, 4, 2 ),
                array( 1, 2, 1 )
                );
            imageconvolution($imgCanvas, $matrix, 16, 0);
            
        } else {
                
            // Move copies of the image around one pixel at the time and merge them with weight
            // according to the matrix. The same matrix is simply repeated for higher radii.
                    
            imagecopy      ($imgBlur, $img, 0, 0, 1, 1, $w - 1, $h - 1); // up left
            imagecopymerge ($imgBlur, $img, 1, 1, 0, 0, $w, $h, 50); // down right
            imagecopymerge ($imgBlur, $img, 0, 1, 1, 0, $w - 1, $h, 33.33333); // down left
            imagecopymerge ($imgBlur, $img, 1, 0, 0, 1, $w, $h - 1, 25); // up right
            
            imagecopymerge ($imgBlur, $img, 0, 0, 1, 0, $w - 1, $h, 33.33333); // left
            imagecopymerge ($imgBlur, $img, 1, 0, 0, 0, $w, $h, 25); // right
            imagecopymerge ($imgBlur, $img, 0, 0, 0, 1, $w, $h - 1, 20 ); // up
            imagecopymerge ($imgBlur, $img, 0, 1, 0, 0, $w, $h, 16.666667); // down
            
            imagecopymerge ($imgBlur, $img, 0, 0, 0, 0, $w, $h, 50); // center

            // During the loop above the blurred copy darkens, possibly due to a roundoff
            // error. Therefore the sharp picture has to go through the same loop to
            // produce a similar image for comparison. This is not a good thing, as processing
            // time increases heavily.
//            imagecopy ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h);
  /*          imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 50);
            imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 33.33333);
            imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 25);
            imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 33.33333);
            imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 25);
            imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 20 );
            imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 16.666667);
            imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 50);
            imagecopy ($imgCanvas2, $imgBlur2, 0, 0, 0, 0, $w, $h);
    */        
        }
    }

    // Calculate the difference between the blurred pixels and the original
    // and set the pixels
    for ($x = 0; $x < $w; $x++)    { // each row
        for ($y = 0; $y < $h; $y++)    { // each pixel
                
            $rgbOrig = ImageColorAt($img, $x, $y);
            $rOrig = (($rgbOrig >> 16) & 0xFF);
            $gOrig = (($rgbOrig >> 8) & 0xFF);
            $bOrig = ($rgbOrig & 0xFF);
            
            $rgbBlur = ImageColorAt($imgBlur, $x, $y);
            
            $rBlur = (($rgbBlur >> 16) & 0xFF);
            $gBlur = (($rgbBlur >> 8) & 0xFF);
            $bBlur = ($rgbBlur & 0xFF);
            
            // When the masked pixels differ less from the original
            // than the threshold specifies, they are set to their original value.
            $rNew = (abs($rOrig - $rBlur) >= $threshold)
                ? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig))
                : $rOrig;
            $gNew = (abs($gOrig - $gBlur) >= $threshold)
                ? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig))
                : $gOrig;
            $bNew = (abs($bOrig - $bBlur) >= $threshold)
                ? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig))
                : $bOrig;
            
            
                        
            if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew)) {
                $pixCol = ImageColorAllocate($img, $rNew, $gNew, $bNew);
                ImageSetPixel($img, $x, $y, $pixCol);
            }
        }
    }
    
    return $img; 
}


function imagecreatefrom($file){
if(strtoupper(substr($file,-3,3))=="JPG" || strtoupper(substr($file,-4,4))=="JPEG"){		
	$image=imagecreatefromjpeg($file);
}
if(strtoupper(substr($file,-3,3))=="PNG"){		
	$image=imagecreatefrompng($file);
}
if(strtoupper(substr($file,-3,3))=="GIF"){		
	$image=imagecreatefromgif($file);
}
return $image;
}

function image_same_type($file,$image,$quality = 100){
if(strtoupper(substr($file,-3,3))=="JPG" || strtoupper(substr($file,-4,4))=="JPEG"){		
	imagejpeg($image,null,$quality);
}
if(strtoupper(substr($file,-3,3))=="PNG"){		
	imagepng($image);
}
if(strtoupper(substr($file,-3,3))=="GIF"){		
	imagegif($image);
}
}


function check_gd(){
 if(function_exists("gd_info")){
 	$info=gd_info();
	if(strstr($info['GD Version'],"2.")){
  		return true;
	}else{
	         return false;
	}
 }
 return false;
}

function pa_html_encode($string){
	return str_replace( array ( '&', '"', "'", '<', '>'), array ( '&amp;' , '&quot;', '&#39;' , '&lt;' , '&gt;' ),$string);
}
function pa_html_decode($string){
	return str_replace( array ( '&amp;' , '&quot;', '&#39;' , '&lt;' , '&gt;' ),array ( '&', '"', "'", '<', '>'),$string);
}
/****************************************/
/*      SETTINGS                 */
/****************************************/

function read_settings(){
	global $pa_setup,$pa_theme,$pa_color_map,$pa_lang;
	$rec=db_select_all("setup");
	$pa_setup=$rec[0];
	
	$rec=db_select_all("theme","name=='".$pa_setup["site_theme"]."'");
	if(count($rec)==0){
		//used new theme, never used before
		db_insert("theme",Array( "name"=>$pa_setup["site_theme"]));
		$rec=db_select_all("theme","name=='".$pa_setup["site_theme"]."'");
	}
	$pa_theme=$rec[0];
	
	$rec=db_select_all("color_map","id==".$pa_theme["color_map"]);
	$pa_color_map=$rec[0];
	
	$rec=db_select_all("languages","name=='".$pa_setup["language"]."'");
	$pa_lang=$rec[0];
//echo db_get_last_error_text();
}


function print_error($error,$par=null){
   //echo "<table border=\"2\" bgcolor=\"#DD0000\"><tr><td><font color=\"#FFFFFF\"><b>$error</b></font></td></tr></table>";
   if($par){
   		printf("<div class=\"messages error\"><table><tr><td valign=\"center\" width=\"20\"><img boreder=\"0\" src=\"res/expl.png\" /></td><td valign=\"center\" >".$error."</td></tr></table></div>",$par);
   }else{
   		printf("<div class=\"messages error\"><table><tr><td valign=\"center\" width=\"20\"><img boreder=\"0\" src=\"res/expl.png\" /></td><td valign=\"center\" >".$error."</td></tr></table></div>");
   }
}
function print_warning($error){
   echo "<table border=\"2\" bgcolor=\"#EECC00\"><tr><td><font color=\"#000000\"><b>WARNING:$error</b></font></td></tr></table>";
}

function is_cachable($text,$var1){
global $pa_setup;
		if ($text == "logo" || $text == "themeimage") return true;
		if ($text == "theme") return false;
		if ($text == "image") {
		  if($pa_setup["cache_resized_photos"]=="true"){
		  return true;}else{
		  return false;}
		}
		if ($text == "setup") return false;
		if ($text == "delcache") return false;
		if ($text == "setquality") return false;
		if ($text == "album") return false;
		if ($text == "imageview") return false;
		if ( strlen($text)==0) return false;
		if ($text == "thmb"){
			if($pa_setup["cache_thumbnails"]=="true"){
		  			return true;
			}else{
		  			return false;
			}

		}
		return false;
}

function is_movie($var1){
	$t=strtoupper(substr($var1,-3,3));
	$t2=strtoupper(substr($var1,-4,4));
	if($t=="AVI" ||$t=="MPG"||$t=="3GP"||$t=="MP4" ||$t2=="MPEG" ||$t=="MOV" ||$t=="WMV" ||$t=="VOB") return true;
	return false;
}
function is_audio($var1){
	$t=strtoupper(substr($var1,-3,3));
	if($t=="MP3" ||$t=="WMA" ||$t=="WAV") return true;
	return false;
}
function is_image($var1){
	$t=strtoupper(substr($var1,-3,3));
	$t2=strtoupper(substr($var1,-4,4));
	if($t=="GIF" ||$t=="PNG" ||$t=="JPG" ||$t2=="JPEG") return true;
	return false;
}

function is_cached($cmd,$var1,$var2,$var3,$quality){
global $pa_setup;
$cache_dir=$pa_setup["cache_dir"];
	//return false;
	$fn=get_cache_file_name($cache_dir,$cmd,$var1,$var2,$var3,$quality);
	return file_exists($fn);
}

function load_from_cache($cmd,$var1,$var2,$var3,$quality){
global $pa_setup;
$cache_dir=$pa_setup["cache_dir"];
	
$fn=get_cache_file_name($cache_dir,$cmd,$var1,$var2,$var3,$quality);
	
	if($cmd == "thmb" || $cmd=="themeimage" || $cmd == "logo" || $cmd == "dir_logo" || $cmd == "image" ){
		//$headers=getallheaders();-- not supported by others then apache
		if (isset( $_SERVER["HTTP_IF_MODIFIED_SINCE"] ) ){
			if ( date("D, d M Y H:i:s T",filemtime($fn)) == $_SERVER["HTTP_IF_MODIFIED_SINCE"] ) {
				header('HTTP/1.0 304 Not Modified');
				exit; 
			}
		}
	}
	if(file_exists($fn.".hdr")){
		resend_header($fn.".hdr");
	}
	pa_readfile($fn);
	
}

function get_cache_file_name($cache_dir,$cmd,$var1,$var2,$var3,$quality){
$filename=$cache_dir . "cache_";
$filename.=$cmd;
$filename.="_".str_replace(" ","_",str_replace("/","_",$var1));
$filename.="_".str_replace(" ","_",str_replace("/","_",$var2));
$filename.="_".str_replace(" ","_",str_replace("/","_",$var3));
$filename.="_".$quality;
$filename.=".cache";
return $filename;
}

function cache_document($cmd,$var1,$var2,$var3,$quality){
global $pa_setup;
$cache_dir=$pa_setup["cache_dir"];
$doc=ob_get_contents();
//echo ob_get_length();
$filename=get_cache_file_name($cache_dir,$cmd,$var1,$var2,$var3,$quality);
//echo $filename;
$file=fopen($filename,"wb");
fwrite($file,$doc);
fclose($file);

$m_time= filemtime($filename);
send_header("Last-Modified: ".date("D, d M Y H:i:s T",$m_time) );
send_header("Cache-Control: public, max-age=" . 3600 * 48);

if(sent_header()){
	/*cache header*/
	store_header($filename.".hdr");
}

}
function invalidate_object_cache($type){
	$rec=db_select_all("object_cache","type=='".$type."'");
	if(is_array($rec)){
		foreach($rec as $key=>$record){
			@unlink($record["file"]);
		}
	}
	db_delete("object_cache","type=='".$type."'");
}
function get_cached_object ($type,$var1){
global $pa_setup;
$cache_dir=$pa_setup["cache_dir"];
	$filename=$cache_dir.$type.str_replace(" ","_",str_replace("/","_",$var1)).".obj";
	if(file_exists($filename)){
		$string=file_get_contents($filename);
		return unserialize($string);
	}else{
		return null;
	}
}
function cache_object($type,$var1,$obj){
global $pa_setup;
$cache_dir=$pa_setup["cache_dir"];
	$filename=$cache_dir.$type.str_replace(" ","_",str_replace("/","_",$var1)).".obj";
	$str=serialize($obj);
	$f=fopen($filename,"w");
	fwrite($f,$str);
	fclose($f);
	db_insert("object_cache",Array("type"=>$type,"file"=>$filename));
}

function delete_old_ecards(){
	$time=time()-60*60*24*14;
	db_delete("ecards","created<$time");
}
function delete_old_anitspam(){
	$time=time()-60*60;
	db_delete("anti_spam_codes","time<$time");
}

function get_file_for_screenshot($scr,$dw){
  $scr_base=substr($scr,0,strlen($scr)-4);
	foreach($dw as $file){
		if(!is_image($file)){
	  	if($scr_base==$file	|| $scr_base."."== substr($file,0,strlen($scr_base."."))){
	  		 return $file;
	  	}
	  }
	}
	return "";
}
function get_screanshot_for_file($file,$fl){
	foreach($fl as $scr){
		if( is_image($scr)){
			$scr_base=substr($scr,0,strlen($scr)-4);
			if($scr_base==$file || $scr_base."." == substr($file,0,strlen($scr_base."."))){
				return $scr;
			}
		}
	}
	return "";
}
function get_thmb_standard_link($dir,$file_rec){
	global $pa_quality;
	if($file_rec["type"]=="I"){
		$file=$dir.$file_rec["file_name"];
	}else if($file_rec["type"]=="V"){
		$file=$dir.$file_rec["file_name"];
		if($file_rec["screenshot"]==""){
			$file="[movie]";
		}else{
			$file=$dir.$file_rec["screenshot"];
		}
	}else if($file_rec["type"]=="A"){
		$file=$dir.$file_rec["file_name"];
		if($file_rec["screenshot"]==""){
			$file="[audio]";
		}else{
			$file=$dir.$file_rec["screenshot"];
		}
	}else if($file_rec["type"]=="O"){
		$file=$dir.$file_rec["file_name"];
		if($file_rec["screenshot"]==""){
			$file="[file]";
		}else{
			$file=$dir.$file_rec["screenshot"];
		}
	}
	if($pa_quality["thmb_sharp_use"]=='true'){
		$sharpen_str="_".$pa_quality["thmb_sharp_amount"]."_".$pa_quality["thmb_sharp_radius"]."_".$pa_quality["thmb_sharp_treshold"];
	}else{
		$sharpen_str="";
	}
	return "main.php?cmd=thmb&var1=". urlencode($file)."&var2=".$pa_quality["thmb_size"]."_".$pa_quality["thmb_qual"]."_".$pa_quality["square_thumbnails"].$sharpen_str;
}
function get_thmb_dir_link($file){
	global $pa_quality,$pa_theme;
	if($pa_quality["thmb_sharp_use"]=='true'){
		$sharpen_str="_".$pa_quality["thmb_sharp_amount"]."_".$pa_quality["thmb_sharp_radius"]."_".$pa_quality["thmb_sharp_treshold"];
	}else{
		$sharpen_str="";
	}
	if($pa_theme["dir_logo_style"]=="pic_other_size"){
		return "main.php?cmd=thmb&var1=". urlencode($file)."&var2=".$pa_theme["dir_logo_size"]."_".$pa_theme["dir_logo_quality"]."_".$pa_theme["dir_logo_square_thumbnail"].$sharpen_str."_".$pa_color_map["bg_color"]."&var3=DIR";
	}else{
		return "main.php?cmd=thmb&var1=". urlencode($file)."&var2=".$pa_quality["thmb_size"]."_".$pa_quality["thmb_qual"]."_".$pa_quality["square_thumbnails"].$sharpen_str."_".$pa_color_map["bg_color"]."&var3=DIR";
	}
}

function check_access_to_dirs_groups($groups,$inh_groups){
	global $pa_user;
	if(isset($pa_user["groups"]["superuser"])){
		return true;
	}
	if((!is_array($groups) || count($groups)==0) && (!is_array($inh_groups) || count($inh_groups)==0)){ return true;}
	
	if(is_array($pa_user["groups"])){
	  if(is_array($groups)){
		foreach($groups as $key => $value){
			if(isset($pa_user["groups"][$key])){
				return true;
			}
		}
	  }
	  if(is_array($inh_groups)){
		foreach($inh_groups as $key => $value){
			if(isset($pa_user["groups"][$key])){
				return true;
			}
		}
	  }
		return false;
	}else{
		if(count($groups)>0){
			return false;
		}
	}
	return true;
}
function check_access_to_dir($dir){
	global $pa_user;
	if(isset($pa_user["groups"]["superuser"])){
		return true;
	}
	$sett_1=get_directory_settings($dir,0);
	$sett=$sett_1[0];
	if((!is_array($sett["groups"]) || count($sett["groups"])==0) && (!is_array($sett["inh_groups"]) || count($sett["inh_groups"])==0)){ return true;}
	
	if(is_array($pa_user["groups"])){
	  if(is_array($sett["groups"])){
		foreach($sett["groups"] as $key => $value){
			if(isset($pa_user["groups"][$key])){
				return true;
			}
		}
	  }
	  if(is_array($sett["inh_groups"])){
		foreach($sett["inh_groups"] as $key => $value){
			if(isset($pa_user["groups"][$key])){
				return true;
			}
		}
	  }
		return false;
	}else{
		if(count($sett["groups"])>0){
			return false;
		}
	}
	return true;
}
function get_sorted_file_list($seq_files){
	global $act_dir_sorting;
	switch($act_dir_sorting){
		case "date_asc":
			return db_select_all("files_$seq_files","visible=='true'","file_time");
		case "date_desc":
			return db_select_all("files_$seq_files","visible=='true'","file_time-");
		case "filename_asc":
			return db_select_all("files_$seq_files","visible=='true'","file_name");
		case "filename_desc":
			return db_select_all("files_$seq_files","visible=='true'","file_name-");
		case "name_asc":
			return db_select_all("files_$seq_files","visible=='true'","desc,file_name");
		case "name_desc":
			return db_select_all("files_$seq_files","visible=='true'","desc-,file_name-");
		default:
			return db_select_all("files_$seq_files","visible=='true'",null);

	}
}
function get_sorted_dir_list($path){
	global $act_dir_sorting;
	switch($act_dir_sorting){
		case "date_asc":
			return db_select_all("directory","visibility=='true' && path!='".prepdb($path)."' && translate_directory(dirname(path))=='".prepdb($path)."' && check_access_to_dirs_groups(groups,inh_groups)","newest_file_time_with_subdirs");
		case "date_desc":
			return db_select_all("directory","visibility=='true' && path!='".prepdb($path)."' && translate_directory(dirname(path))=='".prepdb($path)."' && check_access_to_dirs_groups(groups,inh_groups)","newest_file_time_with_subdirs-");
		case "filename_asc":
			return db_select_all("directory","visibility=='true' && path!='".prepdb($path)."' && translate_directory(dirname(path))=='".prepdb($path)."' && check_access_to_dirs_groups(groups,inh_groups)","path");
		case "filename_desc":
			return db_select_all("directory","visibility=='true' && path!='".prepdb($path)."' && translate_directory(dirname(path))=='".prepdb($path)."' && check_access_to_dirs_groups(groups,inh_groups)","path-");
		case "name_asc":
			return db_select_all("directory","visibility=='true' && path!='".prepdb($path)."' && translate_directory(dirname(path))=='".prepdb($path)."' && check_access_to_dirs_groups(groups,inh_groups)","alias,path");
		case "name_desc":
			return db_select_all("directory","visibility=='true' && path!='".prepdb($path)."' && translate_directory(dirname(path))=='".prepdb($path)."' && check_access_to_dirs_groups(groups,inh_groups)","alias-,path-");
		default:
			return db_select_all("directory","visibility=='true' && path!='".prepdb($path)."' && translate_directory(dirname(path))=='".prepdb($path)."' && check_access_to_dirs_groups(groups,inh_groups)",null);

	}
}
function get_keyword_link($keyword){
	return '<a class="me" href="main.php?cmd=albumnew&keyword='.htmlspecialchars(urlencode($keyword)).'">'.htmlspecialchars($keyword).'</a>';
}
function get_keyword_parameter_for_link(){
	global $pa_keywords;
	$strings=trim(implode(" ",$pa_keywords));
	if($strings!=""){
		return "&keyword=".htmlspecialchars(urlencode($strings));
	}else{
		return "";
	}
	
}
function  generate_albumnew($var1,$start_with){
  global $pa_setup,$pa_quality,$pa_theme,$pa_color_map,$pa_keywords,$pa_keywords_unsorted;
  global $act_dir_sorting;
  if($start_with=="")$start_with=0;
  if ($pa_theme["directory_style"]=="flowing"){
      $number_of_thmbs=$pa_theme["maximum_photos_per_page"];
  }else{
      $number_of_thmbs=$pa_theme["raster_dir_x"]*$pa_theme["raster_dir_y"];
  }  
  if($number_of_thmbs==0 || $number_of_thmbs<0){
  	$number_of_thmbs=1000000;/*i hope nobody will make more then million photos in one dir, if yes, i'm sorry :)*/
  }
	$newest_pics=get_newest_photos($var1,$start_with+$number_of_thmbs+1);
	$cnt=0;
	$offset=0;
	foreach($newest_pics as $key => $record){
	  if($offset>=$start_with){
	   $thumbnails[$cnt]['thmb']=get_thmb_standard_link(substr($record["path"],1),$record);
	   $thumbnails[$cnt]['desc']=pa_html_decode($record["desc"]);
	   if($pa_theme["show_filenames"]=="true" && $thumbnails[$cnt]['desc']==""){
			$thumbnails[$cnt]['desc']=conv_out($record["file_name"]);
	   }
	   $thumbnails[$cnt]['link']="main.php?cmd=imageviewnew&var1=$offset".get_keyword_parameter_for_link();
	   $thumbnails[$cnt]['width']=$pa_quality["thmb_size"]+$pa_theme["additional_thmb_width"];
	   $thumbnails[$cnt]['height']=$pa_quality["thmb_size"]+$pa_theme["additional_thmb_height"];
	   $thumbnails[$cnt]['view_count']=$record["view_count"];
	   $thumbnails[$cnt]['vote_count']=$record["vote_count"];
	   $thumbnails[$cnt]['vote_avg']=$record["vote_avg"];
	   $thumbnails[$cnt]['comment_count']=$record["comment_count"];
	   $cnt++;
	   if($cnt==$number_of_thmbs) break;
	  }
	   $offset++;
	}
	$qualities=db_select_all("quality","enabled=='true'"); // select all enabled qualities
	$quality_links=Array();
	if(count($qualities)>1){
		foreach($qualities as $key=>$val){
			$quality_links[]=Array("name"=>$val["name"],
								   "link"=>"main.php?cmd=setquality&var1=".$val["id"]."&var2=albumnew&var3=".urlencode($var1)."&var4=$start_with".get_keyword_parameter_for_link(),
								   "actual" => ($val["id"]==$pa_quality["id"])?1:0
								   );
		}
	}
	if ( sizeof($newest_pics)<=$start_with+$number_of_thmbs){
		//no next page
		$next_start_with=-1;
	}else{
		$next_start_with=$start_with+$number_of_thmbs;
	}
	
   	if ( $start_with==0){
		//no next page
		$previous_start_with=-1;
	}else{
	     $previous_start_with=$start_with-$number_of_thmbs;
	     if($previous_start_with<0){$previous_start_with=0;}
	}
	$dir_path[0]['name']=t('ID_NEWEST_PICTURES');
	$dir_path[0]['link']="main.php?cmd=albumnew";
	$cnt=1;
	$keywords="";
	if(is_array($pa_keywords_unsorted)){
		foreach($pa_keywords_unsorted as $key=>$value){
			$dir_path[$cnt]['name']=htmlspecialchars($value);
			if($keywords!=""){
				$keywords.=" ".$value;
			}else{
				$keywords=$value;
			}
			$dir_path[$cnt]['link']="main.php?cmd=albumnew&keyword=".htmlspecialchars(urlencode($keywords));
			$cnt++;
		}
	}
	theme_generate_album_page($dir_path,$quality_links,null,$thumbnails,null,null,$next_start_with,$previous_start_with,$var1,"NEW");
	return true;

}

function  generate_album($var1,$start_with){
  global $pa_setup,$pa_quality,$pa_theme,$pa_color_map,$pa_keywords;
  global $act_dir_sorting;
  if(strlen($var1)>0 && substr($var1,-1)!="/") $var1=$var1."/";
  if($start_with=="")$start_with=0;
  if ($pa_theme["directory_style"]=="flowing"){
      $number_of_thmbs=$pa_theme["maximum_photos_per_page"];
  }else{
      $number_of_thmbs=$pa_theme["raster_dir_x"]*$pa_theme["raster_dir_y"];
  }  
  if($number_of_thmbs==0 || $number_of_thmbs<0){
  	$number_of_thmbs=1000000;/*i hope nobody will make more then million photos in one dir, if yes, i'm sorry :)*/
  }
    $ss=get_directory_settings("/".$var1,0);
    $dir_settings=$ss[0];
	/*newest pictures*/
	$new_thumbnails=Array();
	if($dir_settings["show_newest_pictures_count"]>0){
		$newest_pics=get_newest_photos($var1,$dir_settings["show_newest_pictures_count"]);
		$cnt=0;
		foreach($newest_pics as $key => $record){
		   $new_thumbnails[$cnt]['thmb']=get_thmb_standard_link($record["path"],$record);
		   $new_thumbnails[$cnt]['desc']=pa_html_decode($record["desc"]);
		   if($pa_theme["show_filenames"]=="true" && $new_thumbnails[$cnt]['desc']==""){
				$new_thumbnails[$cnt]['desc']=conv_out($record["file_name"]);
		   }
           $new_thumbnails[$cnt]['link']="main.php?cmd=imageview&var1=".urlencode(substr($record["path"],1).$record["file_name"]);
  	       $new_thumbnails[$cnt]['width']=$pa_quality["thmb_size"]+$pa_theme["additional_thmb_width"];
	       $new_thumbnails[$cnt]['height']=$pa_quality["thmb_size"]+$pa_theme["additional_thmb_height"];
	       $new_thumbnails[$cnt]['view_count']=$record["view_count"];
	       $new_thumbnails[$cnt]['vote_count']=$record["vote_count"];
	       $new_thumbnails[$cnt]['vote_avg']=$record["vote_avg"];
	       $new_thumbnails[$cnt]['comment_count']=$record["comment_count"];
		   $cnt++;
		}
	}else{
		$new_thumbnails=null;
	}
	
	
	
    if(isset($dir_settings["sorting"])){
       	$act_dir_sorting=$dir_settings["sorting"];
    }
	//$act_dir_sorting=$dir_settings["sorting"];
   	if($act_dir_sorting=='default'){
   		$act_dir_sorting=$pa_setup["default_sorting"];
   	}
	$dir_path[0]['name']=t('ID_PHOTO_DIR');
	$dir_path[0]['link']="main.php?cmd=album";

	$dirs=explode('/',$var1);
	$act_dir="";
	for($i=0;$i<count($dirs)-1;$i++){
		$act_dir.=$dirs[$i]."/";
		$ss=get_directory_settings($act_dir,0);
		if(strlen($ss[0]["alias"])>0){
			$dir_path[$i+1]['name']=pa_html_decode($ss[0]["alias"]);
		}else{
			$dir_path[$i+1]['name']=conv_out($dirs[$i]);
		}
		$dir_path[$i+1]['link']="main.php?cmd=album&var1=".urlencode($act_dir);
		
	}

	$qualities=db_select_all("quality","enabled=='true'"); // select all enabled qualities
	$quality_links=Array();
	if(count($qualities)>1){
		foreach($qualities as $key=>$val){
			$quality_links[]=Array("name"=>$val["name"],
								   "link"=>"main.php?cmd=setquality&var1=".$val["id"]."&var2=album&var3=".urlencode($var1)."&var4=$start_with",
								   "actual" => ($val["id"]==$pa_quality["id"])?1:0
								   );
		}
	}
	$dir=$pa_setup["album_dir"] . $var1;
	/*directory description*/
	
	$dir_long_desc=pa_html_decode($dir_settings["long_desc"]);
	/*openning directories*/
	
	  $dirlist=get_sorted_dir_list($dir_settings["path"]);
      $directories=Array();
      $directories_cnt=0;
      if(sizeof($dirlist)>0){
       while ( list($key,$rec)=each($dirlist)){
		/*visibility*/
		        $file=$rec['file_name'];
				$blocked=false;
				/*test if there is some new images*/
					$diff = (time() - $rec["newest_file_time_with_subdirs"])/60/60;
					if ($diff < $pa_setup["new_dir_indic"] ){
						$dir_pic="main.php?cmd=themeimage&var1=dir_new.png&var2=".$pa_color_map["bg_color"];
						$directories[$directories_cnt]['stat']='NEW';
					}else{
						$dir_pic="main.php?cmd=themeimage&var1=dir.png&var2=".$pa_color_map["bg_color"];
						$directories[$directories_cnt]['stat']='NORM';
					}
				if($pa_theme["dir_logo_style"]=="pic_thmb_size" || $pa_theme["dir_logo_style"]=="pic_other_size"){
					$dir_logo=db_select_all("files_".$rec["seq_files"],"use_for_logo=='true' && type=='I'");
					if(!$dir_logo){
						$dir_logo=db_select_all("files_".$rec["seq_files"],"visible=='true' && type=='I'");
					}
					if($dir_logo){
					   $dir_pic=get_thmb_dir_link($rec["path"].$dir_logo[0]["file_name"]);
					}else{
					   $dir_pic=get_thmb_dir_link("[NOPIC]");
					}
				}
				/*defining variable*/
				$directories[$directories_cnt]['link']="main.php?cmd=album&var1=".urlencode($var1.basename($rec['path']))."/";
				$directories[$directories_cnt]['logo']=$dir_pic;
				if($rec['alias']!=""){
					$directories[$directories_cnt]['name']=pa_html_decode($rec['alias']);
				}else{
					/*it is filename and should be converted*/
					$directories[$directories_cnt]['name']=conv_out(basename($rec['path']));
				}
				$directories[$directories_cnt]['desc']=pa_html_decode($rec['desc']);
				$directories[$directories_cnt]['width']=$pa_quality["thmb_size"]+$pa_theme["additional_thmb_width"];
				$directories[$directories_cnt]['height']=$pa_quality["thmb_size"]+$pa_theme["additional_thmb_height"];
						
				
				$directories_cnt++;
		
      }
     }
	   /*openning files*/
   	   if($start_with<0){
       		$start_with=0; /*just to be sure*/
       }
	   $filelist=get_sorted_file_list($dir_settings["seq_files"]);
       $qq=$pa_quality["thmb_size"]."_".$pa_quality["thmb_qual"];
       $qpic=$pa_quality["photo_size"]."_".$pa_quality["photo_qual"];
       $thumbnails=Array();
       $thumbnails_cnt=0;
       $fl=array_slice($filelist,$start_with,$number_of_thmbs);
       foreach($fl as $key => $record){
	       	$file=$record['file_name'];
			if($record["type"]=="I"){
			    $thumbnails[$thumbnails_cnt]['thmb']=get_thmb_standard_link($var1,$record);
			    $thumbnails[$thumbnails_cnt]['desc']=pa_html_decode($record["desc"]);
				$thumbnails[$thumbnails_cnt]['link']="main.php?cmd=imageview&var1=".urlencode($var1.$file);
			    if($pa_theme["show_filenames"]=="true" && $thumbnails[$thumbnails_cnt]['desc']==""){
			       	$thumbnails[$thumbnails_cnt]['desc']=conv_out($file);
			    }
			}
			if($record["type"]=="V"){
			   $thumbnails[$thumbnails_cnt]['thmb']=get_thmb_standard_link($var1,$record);
			   $thumbnails[$thumbnails_cnt]['desc']=pa_html_decode($record["desc"]);
	 	       $thumbnails[$thumbnails_cnt]['link']="main.php?cmd=image&var1=".urlencode($var1.$file);
			    if($pa_theme["show_filenames"]=="true" && $thumbnails[$thumbnails_cnt]['desc']==""){
			       	$thumbnails[$thumbnails_cnt]['desc']=conv_out($file);
			    }
			}
			if($record["type"]=="A"){
				$thumbnails[$thumbnails_cnt]['thmb']=get_thmb_standard_link($var1,$record);
			   $thumbnails[$thumbnails_cnt]['desc']=pa_html_decode($record["desc"]);
	 	       $thumbnails[$thumbnails_cnt]['link']="main.php?cmd=image&var1=".urlencode($var1.$file);
			    if($pa_theme["show_filenames"]=="true" && $thumbnails[$thumbnails_cnt]['desc']==""){
			       	$thumbnails[$thumbnails_cnt]['desc']=conv_out($file);
			    }
			}
			if($record["type"]=="O"){
			   $thumbnails[$thumbnails_cnt]['thmb']=get_thmb_standard_link($var1,$record);
			   $thumbnails[$thumbnails_cnt]['desc']=pa_html_decode($record["desc"]);
	 	       $thumbnails[$thumbnails_cnt]['link']="main.php?cmd=image&var1=".urlencode($var1.$file);
			    if($pa_theme["show_filenames"]=="true" && $thumbnails[$thumbnails_cnt]['desc']==""){
			       	$thumbnails[$thumbnails_cnt]['desc']=conv_out($file);
			    }
			}
	       $thumbnails[$thumbnails_cnt]['width']=$pa_quality["thmb_size"]+$pa_theme["additional_thmb_width"];
	       $thumbnails[$thumbnails_cnt]['height']=$pa_quality["thmb_size"]+$pa_theme["additional_thmb_height"];
	       $thumbnails[$thumbnails_cnt]['view_count']=$record["view_count"];
	       $thumbnails[$thumbnails_cnt]['vote_count']=$record["vote_count"];
	       $thumbnails[$thumbnails_cnt]['vote_avg']=$record["vote_avg"];
	       $thumbnails[$thumbnails_cnt]['comment_count']=$record["comment_count"];
	       $thumbnails_cnt++;
		}

		
   	if ( sizeof($filelist)<=$start_with+$number_of_thmbs){
		//no next page
		$next_start_with=-1;
	}else{
		$next_start_with=$start_with+$number_of_thmbs;
	}
	
   	if ( $start_with==0){
		//no next page
		$previous_start_with=-1;
	}else{
	     $previous_start_with=$start_with-$number_of_thmbs;
	     if($previous_start_with<0){$previous_start_with=0;}
	}
	/*call theme function to generate page*/
	
	theme_generate_album_page($dir_path,$quality_links,$directories,$thumbnails,$new_thumbnails,$dir_long_desc,$next_start_with,$previous_start_with,$var1);
	   
	return true;
}

function translate_directory($dir){
	if ($dir=="\\" || $dir==".") $dir="";
	
	if(substr($dir,0,1)!="/"){
 		$dir="/".$dir;
	}
	if(substr($dir,-1,1)!="/"){
 		$dir=$dir."/";
	}
	return $dir;
}
function get_directory_settings($dir,$full=1){
	
	global $data_dir,$pa_setup;

	$dir=translate_directory($dir);
	if(!is_dir($pa_setup["album_dir"].$dir)){
		theme_generate_error_page();
		exit(0);
	}
	
	$inh_groups=Array();
	if(!db_select_exists("directory","path=='".prepdb($dir)."'")){
		// not found, first time visiting directory, do insert
		if($dir!="/"){
			//inheriting directory permissions for new directory.
			$up_dir=dirname($dir);
			if(substr($up_dir,-1,1)!="/"){
 				$up_dir=$up_dir."/";
			}	
			$rec=db_select_all("directory","path=='".prepdb($up_dir)."'");
			$grps=db_select_all("group");
			foreach($grps as $group){
				if(isset($rec[0]["groups"][$group["name"]])){
					$inh_groups[$group["name"]]=$rec[0]["seq_files"];
				}else{
					if(isset($rec[0]["inh_groups"][$group["name"]])){
						$inh_groups[$group["name"]]=$rec[0]["inh_groups"][$group["name"]];
					}
				}
			}
						
		}
		
		$seq_files=db_get_seq_nextval("seq_files");
		db_insert("directory",Array("path"=>$dir,"seq_files"=>$seq_files));
		db_update("directory","inh_groups=".var_export($inh_groups,true).";","seq_files==".$seq_files);
		
		db_create_table("files_$seq_files",Array(
			"file_name"=>"",
			"visible"=>"true",
			"desc"=>"",
			"long_desc"=>"",
			"params"=>"",
			"dir_logo"=>"true",
			"view_count"=>0,
			"vote_count"=>0,
			"vote_avg"=>0,
			"comment_count"=>0,
			"use_for_logo"=>"false",
			"file_time"=>"",
			"screenshot"=>"",
			"type"=>"I",
			"keywords"=>Array()
		));
		db_create_table("comments_$seq_files",Array(
			"id"=>"",
			"file_name"=>"",
			"time"=>"",
			"name"=>"",
			"email"=>"",
			"text"=>"",
			"visible"=>"true"
		));

	}
	$rec=db_select_all("directory","path=='".prepdb($dir)."'");	
	if($full!=1){
		return Array($rec[0],null);
	}
	$seq_files=$rec[0]["seq_files"];
	//continue for files settings
	$changed=false;
	//load files from DB
	$files_db=db_select_all("files_$seq_files",null,true);
	//load files from Medium
	$dir_path=substr($dir,1);
	$files_hd=Array();
	if(file_exists($pa_setup["album_dir"].$dir_path)){
	    if ($dh = opendir($pa_setup["album_dir"].$dir_path)) {
	       while (($file = readdir($dh)) !== false) {
	           if( filetype($pa_setup["album_dir"].$dir_path. $file)=="file" || filetype($pa_setup["album_dir"].$dir_path. $file)=="link" ){
					$files_hd[$file]=filemtime($pa_setup["album_dir"].$dir_path. $file);
	           }
	       }
	       closedir($dh);
	    }
	}
	$where="";//for deleting files, first screenshots then not existing files
	//parse screenshots
	$scr_files=Array();
	
	foreach($files_hd as $fn => $t){
		if(is_image($fn)){
				if(isset($files_hd[substr($fn,0,strlen($fn)-4)])){
					$scr_files[substr($fn,0,strlen($fn)-4)]=$fn;
					if($where==""){
						$where="file_name=='".prepdb($fn)."'";
					}else{
						$where.=" || file_name=='".prepdb($fn)."'";
					}
				}
		}
	}
	//now delete not existing files from DB
	foreach($files_db as $key => $record){
		if(!isset($files_hd[$record["file_name"]])){
			$changed=true;
			if($where==""){
				$where="file_name=='".prepdb($record["file_name"])."'";
			}else{
				$where.=" || file_name=='".prepdb($record["file_name"])."'";
			}
		}else{
			//names from database
			$files_db_names[$record["file_name"]]=$record["file_time"];
		}
	}
	if($where !=""){
		db_delete("files_$seq_files",$where);
	}
	//reload of db files
	foreach($files_hd as $fn => $t){
		if(isset($scr_files[$fn])){
			$screenshot=$scr_files[$fn];
		}else{
			$screenshot="";
		}
		if(!isset($files_db_names[$fn])){
		//file is not in db, insert it as new
			if(is_image($fn)){
				//check if it is a screenshot of some other file, in this case, this file will not be inserted.
				if(!isset($files_hd[substr($fn,0,strlen($fn)-4)])){
					//is not screensot
					$changed=true;
					// check for iptc descriptions if needed
					$short_desc="";
					$long_desc="";
					$keywords=Array();
					if($pa_setup["use_iptc_desc"]=="true"){
						list($www,$hhh)=getimagesize($pa_setup["album_dir"].$dir_path.$fn,$info);
						if (isset($info["APP13"])) {
							$iptc = iptcparse($info["APP13"]);
							if(isset($iptc["2#105"])){
								$short_desc=$iptc["2#105"][0];
							}
							if(isset($iptc["2#120"])){
								$long_desc=str_replace("\r","<br/>",$iptc["2#120"][0]);
							}
							if(isset($iptc["2#025"])){
								$keywords=$iptc["2#025"];
							}
						}
					}
					db_insert("files_$seq_files",Array("file_name"=>$fn,"file_time"=>$t,"desc"=>$short_desc,"long_desc"=>$long_desc,"keywords"=>$keywords));
				}
			}else if(is_movie($fn)){
				//check for screenshot
				$changed=true;
				db_insert("files_$seq_files",Array("file_name"=>$fn,"file_time"=>$t,"type"=>"V","screenshot"=>$screenshot));
			}else if(is_audio($fn)){
				//check for screenshot
				$changed=true;
				db_insert("files_$seq_files",Array("file_name"=>$fn,"file_time"=>$t,"type"=>"A","screenshot"=>$screenshot));
			}else{
				//check for screenshot
				$changed=true;
				db_insert("files_$seq_files",Array("file_name"=>$fn,"file_time"=>$t,"type"=>"O","screenshot"=>$screenshot));
			}
		}else if ($files_db_names[$fn] != $t){
			//timestamp is changed , update the file
			$short_desc="";
			$long_desc="";
			$keywords_text=var_export(Array(),true);
			if(is_image($fn)){
					// check for iptc descriptions if needed
					if($pa_setup["use_iptc_desc"]=="true"){
						list($www,$hhh)=getimagesize($pa_setup["album_dir"].$dir_path.$fn,$info);
						if (isset($info["APP13"])) {
							$iptc = iptcparse($info["APP13"]);
							if(isset($iptc["2#105"])){
								$short_desc=$iptc["2#105"][0];
							}
							if(isset($iptc["2#120"])){
								$long_desc=str_replace("\r","<br/>",$iptc["2#120"][0]);
							}
							if(isset($iptc["2#025"])){
								$keywords_text=var_export($iptc["2#025"],true);
							}
						}
					}
				
				db_update("files_$seq_files","keywords=".$keywords_text.";file_time='".$t."';desc='".$short_desc."';long_desc='".$long_desc."';","file_name=='".prepdb($fn)."'");
			}else{		
				db_update("files_$seq_files","file_time='".$t."'; screenshot='$screenshot';","file_name=='".prepdb($fn)."'");
			}
		}else if( !is_image($fn)){
				db_update("files_$seq_files","file_time='".$t."'; screenshot='$screenshot';","file_name=='".prepdb($fn)."'");
		}
	}
	
	/*rereading of files*/
	if($changed){
		$files_db=db_select_all("files_$seq_files");
	}
	if($rec[0]["photo_count"]!=count($files_db)){
		db_update("directory","photo_count=".count($files_db).";","path=='".prepdb($dir)."'");
	}
	return Array($rec[0],$files_db);
}
	

function get_all_sortings(){
	$sorts= Array ( "default"=> "Default",
					"date_asc"=> "Date - Ascending",
					"date_desc"=> "Date - Descending",
					"filename_asc"=> "Filename - Ascending",
					"filename_desc"=> "Filename - Descending",
					"name_asc"=> "Name - Ascending",
					"name_desc"=> "Name - Descending"
	);
	return $sorts;
}
function add_column_to_array(&$array, $column,$value) {
	foreach($array as $key => $rec){
		$array[$key][$column]=$value;
	}
}
function get_newest_photos($dir,$count){
	global $pa_user,$pa_keywords,$pa_grants;
	if ($dir=="\\" || $dir==".") $dir="";
	
	if(substr($dir,0,1)!="/"){
 		$dir="/".$dir;
	}
	if(substr($dir,-1,1)!="/"){
 		$dir=$dir."/";
	}
	sort($pa_keywords);
	$obj=get_cached_object("GNP",$dir.$count.md5(implode("_",$pa_keywords).implode("_",array_keys($pa_user["groups"]))));
	if($obj!=null){
		return $obj;
	}
	
	$func=db_create_order_by_function("file_time-,file_name-");
	$len=strlen($dir);
	$sorted=true;
	$where_clause="substr(path,0,$len)=='".prepdb($dir)."'";
	$where_groups="";
	if(!isset($pa_user["groups"]["superuser"])){
		$where_groups=" && (( (!is_array(groups) ||count(groups)==0 )&& (!is_array(inh_groups) || count(inh_groups)==0) )";
		foreach($pa_user["groups"] as $key => $val){
			$where_groups.=" || isset(groups['$key']) || isset(inh_groups['$key'])";
		}
		$where_groups.=")";
	}
	$where_clause.=$where_groups;
	$where_keyword="";
	if(is_array($pa_keywords)){
		foreach($pa_keywords as $key =>$keyword){
			if($where_keyword==""){
				$where_keyword="in_array('$keyword',keywords)";
			}else{
				$where_keyword.=" && in_array('$keyword',keywords)";
			}
		}
	}
	if($where_keyword!=""){
		$where_clause.= " && (".$where_keyword.")";
	}
	$dirs=db_select_limit(1,$count,"directory",$where_clause,"newest_file_time-");
	$newest_files=Array();
	//new where for pictures
	if($where_keyword!=""){
		$where_clause="visible=='true' && ".$where_keyword;
	}else{
		$where_clause="visible=='true'";
	}
	if(is_array($dirs)){
		foreach($dirs as $dir_rec){
			if(count($newest_files)==$count){
				if($newest_files[$count-1]["file_time"]>$dir_rec["newest_file_time"]){
					//there are no newer files in further directories, so we can break up here
					break;
				}
			}
			$files=db_select_limit(1,$count,"files_".$dir_rec["seq_files"],$where_clause,"file_time-,file_name-");
			add_column_to_array($files,"path",$dir_rec["path"]);
			if(count($files)>0){
				$newest_files=array_merge($newest_files,$files);
				$sorted=false;
				if(count($newest_files)>$count){
					//sort and slice
					usort($newest_files,$func);
					$sorted=true;
					$newest_files=array_slice($newest_files,0,$count);
				}
			}
		}
	}
	if(!$sorted){
		usort($newest_files,$func);
	}
	unset($func);
	cache_object("GNP",$dir.$count.md5(implode("_",$pa_keywords).implode("_",array_keys($pa_user["groups"]))),$newest_files);
	return $newest_files;	
}

function scan_photos_directories($dir,$level=0){
global $pa_setup;
$album_dir=$pa_setup["album_dir"];
$sett=get_directory_settings($dir,1);
$rec=db_select_all("files_".$sett[0]["seq_files"],null,"file_time-");
if(isset($rec[0])){
	$max_file_time=$rec[0]["file_time"];
}else{
	$max_file_time=0;
}
//sumarising keywords
$keywords=Array();
foreach($rec as $key=>$record){
	$keywords=array_unique(array_merge($keywords,$record["keywords"]));
}
$keywords_text=var_export($keywords,true);
db_update("directory","keywords=".$keywords_text.";newest_file_time='".$max_file_time."';","seq_files==".$sett[0]["seq_files"]);
if (is_dir($album_dir.$dir)) {
    if ($dh = opendir($album_dir.$dir)) {
       while (($file = readdir($dh)) !== false) {
           if( filetype($album_dir.$dir.$file)=="dir" && $file!="." && $file !="..") {
			 $time=scan_photos_directories($dir.$file."/",$level+1);
			 if($time>$max_file_time){
			 	$max_file_time=$time;
			 }
		}
			
       }
       closedir($dh);
    }

}
db_update("directory","newest_file_time_with_subdirs='".$max_file_time."';","seq_files==".$sett[0]["seq_files"]);
db_commit(true);
if($level==0){
	//delete not existing directories from db
	if($dir==""){
		//only once and if the whole directory is scanned
		$rec=db_select_all("directory");
		
		foreach($rec as $record){
			if(!file_exists(substr($pa_setup["album_dir"],0,-1).$record["path"])){
				db_drop_table("files_".$record["seq_files"]);
				db_drop_table("comments_".$record["seq_files"]);
				db_delete("directory","seq_files==".$record["seq_files"]);
			}
		}
	}
	
	db_update("directory","photo_count_r=0;");
	$rec=db_select_all("directory");
	foreach($rec as $record){
		if($record["photo_count"]>0){
			db_update("directory","photo_count_r+=".$record["photo_count"].";","substr('".prepdb($record["path"])."',0,strlen(path))==path");
		}
	}	
	$t=time();
	db_update("setup","last_dir_scan=".$t.";");
	$pa_setup["last_dir_scan"]=$t;
	db_commit(true);
	//invalidate GNP cache
	invalidate_object_cache("GNP");
}else{
	return $max_file_time;
}
}



function get_themes(){
global $themes_dir;
$dir=$themes_dir;
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
       while (($file = readdir($dh)) !== false) {
           if( filetype($dir . $file)=="dir" && $file!="." && $file !=".."  && $file !="engines") {
	   		$filelist[]=$file;
		}
			
       }
       closedir($dh);
    }
}
return $filelist;
	
}
/****************************************/
/*      THMB                            */
/****************************************/

function generate_thumb($var1,$var3){
  global $pa_setup,$pa_quality,$pa_theme;
  $sharp=true;
  if($pa_theme["dir_logo_style"]=="pic_other_size" && $var3=="DIR"){
	  $width = $pa_theme["dir_logo_size"];
	  $height = $pa_theme["dir_logo_size"];
	  $square = $pa_theme["dir_logo_square_thumbnail"];
	  $thmb_quality =$pa_theme["dir_logo_quality"];
  	
  }else{
	  $width = $pa_quality["thmb_size"];
	  $height = $pa_quality["thmb_size"];
	  $square = $pa_quality["square_thumbnails"];
	  $thmb_quality =$pa_quality["thmb_qual"];
  }
  $var1=stripslashes($var1);
  // Content type
  if(is_image($var1)){
  	$mime=get_mime($var1);
  	send_header("Content-type: ".$mime);
  }else{
  	send_header('Content-type: image/png'); // for movie.png and video.png
  }
  send_header("Content-Disposition: filename=thmb_".conv_out_header(basename($var1),$character_set)." ");
  if($var1=="[movie]"){$var1="res/movie.png"; $sharp=false;}
  else if($var1=="[audio]"){$var1="res/audio.png"; $sharp=false;}
  else if($var1=="[file]"){$var1="res/file.png"; $sharp=false;}
  else if($var1=="[NOPIC]"){$var1="res/nopic.png"; $sharp=false;}
  else{$var1=$pa_setup["album_dir"].$var1;}
  // Get new dimensions
  list($width_orig, $height_orig) = getimagesize($var1);
  //$image_p = imagecreatetruecolor($width+10, $height+10);
  //$color=ImageColorAllocate( $image_p, 32, 32, 32 );
  //imagefill($image_p,0,0,$color);
  if($square=="true"){
  	if ($width_orig < $height_orig) {
  		$src_x=0;
  		$src_y=($height_orig-$width_orig)/2;
  		$height_orig=$width_orig;
  	}else{
  		$src_y=0;
  		$src_x=($width_orig-$height_orig)/2;
  		$width_orig=$height_orig;
  	}
  }else{
  	  //keep aspect ratio
  	  $src_x=0; $src_y=0;
	  if ($width && ($width_orig < $height_orig)) {
	     $width = ($height / $height_orig) * $width_orig;
	  } else {
	     $height = ($width / $width_orig) * $height_orig;
	  }
  }

  // Resample
  $image=imagecreatefrom($var1);

  $image_p = imagecreatetruecolor($width, $height);
  $bgcol=theme_get_bgcolor();
  $color = ImageColorAllocate( $image_p,$bgcol[0] ,$bgcol[1] ,$bgcol[2] );
  imagefill($image_p,0,0,$color);
  
  imagecopyresampled($image_p, $image, 0, 0, $src_x, $src_y, $width, $height, $width_orig, $height_orig);
  //$image_p=UnsharpMask($image_p,50,1,3);
  // Output
  //sharpening
  if($pa_quality["thmb_sharp_use"]=='true' && $sharp){
  	$image_p=UnsharpMask($image_p, $pa_quality["thmb_sharp_amount"], $pa_quality["thmb_sharp_radius"],$pa_quality["thmb_sharp_treshold"]);
  }
  image_same_type($var1,$image_p,$thmb_quality);
	
}
/****************************************/
/*      IMAGE                           */
/****************************************/
function get_mime($var1){
	$t=strtoupper(substr($var1,-4,4));
	switch($t){
		case ".JPG":
		case "JPEG":
			return "image/jpeg";
			break;
		case ".GIF":
			return "image/gif";
			break;
		case ".PNG":
			return "image/png";
			break;
		default: return "";
			break;
	}
}
function get_resized_imagesize($var1){
global $pa_setup,$pa_quality;

  list($width_orig, $height_orig) = getimagesize($pa_setup["album_dir"].$var1);

  if( $pa_quality["photo_size"] > 0){

	$image_low_size=$pa_quality["photo_size"];
  	
  	if($pa_quality["resize_if_bigger"]=="true"){
  		if( ($width_orig <= $image_low_size && $pa_quality["resize_photo_to_fit"]=="width") ||
  			($height_orig <= $image_low_size && $pa_quality["resize_photo_to_fit"]=="height") ||
  			($width_orig <= $image_low_size && $height_orig <= $image_low_size && $pa_quality["resize_photo_to_fit"]=="both")
  		  ){
			  	return Array($width_orig,$height_orig,false);
  		  }
  	}
  	if($pa_quality["resize_photo_to_fit"]=="both"){
		$width=$image_low_size;
		$height=$image_low_size;
		// Get new dimensions
		if ($width_orig < $height_orig) {
		   $width = ($height / $height_orig) * $width_orig;
		} else {
		   $height = ($width / $width_orig) * $height_orig;
		}
  	}
  	if($pa_quality["resize_photo_to_fit"]=="width"){
  		$width=$image_low_size;
  		$height = ($width / $width_orig) * $height_orig;
  	}  	
  	if($pa_quality["resize_photo_to_fit"]=="height"){
  		$height=$image_low_size;
  	    $width = ($height / $height_orig) * $width_orig;
  	}  	
	return Array($width,$height,true);
  }else{
    	return Array($width_orig,$height_orig,false);
  }
}
function generate_image($var1,$quality,$original=false){

 global $pa_quality,$pa_setup;
  $var1=stripslashes($var1);
  $m_time=filemtime($pa_setup["album_dir"].$var1);
  //$headers=getallheaders(); --not supported by others then apache
  if (isset( $_SERVER["HTTP_IF_MODIFIED_SINCE"] ) ){
	if ( date("D, d M Y H:i:s T",$m_time) == $_SERVER["HTTP_IF_MODIFIED_SINCE"] ) {
		send_header('HTTP/1.0 304 Not Modified');
		exit; 
	}
  }


 if(is_image($var1)){
  // Content type
  send_header("Last-Modified: ".date("D, d M Y H:i:s T",$m_time));
  $mime=get_mime($var1);
  send_header("Content-type: ".$mime);
  send_header("Content-Disposition: filename=".conv_out_header(basename($var1))." ");

     list($width_orig, $height_orig) = getimagesize($pa_setup["album_dir"].$var1);
     list($width,$height,$resize) = get_resized_imagesize($var1);
  if((!$original) && ($resize || is_file($pa_quality["watermark_file"]))){
  	
	if($resize){
		$image_p = imagecreatetruecolor($width, $height);
		$image = imagecreatefrom($pa_setup["album_dir"].$var1);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	}else{
		$image_p = imagecreatefrom($pa_setup["album_dir"].$var1);
	}
	
	if(is_file($pa_quality["watermark_file"])){
		// should be placed a watermark
		list($width_wat,$height_wat) = getimagesize($pa_quality["watermark_file"]);
		$image_w=imagecreatefrom($pa_quality["watermark_file"]);
		
		$x_wat=$width/2-$width_wat/2;
		$y_wat=$height/2-$height_wat/2;
		
		if(strstr($pa_quality["watermark_position"],"L")){
			$x_wat=0;
		}
		if(strstr($pa_quality["watermark_position"],"R")){
			$x_wat=$width-$width_wat;
		}
		if(strstr($pa_quality["watermark_position"],"U")){
			$y_wat=0;
		}
		if(strstr($pa_quality["watermark_position"],"D")){
			$y_wat=$height-$height_wat;
		}
		imagecopy($image_p,$image_w,$x_wat,$y_wat,0,0,$width_wat,$height_wat);
		
	}
	 //$image_s=UnsharpMask($image_p, 20, 1,0);
	image_same_type($var1,$image_p,$pa_quality["photo_qual"]);
	return true; // cache it
  }else{
	pa_readfile($pa_setup["album_dir"].$var1);
	return false; //don't cache
  
  }
 }
 if(!is_image($var1)){
 	ob_end_clean();
	send_header("Content-type: application/download; name=\"".basename($var1)."\"");
	send_header("Content-Disposition: attachment; filename=\"".basename($var1)."\" ");
 	send_header("Content-Length: ".filesize($pa_setup["album_dir"].$var1)." ");
	send_header("Last-Modified: ".date("D, d M Y H:i:s T",$m_time)." " );
  send_header("Last-Modified: ".date("D, d M Y H:i:s T",$m_time)." " );
  pa_readfile($pa_setup["album_dir"].$var1);
  return false;
 }
}
/****************************************/
/*      DELTE CACHE                     */
/****************************************/

function delete_cache($cache_dir,$display=1){
   if ($dh = opendir($cache_dir)) {
       while (($file = readdir($dh)) !== false) {
           if($file != "." && $file!=".."){
	       unlink ( $cache_dir . $file);
           	if($display==1) echo "deleting : ".$cache_dir.$file."<br>";
           }
			
       }
       closedir($dh);
   }
} 
/****************************************/
/*      NEXT PREV IMAGE                 */
/****************************************/

function get_next_prev_image ($var1){
   global $pa_setup,$act_dir_sorting;
   $tmp="null";
       $dirname=dirname($var1);
       if($dirname=="."){
       	$dirname="";
       }else{
        $dirname.="/";
       }
   $dir_settings=get_directory_settings($dirname,0);
   $act_dir_sorting=$dir_settings[0]["sorting"];
   if($act_dir_sorting=='default'){
   	$act_dir_sorting=$pa_setup["default_sorting"];
   }
   $filelist=get_sorted_file_list($dir_settings[0]["seq_files"]);
   if(sizeof($filelist)>0) {

       while(list($key,$file_array)=each($filelist)){
       	    $file=$file_array["file_name"];
           	if ($file == basename($var1)){
           		if($tmp!="null"){
           			$names[]=$dirname.$tmp;
           		}else{
           			$names[]="null";
           		}
           	}
           	if($tmp==basename($var1)){
           			$names[]= $dirname.$file;
           			break;
           	}
        
         	$tmp=$file;
       }
       		if(sizeof($names)<2){
       			$names[]="null";
       		}
      }
       return $names;
   
	
}
function get_dir_from_photo_var($var){
		$dir=dirname($var);
		if($dir!="."){
			$dir="/".dirname($var)."/";
			$dir=str_replace("//","/",$dir);
		}else{
			$dir="/";
		}
		return $dir;	
}
function update_stats($for_what,$var,$var2,$var3=null){
	global $pa_setup;
	if($for_what=="imageview"){
		$dir=get_dir_from_photo_var($var);
		$file=basename($var);
		$rec=db_select_all("directory","path=='". prepdb($dir) ."'");
		$set="";
		if($var2=="view"){
			$set.="view_count=view_count+1;";
		}
		if($var2=="comment"){
			if($var3=="add"){
				$set.="comment_count=comment_count+1;";
			}else{
				$set.="comment_count=comment_count-1;";
			}
		}
		if($var2=="vote"){
			$set.="vote_count=vote_count+1;vote_avg=((vote_avg*vote_count)+$var3)/(vote_count+1);";
		}
	
		db_update("files_".$rec[0]["seq_files"],$set,"file_name=='".prepdb($file)."'");
		return;
	}
	
}
function exiftime_to_timestamp($string){
	// "YYYY:MM:DD HH:MI:SS"
	//  0123456789012345678
	return mktime(
		substr($string,11,2),
		substr($string,14,2),
		substr($string,17,2),
		substr($string,5,2),
		substr($string,8,2),
		substr($string,0,4));
		
}
function send_ecard($r_name,$r_email,$s_name,$s_email,$text,$var1){
		global $pa_setup;
		if($r_email=="") return t("ID_EMAIL_IS_MANDATORY");
		if($r_name=="")$r_name=$r_email;
		if($s_name=="")$s_name=t("ID_SOMEONE");
		$time=time();
		$hash=md5($r_name.$r_email.$time);
		$message=$pa_setup["ecard_text"];
		$subject=$pa_setup["ecard_subject"];
		$header = 'From: '.$s_email . "\r\n" .
				  'Reply-To: '.$s_email. "\r\n" .
				  'X-Mailer: PHP/' . phpversion();
		$message=str_replace("#FROM_NAME",$s_name,$message);
		$message=str_replace("#TO_NAME",$r_name,$message);
		$message=str_replace("#FROM_EMAIL",$s_email,$message);
		$message=str_replace("#TO_EMAIL",$r_email,$message);
		$message=str_replace("#TIME",date("H:i",$time),$message);
		$message=str_replace("#DATE",date("d.m.Y",$time),$message);
		$message=str_replace("#ECARD_ADRESS","main.php?cmd=ecardview&var1=$hash#ECARD",$message);
		$message=str_replace("#IMAGE_ADRESS","main.php?cmd=imageview&var1=".urlencode($var1),$message);
		$ret=mail($r_email,$subject,$message,$header);
		db_insert("ecards",Array("uid"=>$hash,"image"=>$var1,"from_name"=>$s_name,"from_email"=>$s_email,"to_name"=>$r_name,"to_email"=>$r_email,"message_text"=>$text,"created"=>$time,"picked_up"=>"false"));
		if($ret===true){
			return t("ID_YOUR_MESSAGE_WAS SENT");
		}else{
			return t("ID_PROBLEM_SENDING_MESSAGE");
		}
		
}
/****************************************/
/*      IMAGE VIEW                      */
/****************************************/

function generate_ecard_view($var1){
		global $pa_setup;
		$rec=db_select_all("ecards","uid=='".$var1."'");
		if(isset($rec[0])){
			$var3="view_ecard";
			$var1=$rec[0]["image"];
			$time=time();
			if($rec[0]["picked_up"]=="false"){
				//update ecard as viewed
				db_update("ecards","picked_up='true';","uid=='".$rec[0]["uid"]."'");
				//send email to sender that the ecard was picked up
				$message=$pa_setup["ecard_picked_text"];
				$subject=$pa_setup["ecard_picked_subject"];
				$header = 'From: '.$rec[0]["to_email"] . "\r\n" .
						  'Reply-To: '.$rec[0]["to_email"]. "\r\n" .
						  'X-Mailer: PHP/' . phpversion();
				$message=str_replace("#FROM_NAME",$rec[0]["from_name"],$message);
				$message=str_replace("#TO_NAME",$rec[0]["to_name"],$message);
				$message=str_replace("#FROM_EMAIL",$rec[0]["from_email"],$message);
				$message=str_replace("#TO_EMAIL",$rec[0]["to_email"],$message);
				$message=str_replace("#TIME",date("H:i",$time),$message);
				$message=str_replace("#DATE",date("d.m.Y",$time),$message);
				$message=str_replace("#ECARD_ADRESS","main.php?cmd=ecardview&var1=".$rec[0]["uid"]."#ECARD",$message);
				$message=str_replace("#IMAGE_ADRESS","main.php?cmd=imageview&var1=".urlencode($var1),$message);
				 mail($rec[0]["from_email"],$subject,$message,$header);
			}
			generate_image_view($var1,$quality,$var3,false,$rec[0]);	
		}else{
			theme_generate_error_page();
		}

}
function generate_image_view($var1,$quality,$var3,$newest=false,$ecard=null){
global $pa_quality,$pa_setup,$pa_theme,$cmd;
	
	$var1_orig=stripslashes($var1);
	$var1=stripslashes($var1);
	

	//computing the $var if this is showing the newest pictures.
	if ($pa_theme["directory_style"]=="flowing"){
	      $number_of_thmbs=$pa_theme["maximum_photos_per_page"];
	}else{
	      $number_of_thmbs=$pa_theme["raster_dir_x"]*$pa_theme["raster_dir_y"];
	}  
	if($newest===true){
		if($var1<0) $var1=0;//just to be sure :)
		if($var1=="") $var1=0;
		$position=$var1;
		$count=$number_of_thmbs;
		while($count < $position+2){
			$count+=$number_of_thmbs;
		}
		$newest_objects=get_newest_photos("/",$count+1);
		$var1=substr($newest_objects[$position]["path"],1).$newest_objects[$position]["file_name"];
	}
    ////////////////////////////////////////////////////////////end newweest
    $qq=$pa_quality["photo_size"]."_".$pa_quality["photo_qual"];
    if(is_file($pa_quality["watermark_file"])){
    	$qq.="_".$pa_quality["watermark_file"]."_".$pa_quality["watermark_position"];
    }
	
    if(file_exists($pa_setup["album_dir"].$var1)){
		list($width_orig, $height_orig) = getimagesize($pa_setup["album_dir"].$var1,$info);
		if (isset($info["APP13"])) {
			if(function_exists("iptcparse")){
				$iptc = iptcparse($info["APP13"]);
			}
		}

		$sys_par["width"]=$width_orig;
		$sys_par["height"]=$height_orig;
		$sys_par["size"]=filesize($pa_setup["album_dir"].$var1);
		$sys_par["time"]=filemtime($pa_setup["album_dir"].$var1);
		$sys_par["name"]=conv_out(basename($var1));
		$sys_par["link"]="main.php?cmd=imageorig&var1=".urlencode($var1);
		// exif stuff
		if(function_exists("read_exif_data")){
			$info= read_exif_data($pa_setup["album_dir"].$var1);
			//var_dump($info);
			if(isset($info["FNumber"])){
				$f_func=create_function('','$fnum=round('.$info["FNumber"].',1);return $fnum;');
				$sys_par["exif_f"]=number_format($f_func(),1);
			}
			if(isset($info["FocalLength"])){
				$fl_func=create_function('','$fl=round('.$info["FocalLength"].',1);return $fl;');
				$sys_par["exif_fl"]=number_format($fl_func(),1);
			}
	  		$sys_par["exif_model"]=$info["Model"];
			if(isset($info["ExposureTime"])){
				$e_func=create_function('','$fnum='.$info["ExposureTime"].';return $fnum;');
				$time=$e_func();
				if($time>0.25){
					$sys_par["exif_exp_time"]=$time;
				}else{
					$sys_par["exif_exp_time"]="1/".(1/$time);	
				}
				
			}
	  		$sys_par["exif_iso"]=$info["ISOSpeedRatings"];
	  		if(isset($info["DateTimeOriginal"])){
	  			$sys_par["exif_datetime"]=exiftime_to_timestamp($info["DateTimeOriginal"]);
	  		}else{
	  			if(isset($info["DateTime"])){
	  				$sys_par["exif_datetime"]=exiftime_to_timestamp($info["DateTime"]);	  				
	  			}
	  		}
		}
  		//var_dump($info);
    }
	
	$dir_path[0]['name']=t('ID_PHOTO_DIR');
	$dir_path[0]['link']="main.php?cmd=album&var2=".$quality;

	$dirs=explode('/',$var1);
	$act_dir="";
	for($i=0;$i<count($dirs)-1;$i++){
		$act_dir.=$dirs[$i]."/";
		$ss=get_directory_settings($act_dir,0);
		if(strlen($ss[0]["alias"])>0){
			$dir_path[$i+1]['name']=pa_html_decode($ss[0]["alias"]);
		}else{
			$dir_path[$i+1]['name']=conv_out($dirs[$i]);
		}
		$dir_path[$i+1]['link']="main.php?cmd=album&var1=".urlencode($act_dir)."&var2=".$quality;
		
	}
	
	$qualities=db_select_all("quality","enabled=='true'"); // select all enabled qualities
	$quality_links=Array();
	if(count($qualities)>1){
		foreach($qualities as $key=>$val){
			$quality_links[]=Array("name"=>$val["name"],
								   "link"=>"main.php?cmd=setquality&var1=".$val["id"]."&var2=$cmd&var3=".urlencode($var1_orig).get_keyword_parameter_for_link(),
								   "actual" => ($val["id"]==$pa_quality["id"])?1:0
								   );
		}
	}

/*testing for next and previous image ..*/
if($newest===true){
	if($position>=1){$prev_link="main.php?cmd=imageviewnew&var1=".($position-1).get_keyword_parameter_for_link();}else{$prev_link="";}
	if(isset($newest_objects[$position+1])){$next_link="main.php?cmd=imageviewnew&var1=".($position+1).get_keyword_parameter_for_link();}else{$next_link="";}
}else{
	list( $prev,$next) = get_next_prev_image($var1);
	if( $prev != "null" ) { 
		$prev_link = "main.php?cmd=imageview&var1=".urlencode($prev); 
	}else{
		$prev_link ="";
	};
	if( $next != "null" ) { 
		$next_link = "main.php?cmd=imageview&var1=".urlencode($next);
	}else{
		$next_link = "";
	};
}

list($width, $height) = get_resized_imagesize($var1);
$image_link="main.php?cmd=image&var1=".urlencode($var1)."&var2=".$qq;
$imageview_link="main.php?cmd=imageview&var1=".urlencode($var1);

    $sett_b=get_directory_settings(dirname("/".$var1),0);
    $sett=$sett_b[0];//dir settings
    
    $rec=db_select_all("files_".$sett["seq_files"],"file_name=='".prepdb(basename($var1))."'");
    $file=$rec[0];
   	$img_desc=$file["desc"];
    if($pa_theme["show_filenames"]=="true" && $img_desc==""){
    		$img_desc=conv_out(basename($var1));
    }
	$img_desc_long=$file["long_desc"];
	
      
 /* store typed comments*/
 if(!$var3){
 	update_stats("imageview",$var1,"view");
 }
  if($var3=="send_ecard"){
 	$security_checked=true;
	if($pa_setup["antispam_code_enabled"]=="true"){
	 	$rec=db_select_all("anti_spam_codes","pic_seq==".$_POST["p_code_seq"]);
		if($rec[0]["code"]==$_POST["p_code_enter"]){
			$security_checked=true;
		}else{
			$security_checked=false;
		}
		db_delete("anti_spam_codes","pic_seq==".$_POST["p_code_seq"]);
	}
	if($security_checked){
			send_ecard($_POST["p_recipient_name"],$_POST["p_recipient_email"],
					   $_POST["p_sender_name"],$_POST["p_sender_email"],
					   $_POST["p_your_message"],$var1);
	 	}
 	}
	

 if($var3=="save_comment"){
 	$security_checked=true;
	if($pa_setup["antispam_code_enabled"]=="true"){
	 	$rec=db_select_all("anti_spam_codes","pic_seq==".$_POST["p_code_seq"]);
		if($rec[0]["code"]==$_POST["p_code_enter"]){
			$security_checked=true;
		}else{
			$security_checked=false;
		}
		db_delete("anti_spam_codes","pic_seq==".$_POST["p_code_seq"]);
	}
	if($security_checked){
 	 	update_stats("imageview",$var1,"comment","add");
	 	if(isset($_POST['p_text'])){
	 		if(strlen($_POST['p_name'])==0){
	 				$p_name="Anonymous";
	 		}else{
	 			  $p_name=$_POST['p_name'];
	 		}
	 		if( isset($_POST['p_name']))setcookie("comment_name",$_POST['p_name'],time()+60*60*24*365);
	 		if( isset($_POST['p_email']))setcookie("comment_email",$_POST['p_email'],time()+60*60*24*365);
	 		save_comment($var1,$_POST['p_text'],$p_name,$_POST['p_email'],time());
	 	}
 	}
 }
 if(substr($var3,0,15)=="delete_comment-"){
      update_stats("imageview",$var1,"comment","del");
 	  $id=substr($var3,15);
 	  delete_comment($var1,$id);
 }
$comments=get_comments($var1);

/*parameters*/
	$rec=db_select_all("photo_param");
	
	if($rec)foreach($rec as $param){
	 if($sett["show_parameters"]=="default" && $param["default_displayed"]=="true" ||
	   isset($sett["show_parameters_custom_id"][$param["id"]])
	  ){
		
		if($param["type"]=="user"){
			if(isset($file["params"][$param["id"]]) && strlen($file["params"][$param["id"]])>0 ){
				$parameters[$param["name"]]=$file["params"][$param["id"]];
			}elseif(isset($param["default"]) && strlen($param["default"])>0){
				$parameters[$param["name"]]=$param["default"];
			}
		}
		if($param["type"]=="userlov"){
			if(isset($file["params"][$param["id"]]) && $file["params"][$param["id"]]>=0 ){
				$parameters[$param["name"]]=$param["lov"][$file["params"][$param["id"]]];
			}elseif(isset($param["default_lov"]) && $param["default_lov"] >=0){
				$parameters[$param["name"]]=$param["lov"][$param["default_lov"]];
			}
		}
		if($param["type"]=="system"){
				/*"dim"=>"Picture dimensions",
				  "siz"=>"File size in KB",
				  "cdt"=>"Creation date of picture",
				  "fnm"=>"Filename",
				  "fnl"=>"Filename with fullsize download link",
				  "dwl"=>"Fullsize download link"*/
			switch($param["default_lov"]){
				case "siz":
					$parameters[$param["name"]]=t("ID_SYS_PAR_SIZ",round($sys_par["size"]/1024,1));
					break;
				case "dim":
					$parameters[$param["name"]]=t("ID_SYS_PAR_DIM",$sys_par["width"],$sys_par["height"]);
					break;
				case "fnm":
					$parameters[$param["name"]]=t("ID_SYS_PAR_FNM",$sys_par["name"]);
					break;
				case "fnl":
					$parameters[$param["name"]]=t("ID_SYS_PAR_FNL",$sys_par["link"],$sys_par["name"]);
					break;
				case "dwl":
					$parameters[$param["name"]]=t("ID_SYS_PAR_DWL",$sys_par["link"]);
					break;
				case "cdt":
					$parameters[$param["name"]]=t("ID_SYS_PAR_CDT",date($pa_setup["date_format"],$sys_par["time"]));
					break;
				case "exif_iso":
					if(isset($sys_par["exif_iso"]))
						$parameters[$param["name"]]=t("ID_SYS_PAR_EXIF_ISO",$sys_par["exif_iso"]);
					break;
				case "exif_f":
					if(isset($sys_par["exif_f"]))
						$parameters[$param["name"]]=t("ID_SYS_PAR_EXIF_F",$sys_par["exif_f"]);
					break;
				case "exif_fl":
					if(isset($sys_par["exif_fl"]))
						$parameters[$param["name"]]=t("ID_SYS_PAR_EXIF_FL",$sys_par["exif_fl"]);
					break;
				case "exif_model":
					if(isset($sys_par["exif_model"]))
						$parameters[$param["name"]]=$sys_par["exif_model"];
					break;
				case "exif_exp_time":
					if(isset($sys_par["exif_exp_time"]))
						$parameters[$param["name"]]=t("ID_SYS_PAR_EXIF_EXP_TIME",$sys_par["exif_exp_time"]);
					break;
				case "exif_datetime":
					if(isset($sys_par["exif_datetime"])){
						$parameters[$param["name"]]=date($pa_setup["date_format"],$sys_par["exif_datetime"]);
					}
					break;
				case "iptc_caption":
					if(isset($iptc["2#120"])){
						$parameters[$param["name"]]=$iptc["2#120"][0];
					}
					break;
				case "iptc_caption_writer":
					if(isset($iptc["2#122"])){
						$parameters[$param["name"]]=$iptc["2#122"][0];
					}
					break;
				case "iptc_headline":
					if(isset($iptc["2#105"])){
						$parameters[$param["name"]]=$iptc["2#105"][0];
					}
					break;
				case "iptc_spec_ins":
					if(isset($iptc["2#040"])){
						$parameters[$param["name"]]=$iptc["2#040"][0];
					}
					break;
				case "iptc_byline":
					if(isset($iptc["2#080"])){
						$parameters[$param["name"]]=$iptc["2#080"][0];
					}
					break;
				case "iptc_byline_title":
					if(isset($iptc["2#085"])){
						$parameters[$param["name"]]=$iptc["2#085"][0];
					}
					break;
				case "iptc_credits":
					if(isset($iptc["2#110"])){
						$parameters[$param["name"]]=$iptc["2#110"][0];
					}
					break;
				case "iptc_source":
					if(isset($iptc["2#115"])){
						$parameters[$param["name"]]=$iptc["2#115"][0];
					}
					break;
				case "iptc_object_name":
					if(isset($iptc["2#005"])){
						$parameters[$param["name"]]=$iptc["2#005"][0];
					}
					break;
				case "iptc_date":
					if(isset($iptc["2#055"])){
						$parameters[$param["name"]]=$iptc["2#055"][0];
					}
					break;
				case "iptc_city":
					if(isset($iptc["2#090"])){
						$parameters[$param["name"]]=$iptc["2#090"][0];
					}
					break;
				case "iptc_subloc":
					if(isset($iptc["2#092"])){
						$parameters[$param["name"]]=$iptc["2#092"][0];
					}
					break;
				case "iptc_state":
					if(isset($iptc["2#095"])){
						$parameters[$param["name"]]=$iptc["2#095"][0];
					}
					break;
				case "iptc_country":
					if(isset($iptc["2#101"])){
						$parameters[$param["name"]]=$iptc["2#101"][0];
					}
					break;
				case "iptc_otr":
					if(isset($iptc["2#103"])){
						$parameters[$param["name"]]=$iptc["2#103"][0];
					}
					break;
				case "iptc_category":
					if(isset($iptc["2#015"])){
						$parameters[$param["name"]]=$iptc["2#015"][0];
					}
					break;
				case "iptc_subcategory":
					if(isset($iptc["2#020"])){
						foreach($iptc["2#020"] as $key=>$value){
							if(isset($parameters[$param["name"]])){
								$parameters[$param["name"]]=$parameters[$param["name"]]." , ".$value;
							}else{
								$parameters[$param["name"]]=$value;
							}
						}
					}
					break;
				case "iptc_priority":
					if(isset($iptc["2#010"])){
						$parameters[$param["name"]]=$iptc["2#010"][0];
					}
					break;
				case "iptc_keyword":
					if(isset($iptc["2#025"])){
						foreach($iptc["2#025"] as $key=>$value){
							if(isset($parameters[$param["name"]])){
								$parameters[$param["name"]]=$parameters[$param["name"]]." , ". get_keyword_link($value);
							}else{
								$parameters[$param["name"]]=get_keyword_link($value);
							}
						}
					}
					break;
				case "iptc_copyright":
					if(isset($iptc["2#116"])){
						$parameters[$param["name"]]=$iptc["2#116"][0];
					}
					break;
			}
		}
	  }
	}

theme_generate_imageview_page($dir_path,$quality_links,$img_desc,$img_desc_long,$next_link,$prev_link,$image_link,$imageview_link,$width,$height,$var3,$comments,$parameters,$ecard);
}
function approve_comment($var1,$id){
	global $pa_grants;
if(isset($pa_grants["comments"])){
	$dir=get_dir_from_photo_var($var1);
	$file=basename($var1);
	$rec=db_select_all("directory","path=='". prepdb($dir) ."'");
	db_update("comments_".$rec[0]["seq_files"],"visible='true';","id=='".$id."'");
	db_delete("new_comments","id=='".$id."'");
 }
}
function delete_comment($var1,$id){
	global $pa_grants;
 if(isset($pa_grants["comments"])){
	$dir=get_dir_from_photo_var($var1);
	$file=basename($var1);
	$rec=db_select_all("directory","path=='". prepdb($dir) ."'");
	db_delete("comments_".$rec[0]["seq_files"],"id=='".$id."'");
	db_delete("new_comments","id=='".$id."'");
 }
}
function save_comment($var1,$text,$name,$email,$time){
	global $pa_setup;
	$t_text=pa_html_encode(stripslashes($text));
	$t_text=str_replace("\n","<br/>",$t_text);
	$t_text=str_replace("\r","",$t_text);
	
	$dir=get_dir_from_photo_var($var1);
	$file=basename($var1);

	$rec=db_select_all("directory","path=='". prepdb($dir) ."'");
	$id=db_get_seq_nextval("comment_id");
	$visible_flag=$pa_setup["publish_only_approved_comments"]=="true"?"false":"true";
	db_insert("comments_".$rec[0]["seq_files"],Array(
		"id"=>$id,
		"file_name"=>$file,
		"name"=>pa_html_encode($name),
		"time"=>$time,
		"email"=>pa_html_encode($email),
		"text"=>$t_text,
		"visible"=>$visible_flag
	));
	$new_comments=db_select_all("new_comments",null,"time",true);
	if(count($new_comments)>=$pa_setup["comments_approve_queue_size"]){
		db_delete("new_comments","id==".$new_comments[0]["id"]);
	}
	db_insert("new_comments",Array(
	    "seq_files"=>$rec[0]["seq_files"],
		"id"=>$id,
		"pic_link"=>$var1,
		"file_name"=>$file,
		"name"=>pa_html_encode($name),
		"time"=>$time,
		"email"=>pa_html_encode($email),
		"text"=>$t_text
	));
	db_commit();
}

function get_comments($var1){
	$dir=get_dir_from_photo_var($var1);
	$file=basename($var1);

	$rec=db_select_all("directory","path=='". prepdb($dir) ."'");
	$comments=db_select_all("comments_".$rec[0]["seq_files"],"file_name=='".prepdb($file)."' && visible=='true'","time-");
	return $comments;
}
function get_all_comments(){
	global $data_dir;
	$comments=db_select_all("new_comments",null);
	return $comments;
}

/****************************************/
/*      FOOTER                          */
/****************************************/

function generate_footer(){
     echo "<table width=\"100%\"><tr height=\"100\"><td valign=\"bottom\" align=\"center\" width=\"100%\"><font size=\"2\">Powered by <a class=\"me\"href=\"http://www.phpalbum.net\"><font size=\"2\">PHP Photo Album</font></a></font></td></tr></table>";
     echo "</body></html>";

}

function check_writable($dir){
     $file=fopen($dir."writablity_test","w");
     fclose($file);
//     unlink($dir."writablity_test");
     return $file;
}

function write_log(){
global $pa_setup,$cmd,$var1,$passwd,$pa_user;
	if($pa_setup["logs_enabled"]=="true"){
	  $strings=explode(";",$pa_setup["logs_exclude"]);
	  $found="false";
	  $host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
	  foreach($strings as $num=>$string){
	  	if(strlen($string)>0)
	  		if(strstr($host,$string))$found="true";
	  }
	  if($found=="false"){
	  	$file_log=fopen($pa_setup["cache_dir"].$pa_setup["logs_filename"],"a");
	  	fwrite($file_log,date("D.M.j G:i:s")."|".$cmd."|".$var1."|".$pa_user["name"]."|".$host."|\n");
	  	fclose($file_log);
	  }
	}
}

function generate_theme($var1){
	if($var1=="style_css"){
		theme_get_style_css();
		return;
	}
}

function install_database(){
	global $data_dir,$phpalbum_version,$init_album_dir,$init_cache_dir,$init_ftp_server,$init_ftp_photos_dir;
	require("install_db.php");
}

/****************************************/
/*      Start Program v0.               */
/****************************************/


if (!get_magic_quotes_gpc()) {
		//doing magic quotes manually, some servers does not have this setting
		foreach($_GET as $key=>$value){
			$_GET[$key]=addslashes($value);
		}
		foreach($_POST as $key=>$value){
			$_POST[$key]=addslashes($value);
		}
		foreach($_COOKIE as $key=>$value){
			$_COOKIE[$key]=addslashes($value);
		}
	
} 
if(isset($_GET['cmd'])){
	$cmd=$_GET['cmd'];
}
if(isset($_GET['keyword'])){
	$pa_keywords=explode(" ",$_GET['keyword']);
	foreach($pa_keywords as $key=>$value){
		if(strlen(trim($value))==0){
				unset($pa_keywords[$key]);
		}
	}
	$pa_original_keywords=$_GET['keyword'];
	$pa_keywords_unsorted=$pa_keywords;
}
if(isset($_GET['var1'])){
	$var1=stripslashes($_GET['var1']);
}
if(isset($_GET['var2'])){
	$var2=stripslashes($_GET['var2']);
}
if(isset($_GET['var3'])){
	$var3=stripslashes($_GET['var3']);
}
if(isset($_GET['var4'])){
	$var4=stripslashes($_GET['var4']);
}


if(isset($_POST['cmd'])){
	$cmd=$_POST['cmd'];
}
if(isset($_POST['keyword'])){
	$pa_keywords=explode(" ",$_POST['keyword']);
}
if(isset($_POST['var1'])){
	$var1=$_POST['var1'];
}
if(isset($_POST['var2'])){
	$var2=$_POST['var2'];
}
if(isset($_POST['var3'])){
	$var3=$_POST['var3'];
}
if(isset($_POST['var4'])){
	$var4=$_POST['var4'];
}


if($cmd!="album" &&
$cmd!="albumnew" &&
$cmd!="phpinfo" &&
$cmd!="thmb" &&
$cmd!="imageorig" &&
$cmd!="image" &&
$cmd!="imageview" &&
$cmd!="ecardview" &&
$cmd!="imageviewnew" &&
$cmd!="setup" &&
$cmd!="delcache" &&
$cmd!="logo" &&
$cmd!="theme" &&
$cmd!="themeimage" &&
$cmd!="antispampic" &&
//$cmd!="system_check" &&
$cmd!="setquality"){

$cmd="album";
}

require("phpdatabase.php");
/*if(!db_startup_database("album",$data_dir)){
	install_database();
}*/

if(!db_startup_database("album",$data_dir)){
	db_create_database("album",$data_dir);
	install_database();	
}
db_set_auto_commit(false);
$pa_db_version=db_select_all("phpalbum_version");
if(!isset($pa_db_version[0]) || $pa_db_version[0]["version"]!=$phpalbum_version){
	include "upgrade_db.php";
}
read_settings();

require($themes_dir."engines/".$site_engine."/engine.php");
require("language.php");

if($cmd=="setquality"){
	$var1=(int)$var1;
	if(!($rec=db_select_all("quality","id=='$var1'"))){
		//setted quality not found
		$rec=db_select_all("quality","default=='true'");
	}
	
		$pa_quality=$rec[0];
	setcookie("phpAlbum_quality",$pa_quality["id"],time()+60*60*24*365);
	$cmd=$var2;$var1=$var3;$var2="";$var3="";
	if(isset($var3)){ $var2=$var3;}
	if(isset($var4)){ $var3=$var4;}
}else{
	if(isset($_COOKIE["phpAlbum_quality"])){
		if(!($rec=db_select_all("quality","id=='".$_COOKIE["phpAlbum_quality"]."'"))){
			//setted quality not found
			$rec=db_select_all("quality","default=='true'");
		}
	}else{
		$rec=db_select_all("quality","default=='true'");
	}
	$pa_quality=$rec[0];
}
    //remove leading slashes
	while(substr($var1,0,1)=="/"){
		$var1=substr($var1,1);
	}

	//remove slashes on the end of var1
	while(substr($var1,-1)=="/"){
		$var1=substr($var1,0,-1);
	}

if(strstr($var1,"..") || strstr($var1,"//")){
  $var1="";
}
if(isset($_GET["logout"])){
			setcookie("userid","",time()-60*60*24*365);
			setcookie("userpassword","",time()-60*60*24*365);
	
}else{
	if(isset($_COOKIE['userid'])){
		$userid=$_COOKIE['userid'];
	}
	if(isset($_COOKIE['userpassword'])){
		$userpassword=$_COOKIE['userpassword'];
	}
}

if(isset($_POST["p_username"])){
	$username=$_POST["p_username"];
	$userpassword=md5($_POST["p_userpassword"]);
	$rec=db_select_all("user","name=='".$username."' && password=='".$userpassword."'");
	if(isset($rec[0])){
		$pa_user=$rec[0];
		if(!isset($_POST["p_storepassword"])){
			setcookie("userid",$pa_user["id"]);
			setcookie("userpassword",$userpassword);
		}else{
			setcookie("userid",$pa_user["id"],time()+60*60*24*365);
			setcookie("userpassword",$userpassword,time()+60*60*24*365);
		}
	}else{
		$pa_user=Array("name"=>"guest","groups"=>Array("guest"=>"1"));
	}
}else{
	$rec=db_select_all("user","id=='".$userid."' && password=='".$userpassword."'");
	if(isset($rec[0])){
		$pa_user=$rec[0];
		$comment_name=$pa_user["name"];
		$comment_email=$pa_user["email"];
	}else{
		$pa_user=Array("name"=>"guest","groups"=>Array("guest"=>"1"));
		$comment_name=$_COOKIE["comment_name"];
		$comment_email=$_COOKIE["comment_email"];
	}
}
//take all groups where the user is a member
//and merge the grants to be easy to check it later if needed
$where="";
foreach($pa_user["groups"] as $key => $value){
	if($where ==""){
		$where = $where . "name=='".$key."'";
	}else{
		$where = $where . " || name=='".$key."'";
	}
}
$rec=db_select_all("group",$where);
$pa_grants=Array();
if(is_array($rec)){
 foreach($rec as $record){
	if(is_array($record["grants"])){
		$pa_grants =array_merge($pa_grants,$record["grants"]);
	}
 }
}
/*security check, either if it is disabled for actual user or it is not visible.*/
/*if accessed trough direct link it will be redirected to show the root directory*/
if($cmd=="album"){
	$pa_dir_settings = get_directory_settings($var1,0);
	if(!check_access_to_dir($var1) || $pa_dir_settings[0]["visibility"]=="false"){
  		$var1=""; // show the root directory.
  		$var2="";
  		$var3="";
  		$cmd="album";
	}
}else if($cmd=="imageview" || $cmd=="thmb" || $cmd=="image"){
	$pa_dir_settings = get_directory_settings(dirname($var1),0);
	if(!check_access_to_dir(dirname($var1)) || $pa_dir_settings[0]["visibility"]=="false"){
  		$var1=""; // show the root directory.
  		$var2="";
  		$var3="";
  		$cmd="album";
	}
}


$this_is_cachable=false;
	
if(is_cachable($cmd,$var1)) {
	$this_is_cachable=true;
	if(is_cached($cmd,$var1,$var2,$var3,$quality)) {
		load_from_cache($cmd,$var1,$var2,$var3,$quality);
		//echo "<br>Loaded from cache";
		return;
	}
}

/*header("Last-Modified: ".date("D, d M Y H:i:s T",time()) ); */
/*testing for php-info*/
$cache_this_doc=true;
if($this_is_cachable){ob_start();}
/*testing for password */
if($cmd=="phpinfo"){
	phpinfo();
}else if($cmd=="album"){
	write_log();
        $cache_this_doc=generate_album($var1,$var3);	
}else if($cmd=="albumnew"){
	write_log();
        $cache_this_doc=generate_albumnew($var1,$var3);	
}else if($cmd=="thmb"){
        generate_thumb($var1,$var3);	
}else if($cmd=="image"){
	if(is_movie($var1) || is_audio($var1)){
		write_log();
	}
        $cache_this_doc=generate_image($var1,$quality);/* original photos, videos and audios should not be cached.*/
}else if($cmd=="imageorig"){
	if(isset($pa_grants["imageorig"])){
		write_log();
        $cache_this_doc=generate_image($var1,$quality,true);/* original photos, videos and audios should not be cached.*/
	}else{
		theme_generate_error_page();
	}
}else if($cmd=="imageview"){
	if(isset($pa_grants["imageview"])){
		write_log();
        generate_image_view($var1,$quality,$var3);	
	}else{
		theme_generate_error_page();
	}
}else if($cmd=="ecardview"){
	if(isset($pa_grants["imageview"])){
		write_log();
		generate_ecard_view($var1);
	}else{
		theme_generate_error_page();
	}
}else if($cmd=="imageviewnew"){
	if(isset($pa_grants["imageview"])){
		write_log();
        generate_image_view($var1,$quality,$var3,true);	
	}else{
		theme_generate_error_page();
	}
}else if($cmd=="setup"){
		include("setup.php");
        generate_setup_page();
}else if($cmd=="system_check"){
        generate_system_check();
}else if($cmd=="delcache"){
        delete_cache($pa_setup["cache_dir"]);
        echo "Cache Deleted!";
}else if($cmd=="theme"){
	generate_theme($var1);
}else if($cmd=="logo"){
	theme_generate_logo();
}else if($cmd=="antispampic"){
	header("Content-type: image/jpeg");
	pa_readfile($pa_setup["cache_dir"]."cp".$var1.".jpg");
	@unlink($pa_setup["cache_dir"]."cp".$var1.".jpg");
}else if($cmd=="themeimage"){
	if(!isset($var3)){$var3=100;}//no scaling if not defined
	$cache_this_doc=theme_generate_theme_image($var1,$var2,$var3);
}else{
	theme_generate_error_page();
}
/*caching output*/
db_commit();// just to be sure
if($this_is_cachable){
  if(is_cachable($cmd,$var1) && $cache_this_doc){
	 cache_document($cmd,$var1,$var2,$var3,$quality);
  }
  while (ob_get_level() > 0) {
    ob_end_flush();
}
}
/*full-scanning directories evry 1 day*/
if($pa_setup["last_dir_scan"]<time()-24*60*60 && is_dir($pa_setup["album_dir"])){
	scan_photos_directories("");
	delete_old_ecards();
	delete_old_anitspam();
}
