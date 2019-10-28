<?php
/*
search-reviews.php
By Matthew DiMatteo, Children's Technology Review

This file defines the html content for the page 'home.php', which is the primary search page for CTREX
It is included within the file 'content/content-home.php' if the user is logged in, or the site is not in 'Velvet Rope' mode
*/
?>

<!-- SIDEBAR -->
<div class = "sidebar"><?php require_once 'php/sidebar.php';?></div>

<!-- SEARCH AREA -->
<div class = "search-area">

	<!-- SAVE ITEM CONFIRMATION MESSAGES -->
	<?php require_once 'php/save-item-confirmation.php'; // display confirmation message for saved/removed search/bookmark ?>
	
	<!-- SEARCH RESULTS SUMMARY LINE -->
	<div class = "results-heading">
	<?php 
		echo $searchReviewsHeading; // this is calculated in 'php/results-summary.php'
		
		// IF A TOPIC HAS BEEN INCLUDED AS A SEARCH PARAMETER, LOOKUP DESCRIPTION OF THAT TOPIC
		if($searchReviewsTopic != NULL)
		{
			$findSelectedTopic 			= $fmtopic->newFindCommand($fmtopicLayout);
			$findSelectedTopic->addFindCriterion('value' , '=='.$searchReviewsTopic);
			$selectedTopicResult 		= $findSelectedTopic->execute();
			if(FileMaker::isError($selectedTopicResult)) { echo 'Error: '.$selectedTopicResult->getMessage(); exit(); }
			$selectedTopicRecord 		= $selectedTopicResult->getFirstRecord();
			$selectedTopicName 			= $selectedTopicRecord->getField('name');
			$selectedTopicDescription 	= $selectedTopicRecord->getField('description');
			if($selectedTopicDescription != NULL)
			{
				echo '<div class = "text-16 bottom-5">';
					if($selectedTopicName != NULL) { echo '<strong>'.$selectedTopicName.':</strong> '; }
					echo $selectedTopicDescription;
				echo '</div>'; // /.text-16 bottom-5
			} // end if $selectedTopicDescription
		} // end if $searchReviewsTopic
		
		// IF SEARCHING BY RUBRIC, INCLUDE RUBRIC DESCRIPTION
		if($searchReviewsRubric != NULL)
		{
			$findSearchRubric	= $fmrubric->newFindCommand($fmrubricLayout);
			$findSearchRubric->addFindCriterion('rubric', '=='.$searchReviewsRubric);
			$searchRubricResult	= $findSearchRubric->execute();
			if(FileMaker::isError($searchRubricResult)) { echo 'Error: '.$searchRubricResult->getMessage(); exit(); }
			$searchRubricRecord			= $searchRubricResult->getFirstRecord();
			$searchRubricDescription 	= $searchRubricRecord->getField('rubricDescription');
			echo '<div class = "text-16 bottom-5">';
				//echo 'Products evaluated using the ';
				echo '<a href = "rubrics.php?rubric='.$searchReviewsRubric.'" title = "View the details for the '.$searchReviewsRubric.' Rubric">';
					echo '<strong>'.$searchReviewsRubric.' Rubric</strong>';
				echo '</a>';
				if($searchRubricDescription != NULL) { echo ': '.trimText($searchRubricDescription, 100); }
			echo '</div>'; // /.text-16 bottom-5
		} // end if ($searchReviewsRubric)
	?>
	</div><!-- /.results-heading -->
	
	<!-- SEARCH OPTIONS -->
	<div class = "search-options"><?php require_once 'php/search-options.php';?></div>
	
	<!-- VIEW TOGGLE -->
	<?php require_once 'php/view-toggle.php';?>
	
	<!-- PAGENAV (TOP) -->
	<div class = "pagenav" id = "pagenav-top"><?php require 'php/pagenav.php';?></div>
	
	<!-- RESULTS - LIST -->
	<div class = "results-feed" id = "list-container">
	<?php
	// IF SORTING BY RELEVANCE
	//if($newElapsedTime != NULL) { echo $newElapsedTime.' seconds<br/>'; }
	if($searchReviewsSort == 'rel')
	{
		//echo $searchReviewsNumResults.'<br/>';
		if($foundcount < $searchReviewsNumResults) 	{ $stopAt = $foundcount; } else { $stopAt = $searchReviewsNumResults; }
		//if($foundcount < $maxSize) 				{ $stopAt = $foundcount; } else { $stopAt = $maxSize; }
		$numGroups = ceil($stopAt / $resultSize);
		$a = -1;
		for($group = 0; $group < $numGroups; $group++)
		{
			//if($group > 0) { $thisResultGroupClass = 'hide'; } else { $thisResultGroupClass = 'block'; }
			echo '<div id = "results-group-'.$group.'" class = "'.$thisResultGroupClass.'">';
			for($sortedItem = 0; $sortedItem < $resultSize; $sortedItem++)
			{
				$a++;
				if($a < $stopAt)
				{
					$sortedRecord = $recordsToSort[$a];
					$sortedN += 1; 
					$recordN = $sortedN; // allow result-item to reference item counter regardless of sort type
					require 'php/get-sorted-review.php'; // get the sorted record values
					if($velvetRope != true or $sortedN < $numResultsVelvet + 1) { require 'php/result-item.php'; }
				} // if $a < $stopAt
			} // end for (each result)
			//echo $group.'/'.$numGroups.'<br/>';
			
			// LOAD MORE RESULTS
			if($velvetRope != true and $a < $stopAt)
			{
				$nextOption = (($group + 1) * $resultSize) + $step;
				if($foundcount < $nextOption) { $nextOptionLabel = $foundcount; } else { $nextOptionLabel = $nextOption; }
				echo '<div class = "center top-10">';
					echo '<button type = "button" onclick = "loadMore('.$nextOption.')" title = "Load up to '.$nextOptionLabel.' results">';
						echo 'Load More Results';
					echo '</button>';
				echo '</div>';
			}
			echo '<div id = "results-'.$nextOption.'"></div>';
			
			// SHOW MORE RESULTS
			/*
			if($velvetRope != true and $group + 1 < $numGroups)
			{
				echo '<div id = "results-group-more-'.$group.'" class = "center top-10">';
					echo '<button type = "button" onclick = "showMore('.$group.')">Show More Results</button>';
				echo '</div>';
			}
			*/
			echo '</div>'; // /#results-group-$group
		} // end for (each result group)
	} // end if sorting by relevance
	
	// IF NOT SORTING BY RELEVANCE
	else
	{
		foreach($records as $record)
		{
			$recordN += 1;
			if($velvetRope != true or $recordN < $numResultsVelvet + 1)
			{
				$reviewRecord = $record; // for get-qa.php reference
				require 'php/get-review.php';
				require 'php/result-item.php'; 
			} // end if ($velvetRope != true or $recordN < $numResultsVelvet + 1)
		} // end foreach
	} // end else not sorting by relevance
	?>
	</div><!-- /.results-feed #list-container -->
	
	<!-- RESULTS - GRID -->
	<div class = "results-feed hide" id = "grid-container">
		<?php
		// determine when to stop outputing item containers
		if($searchReviewsSort == 'rel') { $ceiling = $searchReviewsNumResults; } else { $ceiling = $resultSize; }
		if($foundcount < $ceiling) 		{ $stopAt = $foundcount; } else { $stopAt = $ceiling; }
		
		$numCols = 4; // number of columns per row
		$numRows = $ceiling/$numCols; // number of rows
		
		$rg = -1; // counter for review grid records
		for($row = 0; $row < $numRows; $row++)
		{
			echo '<div class = "bottom-10">';
				for($col = 0; $col < $numCols; $col++)
				{
					$rg++; // increment the records array counter with each column
					
					if($rg < $stopAt and ($velvetRope != true or $rg < $numResultsVelvet))
					{
						// OUTPUT ITEM SORTED BY RELEVANCE
						if($searchReviewsSort == 'rel')
						{
							$sortedRecord = $recordsToSort[$rg]; 	// locate the record by index number
							require 'php/get-sorted-review.php'; 	// get values for sorted record
							require 'php/result-item-grid.php'; 	// output the grid item
							//echo $titleText;
						}

						// OUTPUT ITEM SORTED NORMALLY
						else
						{
							
							$pageIndex = $rg + 1; // the nth result being output on this page
							$gridIndex = (($searchReviewsPage - 1) * $resultSize) + $pageIndex; // the nth result in the entire results array
							
							// prevent from outputting empty containers after the last result
							if($gridIndex <= $foundcount)
							{
								$item = $gridRecords[$rg]; 				// locate the record by index number
								require 'php/get-vars.php'; 			// get dynamically assigned variables
								require 'php/result-item-grid.php'; 	// output the grid item
							}
							//echo '$pageIndex: '.$pageIndex.', $gridIndex: '.$gridIndex.', $foundcount: '.$foundcount;
						}
					} // end if $rg < $stopAt
				} // end for col
			echo '</div>'; // /.bottom-20
		} // end for row
		
		// LOAD MORE RESULTS
		if($searchReviewsSort == 'rel' and $velvetRope != true)
		{
			$nextOption = $searchReviewsNumResults + $resultSize;
			if($foundcount < $nextOption) { $nextOptionLabel = $foundcount; } else { $nextOptionLabel = $nextOption; }
			//echo $searchReviewsNumResults.'/'.$lastOption.'<br/>';
			if($searchReviewsNumResults < $lastOption)
			{
				echo '<div class = "center top-10">';
					echo '<button type = "button" onclick = "loadMore('.$nextOption.')" title = "Load up to '.$nextOptionLabel.' results">';
						echo 'Load More Results';
					echo '</button>';
				echo '</div>';
			}
			else
			{
				echo '<a href = "#">Back to top</a>';
			}
			
		}
		echo '<div id = "results-'.$nextOption.'"></div>';
		?>
	</div><!-- /.results-feed #grid-container -->
	
	<?php require_once 'php/login-continue-btn.php'; // if velvet rope is true, display 'log in to continue' btn ?>
	
	<!-- PAGENAV (BOTTOM) -->
	<div class = "pagenav" id = "pagenav-bottom"><?php require 'php/pagenav.php';?></div>
	
</div><!-- /.search-area -->