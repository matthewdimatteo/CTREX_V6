<?php
/*
php/result-item-archive-grid.php
By Matthew DiMatteo, Children's Technology Review

This file outputs an individual monthly/weekly result as part of a grid on the archive page
It is included in 'php/content/content-archive.php'
*/
require 'php/result-item-archive-info.php'; // calculate urls, hover text, css classes based on monthly/weekly, access
?>
<div class = "result-item-archive-grid-col">
<div class = "result-item-grid">
<?php
// MONTHLY
if($searchArchiveType == 'monthly')
{
	echo '<div class = "text-18"><a href = "'.$archiveItemLink.'" title = "'.$archiveItemHover.'">'.$monthlyAbbr.'</a></div>';
	echo '<div class = "archive-item-image">';
		echo '<a href = "'.$archiveItemLink.'" title = "'.$archiveItemHover.'">';
		if($linkThumb != NULL) 	{ echo '<img src = "'.$linkThumb.'" alt = "Image not available"/>'; }
		else 					{ echo '<div class = "no-image"><div class = "no-image-text">Image not available</div></div>'; }
		echo '</a>';
	echo '</div>'; // /.archive-item-image
	
	// BOTTOM ROW
	echo '<div class = "center no-print">';
	
		// LIST
		echo '<div class = "inline text-14 top-4 right-4">';
			echo '<a href = "'.$issueTitlesLink.'" title = "'.$issueTitlesHover.'">List</a>';
		echo '</div>';
		
		// DOWNLOAD
		echo '<div class = "inline archive-item-download">';
			echo '<a href = "'.$archiveItemDownloadLink.'" title = "'.$archiveItemDownloadHover.'">';
				echo '<img src = "images/download.png"/>';
			echo '</a>';
		echo '</div>';
		
	echo '</div>'; // /.bottom row
	//echo '<div class = "text-14">$gridIndex = '.$gridIndex.'</div>';
} // end if monthly

// WEEKLY
else
{
	echo '<div class = "weekly-grid-img">';
		echo '<a href = "'.$archiveItemLink.'" title = "'.$archiveItemHover.'">';
		if($firstImg != NULL and $firstImgData != '?') 	{ echo '<img src = "php/img.php?-url='.urlencode($firstImg).'" >'; }
		else 											{ echo '<div class = "no-image"><div class = "no-image-text">Image not available</div></div>'; }
		echo '</a>';
	echo '</div>'; // /.archive-item-image
	echo '<div class = "text-18"><a href = "'.$archiveItemLink.'" title = "'.$archiveItemHover.'">'.$weeklyMDY.'</a></div>';
}
?>
</div><!-- /.result-item-grid -->
</div><!-- /.result-item-grid-col -->