<?php
/*
php/review-format.php
By Matthew DiMatteo, Children's Technology Review

This file formats the content for the review page - it is included in the file 'php/content/content-review.php'
This file:
- determines show/hide status for review data based on whether field has a value
- calculates hover text, urls
- parses text for mobile formats
- handles velvet rope access
*/

// GRANT CUSTOM ACCESS FOR CERTAIN CASES
if($thisPage == 'fullreview.php') 						{ $velvetRope = false; }
if($publisher == true and $publisherName == $company) 	{ $velvetRope = false; }

$n += 1;

// TITLE
if($title != NULL) { $reviewTitleClass = 'review-title'; } else { $reviewTitleClass = 'hide'; }

// COPYRIGHT LINE
if($company != NULL or $copyright != NULL)
{
	$copyrightLine = '&copy;'; 
	if($copyright != NULL) 	{ $copyrightLine .= ' '.$copyright; } 
	if($company != NULL) 	{ $copyrightLine .= ' '.$company; 	}
	$reviewCopyrightClass = 'review-copyright';
}
else { $reviewCopyrightClass = 'hide'; }

// PUBLISHER LINKS
if($company != NULL and ($producer != NULL or $publisherWebsite != NULL))
{
	$reviewPublisherInfoToggleClass = 'review-publisher-info-toggle';
	if($publisherWebsite != NULL)
	{
		$publisherWebsiteClass 	= 'review-publisher-link';
		$publisherWebsiteTitle 	= 'View the website for '.$company.' (external link)';
		$publisherWebsiteLink 	= 'http://'.$publisherWebsite;
	}
	else { $publisherWebsiteClass = 'hide'; }
	if($producer != NULL)
	{
		$publisherProfileClass 	= 'review-publisher-link';
		$publisherProfileTitle 	= 'View the CTREX Profile for '.$company;
		$publisherProfileLink 	= 'profile.php?id='.$companyID.'&type=publisher&mode=public';
	}
	else { $publisherProfileClass = 'hide'; }
	$publisherTitlesTitle = 'Find more '.$company.' titles reviewed by CTR';
	$publisherTitlesLink = 'home.php?publisher='.$company.'&page=1';
}
else { $reviewPublisherInfoToggleClass = 'hide'; }

// PRODUCT INFO - CONVERT LINE BREAKS TO COMMAS
if($platforms != NULL) 		{ $platforms = nl2comma($platforms); }
if($subjects != NULL) 		{ $subjects = nl2comma($subjects); }
if($topics != NULL) 		{ $topics = nl2comma($topics); }
if($languageText != NULL) 	{ $languageText = nl2comma($languageText); }
if($scaffoldingText != NULL){ $scaffoldingText = nl2comma($scaffoldingText); }

// TOPIC LABELS
if($topics != NULL)
{
	$topicsOrig = $topics;
	
	// these are the topics whose values require labels - array format is (value, label)
	$topicLabelArray = array
	(
		array('AllTimeBestApps' , 'All Time Best'),
		array('BestAndroid'		, 'Android'),
		array('Pioneer'			, 'Classics'),
		array('isFiction'		, 'Fiction'),
		array('Library Video Games' , 'Library Videogames'),
		array('coop'			, 'Co-op')
	);
	// replace any topic values that require labels with their corresponding labels in the topics string, which is output in 'php/result-item-info.php'
	foreach($topicLabelArray as $thisTopic)
	{
		$topicValue = $thisTopic[0];
		$topicLabel = $thisTopic[1];
		$topics = str_replace($topicValue, $topicLabel, $topics);
	} // end foreach
} // end if $topics

// AUTHOR
if($author != NULL)
{
	$reviewAuthorClass = 'review-author';
	$authorText = '';
	if($authorID != NULL and $authorShare != NULL) 	{ 	$authorProfileLink = 'profile.php?id='.$authorID.'&type=subscriber&mode=public'; }
	if($authorID != NULL and $authorShare != NULL) 	{ 	$authorText .= '<a href = "'.$authorProfileLink.'">'; }
														$authorText .= $author;
	if($authorID != NULL and $authorShare != NULL) 	{ 	$authorText .= '</a>'; }
}
else { $reviewAuthorClass = 'hide'; }

// ENTRY DATE
if($entered != NULL) { $reviewDateClass = 'review-date'; } else { $reviewDateClass = 'hide'; }

// RATING
if($rated == true and $velvetRope != true) 			{ $ratingLineClass = 'rating-line'; } else { $ratingLineClass = 'hide'; }

// REVIEW TEXT
if($reviewText != NULL)
{
	$reviewTextParsed 	= parseLinks($reviewText);
	$reviewTextParsed 	= nl2br($reviewTextParsed);
	$reviewTextClass 	= 'review-text';
}
else { $reviewTextClass = 'hide'; }

// SHARE
if($published == true) { $reviewShareToggleClass = 'review-share-toggle'; } else { $reviewShareToggleClass = 'hide'; }
$reviewVelvetRopeClass 	= 'hide';

// EXCHANGE
if($velvetRope == true) 								{ $reviewExchangeClass 		= 'hide'; } 	else { $reviewExchangeClass 	= 'block'; }
if($profile == true or $license == true)				{ $reviewCommentClass 		= 'block'; } 	else { $reviewCommentClass 		= 'hide'; }
if($commentCount > 0 and $communityReviews != NULL)		{ $communityReviewsClass 	= 'block'; } 	else { $communityReviewsClass 	= 'hide'; }
if($expertReviewCount > 0 and $expertReviews)			{ $expertReviewsClass 		= 'block'; } 	else { $expertReviewsClass 		= 'hide'; }

// IMAGES
$numImages = 0;
if($imgCount > 0)
{	
	$reviewImages = array();
	$ri = -1;
	if($image1Data != NULL and $image1Data != '?') 
	{ 
		$numImages += 1; 
		$ri += 1;
		$reviewImages[$ri] = $image1;
	}
	if($image2Data != NULL and $image2Data != '?') 
	{ 
		$numImages += 1; 
		$ri += 1;
		$reviewImages[$ri] = $image2;
	}
	if($image3Data != NULL and $image3Data != '?') 
	{ 
		$numImages += 1; 
		$ri += 1;
		$reviewImages[$ri] = $image3;
	}
}
if($imgCount > 0)			{ $reviewImagesClass 		= 'review-images'; }			else { $reviewImagesClass 		= 'hide'; }
if($imgCount > 1)			{ $reviewImageToggleClass 	= 'review-image-toggle'; }		else { $reviewImageToggleClass 	= 'hide'; }
if($linkVideo != NULL) 		{ $reviewVideoClass 		= 'review-video'; }				else { $reviewVideoClass 		= 'hide'; }

// DOWNLOAD LINKS
$downloadLinks = array($linkItunes, $linkAndroid, $linkAmazon, $linkSteam);
$numDownloadLinks = 0;
foreach($downloadLinks as $downloadLink) { if($downloadLink != NULL) { $numDownloadLinks += 1; } }
if($numDownloadLinks > 0)	{ $reviewDownloadLinksClass = 'review-download-links'; }	else { $reviewDownloadLinksClass = 'hide'; }

$downloadLinks = array
(
	array('itunes'	, $linkItunes),
	array('android'	, $linkAndroid),
	array('amazon'	, $linkAmazon),
	array('steam'	, $linkSteam),
);

// DETAILS/MEDIA COLS
if($numImages > 0 or $linkVideo != NULL or $numDownloadLinks > 0)
{
	$reviewDetailsClass = 'review-details-col';
	$reviewMediaClass 	= 'review-media-col';
}
else
{
	$reviewDetailsClass = 'review-details-block';
	$reviewMediaClass 	= 'hide';
}

// $velvetRope = true; // for debugging

// VELVET ROPE OVERRIDES
if($velvetRope == true)
{
	$reviewPublisherInfoToggleClass = 'hide';
	$reviewTextParsed				= substr($reviewTextParsed, 0, 280).'...';
	$reviewImageToggleClass			= 'hide';
	$reviewDownloadLinksClass		= 'hide';
	$reviewShareToggleClass			= 'hide';
	$reviewVelvetRopeClass			= 'review-velvet-rope';
	$reviewExchangeClass			= 'hide';
}

?>