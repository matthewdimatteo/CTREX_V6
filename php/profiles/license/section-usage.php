<?php
/*
php/profiles/license/section-usage.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the content of the 'Usage' tab of the Organization Profile page
It is included dynamically in 'php/profiles/profile-sections.php'
Note: This section is only included in the editable profile (for site admins)
*/
$portalURL = 'https://reviews.childrenstech.com/ctr/site'.$siteName.'.php';

// GET STORED $_SESSION VALUES FOR USAGE REPORT
$usageReportRequest = $_SESSION['usageReportRequest'];
if($usageReportRequest == true)
{
	echo '<script>showProfileSection(2, 3);</script>'; // automatically toggle the usage tab
	
	$usageReportHeading = 'CTREX Site Usage by '.$siteOrg;
	
	// input values
	$usageSort 			= $_SESSION['siteUsageSort'];
	$usageScope 		= $_SESSION['siteUsageScope'];

	// timeframe values
	$lastWeek			= $_SESSION['lastWeek'];
	$lastMonth			= $_SESSION['lastMonth'];
	$lastYear			= $_SESSION['lastYear'];
	$thisCalendarYear 	= $_SESSION['calendarYear'];

	// site view data
	$siteViewsNull		= $_SESSION['siteViewsNull'];
	$siteViewsArray 	= $_SESSION['siteViewsArray'];
	$siteViewsCount		= $_SESSION['siteViewsCount'];
	$siteViewsStart		= $_SESSION['siteViewsStart'];

	// site session data
	$siteSessionsNull 	= $_SESSION['siteSessionsNull'];
	$siteSessionsArray	= $_SESSION['siteSessionsArray'];
	$siteSessionsCount	= $_SESSION['siteSessionsCount'];
	$siteSessionsStart	= $_SESSION['siteSessionsStart'];
	
	// determine oldest overall view (regular pageview or session start)
	if($siteViewsStart < $siteSessionsStart) { $oldestOverall = $siteViewsStart; } else { $oldestOverall = $siteSessionsStart ; }
	
	// construct an array of views and sessions combined
	if($siteViewsArray != NULL)
	{
		$totalViewsArray = array();
		foreach($siteViewsArray as $thisSiteView) { array_push($totalViewsArray, $thisSiteView); }
		if($siteSessionsArray != NULL) { foreach($siteSessionsArray as $thisSiteSession) { array_push($totalViewsArray, $thisSiteSession); } }
		$_SESSION['totalViewsArray'] = $totalViewsArray;
	} // end if $siteViewsArray
	
	
	// DETERMINE TIMEFRAME LABEL BASED ON SELECTED SCOPE VALUE
	switch($usageScope)
	{
		case 'pastweek' 	: $timeframe = $lastWeek; 			break;
		case 'pastmonth' 	: $timeframe = $lastMonth; 			break;
		case 'pastyear' 	: $timeframe = $lastYear; 			break;
		case 'calendaryear' : $timeframe = $thisCalendarYear; 	break;
		case 'alltime' 		: $timeframe = $oldestOverall;		break;
		default				: $timeframe = $oldestOverall;		break;
	} // end switch($usageScope)
	
	// DETERMINE SUMMARY STRING (# OF VIEWS IN TIMEFRAME)
	if($siteViewsNull == true)
	{
		$usageSummary = 'No pageviews for the selected timeframe';
	} // end if $siteViewsNull
	else
	{
		// VIEWS + SESSIONS SEPARATE
		/*
		$usageSummary = $siteViewsCount.' pageview';
		if ($siteViewsCount != 1) { $usageSummary .= 's'; }
		if($siteSessionsNull != true)
		{ 
			$usageSummary .= ' and '.$siteSessionsCount.' session';
			if($siteSessionsCount != 1) { $usageSummary .= 's'; } 
		} // end if !$siteSessionsNull
		*/
		
		// VIEWS + SESSIONS COMBINED
		$siteTotalUsage = $siteViewsCount + $siteSessionsCount; // total usage = views + sessions
		$usageSummary = $siteTotalUsage.' total view';
		if($siteTotalUsage != 1) { $usageSummary .= 's'; }
		$usageSummary .= ' since '.$timeframe; 
	} // end else !$siteViewsNull

} // end if $usageReportRequest
else { $usageReportHeading = 'Generate a Usage Report'; }

// HIDDEN FORM
require_once 'php/usage-report-form.php'; // hidden form for generating usage report

// SECTION CONTAINER
echo '<div id = "usage-info" class = "profile-section-content">';

	// SECTION HEADER
	echo '<div class = "profile-section-header">'.$usageReportHeading.'</div>';
	
	// IF NO REPORT GENERATED, DISPLAY INSTRUCTIONS + BUTTON
	if($usageReportRequest != true)
	{
		echo '<div class = "profile-section-content">';
	
			// EXPLANATION
			echo '<div id = "usage-report-explanation">';
				echo 'Select the button below to generate a usage report detailing patron activity for your site license.';
			echo '</div>'; // /#usage-report-explanation

			// BUTTON CONTAINER
			echo '<div id = "usage-report-button-container" class = "profile-section-submit-btn">';
				echo '<button type = "button" onclick = "usageReport(\'alltime\')">Generate Usage Report</button>';
			echo '</div>'; // /#usage-report-button-container
	
		echo '</div>'; // .profile-section-content
	} // end if !$usageReportRequest
	
	// IF USAGE REPORT REQUESTED, OUTPUT IT, ALONG WITH SORT/SCOPE/REFRESH/EXPORT OPTIONS
	if($usageReportRequest == true)
	{
		// CONTENT CONTAINER
		echo '<div class = "profile-section-content" id = "usage-report-results">';
		
			// SUMMARY STRING
			echo '<div class = "subheader">'.$usageSummary.'</div>';
			
			// CONTROLS
			echo '<div id = "usage-report-controls">';
				
				// RESET
				echo '<div class = "inline right-20">';
					echo '<button type = "button" onclick = "document.getElementById(\'usage-report-reset-form\').submit();">Reset</button>';
			 	echo '</div>'; // /.inline right-10
				
				// PAST WEEK
				echo '<div class = "inline right-20">';
					echo '<div '; if($usageScope == 'pastweek') { echo 'class = "bold"'; } echo '>';
						echo '<button type = "button" onclick = "usageReport(\'pastweek\')">Past Week</button>';
					echo '</div>'; // /#past-week-label .$pastWeekLabelClass
			 	echo '</div>'; // /.inline right-10
				
				// PAST MONTH
				echo '<div class = "inline right-20">';
					echo '<div '; if($usageScope == 'pastmonth') { echo 'class = "bold"'; } echo '>';
						echo '<button type = "button" onclick = "usageReport(\'pastmonth\')">Past Month</button>';
					echo '</div>'; // /#past-month-label .$pastMonthLabelClass
			 	echo '</div>'; // /.inline right-10
				
				// PAST YEAR
				echo '<div class = "inline right-20">';
					echo '<div '; if($usageScope == 'pastyear') { echo 'class = "bold"'; } echo '>';
						echo '<button type = "button" onclick = "usageReport(\'pastyear\')">Past Year</button>';
					echo '</div>'; // /#past-year-label .$pastYearLabelClass
			 	echo '</div>'; // /.inline right-10
				
				// CALENDAR YEAR
				echo '<div class = "inline right-20">';
					echo '<div '; if($usageScope == 'calendaryear') { echo 'class = "bold"'; } echo '>';
						echo '<button type = "button" onclick = "usageReport(\'calendaryear\')">Calendar Year</button>';
					echo '</div>'; // /#calendar-year-label .$calendarYearLabelClass
			 	echo '</div>'; // /.inline right-10
				
				// ALL TIME
				echo '<div class = "inline right-20">';
					echo '<div '; if($usageScope == 'alltime') { echo 'class = "bold"'; } echo '>';
						echo '<button type = "button" onclick = "usageReport(\'alltime\')">All Time*</button>';
					echo '</div>'; // /#all-time-label .$allTimeLabelClass
			 	echo '</div>'; // /.inline right-10
				
			echo '</div>'; // /#usage-report-controls
			echo '<div class = "text-12">*Since usage data began being kept in 2015</div>';
			//echo '<br/>';
			
			// OUTPUT TABULAR DATA IF !NULL
			if($siteViewsNull != true)
			{
				// EXPORT BTNS
				echo '<div class = "top-10 text-14 paragraph bottom-10 center">';
					
					echo '<div class = "inline right-10">';
						echo 'Export: ';
					echo '</div>'; // /.inline right-10
					
					echo '<div class = "inline right-10">';
						echo '<button type = "button" onclick = "window.location.href = \'export.php?type=usage&format=tab\';">.tab</button>';
					echo '</div>'; // /.inline right-10
					
					echo '<div class = "inline right-10">';
						echo '<button type = "button" onclick = "window.location.href = \'export.php?type=usage&format=csv\';">.csv</button>';
					echo '</div>'; // /.inline right-10
					
				echo '</div>'; // /.text-14 paragraph bottom-10 center
				
				// VIEWS LABEL
				echo '<div class = "text-14 paragraph bottom-10 center">';
					echo $siteViewsCount.' view'; if($siteViewsCount != 1) { echo 's'; } echo ' by logged in patrons since '.$timeframe;
				echo '</div>'; // /.text-14 paragraph bottom-10 center

				// TABLE OF VIEWS
				echo '<div class = "usage-report-table">';
					echo '<table>';
					
						// SORTING CONTROLS (DATE, TIME, IP, URL)
						echo '<tr class = "tr-heading">';
							echo '<td '; if($usageSort == 'date' or $usageSort == NULL) { echo 'class = "bold"'; } echo '>';
								echo '<button type = "button" onclick = "usageSort(\'date\')">Date</button>';
							echo '</td>';
							echo '<td>';
								echo '<button type = "button" onclick = "usageSort(\'date\')">Time</button>';
							echo '</td>';
							echo '<td '; if($usageSort == 'ip') { echo 'class = "bold"'; } echo '>';
								echo '<button type = "button" onclick = "usageSort(\'ip\')">IP</button>';
							echo '</td>';
							echo '<td '; if($usageSort == 'url') { echo 'class = "bold"'; } echo '>';
								echo '<button type = "button" onclick = "usageSort(\'url\')">URL</button>';
							echo '</td>';
						echo '</tr>'; // /.tr-heading
						
						// VIEWS DATA
						foreach($siteViewsArray as $thisSiteView)
						{
							$thisViewTime		= $thisSiteView[0];
							$thisViewDate		= $thisSiteView[1];
							$thisViewIP			= $thisSiteView[2];
							$thisViewURL		= $thisSiteView[3];
							$thisViewLabel		= trimText($thisViewURL, 30);
							$thisViewLabel1025 	= trimText($thisViewURL, 20);
							$thisViewLabel769 	= trimText($thisViewURL, 15);
							$thisViewLabel480 	= trimText($thisViewURL, 10);
							echo '<tr>';
								echo '<td>'.$thisViewDate.'</td>';
								echo '<td>'.$thisViewTime.'</td>';
								echo '<td>'.$thisViewIP.'</td>';
								echo '<td>';
									echo '<div class = "show-only-desktop">';
										echo '<a href = "'.$thisViewURL.'">'.$thisViewLabel.'</a>';
									echo '</div>';
									echo '<div class = "show-only-1025">';
										echo '<a href = "'.$thisViewURL.'">'.$thisViewLabel1025.'</a>';
									echo '</div>';
									echo '<div class = "show-only-769">';
										echo '<a href = "'.$thisViewURL.'">'.$thisViewLabel769.'</a>';
									echo '</div>';
									echo '<div class = "show-only-480">';
										echo '<a href = "'.$thisViewURL.'">'.$thisViewLabel480.'</a>';
									echo '</div>';
								'</td>';
							echo '</tr>';
						} // end foreach $siteViewsArray
						
					echo '</table>'; // end views table
					echo '<br/>';
				echo '</div>'; // /.usage-report-table
				
				// OUTPUT TABLE OF SESSIONS IF !NULL
				if($siteSessionsNull != true)
				{
					// SESSIONS LABEL
					echo '<div class = "text-14 paragraph bottom-10 center">';
						echo $siteSessionsCount.' portal url click-through'; if($siteSessionsCount != 1) { echo 's'; } echo ' since '.$timeframe;
					echo '</div>'; // .text-14 paragraph bottom-10 center

					// TABLE OF SESSIONS
					echo '<div class = "usage-report-table">';
						echo '<table>';
						
							// SORTING CONTROLS (DATE, TIME, IP, URL)
							echo '<tr class = "tr-heading">';
								echo '<td '; if($usageSort == 'date' or $usageSort == NULL) { echo 'class = "bold"'; } echo '>';
									echo '<button type = "button" onclick = "usageSort(\'date\')">Date</button>';
								echo '</td>';
								echo '<td>';
									echo '<button type = "button" onclick = "usageSort(\'date\')">Time</button>';
								echo '</td>';
								echo '<td '; if($usageSort == 'ip') { echo 'class = "bold"'; } echo '>';
									echo '<button type = "button" onclick = "usageSort(\'ip\')">IP</button>';
								echo '</td>';
								echo '<td '; if($usageSort == 'url') { echo 'class = "bold"'; } echo '>';
									echo '<button type = "button" onclick = "usageSort(\'url\')">URL</button>';
								echo '</td>';
							echo '</tr>'; // .tr-heading
							
							// SESSION DATA
							foreach($siteSessionsArray as $thisSiteSession)
							{
								$thisSessionTime		= $thisSiteSession[0];
								$thisSessionDate		= $thisSiteSession[1];
								$thisSessionIP			= $thisSiteSession[2];
								$thisSessionURL			= $thisSiteSession[3];
								$thisSessionLabel		= trimText($thisSessionURL, 30);
								$thisSessionLabel1025	= trimText($thisSessionURL, 20);
								$thisSessionLabel769	= trimText($thisSessionURL, 15);
								$thisSessionLabel480	= trimText($thisSessionURL, 10);
								echo '<tr>';
									echo '<td>'.$thisSessionDate.'</td>';
									echo '<td>'.$thisSessionTime.'</td>';
									echo '<td>'.$thisSessionIP.'</td>';
									echo '<td>';
									echo '<div class = "show-only-desktop">';
										echo '<a href = "'.$thisSessionURL.'">'.$thisSessionLabel.'</a>';
									echo '</div>';
									echo '<div class = "show-only-1025">';
										echo '<a href = "'.$thisSessionURL.'">'.$thisSessionLabel1025.'</a>';
									echo '</div>';
									echo '<div class = "show-only-769">';
										echo '<a href = "'.$thisSessionURL.'">'.$thisSessionLabel769.'</a>';
									echo '</div>';
									echo '<div class = "show-only-480">';
										echo '<a href = "'.$thisSessionURL.'">'.$thisSessionLabel480.'</a>';
									echo '</div>';
								'</td>';
								echo '</tr>';
							} // end foreach $siteSessionsArray
							
						echo '</table>'; // end sessions table
					echo '</div>'; // /.usage-report-table
				} // end if $siteSessionsNull != true
			} // end if $siteViewsNull != true
			
		echo '</div>'; // .profile-section-content #usage-report-results
	} // end if $usageReportRequest
	
	echo '<div class = "text-14 top-20" title = "This is the custom URL that provides access to your organization\'s patrons">';
		echo 'Portal URL: <a href = "'.$portalURL.'">'.$portalURL.'</a>';
	echo '</div>'; // /.text-14 top-20

echo '</div>'; // /#usage-info .profile-section-content
?>