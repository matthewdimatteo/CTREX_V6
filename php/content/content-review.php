<?php
/*
php/content-review.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the review page, included dynamically in 'php/content.php'
It contains the html for outputting the review page

The review is first looked up in 'php/load-review.php'
Certain data is formatted in 'php/get-review.php' and php/review-format.php' which are included in 'php/load-review.php'

The structure of the page includes two columns: a larger left side column for text (title, info, review), and a right column for images, video, download links
If no right side media are available for the review, 'php/review-format.php' defines the CSS class for the left column to take the full page width
*/

require_once 'php/load-review.php';	// load the review if an id # is specified; otherwise, return home

// ADD PRODUCT TITLE TO PAGE TITLE
if($title != NULL) 
{ 
	if($pageTitle == NULL) { $pageTitle = 'CTREX Review'; }
	$pageTitle .= ' - '.$title;
	echo '<script>setPageTitle(\''.$pageTitle.'\');</script>';
} // end if $title

// CHECK CONFIRMATION FOR QUICK-EDIT, EDITORIAL PANEL EDIT
$quickEditConfirmation = $_SESSION['quick-edit-confirmation']; 		// check the confirmation flag for a quick edit
$_SESSION['quick-edit-confirmation'] = ''; 							// reset the flag

$editorialConfirmation = $_SESSION['editorial-confirmation']; 		// check confirmation flag for editorial panel edit
$_SESSION['editorial-confirmation'] = ''; 							// reset the flag

// whether to show confirmation
if($quickEditConfirmation == true or $editorialConfirmation == true) { $editConfirmationClass = 'show'; } else { $editConfirmationClass = 'hide'; } 
?>

<!-- PAGE CONTENT CONTAINER START -->
<div class = "review-container">

	<!-- DETAILS -->
	<div class = "<?php echo $reviewDetailsClass;?>" id = "review-details">
	
		<!-- QUICK EDIT CONFIRMATION -->
		<div class = "<?php echo $editConfirmationClass;?>">
			<div class = "confirmation-message text-24">Review Saved Successfully</div>
		</div><!-- /.$quickEditConfirmationClass (show/hide) -->
	
		<?php require_once 'php/review-title.php'; // title and copyright info ?>
		
		<!-- PRODUCT INFO -->
		<div class = "review-product-info"><?php require_once 'php/result-item-info.php';?></div>
		
		<!-- REVIEW HEADING -->
		<div class = "review-heading">CTR Review</div>
		
		<!-- REVIEW AUTHOR -->
		<div class = "<?php echo $reviewAuthorClass;?>" id = "review-author"><?php echo $authorText;?></div>
		
		<!-- REVIEW ENTRY DATE -->
		<div class = "<?php echo $reviewDateClass;?>" id = "review-date"><?php echo $entered;?></div>
		
		<!-- RATING -->
		<div class = "<?php echo $ratingLineClass;?>" id = "rating-line">
			<?php require_once 'php/rating.php';?>
		</div>
		
		<?php
		// EDITORIAL CONTROLS (FOR EXPERTS OR MODS ONLY)
		if
		(
			$expert == true or 
			$mod == true or 
			($juror == true and $authorID == $userID) or 
			($juror == true and $bolognaYear == $year) or 
			($juror == true and $kapiYear == $year)
		)
		{
		
			// ENTER QUICK EDIT MODE
			echo '<div class = "editorial-controls bottom-10">';
				echo '<div class = "inline right-10">';
					echo '<div id = "show-quick-edit"><button type = "button" onclick = "quickEditShow()">Enter Quick-Edit Mode</button></div>';
					echo '<div id = "cancel-quick-edit" class = "hide"><button type = "button" onclick = "quickEditCancel()">Discard Changes</button></div>';
				echo '</div>'; // /.inline right-10
				
				echo '<div class = "inline">';
					echo '<div id = "commit-quick-edit" class = "hide">';
						echo '<div class = "inline right-10"><button type = "button" onclick = "quickEditCommit()">Save Changes</button></div>';
					echo '</div>'; // /.hide
				echo '</div>'; // /.inline
				
				// OPEN IN EDITOR'S PANEL
				echo '<div class = "inline">';
					echo '<button type = "button" onclick = "window.location.href = \'editorial.php?id='.$reviewnumber.'&type=edit\';">';
						echo 'Open in Editor\'s Panel';
					echo '</button>';
				echo '</div>'; // /.inline
				
			echo '</div>'; // /.editorial-controls
		} // end if $expert == true or $mod == true
		
		// STUDENT CONTROLS (FOR STUDENTS WHO ARE AUTHOR ONLY)
		if($student == true and $authorID == $userID)
		{
			echo '<div class = "editorial-controls bottom-10">';
				echo '<button type = "button" onclick = "window.location.href = \'editorial.php?id='.$reviewnumber.'&type=edit\';">';
					echo 'Open in Student Editorial Panel';
				echo '</button>';
			echo '</div>'; // /.editorial-controls
		} // end if $student == true and $authorID == $userID
		?>
		
		<!-- REVIEW TEXT -->
		<div class = "<?php echo $reviewTextClass;?>" id = "review-text"><?php echo $reviewTextParsed;?></div>
		
		<!-- REVIEW TEXT QUICK-EDIT -->
		<div id = "review-text-quick-edit" class = "hide">
			<div class = "editorial-review">
				<form name = "review-quick-edit-form" id = "review-quick-edit-form" method = "POST" action = "editorial-process.php">
					<div class = "hide">
						<input type = "hidden" name = "title" 		value = "<?php echo $title;?>" />
						<input type = "hidden" name = "review-id" 	value = "<?php echo $reviewID;?>" />
						<input type = "hidden" name = "initial-text"value = "<?php echo $reviewText;?>" />
					</div><!-- /.hide -->
					<textarea name="review-quick-edit" id="quick-edit-textarea" rows="10" cols="50" placeholder="Write your review..."><?php echo $reviewText;?></textarea>
				</form>
			</div><!-- /.editorial-review -->
			<div class = "hide" id = "review-text-pre-edit"><?php echo $reviewText;?></div>
		</div><!-- /#review-text-quick-edit-->
		
		<!-- SHARE BTNS -->
		<?php require_once 'php/review-share.php'; ?>
		
		<!-- 
		VELVET ROPE BUTTON 
		The function 'loginforReview(reviewnumber)' sends the user to the page 'login.php' with special parameters containing this review's url
		If the user proceeds to login, the pages 'login.php' and 'login-process.php' are configured to redirect the user back to this review page
		$velvetRopeLink is defined in 'php/get-review.php' to be 'login.php?target=review&redirect='.urlencode($reviewLink)
		-->
		<div class = "<?php echo $reviewVelvetRopeClass;?>" id = "review-velvet-rope">
			<button type = "button" onclick = "openURL('<?php echo $velvetRopeLink;?>')">Log in as a subscriber to see the full review</button>
		</div><!-- /#review-velvet-rope -->
		
	</div><!-- /#review-details -->
	
	<!-- MEDIA -->
	<div class = "<?php echo $reviewMediaClass;?>" id = "review-media">
	
		<!-- IMAGE GALLERY -->
		<?php require_once 'php/review-images.php';?>
		
		<!-- VIDEO -->
		<div class = "<?php echo $reviewVideoClass;?>" id = "review-video">
			<?php echo '<iframe src = "'.$vidURL.'"></iframe>'; ?>
		</div><!-- /#review-video -->
		
		<!-- DOWNLOAD LINKS -->
		<div class = "<?php echo $reviewDownloadLinksClass;?>" id = "review-download-links">
			<div class = "review-download-links-heading">Download Links</div>
			<div class = "review-download-links-thumbs">
			<?php
			foreach($downloadLinks as $downloadLink)
			{
				$appStoreName 	= $downloadLink[0];
				$appStoreURL	= $downloadLink[1];
				$appStoreThumb = 'images/'.$appStoreName.'32.png';
				//echo '<a href = "'.$appStoreURL.'">'.$appStoreThumb.'</a><br/>';
				if($appStoreURL != NULL)
				{ 
					echo '<div class = "review-download-links-thumb">';
						echo '<a href = "'.$appStoreURL.'" target = "_blank"><img src = "'.$appStoreThumb.'" alt = "'.$appStoreThumb.'"></a>'; 
					echo '</div>';
				}
			}
			?>
			</div><!-- /.review-download-links-thumbs -->
			<div class = "review-download-links-disclaimer">
				These links will take you to an external app store.<br/>
				CTR has no commercial connections.
			</div>
		</div><!-- /#review-download-links -->
		
	</div><!-- /#review-media -->
	
</div><!-- /.review-container -->

<!-- REVIEW EXCHANGE -->
<div class = "review-exchange-container">
	
	<div class = "<?php echo $reviewExchangeClass;?>" id = "review-exchange">

		<!-- COMMENT FORM -->
		<?php require_once 'php/review-exchange-comment-form.php'; ?>

		<!-- EXPERT REVIEWS -->
		<div class = "<?php echo $expertReviewsClass;?>" id = "comments-experts">

			<!-- EXPERT REVIEWS HEADING -->
			<div class = "review-heading"><?php echo $expertReviewCount;?> Expert Review<?php if($expertReviewCount != 1) { echo 's'; } ?></div>

			<!-- EXPERT REVIEWS FEED CONTAINER -->
			<div id = "expert-reviews-container">
			<?php
			if($expertReviewCount > 0 and $expertReviews != NULL)
			{
				$postN = 0;
				$relatedFields = $relatedExpertReviewFields; // informs 'php/get-field-related.php' which set of fields to use
				foreach($expertReviews as $relatedRecord) { require 'php/review-exchange-post.php'; }
			} // end if $expertReviews
			?>
			</div><!-- /#expert-reviews-container -->

		</div><!-- /#comments-experts -->

		<!-- COMMUNITY REVIEWS -->
		<div class = "<?php echo $communityReviewsClass;?>" id = "comments-community">

			<!-- COMMUNITY REVIEWS HEADING -->
			<div class = "review-heading"><?php echo $commentCount;?> Community Review<?php if($commentCount != 1) { echo 's'; } ?></div>

			<!-- COMMUNITY REVIEWS FEED CONTAINER -->
			<div id = "community-reviews-container"><?php
			if($commentCount > 0 and $communityReviews != NULL)
			{
				$postN = 0;
				$relatedFields = $relatedCommentFields; // informs 'php/get-field-related.php' which set of fields to use
				foreach($communityReviews as $relatedRecord) { require 'php/review-exchange-post.php'; }
			} // end if $communityReviews
			?>
			</div><!-- /#community-reviews-container -->

		</div><!-- /#comments-community -->

	</div><!-- /#review-exchange -->
		
</div><!-- /.review-exchange-container -->