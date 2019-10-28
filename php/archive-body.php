<?php
/*
php/archive-body.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the body of the archived issue and weekly pages, including the subject heading, intro, related reviews, and conclusion
It is included in the files 'php/content/content-issue.php' and 'php/content/content-weekly.php'
*/

// SUBJECT HEADING
if($subject != NULL) { echo '<div class = "review-heading">'.$subject.'</div>'; }
?>

<!-- INTRO, REVIEWS, CONCLUSION -->
<div class = "review-text">
	<?php
	// INTRO
	if($intro != NULL) 
	{ 
		// VELVET ROPE PREVIEW
		if($velvetRope == true)
		{
			$introPreviewLength = 300;
			echo '<p>'.substr($intro, 0, $introPreviewLength).'...</p>';
			require 'php/login-continue-btn.php';
		} // end if($velvetRope == true)

		// FULL INTRO FOR SUBSCRIBERS
		else { echo '<p>'.parseLinks($intro).'</p>'; }
	} // end if $intro != NULL

	// LIST OF TITLES
	if($numTitles > 0)
	{
		echo '<p>';
		echo '<div class = "text-20"><a href = "'.$issueTitlesLink.'" title = "'.$issueTitlesHover.'">'.$issueTitlesLabel.'</a></div><br/>';
		foreach($titles as $thisTitle)
		{
			$title 		= $thisTitle->getField('CSR::Title');
			$titleID	= $thisTitle->getField('CSR::reviewnumber');
			$titleLink	= 'review.php?id='.$titleID;
			$edChoice	= $thisTitle->getField('CSR::edChoice');
			if($edChoice != NULL) { $titleText = '*'.$title; } else { $titleText = $title; }
			echo '<a href = "'.$titleLink.'" title = "Read our review of '.$title.'">'.$titleText.'</a><br/>';
			if($searchArchiveType == 'weekly' and $velvetRope != true)
			{
				$weeklySummary = $thisTitle->getField('CSR::weeklySummary');
				echo parseLinksOld(nl2br($weeklySummary)).'<br/><br/>';
				echo '<hr/>';
			}
		} // end foreach title
		echo '</p>';
	} // end if($numTitles > 0)

	// CONCLUSION
	if($conclusion != NULL and $velvetRope != true) { echo '<p>'.parseLinks($conclusion).'</p>'; }
	?>
</div><!-- /.review-text -->