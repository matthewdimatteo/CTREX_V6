<?php
/*
php/result-item-info.php
By Matthew DiMatteo, Children's Technology Review

This file calculates the string values for product info (such as platform, subjects, tags)
It is included in the files 'php/result-item.php', 'php/result-item-grid.php', and 'php/content/content-review.php' to display this info on the search/review pages
*/

if($platforms != NULL) 		{ $platforms = nl2comma($platforms); }
if($subjects != NULL) 		{ $subjects = nl2comma($subjects); }
if($topics != NULL) 		{ $topics = nl2comma($topics); }
if($languageText != NULL) 	{ $languageText = nl2comma($languageText); }
if($scaffoldingText != NULL){ $scaffoldingText = nl2comma($scaffoldingText); }

// NULL HANDLERS - text values determined in search page (for match highlighting), but not review page
if($platformText == NULL) 	{ $platformText = $platforms; } 
if($subjectText == NULL) 	{ $subjectText = $subjects; }

// CONCATENATE PLATFORMS LINE
$platformsLine = '';
if($platformText != NULL or $filesize != NULL)
{
	if($filesize != NULL)							{ $platformsLine .= $filesize; }
	if($platformText != NULL and $filesize != NULL)	{ $platformsLine .= ', '; }
	if($platformText != NULL) 						{ $platformsLine .= $platformText; }
}				

$productInfo = array();
if($pageType == 'review') 
{ 
	array_push($productInfo, array('price'			, $price		, $price)); 		
} // end if $pageType == review
	array_push($productInfo, array('platforms'		, $platformsLine, $platformsLine));
	array_push($productInfo, array('ages'			, $ages			, 'Ages: '.$ages));
	array_push($productInfo, array('subjects'		, $subjectText	, 'Teaches: '.ucfirst($subjectText)));
if($pageType == 'review') 
{ 
	array_push($productInfo, array('topics'			, $topics		, 'Tagged for: '.$topics));
	array_push($productInfo, array('languageText'	, $languageText	, 'Laguages: '.$languageText));
	array_push($productInfo, array('scaffoldingText', $scaffoldingText	, 'Scaffolding: '.$scaffoldingText));
	array_push($productInfo, array('languageNotes'	, $languageNotes, 'Language Notes: '.$languageNotes));
} // end if $pageType == review
foreach($productInfo as $infoItem)
{
	$infoItemID 	= $infoItem[0];
	$infoItemValue 	= $infoItem[1];
	$infoItemText 	= $infoItem[2];
	if($infoItemValue != NULL) { echo '<div class = "result-item-info-line">'.$infoItemText.'</div>'; }
}

// AWARDS
if($bolognaYear != NULL)
{
	echo '<div class = "result-item-info-line award-indicator">';
		echo '<a href = "bolognaragazzi.php">BolognaRagazzi Digital Award</a>';
		if(substr_count($bolognaType, 'winner') > 0) 		{ echo ' Winner'; }
		else if(substr_count($bolognaType, 'shortList') > 0){ echo ' Short List'; }
		else if(substr_count($bolognaType, 'mention') > 0)	{ echo ' Mention'; }
		echo ' <a href = "award.php?type=bologna&year='.$bolognaYear.'">'.$bolognaYear.'</a>';
	echo '</div>'; // /.result-item-info-line
} // end if $bolognaYear != NULL
if($kapiYear != NULL)
{
	echo '<div class = "result-item-info-line award-indicator">';
		echo '<a href = "kapis.php">KAPi Award</a>';
		if(substr_count($kapiType, 'winner') > 0) { echo ' Winner'; }

		else if(substr_count($kapiType, 'mention') > 0)	{ echo 'Mention'; }
		echo ' <a href = "award.php?type=kapi&year='.$kapiYear.'">'.$kapiYear.'</a>';
		if($kapiAward != NULL) { echo ': '.$kapiAward; }
	echo '</div>'; // /.result-item-info-line
} // end if $kapiYear != NULL

// original string values for match highlighting debugging purposes
//echo '<div class = "result-item-info-line">'.$platforms.' ('.$numPlatformWords.' words)</div>';
//echo '<div class = "result-item-info-line">'.$subjects.'</div>';