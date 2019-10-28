<?php
/*
promo-process.php
By Matthew DiMatteo, Children's Technology Review

This file processes the promocode entry form submission 'php/promo-form.php'
It looks up the entered promocode in the 'promocodes' table of the 'subbies.fmp12' database and determines if the code matches an active, valid record

Depending on the validity of the code, either a confirmation or error message is stored in $_SESSION to be displayed upon redirect
Additionally, the file references data on the found promocode record to determine which form item(s) to display 
- these link to authorize.net secure transaction portals for the corresponding sale item
*/
$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page

// process the form submission
if(isset($_POST['promocode']))
{

	// GET THE INPUT CODE
	$promocodeEntered 	= test_input($_POST['promocode']);
	$redirect 			= test_input($_POST['redirect']);

	// QUERY DATABASE TO CHECK CODE MATCH
	$findcode 	= $fmpromo->newFindCommand($fmpromoLayout);
	$findcode->addFindCriterion('code','=='.$promocodeEntered);
	$codeResult = $findcode->execute();

	// IF NOT MATCH, REDIRECT
	if (FileMaker::isError ($codeResult) ) 
	{ 
		$_SESSION['promocode-entered'] 	= $promocodeEntered;
		$_SESSION['promocode-status'] 	= 'Invalid';
		$_SESSION['promocode-feedback'] = 'Sorry, the promotional code you entered is not active.';
		require_once 'php/redirect.php';
		exit(); 
	}

	// IF MATCH, GET PROMOCODE RECORD
	$code 		= $codeResult->getFirstRecord();

	// SET FEEDBACK BASED ON STATUS
	$promocodeStatus 	= $code->getField('status');
	$hasItems			= $code->getField('authitems');
	if($hasItems == NULL) { $promocodeStatus = 'Expired'; }

	if($promocodeStatus == 'Active')		{ $promocodeFeedback = 'Your promotional code has been accepted'; }
	else if($promocodeStatus == 'Expired') 	{ $promocodeFeedback = 'Sorry, the promotional code you entered has expired.'; }
	else									{ $promocodeFeedback = 'Sorry, the promotional code you entered is not active.'; }

	// GET RELATED SALE ITEMS FOR THIS CODE
	if($promocodeStatus == 'Active')
	{
		$authitems 	= $code->getRelatedSet('auth');
		$numAuthItems = count($authitems);

		$promocodeItems = array();
		$a = -1;
		foreach($authitems as $authitem)
		{
			$a += 1;

			$linkID 	= $authitem->getField('auth::linkID');
			$btnLabel 	= $authitem->getField('auth::btnLabel');	
			$footnote	= $authitem->getField('auth::footnote');

			$itemdetails = array($linkID, $btnLabel, $footnote);
			$promocodeItems[$a] = $itemdetails;
		} // end foreach
	} // end if Active & hasItems

	$_SESSION['promocode-entered'] 	= $promocodeEntered;
	$_SESSION['promocode-status'] 	= $promocodeStatus;
	$_SESSION['promocode-feedback'] = $promocodeFeedback;
	$_SESSION['promocode-items']	= $promocodeItems;
}
else { $redirect = $lastSearch; }
require_once 'php/redirect.php';
	
?>