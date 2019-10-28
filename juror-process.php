<?php
/*
juror-process.php
By Matthew DiMatteo, Children's Technology Review

This file processes the form on the Juror's Panel page 'juror-panel.php'

*/
$pageTitle 	= 'Processing...';		// placed inside html <title> tag
$pageType 	= 'redirect';			// indicates to 'php/autoload.php' not to include 'php/document.php'
$searchType	= 'reviews';			// determines which form the main searchbar targets
require_once 'php/autoload.php';	// includes all necessary files for outputting the page

// gate out anyone who is not an expert or a moderator -----------
if($expert != true and $mod != true and $juror != true) { $redirect = 'home.php'; require 'php/redirect.php'; exit(); } 

if(isset($_POST['awardType']))
{	
	// get the hidden inputs for award type and number of entries
	$awardType = test_input($_POST['awardType']);
	$awardYear = test_input($_POST['awardYear']);
	$numEntries= test_input($_POST['numEntries']);
	
	// determine the names of the database fields to set based on award type and juror number
    if($awardType == 'bologna') { $fieldPrefix = 'brda'; }
    if($awardType == 'kapi')	{ $fieldPrefix = 'kapi'; }
    if($jurorNumber < 10) 		{ $jurorNumberSuffix = '0'.$jurorNumber; }
    else						{ $jurorNumberSuffix = $jurorNumber; }
    $jurorIDFieldName	= $fieldPrefix.'JurorID'.$jurorNumberSuffix;
    $ynFieldName 		= $fieldPrefix.'YNJ'.$jurorNumberSuffix;
    $commentsFieldName 	= $fieldPrefix.'CommentsJ'.$jurorNumberSuffix;
    $mentionFieldName = 'brdaMentionJ'.$jurorNumberSuffix;
    $shortListFieldName = 'brdaShortListJ'.$jurorNumberSuffix;
	
	// for kapi judging, get the rankings and pioneers inputs
	if($awardType == 'kapi')
	{
		$rankings = test_input($_POST['kapi-rankings']);
		$pioneers = test_input($_POST['kapi-pioneers']);
	} // end if kapi
	
	$submissionData = array(); // declare an array to store arrays of each entry's data
	
	// loop through the inputs for each entry, determine input names based on index number, and get input values
	for($i = 1; $i <= $numEntries; $i++)
	{
		// determine the name of the inputs for each entry
		$reviewIDInputName 	= 'reviewnumber-'.$i;
		$titleInputName 	= 'title-'.$i;
		$ynInputName 		= 'yn-'.$i;
		$commentsInputName 	= 'juror-comments-'.$i;
		$mentionInputName 	= 'mention-'.$i;
		$shortListInputName	= 'shortlist-'.$i;
		
		// get the field contents for the $ith entry
		$thisReviewID		= test_input($_POST[$reviewIDInputName]);
		$thisTitle			= test_input($_POST[$titleInputName]);
		$thisYN 			= test_input($_POST[$ynInputName]);
		$thisComment 		= test_input($_POST[$commentsInputName]);
		
		// get the mention and shortlist inputs if bologna judging
		if($awardType == 'bologna')
		{
			$thisMention	= test_input($_POST[$mentionInputName]);
			$thisShortList	= test_input($_POST[$shortListInputName]);
		} // end if bologna
		else
		{
			$thisMention 	= '';
			$thisShortList 	= '';
		}
		
		$thisEntryData = array(); // create an array to store data for each entry
		
		// add the input names to the entry data array
		array_push($thisEntryData, $reviewIDInputName);
		array_push($thisEntryData, $titleInputName);
		array_push($thisEntryData, $ynInputName);
		array_push($thisEntryData, $commentsInputName);
		array_push($thisEntryData, $mentionInputName);
		array_push($thisEntryData, $shortListInputName);
		
		// add the input values to the entry data array
		array_push($thisEntryData, $thisReviewID);
		array_push($thisEntryData, $thisTitle);
		array_push($thisEntryData, $thisYN);
		array_push($thisEntryData, $thisComment);
		array_push($thisEntryData, $thisMention);
		array_push($thisEntryData, $thisShortList);
		
		array_push($submissionData, $thisEntryData); // append array of entry data to overall submission data
		
		// UPDATE DATABASE
		//$jurorPanelDebug = true;
		if($jurorPanelDebug != true)
		{
            if($thisReviewID != NULL)
            {
                // lookup the review and set its fields
                $thisFind = $fmreviews->newFindCommand($fmreviewsLayout);
                $thisFind->addFindCriterion('reviewnumber', "==".$thisReviewID);
                $thisResult = $thisFind->execute();
                if (FileMaker::isError ($thisResult) ) { echo $thisResult->getMessage(); exit(); }
                $thisRecord = $thisResult->getFirstRecord();
				
                // set the fields
                $thisRecord->setField($jurorIDFieldName, $fullName); // determined in 'php/session.php'
                $thisRecord->setField($ynFieldName, $thisYN);
                $thisRecord->setField($commentsFieldName, $thisComment);
				
                // also do mentions and shortlist if bologna
                if($awardType == 'bologna')
                {
                    $thisRecord->setField($mentionFieldName, $thisMention);
                    $thisRecord->setField($shortListFieldName, $thisShortList);
                } // end if bologna
				
                // commit the record
                $commit = $thisRecord->commit();
                if ( FileMaker::isError ($commit) ) { echo 'Error:'.$commit->getMessage(); exit(); }
				
            } // end if $thisReviewID != NULL
		} // end if !debug
		
	} // end for $i <= $numEntries
	
	// THEN FIGURE OUT HOW TO SET RANKINGS, PIONEERS FOR KAPI JUDGINGS
	if($awardType == 'kapi')
	{
		// determine field names based on juror number
		$rankingsFieldName = 'rankingsJ'.$jurorNumberSuffix;
		$pioneersFieldName = 'pioneersJ'.$jurorNumberSuffix;
		
		// lookup this year's kapi award in the kapi table
		$findKapi = $fmkapi->newFindCommand($fmkapiLayout);
		$findKapi->addFindCriterion('year', $awardYear);
		$kapiResult = $findKapi->execute();
        if (FileMaker::isError ($kapiResult) ) { echo $kapiResult->getMessage(); exit(); }
        $kapiRecord = $kapiResult->getFirstRecord();
		
		// set the fields
		$kapiRecord->setField($rankingsFieldName, $fullName.'\'s Rankings: '."\n"."\n".$rankings);
		$kapiRecord->setField($pioneersFieldName, $fullName.'\'s Pioneers: '."\n"."\n".$pioneers);
		
		// commit the record
        $commit = $kapiRecord->commit();
        if ( FileMaker::isError ($commit) ) { echo 'Error:'.$commit->getMessage(); exit(); }
		
	} // end if $awardType == 'kapi'
	
	// SET REDIRECT DESTINATION TO JUROR PANEL
	$redirect = 'juror-panel.php?type='.$awardType.'&year='.$awardYear;
	
	// SET CONFIRMATION FLAG
	$_SESSION['juror-panel-confirmation'] = true;
	
	// SET MESSAGE
	$summary 		= $fullName.' (Juror #'.$jurorNumber.') performed a Juror\'s Panel submission for the '.$awardYear.' ';
	if($awardType == 'bologna') { $summary .= 'BolognaRagazzi Digital Award'; }
	if($awardType == 'kapi')	{ $summary .= 'KAPi Awards'; }
	$summary .= ':'."\n"."\n";
	foreach($submissionData as $thisEntry)
    {
        $thisReviewIDValue	= $thisEntry[6];
        $thisTitleValue		= $thisEntry[7];
        $thisYNValue		= $thisEntry[8];
        $thisCommentsValue	= $thisEntry[9];
        $thisMentionValue	= $thisEntry[10];
        $thisShortListValue	= $thisEntry[11];
		
		$summary .= $thisTitleValue.': '.$thisYNValue;
        if($thisMentionValue != NULL) 	{ $summary .= ' (Mention)'; }
        if($thisShortListValue != NULL) { $summary .= ' (Short List)'; }
		$summary .= "\n".'Comments: '.$thisCommentsValue."\n"."\n";
    } // end foreach entry
	
	$summary .= "\n";
	
	if($rankings != NULL) { $summary .= 'Rankings: '."\n".$rankings."\n"."\n"; }
	if($pioneers != NULL) { $summary .= 'Pioneers: '."\n".$pioneers."\n"."\n"; }
	
	$inputName 		= $fullName;
	$inputEmail 	= '';
	$emailSubject 	= 'Juror Panel Submission'; 
	$emailMessage 	= $summary."\n".'IP: '.$ip;
	require_once 'php/message-create.php';
	
	// DEBUG OUTPUT
	if($jurorPanelDebug == true)
	{
        // DEBUG OUTPUT
        echo 'Juror Info:<br/>';
        echo '$jurorNumber: '.$jurorNumber.'<br/>';
        echo '$fullName: '.$fullName.'<br/>';
        echo '<br/>';

        echo 'Judging Info:<br/>';
        echo '$awardType: '.$awardType.'<br/>';
        echo '$awardYear: '.$awardYear.'<br/>';
        echo '$numEntries: '.$numEntries.'<br/>';
        echo '$redirect: '.$redirect.'<br/>';
        echo '<br/>';

        echo 'Field Name Calculations:<br/>';
        echo '$fieldPrefix: '.$fieldPrefix.'<br/>';
        echo '$jurorNumberSuffix: '.$jurorNumberSuffix.'<br/>';
        echo '$jurorIDFieldName: '.$jurorIDFieldName.'<br/>';
        echo '$ynFieldName: '.$ynFieldName.'<br/>';
        echo '$commentsFieldName: '.$commentsFieldName.'<br/>';
        echo '$mentionFieldName: '.$mentionFieldName.'<br/>';
        echo '$shortListFieldName: '.$shortListFieldName.'<br/>';
        echo '<br/>';

        echo 'KAPi Textareas:<br/>';
        echo '$rankings: '.$rankings.'<br/>';
        echo '$pioneers: '.$pioneers.'<br/>';
        echo '<br/>';

        echo 'Submission Data:<br/>';
        foreach($submissionData as $thisEntry)
        {
            $thisReviewIDInput 	= $thisEntry[0];
			$thisTitleInput 	= $thisEntry[1];
            $thisYNInput		= $thisEntry[2];
            $thisCommentsInput	= $thisEntry[3];
            $thisMentionInput	= $thisEntry[4];
            $thisShortListInput	= $thisEntry[5];

            $thisReviewIDValue	= $thisEntry[6];
			$thisTitleValue		= $thisEntry[7];
            $thisYNValue		= $thisEntry[8];
            $thisCommentsValue	= $thisEntry[9];
            $thisMentionValue	= $thisEntry[10];
            $thisShortListValue	= $thisEntry[11];

            echo '$thisReviewIDInput:'.$thisReviewIDInput.'<br/>';
            echo '$thisReviewIDValue:'.$thisReviewIDValue.'<br/>';
            echo '$thisYNInput:'.$thisYNInput.'<br/>';
            echo '$thisYNValue:'.$thisYNValue.'<br/>';
            echo '$thisCommentsInput:'.$thisCommentsInput.'<br/>';
            echo '$thisCommentsValue:'.$thisCommentsValue.'<br/>';
            echo '$thisMentionInput:'.$thisMentionInput.'<br/>';
            echo '$thisMentionValue:'.$thisMentionValue.'<br/>';
            echo '$thisShortListInput:'.$thisShortListInput.'<br/>';
            echo '$thisShortListValue:'.$thisShortListValue.'<br/>';
            echo '<br/>';
        } // end foreach entry
    } // end if debug
	
} // end if isset awardType

// if form not submitted properly, redirect to the award page
else
{
	if($jurorPanelDebug == true) { echo 'form not submitted properly'; }
	$redirect = 'award.php?type='.$awardType.'&year='.$awardYear;
} // end else !isset

// perform the redirect back to the juror's panel
if($jurorPanelDebug != true) { require_once 'php/redirect.php'; }
?>