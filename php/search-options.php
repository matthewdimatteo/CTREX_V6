<!--
php/search-options.php
By Matthew DiMatteo, Children's Technology Review

This file contains the html for the search options, such as sorting and filtering results - it is included in 'php/search-reviews.php'
-->

<!-- SORT -->
<div class = "search-options" id = "sort-options">

	<!-- RESET -->
	<div class = "search-options-item">
		<img src = "images/reset.png" class = "icon-24 pointer" class = "pointer" onclick = "clearSearch('<?php echo $thisPage;?>')" title = "Reset your search"/>
	</div>

	<?php 
	// RELEVANCE CONDITIONAL DISPLAY, HOVER TEXT
	$relevanceBtnTitle = 'Try our new search algorithm to sort your results by most relevant based on your keyword(s). Please note, this option may take more time to process, and may not include older product entries.';
	$relevanceBtnTitle = $relSortBtnHover; // data-driven value defined in 'php/settings.php'
	if($searchTermsArray != NULL) 							{ $sortRelClass = 'search-options-item'; } 				else { $sortRelClass = 'hide'; }
	if($searchReviewsSort == 'rel' and $velvetRope != true) { $relevanceMaxResultsClass = 'search-options-item'; } 	else { $relevanceMaxResultsClass = 'hide'; }
	if($thisPage == 'print.php') { $relevanceMaxResultsClass = 'hide'; }
	$relevanceMaxResultsTitle = 'Sorting results by most relevant uses an algorithm that is more taxing on our database and slower to process. As such, only the latest '.$maxSize.' records in our database can be ranked by their relevance. By default, the '.$resultSize.' most relevant results are displayed on the page. Use this setting to increase that number if necessary (though this may slightly increase load times). Sorting by any other criteria is easier for the database to handle and will return all results found, displaying ' .$resultSize.' per page. Do you like this feature? Have any suggestions or requests? We want to hear your feedback! Let us know at info@childrenstech.com.';
	$relevanceMaxResultsTitle = $relSortDropdownHover; // data-driven value defined in 'php/settings.php'
	?>

	<!-- RELEVANCE -->
	<div class = "<?php echo $sortRelClass;?>" title = "<?php echo $relevanceBtnTitle;?>">
		<button type = "button" onclick = "sortReviews('rel', 'desc')" 
			<?php if($searchReviewsSort == 'rel' and $searchReviewsOrder == 'desc') { echo 'class = "btn-inv" '; } ?>>Relevance</button>
	</div><!-- /.$sortRelClass -->

	<!-- DROPDOWN FOR MAX # RESULTS -->
	<div id = "relevance-max-results" class = "<?php echo $relevanceMaxResultsClass;?>" title = "<?php echo $relevanceMaxResultsTitle;?>">
		<select name = "num-results" id = "select-num-results" onchange = "setNumResults()">
			<?php
			// if going from one set to another where the 2nd set size is smaller than the #displayed of the 1st set, cap #results to max for new set
			if($foundcount < $searchReviewsNumResults) { $searchReviewsNumResults = ceil($foundcount/$resultSize) * $resultSize; }

			// determine the options based on the #results per page and the foundset size
			$firstOption 	= $resultSize;
			$lastOption 	= $maxSize;
			if($foundcount < $maxSize) { $lastOption = ceil($foundcount/$resultSize) * $resultSize; }
			$step			= $resultSize;
			$numResultsOptions = array();
			for($nro = $firstOption; $nro <= $lastOption; $nro += $step) { array_push($numResultsOptions, $nro); }
			foreach($numResultsOptions as $numResultsOption)
			{
				echo '<option value = "'.$numResultsOption.'"'; 
					if($numResultsOption == $searchReviewsNumResults) { echo ' selected '; }
				echo '>Show '.$numResultsOption.' results</option>';
			}
			?>
		</select>
	</div><!-- /.$relevanceMaxResultsClass -->
	
	<!-- NEW -->
	<div class = "search-options-item">
		<button type = "button" onclick = "sortReviews('new', 'desc')" title = "Show most recent entries first" 
			<?php if(($searchReviewsSort == 'new' and $searchReviewsOrder == 'desc') or $searchReviewsSort == NULL) { echo 'class = "btn-inv" '; }?>>New</button>
	</div>
	
	<!-- OLD -->
	<div class = "search-options-item">
		<button type = "button" onclick = "sortReviews('new', 'asc')" title = "Show oldest entries first" 
			<?php if($searchReviewsSort == 'new' and $searchReviewsOrder == 'asc') { echo 'class = "btn-inv" '; } ?>>Old</button>
	</div>
	
	<!-- RATING -->
	<div class = "search-options-item">
		<button type = "button" onclick = "sortReviews('best', 'desc')" title = "Show highest rated products first" 
			<?php if($searchReviewsSort == 'best' and $searchReviewsOrder == 'desc') { echo 'class = "btn-inv" '; } ?>>Rating</button>
	</div>
	
	<!-- ABC -->
	<div class = "search-options-item">
		<button type = "button" onclick = "sortReviews('abc', 'asc')" title = "Sort results alphabetically by title" 
			<?php if($searchReviewsSort == 'abc' and $searchReviewsOrder == 'asc') { echo 'class = "btn-inv" '; } ?>>ABC</button>
	</div>
	
	<!-- ZYX -->
	<div class = "search-options-item">
		<button type = "button" onclick = "sortReviews('abc', 'desc')" title = "Sort results reverse alphabetically by title" 
			<?php if($searchReviewsSort == 'abc' and $searchReviewsOrder == 'desc') { echo 'class = "btn-inv" '; } ?>>ZYX</button>
	</div>
	
	<!-- FILTERS -->
	<div class = "search-options-item">
		<button type = "button" id = "show-filters-btn" title = "Filter your search by several criteria" 
			onclick = "showItem('show-filters-btn', 'hide-filters-btn', 'search-filters')" >Filters</button>
		<button type = "button" id = "hide-filters-btn" class = "btn-inv"
			onclick = "hideItem('show-filters-btn', 'hide-filters-btn', 'search-filters')">Filters</button>
	</div>
	
	<!-- MORE -->
	<div class = "search-options-item">
		<button type = "button" id = "show-more-btn" title = "Save a search, generate an RSS feed, print or export search results" 
			onclick = "showItem('show-more-btn', 'hide-more-btn', 'search-more')" >More</button>
		<button type = "button" id = "hide-more-btn" class = "btn-inv"
			onclick = "hideItem('show-more-btn', 'hide-more-btn', 'search-more')">More</button>
	</div>
	
	<!-- PRINT -->
	<?php if($thisPage == 'print.php') { $printBtnClass = 'search-options-item pointer'; } else { $printBtnClass = 'hide'; }?>
	<div class = "<?php echo $printBtnClass;?>">
		<img src = "images/print32.png" onclick = "window.print();" title = "Print this page" />
	</div>
	
</div><!-- /.search-options-debug #debug-sort -->

<!-- SEARCH FILTERS -->
<?php
$filterOptions = array
(
	array('current', 'Current'),
	array('awards', 'Editor\'s Choice'),
	array('rated', 'Rated'),
	array('rubrics', 'Rubrics'),
	array('free', 'Free'),
	array('feature', 'Feature Reviews'),
	array('newrelease', 'New Releases'),
	array('videos', 'Videos'),
	array('images', 'Images'),
	array('comments', 'Comments')
);
// allow moderators and experts to view drafts
if($mod == true or $expert == true) 
{ 
	array_push($filterOptions, array('drafts'		, 'Include Drafts')); 
	array_push($filterOptions, array('drafts-only'	, 'Drafts Only')); 
} // end if $mod == true or $expert == true
echo '<div class = "search-options" id = "search-filters">';
foreach($filterOptions as $filterOption)
{
	$filterValue = $filterOption[0];
	$filterLabel = $filterOption[1];
	$filterVarName = 'filter'.ucfirst($filterValue);
	echo '<div class = "search-filter-checkbox">';
		echo '<input type = "checkbox" name = "filter" id = "'.$filterValue.'" value = "'.$filterValue.'" onchange = "addFilter(\''.$filterValue.'\')" ';
			if($$filterVarName == true) { echo 'checked'; } echo ' />';
	echo '</div>';
	echo '<div class = "search-filter-label">';
		echo $filterLabel;
	echo '</div>';
} // end foreach $filterOptions
	echo '<div class = "search-options-item">';
		echo '<button type = "button" onclick = "searchReviews()">Apply</button>';
	echo '</div>';
echo '</div><!-- /.search-options #search-filters -->';

// set hover text and functions for more options buttons based on login status

// HOVER TEXT
$velvetPrefix		= 'Log in as a subscriber to ';
$savesearchHover 	= 'Save this search to your CTREX Profile';
$rssHover			= 'Generate an RSS Feed for this search - PLEASE NOTE: To properly view an RSS feed, your web browser must have an RSS reader installed.';
$printHover			= 'View your results as a print-friendly list';
$exportTABHover		= 'Export this search in .tab format';
$exportCSVHover		= 'Export this search in .csv format';

// URLS
if($thisQuery != NULL)
{
	$rssLink 			= 'rss.php?'.$thisQuery;
	$printLink 			= 'print.php?'.$thisQuery.'&type=reviews';
	$exportTABLink		= 'export.php?'.$thisQuery.'&type=reviews&format=tab';
	$exportCSVLink		= 'export.php?'.$thisQuery.'&type=reviews&format=csv';
}
else
{
	$rssLink 			= 'rss.php';
	$printLink 			= 'print.php?type=reviews';
	$exportTABLink		= 'export.php?type=reviews&format=tab';
	$exportCSVLink		= 'export.php?type=reviews&format=csv';
}

// BTN FUNCTIONS FOR SUBSCRIBERS
$savesearchFunction = 'savedSearchAdd(\''.$thisURL.'\', \''.$savesearchSummary.'\')';
$rssFunction		= 'openBlank(\''.$rssLink.'\')';
$printFunction		= 'openURL(\''.$printLink.'\')';
$exportTABFunction	= 'openBlank(\''.$exportTABLink.'\')';
$exportCSVFunction	= 'openBlank(\''.$exportCSVLink.'\')';

// PRINT PAGE OVERRIDE
if($thisPage == 'print.php')
{
	$printHover = 'Print this page';
	$printFunction = 'window.print();';
}

// VELVET ROPE OVERRIDES
if($subscriber != true) 
{ 
	$savesearchHover 	= $velvetPrefix.lcfirst($savesearchHover);
	$savesearchLink		= 'login.php?target=savesearch&redirect='.urlencode($thisURL);
	$savesearchFunction	= 'velvetRope(\''.$savesearchHover.'\', \''.$savesearchLink.'\')';
}
if($velvetRope == true)
{
	$rssHover			= $velvetPrefix.lcfirst($rssHover);
	$rssLink			= 'login.php?target=rss&redirect='.urlencode($rssLink);
	$rssLink			= 'login.php?target=rss';
	$rssFunction		= 'velvetRope(\''.$rssHover.'\', \''.$rssLink.'\')';
	
	$printHover			= $velvetPrefix.lcfirst($printHover);
	$printLink			= 'login.php?target=print&redirect='.urlencode($printLink);
	$printFunction		= 'velvetRope(\''.$printHover.'\', \''.$printLink.'\')';
	
	$exportTABHover		= $velvetPrefix.lcfirst($exportTABHover);
	$exportTABLink		= 'login.php?target=export-tab&redirect='.urlencode($exportTABLink);
	$exportTABLink		= 'login.php?target=export-tab';
	$exportTABFunction	= 'velvetRope(\''.$exportTABHover.'\', \''.$exportTABLink.'\')';
	
	$exportCSVHover		= $velvetPrefix.lcfirst($exportCSVHover);
	$exportCSVLink		= 'login.php?target=export-csv&redirect='.urlencode($exportCSVLink);
	$exportCSVLink		= 'login.php?target=export-csv';
	$exportCSVFunction	= 'velvetRope(\''.$exportCSVHover.'\', \''.$exportCSVLink.'\')';
}
?>

<!-- MORE -->
<div class = "search-options" id = "search-more">
	
	<!-- BUTTONS -->
	<div class = "block" id = "search-more-btns">
		<div class = "search-options-item pointer">
			<img src = "images/save.png" 		title = "<?php echo $savesearchHover;?>" 	onclick = "<?php echo $savesearchFunction;?>"/>
		</div>
		<div class = "search-options-item pointer">
			<img src = "images/rss.png" 		title = "<?php echo $rssHover;?>" 			onclick = "<?php echo $rssFunction;?>"/>
		</div>
		<div class = "search-options-item pointer">
			<img src = "images/print32.png" 	title = "<?php echo $printHover;?>" 		onclick = "<?php echo $printFunction;?>"/>
		</div>
		<div class = "search-options-item pointer">
			<img src = "images/export-tab.png" 	title = "<?php echo $exportTABHover;?>" 	onclick = "<?php echo $exportTABFunction;?>"/>
		</div>
		<div class = "search-options-item pointer">
			<img src = "images/export-csv.png" 	title = "<?php echo $exportCSVHover;?>" 	onclick = "<?php echo $exportCSVFunction;?>"/>
		</div>
		
		<?php
		// LIST SIZE OPTION
		
		// display the "More" container if list size has been set
		if($searchReviewsListSize != NULL) { echo '<script>showItem(\'show-more-btn\', \'hide-more-btn\', \'search-more\');</script>'; }
		
		// hover text for the option area
		$listSizeHover = 'Select a value between 1 and 100 to control the number of results displayed per page.';
		if($defaultResultSize != NULL)
		{ 
			$listSizeHover .= ' The default is '.$defaultResultSize.'.'; // $defaultResultSize defined in 'php/find-reviews.php'
			$resetBtnHover = 'Reset to default of '.$defaultResultSize.' results per page';
		} 
		else { $resetBtnHover = 'Reset to default number of results per page'; }
		
		// hide option from guests, hide apply btn if no value set
		if($velvetRope == true or $searchReviewsSort == 'rel') 	{ $listSizeClass = 'hide'; } 	else { $listSizeClass = 'search-options-item'; }
		if($searchReviewsListSize == NULL) 						{ $resetBtnClass = 'hide'; }	else { $resetBtnClass = 'inline top-5'; }
		?>
		
		<!-- OUTPUT LIST SIZE CONTROLS -->
		<div class = "<?php { echo $listSizeClass; } ?>" id = "list-size-options" title = "<?php echo $listSizeHover;?>">
		
			<!-- LABEL -->
			<div class = "inline text-14 top-6">Results per page:</div>
			
			<!-- INPUT -->
			<div class = "inline">
				<input type = "number" id = "select-list-size" min = "1" max = "100" step = "1" value = "<?php echo $searchReviewsListSize;?>"/>
			</div><!-- /.inline -->
			
			<!-- APPLY -->
			<div class = "inline top-5"><button type = "button" onclick = "setListSize()">Apply</button></div>
			
			<!-- RESET -->
			<div class = "<?php echo $resetBtnClass;?>" title = "<?php echo $resetBtnHover;?>">
				<button type = "button" onclick = "resetListSize()">Reset</button>
			</div><!-- /.$resetBtnClass-->
			
		</div><!-- /.search-options-item #list-size-options-->
		
	</div><!-- /.block #search-more-btns -->
	
	<!-- VELVET ROPE POPUP -->
	<div class = "hide" id = "velvet-rope-popup-container">
		<div class = "popup halves top-10">
			<div class = "inline">
				<button type = "button" onclick = "document.getElementById('velvet-rope-popup-container').style.display='none';">x</button>
			</div><!-- /.inline -->
			<div class = "inline">
				<div id = "velvet-rope-popup-content">
					<a href = "login.php?target=more">Log in as a subscriber to access this feature</a>
				</div><!-- /#velvet-rope-popup-content -->
			</div><!-- /.inline -->
		</div><!-- /.popup -->
	</div><!-- /.hide #velvet-rope-popup-container -->
	
</div><!-- /.search-options #search-more -->

<?php require_once 'php/save-item-forms.php'; // html forms for saving searches, bookmarks ?>