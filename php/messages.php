<?php
/*
messages.php
By Matthew DiMatteo, Children's Technology Review

This file displays custom messages in the area just below the header. It is included in the file 'header.php'
Content for promo, new feature, and error messages is entered into the dashboard table of the CSR.fmp12 file
The file 'settings.php' gets these field values and determines global variable values based on them
*/

require_once 'php/get-promocode.php'; // gets the stored session values for a promocode form submission and sets certain copy and css classes accordingly

// DETERMINE WHETHER TO SHOW OR HIDE ELEMENTS BASED ON SESSION VALUES
if($velvetRope == true) 									{ $promoMessageClass 		= 'block'; } 	else { $promoMessageClass 		= 'hide'; }
if($freeMode == true) 										{ $freeModeMessageClass 	= 'block'; }	else { $freeModeMessageClass 	= 'hide'; }
if($newFeatureShow == true and $newFeatureHeader != NULL) 	{ $newFeatureClass 			= 'block'; } 	else { $newFeatureClass 		= 'hide'; }
if($errorMessageShow == true and $errorMessage != NULL) 	{ $errorMessageClass		= 'block'; } 	else { $errorMessageClass 		= 'hide'; }
if($promocodeEntered != NULL) 								{ $promocodeSubmittedClass 	= 'block'; } 	else { $promocodeSubmittedClass = 'hide'; }
if($expired == true and $thisPage != 'renew.php')			{ $renewalMessageClass 		= 'block'; } 	else { $renewalMessageClass 	= 'hide'; }
if($profile == true)										{ $loggedInMessageClass		= 'block'; }	else { $loggedInMessageClass	= 'hide'; }
?>

<!-- LOGGED IN AS INDICATOR -->
<div id = "logged-in-message-container" class = "<?php echo $loggedInMessageClass;?>">
	<div id = "logged-in-message" class = "promo logged-in-message">
		Logged in as <?php echo '<a href = "'.$profileURL.'">'.$usernameLabel.'</a>';?>
	</div>
</div><!-- /#logged-in-message-container -->

<!-- PROMO MESSAGE (light blue bar) -->
<?php
// OMIT THE FORM ON CERTAIN PAGES THAT INCLUDE IT SEPARATELY (DUE TO ELEMENT ID CONSTRAINTS)
if($thisPage == 'login.php' or $thisPage == 'subscribe.php' or $thisPage == 'student.php' or $thisPage == 'promocode.php') { $omitPromoForm = true; }
?>
<div id = "promo-message-container" class = "<?php echo $promoMessageClass;?>">
	
	<div id = "promo-message-show" class = "promo message pointer" 
		<?php if($omitPromoForm != true) { echo 'title = "Show the promocode entry form"'; } else { echo 'title = "Scroll down for promocode entry form"'; } ?>
		<?php if($omitPromoForm != true) { echo 'onclick = "showItem(\'promo-message-show\', \'promo-message-hide\', \'promocode-form-container\')"'; } 
				else					 { echo 'onclick = "showPromocodeEntry()";'; }
		?> 
	>
		<?php echo $promoMessage; if($omitPromoForm != true) { echo ' &#9660;'; } ?>
	</div><!-- /#promo-message-show -->
	
	<div id = "promo-message-hide" class = "promo message pointer hide"
		<?php if($omitPromoForm != true) { echo 'title = "Hide the promocode entry form"'; } else { echo 'title = "Scroll down for promocode entry form"'; } ?>
		onclick = "hideItem('promo-message-show', 'promo-message-hide', 'promocode-form-container')">
		<?php echo $promoMessage; if($omitPromoForm != true) { echo ' &#9650;'; } ?>
	</div><!-- /#promo-message-hide -->
	
	<div id = "promocode-form-container" class = "hide">
		<?php if($promoMessageClass != 'hide' and $omitPromoForm != true) { require 'php/promo-form.php'; } ?>
	</div><!-- /#promocode-form-container .hide -->
</div><!-- /#promo-message-container -->

<!-- FREE MODE INDICATOR (light blue bar) -->
<div id = "free-mode-message-container" class = "<?php echo $freeModeMessageClass;?>">
	<div id = "free-mode-message" class = "promo message">
		<div id = "free-mode-message-header"><?php echo $freeModeMessage;?></div>
		<div id = "free-mode-message-login"><a href = "redirect-login.php"><?php echo $freeModeMessageLogin;?></a></div>
	</div>
</div><!-- /#free-mode-message-container -->

<!-- NEW FEATURE MESSAGE (yellow bar) -->
<div id = "new-feature-message-container" class = "<?php echo $newFeatureClass;?>">
	<div id = "new-feature-message" class = "new-feature">
		<div id = "new-feature-header" class = "message">
			<div id = "new-feature-show" onclick = "showItem('new-feature-show', 'new-feature-hide', 'new-feature-body')" title = "See details">
				<?php echo $newFeatureHeader;?> &#9660;
			</div><!-- /#new-feature-show -->
			<div id = "new-feature-hide" class = "hide" onclick = "hideItem('new-feature-show', 'new-feature-hide', 'new-feature-body')" title = "Hide details">
				<?php echo $newFeatureHeader;?> &#9650;
			</div><!-- /#new-feature-hide .hide -->
		</div><!-- /#new-feature-header .message -->
		<div id = "new-feature-body" class = "hide"><div class = "paragraph left"><?php echo $newFeatureBody;?></div></div>
	</div><!-- #new-feature-message .new-feature -->
</div><!-- /#new-feature-message-container -->

<!-- HORIZONTAL NAV FOR CONTACT PAGES -->
<?php if($pageType == 'contact') 	{ require_once 'php/nav-contact.php'; }?>
<?php if($pageType == 'licenses')	{ require_once 'php/nav-license.php'; }?>
<?php if($pageType == 'subscribe')	{ require_once 'php/nav-subscribe.php'; }?>
<?php if($pageType == 'press')		{ require_once 'php/nav-press.php'; }?>
<?php if($pageType == 'awards')		{ require_once 'php/nav-awards.php'; }?>

<!-- ERROR MESSAGE (red text) -->
<div id = "error-message-container" class = "<?php echo $errorMessageClass;?>">
	<div id = "error-message" class = "error-message"><?php echo $errorMessage;?></div>
</div>

<!-- CUSTOM ERROR MESSAGE -->
<div id = "custom-error-message-container" class = "<?php echo $customErrorMessageClass;?>">
	<div id = "custom-error-message" class = "error-message"><?php echo $customErrorMessage;?></div>
</div>

<!-- RENEWAL MESSAGE -->
<div id = "renewal-message-container" class = "<?php echo $renewalMessageClass;?>">
	<div id = "renewal-message" class = "renewal-message">
		<?php if($expired == true) { require 'php/renewal-form.php'; } ?>
		<div class = "inline right-10">
			<button type = "button" onclick = "document.getElementById('renewal-form').submit();">Renew your CTREX subscription ($10 off)</button>
		</div>
		<div class = "inline right-10">|</div>
		<div class = "inline right-10">
			<button type = "button" onclick = "window.location.href='logout.php';">Hide</button>
		</div>
	</div><!-- /#renewal-message -->
</div><!-- /#renewal-message-container -->

<!-- CONFIRMATION MESSAGE -->
<div id = "confirmation-message-container" class = "<?php echo $confirmationMessageClass;?>">
	<div id = "confirmation-message" class = "confirmation-message"><?php echo $confirmationMessage;?></div>
</div>