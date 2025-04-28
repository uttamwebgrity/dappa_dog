<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";


/*if((int)$_SESSION['admin_access_level'] == 2){		
    $_SESSION['message']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}*/


if(isset($_REQUEST['return_url']) && trim($_REQUEST['return_url']) != NULL){
	$_SESSION['return_url']=trim($_REQUEST['return_url']);	
}


$data=array();


if(isset($_GET['action']) && $_GET['action']=='delete'){		
	$db->query_delete("breeding_status","id='".$_REQUEST['id'] ."'");	
	$_SESSION['msg']="Your selected breeding status deleted!";
	$general_func->header_redirect($_REQUEST['url']);
} 


if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){
	$sql="select * from breeding_status where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);
	$name=$result[0]['name'];	
	$button="Update";
}else{		
	$name="";			
	$button="Add New";
}




if(isset($_POST['enter']) && $_POST['enter']=="breeding_status"){
	$name=trim($_REQUEST['name']);
	
	
	if($_POST['submit']=="Add New"){		
		if($db->already_exist_inset("breeding_status","name",$name)){
			$_SESSION['msg']="Sorry, your specified breeding status is already taken!";			
		}else{
			$data['name']=$name;		
			$db->query_insert("breeding_status",$data);
			
			$_SESSION['msg']="Breeding status successfully added!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}
	}else{
		if($db->already_exist_update("breeding_status","id",$_REQUEST['id'],"name",$name)){	
			$_SESSION['msg']="Sorry, your specified breeding status is already taken!";					
		}else{
			$data['name']=$name;	
			$db->query_update("breeding_status",$data,"id='".$_REQUEST['id'] ."'");
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Breeding status successfully updated!";
			
			$general_func->header_redirect($_SESSION['return_url']);
		}
		
	}						
	
}	


$url=$_SERVER['PHP_SELF']."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
$recperpage=$general_func->admin_recoed_per_page;


$order_by="name ASC";
$query="where 1";
				
$sql="select * from breeding_status $query order by $order_by";
				
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
	td:nth-of-type(1):before { content: "Name"; }	
	td:nth-of-type(2):before { content: "Action"; }
}

</style>

<script language="JavaScript">
function del(id,url,name){
	var a=confirm("Are you sure, you want to delete breeding status: '" + name +"'?")
    if (a){
    	location.href="<?=$_SERVER['PHP_SELF']?>?id="+id+"&action=delete&url="+url;
    }  
}

function validate(){			
	if(!validate_text(document.ff.name,1,"Please enter breeding status"))
		return false;
		
}		 
</script>
 <div class="breadcrumb">
      	<p><a href="customers/pets.php">Pets</a> &raquo; Breeding Status List</p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?> 
        <ul class="tabBtn">
            	<li class="activeTab"><a style="cursor: pointer;">Pets Breeding Status</a></li>              
 		</ul>
        <div class="tableBgStyle">
        <div class="row">
       	  <div class="proAttbInst">
       	<form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="breeding_status" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
        <input name="submit" type="hidden" value="<?=$button?>" />
          	<ul>            	
                <li><span>Name</span><input name="name" type="text" value="<?=$name?>" /></li>
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
        </div>
        <table>
      <thead>
            <tr>
                <th width="70%">Name</th>                          
                <th width="30%" style="text-align:center">Action</th>
            </tr>
            </thead>
            <tbody>
             <?php for($j=0; $j<$total_customers; $j++){?>
             	<tr>
                <td><?=$result[$j]['name']?></td>                
                <td style="text-align:center">
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>customers/breeding-status.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />&nbsp;&nbsp;&nbsp;
                    <img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>','<?=$result[$j]['name']?>')" style="cursor:pointer;" />
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
        </div>
<?php  }?>
   <script>
	document.ff.name.focus();
	
</script>         
<?php
include_once("../foot.htm");
?>