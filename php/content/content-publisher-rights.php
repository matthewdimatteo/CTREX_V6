<?php
/*
php/content/content-publisher-rights.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the Publishers Bill of Rights page 'publisher-rights.php'
It is included dynamically via the file 'php/document.php'

The variable values for this page are defined in 'php/settings.php', which queries the 'dashboard' table in the database 'CSR.fmp12'
*/

// PAGE HEADER
echo '<div class = "page-header">'.$publisherRightsHeader.'</div>';

// PAGE BODY
echo '<div class = "paragraph left">';
	
	// INTRO/DESCRIPTION
	if($publisherRightsIntro != NULL) { echo '<p>'.$publisherRightsIntro.'</p>'; }
	
	if($publisherRightsArray != NULL)
	{
		echo '<p>';
		echo 'THE PUBLISHER<br/>';
		echo '<ol>';
		foreach($publisherRightsArray as $thisRight) { if($thisRight != NULL) { echo '<li>'.$thisRight.'</li>'; } }
		echo '</ol>';
		echo '</p>';
	} // end if $publisherRightsList
	
	if($reviewerRightsArray != NULL)
	{
		echo '<p>';
		echo 'THE REVIEWER<br/>';
		echo '<ol>';
		foreach($reviewerRightsArray as $thisRight) { if($thisRight != NULL) { echo '<li>'.$thisRight.'</li>'; } }
		echo '</ol>';
		echo '</p>';
	} // end if $reviewerRightsList
	
echo '</div>'; // /.paragraph left
?>