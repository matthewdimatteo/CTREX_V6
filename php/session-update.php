<?php
/*
php/session-update.php
By Matthew DiMatteo, Children's Technology Review

This file looks up a subscriber record by its record id (defined in 'php/session.php'), gets its field values, and updates $_SESSION storage values
It is included whenever a subscriber action changes certain values that are stored in $_SESSION, such as saved searches, bookmarks, and rubrics
It is included in the files 'savesearch.php', 'savebookmark.php', and 'save-rubric.php'
*/

// lookup subscriber profile
$findUser = $fmsubs->newFindCommand($fmsubsLayout);
$findUser->addFindCriterion('globalID','=='.$userID);
$result = $findUser->execute();
$record = $result->getFirstRecord();	
require 'php/get-sub.php';		// get subscriber record field data
require 'php/profile-save.php'; // update stored $_SESSION values for saved item arrays, counts
?>