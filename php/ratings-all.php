<!--
php/ratings-all.php
By Matthew DiMatteo, Children's Technology Review

This file displays detailed ratings for multiple rubrics on the review page
The file 'php/rubrics-multiple.php' processes the rubric records and constructs an array $multipleRubrics to output
- Note: This file is only included on the review page - for searches, it is included in 'php/get-review.php'

The output is placed within a <div> element of id 'evaluations-container'
This id is referenced by a JS function in 'php/rating.php' to toggle the display of the selected rubrics on the review page
-->

<!-- EVALUATIONS -->
<div class = "evaluations-container">
<?php
if($pageType == 'review'){ require 'php/rubrics-multiple.php'; }
// loop through the array constructed in 'php/find-rubrics.php' and output each set of detailed ratings
foreach($multipleRubrics as $rubricsList) { require 'php/get-rubrics.php'; }
?>
</div><!-- /#evaluations-container -->