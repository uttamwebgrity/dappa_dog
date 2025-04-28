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
  <p>Calendar</p>
</div>
<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
<div class="row">
  <div class="errorMsg">
    <?=$_SESSION['msg'];$_SESSION['msg']=""; ?>
  </div>
</div>
<?php } ?>
<p style="color:#F00; font-size:14px; font-weight:bold; text-align:center;">No Programing (coding) has been made yet.<br />We are working on it.</p>
<div class="tabPnlCont" style="min-height:200px;">
  <div class="tabPnlContInr" style="min-height:200px;">
    <div class="tableBgStyle" style="background:none;">
      <div class="row">
      <div class="formTwoPnl">
      	<ul class="formTwo">
        	<li><span>Choose Salon  :</span><select>
                    <option value=""> Select Salon</option></select></li>
			<!--<li><span>Choose Size  :</span><select>
                    <option value=""> Select Client / Customer</option></select></li>-->
            <li><span>Choose Service  :</span><select>
                    <option value=""> Select Service</option></select></li>
        </ul>
      </div>
      <div class="formTwoPnl">
      	<ul class="formTwo">
			<li><span>Choose Spa  :</span>
			  <div>
			    <select multiple size="2">
			      <option value=""> Select Service</option>
			      <option value=""> Select Service</option>
			      <option value=""> Select Service</option>
			      <option value=""> Select Service</option>
			      </select>
			    <b style="font-size:10px; font-weight:normal; float:right; width:270px; clear:both; padding-top:5px;">Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</b></div>
			</li>
        </ul>
      </div>
      <div class="formTwoPnl">
      	<ul class="formTwo">
        	<li><span>&nbsp;</span><input name="" type="submit" class="searchBtn" value="" /></li>
        </ul>
      </div>
      
      </div>
    </div>
    <br class="clear" />
  </div>
</div>

<!--
<div class="tabPnlCont" style="margin-top:25px;">
            <div class="appsdule">
				<h2>Animal Planet</h2>
              <ul class="serviceList">
                <li><strong>Service type:</strong><br> Wash &amp; Blow Dry</li>
                <li><strong>Spa Treatments:</strong><br> Nail Trim, Fancy Feet, Colour me Pretty </li>				
                <li><strong>Size:</strong><br> Small</li>
              </ul>
              <div class="calenderPnl">
                <div class="row">
               	  <div class="monthHeading">
                  	<a href="#"><img title="Previous" alt="Previous" class="lftArw" src="images/lftArrow.png"></a>
                  	<h3>April, 2013</h3>
                   <a href="#"><img title="Next" alt="Next" class="rhtArw" src="images/rhtArrow.png"></a>
                  </div>
                  <div class="mwdBtn">
                    <ul>
                    	<li><a style=" border-radius:8px 0 0 8px;" href="#">Month</a></li>
                        <li><a href="#">Week</a></li>
                        <li class="noBg mwdCurrent"><a style=" border-radius:0px 8px 8px 0;" href="#">Day</a></li>
                    </ul>
                  </div>
                  <div class="calenderTablePnl">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="calenderTblSty">
                      <tr>
                        <th>&nbsp;</th>
                        <th>Astle</th>
                        <th>Benjamin</th>
                        <th>Lucas</th>
                        <th>Kim</th>
                        <th>Ryder</th>
                      </tr>
                      <tr>
                        <td class="calenTime">9.00 AM</td>
                        <td align="center" valign="middle" class="wash_BlowDry">Wash &amp; Blow Dry</td>
                        <td align="center" valign="middle" class="finish">Mini Groom</td>
                        <td align="center" valign="middle" class="pref">Available App.</td>
                        <td align="center" valign="middle">&nbsp;</td>
                        <td align="center" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="calenTime">9.00 AM</td>
                        <td align="center" valign="middle" class="pref">Mini Groom</td>
                        <td align="center" valign="middle" class="dry">Wash &amp; Blow Dry</td>
                        <td align="center" valign="middle" class="appBooked">Available App.</td>
                        <td align="center" valign="middle" class="warningBox">Wash &amp; Blow Dry</td>
                        <td align="center" valign="middle">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="calenTime">9.00 AM</td>
                        <td align="center" valign="middle" class="clientContacted">Wash &amp; Blow Dry</td>
                        <td align="center" valign="middle" class="aviAppintment">Mini Groom</td>
                        <td align="center" valign="middle" class="checkin">Available App.</td>
                        <td align="center" valign="middle">&nbsp;</td>
                        <td align="center" valign="middle">&nbsp;</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="row">
                	<ul class="colplt">
                        <li><div class="pref">&nbsp;</div>Prep</li>
                        <li><div class="nail">&nbsp;</div>Nail</li>
                        <li><div class="ears">&nbsp;</div>Ears</li>
                        <li><div class="wash_BlowDry">&nbsp;</div>Wash &amp; Blow Dry</li>
                        <li><div class="dry">&nbsp;</div>Dry</li>
                        <li><div class="finish">&nbsp;</div>Finish</li>
                        <li><div class="clientContacted">&nbsp;</div>Client Contacted</li>
                        <li><div class="warningBox">&nbsp;</div>Warning Box</li>
                        <li><div class="aviAppintment">&nbsp;</div>Avi. Appintment</li>
                        <li><div class="kissable">&nbsp;</div>Kissable</li>
                        <li><div class="appBooked">&nbsp;</div>App. Booked</li>
                        <li><div class="checkin">&nbsp;</div>Checked In</li>
                    </ul>
                </div>
              </div>
            </div>
       </div>-->

<?php
include_once("../foot.htm");
?>