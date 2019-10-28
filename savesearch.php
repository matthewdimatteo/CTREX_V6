<?php
/*
savesearch.php
By Matthew DiMatteo, Children's Technology Review

This file processes the save-search form (in 'php/search-options.php') to save a search url to a user's profile
There are multiple cases for the type of action to perform
- 'add' will create a new record in the 'savedsearches' table in the 'subbies.fmp12' database with the url and search summary
- 'remove' will lookup a record in the 'savedsearches' table by its id value and delete it
- 'rename' will lookup a record in the 'savedsearches' table by its id value and set the description field to a new value

The form that corresponds to this process page is 'save-search-form' in the file 'php/save-item-forms.php'
It is included in the files 'php/search-options.php' and 'php/profiles/content-profile-subscriber.php'
This allows actions to be triggered from both the home page and the profile page
The buttons on the profile page that trigger the form are in the file 'php/profiles/subscriber/section-searches.php'
The JS functions in the file 'js/scripts.js' that submit the form are savedSearchAdd, savedSearchRemove, and savedSearchRename
*/

$pageType 	= 'redirect';
$searchType	= 'reviews';
require_once 'php/autoload.php';

if(isset($_POST['save-search-type']))
{
	$redirect		= test_input($_POST['save-search-redirect']); // the destination to redirect to after a successful action
	$savesearchType = test_input($_POST['save-search-type']); // whether to add or remove
	
	// ADD NEW SAVED SEARCH
	if($savesearchType == 'add')
	{
		$pageTitle 	= 'Saving your search...';
		
		// get form input
		$searchURL 		= test_input($_POST['save-search-url']);
		$searchSummary 	= test_input($_POST['save-search-summary']);	// results summary
		$searchURL = str_replace('amp;', '', $searchURL); // parse out junk characters in the url

		// create record in savedsearches table
		$savedsearch = $fmsavedsearches->createRecord($fmsavedsearchesLayout);
		$savedsearch->setField('userID', $userID);
		$savedsearch->setField('url', $searchURL);
		$savedsearch->setField('description', $searchSummary);
		$commit = $savedsearch->commit();
		if ( FileMaker::isError ($commit) ) { echo $commit->getMessage(); exit(); }

		// set a flag to display a confirmation on the home page after redirect
		$_SESSION['saved-search-confirmation'] = true;
	} // end if type == add
	
	// REMOVE SAVED SEARCH
	else if($savesearchType == 'remove')
	{
		$pageTitle 	= 'Removing saved search...';
		$savedSearchID = test_input($_POST['save-search-id']);
		$toDelete 	= $fmsavedsearches->getRecordById($fmsavedsearchesLayout, $savedSearchID);
		$toDelete->delete();
		if ( FileMaker::isError ($toDelete) ) { echo $toDelete->getMessage(); exit(); }	
		$_SESSION['removed-search-confirmation'] = true; // set a flag to display a confirmation on the home page after redirect
	} // end else if type == remove
	
	// RENAME SAVED SEARCH
	else if($savesearchType == 'rename')
	{
		$pageTitle = 'Renaming saved search...';
		$savedSearchID 	= test_input($_POST['save-search-id']);
		$searchSummary 	= test_input($_POST['save-search-summary']);	// results summary
		$toRename 	= $fmsavedsearches->getRecordById($fmsavedsearchesLayout, $savedSearchID);
		$toRename->setField('description', $searchSummary);
		$commit = $toRename->commit();
		if ( FileMaker::isError ($commit) ) { echo $commit->getMessage(); exit(); }
	}
	
	require_once 'php/session-update.php'; // update stored $_SESSION values for saved item arrays, counts
	
} // end if isset (form submitted properly)

// if form not submitted properly
else
{
	$pageTitle = 'Redirecting...';
	$redirect = $lastSearchReviews;
}
require 'php/redirect.php';
?>