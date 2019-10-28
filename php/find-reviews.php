<?php
/*
find-reviews.php
By Matthew DiMatteo, Children's Technology Review

This file is included in the file 'document.php' for all pages where $pageType == 'search' and $searchType == 'reviews'
It processes search field input, uses it to construct a find request via the FileMaker PHP API, and returns an array of record data for product reviews

1. Get form input values
2. Custom handling based on input values
3. Construct find request
4. Handle errors
5. Process records
6. Calculate analytics
7. Store search parameters in session
8. Calculate summary string
*/
$startTime = microtime(true); // start a timer for calculating the speed of the search

/* 
GET FORM INPUT VALUES -----------------------------------------------------------------------------------------------
Get the values from each of the search form inputs - these are specified in the file 'php/search-form-reviews.php'
*/
if($thisPage == 'print.php') { $type = 'reviews'; } // if performing a search from print pag after loading bookmarks, switch $type to reviews

$searchReviewsKeyword 	= test_input($_GET['keyword']);
$searchReviewsSort		= test_input($_GET['sort']);
$searchReviewsOrder		= test_input($_GET['order']);
$searchReviewsAge		= test_input($_GET['age']);
$searchReviewsPlatform	= test_input($_GET['platform']);
$searchReviewsSubject	= test_input($_GET['subject']);
$searchReviewsTopic		= test_input($_GET['category']);
$searchReviewsPublisher	= test_input($_GET['publisher']);
$searchReviewsMonthly	= test_input($_GET['monthly']);
$searchReviewsWeekly	= test_input($_GET['weekly']);
$searchReviewsRubric	= test_input($_GET['rubric']);
$searchReviewsAward		= test_input($_GET['award']);
$searchReviewsYear		= test_input($_GET['year']);
$searchReviewsNumResults= test_input($_GET['num-results']); // for relevance sort
$searchReviewsListSize	= test_input($_GET['list-size']);	// for any sort
$searchReviewsPage		= test_input($_GET['page']);

$quickfind				= test_input($_GET['quickfind']); // for sidebar links

$searchReviewsPublished	= true; // whether to constrain to published reviews only (moderators can choose to view/edit drafts)

/* 
FILTERS 
Get the search filter input values and assign a boolean to determine whether the corresponding checkbox should be checked
These values are also used in concatenating a string summarizing the search results in 'php/results-summary.php'
*/
foreach($_GET['filter'] as $filter) { $filters .= $filter;	} 
if(substr_count($filters, 'current') > 0) 		{ $filterCurrent = true; } 		else { $filterCurrent = false; }
if(substr_count($filters, 'rated') > 0) 		{ $filterRated = true; } 		else { $filterRated = false; }
if(substr_count($filters, 'rubrics') > 0) 		{ $filterRubrics = true; } 		else { $filterRubrics = false; }
if(substr_count($filters, 'awards') > 0) 		{ $filterAwards = true; } 		else { $filterAwards = false; }
if(substr_count($filters, 'feature') > 0) 		{ $filterFeature = true; } 		else { $filterFeature = false; }
if(substr_count($filters, 'newrelease') > 0)	{ $filterNewrelease = true; }	else { $filterNewrelease = false; }
if(substr_count($filters, 'free' ) > 0) 		{ $filterFree = true; } 		else { $filterFree = false; }
if(substr_count($filters, 'videos' ) > 0) 		{ $filterVideos = true; } 		else { $filterVideos = false; }
if(substr_count($filters, 'images' ) > 0) 		{ $filterImages = true; } 		else { $filterImages = false; }
if(substr_count($filters, 'comments' ) > 0) 	{ $filterComments = true; } 	else { $filterComments = false; }
if(substr_count($filters, 'drafts' ) > 0) 		{ $filterDrafts = true; } 		else { $filterDrafts = false; }
if(substr_count($filters, 'drafts-only' ) > 0) 	{ $filterDraftsOnly = true; } 	else { $filterDraftsOnly = false; }

// override to set draft access to false if lacking credentials (prevents access via url)
if($mod != true and $expert != true)
{ 
	$filterDrafts = false; 
	$filterDraftsOnly = false; 
} // end if $mod != true and $expert != true

// CREATE AN ARRAY OF ALL ENTERED SEARCH TERMS
$searchTermsArray = array();
if($searchReviewsKeyword != NULL) 	{ array_push($searchTermsArray, $searchReviewsKeyword); }
if($searchReviewsAge != NULL) 		{ array_push($searchTermsArray, $searchReviewsAge); }
if($searchReviewsPlatform != NULL) 	{ array_push($searchTermsArray, $searchReviewsPlatform); }
if($searchReviewsSubject != NULL) 	{ array_push($searchTermsArray, $searchReviewsSubject); }
if($searchReviewsTopic != NULL) 	{ array_push($searchTermsArray, $searchReviewsTopic); }
if($searchReviewsPublisher != NULL) { array_push($searchTermsArray, $searchReviewsPublisher); }
if($searchReviewsMonthly != NULL) 	{ array_push($searchTermsArray, $searchReviewsMonthly); }
if($searchReviewsWeekly != NULL) 	{ array_push($searchTermsArray, $searchReviewsWeekly); }
if($searchReviewsRubric != NULL) 	{ array_push($searchTermsArray, $searchReviewsRubric); }
if($searchReviewsAward != NULL) 	{ array_push($searchTermsArray, $searchReviewsAward); }
if($searchReviewsYear != NULL) 		{ array_push($searchTermsArray, $searchReviewsYear); }
$numSearchTerms = count($searchTermsArray);

// PUBLISHER ACCESS
if($publisher == true) 
{ 
	// publishers can see only their products by default
	if($searchTermsArray == NULL or ($numSearchTerms == 1 and $searchReviewsPublisher == $publisherName))
	{
		$searchReviewsPublisher = $publisherName; // set the search criterion for publisher
		$velvetRope = false; // allow access under this condition
		$publisherAccess = true;
		if($searchReviewsSort == NULL) { $searchReviewsSort = 'new'; } // show most recently reviewed products by default
	} // end if $numSearchTerms < 1
	
	//if publisher inputs other search terms, perform typical velvet rope behavior
	else if($searchReviewsPublisher == $publisherName and $numSearchTerms > 1)
	{
		$searchReviewsPublisher = '';
		$velvetRope = true;
		$publisherAccess = false;
	} // end else if($searchReviewsPublisher == $publisherName and $numSearchTerms > 1)
	if($quickfind != NULL)
	{
		$searchReviewsPublisher = '';
		$velvetRope = true;
		$publisherAccess = false;
	}
} // end if $publisher == true
else { $publisherAccess = false; }

/* 
HANDLE SORT ----------------------------------------------------------------------------------------------------------------
Assign a database field based on the sort input to use when adding sort rules to the find request, below
The label variables are used in the search results summary string determined in 'php/results-summary.php'
*/
/*
if($searchReviewsSort == NULL)
{
	//if($numSearchTerms > 0) 			{ $searchReviewsSort = 'rel'; }		// make relevance the default if there are search terms
	if($searchReviewsKeyword != NULL) 	{ $searchReviewsSort = 'rel'; }		// make relevance the default if the keyword param is set
	else								{ $searchReviewsSort = ''; }		// make new the default when no search terms
}
*/
if ($searchReviewsSort == NULL) { $searchReviewsSort = 'new'; } // make new the default
switch($searchReviewsSort)
{
	case 'rel'	: 	$sortField = 'reviewnumber';	$sortLabel = 'most relevant';	$ascLabel = 'by least relevant';	$descLabel = 'by most relevant';
					$sortFunction = 'sortRelNew';
					break;
	case 'new'	:	$sortField = 'reviewnumber'; 	$sortLabel = 'newest';			$ascLabel = 'by oldest'; 			$descLabel = 'by newest';
					if($searchReviewsOrder == 'asc') { $sortFunction = 'sortOld'; } 			else { $sortFunction = 'sortNew'; }
					break;
	case 'best' :	$sortField = 'standardScore';	$sortLabel = 'rating';			$ascLabel = 'by lowest rating'; 	$descLabel = 'by highest rating'; 
					if($searchReviewsOrder == 'asc') { $sortFunction = 'sortWorstRelNew'; } 	else { $sortFunction = 'sortBestRelNew'; }
					$filterRated = true; // show only products with ratings when sorting by rating ($filterRated defined above)
					break;
	case 'abc'  :	$sortField = 'Title';			$sortLabel = 'alphabetically'; 	$ascLabel = 'alphabetically'; 		$descLabel = 'alphabetically'; 		
					if($searchReviewsOrder == 'asc') { $sortFunction = 'sortAbcRelNew'; } 		else { $sortFunction = 'sortZyxRelNew'; }
					break;
	default		:	$sortField = 'reviewnumber'; 	$sortLabel = 'newest';			$ascLabel = 'by oldest'; 			$descLabel = 'by newest';
					if($searchReviewsOrder == 'asc') { $sortFunction = 'sortOld'; } 			else { $sortFunction = 'sortNew'; }
					break;
}

// HANDLE SORT ORDER - also used in adding sort rules to the find request
if($searchReviewsOrder == NULL)	{	$searchReviewsOrder = 'desc'; 	}
switch($searchReviewsOrder)
{
	case 'asc'		:	$sortOrder = FILEMAKER_SORT_ASCEND; 	break;
	case 'desc'		:	$sortOrder = FILEMAKER_SORT_DESCEND; 	break;
	default			:	$sortOrder = FILEMAKER_SORT_DESCEND; 	break;
}

/*
CUSTOM HANDLING FOR AGES/GRADES
The 'age' input is determined by the user's interaction with one of the powersearch items
The value can be one of an array of options determined in the file 'php/sidebar-options.php'

Depending on the value, a different database field must be used in constructing the find request
Namely, the 'Early Elementary', 'Upper Elementary', and 'Middle/High School' options correspond to the values 'E', 'U', and 'M', respectively in the 'CSR::ageCodes' field

A label is also specified to map the coded field contents to a user-friendly string, which displays in the powersearch <select> item when selected
*/
switch($searchReviewsAge)
{
	case 'B' 	: $searchReviewsAgeLabel = 'Baby';				$searchReviewsAgeField = 'Grade Level';	break;
	case 'T' 	: $searchReviewsAgeLabel = 'Toddler';			$searchReviewsAgeField = 'Grade Level';	break;
	case 'P' 	: $searchReviewsAgeLabel = 'Preschool'; 		$searchReviewsAgeField = 'Grade Level';	break;
	case 'K' 	: $searchReviewsAgeLabel = 'Kindergarten'; 		$searchReviewsAgeField = 'Grade Level';	break;
	case 'E' 	: $searchReviewsAgeLabel = 'Early Elementary'; 	$searchReviewsAgeField = 'ageCodes';	break;
	case 'U' 	: $searchReviewsAgeLabel = 'Upper Elementary'; 	$searchReviewsAgeField = 'ageCodes';	break;
	case 'M' 	: $searchReviewsAgeLabel = 'Middle/High School'; $searchReviewsAgeField = 'ageCodes';	break;
	case '1'	: $searchReviewsAgeLabel = "1st Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '2'	: $searchReviewsAgeLabel = "2nd Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '3'	: $searchReviewsAgeLabel = "3rd Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '4'	: $searchReviewsAgeLabel = "4th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '5'	: $searchReviewsAgeLabel = "5th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '6'	: $searchReviewsAgeLabel = "6th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '7'	: $searchReviewsAgeLabel = "7th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '8'	: $searchReviewsAgeLabel = "8th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '9'	: $searchReviewsAgeLabel = "9th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case 'S'	: $searchReviewsAgeLabel = "Sophomore";			$searchReviewsAgeField = 'Grade Level';	break;
	case 'Jr'	: $searchReviewsAgeLabel = "Junior";			$searchReviewsAgeField = 'Grade Level';	break;
	case 'Sr'	: $searchReviewsAgeLabel = "Senior";			$searchReviewsAgeField = 'Grade Level';	break;
	default	 	: $searchReviewsAgeLabel = $searchReviewsAge;	$searchReviewsAgeField = 'Grade Level';	break;
} // end switch

// ASSIGN A LABEL TO POWERSEARCH TOPIC TERMS - also maps coded field contents to user-friendly string for <select> element display
switch($searchReviewsTopic)
{
	case 'AllTimeBestApps'		: $searchReviewsTopicLabel = 'All Time Best';		$topicLabel = true; break;
	case 'BestAndroid'			: $searchReviewsTopicLabel = 'Android';				$topicLabel = true; break;
	case 'Pioneer'				: $searchReviewsTopicLabel = 'Classics'; 			$topicLabel = true; break;
	case 'isFiction'			: $searchReviewsTopicLabel = 'Fiction'; 			$topicLabel = true; break;
	case 'Library Video Games'	: $searchReviewsTopicLabel = 'Library Videogames'; 	$topicLabel = true; break;
	case 'coop'					: $searchReviewsTopicLabel = 'Co-op';				$topicLabel = true; break;	
	default 					: $searchReviewsTopicLabel = $searchReviewsTopic;	$topicLabel = false; break;
} // end switch 

// IF SEARCHING BY AWARD, DETERMINE SEARCH FIELD BASED ON TYPE OF AWARD (BRDP/KAPI)
if($searchReviewsAward != NULL)
{
	if($searchReviewsAward == 'brda' or $searchReviewsAward == 'brdp' or $searchReviewsAward == 'bologna' or $searchReviewsAward == 'bolognaragazzi')
	{
		$searchReviewsAwardField = 'bolognaYear';
		$searchReviewsAwardLabel = 'BolognaRagazzi Digital Award '.$searchReviewsYear;
	} // end if $searchReviewsAward == 'brda'
	else if($searchReviewsAward == 'kapi' or $searchReviewsAward == 'kapis')
	{
		$searchReviewsAwardField = 'kapiYear';
		$searchReviewsAwardLabel = 'KAPi Awards '.$searchReviewsYear;
	} // end if $searchReviewsAward == 'kapi'
} // end if $searchReviewsaward

// PAGE NULL HANDLER
if ( $searchReviewsPage < 1 ) { $searchReviewsPage = 1; }

/* 
CONSTRUCT FIND REQUEST -------------------------------------------------------------------------------------------------
At this point, all user input has been processed. Next, a FileMaker Find Request is constructed using methods from the PHP API
See 'http://www.jsmall.us/apidoc/' for API documentation
*/

/* 
INITIALIZE FIND COMMAND OBJECT
The first step for constructing a find command is always initializing the object, in this case, $findReviews
The newFindCommand() method is a property of the $fmreviews object, which corresponds to the 'CSR' table in the 'CSR.fmp12 database'
Refer to 'php/connect.php' for this object definition

The newFindCommand() method also requires a parameter specifying the FileMaker Layout - the layout name is specified in 'php/connect.php'
All PHP API interaction with the database revolves around layouts in the FileMaker databases
All fields referenced in the php code must be included on the layout (with access given to the CWP account 'webctr')
*/
$findReviews 	= $fmreviews->newFindCommand($fmreviewsLayout);

/*
SET RANGE (NUMBER OF RESULTS TO BE RETURNED)
The setRange() method determines which portion of the found records to display at a given time
It takes two parameters: skip, and size
skip defines where to start from, which is useful for pagination
size defines the number of results (per page) to display
Logged in users can see more results per page than guest users
The exact values are determined in 'php/settings.php', which accesses the 'dashboard' table in the 'CSR.fmp12' database
*/

// set defaults
$guestResultSize 		= 3;
$subscriberResultSize 	= 100;
$maxSize 				= 500;
$exportMax 				= 100;

// handle default based on velvet rope
if($velvetRope == true) 
{ 
	$resultSize 		= $guestResultSize;
	$defaultResultSize 	= $guestResultSize;
}
else
{
	$resultSize 		= $subscriberResultSize;
	$defaultResultSize 	= $subscriberResultSize;
}

// override result size if modified by user input
if($searchReviewsListSize != NULL) 		{ $resultSize = $searchReviewsListSize; }
if($searchReviewsNumResults == NULL) 	{ $searchReviewsNumResults = $resultSize; }

// pagination
$skip = ($searchReviewsPage - 1) * $resultSize;

// set range for find command
$findReviews->setRange($skip, $resultSize);
if(($thisPage == 'export.php' or $thisPage == 'print.php') and $searchReviewsListSize == NULL) 
{ 
	if($searchReviewsNumResults > $exportMax) { $searchReviewsNumResults = $exportMax; }
	$findReviews->setRange(0, $exportMax); 
}

/*
ADD FIND CRITERIA
the addFindCriterion method (a property of the find request object) is used to narrow a search
It takes two parameters: the database field name and the search terms
Logical operators can be used with search terms for flexibility
Each criterion is only added if the corresponding input from the search form has been set
*/

// PUBLISHED/DRAFTS
if($filterDraftsOnly == true)		{ $findReviews->addFindCriterion('published',"=");									}
else 
{
	if($filterDrafts != true)		{ $findReviews->addFindCriterion('published',"*");									}
}

// KEYWORD
if($searchReviewsKeyword != NULL)	{ $findReviews->addFindCriterion('deepsearch',"=*$searchReviewsKeyword*");			}

// POWERSEARCH
if($searchReviewsAge != NULL) 		{ $findReviews->addFindCriterion($searchReviewsAgeField, "=*$searchReviewsAge*"); 	}
if($searchReviewsSubject != NULL) 	{ $findReviews->addFindCriterion('teaches text', "=*$searchReviewsSubject*"); 		}
if($searchReviewsPlatform != NULL) 	{ $findReviews->addFindCriterion('platform text', "=*$searchReviewsPlatform*"); 	}
if($searchReviewsTopic != NULL)		{ $findReviews->addFindCriterion('recommendations' , "=*$searchReviewsTopic*"); 	}

// HIDDEN
if($searchReviewsPublisher != NULL)	{ $findReviews->addFindCriterion('Company' , "=*$searchReviewsPublisher*"); 		}
if($searchReviewsMonthly != NULL)	{ $findReviews->addFindCriterion('issueAbbr' , "=*$searchReviewsMonthly*"); 		}
if($searchReviewsWeekly != NULL)	{ $findReviews->addFindCriterion('weekly' , "==".$searchReviewsWeekly); 			}
if($searchReviewsRubric != NULL)	{ $findReviews->addFindCriterion('rubrics' , "=*$searchReviewsRubric*"); 			}
if($searchReviewsAward != NULL)		{ $findReviews->addFindCriterion($searchReviewsAwardField , "=*$searchReviewsYear*"); }

// FILTERS
if($filterCurrent == true)			{ $findReviews->addFindCriterion('Date of Review', ">$currentSet"); 	}
if($filterRated == true) 			{ $findReviews->addFindCriterion('standardStars', ">0"); 				}
if($filterRubrics == true) 			{ $findReviews->addFindCriterion('rubrics', "*"); 						}
if($filterAwards == true)			{ $findReviews->addFindCriterion('whereisit', "=Editor\'s Choice"); 	}
if($filterFeature == true)			{ $findReviews->addFindCriterion('Feature review', "=*Feature*"); 		}
if($filterNewrelease == true)		{ $findReviews->addFindCriterion('Feature review', "=*New*"); 			}
if($filterFree == true)				{ $findReviews->addFindCriterion('Price', "=*free*"); 					}
if($filterVideos == true)			{ $findReviews->addFindCriterion('video', "*"); 						}
if($filterImages == true)			{ $findReviews->addFindCriterion('imgData', "*"); 						}
if($filterComments == true)			{ $findReviews->addFindCriterion('commentCountText', ">0"); 			}

/*
ADD SORT RULE
addSortRule() takes three parameters:
- The first is the field to sort by, which is determined above based on the user input
- The second is the priority order - you can assign multiple sort rules, starting from the value '1'
- The third is the sort order (ascending or descending), which must take the form of either FILEMAKER_SORT_DESCEND or FILEMAKER_SORT_ASCEND (not a string)
*/

if 		($sortField == 'reviewnumber') 			
{ $findReviews->addSortRule('reviewnumber', 1, $sortOrder); 																			}

else if	($sortField == 'standardScore') 
{ $findReviews->addSortRule('standardScore', 1, $sortOrder); 	$findReviews->addSortRule('reviewnumber', 2, FILEMAKER_SORT_DESCEND); 	}

else if ($sortField == 'Title')
{ $findReviews->addSortRule('Title', 1, $sortOrder); 			$findReviews->addSortRule('reviewnumber', 2, FILEMAKER_SORT_DESCEND); 	}

else
{ $findReviews->addSortRule('reviewnumber', 1, FILEMAKER_SORT_DESCEND); } // defaults to showing most recent

// EXECUTE THE FIND	- after all find criteria and sort rules have been defined, the execute() method performs the find
$result = $findReviews->execute();

/* 
ERROR HANDLER -----------------------------------------------------------------------------------------------------------------
FileMaker returns an error for an empty result set
In the case of searching reviews, this can happen if the user enters criteria that are not met
In the event of a null set, the user should be redirected to a 'No results found' page that allows them to try a new search
*/

if (FileMaker::isError ($result) ) 
{ 
	if($thisPage == 'export.php') { echo $result->getMessage(); exit(); } // for debugging purposes
	//foreach($searchTermsArray as $searchTermOutput) { echo $searchTermOutput.', '; } exit(); // debug
	$redirect = 'noresults.php';
	$pageTitle = 'No results found';
	require_once 'php/redirect.php'; 
	exit();
}
$records = $result->getRecords(); 	// store the found records in the $records object

/*
ANALYTICS --------------------------------------------------------------------------------------------------------------------
Once records have been returned, calculate the time taken to perform the search
The start and end points for the range are also determined, used in displaying page navigation feedback in 'php/pagenav.php'
*/
$endTime = microtime(true);
$elapsedTime = round($endTime - $startTime, 3);

$rangeStart = 1 + (($searchReviewsPage - 1) * $resultSize);
$rangeEnd = $resultSize + (($searchReviewsPage - 1) * $resultSize);
$foundcount = $result->getFoundSetCount();
$fetchcount = $result->getFetchCount();
$numPages = ceil($foundcount/$resultSize);
if ( $rangeEnd > $foundcount ) { $rangeEnd = $foundcount; }

// RANK RESULTS IF SORTING BY RELEVANCE --------------------------------------------------------------------------------------
if($searchReviewsSort == 'rel')
{
	// process records returned from the find request
	$recordsToSort 	= array(); 	// declare an empty array to contain $record objects with calculated $relevance
	$rankN = 0;
	
	// convert search terms text to lowercase for case-sensitive substr_count checks
	$rankSearchKeyword 		= cleanText($searchReviewsKeyword);
	$rankSearchAge			= cleanText($searchReviewsAge);
	$rankSearchAgelabel		= cleanText($searchReviewsAgeLabel);
	$rankSearchPlatform 	= cleanText($searchReviewsPlatform);
	$rankSearchSubject 		= cleanText($searchReviewsSubject);
	$rankSearchTopic 		= cleanText($searchReviewsTopic);
	$rankSearchTopiclabel	= cleanText($searchReviewsTopicLabel);
	$rankSearchCompany	 	= cleanText($searchReviewsPublisher);
	$rankSearchMonthly		= cleanText($searchReviewsMonthly);
	$rankSearchWeekly 		= strtolower($searchReviewsWeekly);

	// determine the number of search terms inputted and parse out each ----------------------------------------------
	$searchTermsDataArray = array('keyword', 'age', 'agelabel', 'platform', 'subject', 'topic', 'topiclabel', 'company', 'monthly', 'weekly');
	foreach($searchTermsDataArray as $thisSearchTermData)
	{
		$dataVarName 		= 'search'.ucfirst($thisSearchTermData).'Data';
		$searchTermVarName 	= 'rankSearch'.ucfirst($thisSearchTermData);
		$$dataVarName 		= getTextArray($$searchTermVarName);
		$dataVarValue 		= $$dataVarName;
		$wordsArrayVarName 	= 'search'.ucfirst($thisSearchTermData).'Words';
		$$wordsArrayVarName = $dataVarValue['words'];
		$wordStringVarName 	= 'search'.ucfirst($thisSearchTermData).'Word';
		$$wordStringVarName = $dataVarValue['word'];
		$wordCountVarName 	= 'numSearch'.ucfirst($thisSearchTermData).'Words';
		$$wordCountVarName 	= $dataVarValue['wordcount'];
	} // end foreach $searchTermsDataArray

	// new pagination method attempt ---------------------------------------------------------------------------------------------
	//$maxSize = 800; // this value is the number of most recent records that will be returned for ranking
	//$maxSize = $searchReviewsNumResults; if($maxSize == NULL) { $maxSize = $resultSize; }
	for($f = 0; $f < $numPages + 1; $f++)
	{
		// calculate the $skip
		$thisSkip = $f * $resultSize;

		// will still crash if result size is too large - cannot use set_time_limit; FM has its own settings
		if($thisSkip <= $maxSize - $resultSize)
		{
			// calculate find request variable name and create request
			$findRequestVarName = 'findRequest'.$f;
			$thisFindRequest = $$findRequestVarName;
			$thisFindRequest = $fmreviews->newFindCommand($fmreviewsLayout);
			$thisFindRequest->setRange($thisSkip, $resultSize);
			
			// add find criteria
			// PUBLISHED/DRAFTS
			if($filterDraftsOnly == true)		{ $thisFindRequest->addFindCriterion('published',"=");									}
			else 
			{
				if($filterDrafts != true)		{ $thisFindRequest->addFindCriterion('published',"*");									}
			}
			if($searchReviewsKeyword != NULL)	{ $thisFindRequest->addFindCriterion('deepsearch',"=*$searchReviewsKeyword*");			}
			if($searchReviewsAge != NULL) 		{ $thisFindRequest->addFindCriterion($searchReviewsAgeField, "=*$searchReviewsAge*"); 	}
			if($searchReviewsSubject != NULL) 	{ $thisFindRequest->addFindCriterion('teaches text', "=*$searchReviewsSubject*"); 		}
			if($searchReviewsPlatform != NULL) 	{ $thisFindRequest->addFindCriterion('platform text', "=*$searchReviewsPlatform*"); 	}
			if($searchReviewsTopic != NULL)		{ $thisFindRequest->addFindCriterion('recommendations' , "=*$searchReviewsTopic*"); 	}
			if($searchReviewsPublisher != NULL)	{ $thisFindRequest->addFindCriterion('Company' , "=*$searchReviewsPublisher*"); 		}
			if($searchReviewsMonthly != NULL)	{ $thisFindRequest->addFindCriterion('issueAbbr' , "=*$searchReviewsMonthly*"); 		}
			if($searchReviewsWeekly != NULL)	{ $thisFindRequest->addFindCriterion('weekly' , "==".$searchReviewsWeekly); 			}
			if($searchReviewsRubric != NULL)	{ $thisFindRequest->addFindCriterion('rubrics' , "=*$searchReviewsRubric*"); 			}
			if($searchReviewsAward != NULL)		{ $thisFindRequest->addFindCriterion($searchReviewsAwardField , "=*$searchReviewsYear*"); }
			if($filterCurrent == true)			{ $thisFindRequest->addFindCriterion('Date of Review', ">$currentSet"); 				}
			if($filterRated == true)			{ $thisFindRequest->addFindCriterion('standardStars', ">0"); 							}
			if($filterRubrics == true)			{ $thisFindRequest->addFindCriterion('rubrics', "*"); 									}
			if($filterAwards == true)			{ $thisFindRequest->addFindCriterion('whereisit', "=Editor\'s Choice"); 				}
			if($filterFeature == true)			{ $thisFindRequest->addFindCriterion('Feature review', "=*Feature*"); 					}
			if($filterNewrelease == true)		{ $thisFindRequest->addFindCriterion('Feature review', "=*New*"); 						}
			if($filterFree == true)				{ $thisFindRequest->addFindCriterion('Price', "=*free*"); 								}
			if($filterVideos == true)			{ $thisFindRequest->addFindCriterion('video', "*"); 									}
			if($filterImages == true)			{ $thisFindRequest->addFindCriterion('imgData', "*"); 									}
			if($filterComments == true)			{ $thisFindRequest->addFindCriterion('commentCountText', ">0"); 						}

			// add sort rule
			$thisFindRequest->addSortRule('reviewnumber', 1, FILEMAKER_SORT_DESCEND); 

			// calculate the result var name and execute the find request
			$resultVarName = 'thisResult'.$f;
			$thisResult = $$thisResultVarName;
			$thisResult = $thisFindRequest->execute();

			// output error message
			if (FileMaker::isError ($thisResult) ) { echo $thisResultVarName.'<br/>'.$thisResult->getMessage(); exit(); }

			// calculate the records var name and get records
			$recordsVarName = 'records'.$f;
			$thisRecords = $$recordsVarName;
			$thisRecords = $thisResult->getRecords();
			foreach($thisRecords as $record) { require 'php/rank-review.php'; }  // rank results and add the records to the array of all records
		} // end if $thisSkip <= 1000
	} // end for
	usort($recordsToSort, $sortFunction); // sort the results by the corresponding function
	$newEndTime = microtime(true);
	$newElapsedTime = round($newEndTime - $startTime, 3);
} // end if($searchReviewsSort == 'rel')

// IF NOT SORTING BY RELEVANCE
else
{
	// compile a separate array of records to be output in grid view
	$gridRecords = array();
	foreach($records as $record)
	{
		require 'php/get-review.php';
		array_push($gridRecords, $fieldValues);
	}
} // end else not sorting by relevance

/*
STORE SEARCH URL AND PARAMETERS -----------------------------------------------------------------------------------------------
$_SESSION storage is used to contain the user's last search
These values are useful for returning a user to their search results after navigating elsewhere, such as to a review or a content page
*/
if($thisPage != 'noresults.php')
{
	$thisLastSearch = $thisURL;
	/*
	if($thisPage == 'print.php' or $thisPage == 'export.php')
	{
		$thisLastSearch = 'home.php';
		if($thisQuery != NULL) { $thisLastSearch .= '?'.$thisQuery; }
	}
	*/
	$_SESSION['lastSearchType']		= $searchType;
	$_SESSION['lastSearch'] 		= $thisLastSearch;
	$_SESSION['lastSearchReviews'] 	= $thisLastSearch;
	$_SESSION['lastQueryReviews'] 	= $thisQuery;
	$_SESSION['lastKeywordReviews']	= $searchReviewsKeyword;
	$_SESSION['lastKeyword']		= $searchReviewsKeyword;
	$_SESSION['lastAge']			= $searchReviewsAge;
	$_SESSION['lastAgeLabel']		= $searchReviewsAgeLabel;
	$_SESSION['lastPlatform']		= $searchReviewsPlatform;
	$_SESSION['lastSubject']		= $searchReviewsSubject;
	$_SESSION['lastTopic']			= $searchReviewsTopic;
	$_SESSION['lastTopicLabel']		= $searchReviewsTopicLabel;
}

// CALCULATE SUMMARY STRING
if($foundcount > 0) 
{ 
	require_once 'php/results-summary.php'; // calculate summary string to display as heading in results section
	require_once 'php/search-filename.php'; // calculate filename for exporting or saving a search
	require_once 'php/pagenav-calc.php'; 	// calculates the url for first/prev/next/last pages based on current url string
} 
?>