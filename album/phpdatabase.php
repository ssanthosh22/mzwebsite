<?php 
	/*checking for security reasons*/
	if(!defined("PHPALBUM_APP")){
		die("Direct access not permitted!");
	}

	/* php flatfile database */
	/* (c) 2006 Patrik Jakab */
	/* License: GNU/GPL      */
	
	
	/*global variables       */
	$db_version="0.2";
	$db_system_file="";
	$db_tabs_file="";
	$db_up="";
	$db_data_dir="";
	$db_error="";
	$db_error_text="";
	
	$db_not_commited=Array();
	$db_auto_commit_flag=true;
	$db_data=Array();
	$db_cursors=Array();
	$db_cursors_counter=0;
	$db_locked_tables=Array();
	$db_locked_files=Array();

	function db_create_database($db_name,$data_dir){
		$system_file=db_get_system_file($db_name);
		if(file_exists($data_dir.$system_file)){
			db_raise("0001"); // database already exists
			return false;			
		}
		if(!db_create_system($db_name,$data_dir)){
			db_raise("0002");	
			return false;
		}
		db_startup_database($db_name,$data_dir);
		db_create_table("SYS_SEQUENCES",Array("name"=>"","nextval"=>"1","increment"=>"1"));
		return true;
		
	}
	function db_create_system($db_name,$data_dir){
		global $db_version,$db_data_dir;
		$db_data_dir=$data_dir;
		/*create system file, and tables file*/
		$data_system=Array( "DB_VERSION"=>$db_version,
												"FILE"=>db_get_system_file($db_name),
						 "CREATE_DATE" => time()						 
		);
		$data_tabs=Array();
		if(!db_save_file($data_system,"SYSTEM",db_get_system_file($db_name))){
			return false;
		}
		if(!db_save_file($data_tabs,"TABS",db_get_tabs_file($db_name))){
			return false;
		}
		return true;
	}
	function db_drop_database(){
		global $db_version,$db_data_dir,$db_up,$db_data,$db_cursors;
		foreach($db_data["TABS"] as $table=>$values){
			@unlink($db_data_dir.$values["FILE"]);
		}
		@unlink($db_data_dir.db_get_system_file($db_up));
		@unlink($db_data_dir.db_get_tabs_file($db_up));
		unset ($db_up);
		unset ($db_data);
		unset ($db_cursors);
	}

	function db_auto_commit(){
		global $db_auto_commit_flag;
		return $db_auto_commit_flag;
	}
	function db_set_auto_commit($var){
		global $db_auto_commit_flag;
		$db_auto_commit_flag=$var;
	}
	function db_upgrade_to_02(){
			global $db_data;
			foreach($db_data["TABS"] as $key=>$table){
				foreach($table["COLUMNS"] as $key2=>$column){
					$db_data["TABS"][$key]["COLUMNS"][$key2]=$column["DEFAULT"];
				}
			}
			$db_data["SYSTEM"]["DB_VERSION"]='0.2';
			
			db_save_data("TABS");
			db_save_data("SYSTEM");
			
	}
	function db_startup_database($db_name,$data_dir){
		/*there is no need to shotdown database*/
		/*starting up equals loading system files*/
		/*allfiles has as prefix db_name*/
		
		global $db_up,$db_data_dir,$db_system_file,$db_tabs_file,$db_data;
		$db_data_dir=$data_dir;
		$db_system_file=db_get_system_file($db_name);
		$db_tabs_file=db_get_tabs_file($db_name);
		$db_up=$db_name;
		if(!db_load_data("SYSTEM",$db_system_file)){
			db_raise("0003");
			return false;
		}
		if(!db_load_data("TABS",$db_tabs_file)){
			//db_raise("0003");
			return false;
		}
		if($db_data["SYSTEM"]["DB_VERSION"]=='0.1'){
			db_upgrade_to_02();
		}
		return true;
	}
	function db_get_system_file($db_name){
		return $db_name."_sys.php";
	}
	function db_get_tabs_file($db_name){
		return $db_name."_tabs.php";
	}
	function db_save_file($db_data,$table,$file){
		global $db_data_dir;
		   $buffer="<?php  \$db_data[\"$table\"] = ".var_export($db_data,true ).";";
		   $f=fopen($db_data_dir.$file,"w");
		   fwrite($f,$buffer);
		   fclose($f);
		   return true;
	}
	function db_save_data($table){
		global $db_data,$db_up;
		switch($table){
			case "TABS": $file=db_get_tabs_file($db_up); break;
			case "SYSTEM": $file=db_get_system_file($db_up); break;
			default: $file=$db_data["TABS"][$table]["FILE"]; break;
		}
		$result = db_save_file($db_data[$table],$table,$file);
		return $result;
	}
	function db_load_data($table,$file=""){
		global $db_data_dir,$db_data,$db_locked_files;
		if(!$file){
			$file=$db_data["TABS"][$table]["FILE"];
		}
		if(isset($db_data[$table])){
			unset($db_data[$table]);
		}
		
		if(is_file($db_data_dir.$file)){
				$locked_here=false;
				if(!db_is_locked_table($table)){
					db_lock_table($table,false);
					$locked_here=true;
				}
				require($db_data_dir.$file); //load data
				
				if($locked_here){
					db_unlock_table($table);
				}
		}else{
			db_raise("0006");
			return false;
		}
		return true;
	}

	function db_raise($db_err_number){
		global $db_error,$db_error_text;
		$db_error=$db_err_number;
		switch($db_error){
			case "0001": $db_error_text = "DB-0001:Unable to create database, controlfile already exits";
			             break;
			case "0002": $db_error_text = "DB-0002:Unable to create database!";
			             break;
			case "0003": $db_error_text = "DB-0003:Unable to startup database";
			             break;
			case "0004": $db_error_text = "DB-0004:Table already exists";break;
			case "0005": $db_error_text = "DB-0005:Table does not exists";break;
			case "0006": $db_error_text = "DB-0006:Table file not found";break;
			case "0007": $db_error_text = "DB-0007:Unable to lock db file";break;
			case "0008": $db_error_text = "DB-0008:Unable to commit data";break;
			case "0009": $db_error_text = "DB-0009:No SET parameter defined for update";break;
			case "0010": $db_error_text = "DB-0010:Column is not existing in this table";break;
			case "0011": $db_error_text = "DB-0011:Where clause has errors";break;
			default: $db_error_text = "DB: Unrecognized database error, internal error";
				     break;
		}
	}
	
	function db_get_last_error(){
		global $db_error;
		return $db_error;
	}
	function db_get_last_error_text(){
		global $db_error_text;
		return $db_error_text;
	}
	function db_lock_table($table,$exclusive=true){
		global $db_locked_tables,$db_data_dir,$db_locked_files;
		//echo "LOCK:".$table.":".$exclusive."<br/>";
		if(isset($db_locked_tables[$table])){
			return true; //already locked with this instance
		}
		
		if(!file_exists($db_data_dir."table.".$table.".lck")){
			db_touch("table.".$table.".lck");
		}
		/*be careful this can make an deadlock*/
		db_lock("table.".$table.".lck",$exclusive);
		$db_locked_tables[$table]="lock";

		return true;
	}
	function db_unlock_table($table){
		global $db_locked_tables;
		//echo "UNLOCK:".$table."<br/>";
		db_unlock("table.".$table.".lck");
		unset($db_locked_tables[$table]);
		return true;
	}
	function db_is_locked_table($table){
		global $db_locked_tables;
		return isset($db_locked_tables[$table]);
	}
	function db_touch($file){
		global $db_data_dir;
		$path=$db_data_dir.$file;
		$f=@fopen($path,"x");
		if($f){
			fwrite($f,"lock");
			fclose($f);
			return true;
		}else{
			return false;
		}
		
	}
	function db_lock ($lock, $exclusive=true) {
	   global $db_data_dir,$db_max_lock_time_sec,$db_locked_files;
	   //return 1;
	   $lock_file = $db_data_dir.$lock;
	   if(!$exclusive){
	   	$fp=fopen($lock_file,"r");
	   	$db_locked_files[$lock]=$fp;
	   	return flock($fp,LOCK_SH)?1:0;
	   }else{
	   	$fp=fopen($lock_file,"w");
	   	$db_locked_files[$lock]=$fp;
	   	return flock($fp,LOCK_EX)?1:0;
	   }
	}

	// Unlock a file.
	function db_unlock ($lock) {
	  global $db_data_dir,$db_locked_files;
 	  flock($db_locked_files[$lock],LOCK_UN);
 	  fclose($db_locked_files[$lock]);
 	  unset($db_locked_files[$lock]);
	}

	
/***********************************************/
/* data definition language DDL                 */
/***********************************************/
function db_get_table_file_name($table_name){
	global $db_up;
	return $db_up."_".$table_name.".php";
}
function db_create_table($table_name,$columns){
	global $db_data,$db_up;
	$colls;
	if(isset($db_data["TABS"][$table_name])){
		db_raise("0004");
		return false;
	}
	foreach($columns as $key=>$val){
		$colls[$key]=$val;
	}
	$db_data["TABS"][$table_name]=Array( "FILE" => db_get_table_file_name($table_name),"COLUMNS" => $colls);
	/*autocommit by DDL*/
	db_save_data("TABS");
	$db_data[$table_name]=Array();
	db_save_data($table_name);
	return true;
}	
function db_drop_table($table_name){
	global $db_data,$db_up,$db_data_dir;
	if(!isset($db_data["TABS"][$table_name])){
		db_raise("0005");
		return false;
	}
	/*deleting table file*/
	@unlink ( $db_data_dir.$db_data["TABS"][$table_name]["FILE"]);
	unset($db_data["TABS"][$table_name]);
	/*autocommit by DDL*/
	db_save_data("TABS");
	return true;
}
function db_alter_table_drop_column($table_name,$column_name){
	global $db_data;
	/*check table*/
	if(!isset($db_data["TABS"][$table_name])){
		/*table not exists*/
			db_raise("0005");
			return false;
	}
	if(!isset($db_data[$table_name]) || !db_is_locked_table($table_name)){
		/*load table data if not loaded or was not locked by last loading*/ 
		db_lock_table($table_name);
		if(!db_load_data($table_name)){
			db_raise("0006");
			return false;
		}
	}
	if(isset($db_data["TABS"][$table_name]["COLUMNS"][$column_name])){
		unset($db_data["TABS"][$table_name["COLUMNS"]][$column_name]);
		db_save_data("TABS");
	}else{
		db_raise("0010");
		return false;
	}
	
	foreach($db_data[$table_name] as $key => $record){
		unset($db_data[$table_name][$key][$column_name]);
	}
	//autocommitin this as by all DDL commands
	db_save_data($table_name);
	db_unlock_table($table_name);
	return true;
}
function db_alter_table_add_column($table_name,$column_name,$default=null){

	global $db_data;
	/*check table*/
	if(!isset($db_data["TABS"][$table_name])){
		/*table not exists*/
			db_raise("0005");
			return false;
	}
	if(!isset($db_data[$table_name]) || !db_is_locked_table($table_name)){
		/*load table data if not loaded or was not locked by last loading*/ 
		db_lock_table($table_name);
		if(!db_load_data($table_name)){
			db_raise("0006");
			return false;
		}
	}

	$db_data["TABS"][$table_name]["COLUMNS"][$column_name]=$default;
	db_save_data("TABS");
	
	foreach($db_data[$table_name] as $key => $record){
		if(!$db_data[$table_name][$key][$column_name]){
			$db_data[$table_name][$key][$column_name]=$default;
		}
	}
	//autocommitin this as by all DDL commands
	db_save_data($table_name);
	db_unlock_table($table_name);
	return true;
	
}
function db_alter_table_modify_column($table_name,$column_name,$default=null){

	global $db_data;
	/*check table*/
	if(!isset($db_data["TABS"][$table_name]["COLUMNS"][$column_name])){
		/*table not exists*/
			db_raise("0010");
			return false;
	}
	$db_data["TABS"][$table_name]["COLUMNS"][$column_name]=$default;
	db_save_data("TABS");
	return true;
	
}

function db_alter_multiple_table_add_column($table_name_prefix,$column_name,$default=null){
	global $db_data;
	foreach($db_data["TABS"] as $key=>$value){
		if(strlen($key)>=strlen($table_name_prefix)){
			if(substr($key,0,strlen($table_name_prefix))==$table_name_prefix){
				db_alter_table_add_column($key,$column_name,$default);
			}
		}
	}
}
function db_create_sequence($seq_name,$start=null,$increment=null){
	$old=db_auto_commit();
	db_set_auto_commit(true);
	$rec["name"]=$seq_name;
	if($start)$rec["nextval"]=$start;
	if($increment)$rec["increment"]=$increment;
	db_insert("SYS_SEQUENCES",$rec);
	db_set_auto_commit($old);
}
/***********************************************/
/* data manipulation language DML                 */
/***********************************************/
function db_commit($free_mem=false){
	global $db_not_commited;
	$db_not_commited=array_unique($db_not_commited);
	if(is_array($db_not_commited)){
		foreach($db_not_commited as $key=>$table){
			if(!db_save_data($table)){
				return false;
			}
			db_unlock_table($table);
			unset($db_not_commited[$key]);
		}
	}
	unset($db_not_commited);
	$db_not_commited=Array();
	if($free_mem){
		db_free_memory();
	}
}

function db_rollback(){
	global $db_not_commited,$db_data;
	if(is_array($db_not_commited)){
		foreach($db_not_commited as $table){
			unset($db_data[$table]); /*remove from memory with changes*/
			db_unlock_table($table);
		}
	}
	unset($db_not_commited);
	$db_not_commited=Array();
}

function db_get_seq_nextval($seq){
	$old=db_auto_commit();
	db_set_auto_commit(true);
	$rec=db_select_all("SYS_SEQUENCES","name=='$seq'",null,true);
	$return=$rec[0]["nextval"];
	$next=$return+$rec[0]["increment"];
	db_update("SYS_SEQUENCES","nextval=$next;","name=='$seq'");
	db_set_auto_commit($old);
	return $return;
}


function db_insert($table_name,$record){
	global $db_data,$db_not_commited;
	if(!isset($db_data["TABS"][$table_name])){
		/*table not exists*/
			db_raise("0005");
			return false;
	}
	if(!isset($db_data[$table_name]) || !db_is_locked_table($table_name)){
		/*load table data*/ 
		while (!db_is_locked_table($table_name)){
			db_lock_table($table_name);
		}
		if(!db_load_data($table_name)){
			db_raise("0006");
			return false;
		}
	}
	
	foreach($db_data["TABS"][$table_name]["COLUMNS"] as $col_name => $col ){
		if(isset($record[$col_name])){
			if(is_array($record[$col_name])){
				$new_record[$col_name]=$record[$col_name];
			}else{
				$new_record[$col_name]=stripslashes($record[$col_name]);
			}
		}else{
			$new_record[$col_name]=$col;
		}
	}
	$db_data[$table_name][]=$new_record;
	if(db_auto_commit()){
		if(!db_save_data($table_name)){
			db_unlock_table($table_name);
			return false;
		}
 		    db_unlock_table($table_name);
	}else{
		$db_not_commited[]=$table_name;
	}
	return true;
	/*assign values , for not defined get an default value and return inserted record*/
}

function db_create_order_by_function($order_by){
	$order_by=str_replace(' ','',$order_by);
	$colls=explode(',',$order_by);
	$coll=end($colls);
	if(substr($coll,-1,1)=='-'){
		$coll=substr($coll,0,strlen($coll)-1);
		$func="if(\$a[$coll]==\$b[$coll]){return 0;}else{return (\$a[$coll]<\$b[$coll])? 1 : -1;}";
	}else{
		if(substr($coll,-1,1)=='+'){$coll=substr($coll,0,strlen($coll)-1);}
		$func="if(\$a[$coll]==\$b[$coll]){return 0;}else{return (\$a[$coll]<\$b[$coll])? -1 : 1;}";
	}
	while($coll=prev($colls)){
	if(substr($coll,-1,1)=='-'){
		$coll=substr($coll,0,strlen($coll)-1);
		$func="if(\$a[$coll]==\$b[$coll]){ ".$func." }else{return (\$a[$coll]<\$b[$coll])? 1 : -1;}";
	}else{
		if(substr($coll,-1,1)=='+'){$coll=substr($coll,0,strlen($coll)-1);}
		$func="if(\$a[$coll]==\$b[$coll]){ ".$func." }else{return (\$a[$coll]<\$b[$coll])? -1 : 1;}";
	}
	}
	return create_function('$a,$b',$func);
}
function db_create_where_function($table_name,$where){
	global $db_data;
	$where_a=preg_split("/'/",$where);
	if($where){
		foreach($db_data["TABS"][$table_name]["COLUMNS"] as $col_name => $col ){
			/*replacing only whole words in where clause*/
		  for($i=0;$i<count($where_a);$i+=2){
				if($i>0 && substr($where_a[$i-1],-1)=="\\"){
					$i--;
				}else{
					$where_a[$i]=preg_replace("/\b$col_name\b/","\$data[\"$col_name\"]",$where_a[$i]);
				}
		  }
		}
	    $where=implode("'",$where_a);
		//echo $table_name." -> ".$where."<br>";
	    
		if(!($where_function = create_function('$data','return '.$where.';'))){
			db_raise("0011");
			return false;
		}
	}
	return $where_function;
}

function db_remove_uvodzovky_slash ( &$item, $key ){ 
	//used in db_update to remove \", only good for php album, as we always use 'string' for defining strings
	//and do not want to have \" in stored string
	$item=str_replace('\"','"',$item);
}
function db_create_set_function($table_name,$set){
	global $db_data;
	$set_a = preg_split("/'/",$set);
	if($set){
		foreach($db_data["TABS"][$table_name]["COLUMNS"] as $col_name => $col ){
			/*replace only the whole words*/
			for($i=0;$i<count($set_a);$i+=2){
				if($i>0 && substr($set_a[$i-1],-1)=="\\"){
					$i--;	
				}else{
					$set_a[$i]=preg_replace("/\b$col_name\b/","\$data[\"$col_name\"]",$set_a[$i]);
				}
			}
		}
		$set = implode("'",$set_a);
//		echo $set."<br>";
		$set.=';array_walk($data,\'db_remove_uvodzovky_slash\');';
		//var_dump($set);
		$set_function = create_function('$data',$set.'; return $data;');
		return $set_function;
	}
}
function db_select_limit($start,$length,$from,$where=null,$order_by=null,$for_update=false){
	$rec=db_select_all($from,$where,$order_by,$for_update);
	if(is_array($rec)){
		return array_slice($rec,$start-1,$length);
	}else{
		return $rec;
	}
}
/*this function should check select parameters and return the result in one array*/
function db_select_all($from,$where=null,$order_by = null,$for_update=false){
	//echo ":".$from.":".$where.":".$order_by.":<br>";
	global $db_data,$db_not_commited;
	/*check table*/
	$table_name=$from;
	if(!isset($db_data["TABS"][$table_name])){
		/*table not exists*/
			db_raise("0005");
			return false;
	}
	if(!isset($db_data[$table_name]) || ( $for_update && !db_is_locked_table($table_name))){
		/*load table data if not loaded or was not locked by last loading*/ 
		if($for_update){
			db_lock_table($table_name);
		}
		if(!db_load_data($table_name)){
			db_raise("0006");
			return false;
		}
	}

	if($where){
		if(!($where_function = db_create_where_function($table_name,$where))){
			return false;
		}
		foreach($db_data[$table_name] as $key=>$record){
			if($where_function($record)){
				$cursor_records[]=	$record	;
			}
		}
	}else{
		$cursor_records=$db_data[$table_name];
	}
  
	if($order_by && is_array($cursor_records)){
		$sort_function=db_create_order_by_function($order_by);
		usort($cursor_records,$sort_function);
		unset($sort_function);
	}
  unset($where_function);
  return $cursor_records;
}
/*this function should check select parameters and return the result in one array*/
function db_select_exists($from,$where=null){
	global $db_data,$db_not_commited;
	/*check table*/
	$table_name=$from;
	if(!isset($db_data["TABS"][$table_name])){
		/*table not exists*/
			db_raise("0005");
			return false;
	}
	if( !isset($db_data[$table_name]) ){
		/*load table data if not loaded or was not locked by last loading*/ 
		
		if(!db_load_data($table_name)){
			db_raise("0006");
			return false;
		}
	}

	if($where){
		$where_function = db_create_where_function($table_name,$where);
		foreach($db_data[$table_name] as $key=>$record){
			if($where_function($record)){
				return true;
			}
		}
	}else{
		if(sizeof($db_data[$table_name])>0) return true;
	}
  	// nothing found
  	return false;
}
function db_update($table_name,$set,$where=null){
	global $db_data,$db_not_commited;
	/*check table*/
	if(!isset($db_data["TABS"][$table_name])){
		/*table not exists*/
			db_raise("0005");
			return false;
	}
	if(!isset($db_data[$table_name]) || !db_is_locked_table($table_name)){
		/*load table data if not loaded or was not locked by last loading*/ 
		while(!db_is_locked_table($table_name)){
			db_lock_table($table_name);
		}
		if(!db_load_data($table_name)){
			db_raise("0006");
			return false;
		}
	}

	/* creating set function */
	if($set){
		$set_function=db_create_set_function($table_name,$set);
/*		if(!function_exists($set_function)){
			db_raise("0009");
			return false;
		}*/
	}else{
		db_raise("0009");
		return false;
	}
	/* looking on where and processing it*/
	$num_updated=0;
	if($where){
		$where_function = db_create_where_function($table_name,$where);
		foreach($db_data[$table_name] as $key=>$record){
			if($where_function($record)){
				$db_data[$table_name][$key]=$set_function($record)	;
				$num_updated++;
			}
		}
	}else{
		foreach($db_data[$table_name] as $key=>$record){
				$db_data[$table_name][$key]=$set_function($record)	;
				$num_updated++;
		}
	}
	if(db_auto_commit()){
		if(!db_save_data($table_name)){
 		    db_unlock_table($table_name);
			   return false;
		}
		db_unlock_table($table_name);
	}else{
		$db_not_commited[]=$table_name;
	}
	return $num_updated;
		
}

function db_delete($table_name,$where=null){
	global $db_data,$db_not_commited;
	/*check table*/
	if(!isset($db_data["TABS"][$table_name])){
		/*table not exists*/
			db_raise("0005");
			return false;
	}
	if(!isset($db_data[$table_name]) || !db_is_locked_table($table_name)){
		/*load table data if not loaded or was not locked by last loading*/ 
		while(!db_is_locked_table($table_name)){
			db_lock_table($table_name);
		}
		if(!db_load_data($table_name)){
			db_raise("0006");
			return false;
		}
	}
	$num_deleted=0;
	/* looking on where and processing it*/
	if($where){
		$where_function = db_create_where_function($table_name,$where);
		foreach($db_data[$table_name] as $key=>$record){
			if($where_function($record)){
				unset($db_data[$table_name][$key]);
				$num_deleted++;
			}
		}
	}else{
		foreach($db_data[$table_name] as $key=>$record){
				unset($db_data[$table_name][$key]);
				$num_deleted++;
		}
	}
	if(db_auto_commit()){
		if(!db_save_data($table_name)){
 		    db_unlock_table($table_name);
			return false;
		}
 		    db_unlock_table($table_name);
	}else{
		$db_not_commited[]=$table_name;
	}
	return $num_deleted;

		
}
function db_free_memory(){
    global $db_data;
	foreach ($db_data as $key=>$table){
		if($key != "TABS" && $key!="SYS"){
			unset($db_data[$key]);
		}
	}
}
/*regex test*/
/*
echo preg_replace("/\btest\b/","\$test['test']", "this is 'test'  test=test+1 (test) test_pato on the testscreen");

/*
for($i=1;$i<100000;$i++){
	if($f=@fopen("../data/test.txt","x")){
//		sleep(5);
		echo "test ok ".time()."<br>";
		fwrite($f,"test test test test test test");
		fclose($f);
		unlink("../data/test.txt");
	}else{
		Echo "test false!!!!!!!!<br>";
	}
}

/*testing unit */
/*
$tt=time();
echo "start".$tt."<br>";
if(!db_create_database("test","data/")){
		echo "startup".time()."<br>";

		
		db_startup_database("test","data/");
		echo "Error: ".time()." ".db_get_last_error_text()."<br>";
}else{
	echo "created database<br>";
	db_create_sequence("seq1");
	db_create_sequence("seq2");
	db_create_table("table",Array("id"=>"","session"=>"","text"=>""));
}
echo "T:".(time()-$tt)."<br>";
db_set_auto_commit(false);
echo "T:".(time()-$tt)."<br>";
if(!($seq=db_get_seq_nextval("seq2"))){die(db_get_last_error_text());}
echo "T:".(time()-$tt)."<br>";
$ccc=0;
for($i=1;$i<500;$i++){
	echo "T:".(time()-$tt)."<br>";
	if(!($seq1=db_get_seq_nextval("seq1"))){die(db_get_last_error_text());}
	$ta=db_select_all("table");
	echo "T:".(time()-$tt)."<br>";	
	if(!db_insert("table",Array("id"=>$seq1,"session"=>$seq,"text"=>"texting"))){die("DIE".db_get_last_error_text());}
	$ccc++;
	if($ccc==10){
		$ccc=0;
		db_commit();
	}
}
db_commit();	
echo "T:".(time()-$tt)."<br>";

$rec=db_select_all("table","session==".$seq);
echo count($rec)." ".time()."<br>";
//db_delete("table","session==".$seq);
//$rec=db_select_all("table","session==".$seq);
//echo count($rec)."<br>";
echo "Error: ".db_get_last_error_text()."<br>";
*/