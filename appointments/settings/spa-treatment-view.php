<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

/*if((int)$_SESSION['admin_access_level'] == 2){		
    $_SESSION['message']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}*/

$data=array();

if(isset($_REQUEST['return_url']) && trim($_REQUEST['return_url']) != NULL){
	$_SESSION['return_url']=trim($_REQUEST['return_url']);	
}


if(isset($_REQUEST['action']) && $_REQUEST['action']=="VIEW"){
	
	$sql="select * from spa_service where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);	
		
	$service_name=$result[0]['spa_service_name'];	
	$service_details=$result[0]['spa_service_details'];
		
	
	$sql_main_service="select id,service_name from service where id IN (select service_id from service_spa_service where spa_service_id=" . (int) $_REQUEST['id'] . ")";
	$result_main_service=$db->fetch_all_array($sql_main_service);
	$total_main_service=count($result_main_service);
	
	$all_services="";
	
	for($main_service=0; $main_service < $total_main_service; $main_service++ ){
		$all_services .=$result_main_service[$main_service]['service_name'].", ";
	}
	$all_services=substr($all_services, 0,-2);
	
	
	$sql_services="select pet_size_id,time_required  from service_time  where service_id =" . (int) $_REQUEST['id'] . " and service_type=2";
	$result_services=$db->fetch_all_array($sql_services);	
	$total_services=count($result_services);
	
	$service_lengths=array();
	
	for($service=0; $service<$total_services; $service++){
		$service_lengths[$result_services[$service]['pet_size_id']]=$result_services[$service]['time_required'];	
	}
		
	
	$button="Update";
}


?>

 <div class="breadcrumb">
      	<p><a href="settings/spa-treatments.php">Spa Treatments</a> &raquo; <?=$service_name?></p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
<li class="activeTab"><a style="cursor: pointer;">View Spa Treatments</a></li>             
</ul>  

<div class="tabPnlCont">
<div class="tabPnlContInr">

       
   <div class="tabcontArea" style="background:none;">
    <h3>General Information:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    	<li>Spa Treatment <br><b><?=$service_name?></b></li>
       	<li>Spa Treatment Details<br><b><?=$service_details?></b></li>
       	<li>Services<br><b><?=$all_services?></b></li>
                 
    </ul>
    </div>
    </div>
    <h3>Service Length:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    <?php              
    	$sql_available_sizes="select id,size_name from pet_available_sizes order by id + 0 ASC";						
       	$result_available_sizes=$db->fetch_all_array($sql_available_sizes);
		$total_available_sizes=count($result_available_sizes);
		for($available_sizes=0; $available_sizes < $total_available_sizes; $available_sizes++ ){?>
			<li style="display: block;"><?=$result_available_sizes[$available_sizes]['size_name']?><br/><b style="width: 100px;"><?=$service_lengths[$result_available_sizes[$available_sizes]['id']]?> minutes</b></li>
		<?php } ?>            
    
    </ul>
    </div>
    </div>
  
  
  
    <div class="submitSection">            	
    <input name="back" type="button" value="Back" onclick="location.href='<?=$_SESSION['return_url']?>'" class="backBtn" />

</div>
</div>
   <br class="clear" />
</div>
</div>        
            
<?php
include("../foot.htm");
?>