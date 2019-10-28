<!--
php/nav-output.php
By Matthew DiMatteo, Children's Technology Review

This file outputs a horizontal secondary navigation bar
It should be included in the file for any navigation after specifying an array $navItems with the values (link, label)

Depending on the number of nav items to display, this file determines the css class with the corresponding width before outputting each nav item
-->
<div id = "secondary-nav">
<?php
// determine the css class to use for each link based on the number of items
$numNavItems = count($navItems);
switch($numNavItems)
{
	case 1 	: $navItemClass = 'full-width nav-item'; 	break;
	case 2 	: $navItemClass = 'halves nav-item'; 		break;
	case 3 	: $navItemClass = 'thirds nav-item'; 		break;
	case 4 	: $navItemClass = 'quarters nav-item'; 		break;
	case 5 	: $navItemClass = 'fifths nav-item'; 		break;
	case 6 	: $navItemClass = 'sixths nav-item'; 		break;
	default : $navItemClass = 'nav-item';				break;
} // end switch($numNavItems)

// output the menu
foreach($navItems as $navItem)
{
	$link 	= $navItem[0];
	$label 	= $navItem[1];
	$httpCount = substr_count($link, 'http://');
	$httpsCount = substr_count($link, 'https://');
	if($httpCount > 0 or $httpsCount > 0) { $newTab = true; }
	if($thisPage == $link) { $thisNavItemClass = $navItemClass.'-active'; } else { $thisNavItemClass = $navItemClass; }
	//echo '<a href = "'.$link.'"><div class = "inline">'.$label.'</div></a>';
	echo '<a href = "'.$link.'"';  if($newTab == true) { echo 'target = "_blank"'; } echo '><div class = "'.$thisNavItemClass.'">'.$label.'</div></a>';
}
?>
</div><!-- /#secondary-nav -->