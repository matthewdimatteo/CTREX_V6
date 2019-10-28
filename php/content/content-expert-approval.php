<?php
/*
php/content/content-expert-approval.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the Expert Approval Form page 'expert-approval.php'
It contains a form for applying to become a CTR Expert Reviewer

NOTE: This page is private - it is not included in the CTREX menus or navigation - the URL is provided to prospective experts by CTR Staff at their discretion
*/

// get the stored product submission after redirection
$sessionItem = 'expert-approval';				// specifies the $_SESSION storage item for the form submission data
require_once 'php/form-submission-get.php';		// gets the stored submission data and assigns each item in the array to a variable
$confirmationType = 'expert-approval';			// specifies $_SESSION storage item prefix for the confirmation number
require_once 'php/get-confirmation-number.php';	// gets the confirmation number from $_SESSION storage and displays it

// ARRAY OF FORM FIELDS
// array (label			, name			, value			, type		, required, note)
$expertApprovalInfo = array
(
	array('Name'		, 'inputName'	, $inputName	, 'text'	, true	, ''),
	array('Job Title'	, 'expTitle'	, $expTitle		, 'text'	, false	, ''),
	array('Company'		, 'expCompany'	, $expCompany	, 'text'	, false	, ''),
	array('Email'		, 'inputEmail'	, $inputEmail	, 'email'	, true	, '')
);
$_SESSION['expert-approval-info'] = $expertApprovalInfo;
$expertApprovalCodes = array
(
	array('Receive product download codes at this address?', 'expGetCodes', $expGetCodes, 'radio', false, '')
);
$_SESSION['expert-approval-codes'] = $expertApprovalCodes;
$expertApprovalBackground = array
(
	array('Send Products To'	, 'expSendProducts'	, $expSendProducts	, 'textarea', false, ''),
	array('Short Bio'			, 'expBio'			, $expBio			, 'textarea', true, ''),
	array('Expertise'			, 'expExpertise'	, $expExpertise		, 'textarea', true, ''),
	array('Bias'				, 'expBias'			, $expBias			, 'textarea', true, ''),
);
$_SESSION['expert-approval-background'] = $expertApprovalBackground;

// FORM SECTIONS
$approvalFormSections = array
(
	array('Expert Info'		, '', $expertApprovalInfo),
	array('Receive Codes?'	, '', $expertApprovalCodes),
	array('Expert Bio'		, '', $expertApprovalBackground)
);
?>

<div class = "page-header"><a href = "experts.php">CTR Expert Reviewer</a> Application Form [BETA]</div>
<div class = "subheader">Please fill out the application form and accept the terms below:</div>

<!-- FORM START -->
<form name = "expert-approval-form" method = "POST" action = "expert-approval-process.php" />

<!-- FIELD CONTAINER -->
<div class = "paragraph-container">

	<!-- REQUIRED FIELD NOTE -->
	<div class = "row top-20">
		<div class = "field-label"><strong>* Indicates required field</strong></div>
		<div class = "field-container"></div>
		<div class = "field-note"></div>
	</div><!-- /.row -->
	
	<?php $fields = $expertApprovalInfo; 		require 'php/form-fields-output.php'; // text fields ?>
	
	<!-- RECEIVE CODES RADIO BTNS -->
	<div class = "center bottom-10">
		Receive product download codes at this address?<br/>
		<div class = "inline">Yes</div>
		<div class = "inline"><input type = "radio" name = "expGetCodes" id = "yes" value = "yes" <?php if($expGetCodes == 'yes') { echo 'checked'; }?>/></div>
		<div class = "inline">No</div>
		<div class = "inline"><input type = "radio" name = "expGetCodes" id = "no" value = "no"   <?php if($expGetCodes == 'no')  { echo 'checked'; }?>/></div>
	</div><!-- /.center bottom-10 -->
	
	<?php $fields = $expertApprovalBackground; 	require 'php/form-fields-output.php'; // textareas ?>
	
</div><!-- /.paragraph-container -->

<!-- CONDITIONS -->
<div class = "center bottom-20">Photo: Please email a headshot photo to <a href = "mailto:info@childrenstech.com">info@childrenstech.com</a></div>
<div class = "center bottom-10">In order to become a <a href = "experts.php">CTR Expert Reviewer</a>, I will agree to the following conditions:</div>
<div class = "left bottom-20 paragraph-70" id = "conditions">
	<ul>
	<?php
	$approvalConditions = array
	(
		'I will disclose any bias either direct or indirect that could influence my opinion of a product. This might include past consulting relationships, any financial ties, or personal relationships that could influence my review or rating.',
		'A link to my public CTREX profile will appear with my reviews.',
		'I understand this is a volunteer (unpaid) activity, although I will receive a CTREX Pro level subscription, as long as my Expert Reviewer status is active.',
		'Any material I contribute will become property of Active Learning Associates, Inc., the publishers of CTREX.',
		'Anything I write or rate is subject to editing by CTR staff.',
		'Your status as an Expert Reviewer may be terminated at any time by myself or by CTR editors.'
	);
	foreach($approvalConditions as $condition) { echo '<li>'.$condition.'</li>'; }
	?>
	</ul>
</div><!-- /#conditions -->
<?php require 'php/captcha.php';?>
<input type = "submit" name = "expSubmit" value = "Submit"/>
</form>