<!--
php/content/content-archive.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the archive page
It is included dynamically in the file 'php/document.php'
-->

<!-- PAGE HEADER -->
<div class = "page-header">CTREX Archive</div>

<?php
// CALCULATE CSS CLASS FOR TYPE TOGGLE BTNS
if($searchArchiveKeyword != NULL) { $resetClass = 'search-options-item'; } else { $resetClass = 'hide'; } // hide the reset btn when no query string

// IF SEARCHING MONTHLIES
if($searchArchiveType == 'monthly')
{
	$monthlyBtnClass	= 'hide';		// hide the monthly btn
	$monthlyLabelClass	= 'btn-label';	// show the monthly label
	$weeklyBtnClass		= 'block';		// show the weekly btn
	$weeklyLabelClass	= 'hide';		// hide the weekly label
	$articlesBtnClass	= 'block';		// show the articles btn
	$articlesLabelClass	= 'hide';		// hide the articles label
} // end else (monthly)

// IF SEARCHING WEEKLIES
else if($searchArchiveType == 'weekly')
{
	$monthlyBtnClass	= 'block';		// show the monthly btn
	$monthlyLabelClass	= 'hide';		// hide the monthly label
	$weeklyBtnClass		= 'hide';		// hide the weekly btn
	$weeklyLabelClass	= 'btn-label';	// show the weekly label
	$articlesBtnClass	= 'block';		// show the articles btn
	$articlesLabelClass	= 'hide';		// hide the articles label
} // end if $searchArchiveType == 'weekly'

// IF SEARCHING ARTICLES
else if($searchArchiveType == 'articles')
{
	$monthlyBtnClass	= 'block';		// show the monthly btn
	$monthlyLabelClass	= 'hide';		// hide the monthly label
	$weeklyBtnClass		= 'block';		// show the weekly btn
	$weeklyLabelClass	= 'hide';		// hide the weekly label
	$articlesBtnClass	= 'hide';		// hide the articles btn
	$articlesLabelClass	= 'btn-label';	// show the articles label
} // end if $searchArchiveType == 'weekly'
?>

<!-- MONTHLY/WEEKLY TOGGLE -->
<div class = "subheader">
	<div class = "<?php echo $resetClass;?>">
		<img src = "images/reset.png" class = "icon-24 pointer" class = "pointer" onclick = "clearSearch('<?php echo $thisPage;?>')"/>
	</div>
	<div class = "inline right-2">
		<div class = "<?php echo $monthlyBtnClass;?>">	<button type = "button" onclick = "searchArchiveType('monthly')">Monthlies</button></div>
		<div class = "<?php echo $monthlyLabelClass;?>"><button type = "button" onclick = "searchArchiveType('monthly')">Monthlies</button></div>
	</div>
	<div class = "inline right-2">
		<div class = "<?php echo $weeklyBtnClass;?>">	<button type = "button" onclick = "searchArchiveType('weekly')">Weeklies</button></div>
		<div class = "<?php echo $weeklyLabelClass;?>">	<button type = "button" onclick = "searchArchiveType('weekly')">Weeklies</button></div>
	</div>
	<div class = "inline right-2">
		<div class = "<?php echo $articlesBtnClass;?>">		<button type = "button" onclick = "searchArchiveType('articles')">Articles</button></div>
		<div class = "<?php echo $articlesLabelClass;?>">	<button type = "button" onclick = "searchArchiveType('articles')">Articles</button></div>
	</div>
</div><!-- /.subheader -->

<?php 
// VIEW TOGGLE
require_once 'php/view-toggle.php';

// PAGENAV (TOP)
//if($foundcount > $resultSize and $velvetRope != true) { require 'php/pagenav.php'; }
?>

<!-- RESULTS LIST -->
<div class = "results-feed" id = "list-container">
<?php
// NOTE - ARTICLES ARE OUTGOING LINKS
if($searchArchiveType == 'articles')
{
	echo '<div class = "text-14 italic bottom-20">';
		echo 'Note: The following are outgoing links to <a href = "https://medium.com" target = "_blank">medium.com</a>';
	echo '</div>'; // /.text-14 italic bottom-2
	$articlesN = 0;
} // end if $searchArchiveType == 'articles'
foreach($records as $record)
{
	require 'php/get-archive.php';
	
	// ARTICLES
	if($searchArchiveType == 'articles')
	{
		$articlesN += 1;
		if($velvetRope != true or $articlesN <= 3)
		{
			if($title == NULL) { $title = $url; }
			echo '<div class = "text-24"><a href = "'.$url.'" title = "View the article on medium.com" target = "blank">'.$title.'</a></div>';
		} // end if($velvetRope != true or $articlesN <= 3)
	} // end if type == articles
	
	// MONTHLY/WEEKLY LIST
	else { require 'php/result-item-archive.php'; }
} // end foreach $record
?>
</div><!-- /#list-container -->

<!-- RESULTS GRID -->
<div class = "results-feed hide" id = "grid-container">
<?php
// FOR ARTICLES, JUST DISPLAY NORMAL LIST
if($searchArchiveType == 'articles')
{
	// NOTE - ARTICLES ARE OUTGOING LINKS
	echo '<div class = "text-14 italic bottom-20">';
		echo 'Note: The following are outgoing links to <a href = "https://medium.com" target = "_blank">medium.com</a>';
	echo '</div>'; // /.text-14 italic bottom-2
	
	foreach($records as $record)
	{
		require 'php/get-archive.php';
		if($title == NULL) { $title = $url; }
		echo '<div class = "text-24"><a href = "'.$url.'" title = "View the article on medium.com" target = "blank">'.$title.'</a></div>';
	} // end foreach $record
} // end if articles

// MONTHLY/WEEKLY GRID
else 
{
	if($foundcount < $resultSize) { $stopAt = $foundcount; } else { $stopAt = $rangeEnd; } // stop outputting after whichever value is lesser
	$numCols = 6; // number of columns per row
	$numRows = ceil($stopAt/$numCols); // number of rows
	//echo '$stopAt: '. $stopAt.'<br/>'; 
	//echo '$foundcount = '.$foundcount.'<br/>'; echo '$resultSize = '.$resultSize.'<br/>'; 
	//echo $numRows.' rows x '.$numCols.' cols<br/>';
	$ag = -1; // counter for review grid records
	for($row = 0; $row < $numRows; $row++)
	{
		echo '<div class = "bottom-10">';
			for($col = 0; $col < $numCols; $col++)
			{
				$ag++; // increment the records array counter with each column

				if($ag < $stopAt and ($velvetRope != true or $ag < $numResultsVelvet))
				{
					$pageIndex = $ag + 1; // the nth result being output on this page
					$gridIndex = (($searchArchivePage - 1) * $resultSize) + $pageIndex; // the nth result in the entire results array
					//echo $gridIndex;
					// prevent from outputting empty containers after the last result
					if($gridIndex <= $stopAt)
					{
						$item = $gridRecords[$ag]; 					// locate the record by index number
						require 'php/get-vars.php'; 				// get dynamically assigned variables
						require 'php/result-item-archive-grid.php'; // output the grid item
					}
				} // end if $ag < $stopAt
			} // end for col
		echo '</div>'; // /.bottom-20
	} // end for row
} // end else !articles
?>
</div><!-- /#grid-container -->

<!-- PAGENAV (BOTTOM) -->
<div class = "pagenav" id = "pagenav-bottom"><?php require 'php/pagenav.php';?></div>
<?php 
// PAGENAV (BOTTOM)
//if($foundcount > $resultSize and $velvetRope != true) { require 'php/pagenav.php'; }

// LOGIN TO CONTINUE
require_once 'php/login-continue-btn.php'; 

// BACK TO TOP
if($foundcount > 20 and $resultSize > 20) { echo '<div class = "top-20 text-20"><a href = "#">Back to top</a></div>'; }
?>