<?php
/*
php/usage-report-form.php
By Matthew DiMatteo, Children's Technology Review

This file includes a hidden form for generating a site license usage report
It is included in the files 'php/profiles/subscriber/section-subscription.php' and 'php/profiles/license/section-usage.php'

The "scope" input can be defined as 'pastweek', 'pastmonth', 'pastyear', or 'calendaryear' to return usage statistics for the given timeframe
The function usageReport() found in the file 'js/scripts.js' requires this argument and defaults to 'pastyear' if not specified

The page 'usage-process.php' processes this form to look up usage statistics
*/

// USAGE REPORT FORMS (HIDDEN)
echo '<div id = "usage-report-form-container" class = "hide">';
	
	// GENERATE REPORT
	echo '<form name = "usage-report-form" id = "usage-report-form" method = "POST" action = "usage-process.php">';
		echo '<input type = "hidden" name = "site-name" value = "'.$siteName.'" />';
		echo '<input type = "hidden" name = "sort" 	id = "usage-report-sort" value "'.$usageSort.'>" />';
		echo '<input type = "hidden" name = "scope" id = "usage-report-scope" value = "'.$usageScope.'"/>';
		echo '<input type = "hidden" name = "redirect" value = "profile.php?id='.$siteName.'&type=license&mode=private" />';
	echo '</form>'; // #usage-report-form
	
	// RESET REPORT
	echo '<form name = "usage-report-reset-form" id = "usage-report-reset-form" method = "POST" action = "usage-clear.php">';
		echo '<input type = "hidden" name = "reset" id = "usage-report-reset" value = "reset" />';
	echo '</form>'; // #usage-report-form
	
echo '</div>'; // /#usage-report-form-container .hide
?>