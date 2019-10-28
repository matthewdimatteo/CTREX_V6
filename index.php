<?php
/*
index.php
By Matthew DiMatteo, Children's Technology Review

This is the index file for the site - it is configured to redirect to the home page
*/
$pageTitle 	= 'CTREX Home';			// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page
$redirect 	= 'home.php';			// specifies the url to redirect to
require_once 'php/redirect.php';	// performs the redirect
?>