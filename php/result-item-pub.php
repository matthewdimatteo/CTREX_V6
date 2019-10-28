<?php
/*
php/result-item-pub.php
By Matthew DiMatteo, Children's Technology Review

This file outputs an individual publisher result in the publisher directory
It is included in 'php/content/content-publishers.php'
*/
require 'php/result-item-pub-info.php'; // calculate links, labels, and hover text
?>

<div class = "result-item pub-item">
	
	<!-- IMG OF LATEST TITLE -->
	<div class = "result-item-image">
		<?php
		echo '<a href = "'.$firstTitleLink.'" title = "'.$reviewHover.'">';
		if($firstImg != NULL and $firstImgData != '?') 	{ echo '<img src = "php/img.php?-url='.urlencode($firstImg).'" alt = "Image not available"/>'; }
		else 											{ echo '<div class = "no-image"><div class = "no-image-text">Image not available</div></div>'; }
		echo '</a>';
		?>
	</div><!-- /.result-item-image -->
	
	<!-- TEXT -->
	<div class = "result-item-text">
	
		<div class = "result-item-heading-bookmark"></div>
	
		<!-- HEADING WITH COMPANY NAME -->
		<a href = "<?php echo $pubProfileURL;?>" title = "<?php echo $pubProfileHover;?>">
		<div class = "result-item-heading">
			<div class = "result-item-heading-title"><?php echo $companyName;?></div>
		</div><!-- /.result-item-heading -->
		</a>
		
		<!-- INFO -->
		<div class = "result-item-info">
			<?php
			if($linkWebsite != NULL) 	{ echo '<a href="http://'.$linkWebsiteParsed.'" target="_blank" title="'.$websiteHover.'">'.$linkWebsite.'</a><br/>'; }
			if($dateEntered != NULL)	{ echo 'Entered '.$dateEntered.'<br/>'; }
			if($firstTitle != NULL)		{ echo 'Latest Title Reviewed: <a href="'.$firstTitleLink.'" title="'.$reviewHover.'">'.$firstTitle.'</a><br/>'; }
			if($numTitlesReviewed > 1)	{ echo '<a href="'.$moreTitlesURL.'" title="'.$moreTitlesHover.'">'.$moreTitlesLabel.'</a>'; }
			?>
		</div><!-- /.result-item-info -->
		
	</div><!-- /.result-item-text -->

</div><!-- /.result-item -->
