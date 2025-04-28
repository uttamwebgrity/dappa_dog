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
	
	$sql="select s.*,name as groming_type from service s left join grooming g on s.grooming_id=g.id  where s.id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);	
		
	$groming_type=$result[0]['groming_type'];	
	$service_name=$result[0]['service_name'];	
	$service_details=$result[0]['service_details'];
		
	
	$sql_services="select pet_size_id,time_required  from service_time  where service_id =" . (int) $_REQUEST['id'] . " and service_type=1";
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
      	<p><a href="settings/services.php">Services</a> &raquo; <?=$service_name?></=?></p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
<li class="activeTab"><a style="cursor: pointer;">View Service</a></li>             
</ul>  

<div class="tabPnlCont">
<div class="tabPnlContInr">

       
   <div class="tabcontArea" style="background:none;">
    <h3>General Information:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    	<li>Pet Type <br><b><?=$groming_type?></b></li>  
        <li>Service Name <br><b><?=$service_name?></b></li>
       	<li>Service Details<br><b><?=$service_details?></b></li>
                 
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