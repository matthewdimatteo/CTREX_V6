<?php
/*
php/rating.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the rating for a product on the home page and the review page
Both displays feature the text 'CTR Rating: ' followed by the score as a percentage and a 5-Star graphic output by 'php/rating-stars.php' below
On the home page, any additional rubric ratings to display are output by the file 'php/ratings-all.php'
On the review page, the CTR Rating is broken down by individual Quality Attributes (or QA) and similar breakdowns are provided for any additional rubrics
*/

if($pageType == 'review') 	{ $ratingLink = 'rubrics.php?id='.$reviewnumber.'&rubric=Standard'; }
else						{ $ratingLink = 'review.php?id='.$reviewnumber; }

// CTR (STANDARD) RATING
if($standardScore != NULL and $standardScore != '?')
{
	echo '<div class = "rating-line-col">'; 
		//if($pageType == 'review') 	{ echo '<a href = "'.$ratingLink.'">CTR Rating</a>: '.$score.'%'; }
		//else 						{ echo 'CTR Rating: '.$score.'%'; }
		echo '<a href = "'.$ratingLink.'">CTR Rating</a>: '.$score.'%';
	echo '</div>'; // CTR RATING

	// STARS
	echo '<div class = "rating-line-col">'; require 'php/rating-stars.php'; echo '</div>'; // 5 STAR GRAPHIC
} // end if $standardScore != NULL and != '?'

// ED. CHOICE SEAL
if($edChoice == true)
{ 
	echo '<div class = "rating-line-col">'; 
 		echo '<img src = "images/seal.png" alt = "CTR Editor\'s Choice" title = "This seal denotes a CTR Editor\'s Choice Award"/>'; 
	echo '</div>'; 
} // end if $edChoice

// ETHICAL SEAL
if($ethical != NULL)
{ 
	echo '<div class = "rating-line-col">'; 
 		echo '<img src = "images/ethical32.png" alt = "CTR Editor\'s Choice" title = "This seal indicates CTR\'s ethical seal of approval"/>'; 
	echo '</div>'; 
} // end if $ethical

// EXPAND FOR INDIVIDUAL QUALITY ATTRIBUTE DETAILS
if($pageType == 'review')
{
	// LOOKUP RUBRIC
	if($rubricUsed == NULL or $rubricUsed == 'Generic' or $rubricUsed == 'generic') { $rubricUsed = 'Standard'; } 
	
	// TOGGLE BTN
	echo '<div class = "rating-line-col">';
		echo '<div class = "pointer">';
			echo '<div id = "rating-details-show-'.$n.'" class = "hide" title = "View detailed ratings"';			
				echo 'onclick = "showItemN(\'rating-details-show-\', \'rating-details-hide-\', \'rating-details-\', '.$n.')">&#9660;</div>';
			echo '<div id = "rating-details-hide-'.$n.'" title = "Hide rating details"';
				echo 'onclick = "hideItemN(\'rating-details-show-\', \'rating-details-hide-\', \'rating-details-\', '.$n.')">&#9650;</div>';
		echo '</div>'; // /.pointer
	echo '</div>'; // /.rating-line-col
	
	// EXPANDABLE DETAILS
	echo '<div class = "block" id = "rating-details-'.$n.'">';
		echo '<div class = "rating-details">';
	
			if($standardDefault == true) { $rubricUsed = 'Standard'; }
			
			// PRIMARY RUBRIC
			$getSelectedRubric	= true;			// this boolean tells 'php/find-rubrics.php' to lookup a single rubric instead of all rubrics
			$primaryRubric 		= true;			// this boolean tells 'php/get-rubrics' to output the individual qa after the name/score line
			require 'php/find-rubrics.php';		// this file looks up either one rubric or all rubrics and gets their qa, storing them in an array
			require 'php/get-rubrics.php';		// this file accesses the stored array of rubrics (in this case, with only 1 item) and outputs its data
			
			// TOTAL SCORE
			echo '<div class = "rating-total">';
				echo '<div class = "inline rating-qa-name">Total:</div>';
				echo '<div class = "inline rating-qa-value">'.$score.'%</div>';
			echo '</div>';
			
			// META
			echo '<div id = "rating-meta">';
				echo 'Reviewed';
				if ($rubricUsed == NULL) { $rubricUsed = 'Standard'; }
				if ($rubricUsed != NULL and $rubricUsed != 'Custom' and $rubricUsed != 'Saved') 
				{ echo ' using the <a href = "rubrics.php?id='.$reviewnumber.'&rubric='.$rubricUsed.'">'.$rubricUsed.'</a> Rubric'; }
				if($rubricUsed == 'Custom' or $rubricUsed == 'Saved')
				{ echo ' using a <a href = "flexcustom.php?id='.$reviewnumber.'">Custom</a> Rubric'; }
				if($thisPage == 'evaluations.php') 	{ echo '<br/><a href = "review.php?id='.$reviewnumber.'">Return to the review page for this product</a>'; }
				else 								
				{ 
					if($rubricsText != NULL)
					{
						echo '<br/>';
						//echo '<a href = "evaluations.php?id='.$reviewnumber.'">See other evaluations of this product</a>';

						// SHOW/HIDE ALL EVALUATIONS
						echo '<div id = "show-all-evaluations" 
							onclick = "showItem(\'show-all-evaluations\', \'hide-all-evaluations\', \'all-evaluations\')">';
							echo '<div class = "btn-text">See other evaluations of this product</div>';
						echo '</div>';
						echo '<div id = "hide-all-evaluations" class = "hide" 
							onclick = "hideItem(\'show-all-evaluations\', \'hide-all-evaluations\', \'all-evaluations\')">';
							echo '<div class = "btn-text">Hide other evaluations of this product</div>';
						echo '</div>';
					} // end if $rubricsText != NULL
				} // end else
			echo '</div>'; // .#rating-meta
				
		echo '</div>'; // /.rating-details
		
		// ALL EVALUATIONS (hidden by default)
		echo '<div class = "hide" id = "all-evaluations">';
			echo '<div class = "review-heading bottom-20">All Evaluations</div>';
			require 'php/ratings-all.php';
			echo '<div class = "btn-text bottom-20" onclick = "hideItem(\'show-all-evaluations\', \'hide-all-evaluations\', \'all-evaluations\')">Hide All Evaluations</div>';
		echo '</div>';
		
	echo '</div>'; // /.hide
} // end if $pageType == 'review'

// if $pageType != 'review' (searching on home page)
else
{
	if($numRubricsSelected > 0) 
	{ 
		require 'php/ratings-all.php'; // this file outputs detailed ratings (with qa) for each selected rubric
		//foreach($multipleRubrics as $rubricsList) { require 'php/get-rubrics.php'; }
	} 
} // end else $pageType != 'review'
?>