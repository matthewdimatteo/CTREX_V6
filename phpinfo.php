<?php
/*
phpinfo.php
By Matthew DiMatteo, Children's Technology Review

This is the file for the phpinfo page of the site, which simply displays the server info via phpinfo();
Each page is output through the 'php/autoload.php' file - the variables $pageTitle, $pageType, and $searchType provides parameters for how the page should function
The content for each page is placed in a file conforming to the naming convention of 'php/content/content-'pagename.php (e.g 'content-phpinfo.php')
*/
$pageTitle 	= 'CTREX PHP Info';		// placed inside html <title> tag
$pageType 	= 'content';
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page
?>