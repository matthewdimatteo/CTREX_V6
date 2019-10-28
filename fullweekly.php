<?php
/*
fullweekly.php
By Matthew DiMatteo, Children's Technology Review

This is the file for the full access weekly page
Each page is output through the 'php/autoload.php' file - the variables $pageTitle, $pageType, and $searchType provides parameters for how the page should function
The content for each page is placed in a file conforming to the naming convention of 'php/content/content-'pagename.php (e.g 'content-weekly.php')
- However, this file is configured by 'php/content.php' to use the same content file 'php/content/content-weekly' as the page 'weekly.php'

This url exists so that CTR can send publishers, VIPs, etc. a link to a particular review if needed
It is configured to display the review as the review page would, but always as a logged in subscriber would see it
*/
$pageTitle 	= 'CTREX Weekly Archive';// placed inside html <title> tag
$pageType 	= 'issue';				
$searchType = 'archive';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page
?>