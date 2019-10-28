<?php
/*
php/get-rubric-inputs.php
By Matthew DiMatteo, Children's Technology Review

This file processes the hidden form inputs from a rubric valuation form
It is included in 'review-process.php', which handles commentary in the review exchange, and 'editorial-process.php', which handles the editorial panel
*/

// GET FORM INPUTS
$submissionType		= test_input($_POST['submission-type']);
$errorRedirect		= test_input($_POST['redirect']);
$reviewID			= test_input($_POST['review-id']);
$evaluatedTitle 	= test_input($_POST['evaluated-title']);
$evaluationRubric 	= test_input($_POST['evaluation-rubric']);
$rubricType			= test_input($_POST['rubric-type']);
$rubricID			= test_input($_POST['rubric-id']);
$numQA 				= test_input($_POST['num-qa']);
$score 				= test_input($_POST['score']);
$evaluationReview 	= test_input($_POST['evaluation-review']);
?>