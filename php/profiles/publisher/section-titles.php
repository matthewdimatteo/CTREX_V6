<?php
/*
php/profiles/publisher/section-titles.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the content of the 'Titles Reviewed' tab of the Publisher Profile page
It is included dynamically in 'php/profiles/profile-sections.php'
*/

// SECTION CONTAINER
echo '<div id = "titles-info" class = "profile-section-content">';

// SECTION HEADER
$sectionHeader = 'Titles Reviewed by CTR';
if($inputMode == 'private') { $sectionHeader .= ' (Public)'; }
echo '<div class = "profile-section-header">'.$sectionHeader.'</div>'; // /.profile-section-header

// SUBHEADER
echo '<div class = "paragraph-70 center">';
	if($numTitlesReviewed > 0) { echo '<a href = "'.$moreTitlesURL.'" title = "View all on home page">'; }
		echo $numTitlesReviewed.' Titles Reviewed';
	if($numTitlesReviewed > 0) { echo '</a>'; }
echo '</div>'; // /.paragraph-70 center

// SUBMIT NEW
if($inputMode == 'private')
{
	echo '<div class = "paragraph-70 center">';
		echo '<button type = "button" onclick = "window.location.href = \'submit.php\';">Submit New</button>';
	echo '</div>'; // /.paragraph-70 center
}

// IF 1 OR MORE TITLES REVIEWED, OUTPUT LIST
if($numTitlesReviewed > 0)
{
	echo '<div class = "paragraph-70 left">';

	// TABLE START
	echo '<table class = "width-100">';

	// TABLE HEADER
	echo '<tr class = "tr-heading-blue"><td>Title</td><td>Copyright</td><td>Reviewed</td></tr>';

	// LIST OF TITLES
	$titleN = 0;
	foreach($titlesReviewedArray as $thisTitle)
	{
		$titleID	= $thisTitle[0];
		$titleName 	= $thisTitle[1];
		$copyright	= $thisTitle[2];
		$entered	= $thisTitle[3];
		$published	= $thisTitle[4];
		$titleN += 1;
		$row = oddEven($titleN); // determine whether row is odd or even numbered - function oddEven found in 'php/functions.php'
		if($row == 'odd') { $trClass = 'tr-title-dark'; }
		if($row == 'even'){ $trClass = 'tr-title-light'; }

		// ROW START
		echo '<tr class = "'.$trClass.'">';

			// TITLE/LINK TO REVIEW
			echo '<td class = "td-title">';
				if($published == true and $titleID != NULL) { echo '<a href = "review.php?id='.$titleID.'" title = "See the review for '.$titleName.'">'; }
					echo $titleName;
				if($published == true and $titleID != NULL) { echo '</a>'; }
			echo '</td>';

			// COPYRIGHT
			echo '<td>'; if($copyright != NULL) { echo '&copy; '.$copyright; } 	echo '</td>';

			// DATE ENTERED
			echo '<td>'; if($entered != NULL) 	{ echo $entered; } 				echo '</td>';

		echo '</tr>'; // ROW END
	} // end foreach title
	echo '</table>'; // TABLE END
	echo '</div>'; // /.paragraph-70 left
	if($numTitlesReviewed > 10) { echo '<div class = "paragraph-70 center top-10"><a href = "#">Back to top</a></div>'; }
} // end if $numTitlesReviewed > 0

echo '</div>'; // /#titles-info .profile-section-content
?>