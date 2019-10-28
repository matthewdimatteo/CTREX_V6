<?php
/*
login-process.php
By Matthew DiMatteo, Children's Technology Review

This file processes the login form input using the $_POST method and determines a course of action based on the validity of the login credentials

The 'login as publisher' checkbox in the 'login-form.php' file creates a second case for form processing in this file
In both the subscriber and publisher cases, custom error messages are set on failed login attempts
These values are saved in $_SESSION storage and accessed by 'session.php' after the redirect

In the case of a subscriber login where the username and password match, but the account has expired, a separate error message is set

In the case of a successful login, the user's settings (such as saved searches and bookmarks) are saved in $_SESSION storage
The user is then redirected to 'home.php'
*/
$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page

// if login form submitted properly
if(isset($_POST['username']))
{	
	// get form inputs from login page
	$inputUsername 		= test_input($_POST['username']);
	$inputPassword 		= test_input($_POST['password']);
	$loginAsPub			= test_input($_POST['publisher']);
	$redirectOnError 	= test_input($_POST['redirect-on-error']);	if($redirectOnError == NULL) 	{ $redirectOnError 		= 'login.php'; }
	$redirectOnSuccess 	= test_input($_POST['redirect']);			if($redirectOnSuccess == NULL) 	{ $redirectOnSuccess 	= 'home.php'; }
	
	// only process login if username and password have values
	if($inputUsername != NULL and $inputPassword != NULL)
	{
		// handle subscriber login
		if($loginAsPub == NULL)
		{
			// lookup subscriber by entered username and password
			$findSub = $fmsubs->newFindCommand($fmsubsLayout);
			$findSub->addFindCriterion('ctrexUsername','=='.$inputUsername);
			$findSub->addFindCriterion('ctrexPassword','=='.$inputPassword);
			$result = $findSub->execute(); 

			/* 
			SUBSCRIBER LOGIN FAILED
			if no match for entered username and password
			*/
			if(FileMaker::isError($result))
			{ 
				$login 		= false; 
				$redirect 	= $redirectOnError;
				$pageTitle 	= 'Login Failed - Redirecting...';

				// set a flag to show error mesage upon redirection to login page
				$_SESSION['login-failed'] = true;
				$_SESSION['login-failed-username'] 	= $inputUsername;
				$_SESSION['login-failed-password'] 	= $inputPassword;
				$_SESSION['login-failed-publisher'] = $loginAsPub;

				$_SESSION['error'] 			= true;
				$_SESSION['error-message'] 	= 'Sorry, the username or password you entered is incorrect. Please try again.';
			}

			// if entered username and password match
			else
			{
				// lookup record in database
				$record 		= $result->getFirstRecord();
				$subscriberID 	= $record->getField('globalID');
				$username 		= $record->getField('ctrexUsername');

				// check if active
				$substatus		= $record->getField('substatus');
				$expDate		= $record->getField('expDate');

				/*
				SUBSCRIBER EXPIRED
				if subscription is expired, set a flag and redirect to login page
				*/
				if($substatus != 'Active')
				{
					$login 		= false;
					$redirect 	= $redirectOnError;
					if(substr_count($redirect, 'login.php') > 0) { $redirect = 'renew.php'; } // enable redirect to renewal page
					$pageTitle	= 'Subscription Expired - Redirecting...';

					// set a flag to show error mesage upon redirection to login page
					$_SESSION['login-failed'] = true;
					$_SESSION['login-failed-username'] 	= $inputUsername;
					$_SESSION['login-failed-password'] 	= $inputPassword;
					$_SESSION['login-failed-publisher'] = $loginAsPub;

					$_SESSION['error'] 			= true;
					$_SESSION['error-message'] 	= 'Your subscription to CTREX has expired as of '.$expDate.'.';

					$expired = true;
					$_SESSION['expired'] = true;
				} // end if $substatus != 'Active';

				/* 
				SUBSCRIBER LOGIN SUCCESFUL
				if subscription is active, get profile data from database, store it in session, and return to home page
				*/
				else
				{
					$login 		= true;
					$expired 	= '';
					$_SESSION['expired'] = '';
					$redirect 	= urldecode($redirectOnSuccess);
					$pageTitle 	= 'Login Successful - Redirecting...';
					require_once 'php/get-sub.php'; // get the remaining record fields
				} // end else $active == true
			} // end else (username and password match)
		} // end if (subscriber login)

		// publisher login
		else
		{
			$findPub = $fmpubs->newFindCommand($fmpubsLayout);
			$findPub->addFindCriterion('username','=='.$inputUsername);
			$findPub->addFindCriterion('password','=='.$inputPassword);
			$result = $findPub->execute();

			/* 
			PUBLISHER LOGIN FAILED
			if no match for entered username and password
			*/
			if(FileMaker::isError($result))
			{ 
				$login 		= false; 
				$redirect 	= $redirectOnError;
				$pageTitle 	= 'Login Failed - Redirecting...';

				// set a flag to show error message upon redirection to login page
				$_SESSION['login-failed'] = true;
				$_SESSION['login-failed-username'] 	= $inputUsername;
				$_SESSION['login-failed-password'] 	= $inputPassword;
				$_SESSION['login-failed-publisher'] = $loginAsPub;

				$_SESSION['error'] 			= true;
				$_SESSION['error-message'] 	= 'Sorry, the username or password you entered is incorrect. Please try again.';
			} // end if error

			/*
			PUBLISHER LOGIN SUCCESSFUL
			if entered username and password match
			*/
			else
			{
				$login 		= true;
				$publisher 	= true;
				$redirect 	= 'home.php';
				$pageTitle 	= 'Login Successful - Redirecting...';

				// get profile info from database
				$record = $result->getFirstRecord();
				$publisherID	= $record->getField('recordID');
				$username 		= $record->getField('username');
				$publisherName 	= $record->getField('Company Name');
				require_once 'php/get-pub.php'; // get field values and save publisher info in session storage			
			} // end else (username and password match)
		} // end else (publisher login)

		require_once 'php/profile-save.php'; // save profile data in PHP $_SESSION storage for future reference
	
	} // end if username and password != null
	else { $redirect = 'login.php'; $pageTitle = 'Redirecting...'; }
} // end if isset username

// if page accessed without submitting form
else { $redirect = 'login.php'; $pageTitle = 'Redirecting...'; }

// includes the html for a redirect
require_once 'php/redirect.php';
?>