<?php
/*
php/content/content-renew.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the renewal page
*/

// gate out improper access - only subscribers can access discounted item
if($subscriber != true and $expired != true)
{
	$redirect = 'login.php?target=renew&redirect=renew.php'; // set the redirect link with params to return to this page on login
	require_once 'php/redirect.php';
	exit();
}
require 'php/renewal-form.php'; // contains the hidden html form for loading authorize.net secure transaction portal
?>

<!-- PAGE CONTAINER -->
<div id = "renew-page-container" class = "paragraph-90 center">
	<div class = "page-header">Renew Your CTREX Subscription</div>
	<?php
	if($subscriber == true) 
	{ 
		$subheaderClass = 'subheader';
		$btnLabel = 'Add 1 Year to your CTREX Subscription ($50)';
	}
	else 
	{ 
		$subheaderClass = 'hide'; 
		$btnLabel = 'Renew your CTREX Subscription ($50)';
	}
	?>
	<div class = "<?php echo $subheaderClass;?>">
		<a href = "<?php echo $profileURL;?>"><?php echo $username;?></a>, thank you for supporting CTREX.<br/>
		As a subscriber, you can add 1 year to your CTREX subscription at a discounted rate.
	</div><!-- /.subheader -->
	<div>
		<button type = "button" onclick = "document.getElementById('renewal-form').submit();"><?php echo $btnLabel;?></button>
		<div class = "text-14 top-10"><em>(Normally $60)</em></div>
	</div>
</div><!-- /.#renew-page-container .paragraph-90 center -->