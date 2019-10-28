<?php
/*
php/content/content-rubrics.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the Flex Rubric page, included dynamically in 'php/content.php'
*/

// PROCESS RUBRIC SELECTION FORMS
require_once 'php/get-rubric-saved.php';

// LOAD THE REVIEW FOR A PRODUCT EVALUATION
require_once 'php/load-review.php';	// load the review for evaluations

// PAGE HEADER, SUBHEADER WITH DESCRIPTION
require_once 'php/rubrics-header.php';

// PRODUCT TITLE
if($reviewID != NULL) { require_once 'php/review-title.php'; } // display the title and copyright info for product being evaluated

// RUBRIC SELECT MENU, OUTPUT
require_once 'php/rubric-controls.php'; // this file contains all of the rubric evaluation tool content
?>