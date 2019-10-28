<?php
/*
contact-process.php
By Matthew DiMatteo, Children's Technology Review

This file processes the contact form input using the $_POST method
On a successful captcha entry, a new record is added to the 'messages' table in the 'CSR.fmp12' database to serve as a notification to CTR staff

After either a success or a failure, the user is redirected back to the page 'contact.php' where a message is displayed

Stored error and confirmation messages are handled by the file 'php/message-calc.php'
The file 'php/content/content-contact.php' is configured to display the initial input values once after a redirect

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
$pageTitle 	= 'Processing...';
$pageType 	= 'redirect';
$searchType	= 'reviews';
require_once 'php/autoload.php';

// specify custom parameters for form processing
$sections 			= array('contact-form-fields');
$sessionItem		= 'contact-form-submission';
$formSubmissionPage = 'contact.php';
$confirmationPage 	= 'contact.php';
$confirmationMessage= 'Your contact form submission has been received.';
$confirmationType	= 'contact-form';
$emailSubject		= 'CTREX Contact Form Submission';
require_once 'php/form-process.php';
?>