<?php
/*
portal.php
By Matthew DiMatteo, Children's Technology Review

This file is included in each Site License page - it provides the code for implementing a custom login for site license users via a portal URL
Files for site licenses follow the naming convention of the string 'site' followed by a nickname for the organization
For example, Children's Technology Review [CTR] might have a file named 'sitectr.php'

This file determines the site license organization nickname from the page name and uses it to lookup the record in the 'subbies.fmp12' database
If the record is not found, or if the license has expired, a custom error message is set to display after redirecting the user to the home page
If the record is found and the license is active, session variables are set with the login credentials

Site License users have a special type of access defined by the $license or $_SESSION['license'] value
If true, the profile page is set to load the organizational contact info for the license, and user comments are signed with the organization's name
Users cannot perform subscriber-account-specific actions, such as saving searches or bookmarks (since they do not have a subscriber profile)
*/

/* 
Parse out the site license nickname from the page/file name
i.e. if the page is 'sitedemo.php', the site license nickname is 'demo'
This value is stored in the 'siteName' field in the 'orgs' table in the 'subbies.fmp12' database file
It also serves as the username for any users (patrons of the organization that holds the site license) logged in via the portal url or IP filtering
*/

$ipFilterSite = true; // flag to designate this session as belonging to a site license w/ip filtering - prevent free mode override in 'php/session.php'

// parse out the site name from the portal url file
$siteNameStart 	= strpos($thisPage, 'site') + strlen('site');
$siteNameEnd	= strpos($thisPage, '.php');
$siteNameLength	= $siteNameEnd - $siteNameStart;
$siteName = substr($thisPage, $siteNameStart, $siteNameLength);

// lookup the site license organization using the $siteName value that was parsed out of the filename
$findLicense = $fmorgs->newFindCommand($fmorgsLayout);
$findLicense->addFindCriterion('siteName','=='.$siteName);
$result = $findLicense->execute();

// if no match for the $siteName, clear the login status and save an error message to display after redirection to the home page
if (FileMaker::isError ($result) ) 
{ 
	//echo $result->getMessage(); exit(); 
	$login 			= false;
	$license		= false;
	$username 		= '';
	$siteName 		= '';
	$siteOrg 		= '';
	
	// set an error message
	$pageTitle					= 'Site License not found - Redirecting...';
	$licenseErrorMessage 		= 'No Site License was found matching the portal URL \''.$thisPage.'\'';
	
	// set a flag to show error mesage upon redirection to home page
	$_SESSION['error'] 			= true;
	$_SESSION['error-message']	= $licenseErrorMessage;
}
// if record found, get field data and check license status
else
{
	$record = $result->getFirstRecord();
	require_once 'php/get-license.php';
	
	// if the site license is active, set the credentials for a valid login
	if($siteStatus == 'Active')
	{
		// set global variables
		$login	 		= true;
		$license 		= true;
		$username 		= $siteName;
		$pageTitle		= 'Logging in as '.$siteOrg;
	}

	// if the site license has expired, clear the login status and the user identification
	else
	{
		$login 			= false;
		$license		= false;
		$username 		= '';
		$siteName 		= '';
		$siteOrg 		= '';

		// set an error message
		$pageTitle				= 'Site License Expired - Redirecting...';
		$licenseErrorMessage 	= 'Your CTREX Site License has expired as of '.$siteExpDate.'.';
		
		// append the admin contact info to the error message so the patron can contact them
		if($numTotalAdmins > 0) 
		{ 
			$licenseErrorMessage .= '<br/>Please contact your organization\'s administrator';
			if($numTotalAdmins > 1) { $licenseErrorMessage .= 's'; }
			$licenseErrorMessage .= ': <br/><br/>';
		
			foreach($totalAdminsList as $admin)
			{
				// fname, lname, job title, email, status, exp date
				$adminFName 	= $admin[0];
				$adminLName 	= $admin[1];
				$adminTitle 	= $admin[2];
				$adminEmail		= $admin[3];
				$adminStatus 	= $admin[4];
				$adminExpDate 	= $admin[5];
				if($adminFName != NULL) { $licenseErrorMessage .= $adminFName; }
				if($adminFName != NULL and $adminLName != NULL) { $licenseErrorMessage .= ' '; }
				if($adminLName != NULL) { $licenseErrorMessage .= $adminLName; }
				if(($adminFName != NULL or $adminLName != NULL) and $adminTitle != NULL) { $licenseErrorMessage .= ', '; }
				if($adminTitle != NULL) { $licenseErrorMessage .= $adminTitle; }
				if($adminStatus != 'Active') 
				{ 
					$licenseErrorMessage .= ' (Expired';
					if($adminExpDate != NULL) { $licenseErrorMessage .= ' '.$adminExpDate; }
					$licenseErrorMessage .= ')';
				} // end if $adminStatus != 'Active'
				if($adminEmail != NULL) { $licenseErrorMessage .= '<br/><a href = "mailto:'.$adminEmail.'">'.$adminEmail.'</a>'; }
				$licenseErrorMessage .= '<br/><br/>';
			} // end foreach $admin
		} // end if $numTotalAdmins > 0
		
		// set a flag to show error mesage upon redirection to home page
		$_SESSION['error'] 			= true;
		$_SESSION['error-message']	= $licenseErrorMessage;
	} // end else (expired license)
	
} // end else (record found)

// save the values in $_SESSION storage
$displayName 				= $siteOrg;
$_SESSION['login'] 			= $login;			// whether the user is logged in
$_SESSION['license']		= $license;			// access level boolean to indicate user is a site license patron
$_SESSION['subscriberID'] 	= $subscriberID;	// used to look up subscriber profile
$_SESSION['siteName']		= $siteName;		// used to look up license profile
$_SESSION['username'] 		= $username;		// display for link to profile
$_SESSION['siteOrg']		= $siteOrg;			// display name for site license patrons on comments
$_SESSION['displayName']	= $displayName;		// display name for comments calculated above based on access level
$_SESSION['adminList']		= $adminList;		// array of contact info for active site admins
$_SESSION['expAdminList']	= $expAdminList;	// array of contact info for expired site admins

// redirect the user to the home page
$redirect = 'home.php';
require_once 'php/redirect.php';
?>