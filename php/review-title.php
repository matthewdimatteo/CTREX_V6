<!--
php/review-title.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the title and copyright/publisher info on the review page
It is included in the file 'php/content/content-review.php'

CSS classes are calculated in 'php/review-format.php'
The file 'php/company-links.php' determines the correct publisher id (in the event of duplicate related publishers) and outputs links
-->

<!-- TITLE -->
<div class = "<?php echo $reviewTitleClass;?>">
	<?php 
	if($pageType != 'review') 	{ echo '<a href = "review.php?id='.$reviewID.'" title = "Back to review">'.$title.'</a>'; }
	else 						{ echo $title; }
	if($published != true) { echo ' [Draft]'; } 
	?>
</div>

<!-- COPYRIGHT LINE -->
<div class = "<?php echo $reviewCopyrightClass;?>" id = "review-publisher-container">
	<div class = "review-copyright-line">
		<?php 
		echo $copyrightLine; // copyright date and publisher name
		require_once 'php/company-links.php'; // determine correct publisher id, display the links to publisher website, CTREX profile, more titles
		?>
	</div><!-- /.review-copyright-line -->
	
	<!--
	<div class = "<?php echo $reviewPublisherInfoToggleClass;?>" id = "review-publisher-info-toggle">
		<div id = "review-publisher-info-show-<?php echo $n;?>" 				
			onclick = "showItemN('review-publisher-info-show-', 'review-publisher-info-hide-', 'review-publisher-info-', <?php echo $n;?>)">&#9660;</div>
		<div id = "review-publisher-info-hide-<?php echo $n;?>" class = "hide" 	
			onclick = "hideItemN('review-publisher-info-show-', 'review-publisher-info-hide-', 'review-publisher-info-', <?php echo $n;?>)">&#9650;</div>
	</div>
	--><!-- /#review-publisher-info-toggle -->
	
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