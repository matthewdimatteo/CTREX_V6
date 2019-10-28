<?php
/*
session.php
By Matthew DiMatteo, Children's Technology Review

This file is included within the 'autoload.php' file
It establishes various global variables for use on any page

After defining date and time variables and the guest access mode, this file accesses an array of values saved in $_SESSION storage
These values define the current user's access level, saved subscriber settings, the url of the last search performed, and any error messages accrued
This file also assigns default values to these variables in the case that they are empty
*/

/*
CALCULATE DATE AND TIME ----------------------------------------------------------------------
Used for comment and pageview timestamps
*/
date_default_timezone_set('America/New_York');

$time 	= date('g').":".date('i A');
$hour 	= date('g');
$minute = date('i');
$second = date('s');
$ampm 	= date('A');
$hour24	= date('G');

$date 		= date('F j').', '.date('Y');
$dateConv 	= date('n').'/'.date('j').'/'.date('Y');
$year 		= date('Y'); // used in 'footer.php' to display copyright dynamically
$month		= date('n');
$monthName 	= date('F');
$day		= date('j');

$time = $hour.':'.$minute.':'.$second.' '.$ampm;

$timestamp = $dateConv.' '.$hour.':'.$minute.':'.$second.' '.$ampm;

// defines a date in the recent past to use as a cutoff for filtering review searches by the 'current' parameter
$pastyear 	= $year - 1;
$cutoffYear	= $year - 4;
$oneyearago	= $month.'/'.$day.'/'.$pastyear;
$currentSet	= $month.'/'.$day.'/'.$cutoffYear;

/*
LOGOUT FLAG
On the logout page, set a flag that the user has just logged out
On all other pages, check that flag and then reset it
Do not implement Free Mode if the logout flag is set to true
*/
if($thisPage == 'logout.php' or $thisPage == 'login.php' or $thisPage == 'redirect-login.php') 	
{ 
	session_unset(); // clear the previous session data
	session_start(); // start a new session to store the logout flag
	$logout = true;					
	$_SESSION['logout'] = true; 
	//echo '$freeModeStatus: '.$freeModeStatus.'<br/>$freeMode: '.$freeMode.'<br/>$login: '.$login.'<br/>$username: '.$username;
	//exit();
}
else 							
{ 
	$logout = $_SESSION['logout']; 	
	$_SESSION['logout'] = false; 
}

/*
GET SESSION VALUES ---------------------------------------------------------------------------
Actions on various other pages store values within $_SESSION storage - these values are accessed here and defined as variables for use on any page
*/
// ACCESS LEVEL [BOOLS] 					// these are set in 'login-process.php'
$login 		= $_SESSION['login']; 			// whether the user is logged in
$expired	= $_SESSION['expired'];			// whether the user failed to log in due to an expired subscription - grants access to renewal page
$subscriber	= $_SESSION['subscriber'];		// whether the user has a subscriber account
$publisher	= $_SESSION['publisher'];		// whether the user has a publisher account
$temp		= $_SESSION['temp'];			// whether the user is logged in with a temporary account (no profile)
$freeMode	= $_SESSION['freeMode'];		// whether the user is logged in with the temporary free trial account
$license	= $_SESSION['license'];			// whether the user is logged in as a site license patron (through a portal url or ip filtering)
$mod		= $_SESSION['mod'];				// whether the user has moderator privileges
$expert		= $_SESSION['expert'];			// whether the user has expert privileges
$student	= $_SESSION['student'];			// whether the user has student reviewer privileges
$juror		= $_SESSION['juror'];			// whether the user has juror privileges
$jurorType	= $_SESSION['jurorType'];		// which award the user is juror for (BRDA or KAPI)
$jurorNumber= $_SESSION['jurorNumber'];		// the juror's designated number (for determining which set of fields they edit)
$siteAdmin	= $_SESSION['siteAdmin'];		// whether the user has site admin privileges

// USER ID										// these are set in 'login-process.php'
$subscriberID	= $_SESSION['subscriberID'];	// used to look up subscriber profile
$publisherID	= $_SESSION['publisherID']; 	// used to look up publisher profile
$siteName 		= $_SESSION['siteName'];		// used to look up license profile
$username		= $_SESSION['username']; 		// display for link to profile
$screenName 	= $_SESSION['screenName'];		// display name for subscribers on comments
$publisherName 	= $_SESSION['publisherName'];	// display name for publisher on comments
$fullName 		= $_SESSION['fullName'];		// display name for experts on comments
$siteOrg 		= $_SESSION['siteOrg'];			// display name for site license patrons on comments
$displayName	= $_SESSION['displayName'];		// display name for comments calculated based on access level

// PROFILE URL - determine default profile url based on user type
if($subscriber == true)		{ $userID = $subscriberID; 	$userType = 'subscriber'; 	$profileMode = 'private'; 	}
else if($publisher == true)	{ $userID = $publisherID; 	$userType = 'publisher';	$profileMode = 'private'; 	}
else if($license == true)	{ $userID = $siteName;		$userType = 'license';		$profileMode = 'public';	}
$profileURL 		= 'profile.php?id='.$userID.'&type='.$userType.'&mode='.$profileMode;
$publicProfileURL 	= 'profile.php?id='.$userID.'&type='.$userType.'&mode=public';

// USERNAME LABEL
if($username == NULL) 	{ $usernameLabel = 'Profile'; } else { $usernameLabel = $username; }
if($publisher == true)	{ $usernameLabel = $publisherName; }
if($license == true) 	{ $usernameLabel = $siteOrg; }
//$usernameLabel = trimText($usernameLabel, 20);

// SUBSCRIBER FAVES											// these are set in 'login-process.php'
$share					= $_SESSION['share'];				// whether the user's subscriber profile is visible to others
$numSavedSearches		= $_SESSION['numSavedSearches']; 	// number of saved searches
$numSavedBookmarks		= $_SESSION['numSavedBookmarks']; 	// number of saved bookmarks (of reviews)
$numSavedRubrics		= $_SESSION['numSavedRubrics']; 	// number of saved rubrics
$numBookmarkFolders		= $_SESSION['numBookmarkFolders'];	// number of bookmark folders

$numSavedTags			= $_SESSION['numSavedTags']; 		// number of saved bookmark folders (old)
$numSavedCollections	= $_SESSION['numSavedCollections']; // number of saved bookmark collections

$savedSearches			= $_SESSION['savedSearches'];		// array containing the user's saved searches
$savedBookmarks			= $_SESSION['savedBookmarks']; 		// array containing the user's saved bookmarks
$savedRubrics			= $_SESSION['savedRubrics']; 		// array containing the user's saved rubrics
$bookmarkFolders		= $_SESSION['bookmarkFolders'];		// array containing the user's saved bookmark folders

$savedTags				= $_SESSION['savedTags']; 			// array containing the user's saved bookmark folders (old)
$savedCollections		= $_SESSION['savedCollections']; 	// array containing the user's saved bookmark collections

// CONSTRUCT STRING OF BOOKMARK ID NUMBERS
if($numSavedBookmarks > 0)
{
	$bookmarkReviewIDs 	= array();
	$bookmarkReviewIDlist = '';
	$bookmarkReviewNumbers 	= array();
	$bookmarkReviewNumberList = ',';
	$IDPair = '';
	$bCounter = -1;
	foreach($savedBookmarks as $bookmark)
	{
		$bCounter += 1;
		$bookmarkID 		= $bookmark[0];
		$bookmarkReviewID 	= $bookmark[1];
		
		$bookmarkReviewNumbers[$bCounter] = $bookmarkReviewID;
		$bookmarkReviewNumberList .= $bookmarkReviewID.',';

		$IDpair .= $bookmarkReviewID.'|'.$bookmarkID.',';
	} // end foreach
} // end if $numSavedBookmarks > 0

// LAST SEARCH												// this is set in 'php/find-reviews.php', 'php/find-publishers.php', and 'php/find-archive.php'
$lastSearchType			= $_SESSION['lastSearchType'];		// whether user was searching reviews, publishers, or archive
$lastSearch				= $_SESSION['lastSearch'];			// the url of the last search

// LAST SEARCH - REVIEWS
$lastSearchReviews		= $_SESSION['lastSearchReviews'];	// the url of the last search of reviews
$lastQueryReviews		= $_SESSION['lastQueryReviews'];	// the query string of the last search of reviews (for loading a search between home and hub pages)
$lastKeywordReviews		= $_SESSION['lastKeywordReviews'];	// the last keyword of a review search

// LAST SEARCH - PUBLISHERS
$lastSearchPublishers	= $_SESSION['lastSearchPublishers'];// the url of the last search of publishers
$lastQueryPublishers	= $_SESSION['lastQueryPublishers'];	// the query string of the last search of publishers
$lastKeywordPublishers	= $_SESSION['lastKeywordPublishers'];// the last keyword of a publisher search

// LAST SEARCH - ARCHIVE
$lastSearchArchive		= $_SESSION['lastSearchArchive'];	// the url of the last search of the archive
$lastQueryArchive		= $_SESSION['lastQueryArchive'];	// the query string of the last search of the archive
$lastKeywordArchive		= $_SESSION['lastKeywordArchive'];	// the last keyword of an archive search

// LAST SEARCH - DEFAULT VALUES
if($lastSearch == NULL) 			{ $lastSearch 			= 'home.php'; }
if($lastSearchReviews == NULL) 		{ $lastSearchReviews 	= 'home.php'; }
if($lastSearchPublishers == NULL)	{ $lastSearchPublishers = 'publishers.php'; }
if($lastSearchArchive == NULL)		{ $lastSearchArchive 	= 'archive.php'; }

// LAST SEARCH - REVIEW SEARCH TERMS
if($searchType == 'reviews')
{
	$searchReviewsKeyword 	= $_SESSION['lastKeyword'];
	$searchReviewsAge		= $_SESSION['lastAge'];
	$searchReviewsAgeLabel	= $_SESSION['lastAgeLabel'];
	$searchReviewsPlatform	= $_SESSION['lastPlatform'];
	$searchReviewsSubject	= $_SESSION['lastSubject'];
	$searchReviewsTopic		= $_SESSION['lastTopic'];
	$searchReviewsTopicLabel= $_SESSION['lastTopicLabel'];
}

// IP FILTERS ------------------------------------------------------------------------------------
/*
// REMOTE TEST
if
(
	$ip == '73.33.191.150' and 
	$logout != true and
	$login != true and 
	$thisPage != 'redirect-login.php' and $thisPage != 'login.php' and $thisPage != 'login-process.php' and $thisPage != 'promo-process.php' and
	substr_count($thisPage, 'site') < 1
)
{
	$ipFilterSite = true; // flag to designate this session as belonging to a site license w/ip filtering - prevent free mode override
	$siteName = 'ctr';
	$portalFile = 'site'.$siteName.'.php'; // determine the portal filename
	$redirect = $portalFile;
	require_once 'php/redirect.php'; // redirect to portal file to authenticate login with site credentials
} // end if remote test
*/

// POUDRE RIVER
//$ip = '198.59.46.6'; // for testing range
$siteIPPoudre = substr($ip, 0, 10);
if
(
	( substr_count($siteIPPoudre, '198.59.46.') > 0 or substr_count($siteIPPoudre, '198.59.47.') > 0 ) and 
	$logout != true and
	$login != true and 
	$thisPage != 'redirect-login.php' and $thisPage != 'login.php' and $thisPage != 'login-process.php' and $thisPage != 'promo-process.php' and
	substr_count($thisPage, 'site') < 1
)
{
	$ipFilterSite = true; // flag to designate this session as belonging to a site license w/ip filtering - prevent free mode override
	$siteName = 'poudreriver';
	$portalFile = 'site'.$siteName.'.php'; // determine the portal filename
	$redirect = $portalFile;
	require_once 'php/redirect.php'; // redirect to portal file to authenticate login with site credentials
} // end if sitepoudreriver

// NYU
//$ip = '128.122.12.24'; // for testing range
$siteIPNYU = substr($ip, 0, 8);
if
(
	( substr_count($siteIPNYU, '128.122.') > 0 or substr_count($siteIPNYU, '128.122.') > 0 ) and 
	$logout != true and
	$login != true and 
	$thisPage != 'redirect-login.php' and $thisPage != 'login.php' and $thisPage != 'login-process.php' and $thisPage != 'promo-process.php' and
	substr_count($thisPage, 'site') < 1
)
{
	$ipFilterSite = true; // flag to designate this session as belonging to a site license w/ip filtering - prevent free mode override
	$siteName = 'newyorkuniversity';
	$portalFile = 'site'.$siteName.'.php'; // determine the portal filename
	$redirect = $portalFile;
	require_once 'php/redirect.php'; // redirect to portal file to authenticate login with site credentials
} // end if sitenewyorkuniversity

/*
FREE MODE SESSION -------------------------------------------------------------------------------
This block implements 'Free Mode', a guest access mode determined by moderator actions within dashboard table of the CSR.fmp12 database
If the Free Mode switch is on, all guest users (not logged in) will be automatically logged in as a free trial account
Conditions are given where this is not the case to allow users to effectively log out of the free trial account and log into their own subscriber accounts
*/
if
(
	$freeModeStatus == true and
	$ipFilterSite != true and 
	$logout != true and
	$login != true and 
	$thisPage != 'redirect-login.php' and $thisPage != 'login.php' and $thisPage != 'login-process.php' and $thisPage != 'promo-process.php' and
	substr_count($thisPage, 'site') < 1
)
{
	$freeMode 		= true;
	$username 		= 'freetrial';
	$subscriberID 	= '79293';
	$login 			= true;
	$temp 			= true;

	$_SESSION['login'] 			= true;
	$_SESSION['subscriberID'] 	= $subscriberID;
	$_SESSION['username'] 		= $username;

	$_SESSION['freeMode'] 		= true;
	$_SESSION['temp'] 			= true;
} // end if $logout != true and $login != true and $thisPage != a login page

// VELVET ROPE, PROFILE BOOLEANS
if($login == true and $publisher != true) 					{ $velvetRope 	= false; } 	else { $velvetRope 	= true; }
if($login == true and $temp != true and $freeMode != true) 	{ $profile 		= true; } 	else { $profile 	= false; }
if($sponsored == true) { $velvetRope = false; } // override for sponsored mode (no velvet rope, but not free mode) - $sponsored set in 'php/settings.php'

// CUSTOM ERROR MESSAGES FOR USER INTERACTION
require_once 'php/message-calc.php';
?>