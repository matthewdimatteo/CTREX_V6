<?php
/*
savebookmark.php
By Matthew DiMatteo, Children's Technology Review

This file processes the save-bookmark form in 'php/save-item-forms.php' to manage saved reviews for a user's profile
Functions in 'js/scripts.js' allow for addition and removal of bookmarked reviews, deletion of all bookmarks, and creation, deletion, and editing of folders
*/

$pageType 	= 'redirect';
$searchType	= 'reviews';
require_once 'php/autoload.php';

// if form is submitted properly
if(isset($_POST['save-bookmark-type']))
{
	$redirect		= test_input($_POST['save-bookmark-redirect']); // the destination (full url) to redirect to after a successful action
	$redirectPage	= test_input($_POST['save-bookmark-redirect-page']); // the page that triggered the form submission (for confirmation messages)
	$bookmarkType 	= test_input($_POST['save-bookmark-type']); // whether to add or remove (set by functions in 'js/scripts.js')
	
	// ADD BOOKMARK
	if($bookmarkType == 'add')
	{
		$pageTitle 	= 'Bookmarking this review...';		
		$reviewID = test_input($_POST['save-bookmark-review-id']); // get form input

		// create record in savedbookmarks table
		$savedbookmark = $fmsavedbookmarks->createRecord($fmsavedbookmarksLayout);
		$savedbookmark->setField('userID', $userID);
		$savedbookmark->setField('reviewID', $reviewID);
		$commit = $savedbookmark->commit();
		if ( FileMaker::isError ($commit) ) { echo $commit->getMessage(); exit(); }
		if($redirectPage == 'home.php')
		{
			$_SESSION['saved-bookmark-confirmation'] = true; // set a flag to display a confirmation on the home page after redirect
		}
	} // end if $bookmarkType == 'add'
	
	// REMOVE BOOKMARK
	else if($bookmarkType == 'remove')
	{
		$pageTitle 	= 'Removing bookmark...';
		$bookmarkID = test_input($_POST['save-bookmark-id']); // get form input
		
		// delete the record with input id in savedbookmarks table
		$toDelete 	= $fmsavedbookmarks->getRecordById($fmsavedbookmarksLayout, $bookmarkID);
		$toDelete->delete();
		if ( FileMaker::isError ($toDelete) ) { echo $toDelete->getMessage(); exit(); }	
		if($redirectPage == 'home.php')
		{
			$_SESSION['removed-bookmark-confirmation'] = true; // set a flag to display a confirmation on the home page after redirect
		}
	} // end else if $bookmarkType == 'remove'
	
	// REMOVE ALL
	else if($bookmarkType == 'deleteAll')
	{
		$pageTitle = 'Deleting bookmarks...';
		
		// lookup all savedbookmarks with the user's id and delete each
		$toDelete = $fmsavedbookmarks->newFindCommand($fmsavedbookmarksLayout);
		$toDelete->addFindCriterion('userID', '=='.$userID);
		$result = $toDelete->execute();
		if (FileMaker::isError ($result) ){ echo $result->getMessage(); exit(); }
		$records = $result->getRecords();
		foreach ($records as $deleteBookmark){ $deleteBookmark->delete(); }
	} // end if $bookmarkType == 'deleteAll'
	
	// MOVE TO FOLDER
	else if($bookmarkType == 'move')
	{
		$pageTitle = 'Moving bookmark...';
		
		// get form input
		$bookmarkID = test_input($_POST['save-bookmark-id']); 
		$folderID	= test_input($_POST['save-bookmark-folder-id']);
		
		// lookup the saved bookmark by its record id
		$moveBookmark = $fmsavedbookmarks->getRecordById($fmsavedbookmarksLayout, $bookmarkID);
		$moveBookmark->setField('folderID', $folderID); // set the folderID field with the input value
		$commit = $moveBookmark->commit();
		if ( FileMaker::isError ($commit) ) { echo $commit->getMessage(); exit(); }
	} // end if $bookmarkType == 'move'
	
	require 'php/session-update.php'; // update stored $_SESSION values for saved item arrays, counts
	
} // end if isset save-bookmark-type

// FOLDERS
else if(isset($_POST['save-folder-type']))
{
	$redirect		= test_input($_POST['save-folder-redirect']); // the destination (full url) to redirect to after a successful action
	$redirectPage	= test_input($_POST['save-folder-redirect-page']); // the page that triggered the form submission (for confirmation messages)
	$folderType 	= test_input($_POST['save-folder-type']); // whether to add or remove (set by functions in 'js/scripts.js')
	
	if($folderType == 'folder-add')
	{
		$pageTitle = 'Creating new folder...';
		$newFolderName = test_input($_POST['save-folder-name']); // get form input
		
		// create a new record in the folders table (if there is a valid value entered)
		if($newFolderName != NULL)
		{
			$newFolder = $fmbookmarkfolders->createRecord($fmbookmarkfoldersLayout);
			$newFolder->setField('userID', $userID);
			$newFolder->setField('name', $newFolderName);
			$commit = $newFolder->commit();
			if ( FileMaker::isError ($commit) ) { echo $commit->getMessage(); exit(); }
			if($redirectPage == 'savedbookmarks.php')
			{
				$_SESSION['saved-folder-confirmation'] = true; // set a flag to display a confirmation on the home page after redirect
			}
		} // end if $newFolderName
	} // end if $folderType == 'folder-add'
	
	// DELETE FOLDER AND ITS BOOKMARKS
	else if($folderType == 'delete')
	{
		$pageTitle = 'Deleting folder...';
		$folderID = test_input($_POST['save-folder-id']); // get form input
		$deleteFolder = $fmbookmarkfolders->getRecordById($fmbookmarkfoldersLayout, $folderID); // lookup folder by its record id
		$numBookmarksInFolder = $deleteFolder->getField('numBookmarks'); // check whether it contains any bookmarks
		$deleteFolder->delete(); // delete the folder record
		$_SESSION['deletedFolder'] = true;
		
		// if the folder has bookmarks in it, lookup bookmarks with this folder id and delete each
		if($numBookmarksInFolder > 0)
		{
			$deleteBookmarks = $fmsavedbookmarks->newFindCommand($fmsavedbookmarksLayout);
			$deleteBookmarks->addFindCriterion('folderID', '=='.$folderID);
			$result = $deleteBookmarks->execute();
			if (FileMaker::isError ($result) ){ echo $result->getMessage(); exit(); }
			$records = $result->getRecords();
			foreach ($records as $deleteBookmark){ $deleteBookmark->delete(); }
		} // end if $numBookmarksInFolder > 0
	} // end if $folderType == 'delete'
	
	require 'php/session-update.php'; // update stored $_SESSION values for saved item arrays, counts

} // end if isset save-folder-type

// if form not submitted properly
else
{
	$pageTitle = 'Redirecting...';
	$redirect = $lastSearchReviews;
}
require 'php/redirect.php'; // perform the redirect
?>