<?php
/*
functions.php
By Matthew DiMatteo, Children's Technology Review

This file contains custom php functions utilized in CTREX - it is included in the 'autoload.php' file that is included in every page
*/

// FILTER FORM INPUT -----------------------------------------------------------------------------------------------------------
function test_input($input)
{
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
} // end test_input()

// DETERMINE WHETHER NUMBER IS ODD OR EVEN
function oddEven($number)
{
	$lastDigit = substr($number, -1, 1);
	if($lastDigit == 1 or $lastDigit == 3 or $lastDigit == 5 or $lastDigit == 7 or $lastDigit == 9) { $oddEven = 'odd'; } else { $oddEven = 'even'; }
	return ($oddEven);
}

// APPEND HTTP TO EXTERNAL LINKS
function convertURL($url)
{
	if((substr_count($url, 'https://') > 0) or (substr_count($url, 'http://') > 0))	{ $url = $url; }
	else { $url = 'http://'.$url; }
	return($url);
}
		
// TRIM TEXT
function trimText($text, $max)
{
	if(strlen($text) > $max) { $text = substr($text, 0, $max).'...'; } 
	else { $text = $text; }
	return($text);
}

// CONVERT COMMAS TO LINE BREAKS
function comma2nl($text)
{
	if($text != NULL)
	{
		$text = str_replace(', ', "\r", $text);
	}
	return($text);
}

// CONVERT LINE BREAKS TO COMMAS
function nl2comma($text)
{
	if($text != NULL)
	{
		$text 		= str_replace("\r", ', ', $text);
		$length 	= strlen($text);
		$lastChar 	= substr($text, -1, 1);
		$lastChars 	= substr($text, -2, 1);
		if($lastChar == ',') 	{ $text = substr($text, 0, $length-1); }
		if($lastChars == ',') 	{ $text = substr($text, 0, $length-2); }
	}
	return($text);
}

// ADD ITEM TO COMMA SEPARATED LIST
function addToList($list, $newItem, $valueList)
{
	$newList = $list;
	if($list != NULL)
	{
		// if the list is comprised of only the new item, just set the list to the new item value
		if($list == $newItem)
		{
			$newList = $newItem;
		}
		// if the list is comprised of at least one other value besides the new item, append the new item with comma separation
		else
		{
			$listItems = explode(', ', $list); // break string of list items into an array
			$listItemsOrig = $listItems;
			$itemsAdded = array();
			
			// only append if there is an item to add
			if($newItem != NULL)
			{
				// check each value in new items against list - only add if not already on list
				$newItems = explode(', ', $newItem); // break new item string into an array
				foreach($newItems as $thisNewItem)
				{
					// only append the new item if not already on list
					if(!in_array($thisNewItem, $listItems))
					{ 
						$newList .= ', '.$thisNewItem;
						array_push($listItems, $thisNewItem); 
						array_push($itemsAdded, $thisNewItem); 
					} // end if	!in_array($thisNewItem, $listItems)			
				} // end foreach new item
			} // end if $newItem
			
			// if no new items to add, just declare empty $newItems array
			else
			{ 
				$newItems = array();
			}
			
			// check for deleted values from new items and remove from list
			//$listItemsCopy = $listItems; // create a copy of the original list items array to compare against later
			$itemsRemoved 	= array();
			$itemsKept 		= array();
			foreach($listItems as $thisListItem)
			{
				// if list items includes a value that is not on the value list and not in the new items, it is a deleted new item
				if(!in_array($thisListItem, $valueList) and !in_array($thisListItem, $newItems))
				{
					// can't use str_replace, because of false positives (e.g. TV, Apple TV) - must remove item from array and then unexplode to recreate string
					$key = array_search ($thisListItem, $listItems); // find the position of the value in the array of list items
					if($key !== false) { unset($listItems[$key]); } // remove that value
					array_push($itemsRemoved, $thisListItem);
				} // end if !in_arrays
				else
				{
					array_push($itemsKept, $thisListItem);
				}
			} // end foreach list item
			$newList = implode(', ', $listItems); // reconstruct string from duplicate array of list items
			/*
			$newList = 
			'<br/>listItemsOrig: '.implode(', ', $listItemsOrig).'<br/>'.
			'$newItems: '.implode(', ', $newItems).'<br/>'.
			'$itemsAdded: '.implode(', ', $itemsAdded).'<br/>'.
			'$itemsKept: '.implode(', ', $itemsKept).'<br/>'.
			'$itemsRemoved: '.implode(', ', $itemsRemoved).'<br/>'.
			'$newList: '.implode(', ', $listItems).'<br/>'
			;
			*/
		} // end else
	} // end if $list
	else { $newList = $newItem; } // if the list is comprised of only the new item, just set the list to the new item value
	return($newList);
} // end function addToList()

// SORT FUNCTIONS FOR RANKED SEARCH RESULTS BY RELEVANCE -------------------------
// format text to be compatible with string comparison functions
function cleanText($text)
{
	$text = strtolower($text);
	//$text = iconv('utf-8', 'ascii//TRANSLIT', $text);
	$text = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($text));
	$text = preg_replace("#[[:punct:]]#", "", $text);
	return ($text);
}

// GET TEXT AS AN ARRAY OF WORDS
function getTextArray($text)
{
	$numWords = str_word_count($text, 0, '1234567890');
	if($numWords > 1) { $wordsArray = explode(' ', $text); } else { $wordsArray = array($text); $word = $text; }
	return(array('words'=>$wordsArray, 'wordcount'=>$numWords, 'word'=>$word));
}

// GET LIST ITEMS
function getListItems($record, $field, $size)
{
	$listItemsArray = array();
	for($li = 0; $li <= $size; $li ++)
	{
		$thisListItem = $record->getField($field, $li);
		//if($thisListItem != NULL) { array_push($listItemsArray, $thisListItem); }
		array_push($listItemsArray, $thisListItem);
	} // end for
	return($listItemsArray);
}

// RE-SORT SEARCH RESULTS -----------------------------------------------------------------
// MOST RELEVANT [THEN BY NEWEST]
function sortRelNew($a, $b)
{
	if($a['relevance'] == $b['relevance']) 
	{ 
		if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
		return ($a['reviewnumber'] < $b['reviewnumber']) ? 1 : -1;
	}
	return ($a['relevance'] < $b['relevance']) ? 1 : -1;
}
// NEWEST
function sortNew($a, $b)
{
	if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
	return ($a['reviewnumber'] < $b['reviewnumber']) ? 1 : -1;
}
// OLDEST
function sortOld($a, $b)
{
	if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
	return ($a['reviewnumber'] > $b['reviewnumber']) ? 1 : -1;
}
// BEST [THEN BY MOST RELEVANT, THEN BY NEWEST]
function sortBestRelNew($a, $b)
{
	if($a['rating'] == $b['rating']) 
	{ 
		if($a['relevance'] == $b['relevance']) 
		{ 
			if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
			return ($a['reviewnumber'] < $b['reviewnumber']) ? 1 : -1;
		}
		return ($a['relevance'] < $b['relevance']) ? 1 : -1;
	}
	return ($a['rating'] < $b['rating']) ? 1 : -1;
}
// WORST [THEN BY MOST RELEVANT, THEN BY NEWEST]
function sortWorstRelNew($a, $b)
{
	if($a['rating'] == $b['rating']) 
	{ 
		if($a['relevance'] == $b['relevance']) 
		{ 
			if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
			return ($a['reviewnumber'] < $b['reviewnumber']) ? 1 : -1;
		}
		return ($a['relevance'] < $b['relevance']) ? 1 : -1;
	}
	return ($a['rating'] > $b['rating']) ? 1 : -1;
}
// ABC [THEN BY MOST RELEVANT, THEN BY NEWEST]
function sortAbcRelNew($a, $b)
{
	if($a['title'] == $b['title']) 
	{ 
		if($a['relevance'] == $b['relevance']) 
		{ 
			if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
			return ($a['reviewnumber'] < $b['reviewnumber']) ? 1 : -1;
		}
		return ($a['relevance'] < $b['relevance']) ? 1 : -1;
	}
	return ($a['title'] > $b['title']) ? 1 : -1;
}
// ZYX [THEN BY MOST RELEVANT, THEN BY NEWEST]
function sortZyxRelNew($a, $b)
{
	if($a['title'] == $b['title']) 
	{ 
		if($a['relevance'] == $b['relevance']) 
		{ 
			if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
			return ($a['reviewnumber'] < $b['reviewnumber']) ? 1 : -1;
		}
		return ($a['relevance'] < $b['relevance']) ? 1 : -1;
	}
	return ($a['title'] < $b['title']) ? 1 : -1;
}
// RE-SORT SEARCH RESULTS [INACTIVE] ------------------------------------------------------
// MOST RELEVANT
function sortRel($a, $b)
{
	if($a['relevance'] == $b['relevance']) { return 0; }
	return ($a['relevance'] < $b['relevance']) ? 1 : -1;
}
// BEST
function sortBest($a, $b)
{
	if($a['rating'] == $b['rating']) { return 0; }
	return ($a['rating'] < $b['rating']) ? 1 : -1;
}
// WORST
function sortWorst($a, $b)
{
	if($a['rating'] == $b['rating']) { return 0; }
	return ($a['rating'] > $b['rating']) ? 1 : -1;
}
// ABC
function sortAbc($a, $b)
{
	//return strcmp($a['title'], $b['title']);
	if($a['title'] == $b['title']) { return 0; }
	return ($a['title'] > $b['title']) ? 1 : -1;
}
// ZYX
function sortZyx($a, $b)
{
	if($a['title'] == $b['title']) { return 0; }
	return ($a['title'] < $b['title']) ? 1 : -1;
}
// MOST RELEVANT [THEN BY OLDEST]
function sortRelOld($a, $b)
{
	if($a['relevance'] == $b['relevance']) 
	{ 
		if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
		return ($a['reviewnumber'] > $b['reviewnumber']) ? 1 : -1;
	}
	return ($a['relevance'] < $b['relevance']) ? 1 : -1;
}
// MOST RELEVANT [THEN BY BEST, THEN BY NEWEST]
function sortRelBestNew($a, $b)
{
	if($a['relevance'] == $b['relevance']) 
	{ 
		if($a['rating'] == $b['rating']) 
		{ 
			if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
			return ($a['reviewnumber'] < $b['reviewnumber']) ? 1 : -1;
		}
		return ($a['rating'] < $b['rating']) ? 1 : -1;
	}
	return ($a['relevance'] < $b['relevance']) ? 1 : -1;
}
// MOST RELEVANT [THEN BY WORST, THEN BY NEWEST]
function sortRelWorstNew($a, $b)
{
	if($a['relevance'] == $b['relevance']) 
	{ 
		if($a['rating'] == $b['rating']) 
		{ 
			if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
			return ($a['reviewnumber'] < $b['reviewnumber']) ? 1 : -1;
		}
		return ($a['rating'] > $b['rating']) ? 1 : -1;
	}
	return ($a['relevance'] < $b['relevance']) ? 1 : -1;
}
// MOST RELEVANT [THEN BY ABC, THEN BY NEWEST]
function sortRelAbcNew($a, $b)
{
	if($a['relevance'] == $b['relevance']) 
	{ 
		if($a['title'] == $b['title']) 
		{ 
			if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
			return ($a['reviewnumber'] < $b['reviewnumber']) ? 1 : -1;
		}
		return ($a['title'] > $b['title']) ? 1 : -1;
	}
	return ($a['relevance'] < $b['relevance']) ? 1 : -1;
}
// MOST RELEVANT [THEN BY ZYX, THEN BY NEWEST]
function sortRelZyxNew($a, $b)
{
	if($a['relevance'] == $b['relevance']) 
	{ 
		if($a['title'] == $b['title']) 
		{ 
			if($a['reviewnumber'] == $b['reviewnumber']) { return 0; }
			return ($a['reviewnumber'] < $b['reviewnumber']) ? 1 : -1;
		}
		return ($a['title'] < $b['title']) ? 1 : -1;
	}
	return ($a['relevance'] < $b['relevance']) ? 1 : -1;
}
// end sort functions for ranked search results by relevance ---------------------------------------------------------------

// GET RECORD FIELDS AND RELATED SETS
function getRecordData($record, $fields, $relatedSets)
{
	// GET FIELD VALUES FROM DATABASE
	$thisRecordData = array();
	if($fields != NULL)
	{
		$thisRecordFields = array();
		foreach($fields as $field)
		{
			$fieldsN += 1;
			$varName 		= $field[0];
			$databaseField 	= $field[1];
			$$varName 		= $record->getField($databaseField);
			$thisRecordFields[$fieldsN] = array($varName, $databaseField, $$varName);
		} // end foreach $fields
	} // end if $fields != NULL
	
	// GET RELATED RECORDS AND THEIR FIELD VALUES FROM DATABASE
	if($relatedSets != NULL)
	{
		$thisRecordRelatedSets = array();
		$relatedSetsN = -1;
		foreach($relatedSets as $relatedSet)
		{
			$relatedSetsN += 1;
			$table 			= $relatedSet[0];
			$relatedFields 	= $relatedSet[1];
			$relatedRecords = $record->getRelatedSet($table);
			$relatedRecordsArray = array();
			$relatedRecordsN	= -1;
			foreach($relatedRecords as $relatedRecord)
			{
				$relatedRecordsN += 1;
				$relatedFieldsN = -1;
				foreach($relatedFields as $relatedField)
				{
					$relatedFieldsN += 1;
					$varName 		= $relatedField[0];
					$databaseField 	= $table.'::'.$relatedField[1];
					$$varName 		= $relatedRecord->getField($databaseField);
					$thisRelatedRecord[$relatedFieldsN] = array($varName, $databaseField, $$varName);
				}
				$relatedRecordsArray[$relatedRecordsN] = $thisRelatedRecord;
			} // end foreach $relatedRecord
			$thisRecordRelatedSets[$relatedSetsN] = array($table, $relatedRecordsArray);
		} // end foreach $relatedSet
	} // end if $relatedSets != NULL
	$thisRecordData = array($thisRecordFields, $thisRecordRelatedSets);
	return $thisRecordData;
} // end function getRecordData

// fmFind **********************************************************************************************************
function fmFind($database, $layout, $getFirst, $skip, $range, $params, $sortRules, $errorRedirect, $fields, $relatedSets)
{
	// DECLARE new FileMaker() OBJECT
	$fmobject = & new FileMaker();
	$fmobject->setProperty('database', $database);
	$fmobject->setProperty('username', 'webctr');
	$fmobject->setProperty('password', 'webctrpassword');
	$fmobjectLayout = $layout;
	$layoutobject = $fmobject->getLayout($fmobjectLayout);
	
	// CONCATENATE DEBUG FEEDBACK
	$feedback = 'function completed<br/>';
	$feedback .= '$database: '.$database.'<br/>';
	$feedback .= '$layout: '.$layout.'<br/>';
	$feedback .= '$fmobjectLayout: '.$fmobjectLayout.'<br/>';
	$feedback .= '$getFirst: '.$getFirst.'<br/>';
	$feedback .= '$skip: '.$skip.'<br/>';
	$feedback .= '$range: '.$range.'<br/>';
	
	// INITIALIZE FIND COMMAND
	$findCommand = $fmobject->newFindCommand($fmobjectLayout);
	
	// SET RANGE
	//$findCommand->setRange($skip, $range);
	if($range != NULL) 	
	{ 
		if($skip == NULL) { $skip = 0; }
		$findCommand->setRange($skip, $range); 
	}
	
	// ADD FIND CRITERIA
	//$findCommand->addFindCriterion('published',"*");
	$feedback .= '$params: '.$params.'<br/>'; 
	if($params != NULL)
	{
		$paramsN = 0;
		foreach($params as $param)
		{
			$paramsN += 1;
			$fieldName 		= $param[0];
			$searchTerms 	= $param[1];
			$feedback .= '$param'.$paramsN.': $fieldName = '.$fieldName.', $searchTerms = '.$searchTerms.'<br/>';
			if($fieldName != NULL and $searchTerms != NULL) { $findCommand->addFindCriterion($fieldName, $searchTerms); }
		} // end foreach $param
	} // end if $params != NULL
	
	// ADD SORT RULES
	//$findCommand->addSortRule('reviewnumber', 1, FILEMAKER_SORT_DESCEND);
	$feedback .= '$sortRules: '.$sortRules.'<br/>';
	if($sortRules != NULL)
	{
		$numSortRules = count($sortRules);
		$feedback .= '$numSortRules: '.$numSortRules.'<br/>';
		
		$priority = 0;
		$sortRulesN = 0;
		foreach($sortRules as $sortRule)
		{
			$priority += 1;
			$sortRulesN += 1;
			$fieldName	= $sortRule[0];
			$sortOrder	= $sortRule[1];
			$feedback .= '$sortRule'.$sortRulesN.': $fieldName: '.$fieldName.', $sortOrder: '.$sortOrder.'<br/>';
			if($fieldName != NULL and $sortOrder != NULL) { $findCommand->addSortRule($fieldName, $priority, $sortOrder); }
		} // end foreach $sortRule
		
	} // end if $sortRules == NULL
	
	// EXECUTE FIND COMMAND
	$result = $findCommand->execute();
	
	// HANDLE ERRORS
	if(FileMaker::isError($result)) 
	{ 
		echo $feedback.'<br/>';
		echo $result->getMessage();
		//require_once 'php/redirect.php'; 
		exit(); 
	}
	
	// GET RECORD OBJECTS
	$records = $result->getRecords();
	$record  = $result->getFirstRecord();
	
	// GET RECORD DATA FOR FIRST RECORD
	if($getFirst == true) 
	{ 
		$thisRecordData = getRecordData($record, $fields, $relatedSets);
		$return = $thisRecordData; 
	} 
	
	// GET RECORD DATA FOR ARRAY OF FOUND RECORDS
	else 
	{
		$recordsArray 	= array();
		$recordsN		= -1;
		foreach($records as $record)
		{
			$recordsN += 1;
			$thisRecordData = getRecordData($record, $fields, $relatedSets);
			$recordsArray[$recordsN] = $thisRecordData;
			
		} // end foreach $record
		$return = $recordsArray;
	}
	
	// RETURN DATA
	return $return;
	
} // end function fmFind()

// assign values of fields for a found record to dynamic variables
function getRecordFields($recordFields)
{
	foreach($recordFields as $field)
	{
		$varName  = $field[0];
		$varValue = $field[2];
		$$varName = $varValue;
	}
	// what to return?
} // end function getRecordFields($recordFields)

// assign related sets for a found record to dynamic variables
function getRecordRelatedSets($recordRelatedSets)
{
	foreach($recordRelatedSets as $recordRelatedSet)
	{
		$tableName 		= $recordRelatedSet[0];
		$relatedRecords = $recordRelatedSet[1];
		$relatedRecordsVarName = $tableName.'RelatedRecords';
		$$relatedRecordsVarName = $relatedRecords;
		$numRelatedRecords = count($relatedRecords);
		if($relatedRecords != NULL)
		{
			$relatedRecordsN = 0; 
			foreach($relatedRecords as $relatedRecord)
			{
				$relatedRecordsN += 1;
				getRecordData($relatedRecord);
			} // end foreach $relatedRecord
		} // end if($relatedRecords != NULL)
	} // end foreach $recordRelatedSet
	// what to return?
} // end function getRecordRelatedSets($recordRelatedSets)

// CONVERT A VIDEO URL TO COMPATIBLE IFRAME FORMAT -----------------------------------------------------------------------------
function videoLink($video)
{
			if ( substr_count ( $video, 'http://youtu.be/' ) 				> 0 )
			{
				$vidIDStart 	= strpos($video, 'http://youtu.be/') + strlen('http://youtu.be');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://youtube.com/embed".$vidID;
			}
	else	if ( substr_count ( $video, 'https://youtu.be/' ) 				> 0 )
			{
				$vidIDStart 	= strpos($video, 'https://youtu.be/') + strlen('https://youtu.be');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://youtube.com/embed".$vidID;
			}
	else	if ( substr_count ( $video,	'https://www.youtube.com/watch?v=') > 0 )
			{
				$vidIDStart 	= strpos($video, 'https://www.youtube.com/watch?v=') + strlen('https://www.youtube.com/watch?v=');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://youtube.com/embed/".$vidID;
			}	
	else	if ( substr_count ( $video,	'http://www.youtube.com/watch?v=') 	> 0 )
			{
				$vidIDStart 	= strpos($video, 'http://www.youtube.com/watch?v=') + strlen('http://www.youtube.com/watch?v=');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://youtube.com/embed/".$vidID;
			}			
	else	if ( substr_count ( $video, 'http://vimeo.com/')							> 0 )
			{
				$vidIDStart 	= strpos($video, 'http://vimeo.com/') + strlen('http://vimeo.com/');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://player.vimeo.com/video/".$vidID;
			}
	else	if ( substr_count ( $video, 'https://vimeo.com/')							> 0 )
			{			
				$vidIDStart 	= strpos($video, 'https://vimeo.com/') + strlen('https://vimeo.com/');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://player.vimeo.com/video/".$vidID;
			}
	else
			{
				$video = '';
				$vidURL = '';
			}	
	$vid = array($vidURL, $video);
	return $vid;
} // end videoLink()

// FORMAT A FULL NAME, REMOVING EXTRA SPACES
function formatFullName($fname, $lname)
{
	$fnameLastChar 	= substr($fname, -1, 1);	// get last character of first name
	$lnameFirstChar = substr($lname, 1, 1);		// get first character of last name
	if($fnameLastChar == ' ') 	{ $fnameLength = strlen($fname); $fname = substr($fname, 0, $fnameLength - 1); }
	if($lnameFirstChar == ' ') 	{ $lnameLength = strlen($lname); $lname = substr($lname, 1, $fnameLength - 1); }
	$fullName = $fname.' '.$lname;
	return ($fullName);
}

// FORMAT A STREET ADDRESS
function formatAddress($street, $city, $state, $zip, $country)
{
	$fullAddress;

	if($street != NULL) 	{ $fullAddress .= $street; }
	if($street != NULL and ($city != NULL or $state != NULL or $zip != NULL or $country != NULL) ) 
							{ $fullAddress .= '<br>'; }
	if($city != NULL)		{ $fullAddress .= $city; }
	if($city != NULL and $state != NULL) 
							{ $fullAddress .= ', '; }
	if($state != NULL)		{ $fullAddress .= $state; }
	if($state != NULL and $zip != NULL) 
							{ $fullAddress .= ' '; }
	if($zip != NULL)		{ $fullAddress .= $zip; }
	if($zip != NULL and $country != NULL)
							{ $fullAddress .= ' '; }
	if($country != NULL)	{ $fullAddress .= $country; }

	return($fullAddress);
} // end formatAddress()

// FORMAT A STREET ADDRESS (NO <br>)
function formatAddressNoBr($street, $city, $state, $zip, $country)
{
	$fullAddress;

	if($street != NULL) 	{ $fullAddress .= $street; }
	if($street != NULL and ($city != NULL or $state != NULL or $zip != NULL or $country != NULL) ) 
							{ $fullAddress .= "\n"; }
	if($city != NULL)		{ $fullAddress .= $city; }
	if($city != NULL and $state != NULL) 
							{ $fullAddress .= ', '; }
	if($state != NULL)		{ $fullAddress .= $state; }
	if($state != NULL and $zip != NULL) 
							{ $fullAddress .= ' '; }
	if($zip != NULL)		{ $fullAddress .= $zip; }
	if($zip != NULL and $country != NULL)
							{ $fullAddress .= ' '; }
	if($country != NULL)	{ $fullAddress .= $country; }

	return($fullAddress);
} // end formatAddress()

// CONVERT SCORES TO LETTERGRADES -----------------------------------------------------------------------------
function lettergrade($score)
{
			if	($score >= 96.5)					{	$lettergrade = 'A+';	}
	else	if	($score >= 93.5 and $score < 96.5)	{	$lettergrade = 'A';		}
	else	if	($score >= 89.5 and $score < 93.5)	{	$lettergrade = 'A-';	}

	else	if	($score >= 86.5 and $score < 89.5)	{	$lettergrade = 'B+';	}
	else	if	($score >= 83.5 and $score < 86.5)	{	$lettergrade = 'B';		}
	else	if	($score >= 79.5 and $score < 83.5)	{	$lettergrade = 'B-';	}

	else	if	($score >= 76.5 and $score < 79.5)	{	$lettergrade = 'C+';	}
	else	if	($score >= 73.5 and $score < 76.5)	{	$lettergrade = 'C';		}
	else	if	($score >= 69.5 and $score < 73.5)	{	$lettergrade = 'C-';	}

	else	if	($score >= 66.5 and $score < 69.5)	{	$lettergrade = 'D+';	}
	else	if	($score >= 63.5 and $score < 66.5)	{	$lettergrade = 'D';		}
	else	if	($score >= 59.5 and $score < 63.5)	{	$lettergrade = 'D-';	}

	else	if	($score < 59.5)					{	$lettergrade = 'F';	}

	else	if	($score == NULL)				{	$lettergrade = '';	}

	return $lettergrade;
} // end lettergrade()

// CHECK IF A REVIEW IS BOOKMARKED -----------------------------------------------------------------------------
function checkBookmark($list, $array, $reviewnumber)
{
	// CHECK IF REVIEWNUMBER IS IN THE STRING OF BOOKMARK REVIEWNUMBERS
	$listMatch		= substr_count($list, $reviewnumber);
	if($listMatch > 0) { $bookmarked = true; } else { $bookmarked = false; }

	if($bookmarked == true)
	{

		// LOCATE THE BOOKMARK REVIEWNUMBER THAT TRIGGERED THE MATCH
		$matchStart 	= strpos($list, $reviewnumber);
		$nextStart		= strpos($list, ',', $matchStart);
		$prevStr		= substr($list, 0, $matchStart);
		$prevCommas 	= substr_count($prevStr, ',');
		$nextCommas		= substr_count($list, ',', $matchStart);
		$bookmarkPlace 	= $prevCommas - 1;
		$fullMatchNo 	= $array[$bookmarkPlace][1];

		// GET THE CORRESPONDING RECORD ID FOR THE BOOKMARK (USED FOR DELETION)
		$fullMatchID 	= $array[$bookmarkPlace][0];
		$bookmarkID 	= $fullMatchID;

		// CHECK IF EXACT MATCH - REVIEWNUMBERS WITH FEWER DIGITS MAY CREATE A FALSE POSITIVE BY PARTIALLY MATCHING A BOOKMARK REVIEWNUMBER
		if ($fullMatchNo != $reviewnumber) { $falsePositive = true; $bookmarked = false; } else { $falsePositive = false; $bookmarked = true; }

		$numMatches = substr_count($list, $reviewnumber);
		if($falsePositive == true and $numMatches > 1)
		{ 
			// FIND THE BOOKMARK REVIEWNUMBER AFTER THE ONE THAT TRIGGERED THE FALSE POSITIVE
			$afterMatch 	= substr($list, $nextStart);

			// DETERMINE THE NUMBER OF BOOKMARK REVIEWNUMBERS IN THE REMAINING PORTION OF THE LIST STRING
			$commasAfter 	= substr_count($afterMatch, ',');
			$bookmarksAfter = $commasAfter - 1;

			// LOOP THROUGH THE REMAINING BOOKMARK REVIEWNUMBERS, CHECK AGAINST REVIEWNUMBER
			$correctMatch = '';
			$correctPlace = '';
			for($nm = 0; $nm < $bookmarksAfter; $nm ++)
			{
				$bookmarkPlace += 1;
				$nextBookmark = $array[$bookmarkPlace][0];

				if($reviewnumber == $nextBookmark) 
						{ $nextCheck = true; $correctMatch = $nextBookmark; $correctPlace = $bookmarkPlace; } 
				else 	{ $nextCheck = false; }
			}
			if($correctMatch != NULL)
			{
				$fullMatchNo 	= $array[$correctPlace][0];
				$fullMatchID 	= $array[$correctPlace][3];	
				$bookmarkID 	= $fullMatchID;
				$bookmarked = true;
			}
			else { $bookmarked == false; $bookmarkID = ''; }
		} // END if($falsePositive == true and $numMatches > 1)
	} // END if($bookmarked == true)

	// RETURN THE BOOKMARKED STATUS AND BOOKMARK RECORD ID
	$bookmarkInfo = array($bookmarked, $bookmarkID);
	return($bookmarkInfo);
} // end checkBookmark()

function parseLinks($text) 
{
	/*
	this function (adapted from http://krasimirtsonev.com/blog/article/php--find-links-in-a-string-and-replace-them-with-actual-html-link-tags)
	handles duplicate urls, but still can be broken by periods followed by line breaks, and does not handle plain 'www' instances
	*/
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    $urls = array();
    $urlsToReplace = array();
	
	// REPLACE ALL INSTANCES OF "WWW" WITH "HTTP://WWW" SO THAT PARSING FUNCTION WILL HANDLE ALL CASES
	$numWWW = substr_count($text, ' www.');
	if($numWWW > 0) { $text = str_replace ( ' www', ' http://www', $text, $numWWW ); }
	$numBRWWW = substr_count($text, "\n".'www.');
	if($numBRWWW > 0) { $text = str_replace ( "\n".'www.', "\n".'http://www.', $text, $numBRWWW ); }
		
    if(preg_match_all($reg_exUrl, $text, $urls))
	{
        $numMatches = count($urls[0]);
        $numOfUrlsToReplace = 0;
        for($i = 0; $i < $numMatches; $i++)
		{
            $alreadyAdded = false;
            $numOfUrlsToReplace = count($urlsToReplace);
            for($j = 0; $j < $numOfUrlsToReplace; $j++)
			{
				if($urlsToReplace[$j] == $urls[0][$i]) { $alreadyAdded = true; }  
			}
            if($alreadyAdded != true) { array_push($urlsToReplace, $urls[0][$i]); }
        } // end for i < $numMatches
		
        $numOfUrlsToReplace = count($urlsToReplace);
        for($i = 0; $i < $numOfUrlsToReplace; $i++)
		{
            $text = str_replace($urlsToReplace[$i], "<a href=\"".$urlsToReplace[$i]."\" target = \"_blank\">".$urlsToReplace[$i]."</a> ", $text);
        }
        
    } // end if preg_match_all
	
	$text = nl2br($text);
	return($text);
	
} // end function parseLinks()

// PARSE LINKS IN A BODY OF TEXT -----------------------------------------------------------------------------
function parseLinksOld($text)
{
	// ADD LINE BREAKS
	$text = nl2br($text);
	
	/*
	the counting method doesn't work - if there is, for example, a case with 1 instance of plain www and 3 instances of https://www,
	then the count is < 0 and the www will not get replaced
	*/
	// COUNT THE NUMBER OF OCCURRENCES OF "WWW" WITHOUT A PRECEEDING "HTTP"
	$numWWW 	= substr_count ( $text, 'www.' );
	$numHTTPWWW = substr_count ( $text, '://www.' );
	$numHTTPSWWW = substr_count($text, 'https://www');
	$w = $numWWW - $numHTTPWWW - $numHTTPSWWW;

	// REPLACE ALL INSTANCES OF "WWW" WITH "HTTP://WWW" SO THAT PARSING FUNCTION WILL HANDLE ALL CASES
	if ($w > 0) { $text = str_replace ( 'www', 'http://www', $text, $w ); }
	
	// BEGIN PARSING
	$needle = 'http';
	$needleLength = strlen($needle);
	$needleCount = substr_count ( $text, $needle );
	
	// DECLARE ARRAYS FOR THE LINKS
	$needles = array();
	$tags = array();
	$hyperlinks = array();

	// LOOP THROUGH ALL LINKS AND PARSE THEM
	for ( $i = 0; $i < $needleCount; $i++ )
	{
		// DETERMINE START POS OF LINK
		$needleStart = strpos($text, $needle, $needleStart + $needleLength );

		// DETERMINE ENDPOINT OF LINK - EITHER A SPACE OR LINE BREAK
		$distSpace 	= abs(stripos($text, ' ', $needleStart) - $needleStart); 
		$distNL 	= abs(stripos($text, "\n", $needleStart) - $needleStart); 
		$distBR		= abs(stripos($text, '<br>', $needleStart) - $needleStart);
		if ($distSpace <= $distNL) { $needleLength = $distSpace; } else { $needleLength = $distNL; } $needleLength += 0;

		// PARSE OUT THE LINK FROM BETWEEN THE START POS AND ENDPOINT
		$needleParsed = substr($text, $needleStart, $needleLength);
		$needleUntrimmed = $needleParsed;

		// TRIM EXTRA CHARACTERS ( periods or parentheses or <br> tags from end of string )
		$needleTrim1 = substr($needleParsed, 0, strlen($needleParsed)-1);
		$needleTrim2 = substr($needleParsed, 0, strlen($needleParsed)-2);

		$lastChar 		= substr($needleParsed, -1);
		$secondLastChar = substr($needleParsed, -2, 1);

		if ($lastChar == '.' or $lastChar == ',' or $lastChar == ')') 						{ $needleParsed = $needleTrim1; }
		if ($secondLastChar == '.' or $secondLastChar == ',' or $secondLastChar == ')') 	{ $needleParsed = $needleTrim2; }

		$needleTrimBR 	= substr($needleParsed, 0, strlen($needleParsed)-3);
		if ( substr_count ( $needleParsed, '<br') > 0 )										{ $needleParsed = $needleTrimBR; }

		// THE LINK SHOULD NOW BE PROPERLY PARSED	

		// CONSTRUCT THE <a> TAG
		$needleTag = '<a href = "'.$needleParsed.'" target = "_blank">'.$needleParsed.'</a>'; 
		// COULD EVENTUALLY DEFINE A VALUE FOR HREF AND DISPLAY TEXT SEPARATELY?

		// UPDATE THE LINK ARRAYS
		$needles[$i] = $needleParsed;
		$tags[$i] = $needleTag;
		$hyperlinks[$i] = array($needleParsed, $needleTag);
		
	} // END FOR LOOP

	// REPLACE THE LINK TEXT WITH THE <a> TAGS (USING THE ARRAYS AS PARAMS IN THE STR REPLACE FUNCTION)
	$parsed = str_replace($needles, $tags, $text);
	return $parsed;

} // END function parseLinksOld($text)
?>