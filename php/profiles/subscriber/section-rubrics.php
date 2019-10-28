<!--
php/profiles/subscriber/section-rubrics.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the Saved Rubrics section of the subscriber profile
The $savedRubricsArray contains records from the 'savedrubrics' table in the 'subbies.fmp12' database - it is defined in 'php/get-sub.php'
If the user has not saved any rubrics yet, a message explaining the feature is displayed instead
-->
<div class = "profile-section-content" id = "profile-section-rubrics">
<?php
// IF 1 OR MORE SAVED RUBRICS - DISPLAY EACH
if($numSavedRubrics > 0)
{
	// SECTION HEADER
	echo '<div class = "profile-section-header">';
		echo 'Saved Rubrics';
		if($inputMode == 'private')
		{
			echo '<br/>';
			echo '(Visible on <a href = "'.$previewLink.'">Public Profile</a> if Shared)';
		} // end if $inputMode == 'private'
	echo '</div>'; // /.profile-section-header
	
	require_once 'php/savedrubrics-output.php'; // output the list of saved rubrics with controls to rename, load, and delete
} // end if $numSavedRubrics > 0

// IF NO SAVED RUBRICS - DISPLAY A MESSAGE EXPLAINING FEATURE
else
{
	// DISPLAY ONLY ON PRIVATE (EDITABLE) PROFILE
	if($inputMode == 'private')
	{
		echo '<div class = "profile-section-header">Did you know you can create custom rubrics, saved to your CTREX profile?</div>';
		echo '<div class = "profile-section-content">';
			echo '<div class = "text-24 bottom-10"><a href = "rubric-create.php">Try it out!</a></div>';

		echo '</div>';
	} // end if input mode == private
} // end else no saved rubrics
?>
</div><!-- /.profile-section-content #profile-section-rubrics -->