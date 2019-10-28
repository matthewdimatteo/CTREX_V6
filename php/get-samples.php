<?php

// LOOKUP LATEST PUBLISHED CSR REVIEW WITH VIDEO AND RATING
$findSampleReview = $fmsamples->newFindCommand($fmsamplesLayout);
$findSampleReview->setRange(0,1);
$findSampleReview->addFindCriterion('published', "*");
$findSampleReview->addFindCriterion('video', "*");
$findSampleReview->addFindCriterion('rubricStars', ">0");
$findSampleReview->addSortRule('reviewnumber', 1, FILEMAKER_SORT_DESCEND);
$result = $findSampleReview->execute();
if (FileMaker::isError ($result) ) { echo $result->getMessage(); exit(); }
$record 			= $result->getFirstRecord();
$thumbdata			= $record->getField('thumbData');	
$thumbnail			= $record->getField('thumbnail');	
$samplesReviewsImg	= $record->getField('Sample Screen');	
$firstSampleTitle 	= $record->getField('Title');
$reviewnumber 		= $record->getField('reviewnumber');
$samplesReviewsLink = 'fullreview.php?id='.$reviewnumber;
$redirect 			= $samplesReviewsLink;

// GET THREE LATEST REVIEWS
$findThree = $fmreviews->newFindCommand($fmreviewsLayout);
$findThree->setRange(0,3);
$findThree->addFindCriterion('published', "*");
$findThree->addSortRule('reviewnumber', 1, FILEMAKER_SORT_DESCEND);
$threeResult = $findThree->execute();
if (FileMaker::isError ($threeResult) ) { echo $threeResult->getMessage(); exit(); }
$threeRecords = $threeResult->getRecords();
$firstThree = array();
$threeN = -1;
foreach($threeRecords as $eachOfThree)
{
	$threeN += 1;
	$title 			= $eachOfThree->getField('Title');
	$reviewnumber 	= $eachOfThree->getField('reviewnumber');
	$link 			= 'review.php?id='.$reviewnumber;
	$firstThree[$threeN] = array($title, $link);
	
	// LATEST REVIEW LINK
	if($threeN == 0) { $latestReviewLink = 'review.php?id='.$reviewnumber; $latestReviewFullLink = 'fullreview.php?id='.$reviewnumber; } 
} // end foreach threeRecords

// LOOKUP LATEST ISSUE - ALL ACTIVE, SORT BY YEAR, MONTH, GET FIRST RECORD FOR LATEST ISSUE
$findIssue = $fmissues->newFindCommand('ISSUE DETAILS');
$findIssue->addFindCriterion('active', "*");
$findIssue->addSortRule('issueYearNumber', 1, FILEMAKER_SORT_DESCEND);
$findIssue->addSortRule('issueMonthNumber', 2, FILEMAKER_SORT_DESCEND);
$issueResult 	= $findIssue->execute();
if (FileMaker::isError ($issueResult) ) { echo $issueResult->getMessage(); exit(); }
$issueRecord 	= $issueResult->getFirstRecord(); 
$issuePDF 		= $issueRecord->getField('linkPDF');
$issueThumb 	= $issueRecord->getField('linkThumb');
$issueLgImg		= $issueRecord->getField('linkLarge');
$issueMonthName	= $issueRecord->getField('issueMonthName');
$issueYear		= $issueRecord->getField('issueYearNumber');
$issueContents	= $issueRecord->getField('toc');
$issueID		= $issueRecord->getField('monthly::archiveID');

// LATEST MONTHLY LINK
$issueArchiveURL		= 'issue.php?id='.$issueID;
$latestMonthlyLink 		= 'issue.php?id='.$issueID;
$latestMonthlyFullLink 	= 'fullissue.php?id='.$issueID;

if($issueLgImg != NULL) 
{ 
	$issuePreview 			= $issueLgImg; 
	$samplesMonthlyThumb 	= $issueLgImg;
	$samplesMonthlyImg		= $issueLgImg;
} 
else 
{ 
	$issuePreview 			= $issueThumb; 
	$samplesMonthlyThumb 	= $issueThumb;
	$samplesMonthlyImg		= $samplesMonthlyThumb;
}

$samplesMonthlyHeader 	= 'View the '.$issueMonthName.' Issue';
if($velvetRope != true) { $samplesMonthlyHeaderLink = $issuePDF; } 	else { $samplesMonthlyHeaderLink 	= $issuePreview; }

$samplesMonthlyImgType 	= 'URL';
if($velvetRope != true) { $samplesMonthlyThumbLink = $issuePDF; } 	else { $samplesMonthlyThumbLink 	= $issuePreview; }

if($issueID != NULL) { $samplesMonthlyHeaderLink = $issueArchiveURL; $samplesMonthlyThumbLink = $issueArchiveURL; }


// THIS METHOD WILL AVOID POSSIBLE NULL SET ERROR IF NO REVIEWS MARKED FOR CURRENT WEEKLY; WILL JUST FIND MOST RECENT ONES MARKED
// FINDS ALL WEEKLIES , SET RANGE TO 3, AND SORT BY MOST RECENT
/*
$findWeeklies = $fmreviews->newFindCommand($fmreviewsLayout);
$findWeeklies->setRange(0,3);
$findWeeklies->addFindCriterion('published', "*");
$findWeeklies->addFindCriterion('weekly', "*");
$findWeeklies->addSortRule('reviewnumber', 1, FILEMAKER_SORT_DESCEND);
$weeklyResult = $findWeeklies->execute();
if (FileMaker::isError($weeklyResult)) { echo $weeklyResult->getMessage(); exit(); }
$weeklyRecords 		= $weeklyResult->getRecords();
$weeklyRecordsArray = array();
$w = -1;
foreach($weeklyRecords as $weeklyRecord)
{
	$w += 1;

	$title 			= $weeklyRecord->getField('Title');
	$reviewnumber 	= $weeklyRecord->getField('reviewnumber');	
	$reviewURL		= 'review.php?id='.$reviewnumber;
	$weeklyRecordsArray[$w] = array($title, $reviewURL);

	// GET IMAGE FROM FIRST RECORD FOR THUMBNAIL PREVIEW
	if($w == 0)
	{
		$firstWeeklyImage 	= $weeklyRecord->getField('thumbnail');
		$firstWeeklyImgData	= $weeklyRecord->getField('thumbData');
		$firstWeeklyTitle	= $title;
		$firstWeeklyURL		= $reviewURL;
		$firstWeeklyDate	= $weeklyRecord->getField('weekly');
		$firstWeeklyArchiveID 	= $weeklyRecord->getField('weekly::archiveID');
		$firstWeeklyArchiveURL 	= 'weekly.php?id='.$firstWeeklyArchiveID;
	}
} // end foreach $weeklyRecords

$firstWeeklyParam = str_replace('/', '%2F', $firstWeeklyDate);
$samplesWeeklyHeaderLink = 'home.php?weekly='.$firstWeeklyParam.'&page=1';
if($firstWeeklyArchiveID != NULL) { $samplesWeeklyHeaderLink = $firstWeeklyArchiveURL; $firstWeeklyURL = $firstWeeklyArchiveURL; }
*/

// defaults
if($samplesReviewsHeaderLink == NULL)	{ $samplesReviewsHeaderLink = 'home.php?filter[]=current&quickfind=Latest+Reviews&page=1'; }
if($samplesReviewsHeader == NULL)		{ $samplesReviewsHeader 	= 'Latest Reviews'; }
if($samplesMonthlyHeader == NULL)		{ $samplesMonthlyHeader 	= 'View the Monthly Issue'; }
if($samplesWeeklyHeader == NULL)		{ $samplesWeeklyHeader 		= 'Weekly News & Picks'; }

?>