<!--
'login-form.php'
By Matthew DiMatteo, Children's Technology Review

This file contains the html for the login form
It is included in two places: within the header (on all pages except the page 'login.php') and within the 'content-login' file

The $lastAttempt* variables are set when a login attempt fails in the file 'login-process.php'
The input username, password, and login-as-publisher values are saved in $_SESSION storage and accessed below
Once the variables are set, the $_SESSION values are then reset so as to only display on the initial redirect after a failed login

The 'redirect-on-error' input contains the current page url $thisURL so as to redirect the user to whichever page they were on for a failed login

The 'redirect' input is for redirect after a successful login
-->
<?php
// get the stored values from 'login-process.php'
$lastAttemptUsername	= $_SESSION['login-failed-username'];
$lastAttemptPassword	= $_SESSION['login-failed-password'];
$lastAttemptPublisher	= $_SESSION['login-failed-publisher'];

// clear the stored values after the initial redirect
$_SESSION['login-failed-username'] 	= '';
$_SESSION['login-failed-password'] 	= '';
$_SESSION['login-failed-publisher'] = '';
?>

<form name = "login-form" id = "login-form" method = "POST" action = "login-process.php">

	<!-- USERNAME ROW -->
	<div class = "row" id = "login-username-row">
		<input type = "text" 		id = "login-input-username" name = "username" required placeholder = "Username" 
		<?php if ($lastAttemptFailed == true) { echo 'value = "'.$lastAttemptUsername.'"'; } ?> title = "Don't know your username? Try using the email address associated with your CTR Subscription. You can also email us at info@childrenstech.com or call us at 908-284-0404"/>
	</div><!-- /.row -->
	
	<!-- PASSWORD ROW -->
	<div class = "row" id = "login-password-row">
		<input type = "password" 	id = "login-input-password" name = "password" required placeholder = "Password" />
	</div><!-- /.row -->
	
	<!-- LOG IN AS PUBLISHER ROW -->
	<div class = "row" id = "login-as-publisher-row">
		<div class = "col">
			<input type = "checkbox" name = "publisher" id = "publisher" value = "publisher" 
			<?php if($lastAttemptPublisher == 'publisher') { echo 'checked'; }?> /> 
		</div><!-- /.col -->
		<div class = "col" id = "login-as-publisher-label" onclick = "loginAsPublisher()">
			Log in as publisher
		</div><!-- /.col -->
	</div><!-- ./row -->
	
	<!-- HIDDEN INPUT FOR REDIRECT DESTINATION ON ERROR (CURRENT PAGE URL) -->
	<input type = "hidden" name = "redirect-on-error" value = "<?php echo $thisURL;?>" />
	
	<!-- HIDDEN INPUT FOR REDIRECT DESTINATION ON SUCCESS -->
	<?php
	if($thisPage != 'login.php') 	{ $redirect = $thisURL; } else { $redirect = $lastSearch; } // by default, return to page where login form was submitted
	if($loginRedirect != NULL)		{ $redirect = $loginRedirect; } // override - this value is set in 'php/content-login.php'
	?>
	<input type = "hidden" name = "redirect" value = "<?php echo $redirect;?>" />
	
	<!-- SUBMIT BUTTON ROW -->
	<div class = "row" id = "login-submit-btn-row">
		<input type = "submit" id = "login-input-submit" name = "submit-login" value = "Log In" />
	</div>
	
	<?php
	if($thisPage == 'login.php')
	{
		echo '<br/>';
		require_once 'php/username-help.php'; // display toggleable username hint
		
		// FORGOT YOUR PASSWORD?
		echo '<div class = "text-16" id = "password-help">';
			echo '<a href = "password.php" title = "Visit our password recovery page">Forgot your password?</a>';
		echo '</div>'; // /#password-help
	} // end if $thisPage == 'login.php'
	?>
	
</form><!-- /#login-form -->