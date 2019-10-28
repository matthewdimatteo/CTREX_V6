<?php
/*
php/find-qa.php
By Matthew DiMatteo, Children's Technology Review

This file looks up a Quality Attribute record in the database file 'CSR.fmp12' and gets its field values
It is included within a foreach loop in the files 'php/get-rubrics-saved.php' and 'rubric-process.php'
The foreach loop specifies that each item in the array be accessed as $thisQA, which is a ratingField value used as the find criterion in this file
The field values are then intended to be passed into an array constructed in the aforemention files which include this file
*/

$findQA = $fmqa->newFindCommand($fmqaLayout); // $fmqa object and $fmqaLayout defined in 'php/connect.php'
$findQA->addFindCriterion('ratingField', "==".$thisQA); // lookup the Quality Attribute by its exact ratingField value (e.g. 'rating1', 'rating2', etc.)
/*if($findQAType == 'fields') { $findQA->addFindCriterion('ratingField', "==".$thisQA); }
else 						{ $findQA->addFindCriterion('name', "==".$thisQA); }*/
$findQA->addSortRule('name', 1, FILEMAKER_SORT_ASCEND);
$result = $findQA->execute();
if (FileMaker::isError ($result) ) { echo $result->getMessage(); exit; }
$record = $result->getFirstRecord();

// get the field values
$qaName 		= $record->getField('name');
$qaType 		= $record->getField('type');
$qaDescriptor 	= $record->getField('descriptor');
$qaField		= $record->getField('ratingField');
$qaWeight		= $record->getField('ratingWeight')*10; // this value is multiplied by 10 to compensate for a scale discrepancy in how weights are calculated in CTREX compared to how they are calculated in FileMaker Pro
?>