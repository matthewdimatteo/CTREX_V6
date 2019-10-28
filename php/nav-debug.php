<?php
$debugNavItems = array
(
	'phpinfo.php',
	'debug.php',
	'index.php',
	'home.php',
	'login.php'
);
?>
<nav id = "debug-nav">
<?php
foreach($debugNavItems as $navitem)
{
	$link 			= $navitem;
	$label 			= str_replace('.php', '', $link);
	$navItemClass 	= 'nav-item'; if($thisPage == $link) { $navItemClass .= '-active'; }
	echo '<a href = "'.$link.'"><div class = "'.$navItemClass.'">'.$label.'</div></a>';
}
?>
</nav><!-- /.nav-horizontal -->