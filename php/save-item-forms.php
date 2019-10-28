<!--
php/save-item-forms.php
By Matthew DiMatteo, Children's Technology Review

This file contains forms for adding or removing saved searches and bookmarks
It is included in the following files:
- 'php/search-options.php' (for performing actions from home page) 
- 'php/profiles/subscriber/section-searches.php' (for performing actions from subscriber profile)
By setting the 'save-search-redirect' input value to $thisURL, the user will always be returned to the page that triggered the form submission
-->

<!-- SAVE SEARCH, BOOKMARK, RUBRIC FORMS (HIDDEN) -->
<div class = "hide">

<!-- SEARCH -->
<form class = "hide" name = "save-search-form" id = "save-search-form" method = "POST" action = "savesearch.php">
	<input type = "hidden" name = "save-search-id" 			id = "save-search-id"/>
	<input type = "hidden" name = "save-search-url" 		id = "save-search-url"/>
	<input type = "hidden" name = "save-search-summary"  	id = "save-search-summary"/>
	<input type = "hidden" name = "save-search-type" 		id = "save-search-type"/>
	<input type = "hidden" name = "save-search-redirect" 	id = "save-search-redirect" value = "<?php echo $thisURL;?>"/>
</form>

<!-- BOOKMARK -->
<form class = "hide" name = "save-bookmark-form" id = "save-bookmark-form" method = "POST" action = "savebookmark.php">
	<input type = "hidden" name = "save-bookmark-id" 			id = "save-bookmark-id"/>
	<input type = "hidden" name = "save-bookmark-review-id" 	id = "save-bookmark-review-id"/>
	<input type = "hidden" name = "save-bookmark-type" 			id = "save-bookmark-type"/>
	<input type = "hidden" name = "save-bookmark-folder-id"		id = "save-bookmark-folder-id"/>
	<input type = "hidden" name = "save-bookmark-redirect" 		id = "save-bookmark-redirect" value = "<?php echo $thisURL;?>"/>
	<input type = "hidden" name = "save-bookmark-redirect-page" id = "save-bookmark-redirect-page" value = "<?php echo $thisPage;?>"/>
</form>

<!-- RUBRIC -->
<form class = "hide" name = "save-rubric-form" id = "save-rubric-form" method = "POST" action = "saverubric.php">
	<input type = "hidden" name = "save-rubric-id" 				id = "save-rubric-id"/>
	<input type = "hidden" name = "save-rubric-name" 			id = "save-rubric-name"/>
	<input type = "hidden" name = "save-rubric-description"		id = "save-rubric-description"/>
	<input type = "hidden" name = "save-rubric-qa-names" 		id = "save-rubric-qa-names"/>
	<input type = "hidden" name = "save-rubric-qa-fields" 		id = "save-rubric-qa-fields"/>
	<input type = "hidden" name = "save-rubric-type" 			id = "save-rubric-type"/>
	<input type = "hidden" name = "save-rubric-redirect" 		id = "save-rubric-redirect" value = "<?php echo $thisURL;?>"/>
</form>

<!-- FOLDER -->
<form class = "hide" name = "save-folder-form" id = "save-folder-form" method = "POST" action = "savebookmark.php">
	<input type = "hidden" name = "save-folder-id" 				id = "save-folder-id"/>
	<input type = "hidden" name = "save-folder-name" 			id = "save-folder-name"/>
	<input type = "hidden" name = "save-folder-type" 			id = "save-folder-type"/>
	<input type = "hidden" name = "save-folder-num-bookmarks" 	id = "save-folder-num-bookmarks"/>
	<input type = "hidden" name = "save-folder-redirect" 		id = "save-folder-redirect" value = "<?php echo $thisURL;?>"/>
	<input type = "hidden" name = "save-folder-redirect-page" id = "save-folder-redirect-page" value = "<?php echo $thisPage;?>"/>
</form>

</div><!-- /.hide -->