<?php
/*
php/results-compile.php
By Matthew DiMatteo, Children's Technology Review

This file generates an array of record data for inclusion on the print and export pages
It is included in 'export.php' and 'php/content-print.php'
*/

// REVIEWS
if($type == 'reviews')
{
	// determine name of array containing search results based on sort type (refer to 'php/find-reviews.php' for each array construction)
	if($searchReviewsSort == 'rel') { $searchResults = $recordsToSort; } 	// special algorithm for sorting by relevance
	else 							{ $searchResults = $gridRecords; } 		// default algorithm compiles array for displaying results as grid
}

// BOOKMARKS
else if($type == 'bookmarks') 		{ $searchResults = $bookmarkRecords; $exportMax = 100; } // $bookmarkRecords compiled in 'php/find-bookmarks.php'

if($exportMax == NULL) { $exportMax = 100; } // null handler to set export max size to 100 records

// COMPILE DATA TO BE EXPORTED
$recordsToExport = array(); // declare an array to contain records to export
$exportN = 1; 				// counter for the export array
foreach($searchResults as $item)
{
	if($exportN <= $exportMax)
	{
		if($searchReviewsSort == 'rel') { $item = $item['fields']; }
		require 'php/get-vars.php'; // assign dynamic variable names
		
		// format score text
		if($score != NULL and $score != 0 and $score != '0') { $score .= '%'; } else { $score = ''; }
		if($edChoice != NULL) { $score .= '*'; $title .= '*'; }
		
		// format review link
		$reviewLink = 'https://reviews.childrenstech.com/ctr/review.php?id='.$reviewnumber;
		
		// declare the fields to include in the data set
		$dataFields = array
		(
			array('#'			, $exportN), 
			array('Date'		, $dateEntered), 
			array('Title'		, $title), 
			array('Rating'		, $score), 
			array('Age Range'	, $ages),
			array('Teaches'		, $subjects),
			array('Platforms'	, $platforms),
			array('Price'		, $price), 
			array('Publisher'	, $company)
		); 
		// make the first row the field names
		if($exportN == 1)
		{
			$dataLabels = array();
			foreach($dataFields as $thisData)
			{
				$thisDataLabel = $thisData[0];
				array_push($dataLabels, $thisDataLabel);
			}
			array_push($recordsToExport, $dataLabels); 	
		} // end if($exportN == 0)
		
		// add the record data for each row
		$exportN += 1;				// increment the export array counter
		$recordData = array();		// declare an array to contain data for this record
		foreach($dataFields as $thisData) 
		{ 
			$thisDataValue = $thisData[1];
			array_push($recordData, $thisDataValue); // append each field to the array of record data
		} 	
		array_push($recordData, $reviewLink); 		 // add the review link as separate from fields (so it won't display as column)
		array_push($recordsToExport, $recordData);	 // append this record data to the array of all records to export
	} // end if $exportN <= $exportMax
} // end foreach($searchResults as $item)
?>