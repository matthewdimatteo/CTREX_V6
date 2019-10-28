<?php
/*
noresults.php
By Matthew DiMatteo, Children's Technology Review

This is the file for the no results page of the site
Each page is output through the 'php/autoload.php' file - the variables $pageTitle, $pageType, and $searchType provides parameters for how the page should function
The content for each page is placed in a file conforming to the naming convention of 'php/content/content-'pagename.php (e.g 'content-noresults.php')

This page is necessary to be used as a redirect destination after a search returns no results
FileMaker treats a found count of zero as an error, and so crashes the page
Within the file 'php/find-reviews.php', the error handling case will apply the redirect
*/
$pageTitle 	= 'No results found';	// placed inside html <title> tag
$pageType 	= 'content';			// indicates to 'php/document.php' to include a find file 'php/find-reviews.php'
require_once 'php/autoload.php';	// includes all necessary files for outputting the page
?>