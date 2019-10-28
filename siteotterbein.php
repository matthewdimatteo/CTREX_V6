<?php
/*
Site License Page Template
By Matthew DiMatteo, Children's Technology Review

This page is one of multiple site license pages
Each site license page must have a filename corresponding to the portal url pattern 'site<<siteName>>.php' 
where <<siteName>> is the value of the 'siteName' field in the 'orgs' table of the 'subbies.fmp12' database file

The file 'portal.php' below parses out the siteName value from the page url and uses it to lookup the record for the license
If the license is found and is active, the user is automatically logged in with patron access
Refer to the 'portal.php' and 'get-license.php' files for further details
*/
$pageTitle 	= 'CTREX - Logging in...';	// placed inside html <title> tag
$pageType 	= 'redirect';				// indicates to 'php/autoload.php' not to include 'php/document.php'
require_once 'php/autoload.php';		// includes all necessary files for outputting the page
require_once 'php/portal.php';			// looks up the record for the corresponding site license in the 'orgs' table of the 'subbies.fmp12' database
?>