<?php
/*
php/form-submission-get.php
By Matthew DiMatteo, Children's Technology Review

This file accesses the stored $_SESSION item for submitted form data, which is an array of arrays for each field
It is included in the content file for each form page (such as 'php/content/content-submit.php')

The file assigns each stored field value to a custom variable name 
This allows the form to display submitted field values after redirection (for a confirmation or an error)
*/
$submissionData = $_SESSION[$sessionItem];
foreach($submissionData as $data)
{
	$label		= $data[0];
	$varName 	= $data[1];
	$varValue 	= $data[2];
	$$varName 	= $varValue;
}
?>