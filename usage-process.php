<?php
/*
usage-process.php
By Matthew DiMatteo

This file performs a database query to fetch a usage report of site license activity

If the form is submitted properly, by a user with the proper credentials:
1. get form input values
2. set timeframe values to be used as find criteria
3. lookup view records
4. look up session records
5. store data in $_SESSION
6. redirect back to organization profile page

Otherwise, redirect to the site licenses page 'licenses.php'
*/

$pageTitle 	= 'Generating usage report...';
$pageType 	= 'redirect';
$searchType	= 'reviews';
require_once 'php/autoload.php';

// process the form only if submitted properly and user has site admin credentials
if(isset($_POST['site-name']) and $siteAdmin == true)
{
	// only generate report if the input site name matches the user's site name (prevent site admin from looking up a report for another site license)
	$inputSiteName = test_input($_POST['site-name']);
	if($inputSiteName == $siteName)
	{
		// 1. GET FORM INPUTS VALUES ----------------------------------------------------------------------------------------------------------
		$usageSort 		= test_input($_POST['sort']);
		$usageScope 	= test_input($_POST['scope']);
		$usageRedirect 	= test_input($_POST['redirect']);
		
		// null handlers - set default values if not specified by form
		if($usageSort == NULL) 		{ $usageSort = 'date'; }
		if($usageScope == NULL)		{ $usageScope = 'alltime'; }
		if($usageRedirect == NULL) 	{ $usageRedirect = 'profile.php?id='.$siteName.'&type=license&mode=private'; }
		
		// 2. SET TIMEFRAME VALUES ------------------------------------------------------------------------------------------------------------
		$pastWeek = new DateTime($today, new DateTimeZone('America/New_York'));
		$pastWeek->setDate(date('Y'), date('n'), date('j') - 7);
		$lastWeek = $pastWeek->format('m/d/Y');

		$pastMonth = new DateTime($today, new DateTimeZone('America/New_York'));
		$pastMonth->setDate(date('Y'), date('n') - 1, date('j'));
		$lastMonth = $pastMonth->format('m/d/Y');

		$pastYear = new DateTime($today, new DateTimeZone('America/New_York'));
		$pastYear->setDate(date('Y') - 1, date('n'), date('j'));
		$lastYear = $pastYear->format('m/d/Y');

		$calendarYear = new DateTime($today, new DateTimeZone('America/New_York'));
		$calendarYear->setDate(date('Y'), 1, 1);
		$thisCalendarYear = $calendarYear->format('m/d/Y');

		// 3. LOOK UP PATRON VIEWS ------------------------------------------------------------------------------------------------------------
		$findViews = $fmviews->newFindCommand($fmviewsLayout); // declare a find request
		$findViews->addFindCriterion('ctrexUsername', '=='.$siteName); // records must match the $siteName
		
		// constrain results to the specified timeframe
		if($usageScope == 'pastweek') 	{ $findViews->addFindCriterion('viewdate', '>='.$lastWeek); }
		if($usageScope == 'pastmonth') 	{ $findViews->addFindCriterion('viewdate', '>='.$lastMonth); }
		if($usageScope == 'pastyear') 	{ $findViews->addFindCriterion('viewdate', '>='.$lastYear); }
		if($usageScope == 'calendaryear'){ $findViews->addFindCriterion('viewdate', '>='.$thisCalendarYear); }
		
		// apply sort rules
		if($usageSort == 'date')
		{
			$findViews->addSortRule('viewdate', 1, FILEMAKER_SORT_DESCEND);
			$findViews->addSortRule('viewtime', 2, FILEMAKER_SORT_DESCEND);
			$findViews->addSortRule('IP', 3, FILEMAKER_SORT_ASCEND);
		}
		else if($usageSort == 'ip')
		{
			$findViews->addSortRule('IP', 1, FILEMAKER_SORT_ASCEND);
			$findViews->addSortRule('viewdate', 2, FILEMAKER_SORT_DESCEND);
			$findViews->addSortRule('viewtime', 3, FILEMAKER_SORT_DESCEND);
		}
		else if($usageSort == 'url')
		{
			$findViews->addSortRule('page', 1, FILEMAKER_SORT_ASCEND);
			$findViews->addSortRule('viewdate', 2, FILEMAKER_SORT_DESCEND);
			$findViews->addSortRule('viewtime', 3, FILEMAKER_SORT_DESCEND);
		}
		else
		{
			$findViews->addSortRule('viewdate', 1, FILEMAKER_SORT_DESCEND);
			$findViews->addSortRule('viewtime', 2, FILEMAKER_SORT_DESCEND);
			$findViews->addSortRule('IP', 3, FILEMAKER_SORT_ASCEND);
		}
		$viewResults = $findViews->execute(); // execute the find request
		
		// IF NO VIEWS FOR GIVEN TIMEFRAME
		if (FileMaker::isError ($viewResults) ) 
		{ 
			//echo 'error fetching site view data:<br>'; echo $viewResults->getMessage(); exit(); // debug line
			$siteViewsCount = 0;
			
			// set flags in $_SESSION storage
			$_SESSION['usageReportRequest'] = true; // that the report was requested
			$_SESSION['siteViewsNull'] = true; 		// that the report returned no results for the timeframe
			
			// save input values
			$_SESSION['siteUsageSort']	= $usageSort;
			$_SESSION['siteUsageScope']	= $usageScope;

			// save timeframe values
			$_SESSION['lastWeek']		= $lastWeek;
			$_SESSION['lastMonth']		= $lastMonth;
			$_SESSION['lastYear']		= $lastYear;
			$_SESSION['calendarYear']	= $thisCalendarYear;
			
			// site view data
			$_SESSION['siteViewsArray']	= '';
			$_SESSION['siteViewsCount']	= '';
			$_SESSION['siteViewsStart']	= '';

			// site session data
			$_SESSION['siteSessionsArray']	= '';
			$_SESSION['siteSessionsCount']	= '';
			$_SESSION['siteSessionsStart']	= '';
			
			// return to the organization profile page
			$redirect = $usageRedirect;
			require 'php/redirect.php';
			exit();
		} // end if error ($viewResults)
		$viewRecords 	= $viewResults->getRecords(); // get the array of view records
		$siteViewsCount = $viewResults->getFoundSetCount(); // determine the number of records found
		
		// CONSTRUCT ARRAY CONTAINING SITE VIEW DATA
		$n = 0; // counter for the loop
		$siteViewsArray = array(); // declare array to contain the data
		
		// loop through array of records and get field data, storing it in new array
		foreach($viewRecords as $siteView)
		{
			$n += 1; // increment the counter
			
			// format the time
			$viewTime 	= $siteView->getField('viewtime');
			$viewTime 	= date_create($viewTime);
			$viewTime 	= date_format($viewTime, 'g:i A');
			
			// get the date, IP address, and page url field values
			$viewDate 	= $siteView->getField('viewdate');
			$viewIP 	= $siteView->getField('IP');
			$viewURL 	= $siteView->getField('page');	
			
			if($n == $siteViewsCount) { $siteViewsStart = $viewDate; } // set the date of the last record to the $siteViewsStart
			array_push($siteViewsArray, array($viewTime, $viewDate, $viewIP, $viewURL)); // append the data to the array of views
		} // end foreach
		// END VIEWS LOOKUP -----------------------------------------------------------------------------------------------------------------------
		
		// 4. LOOK UP NUMBER OF SESSIONS STARTED (initial load of 'sitename.php' page) ------------------------------------------------------------
		$portalPage = 'site'.$siteName.'.php'; // determine the url of the portal page (session initializer)
		$findSessions = $fmviews->newFindCommand($fmviewsLayout); // declare find request
		$findSessions->addFindCriterion('page', '=='.$portalPage); // the page url must match the portal url
		
		// constrain results to the specified timeframe
		if($usageScope == 'pastweek') 	{ $findSessions->addFindCriterion('viewdate', '>='.$lastWeek); }
		if($usageScope == 'pastmonth') 	{ $findSessions->addFindCriterion('viewdate', '>='.$lastMonth); }
		if($usageScope == 'pastyear') 	{ $findSessions->addFindCriterion('viewdate', '>='.$lastYear); }
		if($usageScope == 'calendaryear'){ $findSessions->addFindCriterion('viewdate', '>='.$thisCalendarYear); }
		
		// apply sort rules
		if($usageSort == 'date')
		{
			$findSessions->addSortRule('viewdate', 1, FILEMAKER_SORT_DESCEND);
			$findSessions->addSortRule('viewtime', 2, FILEMAKER_SORT_DESCEND);
			$findSessions->addSortRule('IP', 3, FILEMAKER_SORT_ASCEND);
		}
		else if($usageSort == 'ip')
		{
			$findSessions->addSortRule('IP', 1, FILEMAKER_SORT_ASCEND);
			$findSessions->addSortRule('viewdate', 2, FILEMAKER_SORT_DESCEND);
			$findSessions->addSortRule('viewtime', 3, FILEMAKER_SORT_DESCEND);
		}
		else if($usageSort == 'url')
		{
			$findSessions->addSortRule('page', 1, FILEMAKER_SORT_ASCEND);
			$findSessions->addSortRule('viewdate', 2, FILEMAKER_SORT_DESCEND);
			$findSessions->addSortRule('viewtime', 3, FILEMAKER_SORT_DESCEND);
		}
		else
		{
			$findSessions->addSortRule('viewdate', 1, FILEMAKER_SORT_DESCEND);
			$findSessions->addSortRule('viewtime', 2, FILEMAKER_SORT_DESCEND);
			$findSessions->addSortRule('IP', 3, FILEMAKER_SORT_ASCEND);
		}
		$sessionResults = $findSessions->execute(); // execute the find request
		
		// IF NO SESSIONS FOR GIVEN TIMEFRAME
		if (FileMaker::isError ($sessionResults) )
		{
			//echo 'error fetching site session data:<br>'; echo $viewResults->getMessage(); exit(); // debug line
			$siteSessionsCount = 0;
			
			// set flags in $_SESSION storage
			$_SESSION['usageReportRequest'] = true; // that the report was requested
			$_SESSION['siteSessionsNull'] = true; 	// that the report returned no results for the timeframe
			
			// save input values
			$_SESSION['siteUsageSort']	= $usageSort;
			$_SESSION['siteUsageScope']	= $usageScope;

			// save timeframe values
			$_SESSION['lastWeek']		= $lastWeek;
			$_SESSION['lastMonth']		= $lastMonth;
			$_SESSION['lastYear']		= $lastYear;
			$_SESSION['calendarYear']	= $thisCalendarYear;
			
			// save site view data
			$_SESSION['siteViewsNull'] 	= false;
			$_SESSION['siteViewsArray']	= $siteViewsArray;
			$_SESSION['siteViewsCount']	= $siteViewsCount;
			$_SESSION['siteViewsStart']	= $siteViewsStart;
			
			// save site session data
			$_SESSION['siteSessionsArray']	= '';
			$_SESSION['siteSessionsCount']	= '';
			$_SESSION['siteSessionsStart']	= '';
			
			// return to the organization profile page
			$redirect = $usageRedirect;
			require 'php/redirect.php';
			exit();
		} // end if error ($sessionResults)
		
		$sessionRecords 	= $sessionResults->getRecords(); // get the array of session records
		$siteSessionsCount 	= $sessionResults->getFoundSetCount(); // determine the number of records found
		
		// CONSTRUCT ARRAY CONTAINING SITE SESSION DATA
		$n = 0; // counter for the loop
		$siteSessionsArray = array(); // declare an array to contain the data
		
		// loop through array of records and get field data, storing it in new array
		foreach($sessionRecords as $siteSession)
		{
			$n += 1; // increment the counter
			
			// format the time
			$sessionTime 	= $siteSession->getField('viewtime');
			$sessionTime 	= date_create($sessionTime);
			$sessionTime 	= date_format($sessionTime, 'g:i A');
			
			// get the date, IP address, and page url field values
			$sessionDate 	= $siteSession->getField('viewdate');
			$sessionIP 		= $siteSession->getField('IP');
			$sessionURL 	= $siteSession->getField('page');	

			if($n == $siteSessionsCount) { $siteSessionsStart = $sessionDate; } // set the date of the last record to the $siteSessionsStart
			array_push($siteSessionsArray, array($sessionTime, $sessionDate, $sessionIP, $sessionURL)); // append the data to the array of sessions
		} // end foreach $siteSession
		// END SESSIONS LOOKUP -----------------------------------------------------------------------------------------------------------------
		
		// SAVE DATA IN $_SESSION STORAGE ------------------------------------------------------------------------------------------------------
		
		// input values
		$_SESSION['siteUsageSort']	= $usageSort;
		$_SESSION['siteUsageScope']	= $usageScope;
		$_SESSION['siteUsageFiletype']	= $usageFiletype;
		
		// timeframe values
		$_SESSION['lastWeek']		= $lastWeek;
		$_SESSION['lastMonth']		= $lastMonth;
		$_SESSION['lastYear']		= $lastYear;
		$_SESSION['calendarYear']	= $thisCalendarYear;
		
		// set flags in $_SESSION storage
		$_SESSION['usageReportRequest'] = true; // that the report was requested
		$_SESSION['siteViewsNull'] = ''; 		// clear null views flag
		$_SESSION['siteSessionsNull'] = ''; 	// clear null sessions flag
			
		// site view data
		$_SESSION['siteViewsNull'] 	= false;
		$_SESSION['siteViewsArray']	= $siteViewsArray;
		$_SESSION['siteViewsCount']	= $siteViewsCount;
		$_SESSION['siteViewsStart']	= $siteViewsStart;
		
		// site session data
		$_SESSION['siteSessionsNull'] 	= false;
		$_SESSION['siteSessionsArray']	= $siteSessionsArray;
		$_SESSION['siteSessionsCount']	= $siteSessionsCount;
		$_SESSION['siteSessionsStart']	= $siteSessionsStart;
		
		$redirect = $usageRedirect; // set the redirect value to the organization profile page
		
		// DEBUG OUTPUT
		//$debug = true;
		if($debug == true)
		{
			echo '$siteAdmin: '; if($siteAdmin == true) { echo 'true'; } else { echo 'false'; } echo '<br/>';
			echo '$siteName: '.$siteName.'<br/>';
			echo '$inputSiteName: '.$inputSiteName.'<br/>';

			echo '$usageSort: '.$usageSort.'<br/>';
			echo '$usageScope: '.$usageScope.'<br/>';
			echo '$usageRedirect: '.$usageRedirect.'<br/>';

			echo 'lastWeek: '.$lastWeek.'<br/>';
			echo 'lastMonth: '.$lastMonth.'<br/>';
			echo 'lastYear: '.$lastYear.'<br/>';
			echo 'thisCalendarYear: '.$thisCalendarYear.'<br/>';

			echo '$siteViewsNull: '.$siteViewsNull.'</br>';
			echo '$siteViewsStart: '.$siteViewsStart.'</br>';
			echo '$siteViewsCount: '.$siteViewsCount.'</br>';
			echo '$siteViewsArray: '.$siteViewsArray.'</br>';
			foreach($siteViewsArray as $thisSiteView)
			{
				$thisViewTime	= $thisSiteView[0];
				$thisViewDate	= $thisSiteView[1];
				$thisViewIP		= $thisSiteView[2];
				$thisViewURL	= $thisSiteView[3];
				echo '$thisViewTime: '.$thisViewTime.', $thisViewDate: '.$thisViewDate.', $thisViewIP: '.$thisViewIP.', $thisViewURL: '.$thisViewURL.'<br/>';
			} // end foreach $siteViewsArray
			echo '<br/>';

			echo '$siteSessionsNull: '.$siteSessionsNull.'</br>';
			echo '$siteSessionsStart: '.$siteSessionsStart.'</br>';
			echo '$siteSessionsCount: '.$siteSessionsCount.'</br>';
			echo '$siteSessionsArray: '.$siteSessionsArray.'</br>';

			foreach($siteSessionsArray as $thisSiteSession)
			{
				$thisSessionTime	= $thisSiteSession[0];
				$thisSessionDate	= $thisSiteSession[1];
				$thisSessionIP		= $thisSiteSession[2];
				$thisSessionURL		= $thisSiteSession[3];
				echo '$thisSessionTime: '.$thisSessionTime.', $thisSessionDate: '.$thisSessionDate.', $thisSessionIP: '.$thisSessionIP.', $thisSessionURL: '.$thisSessionURL.'<br/>';
			} // end foreach $siteViewsArray
			exit(); // debug exit
		} // end if $debug
		
	} // end if $inputSiteName == $siteName
	else $redirect = 'licenses.php';
} // end if isset site-name and $siteAdmin

// RESET
else if(isset($_POST['reset']) and $siteAdmin == true)
{
	$_SESSION['usageReportRequest'] = '';
	$redirect = 'profile.php?id='.$siteName.'&type=license&mode=private';
} // end else if isset reset and $siteAdmin

// IF FORM NOT SUBMITTED PROPERLY
else  { $redirect = 'licenses.php'; }

// REDIRECT
require 'php/redirect.php'; // perform the redirection
exit();
?>