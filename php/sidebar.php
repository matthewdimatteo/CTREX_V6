<?php
/*
php/sidebar.php
By Matthew DiMatteo, Children's Technology Review

This file outputs a left sidebar on search pages containing additional options
It is included in 'php/search-reviews.php'
*/

// REVIEWS
if($searchType != 'publishers')
{
	//$publishedReviewCount = $totalPublishedReviews; // the field in settings.php needs to be manually updated and gets out of sync with foundcount
	if($publishedReviewCount == NULL) { $publishedReviewCount = '12,800+'; }
	else { $publishedReviewCount = number_format($publishedReviewCount, 0, '.', ','); }
	$sidebarSections = array
	(
		array
		(
			'Browse '.$publishedReviewCount.' academic reviews',
			// 	array(label				, id						, isArray	, link/arrayItems)
			array
			(
				array('Latest Reviews'	, 'Latest+Reviews'			, false	, 'home.php?filter[]=current&quickfind=Latest+Reviews&page=1'),
				array('Editor\'s Choice', 'Editor\'s+Choice'		, false	, 'home.php?filter[]=awards&quickfind=Editor\'s+Choice&page=1'),
				array('All Time Best'	, 'All+Time+Best'			, false	, 'home.php?sort=best&category=AllTimeBestApps&quickfind=All+Time+Best&page=1')
			)
		),
		array
		(
			'Find products by category:',
			array
			(
				array('Age Range'		, 'age-range-options'		, true	, $ageRangeOptions), 
				array('Grade Level'		, 'grade-level-options'		, true	, $gradeLevelOptions), 
				array('Platforms'		, 'platform-options'		, true	, $platformOptions), 
				array('Subjects'		, 'subject-options'			, true	, $subjectOptions), 
				array('Special Topics'	, 'special-topic-options'	, true	, $specialTopicOptions)
			)
		),
		array
		(
			'Find resources for:',
			array
			(
				array('Families'		, 'families-options'		, true 	, $familiesOptions),
				array('Libraries'		, 'libraries-options'		, true	, $librariesOptions),
				array('Schools'			, 'schools-options'			, true	, $schoolsOptions),
				array('Early Childhood'	, 'ece-options'				, true	, $eceOptions),
				array('Publishers'		, 'publisher-options'		, true	, $publisherOptions)
			)
		)
	);

	// OUTPUT
	foreach($sidebarSections as $sidebarSection)
	{
		$sidebarSectionHeading 	= $sidebarSection[0];
		$sideBarSectionItems 	= $sidebarSection[1];

		// SECTION CONTAINER
		echo '<div class = "sidebar-section">';

			// SECTION HEADING
			echo '<div class = "sidebar-section-heading">'.$sidebarSectionHeading.'</div>';

			// SECTION ITEMS
			echo '<div class = "sidebar-section-items">';
				foreach($sideBarSectionItems as $sideBarSectionItem)
				{
					$sidebarItemLabel 	= $sideBarSectionItem[0];
					$sidebarItemID		= $sideBarSectionItem[1];
					$sidebarItemArray	= $sideBarSectionItem[2];
					$sidebarItemOptions	= $sideBarSectionItem[3];

					// ITEM
					echo '<div class = "sidebar-section-item">';

						// IF SIDEBAR CONTAINS AN ARRAY OF ITEM OPTIONS
						if($sidebarItemArray == true)
						{
							// SHOW/HIDE BUTTONS
							echo '<div class = "show" id = "sidebar-item-show-'.$sidebarItemID.'">';
								echo '<div class = "sidebar-item-button" 
									onclick = "showItemN(\'sidebar-item-show-\', \'sidebar-item-hide-\', \'sidebar-item-options-\', \''.$sidebarItemID.'\')">';
									echo '<div class = "sidebar-item-button-text">'.$sidebarItemLabel.'</div>';
									echo '<div class = "sidebar-item-button-icon">&#9660;</div>';
								echo '</div>'; // /.sidebar-item-button
							echo '</div>'; // /.show

							echo '<div class = "hide" id = "sidebar-item-hide-'.$sidebarItemID.'">';
								echo '<div class = "sidebar-item-button" 
									onclick = "hideItemN(\'sidebar-item-show-\', \'sidebar-item-hide-\', \'sidebar-item-options-\', \''.$sidebarItemID.'\')">';
									echo '<div class = "sidebar-item-button-text">'.$sidebarItemLabel.'</div>';
									echo '<div class = "sidebar-item-button-icon">&#9650;</div>';
								echo '</div>'; // /.sidebar-item-button
							echo '</div>'; // /.hide

							// CONTAINER FOR TOGGLEABLE ITEMS
							echo '<div class = "sidebar-item-options" id = "sidebar-item-options-'.$sidebarItemID.'">';

							foreach($sidebarItemOptions as $itemOption)
							{
								$searchInput		= $itemOption[0];
								if($searchInput == 'publishers')
								{
									$sidebarItemLink	= $itemOption[2];
									$sidebarItemLabel	= $itemOption[3];
								}
								else
								{
									$searchParam 		= $itemOption[1];
									$quickfindParam 	= $itemOption[2];
									$quickfindParamParsed = str_replace('+', ' ', $quickfindParam);
									$sidebarItemLabel	= $itemOption[3];
									$itemOptionClass = 'sidebar-item-option';
									if($quickfind == $quickfindParamParsed) { $itemOptionClass .= '-active'; }
									$mainAction = 'home.php';
									$sidebarItemLink = $mainAction.'?'.$searchInput.'='.$searchParam.'&quickfind='.$quickfindParam.'&page=1';
									$sidebarItemOnclick = 'powersearchShow()';
								}

								// ITEM BUTTONS
								echo '<a href = "'.$sidebarItemLink.'" '; 
									if($sidebarItemOptions != $publisherOptions) { echo 'onclick = "powersearchShow()"'; } 
								echo '>';
									echo '<div class = "'.$itemOptionClass.'">';
										echo '<div class = "sidebar-item-option-text">'.$sidebarItemLabel.'</div>';
										echo '<div class = "sidebar-item-option-icon">></div>';
									echo '</div>'; // /.sidebar-item
								echo '</a>';
							} // end foreach $sidebarItemOptions
							echo '</div>'; // /.sidebar-item-options
						} // end if $sidebarItemArray

						// IF SIDEBAR ITEM IS A SINGLE LINK
						else
						{
							$itemClass = 'sidebar-item-';
							$quickfindParam = $sidebarItemID;
							$quickfindParamParsed = str_replace('+', ' ', $quickfindParam);
							if($quickfind != NULL and $quickfind == $quickfindParamParsed) { $itemClass .= 'label'; } else { $itemClass .= 'button'; }
							$sidebarItemLink = $sidebarItemOptions;
							//echo '$quickfind: '.$quickfind.', $quickfindParamParsed'.$quickfindParamParsed.'<br/>';
							echo '<a href = "'.$sidebarItemLink.'">';
								echo '<div class = "'.$itemClass.'">';
									echo '<div class = "sidebar-item-option-text">'.$sidebarItemLabel.'</div>';
									echo '<div class = "sidebar-item-option-icon">></div>';
								echo '</div>';
							echo '</a>';
						} // end else single link

					echo '</div>'; // /.sidebar-section-item
				} // end foreach $sidebarSectionItem
			echo '</div>'; // /.sidebar-section-items
		echo '</div>'; // /.sidebar-section
	} // end foreach $sidebarSection
} // end if($searchType != 'publishers')

// PUBLISHERS
else if ($searchType == 'publishers')
{
	//$activePublisherCount = $totalActivePublishers;
	if($activePublisherCount == NULL) { $activePublisherCount = '2,700+'; }
	else { $activePublisherCount = number_format($activePublisherCount, 0, '.', ','); }
	
	// SECTION CONTAINER
	echo '<div class = "sidebar-section">';
	
		// SECTION HEADING
		echo '<div class = "sidebar-section-heading">Browse '.$activePublisherCount.' Publishers:</div>';
		
		echo '<div class = "sidebar-section-items">';
			echo '<a href = "'.$lastSearchPublishers.'">';
				echo '<div class = "sidebar-item-label">';
					echo '<div class = "sidebar-item-option-text">Publisher Directory</div>';
					echo '<div class = "sidebar-item-option-icon">></div>';
				echo '</div>'; // /.sidebar-item
			echo '</a>';
		echo '</div>';// /.sidebar-section-items
	
	echo '</div>'; // /.sidebar-section
	
	// SECTION CONTAINER
	echo '<div class = "sidebar-section">';
		
		// SECTION ITEMS
		echo '<div class = "sidebar-section-items">';
		
			// SECTION HEADING
			echo '<div class = "sidebar-section-heading">Publisher Resources:</div>';
		
			// $publisherOptions array defined in 'php/sidebar-options.php'
			foreach($directoryOptions as $pubOption)
			{
				$pubOptionLink 	= $pubOption[2];
				$pubOptionLabel = $pubOption[3];
				echo '<a href = "'.$pubOptionLink.'" '; if(substr_count($pubOptionLink, 'http') > 0) { echo ' target = "_blank"'; } echo '>';
					echo '<div class = "sidebar-item-button">';
						echo '<div class = "sidebar-item-option-text">'.$pubOptionLabel.'</div>';
						echo '<div class = "sidebar-item-option-icon">></div>';
					echo '</div>'; // /.sidebar-item
				echo '</a>';
			} // end foreach $pubOption
			
		echo '</div>'; // /.sidebar-section-items
	echo '</div>'; // /.sidebar-section
} // end if($searchType == 'publishers')
?>