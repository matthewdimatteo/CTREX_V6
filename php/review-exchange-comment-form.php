<!-- 
php/review-exchange-comment-form.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the comment form on the review page
It is included in the file 'php/content/content-review.php'

The containing <div> element is set to show or hide via the $reviewCommentClass variable, determined in 'php/review-format.php'
The form consists of a heading, instructions, a textarea, and a rating slider, with increment/decrement/reset buttons
There is also a post preview generated with the JS function postPreview(), found in 'js/scripts.php'
-->

<!-- YOUR TURN -->
<div class = "<?php echo $reviewCommentClass;?>" id = "comment">

	<!-- COMMENT HEADING -->
	<div class = "review-heading">Your Turn</div>

	<!-- COMMENT INFO -->
	<div id = "review-comment-info">
		Anyone can leave a comment or review. Publishers can respond or add details.<br/>
		Please note that your screen name will be included in your post. You can <a href = "<?php echo $profileURL;?>">edit this info on your profile page</a>.<br/>
		You can edit or remove this post at any time. CTR reserves the right to delete any post.
	</div><!-- /#review-comment-info -->

	<!-- COMMENT FORM -->
	<div id = "review-comment-form-container" class = "bottom-20">
		<form name = "review-comment-form" id = "review-comment-form" method = "POST" action = "review-process.php">

			<!-- TEXTAREA -->
			<div class = "top-10 bottom-10" id = "review-comment-textarea-container">
				<textarea name = "evaluation-review" id = "review-comment-textarea" rows = "6" required onKeyUp = "postPreview()" placeholder = "Join the exchange..."></textarea>
			</div><!-- /#review-comment-textarea-container -->

			<div class = "center top-10 bottom-10">
				Leave a rating (optional)
			</div>

			<!-- RATING SLIDER -->
			<div id = "review-rating-container">

				<!-- RESET -->
				<div class = "inline left" id = "review-rating-col-reset">
					<div class = "inline pointer"><img id = "quick-rating-reset" src = "images/reset.png" width = "24" height = "24" onclick = "quickRatingReset()"/></div>
					<div class = "inline"><div class = "btn-text" onclick = "quickRatingReset()">Reset</div></div>
				</div><!-- /#review-rating-col-reset -->

				<!-- CENTER COL -->
				<div class = "inline center" id = "review-rating-col-slider">
					<div class = "bottom-10">
						<input type = "range" name = "rating" id = "quick-rating-slider" min = "0" max = "100" step = "1" 
							onchange = "quickRatingOutput()"/>

						<!-- HIDDEN INPUTS -->
						<input type = "hidden" name = "submission-type" 		value = "quick-rating" />
						<input type = "hidden" name = "redirect" 				value = "<?php echo $thisURL;?>" />
						<input type = "hidden" name = "review-id" 				value = "<?php echo $reviewnumber;?>" />
						<input type = "hidden" name = "evaluated-title" 		value = "<?php echo $title;?>" />
						<input type = "hidden" name = "evaluation-rubric" 		value = "" />
						<input type = "hidden" name = "num-qa" 	id = "num-qa" 	value = "0" />
						<input type = "hidden" name = "score" 	id = "quick-rating-score" />

					</div>
					<div><?php require_once 'php/range-steps.php';?></div>
				</div><!-- /#review-rating-col-slider -->

				<!-- INC/DEC -->
				<div class = "inline left" id = "review-rating-col-inc-dec">
					<div class = "quick-rating-inc-dec"><button type = "button" onclick = "quickRatingInc('inc')">+</button></div>
					<div class = "quick-rating-inc-dec"><button type = "button" onclick = "quickRatingInc('dec')">-</button></div>
				</div><!-- /#review-rating-col-inc-dec -->

				<!-- RIGHT COL -->
				<div class = "inline right" id = "review-rating-col-output">
					<div id = "quick-rating-output" class = "text-30"></div>
				</div><!-- /#review-rating-col-output -->

			</div><!-- /#review-rating-container -->

			<!-- CAPTCHA / SUBMIT -->
			<div class = "center top-20" id = "quick-rating-submit-area">
				<div class = "width-40 inline" id = "quick-rating-captcha">
				<?php 
				$includeSubmit 	= true;
				$submitBtnName 	= 'quick-rating-submit';
				$submitBtnLabel = 'Post';
				require_once 'php/captcha-min.php'; 
				?>
				</div><!-- /#quick-rating-captcha -->
			</div><!-- /#quick-rating-submit-area -->

		</form>
	</div><!-- /#review-comment-form-container -->

	<!-- FLEX RUBRIC LINK -->
	<div class = "center bottom-20">
		<a href = "rubrics.php?id=<?php echo $reviewnumber;?>" title = "Use the CTR Flex-Rubric system to evaluate according to specific criteria">
			Submit a detailed evaluation using a rubric
		</a>
	</div><!-- /flex-rubric link -->

	<!-- POST PREVIEW -->
	<div id = "post-preview" class = "hide">
		<div class = "bold bottom-10">Here's how your post will appear when published:</div>
		<div class = "post-heading">
			<div>
				<?php 
				if($share == true) { echo '<a href = "'.$publicProfileURL.'">'; }
				echo $displayName;
				if($share == true) { echo '</a>'; }
				?>
			</div>
			<div class = "text-12"><?php echo $dateConv;?></div>
		</div><!-- /.post-heading -->
		<div class = "post-content">
			<div class = "post-rating"  id = "post-preview-rating"></div>
			<div class = "post-comment" id = "post-preview-comment"></div>
		</div><!-- /.post-content -->
	</div><!-- /#post-preview -->

</div><!-- /#comment -->