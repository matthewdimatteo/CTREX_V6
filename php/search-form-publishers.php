<!--
php/search-form-publishers.php
By Matthew DiMatteo, Children's Technology Review

This file contains the html form for performing searches of the publisher directory - it is included in 'php/document.php'
The CTREX interface contains separate inputs, such as text fields or dropdown menus, which the user interacts with to specify search criteria
Each of those inputs contains an event attribute to call a JavaScript function which maps input values to this form's hidden inputs
	The id values of these inputs are used for referencing the elements in those functions

The file 'php/find-publishers.php' processes this form input, referencing the input names, and assigning their values to variables
	The php variables remain in the form
-->
<form name = "search-publishers-form" 		id = "search-publishers-form" method = "GET" action = "publishers.php" class = "hide">
	<input type = "hidden" name = "search" 	id = "search-publishers-submit" 	value = "publishers" />
	<input type = "hidden" name = "keyword" id = "search-publishers-keyword" 	value = "<?php echo $searchPublishersKeyword;?>" />
	<input type = "hidden" name = "sort" 	id = "search-publishers-sort" 		value = "<?php echo $searchPublishersSort;?>" />
	<input type = "hidden" name = "order" 	id = "search-publishers-order" 		value = "<?php echo $searchPublishersOrder;?>" />
</form>