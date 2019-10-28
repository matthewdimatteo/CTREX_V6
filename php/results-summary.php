<?php
/*
php/results-summary.php
By Matthew DiMatteo, Children's Technology Review

This file calculates a string to display as the search results summary/description
It is included in the file 'php/find-reviews.php' after the find command has been executed

There are two methods (plus a simplified debug method) for calculating this string
- Method 1 assigns the value to the variable $searchResultsSummary (this method seems to be best)
- Method 2 assigns the value to the variable $searchDescription

The displayed string can be switched by commenting the lines at the end of this file
*/

// FORMAT THOUSANDS SEPARATOR - foundcount, numPages, rangeStart, rangeEnd
if($foundcount > 1000) 	{ $foundcountStr 	= number_format($foundcount, 0, '.', ','); }	else { $foundcountStr 	= $foundcount; }
if($numPages > 1000) 	{ $numPagesStr 		= number_format($numPages, 0, '.', ','); }		else { $numPagesStr 	= $numPages; }
if($rangeStart > 1000) 	{ $rangeStartStr 	= number_format($rangeStart, 0, '.', ','); }	else { $rangeStartStr 	= $rangeStart; }
if($rangeEnd > 1000) 	{ $rangeEndStr 		= number_format($rangeEnd, 0, '.', ','); } 		else { $rangeEndStr 	= $rangeEnd; }

// get the value of the current page depending on the type of search
if($searchType == 'reviews')			{ $searchPage = $searchReviewsPage; }
else if($searchType == 'publishers')	{ $searchPage = $searchPublishersPage; }
else if($searchType == 'archive')		{ $searchPage = $searchArchivePage; }
else									{ $searchPage = $searchReviewsPage; }

// SET PAGE NAVIGATION STRING
if($velvetRope == true) 
{ 
	$rangeEndLabel = $numResultsVelvet; 
	$numPagesLabel = ceil($foundcount/$numResultsVelvet);
	if($numPagesLabel > 1000) { $numPagesLabel = number_format($numPagesLabel, 0, '.', ','); }
} 
else 
{ 
	$rangeEndLabel = $rangeEndStr; 
	$numPagesLabel = $numPagesStr;
}
if($foundcount < $resultSize) { $rangeEndLabel = $foundcount; }
$pagenav = 'Page ';
$pagenav .= $searchPage.' of '.$numPagesLabel;
$pagenav .= ' - Results '.$rangeStartStr.' to '.$rangeEndLabel.' of '.$foundcountStr;

// SET SEARCH RESULTS SUMMARY STRING 
$debugSummary = 'Showing results '.$rangeStartStr.' - '.$rangeEndLabel.' of '.$foundcountStr.'<br/><br/>'; 

// METHOD 1 ---------------------------------------------------
$searchResultsSummary  = '';	// declare variable for search results summary string to append based on search terms

// FOR REVIEWS
if($searchType == 'reviews')
{
	// CONSTRAINED FOUNDSET - RELEVANCE SORT/PRINT PAGE
	// if sorting by relevance, indicate that only however many records are fetched are being displayed
	if
	(
		($searchReviewsSort == 'rel' and $foundcount > $searchReviewsNumResults)  or
		($thisPage == 'print.php' and $foundcount > $exportMax)
	)
	
	//if($searchReviewsListSize != NULL) 	{ $searchResultsSummary = 'Showing first '.$searchReviewsListSize.' of '; }
	//else 								{ $searchResultsSummary = 'Showing first '.$searchReviewsNumResults.' of '; }
	$searchResultsSummary = 'Showing first '.$resultSize.' of ';
	
	// append adjectives for certain filters
	if($searchTermsArray == NULL and $filters == NULL)
	{ 	
		if($searchResultsSummary == NULL) 	{ $searchResultsSummary .= 'All '; }
		else								{ $searchResultsSummary .= 'all '; }
	} // end if $searchTermsArray and !filterRated
	
										$searchResultsSummary .= $foundcountStr;
	if($filterCurrent == true)		{ 	$searchResultsSummary .= ' current'; 			}
	if($filterRated == true)		{ 	$searchResultsSummary .= ' rated'; 				}
	
	if($filterAwards == true) 		{ 	$searchResultsSummary .= ' Editor\'s Choice'; 	}
	if($filterFeature == true) 		{ 	$searchResultsSummary .= ' Feature'; 			}
	if($filterNewrelease == true) 	{ 	$searchResultsSummary .= ' New Release'; 		}
	if($thisPage == 'drafts.php')	{	$searchResultsSummary .= ' draft';				}
										$searchResultsSummary .= ' review'; if($foundcount != 1) { $searchResultsSummary .= 's'; }
	if($filterFree == true)			{ 	$searchResultsSummary .= ' of free products'; 	}
	if($filterRubrics == true)		{	$searchResultsSummary .= ' evaluated with rubrics'; }
	if($searchReviewsAward != NULL)	{	$searchResultsSummary .= ' for '.$searchReviewsAwardLabel; }

	// append 'with' for certain filters
	$withCount = 0;
	if ($filterVideos == true) 		{ $withCount += 1; }
	if ($filterImages == true) 		{ $withCount += 1; }
	if ($filterComments == true) 	{ $withCount += 1; }

	if($withCount > 0)				{ 	$searchResultsSummary .= ' with';				}
	if($withCount >= 2)				{ 	$searchResultsSummary .= ':';					}
										$searchResultsSummary .= ' ';
	$withCount += 1; 				// adds extra comma and space at end of with string for sort label
	if($filterVideos == true)		{ 	$searchResultsSummary .= 'videos'; 		$withCount -= 1;	if($withCount >0) { $searchResultsSummary .= ', ';	} 	}					

	if($filterImages == true)		{ 	$searchResultsSummary .= 'images'; 		$withCount -= 1;	if($withCount >0) { $searchResultsSummary .= ', ';	} 	}	

	if($filterComments == true)		{ 	$searchResultsSummary .= 'comments'; 	$withCount -= 1;	if($withCount >0) { $searchResultsSummary .= ', ';	} 	}	

	// append sort state
	//if($searchReviewsSort != NULL) { if($searchReviewsOrder == 'asc') { $searchResultsSummary .= 'sorted '.$ascLabel; } else { $searchResultsSummary .= 'sorted '.$descLabel; } }
	if($searchReviewsOrder == 'asc') { $searchResultsSummary .= 'sorted '.$ascLabel; } else { $searchResultsSummary .= 'sorted '.$descLabel; }
	$navlinefeedback 	= $searchResultsSummary;
	$mobilefeedback 	= $searchResultsSummary;

	// append performance analytics
	//$searchResultsSummary .= ' found in '.$elapsedTime.' seconds';	

	// METHOD 2 -------------------------------------------------------------------------------------------------------
	// COUNT NUMBER OF SEARCH PARAMETERS INPUTTED
	$numParams = 0; $plusCount = 0;
	$numFilters = 0; $filterCount = 0;

	if ($searchReviewsKeyword != NULL) 	{ $numParams += 1; $plusCount += 1; }
	if ($searchReviewsAge != NULL) 		{ $numParams += 1; $plusCount += 1; }
	if ($searchReviewsSubject != NULL) 	{ $numParams += 1; $plusCount += 1; }
	if ($searchReviewsPlatform != NULL) { $numParams += 1; $plusCount += 1; }
	if ($searchReviewsTopic != NULL) 	{ $numParams += 1; $plusCount += 1; }
	if ($searchReviewsPublisher != NULL){ $numParams += 1; $plusCount += 1; }
	if ($searchReviewsMonthly != NULL) 	{ $numParams += 1; $plusCount += 1; }
	if ($searchReviewsWeekly != NULL) 	{ $numParams += 1; $plusCount += 1; }

	if ($filterCurrent == true)		{ $numFilters += 1; $filterCount += 1; }
	if ($filterFeature == true)		{ $numFilters += 1; $filterCount += 1; }
	if ($filterNewrelease == true)	{ $numFilters += 1; $filterCount += 1; }
	if ($filterRated == true)		{ $numFilters += 1; $filterCount += 1; }
	if ($filterRubrics == true)		{ $numFilters += 1; $filterCount += 1; }
	if ($filterAwards == true)		{ $numFilters += 1; $filterCount += 1; }
	if ($filterWeekly == true)		{ $numFilters += 1; $filterCount += 1; }
	if ($filterVideos == true)		{ $numFilters += 1; $filterCount += 1; }
	if ($filterFree == true)		{ $numFilters += 1; $filterCount += 1; }
	if ($filterComments == true)	{ $numFilters += 1; $filterCount += 1; }
	if ($filterImages == true)		{ $numFilters += 1; $filterCount += 1; }
	if ($filterGalleries == true)	{ $numFilters += 1; $filterCount += 1; }

	$withCount = 0;
	if ($filterVideos == true) 		{ $withCount += 1; }
	if ($filterImages == true) 		{ $withCount += 1; }
	if ($filterGalleries == true) 	{ $withCount += 1; }
	if ($filterComments == true) 	{ $withCount += 1; }

	// SET FEEDBACK STRING FOR SAVED SEARCHES BASED ON SEARCH PARAMETERS
	$searchDescription  = $foundcount.' ';

	if ($filterCount == 0) 				{ $searchDescription .= 'result'; } if($foundcount != 1) { $searchDescription .= 's'; }
	if ($numParams == 0 and $numFilters == 0)	{ $searchDescription .= ' (all records)'; }
	if ($filterCurrent == true)			{ $searchDescription .= 'current '; }
	if ($filterRated == true)			{ $searchDescription .= 'rated '; }
	if ($filterAwards == true)			{ $searchDescription .= 'Editor\'s Choice '; }
	if ($filterFeature == true)			{ $searchDescription .= 'Feature '; }
	if ($filterNewrelease == true)		{ $searchDescription .= 'New Release '; }
	if ($filterCount > 0) 				{ $searchDescription .= 'records'; }
	if ($filterFree == true)			{ $searchDescription .= ' for free products'; }
	if ($filterRubrics == true)			{ $searchDescription .= ' evaluated with rubrics'; }

	if ($withCount > 0)					{ $searchDescription .= ' with'; $originalWithCount = $withCount; }
	if ($withCount >= 2)				{ $searchDescription .= ':'; }
										  $searchDescription .= ' ';

	if ($filterVideos == true)			{ $searchDescription .= 'videos'; 	$withCount -= 1;	if($withCount > 0) { $searchDescription .= ', ';	} 	}
	if ($filterImages == true)			{ $searchDescription .= 'images'; 	$withCount -= 1;	if($withCount > 0) { $searchDescription .= ', ';	} 	}
	if ($filterComments == true)		{ $searchDescription .= 'comments'; $withCount -= 1;												  			}

	if ($originalWithCount > 0)			{ $searchDescription .= ' '; }
										  $searchDescription .= 'found';
	if ($numParams != 0) 				{ $searchDescription .= ' for '; }

	if ($searchReviewsKeyword != NULL) 	{ $searchDescription .= $searchTerms; 				$plusCount -= 1; if ($plusCount > 0) { $searchDescription .= '+'; } }
	if ($searchReviewsAge != NULL) 		{ $searchDescription .= $searchReviewsAgeLabel; 	$plusCount -= 1; if ($plusCount > 0) { $searchDescription .= '+'; } }
	if ($searchReviewsSubject != NULL) 	{ $searchDescription .= $searchSubject; 			$plusCount -= 1; if ($plusCount > 0) { $searchDescription .= '+'; } }
	if ($searchReviewsPlatform != NULL) { $searchDescription .= $searchPlatform; 			$plusCount -= 1; if ($plusCount > 0) { $searchDescription .= '+'; } }
	if ($searchReviewsTopic != NULL) 	{ $searchDescription .= $searchReviewsTopicLabel; 	$plusCount -= 1; if ($plusCount > 0) { $searchDescription .= '+'; } }
	if ($searchReviewsPublisher != NULL){ $searchDescription .= $searchPublisher; 			$plusCount -= 1; if ($plusCount > 0) { $searchDescription .= '+'; } }
	if ($searchReviewsMonthly != NULL) 	{ $searchDescription .= $searchIssue; 				$plusCount -= 1;  }
										  $searchDescription .= ', sorted by '.$sortLabel;

	// toggle between 2 methods
	//$searchReviewsHeading = $debugSummary;
	$searchReviewsHeading = $searchResultsSummary;
	//$searchReviewsHeading = $searchDescription;

	// calc string for save search summary
	$savesearchSummary = $searchReviewsHeading; // for saving searches
	if($numSearchTerms > 0)
	{
		$savesearchTerms = ' ('; // declare a suffix to concatenate based on search params
		if($searchReviewsKeyword != NULL) 	{ $savesearchTerms .= ' keyword = '.$searchReviewsKeyword; }
		if($searchReviewsAge != NULL) 		{ $savesearchTerms .= ' age = '.$searchReviewsAgeLabel; }
		if($searchReviewsSubject != NULL) 	{ $savesearchTerms .= ' subject = '.$searchReviewsSubject; }
		if($searchReviewsPlatform != NULL) 	{ $savesearchTerms .= ' platform = '.$searchReviewsPlatform; }
		if($searchReviewsTopic != NULL) 	{ $savesearchTerms .= ' topic = '.$searchReviewsTopicLabel; }
		if($searchReviewsPublisher != NULL) { $savesearchTerms .= ' publisher = '.$searchReviewsPublisher; }
		if($searchReviewsMonthly != NULL) 	{ $savesearchTerms .= ' monthly = '.$searchReviewsMonthly; }
		if($searchReviewsWeekly != NULL) 	{ $savesearchTerms .= ' weekly = '.$searchReviewsWeekly; }
		if($searchReviewsRubric != NULL) 	{ $savesearchTerms .= ' rubric = '.$searchReviewsRubric; }
		$savesearchTerms .= ' )';
		$savesearchSummary .= $savesearchTerms;
	} // end if $numSearchTerms > 0
} // end if $searchType == 'reviews'

// FOR PUBLISHERS
else if($searchType == 'publishers')
{
	if($searchPublishersKeyword == NULL)	{ $searchResultsSummary .= 'All '; 	}
	$searchResultsSummary .= $foundcountStr;
	$searchResultsSummary .= ' publishers';
	if($searchPublishersOrder == 'asc') { $searchResultsSummary .= ' sorted '.$ascLabel; } else { $searchResultsSummary .= ' sorted '.$descLabel; }
	$searchPublishersHeading = $searchResultsSummary;
}

// FOR ARCHIVE
else if($searchType == 'archive')
{
	if($searchArchiveKeyword == NULL)		{ $searchResultsSummary .= 'All '; 	}
	$searchResultsSummary .= $foundcountStr;
	if($searchArchiveType == 'monthly') 	{ $searchResultsSummary .= ' monthly issues'; }
	else if($searchArchiveType == 'weekly') { $searchResultsSummary .= ' weekly newsletters'; }
	if($searchArchiveOrder == 'asc') { $searchResultsSummary .= ' sorted '.$ascLabel; } else { $searchResultsSummary .= ' sorted '.$descLabel; }
	$searchArchiveHeading = $searchResultsSummary;
}
?>