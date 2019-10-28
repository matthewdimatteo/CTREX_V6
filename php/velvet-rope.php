<?php 
/*
php/velvet-rope.php
By Matthew DiMatteo, Children's Technology Review

This file checks whether the user has access to subscriber features and redirects guests to the login page
If the $velvetRope variable (set in 'php/session.php') is true, this file sets the redirect destination to the login page and performs the redirect
*/
if($velvetRope == true) { $redirect = 'login.php'; require_once 'php/redirect.php'; exit(); } // prevent guest access 
?>