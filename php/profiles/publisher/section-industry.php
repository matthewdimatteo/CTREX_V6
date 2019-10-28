<?php
/*
php/profiles/publisher/section-industry.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the content of the 'Industry Contact' tab of the Publisher Profile page
It is included dynamically in 'php/profiles/profile-sections.php'
Note: This tab only displays while in Edit Mode (or if the info has been made public through the Share option)
*/

// SECTION CONTAINER
echo '<div id = "industry-info" class = "profile-section-content">';
	
// EDIT MODE
if($inputMode == 'private')
{
	// SECTION HEADER
	echo '<div class = "profile-section-header">Industry Contact (Private unless shared)</div>'; // /.profile-section-header

	// SHARE/HIDE
	echo '<div id = "profile-options-container">';
		echo '<form name = "profile-update-form-publisher-privacy" method = "POST" action = "profile-update.php">';
			echo '<div class = "profile-options">';
				echo '<div id = "share-hide-container">';
					echo '<div class = "profile-options-btn">';
						echo '<input type = "radio" name = "share" id = "share" value = "share" '; 
							if($share == true) { echo 'checked'; } echo ' onchange = "this.form.submit()" />';
					echo '</div>';
					echo '<div class = "profile-options-label">Share</div>';
					echo '<div class = "profile-options-btn">';
						echo '<input type = "radio" name = "share" id = "hide" value = "hide" ';
							if($share != true) { echo 'checked'; } echo ' onchange = "this.form.submit()" />';
					echo '</div>';
					echo '<div class = "profile-options-label">Hide</div>';
				echo '</div>'; // /#share-hide-container
				echo '<input type = "hidden" name = "type" 		value = "publisher" />';
				echo '<input type = "hidden" name = "section" 	value = "privacy" />';
			echo '</div>'; // /.profile-options
		echo '</form>'; // /profile-update-form-subscriber-privacy
	echo '</div>'; // /#profile-options-container

	// FORM START
	echo '<form name = "profile-update-form-publisher-industry" method = "POST" action = "profile-update.php">';

		// SECTION ITEMS
		// array (label			, id/var			, edit	, type		, note)
		$sectionItems = array
		(
			array('First Name'		, 'contactFname'	, true	, 'text'	, ''),
			array('Last Name'		, 'contactLname'	, true	, 'text'	, ''),
			array('Contact Title'	, 'contactTitle'	, true	, 'text'	, ''),
			array('Contact Email'	, 'contactEmail'	, true	, 'email'	, ''),
		);

		// INPUT FIELDS
		require 'php/profiles/section-items.php'; // outputs the items in the array

		// HIDDEN INPUTS
		echo '<input type = "hidden" name = "type" 	value = "publisher" />';
		echo '<input type = "hidden" name = "section" value = "industry" />';

		// SUBMIT BTN
		echo '<div class = "profile-section-submit-btn">';
			echo '<input type = "submit" name = "update-industry-info" value = "Update this information" />';
		echo '</div>'; // /.profile-section-submit-btn

	echo '</form>'; // FORM END
} // end if($inputMode == 'private')

// PUBLIC PROFILE
else
{
	if($share == true)
	{
		$possibleItems = array
		(
			array('Contact First Name'	, 'contactFname'	, true	, 'text'	, ''),
			array('Contact Last Name'	, 'contactLname'	, true	, 'text'	, ''),
			array('Contact Title'		, 'contactTitle'	, true	, 'text'	, ''),
			array('Contact Email'		, 'contactEmail'	, true	, 'email'	, ''),
		);
		$sectionItems = array();
		foreach($possibleItems as $item)
		{
			$varName = $item[1];
			$value = $$varName;
			if($value != NULL) { array_push($sectionItems, $item); }
		}
		require 'php/profiles/section-items.php'; // outputs the items in the array
	} // end if $share == true
} // end else public

echo '</div>'; // /#industry-info .profile-section-content
?>