<?php 
/*
php/redirect-out.php
By Matthew DiMatteo, Children's Technology Review

This file redirects the user outside of CTREX - it is used to prevent spam/bot traffic from logging multitudes of pageview records
The redirect url is set to the CTR blog's disclaimer page
*/
$redirect = 'http://childrenstech.com/disclaimer';
require_once "php/redirect.php"; // this file contains the html document structure with a meta tag to perform the redirect based on $redirect
exit();
?>