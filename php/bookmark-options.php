<?php
/*
php/bookmark-options.php
By Matthew DiMatteo, Children's Technology Review

This file contains buttons for printing and exporting a user's bookmarked reviews
This file is included in 'php/profiles/subscriber/section-bookmarks.php' and 'php/content/content-savedbookmarks.php'
*/

// EXPORT TAB
echo '<div class = "inline left-5 right-5 export-btn">';
	//echo '<button type = "button" onclick = "window.location.href = \'export.php?type=bookmarks&format=tab\';">Export .tab</button>';
	echo '<img src = "images/export-tab.png" onclick = "window.location.href = \'export.php?type=bookmarks&format=tab\';"/>';
echo '</div>'; // /.inline left-5 right-5 export-btn

// EXPORT CSV
echo '<div class = "inline left-5 right-5 export-btn">';
	//echo '<button type = "button" onclick = "window.location.href = \'export.php?type=bookmarks&format=csv\';">Export .csv</button>';
	echo '<img src = "images/export-csv.png" onclick = "window.location.href = \'export.php?type=bookmarks&format=csv\';"/>';
echo '</div>'; // /.inline left-5 right-5 export-btn

// PRINT
echo '<div class = "inline left-5 right-5">';
	//echo '<button type = "button" onclick = "">Print list</button>';
	echo '<img src = "images/print32.png" onclick = "window.location.href = \'print.php?type=bookmarks\';"/>';
echo '</div>'; // /.inline left-5 right-5
?>