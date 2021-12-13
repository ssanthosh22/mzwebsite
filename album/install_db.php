<?php
	/*checking for security reasons*/
	if(!defined("PHPALBUM_APP")){
		die("Direct access not permitted!");
	}

//creating tables
	db_create_table("setup",Array( 
		"album_dir"=>"photos/",
		"cache_dir"=>"cache/",
		"site_name"=>"phpAlbum.net",
		"site_theme"=>"Borders",
		"return_home_url"=>"www.phpalbum.net",
		"new_dir_indic"=>"48",
		"cookie_password_hours"=>"168",
		"language"=>"EN_UTF8",
		"ftp_server"=>"",
		"ftp_server_photos_dir"=>"",
		"default_sorting"=>"name_asc",
		"comments_enabled"=>"true",
		"comments_approve_queue_size"=>"100",
		"logs_enabled"=>"true",
		"logs_filename"=>"logs.txt",
		"logs_exclude"=>"",
		"cache_thumbnails"=>"true",
		"cache_resized_photos"=>"true",
		"statistic_count"=>"50",
		"login_enabled"=>"true",
		"register_enabled"=>"true",
		"last_dir_scan"=>"0",
		"date_format"=>"d.M.Y H:i:s",
		"error_logging_enabled"=>"false",
		"antispam_code_enabled"=>"true",
		"publish_only_approved_comments"=>"false",
		"use_iptc_desc"=>"true"
		));
	if(strlen($init_album_dir)>0){
		db_insert("setup",Array("album_dir"=>$init_album_dir,
								"cache_dir"=>$init_cache_dir,
								"ftp_server"=>$init_ftp_server,
								"ftp_server_photos_dir"=>$init_ftp_photos_dir)); // inserts an default record;
	}else{
		db_insert("setup",NULL);
	}
	
	db_create_table("quality",Array(
	    "id"=>"",
		"name"=>"my_quality",
		"thmb_size"=>"140",
		"thmb_qual"=>"70",
		"photo_size"=>"700",
		"photo_qual"=>"85",
		"enabled"=>"true",
		"default"=>"false",
		"resize_if_bigger"=>"false",
		"square_thumbnails"=>"false",
		"resize_photo_to_fit"=>"both", // possible values width, height , both
		"watermark_file"=>"",
		"watermark_position"=>"RD",
		"thmb_sharp_use"=>"false",
		"thmb_sharp_amount"=>"20",
		"thmb_sharp_radius"=>"1",
		"thmb_sharp_treshold"=>"0",
		"thmb_show_views"=>"true",
		"thmb_show_comments"=>"true",
		"thmb_show_votes"=>"false",
	));
	
	db_insert("quality",Array("id"=>1,"name"=>"original","thmb_size"=>"160","thmb_qual"=>"70","photo_size"=>"0","photo_qual"=>"0","enabled"=>"true","default"=>"false"));
	db_insert("quality",Array("id"=>2,"name"=>"middle","thmb_size"=>"140","thmb_qual"=>"70","photo_size"=>"700","photo_qual"=>"85","enabled"=>"true","default"=>"true"));
	db_insert("quality",Array("id"=>3,"name"=>"small","thmb_size"=>"100","thmb_qual"=>"70","photo_size"=>"500","photo_qual"=>"85","enabled"=>"true","default"=>"false"));
	
	db_create_table("color_map",Array(
		"id"=>"",
		"name"=>"my_colors",
		"bg_color"=>"464646",
		"link_color"=>"DDCC88",
		"dir_desc_color"=>"CCCCCC",
		"border_color"=>"FFFFFF",
		"photo_desc_color"=>"DDCC88",
		"logo_color"=>"DDCC88"
	));
	db_insert("color_map",Array("id"=>1,"name"=>"default","bg_color"=>"EEDD99","link_color"=>"464646","dir_desc_color"=>"777777","border_color"=>"FFFFFF","photo_desc_color"=>"464646","logo_color"=>"464646"));
	db_insert("color_map",Array("id"=>2,"name"=>"dark","bg_color"=>"464646","link_color"=>"DDCC88","dir_desc_color"=>"CCCCCC","border_color"=>"FFFFFF","photo_desc_color"=>"DDCC88","logo_color"=>"DDCC88"));
	db_insert("color_map",Array("id"=>3,"name"=>"winter","bg_color"=>"cceeff","link_color"=>"0011aa","dir_desc_color"=>"222222","border_color"=>"FFFFFF","photo_desc_color"=>"0011aa","logo_color"=>"DDCC88"));
	
	db_create_table("theme",Array(
		"name"=>"Flowing_Dark",
		"color_map"=>"1",
		"logo_path"=>"res/logo.png",
		"logo_style"=>"file",
		"logo_text"=>"phpAlbum.net",
		"directory_style"=>"flowing",
		"additional_thmb_height"=>"65",
		"additional_thmb_width"=>"45",
		"maximum_photos_per_page"=>"100",
		"raster_dir_x"=>"4",
		"raster_dir_y"=>"3",
		"disable_bottom_nextprev"=>"false",
		"show_filenames"=>"true",
		"display_shadows"=>"true",
		"picture_border_size"=>"10",
		"thumbnail_border_size"=>"5",
		"dir_logo_style"=>"pic_other_size", //logo,pic_thmb_size,pic_other_size
		"dir_logo_size"=>"70",
		"dir_logo_quality"=>"85",
		"dir_logo_square_thumbnail"=>"false",
		"show_search_box"=>"true"
	));
	db_insert("theme",Array("name"=>"Flowing_Dark","color_map"=>"1","logo_style"=>"file","logo_text"=>"phpAlbum.net","dir_logo_style"=>"pic_thmb_size"));
	db_insert("theme",Array("name"=>"Borders","color_map"=>"1","logo_style"=>"file","logo_text"=>"phpAlbum.net"));

	db_create_table("directory",Array(
		"path"=>"",
		"password"=>"",
		"desc"=>"",
		"long_desc"=>"",
		"alias"=>"",
		"sorting"=>"default",
		"visibility"=>"true",
		"view_count"=>0,
		"vote_count"=>0,
		"vote_avg"=>0,
		"comment_count"=>0,
		"photo_count"=>0,
		"photo_count_r"=>0,
		"icon_path"=>"",
		"groups"=>"",
		"inh_groups"=>"",
		"show_parameters"=>"default", //this can be "default","custom"
		"show_parameters_custom_id"=>"",
		"seq_files"=>"",
		"newest_file_time"=>"",
		"newest_file_time_with_subdirs"=>"",
		"show_newest_pictures_count"=>"0",
		"keywords"=>Array(),
	));
    db_create_table("new_comments",Array(
    		"seq_files"=>"",
    		"pic_link"=>"",
    		"id"=>"",
			"file_name"=>"",
			"time"=>"",
			"name"=>"",
			"email"=>"",
			"text"=>""
		));
    db_create_table("languages",Array(
    	"name"=>"",
    	"desc"=>"",
    	"character_set"=>"",
    	"include_file"=>"",
    	"translate_file"=>""
    ));
    db_insert("languages",Array("name"=>"EN_UTF8","desc"=>"English UTF-8","character_set"=>"UTF-8","include_file"=>"en_utf8.php","translate_file"=>"translate_en_utf8.dat"));
    db_insert("languages",Array("name"=>"EN_ISO8859_1","desc"=>"English ISO-8859-1","character_set"=>"ISO-8859-1","include_file"=>"en_utf8.php","translate_file"=>"translate_en_iso88591.dat"));
    db_insert("languages",Array("name"=>"EN_ISO8859_2","desc"=>"English ISO-8859-2","character_set"=>"ISO-8859-2","include_file"=>"en_utf8.php","translate_file"=>"translate_en_iso88592.dat"));
    
    db_create_table("user",Array(
    	"id"=>"",
    	"name"=>"",
    	"password"=>"", //coded with md5
    	"email"=>"",
    	"homepage"=>"",
    	"groups"=>"",
    ));
    db_create_table("group",Array(
    	"name"=>"",
    	"grants"=>Array("imageorig"=>"1","imageview"=>"1"),
    	"default"=>"false"
    ));
    
			
    db_insert("group",Array("name"=>"guest"));
    db_insert("group",Array("name"=>"superuser","grants"=>Array("main"=>"1","themes"=>"1","thumbnails"=>"1",
			 "dirs"=>"1","pics"=>"1","params"=>"1",
			 "users"=>"1","groups"=>"1","admin"=>"1",
			 "comments"=>"1","texts"=>"1","cache"=>"1",
			 "logs"=>"1","errorlog"=>"1","syscheck"=>"1","imageorig"=>"1","imageview"=>"1","ecard"=>"1")));
    db_insert("group",Array("name"=>"Friends"));
    db_insert("group",Array("name"=>"Family"));
	db_insert("user",Array("id"=>1,"name"=>"admin","password"=>md5("admin"),"groups"=>Array("superuser"=>"1")));

	db_create_table("photo_param",Array(
		"id"=>"",
		"name"=>"",
		"type"=>"",//User value, User list of valu, System value
		"default"=>"",
		"default_lov"=>-1,//FileName (download fullsize),creation date, File Size, Dimensions, User Defined
		"lov"=>"",
		"allow_html"=>"false",
		"default_displayed"=>"true"
		
	));
	//insert initial parameters
	db_insert("photo_param",Array("id"=>'1',"name"=>"File name","type"=>"system","default_lov"=>"fnl"));
	db_insert("photo_param",Array("id"=>'2',"name"=>"File size","type"=>"system","default_lov"=>"siz"));
	db_insert("photo_param",Array("id"=>'3',"name"=>"Date/Time","type"=>"system","default_lov"=>"cdt"));
	db_insert("photo_param",Array("id"=>'4',"name"=>"Dimensions","type"=>"system","default_lov"=>"dim"));
	db_insert("photo_param",Array("id"=>'5',"name"=>"Camera model","type"=>"system","default_lov"=>"exif_model"));
	db_insert("photo_param",Array("id"=>'6',"name"=>"Sensitivity","type"=>"system","default_lov"=>"exif_iso"));
	db_insert("photo_param",Array("id"=>'7',"name"=>"Shutter speed","type"=>"system","default_lov"=>"exif_exp_time"));
	db_insert("photo_param",Array("id"=>'8',"name"=>"Aperture","type"=>"system","default_lov"=>"exif_f"));
	db_insert("photo_param",Array("id"=>'9',"name"=>"Focal Length","type"=>"system","default_lov"=>"exif_fl"));
	db_insert("photo_param",Array("id"=>'10',"name"=>"Date/Time(Exif)","type"=>"system","default_lov"=>"exif_datetime"));
	
	
	db_create_table("photo_param_type",Array("name"=>"","desc"=>""));
	
	db_insert("photo_param_type",Array("name"=>"user","desc"=>"User value"));
	db_insert("photo_param_type",Array("name"=>"userlov","desc"=>"User list of value"));
	db_insert("photo_param_type",Array("name"=>"system","desc"=>"System value"));
// sequences
	db_create_sequence("seq_files",1000,1);
	db_create_sequence("seq_quality_id",4,1);
	db_create_sequence("color_map_id",3,1);
	db_create_sequence("comment_id");
	db_create_sequence("user_id",2,1);
	db_create_sequence("photo_param_id",11,1);
    // changes for 0.4.1.beta9
    db_create_table("anti_spam_codes",Array(
    	"pic_seq"=>"",
    	"code"=>"",
    	"time"=>"",
    ));
    db_create_sequence("antispam_pic_seq",1,1);
    db_create_table("phpalbum_version",Array("version"=>""));
    db_insert("phpalbum_version",Array("version"=>"$phpalbum_version"));
	db_create_table("object_cache",Array("type"=>"","file"=>""));
	
	//changes 0.4.1.14
	db_create_table("ecards",Array("uid"=>"","image"=>"","from_name"=>"","from_email"=>"","to_name"=>"","to_email"=>"","message_text"=>"","created"=>"","picked_up"=>"false"));
	db_alter_table_add_column("setup","ecard_enabled","true");
	db_alter_table_add_column("setup","ecard_subject","You have got an e-card !");
	db_alter_table_add_column("setup","ecard_text","Hello #TO_NAME,\n\n#FROM_NAME sent you an electronic card from phpAlbum.net.\nYou can pick up it on this adress: http://www.phpalbum.net/phpAlbum/#ECARD_ADRESS\nOr you can just look at the picture here: http://www.phpalbum.net/phpAlbum/#IMAGE_ADRESS\n\nYour e-card was sent on #DATE at #TIME.");
	db_alter_table_add_column("setup","ecard_picked_subject","You e-card was picked up !");
	db_alter_table_add_column("setup","ecard_picked_text","Hello #FROM_NAME,\n\n#TO_NAME picked up your e-card on #DATE at #TIME\n\ne-card adress: http://www.phpalbum.net/phpAlbum/#ECARD_ADRESS"); 
	db_alter_table_add_column("setup","tracking_code","");