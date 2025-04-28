<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";


/*if((int)$_SESSION['admin_access_level'] == 2){		
    $_SESSION['message']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}*/




if(isset($_REQUEST['salon_id']) && trim($_REQUEST['salon_id']) != NULL){
	$_SESSION['salon_id']=trim($_REQUEST['salon_id']);	
}

$data=array();

if(isset($_POST['enter']) && $_POST['enter']=="salon_services"){	
	$salon_service=array();
	$salon_service=$_REQUEST['salon_service'];
	$total_salon_service=count($salon_service);	
	
	if( $total_salon_service > 0){
		$db->query("delete from salon_services where salon_id='" . $_SESSION['salon_id'] . "'");			
		
		$services_data = "INSERT INTO `salon_services` (`service_id`, `salon_id`) VALUES ";
		
		for($s=0; $s<$total_salon_service; $s++){
			$services_data .="('" . $salon_service[$s] ."', '" . $_SESSION['salon_id'] ."'), ";
		}
				
		$services_data = substr($services_data,0,-2);
		$services_data .=";";				
		$db->query($services_data);
		$_SESSION['msg']="Your selected services has been added to salon -'" . $objdappaDogs->salon_name($_SESSION['salon_id']). "'";
		$general_func->header_redirect($_SERVER['PHP_SELF']);
	}	
}	



$sql_added_services="select service_id from salon_services where salon_id='" . $_SESSION['salon_id'] . "'";
$result_added_services=$db->fetch_all_array($sql_added_services);
$total_added_services=count($result_added_services);
	
$salon_services=array();
	
for($service=0; $service<$total_added_services; $service++){
	$salon_services[]=$result_added_services[$service]['service_id'];	
}
	
?>


 <div class="breadcrumb">
      	 	<p><a href="settings/salons.php">Salons</a> &raquo; List of Services </p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
 
        <ul class="tabBtn">
            	<li class="activeTab"><a style="cursor: pointer;"><?=$objdappaDogs->salon_name($_SESSION['salon_id'])?></a></li>              
 		</ul>
        <div class="tableBgStyle">
        <div class="row">
        <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" >
        <input type="hidden" name="enter" value="salon_services" />
       	 <table width="100%" cellpadding="0" cellspacing="1" class="staffServ">
       	 	<?php
       	 	$sql_grooming="select id,name from grooming where id IN(select DISTINCT(grooming_id) from service)  order by name";
			$result_grooming=$db->fetch_all_array($sql_grooming);
			for($gromming=0; $gromming < count($result_grooming); $gromming++ ){?>
			<tr>
                <td width="100%" colspan="4"><strong><?=$result_grooming[$gromming]['name']?></strong></td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="20%"><strong>Service name</strong></td> 
                <td width="55%"><strong>Details</strong></td>               
                <td width="20%"><strong>Core Service</strong></td> 
            </tr>   
			<?php 
				$sql_services="select id,parent_id,service_name,service_details from service where grooming_id='" . $result_grooming[$gromming]['id']. "'  order by parent_id + 0,service_name";
				$result_services=$db->fetch_all_array($sql_services);
				$total_services=count($result_services);
				
				for($services=0; $services < $total_services; $services++ ){?>
				<tr>
	                <td width="5%"><input type="checkbox" name="salon_service[]" id="salon_service" <?=in_array($result_services[$services]['id'],$salon_services)?'checked="checked"':'';?>  value="<?=$result_services[$services]['id']?>" ></td>
	                <td width="20%"><?=$result_services[$services]['service_name']?></td> 
	                <td width="55%"><?=$result_services[$services]['service_details']?></td>               
	                <td width="20%"><?=$objdappaDogs->show_core($result_services[$services]['parent_id'])?></td> 
            	</tr>   
					
				<?php }?>
					<tr>
                <td width="100%" colspan="4" height="20px;"></td>
            </tr>
				<?php
			}
       	 	?>
       	 </table>
       	 
       	 <div class="submitSection">
            	<?php if($total_added_services == 0 ){?>
            		 <input name="save" type="submit" value="" class="saveBtn" />					
            	<?php }else{?>            		
					 <input name="update" type="submit" value="" class="updateBtn" />
            	<?php }?>
            	
       	   
            	<input name="back" type="button" value="Back" onclick="location.href='settings/salons.php'" class="backBtn" />
                
            </div>
       	 
       	 </form>
        </div>
        </div>
<?php
include_once("../foot.htm");
