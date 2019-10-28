<?php
/*
php/result-item-context.php
By Matthew DiMatteo, Children's Technology Review

This file displays the matches for any search terms within the context of the review for each result of a review search
It is included in the file 'php/result-item/php'

The cleanText() function can be found in 'php/functions.php' - it removes certain characters from a string and converts to lowercase for string comparisons
The $cleanedReviewWords variable is an array containing the words of the cleaned review body text ($sortedRevieWords is the array of the original text)
- These values are calculated in 'php/rank-review.php' and passed as array values for the sorted records, accessed in 'php/content/content-home.php'
*/

if($reviewMatches > 0) 
{ 
	$matches = array(); // array to store the context strings for each match
	$paddingRange = 10; // the number of words to get before and after the match word
	
	// loop through all search terms, clean each, explode into array, check against cleaned review words array, find position of matches
	foreach($searchTermsArray as $thisTerm)
	{
		$thisTermCleaned = cleanText($thisTerm); // clean the search term string
		$thisTermWords = explode(' ', $thisTermCleaned, '0213456789'); // parse search term string into array of words
		
		// check each search term word against the array of review words
		foreach($thisTermWords as $thisWord)
		{
			$wordsBefore 	= ''; // string to store the words before the match
			$wordsAfter 	= ''; // string to store the words after the match
			
			// if match, find the position and add to array of positions
			if(in_array($thisWord, $cleanedReviewWords)) 
			{ 
				$thisWordIndex = array_search($thisWord, $cleanedReviewWords); 	// get the array index

				// 12 - 5 = 7		7, 8, 9, 10, 11 	// 12 + 5 = 17		13, 14, 15, 16, 17
				$beforeStart 	= $thisWordIndex - $paddingRange;	// determine how many words before the match to start
				$afterEnd 		= $thisWordIndex + $paddingRange;	// determine how many words after the match to end
				
				// loop through the array of review words and get the words at the index values before the match
				for($before = 0; $before < $paddingRange; $before++)
				{
					$bIndex = $beforeStart + $before;			// calculate the index of the word to get
					$beforeWord = $sortedReviewWords[$bIndex];	// get the word at that index of the original review text
					$wordsBefore .= $beforeWord.' ';			// append that word to the string of all words before the match
				}
				
				// loop through the array of review words and get the words at the index values after the match
				for($after = 1; $after < $paddingRange; $after++)
				{
					$aIndex = $thisWordIndex + $after;			// calculate the index of the word to get
					$afterWord = $sortedReviewWords[$aIndex];	// get the word at that index of the original review text
					$wordsAfter .= $afterWord;					// append that word to the string of all words before the match
					if($after != $paddingRange - 1) { $wordsAfter .= ' '; } // only add a space if not the last word
				}
				$thisWordOrig = $sortedReviewWords[$thisWordIndex]; // get the match word from the uncleaned text at the same index
				$wordsAround = $wordsBefore.'<strong>'.$thisWordOrig.'</strong> '.$wordsAfter; // concatenate the context string
				array_push($matches, $wordsAround); // add the context string for this match to the array of context string

			} // end if in this word in review word array
		} // end foreach this term words
	} // end foreach search term
	if($matches != NULL) { foreach($matches as $match) { echo '...'.$match; } echo '...'; } // output the context strings for all matches

} // end if review matches
?>