<?php
/*
editorial-process.php
By Matthew DiMatteo, Children's Technology Review

This file processes the quick edit form input on the review page and the editorial form input on the editorial page using the $_POST method
On a successful captcha entry, a new record is added to the 'messages' table in the 'CSR.fmp12' database to serve as a notification to CTR staff

After either a success or a failure, the user is redirected back to the review page where a message is displayed

Stored error and confirmation messages are handled by the file 'php/message-calc.php'
The file 'php/content/content-editorial.php' is configured to display the initial input values once after a redirect

*/
$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page

// ALLOW ONLY MODS AND EXPERTS
if($mod != true and $expert != true and $student != true and $juror != true) { require 'php/redirect-home.php'; }

// PROCESS THE QUICK EDIT FORM
if(isset($_POST['review-quick-edit']))
{
	// get the form inputs
	$title			= test_input($_POST['title']);
	$reviewID		= test_input($_POST['review-id']);
	$initialText	= test_input($_POST['initial-text']);
	$editedText		= test_input($_POST['review-quick-edit']);
	
	// lookup the review record and update the review text
	// note: cannot use getRecordById method, as CSR::reviewnumber (field used for CTREX links) does not correspond to the actual recordID
	$findReview = $fmreviews->newFindCommand($fmreviewsLayout);
	$findReview->addFindCriterion('reviewnumber',"==".$reviewID);
	$result = $findReview->execute();
	if (FileMaker::isError ($result) ) { echo $result->getMessage(); exit(); }
	$editReview = $result->getFirstRecord();
	
	// gate out students/jurors attempting to access unauthorized reviews (both can enter new and edit own; jurors can edit current entries)
	$authorID 		= $editReview->getField('subsScreenName::globalID');
	$bolognaYear 	= $editReview->getField('bolognaYear');
	$kapiYear 		= $editReview->getField('kapiYear');
	if($student == true and $authorID != $userID) 													{ require 'php/redirect-home.php'; }
	if($juror == true and $authorID != $userID and $bolognaYear != $year and $kapiYear != $year) 	{ require 'php/redirect-home.php'; }
	
	// set the review fields and commit the record
	$editReview->setField('Web Site Comments Field', $editedText);
	$commit = $editReview->commit();
	if ( FileMaker::isError ($commit) ) { echo 'Error:'.$commit->getMessage(); exit(); }
	
	// set the redirect destination as the review page
	$redirect = 'review.php?id='.$reviewID;
	
	// set a flag to display a confirmation message
	$_SESSION['quick-edit-confirmation'] = true;
	
	// create a notification record in the database
	$summary = $fullName.' edited the review for '.$title.' using the Quick Edit Form:';
	$summary .= "\n"."\n".'Original:'."\n"."\n".$initialText."\n"."\n".'Edited:'."\n"."\n".$editedText;
	$summary .= "\n"."\n".'CTREX Link: https://reviews.childrenstech.com/ctr/review.php?id='.$reviewID;
	$summary .= "\n".'Local Link: https://local.childrenstech.com/ctr/review.php?id='.$reviewID;
	$inputName 		= $fullName;
	$inputEmail 	= '';
	$emailSubject = 'Review Quick Edit'; 
	$emailMessage 	= $summary."\n".'IP: '.$ip;
	require_once 'php/message-create.php';

} // end if isset review-quick-edit

// PROCESS THE EDITORIAL FORM
else if(isset($_POST['review-editorial']))
{
	$fields = $_SESSION['editorial-fields'];		// set in 'php/content/content-editorial.php', tells 'php/form-fields-process.php' which fields to process
	require_once 'php/form-fields-process.php'; 	// get input values and assign to dynamically named variables
	require_once 'php/get-rubric-inputs.php';		// get rubric evaluation form inputs
	require_once 'php/get-rubric-qa-inputs.php'; 	// get the values from each qa input (name, index, rating, weight)
	
	// DEBUG BOOL
	//$debug = true;
	//$debug = '';
	
	// DEBUG OUTPUT FORM INPUTS
	// label, name, value
	foreach($submissionData as $thisInput)
	{
		$dataLabel 		= $thisInput[0];
		$dataVarName 	= $thisInput[1];
		$dataVarValue 	= $thisInput[2];
		if($debug == true) { echo $dataVarName.': '.$dataVarValue.'<br/>'; }
	} // end foreach $submissionData
	
	//exit();
	
	// ADD "OTHER" VALUES TO LISTS (function addToList() found in 'php/functions.php')
	$editorialplatforms 	= addToList($editorialplatforms		, $editorialplatformsOther		, $platformValueListItems);
	$editorialsubjects 		= addToList($editorialsubjects		, $editorialsubjectsOther		, $subjectValueListItems);
	$editorialtopics 		= addToList($editorialtopics		, $editorialtopicsOther			, $topicValueListItems);
	$editoriallanguages 	= addToList($editoriallanguages		, $editoriallanguagesOther		, $languageValueListItems);
	$editorialscaffolding 	= addToList($editorialscaffolding	, $editorialscaffoldingOther	, $scaffoldingValueListItems);
	
	// parse out checkbox fields' list formats, converting commas to line breaks
	$editorialplatformsParsed 	= comma2nl($editorialplatforms);
	$editorialsubjectsParsed 	= comma2nl($editorialsubjects);
	$editorialtopicsParsed 		= comma2nl($editorialtopics);
	$editoriallanguagesParsed 	= comma2nl($editoriallanguages);
	$editorialscaffoldingParsed = comma2nl($editorialscaffolding);
	if($debug == true)
	{
		echo '<br/>';
		echo '$editorialplatforms: '.$editorialplatforms.'<br/>';
		echo '$editorialsubjects: '.$editorialsubjects.'<br/>';
		echo '$editorialtopics: '.$editorialtopics.'<br/>';
		echo '$editoriallanguages: '.$editoriallanguages.'<br/>';
		echo '$editorialscaffolding: '.$editorialscaffolding.'<br/>';

		echo '$editorialplatformsParsed: '.$editorialplatformsParsed.'<br/>';
		echo '$editorialsubjectsParsed: '.$editorialsubjectsParsed.'<br/>';
		echo '$editorialtopicsParsed: '.$editorialtopicsParsed.'<br/>';
		echo '$editoriallanguagesParsed: '.$editoriallanguagesParsed.'<br/>';
		echo '$editorialscaffoldingParsed: '.$editorialscaffoldingParsed.'<br/>';
	} // end if $debug
	//exit();
	
	// determine which awards were checked
	if(substr_count($editorialawards, 'edchoice') > 0) 	{ $editorialedchoice = true; }	else { $editorialedchoice = ''; }
	if(substr_count($editorialawards, 'ethical') > 0) 	{ $editorialethical = true; } 	else { $editorialethical = ''; }
	if($debug == true)
	{
		echo '$editorialedchoice: '.$editorialedchoice.'<br/>';
		echo '$editorialethical: '.$editorialethical.'<br/>';
	} // end if $debug
	
	// determine age tags and age codes based on grade level value
	$ageTagsContents;
	$ageCodesContents;
	if(substr_count($editorialgrades, 'B') > 0) { $ageTagsContents .= "\n".'Baby'; 									$ageCodesContents .= "\n".'B'; }
	if(substr_count($editorialgrades, 'T') > 0) { $ageTagsContents .= "\n".'Toddler'; 								$ageCodesContents .= "\n".'T'; }
	if(substr_count($editorialgrades, 'P') > 0) { $ageTagsContents .= "\n".'Preschool'; 							$ageCodesContents .= "\n".'P'; }
	if(substr_count($editorialgrades, 'K') > 0) { $ageTagsContents .= "\n".'Kindergarden'; 							$ageCodesContents .= "\n".'K'; }
	if(substr_count($editorialgrades, '1') > 0) { $ageTagsContents .= "\n".'1st Grade'."\n".'Early Elementary'; 	$ageCodesContents .= "\n".'E'; }
	if(substr_count($editorialgrades, '2') > 0) { $ageTagsContents .= "\n".'2nd Grade'."\n".'Early Elementary'; 	$ageCodesContents .= "\n".'E'; }
	if(substr_count($editorialgrades, '3') > 0) { $ageTagsContents .= "\n".'3rd Grade'."\n".'Early Elementary'; 	$ageCodesContents .= "\n".'E'; }
	if(substr_count($editorialgrades, '4') > 0) { $ageTagsContents .= "\n".'4th Grade'."\n".'Upper Elementary'; 	$ageCodesContents .= "\n".'U'; }
	if(substr_count($editorialgrades, '5') > 0) { $ageTagsContents .= "\n".'5th Grade'."\n".'Upper Elementary'; 	$ageCodesContents .= "\n".'U'; }
	if(substr_count($editorialgrades, '6') > 0) { $ageTagsContents .= "\n".'6th Grade'."\n".'Upper Elementary'; 	$ageCodesContents .= "\n".'U'; }
	if(substr_count($editorialgrades, '7') > 0) { $ageTagsContents .= "\n".'7th Grade'."\n".'Middle School'; 		$ageCodesContents .= "\n".'M'; }
	if(substr_count($editorialgrades, '8') > 0) { $ageTagsContents .= "\n".'8th Grade'."\n".'Middle School'; 		$ageCodesContents .= "\n".'M'; }
	if(substr_count($editorialgrades, '9') > 0) { $ageTagsContents .= "\n".'9th Grade'."\n".'High School'; 			$ageCodesContents .= "\n".'M'; }
	if(substr_count($editorialgrades, 'S,') > 0){ $ageTagsContents .= "\n".'Sophomore'."\n".'High School'; 			$ageCodesContents .= "\n".'M'; }
	if(substr_count($editorialgrades, 'J') > 0) { $ageTagsContents .= "\n".'Junior'."\n".'High School'; 			$ageCodesContents .= "\n".'M'; }
	if(substr_count($editorialgrades, 'Sr') > 0){ $ageTagsContents .= "\n".'Senior'."\n".'High School'; 			$ageCodesContents .= "\n".'M'; }
	
	// determine search field contents (field is typically modified via the publish script in the database)
	//platforms, subjects, ages, grades, links
	$searchFieldContents;
	if($editorialtitle != NULL)     { $searchFieldContents .= "\n".$editorialtitle; }
	if($editorialcopyright != NULL) { $searchFieldContents .= "\n".$editorialcopyright; }
	if($editorialcompany != NULL)   { $searchFieldContents .= "\n".$editorialcompany; }
	if($editorialissue != NULL)		{ $searchFieldsContents .= "\n".$editorialissue; }
	if($editorialweekly != NULL)	{ $searchFieldsContents .= "\n".$editorialweekly; }
	if($ageTagsContents != NULL)    { $searchFieldContents .= "\n".$ageTagsContents; }
	if($editorialgrades != NULL)	{ $searchFieldContents .= "\n".$editorialgrades; }
	
	if($editorialsubjects != NULL) 	{ $searchFieldContents .= "\n".$editorialsubjects; }
	else if($editorialsubjectsParsed != NULL) 	{ $searchFieldContents .= "\n".$editorialsubjectsParsed; }
	
	if($editorialplatforms != NULL) { $searchFieldContents .= "\n".$editorialplatforms; }
	else if($editorialplatformsParsed != NULL) 	{ $searchFieldContents .= "\n".$editorialplatformsParsed; }
	
	if($editorialtopics != NULL) 	{ $searchFieldContents .= "\n".$editorialtopics; }
	else if($editorialtopicsParsed != NULL) 	{ $searchFieldContents .= "\n".$editorialtopicsParsed; }
	
	if($editoriallanguages != NULL) { $searchFieldContents .= "\n".$editoriallanguages; }
	else if($editoriallanguagesParsed != NULL) 	{ $searchFieldContents .= "\n".$editoriallanguagesParsed; }
	
	if($editorialscaffolding != NULL) { $searchFieldContents .= "\n".$editorialscaffolding; }
	else if($editorialscaffoldingParsed != NULL) { $searchFieldContents .= "\n".$editorialscaffoldingParsed; }
	
	if($editoriallanguageNotes != NULL)	{ $searchFieldContents .= "\n".$editoriallanguageNotes; }
	/*
	CSR::Title & ¶ & 
	CSR::Company & ¶ & 
	CSR::issueAbbr & ¶ & 
	CSR::ageTags & ¶ & 
	CSR::Grade Level & ¶ & 
	CSR::teaches text & ¶ & 
	CSR::Language Text & ¶ & 
	CSR::Scaffolding Text & ¶ & 
	CSR::platform text & ¶ & 
	CSR::recommendations & ¶ & 
	CSR::tagField
	*/
	// set deepsearch field contents to regular search field contents plus review text
	$deepsearchContents = $searchFieldContents."\n".$editorialreviewText;
	
	if($debug == true)
	{
		echo '<br/>';
		echo '$ageTagsContents: '.$ageTagsContents.'<br/><br/>';
		echo '$ageCodesContents: '.$ageCodesContents.'<br/><br/>';
		echo '$searchFieldContents: '.$searchFieldContents.'<br/><br/>';
		echo '$deepsearchContents: '.$deepsearchContents.'<br/><br/>';

		echo '$evaluationRubric: '.$evaluationRubric.'<br/>';
	} // end if $debug
	//exit();
	
	// lookup the review record and update the review text
	// note: cannot use getRecordById method, as CSR::reviewnumber (field used for CTREX links) does not correspond to the actual recordID
	if($editorialtype == 'edit')
	{
		$findReview = $fmreviews->newFindCommand($fmreviewsLayout);
		$findReview->addFindCriterion('reviewnumber',"==".$reviewID);
		$result = $findReview->execute();
		if (FileMaker::isError ($result) ) { echo $result->getMessage(); exit(); }
		$editReview = $result->getFirstRecord();
		
		// gate out students/jurors attempting to access unauthorized reviews (both can enter new and edit own; jurors can edit current entries)
        $authorID 		= $editReview->getField('subsScreenName::globalID');
        $bolognaYear 	= $editReview->getField('bolognaYear');
        $kapiYear 		= $editReview->getField('kapiYear');
        if($student == true and $authorID != $userID) 													{ require 'php/redirect-home.php'; }
        if($juror == true and $authorID != $userID and $bolognaYear != $year and $kapiYear != $year) 	{ require 'php/redirect-home.php'; }
	
	} // end if $editorialtype == 'edit'
	else if($editorialtype == 'new')
	{
		$editReview = $fmreviews->createRecord($fmreviewsLayout);
	}
	
	// set fields
	if($editorialtype == 'new') 
	{ 
		// set authorship for new product entries
		if($mod == true) { $authorType = 'CTR'; } else if($expert == true) { $authorType = 'Expert'; }
		$editReview->setField('author', $username);
		$editReview->setField('authorType', $authorType);
	} // end if $editorialtype == 'new'
	else { $editReview->setField('edited', $username); } // set CSR::edited field if editing existing
	$editReview->setField('published', $editorialstatus);
	$editReview->setField('CTR Issue', $editorialissue);
	$editReview->setField('weekly', $editorialweekly);
	
	$editReview->setField('Title', $editorialtitle);
	$editReview->setField('Copyright Date', $editorialcopyright);
	$editReview->setField('Company', $editorialcompany);
	$editReview->setField('Price', $editorialprice);
	$editReview->setField('fileSize', $editorialfilesize);
	$editReview->setField('Age Range', $editorialages);
	$editReview->setField('Grade Level', $editorialgrades);
	
	$editReview->setField('Platform', $editorialplatformsParsed);
	$editReview->setField('Teaches', $editorialsubjectsParsed);
	$editReview->setField('recommendations', $editorialtopicsParsed);
	$editReview->setField('Language List', $editoriallanguagesParsed);
	$editReview->setField('Scaffolding List', $editorialscaffoldingParsed);
	
	$editReview->setField('Language Notes', $editoriallanguageNotes);
	
	$editReview->setField('itunes code', $editoriallinkItunes);
	$editReview->setField('Android code', $editoriallinkAndroid);
	$editReview->setField('amazon', $editoriallinkAmazon);
	$editReview->setField('steam code', $editoriallinkSteam);
	$editReview->setField('video', $editoriallinkVideo);
	
	$editReview->setField('Web Site Comments Field', $editorialreviewText);
	$editReview->setField('clipboard', $editorialreviewNotes);
	
	$editReview->setField('rating1', $editorialstandardQA1);
	$editReview->setField('rating2', $editorialstandardQA2);
	$editReview->setField('rating3', $editorialstandardQA3);
	$editReview->setField('rating4', $editorialstandardQA4);
	$editReview->setField('rating5', $editorialstandardQA5);
	
	// DEBUG OUTPUT RUBRIC QA INPUTS
	// name, index, rating, weight
	if($debug == true)
	{
		foreach($evaluationQA as $thisInputQA)
		{
			$thisInputQAName 	= $thisInputQA[0];
			$thisInputQAIndex 	= $thisInputQA[1];
			$thisInputQARating 	= $thisInputQA[2];
			$thisInputQAWeight 	= $thisInputQA[3];
			echo '$thisInputQAName: '.$thisInputQAName.' ('.$thisInputQAIndex.') - '.$thisInputQARating.'<br/>';
		} // end foreach $evaluationQA
	} // end if $debug
	//exit();
	
	// set the ratings and weights for a flex-rubric evaluation if one was submitted
	if($evaluationQA != NULL)
	{
		foreach($evaluationQA as $thisInputQA)
		{
			// get the form inputs
			$thisInputQAName 	= $thisInputQA[0];
			$thisInputQAIndex 	= $thisInputQA[1];
			$thisInputQARating 	= $thisInputQA[2];
			$thisInputQAWeight 	= $thisInputQA[3];
			
			// scale the rating for database use
			if($thisInputQARating != NULL) 	{ $thisInputQARating = round(($thisInputQARating/10), 2); }
			else							{ $thisInputQARating = ''; }
			
			// determine the name of the field for each rating and weight
			$thisInputQARatingField	= 'rating'.$thisInputQAIndex;
			$thisInputQAWeightField	= 'weight'.$thisInputQAIndex;
			
			// set the fields for rating and weight if index provided
			if($thisInputQAIndex != NULL and $thisInputQARating != NULL) 
			{ 
				$editReview->setField($thisInputQARatingField, $thisInputQARating);
				$editReview->setField($thisInputQAWeightField, $thisInputQAWeight);
			} // end if $thisInputQAIndex
		} // end foreach $evaluationQA
	} // end if $evaluationQA
	
	// update the rubric checkbox set
	if($evaluationRubric != NULL)
	{
		// get the existing record value for th rubrics field to check rubric used against
		$recordRubrics	 	= $editReview->getField('rubrics');
		$recordRubricsText 	= $editReview->getField('rubricsText');
		$recordRubricsArray = explode(', ', $recordRubricsText);
		
		// only update the 'rubrics' field in the database if the rubric used for the evaluation is not already checked
		if(!in_array($evaluationRubric, $recordRubricsArray))
		{
			// if existing values, add a new line and new rubric
			if($recordRubricsText != NULL) 
			{
				$updatedRubrics 	= $recordRubrics."\n".$evaluationRubric; // line-break separated list for CSR::rubrics (checkbox field)
				$updatedRubricsText = $recordRubricsText.', '.$evaluationRubric; // comma separated list for CSR::rubricsText
			} // end if $recordRubricsText
			
			// otherwise, just set to new rubric
			else
			{
				$updatedRubrics 	= $evaluationRubric; // line-break separated list for CSR::rubrics (checkbox field)
				$updatedRubricsText = $evaluationRubric; // comma separated list for CSR::rubricsText
			}
			$editReview->setField('rubrics', $updatedRubrics); // set the field with the updated value
		} // end if !in_array
		else
		{
			if($debug == true)
			{
				echo '$evaluationRubric is already checked<br/>';
			} // end if $debug
		} // end else $evaluationRubric is already checked in db
	} // end if $evaluationRubric
	if($debug == true)
	{
		echo '$recordRubrics: '.$recordRubrics.'<br/>';
		echo '$recordRubricsText: '.$recordRubricsText.'<br/>';
		echo '$recordRubricsArray: '.$recordRubricsArray.'<br/>';
		foreach($recordRubricsArray as $thisRecordRubric) { echo $thisRecordRubric.'<br/>'; }
		echo '<br/>';
		echo '$updatedRubrics: '.$updatedRubrics.'<br/>';
		echo '$updatedRubricsText: '.$updatedRubricsText.'<br/>';
	} // end if $debug
	//exit();
	
	$editReview->setField('ageTags', $ageTagsContents);
	$editReview->setField('ageCodes', $ageCodesContents);
	$editReview->setField('searchField', $searchFieldContents);
	$editReview->setField('deepsearch', $deepsearchContents);
	
	// EDITOR'S CHOICE
	$recordWhereisit = $editReview->getField('whereisit');
	
	// if CSR::whereisit has values
	if($recordWhereisit != NULL)
	{
		// if none of those values is Editor's Choice, the add value appends to the existing value
		if(substr_count($recordWhereisit, 'Editor\'s Choice') == 0) { $addEdChoice 	= $recordWhereisit."\n".'Editor\'s Choice'; }
		
		// if already marked with Editor's Choice, the add value is just the field as it is 
		else { $addEdChoice = $recordWhereisit; }
		
		// the remove value replaces instances of Editor's Choice with nothing
		$removeEdChoice	= str_replace('Editor\'s Choice', '', $recordWhereisit);
		//if(substr_count($recordWhereisit, 'Editor\'s Choice') == 0) { $editReview->setField('whereisit', $recordWhereisit."\n".'Editor\'s Choice'); }
	} // end if $recordWhereisit
	
	// if CSR::whereisit is empty
	else
	{
		// the add and remove values are just Editor's Choice and nothing if the field is empty
		$addEdChoice 	= 'Editor\'s Choice';
		$removeEdChoice = '';
	}
	
	// set the CSR::whereisit field based on whether edchoice was marked - CSR::edChoice is a calc based on CSR::whereisit
	if($editorialedchoice == true) 	{ $editReview->setField('whereisit', $addEdChoice); } 
	else							{ $editReview->setField('whereisit', $removeEdChoice); }
	
	// set the CSR::ethical field based on whether ethical was marked
	if($editorialethical == true) 	{ $editReview->setField('ethical', 'Ethical'); }
	else							{ $editReview->setField('ethical', ''); }
	
	$commit = $editReview->commit();
	if ( FileMaker::isError ($commit) ) { echo 'Error:'.$commit->getMessage(); exit(); }
	
	// add these fields as a second commit, as they are set to auto-enter calculation, and would revert to line break format if entered all at once
	$editReview->setField('platform text', $editorialplatforms);
	$editReview->setField('teaches text', $editorialsubjects);
	$editReview->setField('recommendations text', $editorialtopics);
	$editReview->setField('Language Text', $editoriallanguages);
	$editReview->setField('Scaffolding Text', $editorialscaffolding);
	$editReview->setField('Language Notes', $editoriallanguageNotes);
	if($evaluationRubric != NULL and !in_array($evaluationRubric, $recordRubricsArray)) { $editReview->setField('rubricsText', $updatedRubricsText); }
	$commit = $editReview->commit();
	if($editorialtype == 'new') { $reviewID = $editReview->getField('reviewnumber'); } // get the review number for redirect purposes if new entry
	if ( FileMaker::isError ($commit) ) { echo 'Error:'.$commit->getMessage(); exit(); }
	
	// set the redirect destination as the review page
	$redirect = 'review.php?id='.$reviewID;
	
	// set a flag to display a confirmation message
	$_SESSION['editorial-confirmation'] = true;
	
	// create a notification record in the database
	$summary = $fullName.' edited the review for '.$editorialtitle.' using the Editorial Panel.';
	$summary .= "\n"."\n".'CTREX Link: https://reviews.childrenstech.com/ctr/review.php?id='.$reviewID;
	$summary .= "\n".'Local Link: https://local.childrenstech.com/ctr/review.php?id='.$reviewID;
	$inputName 		= $fullName;
	$inputEmail 	= '';
	$emailSubject = 'CSR Record Updated via CTREX Editorial Panel'; 
	$emailMessage 	= $summary."\n".'IP: '.$ip;
	require_once 'php/message-create.php';
	
} // end else if isset review-editorial

// REDIRECT HOME IF PAGE ACCESSED WITHOUT PROPER FORM SUBMISSION
else
{
	$redirect = 'home.php';
}
require_once 'php/redirect.php'; exit();
?>