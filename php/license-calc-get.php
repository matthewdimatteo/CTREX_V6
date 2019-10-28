<?php
/*
php/license-calc-get.php
By Matthew DiMatteo, Children's Technology Review

This file accesses the stored site license cost calculator values from $_SESSION
It is included in the files 'php/content/content-license.php' and php/content/content-license-order.php'
The values are used to display within the form fields and the cost summary breakdown below the form
*/

// get cost calculator values from $_SESSION storage
$licenseCalc	= $_SESSION['license-calc'];

$numAdmins		= $_SESSION['license-calc-admins'];
$adminCost		= $_SESSION['license-calc-admin-cost'];
$adminRate		= $_SESSION['license-calc-admin-rate'];
$adminSavings	= $_SESSION['license-calc-admin-savings'];

$numTerminals 	= $_SESSION['license-calc-terminals'];
$terminalCost	= $_SESSION['license-calc-terminal-cost'];
$terminalRate	= $_SESSION['license-calc-terminal-rate'];
$terminalSavings= $_SESSION['license-calc-terminal-savings'];

$totalCost		= $_SESSION['license-calc-total-cost'];
$totalSavings	= $_SESSION['license-calc-total-savings'];

if($totalCost != NULL)
{ 
	$enterClass			= 'hide';
	$clearClass			= 'block';
	$costSummaryClass 	= 'block'; 
	$calcBtnLabel 		= 'Recalculate';
} 
else 
{ 
	$enterClass			= 'block';
	$clearClass			= 'hide';
	$costSummaryClass 	= 'hide'; 
	$calcBtnLabel 		= 'Calculate';
}
if($thisPage == 'license-order.php') { $customizeBtnClass = 'hide'; } else { $customizeBtnClass = 'block'; }
?>