<?php
/*
php/rating-qa.php
By Matthew DiMatteo, Children's Technology Review

This file accesses a stored array of Quality Attribute (or QA) data from 'php/get-qa.php' for displaying detailed product ratings
It is included twice within the file 'php/get-rubrics.php':
- once to display detailed ratings for the Standard Rubric on the review page
- another to display detailed ratings for additional selected rubrics on the review page
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
	$csrWeight 		= $thisQA[6];
	$weightedRating	= $thisQA[7];
	$qaNumber		= str_replace('rating', '', $qaField);
	
	// OUTPUT QA FOR REVIEW
	if($pageType == 'review')
	{
		// OUTPUT QA NAME, RATING VALUE
		if($csrRating == NULL or $csrRating == 'N' or $csrRating == 'N/A') { $csrRating = 'N'; }
		echo '<div class = "rating-qa-line">';
			echo '<div class = "inline rating-qa-name">'.$qaName.'</div>';
			echo '<div class = "inline rating-qa-value">'.$csrRating.'/10</div>';
		echo '</div>'; // /.rating-qa-line
	} // end if $pageTyp == 'review'
	
	// OUTPUT QA FOR RUBRIC EVALUATION
	else
	{
		// determine css class for qa name based on string length
		$qaNameLength = strlen($qaName);
		if($qaNameLength <= 15) 						{ $qaNameClass = 'text-18'; }
		if($qaNameLength > 15 and $qaNameLength <= 20) 	{ $qaNameClass = 'text-16 top-1'; }
		if($qaNameLength > 20 and $qaNameLength <= 25) 	{ $qaNameClass = 'text-14 top-2'; }
		if($qaNameLength > 25 and $qaNameLength <= 30) 	{ $qaNameClass = 'text-13 top-3'; }
		if($qaNameLength > 30 and $qaNameLength <= 35) 	{ $qaNameClass = 'text-12 top-4'; }
		if($qaNameLength > 35) 							{ $qaNameClass = 'text-11 top-5'; }
		//echo 'Name = '.$qaName.', Length = '.$qaNameLength.', Class = '.$qaNameClass.'<br/>';
		
		// SCALE THE CSR RATING FOR DISPLAY ON EDITORIAL PAGE
		if($thisPage == 'editorial.php')
		{
			if($csrRating != NULL and $csrRating != 'N') 	{ $csrScaled = $csrRating * 10; }
			else											{ $csrScaled = ''; }
		} // end if $thisPage == 'editorial.php'
		//echo '$csrRating: '.$csrRating.', $csrScaled: '.$csrScaled.'<br/>';
		
		// QA ITEM START
		echo '<div class = "rubric-qa-item" id = "qa-item-'.$qaN.'">';
		
			// MOBILE ROW 1 (RESET, QA NAME)
			echo '<div class = "qa-mobile-row-1">';
			
				// RESET
				echo '<div class = "qa-reset" id = "qa-reset-'.$qaN.'" title = "Reset this rating">';
					echo '<img src = "images/reset.png" class = "pointer" onclick = "resetQA('.$qaN.')"/>';
				echo '</div>';

				// NAME
				echo '<div class = "qa-name">';

					// HIDDEN INPUTS FOR NAME AND INDEX
					echo '<input type = "hidden" id = "qa-name-'.$qaN.'" 	name = "qa-name-'.$qaN.'" 	value = "'.$qaName.'"/>';
					echo '<input type = "hidden" id = "qa-index-'.$qaN.'" 	name = "qa-index-'.$qaN.'" 	value = "'.$qaNumber.'"/>';

					// NAME (DESCRIPTOR TOGGLE BTN)
					echo '<div class = "block"	id = "qa-details-show-'.$qaN.'" title = "Expand description"
						onclick = "showItemN(\'qa-details-show-\', \'qa-details-hide-\', \'qa-descriptor-\', '.$qaN.')">';
						echo '<div class = "btn-text"><div class = "'.$qaNameClass.'">'.$qaName.'</div></div>';
					echo '</div>';
					echo '<div class = "hide" 	id = "qa-details-hide-'.$qaN.'" title = "Hide description"
						onclick = "hideItemN(\'qa-details-show-\', \'qa-details-hide-\', \'qa-descriptor-\', '.$qaN.')">';
						echo '<div class = "btn-text"><div class = "'.$qaNameClass.'">'.$qaName.'</div></div>';
					echo '</div>';
					
				echo '</div>'; // /.qa-name
			echo '</div>'; // /.qa-mobile-row-1
			
			// MOBILE ROW 2 (RATING, BTNS, OUTPUT)
			echo '<div class = "qa-mobile-row-2">';
			
				// RATING
				echo '<div class = "qa-rating">';
					echo '<input type = "range" 	id = "qa-rating-'.$qaN.'" min = "0" max = "100" step = "1" ';
						if($thisPage == 'editorial.php') { echo ' value = "'.$csrScaled.'" '; }
						echo 'onchange = "outputQA(\'rating\', '.$qaN.')"/>';

					// HIDDEN INPUT FOR RATING
					echo '<input type = "hidden" 	id = "qa-score-'.$qaN.'" name = "qa-score-'.$qaN.'" '; 
						if($thisPage == 'editorial.php') { echo ' value = "'.$csrScaled.'" '; }
					echo '/>';

					require 'php/range-steps.php'; // outputs the 0-100 markings
				echo '</div>'; // /.qa-rating

				// INCREMENT/DECREMENT RATING
				echo '<div class = "qa-inc-dec">';
					echo '<div class = "qa-inc-dec-btn" title = "Increase this rating by one">';
						echo '<button type = "button" onclick = "incrementQA(\'inc\', \'rating\', '.$qaN.')">+</button>';
					echo '</div>';
					echo '<div class = "qa-inc-dec-btn" title = "Decrease this rating by one">';
						echo '<button type = "button" onclick = "incrementQA(\'dec\', \'rating\', '.$qaN.')">-</button>';
					echo '</div>';
				echo '</div>';

				// OUTPUT RATING
				echo '<div class = "qa-output" id = "qa-rating-output-'.$qaN.'">';
					if($thisPage == 'editorial.php' and $csrScaled != NULL) { echo $csrScaled.'%'; }
				echo '</div>';

				// WEIGHT
				echo '<div class = "qa-weight">';
					echo '<input type = "range" id = "qa-weight-'.$qaN.'" name = "qa-weight-'.$qaN.'" min = "0" max = "100" step = "1" value = "'.$qaWeight.'" 
						onchange = "outputQA(\'weight\', '.$qaN.')"/>';

					// HIDDEN INPUT FOR DEFAULT WEIGHT
					echo '<input type = "hidden" 	id = "qa-weight-default-'.$qaN.'" name = "qa-weight-default-'.$qaN.'" value = "'.$qaWeight.'" />';

					require 'php/range-steps.php'; // outputs the 0-100 markings
				echo '</div>';

				// INCREMENT/DECREMENT WEIGHT
				echo '<div class = "qa-inc-dec weight-inc-dec">';
					echo '<div class = "qa-inc-dec-btn" title = "Increase this rating\'s importance by one">';
						echo '<button type = "button" onclick = "incrementQA(\'inc\', \'weight\', '.$qaN.')">+</button>';
					echo '</div>';
					echo '<div class = "qa-inc-dec-btn" title = "Decrease this rating\'s importance by one">';
						echo '<button type = "button" onclick = "incrementQA(\'dec\', \'weight\', '.$qaN.')">-</button>';
					echo '</div>';
				echo '</div>';

				// OUTPUT WEIGHT
				echo '<div class = "qa-output weight-output" id = "qa-weight-output-'.$qaN.'"></div>';
			
			echo '</div>'; // /.qa-mobile-row-2
			
		echo '</div>'; // /.rubric-qa-item #qa-item-$qaN
		// QA ITEM END
		
		// DESCRIPTOR
		echo '<div class = "hide" id = "qa-descriptor-'.$qaN.'">';
			echo '<div class = "qa-descriptor">';
				echo $qaDescriptor;
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
		
	} // end else (rubric evaluation)

} // end foreach qa
?>