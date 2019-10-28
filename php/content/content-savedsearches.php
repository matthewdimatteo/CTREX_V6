<?php
/*
php/content/content-savedsearches.php
By Matthew DiMatteo, Children's Technology Review

This file displays a user's saved searches if they have any
Here, the user can rename, delete, and load saved searches as they would on their profile page
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
echo '<div class = "page-header">Your Saved Searches'; if($numSavedSearches > 0) { echo ' ('.$numSavedSearches.')'; } echo'</div>'; // /.page-header 
	
// IF 1 OR MORE SAVED SEARCHES - DISPLAY EACH
if($numSavedSearches > 0)
{
	require_once 'php/savedsearches-output.php'; // output the list of saved searches with controls to rename, load, and delete
} // end if $numSavedSearches > 0

// IF NO SAVED SEARCHES - DISPLAY A MESSAGE EXPLAINING FEATURE
else
{
	echo '<div class = "subheader">Did you know you can save searches to your CTREX profile?</div>';
	echo '<div class = "profile-section-content">';
		echo '<div class = "text-24 bottom-10"><a href = "'.$lastSearchReviews.'">Try it out!</a></div>';
		echo '<div class = "img-24 bottom-10">On the <a href = "'.$lastSearchReviews.'">home page</a>, select the <img src = "images/save.png" width = "24" height = "24" alt = "save"/> icon under the "More" tab - this will save your search!</div>';
		//echo '<div id = "save-search-example"><img src = "images/save-search-example.png" alt = "example"/></div>';
	echo '</div>';
} // end else no saved searches
?>