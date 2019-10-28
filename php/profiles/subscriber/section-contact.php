<?php
/*
php/profiles/subscriber/section-contact.php
By Matthew DiMatteo, Children's Technology Review

This file defines the content for the 'Contact' section of the subscriber profile
An array is constructed for each set of fields to be displayed - this array is output by the file 'php/profiles/section-items.php'
The array should include:
- the field label ($label)
- the element id/variable name ($id) *
- whether the field should be editable or readonly ($edit), true if editable, false if readonly
- the type of input ($type) such as text, email, password, number
- and an annotation, if any ($note) to provide some context for the field

* Regarding variable names:

The values for each field on the profile are stored in variables whose names are calculated dynamically
- For subscriber profiles, reference 'php/get-sub.php'
- For site license organization profiles, reference 'php/get-license.php'
- For publisher profiles, reference 'php/get-pub.php'

The input elements share the same name as their corresponding variables
The page for processing $_POST data for profile update form submissions should target fields by those names


This file handles both the 'private' (editable) and 'public' cases

This is one of multiple files for each profile section

Each of these files must follow the filename convention:
'section-' followed by the string used to define a section in the $sections array in php/profiles/content-profile-subscriber.php
*/

// PRIVATE (EDITABLE) PROFILE
if($inputMode == 'private')
{

	// FORM START (CONTACT INFO - PRIVATE)
	echo '<form name = "profile-update-form-subscriber-contact-private" method = "POST" action = "profile-update.php">';

		// PRIVATE CONTACT INFO
		echo '<div id = "private-contact-info" class = "profile-section-content">';

			// HEADER
			echo '<div class = "profile-section-header">';
				echo 'Private Contact Info*';
				echo '<br/>';
				echo '(NOT Included on <a href = "'.$previewLink.'">Public Profile</a>)';
			echo '</div>'; // /.profile-section-header

			// SECTION ITEMS
			// array (label			, id/var				, edit	, type		, note)
			$sectionItems = array
			(
				array('First Name'		, 'fname'			, true	, 'text'	, ''),
				array('Last Name'		, 'lname'			, true	, 'text'	, ''),
				array('Street Address'	, 'addressStreet'	, true	, 'text'	, ''),
				array('City'			, 'addressCity'		, true	, 'text'	, ''),
				array('State'			, 'addressState'	, true	, 'text'	, ''),
				array('Zip'				, 'addressZip'		, true	, 'text'	, ''),
				array('Country'			, 'addressCountry'	, true	, 'text'	, ''),
				array('Phone 1'			, 'phone1'			, true	, 'text'	, ''),
				array('Phone 2'			, 'phone2'			, true	, 'text'	, ''),
				array('Fax'				, 'fax'				, true	, 'text'	, ''),
			);
			
			// FIELD INPUTS
			require 'php/profiles/section-items.php'; // outputs the items in the array
			
			// HIDDEN INPUTS
			echo '<input type = "hidden" name = "type" 		value = "subscriber" />';
			echo '<input type = "hidden" name = "section" 	value = "contact-private" />';
			
			// FOOTNOTE
			echo '<div class = "profile-section-footnote">';
				if($expert != true) 
				{ 
					echo '*This information is never displayed publically, even if you share your <a href = "'.$previewLink.'">public profile</a>.'; 
				}
				else				
				{ 
					echo '*This information is never displayed publically, not even on your <a href = "'.$previewLink.'">public profile</a>.'; 
				}
			echo '</div>'; // /.profile-section-footnote
			
			// UPDATE BTN
			echo '<div class = "profile-section-submit-btn">';
				echo '<input type = "submit" name = "update-contact-private" value = "Update this information" />';
			echo '</div>'; // /.#profile-section-submit-btn

		echo '</div>'; // /#private-contact-info
	
	echo '</form>'; // FORM END (CONTACT INFO - PRIVATE)
	
	// FORM START (CONTACT INFO - PUBLIC)
	echo '<form name = "profile-update-form-subscriber-contact-public" method = "POST" action = "profile-update.php">';
		
		// PUBLIC CONTACT INFO
		echo '<div id = "public-contact-info" class = "profile-section-content">';

			// SECTION HEADER
			echo '<div class = "profile-section-header">';
				echo '(Optional) Public Contact Info**';
				echo '<br/>';
				echo '(Visible on <a href = "'.$previewLink.'">Public Profile</a> if Shared)';
			echo '</div>'; // /.profile-section-header

			// SECTION ITEMS
			// array (label			, id/var		, edit	, type		, note)
			$sectionItems = array
			(
				array('Organization'	, 'organization'	, true	, 'text'	, ''),
				array('Job Title'		, 'jobTitle'		, true	, 'text'	, ''),
				array('Public Email'	, 'publicEmail'		, true	, 'text'	, ''),
				array('Public Phone'	, 'publicPhone'		, true	, 'text'	, ''),
				array('Website'			, 'publicWebsite'	, true	, 'text'	, ''),
				array('Facebook'		, 'publicFacebook'	, true	, 'text'	, ''),
				array('Twitter'			, 'publicTwitter'	, true	, 'text'	, ''),
				array('YouTube'			, 'publicYouTube'	, true	, 'text'	, ''),
				array('Instagram'		, 'publicInstagram'	, true	, 'text'	, ''),
				array('Pinterest'		, 'publicPinterest'	, true	, 'text'	, ''),
				array('LinkedIn'		, 'publicLinkedIn'	, true	, 'text'	, ''),
			);
			
			// INPUT FIELDS
			require 'php/profiles/section-items.php'; // outputs the items in the array
			
			// HIDDEN INPUTS
			echo '<input type = "hidden" name = "type" 		value = "subscriber" />';
			echo '<input type = "hidden" name = "section" 	value = "contact-public" />';

			// FOOTNOTE
			echo '<div class = "profile-section-footnote">';
				if($expert != true) 
				{ 
					echo '**This information is only displayed on your <a href = "'.$previewLink.'">public profile</a> if the \'Share\' setting above is selected.'; 
				}
				else				
				{ 
					echo '**This information, if specified, will appear on your <a href = "'.$previewLink.'">public profile</a>';
					echo ', which, as a CTR Expert Reviewer, is shared by default.'; 
				}
			echo '</div>'; // /.profile-section-footnote

			// UPDATE BTN
			echo '<div class = "profile-section-submit-btn">';
				echo '<input type = "submit" name = "update-contact-public" value = "Update this information" />';
			echo '</div>'; // /.#profile-section-submit-btn

		echo '</div>'; // /.#public-contact-info
	
	echo '</form>'; // FORM END (CONTACT INFO - PUBLIC)
	
} // end if private

// PUBLIC PROFILE
else
{
	// CONTACT INFO
	echo '<div id = "contact-info" class = "profile-section-content">';
		$possibleItems = array
		(
			array('Organization'	, 'organization'	, true	, 'text'	, ''),
			array('Job Title'		, 'jobTitle'		, true	, 'text'	, ''),
			array('Public Email'	, 'publicEmail'		, true	, 'text'	, ''),
			array('Public Phone'	, 'publicPhone'		, true	, 'text'	, ''),
			array('Website'			, 'publicWebsite'	, true	, 'text'	, ''),
			array('Facebook'		, 'publicFacebook'	, true	, 'text'	, ''),
			array('Twitter'			, 'publicTwitter'	, true	, 'text'	, ''),
			array('YouTube'			, 'publicYouTube'	, true	, 'text'	, ''),
			array('Instagram'		, 'publicInstagram'	, true	, 'text'	, ''),
			array('Pinterest'		, 'publicPinterest'	, true	, 'text'	, ''),
			array('LinkedIn'		, 'publicLinkedIn'	, true	, 'text'	, ''),
		);
		$sectionItems = array();
		foreach($possibleItems as $item)
		{
			$varName = $item[1];
			$value = $$varName;
			if($value != NULL) { array_push($sectionItems, $item); }
		}
		require 'php/profiles/section-items.php'; // outputs the items in the array
	echo '</div>'; // /.#contact-info .profile-section-content
} // end else public
?>