<?php
/*
php/profiles/section-textareas.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the individual textareas on a profile section (The file 'php/profiles/section-items.php' likewise is used for outputting other input elements)

It should be included in the files for each section (such as 'php/profiles/subscriber/section-contact.php')
In those files, before including this file, an array $sectionItems should be defined
It should include:
- the field label ($label)
- the element id/variable name ($id) *
- whether the textarea should be editable or readonly ($edit), true if editable, false if readonly
- the number rows
- and an annotation, if any ($note) to provide some context for the field


* Regarding variable names:

The values for each field on the profile are stored in variables whose names are calculated dynamically
- For subscriber profiles, reference 'php/get-sub.php'
- For site license organization profiles, reference 'php/get-license.php'
- For publisher profiles, reference 'php/get-pub.php'

The input elements share the same name as their corresponding variables
The page for processing $_POST data for profile update form submissions should target fields by those names

*/

// array (label, id/var, edit, rows, note)
foreach($sectionItems as $item)
{
	$label 	= $item[0]; // the field label
	$id		= $item[1]; // the element id
	$var	= $item[1]; // the variable name
	$value 	= $$var;	// the variable value
	$edit	= $item[2]; // whether the field is editable (true) or readonly (false)
	$rows	= $item[3]; // the number of rows for the textarea
	$note	= $item[4]; // an annotation, if any to provide some context for the textarea
	
	// SECTION START
	echo '<div class = "profile-section-content">';
	
		// LABEL
		if($label != NULL) 
		{ 
			echo '<div class = "row">';
				if($inputMode == 'public') { echo '<div class = "textarea-readonly-label">'; }
					echo $label;
				if($inputMode == 'public') { echo '</div>'; }
			echo '</div>'; 
		}
		
		// TEXTAREA
		echo '<div class = "profile-textarea-container">';
			if($edit == true) 	{ echo '<textarea name = "'.$id.'" id = "'.$id.'" rows = "'.$rows.'" cols = "50">'.$value.'</textarea>'; }
			else				{ echo '<div class = "textarea-readonly">'.$value.'</div>'; }
		echo '</div>'; // /.profile-textarea-container
		
		// FOOTNOTE
		if($note != NULL) { echo '<div class = "profile-section-footnote">'.$note.'</div>'; }
		
	echo '</div>'; // /.profile-section-container
} // end foreach
?>