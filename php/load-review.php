<?php
/*
php/load-review.php
By Matthew DiMatteo, Children's Technology Review

This file looks up a review record in the CSR table in the database 'CSR.fmp12'
It is included in the file 'php/content-review.php'

If no id value is specified, the user is redirected to the home page

This file also performs a check to make sure that draft reviews are not accessed by users other than moderators
If the review has not been marked as published and the user is not logged in with moderator privileges, the user is redirected home

After passing the check, the record data is accessed via the file 'php/get-review.php'
*/

if(isset($_GET['id']))
{
	$reviewID 	= test_input($_GET['id']);
	if($reviewID != NULL) 	
	{ 
		if($containsRubric == true and $velvetRope == true) { require_once 'php/redirect-home.php'; } // prevent guests from accessing rubric evaluation
		
		// PERFORM THE FIND -------------------------------------------------------------
		// note: cannot use getRecordById method, as CSR::reviewnumber (field used for CTREX links) does not correspond to the actual recordID
		$findReview = $fmreviews->newFindCommand($fmreviewsLayout);
		$findReview->addFindCriterion('reviewnumber',"==".$reviewID);
		$result = $findReview->execute();
		if (FileMaker::isError ($result) ) { echo $result->getMessage(); exit(); }
		$record = $result->getFirstRecord();
		$reviewRecord = $record;

		/*
		ACCESS CHECK FOR DRAFTS
		experts and mods can edit all
		student reviewers can only edit drafts of reviews they authored themselves
		jurors can only edit drafts if they authored review themself or if the product is among the current year's entries
		*/
		$published 	= $record->getField('published');
		$authorType	= $record->getField('authorType');
		$authorID	= $record->getField('subsScreenName::globalID');
		$bolognaYear= $record->getField('bolognaYear');
		$kapiYear	= $record->getField('kapiYear');
		if($published != true and $mod != true and $expert != true and $student != true and $juror != true) 				{ require 'php/redirect-home.php'; }
		if($published != true and $student == true and $authorID != $userID) 												{ require 'php/redirect-home.php'; }
		if($published != true and $juror == true and $authorID != $userID and $bolognaYear != $year and $kapiYear != $year) { require 'php/redirect-home.php'; }

		// get the record data
		require_once 'php/get-review.php';
		require_once 'php/review-format.php';	// determine which elements to show/hide, calculate urls, parse text, etc.
		//require_once 'php/get-rubrics.php';		// gets the CTR internal rubrics and qa (for use in displaying detailed ratings in 'php/rating.php')
	} // end if $reviewID
	
	else 					{ if($pageType == 'review') { require_once 'php/redirect-home.php'; } } // return home if no id specified (on review page only)
} // end if isset id
else						{ if($pageType == 'review') { require_once 'php/redirect-home.php'; } } // return home if id input not set (on review page only)

?>