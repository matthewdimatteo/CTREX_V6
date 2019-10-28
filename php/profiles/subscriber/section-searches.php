<!--
php/profiles/subscriber/section-searches.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the Saved Searches section of the subscriber profile
The $savedSearchesArray contains records from the 'savedsearches' table in the 'subbies.fmp12' database - it is defined in 'php/get-sub.php'
If the user has not saved any searches yet, a message explaining the feature is displayed instead
-->
<div class = "profile-section-content" id = "profile-section-searches">
<?php
// IF 1 OR MORE SAVED SEARCHES - DISPLAY EACH
if($numSavedSearches > 0)
{
	// SECTION HEADER
	echo '<div class = "profile-section-header">';
		echo 'Saved Searches';
		echo '<br/>';
		echo '(NOT Included on <a href = "'.$previewLink.'">Public Profile</a>)';
	echo '</div>'; // /.profile-section-header
	
	require_once 'php/savedsearches-output.php'; // output the list of saved searches with controls to rename, load, and delete
} // end if $numSavedSearches > 0

// IF NO SAVED SEARCHES - DISPLAY A MESSAGE EXPLAINING FEATURE
else
{
	echo '<div class = "profile-section-header">Did you know you can save searches to your CTREX profile?</div>';
	echo '<div class = "profile-section-content">';
		echo '<div class = "text-24 bottom-10"><a href = "'.$lastSearchReviews.'">Try it out!</a></div>';
		echo '<div class = "img-24 bottom-10">On the <a href = "'.$lastSearchReviews.'">home page</a>, select the <img src = "images/save.png" width = "24" height = "24" alt = "save"/> icon under the "More" tab - this will save your search!</div>';
		echo '<div id = "save-search-example"><img src = "images/save-search-example.png" alt = "example"/></div>';
	echo '</div>';
} // end else no saved searches
?>
</div><!-- /.profile-section-content #profile-section-searches -->