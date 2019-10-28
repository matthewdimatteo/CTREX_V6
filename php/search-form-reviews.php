<!--
php/search-form-reviews.php
By Matthew DiMatteo, Children's Technology Review

This file contains the html form for performing searches of reviews - it is included in 'php/document.php'
The CTREX interface contains separate inputs, such as text fields or dropdown menus, which the user interacts with to specify search criteria
Each of those inputs contains an event attribute to call a JavaScript function which maps input values to this form's hidden inputs
	The id values of these inputs are used for referencing the elements in those functions

The file 'php/find-reviews.php' processes this form input, referencing the input names, and assigning their values to variables
	The php variables remain in the form
-->
<?php if($pageType == 'search') { $searchAction = $thisPage; } else { $searchAction = 'home.php'; } ?>
<form name = "search-reviews-form" 			id = "search-reviews-form" method = "GET" action = "<?php echo $searchAction;?>" class = "hide">

<input type = "hidden" name = "search" 		id = "search-reviews-submit" 			value = "reviews" />
<input type = "hidden" name = "keyword" 	id = "search-reviews-keyword" 			value = "<?php echo $searchReviewsKeyword;?>" />

<input type = "hidden" name = "sort" 		id = "search-reviews-sort" 				value = "<?php echo $searchReviewsSort;?>" />
<input type = "hidden" name = "order" 		id = "search-reviews-order" 			value = "<?php echo $searchReviewsOrder;?>" />

<input type = "hidden" name = "age" 		id = "search-reviews-age" 				value = "<?php echo $searchReviewsAge;?>" />
<input type = "hidden" name = "subject" 	id = "search-reviews-subject" 			value = "<?php echo $searchReviewsSubject;?>" />
<input type = "hidden" name = "platform" 	id = "search-reviews-platform" 			value = "<?php echo $searchReviewsPlatform;?>" />
<input type = "hidden" name = "category" 	id = "search-reviews-topic" 			value = "<?php echo $searchReviewsTopic;?>" />

<input type = "hidden" name = "publisher" 	id = "search-reviews-publisher" 		value = "<?php echo $searchReviewsPublisher;?>" />
<input type = "hidden" name = "monthly" 	id = "search-reviews-monthly" 			value = "<?php echo $searchReviewsMonthly;?>" />
<input type = "hidden" name = "weekly" 		id = "search-reviews-weekly" 			value = "<?php echo $searchReviewsWeekly;?>" />
<input type = "hidden" name = "rubric" 		id = "search-reviews-rubric" 			value = "<?php echo $searchReviewsRubric;?>" />
<input type = "hidden" name = "award" 		id = "search-reviews-award" 			value = "<?php echo $searchReviewsAward;?>" />
<input type = "hidden" name = "year" 		id = "search-reviews-year" 				value = "<?php echo $searchReviewsYear;?>" />

<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-current" 	value = "current" 	<?php if($filterCurrent == true){ echo 'checked'; } ?> />
<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-awards" 	value = "awards" 	<?php if($filterAwards == true) { echo 'checked'; } ?> />
<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-rated" 		value = "rated"		<?php if($filterRated == true) { echo 'checked'; } ?> />
<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-rubrics" 	value = "rubrics"	<?php if($filterRubrics == true){ echo 'checked'; } ?> />
<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-feature" 	value = "feature"	<?php if($filterFeature == true){ echo 'checked'; } ?> />
<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-newrelease" value = "newrelease"<?php if($filterNewrelease == true){ echo 'checked';}?>/>
<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-free" 		value = "free" 		<?php if($filterFree == true) { echo 'checked'; } ?> />
<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-videos" 	value = "videos" 	<?php if($filterVideos == true) { echo 'checked'; } ?> />
<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-images" 	value = "images" 	<?php if($filterImages == true) { echo 'checked'; } ?> />
<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-comments" 	value = "comments" 	<?php if($filterComments == true){ echo 'checked'; } ?>/>
<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-drafts"		value = "drafts"	<?php if($filterDrafts == true)	{ echo 'checked'; } ?> />
<input type = "checkbox" name = "filter[]" 	id = "search-reviews-filter-drafts-only"value="drafts-only"<?php if($filterDraftsOnly == true){ echo 'checked';}?>/>

<input type = "hidden" name = "num-results" id = "search-reviews-num-results"		value = "<?php echo $searchReviewsNumResults;?>" />
<input type = "hidden" name = "list-size" 	id = "search-reviews-list-size"			value = "<?php echo $searchReviewsListSize;?>" />
<input type = "hidden" name = "page" 		id = "search-reviews-page" 				value = "<?php echo $searchReviewsPage;?>" />
</form>