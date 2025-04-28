<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

$return_url=$_REQUEST['return_url'];


$result=mysql_fetch_object(mysql_query("select subject,message,(CASE send_to WHEN 0 THEN 'All' WHEN 1 THEN 'Customers'WHEN 2 THEN 'Subscribers' ELSE 'Donars' END) as send_to,subject,DATE_FORMAT(send_date,'%a %b, %Y') as send_date,send_to_emails,email_address from newsletters where id=" . (int)$_REQUEST['id']. " limit 1"));

?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          
          <td align="left" valign="middle" class="body_tab-middilebg2">NEWSLETTER EMAIL on <?=$result->send_date?></td>
          
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg">
        <table width="883" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
          	<td colspan="4" height="30"></td>
          </tr>
          
          
          <tr>
            <td width="73" align="left" valign="top"></td>
            <td width="700" align="left" valign="top"><table width="94%" border="0" cellspacing="0" cellpadding="8">
                
                <tr>
                  <td width="21%" class="body_content-form"  valign="top">Subject:</td>
                  <td width="79%"  valign="top"><?php echo $result->subject; ?></td>
                </tr>
                <tr>
                  <td width="21%" class="body_content-form"  valign="top">Message:</td>
                  <td width="79%"  valign="top">
				  <table width="620" border="0" cellspacing="0" cellpadding="0" style="padding:0;margin:0">
		<tr>
		<td style="padding:0 0 10px 0;margin:0;height:120px;background:#dcdcdc"><div style="float:left;width:110px;height:103px;margin:8px 20px 0 20px;padding:0;background:#2c2c2d"><img src="http://sandisfieldartscenter.org/cms_images/logo.jpg" width="72" height="84" alt="" style="margin-left:auto;margin-right:auto;display:block;margin-top:10px" /></div>
		<h1 style="font:italic 25px/30px Georgia,\'Times New Roman\',Times,serif;color:#736f6f;text-shadow:#fff 2px 2px 2px;padding:0;margin:22px 0">To succeed in life, you need two things:<br />
		ignorance and confidence.</h1></td>
		</tr>
		<tr>
		<td style="padding:20px;margin:0;background:#fff;font:normal 13px/18px Arial,Helvetica,sans-serif;color:#736f6f">
				  					<?php echo $result->message; ?>
				  					
								</td>
								</tr>
								<tr>
								<td style="padding:25px 25px 15px;margin:0;background:#dcdcdc;height:180px"><div style="float:left;width:280px;padding:5px 0 0 0">
								<h3 style="font:bold 20px/26px Arial,Helvetica,sans-serif;color:#6d6b6b;padding:0 0 0 0px;margin:0;"><img src="http://sandisfieldartscenter.org/cms_images/footerIcon.jpg" /> Sandisfield Arts Center</h3>
								<ul style="padding:0;margin:0">
								<li style="list-style:none;color:#6d6b6b;font:normal 13px/18px Arial,Helvetica,sans-serif"><strong style="float:left;width:70px;padding-bottom:10px">Address:</strong> <span style="float:left;width:190px;padding-bottom:10px">5 Hammertown Road,<br>
								P.O. Box 31<br>
								Sandisfield, MA 01255</span></li>
								<li style="list-style:none;color:#6d6b6b;font:normal 13px/18px Arial,Helvetica,sans-serif"><strong style="float:left;width:70px;padding-bottom:10px">Phone #:</strong> <span style="float:left;width:190px;padding-bottom:10px">413-258-4100</span></li>
								<li style="list-style:none;color:#6d6b6b;font:normal 13px/18px Arial,Helvetica,sans-serif"><strong style="float:left;width:70px;padding-bottom:10px">Email Us:</strong> <span style="float:left;width:190px;padding-bottom:10px">info@Sandisfieldartscenter.org</span></li>
								</ul>
								</div>
								<div style="float:right;width:275px;padding:0;margin:0"> <img src="http://sandisfieldartscenter.org/cms_images/footerPic.jpg" alt="" style="padding:36px 0 0 0;margin:0;float:right" />
								<p style="color:#6d6b6b;text-align:right;font:normal 12px/20px Arial,Helvetica,sans-serif;clear:both;padding:10px 0 0 0;margin:0">© 2013 Sandisfield Arts Center. All rights reserved. </p>
								</div></td>
								</tr>
								</table>
				  					
				  			
						
                  </td>
                </tr>
                <tr>
                  <td width="21%" class="body_content-form"  valign="top">Sent To:</td>
                  <td width="79%"  valign="top"><?php 
				  if(strlen($result->send_to_emails) < 6 )
				   echo $result->email_address;
				  
				  echo str_replace("_~_","<br/>",$result->send_to_emails); ?></td>
                </tr>
                
               
            </table></td>
           
           
          </tr>
           <tr>
          	<td colspan="4" height="20"></td>
          </tr>
           <tr>
          	<td colspan="4" height="30" align="center"><table width="879" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
                  <td width="24%"></td>
                  <td width="23%">&nbsp;</td>
      <td width="7%"><table border="0" align="left" cellpadding="0" cellspacing="0">
                            <tr>
                              
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="back" onClick="location.href='<?=$general_func->admin_url?>newsletter/<?=$_REQUEST['return_url']?>'"  type="button" class="submit1" value="Back" /></td>
                              
                            </tr>
                          </table></td>
                  <td width="46%">                  </td>
                </tr>
                    </table></td>
          </tr>
           <tr>
          	<td colspan="4" height="30"></td>
          </tr>
        </table>
     </td>
  </tr>
</table>
<?php
include("../foot.htm");
?>
