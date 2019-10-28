<?php
/*
php/result-item-grid.php
By Matthew DiMatteo, Children's Technology Review

This file outputs an individual review as part of a grid view in the results feed on the home page
It is included in 'php/search-reviews.php'
*/
require 'php/result-item-text.php'; // handles text values for non-relevance sorted sets
?>

<div class = "result-item-grid-col">
<a href = "review.php?id=<?php echo $reviewnumber;?>" title = "<?php echo $reviewHover;?>">
<div class = "result-item-grid">
	
	<!-- PHOTO -->
	<div class = "result-item-grid-photo">
		<?php
		if($thumbdata != NULL and $thumbdata != '?') 	{ echo '<img src = "php/img.php?-url='.urlencode($thumbnail).'" alt = "Image not available">';	}
		else 											{ echo '<div class = "no-image-grid"><div class = "no-image-grid-text">Image not available</div></div>'; }
		?>
	</div><!-- /.result-item-grid-photo -->

	<!-- TITLE, COPYRIGHT -->
	<div class = "<?php echo $resultItemGridTitleClass;?>">
		<?php
		// TITLE
		echo '<div class = "show-only-desktop">'.$titleGridText.'</div>';
		echo '<div class = "show-only-1025">'.$titleGridText1025.'</div>';
		echo '<div class = "show-only-769">'.$titleGridText769.'</div>';
		echo '<div class = "show-only-480">'.$titleGridText480.'</div>';
		
		// COPYRIGHT
		echo '<div class = "result-item-grid-copyright">';
			echo '<div class = "show-only-desktop">'.$copyrightGridLine.'</div>';
			echo '<div class = "show-only-1025">'.$copyrightGridLine1025.'</div>';
			echo '<div class = "show-only-769">'.$copyrightGridLine769.'</div>';
			echo '<div class = "show-only-480">'.$copyrightGridLine480.'</div>';
		echo '</div>';
		?>
	</div><!-- /.result-item-grid-title -->
	
</div><!-- /.result-item-grid -->
</a>

<!-- TOGGLE DETAILS BTN -->
<div class = "result-item-grid-expand no-print">

	<!-- SHOW -->
	<div id = "show-details-<?php echo $rg;?>" >
		<img src = "images/expand-dark.png" title = "Show product details" 
			onclick = "showItemN('show-details-', 'hide-details-', 'result-item-grid-details-', <?php echo $rg;?>)"/>
	</div>
	
	<!-- HIDE -->
	<div id = "hide-details-<?php echo $rg;?>" class = "hide" >
		<img src = "images/collapse-dark.png" title = "Hide product details" 
			onclick = "hideItemN('show-details-', 'hide-details-', 'result-item-grid-details-', <?php echo $rg;?>)"/>
	</div>
	
</div><!-- /.result-item-grid-expand -->

<!-- DETAILS -->
<div class = "hide" id = "result-item-grid-details-<?php echo $rg;?>">
	<div class = "result-item-grid-details">
		<?php 
		require 'php/result-item-info.php';
		require 'php/result-item-rating.php';
		?>
	</div><!-- /.result-item-grid-details -->
</div><!-- /.hide -->

</div><!-- /.result-item-grid-col -->
