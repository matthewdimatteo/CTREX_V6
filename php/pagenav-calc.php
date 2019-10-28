<?php
/*
php/pagenav-calc.php
By Matthew DiMatteo, Children's Technology Review

This file calculates the destination url for each page navigation button on a search page
It is included in the 'find' file for each search page (such as 'php/find-reviews.php')

First, the file calculates the destination page value based on the value of the current page
Then, the file parses the current page url and inserts the destination page value as the value for the page parameter

These destination urls are passed as parameters to the JavaScript function pageNav(url), found in 'js/scripts.js'
*/

// calculate the page number for each button
$firstPage 				= 1;
$lastPage 				= $numPages;
$lastPageVelvet 		= ceil($foundcount/$numResults);
if($searchPage < 2)				{ $prevPage = 1; }
else 							{ $prevPage = $searchPage - 1; }
if($searchPage >= $numPages) 	{ $nextPage = $numPages; }
else							{ $nextPage = $searchPage + 1; }

// parse the current url and replace the value of the page parameter with that of the page value for each button
// if there is a query string with a page parameter
if($thisQuery != NULL and substr_count($thisURL, 'page=') > 0)
{
	$pageStart 			= strpos($thisURL, 'page=') + strlen('page=');
	$thisPageFirst 		= substr_replace($thisURL, $firstPage, $pageStart);
	$thisPagePrev 		= substr_replace($thisURL, $prevPage, $pageStart);
	$thisPageNext 		= substr_replace($thisURL, $nextPage, $pageStart);
	$thisPageLast 		= substr_replace($thisURL, $lastPage, $pageStart); 
	$thisPageLastVelvet = substr_replace($thisURL, $lastPageVelvet, $pageStart);
}
// if there is a query string without the page parameter (should not happen, but just in case)
else if($thisQuery != NULL and substr_count($thisURL, 'page=') < 1)
{
	$thisPageFirst		= $thisURL.'?page='.$firstPage;
	$thisPagePrev		= $thisURL.'?page='.$prevPage;
	$thisPageNext		= $thisURL.'?page='.$nextPage;
	$thisPageLast		= $thisURL.'?page='.$lastPage;
	$thisPageLastVelvet	= $thisURL.'?page='.$lastPageVelvet;
}
// if there is no query string
else
{
	$thisPageFirst		= $thisPage.'?page='.$firstPage;
	$thisPagePrev		= $thisPage.'?page='.$prevPage;
	$thisPageNext		= $thisPage.'?page='.$nextPage;
	$thisPageLast		= $thisPage.'?page='.$lastPage;
	$thisPageLastVelvet	= $thisPage.'?page='.$lastPageVelvet;
}
// velvet rope override (includes target destination as url for redirection after login)
if($velvetRope == true)
{
	$thisPageNext = 'login.php?target=next-page&redirect='.urlencode($thisPageNext);
	$thisPageLast = 'login.php?target=last-page&redirect='.urlencode($thisPageLastVelvet);
}
?>