<!--
php-captcha-output.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the captcha independently of containing form elements
It is included in the files 'php/captcha.php' (which includes containing form elements) and 'php/captcha-min.php' (which does not)

This file can optionally output a submit button in the right column if the following variables are provided:
- $includeSubmit (set to true to display the button)
- $submitBtnName (the name attribute for the input, which is required in form processing)
- $submitBtnLabel (the value attribute for the input, which displays to the user - this is set to 'Submit' if not specified)

-->

<!-- DISPLAY CAPTCHA ROW -->
<div id = "captcha">

	<!-- GENERATED DIGITS -->
	<div class = "inline thirds-sm right">
		Enter <div class = "captcha-digits"><?php foreach($captchaDigits as $digit) { echo $digit; } ?></div>
	</div>
	
	<!-- INPUT FIELD -->
	<div class = "inline thirds-sm center">
		<input type = "text" name = "captcha" required tabindex = "<?php echo $tabindex;?>" />
		<input type = "hidden" 	name = "captcha-solution" value = "<?php echo $captchaString; ?>" />
	</div>
	
	<!-- SUBMIT BTN -->
	<div class = "inline thirds-sm left">
		<?php
		if($includeSubmit == true and $submitBtnName != NULL)
		{
			if($submitBtnLabel == NULL) {$submitBtnLabel = 'Submit'; }
			echo '<div id = "captcha-submit-container">';
				echo '<input type = "submit" name = "'.$submitBtnName.'" value = "'.$submitBtnLabel.'" title = "'.$submitBtnHover.'"/>';
			echo '</div>';
		}
		?>
	</div>
	
</div><!-- /#captcha -->