<?php
/*
php/nav-license.php
By Matthew DiMatteo, Children's Technology Review

This file specifies an array of items for a horizontal secondary navigation for the site license pages
It is included in paged with $pageType 'licenses' in the file 'php/messages.php'
*/

// define an array of links: array('link', 'label')
$navItems = array
(
	array('license-faq.php'		, 'FAQ'),
	array('licenses.php'		, 'Cost Calculator'),
	array('license-order.php'	, 'Customize Your Site License')
);
require_once 'php/nav-output.php'; // calculates css class based on #items, outputs each
?>