<?php
/*
php/form-dropdown-output.php
By Matthew DiMatteo, Children's Technology Review

This file outputs an array of select elements, or dropdown menus
Value lists are defined in the file 'php/value-lists.php'
Before including this file, the $dropdownItems array must be declared with the format (label, input name, overall value, array of items)
The overall value refers to the value to check each dropdown's value against, to determine which option should be selected
*/
foreach($dropdownItems as $dropdownItem)
{
	$label 		= $dropdownItem[0];
	$name		= $dropdownItem[1];
	$value 		= $dropdownItem[2];
	$valueList	= $dropdownItem[3];
	if($label != NULL) { $label .':'; }
	
	// FORM ROW START
	echo '<div class = "row bottom-10">';
		echo '<div class = "field-label">'.$label.'</div>';
		echo '<div class = "field-container">';
		
			// SELECT ELEMENT START
			echo '<select name = "'.$name.'" id = "'.$name.'">';
			
				// IF NO VALUE, DISPLAY LABEL AS DEFAULT OPTION
				if($value == NULL) 
				{ 
					echo '<option value = "" selected>'.$label.'</option>'; 
				}
				
				// IF VALUE IS SPECIFIED BUT NOT IN VALUE LIST, ADD AN OPTION WITH THAT VALUE SELECTED, AS WELL AS A CLEAR OPTION
				else if($value != NULL and !in_array($value, $valueList))
				{ 
					echo '<option value = "'.$value.'" selected>'.$value.'</option>'; 
					echo '<option value = "" selected>Clear</option>';
				}
				
				// FOR ALL OTHER VALUES IN THE LIST, OUTPUT EACH AS OPTIONS, SELECTING IF MATCHES VALUE
				foreach($valueList as $option)
				{
					echo '<option value = "'.$option.'"';
					if($value == $option) { echo ' selected '; }
					echo '>'.$option.'</option>';
				} // end foreach $option
			echo '</select>';
			
		echo '</div>'; // /.field-container
		echo '<div class = "field-note"></div>';
	echo '</div>'; // /.row bottom-10
} // end foreach $dropdownItem
?>