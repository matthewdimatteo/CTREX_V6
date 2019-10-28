<?php
/*
php/issue-covers.php
By Matthew DiMatteo, Children's Technology Review

This file outputs a grid of issue cover thumbnail images for the past year

It is included on:
- the Editorial Calendar page via 'php/content/content-editorial-calendar.php'
- the From the Editor Page via 'php/content/content-from-the-editor.php'
*/

// ISSUE COVER THUMB GRID
echo '<div id = "issue-cover-thumbs">';

	$searchArchiveType = 'monthly';

	$numCols = 6; // number of columns per row
	$numRows = 2; // number of rows

	// lookup 6 most recent active monthlies
	$findArchive = $fmmonthly->newFindCommand($fmmonthlyLayout);
	$findArchive->setRange(0, 12);
	$findArchive->addFindCriterion('issues::active', "*");
	$findArchive->addSortRule('year', 1, FILEMAKER_SORT_DESCEND); 
	$findArchive->addSortRule('month', 2, FILEMAKER_SORT_DESCEND);
	$result = $findArchive->execute();
	if(FileMaker::isError($result)) 
	{ 
		echo 'Error loading issue cover thumbnails';
		exit();
	}
	$records = $result->getRecords();

	// compile a separate array of records to be output in grid view 
	// (cannot use $records object because grid output requires access of array elements by index across a nested for loop)
	$gridRecords = array();
	foreach($records as $record)
	{
		require 'php/get-archive.php';
		array_push($gridRecords, $fieldValues);
	} // end foreach

	$ag = -1; // counter for review grid records
	for($row = 0; $row < $numRows; $row++)
	{
		echo '<div class = "bottom-10">';
			for($col = 0; $col < $numCols; $col++)
			{
				$ag++; // increment the records array counter with each column

				$item = $gridRecords[$ag]; 					// locate the record by index number
				require 'php/get-vars.php'; 				// get dynamically assigned variables
				require 'php/result-item-archive-info.php'; // calculate urls, hover text, css classes based on monthly/weekly, access

				echo '<div class = "result-item-archive-grid-col">';
				echo '<div class = "result-item-grid">';

					// output the grid item
					echo '<div class = "text-18"><a href = "'.$archiveItemLink.'" title = "'.$archiveItemHover.'">'.$monthlyAbbr.'</a></div>';
					echo '<div class = "archive-item-image">';
						echo '<a href = "'.$archiveItemLink.'" title = "'.$archiveItemHover.'">';
						if($linkThumb != NULL) 	{ echo '<img src = "'.$linkThumb.'"/>'; }
						else 					{ echo '<div class = "no-image"><div class = "no-image-text">Image not available</div></div>'; }
						echo '</a>';
					echo '</div>'; // /.archive-item-image

				echo '</div>'; // /.result-item-grid
				echo '</div>'; // /.result-item-archive-grid-col
			} // end for col
		echo '</div>'; // /.bottom-20
	} // end for row
echo '</div>'; // /#issue-cover-thumbs	
?>