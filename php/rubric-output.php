<?php
/*
php/rubric-output.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the rubric evaluation form, including"
- the table headin
- print-friendly heading
- each quality attribute control
- total score
- comment textarea and form submission area (if a review is being evaluated)

It is included in the files 'php/content/content-rubrics.php' and 'php/content/content-rubric-create.php'
*/

// $rubricOutputClass determined in 'php/rubric-controls.php' before including this file
echo '<div id = "rubric-output-container" class = "'.$rubricOutputClass.'">';
echo '<br/>';

// OUTPUT QA HEADING
echo '<div class = "qa-heading">';
	echo '<div class = "qa-mobile-row-1">';
		echo '<div class = "qa-reset"></div>';
		echo '<div class = "qa-name">Quality Attribute</div>';
	echo '</div>';
	echo '<div class = "qa-mobile-row-2">';
		echo '<div class = "qa-rating">Rating</div>';
		echo '<div class = "qa-inc-dec"></div>';
		echo '<div class = "qa-output"></div>';
		echo '<div class = "qa-weight">Importance</div>';
		echo '<div class = "qa-inc-dec"></div>';
		echo '<div class = "qa-output"></div>';
	echo '</div>';
echo '</div>'; // /.qa-heading

// PRINT-FRIENDLY FORM HEADING
echo '<div class = "qa-heading-print" id = "rubric-print-heading">';
	echo '<div class = "qa-heading-print-row">';
		echo '<div class = "qa-heading-print-label">Title:</div>';
		echo '<div class = "qa-heading-print-space-long"><div class = "print-line">&nbsp;</div></div>';
		echo '<div class = "qa-heading-print-label">Score:</div>';
		echo '<div class = "qa-heading-print-space-short"><div class = "print-line">&nbsp;</div></div>';
	echo '</div>'; // .qa-heading-print-row
	echo '<div class = "qa-heading-print-row">';
		echo '<div class = "qa-heading-print-label">Rubric:</div>';
		echo '<div class = "qa-heading-print-space-long"><div class = "print-line"><div class = "rubric-print-name">'.$selectedRubricName.'</div></div></div>';
		echo '<div class = "qa-heading-print-label"></div>';
		echo '<div class = "qa-heading-print-space-short"></div>';
	echo '</div>'; // .qa-heading-print-row
echo '</div>'; // /.qa-heading-print

// PRINT-FRIENDLY TABLE HEADING
echo '<div class = "qa-heading-print" id = "qa-print-heading">';
	echo '<div class = "qa-name-print">Quality Attribute</div>';
	echo '<div class = "qa-rating-print">Rating (Circle One)</div>';
	echo '<div class = "qa-weight-print"><div class = "qa-operator">x</div>Importance</div>';
	echo '<div class = "qa-score-print"><div class = "qa-operator">=</div>Points</div>';
echo '</div>'; // /.qa-heading-print

// SET FORM ACTION
if($thisPage == 'editorial.php') { $formAction = 'editorial-process.php'; } else { $formAction = 'review-process.php'; }

// FORM START
echo '<form name = "rubric-evaluation-form" id = "rubric-evaluation-form" method = "POST" action = "'.$formAction.'">';

	/* EDITORIAL INPUTS (HIDDEN)
		on form submission, js function editorialSubmit() in 'js/scripts.js' copies visible field values to these
		dynamically calculates input id values as "editorial" + id of visible input
	*/
	if($thisPage == 'editorial.php')
	{
		// label, name/id, value, type, required, note
		$fields = array
		(
			array('Edit Type'	, 'editorialtype'				, $editType			, 'hidden', false	, ''),
			
			array('Status'		, 'editorialstatus'				, $published		, 'hidden', false	, ''),
			array('Issue'		, 'editorialissue'				, $issue			, 'hidden', false	, ''),
			array('Weekly'		, 'editorialweekly'				, $weekly			, 'hidden', false	, ''),
			
			array('Title'		, 'editorialtitle'				, $title			, 'hidden', false	, ''),
			array('Copyright'	, 'editorialcopyright'			, $copyright		, 'hidden', false	, ''),
			array('Publisher'	, 'editorialcompany'			, $company			, 'hidden', false	, ''),
			array('Price'		, 'editorialprice'				, $price			, 'hidden', false	, ''),
			array('Filesize'	, 'editorialfilesize'			, $filesize			, 'hidden', false	, ''),
			array('Age Range'	, 'editorialages'				, $ages				, 'hidden', false	, ''),
			array('Grade Level'	, 'editorialgrades'				, $grades			, 'hidden', false	, ''),
			
			array('Platforms'	, 'editorialplatforms'			, $platforms		, 'hidden', false	, ''),
			array('Subjects'	, 'editorialsubjects'			, $subjects			, 'hidden', false	, ''),
			array('Topics'		, 'editorialtopics'				, $topics			, 'hidden', false	, ''),
			array('Languages'	, 'editoriallanguages'			, $languageList		, 'hidden', false	, ''),
			array('Scaffolding'	, 'editorialscaffolding'		, $scaffoldingList	, 'hidden', false	, ''),
			array('Language Notes', 'editoriallanguageNotes'	, $languageNotes	, 'hidden', false	, ''),
			
			array('Platforms'	, 'editorialplatformsOther'		, $platforms		, 'hidden', false	, ''),
			array('Subjects'	, 'editorialsubjectsOther'		, $subjects			, 'hidden', false	, ''),
			array('Topics'		, 'editorialtopicsOther'		, $topics			, 'hidden', false	, ''),
			array('Languages'	, 'editoriallanguagesOther'		, $languageList		, 'hidden', false	, ''),
			array('Scaffolding'	, 'editorialscaffoldingOther'	, $scaffoldingList	, 'hidden', false	, ''),
			
			array('iTunes Link'	, 'editoriallinkItunes'			, $linkItunes		, 'hidden', false	, ''),
			array('Android Link', 'editoriallinkAndroid'		, $linkAndroid		, 'hidden', false	, ''),
			array('Kindle Link'	, 'editoriallinkAmazon'			, $linkAmazon		, 'hidden', false	, ''),
			array('Steam Link'	, 'editoriallinkSteam'			, $linkSteam		, 'hidden', false	, ''),
			array('Video Link'	, 'editoriallinkVideo'			, $linkVideo		, 'hidden', false	, ''),
			
			array('Review Text'	, 'editorialreviewText'			, $reviewText		, 'hidden', false	, ''),
			array('Review Notes', 'editorialreviewNotes'		, $reviewNotes		, 'hidden', false	, ''),
			
            array('Standard QA1', 'editorialstandardQA1'		, $standardQA1  	, 'hidden', false   , ''),
            array('Standard QA2', 'editorialstandardQA2'		, $standardQA2  	, 'hidden', false   , ''),
            array('Standard QA3', 'editorialstandardQA3'		, $standardQA3  	, 'hidden', false   , ''),
            array('Standard QA4', 'editorialstandardQA4'		, $standardQA4  	, 'hidden', false   , ''),
            array('Standard QA5', 'editorialstandardQA5'		, $standardQA5  	, 'hidden', false   , ''),
			
			array('Awards'		, 'editorialawards'				, $awardsValue		, 'hidden', false	, ''),
		);
		require 'php/form-fields-output.php';
		$_SESSION['editorial-fields'] = $fields; // stored value accessed on 'editorial-process.php'
		
		// indicates to 'editorial-process.php' to process this form (as opposed to quick-edit form)
		echo '<input type = "hidden" name = "review-editorial" value = "review-editorial" />'; 
		
	} // end if $thisPage == editorial
	
	// HIDDEN INPUTS
	if($containsRubric == true) 	{ $submissionType = 'rubric'; }
	else 							{ $submissionType = 'quick-rating'; }
	if($thisPage == 'editorial.php'){ $submissionType = 'editorial'; }
	if($ctrRubric != NULL)			{ $selectedRubricType = 'ctr'; }
	else							{ $selectedRubricType = 'saved'; }
	echo '<input type = "hidden" name = "submission-type" 								value = "'.$submissionType.'" />';
	echo '<input type = "hidden" name = "redirect" 										value = "'.$thisURL.'" />';
	echo '<input type = "hidden" name = "review-id"			id = "review-id"			value = "'.$reviewID.'" />';
	echo '<input type = "hidden" name = "evaluated-title"	id = "evaluated-title"		value = "'.$title.'" />';
	echo '<input type = "hidden" name = "evaluation-rubric" id = "evaluation-rubric" 	value = "'.$selectedRubricName.'" />';
	echo '<input type = "hidden" name = "rubric-type" 		id = "rubric-type" 			value = "'.$selectedRubricType.'" />';
	echo '<input type = "hidden" name = "rubric-id" 		id = "rubric-id" 			value = "'.$savedRubricID.'" />';
	echo '<input type = "hidden" name = "num-qa" 			id = "num-qa" 				value = "'.$numQA.'" />';
	echo '<input type = "hidden" name = "score" 			id = "score"  />';

	// OUTPUT EACH QA
	$qaData = $selectedQAData; // the foreach loop that outputs each rubric in the selector overwrites $qaData - reset this to the QA for the selected rubric
	if($qaData != NULL) { require 'php/rating-qa.php'; } // outputs each qa

	// OUTPUT OVERALL RATING
	echo '<div class = "hide" id = "rubric-evaluation-total-container">';
		echo '<div id = "rubric-evaluation-total">';
			// RESET ALL
			echo '<div class = "inline thirds left"		id = "rubric-evaluation-total-left">';
				echo '<button type = "button" onclick = "resetRubric()">Reset All</button>';
			echo '</div>';
			// OUTPUT OVERALL RATING
			echo '<div class = "inline thirds center" 	id = "rubric-evaluation-total-center"><div id = "rubric-evaluation-score"></div></div>';
			// OFFSET
			echo '<div class = "inline thirds right" 	id = "rubric-evaluation-total-right"></div>';
		echo '</div>'; // /#rubric-evaluation-total
	echo '</div>'; // /.hide #rubric-evaluation-total-container

	// PRINT-FRIENDLY OVERALL RATING
	echo '<div class = "rubric-print-score">';

		// PTS EARNED
		echo '<div class = "print-score-row" id = "pts-earned-row">';
			echo '<div class = "print-score-label">Points Earned</div>';
			echo '<div class = "print-score-subtext">(Sum of Points Column)</div>';
			echo '<div class = "print-score-operator">=</div>';
			echo '<div class = "print-score-line">&nbsp;</div>';
		echo '</div>';

		// PTS POSSIBLE
		echo '<div class = "print-score-row" id = "pts-possible-row">';
			echo '<div class = "print-score-label">Points Possible</div>';
			echo '<div class = "print-score-subtext">(Sum of Importance Column x 10)</div>';
			echo '<div class = "print-score-operator">=</div>';
			echo '<div class = "print-score-line">&nbsp;</div>';
		echo '</div>';

		// OVERALL SCORE
		echo '<div class = "print-score-row" id = "overall-score-row">';
			echo '<div class = "print-score-label">Overall Score</div>';
			echo '<div class = "print-score-subtext">(Points Earned / Points Possible)</div>';
			echo '<div class = "print-score-operator">=</div>';
			echo '<div class = "print-score-line">%</div>';
		echo '</div>';

	echo '</div>'; // /.rubric-print-score

	// COMMENT FIELD FOR EVALUATIONS
	if($reviewID != NULL and $thisPage != 'editorial.php')
	{
		echo '<div class = "rubric-review-area">';
			echo '<textarea name="evaluation-review" id="rubric-evaluation-textarea" onkeyup="storeRubricReview()" rows="6" placeholder="Write a review (optional)"></textarea>';
		echo '</div>';

		echo '<div class = "center top-20" id = "rubric-evaluation-captcha">';
			echo '<div class = "width-20 inline">';
				$includeSubmit 	= true;
				$submitBtnName 	= 'rubric-evaluation-submit';
				$submitBtnLabel = 'Publish';
				$submitBtnHover = 'When published, this evaluation will display in the comments section of the page for this review';
				require_once 'php/captcha-min.php'; 
			echo '</div>'; // /.width-20 inline
		echo '</div>'; // /.center top-20 #rubric-evaluation-captcha

	} // end if $reviewID

echo '</form>';
// FORM END
//echo '<button type = "button" onclick = "loadWeightOutputs()">Load Weight Outputs</button>';
if($selectedRubric != $lastRubric) { echo '<script>resetRubric();</script>'; } // clear JS session storage of ratings/weights when rubric is changed
echo '</div>'; // /#rubric-output-container .$rubricOutputClass	
?>