<?php
/*
php/get-rubric-qa-inputs.php
By Matthew DiMatteo, Children's Technology Review

This file processes the qa inputs from a rubric valuation form
It is included in 'review-process.php', which handles commentary in the review exchange, and 'editorial-process.php', which handles the editorial panel
*/

if($numQA > 0)
{
	// LOOP THROUGH HOWEVER MANY ATTRIBUTES WERE RATED AND GET THE FIELD VALUES FOR EACH
	$evaluationQA = array();
	for($q = 1; $q < ($numQA + 1); $q++)
	{
		$nameInputName		= 'qa-name-'.$q;
		$qaName 			= test_input($_POST[$nameInputName]);

		$indexInputName		= 'qa-index-'.$q;
		$qaIndex 			= test_input($_POST[$indexInputName]);

		$scoreInputName 	= 'qa-score-'.$q;
		$qaRating 			= test_input($_POST[$scoreInputName]);

		$weightInputName 	= 'qa-weight-'.$q;
		$qaWeight 			= test_input($_POST[$weightInputName]);

		$evaluationQA[$q] = array($qaName, $qaIndex, $qaRating, $qaWeight);
	} // end for qa	
} // end if $numQA > 0
?>