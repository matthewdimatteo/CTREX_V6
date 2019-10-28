<?php
/*
php/get-review.php
By Matthew DiMatteo, Children's Technology Review

This file gets the field values for a review from the 'CSR.fmp12' database file and performs calculations based on field values
It is included within the foreach loop that outputs records in 'content-home.php' and 'load-review.php' which loads data for the review page
*/
$reviewRecord = $record; 		// for get-qa.php reference
$fields = $reviewFields;		// $reviewFields is defined in 'php/fields.php', which is included in 'php/autoload.php'
require 'php/get-field.php';	// this file uses the $fields array to get the values for each field and assign them to variables

// after accessing the database fields, perform several calculations based on record data

// BOOKMARKED STATUS
$getBookmark 	= checkBookmark($bookmarkReviewNumberList, $savedBookmarks, $reviewnumber); // function is in 'php/functions.php'
$bookmarked 	= $getBookmark[0]; // $getBookmark is an array returned by the function - this value is the boolean of whether review is bookmarked
$bookmarkID 	= $getBookmark[1]; // this value is the record ID of the bookmark in the 'savedbookmarks' table - used for record deletion
array_push($fieldValues, array('bookmarked', $bookmarked));
array_push($fieldValues, array('bookmarkID', $bookmarkID));

// AUTHORSHIP
$authorLink		= 'profile-public.php?id='.$authorID;	
$editorLink		= 'profile-public.php?id='.$editorID;	
array_push($fieldValues, array('authorLink', $authorLink));
array_push($fieldValues, array('editorLink', $editorLink));

// RATING
if($numberOverallRating != '?')
{ 
	$stars = round($numberOverallRating, 1); 
	$score = $stars * 20;
}
else { $score = ''; }
$standardDefault = true; // make 'Standard' Rubric correspond to 'CTR Rating'
if($standardDefault == true) { $rubricUsed = 'Standard'; }
else
{
	// if a rubric has been used to evaluate, use its overall rating instead
	if ($ptsPossible != NULL) 
	{ 
		$score = $rubricScore; 
		$stars = $rubricStars; 
	}		
} // end if ($standardDefault == true)			
$score 			= number_format($score, 0);				
$lettergrade 	= lettergrade($score);					
if($score != '?' and $score != NULL and $score != 0 and $score != '0%') { $rated = true; } else { $rated = false; }		
array_push($fieldValues, array('rated', $rated));
array_push($fieldValues, array('stars', $stars));
array_push($fieldValues, array('score', $score));
array_push($fieldValues, array('rubricUsed', $rubricUsed));

// MULTIPLE RUBRICS
if($numRubricsSelected > 0 and $rubricsText != NULL) 
{
	$rubricsText = nl2comma($rubricsText);
	$rubricsTextArray = explode(',', $rubricsText); // parse the selected rubrics
} 
array_push($fieldValues, array('standardDefault', $standardDefault));
array_push($fieldValues, array('rubricsTextArray', $rubricsTextArray));
if($numRubricsSelected > 0){ require 'php/rubrics-multiple.php'; } else { $multipleRubrics = ''; } // get data for multiple rubrics
array_push($fieldValues, array('multipleRubrics', $multipleRubrics));
if($multipleRubrics != NULL) { $rated = true; } // override above to include products with rubric rating but no standard rating

// EDITOR'S CHOICE
$awardyear 		= substr($issue, 4, 2);					
$awardlabel 	= 'Editor\'s Choice 20'.$awardyear;		
array_push($fieldValues, array('awardyear', $awardyear));
array_push($fieldValues, array('awardlabel', $awardlabel));

// VIDEO
$vid 			= videoLink($linkVideo);
$vidURL 		= $vid[0];								
$video 			= $vid[1];			
array_push($fieldValues, array('vidURL', $vidURL));
array_push($fieldValues, array('video', $video));

// REVIEW LINK
$reviewLink 	= 'review.php?id='.$reviewnumber;		
$fullreviewLink = 'full'.$reviewLink;					
$velvetRopeLink = 'login.php?target=review&redirect='.urlencode($reviewLink);
array_push($fieldValues, array('reviewLink', $reviewLink));
array_push($fieldValues, array('fullreviewLink', $fullreviewLink));
array_push($fieldValues, array('velvetRopeLink', $velvetRopeLink));

// RESULT ITEM CLASS
if($published == NULL) 
{ 
	$resultItemClass 			= 'result-item-heading-draft'; 
	$resultItemGridTitleClass 	= 'result-item-grid-title-draft'; 
} 
else 
{ 
	$resultItemClass 			= 'result-item-heading'; 
	$resultItemGridTitleClass 	= 'result-item-grid-title'; 
}
array_push($fieldValues, array('resultItemClass', $resultItemClass));
array_push($fieldValues, array('resultItemGridTitleClass', $resultItemGridTitleClass));

// COMMENTS
$totalComments 	= $commentCount + $expertReviewCount;
array_push($fieldValues, array('totalComments', $totalComments));
if($commentCount > 0) 		{ $communityReviews = $record->getRelatedSet('comments'); }
if($expertReviewCount > 0) 	{ $expertReviews 	= $record->getRelatedSet('expertreviews'); }

// PRODUCERS
if($numProducers > 0) 		{ $producers		= $record->getRelatedSet('Producers'); } else { $producers = ''; }

?>