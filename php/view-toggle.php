<?php
/*
php/view-toggle.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the buttons for a list/grid view toggle, calculating element ids based on the page
It is included in:
	- the home page ('php/search-reviews.php')
	- the publisher directory ('php/content/content-publishers.php')
	- the experts page ('php/content/content-experts.php')

The function showGrid(type) is defined in 'js/scripts.js'
- It uses the string argument 'type' to determine which sessionStorage item to save the last mode to
- In this way, the last view mode is local to each page, and switching modes on one page won't affect the mode on others
*/

// determine the 'type' argument
switch($thisPage)
{
	case 'home.php'			:	$viewLabel = 'reviews'; 	break;
	case 'publishers.php'	:	$viewLabel = 'publishers'; 	break;
	case 'archive.php'		:	$viewLabel = 'archive'; 	break;
	case 'experts.php'		:	$viewLabel = 'experts'; 	break;
} // end switch
?>
<!-- VIEW TOGGLE -->
<div class = "full-width center" id = "view-toggle">

	<!-- LIST -->
	<div class = "search-options-item">

		<!-- LABEL -->
		<div id = "list-label" class = "block" title = "Viewing results as a list">
			<img src = "images/view-list-dark.png"/>
		</div>

		<!-- BTN -->
		<div id = "list-btn" class = "hide pointer" title = "View results as a list">
			<img src = "images/view-list-gray.png" onclick = "showList('<?php echo $viewLabel;?>')"/>
		</div>

	</div><!-- /.search-options-item -->

	<!-- GRID -->
	<div class = "search-options-item">

		<!-- BTN -->
		<div id = "grid-btn" class = "block pointer" title = "View results as a grid">
			<img src = "images/view-grid-gray.png" onclick = "showGrid('<?php echo $viewLabel;?>')"/>
		</div>

		<!-- LABEL -->
		<div id = "grid-label" class = "hide" title = "Viewing results as a grid">
			<img src = "images/view-grid-dark.png"/>
		</div>

	</div><!-- /.search-options-item -->

</div><!-- /#view-toggle -->