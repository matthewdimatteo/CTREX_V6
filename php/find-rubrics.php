<?php
/*
php/find-rubrics.php
By Matthew DiMatteo, Children's Technology Review

This file looks up either one rubric or all rubrics and gets the names and corresponding values for their Quality Attributes (or QA)
Each rubric and its set of QA is stored in an array

This file is included in 'php/rating.php' and 'php/ratings-all.php'
The file 'php/get-rubrics.php' accesses the array that this file constructs and outputs the rubric name and score text
and the file 'php/rating-qa' outputs details for individual QA
*/

// construct a find request to lookup rubric(s)
$getRubrics = $fmrubrics->newFindCommand($fmrubricsLayout);

// lookup a selected rubric
//if($getSelectedRubric == true) { $getRubrics->addFindCriterion('rubric', '=="'.$rubricUsed.'"'); } 
if($getSelectedRubric == true) { $getRubrics->addFindCriterion('rubric', "=*$rubricUsed*"); } 

// lookup all active rubrics
else
{
	$getRubrics->addFindCriterion('rubric', "*");
	$getRubrics->addFindCriterion('active', "*");
}

// execute the find request
$rubricsResult = $getRubrics->execute();
if (FileMaker::isError ($rubricsResult) ) { echo $rubricUsed.'<br/>'.$rubricsResult->getMessage(); exit; }	
if($getSelectedRubric == true) 	{ $rubrics = $rubricsResult->getFirstRecord(); }
else 							{ $rubrics = $rubricsResult->getRecords(); }

// declare an array to store rubric data
$rubricsList = array();
$rubricsN = -1;

// get the rubric names and qa sets from the database and store these in the array of rubrics
foreach($rubrics as $rubricRecord)
{
	$rubricsN += 1;
	$rubricName 		= $rubricRecord->getField('rubric');
	$qaSet 				= $rubricRecord->getRelatedSet('qa');
	$rubricDescription 	= $rubricRecord->getField('rubricDescription');
	$rubricDescription = parseLinks($rubricDescription);
	require 'php/get-qa.php';
	$rubricsList[$rubricsN] = array($rubricName, $qaData, $ptsPossible, $ptsEarned, $rubricDescription);
} // end foreach rubric

?>