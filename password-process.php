<?php
/*
password-process.php
By Matthew DiMatteo, Children's Technology Review

This file processes the password recovery form input using the $_POST method
It handles errors for no matching username and no matching zip code, storing the error flags and messages in $_SESSION
On a successful request, a record is added to the 'messages' table in the 'CSR.fmp12' database to serve as a notification to CTR staff
After either a success or a failure, the user is redirected back to the page 'password.php' where a message is displayed

Stored error and confirmation messages are handled by the file 'php/message-calc.php'
The file 'php/content/content-password.php' is configured to display the initial input values once after a redirect
*/
$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page
$redirect = 'password.php'; 		// always return back to the page 'password.php' after form submission is processed by this page

// specify custom parameters for form processing
$sections 			= array('password-recovery-fields');
$sessionItem		= 'password-recovery-request';
$formSubmissionPage = 'password.php';
$confirmationPage 	= 'password.php';
$confirmationMessage= 'Your password recovery request has been received.';
$confirmationType	= 'password-recovery';
$emailSubject		= 'CTREX Password Recovery Request';

// process the form submission
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
	
	// only perform database operations if the captcha is valid
	if($captcha == $captchaSolution)
	{
		// look up subscriber record
		$findSubscriber = $fmsubs->newFindCommand($fmsubsLayout);
		$findSubscriber->addFindCriterion('ctrexUsername','=='.$inputName);
		$results = $findSubscriber->execute();

		// if no matching username found, store an error message and return to the password recovery page
		if ( FileMaker::isError ($results) )
		{
			$_SESSION['error'] 					= true;
			$_SESSION['error-message'] 			= 'No <strong>username</strong> was found matching the one you provided.';
			require_once 'php/redirect.php'; exit();
		}
		
		// if the username is found, check the zip code
		else
		{
			$record 	= $results->getFirstRecord();
			$zip		= $record->getField('Zip');
			
			// if the zip code does not match, store an error message and return to the password recovery page
			if($zip != $inputZip) 
			{ 
				$passwordRecoveryError 			= true;
				$passwordRecoveryErrorMessage 	= 'The <strong>zip code</strong> you entered did not match the one on record.';
				$_SESSION['error'] 				= true;
				$_SESSION['error-message'] 		= $passwordRecoveryErrorMessage;
				//require_once 'php/redirect.php'; exit();
			}
			
			// if the zip code matches, store the user's password and a confirmation message
			else
			{
				$password 	= $record->getField('ctrexPassword');
				$_SESSION['confirmation'] = true;
				$_SESSION['confirmation-message'] = $inputName.', your CTREX password is <strong>'.$password.'</strong>';
			} // end else zip code matches
		
		} // end if username found
	
		// format notification message
		$emailSubject = 'CTREX Password Recovery Request';
		if($passwordRecoveryError == true) { $emailSubject .= ' (Failed - Invalid Zip Code)'; }
		$emailMessage = 
						'Username: '.$inputName."\n".
						'Email: '.$inputEmail."\n".
						'Password: '.$password."\n".
						'Zip Code on Record: '.$zip."\n".
						'Zip Code Entered: '.$inputZip."\n".
						'IP: '.$ip;
		
		require_once 'php/message-create.php'; 	// enter new record in 'CSR.fmp12' file's messages table as notification to CTR staff
	} // end if captcha valid
	else 
	{ 
		$_SESSION['error'] = true; 
		$_SESSION['error-message'] = 'Sorry, the CAPTCHA you entered is incorrect. Please try again.';
	} // end else captcha invalid
} // end if(isset($_POST['message']))
require_once 'php/redirect.php'; // the $redirect value is set above to 'password.php'
?>