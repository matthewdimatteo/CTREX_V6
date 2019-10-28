<?php
/*
php/captcha-create.php
By Matthew DiMatteo, Children's Technology Review

This file generates a string of random digits for a form CAPTCHA (to prevent spambot form submissions)
It is included in the file 'php/captcha.php' which outputs the form element
*/

// GENERATE STRING OF RANDOM DIGITS
$captchaDigits = array();
$captchaLength = 3;
$captchatring;
for ($i = 0; $i < $captchaLength; $i++)
{
	$captchaDigits[$i] = rand(0,9);
	$captchaString .= $captchaDigits[$i];
}

$tabindex += 1;
?>