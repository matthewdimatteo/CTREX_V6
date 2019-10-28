<?php
/*
php/profiles/publisher/section-contact.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the content of the 'Contact Info' tab of the Publisher Profile page
It is included dynamically in 'php/profiles/profile-sections.php'
*/

// SECTION CONTAINER
echo '<div id = "contact-info" class = "profile-section-content">';
	
// EDIT MODE
if($inputMode == 'private')
{
	// SECTION HEADER - COMPANY CONTACT INFO
	echo '<div class = "profile-section-header">Company Contact Info (Public)</div>'; // /.profile-section-header

	// FORM START
	echo '<form name = "profile-update-form-publisher-contact" method = "POST" action = "profile-update.php">';

		// SECTION ITEMS - CONTACT INFO
		// array (label			, id/var			, edit	, type		, note)
		$sectionItems = array
		(
			array('Street Address'		, 'addressStreet'	, true	, 'text'	, ''),
			array('City'				, 'addressCity'		, true	, 'text'	, ''),
			array('State'				, 'addressState'	, true	, 'text'	, ''),
			array('Zip'					, 'addressZip'		, true	, 'text'	, ''),
			array('Country'				, 'addressCountry'	, true	, 'text'	, ''),

			array('Phone 1'				, 'phone1'			, true	, 'text'	, ''),
			array('Phone 2'				, 'phone2'			, true	, 'text'	, ''),
			array('Fax'					, 'fax'				, true	, 'text'	, ''),
		);

		// INPUT FIELDS - CONTACT INFO
		require 'php/profiles/section-items.php'; // outputs the items in the array

		// SECTION HEADER - PUBLIC EMAILS
		echo '<div class = "profile-section-header">Specify up to five (5) Public Email Addresses:</div>';

		// SECTION ITEMS - PUBLIC EMAILS
		// array (label			, id/var			, edit	, type		, note)
		$sectionItems = array
		(
			array('Email 1'		, 'publicEmail1'		, true	, 'email'	, ''),
			array('Use for'		, 'publicEmail1Type'	, true	, 'text'	, ''),
			array('Email 2'		, 'publicEmail2'		, true	, 'email'	, ''),
			array('Use for'		, 'publicEmail2Type'	, true	, 'text'	, ''),
			array('Email 3'		, 'publicEmail3'		, true	, 'email'	, ''),
			array('Use for'		, 'publicEmail3Type'	, true	, 'text'	, ''),
			array('Email 4'		, 'publicEmail4'		, true	, 'email'	, ''),
			array('Use for'		, 'publicEmail4Type'	, true	, 'text'	, ''),
			array('Email 5'		, 'publicEmail5'		, true	, 'email'	, ''),
			array('Use for'		, 'publicEmail5Type'	, true	, 'text'	, ''),
		);

		// INPUT FIELDS - PUBLIC EMAILS
		require 'php/profiles/section-items.php'; // outputs the items in the array

		// HIDDEN INPUTS
		echo '<input type = "hidden" name = "type" 		value = "publisher" />';
		echo '<input type = "hidden" name = "section" 	value = "contact" />';

		// SUBMIT BTN -->
		echo '<div class = "profile-section-submit-btn">';
			echo '<input type = "submit" name = "update-contact-info" value = "Update this information" />';
		echo '</div>'; // /.profile-section-submit-btn

	echo '</form>'; // FORM END
} // end if($inputMode == 'private')

// PUBLIC PROFILE
else
{
	$possibleItems = array
	(
		array('Street Address', 'addressStreet'	, true	, 'text'	, ''),
		array('City'		, 'addressCity'		, true	, 'text'	, ''),
		array('State'		, 'addressState'	, true	, 'text'	, ''),
		array('Zip'			, 'addressZip'		, true	, 'text'	, ''),
		array('Country'		, 'addressCountry'	, true	, 'text'	, ''),

		array('Phone 1'		, 'phone1'			, true	, 'text'	, ''),
		array('Phone 2'		, 'phone2'			, true	, 'text'	, ''),
		array('Fax'			, 'fax'				, true	, 'text'	, ''),
		
		array('Email 1'		, 'publicEmail1'	, true	, 'email'	, ''),
		array('Use for'		, 'publicEmail1Type', true	, 'text'	, ''),
		array('Email 2'		, 'publicEmail2'	, true	, 'email'	, ''),
		array('Use for'		, 'publicEmail2Type', true	, 'text'	, ''),
		array('Email 3'		, 'publicEmail3'	, true	, 'email'	, ''),
		array('Use for'		, 'publicEmail3Type', true	, 'text'	, ''),
		array('Email 4'		, 'publicEmail4'	, true	, 'email'	, ''),
		array('Use for'		, 'publicEmail4Type', true	, 'text'	, ''),
		array('Email 5'		, 'publicEmail5'	, true	, 'email'	, ''),
		array('Use for'		, 'publicEmail5Type', true	, 'text'	, ''),
	);
	$sectionItems = array();
	foreach($possibleItems as $item)
	{
		$varName = $item[1];
		$value = $$varName;
		if($value != NULL) { array_push($sectionItems, $item); }
	}
	require 'php/profiles/section-items.php'; // outputs the items in the array
} // end else public

echo '</div>'; // /#contact-info .profile-section-content
?>