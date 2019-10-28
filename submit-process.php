<?php
/*
submit-process.php
By Matthew DiMatteo, Children's Technology Review

This file processes the product submission form input using the $_POST method
On a successful captcha entry, a new record is added to the 'messages' table in the 'CSR.fmp12' database to serve as a notification to CTR staff

After either a success or a failure, the user is redirected back to the page 'submit.php' where a message is displayed

Stored error and confirmation messages are handled by the file 'php/message-calc.php'
The file 'php/content/content-submit.php' is configured to display the initial input values once after a redirect

The form processing is handled by the file 'php/form-process.php'
It requires the use of the variables:
- $sections					- (array) section arrays of form field parameters (see 'php/form-field-output' and 'php/form-field-process')
- $sessionItem				- the $_SESSION storage item name for the $submissionData to be stored in
- $formSubmissionPage		- relative link to the form submission page for redirect on error
- $confirmationPage			- relative link to the confirmation page for redirect on success
- $confirmationMessage		- message content for the notification in the 'CSR.fmp12' database table 'messages'
- $confirmationType			- $_SESSION item name prefix for the confirmation number
- $emailSubject				- subject field for the notification in the 'CSR.fmp12' database table 'messages'
- $customPrefix (optional) 	- is added to the start of the email message
- $customSuffix (optional) 	- is added to the end of the email message
*/
$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page

// specify custom parameters for form processing
$sections 			= array('submit-product-info-fields', 'submit-product-screenshot-fields', 'submit-product-contact-fields', 'submit-product-additional-info');
$sessionItem		= 'product-submission';
$formSubmissionPage = 'submit.php';
$confirmationPage 	= 'submit.php';
$confirmationMessage= 'Your product submission has been received.';
$confirmationType	= 'product-submission';
$emailSubject		= 'CTREX Product Submission';
require_once 'php/form-process.php'; // processes the form submission based on the variables specified above
?>