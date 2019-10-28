<?php
/*
php/find-bookmarks.php
By Matthew DiMatteo, Children's Technology Review

This file looks up a user's savedbookmarks from the 'savedbookmarks' table in the 'subbies.fmp12' database file
It is included in 'export.php', 'php/content/content-savedbookmarks.php'
*/

// require a userID to be specified - redirect away if not
if($userID == NULL) 
{
	$redirect = $lastSearch;
	require_once 'php/redirect.php';
	exit();
}

// require the user to have at least 1 saved bookmark to perform find request
if($numSavedBookmarks > 0)
{
	// construct and execute a find request to look up all bookmarks with the current user's id
	$findBookmarks = $fmsavedbookmarks->newFindCommand($fmsavedbookmarksLayout);
	$findBookmarks->addFindCriterion('userID', '=='.$userID);
	$result = $findBookmarks->execute();
	if (FileMaker::isError ($result) )
	{
		echo $result->getMessage(); exit();
	}
	$records = $result->getRecords();

	// construct an array of record data
	$bookmarkRecords = array(); // declare an array to contain bookmark record values
	$fields = $bookmarkFields; // tell 'php/get-field.php' to use $bookmarkFields array (defined in 'php/fields.php')
	foreach($records as $record)
	{
		require 'php/get-field.php'; // get field values
		array_push($bookmarkRecords, $fieldValues); // add field values to array of bookmarks
	} // end foreach record
} // end if $numSavedBookmarks > 0
?>