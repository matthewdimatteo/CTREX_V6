<?php
/*
exchange-post-process.php
By Matthew DiMatteo, Children's Technology Review

This file processes update or removal of posts in the review exchange (comments or expertreviews)
*/

$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page

if(isset($_POST['post-id']))
{
	// get the hidden inputs
	$postID			= test_input($_POST['post-id']);		// id value of the post
	$submissionType = test_input($_POST['process-type']); 	// whether this is an update or delete
	$postType 		= test_input($_POST['post-type']);		// whether post is an expertreview or a comment
	$postAuthor		= test_input($_POST['post-author']);	// author's display name
	$title			= test_input($_POST['title']);			// title of product being reviewed
	$redirect		= test_input($_POST['redirect']);		// the redirect destination url
	
	// get the post content
	$postRating 	= test_input($_POST['post-rating']);	// the rating
	$postComment 	= test_input($_POST['post-comment']);	// the comment text
	
	// determine which table to use based on type of post (expertreview or comment)
	if($postType == 'expertreview') 
	{ 
		$postRecord = $fmexpreviews->getRecordById($fmexpreviewsLayout, $postID);
		$commentFieldName 	= 'review';
		$dateFieldName		= 'submissionDate';
		$timeFieldName		= 'submissionTime';
	}
	else if($postType == 'comment')
	{
		$postRecord = $fmcomments->getRecordById($fmcommentsLayout, $postID);
		$commentFieldName = 'comment';
		$dateFieldName		= 'date';
		$timeFieldName		= 'time';
	}
	
	// UPDATE POST
	if($submissionType == 'update')
	{
		$postRecord->setField('rating', $postRating);
		$postRecord->setField('rubric', ''); // clear the rubric field, since this update converts rating to a quick rating
		$postRecord->setField($commentFieldName, $postComment);
		$postRecord->setField($dateFieldName, $dateConv);
		$postRecord->setField($timeFieldName, $time);
		$commit = $postRecord->commit();
	}
	
	// DELETE POST
	else if ($submissionType == 'delete')
	{
		$commit = $postRecord->delete();
	}
	
	// CREATE NOTIFICATION IN MESSAGES TABLE
	$summary = $postAuthor.' '.$submissionType.'d their post on '.$title;
	if($postRating != NULL) { $summary .= "\n".'Rating: '.$postRating; }
	if($postComment != NULL){ $summary .= "\n".'Comment: '.$postComment; }
	$emailSubject = 'CTREX Review Exchange post '.$submissionType.'d';
	
	$inputName 		= $displayName;
	$inputEmail 	= '';
	$emailMessage 	= $summary."\n".'IP: '.$ip;
	require_once 'php/message-create.php';
	
} // end if isset id
require_once 'php/redirect.php'; // handle redirect
?>