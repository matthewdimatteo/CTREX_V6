<?php
/*
export.php
By Matthew DiMatteo, Children's Technology Review

This file exports search results in .tab or .csv format
*/
$pageTitle 	= 'CTREX Home';			// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/document.php' not to include file 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page
require_once 'php/velvet-rope.php';	// prevent guest access

// GET INPUT PARAMETERS
$format = test_input($_GET['format']); 	// get the format (tab or csv)
$type	= test_input($_GET['type']);	// get the type of export (search results, bookmarks, MARC format)

if($format == NULL) { $format = 'csv'; } // default to .csv if format not specified

// REVIEW SEARCH RESULTS - export search results for a list of reviews
if($type == 'reviews')
{
	require_once 'php/find-reviews.php';// performs FM find request for reviews
	require 'php/results-compile.php'; 	// process search results
}

// BOOKMARKS - export a user's saved bookmarks
else if($type == 'bookmarks')
{
	if($numSavedBookmarks > 0)
	{
		require 'php/find-bookmarks.php';	// lookup the user's saved bookmarks
		require 'php/results-compile.php'; 	// process search results
		$exportFilename = 'ctrex-bookmarks-'.$username;
	} // end if $numSavedBookmarks > 0
	else
	{
		require 'php/redirect.php';
		exit();
	}
} // end if $type == 'bookmarks'

// MARC - export a single review in MARC format
else if($type == 'marc')
{
	require_once 'php/load-review.php';		// lookup the review by its recordID and get its field values
	
	if($rated == true) 		{ $scoreText = $score.'%'; } // format score text (boolean $rated is determined in 'php/get-review.php')
	
	// add denotations for awards
	if($edChoice != NULL) 	{ $edChoiceText = 'CTR Editor\'s Choice'; } 		else { $edChoiceText 	= ''; }
	if($ethical != NULL)	{ $ethicalText	= 'CTR Ethical Seal of Approval'; }	else { $ethicalText 	= ''; }
	
	// declare the fields to include in the data set
	$marcFields = array
	(
		array('Title'		, $title), 
		array('Publisher'	, $company),
		array('Copyright'	, $copyright),
		
		array('Price'		, $price), 
		array('Platforms'	, $platforms),
		array('Filesize'	, $fileSize),
		
		array('Age Range'	, $ages),
		array('Grade Level'	, $grades),
		array('Subjects'	, $subjects),
		array('Tagged for:'	, $topics),
		
		array('Date of Review'		, $dateEntered),
		array('Reviewed by'			, $authorName),
		array('Feature/New Release'	, $reviewType),
		
		array('CTR Issue'	, $issue),
		array('CTR Weekly'	, $weekly),
		
		array('Rating'		, $scoreText),
		array('Award'		, $edChoiceText),
		array('Award'		, $ethicalText),
		
		array('iTunes Link'	, $linkItunes),
		array('Android Link', $linkAndroid),
		array('Amazon Link'	, $linkAmazon),
		array('Steam Link'	, $linkSteam),
		array('Video Link'	, $linkVideo),
		array('CTREX Link'	, $reviewLink),
		
		array('Disclaimer'	, 'Copyright '.$year.' Children\'s Technology Review. All Rights Reserved.')
	);
	$recordsToExport = array();// declare an array to contain the field label/value pairs
	
	// only include fields that have values
	foreach($marcFields as $marcField)
	{
		$marcFieldLabel = $marcField[0];
		$marcFieldValue = $marcField[1];
		if($marcFieldValue != NULL) { array_push($recordsToExport, array($marcFieldLabel, $marcFieldValue)); }
	}
	$exportFilename = 'review-'.$reviewID.'-'.$title.'-marc'; // set filename
	
	// DEBUG OUTPUT
	/*
	echo '$thisURL: '.$thisURL; echo '<br/>'; echo '$exportFilename: '.$exportFilename.'<br/>';
	echo '$fieldValues: '.$fieldValues.' ('.count($fieldValues).')<br/>';
	//echo '$searchResults: '.$searchResults.' ('.count($searchResults).')<br/>';
	echo '$recordsToExport: '.$recordsToExport.' ('.count($recordsToExport).')<br/>';
	foreach($recordsToExport as $rte) { echo $rte[0].': '.$rte[1].'<br/>'; }
	exit();
	*/
} // end if $type == 'marc'
else if($type == 'usage')
{
	$recordsToExport 	= $_SESSION['totalViewsArray']; // get the stored totalViewsArray (constructed and stored in 'php/profiles/license/section-usage.php')
	$exportFilename 	= 'ctrex-usage-report-site'.$siteName;
} // end if $type == 'usage'

// OTHER - if type none of the above, redirect home
else
{
	$redirect = $lastSearch;
	require_once 'php/redirect.php';
	exit();
} // end else $type none of above

// FORMAT FILENAME
if($exportFilename == NULL) { $exportFilename = 'ctrex-export'; } // null handler

// parse out commas from filename
$commaCount = substr_count($exportFilename, ',');
$exportFilename = str_replace ( ',', '-', $exportFilename, $commaCount);

// parse out spaces from filename
$spaceCount = substr_count($exportFilename, ' ');
$exportFilename = str_replace ( ' ', '+', $exportFilename, $spaceCount );

// EXPORT THE FILE
$export = $recordsToExport;
ob_clean();
header("Content-type: text/x-".$format);
header("Content-Transfer-Encoding: binary");
header("Content-Disposition: attachment; filename=".$exportFilename."-".date("Y-m-d").".".$format); // add the current date and the file extension
header("Pragma: no-cache");
header("Expires: 0");
$file = fopen('php://temp/maxmemory:'. (12*1024*1024), 'r+'); // 128MB
fputcsv($file, array_keys(call_user_func_array('array_merge', $array)));
foreach($export as $row) { fputcsv($file, $row); }
rewind($file);
$output = stream_get_contents($file);
fclose($file);
echo $output;
die();
?>