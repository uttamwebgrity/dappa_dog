<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

if($_SESSION['admin_access_level'] != 1 && ! in_array(23,$_SESSION['access_permission'])){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


if(isset($_POST['enter']) && $_POST['enter']=="yes"){		
	$data['template_subject']=$_REQUEST['template_subject'];
	$data['template_content']=$_REQUEST['template_content'];	
	$db->query_update("email_template",$data,"id=".$_REQUEST['template_id']);	
	$_SESSION['msg']="Template successfully updated.";	
	$general_func->header_redirect($_SERVER['PHP_SELF']."?template_id=" . $_REQUEST['template_id']);	
}	

if(isset($_GET['template_id']) && intval($_GET['template_id']) > 0){
	$sql="select *  from email_template where id='" .$_REQUEST['template_id']."'";
	$result=$db->fetch_all_array($sql);	
	$template_name=$result[0]['template_name'];
	$template_subject=$result[0]['template_subject'];
	$template_content=$result[0]['template_content'];	
}	



?>
<script language="JavaScript">
function validate(){	
	if(document.ff.template_id.selectedIndex == 0){
		alert("Please choose a Template");
		document.ff.template_id.focus();
		return false;
	}			
	if(!validate_text(document.ff.template_subject,1,"Please enter template subject"))
		return false;
			
	if(document.ff.template_content.value == ""){
		alert("Please enater template content");		
		return false;		
	}
	
}
</script>
 <div class="breadcrumb">
      	<p><a>Settings</a> &raquo; Email Templates </p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
            	
            	<li class="activeTab"><a style="cursor: pointer;">Template CONTENT</a></li>             
                
            </ul>
        <form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="ff" onsubmit="return validate()" >
        <input type="hidden" name="enter" value="yes" />        
              <div class="tabPnlCont">
<div class="tabPnlContInr">
              <div class="tabcontArea" style="background:none">
          	 <h3>Template Information:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">                   
                   <li>Choose a Template <span class="star">*</span><br>                   
                   	
                   	<select name="template_id" style="width: 320px;" onchange="location.href='<?=$_SERVER['PHP_SELF']?>?template_id='+this.value">
                    	<option value=""> Select One</option>
                    	<?php                     	
                    	$sql_template="select id,template_name from email_template order by template_order + 0 ASC";
						$result_template=$db->fetch_all_array($sql_template);
						$total_template=count($result_template);
                    	
						for($template=0; $template < $total_template; $template++ ){?>
							<option value="<?=$result_template[$template]['id']?>" <?=$result_template[$template]['id']==$_REQUEST['template_id']?'selected="selected"':'';?>><?=$result_template[$template]['template_name']?></option>
						<?php } ?>
                  </select></li>
                   <li style="width: 100%;">Subject <span class="star">*</span> <br>
                   	<input name="template_subject" value="<?=$template_subject?>" type="text" style="width: 320px;" /></li>
                   	
                   	 <li style="width: 100%;">Template <span class="star">*</span> <br>
                   	 <?php 
                   	 
					include("../fckeditor/fckeditor.php") ;
					$sBasePath ="fckeditor/";
					$oFCKeditor = new FCKeditor('template_content') ;
					$oFCKeditor->BasePath	= $sBasePath ;
					$oFCKeditor->Height = '400' ;
					$oFCKeditor->width = '400' ;
					$oFCKeditor->Value		= $template_content;
					$oFCKeditor->Create();
					?></li>
					<li style="width: 100%;"><?php if($_GET['template_id'] == 6){
                   	 	echo "<strong>Keywords are:</strong> #dog_owner_name#, #email_address#, #password#";
						echo "<br>
						
						<strong>Note:</strong> Do not remove or modify keywords!";
                   	 }?>
                   </li>
					
                   
                 </ul>
               </div>
             </div>            
           
            <div class="submitSection">
                <input name="update" type="submit" value="" class="updateBtn" />         	
            	<input name="back" type="button" value="Back" onclick="location.href='home.php'" class="backBtn" />
              
            </div>
          </div>
          
          <br class="clear" />
</div>
</div>
          </form>          
            
<?php
include("../foot.htm");
?>