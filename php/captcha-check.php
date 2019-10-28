<?php
/*
php/captcha-check.php
By Matthew DiMatteo, Children's Technology Review

This file gets the form inputs for the captcha 'php/captcha.php' included in any form
It is included in the file 'php/form-process.php'

If the user input does not match the solution, an error flag is set - the file 'php/form-process.php' will then not commit any data to the database
The file 'php/message-calc.php' gets the $_SESSION value after a redirect and sets the css class for the error message to display
The file 'php/messages.php' outputs the error message
*/
// check the captcha
$captcha			= test_input($_POST['captcha']);
$captchaSolution 	= test_input($_POST['captcha-solution']);
if($captcha != $captchaSolution) 
{ 
	$captchaError 				= true;
	$error 						= true;
	$_SESSION['error']			= true;
	$_SESSION['error-message'] 	= 'Sorry, the CAPTCHA you entered is incorrect. Please try again.';
}
?>