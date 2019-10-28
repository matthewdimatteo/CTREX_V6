<?php
/*
php/form-checkbox-output.php
By Matthew DiMatteo, Children's Technology Review

This file outputs an array of checkbox sets
Value lists are defined in the file 'php/value-lists.php'
Before including this file, the $checkboxSets array must be declared with the format (label, input name, overall value, array of items)
The overall value refers to the value to check each box's value against, to determine whether that box should be checked
*/
foreach($checkboxSets as $checkboxSet)
{
	// get the array values specified before the inclusion of this file
	$checkboxSetLabel 	= $checkboxSet[0]; // the label for the checkbox set
	$checkboxSetName	= $checkboxSet[1]; // the input name for the checkbox
	$checkboxSetValue	= $checkboxSet[2]; // the variable that stores the overall value of the input (to check against each checkbox item value)
	$checkboxSetItems	= $checkboxSet[3]; // the array of items to output as individual checkboxes
	
	// convert comma separated list string into an array for checking values against
	$checkboxSetValues	= str_replace(', ', ',', $checkboxSetValue); // remove spaces after commas
	$checkboxSetValues	= explode(', ', $checkboxSetValue); // convert string into an array
	
	// determine "other" values (items in list string that are not part of value list) to display in the "Other" field
	$otherValuesArray = array();
	$otherValuesList = '';
	foreach($checkboxSetValues as $thisCheckboxSetValue)
	{
		if(!in_array($thisCheckboxSetValue, $checkboxSetItems))
		{
			array_push($otherValuesArray, $thisCheckboxSetValue);
			if($otherValuesList != NULL) 	{ $otherValuesList .= ', '.$thisCheckboxSetValue; }
			else							{ $otherValuesList = $thisCheckboxSetValue; }
		} // end if !in_array
	} // end foreach $checkboxSetValues
	
	// output the the checkbox in a row
	echo '<div class = "row">';
		echo '<div class = "field-label">'.$checkboxSetLabel.'</div>';
		echo '<div class = "field-container">';
		
			foreach($checkboxSetItems as $checkboxItem)
			{
				$itemID = $checkboxSetName.'_'.str_replace(' ', '_', $checkboxItem);
				echo '<div class = "text-12">';
					echo '<div class = "inline right-10">';
						echo '<input type = "checkbox" name = "'.$checkboxSetName.'" id = "'.$itemID.'" value = "'.$checkboxItem.'" ';  
							//if(substr_count($checkboxSetValue, $checkboxItem) > 0) { echo 'checked '; }
							if(in_array($checkboxItem, $checkboxSetValues)) { echo 'checked '; }
							
							// update the hidden input
							echo 'onchange = "checkboxUpdate(\''.$itemID.'\', \''.$checkboxItem.'\', \''.$checkboxSetName.'\')"';
						echo '/>';
					echo '</div>'; // end checkbox col
					echo '<div class = "inline pointer">';
						echo '<div onclick = "checkboxSelect(\''.$itemID.'\', \''.$checkboxItem.'\', \''.$checkboxSetName.'\')">'.$checkboxItem.'</div>';
						//echo ' ($itemID: '.$itemID.')'; 
					echo'</div>'; // /.inline
				echo '</div>'; // end checkbox row
			} // end foreach $platformItem
			
		echo '</div>'; //<!-- /.field-container -->
		echo '<div class = "field-note">';
			//echo $checkboxSetValue;
		echo '</div>'; // /.field-note
		
		// HIDDEN INPUT WITH ID MATCHING CHECKBOX INPUT NAME
		//echo '<div class = "block"><input type = "text" id = "'.$checkboxSetName.'" value = "'.$checkboxSetValue.'"/></div>';
		echo '<div class = "hide"><input type = "hidden" id = "'.$checkboxSetName.'" value = "'.$checkboxSetValue.'"/></div>';
	echo '</div>'; //<!-- /.row -->
	
	// OTHER
	echo '<div class = "row top-5">';
		echo '<div class = "field-label">Other</div>';
		echo '<div class = "field-container">';
			echo '<input type = "text" name = "'.$checkboxSetName.'Other" id = "'.$checkboxSetName.'Other" value = "'.$otherValuesList.'"/>';
			//echo $checkboxSetName.'Other';
		echo '</div>'; //<!-- /.field-container -->
	echo '</div>'; //<!-- /.row -->
	echo '<br/>';
} // end foreach $checkboxSet

?>