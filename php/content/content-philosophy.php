<?php 
/*
php/content/content-philosophy.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the Philosophy page
It is included dynamically in the file 'php/document.php'
Variable values are defined in 'php/settings.php'
*/

if($philosophyHeader != NULL) 		{ echo '<div class = "page-header">'.$philosophyHeader.'</div>'; }
if($philosophyText != NULL) 		{ echo '<div class = "paragraph left bottom-10" id = "philosophy">'.parseLinksOld($philosophyText).'</div>'; }
?>