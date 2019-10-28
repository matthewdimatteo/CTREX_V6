<?php
/*
php/savedrubric-output.php
By Matthew DiMatteo

This file outputs a user's saved rubrics as a list, including controls to rename, load, and delete each
It is included in 'php/profiles/subscriber/section-rubrics.php' and 'php/content/content-savedrubrics.php' for inclusion on the profile and savedrubric pages
*/
$savedRubricN = 0; // declare a counter to define unique element ids
echo '<div class = "paragraph-90 left">'; // container for the list of saved rubrics

// determine which variable contains the array - profile page uses array defined in 'php/get-sub.php', while savedrubrics page uses array accessed from session
if($thisPage == 'profile.php') 				{ $rubricsArray = $savedRubricsArray; } 
else if($thisPage == 'savedrubrics.php') 	{ $rubricsArray = $savedRubrics; }

// LIST OF SAVED RUBRICS
foreach($rubricsArray as $savedRubric)
{
	// these values are set in 'php/get-sub.php'
	$savedRubricID 			= $savedRubric[0]; // record id of the saved rubric in the 'savedrubrics' table - used for loading, editing, or deleting
	$savedRubricName 		= $savedRubric[1]; // the rubric name
	$savedRubricDescription = $savedRubric[2]; // the description of the rubric
	$savedRubricQANames 	= $savedRubric[3]; // the string of quality attribute names
	$savedRubricQAFields 	= $savedRubric[4]; // the string of quality attribute rating field names
	$savedRubricN += 1; // increment the counter for element ids

	// ROW FOR EACH SAVED RUBRIC
	echo '<div class = "profile-section-row profile-saved-item-row">';

		// DISPLAY EDIT BTNS ON PRIVATE (EDITABLE) PROFILE
		if($inputMode == 'private' or $thisPage == 'savedrubrics.php')
		{
			// COL - DELETE BTN
			echo '<div class = "inline">';
				echo '<button type = "button" onclick = "savedRubricRemove('.$savedRubricID.')" title = "Delete this saved rubric">x</button>';
			echo '</div>';

			// COL - EDIT BTN
			echo '<div class = "inline">';
				echo '<button type = "button" id = "show-edit-saved-rubric-'.$savedRubricN.'" title = "Edit description" 
					onclick = "swapItemN(\'show-edit-saved-rubric-\', \'hide-edit-saved-rubric-\', \'saved-rubric-field-\', \'saved-rubric-link-\', '.$savedRubricN.')">Options</button>';

				echo '<button type = "button" id = "hide-edit-saved-rubric-'.$savedRubricN.'" title = "Close" class = "hide"
					onclick = "swapItemN(\'hide-edit-saved-rubric-\', \'show-edit-saved-rubric-\', \'saved-rubric-link-\', \'saved-rubric-field-\', '.$savedRubricN.')">Options</button>';
			echo '</div>';
		} // end if input mode == private

		// COL - LINK/EDITING OPTIONS
		echo '<div class = "inline saved-item-label">';

			// LINK TO LOAD RUBRIC ON EVALUATION PAGE
			echo '<div class = "saved-item-link" id = "saved-rubric-link-'.$savedRubricN.'">';
				echo '<a href = "rubrics.php?rubric-id='.$savedRubricID.'" title = "Load this rubric">'.$savedRubricName.'</a>';
			echo '</div>';

			// DISPLAY EDITING CONTROLS ON PRIVATE (EDITABLE) PROFILE
			if($inputMode == 'private' or $thisPage == 'savedrubrics.php')
			{

				// EDITING OPTIONS - NAME, DESCRIPTION, QA
				echo '<div id = "saved-rubric-field-'.$savedRubricN.'" class = "hide">';

					// NAME
					echo '<div>';
						echo '<div class = "saved-item-field inline">';
							echo '<input type = "text" id = "saved-rubric-name-'.$savedRubricN.'" value = "'.$savedRubricName.'"/>';
						echo '</div>'; // /.saved-item-field inline
						echo '<div class = "inline">';
							echo '<button type = "button" onclick = "savedRubricUpdate('.$savedRubricN.')">Update</button>';
							echo '<input type = "hidden" id = "saved-rubric-id-'.$savedRubricN.'" value = "'.$savedRubricID.'"/>';
							echo '<input type = "hidden" id = "saved-rubric-qa-names-'.$savedRubricN.'" value = "'.$savedRubricQANames.'"/>';
							echo '<input type = "hidden" id = "saved-rubric-qa-fields-'.$savedRubricN.'" value = "'.$savedRubricQAFields.'"/>';
						echo '</div>'; // /.inline
					echo '</div>'; // /name row

					// DESCRIPTION
					echo '<div>';
						echo '<div class = "saved-item-field inline">';
							echo '<textarea id = "saved-rubric-description-'.$savedRubricN.'" placeholder = "Add a description">'.$savedRubricDescription.'</textarea>';
						echo '</div>'; // /.saved-item-field inline
						echo '<div class = "inline">';
							echo '<button type = "button" onclick = "savedRubricUpdate('.$savedRubricN.')">Update</button>';
						echo '</div>'; // /.inline
					echo '</div>'; // /description row

					// QA
					$loadRubricURL = 'rubric-create.php?rubric-id='.$savedRubricID;
					echo '<div>';
						echo '<div class = "saved-item-field inline">';
							echo 'Quality Attributes: <a href = "'.$loadRubricURL.'">'.$savedRubricQANames.'</a>';
						echo '</div>'; // /.saved-item-field inline
						echo '<div class = "inline">';
							echo '<button type = "button" onclick = "openURL(\''.$loadRubricURL.'\')">Edit QA</button>';
						echo '</div>'; // /.inline
					echo '</div>'; // /qa row

				echo '</div>'; // /.hide
			} // end if input mode == private

		echo '</div>'; // /.inline saved-item-label (link/input column)

	echo '</div>'; // /.profile-section-row

} // end foreach
echo '</div>'; // end .paragraph-90 left (container for list of saved rubrics)
?>