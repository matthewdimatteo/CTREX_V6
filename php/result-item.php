<?php
/*
php/result-item.php
By Matthew DiMatteo, Children's Technology Review

This file outputs an individual review in the results feed on the home page
It is included in 'php/search-reviews.php'

There are CSS rules defined in 'css/main.css' to allow for the container to be highlighted on hover
The $reviewLink value is defined in 'php/get-review.php' to concatenate the review's id number onto the 'review.php?id=' string

The <a> tag placement is set to allow for the bookmark icon and velvet rope login button to escape the coverage and perform onclick operations
*/
require 'php/result-item-text.php'; // handles text values for non-relevance sorted sets, text trimming, and hover text

echo '<div class = "result-item">';
	
	// IMAGE
	echo '<a href = "'.$reviewLink.'" title = "'.$reviewHover.'">';
	echo '<div class = "result-item-image">';
			if($thumbdata != NULL and $thumbdata != '?') 	{ echo '<img src = "php/img.php?-url='.urlencode($thumbnail).'" alt = "Image not available">';	}
			else 											{ echo '<div class = "no-image"><div class = "no-image-text">Image not available</div></div>'; }
	echo '</div>'; // /.result-item-image
	echo '</a>'; 
	
	// BODY
	echo '<div class = "result-item-text">';
	
		// HEADING
		echo '<div class = "'.$resultItemClass.'">'; // $resultItemClass determined in 'php/get-review.php' based on $published (blue=published, grey=draft)
		
			// BOOKMARK ICON
			require 'php/result-item-bookmark.php'; // determines hover text, img src, btn function
			
			// TITLE - vars for different screen widths calculated in 'php/result-item-text.php'
			echo '<a href = "'.$reviewLink.'" title = "'.$reviewHover.'">';
				echo '<div class = "result-item-heading-title">';
					echo '<div class = "show-only-desktop">'.$titleText.'</div>';
					echo '<div class = "show-only-1025">'.$titleText1025.'</div>';
					echo '<div class = "show-only-769">'.$titleText769.'</div>';
					echo '<div class = "show-only-480">'.$titleText480.'</div>';
				echo '</div>';
			echo '</a>';
			
		echo '</div>'; // /.$resultItemClass
		
		// REVIEW LINK START
		echo '<a href = "'.$reviewLink.'" title = "'.$reviewHover.'">';
		
		// INFO
		echo '<div class = "result-item-info">';
		
			// COPYRIGHT, COMPANY
			echo '<div class = "result-item-copyright full-width">';
				echo '<div class = "inline right-2">&copy;'.' '.$copyright.' '.$companyText.'</div>';
				/*	
				// TOGGLE
				echo '<div class = "inline">';
					echo '<div id = "show-company-links-'.$recordN.'" title = "Show company links" onclick = "showItemN(\'show-company-links-\', \'hide-company-links-\', \'company-links-\', '.$recordN.')">&#9660</div>';
					echo '<div id = "hide-company-links-'.$recordN.'" title = "Hide company links" class = "hide"
						onclick = "hideItemN(\'show-company-links-\', \'hide-company-links-\', \'company-links-\', '.$recordN.')">&#9650</div>';
				echo '</div>'; // /.inline
				*/
			echo '</div>'; // /.result-item-copyright
		echo '</a>'; // END REVIEW LINK BEFORE COMPANY LINKS
		
		if($producer != NULL)
		{
			// COMPANY LINKS
			echo '<div class = "result-item-company-links-container">';
				require 'php/company-links.php';
			echo '</div>'; // /.result-item-company-links-container
		} // end if $producer != NULL
		
		// RESTART REVIEW LINK AFTER COMPANY LINKS
		echo '<a href = "'.$reviewLink.'" title = "'.$reviewHover.'">';
			
			if($producer != NULL)
			{
				echo '<div class = "result-item-company-links-padding"></div>'; // padding to extend area of review hyperlink to the right of company links
			} // end if $producer != NULL
			
			// PLATFORM/AGES/SUBJECT
			require 'php/result-item-info.php';
			
		echo '</div>'; // /.result-item-info
		
		// RATING
		if($rated == true)
		{
			echo '</a>'; // END REVIEW LINK BEFORE RATING

			echo '<div class = "result-item-rating-container">';
				require 'php/result-item-rating.php';
			echo '</div>';

			// RESTART REVIEW LINK AFTER RATING
			echo '<a href = "'.$reviewLink.'" title = "'.$reviewHover.'">';
			echo '<div class = "result-item-rating-padding"></div>'; // padding to extend area of review hyperlink to the right of rating
		} // end if $rated
		
		// RELEVANCE
		echo '<div class = "result-item-info result-item-context">';
			if($sortedRecordRelevance != NULL) 
			{ 
				//echo $sortedN.'. ';
				//echo 'Relevance: '.$sortedRecordRelevance; 
				require 'php/result-item-context.php'; // display the context of the search term match in the body of the review
			} // end if relevance
			//echo '<br/># Keywords: '.$sortedRecordNumKeywords;
		echo '</div>';
		
	echo '</div>'; // /.result-item-text
	
echo '</div>'; // /.result-item
echo '</a>'; 

?>