<?php
/*
php/rank-review.php
By Matthew DiMatteo, Children's Technology Review

This file assigns a relevance value to a review record, parses text from target fields for keyword highlighting, and appends data to the sorted record array
It is included within the foreach loop in 'php/find-review.php'
*/
require 'php/get-review.php'; // get field values from database and store in array

// get each of the search fields' content for each record - convert text to lowercase for case-sensitive substr_count checks
$rankID			= $record->getField('reviewnumber');
$rankTitle 		= cleanText($record->getField('Title'));
$rankAge		= cleanText($record->getField('ageCodes'));
$rankGrade		= cleanText($record->getField('Grade Level'));
$rankAgeField 	= cleanText($record->getField($searchReviewsAgeField));
$rankPlatform	= cleanText($record->getField('platform text'));
$rankSubject	= cleanText($record->getField('teaches text'));
$rankTopic		= cleanText($record->getField('recommendations text'));
$rankCompany	= cleanText($record->getField('Company'));
$rankMonthly	= cleanText($record->getField('issueAbbr'));
$rankWeekly		= $record->getField('weekly');
$rankReview 	= cleanText($record->getField('Web Site Comments Field'));
$rankReview = str_replace("\n", ' ', $rankReview);
$review 	= str_replace("\n", ' ', $reviewText);
$platform 	= $platforms;
$subject 	= $subjects;
$topic 		= $topics;
$monthly 	= $issue;

if($searchReviewsAgeField == 'ageCodes') { $ageTarget = 'age'; } else { $ageTarget = 'grade'; }

// determine the number of words for each match field and parse out each into an array ---------------
$targetFieldDataArray = array('title', 'review', 'company', $ageTarget, 'platform', 'subject', 'topic', 'monthly', 'weekly');
foreach($targetFieldDataArray as $thisTargetFieldData)
{
	// original text
	$originalTargetVarName		= $thisTargetFieldData;
	$originalDataVarName		= $thisTargetFieldData.'WordsData';
	$$originalDataVarName		= getTextArray($$originalTargetVarName);
	$originalDataVarValue 		= $$originalDataVarName;
	$originalWordsArrayVarName 	= $thisTargetFieldData.'Words';
	$$originalWordsArrayVarName = $originalDataVarValue['words'];
	$originalWordCountVarName	= 'num'.ucfirst($thisTargetFieldData).'Words';
	$$originalWordCountVarName	= $originalDataVarValue['wordcount'];

	// cleaned text
	$cleanedTargetVarName 		= 'rank'.ucfirst($thisTargetFieldData);
	$cleanedDataVarName			= 'rank'.ucfirst($thisTargetFieldData).'WordsData';
	$$cleanedDataVarName 		= getTextArray($$cleanedTargetVarName);
	$cleanedDataVarValue 		= $$cleanedDataVarName;
	$cleanedWordsArrayVarName 	= 'rank'.ucfirst($thisTargetFieldData).'Words';
	$$cleanedWordsArrayVarName 	= $cleanedDataVarValue['words'];
	$cleanedWordCountVarName 	= 'numRank'.ucfirst($thisTargetFieldData).'Words';
	$$cleanedWordCountVarName 	= $cleanedDataVarValue['wordcount'];		
} // end foreach $targetFieldDataArray

// declare arrays to reconstruct the original result field text, with parameter for match y/n
$titleWordsArray 	= array(); 	
$companyWordsArray 	= array();
$platformWordsArray = array();
$subjectWordsArray 	= array();
$reviewWordsArray	= array();

// ASSIGN RELEVANCE AND FIND MATCH CONTEXT FOR EACH SEARCH TERM INPUT ---------------------------------------------------------
$relevance = 0; // start the relevance at 0 for each result
$reviewMatches = 0;
$compWords = array('keyword', 'age', 'agelabel', 'platform', 'subject', 'topic', 'topiclabel', 'company', 'monthly', 'weekly'); // array of search inputs
//$compWords = $searchTermsDataArray;
foreach($compWords as $compWord) { require 'php/rank-param.php'; } // assign relevance and highlight text for each search input

// get these values as numeric data types
$reviewnumber 	= intval($reviewnumber);	// int since should always be integer
$score 			= floatval($score);			// float since can be decimal

// create an associative array for current record containing fields values, sort fields, relevance
$thisRecordData = array
(
	"fields"=>$fieldValues, 
	"relevance"=>$relevance,
	"reviewnumber"=>$reviewnumber,
	"rating"=>$score,
	"title"=>$title,
	"titleText"=>$titleText,
	"companyText"=>$companyText,
	"platformText"=>$platformText,
	"subjectText"=>$subjectText,
	"reviewMatches"=>$reviewMatches,
	"reviewbodyText"=>$reviewbodyText,
	"rankReviewWords"=>$rankReviewWords,
	"reviewWords"=>$reviewWords,
	"rankReview"=>$rankReview,
	"reviewText"=>$review
); 
array_push($recordsToSort, $thisRecordData); // add the current record data array to the array of records
?>