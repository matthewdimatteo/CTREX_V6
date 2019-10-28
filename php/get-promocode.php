<?php
/*
php/get-promocode.php
By Matthew DiMatteo, Children's Technology Review

This file gets the stored session values for a promocode form submission and sets certain copy and css classes accordingly
It is included in the file 'php/messages.php'

*/
// HANDLE PROMOCODE FORM SUBMISSION (ON REDIRECTION FROM promo-process.php)
// get the session storage items set in 'promo-process.php' and then reset the stored items
$promocodeEntered 		= $_SESSION['promocode-entered'];	$_SESSION['promocode-entered']	= '';
$promocodeStatus		= $_SESSION['promocode-status'];	$_SESSION['promocode-status']	= '';
$promocodeFeedback		= $_SESSION['promocode-feedback'];	$_SESSION['promocode-feedback']	= '';
$promocodeItems 		= $_SESSION['promocode-items'];		$_SESSION['promocode-items']	= '';
$numPromocodeItems 		= count($promocodeItems);
if($promocodeStatus == 'Active')
{
	if($numPromocodeItems > 0)	{ $promocodeInstructions = 'Use the button below to proceed to the secure order form:'; }
	if($numPromocodeItems > 1) 	{ $promocodeInstructions = 'Use the buttons below to proceed to the secure order form:'; }
}
$promocodeParsed = strtolower($promocodeEntered);
if($promocodeParsed == 'supporter')
{ 
	$promocodeSupporter = 'All supporters get a <a href = "http://dustormagic.com" target = "_blank">Dust or Magic</a> fleece vest and are listed on our <a href = "supporters.php">supporters page</a>.';
}
if($promocodeStatus == 'Active') 
{ $promocodeFeedbackClass = 'promocode-accepted'; } else { $promocodeFeedbackClass = 'promocode-invalid'; }
?>