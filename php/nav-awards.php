<?php
/*
php/nav-awards.php
By Matthew DiMatteo, Children's Technology Review

This file specifies an array of items for a horizontal secondary navigation for the awards pages
It is included in paged with $pageType 'contact' in the file 'php/messages.php'
*/

// define an array of links: array('link', 'label')
$navItems = array
(
	array('awards.php'			, 'Award Programs'),
	array('bolognaragazzi.php'	, 'BolognaRagazzi'),
	array('kapis.php'			, 'KAPi Awards' )
);
require_once 'php/nav-output.php'; // calculates css class based on #items, outputs each
?>