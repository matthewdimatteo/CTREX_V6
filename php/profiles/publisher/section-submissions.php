<?php
/*
php/profiles/publisher/section-submissions.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the content of the 'Titles Submitted' tab of the Publisher Profile page
It is included dynamically in 'php/profiles/profile-sections.php'
*/

// SECTION CONTAINER
echo '<div id = "submissions-info" class = "profile-section-content">';

// SECTION HEADER
echo '<div class = "profile-section-header">Submissions Received (Private)</div>'; // /.profile-section-header

// SUBHEADER
echo '<div class = "paragraph-70 center">';
	if		($numTitlesSubmitted < 1 and $numTitlesReviewed < 1) { $subheader = 'No titles submitted'; }
	else if ($numTitlesSubmitted < 1 and $numTitlesReviewed > 0) { $subheader = 'All submissions have been reviewed'; }
	else	{ $subheader = $numTitlesPending.' titles not reviewed'; }
	echo $subheader;
echo '</div>'; // /.paragraph-70 center

echo '<div class = "paragraph-70 center">';
	echo '<button type = "button" onclick = "window.location.href = \'submit.php\';">Submit New</button>';
echo '</div>'; // /.paragraph-70 center

// IF 1 OR MORE SUBMISSIONS NOT REVIEWED, OUTPUT LIST
if($numTitlesPending > 0)
{
	echo '<div class = "paragraph-70 left">';

	// TABLE START
	echo '<table class = "width-100">';

	// TABLE HEADER
	echo '<tr class = "tr-heading"><td>Title</td><td>Copyright</td><td>Received</td></tr>';

	// LIST OF TITLES
	$titleN = 0;
	foreach($titlesSubmittedArray as $thisTitle)
	{
		$titleID	= $thisTitle[0];
		$titleName 	= $thisTitle[1];
		$copyright	= $thisTitle[2];
		$entered	= $thisTitle[3];
		$published	= $thisTitle[4];
		$titleN += 1;
		$row = oddEven($titleN); // determine whether row is odd or even numbered - function oddEven found in 'php/functions.php'
		if($row == 'odd') { $trClass = 'tr-dark'; }
		if($row == 'even'){ $trClass = 'tr-light'; }

		// ROW START
		echo '<tr class = "'.$trClass.'">';

			// TITLE
			echo '<td class = "td-title">'.$titleName.'</td>';

			// COPYRIGHT
			echo '<td>'; if($copyright != NULL) { echo '&copy; '.$copyright; } 	echo '</td>';

			// DATE ENTERED
			echo '<td>'; if($entered != NULL) 	{ echo $entered; } 				echo '</td>';

		echo '</tr>'; // ROW END
	} // end foreach title
	echo '</table>'; // TABLE END
	echo '</div>'; // /.paragraph-70 left
	if($numTitlesSubmitted > 10) { echo '<div class = "paragraph-70 center top-10"><a href = "#">Back to top</a></div>'; }
} // end if $numTitlesReviewed > 0

echo '</div>'; // /#submissions-info .profile-section-content
?>