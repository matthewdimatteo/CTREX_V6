<?php
/*
php/save-item-confirmation.php
By Matthew DiMatteo, Children's Technology Review

This file outputs a confirmation message (in green text) at the top of the search area after a search or bookmark has been saved or removed
It is included in the files 'php/search-reviews.php' and 'php/content/content-rubric-create.php'

The files 'savesearch.php' and 'savebookmark.php' process the form submission and handle database updates, while also setting flags to display messages
This file checks and also resets each flag, displaying a message if the stored $_SESSION value for the flag was true
*/

// SAVED SEARCH CONFIRMATION
$savedSearchStatus = $_SESSION['saved-search-confirmation']; // check the flag (set in 'savesearch.php')
$_SESSION['saved-search-confirmation'] = ''; // reset the flag
if($savedSearchStatus == true)
{
	echo '<div class = "results-heading search-confirmation"><div class = "confirmation-message text-24">Search saved successfully!</div></div>';
}

// SAVED BOOKMARK CONFIRMATION
$savedBookmarkStatus = $_SESSION['saved-bookmark-confirmation']; // check the flag (set in 'savebookmark.php')
$_SESSION['saved-bookmark-confirmation'] = ''; // reset the flag
if($savedBookmarkStatus == true)
{
	echo '<div class = "results-heading search-confirmation"><div class = "confirmation-message text-24">Bookmark saved successfully!</div></div>';
}

// REMOVED BOOKMARK CONFIRMATION
$removedBookmarkStatus = $_SESSION['removed-bookmark-confirmation']; // check the flag (set in 'savebookmark.php')
$_SESSION['removed-bookmark-confirmation'] = ''; // reset the flag
if($removedBookmarkStatus == true)
{
	echo '<div class = "results-heading search-confirmation"><div class = "confirmation-message text-24">Bookmark removed successfully</div></div>';
}

// SAVED RUBRIC CONFIRMATION
$savedRubricStatus = $_SESSION['saved-rubric-confirmation']; // check the flag (set in 'saverubric.php')
$_SESSION['saved-rubric-confirmation'] = ''; // reset the flag
if($savedRubricStatus == true)
{
	echo '<div class = "results-heading search-confirmation"><div class = "confirmation-message text-24">Rubric saved successfully!</div></div>';
}
?>