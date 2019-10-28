<?php
/*
php/disclaimer-text.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the disclaimer text, accessed in 'php/settings.php'
It is included on the disclaimer page via 'php/content-content-disclaimer.php' and the about page via 'php/content-content-about.php'
*/

if($disclaimerText != NULL)
{ 
	echo '<div class = "page-header">Disclaimer and Copyright</div>';
	echo '<div class = "paragraph left bottom-10">';
		echo parseLinks($disclaimerText); // $disclaimerText determined in 'php/settings.php'
	echo '</div>'; // /.paragraph left bottom-10
} 
?>