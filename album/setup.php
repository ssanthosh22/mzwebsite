<?php
	/*checking for security reasons*/
if(!defined("PHPALBUM_APP")){
	die("Direct access not permitted!");
}


/****************************************/
/*      SETUP COMMAND                   */
/****************************************/
function get_dir_size($dir){
 $list = dir($dir);
 $size=0;
 if($list){
	 while ($filename = $list->read()){
	  if ($filename == '.' || $filename == '..')
	   continue;
	   $size=$size+filesize($dir.$filename);
	 }
 }
 return $size;
}

function generate_setup_page(){
global $var1;
global $var2;
global $var3;
global $var4;
global $data_dir,$site_engine,$themes_dir,$pa_theme,$pa_color_map;
global $phpalbum_version;
global $pa_texts,$pa_translated_texts;
global $pa_setup,$pa_lang,$pa_user,$pa_grants;
////////menu generating/////////////
if (PHPALBUM_APP=="DEMO" && !isset($pa_user["groups"]["superuser"])){
	$demo_mode=true;
}else{
	$demo_mode=false;
}
if(isset($pa_user["name"])){
$menus=Array("user"=>t("ID_SETUP_MY_ACCOUNT"),
			"main"=>t("ID_SETUP_MENU_MAIN"),
		    "themes"=>t("ID_SETUP_MENU_THEMES"),
		    "thumbnails"=>t("ID_SETUP_MENU_THUMBNAILS"),
			 "dirs"=>t("ID_SETUP_MENU_DIRS"),
			 "pics"=>t("ID_SETUP_MENU_PICS"),
			 "params"=>t("ID_SETUP_MENU_PARAMS"),
			 "users"=>t("ID_SETUP_MENU_USERS"),
			 "groups"=>t("ID_SETUP_MENU_GROUPS"),
			 "admin"=>t("ID_SETUP_MENU_ADMIN"),
			 "comments"=>t("ID_SETUP_MENU_COMMENTS"),
			 "ecard"=>t("ID_SETUP_MENU_ECARD"),
			 "texts"=>t("ID_SETUP_MENU_TEXTS"),
			 "cache"=>t("ID_SETUP_MENU_CACHE"),
			 "logs"=>t("ID_SETUP_MENU_LOGS"),
			 "errorlog"=>t("ID_SETUP_MENU_ERRORLOG"),
			 //"syscheck"=>t("ID_SETUP_MENU_SYSCHECK"),
			 );
}else{
	$menus=Array("my_account"=>t("ID_SETUP_MY_ACCOUNT"));
	$var1="user";
	if($pa_user["name"]=="guest"){
		$var2="insert";
	}
}
//filter out menu where no grants exists
foreach($menus as $key => $value){
	if(!isset($pa_grants[$key]) && $key!="user"){
		unset($menus[$key]);
		if($var1==$key){
			$var1="user";
			$var2="";
		}
	}
}
//generate menu table
$menu="<table><tr><td class=\"boxhead\">".t("ID_SETUP_MENU")."</td></tr>\n";
if($var1==""){
	$var1="user";
}
foreach($menus as $cmd=>$text){
	if($cmd==$var1){
		$menu.="<tr><td nowrap class=\"menu_selected\">&nbsp;<a href=\"main.php?cmd=setup&var1=$cmd\">$text</a></td></tr>\n";
	}else{
		if(($cmd =="pics" || $cmd == "dirs") && ($var1=="pics" || $var1=="dirs")){
			$menu.="<tr><td nowrap class=\"menu\">&nbsp;<a href=\"main.php?cmd=setup&var1=$cmd&var2=chdir&var3=$var3\">$text</a></td></tr>\n";
		}else{
			$menu.="<tr><td nowrap class=\"menu\">&nbsp;<a href=\"main.php?cmd=setup&var1=$cmd\">$text</a></td></tr>\n";
		}
	}
}
$menu.="<tr><td nowrap class=\"menu\">&nbsp;<a class=\"red\" href=\"main.php?cmd=album&logout\">".t("ID_LOGOUT")."</a></td></tr>\n";

$menu.="<tr><td nowrap class=\"menu\"><a class=\"green\" href=\"main.php?cmd=album\"><h1>&lt;&lt;&lt;&nbsp;&nbsp;&nbsp;Album</h1></a></td></tr>\n";
$menu.="</table>";
///////end generating menu//////////
if($var1=="params"){
	if($var2=="save"){
		if(isset($_POST["p_lov_edit"])){
			$lov=Array();
			foreach($_POST as $key=>$value){
				if(substr($key,0,12)=="p_lov_value_"){
					$lov[substr($key,12)]=$value;				
				}
			}
			if(strlen($_POST["p_lov_new"])>0){
				$lov[]=$_POST["p_lov_new"];
			}
			if(!$demo_mode)db_update("photo_param","lov=".var_export($lov,true).";","id==".$_POST["p_lov_edit"]);
		}
		$cnt=1;
		while(isset($_POST["p_id$cnt"])){
			$set="";
			if(strlen($_POST["p_name$cnt"])>0){
				$set.="name='".$_POST["p_name$cnt"]."';";
			}
			if(isset($_POST["p_default$cnt"])){
				$set.="default='".$_POST["p_default$cnt"]."';";
			}
			if(isset($_POST["p_default_lov$cnt"])){
				$set.="default_lov=".$_POST["p_default_lov$cnt"].";";
			}
			if(isset($_POST["p_allow_html$cnt"])){
				$set.="allow_html='true';";
			}else{
				$set.="allow_html='false';";
			}
			if(isset($_POST["p_default_displayed$cnt"])){
				$set.="default_displayed='true';";
			}else{
				$set.="default_displayed='false';";
			}
			if(!$demo_mode)db_update("photo_param",$set,"id==".$_POST["p_id$cnt"]);
			$cnt++;
		}
	}
	if($var2=="dellov"){
		if(!$demo_mode)db_update("photo_param","unset(lov[$var4]);","id==$var3");
	}
	if($var2=="add"){
		$noerrors=true;
		if(strlen($_POST["p_name"])==0){
			$errors[]=t("ID_MSG_PARAM_MANDATORY");
			$err_name=" error";
			$noerrors=false;
		}
		$rec=db_select_all("photo_param","name=='".$_POST["p_name"]."'");
		if(isset($rec[0])){
			$errors[]=t("ID_MSG_PARAM_EXISTS",$_POST["p_name"]);
			$noerrors=false;
			$err_name=" error";
		}
		if($noerrors){
			$id=db_get_seq_nextval("photo_param_id");
			if(!$demo_mode)db_insert("photo_param",Array("id"=>$id,"name"=>$_POST["p_name"],"type"=>$_POST["p_type"]));
		}
	}
	if($var2=="del"){
		if(!$demo_mode)db_delete("photo_param","id==".$var3); //delete the parameter
	}
	ob_start();require("setup_params.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	return;
}
if($var1=="users"){
	if($var2=="delete"){
		if(!$demo_mode)db_delete("user","id==".$var3);
	}
	ob_start();require("setup_users.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	return;
}
if($var1=="groups"){
	if($var2=="delete"){
		if(!$demo_mode){
			if($var3!="guest" && $var3!="superuser")db_delete("group","name=='".prepdb($var3)."'");
		}
	}
	if($var2=="add"){
		if($_POST["p_new_group_name"]){
			$rec=db_select_all("group","name=='".$_POST["p_new_group_name"]."'");
			if(isset($rec[0])){
				$errors[]=t("ID_MSG_GROUP_EXISTS",$_POST["p_new_group_name"]);
				$err_group=" error";
				$new_group=$_POST["p_new_group_name"];
			}else{
				if(!$demo_mode)db_insert("group",Array("name"=>$_POST["p_new_group_name"]));
			}
		}
	}
	if($var2=="grant"){
		if(!$demo_mode)db_update("group","grants['".$var4."']='1';","name=='".prepdb($var3)."'");
	}
	if($var2=="revoke"){
		if(!$demo_mode)db_update("group","unset(grants['".$var4."']);","name=='".prepdb($var3)."'");
	}
	if($var2=="save"){
		// save changes on groups
		if(!$demo_mode)db_update("group","default='false';");	
		foreach($_POST as $key =>$value){
			if(substr($key,0,9)=="p_default"){
				if(!$demo_mode)db_update("group","default='true';","name=='".$value."';");
			}
		}
	}
	ob_start();require("setup_groups.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	return;
}
if($var1=="user"){
	$superuser=false;
	if(isset($pa_user["groups"]["superuser"])){
			$superuser=true;
	}
	if($var3>0){
		//editing users by superuser
		if(isset($pa_user["groups"]["superuser"])){
			$superuser=true;
			$rec=db_select_all("user","id==".$var3);
			if(isset($rec[0])){
				$pa_user=$rec[0];
			}
		}
	}
	if($var2=="update"){
		$set="";
		/*check for new name*/
		if($pa_user["name"]!=$_POST["p_username_f"]){
			$rec=db_select_all("user","name=='".$_POST["p_username_f"]."'");
			if(isset($rec[0]) || $_POST["p_username_f"]=="guest"){
				$errors[]=t("ID_MSG_USERNAME_EXISTS",$_POST["p_username_f"]);
				$err_name=" error";
			}else{
				$set.="name='".$_POST["p_username_f"]."';";
			}
		}
		if($_POST["p_password_f"]!=$_POST["p_retype_password_f"]){
			$errors[]=t("ID_MSG_PASSWORD_ERROR");
			$err_pass=" error";
		}else if($_POST["p_password_f"]!=""){
			$set.="password='".md5($_POST["p_password_f"])."';";
			if(!isset($var3)){
				setcookie("userpassword",md5($_POST["p_password_f"]));
			}
		}
		if($_POST["p_email_f"]==""){
			$errors[]=t("ID_MSG_EMAIL_REQUIRED");
			$err_email=" error";
		}else{
			$set.="email='".$_POST["p_email_f"]."';";
		}
		
		$set.="homepage='".$_POST["p_homepage_f"]."';";
		
		if($superuser){
			//check the groups
			$groups=Array();
			foreach($_POST as $key => $post){
				if(substr($key,0,7)=="p_group"){
					$groups[$post]="1";
				}
			}
			$set.="groups=".var_export($groups,true).";";
		}
		
		if(!$demo_mode)db_update("user",$set,"id==".$pa_user["id"]."");
		
		$rec=db_select_all("user","id==".$pa_user["id"]);
		$pa_user=$rec[0];
	
	}
	if($var2=="insert"){
		$noerrors=true;
		/*check for new name*/
		$pa_user["name"]=$_POST["p_username_f"];
		$rec=db_select_all("user","name=='".$_POST["p_username_f"]."'");
		if(isset($rec[0]) || $_POST["p_username_f"]=="guest"){
			$errors[]=t("ID_MSG_USERNAME_EXISTS",$_POST["p_username_f"]);
			$err_name=" error";
			$noerrors=false;
		}
		if(strlen($_POST["p_username_f"])==0){
			$errors[]=t("ID_MSG_USERNAME_MANDATORY");
			$err_name=" error";
			$noerrors=false;
		}
		
			
		if($_POST["p_password_f"]!=$_POST["p_retype_password_f"]){
			$errors[]=t("ID_MSG_PASSWORD_ERROR");
			$err_pass=" error";
			$noerrors=false;
		}else if($_POST["p_password_f"]!=""){
			$pa_user["password"]=md5($_POST["p_password_f"]);
		}else{
			$errors[]=t("ID_MSG_PASSWORD_REQUIRED");
			$err_pass=" error";
			$noerrors=false;
		}
		if($_POST["p_email_f"]==""){
			$errors[]=t("ID_MSG_EMAIL_REQUIRED");
			$err_email=" error";
			$noerrors=false;
		}
		$pa_user["email"]=$_POST["p_email_f"];
		
		$pa_user["homepage"]=$_POST["p_homepage_f"];
		
		if($noerrors){
			$var2="";
			$message=t("ID_THANKS_FOR_REGISTER");
			$pa_user["id"]=db_get_seq_nextval("user_id");
			$rec=db_select_all("group","default=='true'");
			foreach($rec as $record){
				$pa_user["groups"][$record["name"]]='1';
			}
			db_insert("user",$pa_user);
			setcookie("userpassword",$pa_user["password"]);
			setcookie("userid",$pa_user["id"]);
			//$rec=db_select_all("user","name=='".$username."' && password=='".$userpassword."'");
			//$pa_user=$rec[0];
		}
	
	}	
	ob_start();require("setup_user.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	return;
}
if($var1=="themes"){
	if($var2=="add_color"){
		$seq=db_get_seq_nextval("color_map_id");
		if(!$demo_mode)db_insert("color_map",Array("id"=>$seq));
		if(!$demo_mode)db_update("theme","color_map=".$seq,"name=='".$pa_setup["site_theme"]."'");
	}
	if($var2=="del_color"){
		if(!$demo_mode)db_delete("color_map","id==".$pa_color_map["id"]);
		$mm=db_select_all("color_map",null,"id");
		if(!$demo_mode)db_update("theme","color_map=".$mm[0]["id"],"name=='".$pa_setup["site_theme"]."'");
	}
	if($var2=="save"){
			if($_POST["p_theme"]!=$pa_setup["site_theme"]){
				if(!$demo_mode)db_update("setup","site_theme='".$_POST["p_theme"]."'");	
			}else{
				$set="logo_path='".$_POST['p_logo_path']."';";
				$set.="logo_text='".$_POST['p_logo_text']."';";
				$set.="logo_style='".$_POST['p_logo_style']."';";
				if(isset($_POST['p_show_filenames'] )){
					$set.="show_filenames='true';";
				}else{
					$set.="show_filenames='false';";
				}
				if(isset($_POST['p_disable_bottom_nextprev'] )){
					$set.="disable_bottom_nextprev='true';";
				}else{
					$set.="disable_bottom_nextprev='false';";
				}
				 $set.="directory_style='".$_POST['p_directory_style']."';";
		 		 $set.="maximum_photos_per_page='".$_POST['p_maximum_photos_per_page']."';";
				 $set.="raster_dir_x='".$_POST['p_raster_dir_x']."';";
				 $set.="raster_dir_y='".$_POST['p_raster_dir_y']."';";
				 $set.="picture_border_size='".$_POST["p_picture_border_size"]."';";
				 $set.="thumbnail_border_size='".$_POST["p_thumbnail_border_size"]."';";
				 $set.="dir_logo_style='".$_POST["p_dir_logo_style"]."';";
				 if(isset($_POST["p_dir_logo_size"])){
					 $set.="dir_logo_size='".$_POST["p_dir_logo_size"]."';";
				 }
				 if(isset($_POST["p_dir_logo_quality"])){
					 $set.="dir_logo_quality='".$_POST["p_dir_logo_quality"]."';";
				 }
				 if(isset($_POST["p_dir_logo_square_thumbnail"])){
				 	$set.="dir_logo_square_thumbnail='true';";
				 }else{
				 	$set.="dir_logo_square_thumbnail='false';";
				 }
				 if(isset($_POST["p_show_search_box"])){
				 	$set.="show_search_box='true';";
				 }else{
				 	$set.="show_search_box='false';";
				 }
				if(isset($_POST['p_display_shadows'] )){
					$set.="display_shadows='true';";
				}else{
					$set.="display_shadows='false';";
				}
				$set.="additional_thmb_height='".$_POST["p_additional_thmb_height"]."';";
				$set.="additional_thmb_width='".$_POST["p_additional_thmb_width"]."';";

				if(!$demo_mode)db_update("theme",$set,"name=='".$pa_setup["site_theme"]."'");
			}
			if($_POST["p_color_map"]!=$pa_theme["color_map"]){
				// color map was changed
				if(!$demo_mode)db_update("theme","color_map=".$_POST["p_color_map"],"name=='".$pa_setup["site_theme"]."'");
			}else{
				$set="bg_color='".$_POST["p_bg_color"]."';";
				$set.="link_color='".$_POST["p_link_color"]."';";
				$set.="dir_desc_color='".$_POST["p_dir_desc_color"]."';";
				$set.="photo_desc_color='".$_POST["p_photo_desc_color"]."';";
				$set.="border_color='".$_POST["p_border_color"]."';";
				$set.="logo_color='".$_POST["p_logo_color"]."';";
				$set.="name='".$_POST["p_color_name"]."';";
				if(!$demo_mode)db_update("color_map",$set,"id==".$pa_color_map["id"]);
			}
	}
    read_settings();
  	ob_start();require("setup_themes.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	return;
	
}
if($var1=="thumbnails" ){
		if($var2=="del"){
			if(!$demo_mode)db_delete("quality","id==".$var3);
		}
		if($var2=="add"){
			$seq=db_get_seq_nextval("seq_quality_id");
			if(!$demo_mode)db_insert("quality",Array("id"=>$seq));
		}
		if($var2=="save"){
			$q=db_select_all("quality");
			foreach($q as $rec){
				  $id=$rec["id"];
					if(isset($_POST["p_q_desc$id"])){
						$set= "name='".$_POST["p_q_desc$id"]."';";
						$set.="thmb_size='".$_POST["p_q_thmbs$id"]."';";
						if($_POST["p_q_thmbq$id"]<=0){
							$set.="thmb_qual='85';";
						}else{
							$set.="thmb_qual='".$_POST["p_q_thmbq$id"]."';";
						}
						$set.="photo_size='".$_POST["p_q_pics$id"]."';";
						if($_POST["p_q_picq$id"] <=0 ){
							$set.="photo_qual='85';";
						}else{
							$set.="photo_qual='".$_POST["p_q_picq$id"]."';";
						}
						$set.="resize_photo_to_fit='".$_POST["p_resize_photo_to_fit$id"]."';";
						$set.="watermark_file='".$_POST["p_watermark_file$id"]."';";
						$set.="watermark_position='".$_POST["p_watermark_position$id"]."';";
						$set.="thmb_sharp_amount='".$_POST["p_thmb_sharp_amount$id"]."';";
						$set.="thmb_sharp_radius='".$_POST["p_thmb_sharp_radius$id"]."';";
						//$set.="thmb_sharp_treshold='".$_POST["p_thmb_sharp_treshold$id"]."';";
						if($_POST["p_q_default"]==$rec["id"]){
							$set.="default='true';";
							$set.="enabled='true';";
						}else{
							$set.="default='false';";
							if(isset($_POST["p_q_enabled$id"])){
								$set.="enabled='true';";
							}else{
								$set.="enabled='false';";
							}
						}
						if(isset($_POST["p_q_resizeifbigger$id"])){
							$set.="resize_if_bigger='true';";
						}else{
							$set.="resize_if_bigger='false';";
						}
						if(isset($_POST["p_q_square_thumbnails$id"])){
							$set.="square_thumbnails='true';";
						}else{
							$set.="square_thumbnails='false';";
						}
						if(isset($_POST["p_thmb_sharp_use$id"])){
							$set.="thmb_sharp_use='true';";
						}else{
							$set.="thmb_sharp_use='false';";
						}
					
						if(isset($_POST["p_thmb_show_views$id"])){
							$set.="thmb_show_views='true';";
						}else{
							$set.="thmb_show_views='false';";
						}
						if(isset($_POST["p_thmb_show_comments$id"])){
							$set.="thmb_show_comments='true';";
						}else{
							$set.="thmb_show_comments='false';";
						}
						if(isset($_POST["p_thmb_show_votes$id"])){
							$set.="thmb_show_votes='true';";
						}else{
							$set.="thmb_show_votes='false';";
						}

					}
					if(!$demo_mode)db_update("quality",$set,"id==$id");
			}
			
			
		}
				/*check for at least one existing enabled and default*/
			$rec=db_select_all("quality");
			$default_found=false;
			$enabled_found=false;
			$id_found=false;
			foreach($rec as $qual){
				if($qual["default"]=="true"){
					$default_found=$qual["id"];
				}
				if($qual["enabled"]=="true"){
					$enabled_found=$qual["id"];
				}
				$id_found=$qual["id"];
			}
			if(!$enabled_found){
				if(!$default_found){
					if(!$demo_mode)db_update("quality","enabled='true';default='true'","id==$id_found");
				}else{
					if(!$demo_mode)db_update("quality","enabled='true'","id==$default_found");
				}
				
			}else{
				if(!$default_found){
					if(!$demo_mode)db_update("quality","default='true'","id==$enabled_found");
				}else{
					/*everything is ok*/
				}
			}

  	ob_start();require("setup_thumbnails.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	return;
}

if($var1=="main"){
	  if($var2=="save"){
	  		$set="";
			$p_pd=$_POST['p_album_dir'];
			$p_cd=$_POST['p_cache_dir'];
			$old_pd=$pa_setup["album_dir"];//storing for later comparsion.
			if(substr($p_cd,-1,1)!="/"){
				$p_cd=$p_cd."/";
			}
			if(substr($p_pd,-1,1)!="/"){
				$p_pd=$p_pd."/";
			}
			$set.="album_dir='".$p_pd."';";
			$set.="cache_dir='".$p_cd."';";
			$set.="site_name='".$_POST['p_site_name']."';";
			$set.="return_home_url='".$_POST['p_return_home_url']."';";
			$set.="new_dir_indic='".$_POST['p_new_dir_indic']."';";
			$set.="language='".$_POST['p_language']."';";
			$set.="date_format='".$_POST['p_date_format']."';";
			$set.="cookie_password_hours='".$_POST['p_cookie_password_hours']."';";
			//0.3.0
			 $set.="ftp_server='".$_POST['p_ftp_server']."';";
			 $set.="ftp_server_photos_dir='".$_POST['p_ftp_server_photos_dir']."';";
	     $set.="default_sorting='".$_POST['p_default_sorting']."';";
		 if(isset($_POST['p_use_iptc_desc'])){
			$set.="use_iptc_desc='true';";
		 }else{
			$set.="use_iptc_desc='false';";
		 }
		$set.="tracking_code='".$_POST['p_tracking_code']."';";
	     if(!$demo_mode)db_update("setup",$set);
			 read_settings();
		}
		//scan photodirectory if it was changed		
		if($old_pd!=$p_pd){
			scan_photos_directories("");
		}
//        /save_quality_settings();
		
  	ob_start();require("setup_main.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	  return;
}

	if($var1=="logs"){
	  if($var2=="save"){
	  	if(isset($_POST["p_enabled"])){
	  		$set="logs_enabled='true';";
	  	}else{
	  		$set="logs_enabled='false';";
	  	}
	  	$set.="logs_filename='".$_POST['p_filename']."';";
	  	$set.="logs_exclude='".$_POST['p_exclude']."';";
		if(!$demo_mode)db_update("setup",$set);		
		read_settings();
	  }
   	  ob_start();require("setup_logs.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	  return;
	}
	if($var1=="pics"){
		if(strlen($var3)==0){
			$rec=db_select_all("directory","path=='/'");
			$var3=$rec[0]["seq_files"];
		}
		if($var2=="scan_dirs"){
			if(!$demo_mode)scan_photos_directories("");
		}
		$params=db_select_all("photo_param");
		if($var2=="save"){
			$cnt=1;
			while( isset($_POST["p_file_name$cnt"])){
				$set="";
				$set.="desc='".($_POST["p_desc$cnt"])."';";
				$set.="long_desc='".($_POST["p_long_desc$cnt"])."';";
				if(isset($_POST["p_visible$cnt"])){
					$set.="visible='true';";
				}else{
					$set.="visible='false';";
				}
				if(isset($_POST["p_use_for_logo$cnt"])){
					$set.="use_for_logo='true';";
				}else{
					$set.="use_for_logo='false';";
				}
				
				//photo parameters
				$p=Array();
				foreach($params as $param){
					
					if(isset($_POST["p_param".$cnt."_".$param["id"]])){
					   $p[$param["id"]]=$_POST["p_param".$cnt."_".$param["id"]];
					}
				}
				
				$set.="params=".var_export($p,true).";";
				if(!$demo_mode)db_update("files_$var3",$set,"file_name=='".$_POST["p_file_name$cnt"]."'");
				$cnt++;
			}
		}
	  ob_start();require("setup_photos.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	  return;
	}
	if($var1=="dirs"){
		if(strlen($var3)==0){
			$rec=db_select_all("directory","path=='/'");
			$var3=$rec[0]["seq_files"];
		}
		if($var2=="scan_dirs"){
			if(!$demo_mode)scan_photos_directories("");
		}
		if($var2=="save"){
			invalidate_object_cache("GNP"); //invalidate cache (what if groups has been changed)
			/*save settings*/
			$rec=db_select_all("directory","seq_files=='$var3'",null,true);
			$dir=$rec[0];
			$set="alias='".$_POST["p_alias"]."';";
			if(isset($_POST["p_visibility"])){
				$set.="visibility='true';";
			}else{
				$set.="visibility='false';";
			}
			$set.="desc='".$_POST["p_desc"]."';";
			$set.="long_desc='".$_POST["p_long_desc"]."';";
			$set.="sorting='".$_POST["p_sorting"]."';";
			$set.="show_parameters='".$_POST["p_show_parameters"]."';";
			$set.="show_newest_pictures_count='".$_POST["p_show_newest_pictures_count"]."';";
			if($_POST["p_show_parameters"]=="custom" && isset($_POST["p_default"])){
				//switched from default to custom, select default params as default
				$rec=db_select_all("photo_param","default_displayed=='true'");
				foreach($rec as $param){
					$set_custom_ids[$param["id"]]='1';
				}
			}else{
				foreach($_POST as $key => $post){
						if(substr($key,0,7)=="p_param"){
							$set_custom_ids[$post]='1';
					    }
				}
			}
			$set.="show_parameters_custom_id=".var_export($set_custom_ids,true ).";";
			//groups
			$set_inh="";
			//select all groups
			$grps=db_select_all("group");
			foreach($grps as $group){
				$group_found=false;
				foreach($_POST as $key => $post){
					if(substr($key,0,7)=="p_group" && $post==$group["name"]){
						if(!isset($dir["inh_groups"][$post])){
							//if it was not inherited then
							$new_groups[$post]="1";
							$set_inh.="if(!isset(inh_groups[$post])){inh_groups[$post]=$var3;}";
							$group_found=true;
					    }
				    }
				}
				if(!$group_found){
					$set_inh.="if(inh_groups[".$group["name"]."]==$var3){unset(inh_groups[".$group["name"]."]);}";
					
				}
			}
			$set.="groups=".var_export($new_groups,true).";";
			if(!$demo_mode)db_update("directory",$set,"seq_files=='$var3'");
			
			//$set_inh="inh_groups=".var_export($inh_groups,true).";";
			$len=strlen($dir["path"]);
			if(!$demo_mode)db_update("directory",$set_inh,"substr(path,0,$len)=='".$dir["path"]."' && path!='".$dir["path"]."'");
			
			
		}
   	  ob_start();require("setup_dirs.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	  return;
	}
	
	if($var1=="comments"){
		if($var2=="delete"){
			if($var3 && $var4){
			 if(!$demo_mode)delete_comment($var3,$var4);
			 if(!$demo_mode)update_stats("imageview",$var3,"comment","del");
			}
		}
		if($var2=="approve"){
			if($var3 && $var4){
			 if(!$demo_mode)approve_comment($var3,$var4);
			}
		}
	  if($var2=="save"){
	  	$set="";
		if(isset($_POST['p_comments_enabled'] )){
			$set.="comments_enabled='true';";
		}else{
			$set.="comments_enabled='false';";
		}
		if(isset($_POST['p_antispam_enabled'] )){
			$set.="antispam_code_enabled='true';";
		}else{
			$set.="antispam_code_enabled='false';";
		}
		if(isset($_POST['p_publish_only_approved'] )){
			$set.="publish_only_approved_comments='true';";
		}else{
			$set.="publish_only_approved_comments='false';";
		}
		$set.="comments_approve_queue_size=".$_POST["p_comments_approve_queue_size"].";";
		if(!$demo_mode)db_update("setup",$set);
		read_settings();
	  }
  	  ob_start();require("setup_comments.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	  return;
	}
	if($var1=="ecard"){
	  if($var2=="save"){
	  	$set="";
		if(isset($_POST['p_ecard_enabled'] )){
			$set.="ecard_enabled='true';";
		}else{
			$set.="ecard_enabled='false';";
		}
		if(isset($_POST['p_antispam_enabled'] )){
			$set.="antispam_code_enabled='true';";
		}else{
			$set.="antispam_code_enabled='false';";
		}
		$set.="ecard_subject='".$_POST["p_ecard_subject"]."';";
		$set.="ecard_picked_subject='".$_POST["p_ecard_picked_subject"]."';";
		$set.="ecard_text='".$_POST["p_ecard_text"]."';";
		$set.="ecard_picked_text='".$_POST["p_ecard_picked_text"]."';";
		echo $set."<br>";
		if(!$demo_mode)db_update("setup",$set);
		read_settings();
	  }
  	  ob_start();require("setup_ecard.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	  return;
	}
	if($var1=="cache"){
	  if($var2=="delete"){
	     if(!$demo_mode)delete_cache($pa_setup["cache_dir"],0);
	  }
	  if($var2=="save"){
	  	$set="";
		if(isset($_POST['p_cache_thumbnails'] )){
			$set.="cache_thumbnails='true';";
		}else{
			$set.="cache_thumbnails='false';";
		}
		if(isset($_POST['p_cache_resized_photos'] )){
			$set.="cache_resized_photos='true';";
		}else{
			$set.="cache_resized_photos='false';";
		}
		if(!$demo_mode)db_update("setup",$set);
		read_settings();
	  }
  	  ob_start();require("setup_cache.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	  return;
	}
	if($var1=="errorlog"){
		if($var2=="save"){
			if(isset($_POST['p_disable_error_log'])){
				if(!$demo_mode)db_update("setup","error_logging_enabled='false';");
			}else{
				if(!$demo_mode)db_update("setup","error_logging_enabled='true';");
			}
			read_settings();

		}
		ob_start();include("setup_errorlog.inc");
		$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	  return;
	}
	if($var1=="texts"){
		if($var2=="save" && !$demo_mode){
			if(file_exists($data_dir.$pa_lang["translate_file"])){
				/*delete*/
				unlink($data_dir.$pa_lang["translate_file"]);
			}
			$first=true;
			foreach($_POST as $key => $text){
				if(substr($key,0,3)=="ID_" && strlen($text)>0){
					  $text=str_replace(Array('\\','"'),Array('\\\\','\"'),stripslashes($text));
						/*this is an id translation*/
						if($first){
							$file=fopen($data_dir.$pa_lang["translate_file"],"w");
							$first=false;
							fwrite($file,"<?php\n\$pa_translated_texts = Array(\n\"$key\" => \"$text\"\n");
						}else{
							fwrite($file,",\"$key\" => \"$text\"\n");
						}
						
				}
			}
			if(!$first){ fwrite($file,");\n"); fclose($file); }
			if(file_exists($data_dir.$pa_lang["translate_file"])){
				unset($pa_translated_texts);
				include($data_dir.$pa_lang["translate_file"]);
			}else{
				unset($pa_translated_texts);
			}
		}
		 
		ob_start();require("setup_texts.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
	  return;
  }
	if($var1=="admin" && !$demo_mode ){
		if(isset($_COOKIE['p_pass'])){ $p_pass=$_COOKIE['p_pass']; }
		if(isset($_COOKIE['p_user'])){ $p_user=$_COOKIE['p_user']; }
		if(isset($_COOKIE['p_actdir'])){ $p_actdir=$_COOKIE['p_actdir']; }

		if(isset($_POST['p_user'])){ $p_user=$_POST['p_user']; }
		if(isset($_POST['p_pass'])){ $p_pass=$_POST['p_pass']; }

	
		if(isset($_POST['p_dir'])){ $p_dir=conv_in($_POST['p_dir']); }
		if(isset($_GET['p_dir'])){ $p_dir=conv_in($_GET['p_dir']); }
		
		if(isset($_POST['p_file_name'])){ $p_file_name=conv_in($_POST['p_file_name']); }
		if(isset($_GET['p_file_name'])){ $p_file_name=conv_in($_GET['p_file_name']); }
		if(!$var2){
				ob_start();require("setup_admin.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
				return;
		}
		if($var2=="login"){
			if( !($ftp_error=ftp_check_login($p_user,$p_pass)) ){
				/*set cookie*/
				setcookie("p_user",$p_user);
				setcookie("p_pass",$p_pass);
				setcookie("p_actdir","");
				$p_actdir="";
				ob_start();require("setup_admin.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
				return;
			}else{
				$var2="";
				ob_start();require("setup_admin.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
				return;
			}
		}
		if($var2=="chdir"){
			$p_actdir=$p_dir;
			setcookie("p_actdir",$p_actdir);
			ob_start();require("setup_admin.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
			return;
			
		}
		if($var2=="mkdir"){
			$ftp_error=ftp_setup_mkdir($p_user,$p_pass,$p_actdir,$p_dir);
			ob_start();require("setup_admin.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
			return;
		}
		if($var2=="rmdir"){
			$ftp_error=ftp_setup_rmdir($p_user,$p_pass,$p_actdir,$p_dir);
			ob_start();require("setup_admin.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
			return;
		}
		if($var2=="delete"){
			$ftp_error=ftp_setup_delete($p_user,$p_pass,$p_actdir,$p_file_name);
			ob_start();require("setup_admin.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
			return;
		}
		if($var2=="upload"){

			$uploaddir = $pa_setup["cache_dir"];

			if (move_uploaded_file($_FILES['p_file']['tmp_name'], $uploaddir . conv_in($_FILES['p_file']['name']))) {
			   $ftp_error=ftp_setup_put_file($p_user,$p_pass,$p_actdir,$uploaddir . conv_in($_FILES['p_file']['name']),conv_in($_FILES['p_file']['name']));
			   /*deleted from cache*/
			   unlink($uploaddir . $_FILES['p_file']['name']);				   
			} else {
			   $ftp_error=t("ID_MSG_FTP_FILE_UPLOAD_ATTACK");
			}


			ob_start();require("setup_admin.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
			return;
		}
		if($var2=="uploadzip"){

			$uploaddir = $pa_setup["cache_dir"];

			if (move_uploaded_file($_FILES['p_file']['tmp_name'], $uploaddir . conv_in($_FILES['p_file']['name']))) {
			   $ftp_error=ftp_setup_put_zip_file($p_user,$p_pass,$p_actdir,$uploaddir . conv_in($_FILES['p_file']['name']),conv_in($_FILES['p_file']['name']));
			   /*deleted from cache*/
			   unlink($uploaddir . $_FILES['p_file']['name']);				   
			} else {
			   $ftp_error=t("ID_MSG_FTP_FILE_UPLOAD_ATTACK");
			}


			ob_start();require("setup_admin.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
			return;
		}
		
	}
  	 //ob_start();require("setup.inc");$contents = ob_get_contents();ob_end_clean();theme_generate_setup_page($menu,$contents);
}



/**********************************************************/
/****************** FTP Functions *************************/
/**********************************************************/
function create_dir($conn,$remote_directory){
global $error_logging;
$error_logging=false;
  $dir=split("/", $remote_directory);
   $path="";
   $result = true;
  
   for ($i=1;$i<count($dir);$i++)
   {
	    $path.="/".$dir[$i];
       //echo "$path\n";
       if(!ftp_chdir($conn,$path)){
         ftp_chdir($conn,"/");
         if(!ftp_mkdir($conn,$path)){
            $result=false;
            break;
         }
       }
   }
$error_logging=true;
return $result;
}

function ftp_setup_mkdir($p_user,$p_pass,$p_actdir,$p_dir){
	global $pa_setup;
	
        $conn=ftp_connect($pa_setup["ftp_server"]);
	if (!$conn ){
    		return t("ID_MSG_FTP_UNABLE_CONNECT",$pa_setup["ftp_server"]);
	}

	$result = ftp_login($conn,$p_user,$p_pass);

	if(!$result){
	    ftp_close($conn);return t("ID_MSG_FTP_INVALID_LOGIN");
	}

	$result = ftp_pasv($conn,true);

	if(!$result){
	    ftp_close($conn);return t("ID_MSG_FTP_PASSIVE_MODE");
	}

/*reading install script and doing what to do is*/
   	$result=create_dir($conn,$pa_setup["ftp_server_photos_dir"].$p_actdir.$p_dir);
	if(!$result){
		ftp_close($conn);return t("ID_MSG_FTP_UNABLE_MKDIR",$p_dir);
   	}
	$result=ftp_close($conn);
	return "";
}
function ftp_setup_rmdir($p_user,$p_pass,$p_actdir,$p_dir){
	global $pa_setup;
	
        $conn=ftp_connect($pa_setup["ftp_server"]);
	if (!$conn ){
    		return t("ID_MSG_FTP_UNABLE_CONNECT",$pa_setup["ftp_server"]);
	}

	$result = ftp_login($conn,$p_user,$p_pass);

	if(!$result){
	    ftp_close($conn);return t("ID_MSG_FTP_INVALID_LOGIN");
	}

	$result = ftp_pasv($conn,true);

	if(!$result){
	    ftp_close($conn);return t("ID_MSG_FTP_PASSIVE_MODE");
	}

/*reading install script and doing what to do is*/
	$result=ftp_chdir($conn,$pa_setup["ftp_server_photos_dir"].$p_actdir.".");
	if(!$result){
		ftp_close($conn);return t("ID_MSG_FTP_UNABLE_CHDIR",$pa_setup["ftp_server_photos_dir"].$p_actdir);
   	}
   	$result=ftp_rmdir($conn,$p_dir);
	if(!$result){
		ftp_close($conn);return t("ID_MSG_FTP_UNABLE_RMDIR",$pa_setup["ftp_server_photos_dir"].$p_actdir.$p_dir);
   	}
	$result=ftp_close($conn);
	return "";
}
function ftp_setup_delete($p_user,$p_pass,$p_actdir,$p_file){
	global $pa_setup;
	
        $conn=ftp_connect($pa_setup["ftp_server"]);
	if (!$conn ){
    		return t("ID_MSG_FTP_UNABLE_CONNECT",$pa_setup["ftp_server"]);
	}

	$result = ftp_login($conn,$p_user,$p_pass);

	if(!$result){
	    ftp_close($conn);return t("ID_MSG_FTP_INVALID_LOGIN");
	}

	$result = ftp_pasv($conn,true);

	if(!$result){
	    ftp_close($conn);return t("ID_MSG_FTP_PASSIVE_MODE");
	}

/*reading install script and doing what to do is*/
	$result=ftp_chdir($conn,$pa_setup["ftp_server_photos_dir"].$p_actdir.".");
	if(!$result){
		ftp_close($conn);return t("ID_MSG_FTP_UNABLE_CHDIR",$pa_setup["ftp_server_photos_dir"].$p_actdir);
   	}
   	$result=ftp_delete($conn,$p_file);
	if(!$result){
		ftp_close($conn);return t("ID_MSG_FTP_UNABLE_DELETE",$p_file);
   	}
	$result=ftp_close($conn);
	return "";
}
function ftp_setup_put_file($p_user,$p_pass,$p_actdir,$local,$remote){
	global $pa_setup;
	
        $conn=ftp_connect($pa_setup["ftp_server"]);
	if (!$conn ){
    		return t("ID_MSG_FTP_UNABLE_CONNECT",$pa_setup["ftp_server"]);
	}

	$result = ftp_login($conn,$p_user,$p_pass);

	if(!$result){
	    ftp_close($conn);return t("ID_MSG_FTP_INVALID_LOGIN");
	}

	$result = ftp_pasv($conn,true);

	if(!$result){
	    ftp_close($conn);return t("ID_MSG_FTP_PASSIVE_MODE");
	}

/*reading install script and doing what to do is*/
	$result=ftp_chdir($conn,$pa_setup["ftp_server_photos_dir"].$p_actdir.".");
	if(!$result){
		ftp_close($conn);return t("ID_MSG_FTP_UNABLE_CHDIR",$pa_setup["ftp_server_photos_dir"].$p_actdir);
   	}
	
	
   	if(!ftp_put($conn,$remote,$local,FTP_BINARY)){ftp_close($conn);return t("ID_MSG_FTP_UNABLE_UPLOAD",$remote);}
	$result=ftp_close($conn);
	return "";
}

function ftp_setup_put_zip_file($p_user,$p_pass,$p_actdir,$local,$remote){
	global $pa_setup;
	$tmp=$pa_setup["cache_dir"]."tmp.file";
        $conn=ftp_connect($pa_setup["ftp_server"]);
	if (!$conn ){
    		return t("ID_MSG_FTP_UNABLE_CONNECT",$pa_setup["ftp_server"]);
	}

	$result = ftp_login($conn,$p_user,$p_pass);

	if(!$result){
	    ftp_close($conn);return t("ID_MSG_FTP_INVALID_LOGIN");
	}

	$result = ftp_pasv($conn,true);

	if(!$result){
	    ftp_close($conn);return t("ID_MSG_FTP_PASSIVE_MODE");
	}

/*reading install script and doing what to do is*/
	$result=ftp_chdir($conn,$pa_setup["ftp_server_photos_dir"].$p_actdir.".");
	if(!$result){
		ftp_close($conn);return t("ID_MSG_FTP_UNABLE_CHDIR",$pa_setup["ftp_server_photos_dir"].$p_actdir);
   	}
	if(function_exists('zip_open')){
		$zip=zip_open($local);
		if($zip){
			while($zip_entry=zip_read($zip)){
				if(zip_entry_filesize($zip_entry)>0){
					if (zip_entry_open($zip, $zip_entry, "rb")) {
					   $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
		           	   $ft=fopen($tmp,"wb");
		           	   if($ft){
		         	   		fwrite($ft,$buf,zip_entry_filesize($zip_entry));
		           	   		fclose($ft);
		           	   }else{
		           	   		ftp_close($conn);return t("ID_MSG_FTP_UNABLE_OPEN_TMP");
		           	   }
		           	   		
		           	   if(!ftp_put($conn,$pa_setup["ftp_server_photos_dir"].$p_actdir.zip_entry_name($zip_entry),$tmp,FTP_BINARY)){
		    			   	$result=create_dir($conn,$pa_setup["ftp_server_photos_dir"].$p_actdir.dirname(zip_entry_name($zip_entry)));
							if(!$result){ ftp_close($conn);return  t("ID_MSG_FTP_UNABLE_MKDIR",dirname(zip_entry_name($zip_entry)));}
							if(!ftp_put($conn,$pa_setup["ftp_server_photos_dir"].$p_actdir.zip_entry_name($zip_entry),$tmp,FTP_BINARY)){ftp_close($conn);return "Unable to upload file ".zip_entry_name($zip_entry);}
		           	   }
		           	   zip_entry_close($zip_entry);
		       		}
				}else{
				   	$result=create_dir($conn,$pa_setup["ftp_server_photos_dir"].$p_actdir.zip_entry_name($zip_entry));
					if(!$result){
						ftp_close($conn);return t("ID_MSG_FTP_UNABLE_MKDIR",$p_dir);
   					}
				}
			}
		}else{
			ftp_close($conn);return t("ID_MSG_FTP_NOT_ZIP");
		}
	}else{
		ftp_close($conn);return t("ID_MSG_FTP_ZIP_UNSUPPORTED");
	}
	
	
	$result=ftp_close($conn);
	return "";
}


function ftp_check_login($p_user,$p_pass){
	/*create test file, upload and thest if it comes to the right directory*/
	global $pa_setup;
	
        $conn=ftp_connect($pa_setup["ftp_server"]);
	if (!$conn ){
    		return t("ID_MSG_FTP_UNABLE_CONNECT",$pa_setup["ftp_server"]);
	}

	$result = ftp_login($conn,$p_user,$p_pass);

	if(!$result){
	    ftp_close($conn); return t("ID_MSG_FTP_INVALID_LOGIN");
	}

	$result = ftp_pasv($conn,true);

	if(!$result){
	    ftp_close($conn); return t("ID_MSG_FTP_PASSIVE_MODE");
	}

/*reading install script and doing what to do is*/
	$result=ftp_chdir($conn,$pa_setup["ftp_server_photos_dir"].".");
	if(!$result){
		ftp_close($conn); return t("ID_MSG_FTP_UNABLE_CHDIR",$pa_setup["ftp_server_photos_dir"].$p_actdir);
   	}
	$test=md5(time());
	$f=fopen($pa_setup["cache_dir"].".test","w"); fwrite($f,$test); fclose($f);
	
   	if(!ftp_put($conn,".test",$pa_setup["cache_dir"].".test",FTP_BINARY)){ftp_close($conn); return t("ID_MSG_FTP_UNABLE_UPLOAD","testfile");}
	
	$ff=file($pa_setup["album_dir"].".test");
	if($ff[0]!=$test){
		ftp_close($conn);
		return t("ID_MSG_FTP_PHOTO_DIR");
	}
	$result=ftp_delete($conn,".test");	
	
	$result=ftp_close($conn);
	return "";
	
}
function my_cmp($a,$b){
	if($a['type']==$b['type']){
		if($a['name']==$b['name']) return 0;
		return ($a['name'] < $b['name']) ? -1 : 1;
	}
	if($a['type']=="dir") return -1;
	return 1;
}
function ftp_get_files($actdir){
  global $pa_setup;
  $files=Array(); 
  $dir=$pa_setup["album_dir"].$actdir;
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
       while (($file = readdir($dh)) !== false) {
       	   $f=Array();
           if( filetype($dir . $file)=="dir" ){
  	      $f['type']="dir";
	   }else{
  	      $f['type']="file";
	   }
	   $f['name']=$file;
	   $f['size']=filesize($dir."/".$file)." B";	
	   if(is_image($file)){
	   	list($width,$height)=getimagesize($dir."/".$file);
	   	$f['image_size']=$width." x ".$height;
	   }
	   if(function_exists('posix_getpwuid')){
	   		$ow=posix_getpwuid(fileowner($dir."/".$file));
	   		$f['owner']=$ow['name'];
	   }else{
	   		$f['owner']=fileowner($dir."/".$file);
	   }
	   if(function_exists('posix_getgrgid')){
		   $gr=posix_getgrgid(filegroup($dir."/".$file));
		   $f['group']=$gr['name'];
	   }else{
	   	   $f['group']=filegroup($dir."/".$file);
	   }
	   $f['time']=date("d.m.Y H:i:s",filectime($dir."/".$file));
	   if($f['type']=="dir" && $f['name']!=".." && $f['name']!="."){
	   	$f['func']="<a class=\"mex\" href=\"main.php?cmd=setup&var1=admin&var2=rmdir&p_dir=".urlencode(conv_out($file))."\">remove_dir</a>";
	   }else if($f['type']=="file"){
	   	$f['func']="<a class=\"mex\" href=\"main.php?cmd=setup&var1=admin&var2=delete&p_file_name=".urlencode(conv_out($file))."\">delete</a>";
	   }


	   $files[]=$f;
	}
       closedir($dh);
    }
  }
	if(is_array($files)) usort($files,"my_cmp");
	return $files;
}
/**********************************************************/
/**************END  FTP Functions *************************/
/**********************************************************/