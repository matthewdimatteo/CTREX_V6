<?php
/*
php/profiles/license/section-contact.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the content of the 'Contact' tab of the Organization Profile page
It is included dynamically in 'php/profiles/profile-sections.php'
*/

// SECTION CONTAINER
echo '<div id = "contact-info" class = "profile-section-content">';

// EDIT MODE
if($inputMode == 'private')
{
	// SECTION HEADER - ORGANIZATION CONTACT INFO
	echo '<div class = "profile-section-header">Organization Contact Info (Visible to your patrons)</div>'; // /.profile-section-header

	// FORM START
	echo '<form name = "profile-update-form-license-contact" method = "POST" action = "profile-update.php">';
	
		$portalURL = '<a href = "'.$portal.'" title = "Custom link for patron access">'.$portal.'</a>';
		$sectionItems = array
		(
			array('Portal URL'		, 'portalURL'			, false	, ''		, ''),
			array('Active Through'	, 'siteDuration'		, false	, ''		, ''),
			array('Street Address'	, 'siteAddressStreet'	, true	, 'text'	, ''),
			array('City'			, 'siteAddressCity'		, true	, 'text'	, ''),
			array('State'			, 'siteAddressState'	, true	, 'text'	, ''),
			array('Zip'				, 'siteAddressZip'		, true	, 'text'	, ''),
			array('Email'			, 'siteEmail'			, true	, 'email'	, ''),
			array('Phone 1'			, 'sitePhone1'			, true	, 'text'	, ''),
			array('Fax'				, 'siteFax'				, true	, 'text'	, ''),
		);
		// INPUT FIELDS
		require 'php/profiles/section-items.php'; // outputs the items in the array

		// HIDDEN INPUTS
		echo '<input type = "hidden" name = "type" 		value = "license" />';
		echo '<input type = "hidden" name = "section" 	value = "contact" />';

		// SUBMIT BTN -->
		echo '<div class = "profile-section-submit-btn">';
			echo '<input type = "submit" name = "update-contact-info" value = "Update this information" />';
		echo '</div>'; // /.profile-section-submit-btn

	echo '</form>'; // FORM END
} // end if private

// PUBLIC PROFILE
else
{
	// SECTION HEADER - COMPANY CONTACT INFO
	echo '<div class = "profile-section-header">Organization Contact Info</div>'; // /.profile-section-header

	$portalURL = '<a href = "'.$portal.'" title = "Custom link for patron access">'.$portal.'</a>';
	$siteEmailURL = '<a href = "mailto:'.$siteEmail.'">'.$siteEmail.'</a>';
	$sectionItems = array
	(
		array('Portal URL'		, 'portalURL'			, false	, ''	, ''),
		array('Active Through'	, 'siteDuration'		, false	, ''	, ''),
		array('Primary Address'	, 'siteAddressLine'		, false	, ''	, ''),
		array('Email'			, 'siteEmailURL'		, false	, ''	, ''),
		array('Phone 1'			, 'sitePhone1'			, false	, ''	, ''),
		array('Fax'				, 'siteFax'				, false	, ''	, ''),
	);
	// INPUT FIELDS
	require 'php/profiles/section-items.php'; // outputs the items in the array
	
} // end else public

echo '</div>'; // /#contact-info .profile-section-content
?>