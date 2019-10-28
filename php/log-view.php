<?php
/*
php/log-view.php
By Matthew DiMatteo, Children's Technology Review

This file creates a new record in the 'views' table in the 'CSR.fmp12' database file to track pageview data
It is included in the file 'php/autoload.php'
*/

//$debugViews = true; // boolean to log views in test folder

// only log pageviews in the live folder or debugging
if($directory == 'ctr' or $debugViews == true)
{
	// set guest username to 'Guest' in the log ($username defined in 'php/session.php')
	$logUsername 	= $username; if ($logUsername == NULL) { $logUsername = 'Guest'; }

	// create new record in 'views' table
	$log = $fmviews->createRecord($fmviewsLayout);

	// set fields
	$log->setField('IP', $ip); 						// defined in 'php/autoload.php' (tracked for spam fighting purposes)
	$log->setField('userID', $userID); 				// defined in 'php/session.php'
	$log->setField('ctrexUsername', $logUsername); 	// defined above based on $username ($username defined in 'php/session.php')
	$log->setField('page', $thisURL); 				// defined in 'php/autoload.php'
	$log->setField('viewdate' , $dateConv); 		// defined in 'php/autoload.php'
	$log->setField('viewtime' , $time); 			// defined in 'php/autoload.php'

	// mark field for site license patron views via portal url (records marked in this way are excluded from deletion on archival to be included in usage reports)
	if(substr_count($thisPage, 'site') > 0)
	{ 
		$log->setField('sitesession', 'sitesession');
		$log->setField('siteName', $siteName);
	}

	// mark field for site license patron or admin views (records marked in this way are excluded from deletion on archival to be included in usage reports)
	if($license == true or $siteAdmin == true) 	
	{ 
		$log->setField('sitelicense', 'sitelicense');
		$log->setField('siteName', $siteName);
	}

	$commit = $log->commit();
	if ( FileMaker::isError ($commit) ) { echo $commit->getMessage(); exit(); }
} // end if directory == ctr (live folder)
?>