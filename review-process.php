<?php
/*
review-process.php
By Matthew DiMatteo, Children's Technology Review

This file processes the quick rating/comment form input using the $_POST method
On a successful captcha entry, a new record is added to the 'messages' table in the 'CSR.fmp12' database to serve as a notification to CTR staff

After either a success or a failure, the user is redirected back to the review page where a message is displayed

Stored error and confirmation messages are handled by the file 'php/message-calc.php'
The file 'php/content/content-review.php' is configured to display the initial input values once after a redirect

*/
$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page

if(isset($_POST['captcha']))
{
	require_once 'php/captcha-check.php';
	require_once 'php/get-rubric-inputs.php'; // get rubric evaluation form inputs
	
	if($error == true)
	{
		$redirect = $errorRedirect;
	}
	
	// PROCESS QA INPUTS AND ADD COMMENT, NOTIFCATION RECORDS TO DATABASE
	else
	{
		echo '<script>sessionStorage.clear();</script>'; // clear session storage on a successful submission
		$redirect = 'review.php?id='.$reviewID;
		require_once 'php/get-rubric-qa-inputs.php'; // get the values from each qa input (name, index, rating, weight)
		
		// START SUMMARY
		$summary = $displayName.' evaluated '.$evaluatedTitle.' '; 
		
		// handle whether rubric or quick rating was used
		if($evaluationRubric != NULL) 	
		{ 
			if($rubricType == 'saved') 	{ $summary .= 'using a custom rubric'; }
			else 						{ $summary .= 'using the '.$evaluationRubric.' Rubric:';  }
			$emailSubject = 'Flex Rubric Evaluation'; 
		}
		
		// if not a rubric evaluation, handle whether score/rating
		else 						
		{ 
			if($score != NULL) 	{ $summary .= 'using a Quick Rating'; 	$emailSubject = 'Quick Rating Submission'; }
			else				{ $summary .= 'with a comment'; 		$emailSubject = 'Comment Submission'; } 
		}
		$summary .= "\n"."\n";
		
		// IF EXPERT, CREATE A NEW RECORD IN 'expertreviews' TABLE
		if($expert == true)
		{
			
			$emailSubject = 'Expert Review'; // override value defined above if $expert
			
			// CREATE NEW RECORD OBJECT IN 'expertreviews' TABLE
			$newComment = $fmexpreviews->createRecord($fmexpreviewsLayout);

			// SET FIELDS FOR AUTHORTYPE
			$newComment->setField('reviewerID', $userID);
			$newComment->setField('reviewnumber', $reviewID);
			//if($mod == true) { $authorType = 'CTR'; } else { $authorType = 'Expert'; }
			//$newComment->setField('authorType', $authorType);
			$newComment->setField('review', $evaluationReview);
			
			// DATE AND TIME
			$newComment->setField('submissionDate', $dateConv);
			$newComment->setField('submissionTime', $time);

		} // end if expert

		// OTHERWISE, CREATE A NEW RECORD IN 'comments' TABLE
		else
		{
			// DETERMINE COMMENT PARAMETERS BASED ON USERTYPE
			if($subscriber == true)		{ $usertype = 'Subscriber'; $commentTypeField = 'subComment'; 	$idField = 'userID'; }
			else if($license == true)	{ $usertype = 'License'; 	$commentTypeField = 'subComment'; 	$idField = 'siteName'; }
			else if($publisher == true)	{ $usertype = 'Publisher'; 	$commentTypeField = 'pubComment'; 	$idField = 'publisherID'; }
			else if($freeMode == true) 	{ $usertype = 'Free Trial'; $commentTypeField = 'guestComment'; $idField = ''; }
			else						{ $usertype = 'Guest'; 		$commentTypeField = 'guestComment'; $idField = ''; }

			// CREATE NEW RECORD OBJECT IN 'comments' TABLE
			$newComment = $fmcomments->createRecord($fmcommentsLayout);

			// SET FIELDS FOR USERTYPE
			if($idField != NULL) { $newComment->setField($idField, $userID); } // comments table configured to determine displayName based on usertype, id
			if($license == true) { $newComment->setField('orgName', $siteOrg); } // site license org name must be set manually since match field is a calc
			$newComment->setField('usertype' , $usertype);
			$newComment->setField($commentTypeField , 1);

			// SET COMMENT FIELD
			$newComment->setField('comment', $evaluationReview);
			
			// DATE AND TIME
			$newComment->setField('date', $dateConv);
			$newComment->setField('time', $time);
			
		} // end else !expert

		// SET FIELDS FOR TITLE ID, RUBRIC, AND RATING - regardless of expert status, field names and new record objects are the same
		$newComment->setField('reviewnumber', $reviewID);
		if($evaluationRubric != NULL) 			
		{ 
			$newComment->setField('rubric', $evaluationRubric);
			$newComment->setField('rubricType', $rubricType);
			$newComment->setField('rubricID', $rubricID);
		}
		if($score != NULL and $score != 'NaN') 	{ $newComment->setField('rating', $score); }		
		
		if($numQA > 0)
		{
			// LOOP THROUGH QA VALUES
			$q = 0;
			foreach($evaluationQA as $thisQA)
			{
				$q += 1;
				$qaName 	= $thisQA[0];
				$qaIndex 	= $thisQA[1];
				$qaRating 	= $thisQA[2];
				$qaWeight 	= $thisQA[3]/10;

				// CALCULATE FIELD NAME BASED ON QA INDEX NUMBER
				$ratingFieldName = 'rating'.$qaIndex;
				$weightFieldName = 'weight'.$qaIndex;

				// SET THE RATING/WEIGHT FIELDS IN THE DATABASE - regardless of expert status, field names and new record objects are the same
				$newComment->setField($ratingFieldName, $qaRating);
				$newComment->setField($weightFieldName, $qaWeight);
				//echo $q.'. '.$qaName.', ('.$ratingFieldName.'): '.$qaRating.', ('.$weightFieldName.'): '.$qaWeight.'<br/>';

				// APPEND SUMMARY
				$summary .= $qaName.': '.$qaRating.'% (Importance: '.$qaWeight.'/10)'."\n";
			} // end foreach $evaluationQA
		} // end if $numQA > 0

		// COMMIT NEW RECORD - regardless of expert status, field names and new record objects are the same
		$commit = $newComment->commit();
		if(FileMaker::isError($commit)) { if($expert == true) { echo 'expertreviews'; } else { echo 'comments'; } echo '<br/>'.$commit->getMessage(); exit(); }

		// APPEND SUMMARY
		if($score != NULL)				{ $summary .= "\n".'Overall Score: '.$score.'%'."\n"."\n"; }
		if($evaluationReview != NULL) 	{ $summary .= 'Review: '.$evaluationReview."\n"; }
		//echo '<br/>Summary: '.nl2br($summary);

		// CREATE NOTIFICATION IN MESSAGES TABLE
		$inputName 		= $displayName;
		$inputEmail 	= '';
		$emailMessage 	= $summary."\n".'IP: '.$ip;
		require_once 'php/message-create.php';
		
	} // end else no error
	
} // end if captcha isset

// handle redirect
require_once 'php/redirect.php';
?>