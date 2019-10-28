<?php
/*
php/message-calc.php
By Matthew DiMatteo, Children's Technology Review

This file is included at the end of 'php/session.php'
It includes the code for handling custom error and confirmation messages based on user input

If the user incurs an error that requires notification, the page on which the error occurs stores a flag (true/false) in $_SESSION storage, along with a message
This file accesses the stored $_SESSION values, assigns them to variables, and clears the stored flags (so that the message only displays once)

If there is an error message to display, the stored message is assigned to the $customErrorMessage variable
The file 'php/messages.php' contains the html for outputting these messages
The containing element is set to show (if there is an error) or hide (if there is no error) based on the $customErrorMessageClass value

Likewise, if the user submits a form that requires a confirmation message, a flag is set on the page that processes the form submission
This file also sets the display of the confirmation message element
*/

// SHOW LOGIN MENU ON FAILED LOGIN ---------------------------------------------------------------------------------------------
// append a function to $onload, defined in autoload.php, which specifies 'scripts.js' functions to include in body onload
$lastAttemptFailed 			= $_SESSION['login-failed']; 	// check whether the last login attempt failed - this is set in login-process.php
$_SESSION['login-failed'] 	= '';							// clear the flag
if($lastAttemptFailed == true) { $onload .= 'showItem(\'login-menu-show\', \'login-menu-hide\', \'login-menu-container\')"'; }

// CUSTOM ERROR MESSAGE -------------------------------------------------------------------------------------------------
$customError 						= $_SESSION['error'];
$customErrorMessage 				= $_SESSION['error-message'];
$_SESSION['error'] 					= '';
$_SESSION['error-message'] 			= '';
if($customError == true and $customErrorMessage != NULL) 	{ $customErrorMessageClass = 'block'; }	 else { $customErrorMessageClass = 'hide'; }

// CONFIRMATION MESSAGE -------------------------------------------------------------------------------------------------
$confirmation 						= $_SESSION['confirmation'];
$confirmationMessage 				= $_SESSION['confirmation-message'];
$_SESSION['confirmation'] 			= '';
$_SESSION['confirmation-message'] 	= '';
if($confirmation == true and $confirmationMessage != NULL) 	{ $confirmationMessageClass = 'block'; } else { $confirmationMessageClass = 'hide'; }

?>