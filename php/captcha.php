<?php
/*
php/captcha.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the form elements for a CAPTCHA (to prevent spambot form submissions)
It can be included in any form
This version includes the form structure elements used throughout the site - refer to 'php/captcha-min.php' for a more minimalized version
*/

require_once 'php/captcha-create.php'; // generates the digits
?>

<!-- DISPLAY CAPTCHA ROW -->
<div class = "captcha-row">
	<div class = "field-label"></div>
	<div class = "field-container">
		<?php require_once 'php/captcha-output.php'; // outputs the captcha and entry field ?>
	</div><!-- /.field-container -->
	<div class = "field-note"></div>
</div><!-- /.captcha-row -->