<?php
/*
php/range-steps.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the step markers (0-100) for a slider input on a rubric quality attribute
It is included twice in 'php/rating-qa.php' for both the rating and importance sliders on a rubric evaluation
It is also included in 'php/review-exchange-comment-form.php' for leaving a quick rating on a review
*/
echo '<div class = "range-step-container">';
for($i = 0; $i < 11; $i++)
{
	$step = $i * 10;
	$rangeStepClass = 'range-step';
	echo '<div class = "'.$rangeStepClass.'">'.$step.'</div>';
}
echo '</div>'; // /.range-step-container
?>