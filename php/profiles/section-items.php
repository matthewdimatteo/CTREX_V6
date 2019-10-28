<?php
/*
section-items.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the individual fields on a profile section
It should be included in the files for each section (such as 'php/profiles/subscriber/section-contact.php')
In those files, before including this file, an array $sectionItems should be defined
It should include:
- the field label ($label)
- the element id/variable name ($id) *
- whether the field should be editable or readonly ($edit), true if editable, false if readonly
- the type of input ($type) such as text, email, password, number
- and an annotation, if any ($note) to provide some context for the field


* Regarding variable names:

The values for each field on the profile are stored in variables whose names are calculated dynamically
- For subscriber profiles, reference 'php/get-sub.php'
- For site license organization profiles, reference 'php/get-license.php'
- For publisher profiles, reference 'php/get-pub.php'

The input elements share the same name as their corresponding variables
The page for processing $_POST data for profile update form submissions should target fields by those names

*/

// array (label, id/var, edit, type, note)
foreach($sectionItems as $item)
{
	$label 	= $item[0];
	$id		= $item[1];
	$var	= $item[1];
	$value 	= $$var;
	$edit	= $item[2];
	$type	= $item[3];
	$note	= $item[4];
	
	// PRIVATE (EDITABLE) PROFILE
	if($inputMode == 'private')
	{
		echo '<div class = "form-row">';
			echo '<div class = "field-label">'.$label.':</div>';
			echo '<div class = "field-container">';
				if($edit == true) 	{ echo '<input type = "'.$type.'" name = "'.$id.'" id = "profile-field-'.$id.'" value = "'.$value.'" />'; }
				else 				{ echo $value; }
			echo '</div>';
			echo '<div class = "field-note">'.$note.'</div>';
		echo '</div>'; // /.profile-section-row
	} // end if private
	
	// PUBLIC PROFILE
	else
	{
		if($value != NULL)
		{
			echo '<div class = "form-row">';
				echo '<div class = "field-label">'.$label.':</div>';
				echo '<div class = "field-container">'.$value.'</div>';
				echo '<div class = "field-note"></div>';
			echo '</div>'; // /.profile-section-row
		} // end if $value
	} // end else if public
	
} // end foreach

?>