<?php
/*
php/find-archive.php
By Matthew DiMatteo, Children's Technology Review

This file is included in the file 'document.php' for the page 'archive.php' where $pageType == 'search' and $searchType == 'archive'
It processes search field input, uses it to construct a find request via the FileMaker PHP API, and returns an array of publisher record data

*/
$startTime = microtime(true); // start a timer for calculating the speed of the search

/* 
GET FORM INPUT VALUES -----------------------------------------------------------------------------------------------
Get the values from each of the search form inputs - these are specified in the file 'php/search-form-archive.php'
*/
$searchArchiveType 		= test_input($_GET['type']);
$searchArchiveKeyword 	= test_input($_GET['keyword']);
$searchArchiveSort		= test_input($_GET['sort']);
$searchArchiveOrder		= test_input($_GET['order']);
$searchArchivePage		= test_input($_GET['page']);

if($searchArchiveType == NULL) { $searchArchiveType = 'monthly'; }

// HANDLE SORT ORDER - also used in adding sort rules to the find request
if($searchArchiveOrder == NULL)	{	$searchArchiveOrder = 'desc'; 	}
switch($searchArchiveOrder)
{
	case 'asc'		:	$sortOrder = FILEMAKER_SORT_ASCEND; 	break;
	case 'desc'		:	$sortOrder = FILEMAKER_SORT_DESCEND; 	break;
	default			:	$sortOrder = FILEMAKER_SORT_DESCEND; 	break;
}

// PAGE NULL HANDLER
if ( $searchArchivePage < 1 ) 	{ $searchArchivePage = 1; }
if($velvetRope == true) 		{ $searchArchivePage = 1; }

// # RESULTS PER PAGE
$guestResultSize		= 3;
$subscriberResultSize 	= 12;
if($velvetRope == true) { $resultSize = $guestResultSize; } else { $resultSize = $subscriberResultSize; }
$skip = ($searchArchivePage - 1) * $resultSize;

/* 
CONSTRUCT FIND REQUEST -------------------------------------------------------------------------------------------------
At this point, all user input has been processed. Next, a FileMaker Find Request is constructed using methods from the PHP API
See 'http://www.jsmall.us/apidoc/' for API documentation
*/

/* 
INITIALIZE FIND COMMAND OBJECT
The first step for constructing a find command is always initializing the object, in this case, $findArchive
The newFindCommand() method is a property of the $fmpubs object, which corresponds to the 'Producers' table in the 'Producers.fmp12 database'
Refer to 'php/connect.php' for this object definition

The newFindCommand() method also requires a parameter specifying the FileMaker Layout - the layout name is specified in 'php/connect.php'
All PHP API interaction with the database revolves around layouts in the FileMaker databases
All fields referenced in the php code must be included on the layout (with access given to the CWP account 'webctr')
*/

// MONTHLIES
if($searchArchiveType == 'monthly')
{
	$findArchive = $fmmonthly->newFindCommand($fmmonthlyLayout);
		$findArchive->setRange($skip, $resultSize);
		if($searchArchiveKeyword != NULL) { $findArchive->addFindCriterion('searchField', "=*$searchArchiveKeyword*"); }
	$findArchive->addFindCriterion('issues::active', "*");
		
	$findArchive->addSortRule('year', 1, FILEMAKER_SORT_DESCEND); 
	$findArchive->addSortRule('month', 2, FILEMAKER_SORT_DESCEND);
} // end if monthlies

// WEEKLIES
else if($searchArchiveType == 'weekly')
{
	$findArchive = $fmweekly->newFindCommand($fmweeklyLayout);
		$findArchive->setRange($skip, $resultSize);
		if($searchArchiveKeyword != NULL) { $findArchive->addFindCriterion('searchField', "=*$searchArchiveKeyword*"); }
	$findArchive->addFindCriterion('active', "*");
	$findArchive->addSortRule('weeklyDate', 1, FILEMAKER_SORT_DESCEND); 
} // end if weeklies

else if($searchArchiveType == 'articles')
{
	$findArchive = $fmarticles->newFindCommand($fmarticlesLayout);
	$findArchive->addFindCriterion('url', '*');
	$findArchive->addSortRule('recordID', 1, FILEMAKER_SORT_DESCEND);
	$result = $findArchive->execute();
} // end if archive

$result = $findArchive->execute();
if(FileMaker::isError($result)) 
{ 
	$redirect = 'noresults.php';
	$pageTitle = 'No results found';
	require_once 'php/redirect.php'; 
	exit();
}
$records = $result->getRecords();

// compile a separate array of records to be output in grid view 
// (cannot use $records object because grid output requires access of array elements by index across a nested for loop)
$gridRecords = array();
foreach($records as $record)
{
	require 'php/get-archive.php';
	array_push($gridRecords, $fieldValues);
}

/*
ANALYTICS --------------------------------------------------------------------------------------------------------------------
Once records have been returned, calculate the time taken to perform the search
The start and end points for the range are also determined, used in displaying page navigation feedback in 'php/pagenav.php'
*/
$endTime = microtime(true);
$elapsedTime = round($endTime - $startTime, 3);

$rangeStart = 1 + (($searchArchivePage - 1) * $resultSize);
$rangeEnd = $resultSize + (($searchArchivePage - 1) * $resultSize);
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
	$_SESSION['lastSearchType']		= $searchType;
	$_SESSION['lastSearch'] 		= $thisLastSearch;
	$_SESSION['lastSearchArchive'] 	= $thisLastSearch;
	$_SESSION['lastQueryArchive'] 	= $thisQuery;
	$_SESSION['lastKeywordArchive']	= $searchArchiveKeyword;
}

// CALCULATE SUMMARY STRING
if($foundcount > 0) 
{ 
	require_once 'php/results-summary.php'; // calculate summary string to display as heading in results section
	require_once 'php/pagenav-calc.php'; 	// calculates the url for first/prev/next/last pages based on current url string
} 