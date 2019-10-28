<?php
/*
php/content/content-license-order.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the site license order form page 'license-order.php'
*/
require_once 'php/license-calc-get.php'; 		// get the last cost calculation based on #admins/terminals specified
$numAdminsCalc = $numAdmins;					// save a separate variable here for # of admin field rows to output
$confirmationType = 'site-license-order';		// specifies $_SESSION storage item prefix for the confirmation number
require_once 'php/get-confirmation-number.php'; // gets the confirmation number from $_SESSION storage and displays it
?>

<div class = "page-header">Customize Your CTREX Site License</div>
<div id = "site-license-order-content" class = "paragraph-70 center">
<div class = "full-width left">

	<!-- STEP 1 -->
	<div id = "license-order-step-1" class = "bottom-40">
		<div class = "bold text-18">Step 1: Review your order details:</div>
		<div><?php require_once 'php/license-calc-form.php';?></div>
	</div><!-- /#step1 -->
	
	<!-- ORDER FORM START -->
	<form name = "site-license-order-form" id = "site-license-order-form" method = "POST" action = "license-process.php">
	
	<!-- STEP 2 -->
	<div id = "license-order-step-2" class = "bottom-40">
		<div class = "bold text-18 bottom-10">Step 2: Provide the contact info for your administrators. We need a valid email address for each</div>
		<div class = "bottom-10">
			Enter administrator names and addresses in the fields below, or send via email to 
			<a href = "mailto:info@childrenstech.com">info@childrenstech.com</a>
		</div>
		
		<!-- TOGGLE EMAIL FIELDS -->
		<div id = "toggle-email-fields" class = "btn-text bottom-10">
			<div class = "block" id = "hide-email-fields" >
				<div onclick = "hideItem('show-email-fields', 'hide-email-fields', 'email-fields')">Hide Email Fields</div>
			</div>
			<div class = "hide" id = "show-email-fields">
				<div onclick = "showItem('show-email-fields', 'hide-email-fields', 'email-fields')">Show Email Fields</div>
			</div>
		</div><!-- /#toggle-email-fields -->
	
		<!-- HIDDEN INPUTS FOR NUM ADMINS, TERMINALS, COST -->
		<?php
		//array(label, name, value, type, required, note)
		$orderFields = array
		(
			array('#Admins'			, 'numAdmins'		, $numAdmins		, 'hidden' , false, ''),
			array('#Terminals'		, 'numTerminals'	, $numTerminals		, 'hidden' , false, ''),
			array('Admin Rate'		, 'adminRate'		, $adminRate		, 'hidden' , false, ''),
			array('Terminal Rate'	, 'terminalRate'	, $terminalRate		, 'hidden' , false, ''),
			array('Admin Cost'		, 'adminCost'		, $adminCost		, 'hidden' , false, ''),
			array('Terminal Cost'	, 'terminalCost'	, $terminalCost		, 'hidden' , false, ''),
			array('Total Cost'		, 'totalCost'		, $totalCost		, 'hidden' , false, ''),
			array('Admin Savings'	, 'adminSavings'	, $adminSavings		, 'hidden' , false, ''),
			array('Terminal Savings', 'terminalSavings'	, $terminalSavings	, 'hidden' , false, ''),
			array('Total Savings'	, 'totalSavings'	, $totalSavings		, 'hidden' , false, ''),
		);
		$_SESSION['order-fields'] = $orderFields;
		$fields = $orderFields;
		require 'php/form-fields-output.php';
		?>
		
		<div id = "email-fields">
		<?php
		/*
		get the submission data on a redirect (if # not specified)
		do this AFTER the $orderFields hidden inputs have been set to allow user to recalculate with different #admins/terminals
		*/
		$sessionItem = 'site-license-order-details';	// specifies the $_SESSION storage item for the form submission data
		require_once 'php/form-submission-get.php';		// gets the stored submission data and assigns each item in the array to a variable
		
		$adminInfo = array();
		for($a = 0; $a < $numAdminsCalc; $a++) 
		{ 
			$b = $a + 1;
			
			// calculate variable names for each admin
			$adminEmailVarName = 'admin'.$b.'Email';
			$adminFnameVarName = 'admin'.$b.'Fname';
			$adminLnameVarName = 'admin'.$b.'Lname';
			$adminTitleVarName = 'admin'.$b.'Title';
			
			// set the field values to the dynamic variable values
			$adminEmail = $$adminEmailVarName;
			$adminFname = $$adminFnameVarName;
			$adminLname = $$adminLnameVarName;
			$adminTitle = $$adminTitleVarName;
			
			// array(label, name, value, type, required, note, width)
			$thisAdminFields = array
			(
				array('Email'		, $adminEmailVarName	, $adminEmail	, 'email'	, false	, '', 'width-30'),
				array('First Name'	, $adminFnameVarName	, $adminFname	, 'text'	, false	, '', 'sixths'),
				array('Last Name'	, $adminLnameVarName	, $adminLname	, 'text'	, false	, '', 'sixths'),
				array('Job Title'	, $adminTitleVarName	, $adminTitle	, 'text'	, false	, '', 'width-30')
			);
			foreach($thisAdminFields as $thisAdminField) { array_push($adminInfo, $thisAdminField); }
			
			echo '<div id = "admin-'.$b.'-row">';
				$fields = $thisAdminFields;
				require 'php/form-fields-output-inline.php';
			echo '</div>'; // end admin-$b-row
		} // end for
		$_SESSION['admin-info-fields'] = $adminInfo;
		?>
		</div><!-- /#license-order-email-fields -->
	</div><!-- /#step-2 -->
	
	<!-- STEP 3 -->
	<div id = "license-order-step-3" class = "bottom-40">
		<div class = "bold text-18 bottom-10">Step 3: Provide your organization's contact information</div>
		<?php
		//array(label, name, value, type, required, note)
		$orgInfoFields = array
		(
			array('Organization Name'	, 'inputName'	, $inputName		, 'text'	, true	, 	''),
			array('Email Address'		, 'inputEmail'	, $inputEmail		, 'email'	, true	, 	''),
			array('Street Address'		, 'street'		, $street			, 'text'	, false	, 	''),
			array('City'				, 'city'		, $city				, 'text'	, false	, 	''),
			array('State'				, 'state'		, $state			, 'text'	, false	, 	''),
			array('Zip'					, 'zip'			, $zip				, 'text'	, false	, 	''),
			array('Country'				, 'country'		, $country			, 'text'	, false	, 	''),
			array('Phone'				, 'phone'		, $phone			, 'text'	, false	, 	''),
			array('Phone 2'				, 'phone2'		, $phone2			, 'text'	, false	, 	''),
			array('Fax'					, 'fax'			, $fax				, 'text'	, false	, 	''),
		);
		$_SESSION['org-info-fields'] = $orgInfoFields;
		$fields = $orgInfoFields;
		require 'php/form-fields-output.php';
		?>
	</div><!-- /#step-3 -->
	
	<!-- STEP 4 -->
	<div id = "license-order-step-4" class = "bottom-40">
		<div class = "bold text-18 bottom-10">Step 4: Enter the digits and press the button below to submit your order:</div>
		<div class = "full-width center"><?php require_once 'php/captcha.php';?></div>
		<div class = "full-width center"><input type = "submit" name = "site-license-order-submit" value = "Submit Your Order"/></div>
	</div><!-- /#step-4 -->
	
	</form><!-- ORDER FORM END -->
	
	<div id = "payment-instructions" >
        <p>You'll receive an email confirmation of your order immediately, and an invoice via email within 1-2 business days.</p>
       	<p><strong>To Pay by Credit Card:</strong> Call 908-284-0404 from 9:00 - 3:30 EST</p>
        <div><strong>To Pay by Check or Purchase Order:</strong></div>
        <div>Mail payment to:</div>
        <div class = "left-20">
            Children's Technology Review
            <br />
            126 Main Street
            <br />
            Flemington, NJ 08822
        </div>
        <p>Or Fax to 908-284-0405</p>
        <p>Your site license will be activated once we have processed your payment.</p>
        <p>Thank you for supporting our work!</p>
    </div><!-- /#payment-instructions -->
</div><!-- /#paragraph-80 left -->
</div><!-- #site-license-order-content -->