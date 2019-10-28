<?php
/*
php/profiles/section-items.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the individual fields on a profile section (The file 'php/profiles/section-textareas.php' likewise is used for outputting textareas only)
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
	$label 	= $item[0]; // the field label
	$id		= $item[1]; // the element id
	$var	= $item[1]; // the variable name
	$value 	= $$var;	// the variable value
	$edit	= $item[2];	// whether the field is editable (true) or readonly (false)
	$type	= $item[3]; // the type of input, such as text, email, password, number
	$note	= $item[4]; // an annotation, if any to provide some context for the field
	
	// ROW START
	echo '<div class = "profile-section-row">';
	
		// LABEL
		echo '<div class = "profile-section-label">'.$label.':</div>';
		
		// INPUT FIELD
		echo '<div class = "profile-section-field">';
			if($edit == true) 	{ echo '<input type = "'.$type.'" name = "'.$id.'" id = "profile-field-'.$id.'" value = "'.$value.'" />'; }
			else 				{ echo $value; }
		echo '</div>';
		
		// NOTE
		echo '<div class = "profile-section-note">'.$note.'</div>';
		
	echo '</div>'; // /.profile-section-row
} // end foreach
?>