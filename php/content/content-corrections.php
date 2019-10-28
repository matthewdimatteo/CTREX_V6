<!--
php/content/content-corrections.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the corrections page 'corrections.php'
It is included dynamically in the file 'php/document.php'
-->

<!-- PAGE HEADER -->
<div class = "page-header">Corrections</div>

<!-- SUBHEADER -->
<div class = "subheader">
	This is where we post corrections. We also may make notes in the body or the review. Scroll down for instructions about leaving a comment.
</div><!-- /.subheader -->

<!-- PAGE BODY -->
<div class = "paragraph left">
	<?php
	// This block gets all records from the 'corrections' table in the database 'CSR.fmp12' with values for the 'correction' field and outputs newest first
	$findCorrections = $fmcorrections->newFindCommand($fmcorrectionsLayout);
	$findCorrections->addFindCriterion('correction', '*');
	$findCorrections->addSortRule('recordID', 1, FILEMAKER_SORT_DESCEND);
	$correctionsResult = $findCorrections->execute();
	if(FileMaker::isError($correctionsResult)) { echo 'Error: '.$correctionsResult->getMessage(); exit(); }
	$correctionsRecords = $correctionsResult->getRecords();
	foreach($correctionsRecords as $correctionsRecord)
	{
		$correction = $correctionsRecord->getField('correction');
		echo '<p>'.parseLinks($correction).'</p>';
	} // end foreach $correctionsRecord
	?>
	<!--
	<p>
	SEPTEMBER 2010: We incorrectly attributed the creators of Mission-US (<a href = "https://www.mission-us.org" target = "_blank">www.mission-us.org</a>) as follows “It was created by Kids Interactive and Electric Funstuff for WNET in cooperation with the Center for Children and Technology.” The correct attribution should be “The development team includes historians from the American Social History Project (ASHP) at CUNY, researchers from Education Development Center’s Center for Children and Technology (CCT), and game developers from Electric Funstuff.  Mission US is produced by THIRTEEN in association with WNET.ORG.”
	</p>

	<p>MARCH 2010: VTech’s new reading system was listed incorrectly, as “VTech Flash” on page 2 The correct title is VTech FLiP.</p>
	-->
	<p><strong>If you disagree with a review, consider leaving a comment or writing your review.</strong></p>

	<p><strong>If you notice an error or would like to suggest a correction, please let us know in one of the following ways:</strong></p>
	
</div><!-- /.paragraph left -->

<div class = "paragraph center"><?php require 'php/contact-form.php';?></div>
<!--
<p>
BY EMAIL (best and fastest way)<br/>
Editor: Warren Buckleitner <a href = "mailto:warren@childrenstech.com">warren@childrenstech.com</a><br/>
Office: <a href = "mailto:info@childrenstech.com">info@childrenstech.com</a><br/>
</p>

<p>
BY PHONE<br/>
908-284-0404 (9 to 3:30 PM, EST)<br/>
</p>

<p>
IN PERSON or BY MAIL<br/>
Children’s Technology Review<br/>
126 Main Street<br/>
Flemington, NJ 08822 USA<br/>
</p>
-->