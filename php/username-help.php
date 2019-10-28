<?php
/*
php/username-help.php
By Matthew DiMatteo, Children's Technology Review

This file displays a toggleable username help section
It is included in the login page via 'php/login-form.php' and password recovery page via 'php/content/content-password.php'
The functions showItem() and hideItem() are defined in 'js/scripts.js' and are used to perform the toggle
- The parameters specified are the ids of the show button, hide button, and content
*/

// SHOW USERNAME HELP
echo '<div class = "bold" id = "show-username-help" title = "Try using the email address associated with your CTR Subscription. You can also email us at info@childrenstech.com or call us at 908-284-0404">';
	echo '<button type = "button" onclick = "showItem(\'show-username-help\', \'hide-username-help\', \'username-help\')">';
		echo 'Don\'t know your username?';
	echo '</button>';
echo '</div>'; // /#show-username-help

// HIDE USERNAME HELP
echo '<div class = "hide bold" id = "hide-username-help" title = "Hide this">';
	echo '<button type = "button" onclick = "hideItem(\'show-username-help\', \'hide-username-help\', \'username-help\')">';
		echo 'Don\'t know your username?';
	echo '</button>';
echo '</div>'; // /#hide-username-help

// USERNAME HELP
echo '<div class = "hide" id = "username-help">';
	echo 'Try using the email address associated with your CTR Subscription.<br/>';
	echo 'You can also contact us using <a href = "contact.php">this form</a>, email us at <a href = "mailto:nfo@childrenstech.com">info@childrenstech.com</a>, or call us at 908-284-0404.<br/><br/>';
echo '</div>'; // /#username-help
?>