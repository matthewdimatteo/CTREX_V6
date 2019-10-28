<?php
/*
php/contact-form.php
By Matthew DiMatteo, Children's Technology Review

This file contains the form for submitting a message - it is included in the file 'php/content/content-contact.php'
It has been abstracted from the content file 'php/content/content-contact.php' for use in other areas, such as the press/media resources page

The form submission is processed by the page 'contact-process.php'
*/

// get the stored $_SESSION values from a redirect (on captcha error)
$sessionItem = 'contact-form-submission';
require_once 'php/form-submission-get.php';

// set the default username to 'Guest' if user not logged in
if ($username == NULL) { $contactUsername = 'Guest'; }

?>

<!-- CONTACT FORM -->
<div class = "page-header">Contact Us</div>
<div class = "paragraph-90">
<form name = "contact-form" id = "contact-form" method = "POST" action = "contact-process.php">
	<?php
	$contactFormFields = array
	(
		array('Username', 'contactUsername'	, $contactUsername	, 'hidden'	, false	, ''),
		array('Name'	, 'inputName'		, $inputName		, 'text'	, true	, ''),
		array('Email'	, 'inputEmail'		, $inputEmail		, 'email'	, true	, ''),
		array('Message'	, 'contactMessage'	, $contactMessage	, 'textarea', true	, '')
	);
	$_SESSION['contact-form-fields'] = $contactFormFields;
	$fields = $contactFormFields;
	require 'php/form-fields-output.php';
	require_once 'php/captcha.php';
	?>
    <div class = "submit-row"><input type = "submit" name = "submit-contact-form" value = "Submit Your Message"/></div>
</form>
</div><!-- /.paragraph -->
<br/>
<br/>
<?php require_once 'php/contact-info.php';?>