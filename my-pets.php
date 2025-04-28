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
  background: none; 
}
tr:nth-of-type(even) { 
  background: none; 
}
th { 
  background:none; 
  color:#0595b5 !important; 
  font:normal 15px/20px 'proxima_nova_rgregular', Arial, Helvetica, sans-serif !important;
  font-weight: bold; 
}
td, th { 
  padding: 6px; 
  /*border: 1px solid #ccc; */
  text-align: left; 
  color:#4d5759; 
  font:normal 13px/18px 'proxima_nova_rgregular', Arial, Helvetica, sans-serif;
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
	td:nth-of-type(1):before { content: "Name of your Pet"; }
	td:nth-of-type(2):before { content: "Breed"; }
	td:nth-of-type(3):before { content: "No of Appointment(s)"; }
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
      	<h2>Your Pets</h2>
        <div class="row">
          <div class="filterBy">Filter by : <select><option>Received SMS / Email</option></select></div>
        </div>
        <div class="row">
       	  <table>
                <thead>
                <tr>
                    <th valign="middle">Name of your Pet</th>
                    <th valign="middle">Breed</th>
                    <th valign="middle">No of Appointment(s)</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td valign="middle">Shadow</td>
                    <td valign="middle">Alaskan Malamute</td>
                    <td valign="middle">#5</td>
                </tr>
                </tbody>
            </table>
          <div class="reBookAppBtn"><a href="#url">Rebook appointment</a></div>
        </div>
      </div>
  </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>