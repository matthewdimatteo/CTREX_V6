<?php
/*
php/captcha-min.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the form elements for a CAPTCHA (to prevent spambot form submissions)
It can be included in any form
This version outputs only the bare minimum div elements - refer to 'php/captcha.php' for a version that incorporates the form structure used on the site
*/

require_once 'php/captcha-create.php'; // generates the digits
require_once 'php/captcha-output.php'; // outputs the captcha and entry field
?>