<?php
/*
php/form-fields-output-inline.php
By Matthew DiMatteo, Children's Technology Review

This file is used to output the html elements that display a set of fields for a form using inline element display
It is included for each set of fields in a section of a form in the content file for a form page (such as 'php/content/content-license-order.php')

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
		$width		= $field[6];
		$labelClass = 'field-label';
		if($required == true) { $label = '*'.$label; $labelClass .= ' bold'; }
		if($type == 'hidden') { echo '<div class = "hide">'; }
		
		echo '<div class = "inline right-20 '.$width.'">';	
			echo '<div class = "text-14">'.$label.':</div>';
			echo '<div><input type = "'.$type.'" name = "'.$name.'" value = "'.$value.'"'; if($required == true) { echo 'required'; } echo '/></div>';
		echo '</div>';
		
		
		if($type == 'hidden') { echo '</div>'; } // /.hide
	} // end foreach $fields as $field
} // end if $fields != NULL		
?>