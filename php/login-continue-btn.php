<?php
/*
php/login-continue-btn.php
By Matthew DiMatteo, Children's Technology Review

This file displays a 'Log in to continue' button at the end of a search results feed
It is included in 'php/search-reviews.php' and 'php/content/content-publishers.php'

The button is only displayed if the user is not logged in with access to full search features (if $velvetRope is true)
When clicked, the user is navigated to the login page with a redirect url value calculated to return them to the original page after logging in
*/
// LOG IN TO CONTINUE
if($velvetRope == true) 
{ 
	$loginRedirect = 'login.php?target=more-'.$searchType.'&redirect='.urlencode($thisURL);
	echo '<div class = "row-top-margin center ">';
		echo '<button type = "button" onclick = "openURL(\''.$loginRedirect.'\')" title = "Log in as a subscriber for unlimited searching, with '.$subscriberResultSize.' results per page'.'">Log in as a subscriber to continue</button>'; 
	echo '</div>'; // /.row-top-margin center
}
?>