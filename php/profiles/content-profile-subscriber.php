<?php
/*
php/profiles/content-profile-subscriber.php
By Matthew DiMatteo, Children's Technology Review

This file displays a subscriber profile using a tab control for different groups of data
It is included in the file 'php/content-profile.php'

For publisher profiles, refer to 'php/profiles/content-profile-publisher.php'
For site license organizational profiles, refer to 'php/profiles/content-profile-license.php'
*/

// GET FIELD VALUES
require_once 'php/get-sub.php'; // get the field values from the 'subbies.fmp12' database file

// determine what to show for private vs. public
switch($inputMode)
{
	case 'private' 	: 
		$headerLabel = $username;
		$optionsClass = 'block';
		$previewClass = 'block';
		$previewLabel = 'Preview Public Profile';
		if($expert == true) { $previewLabel = 'View Public Profile'; $optionsClass = 'hide'; }
		if($share == true) 	{ $previewLabel = 'View Public Profile'; }
		$previewLink = 'profile.php?id='.$userID.'&type=subscriber&mode=public';
		
		// specify an array of items for the tab control
		$sections = array
		(
			array('about'		, 'About'),
			array('subscription', 'Subscription'),
			array('contact'		, 'Contact'),
			array('bio'			, 'Bio'),
			array('searches'	, 'Searches'),
			array('bookmarks'	, 'Bookmarks'),
			array('rubrics'		, 'Rubrics'),
		);
		if($expert == true) { array_push($sections, array ('reviews', 'Reviews')); }
		break;
	case 'public'	:	
		$headerLabel = $screenName; if($expert == true) { $headerLabel = $fullName; }
		$optionsClass = 'hide';
		$sections = array
		(
			array('bio'		, 'Bio'),
			array('contact'	, 'Contact'),
		);
		if($numSavedRubrics > 0) 						{ array_push($sections, array('rubrics', 'Rubrics')); }
		if($numExpertReviews > 0 or $numCSRreviews > 0) { array_push($sections, array('reviews', 'Reviews')); }
		if($userID == $inputID)
		{
			$previewClass = 'block';
			$previewLabel = 'Return to Edit Mode';
			$previewLink = 'profile.php?id='.$inputID.'&type=subscriber&mode=private';
		}
		else
		{
			$optionsClass = 'hide';
			$previewClass = 'hide';
			$previewLabel = '';
			$previewLink = '';
		}
		break;
} // end switch

// ADD USERNAME TO PAGE TITLE
if($username != NULL)
{
	if($pageTitle == NULL) { $pageTitle = 'CTREX Profile'; }
	$pageTitle .= ' - '.$username;
	echo '<script>setPageTitle(\''.$pageTitle.'\');</script>';
} // end if $username

/*
CHECK IF USERNAME NOT AVIALABLE ERROR 
not included in custom error messages 'php/messages-error.php', because 'profile-check.php' and 'profile-update.php' files require access to $_SESSION values
*/
$usernameChecked 		= $_SESSION['username-available'];
$usernameTaken 			= $_SESSION['username-taken'];
$usernameErrorMessage 	= $_SESSION['username-taken-message'];

// reset the session values
$_SESSION['username-available'] 	= '';
$_SESSION['username-taken'] 		= '';
$_SESSION['username-taken-message'] = '';

if($usernameTaken == true and $usernameErrorMessage != NULL) 	{ $usernameErrorMessageClass = 'block'; }
else 															{ $usernameErrorMessageClass = 'hide'; }
?>

<!-- USERNAME ERROR MESSAGE -->
<div id = "custom-error-message-container" class = "<?php echo $usernameErrorMessageClass;?>">
	<div id = "custom-error-message" class = "error-message"><?php echo $usernameErrorMessage;?></div>
</div>

<!-- PAGE HEADER -->
<div class = "profile-header"><?php echo $headerLabel;?>'s CTREX Profile</div><!-- /.profile-header -->

<!-- PAGE CONTAINER -->
<div id = "profile-container-subscriber">

	<!-- SHARE/HIDE -->
	<div id = "profile-options-container" class = "<?php echo $optionsClass;?>">
		<form name = "profile-update-form-subscriber-privacy" method = "POST" action = "profile-update.php">
			<div class = "profile-options">
				<div id = "share-hide-container">
					<div class = "profile-options-btn">
						<input type = "radio" name = "share" id = "share" value = "share" <?php if($share == true) { echo 'checked'; } ?> onchange = "this.form.submit()" />
					</div>
					<div class = "profile-options-label">Share</div>
					<div class = "profile-options-btn">
						<input type = "radio" name = "share" id = "hide" value = "hide" <?php if($share != true) { echo 'checked'; } ?> onchange = "this.form.submit()" />
					</div>
					<div class = "profile-options-label">Hide</div>
				</div><!-- /#share-hide-container -->
				<input type = "hidden" name = "type" 		value = "subscriber" />
				<input type = "hidden" name = "section" 	value = "privacy" />
			</div><!-- /.profile-options -->
		</form><!-- /profile-update-form-subscriber-privacy -->
	</div><!-- /#profile-options-container -->
	
	<!-- PREVIEW PUBLIC-->
	<div id = "preview-public-container" class = "<?php echo $previewClass;?>">
		<div class = "profile-options">
			<a href = "<?php echo $previewLink;?>"><?php echo $previewLabel;?></a>
		</div><!-- /.profile-options -->
	</div><!-- /#preview-public-container -->
	
	<?php 
	require_once 'php/profiles/profile-sections.php'; // outputs each section as a tab
	require_once 'php/save-item-forms.php'; // html forms for saving searches, bookmarks
	?>
	
</div><!-- /.profile-container-subscriber -->