<?php
/*
php/menu.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the main menu and profile menu
It is included in the file 'php/header.php'

The menu item array are defined in 'php/header-format.php'
*/
?>

<!-- OUTPUT MAIN MENU -->
<div id = "menu-container">
    <div id = "menu">
    	<?php
		$menuN = -1;
		foreach($allMenuItems as $menuItem)
		{
			$menuN += 1;
			$itemLink 	= $menuItem[0];
			$itemLabel 	= $menuItem[1];
			echo '<a href = "'.$itemLink.'" id = "menu-item-'.$menuN.'"><div class = "menu-line">'.$itemLabel.'</div></a>';
		}
		?>
    </div><!-- menu -->
</div><!-- /#menu-container -->

<!-- OUTPUT PROFILE MENU -->
<div id = "profile-menu-container">
	<div id = "profile-menu">
	<?php
	foreach($profileMenuItems as $profileMenuItem)
	{
		$profileMenuItemLink 	= $profileMenuItem[0];
		$profileMenuItemLabel 	= $profileMenuItem[1];
		echo '<a href = "'.$profileMenuItemLink.'"><div class = "menu-line">'.$profileMenuItemLabel.'</div></a>';
	}
	?>
	</div><!-- /#profile-menu -->
</div><!-- /#profile-menu-container -->