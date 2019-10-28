<?php
/*
upgrade.php
By Matthew DiMatteo, Children's Technology Review

This file exists to redirect traffic from a deprecated url to the renewal page
*/
$redirect = 'renew.php';
$pageTitle = 'Redirecting...';
require_once "php/redirect.php"; 
exit(); 
?>