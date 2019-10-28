<?php
/*
php/get-confirmation-number.php
By Matthew DiMatteo, Children's Technology Review

This file gets the stored $_SESSION item value for a form submission confirmation number
It should be included in the content file for any form page that generates a confirmation (such as Submit Products or Site License Order)
*/
$confirmationNumber = $_SESSION[$confirmationType.'-confirmation-number']; 
if($confirmationNumber != NULL) { echo '<div class = "text-24 confirmation-message">Confirmation #'.$confirmationNumber.'</div>'; }
?>