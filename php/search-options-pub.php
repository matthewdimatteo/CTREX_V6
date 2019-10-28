<!--
php/search-options-pub.php
By Matthew DiMatteo, Children's Technology Review

This file contains the html for the publisher directory search options, such as sorting results - it is included in 'php/content-publishers.php'
-->

<!-- SORT -->
<div class = "search-options" id = "sort-options">

	<!-- RESET -->
	<div class = "search-options-item">
		<img src = "images/reset.png" class = "icon-24 pointer" class = "pointer" onclick = "clearSearch('<?php echo $thisPage;?>')"/>
	</div>
	
	<!-- NEW -->
	<div class = "search-options-item">
		<button type = "button" onclick = "sortPublishers('new', 'desc')" 
			<?php if(($searchPublishersSort == 'new' and $searchPublishersOrder == 'desc') or $searchPublishersSort == NULL) { echo 'class = "btn-inv" '; }?>>New</button>
	</div>
	
	<!-- OLD -->
	<div class = "search-options-item">
		<button type = "button" onclick = "sortPublishers('new', 'asc')"
			<?php if($searchPublishersSort == 'new' and $searchPublishersOrder == 'asc') { echo 'class = "btn-inv" '; } ?>>Old</button>
	</div>
	
	<!-- RATING -->
	<div class = "search-options-item">
		<button type = "button" onclick = "sortPublishers('titles', 'desc')"
			<?php if($searchPublishersSort == 'titles' and $searchPublishersOrder == 'desc') { echo 'class = "btn-inv" '; } ?>># Titles</button>
	</div>
	
	<!-- ABC -->
	<div class = "search-options-item">
		<button type = "button" onclick = "sortPublishers('abc', 'asc')"
			<?php if($searchPublishersSort == 'abc' and $searchPublishersOrder == 'asc') { echo 'class = "btn-inv" '; } ?>>ABC</button>
	</div>
	
	<!-- ZYX -->
	<div class = "search-options-item">
		<button type = "button" onclick = "sortPublishers('abc', 'desc')"
			<?php if($searchPublishersSort == 'abc' and $searchPublishersOrder == 'desc') { echo 'class = "btn-inv" '; } ?>>ZYX</button>
	</div>
	
</div><!-- /.search-options #sort-options -->