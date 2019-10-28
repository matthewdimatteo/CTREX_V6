<?php 
/*
php/result-item-rating.php
By Matthew DiMatteo, Children's Technology Review

This file determines whether the a product is rated and whether the velvet rope is up and accordingly displays the rating or a login button
It is included in the files 'php/result-item.php' and 'php/result-item-grid.php'
*/
if($rated == true) // $rated is a boolean defined in 'php/get-review.php' to determine if there is a rating value
{
	echo '<div class = "rating-line">';

		// VELVET ROPE - LOGIN FOR RATING
		if($velvetRope == true) 
		{ 
			echo '<button type = "button" onclick = "openURL(\''.$velvetRopeLink.'\')">';
				echo 'Log in as a subscriber to see the rating';
			echo '</button>'; 
		}

		// CTR RATING & STAR GRAPHIC
		else { require 'php/rating.php'; } // end else not $velvetRope

	echo '</div>'; // /.result-item-info
} // end if $rated
?>