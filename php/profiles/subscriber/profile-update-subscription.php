<?php
/*
php/profiles/subscriber/profile-update-subscription.php
By Matthew DiMatteo, Children's Technology Review

This file is included in 'profile-update.php' - it handles the special case of the subscription section update

The subscription section is different from the others in that it contains the username field, which must be a unique value
As such, the form for that section target the page 'profile-check.php', which first performs a separate find to determine whether the input username is available

If the username value has not been changed, or is available, the user is redirected to 'profile-update.php'
The 'profile-check' file stores the original field input values in $_SESSION storage - this file accesses those values

This file, included in 'profile-update.php', access the stored field input values and then performs the database update
*/

// CHECK WHETHER USERNAME WAS CHECKED AND IS AVAILABLE, RESET STORED VALUE
$usernameChecked = $_SESSION['username-available'];
$_SESSION['username-available'] = '';

// if accessing page from profile-check.php, perform the update
if($usernameChecked == true)
{
	
	// get the stored $_SESSION values
	$inputEmail 		= $_SESSION['profile-update-email'];
	$inputScreenName 	= $_SESSION['profile-update-screenName'];
	$inputUsername 		= $_SESSION['profile-update-username'];
	$inputPassword 		= $_SESSION['profile-update-password'];
	
	// reset the $_SESSION values
	$_SESSION['profile-update-email'] 		= '';
	$_SESSION['profile-update-screenName'] 	= '';
	$_SESSION['profile-update-username'] 	= '';
	$_SESSION['profile-update-password'] 	= '';
	
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
	
	$fields = $fieldsSubscription;
	
	// check that $fields array has values to handle an unexpected case for $inputSection
	if($fields != NULL)
	{
		// get the input field values and set the database record's fields with those values
		$inputValues 	= array();
		$i = -1;
		foreach($fields as $field)
		{
			$inputFieldName 	= $field[0];
			$databaseFieldName 	= $field[1];
			$inputVarName 	= 'input'.ucfirst($inputFieldName);
			//$$inputVarName 	= test_input($_POST[$inputFieldName]);
			$inputVarValue 	= $$inputVarName;
			$recordVarName 	= 'record'.ucfirst($inputFieldName);
			$$recordVarName = $record->getField($databaseFieldName);
			$recordVarValue = $$recordVarName;
			$i += 1;
			$inputValues[$i] = array($inputVarName, $inputVarValue, $databaseFieldName, $recordVarName, $recordVarValue);
			// echo $i.'. '.$inputVarName.': '.$inputVarValue.' --> '.$databaseFieldName.' ('.$recordVarName.': '.$recordVarValue.')<br/>';
			$record->setField($databaseFieldName, $inputVarValue);
		} // end foreach $field

		//exit(); // debug exit

		// commit the record edits
		$result= $record->commit();
		if ( FileMaker::isError ($result) ) 
		{ 
			// echo 'error on commit (subscription)'; echo $result->getMessage(); exit();
			// return to user profile
			$redirect = 'profile.php?id='.$userID.'&type=subscriber&mode=private';
			require_once 'php/redirect.php'; exit();
		}
		
		// UPDATE SESSION VALUES
		require_once 'php/get-sub.php'; // get the remaining record fields
		require_once 'php/profile-save.php'; // save profile data in PHP $_SESSION storage for future reference

		// return to user profile
		$redirect = 'profile.php?id='.$userID.'&type=subscriber&mode=private';
		require_once 'php/redirect.php'; exit();
		
	} // end if $fields
} // end if accessing page from 'profile-check.php'
?>