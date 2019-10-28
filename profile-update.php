<?php
/*
profile-update.php
By Matthew DiMatteo, Children's Technology Review

This file processes the profile update form input using the $_POST method
It is designed to only update one section of the subscriber's profile at a time
The form input field names and their corresponding database field names are defined for each section in 'php/profiles/section-fields.php'
This file loops through each field, gets the form input value, and assigns that value to the database field

Note: the subscription section is handled separately, due to the requirement to check username availability before updating
The code to handle subscription section updates is included in 'php/profiles/subscriber/profile-update-subscription.php'
*/

$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page

// GATE OUT IMPROPER ACCESS
if($profile != true) { $redirect = $lastSearch; $pageTitle = 'Redirecting...'; require 'php/redirect.php'; exit(); }

// arrays with field names for each section
require_once 'php/profiles/section-fields.php';

// handle subscription section update following referral from 'profile-check.php';
require_once 'php/profiles/subscriber/profile-update-subscription.php';

// CHECK TYPE OF USER
if(isset($_POST['type']))
{
	$inputType = test_input($_POST['type']);
	
	// HANDLE SUBSCRIBER PROFILE UPDATE
	if($inputType == 'subscriber')
	{
		
		if(isset($_POST['section']))
		{
			// lookup the subscriber record in the 'subbies.fmp12' database
			$findCommand = $fmsubs->newFindCommand($fmsubsLayout);
			$findCommand->addFindCriterion('globalID','=='.$userID);
			$result = $findCommand->execute();
			if (FileMaker::isError ($result) ) 
			{ 
				echo 'Error: Failed to look up subscriber profile, User ID: '.$userID.'<br/>'; echo $result->getMessage(); exit(); 
			}		
			$record = $result->getFirstRecord();
				
			$inputSection 	= test_input($_POST['section']);
			switch($inputSection)
			{
				case 'privacy' 			: $fields = $fieldsPrivacy; 		break;
				case 'license' 			: $fields = $fieldsLicense;			break;
				case 'contact-private' 	: $fields = $fieldsContactPrivate;	break;
				case 'contact-public' 	: $fields = $fieldsContactPublic;	break;
				case 'bio' 				: $fields = $fieldsBio;				break;
				case 'expert' 			: $fields = $fieldsExpert;			break;
			} // end switch($inputSection)
			
			require 'php/profiles/profile-update-commit.php'; // perform the database update
			
		} // end if isset section
	} // end if type == 'subscriber'
	
	// HANDLE PUBLISHER PROFILE UPDATE
	else if($inputType == 'publisher')
	{
		if(isset($_POST['section']))
		{
			// lookup the publisher record in the 'Producers.fmp12' database
			$findCommand = $fmpubs->newFindCommand($fmpubsLayout);
			$findCommand->addFindCriterion('recordID','=='.$userID);
			$result = $findCommand->execute();
			if (FileMaker::isError ($result) ) 
			{ 
				echo 'Error: Failed to look up publisher profile, User ID: '.$userID.'<br/>'; echo $result->getMessage(); exit(); 
			}		
			$record = $result->getFirstRecord();
			
			$inputSection 	= test_input($_POST['section']);
			switch($inputSection)
			{
				case 'account' 		: $fields = $fieldsAccount; 		break;
				case 'privacy' 		: $fields = $fieldsPrivacy;			break;
				case 'industry' 	: $fields = $fieldsIndustry;		break;
				case 'description' 	: $fields = $fieldsDescription;		break;
				case 'links' 		: $fields = $fieldsLinks;			break;
				case 'contact' 		: $fields = $fieldsPubContact;		break;
			} // end switch($inputSection)
			
			require 'php/profiles/profile-update-commit.php'; // perform the database update
			
		} // end if isset section
			
	} // end else if type == 'publisher'
	
	// if $inputType is some other value, redirect out
	else
	{
		//echo '$inputType is ???<br/>';
		//echo '$inputType: '.$inputType.'<br/>';
		$redirect = 'home.php'; $pageTitle = 'Redirecting...'; require_once 'php/redirect.php'; exit();
	} // end else invalid value
	
} // end if isset type

// if form not submitted properly
else
{
	// echo 'form not submitted properly<br/>'; exit(); // debug exit
	$redirect = 'home.php'; require_once 'php/redirect.php'; exit();
} // end else form not submitted properly

?>