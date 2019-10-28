<!--
php/pagenav.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the page navigation buttons and feedback string
Each button press triggers the JavaScript function pageNav() defined in the file 'js/scripts.js'
The url values for each button are defined in the file 'php/pagenav-calc.php', which is included at the end of the 'find' file for each search page
The $pagenav string is calculated in the file 'php/results-summary.php', which is also included near the end of the 'find' file (such as 'php/find-reviews.php')

This file may be included at the top and/or bottom of the .search-area <div> element for the search page's 'content' file (such as 'php/content-home.php')
-->
<?php 
// hide the pagenav when sorting by relevance, since it does not output using pagination
if($searchReviewsSort == 'rel') { $pageNavClass = 'hide'; } else { $pageNavClass = 'block'; }
?>
<div class = "<?php echo $pageNavClass;?>">
	<div class = "pagenav-col">
		<button type = "button" onclick = "openURL('<?php echo $thisPageFirst;?>')" <?php if($searchPage < 2) { echo 'class = "hide"'; }?> >First</button>
	</div>
	<div class = "pagenav-col">
		<button type = "button" onclick = "openURL('<?php echo $thisPagePrev;?>')" <?php if($searchPage < 2) { echo 'class = "hide"'; }?> >Prev</button>
	</div>

	<div class = "pagenav-col" id = "pagenav-string"><?php echo $pagenav;?></div>
	<div class = "pagenav-col">
		<button type = "button" onclick = "openURL('<?php echo $thisPageNext;?>')" <?php if($searchPage >= $numPages){echo 'class="hide"';}?>>Next</button>
	</div>
	<div class = "pagenav-col">
		<button type = "button" onclick = "openURL('<?php echo $thisPageLast;?>')" <?php if($searchPage >= $numPages){echo 'class="hide"';}?>>Last</button>
	</div>
</div><!-- /.$pageNavClass -->