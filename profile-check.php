<?php
/*
profile-check.php
By Matthew DiMatteo, Children's Technology Review

This page is the processing page for handling updates to the subscription section of the subscriber profile 'php/profiles/subscriber/section-subscription.php'

Because the username field, included in the subscription section form, must be a unique value in the database, this page must first check that any new username
value is available before committing any edits to the record

This file gets each of the form input values from the subscription section and stores them in $_SESSION storage
If the username field has not been modified, or if a new username value is available, the user is redirected to 'profile-update.php' where the update is made

If the new username is not available, an error message is saved in $_SESSION storage, and the user is returned to the profile page, where the error displays
*/

$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page

// GATE OUT IMPROPER ACCESS
if($profile != true) { $redirect = $lastSearch; $pageTitle = 'Redirecting...'; require 'php/redirect.php'; exit(); }

// check that the form was submitted properly
if(isset($_POST['section']))
{
	$inputSection = test_input($_POST['section']);
	
	// make sure that the subscription section is being updated
	if($inputSection == 'subscription')
	{
	
		// lookup the subscriber record in the 'subbies.fmp12' database
		$findCommand = $fmsubs->newFindCommand($fmsubsLayout);
		$findCommand->addFindCriterion('globalID','=='.$userID);
		$result = $findCommand->execute();
		if (FileMaker::isError ($result) ) 
		{ 
			// echo 'error on record lookup<br/>'; echo $result->getMessage(); exit(); 
			$redirect = 'home.php'; require_once 'php/redirect.php'; exit();
		}		
		$record = $result->getFirstRecord();
		
		// declare an array of form input field names and database field names
		$fields = 
		 array
		(
			array('email'			, 'EMail'),
			array('screenName'		, 'screenName'),
			array('ctrexUsername'	, 'ctrexUsername'), 
			array('password'		, 'ctrexPassword')
		);
		
		// get the input field values and store in session for profile update
		if($fields != NULL)
		{
			$inputValues 	= array();
			$i = -1;
			foreach($fields as $field)
			{
				$inputFieldName 	= $field[0];
				$databaseFieldName 	= $field[1];
				$inputVarName = 'input'.ucfirst($inputFieldName);
				$$inputVarName = test_input($_POST[$inputFieldName]);
				$recordVarName = 'record'.ucfirst($inputFieldName);
				$$recordVarName = $record->getField($databaseFieldName);
				$i += 1;
				//echo $i.'. '.$inputVarName.': '.$$inputVarName.' --> '.$databaseFieldName.' ('.$recordVarName.': '.$$recordVarName.')<br/>';
			} // end foreach
			//exit();
;			$_SESSION['profile-update-email'] 		= $inputEmail;
			$_SESSION['profile-update-screenName'] 	= $inputScreenName;
			$_SESSION['profile-update-username'] 	= $inputCtrexUsername;
			$_SESSION['profile-update-password'] 	= $inputPassword;
			
		} // end if $fields
		
		// check if the username field was modified - if so, check that it is available; if not, proceed to profile update
		if($inputCtrexUsername != $recordCtrexUsername)
		{
			// perform a find for the input username
			$findUsername = $fmsubs->newFindCommand('subbies');
			$findUsername->addFindCriterion('ctrexUsername','=='.$inputCtrexUsername);
			$usernameResults = $findUsername->execute();
			
			// if no results found, the new username is available - proceed to profile update
			if(FileMaker::isError($usernameResults)) 
			{ 
				$dup = false;
				$_SESSION['username-available'] 	= true;
				$_SESSION['username-taken'] 		= '';
				$_SESSION['username-taken-message'] = '';
				//echo 'username is available<br/>'; exit(); // debug exit
				$redirect = 'profile-update.php'; require_once 'php/redirect.php'; exit();
			}
			
			// if no error (1 or more results), check whether the current username accounts for found record
			else
			{
				$numFound = $usernameResults->getFoundSetCount();
				if(($numFound == 0) 		or ($numFound == 1 and $inputCtrexUsername == $recordCtrexUsername))	{ $dup = false;	}
				else if (($numFound > 1) 	or ($numFound == 1 and $inputCtrexUsername != $recordCtrexUsername))	{ $dup = true; 	}
				
				// if username is not available
				if ($dup == true)
				{
					$dupMessage = 'Sorry, the username "'.$inputCtrexUsername.'" is already taken. Please try another username.';
					$_SESSION['username-available'] 	= '';
					$_SESSION['username-taken'] 		= true;
					$_SESSION['username-taken-message'] = $dupMessage;
					//echo 'username already taken<br/>';exit(); // debug exit
					$redirect = 'profile.php?id='.$userID.'&type=subscriber&mode=private'; require_once 'php/redirect.php'; exit();
				} // end if $dup true
				
				// if username is available
				// in theory, this case should not come up, since enclosed within if($inputCtrexUsername != $recordCtrexUsername)
				else if($dup == false)
				{
					$_SESSION['username-available'] 	= true;
					$_SESSION['username-taken'] 		= '';
					$_SESSION['username-taken-message'] = '';
					//echo 'username is available<br/>'; exit(); // debug exit
					$redirect = 'profile-update.php'; require_once 'php/redirect.php'; exit();
				} // end else if $dup false
				echo 'end dup check<br/>';

			} // end else 1 or more results

		} // end if $inputCtrexUsername != $recordCtrexUsername
		
		// if the username was not changed, proceed to profile-update.php
		else
		{
			//echo 'username not changed<br/>'; exit(); // debug exit
			$dup = false;
			$_SESSION['username-available'] 	= true;
			$_SESSION['username-taken'] 		= false;
			$_SESSION['username-taken-message'] = '';
			//echo 'username is available<br/>'; exit(); // debug exit
			$redirect = 'profile-update.php'; require_once 'php/redirect.php'; exit();
		} // end else username was not change

	} // end if subscription section
	else
	{
		// echo 'subscription section not updated<br/>'; exit(); // debug exit
		$redirect = 'home.php'; require_once 'php/redirect.php'; exit();
	}
} // end if isset
else
{
	// echo 'form not submitted properly<br/>'; exit(); // debug exit
	$redirect = 'home.php'; require_once 'php/redirect.php'; exit();
}
?>