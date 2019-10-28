<?php
/*
redirect-login.php
By Matthew DiMatteo, Children's Technology Review

This file exists to redirect traffic from deprecated urls 'ctrlogin.php' and 'publisherlogin.php' to the current login page
It is included in the above files, as well as conditionally in 'messages.php' to allow free mode users to log in as subscribers
*/
$redirect = 'login.php';
$pageTitle = 'CTREX Login';
require_once "php/redirect.php"; // this file contains the html document structure with a meta tag to perform the redirect based on $redirect
exit(); 
?>