<?php
/*
php/content/content-print.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the print page - it displays search results as a print-friendly list
*/
$type = test_input($_GET['type']); // either 'reviews' or 'bookmarks'
if($type == NULL) { $type = 'reviews'; }
if($type == 'bookmarks') { require 'php/find-bookmarks.php'; } // lookup the user's saved bookmarks 
require_once 'php/results-compile.php'; // process search results
?>
<div id = "print-page-container">

	<!-- HEADER (SEARCH DESCRIPTION AND HOME LINK) -->
	<div id = "print-page-header">
		<div class = "text-18">
			<?php
			// DESCRIPTION
			if($type == 'reviews') 			{ echo 'CTREX Search: '.$searchReviewsHeading; }
			else if($type == 'bookmarks') 	{ echo 'CTREX Bookmarked Reviews for <a href = "'.$profileURL.'">'.$username.'</a>'; }
			?>
		</div>
		<div class = "text-12" id = "search-url">
			<?php
			// LINK TO FULL VIEW
			if($type == 'reviews')
			{ 
				$homeLink = 'home.php';
				if($thisQuery != NULL) { $homeLink .= '?'.$thisQuery; } 
				echo '<a href = "'.$homeLink.'">'.$homeLink.'</a>';
			}
			else if($type == 'bookmarks')
			{
				echo '<a href = "savedbookmarks.php">savedbookmarks.php</a>';
			}
			?>
		</div>
	</div><!-- /#print-page-header -->
	
	<!-- OPTIONS (PRINT PAGE, EXPORT) -->
	<div id = "print-page-options">
		<?php
		if($type == 'reviews')	{ require_once 'php/search-options.php'; }
		else 					{ echo '<div class = "search-options-item pointer"><img src = "images/print32.png" onclick = "window.print();"/></div>'; }
		?>
	</div><!-- /#print-page-options -->
	
	<!-- RESULTS AS A TABLE -->
	<div id = "print-page-results">
		<div class = "text-12" id = "edchoice-note"><em>* Denotes Editor's Choice</em></div>
		<table class = "print-table">
			<?php
			// declare an array of table columns
			// label, varName
			$printCols = array
			(
				array('#'				, 'printN'),
				array('Title'			, 'title'),
				array('Publisher'		, 'company'),
				array('Date Reviewed'	, 'dateEntered'),
				array('Price'			, 'price'),
				array('Age Range'		, 'ages'),
				array('CTR Rating'		, 'score'),
			);
			?>
			<tr class = "tr-heading">
				<?php
				// output the table heading
				foreach($printCols as $printCol)
				{
					$printColLabel  = $printCol[0];
					echo '<td>'.$printColLabel.'</td>';
				}
				?>
			</tr>
		<?php
		// output the records
		$printN = -1; // counter for each row/record
		foreach($recordsToExport as $printRecord)
		{
			// the order of these values is defined in 'php/results-compile.php' $dataFields array
			$dateEntered 	= $printRecord[1];
			$title 			= $printRecord[2];
			$score			= $printRecord[3];
			$ages			= $printRecord[4];
			$subjects		= $printRecord[5];
			$platforms		= $printRecord[6];
			$price			= $printRecord[7];
			$company 		= $printRecord[8];
			$reviewLink		= $printRecord[9]; // this is the full absolute link (kept intact for exporting purposes)
			
			// parse out the relative link and wrap title with <a> tag to link to review
			$reviewLinkNeedle = 'ctr/';
			$reviewLinkNeedleLength = strlen($reviewLinkNeedle);
			$reviewLinkNeedlePos = strpos($reviewLink, 'ctr/');
			$reviewLinkStart = $reviewLinkNeedlePos + $reviewLinkNeedleLength;
			$reviewLink = substr($reviewLink, $reviewLinkStart);
			$title = '<a href = "'.$reviewLink.'">'.$title.'</a>';
			
			$printN += 1; // increment the counter for each row/record
			
			if($printN > 0) // don't output 0th row - column names
			{
				// determine whether odd or even row # to set row css class to dark or light
				//$lastDigit = substr($printN, -1, 1);
				//if($lastDigit == '1' or $lastDigit == '3' or $lastDigit == '5' or $lastDigit == '7' or $lastDigit == '9')
				$oddEven = oddEven($printN);
				if($oddEven == 'odd'){ $rowClass = 'tr-dark'; } else { $rowClass = 'tr-light'; }
				
				// output each record as a table row
				echo '<tr class = "'.$rowClass.'">';
					foreach($printCols as $printCol)
					{
						$printColVarName  	= $printCol[1];
						$printColValue 		= $$printColVarName;
						echo '<td class = "'.$printColClass.'">'.$printColValue.'</td>';
					}
				echo '</tr>';
			} // end if($printN > 0)
		} // end foreach($recordsToExport as $printRecord)
		?>
		</table>
	</div><!-- /#print-page-results -->
</div><!-- /#print-page-container