<?php
/*
php/content/content-password.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the password recovery page 'password.php'
It contains the form for submitting a password recovery request
The form submission is processed by the page 'password-process.php'
*/

// get the stored product submission after redirection
$sessionItem = 'password-recovery-request';	// specifies the $_SESSION storage item for the form submission data
require_once 'php/form-submission-get.php';		// gets the stored submission data and assigns each item in the array to a variable

// array (label, name, value, type, required, note)
$fields = array
(
	array('Username', 'inputName'	, $inputName	, 'text'	, true, ''),
	array('Email'	, 'inputEmail'	, $inputEmail	, 'email'	, true, ''),
	array('Zip*'	, 'inputZip'	, $inputZip		, 'text'	, true, ''),
);
$_SESSION['password-recovery-fields'] = $fields;
?>

<div id = "password-page-container">

	<!-- PAGE HEADER -->
	<div class = "page-header">Enter your CTREX Username and provide an Email Address to receive your password</div>

	<!-- FORM START -->
	<div class = "paragraph bottom-20">
	<form name = "password-recovery-form" id = "password-recovery-form" method = "POST" action = "password-process.php">
		<?php require 'php/form-fields-output.php';?>
		<?php require_once 'php/captcha.php';?>
		<div class = "submit-row"><input type = "submit" name = "submit-password-recovery-form" value = "Submit"/></div>
	</form>
	</div><!-- /.paragraph -->

	<?php require_once 'php/username-help.php'; // display toggleable username hint ?>
	
	<!-- FOOTNOTES -->
	<div class = "paragraph instructions">
	
		<!-- ZIP CODE FOOTNOTE -->
		<p>*Enter your zip code to verify your identity: If we don't have your zip code on file, <a href = "contact.php">contact us</a> for a manual reset.</p>
		<p><a href = "mailto:info@childrenstech.com">Email us your zip code to update your record.</a></p>
	
	</div><!-- /.paragraph instructions -->
	
</div><!-- /#password-page-container -->