<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";


if($_SESSION['admin_access_level'] != 1 && ! in_array(8,$_SESSION['access_permission'])){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


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
  <p><a>Reports</a> &raquo; Customer Spend</p>
</div>
<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
<div class="row">
  <div class="errorMsg">
    <?=$_SESSION['msg'];$_SESSION['msg']=""; ?>
  </div>
</div>
<?php } ?>


<div class="pageTopPnl">
    <ul class="stfRept">
        <li><span>Start Date:</span> <input type="text" name=""></li>
        <li><span>End Date:</span> <input type="text" name=""></li>
        <li><input type="submit" name=""></li>
    </ul>
</div>

<div class="tabPnlCont">
  <div class="tabPnlContInr">
    <div class="tabcontArea" style="background:none; padding-top:0;">
    <h5>Uttam Majumder</h5>
      <div class="row">
        <div class="formTwoPnl">
          <ul class="formTwoDply">
            <li><span>Total Spend $: </span> $ 112.00</li>
            <li><span>Appointments: </span> 4</li>
            <li><span>Services: </span>4</li>
          </ul>
        </div>
        <div class="formTwoPnl">
          <ul class="formTwoDply">
            <li><span>Email: </span>test@test.com</li>
            <li><span>Telephone: </span> 987654321</li>
            <li><span>Mobile: </span>64 34324324</li>
          </ul>
        </div>
      </div>
    </div>
    
    <div class="tabcontArea" style="background:none; padding-top:0;">
    <h5>Saikat Das</h5>
      <div class="row">
        <div class="formTwoPnl">
          <ul class="formTwoDply">
            <li><span>Total Spend $: </span> $ 112.00</li>
            <li><span>Appointments: </span> 4</li>
            <li><span>Services: </span>4</li>
          </ul>
        </div>
        <div class="formTwoPnl">
          <ul class="formTwoDply">
            <li><span>Email: </span>test@test.com</li>
            <li><span>Telephone: </span> 987654321</li>
            <li><span>Mobile: </span>64 34324324</li>
          </ul>
        </div>
      </div>
      
    </div>
    <br class="clear" />
  </div>
</div>
<?php
include_once("../foot.htm");
?>