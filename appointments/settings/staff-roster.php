<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";


if((int)$_SESSION['admin_access_level'] == 3){		
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


if(isset($_REQUEST['staff_id']) && trim($_REQUEST['staff_id']) != NULL){
	$_SESSION['staff_id']=trim($_REQUEST['staff_id']);	
}


if($_SESSION['admin_access_level'] == 2 &&  !$objdappaDogs->his_own_salon_staff($_SESSION['admin_user_id'],$_SESSION['staff_id'])){
	$_SESSION['msg']="Sorry, you do not have the permission to access this staff!";
	$general_func->header_redirect($general_func->admin_url."home.php");	
} 



if(isset($_GET['action']) && $_GET['action']=='delete'){		
	
	$splited_salon_day=array();	
	$splited_salon_day=explode("_",$_GET['value']);//********  0-salon/1-dayindex					

	$db->query_delete("staff_salon_availability","staff_id='".$_SESSION['staff_id'] ."' and salon_id='".$splited_salon_day[0] ."' and working_day='".$splited_salon_day[1] ."'");
	$_SESSION['msg']="Your selected day has been deleted!";
	$general_func->header_redirect($_SERVER['PHP_SELF']);
} 





$data=array();

if(isset($_POST['enter']) && $_POST['enter']=="staff_roster"){	
	$salon_days=array();
	$salon_days=$_REQUEST['salon_days'];
	$total_salon_days=count($salon_days);
	
	
	if($total_salon_days > 0){		
		
		for($sd=0; $sd<$total_salon_days; $sd++){
			$splited_salon_day=array();	
			$splited_salon_day=explode("_",$salon_days[$sd]);//********  0-salon/1-dayindex	
			
			$from_time=$_REQUEST['from_time_'.$salon_days[$sd]];
			$to_time=$_REQUEST['to_time_'.$salon_days[$sd]];
			
			if($to_time > $from_time){//***** to time > from tim
				$result_staff_salon_daytime=$db->fetch_all_array("select id from staff_salon_availability where staff_id='" . $_SESSION['staff_id'] ."' and salon_id='" . $splited_salon_day[0] ."' and working_day ='" . $splited_salon_day[1] ."' limit 1");
				
				if(count($result_staff_salon_daytime) == 0){//*** not exists
					/*echo "select id from staff_salon_availability where ('" . $from_time ."' BETWEEN start_time AND end_time OR '" . $to_time ."' BETWEEN start_time AND end_time) and staff_id='" . $_SESSION['staff_id'] ."' and salon_id !='" . $splited_salon_day[0] ."' and working_day ='" . $splited_salon_day[1] ."' ";
					echo "<br/>";*/				
					$result_staff_salon_daytime_exists_to_another_salon=$db->fetch_all_array("select id from staff_salon_availability where ('" . $from_time ."' BETWEEN start_time AND end_time OR '" . $to_time ."' BETWEEN start_time AND end_time) and staff_id='" . $_SESSION['staff_id'] ."' and salon_id !='" . $splited_salon_day[0] ."' and working_day ='" . $splited_salon_day[1] ."' ");
					if(count($result_staff_salon_daytime_exists_to_another_salon) == 0){//*********  insert to DB
						$insert_data = "INSERT INTO `staff_salon_availability` (`staff_id`, `salon_id`, `working_day`,`start_time`, `end_time`) VALUES ";	
						$insert_data .="('" . $_SESSION['staff_id'] ."', '" . $splited_salon_day[0] ."', '" . $splited_salon_day[1] ."', '" . $from_time ."', '" . $to_time ."')";
						/*echo "<br/>";
						echo "<br/>";*/
						$db->query($insert_data);
					}
				}else{//************** already exists
					$id=$result_staff_salon_daytime[0]['id'];	
					/*echo "select id from staff_salon_availability where ('" . $from_time ."' BETWEEN start_time AND end_time OR '" . $to_time ."' BETWEEN start_time AND end_time) and staff_id='" . $_SESSION['staff_id'] ."' and salon_id !='" . $splited_salon_day[0] ."' and working_day ='" . $splited_salon_day[1] ."'";
					exit;*/				
					$result_staff_salon_daytime_exists_to_another_salon=$db->fetch_all_array("select id from staff_salon_availability where ('" . $from_time ."' BETWEEN start_time AND end_time OR '" . $to_time ."' BETWEEN start_time AND end_time) and staff_id='" . $_SESSION['staff_id'] ."' and salon_id !='" . $splited_salon_day[0] ."' and working_day ='" . $splited_salon_day[1] ."'");
					if(count($result_staff_salon_daytime_exists_to_another_salon) == 0){//*********  update to DB
						$update_data = "UPDATE `staff_salon_availability` set 
						`staff_id`='" . $_SESSION['staff_id'] ."', 
						`salon_id`='" . $splited_salon_day[0] ."', 
						`working_day`='" . $splited_salon_day[1] ."',
						`start_time`='" . $from_time ."', 
						`end_time`='" . $to_time ."'  where id='" . $id . "'";											
						$db->query($update_data);
					}
				}
			}
		}

		$_SESSION['msg']="Your selected hours has been added to staff -'" . $objdappaDogs->staff_name($_SESSION['staff_id']). "'";
		//$general_func->header_redirect($_SERVER['PHP_SELF']);
	}	
}	


$sql_added_days="select CONCAT(salon_id,'_',working_day) as salon_days,start_time,end_time from staff_salon_availability where staff_id='" . $_SESSION['staff_id'] . "'";
$result_added_days=$db->fetch_all_array($sql_added_days);
$total_added_days=count($result_added_days);
	
$salon_added_days=array();
	
for($added_days=0; $added_days<$total_added_days; $added_days++){
	$salon_added_days[$added_days]=$result_added_days[$added_days]['salon_days'];
	$salon_added_days["from_time_".$result_added_days[$added_days]['salon_days']]=$result_added_days[$added_days]['start_time'];
	$salon_added_days["to_time_".$result_added_days[$added_days]['salon_days']]=$result_added_days[$added_days]['end_time'];		
}


//print_r ($salon_services);	
?>
<script language="JavaScript">
function del(value,day,salon){
	var a=confirm("Are you sure, you want to delete '" + day +"' schedule from salon '" + salon +"'?")
    if (a){
    	location.href="<?=$_SERVER['PHP_SELF']?>?value="+value+"&action=delete";
    }  
} 
</script>

 <div class="breadcrumb">
      	 	<p><a href="settings/staffs.php">Staff</a>  &raquo; List of Hours</p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?> 
        <ul class="tabBtn">
            	<li class="activeTab"><a style="cursor: pointer;"><?=$objdappaDogs->staff_name($_SESSION['staff_id'])?></a></li>              
 		</ul>
        <div class="tabPnlCont">
<div class="tabPnlContInr">
        <div class="tableBgStyle" style="background:none;">
        <div class="row">
        <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" >
        <input type="hidden" name="enter" value="staff_roster" />
       	 
       	 	<?php       	 	
       	 	 $staff_query .=" where staff_id='" . $_SESSION['staff_id']. "'";
             if((int)$_SESSION['admin_access_level'] == 2){
				$staff_query .=" and salon_id='" . $_SESSION['admin_user_id'] . "'";
			}	
       	 	
       	 	$sql_attached_salons="select id,salon_name,opening_time,closing_time from salons where id IN(select DISTINCT(salon_id) from staff_salon $staff_query) "; //attached salon
       	 	$result_attached_salons=$db->fetch_all_array($sql_attached_salons);
			for($salons=0; $salons < count($result_attached_salons); $salons++ ){?>
				<table width="100%" cellpadding="0" cellspacing="0" class="listHour">
                <tr>
                	<td width="100%" colspan="4"><h3><?=$result_attached_salons[$salons]['salon_name']?></h3></td>
            	</tr>
            	
				<tr>
                <td width="100%" colspan="4" height="2px;"></td>
            </tr>
			<?php 
		
				//************ working_days **********************//	
				$sql_working_day="select working_day from salon_working_days where salon_id='" . $result_attached_salons[$salons]['id'] . "' order by working_day + 0 ASC";
				$result_working_day=$db->fetch_all_array($sql_working_day);
				$total_working_day=count($result_working_day);
				
				$working_days=array();
				
				for($day=0; $day<$total_working_day; $day++){
					$value_salon_working=$result_attached_salons[$salons]['id']."_".$result_working_day[$day]['working_day'];				
					
					?>
				<tr>
                	<td width="20%">
                		<input type="checkbox" name="salon_days[]" id="salon_days" <?=in_array($value_salon_working,$salon_added_days)?'checked="checked"':'';?> value="<?=$value_salon_working?>" >
                		&nbsp; <strong><?=substr($all_days_in_a_week[$result_working_day[$day]['working_day']],0,3)?></strong> </td>
                	<td width="80%" colspan="3" align="left">
                		From 
                    	<select name="from_time_<?=$result_attached_salons[$salons]['id']?>_<?=$result_working_day[$day]['working_day']?>">
                    	<?php for ($i = $result_attached_salons[$salons]['opening_time']; $i <= $result_attached_salons[$salons]['closing_time']; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=(isset($salon_added_days["from_time_".$value_salon_working]) && $salon_added_days["from_time_".$value_salon_working]==$i)?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                    		
                    	</select>
                    	
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 	  
                  To 
                   	<select name="to_time_<?=$result_attached_salons[$salons]['id']?>_<?=$result_working_day[$day]['working_day']?>">
                    <?php for ($i = $result_attached_salons[$salons]['opening_time']; $i <= $result_attached_salons[$salons]['closing_time']; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=(isset($salon_added_days["to_time_".$value_salon_working]) && $salon_added_days["to_time_".$value_salon_working]==$i)?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                    		
                    	</select>
                   <?php
                   if(in_array($value_salon_working,$salon_added_days)){?>
                   	<img src="images/tick1.png" />&nbsp;&nbsp; <img src="images/del1.png" title="DELETE" alt="DELETE" onclick="del('<?=$value_salon_working?>','<?=$all_days_in_a_week[$result_working_day[$day]['working_day']]?>','<?=$result_attached_salons[$salons]['salon_name']?>')" style="cursor:pointer;" />				
                  <?php } else{?>
					  <img src="images/tick1dis.png" />
					  <?php  } ?>                		
                	</td>
            	</tr>
				 <?php }?>
				 <tr>
                	<td width="100%" colspan="4" height="15px;"></td>
            	</tr>
                </table>
				 <?php
			}	
       	 	?>
       	        	 
       	 <div class="submitSection">
            	<?php if($total_added_days == 0 ){?>
            		 <input name="save" type="submit" value="" class="saveBtn" />					
            	<?php }else{?>            		
					 <input name="update" type="submit" value="" class="updateBtn" />
            	<?php }?>  
            	<input name="back" type="button" value="Back" onclick="location.href='settings/staffs.php'" class="backBtn" />
               </div>
       	 </form>
        </div>
        </div>
<br class="clear" />
</div>
</div>        
        
<?php
include_once("../foot.htm");
