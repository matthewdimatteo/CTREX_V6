<?php
/*
license-calc.php
By Matthew DiMatteo, Children's Technology Review

This file processes the submission of the site license cost calculator form 'php/license-calc-form.php'
*/
$pageName 	= 'Calculating cost...';	// placed inside html <title> tag
$pageType 	= 'redirect';				// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType = 'reviews';				// determines which form the main searchbar targets
require_once 'php/autoload.php';		// includes all necessary files for outputting the page
require_once 'php/license-tiers.php';	// includes arrays containing the data for each pricing tier

// process the cost calculator form submission
if(isset($_POST['num-admins']))
{
	// get each field
	$redirect 		= test_input($_POST['redirect']);
	$numAdmins 		= test_input($_POST['num-admins']);
	$numTerminals 	= test_input($_POST['num-terminals']);
	
	// determine rate based on number of admins/terminals - values for each pricing tier are included in 'php/license-tiers.php' above
		 if($numAdmins == NULL)				{ $adminRate = ''; }
	else if($numAdmins == 0)				{ $adminRate = ''; }
	else if($numAdmins == 1) 				{ $adminRate = $tier00pro; }
	else if($numAdmins <= $tier01max) 		{ $adminRate = $tier01pro; }
	else if($numAdmins <= $tier02max) 		{ $adminRate = $tier02pro; }
	else if($numAdmins <= $tier03max) 		{ $adminRate = $tier03pro; }
	else if($numAdmins <= $tier04max) 		{ $adminRate = $tier04pro; }
	else if($numAdmins <= $tier05max) 		{ $adminRate = $tier05pro; }
	else if($numAdmins <= $tier06max) 		{ $adminRate = $tier06pro; }
	else if($numAdmins <= $tier07max) 		{ $adminRate = $tier07pro; }
	else if($numAdmins > $tier07max) 		{ $adminRate = $tier07pro; }
	else									{ $adminRate = ''; }
											
		 if($numTerminals == NULL)			{ $terminalRate = ''; }
	else if($numTerminals == 0)				{ $terminalRate = ''; }
	else if($numTerminals == 1) 			{ $terminalRate = $tier00basic; }
	else if($numTerminals <= $tier01max) 	{ $terminalRate = $tier01basic; }
	else if($numTerminals <= $tier02max) 	{ $terminalRate = $tier02basic; }
	else if($numTerminals <= $tier03max) 	{ $terminalRate = $tier03basic; }
	else if($numTerminals <= $tier04max) 	{ $terminalRate = $tier04basic; }
	else if($numTerminals <= $tier05max) 	{ $terminalRate = $tier05basic; }
	else if($numTerminals <= $tier06max) 	{ $terminalRate = $tier06basic; }
	else if($numTerminals <= $tier07max) 	{ $terminalRate = $tier07basic; }
	else if($numTerminals > $tier07max) 	{ $terminalRate = $tier07basic; }
	else									{ $terminalRate = ''; }

	// calculate the actual cost
	$adminCost 			= $numAdmins * $adminRate;
	$terminalCost 		= $numTerminals * $terminalRate;
	$totalCost 			= $adminCost + $terminalCost;
	
	// calculate what the cost would have been at standard rate
	$basicCost 			= $numTerminals * 20; 
	$proCost 			= $numAdmins * 60;
	$normalCost 		= $basicCost + $proCost;

	// calculate the savings
	$adminSavings 		= $proCost - $adminCost;
	$terminalSavings	= $basicCost - $terminalCost;
	$totalSavings 		= $adminSavings + $terminalSavings;

} // end if isset submit-cost-calc
else if ( isset($_POST['reset']) )
{
	$redirect 			= test_input($_POST['redirect']);
	
	$numAdmins 			= '';
	$adminCost 			= '';
	$adminRate 			= '';
	$adminSavings 		= '';

	$numTerminals 		= '';
	$terminalCost 		= '';
	$terminalRate 		= '';
	$terminalSavings 	= '';

	$totalCost 			= '';
	$totalSavings		= '';
}

// store the calculated values in $_SESSION
$_SESSION['license-calc']					= true;

$_SESSION['license-calc-admins'] 			= $numAdmins;
$_SESSION['license-calc-admin-cost'] 		= $adminCost;
$_SESSION['license-calc-admin-rate']		= $adminRate;
$_SESSION['license-calc-admin-savings']		= $adminSavings;

$_SESSION['license-calc-terminals'] 		= $numTerminals;
$_SESSION['license-calc-terminal-cost'] 	= $terminalCost;
$_SESSION['license-calc-terminal-rate']		= $terminalRate;
$_SESSION['license-calc-terminal-savings']	= $terminalSavings;

$_SESSION['license-calc-total-cost'] 		= $totalCost;
$_SESSION['license-calc-total-savings']		= $totalSavings;

// redirect the user to the page they were on
if($redirect == NULL) { $redirect = 'licenses.php'; }
require_once 'php/redirect.php';
?>