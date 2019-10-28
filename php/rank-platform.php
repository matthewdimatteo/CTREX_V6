<?php
// CHECK AGAINST PLATFORM
if(in_array($searchPlatformWord		, $rankPlatformWords)) 		{ $relevance += 10; }	// add greater relevance for entire word match
else if(substr_count($rankPlatform	, $searchPlatformWord) > 0) { $relevance += 2; }	// add lesser relevance for string match/partial word
?>