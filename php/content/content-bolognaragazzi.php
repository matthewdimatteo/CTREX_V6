<?php
/*
php/content/content-bolognaragazzi.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the BolognaRagazzi Award page 'bolognaragazzi.php'
It is included dynamically in the file 'php/document.php'
Variable values are defined in the file 'php/settings.php'
*/

// PAGE CONTAINER
echo '<div id = "bologna-page-container" class = "award-page-container">';

// PAGE HEADER, SUBHEADER
if($bolognaHeader != NULL) 		{ echo '<div class = "page-header">'.$bolognaHeader.'</div>'; }
if($bolognaSubheader != NULL) 	{ echo '<div class = "subheader">'.$bolognaSubheader.'</div>'; }

// PAGE BODY
if($numBolognaImgs > 0) 
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
	if($bolognaDeadline != NULL) 	{ echo 'The deadline for entering is '.$bolognaDeadline.'. '; }
	if($bolognaLink != NULL) 		{ echo '<a href = "'.$bolognaLink.'" target = "_blank">Read about the award</a>.<br/>'; }
	
	// BULLET POINT LIST LINKING TO EACH AWARD BY YEAR
	$findAwards = $fmbologna->newFindCommand($fmbolognaLayout);
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
		echo '<a href = "award.php?type=bologna&year='.$awardYear.'">'.$awardYear.'</a>';
		if($juror == true and substr_count($jurorType, 'bologna') > 0 and $awardsN == 1) 
		{ echo ' | <a href = "juror-panel.php?type=bologna&year='.$awardYear.'">Juror\'s Panel</a>'; }
		echo '</li>';
	} // end foreach $awardsRecords
	echo '</ul>';
	
	// DESCRIPTION
	if($bolognaText != NULL) { echo parseLinksOld($bolognaText); }
	
	// CONTACT INFO
	if($bolognaAddress != NULL or $bolognaPhone != NULL or $bolognaEmail != NULL)
	{
		echo '<p>';
		echo 'For further information:<br/><br/>';
		if($bolognaAddress != NULL) { echo $bolognaAddress.'<br/>'; }
		if($bolognaPhone != NULL) 	{ echo $bolognaPhone.'<br/>'; }
		if($bolognaEmail != NULL) 	{ echo 'Email: <a href = "mailto:'.$bolognaEmail.'">'.$bolognaEmail.'</a><br/>'; }
		echo '</p>';
	} // end if contact info
echo '</div>'; // /.$textClass

// IMAGES
if($numBolognaImgs > 0)
{
	echo '<div class = "'.$imgsClass.'">';
		if($bolognaImg1 != NULL) { echo '<div class = "width-90 bottom-40"><img src = "php/img.php?-url='.urlencode($bolognaImg1).'" ></div>'; }
		if($bolognaImg2 != NULL) { echo '<div class = "width-90 bottom-40"><img src = "php/img.php?-url='.urlencode($bolognaImg2).'" ></div>';}
		if($bolognaImg3 != NULL) { echo '<div class = "width-90 bottom-40"><img src = "php/img.php?-url='.urlencode($bolognaImg3).'" ></div>';}
	echo '</div>'; // /.$imgsClass
} // end if $numBolognaImgs > 0

echo '</div>'; // /#bologna-page-container .award-page-container
?>