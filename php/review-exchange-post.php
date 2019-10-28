<?php
/*
php/review-exchange-post.php
By Matthew DiMatteo, Children's Technology Review

This file outputs an individual post within the community reviews (subscriber comments) section of the review page
It is included within a foreach loop in 'php/content/content-review.php'
The file 'php/get-field-related.php' generates variables dynamically based on the $relatedCommentFields array in 'php/fields.php'
*/
$postN += 1;
require 'php/get-field-related.php';

// DETERMINE WHETHER CURRENT USER IS POST AUTHOR (AND CAN EDIT)
if 
(
	($login == true and $license != true and $temp != true and $publisher != true and $userID == $postAuthorUserID) or
	($publisher == true and $publisherID == $postAuthorPublisherID) or
	($license == true and $username == $postAuthorUsername) or
	($mod == true)
)
{ $canEdit = true; $postItemClass = 'exchange-post-edit'; } else { $canEdit = false; $postItemClass = 'exchange-post'; }

// determine values, show/hide classes
if($postAuthorShare == 'Share' or $postAuthorShare == 'share') { $postAuthorShare = true; } else { $postAuthorShare = false; } // whether public profile shared
if($postAuthorScreenName == NULL) { $postAuthorScreenName = $postAuthorScreenNameD; } // default screenname if none customized
if($postRating != NULL) 	{ $postRatingClass 	= 'exchange-post-rating'; } 	else { $postRatingClass 	= 'hide'; } // rating
if($postComment != NULL) 	{ $postCommentClass = 'exchange-post-comment'; } 	else { $postCommentClass 	= 'hide'; } // comment

// determine whether post is an expertreview or a comment ($relatedFields value set in 'php/content/content-review.php' within foreach loop)
if($relatedFields == $relatedExpertReviewFields) { $postType = 'expertreview'; } else { $postType = 'comment'; }

// determine author's display name
if($postType == 'expertreview') 				{ $postAuthorDisplayName = $postAuthorFullName; }
/*
else
{
	if($postAuthorUsertype == 'License') 		{ $postAuthorDisplayName = $postAuthorOrgName; }
	else if($postAuthorUsertype == 'Publisher')	{ $postAuthorDisplayName = $postAuthorPublisherName; }
	else 										{ $postAuthorDisplayName = $postAuthorScreenName; }
}
*/

// DETERMINE WHETHER TO LINK TO POST AUTHOR'S PROFILE
if
(
	$postAuthorShare == true or 
	$postAuthorUsertype == 'Publisher' or 
	($postAuthorUsertype == 'License' and $canEdit == true) or 
	$postType == 'expertreview'
){ $postAuthorLinkTo = true; } else { $postAuthorLinkTo = false; }
?>

<!-- POST ITEM CONTAINER -->
<div id = "community-review-post-<?php echo $postN;?>" class = "<?php echo $postItemClass;?>">

	<!-- AUTHOR -->
	<div class = "exchange-post-author">
		<?php 
		// link to profile if public
		if($postAuthorLinkTo == true)
		{ 
			// determine link parameters based on usertype of post author
			switch($postAuthorUsertype)
			{
				case 'License' 		: $postAuthorLinkType = 'license'; 		$postAuthorLinkID = $postAuthorSiteName; 	break;
				case 'Publisher' 	: $postAuthorLinkType = 'publisher';	$postAuthorLinkID = $postAuthorPublisherID; break;
				case 'Subscriber'	: $postAuthorLinkType = 'subscriber';	$postAuthorLinkID = $postAuthorUserID;		break;
			}
			if($postType == 'expertreview'){ $postAuthorLinkType = 'subscriber'; $postAuthorLinkID = $postAuthorUserID; } // if expert review
			$postAuthorLinkURL = 'profile.php?id='.$postAuthorLinkID.'&type='.$postAuthorLinkType.'&mode=public'; // calculate the url
			echo '<a href = "'.$postAuthorLinkURL.'">'; // output the hyperlink
		} // end if($postAuthorLinkTo == true)
		echo $postAuthorDisplayName;
		if($postAuthorLinkTo == true) { echo '</a>'; }
		?>
	</div>
	
	<!-- DATE & TIME -->
	<?php
	$postTime = date('g:i A', strtotime($postTime));
	?>
	<div class = "exchange-post-date"><?php echo $postDate.' '.$postTime;?></div><div class = "exchange-post-line"></div>
	
	<?php
	// QA FOR A RUBRIC EVALUATION
	if($postRubric != NULL)
	{
		echo '<div>';
		
		// IF USING SAVED RUBRIC
		if($postRubricType == 'saved')
		{
			echo 'Reviewed using the <a href = "rubric-create.php">custom rubric</a> '.$postRubric.'<br/>';
			//echo 'Rubric Name: '.$postRubric.'<br/>';
			$savedRubricID = $postRubricID;
			require 'php/find-savedrubric.php'; // lookup the saved rubric by its id value, get its field values, and parse out each qa
			$customRatings = array(); // declare an array to store the custom ratings
			$crn = -1; // declare a counter to synchronize qa names with their corresponding values
			
			// lookup the value of each rating field by its name - $postType, defined above, is either 'expertreview' or 'comment'
			foreach($selectedQAFields as $thisQAField)
			{
				$crn += 1; // increment the counter
				$thisQAName = $selectedQANames[$crn]; // get the corresponding qa name at this index in the array of qa names
				$thisQARating = $relatedRecord->getField($postType.'s::'.$thisQAField); // get the rating value
				array_push($customRatings, array($thisQAName, $thisQARating)); // update the custom ratings array with both the qa name and the rating
			} // end foreach qa field
			
			// output each rating as a pair of qa name and rating value
			foreach($customRatings as $thisRating)
			{
				$thisRatingQA 		= $thisRating[0];
				$thisRatingValue 	= $thisRating[1]/10;
				//echo $thisRatingQA.': '.$thisRatingValue.'%<br/>';
				echo '<div class = "rating-qa-line">';
					echo '<div class = "inline rating-qa-name">'.$thisRatingQA.'</div>';
					echo '<div class = "inline rating-qa-value">'.$thisRatingValue.'/10</div>';
				echo '</div>'; // /.rating-qa-line
			}
		} // end if saved rubric
		
		// IF USING CTR RUBRIC
		else
		{
			echo 'Reviewed using the <a href = "rubrics.php?rubric='.$postRubric.'&id='.$reviewnumber.'">'.$postRubric.' Rubric</a>';
			$rubricUsed = $postRubric;
			$getSelectedRubric	= true;			// this boolean tells 'php/find-rubrics.php' to lookup a single rubric instead of all rubrics
			$primaryRubric 		= true;			// this boolean tells 'php/get-rubrics' to output the individual qa after the name/score line
			$evalType = 'post';
			if($postType == 'expertreview') { $ratingTable = 'expertreviews'; } else { $ratingTable = 'comments'; }
			require 'php/find-rubrics.php';		// this file looks up either one rubric or all rubrics and gets their qa, storing them in an array
			require 'php/get-rubrics.php';		// this file accesses the stored array of rubrics (in this case, with only 1 item) and outputs its data	
		} // end else ctr rubric
		echo '</div>';
	} // end if($postRubric)
	
	// EDIT RATING, COMMENT
	if($canEdit == true)
	{
		// UPDATE POST FORM
		echo '<form id = "exchange-post-edit-'.$postN.'" method = "POST" action = "exchange-post-process.php">';
			
			// HIDDEN INPUTS
			echo '<input type = "hidden" name = "post-id" value = "'.$postID.'" />'; // POST ID (HIDDEN)
			echo '<input type = "hidden" name = "process-type" value = "update" />'; // PROCESS TYPE - UPDATE (HIDDEN)
			echo '<input type = "hidden" name = "post-type" value = "'.$postType.'" />'; // POST TYPE - expertreview or comment (HIDDEN)
			echo '<input type = "hidden" name = "post-author" value = "'.$postAuthorDisplayName.'" />'; // POST AUTHOR
			echo '<input type = "hidden" name = "title" value = "'.$title.'" />'; // TITLE OF PRODUCT BEING REVIEWED
			echo '<input type = "hidden" name = "redirect" value = "'.$thisURL.'" />'; // REDIRECT - PAGE URL
			
			// RATING
			echo '<div class = "exchange-post-rating">';
				echo '<div class = "inline post-rating-label">Rating: </div>';
				echo '<div class = "inline post-rating-input">';
					echo '<input type = "number" name = "post-rating" value = "'.$postRating.'" min="0" max="100" step="0.01"/>';
				echo '</div>';
				echo '<div class = "inline post-rating-pct">%</div>';
			echo '</div>'; // /.exchange-post-rating
			
			// TEXTAREA
			echo '<div class = "exchange-post-comment">';
				echo '<textarea name = "post-comment" rows = "5" cols = "100" placeholder = "Add a comment...">'.$postComment.'</textarea>';
			echo '</div>'; // /.exchange-post-comment
			
		echo '</form>'; // UPDATE POST FORM END
		
		// UPDATE BUTTON
		echo '<div class = "inline right-10 update-post"><button type = "button" onclick = "updatePost('.$postN.')">Update</button></div>';
		
		// DELETE POST FORM
		echo '<div class = "inline delete-post">';
			echo '<form id = "exchange-post-delete-'.$postN.'" method = "POST" action = "exchange-post-process.php">'; // DELETE FORM START
				echo '<input type = "hidden" name = "post-id" value = "'.$postID.'" />'; // POST ID (HIDDEN)
				echo '<input type = "hidden" name = "process-type" value = "delete" />'; // PROCESS TYPE - DELETE (HIDDEN)
				echo '<input type = "hidden" name = "post-type" value = "'.$postType.'" />'; // POST TYPE - expertreview or comment (HIDDEN)
				echo '<input type = "hidden" name = "post-author" value = "'.$postAuthorDisplayName.'" />'; // POST AUTHOR
				echo '<input type = "hidden" name = "title" value = "'.$title.'" />'; // TITLE OF PRODUCT BEING REVIEWED
				echo '<input type = "hidden" name = "redirect" value = "'.$thisURL.'" />'; // REDIRECT - PAGE URL
				echo '<input type = "hidden" name = "post-rating" value = "'.$postRating.'" />'; // RATING VALUE
				echo '<input type = "hidden" name = "post-comment" value = "'.$postComment.'" />'; // COMMENT
			echo '</form>'; // DELETE FORM END
			echo '<button type = "button" class = "red-btn" onclick = "deletePost('.$postN.')">Delete</button>'; // DELETE BUTTON
		echo '</div>'; // /.inline delete-post
	} // end if($canEdit == true)
	
	// STATIC RATING, COMMENT
	else
	{
		echo '<div class = "'.$postRatingClass.'">Rating: '.$postRating.'%</div>';
		echo '<div class = "'.$postCommentClass.'">'.$postComment.'</div>';
	} // end else cannot edit
	
	?>
	
</div><!-- /#community-review-post-$n -->