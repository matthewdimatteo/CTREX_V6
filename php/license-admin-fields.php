<?php
$b = $a + 1;
echo '<div id = "admin-'.$b.'-row">';

	// EMAIL
	echo '<div class = "inline width-30 right-20">';	
		echo '<div class = "text-14">Email Address:</div>';
		echo '<div><input type = "email" name = "admin-'.$b.'-email" id = "admin-'.$b.'-email" value = "'.$adminEmail.'"/></div>';
	echo '</div>';

	// FIRST NAME
	echo '<div class = "inline sixths right-20">';
		echo '<div class = "text-14">First Name:</div>';
		echo '<div><input type = "text" name = "admin-'.$b.'-fname" id = "admin-'.$b.'-fname"  value = "'.$adminFname.'"/></div>';
	echo '</div>';

	// LAST NAME
	echo '<div class = "inline sixths right-20">';
		echo '<div class = "text-14">Last Name:</div>';
		echo '<div><input type = "text" name = "admin-'.$b.'-lname" id = "admin-'.$b.'-lname" value = "'.$adminLname.'"/></div>';
	echo '</div>';

	// JOB TITLE
	echo '<div class = "inline width-30 right-20">';	
		echo '<div class = "text-14">Job Title:</div>';
		echo '<div><input type = "text" name = "admin-'.$b.'-title" id = "admin-'.$b.'-title" value = "'.$adminTitle.'"/></div>';
	echo '</div>';
echo '</div>';
?>