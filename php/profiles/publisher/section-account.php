<?php
/*
php/profiles/publisher/section-account.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the content of the 'Account Login' tab of the Publisher Profile page
It is included dynamically in 'php/profiles/profile-sections.php'
Note: This tab only displays while in Edit Mode
*/

// EDIT MODE
if($inputMode == 'private')
{
	// SECTION CONTAINER
	echo '<div id = "account-info" class = "profile-section-content">';

		// SECTION HEADER -->
		echo '<div class = "profile-section-header">Publisher Account Login Credentials (Private)</div>'; // /.profile-section-header

		// FORM START -->
		echo '<form name = "profile-update-form-publisher-account" method = "POST" action = "profile-update.php">';

			// SECTION ITEMS
			// array (label			, id/var			, edit	, type		, note)
			$sectionItems = array
			(
				array('Username'	, 'ctrexUsername'	, false	, 'text'	, ''),
				array('Password'	, 'ctrexPassword'	, true	, 'text'	, '')
			);

			// INPUT FIELDS
			require 'php/profiles/section-items.php'; // outputs the items in the array

			// HIDDEN INPUTS -->
			echo '<input type = "hidden" name = "type" 	value = "publisher" />';
			echo '<input type = "hidden" name = "section" value = "account" />';

			// SUBMIT BTN -->
			echo '<div class = "profile-section-submit-btn">';
				echo '<input type = "submit" name = "update-account-info" value = "Update Password" />';
			echo '</div>'; // /.profile-section-submit-btn

			// FOOTNOTE
			echo '<div class = "profile-section-footnote">';
				echo 'Your login information is private, and only visible to you on this profile page while in Edit Mode.<br/>';
				echo 'To change your company name or username, <a href = "contact.php">contact us</a>.';
			echo '</div>'; // /.profile-section-footnote

		echo '</form>'; // FORM END

	echo '</div>'; // /#account-info .profile-section-content
	} // end if($inputMode == 'private')
?>	