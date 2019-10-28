<?php
$t = -1;
$tiers = array();

$tier00 = '1'; 			$tier00max = 1; 	$tier00pro = 60.00;	$tier00basic = 20.00;
$tier00array = array($tier00, $tier00pro, $tier00basic); $t += 1; $tiers[$t] = $tier00array;

$tier01 = '2-9'; 		$tier01max = 9; 	$tier01pro = 57.00;	$tier01basic = 18.00; 	
$tier01array = array($tier01, $tier01pro, $tier01basic); $t += 1; $tiers[$t] = $tier01array;

$tier02 = '10-24';		$tier02max = 24;	$tier02pro = 54.00;	$tier02basic = 16.00; 	
$tier02array = array($tier02, $tier02pro, $tier02basic); $t += 1; $tiers[$t] = $tier02array;

$tier03 = '25-49';		$tier03max = 49;	$tier03pro = 51.00;	$tier03basic = 14.00; 	
$tier03array = array($tier03, $tier03pro, $tier03basic); $t += 1; $tiers[$t] = $tier03array;

$tier04 = '50-99';		$tier04max = 99;	$tier04pro = 48.00;	$tier04basic = 12.00; 	
$tier04array = array($tier04, $tier04pro, $tier04basic); $t += 1; $tiers[$t] = $tier04array;

$tier05 = '100-149';	$tier05max = 149;	$tier05pro = 45.00;	$tier05basic = 10.00; 	
$tier05array = array($tier05, $tier05pro, $tier05basic); $t += 1; $tiers[$t] = $tier05array;

$tier06 = '150-199';	$tier06max = 199;	$tier06pro = 42.00;	$tier06basic = 8.00; 	
$tier06array = array($tier06, $tier06pro, $tier06basic); $t += 1; $tiers[$t] = $tier06array;

$tier07 = '200-999*';	$tier07max = 999;	$tier07pro = 39.00;	$tier07basic = 7.00; 	
$tier07array = array($tier07, $tier07pro, $tier07basic); $t += 1; $tiers[$t] = $tier07array;

$maxSize = $tier07max + 1;

?>