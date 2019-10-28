<?php
/*
logout.php
By Matthew DiMatteo, Children's Technology Review

This file performs a logout, unsetting the session - this step is performed in 'php/session.php'
*/
$pageTitle 	= 'Logging out...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
echo '<script>sessionStorage.clear();</script>';
require_once 'php/autoload.php';	// includes all necessary files for outputting the page
$redirect 	= 'home.php';			// specifies the url to redirect to
require_once 'php/redirect.php';	// performs the redirect
?>