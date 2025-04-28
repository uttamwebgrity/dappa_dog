<?php
error_reporting(0);
/**
 * Example use of the Calendar class
 * Copyright (c): 1999-2000 ispi, all rights reserved

 * This source file is subject to version 2.02 of the PHP license,
 * that is bundled with this package in the file LICENSE, and is
 * available at through the world-wide-web at
 * http://www.php.net/license/2_02.txt.
 * If you did not receive a copy of the PHP license and are unable to
 * obtain it through the world-wide-web, please send a note to
 * license@php.net so we can mail you a copy immediately.
 *
 * Copyright (c) 1999, 2000 ispi
 *
 * @access public
 *
 * @version 1.1
 * @author Monte Ohrt <monte@ispi.net>
 */


require("Calc.php");


if(isset($_REQUEST['year']) || isset($_REQUEST['month']) || isset($_REQUEST['day'])){	
	$year = $_REQUEST['year'];
	$month =$_REQUEST['month'];
	$day = $_REQUEST['day'];
}else{		
	$year = Date_Calc::dateNow("%Y");
	$month = Date_Calc::dateNow("%m");
	$day = "01";
}



// get month structure for generating calendar
$month_cal = Date_Calc::getCalendarMonth($month,$year,"%E");
$view = "month";

?>

<TABLE border=0>
<TR>

<TD>
	<TABLE border=0 bgcolor=#1e1e1e cellspacing=1>

	
	<TR bgcolor=#e0e0e0>
	<TD colspan=7 align=center>
	<A href="<?php echo $PHP_SELF."?".Date_Calc::beginOfPrevMonth($day,$month,$year,"year=%Y&month=%m&day=%d"); ?>">&lt;&lt;</A>
	&nbsp;
	<?php echo Date_Calc::dateFormat($day,$month,$year,"<b>%B, %Y</b>%n"); ?>
	&nbsp;
	<A href="<?php echo $PHP_SELF."?".Date_Calc::beginOfNextMonth($day,$month,$year,"year=%Y&month=%m&day=%d"); ?>">&gt;&gt;</A>
	</TD>
	</TR>
	<?php

		if(DATE_CALC_BEGIN_WEEKDAY == 0)
		{
		?>
			<TR bgcolor=#d3d3d3>
				<TH>Sun</TH>
				<TH>Mon</TH>
				<TH>Tue</TH>
				<TH>Wed</TH>
				<TH>Thu</TH>
				<TH>Fri</TH>
				<TH>Sat</TH>
			</TR>
		<?php
		}
		else
		{
		?>
			<TR bgcolor=#d3d3d3>
				<TH>Mon</TH>
				<TH>Tue</TH>
				<TH>Wed</TH>
				<TH>Thu</TH>
				<TH>Fri</TH>
				<TH>Sat</TH>
				<TH>Sun</TH>
			</TR>	
		<?php
		}

	$curr_day = Date_Calc::dateNow("%Y%m%d");

	// loop through each week of the calendar month
	for($row = 0; $row < count($month_cal); $row++)
	{
		echo "<TR>\n";
		/*echo "<TD rowspan=2 align=right valign=top bgcolor=#e0e0e0 width=1>"
				."<A href=\"showCalendarWeek.php?"
				.Date_Calc::daysToDate($month_cal[$row][0],"year=%Y&month=%m&day=%d")
				."\">&nbsp;<font size=-1>week&nbsp;<br>&nbsp;view</font>&nbsp;</A>"
				."</TD>\n";*/
		// loop through each day of the current week
		for($col=0; $col < 7; $col++)
		{
				// set the font color of the day, highlight if it is today
				if(Date_Calc::daysToDate($month_cal[$row][$col],"%Y%m%d") == $curr_day)
					$fontColor="#a00000";			
				elseif(Date_Calc::daysToDate($month_cal[$row][$col],"%m") == $month)
					$fontColor="#0000ff";
				else
					$fontColor="#777777";

				echo "<TD bgcolor=#e0e0e0>"
					."<A href=\"showCalendarDay.php?"
					.Date_Calc::daysToDate($month_cal[$row][$col],"year=%Y&month=%m&day=%d")
					."\">"
					."<FONT color=$fontColor>"
					.Date_Calc::daysToDate($month_cal[$row][$col],"%d")
					."</FONT>"
					."</A>"
					."</TD>\n";
		}
		echo "</TR>\n";
		echo "<TR>\n";
		// output the row for the week. This is where you would print calendar events and such.
	
	}

	?>
	</TABLE>
</TD>
</TR>
</TABLE>
	

