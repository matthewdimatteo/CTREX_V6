<?php
/*
php/rating-stars.php
By Matthew DiMatteo, Children's Technology Review

This file outputs a 5-Star graphic dynamically reflecting the rating of a review
It is included in the file 'php/rating.php'
*/

$starFloat = $score/20;
$starInts = floor($starFloat);
$starPiece = round(10 * ($starFloat - $starInts));
$emptyInts = 5 - $starInts;
if($starPiece != 0) { $emptyInts -= 1; }
for($s = 0; $s < $starInts; $s++) { echo '<img src = "images/star-5.png" >'; }
if($starPiece == 1) { echo '<img src = "images/star-1.png" >'; }
if($starPiece == 2) { echo '<img src = "images/star-1.png" >'; }
if($starPiece == 3) { echo '<img src = "images/star-2.png" >'; }
if($starPiece == 4) { echo '<img src = "images/star-2.png" >'; }
if($starPiece == 5) { echo '<img src = "images/star-3.png" >'; }
if($starPiece == 6) { echo '<img src = "images/star-3.png" >'; }
if($starPiece == 7) { echo '<img src = "images/star-4.png" >'; }
if($starPiece == 8) { echo '<img src = "images/star-4.png" >'; }
if($starPiece == 9) { echo '<img src = "images/star-4.png" >'; }
for($e = 0; $e < $emptyInts; $e++) { echo '<img src = "images/star-0.png" >'; }
?>