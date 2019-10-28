<?php
/*
php/rubric-select.php
By Matthew DiMatteo, Children's Technology Review

This file outputs a rubric select element (dropdown menu)
It handles whether to output all CTR rubrics or all of a user's saved rubrics via the $showSavedRubrics bool
- this value must be set to true before including this file in order to show saved rubrics
*/

// determine form id, select input name and id, and label for select element when no selection (based on whether outputting CTR or saved rubrics)
if($showSavedRubrics == true) 
{ 
	$formID				= 'saved-rubric-select-form';
	$selectInputName 	= 'saved-rubric';
	$selectInputID		= 'saved-rubric-selector';
	$defaultLabel 		= 'Select a Saved Rubric'; 
} 
else 
{ 
	$formID				= 'ctr-rubric-select-form';
	$selectInputName 	= 'rubric';
	$selectInputID		= 'ctr-rubric-selector';
	$defaultLabel 		= 'Select a CTR Rubric';
}

// output the rubric selection form, including select element and containing div elements
echo '<div class = "rubric">';
echo '<form name = "rubric-select-form" id = "'.$formID.'" method = "GET" action = "'.$thisURL.'#evaluate">';
	echo '<input type = "hidden" name = "id" value = "'.$reviewID.'" />';
	if($thisPage == 'editorial.php') 			{ echo '<input type = "hidden" name = "type" value = "'.$editType.'" />'; }
	if($thisPage == 'expert-review-edit.php') 	{ echo '<input type = "hidden" name = "expert-review-id" value = "'.$expertReviewID.'" />'; }
	echo '<div class = "dropdown-div">';
		echo '<select name = "'.$selectInputName.'" id = "'.$selectInputID.'" onchange = "this.form.submit()" class = "dropdown-select">';

			// if saved rubric
			if($showSavedRubrics == true)
			{
				if($savedRubricID != NULL)	{ echo '<option value = "">Clear</option>'; }
				else 						{ echo '<option value = "" selected>'.$defaultLabel.'</option>'; }
				
				foreach($savedRubrics as $savedRubricOption)
				{
					$rubricID	= $savedRubricOption[0];
					$rubricName = $savedRubricOption[1];
					
					echo '<option value = "'.$rubricID.'"'; 
						if($rubricID == $savedRubricID) { echo 'selected'; }
					echo ' >'.$rubricName.'</option>';	
				} // end foreach saved rubric option
			}// end if show saved rubrics
			
			// else ctr rubric
			else
			{
				if($ctrRubric != NULL)	{ echo '<option value = "">Clear</option>'; }
				else 					{ echo '<option value = "" selected>'.$defaultLabel.'</option>'; }
			
				$getSelectedRubric = '';		// reset boolean to tell 'php/find-rubrics.php' to lookup all active rubrics
				require 'php/find-rubrics.php';	// lookup all active rubrics and store data in array $rubricsList
				foreach($rubricsList as $thisRubric)
				{
					$rubricName = $thisRubric[0];
					echo '<option value = "'.$rubricName.'"'; 
						if($rubricName == $ctrRubric) { echo 'selected'; }
					echo ' >'.$rubricName.'</option>';	
				} // end foreach rubric
			} // end else show ctr rubrics
			
		echo '</select>'; // /.dropdown-select
	echo '</div>'; // /.dropdown-div
echo '</form>';
echo '</div>'; // /.rubric
$showSavedRubrics == ''; // reset this boolean to prevent it from carrying over
?>