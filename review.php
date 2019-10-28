<?php
/*
review.php
By Matthew DiMatteo, Children's Technology Review

This is the file for the review page
Each page is output through the 'php/autoload.php' file - the variables $pageTitle, $pageType, and $searchType provides parameters for how the page should function
The content for each page is placed in a file conforming to the naming convention of 'php/content/content-'pagename.php (e.g 'content-review.php')
*/
$pageTitle 	= 'CTREX Review';		// placed inside html <title> tag
$pageType 	= 'review';				// indicates to 'php/fields.php' to include image fields in the fields array
$searchType = 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page
?>