<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";


if($_SESSION['admin_access_level'] != 1){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}

if(isset($_GET['action']) && $_GET['action']=='delete'){	
	$db->query_delete("service_time","service_type=2 and service_id='".$_REQUEST['id'] ."'");	
	$db->query_delete("salon_services","service_type=2 and  service_id='".$_REQUEST['id'] ."'");
	$db->query_delete("staff_salon_services","service_type=2 and  service_id='".$_REQUEST['id'] ."'");	
	$db->query_delete("service_spa_service","spa_service_id='".$_REQUEST['id'] ."'");
		
	$db->query_delete("spa_service","id='".$_REQUEST['id'] ."'");	
	$_SESSION['msg']="Your selected spa treatment deleted!";
	$general_func->header_redirect($_REQUEST['url']);
} 

$keyword="Search by spa treatment";


$url=$_SERVER['PHP_SELF']."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
$recperpage=$general_func->admin_recoed_per_page;


$order_by="spa_service_name";
$query="where 1";
				
	
	
if(isset($_REQUEST['keyword']) && trim($_REQUEST['keyword']) != NULL){
	$keyword=trim($_REQUEST['keyword']);	
	$query .=" and (spa_service_name LIKE '%" .$_REQUEST['keyword']. "%' ";			
	$query .=")";
}				
		
				
$sql="select id,spa_service_name from spa_service  $query order by $order_by";
				
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
	
	td:nth-of-type(1):before { content: "Spa Treatment"; }	
	td:nth-of-type(2):before { content: "Action"; }
	
	
	
}

</style>

<script language="JavaScript">
function show_spa_services(value){
	document.body.style.cursor='wait';
	
	
	if(value.length > 0)
		document.getElementById("submit").style.display="block"; 
	else
		document.getElementById("submit").style.display="none"; 
	
	
	
	var ajaxURL="search.php?keywords=" + document.frmsearch.keyword.value +"&type=spaservicessearch&t=" + Math.random();
	
		
	loadXMLDoc(ajaxURL,function(){		
  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
  			document.getElementById("search_result").innerHTML=xmlhttp.responseText; 
    	}
  	}); 	
  	document.body.style.cursor='auto';
}


function del(id,url,name){
	var a=confirm("Are you sure, you want to delete spa service: '" + name +"'? and all its related record")
    if (a){
    	location.href="<?=$_SERVER['PHP_SELF']?>?id="+id+"&action=delete&url="+url;
    }  
} 
</script>
 <div class="breadcrumb">
      	<p><a href="settings/spa-treatments.php">Spa Treatments</a> &raquo; Spa Treatments List</p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
 <div class="pageTopPnl">
        	<div class="searchPnl">
        		  <form name="frmsearch"  method="post">
        		 <input type="hidden" name="enter" value="search"/>
        		  <?php if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0") || strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 8.0")){?>
				<img src="images/search_ie.png" style="float: left; padding-right: 3px; " />		
				<?php }	?>
        		<input name="keyword"  value="" type="text"  onkeyup="show_spa_services(this.value)" placeholder="Search by spa treatment" />
        		<input name="submit" id="submit"  style="display: none;" type="button" value="Clear Search" onclick="location.href='<?=$_SERVER['PHP_SELF']?>'" />
        		 </form>
        		</div>
            <div class="buttonPnl"><input name="add_services" type="button" value="Add Spa Treatments" onclick="location.href='<?=$general_func->admin_url?>settings/spa-treatment-new.php?return_url=<?=urlencode($url)?>'" /> 
       </div>
        </div>
        <div class="tableBgStyle" id="search_result">
		<table>
		<thead>
            <tr>
                <th width="70%">Spa Treatment </th>                           
                <th width="30%" style="text-align:center">Action</th>
            </tr> 
            </thead>
            <tbody>
           <?php for($j=0; $j<$total_customers; $j++){?>
                <td><?=$result[$j]['spa_service_name']?></td> 
                <td style="text-align:center">                	 
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>settings/spa-treatment-new.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />&nbsp;&nbsp;&nbsp;
                    <img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>settings/spa-treatment-view.php?id=<?=$result[$j]['id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;
          			<img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>','<?=$result[$j]['spa_service_name']?>')" style="cursor:pointer;" />
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
            
<?php
include_once("../foot.htm");
?>