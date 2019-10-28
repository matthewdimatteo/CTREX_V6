<?php
/*
php/profiles/subscriber/section-bio.php
By Matthew DiMatteo, Children's Technology Review

This file defines the content for the 'Bio' section of the subscriber profile
It uses a custom output instead of including the file 'php/profiles/section-items.php'

This file handles both the 'private' (editable) and 'public' cases

This is one of multiple files for each profile section

Each of these files must follow the filename convention:
'section-' followed by the string used to define a section in the $sections array in php/profiles/content-profile-subscriber.php
*/

// FORMAT TEXT
if($bio != NULL) 				{ $bio 				= parseLinks(nl2br($bio)); }
if($expertSpecialty != NULL) 	{ $expertSpecialty 	= nl2br($expertSpecialty); }
if($expertBias != NULL) 		{ $expertBias 		= nl2br($expertBias); }
if($sendProductsTo != NULL) 	{ $sendProductsTo 	= nl2br($sendProductsTo); }
			
// PRIVATE (EDITABLE) PROFILE
if($inputMode == 'private')
{
	// FORM START (BIO)
	echo '<form name = "profile-update-form-subscriber-bio" method = "POST" action = "profile-update.php">';
	
		// BIO INFO
		echo '<div id = "bio-info" class = "profile-section-content">';

			// SECTION HEADER
			echo '<div class = "profile-section-header">Bio*<br/>(Visible on <a href = "'.$publicProfileURL.'">Public Profile</a> if Shared)</div>';

			// PHOTO/BIO CONTAINER
			echo '<div class = "profile-bio-container">';

				// PHOTO
				if($photo != NULL)
				{
					echo '<div class = "profile-bio-col" id = "bio-photo-col">';
						echo '<img src = "php/img.php?-url='.urlencode($photo).'" alt = "Subscriber Photo"/>';
					echo '</div>'; // /.profile-bio-col
				}

				// BIO TEXTAREA
				echo '<div class = "profile-bio-col" id = "bio-textarea-col">';
					echo '<textarea name = "bio" id = "bio" rows = "12">'.$bio.'</textarea>';
				echo '</div>'; // /.profile-bio-col
				
				// HIDDEN INPUTS
				echo '<input type = "hidden" name = "type" 		value = "subscriber" />';
				echo '<input type = "hidden" name = "section" 	value = "bio" />';

				// PADDING
				if($photo != NULL) { echo '<div class = "profile-bio-col" id = "bio-padding-col"></div>'; }


			echo '</div>'; // /.profile-bio-container

			// FOOTNOTE
			echo '<div class = "profile-section-footnote">';
				echo '*This information is only displayed on your public profile if the \'Share\' setting above is selected.<br/>';
				echo 'It is also used for any Dust or Magic events you attend.';
			echo '</div>'; // /.profile-section-footnote

			// UPDATE BTN
			echo '<div class = "profile-section-submit-btn">';
				echo '<input type = "submit" name = "update-bio-info" value = "Update this information" />';
			echo '</div>'; // /.#profile-section-submit-btn

			if($photo == NULL)
			{
				echo '<div class = "profile-section-header">';
					echo '<a href = "mailto:info@childrenstech.com">Send us a Photo</a>';
				echo '</div>'; // /.profile-section-header
			}

		echo '</div>'; // /#bio-info
		
	echo '</form>'; // FORM END (BIO)
	
	// EXPERT INFO
	if($expert == true)
	{
		// FORM START (EXPERT INFO)
		echo '<form name = "profile-update-form-subscriber-bio" method = "POST" action = "profile-update.php">';
	
			echo '<div id = "expert-info" class = "profile-section-content">';

				// SECTION HEADER
				echo '<div class = "profile-section-header">';
					echo 'Expert Info*';
				echo '</div>'; // /.profile-section-header

				// DEFINE THE TEXTAREA ITEMS
				$sectionItems = array
				(
					array('Area(s) of Expertise', 'expertSpecialty'	, true, 6, ''),
					array('Disclosed Bias'		, 'expertBias'		, true, 4, ''),
					array('Send Products To'	, 'sendProductsTo'	, true, 4, 'Specify an address if you wish to receive products for reviewing.')
				);
				
				// TEXTAREAS
				require 'php/profiles/section-textareas.php'; // outputs the items in the array
				
				// HIDDEN INPUTS
				echo '<input type = "hidden" name = "type" 		value = "subscriber" />';
				echo '<input type = "hidden" name = "section" 	value = "expert" />';

				// FOOTNOTE
				echo '<div class = "profile-section-footnote">';
					echo '*As a CTR Expert Reviewer, your public profile is shared by default.';
				echo '</div>'; // /.profile-section-footnote

				// UPDATE BTN
				echo '<div class = "profile-section-submit-btn">';
					echo '<input type = "submit" name = "update-expert-info" value = "Update this information" />';
				echo '</div>'; // /.#profile-section-submit-btn

			echo '</div>'; // /#bio-info
		
		echo '</form>'; // FORM END (EXPERT INFO)
		
	} // end if $expert
	
} // end if private

// PUBLIC PROFILE
else
{
	echo '<div id = "bio-info" class = "profile-section-content">';
	
		// PHOTO/BIO CONTAINER
		echo '<div class = "profile-bio-container">';
			
			echo '<div class = "profile-section-header"></div>'; // /.profile-section-header
			
			// PHOTO
			if($photo != NULL)
			{
				echo '<div class = "profile-bio-col" id = "bio-photo-col">';
					echo '<img src = "php/img.php?-url='.urlencode($photo).'" alt = "Subscriber Photo"/>';
				echo '</div>'; // /.profile-bio-col
			}
			
			// BIO TEXTAREA
			echo '<div class = "profile-bio-col" id = "bio-textarea-col">';
			if($bio != NULL) 	{ echo '<div class = "textarea-readonly">'.$bio.'</div>'; }
			else 				{ echo 'No bio on record'; }
			echo '</div>'; // /.profile-bio-col
			
			// PADDING
			if($photo != NULL) { echo '<div class = "profile-bio-col" id = "bio-padding-col"></div>'; }
			
		echo '</div>'; // /.profile-bio-container
		
	echo '</div>'; // /#bio-info
	
	// EXPERT INFO
	if($recordExpert == true)
	{
		echo '<div id = "expert-info" class = "profile-section-content">';
			
			// DEFINE THE TEXTAREA ITEMS
			$sectionItems = array();
			if($expertSpecialty != NULL) 	{ array_push($sectionItems, array('Area(s) of Expertise', 'expertSpecialty'	, false, 6, '')); }
			if($expertBias != NULL) 		{ array_push($sectionItems, array('Disclosed Bias'		, 'expertBias'		, false, 4, '')); }
			if($sendProductsTo != NULL) 	{ array_push($sectionItems, array('Send Products To'	, 'sendProductsTo'	, false, 4, '')); }
			if($sectionItems != NULL)		{ require 'php/profiles/section-textareas.php'; } // outputs the items in the array
			
		echo '</div>'; // /#bio-info
	} // end if $expert
}
?>