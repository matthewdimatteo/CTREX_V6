<?php
/*
php/form-fields-process.php
By Matthew DiMatteo, Children's Technology Review

This file is used to get the field values for a set of form inputs
It is included in the file 'php/form-process.php' within a foreach loop

Within the content files for each of the form pages (such as 'php/content/content-contact.php'), arrays for each set of form fields must be specified
These arrays should include an array for each field containing the values (label, name, value, type, required, note, width)
- label: 	the label for the field (not used in processing data - just for the user to see)
- name: 	used for both the name attribute of the input element and the variable name
- value:	the value attribute for the input element (this should be a php variable with a name identical to the name value)
- type:		the type attribute for the input element (such as text, number, hidden, email, etc.)
- required:	true/false boolean for whether the field is required
- note:		optional - will display a description in fine print beneath the field if specified
- width:	for inline fields only - the css class corresponding to the desired width of the field container element

In getting the values from the specified field array, this file:
- uses the POST method to get the form input with a name matching the $name value
- assigns the field value to a variable with the name specified by the name parameter
- creates an array for the processed field and appends it to the array of $submissionData declared in 'php-form-process.php'
- appends the info for each field to the email notification summary declared in 'php/form-process.php'

'php/form-process.php' then is able to store the $submissionData array in $_SESSION storage for reference upon redirection to the form page
It also creates a new record in the 'messages' table of the 'CSR.fmp12' database to serve as notification to CTR staff

*/
// process fields
if($fields != NULL)
{
	foreach($fields as $field)
	{
		$label		= $field[0];
		$name		= $field[1];
		$value		= $field[2];
		$varName 	= $name;
		$$varName 	= test_input($_POST[$name]);			// assigns the field value to a variable with the name specified by the name parameter
		$thisField 	= array($label, $varName, $$varName);	// stores the information for this field in an array
		
		// append the submission data array and the email message
		$submissionDataN += 1;								// increment the array counter for the submission data
		$submissionData[$submissionDataN] = $thisField;		// appends the array of this field's information to the array of submission data
		$summary .= $label.': '.$$varName."\n"; 			// append the info for this field to the email notification summary
	} // end foreach $fields as $field
} // end if $fields != NULL

// FILTER OUT SPAM EMAIL ADDRESSES
require 'php/spam-emails.php'; // contains array of known spam email addresses
if(in_array($inputEmail, $spamEmails)) { require_once 'php/redirect-out.php'; }
?>