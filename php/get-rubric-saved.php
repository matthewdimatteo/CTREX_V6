<?php
/*
php/get-rubric-saved.php
By Matthew DiMatteo, Children's Technology Review

This file handles the saved rubric selection form input and loads the selected rubric
It is included in 'php/content/content-rubrics.php' and 'php/content/content-rubric-create.php'
*/

$lastRubric = $_SESSION['last-rubric']; // get the last rubric from session storage - is used to determine if rubric is changed

// PROCESS RUBRIC SELECTION FORM SUBMISSION
if(isset($_GET['rubric']))
{
	$rubricUsed 				= $_GET['rubric'];
	$_SESSION['last-rubric'] 	= $rubricUsed;
	if($rubricUsed != NULL)
	{
		$getSelectedRubric		= true;					// this boolean tells 'php/find-rubrics.php' to lookup a single rubric instead of all rubrics
		$primaryRubric 			= true;					// this boolean tells 'php/get-rubrics' to output the individual qa after the name/score line
		require 'php/find-rubrics.php';					// this file looks up either one rubric or all rubrics and gets their qa, storing them in an array
		$thisRubric 			= $rubricsList[0];		// set variable $thisRubric that is used by 'php/get-rubric.php'
		require 'php/get-rubric.php';					// gets the stored array values for the rubric (name, qa, ptsPossible, ptsEarned, description)
		$selectedQAData 		= $qaData;				// store the QA set for the selected rubric in a variable to be referenced later
		$selectedDescription 	= $rubricDescription;	// store the description for the selected rubric in a variable to be referenced later
		$numQA					= count($selectedQAData);// determine the number of quality attributes
		$ctrRubric 				= $rubricUsed; 			// store rubric name in a different variable, as $rubricUsed is referenced by 'php/load-review.php'
	} // end if $rubricUsed != NULL
} // end if isset $_GET['rubric']

// LOAD A RUBRIC USED IN CSR ON THE EDITORIAL PAGE
if($thisPage == 'editorial.php' and !isset($_GET['rubric']))
{
	$rubricUsed 				= $editorialRubric; // this value is set in 'php/content/content-editorial.php' before including this file
	$_SESSION['last-rubric'] 	= $rubricUsed;
	if($rubricUsed != NULL)
	{
		$getSelectedRubric		= true;					// this boolean tells 'php/find-rubrics.php' to lookup a single rubric instead of all rubrics
		$primaryRubric 			= true;					// this boolean tells 'php/get-rubrics' to output the individual qa after the name/score line
		require 'php/find-rubrics.php';					// this file looks up either one rubric or all rubrics and gets their qa, storing them in an array
		$thisRubric 			= $rubricsList[0];		// set variable $thisRubric that is used by 'php/get-rubric.php'
		require 'php/get-rubric.php';					// gets the stored array values for the rubric (name, qa, ptsPossible, ptsEarned, description)
		$selectedQAData 		= $qaData;				// store the QA set for the selected rubric in a variable to be referenced later
		$selectedDescription 	= $rubricDescription;	// store the description for the selected rubric in a variable to be referenced later
		$numQA					= count($selectedQAData);// determine the number of quality attributes
		$ctrRubric 				= $rubricUsed; 			// store rubric name in a different variable, as $rubricUsed is referenced by 'php/load-review.php'
	} // end if $rubricUsed != NULL
}

// LOAD SAVED RUBRIC FROM PROFILE
if(isset($_GET['rubric-id']))
{
	// get the saved rubric record id from the form input
	$savedRubricID 	= test_input($_GET['rubric-id']); // form input name specified in 'php/profiles/subscriber/section-rubrics.php'
}

// LOAD SAVED RUBRIC FROM RUBRICS PAGE SELECTOR
else if(isset($_GET['saved-rubric']))
{
	$savedRubricID 	= test_input($_GET['saved-rubric']); // form input name specified in 'php/rubrics-select.php'
}

// CHECK WHETHER SAVED RUBRIC WAS LAST LOADED ON RUBRIC CREATION PAGE - IF SO, SET ID TO THAT VALUE
else
{
	if($thisPage == 'rubric-create.php')
	{
		$lastSavedRubricID = $_SESSION['savedRubricID'];
		if($lastSavedRubricID != NULL) { $savedRubricID = $lastSavedRubricID; }
		$selectedQAUpdated = $_SESSION['selectedQAUpdated']; // check whether the qa were modified via the checkbox set (flag set in 'rubric-process.php')
		$_SESSION['selectedQAUpdated'] = ''; // reset the flag
	} // end if $thisPage == rubric-create
} // end else

// LOOKUP THE SAVED RUBRIC BY ITS ID VALUE
if($savedRubricID != NULL)
{
	require 'php/find-savedrubric.php'; // lookup saved rubric by its record id and get its field values
	
	// set/override the stored session values defined in 'rubric-process.php' on creation form submission (accessed below)
	if($thisPage == 'rubric-create.php')
	{
		// only override stored qa data from rubric-process if the checkbox set has not been modified (flag checked above)
		if($selectedQAUpdated != true)
		{
			$_SESSION['selectedQAData'] 	= $selectedQAData; // save the array of qa data in session storage so that 'rubric-create.php' can access it
			$_SESSION['selectedQANames'] 	= $selectedQANames;// save the array of qa names in session storage so that 'rubric-create.php' can access it
			$_SESSION['selectedQAFields'] 	= $selectedQAFields;// save the array of qa fields in session storage so that 'rubric-create.php' can access it
		}
		$_SESSION['savedRubricID']		= $savedRubricID; // save the saved rubric id in session storage to reload if navigating away from page and back
	}
} // end if $savedRubricID

// HANDLE CREATION FORM SUBMISSION - GET STORED SESSION VALUES FOR QA ARRAYS (set in 'rubric-process.php')
if($thisPage == 'rubric-create.php')
{
	$selectedQAData 	= $_SESSION['selectedQAData']; // the record data used for outputting each qa as part of rubric
	$selectedQANames 	= $_SESSION['selectedQANames'];// the qa names used for checking which boxes to check
	$selectedQAFields 	= $_SESSION['selectedQAFields'];// the qa fields used for checking which boxes to check
}
$numQA = count($selectedQAData); // variable used in hidden input 'num-qa' in evaluation form in 'php/rubric-output.php'

// determine whether using CTR or saved rubric - set $selectedRubricName (for print) and $selectedRubric (for comparing with $lastRubric)
if($ctrRubric != NULL) 		{ $selectedRubricName = $ctrRubric; 		$selectedRubric = $ctrRubric; }
if($savedRubricID != NULL) 	{ $selectedRubricName = $savedRubricName; 	$selectedRubric = $savedRubricID; }

// save the $selectedRubric in $_SESSION storage
$_SESSION['last-rubric'] = $selectedRubric;
/*
echo '$lastSavedRubricID: '.$lastSavedRubricID.'<br/>';
echo '$savedRubricID: '.$savedRubricID.'<br/>';
*/
?>