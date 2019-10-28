<?php
/*
php/form-fields-output.php
By Matthew DiMatteo, Children's Technology Review

This file is used to output the html elements that display a set of fields for a form using block element display
It is included for each set of fields in a section of a form in the content file for a form page (such as 'php/content/content-submit.php')

Within the content files for each of the form pages (such as 'php/content/content-contact.php'), arrays for each set of form fields must be specifies
These arrays should include an array for each field containing the values (label, name, value, type, required, note, width)
- label: 	the label for the field (not used in processing data - just for the user to see)
- name: 	used for both the name attribute of the input element and the variable name
- value:	the value attribute for the input element (this should be a php variable with a name identical to the name value)
- type:		the type attribute for the input element (such as text, number, hidden, email, etc.)
- required:	true/false boolean for whether the field is required
- note:		optional - will display a description in fine print beneath the field if specified
- width:	for inline fields only - the css class corresponding to the desired width of the field container element
*/
// output fields
if($fields != NULL)
{
	foreach($fields as $field)
	{
		$tabindex	+= 1;
		$label		= $field[0];
		$name		= $field[1];
		$value		= $field[2];
		$type		= $field[3];
		$required	= $field[4];
		$note		= $field[5];
		$labelClass = 'field-label';
		if($required == true) { $label = '*'.$label; $labelClass .= ' bold'; }
		if($type == 'hidden') { echo '<div class = "hide">'; }
		echo '<div class = "row">';
			echo '<div class = "field-label">'.$label.'</div>';
			echo '<div class = "field-container">';
				if($type == 'textarea')
				{
					echo '<textarea name = "'.$name.'" id = "'.$name.'" rows = "5" cols = "50" tabindex = "'.$tabindex.'">'.$value.'</textarea>';
				}
				else
				{
					echo '<input type = "'.$type.'" name = "'.$name.'" id = "'.$name.'" tabindex = "'.$tabindex.'" value = "'.$value.'" '; 
						if($required == true) { echo 'required '; }
					echo' />';
				}
				if($note != NULL) { echo '<div class = "field-footnote">'.$note.'</div>'; }
			echo '</div>'; // /.field-container
			echo '<div class = "field-note"></div>';
		echo '</div>'; // /.row
		if($type == 'hidden') { echo '</div>'; } // /.hide
	} // end foreach $fields as $field
} // end if $fields != NULL		
?>