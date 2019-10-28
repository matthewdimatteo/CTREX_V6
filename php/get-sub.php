<?php
/*
php/get-sub.php
By Matthew DiMatteo, Children's Technology Review

This file gets the field values for a review from the 'subbies.fmp12' database file and performs calculations based on field values
It is included in 'php/content/profiles/content-profile-subscriber.php' and 'login-process.php'
*/

$fields = $subscriberFields;		// $subscriberFields is defined in 'php/fields.php', which is included in 'php/autoload.php'
require_once 'php/get-field.php'; 	// this file uses the $fields array to get the values for each field and assign them to variables

// perform calculations based on field data
if($screenName == NULL) { $screenName = $screenNameD; }
if($share == 'Share' or $share == 'share') 	{ $share = true; } 		else { $share = false; }
if ($temp != NULL) 							{ $temp = true; } 		else { $temp = false; }
if ($mod != NULL )							{ $mod = true; } 		else { $mod = false; }
if ($expert != NULL)						{ $expert = true; } 	else { $expert = false; }
if ($student != NULL)						{ $student = true; } 	else { $student = false; }
if ($juror != NULL)							{ $juror = true; } 		else { $juror = false; }
if($siteAdmin != NULL) 						{ $siteAdmin = true; }	else { $siteAdmin = false; }

// if the user is a site license administrator with an expired license, set a flag to display a notification
if($siteAdmin == true and $siteStatus != 'Active' and $thisPage != 'profile.php')
{
	$_SESSION['error'] 			= true;
	$_SESSION['error-message']	= 'Attention: The Site License for '.$siteOrg.' has expired as of '.$siteExpDate.'.';
} // end if $siteAdmin

// get saved items
if($numSavedSearches > 0)
{
	$savedSearchesArray = array();
	$savedSearches = $record->getRelatedSet('savedsearches');
	foreach($savedSearches as $savedSearch)
	{
		$savedSearchID				= $savedSearch->getField('savedsearches::recordID');
		$savedSearchURL 			= $savedSearch->getField('savedsearches::url');
		$savedSearchDescription 	= $savedSearch->getField('savedsearches::description');
		array_push($savedSearchesArray, array($savedSearchID, $savedSearchURL, $savedSearchDescription));
	} // end foreach
} // end if $numSavedSearches > 0
if($numSavedBookmarks > 0)
{
	$savedBookmarksArray = array();
	$savedBookmarks = $record->getRelatedSet('savedbookmarks');
	foreach($savedBookmarks as $savedBookmark)
	{
		$savedBookmarkID			= $savedBookmark->getField('savedbookmarks::recordID');
		$savedBookmarkReviewID		= $savedBookmark->getField('savedbookmarks::reviewID');
		$savedBookmarkTitle			= $savedBookmark->getField('CSRbookmark::Title');
		$savedBookmarkCollectionID	= $savedBookmark->getField('savedbookmarks::collectionID');
		array_push($savedBookmarksArray, array($savedBookmarkID, $savedBookmarkReviewID, $savedBookmarkTitle, $savedBookmarkCollectionID));
	} // end foreach
} // end if $numSavedBookmarks > 0
if($numSavedRubrics > 0)
{
	$savedRubricsArray = array();
	$savedRubrics = $record->getRelatedSet('savedrubrics');
	foreach($savedRubrics as $savedRubric)
	{
		$savedRubricID				= $savedRubric->getField('savedrubrics::recordID');
		$savedRubricName			= $savedRubric->getField('savedrubrics::rubricName');
		$savedRubricDescription		= $savedRubric->getField('savedrubrics::rubricDescription');
		$savedRubricQANames			= $savedRubric->getField('savedrubrics::qaNames');
		$savedRubricQAFields		= $savedRubric->getField('savedrubrics::qaFields');
		array_push($savedRubricsArray, array($savedRubricID, $savedRubricName, $savedRubricDescription, $savedRubricQANames, $savedRubricQAFields));
	} // end foreach
} // end if $numSavedRubrics > 0
if($numBookmarkFolders > 0)
{
	$bookmarkFoldersArray = array();
	$bookmarkFolders = $record->getRelatedSet('folders');
	foreach($bookmarkFolders as $bookmarkFolder)
	{
		$bookmarkFolderID			= $bookmarkFolder->getField('folders::recordID');
		$bookmarkFolderName			= $bookmarkFolder->getField('folders::name');
		$numBookmarksInFolder		= $bookmarkFolder->getField('folders::numBookmarks');
		if($numBookmarksInFolder == NULL) { $numBookmarksInFolder = '0'; }
		array_push($bookmarkFoldersArray, array($bookmarkFolderID, $bookmarkFolderName, $numBookmarksInFolder));
	} // end foreach
} // end if $numBookmarkFolders > 0

// get related expert reviews
if($numExpertReviews > 0)
{
	$expertReviewsArray = array();
	$numExpertReviewsPublished = 0;
	$expertReviews = $record->getRelatedSet('expertreviews');
	foreach($expertReviews as $expertReview)
	{
		$expertReviewID 			= $expertReview->getField('expertreviews::expertReviewID');
		$expertReviewTitleID 		= $expertReview->getField('expertreviews::reviewnumber');
		$expertReviewTitle	 		= $expertReview->getField('expertreviews::title');
		$expertReviewTitleStatus 	= $expertReview->getField('expertreviews::csrReviewStatus');
		$expertReviewDate 			= $expertReview->getField('expertreviews::submissionDate');
		$expertReviewTime 			= $expertReview->getField('expertreviews::submissionTime');
		if($expertReviewTitleStatus != NULL) { $numExpertReviewsPublished += 1; } // increment the published expert reviews counter
		array_push($expertReviewsArray, array($expertReviewID, $expertReviewTitleID, $expertReviewTitle, $expertReviewTitleStatus, $expertReviewDate, $expertReviewTime));
	} // end foreach $expertReview
} // end if $numExpertReviews > 0

// get related authored reviews
if($numCSRreviews > 0)
{
	$csrReviewsArray = array();
	$numCSRreviewsPublished = 0;
	$csrReviews = $record->getRelatedSet('CSRauthor');
	foreach($csrReviews as $csrReview)
	{
		$csrReviewID 	= $csrReview->getField('CSRauthor::reviewnumber');
		$csrReviewTitle = $csrReview->getField('CSRauthor::Title');
		$csrReviewDate	= $csrReview->getField('CSRauthor::Date of Review');
		$csrReviewStatus= $csrReview->getField('CSRauthor::published');
		if($csrReviewStatus != NULL) { $csrReviewStatus = 'Published'; $numCSRreviewsPublished += 1; } else { $csrReviewStatus = 'Draft'; }
		$csrReviewURL	= 'review.php?id='.$csrReviewID;
		array_push($csrReviewsArray, array($csrReviewID, $csrReviewTitle, $csrReviewDate, $csrReviewStatus, $csrReviewURL));
	} // end foreach $csrReview
} // end if $numCSRreviews > 0

// UPDATE SESSION STORAGE (for displaying username, screenname, etc.)
if($subscriberID == $recordID) { require_once 'php/profile-save.php'; } // only do this if profile belongs to user
?>