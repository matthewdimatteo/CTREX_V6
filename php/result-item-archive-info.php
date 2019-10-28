<?php
/*
php/result-item-archive-info.php
By Matthew DiMatteo, Children's Technology Review

This file calculates urls, hover text, and css classes for a result on the archive page
It is included within the list and grid containers in the file 'php/content/content-archive.php'
It is also included in the detailed issue and weekly pages' content files, 'php/content/content-issue.php' and 'php/content/content-weekly.php'
*/

// grant full access on designated full access pages
if($thisPage == 'fullissue.php' or $thisPage == 'fullweekly.php') { $velvetRope = false; }

// IF SEARCHING MONTHLIES
if($searchArchiveType == 'monthly')
{ 
	$archiveItemLink = 'issue.php?id='.$archiveID; // link to individual archive item
	$archiveItemHover = 'View the detailed issue'; if($archiveDate != NULL) { $archiveItemHover .= ' for CTR '.$archiveDate; } // hover text
	$archiveImgClass = 'archive-item-image'; // show the issue cover thumbnail
	$archiveItemHeading = 'CTR '.$archiveDate;
	$archiveInfoClass = 'result-item-info archive-info left';
	
	// CALCULATE VOLUME/NO/ISSUE TEXT
	if($volume != NULL) { $volumeLine = 'Vol. '.$volume.' '; }
	if($number != NULL) { $volumeLine .= 'No. '.$number.' '; }
	if($issue != NULL)	{ $volumeLine .= 'Issue '.$issue; }
	if($volumeLine != NULL) { $volumeLineClass 			= 'volume-line top-10'; } 		else { $volumeLineClass 			= 'hide'; }
	if($linkPDF != NULL) 	{ $archiveItemDownloadClass = 'volume-line bottom-10'; } 	else { $archiveItemDownloadClass 	= 'hide'; }
	
	// DETERMINE HIGHEST-RES IMG TO DISPLAY ON ISSUE PAGE
	if($linkLarge != NULL) 			{ $coverImg = $linkLarge; }
	else if ($linkThumb != NULL) 	{ $coverImg = $linkThumb; }
	
	// DISPLAY TEXT AND IMG COLS IF COVER IMG, DISPLAY FULL-WIDTH TEXT IF NO COVER IMG
	if($coverImg != NULL)
	{
		$detailsClass 	= 'review-details-col';
		$mediaClass 	= 'review-media-col';
	}
	else
	{
		$detailsClass 	= 'review-details-block';
		$mediaClass 	= 'hide';
	}
		
	// DOWNLOAD LINK URL
	if($linkPDF != NULL) 		{ $archiveItemDownloadLink = $linkPDF; }
	else if($coverImg != NULL) 	{ $archiveItemDownloadLink = $coverImg; }
	
	// DOWNLOAD LINK TEXT
	$archiveItemDownloadHover 	= 'Download this issue as a .pdf';
	$archiveItemDownloadLabel	= 'Download this issue as a PDF';
	
	// DOWNLOAD LINK VELVET ROPE OVERRIDES
	if($velvetRope == true) 
	{ 
		$archiveItemDownloadLink 	= 'login.php?target=issue-download&redirect='.urlencode($thisURL); 
		$archiveItemDownloadHover 	= 'Log in as a subscriber to '.lcfirst($archiveItemDownloadHover);
		$archiveItemDownloadLabel 	= 'Log in as a subscriber to '.lcfirst($archiveItemDownloadLabel);
	}
	
	// REVIEWS LINK
	$issueTitlesLink 	= 'home.php?monthly='.$monthlyAbbr.'&page=1';
	$issueTitlesHover 	= 'View titles in this issue on the home page';
	$issueTitlesLabel	= 'Reviews in this issue:';
} 

// IF SEARCHING WEEKLIES
else
{ 
	$archiveItemLink 	= 'weekly.php?id='.$archiveID; // link to individual archive item
	$archiveItemHover 	= 'View the detailed weekly'; // hover text
	$archiveImgClass 	= 'hide'; // no image for weeklies
	$archiveItemHeading = $weeklyMDY;
	$archiveInfoClass 	= 'weekly-info';
	
	// REVIEWS LINK
	$issueTitlesLink 	= 'home.php?weekly='.$weeklyParam.'&page=1';
	$issueTitlesHover 	= 'View titles in this weekly on the home page';
	$issueTitlesLabel	= 'This week\'s noteworthy products:';
	
	// REVIEW IMAGE GALLERY
	if($numImages > 0)
	{
		$detailsClass 	= 'review-details-col';
		$mediaClass 	= 'review-media-col';
	}
	else
	{
		$detailsClass 	= 'review-details-block';
		$mediaClass 	= 'hide';
	}
	
	if($numImages > 0)	{ $reviewImagesClass 		= 'review-images'; }			else { $reviewImagesClass 		= 'hide'; }
	if($numImages > 1)	{ $reviewImageToggleClass 	= 'review-image-toggle'; }		else { $reviewImageToggleClass 	= 'hide'; }
}

// VELVET ROPE OVERRIDES
/*
if($velvetRope == true) 
{ 
	$archiveItemLink = 'login.php?target=archive-item&redirect='.urlencode($archiveItemLink); // link to individual archive item
	$archiveItemHover = 'Log in as a subscriber to '.lcfirst($archiveItemHover); // hover text
}
*/
if($velvetRope != true) { $reviewShareToggleClass = 'review-share-toggle'; } else { $reviewShareToggleClass = 'hide'; } // whether to display share btns

if($subject != NULL) { $archiveItemHeading .= ' - '.$subject; } // add subject to heading if specified

$headingMax 	= 110;
$headingMax1025 = 100;
$headingMax769 	= 70;
$headingMax480 	= 50;
$headingText 	= trimText($archiveItemHeading, $headingMax);
$headingText1025= trimText($archiveItemHeading, $headingMax1025);
$headingText769 = trimText($archiveItemHeading, $headingMax769);
$headingText480 = trimText($archiveItemHeading, $headingMax480);

?>