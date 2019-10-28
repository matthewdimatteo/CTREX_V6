<?php
/*
php/get-rubrics.php
By Matthew DiMatteo, Children's Technology Review

This file accesses the stored array of rubrics ($rubricsList) constructed by 'php/find-rubrics.php' and outputs its data
It is included in the files 'php/rating.php' and 'php/ratings-all.php'

For its inclusion in 'php/rating.php', which outputs the Standard Rubric evaluation on the review page, the detailed ratings are output by 'php/rating-qa.php'
The boolean $primaryRubric is set to true before this file's inclusion in 'php/rating.php'
This boolean is reset to '' in the file 'php/ratings-all.php'
*/
foreach($rubricsList as $thisRubric)
{
	require 'php/get-rubric.php'; // this file accesses the array of individual rubric data defined in 'php/find-rubrics.php'
	if($primaryRubric == true) { require 'php/rating-qa.php'; } // outputs the individual qa details for the primary rubric

	// outputs only the first line (rubric name and score) for multiple rubrics
	else
	{
		if($thisRubricScore > 0 and $thisRubric != 'Standard' and $rubricName != 'Standard')
		{
			// OUTPUT ON REVIEW PAGE
			if($pageType == 'review')
			{
				echo '<div class = "text-18">';
					echo '<a href = "rubrics.php?id='.$reviewnumber.'&rubric='.$rubricName.'">'.$rubricName.' Rubric</a>: '.$thisRubricScoreText;
				echo '</div>';
				require 'php/rating-qa.php'; // outputs each qa line based on stored array data

				// TOTAL
				echo '<div class = "rating-total">';
					echo '<div class = "inline rating-qa-name">Total:</div>';
					echo '<div class = "inline rating-qa-value">'.$thisRubricScoreText.'</div>';
				echo '</div>';
				echo '<br/>';
				//echo $ptsEarned.'/'.$ptsPossible;
			} // end if $pageType == 'review'
			
			// OUTPUT ON SEARCH PAGE
			else
			{
				echo '<div class = "text-16" style = "border:0px solid black;">';
				
					// RUBRIC NAME, RATING
					echo '<div class = "inline" style = "border:0px solid blue;">';
						echo '<a href = "rubrics.php?id='.$reviewnumber.'&rubric='.$rubricName.'">'.$rubricName.' Rubric</a>: '.$thisRubricScoreText;
					echo '</div>'; // /.inline
					
					// LINK: MORE RATED WITH THIS RUBRIC
					echo '<div class = "inline left-5 text-12 top-3" style = "border:0px solid blue;">';
						echo '<a href = "home.php?rubric='.$rubricName.'&page=1" title = "View other products evaluated using the '.$rubricName.' rubric">';
							echo 'More rated with this rubric';
						echo '</a>';
					echo '</div>'; // /.inline left-5 text-12 top-3
				echo '</div>'; // /.text-16
			} // end else (search page, not review)

		} // end if $thisRubricScore
	} // end else $primaryRubric != true

} // end foreach rubric
?>