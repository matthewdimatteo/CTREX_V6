<?php
/*
php/result-item-archive.php
By Matthew DiMatteo, Children's Technology Review

This file outputs an individual monthly/weekly result in the archive
It is included in 'php/content/content-archive.php'
*/

require 'php/result-item-archive-info.php'; // calculate urls, hover text, css classes based on monthly/weekly, access
?>

<div class = "result-item archive-item">
	
	<!-- HEADING WITH DATE, SUBJECT -->
	<a href = "<?php echo $archiveItemLink;?>" title = "<?php echo $archiveItemHover;?>">
	<div class = "result-item-heading">
		<div class = "result-item-heading-title" title = "<?php echo $archiveItemHeading;?>">
			<div class = "show-only-desktop"><?php echo $headingText;?></div>
			<div class = "show-only-1025"><?php echo $headingText1025;?></div>
			<div class = "show-only-769"><?php echo $headingText769;?></div>
			<div class = "show-only-480"><?php echo $headingText480;?></div>
		</div><!-- /.result-item-heading-title -->
	</div><!-- /.result-item-heading -->
	</a>
	
	<!-- COVER THUMB -->
	<div class = "<?php echo $archiveImgClass;?>">
		<?php
		echo '<a href = "'.$archiveItemLink.'" title = "'.$archiveItemHover.'">';
		if($linkThumb != NULL) 	{ echo '<img src = "'.$linkThumb.'" alt = "Image not available"/>'; }
		else 					{ echo '<div class = "no-image"><div class = "no-image-text">Image not available</div></div>'; }
		echo '</a>';
		?>
		<div class = "<?php echo $volumeLineClass;?>"><?php echo $volumeLine;?></div><!-- /volume line -->
		<div class = "<?php echo $archiveItemDownloadClass;?> no-print"><a href = "<?php echo $archiveItemDownloadLink;?>">Download issue as .pdf</a></div>
	</div><!-- /.result-item-image -->

	<!-- INFO -->
	<div class = "<?php echo $archiveInfoClass;?>">
	<?php
	// MONTHLY
	if($searchArchiveType == 'monthly')
	{
		if($numTitles != NULL) 
		{ 
			echo '<div class = "feature-reviews"><a href = "'.$issueTitlesLink.'" title = "'.$issueTitlesHover.'">'.$numTitles.' Feature Reviews</a></div>';
			echo '<div class = "text-12 bottom-10"><em>* Denotes Editor\'s Choice</em></div>';
			$gridTitles = array();
			$gridTitleMax 		= 36;
			$gridTitleMax1025	= 30;
			$gridTitleMax769	= 20;
			$gridTitleMax480	= 9;
			foreach($titles as $thisTitle)
			{
				$title 		= $thisTitle->getField('CSR::Title');
				$titleID	= $thisTitle->getField('CSR::reviewnumber');
				$titleLink	= 'review.php?id='.$titleID;
				$edChoice	= $thisTitle->getField('CSR::edChoice');
				if($edChoice != NULL) { $title = '*'.$title; }
				$titleText 		= trimText($title, $gridTitleMax);
				$titleText1025 	= trimText($title, $gridTitleMax1025);
				$titleText769 	= trimText($title, $gridTitleMax769);
				$titleText480 	= trimText($title, $gridTitleMax480);
				$thisTitleInfo = array($title, $titleLink);
				array_push($gridTitles, array($title, $titleLink, $titleText, $titleText1025, $titleText769, $titleText480));
				//echo $title.'<br/>';
			} // end foreach title

			$numCols = 3; // number of columns per row
			$numRows = $numTitles/$numCols; // number of rows

			$tg = -1; // counter for result grid records
			for($row = 0; $row < $numRows; $row++)
			{
				echo '<div class = "archive-item-title-row">';
					for($col = 0; $col < $numCols; $col++)
					{
						$tg++; // increment the titles array counter with each column
						echo '<div class = "archive-item-title-col">';
							// prevent from outputting empty containers after the last result
							if($tg < $numTitles)
							{
								$gridTitleInfo 		= $gridTitles[$tg];
								$gridTitle 			= $gridTitleInfo[0];
								$gridTitleLink 		= $gridTitleInfo[1];
								$gridTitleText		= $gridTitleInfo[2];
								$gridTitleText1025	= $gridTitleInfo[3];
								$gridTitleText769	= $gridTitleInfo[4];
								$gridTitleText480	= $gridTitleInfo[5];
								echo '<div class = "show-only-desktop">';
									echo '<a href = "'.$gridTitleLink.'" title = "See our review of '.$gridTitle.'">'.$gridTitleText.'</a>';
								echo '</div>';
								echo '<div class = "show-only-1025">';
									echo '<a href = "'.$gridTitleLink.'" title = "See our review of '.$gridTitle.'">'.$gridTitleText1025.'</a>';
								echo '</div>';
								echo '<div class = "show-only-769">';
									echo '<a href = "'.$gridTitleLink.'" title = "See our review of '.$gridTitle.'">'.$gridTitleText769.'</a>';
								echo '</div>';
								echo '<div class = "show-only-480">';
									echo '<a href = "'.$gridTitleLink.'" title = "See our review of '.$gridTitle.'">'.$gridTitleText480.'</a>';
								echo '</div>';
							} // end if $tg < $numTitles
						echo '</div>'; // /.archive-item-title-col
					} // end for col
				echo '</div>'; // /row
			} // end for row
		} // end if $numTitles != NULL
	} // end if type == monthly

	// WEEKLY
	else
	{
		if($numTitles > 0)
		{
			switch($numTitles)
			{
				case 1 : $titleColClass = 'inline full-width'; 	$titleMax = 100; 	$titleMax1025 = 80; $titleMax769 = 60; $titleMax480 = 40;	
				break;
				case 2 : $titleColClass = 'inline halves';		$titleMax = 50;		$titleMax1025 = 40; $titleMax769 = 30; $titleMax480 = 20;	
				break;
				case 3 : $titleColClass = 'inline thirds';		$titleMax = 30;		$titleMax1025 = 25; $titleMax769 = 25; $titleMax480 = 12;	
				break;
				case 4 : $titleColClass = 'inline quarters';	$titleMax = 25;		$titleMax1025 = 20; $titleMax769 = 15; $titleMax480 = 10;	
				break;
				case 5 : $titleColClass = 'inline fifths';		$titleMax = 20;		$titleMax1025 = 20; $titleMax769 = 15; $titleMax480 = 8;	
				break;
				case 6 : $titleColClass = 'inline sixths';		$titleMax = 16;		$titleMax1025 = 20; $titleMax769 = 15; $titleMax480 = 5;	
				break;
			} // end switch($numTitles)
			foreach($titles as $thisTitle)
			{
				$titleName 		= $thisTitle->getField('CSR::Title');
				$titleImg 		= $thisTitle->getField('CSR::Sample Screen');
				$titleImgData	= $thisTitle->getField('CSR::imgData');
				$titleID		= $thisTitle->getField('CSR::reviewnumber');
				$titleLink		= 'review.php?id='.$titleID;
				
				echo '<div class = "'.$titleColClass.'">';
					echo '<div class = "weekly-img">';
						echo '<a href = "'.$titleLink.'" title = "Read our review of '.$titleName.'">';
							if($titleImg != NULL and $titleImgData != '?') { echo '<img src = "php/img.php?-url='.urlencode($titleImg).'" >'; }
							else { echo '<div class = "no-image"><div class = "no-image-text">Image not available</div></div>'; }
						echo '</a>';
					echo '</div>'; // /.weekly-img
					//if(strlen($titleName) > $titleMax) { $titleText = substr($titleName, 0, $titleMax); } else { $titleText = $titleName; }
					$titleText 		= trimText($titleName, $titleMax);
					$titleText1025 	= trimText($titleName, $titleMax1025);
					$titleText769 	= trimText($titleName, $titleMax769);
					$titleText480 	= trimText($titleName, $titleMax480);
					echo '<div class = "weekly-title">';
						echo '<div class = "show-only-desktop">';
							echo '<a href = "'.$titleLink.'" title = "Read our review of '.$titleName.'">'.$titleText.'</a>';
						echo '</div>'; // /.show-only-desktop
						echo '<div class = "show-only-1025">';
							echo '<a href = "'.$titleLink.'" title = "Read our review of '.$titleName.'">'.$titleText1025.'</a>';
						echo '</div>'; // /.show-only-1025
						echo '<div class = "show-only-769">';
							echo '<a href = "'.$titleLink.'" title = "Read our review of '.$titleName.'">'.$titleText769.'</a>';
						echo '</div>'; // /.show-only-769
						echo '<div class = "show-only-480">';
							echo '<a href = "'.$titleLink.'" title = "Read our review of '.$titleName.'">'.$titleText480.'</a>';
						echo '</div>'; // /.show-only-480
					echo '</div>'; // /.weekly-title
				echo '</div>'; // /.$titleColClass
			} // end foreach title
		} // end if($numTitles > 0)
	} // end else weekly
	?>
	</div><!-- /.result-item-info -->
</div><!-- /.result-item -->
