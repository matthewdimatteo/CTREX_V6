<?php
/*
php/redirect-archive.php
By Matthew DiMatteo, Children's Technology Review

This file sets a redirect destination to the archive page and calls the file 'php/redirect.php' that performs a redirect
It is used in cases where an issue or weekly page is being accessed with improper access credentials or invalid parameters
*/
$redirect = 'archive.php';
require_once "php/redirect.php"; // this file contains the html document structure with a meta tag to perform the redirect based on $redirect
exit();
?>