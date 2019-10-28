<!-- 
content-login.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the page 'login.php'
It includes the login form in the file 'login-form.php'
-->
<?php
/*
LOGIN REDIRECT
If a guest user tried to access something that is available to subscribers only, the user is redirected to the login page with a redirect parameter
The redirect parameter specifies where the user should be returned to after a successful login
This file gets the parameter and saves it in $_SESSION storage - the 'login-process.php' page gets the stored value on a successful login
*/
if(isset($_GET['redirect'])) { $loginRedirect = test_input($_GET['redirect']); }
?>
<div class = "page-header">Log In</div>
<div id = "login-page-form-container"><?php require_once 'php/login-form.php';?></div>
<br/>
<br/>
<?php require_once 'php/subscription-form.php'; ?>