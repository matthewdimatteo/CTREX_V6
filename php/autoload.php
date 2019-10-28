<?php
/*
autoload.php
By Matthew DiMatteo, Children's Technology Review

This file is included in every page within the CTREX directory
It establishes the browser session, includes the FileMaker PHP API, and sets many global variables used across various pages
Several other php snippets below handle specialized tasks

Finally, the file 'document.php' is included in every non-redirect page - this contains the html macro structure for each page
*/
session_name("CTR_1297536258621");
session_start();
header('Cache-Control: max-age=28800'); // defines timeout for cache storage
require_once 'FileMaker.php'; 			// FileMaker PHP API
$ip 		= $_SERVER['REMOTE_ADDR'];
$server 	= $_SERVER['PHP_SELF'];
$directory 	= str_replace('/', '', dirname($server));
$thisPage 	= basename($server); 		// this variable is referenced frequently for context-specific conditions
$thisQuery	= $_SERVER['QUERY_STRING'];	// this variable contains the parameters or form input values of the page url
if($thisQuery != NULL) { $thisURL = $thisPage.'?'.$thisQuery; } else { $thisURL = $thisPage; } // concatenation to define the entire url
//$thisPageFull 	= $thisPage.$thisPageParams;
require_once 'php/connect.php'; 	// defines connection parameters for FileMaker databases
require_once 'php/blacklist.php'; 	// block traffic from known spam IPs
require_once 'php/fields.php';		// defines arrays of fields for processing found records
require_once 'php/value-lists.php'; // defines arrays of value list items for checkbox sets
require_once 'php/functions.php'; 	// custom php functions
require_once 'php/settings.php'; 	// get dashboard settings for guest mode, display messages, etc.
require_once 'php/session.php'; 	// set global variables for session
require_once 'php/sidebar-options.php';	// arrays of links and labels for the left sidebar 'quick links', including powersearch categories
require_once 'php/log-view.php';	// create a pageview record in 'views' table in the 'CSR.fmp12' database
if($searchType == NULL) 			{ $searchType = 'reviews'; } 						// defines which search form to load

// ONLOAD SCRIPTS
if($thisPage == 'profile.php')		{ $onload .= 'loadProfileSection(); '; }
if($searchType == 'reviews')		{ $onload .= 'loadPowersearch(); loadAndOr(); '; }	// defines the body onload functions (defined in 'scripts.js')
									  $onload .= 'loadPromocode(); ';
if($thisPage == 'home.php')			{ $onload .= 'loadViewMode(\'reviews\'); '; }
if($containsRubric == true) 		{ $onload .= 'loadRubric(); '; }
if($pageType == 'review')			{ $onload .= 'quickRatingLoad(); '; }

if($thisPage == 'publishers.php')	{ $onload .= 'loadViewMode(\'publishers\'); '; }
if($thisPage == 'archive.php')		{ $onload .= 'loadViewMode(\'archive\'); '; }
if($thisPage == 'experts.php')		{ $onload .= 'loadViewMode(\'experts\'); '; }

if($thisPage == 'editorial.php')	{ $onload .= 'editorialInputsLoad(); '; $beforeUnload .= 'editorialInputsStore(); '; }
if($thisPage != 'editorial.php')	{ $onload .= 'editorialClear(); '; }

if($thisPage == 'juror-panel.php')	{ $onload .= 'jurorPanelLoad(); '; 		$beforeUnload .= 'jurorPanelStore(); '; }
if($thisPage != 'juror-panel.php')	{ $onload .= 'jurorPanelClear(); '; }

if($thisPage == 'savedbookmarks.php') 
{
	// because bookmarks can never just be simple:
	
	$deletedFolder = $_SESSION['deletedFolder']; // flag set by 'savebookmark.php' on folder deletion
	$_SESSION['deletedFolder'] = ''; // reset the flag
	
	/* 
	if a bookmarks folder was just deleted, the stored 'count' value will need to be decremented to prevent js error looking for id that no longer exists
	if the flag was set, call the load folder function with an argument that will tell it to decrement the count
	otherwise, call the function without arguments
	*/
	if($deletedFolder == true) 	{ $onload .= 'loadBookmarksFolder(\'true\'); '; } // tell function to decrement count by 1
	else 						{ $onload .= 'loadBookmarksFolder(); '; }
} // end if $thisPage == 'savedbookmarks.php'

if($pageType != 'redirect' and $thisPage != 'rss.php') 	{ require_once 'php/document.php'; } // contains the html macro structure for each page
?>