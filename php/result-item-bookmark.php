<?php
/*
php/result-item-bookmark.php
By Matthew DiMatteo, Children's Technology Review

This file determines the hover text, image filename, and button function for the bookmark icon of a review search result item and outputs the button
It is includes in the file 'php/result-item.php'
*/

// CALCULATE BOOKMARK HOVER TEXT, IMG SRC, ONCLICK FUNCTION BASED ON LOGIN, BOOKMARK STATUS
$bookmarkHover = 'Bookmark this review to your CTREX Profile';

// IF NOT LOGGED IN WITH A USER PROFILE
if($subscriber != true) 
{ 
	$bookmarkIcon = 'images/bookmark-empty.png';
	$bookmarkHover = 'Log in as a subscriber to '.lcfirst($bookmarkHover);
	$bookmarkFunction = 'bookmarkVelvet(\'velvet-bookmark-'.$recordN.'\')';
}

// IF LOGGED IN WITH USER PROFILE
else
{
	if($bookmarked == true) 
	{ 
		$bookmarkIcon = 'images/bookmark-full.png';
		$bookmarkFunction = 'bookmarkRemove('.$bookmarkID.')';
		$bookmarkHover = 'Remove this bookmark';
	}
	else
	{
		$bookmarkIcon = 'images/bookmark-empty.png';
		$bookmarkFunction = 'bookmarkAdd('.$reviewnumber.')';
	}
} // end else logged in with profile

// OUTPUT THE ICON ON THE SEARCH PAGE
if($pageType == 'search')
{

	// BOOKMARK ICON
	echo '<div class = "result-item-heading-bookmark" title = "'.$bookmarkHover.'">';
		echo '<img src = "'.$bookmarkIcon.'" onclick = "'.$bookmarkFunction.'"/>';
} // end if $pageType == search

// ON THE REVIEW PAGE, THE ICON IS ALREADY OUTPUT AS PART OF AN ARRAY OF SHARE BTNS, SO DON'T OUTPUT
else
{
	echo '<div>'; // only output a nondescript div on the review page
}
		// VELVET POPUP
		echo '<div class = "hide velvet-bookmark" id = "velvet-bookmark-'.$recordN.'">';
			echo '<div class = "popup">';
				echo '<div class = "inline right-2">';
					echo '<button type = "button" onclick = "document.getElementById(\'velvet-bookmark-'.$recordN.'\').style.display=\'none\';">x</button>';
				echo '</div>'; // /.inline
				echo '<div class = "inline">';
					echo '<div id = "velvet-rope-popup-content-'.$recordN.'">';
						echo '<a href = "login.php?target=bookmark">Log in as a subscriber to bookmark this review</a>';
					echo '</div>'; // /#velvet-rope-popup-content.$recordN
				echo '</div>'; // /.inline
			echo '</div>';
		echo '</div>'; // /.hide

	echo '</div>'; // close .result-item-heading-bookmark on search page, nondescript div on review page
?>