<?php
require_once 'php/fields.php';
//require_once 'php/find-function.php';
?>
<div class = "page-header">Test</div>
<div class = "full-width">
<?php

//$testType = 'reviews';
$testType = 'profiles';

// TEST REVIEWS -------------------------------------------------------------------------------------------

// DEBUG PARAM VALUES
$searchReviewsDrafts	= false;
//$searchReviewsKeyword 	= 'zelda';
//$searchReviewsAge 		= 'E';
$searchReviewsAgeField	= 'ageCodes';
$searchReviewsSubject	= 'Math';
$searchReviewsPlatform	= 'Android';
//$searchReviewsTopic		= 'Pioneer';
//$searchReviewsPublisher	= 'Fox and Sheep GmbH';
$searchReviewsIssue 	= '';
$searchReviewsWeekly 	= '';
$filterCurrent			= true;
$filterRated			= false;
$filterAwards			= false;
$filterFeature			= false;
$filterNewrelease		= false;
$filterFree				= false;
$filterVideos			= false;
$filterImages			= false;
$filterComments			= false;

// ARRAY OF CRITERIA (value, parameter)
$findReviewCriteria = array
(
	array($searchReviewsDrafts		, array('published'				, '*')),
	array($searchReviewsKeyword		, array('deepsearch'			, '=*'.$searchReviewsKeyword.'*')),
	array($searchReviewsAge			, array($searchReviewsAgeField, '=*'.$searchReviewsAge.'*')),
	array($searchReviewsSubject		, array('teaches text'			, '=*'.$searchReviewsSubject.'*')),
	array($searchReviewsPlatform	, array('platform text'			, '=*'.$searchReviewsPlatform.'*')),
	array($searchReviewsTopic		, array('recommendations'		, '=*'.$searchReviewsTopic.'*')),
	array($searchReviewsPublisher	, array('Company'				, '==*'.$searchReviewsPublisher.'*')),
	array($searchReviewsIssue		, array('issueAbbr'				, '=*'.$searchReviewsIssue.'*')),
	array($searchReviewsWeekly		, array('weekly'				, '==*'.$searchReviewsWeekly.'*')),
	array($filterCurrent			, array('Date of Review'		, '>'.$currentSet)),
	array($filterRated				, array('rubricStars'			, '>0')),
	array($filterAwards				, array('whereisit'			, '=Editor\'s Choice')),
	array($filterFeature			, array('Feature review'		, '=*Feature*')),
	array($filterNewrelease			, array('Feature review'		, '=*New*')),
	array($filterFree				, array('Price'				, '=*free*')),
	array($filterVideos				, array('video'				, '*')),
	array($filterImages				, array('imgData'				, '*')),
	array($filterComments			, array('commentCountText'	, '>0')),
);

// CONSTRUCT ARRAY OF PARAMS TO FEED INTO FUNCTION
$findReviewParams = array();
foreach($findReviewCriteria as $criterion)
{
	$criterionValue = $criterion[0];
	$criterionParam	= $criterion[1];
	if($criterionValue != NULL) { array_push($findReviewParams, $criterionParam); }
}

/*
// this block does the same thing as the foreach($findReviewCriteria as $criterion) loop above, but the loop is more efficient
if($searchReviewsDrafts != true)	{ array_push($findReviewParams, array('published'			, '*')); 								}
if($searchReviewsKeyword != NULL)	{ array_push($findReviewParams, array('deepsearch'			, '=*'.$searchReviewsKeyword.'*'));		}
if($searchReviewsAge != NULL) 		{ array_push($findReviewParams, array($searchReviewsAgeField, '=*'.$searchReviewsAge.'*')); 		} 	
if($searchReviewsSubject != NULL) 	{ array_push($findReviewParams, array('teaches text'		, '=*'.$searchReviewsSubject.'*'));		}
if($searchReviewsPlatform != NULL) 	{ array_push($findReviewParams, array('platform text'		, '=*'.$searchReviewsPlatform.'*'));	}
if($searchReviewsTopic != NULL)		{ array_push($findReviewParams, array('recommendations'		, '=*'.$searchReviewsTopic.'*'));		}
if($searchReviewsPublisher != NULL)	{ array_push($findReviewParams, array('Company'				, '==*'.$searchReviewsPublisher.'*'));	}
if($searchReviewsIssue != NULL)		{ array_push($findReviewParams, array('issueAbbr'			, '=*'.$searchReviewsIssue.'*'));		}
if($searchReviewsWeekly != NULL)	{ array_push($findReviewParams, array('weekly'				, '==*'.$searchReviewsWeekly.'*'));		}
if($filterCurrent == true)			{ array_push($findReviewParams, array('Date of Review'		, '>'.$currentSet));					}
if($filterRated == true)			{ array_push($findReviewParams, array('rubricStars'			, '>0'));								}
if($filterAwards == true)			{ array_push($findReviewParams, array('whereisit'			, '=Editor\'s Choice'));				}
if($filterFeature == true)			{ array_push($findReviewParams, array('Feature review'		, '=*Feature*'));						}
if($filterNewrelease == true)		{ array_push($findReviewParams, array('Feature review'		, '=*New*'));							}
if($filterFree == true)				{ array_push($findReviewParams, array('Price'				, '=*free*'));							}
if($filterVideos == true)			{ array_push($findReviewParams, array('video'				, '*'));								}
if($filterImages == true)			{ array_push($findReviewParams, array('imgData'				, '*'));								}
if($filterComments == true)			{ array_push($findReviewParams, array('commentCountText'	, '>0'));								}
*/

$findReviewSortRules = array
(
	array('reviewnumber', FILEMAKER_SORT_DESCEND)
);

// VALUES FOR THE FUNCTION PARAMETERS
if($testType == 'reviews')
{
	$database		= 'CSR';
	$layout			= $fmreviewsLayout;
	$skip			= 0;
	$range			= 10;
	$params			= $findReviewParams;
	$sortRules		= $findReviewSortRules;
	//$errorRedirect 	= 'home.php';
	$getFirst		= false;
	$fields 		= $reviewFields;
	$relatedSets 	= '';
}


// TEST PROFILES ---------------------------------------------------

if($testType == 'profiles')
{
	//$inputType = 'subscriber';
	//$inputType = 'publisher';
	$inputType = 'license';
	switch($inputType)
	{
		case 'subscriber' 	: 
			$database 	= 'subbies';
			$layout		= $fmsubsLayout;
			$fmField	= 'globalID';
			$testUserID	= 78977;
			$fields		= $subscriberFields;
			$relatedSets = array
			(
				array('faves'	, $favesFields)
			);
			break;
		case 'publisher'	:
			
			$database	= 'Producers';
			$layout		= $fmpubsLayout;
			$fmField	= 'recordID';
			$testUserID = 5017;
			$fields		= $publisherFields;
			$relatedSets = array(array('CSR', $reviewFields));
			break;
		case 'license'		: 
			
			$database 	= 'subbies';
			$layout		= $fmorgsLayout;
			$fmField	= 'siteName';
			$testUserID	= 'ctr';
			$fields		= $licenseFields;
			$relatedSets = array(array('subs', $subscriberFields));
			break;
	} // end switch($type)

	$skip			= '';
	$range			= '';
	$params			= array ( array($fmField, '=='.$testUserID) );
	$sortRules		= '';
	//$errorRedirect 	= 'home.php';
	$getFirst		= true;
} // end if $testType == 'profiles'

// FIND RECORDS USING THE FUNCTION
$output = fmFind($database, $layout, $getFirst, $skip, $range, $params, $sortRules, $errorRedirect, $fields, $relatedSets);
$testRecordN = 0;
//echo '$output = '.$output.'<br/><br/>';
//foreach($output as $outputItem) { echo $outputItem.'<br/>'; } echo '<br/>';

// OUTPUT FIRST RECORD
if($getFirst == true)
{
	$testRecordData			= $output;
	$testRecordFields 		= $testRecordData[0];
	$testRecordRelatedSets 	= $testRecordData[1];
	$testRecordN += 1;
	echo 'Result #'.$testRecordN.': ';
	foreach($testRecordFields as $field)
	{
		$varName  = $field[0];
		$varValue = $field[2];
		$$varName = $varValue;
		if($testType == 'profiles') { echo '$varName: '.$varName.' = '.$$varName.'<br/>'; }
	}
	if($testType == 'reviews') { echo 'Record #'.$reviewnumber.'. '.$title.'<br/>'; }
	//if($testType == 'profiles') { echo 'profiles'; }
	if($testRecordRelatedSets != NULL)
	{
		echo '<br/>$testRecordRelatedSets: '.$testRecordRelatedSets.'<br/>';
		$numRelatedSets = count($testRecordRelatedSets);
		echo '$numRelatedSets: '.$numRelatedSets.'<br/><br/>';
		foreach($testRecordRelatedSets as $testRecordRelatedSet)
		{
			$tableName 		= $testRecordRelatedSet[0];
			$relatedRecords = $testRecordRelatedSet[1];
			$numRelatedRecords = count($relatedRecords);
			echo '$tableName: '.$tableName.'<br/>';
			if($relatedRecords != NULL)
			{
				echo '$relatedRecords: '.$relatedRecords.'<br/>';
				echo '$numRelatedRecords: '.$numRelatedRecords.'<br/><br/>';
				$relatedRecordsN = 0; 
				foreach($relatedRecords as $relatedRecord)
				{
					$relatedRecordsN += 1;
					echo 'Related Record #: '.$relatedRecordsN.'<br/>';
					foreach($relatedRecord as $field)
					{
						
						$varName  	= $field[0];
						$fieldName 	= $field[1];
						$varValue 	= $field[2];
						$$varName 	= $varValue;
						echo '$varName: '.$varName.' = '.$$varName.'<br/>';
					}  // end foreach $relatedRecord $field
					echo '</br>';
				} // end foreach $relatedRecord
			} // end if($relatedRecords != NULL)
		} // end foreach $testRecordRelatedSet
	} // end if($testRecordRelatedSets != NULL)
} // end if($getFirst == true)

// OUTPUT AN ARRAY OF RECORDS
else
{
	foreach($output as $testRecordData)
	{
		$testRecordFields 		= $testRecordData[0];
		$testRecordRelatedSets 	= $testRecordData[1];
		$testRecordN += 1;
		echo 'Result #'.$testRecordN.': ';
		foreach($testRecordFields as $field)
		{
			$varName  = $field[0];
			$varValue = $field[2];
			$$varName = $varValue;
			//echo '$varName: '.$varName.' = '.$$varName.'<br/>';
		}
		if($testType == 'reviews') { echo 'Record #'.$reviewnumber.'. '.$title.'<br/>'; }
		if($testType == 'profiles') { echo 'profiles'; }
	} // end foreach $testRecord
} // end else getFirst == false
?>
</div><!-- /.full-width -->