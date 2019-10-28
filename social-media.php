<?php
/*
social-media.php
By Matthew DiMatteo, Children's Technology Review

This is the file for the social media page of the site
Each page is output through the 'php/autoload.php' file - the variables $pageTitle, $pageType, and $searchType provides parameters for how the page should function
The content for each page is placed in a file conforming to the naming convention of 'php/content/content-'pagename.php (e.g 'content-social-media.php')
*/
$pageTitle 	= 'CTREX on Social Media';	// placed inside html <title> tag
$pageType 	= 'content';				
$searchType	= 'reviews';				// determines which form the main searchbar targets
require_once 'php/autoload.php';		// includes all necessary files for outputting the page
?>