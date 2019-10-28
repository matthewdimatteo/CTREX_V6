<?php
// DETERMINE VALUES BASED ON SEARCH PARAMETER
$searchInputVarName 	= 'rankSearch'.ucfirst($compWord);
$compStringCountVarName	= 'numSearch'.ucfirst($compWord).'Words';
$compStringArrayVarName	= 'search'.ucfirst($compWord).'Words';
$compStringVarName		= 'search'.ucfirst($compWord).'Word';
if($compWord == 'keyword') 	{ $targetStringArrayVarName = 'rankTitleWords'; 					$targetStringVarName = 'rankTitle';	}
else						{ $targetStringArrayVarName	= 'rank'.ucfirst($compWord).'Words'; 	$targetStringVarName = 'rank'.ucfirst($compWord); }
$searchInput 		= $$searchInputVarName;
$compStringCount 	= $$compStringCountVarName;
$compStringArray 	= $$compStringArrayVarName;
$targetStringArray 	= $$targetStringArrayVarName;
$targetString 		= $$targetStringVarName;

// SPECIAL CASE - FOR KEYWORD, ADD GREATEST RELEVANCE IF MATCHES ENTIRE TITLE FIELD
if($compWord == 'keyword') 		{ if($rankSearchKeyword == $rankTitle) { $relevance += 100; } } // add greatest relevance for entire field match

// ASSIGN RELEVANCE FOR SEARCH INPUT ----------------------------------------------------------------------------
if($compStringCount > 0) 		{ foreach($compStringArray as $compString) { require 'php/rank-word.php'; } }
else if ($compStringCount > 0) 	{ require 'php/rank-word.php'; }

// HIGHLIGHT TEXT FOR MATCHES -----------------------------------------------------------------------
$titleText = ''; // declare a string to reconstruct the original title, substituting bold for matches
$titleTextN = 0;
foreach($titleWordsArray as $titleWord)
{
	$thisWord 	= $titleWord[0];	// get the word
	$thisMatch	= $titleWord[1];	// get the match state (true/false)
	if($thisMatch == true) { $thisWordParsed = '<strong>'.$thisWord.'</strong>'; } else { $thisWordParsed = $thisWord; } // make matches bold
	$titleText .= $thisWordParsed;	// append the parsed word to the reconstructed string
	$titleTextN += 1;				// increment the counter
	if($titleTextN < $numTitleWords) { $titleText .= ' '; } // add spaces between words, except for last word
} // end foreach $titleWordsArray
if($titleText == NULL) { $titleText = $title; } // null handler defaults to original $title value

// HIGHLIGHT MATCHES IN COMPANY TEXT
$companyText = '';
$companyTextN = 0;
foreach($companyWordsArray as $companyWord)
{
	$thisWord 	= $companyWord[0];
	$thisMatch 	= $companyWord[1];
	if($thisMatch == true) { $thisWordParsed = '<strong>'.$thisWord.'</strong>'; } else { $thisWordParsed = $thisWord; } // make matches bold
	$companyText .= $thisWordParsed;	// append the parsed word to the reconstructed string
	$companyTextN += 1;					// increment the counter
	if($companyTextN < $numCompanyWords) { $companyText .= ' '; } // add spaces between words, except for last word
}
if($companyText == NULL) { $companyText = $company; }

// HIGHLIGHT MATCHES IN PLATFORM TEXT
$platformText = '';
$platformTextN = 0;
foreach($platformWordsArray as $platformWord)
{
	$thisWord 	= $platformWord[0];
	$thisMatch 	= $platformWord[1];
	if($thisMatch == true) { $thisWordParsed = '<strong>'.$thisWord.'</strong>'; } else { $thisWordParsed = $thisWord; } // make matches bold
	$platformText .= $thisWordParsed;	// append the parsed word to the reconstructed string
	$platformTextN += 1;				// increment the counter
	if($platformTextN < $numPlatformWords) { $platformText .= ' '; } // add spaces between words, except for last word
}

// HIGHLIGHT MATCHES IN SUBJECT TEXT
$subjectText = '';
$subjectTextN = 0;
foreach($subjectWordsArray as $subjectWord)
{
	$thisWord 	= $subjectWord[0];
	$thisMatch 	= $subjectWord[1];
	if($thisMatch == true) { $thisWordParsed = '<strong>'.$thisWord.'</strong>'; } else { $thisWordParsed = $thisWord; } // make matches bold
	$subjectText .= $thisWordParsed;	// append the parsed word to the reconstructed string
	$subjectTextN += 1;					// increment the counter
	if($subjectTextN < $numSubjectWords) { $subjectText .= ' '; } // add spaces between words, except for last word
}
if($subjectText == NULL) { $subjectText = $subjects; }

// DISPLAY MATCHES IN REVIEW BODY TEXT
$reviewbodyText = '';
$reviewbodyTextN = 0;
foreach($reviewWordsArray as $reviewWord)
{
	$thisWord 	= $reviewWord[0];
	$thisMatch	= $reviewWord[1];
	if($thisMatch == true) { $thisWordParsed = '<strong>'.$thisWord.'</strong>'; } else { $thisWordParsed = $thisWord; } // make matches bold
	$reviewbodyText .= $thisWordParsed;	// append the parsed word to the reconstructed string
	$reviewbodyTextN += 1;				// increment the counter
	//if($reviewbodyTextN < $numReviewWords) { $reviewbodyText .= ' '; }
	$reviewbodyText .= ' ';
} // end for each review word

if($reviewbodyText == NULL) { $reviewbodyText = $review; }
?>