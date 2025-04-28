<?php include_once("includes/header.php"); ?>
<style type="text/css">
/* 
Generic Styling, for Desktops/Laptops 
*/
table { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #eaf9fc; 
}
tr:nth-of-type(even) { 
  background: #fff; 
}
th { 
  background: #86cee0; 
  color:#4d5759; 
  font-weight: bold; 
}
td, th { 
  padding: 6px; 
  /*border: 1px solid #ccc; */
  text-align: left; 
  color:#4d5759; 
}
td img{ margin:0 5px; }

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
	
	tr { border: 1px solid #86cee0; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		/*border-bottom: 1px solid #eee; */
		position: relative;
		padding-left: 50%; 
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
	td:nth-of-type(1):before { content: "Type"; }
	td:nth-of-type(2):before { content: "Date"; }
	td:nth-of-type(3):before { content: "Salon"; }
	td:nth-of-type(4):before { content: "Subject"; }
	td:nth-of-type(5):before { content: "View"; }
	td:nth-of-type(6):before { content: "Reply"; }
}
</style>





<div class="middilePnl">
<div class="bodyContentInr">
  <div class="mainDiv">
    	<?php /*?><h1><?=$dynamic_content['page_heading']?></h1>
        <?=$dynamic_content['file_data']?><?php */?>
      <div class="myAccLft">
      	<h2>My Account</h2>
        <ul>
            <li><img src="images/myAcIco1.png" alt="" /><a href="#url">Your Pets</a></li>
            <li><img src="images/myAcIco2.png" alt="" /><a href="#url">Change / Update Profile</a></li>
            <li><img src="images/myAcIco3.png" alt="" /><a href="#url">My Appointment(s)</a></li>
            <li><img src="images/myAcIco4.png" alt="" /><a href="#url">Change Password</a></li>
            <li><img src="images/myAcIco5.png" alt="" /><a href="#url">Reminders</a></li>
        </ul>
      </div>
      <div class="myAccRht">
      	<h2>Reminders</h2>
        <div class="row">
          <div class="filterBy">Filter by : <select><option>Received SMS / Email</option></select></div>
          <div class="smsMailBtn"><a href="#URL">SMS / Email</a></div>
        </div>
        <div class="row">
        	<table>
                <thead>
                <tr>
                    <th valign="middle">Type</th>
                    <th valign="middle">Date</th>
                    <th valign="middle">Salon</th>
                    <th valign="middle">Subject</th>
                  <th valign="middle">View</th>
                    <th valign="middle">Reply</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td valign="middle"><img src="images/acTypeIco.png" alt="" /> <img src="images/acTypeIco1.png" alt="" /></td>
                    <td valign="middle">20 April 2013</td>
                  <td valign="middle">Animel Planet</td>
                    <td valign="middle">This is a test Subjecis a test Subject........</td>
                  <td valign="middle"><img src="images/acViewIco.png" alt="" /></td>
                  <td valign="middle"><img src="images/acReplyIco.png" alt="" /></td>
                </tr>
                <tr>
                    <td valign="middle"><img src="images/acTypeIco.png" alt="" /> <img src="images/acTypeIco1.png" alt="" /></td>
                    <td valign="middle">20 April 2013</td>
                    <td valign="middle">Animel Planet</td>
                    <td valign="middle">This is a test Subjecis a test Subject........</td>
                    <td valign="middle"><img src="images/acViewIco.png" alt="" /></td>
                    <td valign="middle"><img src="images/acReplyIco.png" alt="" /></td>
                </tr>
                <tr>
                    <td valign="middle"><img src="images/acTypeIco.png" alt="" /> <img src="images/acTypeIco1.png" alt="" /></td>
                    <td valign="middle">20 April 2013</td>
                    <td valign="middle">Animel Planet</td>
                    <td valign="middle">This is a test Subjecis a test Subject........</td>
                    <td valign="middle"><img src="images/acViewIco.png" alt="" /></td>
                    <td valign="middle"><img src="images/acReplyIco.png" alt="" /></td>
                </tr>
                </tbody>
            </table>
        </div>
      </div>
  </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>