<?php
/*
php/profiles/publisher/section-description.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the content of the 'Description' tab of the Publisher Profile page
It is included dynamically in 'php/profiles/profile-sections.php'
*/

// SECTION CONTAINER
echo '<div id = "description-info" class = "profile-section-content">';
	
// EDIT MODE
if($inputMode == 'private')
{
	// SECTION HEADER
	echo '<div class = "profile-section-header">Company Description (Public)</div>'; // /.profile-section-header

	// FORM START
	echo '<form name = "profile-update-form-publisher-description" method = "POST" action = "profile-update.php">';

		// TEXTAREA
		echo '<div class = "profile-textarea-container">';
			echo '<div class = "company-description-private">';
				echo '<textarea name = "description" rows = "8" placeholder = "Add a description...">'.$description.'</textarea>';
			echo '</div>'; // /.company-description-private
		echo '</div>'; // /.profile-textarea-container

		// HIDDEN INPUTS
		echo '<input type = "hidden" name = "type" 	value = "publisher" />';
		echo '<input type = "hidden" name = "section" value = "description" />';

		// SUBMIT BTN
		echo '<div class = "profile-section-submit-btn">';
			echo '<input type = "submit" name = "update-description-info" value = "Update description" />';
		echo '</div>'; // /.profile-section-submit-btn

	echo '</form>'; // FORM END

}// end if($inputMode == 'private')

// PUBLIC PROFILE
else
{
	if($description != NULL)
	{
		echo '<div class = "paragraph-90 left">';
			echo '<div class = "company-description-public">'.$description.'</div>';
		echo '</div>'; // /.profile-textarea-container
	} // end if $description
} // end else public

echo '</div>'; // /#description-info .profile-section-content
?>