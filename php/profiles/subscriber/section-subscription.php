<?php
/*
php/profiles/subscriber/section-subscription.php
By Matthew DiMatteo, Children's Technology Review

This file defines the content for the 'Subscription' section of the subscriber profile
An array is constructed for each set of fields to be displayed - this array is output by the file 'php/profiles/section-items.php'
The array should include:
- the field label ($label)
- the element id/variable name ($id) *
- whether the field should be editable or readonly ($edit), true if editable, false if readonly
- the type of input ($type) such as text, email, password, number
- and an annotation, if any ($note) to provide some context for the field

* Regarding variable names:

The values for each field on the profile are stored in variables whose names are calculated dynamically
- For subscriber profiles, reference 'php/get-sub.php'
- For site license organization profiles, reference 'php/get-license.php'
- For publisher profiles, reference 'php/get-pub.php'

The input elements share the same name as their corresponding variables
The page for processing $_POST data for profile update form submissions should target fields by those names


This file handles both the 'private' (editable) and 'public' cases
This file also includes site license information for site license administrators

This is one of multiple files for each profile section

Each of these files must follow the filename convention:
'section-' followed by the string used to define a section in the $sections array in php/profiles/content-profile-subscriber.php
*/

// PRIVATE (EDITABLE) PROFILE
if($inputMode == 'private')
{
	// FORM START (SUBSCRIPTION)
	echo '<form name = "profile-update-form-subscriber-subscription" method = "POST" action = "profile-check.php">';
		
		// SUBSCRIPTION INFO
		echo '<div id = "subscription-info" class = "profile-section-content">';

			// SECTION HEADER
			echo '<div class = "profile-section-header">';
				echo $username.'\'s CTREX Subscription';
				echo '<br/>';
				echo '(NOT Included on <a href = "'.$previewLink.'">Public Profile</a>)';
			echo '</div>'; // /.profile-section-header

			// SECTION ITEMS
			// array (label			, id/var		, edit	, type		, note)
			$sectionItems = array
			(
				array('Email'		, 'email'			, true	, 'email'	, 'Where you receive the CTR Weekly Newsletter and Monthly Issue'),
				array('Screen Name'	, 'screenName'		, true	, 'text'	, 'Appears with any comments you post on reviews'),
				array('Username'	, 'ctrexUsername'	, true	, 'text'	, 'Never displayed publically*'),
				array('Password'	, 'password'		, true	, 'password', 'Please avoid using the characters < > # \ " " & as these will not work'),
				array('Start Date'	, 'startDate'		, false	, ''		, ''),
				array('Exp. Date'	, 'expDate'			, false	, ''		, '')
			);

			// declare an array containing the names and values of only this section's fields
			$sectionItemsSubscription = array();
			$s = -1;
			foreach($sectionItems as $item)
			{
				$s += 1;
				$varName 	= $item[1];
				$value 		= $$varName;
				$edit		= $item[2];
				if($edit == true) { $sectionItemsSubscription[$s] = array($varName, $value); }
			}
			// foreach($sectionItemsSubscription as $item){ $varName = $item[0]; $value = $item[1];	echo $varName.': '.$value.'<br/>'; }

			// INPUT FIELDS
			require 'php/profiles/section-items.php'; // outputs the items in the array

			// HIDDEN INPUTS
			echo '<input type = "hidden" name = "type" 		value = "subscriber" />';
			echo '<input type = "hidden" name = "section" 	value = "subscription" />';
			
			// FOOTNOTE
			echo '<div class = "profile-section-footnote">';
			
				// PASSWORD SPECIAL CHARS
				//echo '<div>Note: When creating a password, please avoid using the characters < > # \ " " & as these will not work.</div><br/>';
				
				// ADD 1 YEAR
				echo '<button type = "button" onclick = "document.getElementById(\'renewal-form\').submit();">';
					echo 'Add 1 Year to your CTREX Subscription ($10 off)';
				echo '</button><br/>';
				
				// PRIVACY
				echo '*By default, your username is set to the email address used to purchase your initial subscription.<br/>';
				echo 'To ensure privacy, it is recommended that you change this to something else.';
				
			echo '</div>'; // /.profile-section-footnote

			// UPDATE BTN
			echo '<div class = "profile-section-submit-btn">';
				echo '<input type = "submit" name = "update-subscription-info" value = "Update this informtion" />';
			echo '</div>'; // /.#profile-section-submit-btn

		echo '</div>'; // /#subscription-info
	
	echo '</form>'; // FORM END (SUBSCRIPTION)
	
	// RENEWAL FORM (HIDDEN)
	require 'php/renewal-form.php'; // contains the hidden html form for loading authorize.net secure transaction portal
	
	// SITE LICENSE INFO
	if($siteAdmin == true)
	{
		$siteProfileLink = 'profile.php?id='.$siteName.'&type=license&mode=public';
		
		// FORM START (LICENSE)
		echo '<form name = "profile-update-form-subscriber-license" method = "POST" action = "profile-update.php">';
		
			// LICENSE INFO CONTAINER
			echo '<div id = "site-license-info" class = "profile-section-content">';

				// SECTION HEADER
				echo '<div class = "profile-section-header">';
					echo 'Site License Administrator for <a href = "'.$siteProfileLink.'">'.$siteOrg.'</a>';
					echo '<br/>';
					echo '(Visible to your patrons on your <a href = "'.$siteProfileLink.'">Organization Profile Page</a>**)';
				echo '</div>'; // /.profile-section-header

				// SECTION ITEMS
				// array (label			, id/var			, edit	, type		, note)
				$sectionItems = array
				(
					array('Portal URL'	, 'portal'			, false	, 'text'	, ''),
					array('Start Date'	, 'siteStartDate'	, false	, 'text'	, ''),
					array('Exp Date'	, 'siteExpDate'		, false	, 'text'	, ''),
					array('IP Range'	, 'ipRange'			, true	, 'text'	, ''),
					array('FTE Size'	, 'fte'				, true	, 'text'	, ''),
					array('Email'		, 'siteEmail'		, true	, 'email'	, ''),
					array('Address'		, 'siteAddressStreet', true	, 'text'	, ''),
					array('City'		, 'siteAddressCity'	, true	, 'text'	, ''),
					array('State'		, 'siteAddressState', true	, 'text'	, ''),
					array('Zip'			, 'siteAddressZip'	, true	, 'text'	, ''),
					array('Country'		, 'siteAddressCountry', true, 'text'	, ''),
					array('Phone 1'		, 'sitePhone1'		, true	, 'text'	, ''),
					array('Phone2'		, 'sitePhone2'		, true	, 'text'	, ''),
					array('Fax'			, 'siteFax'			, true	, 'text'	, ''),
				);

				// INPUT FIELDS
				require 'php/profiles/section-items.php'; // outputs the items in the array
				
				// HIDDEN INPUTS
				echo '<input type = "hidden" name = "type" 		value = "subscriber" />';
				echo '<input type = "hidden" name = "section" 	value = "license" />';

				// FOOTNOTE
				echo '<div class = "profile-section-footnote">';
					echo '*This information appears on your <a href = "'.$siteProfileLink.'">organization profile page</a>.<br/>';
					echo 'This page is only visible only to you and your organization\'s patrons.';
				echo '</div>'; // /.profile-section-footnote

				// UPDATE BTN
				echo '<div class = "profile-section-submit-btn">';
					echo '<input type = "submit" name = "update-license-info" value = "Update this information" />';
				echo '</div>'; // /.#profile-section-submit-btn
				
				echo '<br/>';
				
				// SECTION HEADER - USAGE
				echo '<div class = "profile-section-header">';
					echo '<div id = "usage-report-heading">Site License Usage by Your Patrons</div>';
				echo '</div>'; // /.profile-section-header
				
				// EXPLANATION
				echo '<div id = "usage-report-explanation">';
					echo 'Select the button below to generate a usage report detailing patron activity for your site license.';
				echo '</div>'; // /#usage-report-explanation
	
				// USAGE REPORT BUTTON
				echo '<div id = "usage-report-button-container" class = "profile-section-submit-btn">';
					echo '<button type = "button" onclick = usageReport(\'alltime\')>Generate Usage Report</button>';
				echo '</div>'; // /#usage-report-button-container
		
			echo '</div>'; // /#site-admin-info
		
		echo '</form>'; // FORM END (LICENSE)
		
		// USAGE REPORT FORM
		require_once 'php/usage-report-form.php'; // hidden form for generating usage report
	} // end if $siteAdmin
} // end if private
?>