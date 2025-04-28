<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";


if($_SESSION['admin_access_level'] != 1 && ! in_array(7,$_SESSION['access_permission'])){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}



//*********************  order delete *************************************//
if(isset($_GET['action']) && $_GET['action']=="delete"){
	@mysql_query("delete from newsletters where id=" . (int) $_GET['id']." limit 1");
	
	$_SESSION['msg']="The selected newsletter has been deleted!";
	$general_func->header_redirect($_SERVER['PHP_SELF']);
}
//*************************************************************************//

//*********************  resend *************************************//
if(isset($_GET['action']) && $_GET['action']=="edit"){
	$rs_nl=mysql_fetch_object(mysql_query("select * from newsletters where id=" . (int) $_GET['id']." limit 1"));
	
	$send_to=$rs_nl->send_to;
	$subject=$rs_nl->subject;
	$email_address=$rs_nl->email_address;
	$message=$rs_nl->message;
	
	$button="Resend";
}else{
	$subject="";
	$message='';
	$email_address="";
	$button="Send";
}

//*************************************************************************//



		
//**************************************************************************************//
		$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
		$recperpage=30;
		
		
		$sql="select id,(CASE send_to WHEN 0 THEN 'All' WHEN 1 THEN 'Customers'WHEN 2 THEN 'Staff' ELSE 'Salon Admin' END) as send_to,subject,DATE_FORMAT(send_date,'%a %b, %Y') as send_date from newsletters  order by send_date DESC";
		//-----------------------------------/Pagination------------------------------
		
		//print $sql;
		if(isset($_GET['in_page'])&& $_GET['in_page']!="")
			$page=$_GET['in_page'];
		else
			$page=1;
		
		$total_count=$db->num_rows($sql);
		$sql=$sql." limit ".(($page-1)*$recperpage).", $recperpage";
		
			if($page>1)
			{
				$url_prev=stristr($url,"&in_page=".$page)==FALSE?$url."&page=".($page-1):str_replace("&in_page=".$page,"&in_page=".($page-1),$url);
				$prev="<a href='$url_prev' class='nav'>Prev</a>";
			}
			else
				$prev="Prev";
				
			if((($page)*$recperpage)<$total_count)
			{
				$url_next=stristr($url,"&in_page=".$page)==FALSE?$url."&in_page=".($page+1):str_replace("&in_page=".$page,"&in_page=".($page+1),$url);
				$next="<a href='$url_next' class='nav'>Next</a>";
			}
			else
				$next="Next";
				
			$page_temp=(($page)*$recperpage);
			$page_temp=$page_temp<$total_count?$page_temp:$total_count;
			$showing=" Showing ".(($page-1)*$recperpage+1)." - ".$page_temp." of ".$total_count." | ";
		 
		//-----------------------------------/Pagination------------------------------
		//*************************************************************************************************//
		$result=$db->fetch_all_array($sql);
		$total_customers=count($result);
		//*******************************************************************************************************************//
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
	td:nth-of-type(1):before { content: "Sent To"; }
	td:nth-of-type(2):before { content: "Subject"; }
	td:nth-of-type(3):before { content: "Date"; }
	td:nth-of-type(4):before { content: "Action"; }
	
	
	
}
</style>
 
 
 
 
<script language="JavaScript">

function delete_confirmed(id){
	var decide=confirm("Are you sure you want to delete this newsletter?")
    if (decide)   {
    	location.href="<?=$_SERVER['PHP_SELF']?>?id="+id+"&action=delete"
    }  
}
function validate(){
	if(!validate_text(document.ff.subject,1,"Please enter subject")){
		document.ff.subject.value="";
		document.ff.subject.focus();
		return false;
	}
}	
	
//**********************************************************************//
</script>
 <div class="breadcrumb">
      	<p><a>Messages</a> &raquo; Newsletter Email</p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
            	
            	<li class="activeTab"><a style="cursor: pointer;">NEWSLETTER EMAIL</a></li>             
                
            </ul>
        <form method="post" action="<?=$general_func->admin_url?>messages/send-newsletter.php" name="ff" onsubmit="return validate()">
				<input type="hidden" name="enter" value="2" /> 
                
                <div class="tabPnlCont">
<div class="tabPnlContInr">
<div class="tabcontArea" style="background:none;">
          	 <h3>Newsletter Information:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">                   
                   <li>Send To<br>                   
                   	<select name="send_to" class="cont-select" style="width: 200px;">
                   		<option value="0">All</option>
                     	<option value="1" <?=$send_to=="1"?'selected="selected"':'';?> >Customers/Dog Owner</option>        
                      	<option value="2" <?=$send_to=="2"?'selected="selected"':'';?> >Staff</option>  
                      	<option value="3" <?=$send_to=="3"?'selected="selected"':'';?> >Salon Admin</option>       
                     </select>                   	
                   </li>
                   <li style="width: 100%;">Subject <span class="star">*</span> <br>
                   	<input name="subject" value="<?=$subject?>" type="text" style="width: 320px;" /></li>
                   	
                   	 <li style="width: 100%;">Template <span class="star">*</span> <br>
                   	<?php
					include("../fckeditor/fckeditor.php") ;
					$sBasePath ="fckeditor/";
					$oFCKeditor = new FCKeditor('message') ;
					$oFCKeditor->BasePath	= $sBasePath ;
					$oFCKeditor->Height = '400' ;
					$oFCKeditor->width = '400' ;
					$oFCKeditor->Value		= $message;
					$oFCKeditor->Create();
					?></li>
                   
                 </ul>
               </div>
             </div>            
           
            <div class="submitSection">            	
            	<?php if($button =="Send"){?>
            		 <input name="submit" type="submit" value="" class="sentBtn" />					
            	<?php }else{?>            		
					 <input name="submit" type="submit" value="" class="resentBtn" />
            	<?php }?>            	
                <?php if($_GET['action']=="edit"){?>
                	<input name="back" type="button" value="Back" onclick="location.href='<?=$general_func->admin_url?>messages/newsletter.php'" class="backBtn" />
       			<?php  } ?> 
            </div>
          </div>
          
          <br class="clear" />
</div>
</div>
          
          
          </form> 
          
            <div class="tableBgStyle" style="margin-top:20px;">
		<table>
<thead>
            <tr>
                <th width="23%">Sent To</th>
                <th width="22%">Subject</th>              
                <th width="14%">Date</th>                               
                <th width="9%" style="text-align:center">Action</th>
            </tr>
            </thead>
            <tbody>
           <?php for($j=0; $j<$total_customers; $j++){?>
          	<tr>
                <td><?=$result[$j]['send_to']?></td>
                <td><?=$result[$j]['subject']?></td>
                <td><?=$result[$j]['send_date']?></td>                
                <td>
                	<img src="images/copy.png" onclick="location.href='<?=$general_func->admin_url?>messages/newsletter.php?id=<?php echo $result[$j]['id']?>&action=edit'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;	
               		<img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>messages/view_newsletter.php?id=<?php echo $result[$j]['id']?>&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;
                   <img src="images/delete.png" title="DELETE" alt="DELETE" onclick="javascript:delete_confirmed('<?php echo $result[$j]['id']?>')" style="cursor:pointer;" />
                            	
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
include("../foot.htm");
?>