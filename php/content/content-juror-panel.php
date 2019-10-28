<?php
/*
php/content/content-juror-panel.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the juror's panel page (for evaluating products for awards)
*/

// gate out anyone who is not an expert or a moderator -----------
if($expert != true and $mod != true and $juror != true) { $redirect = 'home.php'; require 'php/redirect.php'; exit(); } 

// GET PARAMETERS ------------------------------------------------
$awardType 	= test_input($_GET['type']);
$awardYear 	= test_input($_GET['year']);
if($awardYear == NULL) { $awardYear = $year; } // default to current year if not specified
if($awardType == NULL) { $redirect = 'awards.php'; require 'php/redirect.php'; exit(); } // redirect back to award page if type not specified

// LOOKUP TITLES FOR AWARD TYPE & YEAR ---------------------------
// CONSTRUCT FIND - BOLOGNA
if($awardType == 'bologna')
{
	$findTitles = $fmreviews->newFindCommand($fmreviewsLayout);
	$findTitles->addFindCriterion('bolognaYear', $awardYear);
	$findTitles->addSortRule('bolognaYear', 1, FILEMAKER_SORT_DESCEND);
	$findTitles->addSortRule('Title', 2, FILEMAKER_SORT_ASCEND);
} // end if bologna

// CONSTRUCT FIND - KAPI
if($awardType == 'kapi')
{
	$findTitles = $fmreviews->newFindCommand($fmreviewsLayout);
	$findTitles->addFindCriterion('kapiYear', $awardYear);
	$findTitles->addSortRule('kapiYear', 1, FILEMAKER_SORT_DESCEND);
	$findTitles->addSortRule('Title', 2, FILEMAKER_SORT_ASCEND);
} // end if kapi

// EXECUTE FIND
$result = $findTitles->execute();
if(FileMaker::isError($result)) { echo 'Error: '.$result->getMessage(); exit(); }
$records = $result->getRecords();

// DETERMINE NUMBER OF RESULTS
$numEntries = $result->getFoundSetCount();

// CHECK CONFIRMATION
$jurorPanelConfirmation = $_SESSION['juror-panel-confirmation']; 	// check confirmation flag for juror's panel edit
$_SESSION['juror-panel-confirmation'] = ''; 						// reset the flag

// whether to show confirmation
if($jurorPanelConfirmation == true) { $confirmationClass = 'show'; } else { $confirmationClass = 'hide'; } 

// PAGE CONTAINER
echo '<div id = "juror-panel-page-container">';

// CONFIRMATION
echo '<div class = "'.$confirmationClass.'">';
    echo '<div class = "confirmation-message text-24">Juror Panel Form Successfully Submitted</div>';
echo '</div>'; // /.$confirmationClass (show/hide) -->
		
// PAGE HEADER
if($awardType == 'bologna') { $awardTypeLabel = 'BolognaRagazzi Digital Award'; } else if($awardType == 'kapi') { $awardTypeLabel = 'KAPi Awards'; }
echo '<div class = "review-title top-10 bottom-10">'.$awardYear.' '.$awardTypeLabel.' Juror\'s Panel </div>';

// DEBUG STORAGE SCRIPT
//echo '<div><button type = "button" onclick = "jurorPanelStore();">Test Storage</button></div><br/>';

// EDITORIAL INDICATOR
echo '<div class = "juror-panel-heading">';
    echo 'Judging as ';
         if($mod == true) 		{ echo 'Moderator '; } 
    else if($expert == true) 	{ echo 'Expert '; } 
    else if($juror == true) 	{ echo 'Juror '; if($jurorNumber != NULL) { echo ' #'.$jurorNumber.' '; } } 
    echo '<a href = "'.$profileURL.'">'.$fullName.'</a>';
echo '</div>'; // /.editorial-heading

// DISPLAY TABLE OF TITLES WITH SET OF FORM FIELDS
echo '<div class = "review-heading">Entries</div>';
echo '<form id = "juror-evaluation form" name = "juror-evaluation-form" method = "POST" action = "juror-process.php">';
$fields = $reviewFields; // tells 'php/get-field.php to use the $reviewFields array'
$titleN = -1; // counter for iterating through field id values
foreach($records as $record)
{
    require 'php/get-field.php'; // get field values and assign to variables with dynamic names as specified by $reviewFields array
	
	// OUTPUT ROW WITH TITLE AND FIELDS
	$titleN += 1; // increment counter for iterating through field id values
    echo '<div class = "juror-panel-item">';
	
		// IMAGE
		echo '<div class = "juror-panel-img">';
			if($thumbnail != NULL and $thumbdata != '?') 
			{ 
				echo '<a href = "review.php?id='.$reviewnumber.'" class = "text-18" title = "Read the review for '.$title.'">';
					echo '<img src = "php/img.php?-url='.urlencode($thumbnail).'" >';
				echo '</a>';
			} // end if image
		echo '</div>';
	
		// TITLE
    	echo '<div class = "juror-panel-title">';
			echo '<a href = "review.php?id='.$reviewnumber.'" class = "text-18" title = "Read the review for '.$title.'">'.$title.'</a>';
			echo '<input type = "hidden" name = "reviewnumber-'.$titleN.'" 	id = "reviewnumber-'.$titleN.'" value = "'.$reviewnumber.'"/>';
			echo '<input type = "hidden" name = "title-'.$titleN.'"			 id = "title-'.$titleN.'" 		value = "'.$title.'"/>';
			if($company != NULL)
			{
				echo '<div class = "text-14">by ';
					if($publisherWebsite != NULL) { echo '<a href = "http://'.$publisherWebsite.'" title="View the web site for '.$company.'" target="_blank">'; }
					echo $company;
					if($publisherWebsite != NULL) { echo '</a>'; }
				echo '</div>';
			} // end if $company
			if($bolognaGenre != NULL and $awardType == 'bologna')
			{ 
				if($bolognaGenre == 'fict') { $bolognaGenreLabel = 'Fiction'; }
				if($bolognaGenre == 'non')	{ $bolognaGenreLabel = 'Non-Fiction'; }
				echo '<div class = "text-14">('.$bolognaGenreLabel.')</div>';
			} // end if $bolognaGenre
			//echo '$titleN: '.$titleN;
		echo '</div>';
		
		// RADIO BTNS
		echo '<div class = "juror-panel-btns">';
			echo '<div class = "bottom-10">';
                echo '<div class = "inline"><input type = "radio" name="yn-'.$titleN.'" id="yes-'.$titleN.'"   value = "Yes"/></div>';
                echo '<div class = "inline left-5 right-10">Yes</div>';
                echo '<div class = "inline"><input type = "radio" name="yn-'.$titleN.'" id="no-'.$titleN.'"    value = "No"/></div>';
                echo '<div class = "inline left-5 right-10">No</div>';
                echo '<div class = "inline"><input type = "radio" name="yn-'.$titleN.'" id="maybe-'.$titleN.'" value = "Maybe"/></div>';
                echo '<div class = "inline left-5 right-10">Maybe</div>';
			echo '</div>';
			if($awardType == 'bologna')
			{
				echo '<div>';
					echo '<div class = "inline"><input type = "checkbox" name="mention-'.$titleN.'" id="mention-'.$titleN.'"    value = "Mention"/></div>';
                    echo '<div class = "inline left-5 right-10">Mention</div>';
					echo '<div class = "inline"><input type = "checkbox" name="shortlist-'.$titleN.'" id="shortlist-'.$titleN.'"   value = "Short List"/></div>';
                    echo '<div class = "inline left-5 right-10">Short List</div>';
				echo '</div>';
			} // end if $awardType == 'bologna'
		echo '</div>'; //.inline width-30 (yes/no/maybe radio btns)
		
		// COMMENTS TEXTAREA
		echo '<div class = "juror-panel-comments">';
			echo '<textarea name = "juror-comments-'.$titleN.'" id = "juror-comments-'.$titleN.'" rows = "3" placeholder = "Add a comment..."></textarea>';
		echo '</div>'; //.inline width-30 (comments textarea)
		
    echo '</div>'; // /.paragraph bottom-10
	
} // end foreach record

echo '<br/><br/>';

// IF KAPI, TEXTAREAS FOR RANKINGS, PIONEERS
if($awardType == 'kapi')
{

	// RANKINGS
	echo '<div class = "review-heading bottom-10">Rankings</div>';
	echo '<div class = "paragraph bottom-20">';
		echo '<textarea name = "kapi-rankings" id = "kapi-rankings" rows = "8" placeholder = "Please provide your ranking of the entries:"></textarea>';
	echo '</div>';
	
	// PIONEERS
	echo '<div class = "review-heading bottom-10">Pioneers</div>';
	echo '<div class = "paragraph bottom-20">';
		echo '<textarea name = "kapi-pioneers" id = "kapi-pioneers" rows = "8" placeholder = "Please list any nominations for pioneer awards:"></textarea>';
	echo '</div>';
	
} // end if kapi

// DISCARD, SUBMIT BTNS
echo '<div class = "paragraph center">';

	// DISCARD
	echo '<div class = "inline right-10">';
		echo '<button type = "button" onclick = "discardJurorPanel(\''.$awardType.'\')">Discard</button>';
	echo '</div>';
	
	// SUBMIT
	echo '<div class = "inline right-10">';
		echo '<input type = "submit" name = "submitJurorPanel" value = "Submit" />';
		echo '<input type = "hidden" name = "awardType" 	id = "award-type" 	value = "'.$awardType.'"/>';
		echo '<input type = "hidden" name = "awardYear" 	id = "award-year" 	value = "'.$awardYear.'"/>';
		echo '<input type = "hidden" name = "numEntries" 	id = "num-entries"	value = "'.$numEntries.'"/>';
	echo '</div>'; // /.inline right-10
	
echo '</div>'; // /.paragraph center

echo '</form>'; // /#juror-evaluation-form

echo '</div>'; // /#juror-panel-page-container
?>
