<?php
/*
content-profile.php
By Matthew DiMatteo, Children's Technology Review

This page serves as the content file for the page 'profile.php'
However, it is more nuanced than other content files
The profile page is intended to serve a variety of purposes, supporting various conditions
These include the type of user logged in (a subscriber, a publisher, or a site license patron) and the mode (readonly or edit)
As such, a series of calculations is first performed to determine the type of profile content file to include, as well as to gate out improper access attempts
*/

if(isset($_GET['id']))
{
	// get the input parameters
	$inputID	= test_input($_GET['id']);
	$inputType	= test_input($_GET['type']); // subscriber/publisher/license
	$inputMode 	= test_input($_GET['mode']); // public or private
	
	// by default, use the current user type to load their own profile in the default more for that user type
	if($inputType == NULL or $inputMode == NULL) { $inputType = $userType;	$inputMode = $profileMode; }
	
	// determine the type of find request to construct based on user type
	switch($inputType)
	{
		case 'subscriber' 	: 
			$fmobj 		= $fmsubs;
			$fmLayout 	= $fmsubsLayout;
			$fmField	= 'globalID';
			break;
		case 'publisher'	: 
			$fmobj 		= $fmpubs;
			$fmLayout 	= $fmpubsLayout;
			$fmField	= 'recordID';
			break;
		case 'license'		: 
			$fmobj		= $fmorgs;
			$fmLayout	= $fmorgsLayout;
			$fmField	= 'siteName';
			break;
	} // end switch($type)
	// lookup the record associated with the profile
	$findCommand = $fmobj->newFindCommand($fmLayout);
	$findCommand->addFindCriterion($fmField,'=='.$inputID);
	$result = $findCommand->execute();
	if (FileMaker::isError ($result) ) { echo $result->getMessage(); exit(); }		
	$record = $result->getFirstRecord();
	if($inputType == 'subscriber')
	{
		$publicProfile = $record->getField('share');
		if($publicProfile == 'Share' or $publicProfile == 'share') { $publicProfile = true; } else { $publicProfile = false; }
		$recordExpert = $record->getField('expert');
		if($recordExpert != NULL) { $share = 'share'; $publicProfile = true; } // make expert profiles shared by default
	}
	
	// gate out improper access (attempts to view someone else's profile in private mode, or if public mode is not available)
	if
	(
		(
			// SUBSCRIBER PROFILE IN PRIVATE MODE - ALLOW ONLY SUBSCRIBER WITH MATCHING ID
			$inputType == 'subscriber' 	and 
			$inputMode == 'private' 	and 
			($userType != 'subscriber' 	or ($userType == 'subscriber' and $userID != $inputID) ) 
		)
		or
		(
			// SUBSCRIBER PROFILE IN PUBLIC MODE BUT SHARE NOT ON - ALLOW ONLY SUBSCRIBER WITH MATCHING ID
			$inputType == 'subscriber' 	and 
			$inputMode == 'public' 		and 
			$publicProfile != true 		and $userID != $inputID
		)
		or
		(
			// SUBSCRIBER PROFILE IN PUBLIC MODE BUT SHARE NOT ON - PREVENT EDGE CASE OF PUBLISHER WITH SAME ID
			$inputType == 'subscriber' 	and 
			$inputMode == 'public' 		and 
			$publicProfile != true 		and 
			$userID == $inputID 		and 
			$userType != 'subscriber'
		)
		or
		(
			// PUBLISHER PROFILE IN PRIVATE MODE - ALLOW ONLY PUBLISHER WITH MATCHING ID
			$inputType == 'publisher' 	and 
			$inputMode == 'private' 	and 
			($userType != 'publisher' 	or ($userType == 'publisher' and $userID != $inputID) ) 
		)
		or
		(
			// PUBLISHER PROFILE IN PUBLIC MODE - PREVENT PUBLISHERS FROM VIEWING OTHER PUBLISHERS
			$inputType == 'publisher' 	and 
			$inputMode == 'public' 		and 
			$userType == 'publisher' 	and $userID != $inputID
		)
		or
		(
			// PREVENT GUESTS FROM VIEWING PUBLISHERS
			$inputType == 'publisher' 	and 
			$inputMode == 'public' 		and 
			$velvetRope == true 		and $userType != 'publisher'
		)
		or
		(
			// LICENSE PROFILE (PUBLIC MODE BY DEFAULT) - ALLOW ONLY OTHER MEMBERS OF THAT LICENSE AND SITE ADMINS
			($inputType == 'license' 	and ($userType == 'license' 	and $userID != $inputID) ) or
			($inputType == 'license' 	and ($userType != 'license' 	and $siteAdmin != true) ) or
			($inputType == 'license' 	and ($userType != 'license' 	and $siteAdmin == true and $siteName != $inputID) )
		)
		or
		(
			// LICENSE PROFILE IN PRIVATE MODE - ALLOW ONLY SITE ADMIN WITH MATCHING ID
			($inputType == 'license'	and ($inputMode == 'private'	and $siteAdmin != true ) ) or
			($inputType == 'license' 	and ($inputMode == 'private'	and $siteAdmin == true and $siteName != $inputID))
		)
	)
	{
		/*
		echo 'IMPROPER ACCESS<br/>';
		echo '$userType: '.$userType.'<br/>$inputType: '.$inputType.'<br/>$userID: '.$userID.'<br/>$inputID: '.$inputID.'<br/>$publicProfile: '.$publicProfile.'<br/>share: '.$share.'<br/>'; 
		exit();
		*/
		$redirect = $lastSearch;
		require_once 'php/redirect.php';
		exit();
	} // end if improper access
	
	// if proper access, load the content file for the specified user type
	else
	{
		$profileContentFile = 'php/profiles/content-profile-'.$inputType.'.php';
		require_once $profileContentFile;
	} // end else proper access
	
} // end if(isset($_GET['id']))

// if form not submitted properly, redirect back to last search
else
{
	$redirect = $lastSearch;
	require_once 'php/redirect.php';
	exit();
}

?>