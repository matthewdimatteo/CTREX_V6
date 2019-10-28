<?php
/*
php/find-savedrubric.php
By Matthew DiMatteo, Children's Technology Review

This file looks up a subscriber's saved rubric by its record id value, gets its field values, and parses out each quality attribute name and field
*/

// lookup the saved rubric by its id
$savedrubric 			= $fmsavedrubrics->getRecordById($fmsavedrubricsLayout, $savedRubricID);

// get the field values for the saved rubric
$savedRubricName 		= $savedrubric->getField('rubricName');
$savedRubricDescription = $savedrubric->getField('rubricDescription');
$savedRubricQANames 	= $savedrubric->getField('qaNames');
$savedRubricQAFields 	= $savedrubric->getField('qaFields');

// parse out each qa from the string into an array
$savedQANames 	= explode(", ", $savedRubricQANames);
$savedQAFields 	= explode(", ", $savedRubricQAFields);

// declare arrays to store qa data and names
$selectedQAData 	= array();
$selectedQANames	= array();
$selectedQAFields	= array();
//$findQAType = 'fields'; // tells find-qa to lookup qa records by ratingField values
// lookup each qa and get its values
foreach($savedQAFields as $thisQA)
{
	require 'php/find-qa.php'; // lookup each qa and get is field values
	array_push($selectedQAData, array($qaName, $qaType, $qaDescriptor, $qaField, $qaWeight)); // add the qa data to the array of all selected qa
	array_push($selectedQANames, $qaName); // add the qa name to the array of all selected qa names
	array_push($selectedQAFields, $qaField); // add the qa field to the array of all selected qa fields
} // end foreach selected qa name
?>