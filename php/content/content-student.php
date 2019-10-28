<?php
/*
php/content/content-students.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the student discount page 'students.php'
The $studentDiscountText instructions value is defined in 'php/settings.php'
*/

// get stored session values for previous form submission
$studentEmail = $_SESSION['studentEmail'];
$studentValid = $_SESSION['studentValid'];

// reset session values
$_SESSION['studentEmail'] = '';
$_SESSION['studentValid'] = '';
?>

<!-- PAGE HEADER -->
<div class = "page-header">CTREX Student Discounts</div>

<!-- INSTRUCTIONS -->
<div class = "paragraph-70 left bottom-20"><?php echo $studentDiscountText; ?></div>

<!-- EMAIL ENTRY FORM -->
<div class = "paragraph center bottom-20">
	<form name = "student-discount-form" id = "student-discount-form" method = "POST" action = "student-check.php">
		<div class = "inline width-30 right top-5">Email:</div>
		<div class = "inline width-30 center right-10"><input type = "email" name = "student-email" value = "<?php echo $studentEmail;?>"/></div>
		<div class = "inline width-30 left"><input type = "submit" name = "submit-email" value = "Submit"/></div>
	</form><!-- /#student discount form -->
</div><!-- /.paragraph center bottom-20 -->

<?php
// FEEDBACK FOR EMAIL FORM SUBMISSION
if($studentEmail != NULL)
{
	echo '<div class = "paragraph center bottom-20">';
	
		// IF VALID
		if($studentValid == true)
		{
			echo '<div class = "confirmation-message">Your email address has been validated. Your promo code is STARKID</div>';
		} // end if valid
		
		// IF INVALID
		else
		{
			echo '<div class = "error-message">';
			echo 'We\'re sorry - the email address you submitted was not recognized as a valid student email address. Please submit an email address ending in .edu.';
			echo '</div>'; // /.error
		} // end else invalid
	
	echo '</div>'; // .paragraph center bottom-20
} // end if $studentEmail

// PROMOCODE ENTRY FORM
if($promocodeFormInstances < 1) { echo '<br/>'; require 'php/promo-form.php'; }
?>