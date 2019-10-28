<?php
/*
php/content/content-kapis.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the KAPi Awards page 'kapis.php'
It is included dynamically in the file 'php/document.php'
Variable values are defined in the file 'php/settings.php'
*/

// PAGE CONTAINER
echo '<div id = "kapis-page-container" class = "award-page-container">';

// PAGE HEADER, SUBHEADER
if($kapisHeader != NULL) 		{ echo '<div class = "page-header">'.$kapisHeader.'</div>'; }
if($kapisSubheader != NULL) 	{ echo '<div class = "subheader">'.$kapisSubheader.'</div>'; }

// PAGE BODY
if($numKapisImgs > 0)
{
	$textClass = 'paragraph-70 left awards-text';
	$imgsClass = 'inline width-20 left-20 awards-img';
} // end if imgs
else
{
	$textClass = 'paragraph-90 left';
	$imgsClass = 'hide';
} // end else no imgs

// TEXT
echo '<div class = "'.$textClass.'">';
	
	// DEADLINE AND BOOK FAIR LINK
	if($kapisDeadline != NULL) 	{ echo 'The deadline for entering is '.$kapisDeadline.'. '; }
	if($kapisLink != NULL) 		{ echo '<a href = "'.$kapisLink.'" target = "_blank">Read about the award</a>.<br/>'; }
	
	// BULLET POINT LIST LINKING TO EACH AWARD BY YEAR
	$findAwards = $fmkapi->newFindCommand($fmkapiLayout);
	$findAwards->addFindCriterion('year', '*');
	$findAwards->addSortRule('year', 1, FILEMAKER_SORT_DESCEND);
	$awardsResult = $findAwards->execute();
	if(FileMaker::isError($awardsResult)) { echo 'Error: '.$awardsResult->getMessage(); exit(); }
	$awardsRecords = $awardsResult->getRecords();
	echo '<ul>';
	$awardsN = 0;
	foreach($awardsRecords as $record)
	{
		$awardsN += 1;
		$awardYear = $record->getField('year');
		echo '<li>';
		echo '<a href = "award.php?type=kapi&year='.$awardYear.'">'.$awardYear.'</a>';
		if($juror == true and substr_count($jurorType, 'kapi') > 0 and $awardsN == 1) { echo ' | <a href = "juror-panel.php?type=kapi&year='.$awardYear.'">Juror\'s Panel</a>'; }
		echo '</li>';
	} // end foreach $awardsRecords
	echo '</ul>';
	
	// DESCRIPTION
	if($kapisText != NULL) { echo parseLinksOld($kapisText); }
	
	// CONTACT INFO
	if($kapisAddress != NULL or $kapisPhone != NULL or $kapisEmail != NULL)
	{
		echo '<p>';
		echo 'For further information:<br/><br/>';
		if($kapisAddress != NULL) { echo $kapisAddress.'<br/>'; }
		if($kapisPhone != NULL) 	{ echo $kapisPhone.'<br/>'; }
		if($kapisEmail != NULL) 	{ echo 'Email: <a href = "mailto:'.$kapisEmail.'">'.$kapisEmail.'</a><br/>'; }
		echo '</p>';
	} // end if contact info
echo '</div>'; // /.$textClass

// IMAGES
if($numKapisImgs > 0)
{
	echo '<div class = "'.$imgsClass.'">';
		if($kapisImg1 != NULL) { echo '<div class = "width-90 bottom-40"><img src = "php/img.php?-url='.urlencode($kapisImg1).'" ></div>'; }
		if($kapisImg2 != NULL) { echo '<div class = "width-90 bottom-40"><img src = "php/img.php?-url='.urlencode($kapisImg2).'" ></div>';}
		if($kapisImg3 != NULL) { echo '<div class = "width-90 bottom-40"><img src = "php/img.php?-url='.urlencode($kapisImg3).'" ></div>';}
	echo '</div>'; // /.$imgsClass
} // end if $numkapisImgs > 0

echo '</div>'; // /#kapis-page-container .award-page-container
?>