<?php
/*
php/get-archive.php
By Matthew DiMatteo, Children's Technology Review

This file gets the field values for an archived monthly or weekly record in the database 'subbies.fmp12'
It is included in the file 'php/find-archive.php'

*/

// tell 'php/get-field.php' which array of fields to use (defined in 'php/fields.php') based on whether searching monthlies or weeklies
if		($searchArchiveType == 'monthly') 	{ $fields = $monthlyFields; } 
else if	($searchArchiveType == 'weekly') 	{ $fields = $weeklyFields; }
else if	($searchArchiveType == 'articles') 	{ $fields = $articleFields; }
foreach($fields as $field) { require 'php/get-field.php'; } // get all of the field values and assign to variables

if($searchArchiveType != 'articles')
{

	// get the list of titles for each monthly or weekly
	if($numTitles > 0) 
	{ 
		$titles = $record->getRelatedSet('CSR'); 
		$relatedTitleN = 0;
		foreach($titles as $thisTitle)
		{
			$titleID	= $thisTitle->getField('CSR::reviewnumber');
			$titleName 	= $thisTitle->getField('CSR::Title');

			// get the image and review link for the first title for the grid view of weeklies
			$relatedTitleN += 1;
			if($relatedTitleN == 1)
			{
				$firstImg 		= $thisTitle->getField('CSR::Sample Screen');
				$firstImgData	= $thisTitle->getField('CSR::imgData');
				$firstTitle		= $titleName;
				$firstTitleID	= $titleID;
				$firstTitleLink	= 'review.php?id='.$firstTitleID;
			} // end if n == 1
		} // end foreach
	} // end if $numTitles > 0

	// if no titles, set values to null to avoid empty item inheriting previous item's values
	else
	{
		$firstImg 		= '';
		$firstImgData	= '';
		$firstTitle		= '';
		$firstTitleID	= '';
		$firstTitleLink	= '';
	}

	// append $fieldValues array for reference in grid output
	array_push($fieldValues, array('firstImg'		, $firstImg));
	array_push($fieldValues, array('firstImgData'	, $firstImgData));
	array_push($fieldValues, array('firstTitle'		, $firstTitle));
	array_push($fieldValues, array('firstTitleID'	, $firstTitleID));
	array_push($fieldValues, array('firstTitleLink'	, $firstTitleLink));
} // end if !articles

// FOR WEEKLIES
if($searchArchiveType == 'weekly')
{
	// determine the search url for viewing titles in this weekly on the home page
	$weeklySearchURL = 'home.php?weekly='.$weeklyParam.'&page=1';
	array_push($fieldValues, array('weeklySearchURL', $weeklySearchURL));
	
	// get the images and review links for the first 3 titles in the weekly
	if($numTitles > 0)
	{
		$numImages = 0; // counter to determine number of images
		$imageN = 0; // counter to constrain images to 3
		$reviewImages = array(); // declare an array to contain each review's image data
		foreach($titles as $thisTitle)
		{
			$imageN += 1; // increment the constraint counter

			// get the record data only for the first 3
			if($imageN <= 3)
			{
				$title 			= $thisTitle->getField('CSR::Title');
				$titleID		= $thisTitle->getField('CSR::reviewnumber');
				$titleLink		= 'review.php?id='.$titleID;
				$titleImg		= $thisTitle->getField('CSR::Sample Screen');
				$titleImgData	= $thisTitle->getField('CSR::imgData');
				if($titleImgData != NULL and $titleImgData != '?') { $numImages += 1; } // increment the image counter if image is valid
				array_push($reviewImages, array($title, $titleLink, $titleImg, $titleImgData)); // append the record data to the array
			} // end if($imageN <= 3)
		} // end foreach title
	} // end if($numTitles > 0)
} // end if type == weekly
?>