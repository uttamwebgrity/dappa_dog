<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";


if((int)$_SESSION['admin_access_level'] == 3){		
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


if(isset($_GET['action']) && $_GET['action']=='delete'){	
	$db->query_delete("staff_salon","staff_id='".$_REQUEST['id'] ."'");	
	$db->query_delete("staff_salon_services","staff_id='".$_REQUEST['id'] ."'");
	$db->query_delete("staff_salon_availability","staff_id='".$_REQUEST['id'] ."'");	
	$db->query_delete("admin","user_id='".$_REQUEST['id'] ."' and access_level=3");
	$db->query_delete("staffs","id='".$_REQUEST['id'] ."'");	
	$_SESSION['msg']="Your selected staff deleted!";
	$general_func->header_redirect($_REQUEST['url']);
} 

$keyword="Search by name, email, etc";





$url=$_SERVER['PHP_SELF']."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
$recperpage=$general_func->admin_recoed_per_page;


$order_by="staff_name ASC";
$query="where 1";
	
if((int)$_SESSION['admin_access_level'] == 2){
	$query .=" and id IN(select DISTINCT(staff_id) from staff_salon where salon_id='" . $_SESSION['admin_user_id'] . "')";
}		
		
	
				
	
	
if(isset($_REQUEST['keyword']) && trim($_REQUEST['keyword']) != NULL){
	$keyword=trim($_REQUEST['keyword']);
	
	$query .=" and (staff_name LIKE '%" .$_REQUEST['keyword']. "%' ";
	
	$query .=" OR email_address LIKE '%" .$_REQUEST['keyword']. "%' ";
	$query .=" OR landline_no LIKE '%" .$_REQUEST['keyword']. "%' ";
	$query .=" OR mobile_no LIKE '%" .$_REQUEST['keyword']. "%' ";
	$query .=" OR address1 LIKE '%" .$_REQUEST['keyword']. "%' ";
	$query .=" OR address2 LIKE '%" .$_REQUEST['keyword']. "%' ";
	$query .=" OR city LIKE '%" .$_REQUEST['keyword']. "%' ";	
	$query .=" OR state LIKE '%" .$_REQUEST['keyword']. "%' ";	
	$query .=" OR zip LIKE '%" .$_REQUEST['keyword']. "%' ";	
	$query .=")";
}				
		
				
$sql="select id,staff_name,email_address,mobile_no,address1,state from staffs $query order by $order_by";
				
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

table td a{ font-weight:bold; text-decoration:none; color:#3f96b7; }
table td a:hover{ font-weight:bold; text-decoration:none; color:#f5653f; }
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
	td:nth-of-type(1):before { content: "Date"; }
	td:nth-of-type(2):before { content: "Day"; }
	td:nth-of-type(3):before { content: "Shift Worked"; }
}

</style>

<script language="JavaScript">
function validate_search(){
	if(!validate_text(document.frmsearch.cd,1,"Enter name, email, etc")){
		return false;
	}
}

function clear_me(){
	if(document.frmsearch.keyword.value =="Search by name, email, etc"){
		document.frmsearch.keyword.value="";
		document.frmsearch.keyword.focus();
		return false;
	}
}

function del(id,url,name){
	var a=confirm("Are you sure, you want to delete staff: '" + name +"'? and all its related record")
    if (a){
    	location.href="<?=$_SERVER['PHP_SELF']?>?id="+id+"&action=delete&url="+url;
    }  
} 
</script>
<p style="color:#F00; font-size:14px; font-weight:bold; text-align:center;">No Programing (coding) has been made yet.<br>We are working on it.</p>
 <div class="breadcrumb">
      	<p><a href="settings/staff.php">Reports</a> &raquo; Staff Hours</p>
</div>



<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
 	   <div class="pageTopPnl">
        	<ul class="stfRept">
            	<li><select><option>Select Staff</option></select></li>
                <li><select><option>All Salons</option></select></li>
                <li><span>Start Date:</span> <input name="" type="text" /></li>
                <li><span>End Date:</span> <input name="" type="text" /></li>
                <li><input name="" type="submit" /></li>
            </ul>
       </div>
        </div>
        <ul class="tabBtn">
            	<li class="activeTab"><a style="cursor: pointer;"><?=$button?> Staff Report</a></li>              
            </ul>
        <div class="tableBgStyle">
		<table>
		<thead>
            <tr>
                <th width="34%">Date</th>
                <th width="54%">Day</th>              
                <th width="12%">Shift Worked</th>
            </tr>
                       
            </thead>
            <tbody>
          	<tr>
                <td>28/03/2013</td>
                <td><a href="#url" data-reveal-id="popup1">Monday</a></td>
                <td>7:30 (Hours)</td>
             </tr>
             <tr>
                <td>28/03/2013</td>
                <td><a href="#url" data-reveal-id="popup2">Monday</a></td>
                <td>6:15 (Hours)</td>
             </tr>
             <tr>
                <td>28/03/2013</td>
                <td><a href="#url">Monday</a></td>
                <td>7:00 (Hours)</td>
             </tr>
             <tr>
                <td>28/03/2013</td>
                <td><a href="#url">Monday</a></td>
                <td>7:10 (Hours)</td>
             </tr>
           
           
            </tbody>
        </table>
        
        
        <div class="popBox reveal-modal" style="top: 100px; opacity: 1; visibility: hidden;" id="popup1">
        <a class="close-reveal-modal" style="margin:-4px -8px 0 0"><img src="../responsive_lightbox/close.png" alt="" /></a>
       	  <h5>Tom Reed</h5>
          <h6>Hamilton - Bridge Street</h6>
          <div class="popBoxCont">
          	<ul>
            	<li><strong>Date</strong><br />28/03/2013</li>
                <li><strong>Day</strong><br /><span>Monday</span></li>
            </ul>
          </div>
          <div class="popBoxCont">
          	<ul>
            	<li style="background:#edffeb"><strong>Log In (Time)</strong><br />10.00 a.m<br />12.30 p.m</li>
                <li style="background:#fff9eb"><strong>Log Out (Time)</strong><br />10.00 a.m<br />12.30 p.m</li>
            </ul>
          </div>
          <br class="clear" />
          <h6>Hamilton - Bridge Street</h6>
          <div class="popBoxCont">
          	<ul>
            	<li><strong>Date</strong><br />28/03/2013</li>
                <li><strong>Day</strong><br /><span>Monday</span></li>
            </ul>
          </div>
          <div class="popBoxCont">
          	<ul>
            	<li style="background:#edffeb"><strong>Log In (Time)</strong><br />10.00 a.m<br />12.30 p.m</li>
                <li style="background:#fff9eb"><strong>Log Out (Time)</strong><br />10.00 a.m<br />12.30 p.m</li>
            </ul>
          </div>
          <br class="clear" />
          <div class="popBoxTot">Total Worked:<br /><span>7.30 Hours</span></div>
        </div>
        <div class="popBox reveal-modal" style="top: 100px; opacity: 1; visibility: hidden;" id="popup2">
        <a class="close-reveal-modal" style="margin:-4px -8px 0 0"><img src="../responsive_lightbox/close.png" alt="" /></a>
       	  <h5>Tom Reed</h5>
          <h6>Hamilton - Bridge Street</h6>
          <div class="popBoxCont">
          	<ul>
            	<li><strong>Date</strong><br />28/03/2013</li>
                <li><strong>Day</strong><br /><span>Monday</span></li>
            </ul>
          </div>
          <div class="popBoxCont">
          	<ul>
            	<li style="background:#edffeb"><strong>Log In (Time)</strong><br />10.00 a.m<br />12.30 p.m<br />10.00 a.m<br />12.30 p.m</li>
                <li style="background:#fff9eb"><strong>Log Out (Time)</strong><br />10.00 a.m<br />12.30 p.m<br />10.00 a.m<br />12.30 p.m</li>
            </ul>
          </div>
          <br class="clear" />
          <div class="popBoxTot">Total Worked:<br /><span>7.30 Hours</span></div>
        </div>
        
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


<link rel="stylesheet" href="../responsive_lightbox/page.css" type="text/css">
<link rel="stylesheet" href="../responsive_lightbox/stylesheet.css" type="text/css" charset="utf-8">
<link rel="stylesheet" href="../responsive_lightbox/reveal.css" type="text/css">
<script type="text/javascript" src="../responsive_lightbox/jquery-1.js"></script>
<script type="text/javascript" src="../responsive_lightbox/jquery.js"></script>


         
<?php
include_once("../foot.htm");
?>