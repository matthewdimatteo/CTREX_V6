<?php
/*
php/form-process.php
By Matthew DiMatteo, Children's Technology Review

This file dynamically processes any form submission given several variables
It is to be included on any form processing page such as 'contact-process.php'

required variables:
$sections 			= array('order-fields', 'admin-info-fields', 'org-info-fields');
$sessionItem		= 'site-license-order-details';
$formSubmissionPage = 'license-order.php';
$confirmationPage 	= 'license-confirmation.php';
$confirmationMessage= 'Your Site License Order Form Submission has been received';

$emailSubject		= 'CTREX Site License Order Form Submission';
$customContent		= 'Site License Order Confirmation # '.$confirmationNumber;

$formErrorCondition = ($numAdmins < 1 or $numTerminals < 1 or $totalCost < 1);
$formErrorMessage	= 'Please specify a number of administrators and terminals.';
*/

// general form processing procedure
if(isset($_POST['captcha']))
{
	require_once 'php/captcha-check.php';
	
	// declare an array to store the submission data for redirect
	$submissionData 	= array();
	$submissionDataN 	= -1;
	
	// declare a variable for the email notification message
	$summary = '';
	
	foreach($sections as $section)
	{
		$sectionVarName = $section;
		$$sectionVarName = $_SESSION[$section];
		$fields = $$sectionVarName;
		require 'php/form-fields-process.php';
	}
	
	// store the submission data in $_SESSION
	$_SESSION[$sessionItem] = $submissionData;
	
	// custom error handling
	//if($formErrorCondition)
	if($thisPage == 'license-process.php' and ($numAdmins < 1 or $numTerminals < 1 or $totalCost < 1))
	{
		if($formErrorMessage == NULL) 
		{ $formErrorMessage = 'Sorry, there was a problem with your form submission. Please make sure all required fields are filled'; }
		$error = true;
		$_SESSION['error'] = true;
		if($captchaError == true) 	{ $_SESSION['error-message'] .= '<br/>'.$formErrorMessage; }
		else						{ $_SESSION['error-message'] = $formErrorMessage; }
	}
	
	// redirect back to form if error
	if($error == true)
	{
		$redirect = $formSubmissionPage;
	}
	
	// redirect to confirmation page on success, with confirmation message
	else
	{
		// generate a confirmation number and store in $_SESSION for display on confirmation page
		$confirmationDigits = array();
		$confirmationLength = 8;
		$confirmationNumber;
		for ($i = 0; $i < $confirmationLength; $i++)
		{
			$confirmationDigits[$i] = rand(0,9);
			$confirmationNumber .= $confirmationDigits[$i];
		}
		$_SESSION[$confirmationType.'-confirmation-number'] = $confirmationNumber; // $confirmationType should be specified at the start of the process page
		$_SESSION['confirmation'] 			= true;
		$_SESSION['confirmation-message'] 	= $confirmationMessage;
		$redirect = $confirmationPage;
		
		// format notification message
		$emailMessage;
		if($customPrefix != NULL) { $emailMessage .= $customPrefix."\n"; }
		$emailMessage .= 'Confirmation # '.$confirmationNumber."\n".$summary."\n";
		if($customSuffix != NULL) { $emailMessage .= $customSuffix."\n"; }
		$emailMessage .= 'IP: '.$ip."\n";
		
		// enter the notification in the 'CSR.fmp12' database table 'messages' for CTR staff
		require_once 'php/message-create.php';
	}
} // end if (isset($_POST['captcha']))
else { $redirect = $formSubmissionPage; }
require_once 'php/redirect.php';

?>