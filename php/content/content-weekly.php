<?php
/*
php/content-weekly.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the detailed weekly page, included dynamically in 'php/content.php'
It contains the html for outputting the weekly page

This page borrows stylistically from the review page 'php/content/content-review.php'

The structure of the page includes two columns: a larger left side column for text (title, info, review), and a right column for images, video, download links
If no right side media are available for the review, 'php/review-format.php' defines the CSS class for the left column to take the full page width
*/

// lookup the monthly record by its archiveID
if(isset($_GET['id']))
{
	$archiveID 	= test_input($_GET['id']);
	if($archiveID != NULL) 	
	{ 
		// PERFORM THE FIND -------------------------------------------------------------
		$findWeekly = $fmweekly->newFindCommand($fmweeklyLayout);
		$findWeekly->addFindCriterion('archiveID',"==".$archiveID);
		$result = $findWeekly->execute();
		if (FileMaker::isError ($result) ) { echo $result->getMessage(); exit(); }
		$record = $result->getFirstRecord();
		if(FileMaker::isError($result)) 
		{ 
			//echo 'error';
			$redirect = $lastSearchArchive;
			require_once 'php/redirect.php'; 
			exit();
		}
		// check that issue is active
		$active = $record->getField('active');
		if($active != NULL) { $active = true; } else { $active = false; }
		if($active != true) { require_once 'php/redirect-archive.php'; } // return to archive if issue not marked active
		$searchArchiveType = 'weekly'; // tell 'php/get-archive' to get fields for a weekly record
		require_once 'php/get-archive.php'; // get record fields
		require_once 'php/result-item-archive-info.php'; // format strings, links, hover text, css classes
	} // end if $archiveID != NULL
	else { require_once 'php/redirect-archive.php'; } // return to archive if no id specified
} // end if isset id
else { require_once 'php/redirect-archive.php'; } // return to archive if id input not set

// ADD ISSUE DATE TO PAGE TITLE
if($archiveDate != NULL)
{
	if($pageTitle == NULL) { $pageTitle = 'CTREX Profile'; }
	$pageTitle .= ' - '.$archiveDate;
	echo '<script>setPageTitle(\''.$pageTitle.'\');</script>';
} // end if $archiveDate
?>

<!-- PAGE CONTENT CONTAINER START -->
<div class = "review-container">

	<!-- DETAILS -->
	<div class = "<?php echo $detailsClass;?>" id = "review-details">
	
		<!-- WEEKLY DATE -->
		<div class = "review-title">CTR Weekly <?php echo $weeklyMDY;?></div>
		
		<!-- INTRO, REVIEWS, CONCLUSION -->
		<?php 
		require_once 'php/archive-body.php'; // intro, list of reviews, conclusion
		require_once 'php/review-share.php'; // share btns
		?>
		
	</div><!-- /.review-details-col -->
	
	<!-- IMG GALLERY -->
	<div class = "<?php echo $mediaClass;?>" id = "review-media">
		<?php require_once 'php/review-images.php';?>
	</div><!-- /.review-media-col -->

</div><!-- /.review-container -->