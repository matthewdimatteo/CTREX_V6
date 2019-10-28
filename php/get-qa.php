<?php
/*
php/get-qa.php
By Matthew DiMatteo, Children's Technology Review

This file gets the values for each Quality Attribute (or QA) of a rubric and stores the data in an array
It also calculates the corresponding field names in the CSR table for each QA and gets the value of those fields to display detailed product ratings
The overall score for each rubric is calculated as this file increments $ptsEarned and $ptsPossible
*/
$qaN 			= -1;
$qaData			= array();
$ptsEarned		= 0;
$ptsPossible	= 0;
foreach($qaSet as $qaRecord)
{
	$qaN += 1; // increments the array of qa data
	
	$qaName 		= $qaRecord->getField('qa::name');
	$qaType 		= $qaRecord->getField('qa::type');
	$qaDescriptor 	= $qaRecord->getField('qa::descriptor');
	$qaField 		= $qaRecord->getField('qa::ratingField');
	$qaWeight 		= $qaRecord->getField('qa::ratingWeight');
	
	$qaDescriptor = parseLinks($qaDescriptor); 	// php function in 'php/functions.php' adds hyperlinks to text
	$qaWeight *= 10;							// scale to 1-100 scale
	
	if($pageType != 'content' and $editType != 'new')
	{
		// calculate field names of the corresponding rating and weight fields in the CSR table
		$nStart 		= strlen('rating');
		$fieldNumber 	= substr($qaField, $nStart, 2);
		$qaRatingNumber = 'rating'.$fieldNumber;
		$qaWeightNumber = 'weight'.$fieldNumber;
		
		// FOR POST (EXPERTREVIEW OR COMMENT)
		if($evalType == 'post')
		{
			$csrRating 		= $relatedRecord->getField($ratingTable.'::'.$qaRatingNumber)/10;
			$csrWeight 		= $relatedRecord->getField($ratingTable.'::'.$qaWeightNumber)/10;
		}
		
		// FOR CTR RATING
		else
		{
			// get the corresponding CSR fields for rating and weight
			$csrRating 		= $reviewRecord->getField($qaRatingNumber);
			$csrWeight 		= $reviewRecord->getField($qaWeightNumber);
		}
		
		$weightedRating = $csrWeight * $csrRating;

		// increment the pts possible, pts earned
		//$ptsEarned		+= $csrRating;
		$ptsEarned 		+= $weightedRating;
		$ptsPossible 	+= $csrWeight;
	} // end if $pageType != content
	
	$qaData[$qaN] = array($qaName, $qaType, $qaDescriptor, $qaField, $qaWeight, $csrRating, $csrWeight, $weightedRating);
} // end foreach qa
?>