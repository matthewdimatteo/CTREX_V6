<?php
/*
php/samples.php
By Matthew DiMatteo, Children's Technology Review

This file outputs sample review, issue, and weekly content
It is included on the about page via 'php/content/content-about.php' and the velvet rope screen via 'php/content/content-home.php'
*/
require_once 'php/get-samples.php';

// ABOUT TEXT (SHOW ON ABOUT PAGE, BUT NOT VELVET ROPE SCREEN)
if($thisPage == 'about.php' and $aboutText != NULL)
{ 
	echo '<div class = "page-header">About Children\'s Technology Review</div>';
	echo '<div class = "paragraph left bottom-40">';
		echo parseLinks($aboutText); // $aboutText determined in 'php/settings.php'
	echo '</div>'; // /.paragraph left bottom-10
} // end if about
?>

<div class = "page-header"><?php echo $samplesHeader;?></div>

<div class = "samples-container">
	
    <!-- REVIEWS -->
	<div id = "sample-review" class = "inline thirds samples-col">
    	<div class = "subheader">
			<?php if ($samplesReviewsHeaderLink != NULL) { echo '<a href = "'.$samplesReviewsHeaderLink.'" class = "btn-text-24px" title = "See our latest reviews">'; } ?>
			<?php echo $samplesReviewsHeader;?>
        	<?php if ($samplesReviewsHeaderLink != NULL) { echo '</a>'; } ?>
		</div><!-- /.subheader -->
        <div><?php echo $samplesReviewsSubheader;?></div>
    	<?php if($samplesReviewsImg != NULL)
		{
			if($samplesReviewsLink != NULL) { echo '<a href = "'.$samplesReviewsLink.'" title = "Read our review of '.$firstSampleTitle.'">'; }
				echo '<img src = "php/img.php?-url='.urlencode($samplesReviewsImg).'" />'; 
			if($samplesReviewsLink != NULL) { echo '</a>'; }
			echo '<br/><br/>'; 
		} 
		?>
        <div>
        <?php
		// DYNAMICALLY LIST THREE LATEST REVIEWS
		foreach($firstThree as $oneOfThree)
		{
			$title 	= $oneOfThree[0];
			$link 	= $oneOfThree[1];
			echo '<a href = "'.$link.'" title = "Read our review of '.$title.'">'.$title.'</a><br/>';
		}
		?>
        </div><!-- end sample-sublabel (reviews) -->
    </div><!-- end reviews-col -->
    
    <!-- MONTHLY -->
    <div id = "sample-issue" class = "inline thirds samples-col">
		<div class = "subheader">
			<?php if ($samplesMonthlyHeaderLink != NULL) { echo '<a href = "'.$samplesMonthlyHeaderLink.'">'; } ?>
			<?php echo $samplesMonthlyHeader;?>
			<?php if ($samplesMonthlyHeaderLink != NULL) { echo '</a>'; } ?>
		</div><!-- /.subheader -->
        <div><?php echo $samplesMonthlySubheader;?></div>
        <?php if($samplesMonthlyImg != NULL)
		{
			if($samplesMonthlyThumbLink != NULL) { echo '<a href = "'.$samplesMonthlyThumbLink.'">'; }
				echo '<img src = "'.$samplesMonthlyImg.'" title = "'.$samplesMonthlyHeader.'">';
			if($samplesMonthlyThumbLink != NULL) { echo '</a>'; }
			echo '<br/><br/>'; 
		} 
		?>
        <div><?php if($splashIssueContents != NULL) { echo nl2br($splashIssueContents); } ?></div><!-- end sample-sublabel (monthly) -->
    </div><!-- end monthly-col -->
    
    <!-- WEEKLY -->
    <div id = "sample-weekly" class = "inline thirds samples-col">
    	<div class = "subheader">
			<?php if ($latestWeeklyLink != NULL) { echo '<a href = "'.$latestWeeklyLink.'">'; } ?>
			<?php echo $samplesWeeklyHeader;?>
        	<?php if ($latestWeeklyLink != NULL) { echo '</a>'; } ?>
		</div><!-- /.subheader -->
        <div><?php echo $samplesWeeklySubheader;?></div>
        <?php 
		// IMAGE FROM FIRST CSR RECORD FOUND FOR MOST RECENT WEEKLY DATE
		if($samplesWeeklyImage != NULL)
		{
			echo '<div class = "width-70 inline center top-5">';
				echo '<a href = "'.$latestWeeklyLink.'" title = "Read the latest CTR Weekly Newsletter">';
					echo '<img src = "php/img.php?-url='.urlencode($samplesWeeklyImage).'">';
				echo '</a>';
			echo '</div>'; // .width-70 inline center top-5
		} // end if $samplesWeeklyImage
		?>
        <div>
        <?php
		// TITLES USING CSR FOUNDSET
		/*
		foreach($weeklyRecordsArray as $noteworthyApp)
		{
			$title 		= $noteworthyApp[0];
			$titleLink 	= $noteworthyApp[1];
			echo '<a href = "'.$titleLink.'" title = "'.$title.'">'.$title.'</a><br/>';
		} // end foreach
		*/
		?>
        </div><!-- end sample-sublabel (weekly) -->
    </div><!-- end weekly-col -->
</div><!-- end samples container -->