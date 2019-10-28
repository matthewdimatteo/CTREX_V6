<?php
/*
juror-panel.php
By Matthew DiMatteo, Children's Technology Review

This is the file for the juror's panel page (for evaluating products for awards)
Each page is output through the 'php/autoload.php' file - the variables $pageTitle, $pageType, and $searchType provides parameters for how the page should function
The content for each page is placed in a file conforming to the naming convention of 'php/content/content-'pagename.php (e.g 'content-juror-panel.php')
*/
$pageTitle 	= 'CTREX Juror\'s Panel';	// placed inside html <title> tag
$pageType 	= 'editorial';					
$searchType = 'reviews';				// determines which form the main searchbar targets
require_once 'php/autoload.php';		// includes all necessary files for outputting the page
?>