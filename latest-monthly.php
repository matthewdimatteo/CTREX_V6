<?php
/*
latest-monthly.php
By Matthew DiMatteo, Children's Technology Review

This is the file for the latest monthly page of the site
Each page is output through the 'php/autoload.php' file - the variables $pageTitle, $pageType, and $searchType provides parameters for how the page should function
The content for each page is placed in a file conforming to the naming convention of 'php/content/content-'pagename.php (e.g 'content-latest-monthly.php')
*/
$pageTitle 	= 'CTREX - Current Issue';	// placed inside html <title> tag
$pageType 	= 'redirect';			
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page
require_once 'php/get-samples.php';
$redirect = $latestMonthlyLink; 	// determined in 'php/get-samples.php'
//$redirect = $latestMonthlyFullLink; // determined in 'php/get-samples.php'
//echo 'redirect: '.$redirect;
require_once 'php/redirect.php';
?>