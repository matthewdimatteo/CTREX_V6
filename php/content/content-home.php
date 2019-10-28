<?php
/*
content-home.php
By Matthew DiMatteo, Children's Technology Review

This file defines the html content for the page 'home.php', which is the primary search page for CTREX
The conditional handler below checks whether the site is in 'Velvet Rope mode'
- If so, and the user is not logged in with valid credentials, the samples content displays via the file 'php/samples.php'
- If not in 'Velvet Rope' mode, or the user is logged in, the typical home page content displays via the file 'php/search-reviews.php'
*/
if($velvetRopeStatus == true and $velvetRope == true) { require_once 'php/samples.php'; } else { require_once 'php/search-reviews.php'; }
?>