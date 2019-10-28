<?php
/*
php/rank-keyword.php
By Matthew DiMatteo, Children's Technology Review

This file assigns relevance for product review search results based on search terms
It is included within a foreach loop in the file 'php/find-reviews-rank-param.php'

The file 'php/find-review-rank.php' utilizes the getTextArray($text) function found in 'php/functions.php' to construct arrays of strings for each search input and its corresponding target field (for example, the platform input and the platform field)

The file 'php/find-reviews-rank-param.php' uses a switch() block to determine which arrays to check based on the search input
It is included within a foreach loop in 'php/find-reviews-rank.php' that loops through each search input

This file then compares each string within the search input against its corresponding target field
If the string is in the array of strings for the target field (meaning it is an entire word match), greater relevance is assigned
If the string is in the target field string as a substring, a smaller amount of relevance is applied (ex: 'fish' in 'fisher-price')

This file also compares the search input strings against other target fields
The greatest relevance is assigned for a match in the target field for that input (such as platform for platform)
A smaller amount of relevance is assigned for a match in another target field

All things being equal (if the search input is not being compared against its corresponding target field)
- a match in the title field is worth the most (10 pts)
- a match in the company name is worth the next most (5 pts)
- a match in any of the powersearch fields (age, platform, subject, topic) or hidden inputs (monthly, weekly) is worth 2pts
- a match in the body of the review is worth 1 pt

For only a substr match, the relevance added is one-fifth that of the in_array match values above

Finally, this file checks for the context of each match to highlight the text that matches
*/

// CHECK TARGET FIELD -------------------------------------------------------
if(in_array($compString, $targetStringArray)) 				{ $relevance += 10; }	// add greater relevance for entire word match
else if(substr_count($targetString, $compString) > 0 ) 		{ $relevance += 2; }	// add lesser relevance for string match (could be partial word)

// CHECK OTHER FIELDS --------------------------------------------------------

// CHECK AGAINST TITLE
if($compWord != 'keyword' and $compWord != 'age')
{
	if(in_array($compString, $rankTitleWords)) 				{ $relevance += 10; }	// add greater relevance for entire word match
	else if(substr_count($rankTitle		, $compString) > 0) { $relevance += 2; }	// add lesser relevance for string match (could be partial word)
}

// CHECK AGAINST COMPANY
if($compWord != 'company' and $compWord != 'age')
{
	if(in_array($compString, $rankCompanyWords))			{ $relevance += 5; }
	else if(substr_count($rankCompany, $compString) > 0)	{ $relevance += 1; }
}

// CHECK AGAINST EQUALLY WEIGHTED FIELDS (PLATFORM, SUBJECT, TOPIC, MONTHLY, WEEKLY)
$equivFields = array
(
	array('platform', $rankPlatformWords, $rankPlatformWord),
	array('subject'	, $rankSubjectWords	, $rankSubjectWord),
	array('topic'	, $rankTopicWords	, $rankTopicWord),
	array('monthly'	, $rankMonthlyWords	, $rankMonthlyWord),
	array('weekly'	, $rankWeeklyWords	, $rankWeeklyWord),
);
foreach($equivFields as $equivField)
{
	$thisCompWord 			= $equivField[0];
	$thisTargetStringArray 	= $equivField[1];
	$thisTargetString 		= $equivField[2];
	if($compWord != $thisCompWord and $compWord != 'age')
	{
		if(in_array($compString, $thisTargetStringArray))			{ $relevance += 2; }
		else if(substr_count($thisTargetString, $compString) > 0)	{ $relevance += 0.4; }
	}
}

// CHECK AGAINST BODY OF REVIEW
if(in_array($compString, $rankReviewWords))				{ $relevance += 1; $reviewMatches += 1; }
else if(substr_count($rankReview, $compString) > 0) 	{ $relevance += 0.2; }

// FIND CONTEXT OF MATCHES --------------------------------------------------------------------------------------

// CHECK TITLE
$titleN 			= -1;		// counter to be incremented	
foreach($rankTitleWords as $rankTitleWord)
{
	$titleN += 1; // increment the counter

	// locate corresponding item in original title words array - if match, set param to true, if not, set to false
	if(in_array($rankTitleWord, $compStringArray)) 		{ $titleWordsArray[$titleN] 	= array($titleWords[$titleN], true);  } 
	else if($titleWordsArray[$titleN][1] != true)		{ $titleWordsArray[$titleN] 	= array($titleWords[$titleN], false); }
} // end foreach $rankTitleWords

// CHECK COMPANY
$companyN 			= -1;
foreach($rankCompanyWords as $rankCompanyWord)
{
	$companyN += 1;
	if(in_array($rankCompanyWord, $compStringArray)) 	{ $companyWordsArray[$companyN] = array($companyWords[$companyN], true); }
	else if($companyWordsArray[$companyN][1] != true)	{ $companyWordsArray[$companyN] = array($companyWords[$companyN], false); }
}

// CHECK PLATFORM
$platformN 			= -1;
foreach($rankPlatformWords as $rankPlatformWord)
{
	$platformN += 1;
	if(in_array($rankPlatformWord, $compStringArray)) 	{ $platformWordsArray[$platformN] = array($platformWords[$platformN], true); }
	else if($platformWordsArray[$platformN][1] != true)	{ $platformWordsArray[$platformN] = array($platformWords[$platformN], false); }
}

// CHECK SUBJECT
$subjectN 			= -1;
foreach($rankSubjectWords as $rankSubjectWord)
{
	$subjectN += 1;
	if(in_array($rankSubjectWord, $compStringArray)) 	{ $subjectWordsArray[$subjectN] = array($subjectWords[$subjectN], true); }
	else if($subjectWordsArray[$subjectN][1] != true)	{ $subjectWordsArray[$subjectN] = array($subjectWords[$subjectN], false); }
}

// CHECK AGE LABEL
$agelabelN = -1;
foreach($rankAgelabelWords as $rankAgelabelWord)
{
	$agelabelN +=1;
	if(in_array($rankAgelabelWord, $compStringArray))	{ $agelabelWordsArray[$agelabelN] = array($agelabelWords[$agelabelN], true); }
	else if ($agelabelWordsArray[$agelabelN][1] != true){ $agelabelWordsArray[$agelabelN] = array($agelabelWords[$agelabelN], false); }
}

// CHECK REVIEW BODY
$reviewN = -1;
foreach($rankReviewWords as $rankReviewWord)
{
	$reviewN += 1;
	if(in_array($rankReviewWord, $compStringArray))		{ $reviewWordsArray[$reviewN] = array($reviewWords[$reviewN], true); }
	else if ($reviewWordsArray[$reviewN][1] != true)	{ $reviewWordsArray[$reviewN] = array($reviewWords[$reviewN], false); }
}

// CHECK REVIEW CONTEXT SUBSTRING
$contextN = -1;
foreach($rankContextWords as $rankContextWord)
{
	$contextN += 1;
	if(in_array($rankContextWord, $compStringArray))	{ $contextWordsArray[$contextN] = array($contextWords[$contextN], true); }
	else if ($contextWordsArray[$contextN][1] != true)	{ $contextWordsArray[$contextN] = array($contextWords[$contextN], false); }
}

?>