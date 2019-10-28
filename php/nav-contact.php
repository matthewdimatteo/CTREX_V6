<?php
/*
php/nav-contact.php
By Matthew DiMatteo, Children's Technology Review

This file specifies an array of items for a horizontal secondary navigation for the contact pages
It is included in paged with $pageType 'contact' in the file 'php/messages.php'
*/

// define an array of links: array('link', 'label')
$navItems = array
(
	array('contact.php'		, 'Contact Us'),
	array('password.php'	, 'Recover a Password'),
	array('credentials.php'	, 'Publisher Accounts' ),
	array('submit.php'		, 'Submit Products'),
	array('sponsors.php'	, 'Support Our Mission')
);
require_once 'php/nav-output.php'; // calculates css class based on #items, outputs each
?>