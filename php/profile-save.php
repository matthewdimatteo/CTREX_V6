<?php
/*
php/profile-save.php
By Matthew DiMatteo, Children's Technology Review

This file saves profile data in PHP $_SESSION storage for future reference
It is included in the files 'login-process.php' after a successful login attempt, and 'profile-update.php' after a successful profile update
These saved $_SESSION values are accessed by the file 'php/session.php', which runs at the start of every page load

It is also includes in the file 'php/session-update', which first looks up subscriber record and gets field values after a saved item addition/removal
*/

// determine whether current user holds a subscriber account
if($login == true and $temp != true and $publisher != true and $license != true) { $subscriber = true; }

// determine display name for comments
if($subscriber == true)
{
	if($expert == true)		{ $displayName = $fullName; }
	else					{ $displayName = $screenName; }
}
else if($publisher == true) { $displayName = $publisherName; }
else if($license == true)	{ $displayName = $siteOrg; }
else if($temp == true)		{ $displayName = $username; }
else						{ $displayName = 'Guest'; }

// store profile info in session ----------------------------------------

// access level (bools)
$_SESSION['login'] 			= $login;		// whether the user is logged in
$_SESSION['subscriber']		= $subscriber;	// whether the user has a subscriber account
$_SESSION['publisher']		= $publisher;	// whether the user has a publisher account
$_SESSION['temp']			= $temp;		// whether the user is logged in with a temporary account (no profile)
$_SESSION['mod']			= $mod;			// whether the user has moderator privileges
$_SESSION['expert']			= $expert;		// whether the user has expert privileges
$_SESSION['student']		= $student;		// whether the user has student reviewer privileges
$_SESSION['juror']			= $juror;		// whether the user has juror privileges
$_SESSION['jurorType']		= $jurorType;	// which award the user is juror for (BRDA or KAPI)
$_SESSION['jurorNumber']	= $jurorNumber;	// the juror's designated number (for determining which set of fields they edit)
$_SESSION['siteAdmin']		= $siteAdmin;	// whether the user has site admin privileges

// user identification
$_SESSION['subscriberID'] 	= $subscriberID;	// used to look up subscriber profile
$_SESSION['publisherID'] 	= $publisherID;		// used to look up publisher profile
$_SESSION['siteName']		= $siteName;		// used to look up license profile
$_SESSION['username'] 		= $username;		// display for link to profile
$_SESSION['screenName']		= $screenName;		// display name for subscribers on comments
$_SESSION['publisherName']	= $publisherName;	// display name for publisher on comments
$_SESSION['fullName']		= $fullName;		// display name for experts on comments
$_SESSION['siteOrg']		= $siteOrg;			// display name for site license patrons on comments
$_SESSION['displayName']	= $displayName;		// display name for comments calculated above based on access level

// subscriber settings
$_SESSION['share']					= $share;				// whether the user's subscriber profile is visible to others
$_SESSION['numSavedSearches'] 		= $numSavedSearches;	// number of saved searches
$_SESSION['numSavedBookmarks'] 		= $numSavedBookmarks;	// number of saved bookmarks (of reviews)
$_SESSION['numSavedRubrics'] 		= $numSavedRubrics;		// number of saved rubrics
$_SESSION['numBookmarkFolders']		= $numBookmarkFolders;	// number of bookmark folders

$_SESSION['numSavedTags'] 			= $numSavedTags;		// number of saved bookmark folders (old)
$_SESSION['numSavedCollections'] 	= $numSavedCollections;	// number of saved bookmark collections

$_SESSION['savedSearches'] 			= $savedSearchesArray;	// array containing the user's saved searches
$_SESSION['savedBookmarks'] 		= $savedBookmarksArray;	// array containing the user's saved bookmarks
$_SESSION['savedRubrics'] 			= $savedRubricsArray;	// array containing the user's saved rubrics
$_SESSION['bookmarkFolders']		= $bookmarkFoldersArray;// array containing the user's bookmark folders

$_SESSION['savedTags'] 				= $savedTags;			// array containing the user's saved bookmark folders (old)
$_SESSION['savedCollections'] 		= $savedCollections;	// array containing the user's saved bookmark collections
?>