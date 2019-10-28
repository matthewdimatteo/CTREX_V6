<!--
php/profiles/subscriber/section-reviews.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the Expert Reviews section of the subscriber profile
-->
<div class = "profile-section-content" id = "profile-section-reviews">
<?php
// PRIVATE PROFILE
if($inputMode == 'private')
{
	// AUTHORED REVIEWS
	if($numCSRreviews > 0)
	{
		// SECTION HEADER
		echo '<div class = "profile-section-header">';
			echo 'Contributed Product Reviews ('.$numCSRreviews.')';
			echo '<br/>';
			echo '(Visible on <a href = "'.$previewLink.'">Public Profile</a> when published)';
		echo '</div>'; // /.profile-section-header
	} // end if $numCSRreviews > 0
	
	// BTN OPTIONS
	echo '<div class = "profile-section-submit-btn">';
		echo '<div class = "inline right-5">';
			echo '<button type = "button" onclick = "window.location.href = \'editorial.php?type=new\'">Enter New</button>';
		echo '</div>';
		echo '<div class = "inline right-5">';
			echo '<button type = "button" onclick = "window.location.href = \'home.php?filter[]=drafts-only&page=1\'">CTR Drafts</button>';
		echo '</div>';
	echo '</div>'; // /.profile-section-submit-btn
	
	// LIST OF AUTHORED REVIEWS
	if($numCSRreviews > 0)
	{
		$csrReviewN = 0; // declare a counter to define unique element ids
		echo '<div class = "paragraph-90 left">'; // container for the list of authored reviews
			foreach($csrReviewsArray as $thisCSRreview)
			{
				$thisCSRreviewID 	= $thisCSRreview[0];
				$thisCSRreviewTitle = $thisCSRreview[1];
				$thisCSRreviewDate	= $thisCSRreview[2];
				$thisCSRreviewStatus= $thisCSRreview[3];
				$thisCSRreviewLink 	= $thisCSRreview[4];

				// ROW FOR EACH AUTHORED REVIEW
				echo '<div class = "profile-section-row profile-saved-item-row">';
					echo '<div class = "text-18"><a href = "'.$thisCSRreviewLink.'">'.$thisCSRreviewTitle.'</a></div>';
					echo '<div class = "text-12">';
						if($thisCSRreviewDate != NULL) { echo '<div class = "inline right-10">Entered '.$thisCSRreviewDate.'</div>'; }
						echo '<div class = "inline right-10">Status: '.$thisCSRreviewStatus.'</div>';
						echo '<div class = "inline right-10"><a href = "editorial.php?id='.$thisCSRreviewID.'&type=edit">Edit</a></div>';
					echo '</div>'; // /.text-12
				echo '</div>'; // /.profile-section-row profile-saved-item-row
				echo '<div class = "bottom-10"></div>';
				
			} // end foreach $csrReviewsArray
		echo '</div>'; // /.paragraph-90 left
	} // end if $numCSRreviews > 0
	
	// EXPERT COMMENTARY ON EXISTING REVIEWS
	if($numExpertReviews > 0)
	{
		// SECTION HEADER
		echo '<div class = "profile-section-header">';
			echo 'Commentary on Existing Reviews ('.$numExpertReviews.')';
			echo '<br/>';
			echo '(Visible on <a href = "'.$previewLink.'">Public Profile</a> when published)';
		echo '</div>'; // /.profile-section-header
		
		// LIST OF EXPERT COMMENTARY ON EXISTING REVIEWS
		$expertReviewN = 0; // declare a counter to define unique element ids
		echo '<div class = "paragraph-90 left">'; // container for the list of expert reviews
			foreach($expertReviewsArray as $thisExpertReview)
			{
				$thisExpertReviewID 		= $thisExpertReview[0];
				$thisExpertReviewTitleID 	= $thisExpertReview[1];
				$thisExpertReviewTitle	 	= $thisExpertReview[2];
				$thisExpertReviewTitleStatus= $thisExpertReview[3];
				$thisExpertReviewDate 		= $thisExpertReview[4];
				$thisExpertReviewTime 		= $thisExpertReview[5];
				
				// ROW FOR EACH EXPERT REVIEW
				echo '<div class = "profile-section-row profile-saved-item-row">';
					echo '<div class = "text-18"><a href = "review.php?id='.$thisExpertReviewTitleID.'">'.$thisExpertReviewTitle.'</a></div>';
					echo '<div class = "text-12">';
						if($thisExpertReviewDate != NULL)
						{
							echo 'Posted on '.$thisExpertReviewDate;
							//if($thisExpertReviewTime != NULL) { echo ' at '.$thisExpertReviewTime; }
						} // end if $thisExpertReviewDate != NULL
					echo '</div>'; // /.text-12
				echo '</div>'; // /.profile-section-row profile-saved-item-row
				echo '<div class = "bottom-10"></div>';
				
			} // end foreach $expertReviewsArray
		echo '</div>'; // /.paragraph-90 left
	} // end if $numExpertReviews > 0
	
} // end if $inputMode == 'private'

// PUBLIC PROFILE
else if($inputMode == 'public')
{
	// (PUBLISHED)AUTHORED REVIEWS
	if($numCSRreviewsPublished > 0)
	{
		// SECTION HEADER
		echo '<div class = "profile-section-header">';
			echo 'Contributed Product Reviews ('.$numCSRreviewsPublished.')';
		echo '</div>'; // /.profile-section-header
		
		// LIST OF (PUBLISHED) AUTHORED REVIEWS
		$csrReviewN = 0; // declare a counter to define unique element ids
		echo '<div class = "paragraph-90 left">'; // container for the list of authored reviews
			foreach($csrReviewsArray as $thisCSRreview)
			{
				$thisCSRreviewID 	= $thisCSRreview[0];
				$thisCSRreviewTitle = $thisCSRreview[1];
				$thisCSRreviewDate	= $thisCSRreview[2];
				$thisCSRreviewStatus= $thisCSRreview[3];
				$thisCSRreviewLink 	= $thisCSRreview[4];

				// ROW FOR EACH (PUBLISHED) AUTHORED REVIEW
				if($thisCSRreviewStatus == 'Published')
				{
					echo '<div class = "profile-section-row profile-saved-item-row">';
						echo '<div class = "text-18"><a href = "'.$thisCSRreviewLink.'">'.$thisCSRreviewTitle.'</a></div>';
						echo '<div class = "text-12">';
							if($thisCSRreviewDate != NULL) { echo '<div class = "inline right-10">Entered '.$thisCSRreviewDate.'</div>'; }
						echo '</div>'; // /.text-12
					echo '</div>'; // /.profile-section-row profile-saved-item-row
					echo '<div class = "bottom-10"></div>';
				} // end if $thisCSRreviewStatus == 'published'
			} // end foreach $csrReviewsArray
		echo '</div>'; // /.paragraph-90 left
		
	} // end if $numCSRreviewsPublished > 0
	
	// (PUBLISHED) EXPERT COMMENTARY ON EXISTING REVIEWS
	if($numExpertReviewsPublished > 0)
	{
		// SECTION HEADER
		echo '<div class = "profile-section-header">';
			echo 'Expert Commentary on Existing Reviews ('.$numExpertReviewsPublished.')';
		echo '</div>'; // /.profile-section-header
		
		// LIST OF (PUBLISHED) EXPERT REVIEWS
		$expertReviewN = 0; // declare a counter to define unique element ids
		echo '<div class = "paragraph-90 left">'; // container for the list of expert reviews
			foreach($expertReviewsArray as $thisExpertReview)
			{
				$thisExpertReviewID 		= $thisExpertReview[0];
				$thisExpertReviewTitleID 	= $thisExpertReview[1];
				$thisExpertReviewTitle	 	= $thisExpertReview[2];
				$thisExpertReviewTitleStatus= $thisExpertReview[3];
				$thisExpertReviewDate 		= $thisExpertReview[4];
				$thisExpertReviewTime 		= $thisExpertReview[5];
				
				// ROW FOR EACH (PUBLISHED) EXPERT REVIEW
				if($thisExpertReviewTitleStatus != NULL)
				{
					echo '<div class = "profile-section-row profile-saved-item-row">';
						echo '<div class = "text-18"><a href = "review.php?id='.$thisExpertReviewTitleID.'">'.$thisExpertReviewTitle.'</a></div>';
						echo '<div class = "text-12">';
							if($thisExpertReviewDate != NULL)
							{
								echo 'Posted on '.$thisExpertReviewDate;
								//if($thisExpertReviewTime != NULL) { echo ' at '.$thisExpertReviewTime; }
							} // end if $thisExpertReviewDate != NULL
						echo '</div>'; // /.text-12
					echo '</div>'; // /.profile-section-row profile-saved-item-row
					echo '<div class = "bottom-10"></div>';
				} // end if $thisExpertReviewTitleStatus != NULL
			} // end foreach $expertReviewsArray
		echo '</div>'; // /.paragraph-90 left
		
	} // end if $numExpertReviewsPublished > 0
} // end else if $inputMode == 'public'
?>
</div><!-- /.profile-section-content #profile-section-reviews -->