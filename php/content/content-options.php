<!--
php/content/content-options.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the more options page 'options.php'
It utilizes the same menu options as the main menu ('php/menu.php') which defines the $allMenuItems array
-->
<div id = "options-page-container">
<div class= "page-header">More Options</div>
<?php
foreach($allMenuItems as $menuItem)
{
	$itemLink 	= $menuItem[0];
	$itemLabel 	= $menuItem[1];
	echo '<a href = "'.$itemLink.'"><div class = "menu-line">'.$itemLabel.'</div></a>';
}
?>
</div><!-- /#options-page-container -->