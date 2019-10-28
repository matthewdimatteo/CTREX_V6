<?php
/*
php/get-field.php
By Matthew DiMatteo, Children's Technology Review

This file requires the $fields array be defined as one of the arrays of fields in the file 'php/fields.php'
This file gets the field values for a record and dynamically assigns them to variable names based on the 0th item of the fields array
It should be included within a foreach loop processing multiple found records, or after a record object has been obtained for single records
*/
$fieldValues = array();
$fieldValuesN = -1;
foreach($fields as $field)
{
	$fieldValuesN += 1;
	$varName 		= $field[0];	// the first parameter in any of the fields arrays is the variable name to store field data to
	$databaseField 	= $field[1];	// the second parameter is the name of the database field in the FileMaker file
	$$varName 		= $record->getField($databaseField); // use of the $$ notation creates a variable with a name equal to $varName
	$fieldValues[$fieldValuesN] = array($varName, $$varName); // add variable name and field value to array of field values
}
?>