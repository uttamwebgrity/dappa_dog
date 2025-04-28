<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";

if($_SESSION['admin_access_level'] != 1 && ! in_array(17,$_SESSION['access_permission'])){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


if(isset($_REQUEST['salon_id']) && trim($_REQUEST['salon_id']) != NULL){
	$_SESSION['salon_id']=trim($_REQUEST['salon_id']);	
}


if($_SESSION['admin_access_level'] == 2 &&  !$objdappaDogs->his_own_salon($_SESSION['admin_user_id'],$_SESSION['salon_id'])){
	$_SESSION['msg']="Sorry, you do not have the permission to access this salon!";
	$general_func->header_redirect($general_func->admin_url."home.php");	
} 



$data=array();

if(isset($_POST['enter']) && $_POST['enter']=="salon_services"){	
	$salon_service=array();
	$salon_service=$_REQUEST['salon_service'];
	$total_salon_service=count($salon_service);	
	
	$salon_spa_service=array();
	$salon_spa_service=$_REQUEST['salon_spa_service'];
	$total_salon_spa_service=count($salon_spa_service);
	
	$db->query("delete from salon_services where salon_id='" . $_SESSION['salon_id'] . "'");
	
	if( $total_salon_service > 0 || $total_salon_spa_service > 0 ){
		
		$services_data = "INSERT INTO `salon_services` (`service_id`, `salon_id`,`service_type`) VALUES ";
		
		//***************  Services ***********************//
		if($total_salon_service > 0){
			for($s=0; $s<$total_salon_service; $s++){
				$services_data .="('" . $salon_service[$s] ."', '" . $_SESSION['salon_id'] ."',1), ";
			}
		}		
		//***************  Spa Treatments ***********************//
		if($total_salon_spa_service > 0){
			for($s=0; $s<$total_salon_spa_service; $s++){
				$services_data .="('" . $salon_spa_service[$s] ."', '" . $_SESSION['salon_id'] ."',2), ";
			}
		}
								
		$services_data = substr($services_data,0,-2);
		$services_data .=";";				
		$db->query($services_data);
		
		$_SESSION['msg']="Your selected services has been added to salon -'" . $objdappaDogs->salon_name($_SESSION['salon_id']). "'";
		$general_func->header_redirect($_SERVER['PHP_SELF']);
	}	
}	


$sql_added_services="select service_id from salon_services where salon_id='" . $_SESSION['salon_id'] . "' and service_type=1";
$result_added_services=$db->fetch_all_array($sql_added_services);
$total_added_services=count($result_added_services);
	
$salon_services=array();
	
for($service=0; $service<$total_added_services; $service++){
	$salon_services[]=$result_added_services[$service]['service_id'];	
}

$sql_added_spa="select service_id from salon_services where salon_id='" . $_SESSION['salon_id'] . "' and service_type=2";
$result_added_spa=$db->fetch_all_array($sql_added_spa);
$total_added_spa=count($result_added_spa);
	
$salon_spa=array();
	
for($spa=0; $spa<$total_added_spa; $spa++){
	$salon_spa[]=$result_added_spa[$spa]['service_id'];	
}


$total_added_services_and_spa=$total_added_services + $total_added_spa;	
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
        <div class="tabPnlCont">
<div class="tabPnlContInr">
        <div class="tableBgStyle" style="background:none;">
        <div class="row">
        <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" >
        <input type="hidden" name="enter" value="salon_services" />      	
       	 	
			 <table cellpadding="0" cellspacing="0" class="staffServ">
           
            <tr>
                <td width="2%" align="left" valign="top"></td>
            	<td width="49%" align="left" valign="top"><h4>Service name</h4></td>              
            </tr> 
            <tr>
	                <td width="2%" align="left" valign="top"></td>
                  <td width="49%" align="left" valign="top" class="core-ser" >
                  	<ul>   
			<?php 
				$sql_services="select id,service_name,service_details from service order by service_name";
				$result_services=$db->fetch_all_array($sql_services);
				$total_services=count($result_services);
				
				for($services=0; $services < $total_services; $services++ ){?>
				
                  		<li>
                  			<input type="checkbox" name="salon_service[]" id="salon_service" <?=in_array($result_services[$services]['id'],$salon_services)?'checked="checked"':'';?>  value="<?=$result_services[$services]['id']?>" ><span><?=$result_services[$services]['service_name']?></span>
                  			<?php if(trim($result_services[$services]['service_details']) != NULL){?>                  	
                  			<a onmouseout="hideddrivetip();" onmouseover="ddrivetip('<?=addslashes($result_services[$services]['service_details'])?>');"><img src="images/i.png" alt="" /></a>
                  			<?php } ?>
                  		</li>
                  	
				<?php }?>
				</ul>
                  	</td> 
            	</tr>   
				<?php								
				$sql_spa_services="select id,spa_service_name,spa_service_details from spa_service";
				$result_spa_services=$db->fetch_all_array($sql_spa_services);
				$total_spa_services=count($result_spa_services);
				
				if($total_spa_services > 0){?>
				<tr>
                	<td width="2%" align="left" valign="top"></td>
            		<td width="49%" align="left" valign="top"><h4>Spa Treatments</h4></td>              
            	</tr>
            	<tr>
	            	<td width="2%" align="left" valign="top"></td>
                  	<td width="49%" align="left" valign="top" class="core-ser" >
                  		<ul> 					
						<?php 
						for($spa=0; $spa < $total_spa_services; $spa++ ){?>
							<li><input type="checkbox" name="salon_spa_service[]" id="salon_spa_service" <?=in_array($result_spa_services[$spa]['id'],$salon_spa)?'checked="checked"':'';?>  value="<?=$result_spa_services[$spa]['id']?>" ><span><?=$result_spa_services[$spa]['spa_service_name']?></span>
								<?php if(trim($result_spa_services[$spa]['spa_service_details']) != NULL){?>                  	
				     			<a onmouseout="hideddrivetip();" onmouseover="ddrivetip('<?=addslashes($result_spa_services[$spa]['spa_service_details'])?>');"><img src="images/i.png" alt="" /></a>
				      			<?php }?>
							</li>
						<?php }	?>				
						</ul>
                  	</td> 
            	</tr> 
				<?php }	?>
				<tr>
                <td width="100%" colspan="4" height="20px;"></td>
            </tr>
            </table>
       	 <div class="submitSection">
            	<?php if($total_added_services_and_spa == 0 ){?>
	       <input name="save" type="submit" value="" class="saveBtn" />					
            	<?php }else{?>            		
					 <input name="update" type="submit" value="" class="updateBtn" />
            	<?php }?> 
            	<input name="back" type="button" value="Back" onclick="location.href='settings/salons.php'" class="backBtn" />
                </div>
       	 </form>
        </div>
        </div>
        <br class="clear" />
</div>
</div>
<?php
include_once("../foot.htm");
