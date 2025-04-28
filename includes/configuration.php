<?php
ob_start();
session_start();
error_reporting(0);


require_once("classes/database.class.php");
require_once("classes/general.class.php");
require_once("classes/database.dappaDogs.class.php");
require_once("classes/send_mail.class.php");


/*require_once("classes/validator.class.php");



include_once("classes/upload.class.php");
*/



//**************************************************************************************************************//
$db = new Database(); //******************  Database class
$general_func = new General(); 

$objdappaDogs = new dappaDogs(); 
$sendmail = new send_mail();



/*$validator = new Validator(); 


$upload = new uploadclass();
*/



//**********************  General value *******************************************//
$sql_general="select option_name,option_value from tbl_options where admin_id=1 and (option_name='site_title' or option_name='admin_recoed_per_page' or option_name='global_meta_title' or option_name='site_url' or option_name='admin_url' or ";
$sql_general .=" option_name='opening_time' or option_name='closing_time' or option_name='site_address' or option_name='admin_address' or";
$sql_general .=" option_name='global_meta_keywords' or option_name='global_meta_description' or option_name='address' or option_name='phone' or option_name='email' or option_name='facebook')";

$result_general=$db->fetch_all_array($sql_general);

if(count($result_general) > 0){
	for($i=0; $i <count($result_general); $i++){
		$$result_general[$i]['option_name']=trim($result_general[$i]['option_value']);
	}
}



$general_func->site_title=$site_title; 
$general_func->site_url=$site_address;
$general_func->admin_url=$admin_address;



$general_func->admin_recoed_per_page=$admin_recoed_per_page;
$general_func->global_meta_title=$global_meta_title;
$general_func->global_meta_keywords=$global_meta_keywords;
$general_func->global_meta_description=$global_meta_description;
$general_func->address=$address;
$general_func->phone=$phone;
$general_func->email=$email;
$general_func->facebook=$facebook;;
$general_func->opening_time=$opening_time;
$general_func->closing_time=$closing_time;




//********************* Global Value **********************************************************//

date_default_timezone_set('EST');
$today_date_time=date("Y-m-d H:i:s");
$today_date=date("Y-m-d");
$today_year=date("Y");
$current_time_ms=time();


function search($array, $key, $value){
    $results = array();

    if (is_array($array)){
        if (isset($array[$key]) && $array[$key] == $value)
            $results[] = $array;

        foreach ($array as $subarray)
            $results = array_merge($results, search($subarray, $key, $value));
    }
    return $results;
}
function sortTwoDimensionArrayByKey($arr, $arrKey, $sortOrder=SORT_ASC){
	foreach ($arr as $key => $row){
		$key_arr[$key] = $row[$arrKey];
	}
	array_multisort($key_arr, $sortOrder, $arr);
	
	
	return $arr;
}


function escape($string) {
	if(get_magic_quotes_gpc())
		$string = stripslashes($string);
		
	return mysql_real_escape_string($string);
}


//date("N")->ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0)
$all_days_in_a_week=array();
$all_days_in_a_week[1]="Monday";
$all_days_in_a_week[2]="Tuesday";
$all_days_in_a_week[3]="Wednesday";
$all_days_in_a_week[4]="Thursday";
$all_days_in_a_week[5]="Friday";
$all_days_in_a_week[6]="Saturday";
$all_days_in_a_week[7]="Sunday";

//********************************************************************************************//






?>