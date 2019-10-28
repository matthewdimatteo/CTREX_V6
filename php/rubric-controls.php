<!--
php/rubric-controls.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the rubric selection menu and includes the file to output a rubric evaluation form 'php/rubric-output.php' after a selection is made
It is included in the rubrics page via 'php/content/content-rubrics.php' and the editorial page via 'php/content/content-editorial.php'
-->

<!-- RUBRIC SELECTOR ROW -->
<div id = "rubric-menu" class = "top-10">

	<!-- LEFT PADDING -->
	<div id = "rubric-menu-col-left"></div>
	
	<!-- CENTER - MAIN CONTROLS -->
	<div id = "rubric-menu-col-center">
	
		<?php
		// CTR RUBRIC OPTIONS
		echo '<div class = "rubric-menu-col-set" id = "rubric-menu-ctr">';

			// LEFT PADDING
			if($ctrRubric != NULL) { echo '<div class = "rubric-menu-col-btns" id = "rubric-menu-col-left-pad-ctr"></div>'; }

			// CENTER SELECT
			echo '<div class = "rubric-menu-col-select">';

				// CTR RUBRIC SELECT FORM
				echo '<div class = "rubric-menu-col" id = "rubric-menu-col-ctr-select">';
					$showSavedRubrics = ''; // clear this boolean to tell 'php/rubric-select.php' to show CTR rubrics
					require 'php/rubric-select.php'; // output the select element (dropdown menu) and form
				echo '</div>'; // /.rubric-menu-col

			echo '</div>'; // /.rubric-menu-col-select

			// RIGHT - CTR RUBRIC BTNS
			if($ctrRubric != NULL)
			{
				echo '<div class = "rubric-menu-col-btns">';

					// CTR RUBRIC DESCRIPTION BTN
					if($selectedDescription != NULL)
					{
						echo '<div class = "rubric-menu-col" id = "rubric-menu-col-ctr-info">';
							echo '<div id = "show-rubric-description" class = "block" 	
								onclick = "showItem(\'show-rubric-description\', \'hide-rubric-description\', \'rubric-description\')">';
								echo '<img src = "images/info.png" class = "rubric-info-btn" title = "Expand description"/>';
							echo '</div>';
							echo '<div id = "hide-rubric-description" class = "hide" 		
								onclick = "hideItem(\'show-rubric-description\', \'hide-rubric-description\', \'rubric-description\')">';
								echo '<img src = "images/info.png" class = "rubric-info-btn" title = "Hide description"/>';
							echo '</div>';
						echo '</div>'; // /.rubric-menu-col
					} // end if $selectedDescription

					// CTR RUBRIC PRINT BTN COL
					if($ctrRubric != NULL)
					{
						echo '<div class = "rubric-menu-col" id = "rubric-menu-col-ctr-print">';
							echo '<img src = "images/print32.png" class = "pointer top-4" title = "Print this rubric" onclick = "window.print();"/>';
						echo '</div>'; // /.rubric-menu-col
					} // end if $ctrRubric

				echo '</div>'; // /.rubric-menu-col-btns
			} // end if $ctrRubric
		echo '</div>'; // /.rubric-menu-col-set #rubric-menu-ctr

		// SAVED RUBRIC OPTIONS
		if($numSavedRubrics > 0)
		{
			echo '<div class = "rubric-menu-col-set" id = "rubric-menu-saved">';

				// LEFT - SAVED RUBRIC PADDING
				if($savedRubricID != NULL) { echo '<div class = "rubric-menu-col-btns" id = "rubric-menu-col-left-pad-saved"></div>'; }

				// CENTER - SAVED RUBRIC SELECT
				echo '<div class = "rubric-menu-col-select">';

					// SAVED RUBRIC SELECT FORM
					echo '<div class = "rubric-menu-col left-20" id = "rubric-menu-col-saved-select">';
						$showSavedRubrics = true; // set this boolean to true to tell 'php/rubric-select.php' show saved rubrics
						require 'php/rubric-select.php'; // output the select element (dropdown menu) and form
					echo '</div>'; // /.rubric-menu-col

				echo '</div>'; // /.rubric-menu-col-select

				// RIGHT - SAVED RUBRIC BTNS
				if($savedRubricID != NULL)
				{
					echo '<div class = "rubric-menu-col-btns">';

						// SAVED RUBRIC DESCRIPTION BTN
						if($savedRubricDescription != NULL)
						{
							echo '<div class = "rubric-menu-col" id = "rubric-menu-col-saved-info">';
								echo '<div id = "show-saved-rubric-description" class = "block" 	
									onclick = "showItem(\'show-saved-rubric-description\', \'hide-saved-rubric-description\', \'saved-rubric-description\')">';
									echo '<img src = "images/info.png" class = "rubric-info-btn" title = "Expand description"/>';
								echo '</div>';
								echo '<div id = "hide-saved-rubric-description" class = "hide" 		
									onclick = "hideItem(\'show-saved-rubric-description\', \'hide-saved-rubric-description\', \'saved-rubric-description\')">';
									echo '<img src = "images/info.png" class = "rubric-info-btn" title = "Hide description"/>';
								echo '</div>';
							echo '</div>'; // /.rubric-menu-col
						} // end if $savedRubricDescription

						// SAVED RUBRIC PRINT BTN COL
						if($savedRubricID != NULL)
						{
							echo '<div class = "rubric-menu-col" id = "rubric-menu-col-saved-print">';
								echo '<img src = "images/print32.png" class = "pointer top-4" title = "Print this rubric" onclick = "window.print();"/>';
							echo '</div>'; // /.rubric-menu-col
						} // end if $savedRubricID
					
					echo '</div>'; // /.rubric-menu-col-btns
				} // end if $savedRubricID
			echo '</div>'; // /.rubric-menu-col-set #rubric-menu-saved
		} // end if $numSavedRubrics> 0

		?>
	</div><!-- /#rubric-menu-col-center -->
	
	<!-- RIGHT - CREATE YOUR OWN -->
	<div id = "rubric-menu-col-right">
		<?php 
		if($ctrRubric != NULL or $savedRubricID != NULL)
		{ 
			echo '<div class = "text-20 top-10"><a href = "rubric-create.php">Create Your Own &#62;</a></div>'; 
		} 
		else { echo '&nbsp;'; }
		?>
	</div><!-- /.rubric-menu-col-right -->

</div><!-- #rubric-menu -->

<?php
if($ctrRubric == NULL and $savedRubricID == NULL)
{
	echo '<div class = "text-20" id = "alt-rubric-page">';
		echo '<a href = "rubric-create.php">Create Your Own &#62;</a>';
	echo '</div>'; // /.subheader
} // end if rubric

// CTR RUBRIC DESCRIPTION
if($selectedDescription != NULL) 
{ echo '<div id = "rubric-description" 			class = "hide"><div class = "paragraph-90 left">'.$selectedDescription.'</div></div>'; }

// SAVED RUBRIC DESCRIPTION
if($savedRubricDescription != NULL)
{ echo '<div id = "saved-rubric-description" 	class = "hide"><div class = "paragraph-90 left">'.$savedRubricDescription.'</div></div>'; }

// SELECTED RUBRIC QA
echo '<div id = "evaluate"></div>';
if($selectedQAData != NULL) { $rubricOutputClass = 'block'; } else { $rubricOutputClass = 'hide'; }
require 'php/rubric-output.php'; // outputs the evaluation form