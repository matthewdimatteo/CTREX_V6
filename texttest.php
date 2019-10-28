<?php
/*
texttest.php
By Matthew DiMatteo, Children's Technology Review

This is the file for a debug page for working with data-driven text for web content
Each page is output through the 'php/autoload.php' file - the variables $pageTitle, $pageType, and $searchType provides parameters for how the page should function
The content for each page is placed in a file conforming to the naming convention of 'php/content/content-'pagename.php (e.g 'content-texttest.php')
*/
$pageTitle 	= 'CTREX Text Test';	// placed inside html <title> tag
$pageType 	= 'content';				
$searchType	= 'reviews';			// determines which form the main searchbar targets
$dynamicText = true;				// tells 'php/autoload.php' to query 'text' table in 'CSR.fmp12' database file to get text content
require_once 'php/autoload.php';	// includes all necessary files for outputting the page
?>