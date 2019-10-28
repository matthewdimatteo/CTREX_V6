<?php
/*
rubric-process.php
By Matthew DiMatteo, Children's Technology Review

This file processes the rubric creation form input(from the page'rubric-create.php) using the $_POST method

*/
$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page

// process the form
if(isset($_POST['checkboxes']))
{
	$selectedQAData 	= array(); 	// declare an array to store the selected qa field data (for outputting as rubric)
	$selectedQANames 	= array(); 	// declare an array to store just the qa names (for checking whether to display as checked in set of checkbox inputs)
	$selectedQAFields	= array(); 	// declare an array to store just the qa fields (for checking whether to display as checked in set of checkbox inputs)
	//$findQAType = 'fields';			// tell 'php/find-qa.php' to lookup qa by field names
	// lookup each qa that was selected using the checkbox inputs
	foreach($_POST['checkbox-qa'] as $thisQA)
	{	
		require 'php/find-qa.php'; // lookup each qa and get its field values
		array_push($selectedQAData, array($qaName, $qaType, $qaDescriptor, $qaField, $qaWeight)); // add the qa data to the array of all selected qa
		array_push($selectedQANames, $qaName); // add the qa name to the array of all selected qa names
		array_push($selectedQAFields, $qaField); // add the qa number to the array of all selected qa fields
	} // end foreach $checkboxQA
	$_SESSION['selectedQAData'] 	= $selectedQAData; 		// save the array of qa data in session storage so that 'rubric-create.php' can access it
	$_SESSION['selectedQANames'] 	= $selectedQANames;		// save the array of qa names in session storage so that 'rubric-create.php' can access it
	$_SESSION['selectedQAFields'] 	= $selectedQAFields;	// save the array of qa fields in session storage so that 'rubric-create.php' can access it
	$_SESSION['selectedQAUpdated']	= true;
} // end if isset $_POST['checkboxes']

// handle reset
else
{
	$_SESSION['selectedQAData'] 	= '';
	$_SESSION['selectedQANames'] 	= '';
	$_SESSION['selectedQAFields'] 	= '';
	$_SESSION['savedRubricID']		= '';
	$_SESSION['selectedQAUpdated']	= '';
}

$redirect = 'rubric-create.php';
require_once 'php/redirect.php';
exit();
?>