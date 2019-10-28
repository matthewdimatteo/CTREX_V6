<?php
/*
php/content-savedrubrics.php
By Matthew DiMatteo, Children's Technology Review

This file displays a user's saved rubrics if they have any
Here, the user can rename, delete, and load saved rubrics as they would on their profile page
*/

if($subscriber != true) { $redirect = 'subscribe.php'; require_once 'php/redirect.php'; exit(); } // only allow access to page if logged in as a subscriber

// ADD USERNAME TO PAGE TITLE
if($username != NULL)
{
	if($pageTitle == NULL) { $pageTitle = 'CTREX Profile'; }
	$pageTitle .= ' - '.$username;
	echo '<script>setPageTitle(\''.$pageTitle.'\');</script>';
} // end if $username

require_once 'php/save-item-forms.php'; // forms for updating saved items (searches, bookmarks, rubrics)
echo '<div class = "page-header">Your Saved Rubrics'; if($numSavedRubrics > 0) { echo ' ('.$numSavedRubrics.')'; } echo '</div>'; // /.page-header
	
// IF 1 OR MORE SAVED RUBRICS - DISPLAY EACH
if($numSavedRubrics > 0)
{	
	require_once 'php/savedrubrics-output.php'; // output the list of saved rubrics with controls to rename, load, and delete
} // end if $numSavedRubrics > 0

// IF NO SAVED RUBRICS - DISPLAY A MESSAGE EXPLAINING FEATURE
else
{
	echo '<div class = "subheader">Did you know you can create custom rubrics, saved to your CTREX profile?</div>';
	echo '<div class = "profile-section-content">';
		echo '<div class = "text-24 bottom-10"><a href = "rubric-create.php">Try it out!</a></div>';

	echo '</div>';
} // end else no saved rubrics
?>