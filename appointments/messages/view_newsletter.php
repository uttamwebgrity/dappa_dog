<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";


if($_SESSION['admin_access_level'] != 1 && ! in_array(7,$_SESSION['access_permission'])){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}

 
$return_url=$_REQUEST['return_url'];


$result=mysql_fetch_object(mysql_query("select subject,message,(CASE send_to WHEN 0 THEN 'All' WHEN 1 THEN 'Customers'WHEN 2 THEN 'Subscribers' ELSE 'Donars' END) as send_to,subject,DATE_FORMAT(send_date,'%a %b, %Y') as send_date,send_to_emails,email_address from newsletters where id=" . (int)$_REQUEST['id']. " limit 1"));

 ?>

 <div class="breadcrumb">
      	<p><a href="messages/newsletter.php">Newsletter</a> &raquo; View</p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
            	
            	<li class="activeTab"><a style="cursor: pointer;">NEWSLETTER EMAIL on <?=$result->send_date?></a></li>             
                
            </ul>
     
<div class="tabPnlCont">
<div class="tabPnlContInr">
<div class="tabcontArea" style="background:none;">
          	 <h3>Newsletter Information:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">                   
                   
                   <li style="width: 100%;">Subject <br> <b><?php echo $result->subject; ?></b>
                   
                   	
                   	 <li style="width: 100%;">Message<br>
                   <table width="620" border="0" cellspacing="0" cellpadding="0" style="padding:0;margin:0; background: #ffffff;">
				<tr>
				<td style="padding:5px;margin:0;height:auto;background:#f58220;"><img src="<?=$general_func->site_url?>newsletterImg/logo.png" alt="" style="float:left; width:130px" />
				</td>
				</tr>
				<tr>
				<td background="<?=$general_func->site_url?>newsletterImg/dogBanner.jpg" style="padding:20px;margin:0;font:normal 13px/18px Arial,Helvetica,sans-serif;color:#000; background-repeat:no-repeat; background-position:bottom;">
				  					<?php echo $result->message; ?>
				  					
								</td>
			</tr>
			<tr>
			<td style="padding:10px;margin:0;height:auto;background:#f58220; ">
			<p style="font:normal 12px/18px Arial, Helvetica, sans-serif; color:#fff;">&copy; Copyright 2013 Dappadogs.co.nz All Rights Reserved</p></td>
			</tr>
			</table>
				  </li>
                    <li style="width: 100%;">Sent To <br> <b><?php 
				  if(strlen($result->send_to_emails) < 6 )
				   echo $result->email_address;
				  
				  echo str_replace("_~_","<br/>",$result->send_to_emails); ?></b>
                 </ul>
               </div>
             </div>            
           
            <div class="submitSection">
                
            	<input name="back" type="button" value="Back" onclick="location.href='<?=$general_func->admin_url?>messages/<?=$_REQUEST['return_url']?>'" class="backBtn" />
              
            </div>
          </div>
<br class="clear" />
</div>
</div>
            
<?php
include("../foot.htm");
?>