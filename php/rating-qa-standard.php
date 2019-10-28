<?php
/*
php/rating-qa-standard
By Matthew DiMatteo, Children's Technology Review
*/

$qaN = 0;
foreach($qaData as $thisQA)
{
	$qaN += 1;
	$qaName 		= $thisQA[0];
	$qaType 		= $thisQA[1];
	$qaDescriptor	= $thisQA[2];
	$qaField		= $thisQA[3];
	$qaWeight		= $thisQA[4];
	$csrRating		= $thisQA[5];
	$csrRatingScaled = $csrRating * 10;
	if($csrRatingScaled == 0) { $csrRatingScaled = ''; }
	$csrWeight 		= $thisQA[6];
	$weightedRating	= $thisQA[7];
	$qaNumber		= str_replace('rating', '', $qaField);

	// OUTPUT QA FOR REVIEW

	// OUTPUT QA NAME, RATING VALUE
	/*
	if($csrRating == NULL or $csrRating == 'N' or $csrRating == 'N/A') { $csrRating = 'N'; }
	echo '<div class = "rating-qa-line">';
		echo '<div class = "inline rating-qa-name">'.$qaName.'</div>';
		echo '<div class = "inline rating-qa-value">'.$csrRating.'/10</div>';
	echo '</div>'; // /.rating-qa-line
	*/
	
	// determine css class for qa name based on string length
	$qaNameLength = strlen($qaName);
	if($qaNameLength <= 15) 						{ $qaNameClass = 'text-18'; }
	if($qaNameLength > 15 and $qaNameLength <= 20) 	{ $qaNameClass = 'text-16 top-1'; }
	if($qaNameLength > 20 and $qaNameLength <= 25) 	{ $qaNameClass = 'text-14 top-2'; }
	if($qaNameLength > 25 and $qaNameLength <= 30) 	{ $qaNameClass = 'text-13 top-3'; }
	if($qaNameLength > 30 and $qaNameLength <= 35) 	{ $qaNameClass = 'text-12 top-4'; }
	if($qaNameLength > 35) 							{ $qaNameClass = 'text-11 top-5'; }

	//echo 'Name = '.$qaName.', Length = '.$qaNameLength.', Class = '.$qaNameClass.'<br/>';

	// QA ITEM START
	echo '<div class = "rubric-qa-item" id = "standard-qa-item-'.$qaN.'">';

		// NAME
		echo '<div class = "standard-qa-name">';

			// HIDDEN INPUTS FOR NAME AND INDEX
			echo '<input type = "hidden" id = "standard-qa-name-'.$qaN.'" 	name = "qa-name-'.$qaN.'" 	value = "'.$qaName.'"/>';
			echo '<input type = "hidden" id = "standard-qa-index-'.$qaN.'" 	name = "qa-index-'.$qaN.'" 	value = "'.$qaNumber.'"/>';

			// NAME (DESCRIPTOR TOGGLE BTN)
			echo '<div class = "block"	id = "standard-qa-details-show-'.$qaN.'" title = "Expand description"
				onclick = "showItemN(\'standard-qa-details-show-\', \'standard-qa-details-hide-\', \'standard-qa-descriptor-\', '.$qaN.')">';
				echo '<div class = "btn-text"><div class = "'.$qaNameClass.'">'.$qaName.'</div></div>';
			echo '</div>';
			echo '<div class = "hide" 	id = "standard-qa-details-hide-'.$qaN.'" title = "Hide description"
				onclick = "hideItemN(\'standard-qa-details-show-\', \'standard-qa-details-hide-\', \'standard-qa-descriptor-\', '.$qaN.')">';
				echo '<div class = "btn-text"><div class = "'.$qaNameClass.'">'.$qaName.'</div></div>';
			echo '</div>';

		echo '</div>'; // /.standard-qa-name

		// RATING
		echo '<div class = "standard-qa-rating">';
			echo '<div class = "inline right-5">';
				echo '<input type = "radio" name = "standardQARating.'.$qaN.'" id = "standardQARating'.$qaN.'OptionN" value = "N"';
					if($csrRating == 'N') { echo ' checked '; }
					echo ' onchange = "ratingCalcStandard()" ';
				echo '/>';
			echo '</div>';
			echo '<div class = "inline right-10">N</div>';
			for($i = 0; $i <= 10; $i++)
			{
				echo '<div class = "inline right-5">';
					//echo '$i: '.$i;
					echo '<input type = "radio" name = "standardQARating.'.$qaN.'" id = "standardQARating'.$qaN.'Option'.$i.'" value = "'.$i.'" '; 
						if($csrRating != NULL and $csrRating == $i and $csrRating != 'N') { echo ' checked '; }
						echo ' onchange = "ratingCalcStandard()" ';
					echo '/>';
				echo '</div>';
				echo '<div class = "inline right-10">'.$i.'</div>';
			}
           	// echo 'standardQARating'.$qaN;
			//echo '<input type = "number"  min = "0" max = "10" step = "1" value = "'.$csrRating.'" onchange = "ratingCalcStandard()"/> /10';
			//echo '<br/>standardQA'.$qaN;
			echo '<input type = "hidden" name = "standardQA'.$qaN.'" id = "standardQA'.$qaN.'" value = "'.$csrRating.'" />';
		echo '</div>'; // /.standard-qa-rating
		
		// OUTPUT
		echo '<div class = "standard-qa-output">';
			echo '<div id = "standard-qa-output-'.$qaN.'">';
				if($csrRating != NULL) { echo $csrRating; if($csrRating != 'N') { echo '/10'; } }
			echo '</div>';
		echo '</div>'; // /.standard-qa-output

	echo '</div>'; // /.rubric-qa-item #qa-item-$qaN
	// QA ITEM END

	// DESCRIPTOR
	echo '<div class = "hide" id = "standard-qa-descriptor-'.$qaN.'">';
		echo '<div class = "qa-descriptor">';
			echo '<div class = "standard-qa-descriptor">'.$qaDescriptor.'</div>';
		echo '</div>';
	echo '</div>'; // /.hide #qa-descriptor-$qaN

	// PRINT ITEM
	echo '<div class = "rubric-qa-item-print">';
		echo '<div class = "qa-name-print"><div class = "qa-print-text">'.$qaName.'</div></div>';
		echo '<div class = "qa-rating-print">';
			echo '<div class = "qa-print-text">';
				$qaPrintRatings = array('N/A', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
				foreach($qaPrintRatings as $qaPrintRating) { echo '<div class = "qa-rating-print-item">'.$qaPrintRating.'</div>'; }
			echo '</div>';
		echo '</div>';
		echo '<div class = "qa-weight-print"><div class = "qa-print-text"><div class = "qa-operator">x</div>/10</div></div>';
		echo '<div class = "qa-score-print"><div class = "qa-operator">=</div></div>';
	echo '</div>'; // /.rubric-qa-item-print

} // end foreach qa

$standardOverallScore = $score;
if($standardOverallScore == NULL or $standardOverallScore == '?') { $standardOverallScore = ''; }

// OVERALL STANDARD SCORE HIDDEN FORM INPUT
echo '<input type = "hidden" name = "standard-overall-score" id = "standard-overall-score" value = "'.$standardOverallScore.'"/>';

// OVERALL STANDARD SCORE OUTPUT
echo '<div id = "standard-evaluation-total-container">';
	echo '<div id = "standard-score-output" class = "text-24"></div>';
echo '</div>';
?>