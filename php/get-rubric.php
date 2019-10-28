<?php
/*
php/get-rubric.php
By Matthew DiMatteo, Children's Technology Review

This file accesses the array of individual rubric data defined in 'php/find-rubrics.php'
It is included in the file 'php/get-rubrics.php' which is used to access an array of multiple rubrics' data
*/

$rubricName 	= $thisRubric[0];
$qaData			= $thisRubric[1]; // this is an array of the rubric's related Quality Attributes (or QA) defined in 'php/get-qa.php'
$ptsPossible	= $thisRubric[2];
$ptsEarned		= $thisRubric[3];
$rubricDescription = $thisRubric[4];
$thisRubricScore = round((10 * ($ptsEarned/$ptsPossible)), 2);
if($thisRubricScore > 0) 	{ $thisRubricScoreText = $thisRubricScore.'%'; }
else						{ $thisRubricScoreText = 'N/A'; }
?>