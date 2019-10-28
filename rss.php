<?php
/*
rss.php
By Matthew DiMatteo, Children's Technology Review

This file generates an RSS feed for a search
*/				
require_once 'php/autoload.php';			// includes all necessary files for outputting the page
require_once 'php/velvet-rope.php';			// prevent guest access
require_once 'php/find-reviews.php';		// manually include the find file

// determine name of array containing search results based on sort type
if($searchReviewsSort == 'rel') { $searchResults = $recordsToSort; } else { $searchResults = $gridRecords; }

$rssResults = array(); 	// declare array to store RSS result items
foreach($searchResults as $item)
{
	if($searchReviewsSort == 'rel') { $item = $item['fields']; }
	require 'php/get-vars.php'; // assign dynamic variable names
	$permalink = 'https://reviews.childrenstech.com/ctr/review.php?id='.$reviewnumber;
	if($publisherWebsite != NULL) { $company = '<a href = "http://'.$publisherWebsite.'" target = "_blank">'.$company.'</a>'; }
	
	// GENERATE INFO LINE BY LINE
	$rssInfo = '<![CDATA[';
		if($thumbnail != NULL and $thumbdata != "?") { $rssInfo .= '<a href="'.$permalink.'"><img src="php/img.php?-url='.urlencode($thumbnail).'"></a><br />'; }
		if($copyright != NULL)		{ $rssInfo .= '&copy; '.$copyright; if($company != NULL) { $rssInfo .= ', '; } else { $rssInfo .= '<br />'; } }
		if($company != NULL)		{ $rssInfo .= $company.'<br />'; }
		if($price != NULL) 			{ $rssInfo .= 'Price: '.$price.'<br />'; }
		if($platforms != NULL) 		{ $rssInfo .= 'Platform: '.$platforms.'<br />'; }
		if($filesize != NULL) 		{ $rssInfo .= 'Filesize: '.$filesize.'<br />'; }
		if($ages != NULL) 			{ $rssInfo .= 'Ages: '.$ages.'<br />'; }
		if($grades != NULL) 		{ $rssInfo .= 'For grades: '.$grades.'<br />'; }
		if($subjects != NULL) 		{ $rssInfo .= 'Teaches: '.$subjects.'<br />'; }
		if($languageNotes != NULL) 	{ $rssInfo .= 'Language Notes: '.$languageNotes.'<br />'; }
	$rssInfo .= '<br />]]>';

	// ADD THE RECORD INFO TO THE ARRAY
	$rssItem = array($title, $permalink, $rssInfo);
	array_push($rssResults, $rssItem);

} // end foreach
	
// OUTPUT XML
header('Content-type: application/xml');

$rssTitle 		= 'CTREX - Objective reviews of the latest children\'s interactive media';
$rssLink		= 'http://childrenstech.com';
$rssDescription	= 'Objective reviews of the latest children\'s apps, toys, games, and media';
$rssDescription	= $rssFeedback;
$rssImgSrc		= 'http://childrenstech.com/files/2012/06/ctr-logo.png';

echo '<?xml version = "1.0" encoding = "utf-8" ?>';
echo '<rss version = "2.0">';	
	echo '<channel>';
		echo '<title>'.$rssTitle.'</title>';
		echo '<link>'.$rssLink.'</link>';
		echo '<description>'.$rssDescription.'</description>';
		echo '<image>';
			echo '<url>'.$rssImgSrc.'</url>';
			echo '<link>'.$rssLink.'</link>';
		echo '</image>';
		foreach($rssResults as $rssResult)
		{
			$rssItemTitle		= $rssResult[0];
			$rssItemLink		= $rssResult[1];
			$rssItemDescription	= $rssResult[2];

			echo '<item>';	
				echo '<title>'.$rssItemTitle.'</title>';
				echo '<link>'.$rssItemLink.'</link>';
				echo '<description>'.$rssItemDescription.'</description>';
			echo '</item>';	
		}
	echo '</channel>';
echo '</rss>';
?>