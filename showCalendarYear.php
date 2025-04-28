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

if($source == "pretty")
{
	show_source($SCRIPT_FILENAME);
	exit();
}
elseif($source == "plain")
{
	header("Content-type: text/plain");
	readfile($SCRIPT_FILENAME);
	exit();
}

require("Calc.php");

if(empty($year))
	$year = Date_Calc::dateNow("%Y");

// get year structure for generating calendar
$year_cal = Date_Calc::getCalendarYear($year,"%E");
$view = "year";

?>

<CENTER>


<TABLE border=0 cellspacing=0 width=60%>

<TR>
<TD colspan=3 align=center bgcolor=#d0d0d0>
	<?php include("./showNavBar.php"); ?>
</TD>
</TR>

<TR>
<TD colspan=3 align=center bgcolor=#e0e0e0>
<A href="<?php echo $PHP_SELF."?year=".($year-1)."&month=".$month."&day=01"; ?>">&lt;&lt;</A>
&nbsp;
	<?php echo "<b>".$year."</b>"; ?>
&nbsp;
<A href="<?php echo $PHP_SELF."?year=".($year+1)."&month=".$month."&day=01"; ?>">&gt;&gt;</A>
</TD>
</TR>

<TR align=center valign=top>
<TD>

<?php
	// loop through each month
	for($curr_month=0; $curr_month <=11; $curr_month++)
	{
	
	
		?>
		<TABLE cellspacing=0 bgcolor=#d3d3d3>
		<TR bgcolor=#e0e0e0>
		<TD align=center>
		<A HREF="showCalendarMonth.php?<?php echo Date_Calc::daysToDate($year_cal[$curr_month][0][6],"year=%Y&month=%m&day=%d"); ?>">
		<?php
			echo "<b>".Date_Calc::getMonthFullname($curr_month + 1)."</b>";
		?></A>
		</TD>
		</TR>
		<TR bgcolor=#d3d3d3>
		<TD nowrap>
		<?php
			// print the weekday header for the current month
			if(DATE_CALC_BEGIN_WEEKDAY == 0)
				echo "<TT>Su Mo Tu We Th Fr Sa</TT>\n";
			else
				echo "<TT>Mo Tu We Th Fr Sa Su</TT>\n";
		?>
		</TD>
		</TR>
		
		<?php

		// loop through each week of current month
		for($row = 0; $row < count($year_cal[$curr_month]); $row++)
		{
			echo "<TR bgcolor=#e0e0e0><TD valign=top><TT>";
					
			// don't hyperlink blank weeks (not in this month)
			if(Date_Calc::daysToDate($year_cal[$curr_month][$row][0],"%m") != $curr_month + 1 
					&& Date_Calc::daysToDate($year_cal[$curr_month][$row][6],"%m") != $curr_month + 1)
				$link = false;
			else
				$link = true;
			
			if($link)
				echo "<A HREF=\"showCalendarWeek.php?".Date_Calc::daysToDate(($year_cal[$curr_month][$row][0]),"year=%Y&month=%m&day=%d")."\">";

			// loop through each week day of current week
			for($col=0; $col < 7; $col++)
			{
				// print the day with correct spacing
				if(Date_Calc::daysToDate($year_cal[$curr_month][$row][$col],"%m") == $curr_month + 1)
				{
					$day = Date_Calc::daysToDate($year_cal[$curr_month][$row][$col],"%d");
					echo "$day&nbsp;";
				}
				else
					echo "&nbsp;&nbsp;&nbsp;";
		
			}

			if($link)
				echo "</A>";

			echo "</TT></TD></TR>\n";
		}

		?>
		
		</TABLE>

		<?php

		// make a new row every third month.
		// to make the year calendar 4x3, instead of 3x4,
		// change % 3 to % 4 and fix the column span on
		// the calendar headers.
		if($curr_month < 11)
		{
 			if(!(($curr_month + 1) % 3) && $curr_month)
			{
				echo "</TD></TR>\n<TR align=center valign=top><TD>\n";
			}
			else
				echo "</TD>\n<TD>\n";
		}
	
	} // end for loop
	?>
</TD>
</TR>
</TABLE>
<P>
show source
<A href="showCalendarYear.php?source=plain">Plain</A>			
<A href="showCalendarYear.php?source=pretty">Pretty</A>			
</P>
</CENTER>
