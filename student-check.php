<?php
/*
student-check.php
By Matthew DiMatteo, Children's Technology Review

This file processes the student discount form input using the $_POST method
On a successful form submission, a new record is added to the 'messages' table in the 'CSR.fmp12' database to serve as a notification to CTR staff

After either a success or a failure, the user is redirected back to the page 'student.php' where a message is displayed

The file 'php/content/content-student.php' is configured to display the initial input values once after a redirect
*/

$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page

if(isset($_POST['student-email']))
{
	// process form input, determine whether email is valid .edu address, store values in session
	$studentEmail = test_input($_POST['student-email']);
	if(substr_count($studentEmail, '.edu') > 0) { $studentValid = true; } else { $studentValid = false; }
	$_SESSION['studentEmail'] = $studentEmail;
	$_SESSION['studentValid'] = $studentValid;
	
	// format notification message
	$inputName 		= $studentEmail;
	$inputEmail 	= $studentEmail;
	$emailSubject 	= 'CTREX Student Discount Code Request';
	$emailMessage 	= 'Email: '.$studentEmail."\n"."\n".'IP: '.$ip;
	require_once 'php/message-create.php'; // create notification record in database

} // end if student-email isset

// return to the student discount page
$redirect = 'student.php';
require 'php/redirect.php';
?>