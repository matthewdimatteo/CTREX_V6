<?php
/*
php/result-item-pub-grid.php
By Matthew DiMatteo, Children's Technology Review

This file outputs an individual publisher record as part of a grid view in the results feed on the publisher directory page
It is included in 'php/content/content-publishers.php'
*/
require 'php/result-item-pub-info.php'; // calculate links, labels, and hover text
?>

<div class = "result-item-grid-col">
<a href = "<?php echo $pubProfileURL;?>" title = "<?php echo $pubProfileHover;?>">
<div class = "result-item-grid">
	
	<!-- PHOTO OF LATEST PRODUCT REVIEWED -->
	<div class = "result-item-grid-photo">
		<?php
		if($firstImg != NULL and $firstImgData != '?') 	{ echo '<img src = "php/img.php?-url='.urlencode($firstImg).'" alt = "Image not available">';	}
		else 											{ echo '<div class = "no-image-grid"><div class = "no-image-grid-text">Image not available</div></div>'; }
		?>
	</div><!-- /.result-item-grid-photo -->

	<!-- HEADING WITH COMPANY NAME -->
	<div class = "result-item-grid-title">
		<?php
		echo $companyGridText;
		if($dateEntered != NULL) { echo '<div class = "result-item-grid-copyright">Entered '.$dateEntered.'</div>'; }
		?>
	</div><!-- /.result-item-grid-title -->
	
</div><!-- /.result-item-grid -->
</a>

<!-- TOGGLE DETAILS BTN -->
<div class = "result-item-grid-expand">
	
	<!-- NUMBER OF TITLES REVIEWED -->
	<div class = "inline">
		<div class = "text-14 top-5">
		<?php 
		echo '<a href = "'.$moreTitlesURL.'" title = "'.$moreTitlesHover.'">';
			echo $numTitlesReviewed.' Title'; if($numTitlesReviewed != 1) { echo 's'; } echo ' Reviewed'; 
		echo '</a>';
		?>
		</div><!-- /.text-14 top-5 -->
	</div><!-- /.inline -->
	
	<!-- TOGGLE BTN -->
	<div class = "inline">
	
		<!-- SHOW -->
		<div id = "show-details-<?php echo $rg;?>" >
			<img src = "images/expand-dark.png" title = "Show product details" 
				onclick = "showItemN('show-details-', 'hide-details-', 'result-item-grid-details-', <?php echo $rg;?>)"/>
		</div><!-- /show -->

		<!-- HIDE -->
		<div id = "hide-details-<?php echo $rg;?>" class = "hide" >
			<img src = "images/collapse-dark.png" title = "Hide product details" 
				onclick = "hideItemN('show-details-', 'hide-details-', 'result-item-grid-details-', <?php echo $rg;?>)"/>
		</div><!-- /hide -->
		
	</div><!-- /.inline -->
	
</div><!-- /.result-item-grid-expand -->

<!-- DETAILS -->
<div class = "hide" id = "result-item-grid-details-<?php echo $rg;?>">
	<div class = "result-item-grid-details">
		<?php 
		$titleListMax = 3; // number of titles to display
		if($numTitlesReviewed < $titleListMax) { $titleListMax = $numTitlesReviewed; }
		for($t = 0; $t < $titleListMax; $t++)
		{
			$titleInfo = $titlesReviewedArray[$t];
			$titleID		= $titleInfo[0];
			$titleName		= $titleInfo[1];
			$titleCopyright = $titleInfo[2];
			$titleEntered	= $titleInfo[3];
			$titlePublished = $titleInfo[4];
			$titleLink		= 'review.php?id='.$titleID;
			if($titleCopyright != NULL) { $titleText = '&copy; '.$titleCopyright.' '.$titleName; } else { $titleText = $titleName; }
			
			// trim title text to fit grid view (mex lengths var values declared in 'php/result-item-pub-info.php')
			$titleText 		= trimText($titleText, $titleGridMax);
			$titleText1025 	= trimText($titleText, $titleGridMax1025);
			$titleText769 	= trimText($titleText, $titleGridMax769);
			$titleText480 	= trimText($titleText, $titleGridMax480);
			
			echo '<div class = "show-only-desktop">';
				echo '<a href = "'.$titleLink.'" title = "Read our review of '.$titleName.'">';
					echo $titleText;
				echo '</a>';
			echo '</div>';
			echo '<div class = "show-only-1025">';
				echo '<a href = "'.$titleLink.'" title = "Read our review of '.$titleName.'">';
					echo $titleText1025;
				echo '</a>';
			echo '</div>';
			echo '<div class = "show-only-769">';
				echo '<a href = "'.$titleLink.'" title = "Read our review of '.$titleName.'">';
					echo $titleText769;
				echo '</a>';
			echo '</div>';
			echo '<div class = "show-only-480">';
				echo '<a href = "'.$titleLink.'" title = "Read our review of '.$titleName.'">';
					echo $titleText480;
				echo '</a>';
			echo '</div>';
		} // end for
		if($numTitlesReviewed > $titleListMax)
		{
			echo '<a href = "'.$moreTitlesURL.'" title = "'.$moreTitlesHover.'">See all</a>';
		}
		?>
	</div><!-- /.result-item-grid-details -->
</div><!-- /.hide -->

</div><!-- /.result-item-grid-col -->
