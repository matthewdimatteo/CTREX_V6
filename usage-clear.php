<?php
/*
usage-clear.php
By Matthew DiMatteo

This file clears the stored $_SESSION flag indicated that a site license usage report was requested and returns the user to the organization profile page
The form that targets this page is in the file 'php/usage-report-form.php'
*/

$pageTitle 	= 'Clearing usage report...';
$pageType 	= 'redirect';
$searchType	= 'reviews';
require_once 'php/autoload.php';

// RESET
if(isset($_POST['reset']) and $siteAdmin == true)
{
	$_SESSION['usageReportRequest'] = '';
	$redirect = 'profile.php?id='.$siteName.'&type=license&mode=private';
} // end if isset reset and $siteAdmin

// IF FORM NOT SUBMITTED PROPERLY
else  { $redirect = 'licenses.php'; }

// REDIRECT
require 'php/redirect.php'; // perform the redirection
exit();
?>