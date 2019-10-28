<?php
/*
php/savedsearch-output.php
By Matthew DiMatteo

This file outputs a user's saved searches as a list, including controls to rename, load, and delete each
It is included in 'php/profiles/subscriber/section-searches.php' and 'php/content/content-savedsearches.php' for inclusion on the profile and savedsearch pages
*/

$savedSearchN = 0; // declare a counter to define unique element ids
echo '<div class = "paragraph-90 left">'; // container for the list of saved searches

// determine which variable contains the array - profile page uses array defined in 'php/get-sub.php', while savedsearches page uses array accessed from session
if($thisPage == 'profile.php') 				{ $searchesArray = $savedSearchesArray; } 
else if($thisPage == 'savedsearches.php') 	{ $searchesArray = $savedSearches; }

// LIST OF SAVED SEARCHES
foreach($searchesArray as $savedSearch)
{
	// these values are set in 'php/get-sub.php'
	$savedSearchID 			= $savedSearch[0]; // record id of the saved search in the 'savedsearches' table - used for deletion
	$savedSearchURL 		= $savedSearch[1]; // the url of the search - used in hyperlink
	$savedSearchDescription = $savedSearch[2]; // the summary of the search criteria
	$savedSearchN += 1; // increment the counter for element ids

	// ROW FOR EACH SAVED SEARCH
	echo '<div class = "profile-section-row profile-saved-item-row">';

		// COL - DELETE BTN
		echo '<div class = "inline">';
			echo '<button type = "button" onclick = "savedSearchRemove('.$savedSearchID.')" title = "Delete this saved search">x</button>';
		echo '</div>';

		// COL - EDIT BTN
		echo '<div class = "inline">';
			echo '<button type = "button" id = "show-edit-saved-search-'.$savedSearchN.'" title = "Edit description" 
				onclick = "swapItemN(\'show-edit-saved-search-\', \'hide-edit-saved-search-\', \'saved-search-field-\', \'saved-search-link-\', '.$savedSearchN.')">Edit</button>';

			echo '<button type = "button" id = "hide-edit-saved-search-'.$savedSearchN.'" title = "Close" class = "hide"
				onclick = "swapItemN(\'hide-edit-saved-search-\', \'show-edit-saved-search-\', \'saved-search-link-\', \'saved-search-field-\', '.$savedSearchN.')">Edit</button>';
		echo '</div>';

		// COL - LINK/INPUT
		echo '<div class = "inline saved-item-label">';

			// LINK
			echo '<div class = "saved-item-link" id = "saved-search-link-'.$savedSearchN.'">';
				echo '<a href = "'.$savedSearchURL.'" title = "Load this search on the home page">'.$savedSearchDescription.'</a>';
			echo '</div>';

			// INPUT (FOR EDITING DESCRIPTION)
			echo '<div id = "saved-search-field-'.$savedSearchN.'" class = "hide">';
				echo '<div class = "saved-item-field inline">';
					echo '<input type = "text" id = "saved-search-description-'.$savedSearchN.'" value = "'.$savedSearchDescription.'"/>';
					echo '<input type = "hidden" id = "saved-search-id-'.$savedSearchN.'" value = "'.$savedSearchID.'"/>';
				echo '</div>'; // /.saved-search-field
				echo '<div class = "inline">';
					echo '<button type = "button" onclick = "savedSearchRename('.$savedSearchN.')">Rename</button>';
				echo '</div>';
			echo '</div>'; // /.hide

		echo '</div>'; // /.inline saved-item-label (link/input column)

	echo '</div>'; // /.profile-section-row

} // end foreach
echo '</div>'; // end .paragraph-90 left (container for list of saved searches)
?>