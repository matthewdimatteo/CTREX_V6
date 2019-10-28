<?php
/*
php/redirect-login.php
By Matthew DiMatteo, Children's Technology Review

This file redirects the user to the login page 'login.php'
There is also a file in the root directory with this name - it is used for <a> tag href values
*/
$redirect = 'login.php';
require_once "php/redirect.php"; // this file contains the html document structure with a meta tag to perform the redirect based on $redirect
exit();
?>