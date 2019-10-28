<?php 
/*
php/content/content-404.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the 404 page
It is included dynamically in the file 'php/document.php'
*/
?>
<div class = "page-header">Page Not Found</div>
<p>The page you were looking for may have been removed, had its name changed, or is temporarily unavailable.</p>
<p class = "text-20"><a href = "contact.php">Let us know: Contact Us</a></p>
<p class = "text-20"><a href = "home.php">Return Home</a></p>

<p>Select the sandwich icon in the left side of the header to view our main menu. If you're looking for reviews, try the options below:</p>
<div id = "filters-page-container"><?php require_once 'php/sidebar.php';?></div><!-- /#filters-page-container -->