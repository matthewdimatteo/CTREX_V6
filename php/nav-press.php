<?php
/*
php/nav-press.php
By Matthew DiMatteo, Children's Technology Review

This file specifies an array of items for a horizontal secondary navigation for the press/editorial pages
It is included in paged with $pageType 'press' in the file 'php/messages.php'
*/

// define an array of links: array('link', 'label')
$navItems = array
(
	array('press.php'				, 'Press and Media Resources'),
	array('editorial-calendar.php'	, 'Editorial Calendar'),
	array('editorial-guidelines.php', 'Editorial Guidelines'),
	array('disclaimer.php'			, 'Disclaimer'),
);
require_once 'php/nav-output.php'; // calculates css class based on #items, outputs each
?>