<!--
php/profiles/subscriber/section-bookmarks.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the Saved Bookmarks section of the subscriber profile
-->

<div class = "profile-section-content" id = "profile-section-bookmarks">
<?php
// IF 1 OR MORE SAVED BOOKMARKS - DISPLAY EACH
if($numSavedBookmarks > 0)
{
	// SECTION HEADER
	echo '<div class = "profile-section-header">';
		echo 'Saved Bookmarks';
		echo '<br/>';
		echo '(NOT Included on <a href = "'.$previewLink.'">Public Profile</a>)';
	echo '</div>'; // /.profile-section-header
	
	// OPTIONS
	echo '<div id = "bookmark-options">';
		
		// MANAGE
		echo '<div class = "inline left-5 right-5">';
			echo '<button type = "button" onclick = "window.location.href = \'savedbookmarks.php\';">Manage</button>';
		echo '</div>'; // /.inline left-5 right-5
		
		require_once 'php/bookmark-options.php'; // print/export btns
		
		// DELETE ALL
		echo '<div class = "inline left-5 right-5">';
			echo '<button type = "button" onclick = "bookmarkDeleteAll();">Delete All</button>';
		echo '</div>'; // /.inline left-5 right-5
		
	echo '</div>'; // /#bookmark-options
	
	$savedBookmarkN = 0; // declare a counter to define unique element ids
	echo '<div class = "paragraph-90 left">'; // container for the list of saved bookmarks
	foreach($savedBookmarksArray as $savedBookmark)
	{
		$savedBookmarkID			= $savedBookmark[0];
		$savedBookmarkReviewID		= $savedBookmark[1];
		$savedBookmarkTitle			= $savedBookmark[2];
		$savedBookmarkURL 			= 'review.php?id='.$savedBookmarkReviewID;
		$savedBookmarkN += 1;
		
		// ROW FOR EACH SAVED BOOKMARK
		echo '<div class = "profile-section-row profile-saved-item-row">';
		
			// COL - DELETE BTN
			echo '<div class = "inline">';
				echo '<button type = "button" onclick = "bookmarkRemove('.$savedBookmarkID.')" title = "Delete this saved bookmark">x</button>';
			echo '</div>';
			
			// COL - LINK
			echo '<div class = "inline saved-item-label">';
				echo '<div class = "saved-item-link">';
					echo '<a href = "'.$savedBookmarkURL.'" title = "See the review for '.$savedBookmarkTitle.'">'.$savedBookmarkTitle.'</a>';
				echo '</div>';	
			echo '</div>'; // /.inline saved-item-label (link/input column)
			
		echo '</div>'; // /.profile-section-row
		
	} // end foreach
	echo '</div>'; // /.paragraph-90 left
} // end if $numSavedBookmarks > 0

// IF NO SAVED BOOKMARKS - DISPLAY A MESSAGE EXPLAINING FEATURE
else
{
	echo '<div class = "profile-section-header">Did you know you can bookmark reviews to your CTREX profile?</div>';
	echo '<div class = "profile-section-content">';
		echo '<div class = "text-24 bottom-10"><a href = "'.$lastSearchReviews.'">Try it out!</a></div>';
		echo '<div class = "img-24 bottom-10">';
			echo 'On the <a href = "'.$lastSearchReviews.'">home page</a>, select the <img src = "images/bookmark-empty.png" width = "16" height = "24" alt = "bookmark"/> icon in the heading for a review - this will bookmark that review to your profile!<br/>';
			echo 'Reviews you have bookmarked will display with the <img src = "images/bookmark-full.png" width = "16" height = "24" alt = "full bookmark"/> icon.<br/>';
			echo 'You can remove a bookmark at any time by selecting this icon, or from this section of your profile page.';
		echo '</div>';
		//echo '<div id = "save-search-example"><img src = "images/save-search-example.png" alt = "example"/></div>';
	echo '</div>';
} // end else no saved bookmarks
?>
</div><!-- /.profile-section-content #profile-section-bookmarks -->