<?php
/*
php/content/content-credentials.php
By Matthew DiMatteo, Children's Technology Review

This the content file for the page 'credentials.php' - it contains the form for requesting a publisher account
The form submission is processed by the page 'credentials-process.php'
*/

// get the stored $_SESSION values from a redirect (on captcha error)
$sessionItem = 'credentials-form-submission';
require_once 'php/form-submission-get.php';
?>

<!-- CONTACT FORM -->
<div class = "page-header">CTREX Publisher Accounts</div>
<div class = "paragraph bottom-10 instructions">
	All publishers whose products have been reviewed by CTR are entitled to a free publisher account.
	<p>This login provides a publisher profile page and access to reviews of <strong>only your products</strong>.</p>
	<p>In order to receive a login, <strong>one or more</strong> reviews of your <a href = "submit.php">submitted</a> products must have been <strong>published</strong>.</p>
</div>
<div class = "paragraph bottom-20">
<form name = "credentials-form" id = "credentials-form" method = "POST" action = "credentials-process.php">
	<?php
	$credentialsFormFields = array
	(
		array('Company Name'	, 'credentialsCompany'	, $credentialsCompany	, 'text'	, true	, ''),
		array('Contact Name'	, 'inputName'			, $inputName			, 'text'	, true	, ''),
		array('Contact Email'	, 'inputEmail'			, $inputEmail			, 'email'	, true	, ''),
		array('Message'			, 'credentialsMessage'	, $credentialsMessage	, 'textarea', false	, '')
	);
	$_SESSION['credentials-form-fields'] = $credentialsFormFields;
	$fields = $credentialsFormFields;
	require 'php/form-fields-output.php';
	require_once 'php/captcha.php';
	?>
	<?php require_once 'php/captcha.php';?>
    <div class = "submit-row"><input type = "submit" name = "submit-credentials-form" value = "Submit Your Request"/></div>
</form>
</div><!-- /.paragraph -->
<br/>
<br/>
<?php require_once 'php/contact-info.php';?>