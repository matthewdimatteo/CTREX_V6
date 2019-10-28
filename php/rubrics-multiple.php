<?php
/*
'php/rubrics-multiple.php'
By Matthew DiMatteo, Children's Technology Review

This file processes rubric records and constructs an array $multipleRubrics for outputting multiple rubrics used to evaluate a product

It first loops through each value in $rubricsTextArray (defined in 'php/get-review.php') and uses 'php/find-rubrics.php' to:
1. look up each rubric in the database
2. store the rubric name, related Quality Attributs (or QA), and score in an array

It then loops through the array of rubrics constructed in 'php/find-rubrics.php' and outputs each using 'php/get-rubrics.php'

*/
$multipleRubrics = array();					// array to store ratings for each of the selected rubrics
$multipleRubricsN = -1;						// counter for the array
foreach($rubricsTextArray as $thisRubric)
{
	$rubricUsed = $thisRubric; 		// set the variable 'php/find-rubrics.php' uses to lookup the rubric
	$getSelectedRubric = true;		// tells 'php/find-rubrics.php' to lookup one rubric instead of all active rubrics
	require 'php/find-rubrics.php'; // looks up each rubric in the database and stores the rubric name, related QA, and score in array $rubricsList
	$multipleRubricsN += 1;			// increments the counter for the array of multiple rubrics
	$multipleRubrics[$multipleRubricsN] = $rubricsList; // appends the array of individual rubric data to the array of multiple rubrics
}
$primaryRubric = ''; // resets boolean used in 'php/rating.php' to tell 'php/get-rubrics.php' to output a different pattern for primary rubric
?>