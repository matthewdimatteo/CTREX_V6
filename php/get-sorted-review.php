<?php
/*
php/get-sorted-review.php
By Matthew DiMatteo, Children's Technology Review

This file gets the values for a sorted review record from the associative array created in 'php/rank-review.php'
*/

$sortedRecordFields 	= $sortedRecord['fields'];			// array of field values from database
$sortedRecordRelevance 	= $sortedRecord['relevance'];		// calculated relevance

$sortedRecordID			= $sortedRecord['reviewnumber'];	// record id for sorting chronologically, referencing
$sortedRecordRating		= $sortedRecord['rating'];			// for sorting by rating
$sortedRecordTitle		= $sortedRecord['title'];			// for sorting alphabetically

// reconstructed text for including keyword highlighting
$titleText 				= $sortedRecord['titleText'];
$companyText			= $sortedRecord['companyText'];
$platformText			= $sortedRecord['platformText'];
$subjectText			= $sortedRecord['subjectText'];

// for including context of search term matches within body of review
$reviewMatches			= $sortedRecord['reviewMatches'];	
$reviewbodyText			= $sortedRecord['reviewbodyText'];
$cleanedReviewWords		= $sortedRecord['rankReviewWords'];
$sortedReviewWords		= $sortedRecord['reviewWords'];
$cleanedReviewText		= $sortedRecord['rankReview'];
$sortedReviewText		= $sortedRecord['reviewText'];

$item = $sortedRecordFields;	// tell 'php/get-vars.php' which $item to use - declared in output loop in 'php/search-reviews.php'
require 'php/get-vars.php'; 	// assign dynamic variables from reconstructed array
?>