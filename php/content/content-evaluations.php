<?php
/*
php/content-evaluations.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the product evaluations page, included dynamically in 'php/content.php'
It contains the html for outputting the evaluations page

The review is first looked up in 'php/load-review.php'
Certain data is formatted in 'php/get-review.php' and php/review-format.php' which are included in 'php/load-review.php'
*/

require_once 'php/load-review.php';		// load the review if an id # is specified; otherwise, return home
?>
<!-- PAGE CONTENT CONTAINER START -->
<div class = "review-container">

	<!-- DETAILS -->
	<div class = "review-details-block" id = "review-details">
	
		<!-- TITLE -->
		<div class = "<?php echo $reviewTitleClass;?>"><?php echo $title; if($published != true) { echo ' [Draft]'; } ?></div>
		
		<!-- COPYRIGHT LINE -->
		<div class = "<?php echo $reviewCopyrightClass;?>" id = "review-publisher-container">
			<div class = "review-copyright-line"><?php echo $copyrightLine;?></div>
			<div class = "<?php echo $reviewPublisherInfoToggleClass;?>" id = "review-publisher-info-toggle">
				<div id = "review-publisher-info-show-<?php echo $n;?>" 				
					onclick = "showItemN('review-publisher-info-show-', 'review-publisher-info-hide-', 'review-publisher-info-', <?php echo $n;?>)">&#9660;</div>
				<div id = "review-publisher-info-hide-<?php echo $n;?>" class = "hide" 	
					onclick = "hideItemN('review-publisher-info-show-', 'review-publisher-info-hide-', 'review-publisher-info-', <?php echo $n;?>)">&#9650;</div>
			</div><!-- /#review-publisher-info-toggle -->
		</div><!-- /#review-publisher-container -->
		
		<!-- 
		PUBLISHER LINKS 
		These are hidden by default - visibility is toggled by pressing the caret buttons above
		-->
		<div class = "hide" id = "review-publisher-info-<?php echo $n;?>">
			<div class = "review-publisher-info">
				<div class = "<?php echo $publisherWebsiteClass;?>" id = "publisher-website-link">
					<a href = "<?php echo $publisherWebsiteLink;?>" title = "<?php echo $publisherWebsiteTitle;?>" target = "_blank">Website</a>
				</div>
				<div class = "<?php echo $publisherProfileClass;?>" id = "publisher-profile-link">
					<a href = "<?php echo $publisherProfileLink;?>" title = "<?php echo $publisherProfileTitle;?>">CTREX Profile</a>
				</div>
				<div class = "review-publisher-link" 				id = "publisher-titles-link">
					<a href = "<?php echo $publisherTitlesLink;?>" title = "<?php echo $publisherTitlesTitle;?>">More Titles</a>
				</div>
			</div>
		</div><!-- /#review-publisher-info -->
		
		<!-- PRODUCT INFO -->
		<div class = "review-product-info"><?php require_once 'php/result-item-info.php';?></div>
		<div class = "review-heading bottom-20">All Evaluations</div>
		<?php require_once 'php/ratings-all.php';?>
		
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
		
		<!-- REVIEW TEXT -->
		<div class = "<?php echo $reviewTextClass;?>" id = "review-text"><?php echo $reviewTextParsed;?></div>
		
		<!-- 
		VELVET ROPE BUTTON 
		The function 'loginforReview(reviewnumber)' sends the user to the page 'login.php' with special parameters containing this review's url
		If the user proceeds to login, the pages 'login.php' and 'login-process.php' are configured to redirect the user back to this review page
		$velvetRopeLink is defined in 'php/get-review.php' to be 'login.php?target=review&redirect='.urlencode($reviewLink)
		-->
		<div class = "<?php echo $reviewVelvetRopeClass;?>" id = "review-velvet-rope">
			<button type = "button" onclick = "openURL('<?php echo $velvetRopeLink;?>')">Log in as a subscriber to see the full review</button>
		</div>
		
	</div><!-- /#review-details -->
	
</div><!-- /.review-container -->