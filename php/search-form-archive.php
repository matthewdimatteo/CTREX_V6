<!--
php/search-form-archive.php
By Matthew DiMatteo, Children's Technology Review

This file contains the html form for performing searches of the archive - it is included in 'php/document.php'
The CTREX interface contains separate inputs, such as text fields or dropdown menus, which the user interacts with to specify search criteria
Each of those inputs contains an event attribute to call a JavaScript function which maps input values to this form's hidden inputs
	The id values of these inputs are used for referencing the elements in those functions

The file 'php/find-archive.php' processes this form input, referencing the input names, and assigning their values to variables
	The php variables remain in the form
-->
<form name = "search-archive-form" 			id = "search-archive-form" method = "GET" action = "archive.php" class = "hide">
	<input type = "hidden" name = "search" 	id = "search-archive-submit" 	value = "archive" />
	<input type = "hidden" name = "type" 	id = "search-archive-type" 		value = "<?php echo $searchArchiveType;?>" />
	<input type = "hidden" name = "keyword" id = "search-archive-keyword" 	value = "<?php echo $searchArchiveKeyword;?>" />
	<input type = "hidden" name = "sort" 	id = "search-archive-sort" 		value = "<?php echo $searchArchiveSort;?>" />
	<input type = "hidden" name = "order" 	id = "search-archive-order" 	value = "<?php echo $searchArchiveOrder;?>" />
	<input type = "hidden" name = "page" 	id = "search-archive-page" 		value = "<?php echo $searchArchivePage;?>" />
</form>