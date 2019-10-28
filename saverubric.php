<?php
/*
saverubric.php
By Matthew DiMatteo, Children's Technology Review

This file processes the save-rubric form in 'php/content/content-rubric-create.php' to save a custom rubric to a user's profile
*/

$pageType 	= 'redirect';
$searchType	= 'reviews';
require_once 'php/autoload.php';

// if form is submitted properly
if(isset($_POST['save-rubric-name']))
{
	// get the form inputs
	$rubricID 			= test_input($_POST['save-rubric-id']);
	$type				= test_input($_POST['save-rubric-type']);
	$rubricName 		= test_input($_POST['save-rubric-name']);
	$qaNames 			= test_input($_POST['save-rubric-qa-names']);
	$qaFields 			= test_input($_POST['save-rubric-qa-fields']);
	$redirect 			= test_input($_POST['save-rubric-redirect']);
	$rubricDescription 	= test_input($_POST['save-rubric-description']);
	
	// ADD
	if($type == 'add')
	{
		$pageTitle 	= 'Saving your rubric...';
		
		// create record in savedrubrics table
		$savedrubric = $fmsavedrubrics->createRecord($fmsavedrubricsLayout);
		$savedrubric->setField('userID', $userID);
		$savedrubric->setField('rubricName'			, $rubricName);
		$savedrubric->setField('rubricDescription'	, $rubricDescription);
		$savedrubric->setField('qaNames'			, $qaNames);
		$savedrubric->setField('qaFields'			, $qaFields);
		$commit = $savedrubric->commit();
		if ( FileMaker::isError ($commit) ) { echo $commit->getMessage(); exit(); }
		
		// save the new record id in session storage to load it on redirect
		$savedRubricID = $savedrubric->getField('recordID');
		$_SESSION['savedRubricID'] = $savedRubricID;
		
		if($redirect == 'rubric-create.php')
		{
			$_SESSION['saved-rubric-confirmation'] = true; // set a flag to display a confirmation on the rubric creation page after redirect
		}
	} // end if type == add
	
	// UPDATE
	else if($type == 'update')
	{	
		$pageTitle 		= 'Updating your rubric...';
		$savedrubric 	= $fmsavedrubrics->getRecordById($fmsavedrubricsLayout, $rubricID);
		$savedrubric->setField('rubricName'			, $rubricName);
		$savedrubric->setField('rubricDescription'	, $rubricDescription);
		$savedrubric->setField('qaNames'			, $qaNames);
		$savedrubric->setField('qaFields'			, $qaFields);
		$commit = $savedrubric->commit();
		if ( FileMaker::isError ($commit) ) { echo $commit->getMessage(); exit(); }
		if($redirect == 'rubric-create.php')
		{
			$_SESSION['updated-rubric-confirmation'] = true; // set a flag to display a confirmation on the rubric creation page after redirect
		}
	} // end else if type == update
	
	// DELETE
	else if($type == 'remove')
	{
		$pageTitle 	= 'Deleting rubric...';
		$toDelete 	= $fmsavedrubrics->getRecordById($fmsavedrubricsLayout, $rubricID);
		$toDelete->delete();
		if ( FileMaker::isError ($toDelete) ) { echo $toDelete->getMessage(); exit(); }	
	} // end if type == remove
	
	require_once 'php/session-update.php'; // update stored $_SESSION values for saved item arrays, counts
	
} // end if isset save-rubric-name
// if form not submitted properly
else
{
	$pageTitle = 'Redirecting...';
	$redirect = $lastSearchReviews;
}
require 'php/redirect.php'; // perform the redirect
?>