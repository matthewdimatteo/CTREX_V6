<!--
php/content/content-publishers.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the publisher directory
It is included dynamically in the file 'php/document.php'
-->

<!-- SIDEBAR -->
<div class = "sidebar"><?php require_once 'php/sidebar.php';?></div>

<!-- SEARCH AREA -->
<div class = "search-area">

	<!-- SEARCH RESULTS SUMMARY LINE -->
	<div class = "results-heading"><?php echo $searchPublishersHeading;?></div>
	
	<!-- DEBUG OUTPUT -->
	<?php require_once 'php/debug-output.php'; // display variable values in debugging mode ?>
	
	<!-- SEARCH OPTIONS -->
	<div class = "search-options"><?php require_once 'php/search-options-pub.php';?></div>
	
	<!-- VIEW TOGGLE -->
	<?php require_once 'php/view-toggle.php'; ?>
	
	<!-- PAGENAV (TOP) -->
	<div class = "pagenav" id = "pagenav-top"><?php require 'php/pagenav.php';?></div>
	
	<!-- RESULTS - LIST -->
	<div class = "results-feed" id = "list-container">
		<?php
		$recordN = 0;
		foreach($records as $record)
		{
			$recordN += 1;
			if($velvetRope != true or $recordN < $numResultsVelvet + 1)
			{
				require 'php/get-pub.php'; // get record data
				require 'php/result-item-pub.php'; // output each individual result
			} // end if($velvetRope != true or $recordN < $numResultsVelvet + 1)
		} // end foreach record
		?>
	</div><!-- /.results-feed #publishers-list-->
	
	<!-- RESULTS - GRID -->
	<div class = "results-feed hide publishers-grid" id = "grid-container">
		<?php
		// determine when to stop outputing item containers
		if($searchPublishersSort == 'rel') 	{ $ceiling = $searchPublishersNumResults; } else { $ceiling = $resultSize; }
		if($foundcount < $ceiling) 			{ $stopAt = $foundcount; } else { $stopAt = $ceiling; }
		
		$numCols = 4; // number of columns per row
		$numRows = $ceiling/$numCols; // number of rows
		
		$rg = -1; // counter for result grid records
		for($row = 0; $row < $numRows; $row++)
		{
			echo '<div class = "bottom-10">';
				for($col = 0; $col < $numCols; $col++)
				{
					$rg++; // increment the records array counter with each column
					
					if($rg < $stopAt and ($velvetRope != true or $rg < $numResultsVelvet))
					{
						// OUTPUT ITEM SORTED BY RELEVANCE
						if($searchPublishersSort == 'rel')
						{
							$sortedRecord = $recordsToSort[$rg]; 	// locate the record by index number
							//require 'php/get-sorted-review.php'; 	// get values for sorted record
							require 'php/result-item-pub-grid.php'; 	// output the grid item
							//echo $titleText;
						}

						// OUTPUT ITEM SORTED NORMALLY
						else
						{
							$pageIndex = $rg + 1; // the nth result being output on this page
							$gridIndex = (($searchPublishersPage - 1) * $resultSize) + $pageIndex; // the nth result in the entire results array
							
							// prevent from outputting empty containers after the last result
							if($gridIndex <= $foundcount)
							{
								$item = $gridRecords[$rg]; 				// locate the record by index number
								require 'php/get-vars.php'; 			// get dynamically assigned variables
								require 'php/result-item-pub-grid.php'; // output the grid item
							}
							//echo '$pageIndex: '.$pageIndex.', $gridIndex: '.$gridIndex.', $foundcount: '.$foundcount;
						}
					} // end if $rg < $stopAt
				} // end for col
			echo '</div>'; // /.bottom-20
		} // end for row
		?>
	</div><!-- /.results-feed #publishers-grid-->
	
	<?php require_once 'php/login-continue-btn.php'; // if velvet rope is true, display 'log in to continue' btn ?>
	
	<!-- PAGENAV (BOTTOM) -->
	<div class = "pagenav" id = "pagenav-bottom"><?php require 'php/pagenav.php';?></div>
	
</div><!-- /.search-area -->