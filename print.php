<?php
/*
print.php
By Matthew DiMatteo, Children's Technology Review

This file displays search results as a print-friendly list
*/
$pageTitle 	= 'CTREX - Print Search Results';	// placed inside html <title> tag
$pageType 	= 'search';							// indicates to 'php/document.php' to include a find file 'php/find-reviews.php'
$searchType	= 'reviews';						// determines which form the main searchbar targets
require_once 'php/autoload.php';				// includes all necessary files for outputting the page
require_once 'php/velvet-rope.php';				// prevent guest access
?>