<?php
/*
php/nav-subscribe.php
By Matthew DiMatteo, Children's Technology Review

This file specifies an array of items for a horizontal secondary navigation for the subscription pages
It is included in paged with $pageType 'subscribe' in the file 'php/messages.php'
*/

// define an array of links: array('link', 'label')
$navItems = array
(
	array('about.php'		, 'About'),
	array('subscribe.php'	, 'Subscriptions')
);
if($login != true) { array_push($navItems, array('login.php'		, 'Log In')); }
require_once 'php/nav-output.php'; // calculates css class based on #items, outputs each
?>