<?php
$submissionData = $_SESSION[$sessionItem];
foreach($submissionData as $data)
{
	$label		= $data[0];
	$varName 	= $data[1];
	$varValue 	= $data[2];
	$$varName 	= $varValue;
	echo '<div class = "row">';
		echo '<div class = "field-label">'.$label.': </div>';
		echo '<div class = "field-container">'.$varValue.'</div>';
	echo '</div>';
}
?>