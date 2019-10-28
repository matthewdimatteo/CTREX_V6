<?php
/*
php/find-publishers.php
By Matthew DiMatteo, Children's Technology Review

This file is included in the file 'document.php' for the page 'publishers.php' where $pageType == 'search' and $searchType == 'publishers'
It processes search field input, uses it to construct a find request via the FileMaker PHP API, and returns an array of publisher record data

*/
$startTime = microtime(true); // start a timer for calculating the speed of the search

/* 
GET FORM INPUT VALUES -----------------------------------------------------------------------------------------------
Get the values from each of the search form inputs - these are specified in the file 'php/search-form-publishers.php'
*/
$searchPublishersKeyword 	= test_input($_GET['keyword']);
$searchPublishersSort		= test_input($_GET['sort']);
$searchPublishersOrder		= test_input($_GET['order']);
$searchPublishersPage		= test_input($_GET['page']);

/* 
HANDLE SORT ----------------------------------------------------------------------------------------------------------------
Assign a database field based on the sort input to use when adding sort rules to the find request, below
The label variables are used in the search results summary string determined in 'php/results-summary.php'
*/
if($searchPublishersSort == NULL)
{
	/*
	//if($numSearchTerms > 0) 			{ $searchPublishersSort = 'rel'; }	// make relevance the default if there are search terms
	if($searchPublishersKeyword != NULL){ $searchPublishersSort = 'rel'; }	// make relevance the default if the keyword param is set
	else								{ $searchPublishersSort = ''; }		// make new the default when no search terms
	*/
	$searchPublishersSort = '';
}
//if ($searchPublishersSort == NULL) { $searchPublishersSort = 'new'; } // make new the default
switch($searchPublishersSort)
{
	case 'rel'	: 	$sortField = 'recordID';		$sortLabel = 'most relevant';	$ascLabel = 'by least relevant';	$descLabel = 'by most relevant';
					$sortFunction = 'sortRelNew';
					break;
	case 'new'	:	$sortField = 'recordID'; 		$sortLabel = 'newest';			$ascLabel = 'by oldest'; 			$descLabel = 'by newest';
					if($searchPublishersOrder == 'asc') { $sortFunction = 'sortOld'; } 			else { $sortFunction = 'sortNew'; }
					break;
	case 'titles' :	$sortField = 'numPublished';	$sortLabel = 'titles';			$ascLabel = 'by fewest titles'; 	$descLabel = 'by most titles'; 
					if($searchPublishersOrder == 'asc') { $sortFunction = 'sortWorstRelNew'; } 	else { $sortFunction = 'sortBestRelNew'; }
					break;
	case 'abc'  :	$sortField = 'Company Name';	$sortLabel = 'alphabetically'; 	$ascLabel = 'alphabetically'; 		$descLabel = 'alphabetically'; 		
					if($searchPublishersOrder == 'asc') { $sortFunction = 'sortAbcRelNew'; } 	else { $sortFunction = 'sortZyxRelNew'; }
					break;
	default		:	$sortField = 'recordID'; 		$sortLabel = 'newest';			$ascLabel = 'by oldest'; 			$descLabel = 'by newest';
					if($searchPublishersOrder == 'asc') { $sortFunction = 'sortOld'; } 			else { $sortFunction = 'sortNew'; }
					break;
}

// HANDLE SORT ORDER - also used in adding sort rules to the find request
if($searchPublishersOrder == NULL)	{	$searchPublishersOrder = 'desc'; 	}
switch($searchPublishersOrder)
{
	case 'asc'		:	$sortOrder = FILEMAKER_SORT_ASCEND; 	break;
	case 'desc'		:	$sortOrder = FILEMAKER_SORT_DESCEND; 	break;
	default			:	$sortOrder = FILEMAKER_SORT_DESCEND; 	break;
}

// PAGE NULL HANDLER
if ( $searchPublishersPage < 1 ) { $searchPublishersPage = 1; }

/* 
CONSTRUCT FIND REQUEST -------------------------------------------------------------------------------------------------
At this point, all user input has been processed. Next, a FileMaker Find Request is constructed using methods from the PHP API
See 'http://www.jsmall.us/apidoc/' for API documentation
*/

/* 
INITIALIZE FIND COMMAND OBJECT
The first step for constructing a find command is always initializing the object, in this case, $findPublishers
The newFindCommand() method is a property of the $fmpubs object, which corresponds to the 'Producers' table in the 'Producers.fmp12 database'
Refer to 'php/connect.php' for this object definition

The newFindCommand() method also requires a parameter specifying the FileMaker Layout - the layout name is specified in 'php/connect.php'
All PHP API interaction with the database revolves around layouts in the FileMaker databases
All fields referenced in the php code must be included on the layout (with access given to the CWP account 'webctr')
*/
$findPublishers 	= $fmpubs->newFindCommand($fmpubsLayout);

/*
SET RANGE (NUMBER OF RESULTS TO BE RETURNED)
The setRange() method determines which portion of the found records to display at a given time
It takes two parameters: skip, and size
skip defines where to start from, which is useful for pagination
size defines the number of results (per page) to display
Logged in users can see more results per page than guest users
The exact values are determined in 'php/settings.php', which accesses the 'dashboard' table in the 'CSR.fmp12' database
*/

$subscriberResultSize = 100;
$maxSize = 500;
$exportMax = 100;
$resultSize = $subscriberResultSize;
if($searchPublishersNumResults == NULL) { $searchPublishersNumResults = $resultSize; }
$skip = ($searchPublishersPage - 1) * $resultSize;
$findPublishers->setRange($skip, $resultSize);
if($thisPage == 'export.php' or $thisPage == 'print.php') 
{ 
	if($searchPublishersNumResults > $exportMax) { $searchPublishersNumResults = $exportMax; }
	$findPublishers->setRange(0, $exportMax); 
}

/*
ADD FIND CRITERIA
the addFindCriterion method (a property of the find request object) is used to narrow a search
It takes two parameters: the database field name and the search terms
Logical operators can be used with search terms for flexibility
Each criterion is only added if the corresponding input from the search form has been set
*/

$findPublishers->addFindCriterion('inDirectory',"*");
if($searchPublishersKeyword != NULL){ $findPublishers->addFindCriterion('directory',"=*$searchPublishersKeyword*");	}

/*
ADD SORT RULE
addSortRule() takes three parameters:
- The first is the field to sort by, which is determined above based on the user input
- The second is the priority order - you can assign multiple sort rules, starting from the value '1'
- The third is the sort order (ascending or descending), which must take the form of either FILEMAKER_SORT_DESCEND or FILEMAKER_SORT_ASCEND (not a string)
*/

if 		($sortField == 'recordID') 			
{ $findPublishers->addSortRule('recordID', 1, $sortOrder); 																			}

else if	($sortField == 'numPublished') 
{ $findPublishers->addSortRule('numPublished', 1, $sortOrder); 		$findPublishers->addSortRule('recordID', 2, FILEMAKER_SORT_DESCEND); 	}

else if ($sortField == 'Company Name')
{ $findPublishers->addSortRule('Company Name', 1, $sortOrder); 		$findPublishers->addSortRule('recordID', 2, FILEMAKER_SORT_DESCEND); 	}

else
{ $findPublishers->addSortRule('recordID', 1, FILEMAKER_SORT_DESCEND); } // defaults to showing most recent

// EXECUTE THE FIND	- after all find criteria and sort rules have been defined, the execute() method performs the find
$result = $findPublishers->execute();

/* 
ERROR HANDLER -----------------------------------------------------------------------------------------------------------------
FileMaker returns an error for an empty result set
In the case of searching publishers, this can happen if the user enters criteria that are not met
In the event of a null set, the user should be redirected to a 'No results found' page that allows them to try a new search
*/

if (FileMaker::isError ($result) ) 
{ 
	if($thisPage == 'export.php') { echo $result->getMessage(); exit(); } // for debugging purposes
	$redirect = 'noresults.php';
	$pageTitle = 'No results found';
	require_once 'php/redirect.php'; 
	exit();
}
$records = $result->getRecords(); 	// store the found records in the $records object

// compile a separate array of records to be output in grid view 
// (cannot use $records object because grid output requires access of array elements by index across a nested for loop)
$gridRecords = array();
foreach($records as $record)
{
	require 'php/get-pub.php';
	array_push($gridRecords, $fieldValues);
}

/*
ANALYTICS --------------------------------------------------------------------------------------------------------------------
Once records have been returned, calculate the time taken to perform the search
The start and end points for the range are also determined, used in displaying page navigation feedback in 'php/pagenav.php'
*/
$endTime = microtime(true);
$elapsedTime = round($endTime - $startTime, 3);

$rangeStart = 1 + (($searchPublishersPage - 1) * $resultSize);
$rangeEnd = $resultSize + (($searchPublishersPage - 1) * $resultSize);
$foundcount = $result->getFoundSetCount();
$fetchcount = $result->getFetchCount();
$numPages = ceil($foundcount/$resultSize);
if ( $rangeEnd > $foundcount ) { $rangeEnd = $foundcount; }


/*
STORE SEARCH URL AND PARAMETERS -----------------------------------------------------------------------------------------------
$_SESSION storage is used to contain the user's last search
These values are useful for returning a user to their search results after navigating elsewhere, such as to a review or a content page
*/
if($thisPage != 'noresults.php')
{
	$thisLastSearch = $thisURL;
	$_SESSION['lastSearchType']			= $searchType;
	$_SESSION['lastSearch'] 			= $thisLastSearch;
	$_SESSION['lastSearchPublishers'] 	= $thisLastSearch;
	$_SESSION['lastQueryPublishers'] 	= $thisQuery;
	$_SESSION['lastKeywordPublishers']	= $searchPublishersKeyword;
}

// CALCULATE SUMMARY STRING
if($foundcount > 0) 
{ 
	require_once 'php/results-summary.php'; // calculate summary string to display as heading in results section
	require_once 'php/pagenav-calc.php'; 	// calculates the url for first/prev/next/last pages based on current url string
} 

?>