<?php
/*
php/search-filename.php
By Matthew DiMatteo, Children's Technology Review

This file calculates a string for a filename or summary based on the search parameters
It is included in 'php/find-reviews.php'
*/
// COUNT NUMBER OF SEARCH PARAMETERS INPUTTED
$numParams = 0; $plusCount = 0; 
$numFilters = 0; $filterCount = 0;

if ($searchReviewsKeyword != NULL) 		{ $numParams += 1; $plusCount += 1; }
if ($searchReviewsAge != NULL) 			{ $numParams += 1; $plusCount += 1; }
if ($searchReviewsSubject != NULL) 		{ $numParams += 1; $plusCount += 1; }
if ($searchReviewsPlatform != NULL) 	{ $numParams += 1; $plusCount += 1; }
if ($searchReviewsTopic != NULL) 		{ $numParams += 1; $plusCount += 1; }
if ($searchReviewsPublisher != NULL) 	{ $numParams += 1; $plusCount += 1; }
if ($searchReviewsMonthly != NULL) 		{ $numParams += 1; $plusCount += 1; }
if ($searchReviewsWeekly != NULL) 		{ $numParams += 1; $plusCount += 1; }
if ($searchReviewsRubric != NULL) 		{ $numParams += 1; $plusCount += 1; }
if ($searchReviewsAward != NULL) 		{ $numParams += 1; $plusCount += 1; }
if ($searchReviewsYear != NULL) 		{ $numParams += 1; $plusCount += 1; }

if ($filterCurrent == true)		{ $numFilters += 1; $filterCount += 1; }
if ($filterRated == true)		{ $numFilters += 1; $filterCount += 1; }
if ($filterRubrics == true)		{ $numFilters += 1; $filterCount += 1; }
if ($filterAwards == true)		{ $numFilters += 1; $filterCount += 1; }
if ($filterFeature == true)		{ $numFilters += 1; $filterCount += 1; }
if ($filterNewrelease == true)	{ $numFilters += 1; $filterCount += 1; }
if ($filterFree == true)		{ $numFilters += 1; $filterCount += 1; }
if ($filterVideos == true)		{ $numFilters += 1; $filterCount += 1; }
if ($filterImages == true)		{ $numFilters += 1; $filterCount += 1; }
if ($filterComments == true)	{ $numFilters += 1; $filterCount += 1; }
if ($filterDrafts == true)		{ $numFilters += 1; $filterCount += 1; }
if ($filterWeekly == true)		{ $numFilters += 1; $filterCount += 1; }

$storedPlusCount 	= $plusCount;
$storedFilterCount 	= $filterCount;

// SET TITLE FOR EXPORT FILE BASED ON SEARCH PARAMETERS
								  		  $exportFilename  = "ctrex-search-";
//if($foundCount > $printMax) 			{ $exportFilename .= 'Displaying first '.$printMax.' of '; }
//								  		  $exportFilename .= ''.$foundCount.' results found ';
if ($numParams == 0)					{ $exportFilename .= "all-records-"; }
//else 									{ $exportFilename .= 'for-'; }
if ($searchReviewsKeyword != NULL) 		{ $exportFilename .= $searchReviewsKeyword; 	$plusCount -= 1; if ($plusCount > 0) { $exportFilename .= "-"; } }
if ($searchReviewsAge != NULL) 			{ $exportFilename .= $searchReviewsAgeLabel; 	$plusCount -= 1; if ($plusCount > 0) { $exportFilename .= "-"; } }
if ($searchReviewsSubject != NULL) 		{ $exportFilename .= $searchReviewsSubject; 	$plusCount -= 1; if ($plusCount > 0) { $exportFilename .= "-"; } }
if ($searchReviewsPlatform != NULL) 	{ $exportFilename .= $searchReviewsPlatform; 	$plusCount -= 1; if ($plusCount > 0) { $exportFilename .= "-"; } }
if ($searchReviewsTopic != NULL) 		{ $exportFilename .= $searchReviewsTopicLabel; 	$plusCount -= 1; if ($plusCount > 0) { $exportFilename .= "-"; } }
if ($searchReviewsPublisher != NULL) 	{ $exportFilename .= $searchReviewsPublisher; 	$plusCount -= 1; if ($plusCount > 0) { $exportFilename .= "-"; } }
if ($searchReviewsMonthly != NULL) 		{ $exportFilename .= $searchReviewsMonthly; 	$plusCount -= 1; if ($plusCount > 0) { $exportFilename .= "-"; } }
if ($searchReviewsWeekly != NULL) 		{ $exportFilename .= $searchReviewsWeekly;		$plusCount -= 1; if ($plusCount > 0) { $exportFilename .= "-"; } }
if ($searchReviewsRubric != NULL) 		{ $exportFilename .= $searchReviewsRubric;		$plusCount -= 1; if ($plusCount > 0) { $exportFilename .= "-"; } }
if ($searchReviewsAward != NULL) 		{ $exportFilename .= $searchReviewsAward;		$plusCount -= 1; if ($plusCount > 0) { $exportFilename .= "-"; } }
if ($searchReviewsYear != NULL) 		{ $exportFilename .= $searchReviewsYear;		$plusCount -= 1; if ($plusCount > 0) { $exportFilename .= "-"; } }

if ($numParams != 0)					{ $exportFilename .= "-"; }
								  		  $exportFilename .= "sort-".$searchReviewsSort;
if ($numFilters > 0) 					{ $exportFilename .= "-filter-"; }
if ($filterCurrent == true)				{ $exportFilename .= "current"; 				$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }
if ($filterRated == true)				{ $exportFilename .= "rated";					$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }
if ($filterRubrics == true)				{ $exportFilename .= "rubrics";					$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }
if ($filterAwards == true)				{ $exportFilename .= "awards";					$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }
if ($filterFeature == true)				{ $exportFilename .= "feature";					$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }
if ($filterNewrelease == true)			{ $exportFilename .= "newrelease";				$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }
if ($filterFree == true)				{ $exportFilename .= "free";					$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }
if ($filterVideos == true)				{ $exportFilename .= "videos";					$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }
if ($filterImages == true)				{ $exportFilename .= "images";					$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }
if ($filterComments == true)			{ $exportFilename .= "comments";				$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }
if ($filterDrafts == true)				{ $exportFilename .= "drafts";					$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }
if ($filterWeekly == true)				{ $exportFilename .= "weekly";					$filterCount -= 1; if ($filterCount > 0) { $exportFilename .= "-"; } }

// PARSE OUT ANY COMMAS FROM TITLE TO AVOID MULTIPLE HEADERS ERROR IN CHROME
$commaCount = substr_count($exportFilename, ',');
$exportFilename = str_replace ( ',', '-', $exportFilename, $commaCount);

// PARSE OUT SPACES
$spaceCount = substr_count($exportFilename, ' ');
$exportFilename = str_replace ( ' ', '+', $exportFilename, $spaceCount );

$plusCount 		= $storedPlusCount;
$filterCount 	= $storedFilterCount;
?>