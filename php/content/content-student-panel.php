<?php
/*
php/content/content-juror-panel.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the juror's panel page (for evaluating products for awards)
*/

// gate out anyone who is not an expert or a moderator
if($expert != true and $mod != true and $student != true) { $redirect = 'home.php'; require_once 'php/redirect.php'; exit(); } 

// load the review
require_once 'php/load-review.php';
?>

<!-- PAGE CONTENT CONTAINER START -->
<div class = "review-container">
	
	<!-- DETAILS -->
    <div class = "<?php echo $reviewDetailsClass;?>" id = "review-details">

		<!-- EDITORIAL INDICATOR -->
		<div class = "editorial-heading">
			Evaluating as 
			<?php if($mod == true) { echo 'Moderator '; } else if ($expert == true) { echo 'Expert '; } else if ($student == true) { echo 'Student '; } 
			echo '<a href = "'.$profileURL.'">'.$fullName.'</a>'; ?>
		</div><!-- /.editorial-heading -->

		<!-- TITLE AND COPYRIGHT INFO -->
		<?php  require_once 'php/review-title.php'; // title and copyright info ?>

		<!-- PRODUCT INFO -->
		<div class = "review-product-info"><?php require_once 'php/result-item-info.php';?></div>
		
		<!-- WRITE REVIEW HEADING -->
		<div class = "review-heading bottom-10">Juror Notes</div>

		<!-- REVIEW -->
		<div class = "juror-notes">
			<textarea name = "juror-notes" id = "juror-notes" rows = "10" cols = "50" placeholder = "Add notes..."><?php echo $jurorComments;?></textarea>
		</div><!-- /.editorial-review -->

	</div><!-- /#review-details -->
	
	<!-- IMAGE GALLERY -->
	<div class = "<?php echo $reviewMediaClass;?>" id = "review-media"><?php require_once 'php/review-images.php'; ?></div>
	
	<!-- STANDARD RATING HEADING -->
	<div class = "review-heading bottom-10">Standard Evaluation</div>
	<?php
	$rubricUsed = 'Standard';
	$getSelectedRubric	= true;			// this boolean tells 'php/find-rubrics.php' to lookup a single rubric instead of all rubrics
	$primaryRubric 		= true;			// this boolean tells 'php/get-rubrics' to output the individual qa after the name/score line
	require 'php/find-rubrics.php';		// this file looks up either one rubric or all rubrics and gets their qa, storing them in an array
	require 'php/rating-qa-standard.php'; // outputs separate qa set for standard rubric evaluation
	?>

	<!-- ADDITIONAL RUBRICS RATING HEADING -->
	<div class = "review-heading bottom-10">Rubric Evaluation</div>
	<?php 
	//echo '$rubricsText: '.$rubricsText.'<br/>'; echo '$rubricsTextArray: '.$rubricsTextArray.'<br/>'; echo '$numRubricsSelected: '.$numRubricsSelected.'<br/>';
	$editorialRubric = $rubricsTextArray[0]; // load the first rubric in the form
	require_once 'php/get-rubric-saved.php'; 	// process rubric selection forms
	//echo '$rubricUsed: '.$rubricUsed.'<br/>'; echo '$ctrRubric: '.$ctrRubric.'<br/>';
	require_once 'php/rubric-controls.php'; 	// this file contains all of the rubric evaluation tool content 
	?>
		
</div><!-- /.review-container -->