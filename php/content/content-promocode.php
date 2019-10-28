<?php
/*
php/content/content-promocode.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the promo code entry page 'promocode.php'

$promocodeFormInstances is defined in 'php/promo-form.php'
Typically, the file is included in 'php/messages.php' to display to guests in the header
However, certain pages, including this one, omit that inclusion to include the form in the page body instead
Duplicate inclusions of the form would cause id element errors when submitting the form using the enter key
*/

if($promocodeFormInstances < 1) { echo '<br/>'; require 'php/promo-form.php'; }
?>