<?php
include_once("../includes/configuration.php");

$grooming_id=$_REQUEST['grooming'];
$type=$_REQUEST['type'];


$data_string="";

if(strtolower(trim($type)) == "grooming_type"){//************  collect all respective core services
	$sql_service="select id,service_name from service where parent_id = 0 and grooming_id ='" . $grooming_id. "' order by service_name + 0 ASC";						
    $result_service=$db->fetch_all_array($sql_service);
	$total_service=count($result_service);
	for($service=0; $service < $total_service; $service++ ){
		$data_string .= $result_service[$service]['service_name']."/!".$result_service[$service]['id']."#";	
	}	
}

echo $data_string;
?>