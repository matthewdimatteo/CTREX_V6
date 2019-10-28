<?php
/*
php/result-item-savedbookmark.php
By Matthew DiMatteo, Children's Technology Review

This file outputs an individual bookmarked review in the results feed on the bookmarks page
It is included in 'php/content/content-savedbookmarks.php'
*/
require 'php/result-item-text.php'; // handles text trimming and hover text
$reviewLink = 'review.php?id='.$reviewnumber;

echo '<div class = "result-item">';

	// IMAGE
	echo '<a href = "'.$reviewLink.'" title = "Read our review of '.$title.'">';
	echo '<div class = "result-item-image">';
		if($thumbdata != NULL and $thumbdata != '?') 	{ echo '<img src = "php/img.php?-url='.urlencode($thumbnail).'" >';	}
		else 											{ echo '<div class = "no-image"><div class = "no-image-text">Image not available</div></div>'; }
	echo '</div>'; // /.result-item-image
	echo '</a>';
	
	// BODY
	echo '<div class = "result-item-text">';
	
		// HEADING
		echo '<div class = "result-item-heading">';
		
			// BOOKMARK ICON
			echo '<div class = "result-item-heading-bookmark" title = "Remove this bookmark">';
				echo '<img src = "images/bookmark-full.png" onclick = "bookmarkRemove('.$bookmarkID.')"/>';
			echo '</div>'; // /.result-item-heading-bookmark
			
			// TITLE - vars for different screen widths calculated in 'php/result-item-text.php'
			echo '<a href = "'.$reviewLink.'" title = "'.$reviewHover.'">';
				echo '<div class = "result-item-heading-title">';
					echo '<div class = "show-only-desktop">'.$titleText.'</div>';
					echo '<div class = "show-only-1025">'.$titleText1025.'</div>';
					echo '<div class = "show-only-769">'.$titleText769.'</div>';
					echo '<div class = "show-only-480">'.$titleText480.'</div>';
				echo '</div>'; // /.result-item-heading-title
			echo '</a>';
			
		echo '</div>'; // /.result-item-heading
		
		// REVIEW LINK START
		echo '<a href = "'.$reviewLink.'" title = "'.$reviewHover.'">';
		
		// INFO
		echo '<div class = "result-item-info">';
		
			// COPYRIGHT, COMPANY
			echo '<div class = "result-item-copyright full-width">';
				echo '<div class = "inline right-2">&copy;'.' '.$copyright.' '.$companyText.'</div>';
			echo '</div>'; // /.result-item-copyright
			
			// PLATFORM/AGES/SUBJECT
			require 'php/result-item-info.php';
			
		echo '</div>'; // /.result-item-info
		
	echo '</div>'; // /.result-item-text
	
echo '</div>'; // /.result-item
echo '</a>'; // REVIEW LINK END

// MOVE TO FOLDER
if($numBookmarkFolders > 0)
{
	echo '<div class = "move-to-folder">';
		echo '<select name = "bookmark-folder" id = "select-bookmark-'.$bookmarkID.'" onchange = "moveBookmark(\''.$bookmarkID.'\')"/>';
			echo '<option value = "'.$folderID.'" selected>Move to folder</option>';
			echo '<option value = "">Uncategorized</option>';
			foreach($bookmarkFolders as $selectBookmarkFolder)
			{
				$selectBookmarkFolderID 	= $selectBookmarkFolder[0];
				$selectBookmarkFolderName 	= $selectBookmarkFolder[1];
				echo '<option value = "'.$selectBookmarkFolderID.'">'.$selectBookmarkFolderName.'</option>';
			} // end foreach folder
		echo '</select>';
	echo '</div>'; // /.bottom-10
} // end if $numBookmarkFolders > 0
?>
