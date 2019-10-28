<?php
/*
php/get-license.php
By Matthew DiMatteo, Children's Technology Review

This file is included in the file 'php/portal.php' which is included in each site license page ('site'.$siteName.'.php')
It gets the field data for a site license record that has been looked up in 'php/portal.php'

It is also included in the file 'php/profiles/content-profile-license.php' to display the site license organization profile page
*/
$fields = $licenseFields; 			// $licenseFields is defined in 'php/fields.php', which is included in 'php/autoload.php'
require_once 'php/get-field.php';	// this file uses the $fields array to get the values for each field and assign them to variables

// formatAddress() function defined in 'functions.php'
$siteAddressLine = formatAddress($siteAddressStreet, $siteAddressCity, $siteAddressState, $siteAddressZip, $siteAddressCountry); 

// format string for active-exp
$siteDuration = $siteStartDate.' - '.$siteExpDate; 

// only attempt to access the portal if it contains any related records
if($numAdmins > 0)
{
	$admins = $record->getRelatedSet('subs'); 	// access a portal on the orgs layout containing related subs records
	$activeAdminsList 	= array();				// an array to store the active site admins
	$expiredAdminsList 	= array();				// an array to store any expired site admins
	$totalAdminsList	= array();				// an array to store all site admins
	
	// counter variables for looping through each array
	$nActiveAdmins 	= -1; 
	$nExpiredAdmins = -1; 
	$nTotalAdmins	= -1;

	foreach($admins as $admin)
	{
		// get the related record fields
		$adminFirstName 	= $admin->getField('subs::Contact First Name');
		$adminLastName 		= $admin->getField('subs::Contact Last Name');
		$adminJobTitle 		= $admin->getField('subs::Contact Title');
		$adminEmail	 		= $admin->getField('subs::EMail');
		
		$adminStatus		= $admin->getField('subs::siteAdmin');	// whether the contact is marked in 'subs' as a 'siteAdmin'
		$activeStatus		= $admin->getField('subs::substatus');	// whether contact's personal subscription is active or expired
		$adminExpDate		= $admin->getField('subs::expDate');	// expiration date for the contact's personal subscription
		
		// if the related contact record is marked as a 'siteAdmin' in subs, add to arrays
		if($adminStatus != NULL)
		{
			// if active, add the related record data to the active admins array
			if($activeStatus == 'Active')
			{
				array_push($activeAdminsList, array($adminFirstName, $adminLastName, $adminJobTitle, $adminEmail, $activeStatus, $adminExpDate));
			} // end if active

			// if not active, add the related record data to the expired admins array
			else
			{
				array_push($expiredAdminsList, array($adminFirstName, $adminLastName, $adminJobTitle, $adminEmail, $activeStatus, $adminExpDate));
			} // end else (not active)
			
			// either way, also add the related record data to the array of all admins
			array_push($totalAdminsList, array($adminFirstName, $adminLastName, $adminJobTitle, $adminEmail, $activeStatus, $adminExpDate));
			
		} // end if $adminStatus
		
	} // end foreach $admin
	
	// count the size of each array (number of admin contacts)
	$numActiveAdmins 	= count($activeAdminsList);
	$numExpiredAdmins 	= count($expiredAdminsList);
	$numTotalAdmins		= count($totalAdminsList);
	
} // end if $numAdmins > 0
?>