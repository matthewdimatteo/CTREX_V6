<?php
/*
php/result-item-pub-info.php
By Matthew DiMatteo, Children's Technology Review

This file calculates the urls, labels, and hover text for items in a publisher result item
It is included in the files 'php/result-item-pub.php' and 'php/result-item-pub-grid.php'
*/

//echo $companyID.'. '.$companyName.' ('.$numTitlesReviewed.' Titles)<br/>';
$pubProfileURL 	= 'profile.php?id='.$companyID.'&type=publisher&mode=public'; // calculate url for publisher profile
$pubProfileHover= 'View the CTREX profile for '.$companyName;
$reviewHover 	= 'Read our review of '.$firstTitle;
$websiteHover 	= 'View the company website for '.$companyName;
$moreTitlesHover= 'See other CTREX reviews for titles by '.$companyName;
$moreTitlesLabel= 'See all '.$numTitlesReviewed.' titles reviewed';
if($velvetRope == true)
{ 
	// if not logged in, redirect to login page with redirect parameter (if user logs in, will be redirected to targeted resource)
	if($login != true)
	{
		
		$pubProfileURL	= 'login.php?target=publisher&redirect='.urlencode($pubProfileURL);
		$moreTitlesURL	= 'login.php?target=more-titles&redirect='.urlencode($moreTitlesURL);
	}
	// if logged in (as a publisher, for example, redirect to subscribe page so as to avoid revoking the login session)
	else
	{
		$pubProfileURL	= 'subscribe.php?target=publisher';
		$moreTitlesURL	= 'subscribe.php?target=more-titles';
	}
	// set the hover text
	$reviewHover 	= 'Log in as a subscriber to '.lcfirst($reviewHover); 
	$pubProfileHover= 'Log in as a subscriber to '.lcfirst($pubProfileHover); 
	$moreTitlesHover= 'Log in as a subscriber to '.lcfirst($moreTitlesHover); 
	$moreTitlesLabel= 'Log in as a subscriber to '.lcfirst($moreTitlesLabel);
} // end if $velvetRope

// trim text to fit grid view
$companyGridMax = 9;
$companyGridText = trimText($companyName, $companyGridMax);

// max string length per title (grid)
$titleGridMax 		= 42; 
$titleGridMax1025	= 30;
$titleGridMax769	= 36;
$titleGridMax480	= 20;
?>