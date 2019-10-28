<?php
/*
php/get-vars.php
By Matthew DiMatteo, Children's Technology Review

This file assigns dynamic variable names for an item being output from a reconstructed array
It is intended to be included within a for/foreach loop that outputs an array of record data
Before including this file, the $item variable must be set to the object reference for that loop

About reconstructed arrays:
- In some cases, it is sufficient to output record data in the same foreach loop that includes the $record->getField() commands
- However, certain cases call for output of record data AFTER an array of records has been constructed

These cases include:
- Grid outputs: For grid outputs, each record is outputted via an array index reference
	The grid is outputted by a nested for loop, which increments counters for both rows and columns
	Independent of rows or columns, an item counter is also incremented
	This item counter must reference an index in the array of record data
	In this case, that array must already have been constructed
- Re-sorting: The review search includes a feature for sorting by relevance, which entails sorting an existing array
	Sorting by relevance involves an algorithm that assigns relevance values based on known record data
	The algorithm returns a reconstructed array, sorted by relevance
	
*/

// get the dynamic variables created by 'php/get-field.php'
foreach($item as $itemField) 
{ 
	$varName 	= $itemField[0];
	$varValue 	= $itemField[1];
	$$varName 	= $varValue;
} // end foreach $expertField
?>