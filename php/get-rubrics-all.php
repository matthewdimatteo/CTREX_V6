<?php
// GET ALL RUBRICS
require 'php/get-rubrics.php';
require 'php/get-qa-all.php';


// LOAD SAVED RUBRICS
if($numSavedRubrics > 0)
{
	$savedRubricsList = array();	
	$savedR = -1;
	foreach($savedRubrics as $savedRubric)
	{
		$savedR += 1;

		$savedRubricName 		= $savedRubric[0];
		$savedRubricQA			= $savedRubric[1];
		$savedRubricID			= $savedRubric[2];
		$savedRubricDescription	= $savedRubric[3];

		$savedRubricsList[$savedR] = array($savedRubricName, $savedRubricQA, $savedRubricID, $savedRubricDescription);

	} // end foreach $savedRubrics
} // end if $numSavedRubrics > 0	
?>