<?php
/*
content-noresults.php
By Matthew DiMatteo, Children's Technology Review

This file defines the html content for the page 'noresults.php', which is displayed when a user's search returns no results
*/
switch($lastSearchType)
{
	case 'reviews' 		: $resetLink = 'home.php'; 			break;
	case 'publishers' 	: $resetLink = 'publishers.php'; 	break;
	case 'archive' 		: $resetLink = 'archive.php'; 		break;
	default				: $resetLink = 'home.php'; 			break;
} // end switch($lastSearchType)
?>
<!-- SIDEBAR -->
<div class = "sidebar"><?php require_once 'php/sidebar.php';?></div>

<!-- SEARCH AREA -->
<div class = "search-area-noresults">
	<div class = "bottom-20">No results found</div>
	<div class = "bottom-20">
		<div class = "inline"><a href = "<?php echo $lastSearch;?>">Back</a></div>
		<div class = "inline">|</div>
		<div class = "inline"><a href = "<?php echo $resetLink;?>">Reset</a></div>
	</div><!-- /.results-feed -->
</div><!-- /.search-area-noresults -->