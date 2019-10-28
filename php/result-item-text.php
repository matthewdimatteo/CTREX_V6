<?php
/*
php/result-item-text.php
By Matthew DiMatteo, Children's Technology Review

This file provides overrides to default field values for text variables for non-relevance sorted result sets
When sorting by relevance, the $titleText and other variables are reconstructed to highlight keyword matches
Since this process does not occur for other sorts, this file returns those values to the original field contents
This file is included at the start of the 'php/result-item.php' and 'php/result-item-grid.php' files that output individual results on the home page
*/

// hover text for the link to the review
$reviewHover = 'Read our review of '.$title; if($velvetRope == true) { $reviewHover = 'Log in as a subscriber to '.lcfirst($reviewHover); }

// sorting by relevance highlights text that matches search terms, using the 'Text' vars - if not sorting this way, set those vars to the default values
if($searchReviewsSort != 'rel') 
{ 
	$titleText 		= $title; 
	$companyText 	= $company;
	$platformText 	= $platforms;
	$subjectText	= $subjects;
} // end if not sorting by relevance

// maximum title string lengths for different screen widths
$titleMax1025 	= 54;
$titleMax769 	= 50;
$titleMax480 	= 26;

// trim the title text to fit different screen widths
$titleText1025 	= trimText($title, $titleMax1025);
$titleText769	= trimText($title, $titleMax769);
$titleText480	= trimText($title, $titleMax480);

// trim text for title, copyright, to fit grid view
$titleGridMax 		= 20;
$titleGridMax1025 	= 15;
$titleGridMax769 	= 15;
$titleGridMax480 	= 9;
$titleGridText 		= trimText($title, $titleGridMax);
$titleGridText1025	= trimText($title, $titleGridMax1025);
$titleGridText769	= trimText($title, $titleGridMax769);
$titleGridText480	= trimText($title, $titleGridMax480);

$copyrightGridLine = '&copy; '.$copyright.' '.$company;
$copyrightGridMax 		= 36;
$copyrightGridMax1025 	= 28;
$copyrightGridMax769 	= 26;
$copyrightGridMax480 	= 12;
$copyrightGridLine 		= trimText($copyrightGridLine, $copyrightGridMax);
$copyrightGridLine1025 	= trimText($copyrightGridLine, $copyrightGridMax1025);
$copyrightGridLine769 	= trimText($copyrightGridLine, $copyrightGridMax769);
$copyrightGridLine480 	= trimText($copyrightGridLine, $copyrightGridMax480);

?>