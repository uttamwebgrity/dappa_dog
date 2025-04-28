<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";


/*if((int)$_SESSION['admin_access_level'] == 2){		
    $_SESSION['message']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}*/

if(isset($_GET['action']) && $_GET['action']=='delete'){	
	$db->query_delete("products","id='".$_REQUEST['id'] ."'");	
	$_SESSION['msg']="Your selected product deleted!";
	$general_func->header_redirect($_REQUEST['url']);
} 

$keyword="Search by name, barcode, etc";





$url=$_SERVER['PHP_SELF']."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
$recperpage=$general_func->admin_recoed_per_page;


$order_by="product_name ASC";
$query="where 1";
				
	
	
if(isset($_REQUEST['keyword']) && trim($_REQUEST['keyword']) != NULL){
	$keyword=trim($_REQUEST['keyword']);
	
	$query .=" and (product_name LIKE '%" .$_REQUEST['keyword']. "%' ";
	
	$query .=" OR barcode_code LIKE '%" .$_REQUEST['keyword']. "%' ";
	$query .=" OR wholesale_price LIKE '%" .$_REQUEST['keyword']. "%' ";
	$query .=" OR retail_price LIKE '%" .$_REQUEST['keyword']. "%' ";
	$query .=" OR reorder_qty LIKE '%" .$_REQUEST['keyword']. "%' ";
	$query .=" OR product_qty LIKE '%" .$_REQUEST['keyword']. "%' ";
	$query .=" OR reorder_point LIKE '%" .$_REQUEST['keyword']. "%' ";	
	$query .=")";
}				
		
				
$sql="select id,product_name,barcode_code,wholesale_price,retail_price,product_qty from products $query order by $order_by";
				
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
<!--<style type="text/css">
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
	td:nth-of-type(2):before { content: "Email Address"; }
	td:nth-of-type(3):before { content: "Password"; }
	td:nth-of-type(4):before { content: "Address line 1"; }
	td:nth-of-type(5):before { content: "Phone No."; }
	td:nth-of-type(6):before { content: "Action"; }
}
</style>-->

<script language="JavaScript">
function validate_search(){
	if(!validate_text(document.frmsearch.cd,1,"Enter name, barcode, etc")){
		return false;
	}
}

function clear_me(){
	if(document.frmsearch.keyword.value =="Search by name, barcode, etc"){
		document.frmsearch.keyword.value="";
		document.frmsearch.keyword.focus();
		return false;
	}
}

function del(id,url,name){
	var a=confirm("Are you sure, you want to delete product: '" + name +"'?")
    if (a){
    	location.href="<?=$_SERVER['PHP_SELF']?>?id="+id+"&action=delete&url="+url;
    }  
} 
</script>
<div class="breadcrumb">
      	<p>Roster</p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
		<div class="row">
	<div class="errorMsg">We are working on this page!</div>	
	</div>
        
        <ul class="tabBtn">
            	<li class="activeTab"><a style="cursor: pointer;">Roster</a></li>              
</ul>
        <div class="tableBgStyle">
          <div class="rosterHdr">
          	<ul>
                <li><span>Staff : </span> <select class="staff"><option>All Staff</option></select></li>
                <li><span>Month : </span> <select class="month"><option>Mar 2013</option></select></li>
                <li><input name="" type="sumbit" /></li>
            </ul>
          </div>
          
          <div class="tableStyle">
          	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="roster">
              <tr>
                <th align="center" valign="middle"><h4>March 2013</h4></th>
                <th align="center" valign="middle">1<br />Fri</th>
                <th align="center" valign="middle">2<br />Sat</th>
                <th align="center" valign="middle">3<br />Sun</th>
                <th align="center" valign="middle">4<br />Mon</th>
                <th align="center" valign="middle">5<br />Tue</th>
                <th align="center" valign="middle">6<br />Wed</th>
                <th align="center" valign="middle">8<br />Fri</th>
                <th align="center" valign="middle">2<br />Sat</th>
                <th align="center" valign="middle">3<br />Sun</th>
                <th align="center" valign="middle">4<br />Mon</th>
                <th align="center" valign="middle">5<br />Tue</th>
              </tr>
              <tr>
                <td align="center" valign="middle" class="name">Tom Reed</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle" class="crossBtn">&nbsp;</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle" class="crossBtn">&nbsp;</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle">9am<br />7pm</td>
              </tr>
              <tr>
                <td align="center" valign="middle" class="name">Harry Potter</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle" class="crossBtn">&nbsp;</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle" class="crossBtn">&nbsp;</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle">9am<br />7pm</td>
                <td align="center" valign="middle" class="crossBtn">&nbsp;</td>
                <td align="center" valign="middle" class="crossBtn">&nbsp;</td>
                <td align="center" valign="middle">9am<br />7pm</td>
              </tr>
            </table>

          </div>
        </div>

            
<?php
include_once("../foot.htm");
?>