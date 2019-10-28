<!--
php/review-images.php
By Matthew DiMatteo, Children's Technology Review

This file outputs an image gallery for the review and weekly pages
It is included in the files 'php/content/content-review.php' and 'php/content/content-weekly.php'

The $reviewImagesClass is set to 'review-images' if there is 1 or more valid images and 'hide' if none
The $reviewImageToggleClass is set to 'review-images-toggle' if there are multiple valid images and 'hide' if 1 or zero
- These values are set in the file 'php/review-format.php' for the review page and 'php/result-item-archive-info.php' for the weekly page

On the review page, the $reviewImages array is set in the file 'php/review-format.php'
-->

<!-- IMAGES -->
<div class = "<?php echo $reviewImagesClass;?>" id = "review-images">
<?php

$ri = 0;
foreach($reviewImages as $reviewImage)
{
	if($pageType == 'issue')
	{
		$zoomLink 		= $reviewImage[1];
		$reviewImage 	= $reviewImage[2];
	}
	$ri += 1;
	$reviewImageID = 'review-image-'.$ri;
	if($ri == 1) { $reviewImageClass = 'review-image'; } else { $reviewImageClass = 'hide'; }
	
	// on the review page, each image links to the zoom page - on the weekly page, the images link to the review, from $reviewImage[1], above
	if($pageType == 'review') 
	{ 
		$zoomLink = 'zoom.php?id='.$reviewnumber.'&image='.$ri; // set the zoom page url
		if($velvetRope == true) { $zoomLink = 'login.php?target=zoom&redirect='.urlencode($zoomLink); } // velvet rope override
	} // end if $pageType == 'review'
	
	//if($thisPage == 'weekly.php') { $zoomLink = $titleLink; } // link to the review from the weekly page
	echo '<div class = "'.$reviewImageClass.'" id = "'.$reviewImageID.'">';
		echo '<a href = "'.$zoomLink.'" '; if($pageType == 'review' and $velvetRope != true) { echo 'target = "_blank"'; } echo '>';
			echo '<img src = "php/img.php?-url='.urlencode($reviewImage).'" alt = "Image not available" ';
				//echo 'onclick = "reviewImageZoom(\''.$zoomLink.'\')"';
			echo '>';
		echo '</a>';
	echo '</div>'; // /.$reviewImageClass #$reviewImageID
} // end foreach $reviewImage
?>
</div><!-- /#review-images -->

<!-- THUMBNAILS -->
<div class = "<?php echo $reviewImageToggleClass;?>" id = "review-image-toggle">
<?php
$ri = 0;
foreach($reviewImages as $reviewImage)
{
	if($pageType == 'issue')
	{
		$zoomLink 		= $reviewImage[1];
		$reviewImage 	= $reviewImage[2];
	} // end if $pageType == 'issue'
	$ri += 1;
	$reviewImageThumbID = 'review-image-thumb-'.$ri;
	if($ri == 1) { $reviewImageThumbClass = 'review-image-thumb-active'; } else { $reviewImageThumbClass = 'review-image-thumb-inactive'; }
	echo '<div class = "'.$reviewImageThumbClass.'" id = "'.$reviewImageThumbID.'" onclick = "reviewImageShow('.$ri.')">';
		echo '<img src = "php/img.php?-url='.urlencode($reviewImage).'" alt = "Image not available">';
	echo '</div>'; // /.$reviewImageThumbClass #$reviewImageThumbID
} // end foreach $reviewImage
?>
</div><!-- /#review-image-toggle -->
