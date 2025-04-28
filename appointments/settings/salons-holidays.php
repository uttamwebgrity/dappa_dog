<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";

if($_SESSION['admin_access_level'] != 1 && ! in_array(16,$_SESSION['access_permission'])){	
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


if(isset($_GET['action']) && $_GET['action']=='delete'){
		
	$db->query_delete("salon_holidays","id='".$_REQUEST['id'] ."'");	
	$_SESSION['msg']="Your selected holiday deleted!";
	$general_func->header_redirect($_REQUEST['url']);
} 


if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){
	$sql="select * from salon_holidays where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);	
	$haliday_date=$general_func->display_date($result[0]['haliday_date'],7);
	$details=$result[0]['details'];		
	$button="Update";
}else{
	$haliday_date="";			
	$details="";			
	$button="Add New";
}




if(isset($_POST['enter']) && $_POST['enter']=="haliday"){
	$haliday_date=$general_func->display_date(trim($_REQUEST['haliday_date']),11);
	$details=trim($_REQUEST['details']);
	
	if($_POST['submit']=="Add New"){		
		if($db->already_exist_inset("salon_holidays","haliday_date",$haliday_date,"details",$details,"salon_id",$_SESSION['salon_id'])){
			$_SESSION['msg']="Sorry, your specified holiday is already taken!";			
		}else{
			$data['haliday_date']=$haliday_date;
			$data['details']=$details;	
			$data['salon_id']=$_SESSION['salon_id'];	
			$db->query_insert("salon_holidays",$data);
			
			$_SESSION['msg']="Holiday successfully added!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}
	}else{
		if($db->already_exist_update("salon_holidays","id",$_REQUEST['id'],"haliday_date",$haliday_date,"details",$details,"salon_id",$_SESSION['salon_id'])){	
			$_SESSION['msg']="Sorry, your specified holiday is already taken!";					
		}else{
			$data['haliday_date']=$haliday_date;
			$data['details']=$details;	
			$data['salon_id']=$_SESSION['salon_id'];	
			$db->query_update("salon_holidays",$data,"id='".$_REQUEST['id'] ."'");
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Holiday successfully updated!";
			
			$general_func->header_redirect($_SESSION['return_url']);
		}
		
	}						
	
}	


$url=$_SERVER['PHP_SELF']."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
$recperpage=$general_func->admin_recoed_per_page;


$order_by="haliday_date ASC";


if(isset($_REQUEST['selected_year']) && intval($_REQUEST['selected_year']) > 0){
	$selected_year=$_REQUEST['selected_year'];
}else {
	$selected_year=$today_year;
}



$query="where salon_id='" . $_SESSION['salon_id'] ."' and YEAR(haliday_date) = '" . $selected_year . "'";			
$sql="select * from salon_holidays $query order by $order_by";
				
//-	----------------------------------/Pagination------------------------------
				
if(isset($_GET['in_page'])&& $_GET['in_page']!="")
	$page=$_GET['in_page'];
else
	$page=1;
	
$total_count=$db->num_rows($sql);
$sql=$sql." limit ".(($page-1)*$recperpage).", $recperpage";
				
if($page>1){
	$url_prev=stristr($url,"&in_page=".$page)==FALSE?$url."&page=".($page-1):str_replace("&in_page=".$page,"&in_page=".($page-1),$url);
	$prev="&nbsp;<a href='$url_prev' class='nav'>Prev</a>";
}else
	$prev="&nbsp;Prev";
			
if((($page)*$recperpage)<$total_count){
	$url_next=stristr($url,"&in_page=".$page)==FALSE?$url."&in_page=".($page+1):str_replace("&in_page=".$page,"&in_page=".($page+1),$url);
	$next="&nbsp;<a href='$url_next' class='nav'>Next</a>";
}else
	$next="&nbsp;Next";
				
	$page_temp=(($page)*$recperpage);
	$page_temp=$page_temp<$total_count?$page_temp:$total_count;
	$showing=" Showing ".(($page-1)*$recperpage+1)." - ".$page_temp." of ".$total_count." | ";
				 
//-----------------------------------/Pagination------------------------------
	
$result=$db->fetch_all_array($sql);
$total_customers=count($result);


?>
<style type="text/css">





/* 
Generic Styling, for Desktops/Laptops 
*/
table { 
  width: 100%; clear:both; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #ffffff; 
}
tr:nth-of-type(even) { 
  background: #f1fbfd; 
}

th { 
  background: #86cee0; 
  color:#3a6c79; 
  font-family: 'proxima_nova_rgregular';
  font-weight: bold; 
  font-size:15px;
  line-height:16px;
  padding:5px 0;
}
td, th { 
  padding: 6px; 
  /*border: 1px solid #66bdf0; */
  font-family: 'proxima_nova_rgregular';
  text-align: left; 
  font-size:13px;
}
/* 
Max width before this PARTICULAR table gets nasty
This query will take effect for any screen smaller than 760px
and also iPads specifically.
*/
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { /*border: 1px solid #66bdf0;*/ }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		/*border-bottom: 1px solid #66bdf0; */
		position: relative;
		padding-left: 50%; 
		text-align:left !important;
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	/*
	Label the data
	*/
	
	td:nth-of-type(1):before { content: "S.No"; }	
	td:nth-of-type(2):before { content: "Holidays"; }	
	td:nth-of-type(3):before { content: "Date"; }
	td:nth-of-type(4):before { content: "Day"; }		
	td:nth-of-type(5):before { content: "Action"; }
}

</style>

<script language="JavaScript">


function del(id,url,name){
	var a=confirm("Are you sure, you want to delete holiday: '" + name +"'?")
    if (a){
    	location.href="<?=$_SERVER['PHP_SELF']?>?id="+id+"&action=delete&url="+url;
    }  
}

function validate(){	
			
	if(!validate_text(document.ff.haliday_date,1,"Please enter holiday's date"))
		return false;
	if(!validate_text(document.ff.details,1,"Please enter holiday details"))
		return false;
		
}		 
</script>
 <div class="breadcrumb">
      	 	<p><a href="settings/salons.php">Salons</a> &raquo; List of Holidays </p>
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
        <div class="tableBgStyle" style="background:none">
        <div class="row">
       	  <div class="proAttbInst">
       	<form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="haliday" />
        <input type="hidden" name="salon_id" value="<?=$_SESSION['salon_id']?>" />       
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
        <input name="submit" type="hidden" value="<?=$button?>" />
          	<ul>
                <li><span>Date</span><input class="datepicker" name="haliday_date" readonly="readonly" value="<?=$haliday_date?>" /></li>
                <li><span>Holidays</span><input name="details" type="text" value="<?=$details?>" /></li>
                <li><div class="submitSection">
                  <?php if($button =="Add New"){?>
            		 <input name="save" type="submit" value="" class="saveBtn" />					
            	<?php }else{?>            		
					 <input name="back" type="button" value="Back" onclick="location.href='<?=$_SESSION['return_url']?>'" class="backBtn" />
					 <input name="update" type="submit" value="" class="updateBtn" />

            	<?php }?>
            </div></li>
            </ul>
            </form>
          </div> 
              <div class="sortPnl"><span>Filter by Year:</span>
              	<select name="selected_year" onchange="location.href='<?=$_SERVER['PHP_SELF']?>?selected_year='+this.value">
              	<?php
				$sql_year="select DISTINCT(YEAR(haliday_date)) as year from salon_holidays order by year";
              	$result_year=$db->fetch_all_array($sql_year);
				
				for($year=0; $year < count($result_year); $year++ ){?>
				<option value="<?=$result_year[$year]['year']?>" <?=$selected_year==$result_year[$year]['year']?'selected="selected"':'';?>><?=$result_year[$year]['year']?></option>	
					
				<?php }
              	?>	
              		
              	</select></div>     
        </div>
        </div>
        
        <table>
      <thead>
      	
      	
      	
            <tr>
                <th width="10%">S.No</th> 
                <th width="45%">Holidays</th>
                 <th width="15%">Date</th>
                <th width="15%">Day</th>                         
                <th width="15%" style="text-align:center">Action</th>
            </tr>
            </thead>
            <tbody>
             <?php for($j=0; $j<$total_customers; $j++){?>
             	<tr>
                <td><?=$j+1?></td>  
                 <td><?=$result[$j]['details']?></td>   
                  <td><?=$general_func->display_date($result[$j]['haliday_date'],10)?></td>   
                   <td><?=$general_func->display_date($result[$j]['haliday_date'],9)?></td>                 
                <td style="text-align:center">
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>settings/salons-holidays.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />&nbsp;&nbsp;&nbsp;
                    <img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>','<?=$result[$j]['details']?>')" style="cursor:pointer;" />
               </td>
            </tr>
             <?php }?>         	
  </tbody>
      </table>
        <div class="paginationPnl">
         <?php 
		if ($total_count>$recperpage) {
		?>
		
						&nbsp;Jump to page 
 <select name="in_page" style="width:45px;" onChange="javascript:location.href='<?php echo str_replace("&in_page=".$page,"",$url);?>&in_page='+this.value;">
				  <?php for($m=1; $m<=ceil($total_count/$recperpage); $m++) {?>
				  <option value="<?php echo $m;?>" <?php echo $page==$m?'selected':''; ?>><?php echo $m;?></option>
				  <?php }?>
				</select>
				of 
		  <?php echo ceil($total_count/$recperpage); ?>	
		 <p style="float:right;"><?php echo " ".$showing." ".$prev." ".$next." &nbsp;";?></p>
	    </div>
  <br class="clear" />
</div>
</div>      
        
<?php  }?>
            
<?php
include_once("../foot.htm");
?>