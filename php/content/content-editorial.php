<?php
/*
php/content/content-editorial.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the editorial page (for writing and editing reviews)
*/

// gate out anyone who is not an expert or a moderator
if($expert != true and $mod != true and $student != true and $juror != true) { $redirect = 'home.php'; require_once 'php/redirect.php'; exit(); }
$editType = $_GET['type']; // determine the type of editorial action - writing new review or editing existing
if($editType == 'edit') { require_once 'php/load-review.php'; } 	// if editing existing review, get the id input and load the review if id# specified
else 					{ require_once 'php/review-format.php'; }	// include this file anyway to set div class values

// gate out students attempting to edit reviews other than their own
if($editType == 'edit' and $student == true and $authorID != $userID) { $redirect = 'home.php'; require_once 'php/redirect.php'; exit(); }

// gate out jurors entering new
//if($editType == 'new' and $juror == true) { $redirect = 'home.php'; require_once 'php/redirect.php'; exit(); }

// gate out jurors editing anything other than their own and current entries
if($editType == 'edit' and $juror == true and $authorID != $userID and $bolognaYear != $year and $kapiYear != $year)
{ $redirect = 'home.php'; require_once 'php/redirect.php'; exit(); }

// determine checkbox input values for Ed. Choice, Ethical Seals
$awardsValue;
if($edchoice == true) 			{ $awardsValue = 'edchoice'; }
if($ethical == true)
{
	if($awardsValue != NULL) 	{ $awardsValue .= ', ethical'; }
	else						{ $awardsValue = 'ethical'; }
} // end if $ethical

//foreach($platformValueListItems as $valueListItem) { echo $valueListItem.'</br>'; }
?>

<!-- PAGE CONTENT CONTAINER START -->
<div class = "review-container">
	
	<!-- FORM START -->
	<div id = "editorial-form">
	
		<!-- DETAILS -->
		<div class = "<?php echo $reviewDetailsClass;?>" id = "review-details">

			<!-- EDITORIAL INDICATOR -->
			<div class = "editorial-heading">
				Editing as 
				<?php 
					 if($mod == true) 		{ echo 'Moderator '; } 
				else if($expert == true) 	{ echo 'Expert '; } 
				else if($student == true) 	{ echo 'Student '; } 
				echo '<a href = "'.$profileURL.'">'.$fullName.'</a>';
				?>
			</div><!-- /.editorial-heading -->

			<!-- TITLE AND COPYRIGHT INFO -->
			<?php 
			if($editType == 'edit') { require_once 'php/review-title.php'; } // title and copyright info 
			else if($editType == 'new') { echo '<div class = "review-title">New Product Entry</div>'; }
			?>

			<!-- PRODUCT DETAILS HEADING -->
			<div class = "review-heading bottom-10">Product Details</div>

			<!-- PRODUCT DETAILS FIELDS -->
			<div class = "product-details">

				<!-- PUBLISHED/UNPUBLISHED -->
				<div class = "row bottom-10">
					<div class = "field-label">Status:</div>
					<div class = "field-container">
						<div class = "inline right-5">
							<input type = "radio" name = "status" id="unpublished" 	value = "" 			
								<?php if($published == NULL) { echo 'checked '; } ?>
								onchange = "document.getElementById('status').value = '';"
							/>
						</div><!-- /.inline right-5 -->
						<div class = "inline">Unpublished</div>
						<div class = "inline right-5">
							<input type = "radio" name = "status" id="published" 	value = "published" 
								<?php if($published != NULL) { echo 'checked '; } ?>
								onchange = "document.getElementById('status').value = 'published';"
							/>
						</div><!-- /.inline right-5 -->
						<div class = "inline">Published</div>
					</div><!-- /.field-container-->
					<div class = "field-note"></div>
					<div class = "hide">
						<input type = "hidden" id = "status" value = "<?php echo $published;?>" />
					</div><!-- /.hide -->
				</div><!-- /.row bottom-10-->

				<?php
				// ISSUE/WEEKLY
				$dropdownItems = array
				(
					array('CTR Issue'	, 'issue'	, $issue	, $issueValueListItems),
					array('CTR Weekly'	, 'weekly'	, $weekly	, $weeklyValueListItems),
				);
				require 'php/form-dropdown-output.php';

				// CORE INFO
				// label, name/id, value, type, required, note
				$fields = array
				(
					array('Title'		, 'title'		, $title		, 'text', true	, ''),
					array('Copyright'	, 'copyright'	, $copyright	, 'text', false	, ''),
					array('Publisher'	, 'company'		, $company		, 'text', true	, ''),
					array('Price'		, 'price'		, $price		, 'text', false	, ''),
					array('Filesize'	, 'filesize'	, $filesize		, 'text', false	, ''),
					array('Age Range'	, 'ages'		, $ages			, 'text', false	, ''),
				);
				require 'php/form-fields-output.php';

				// GRADE LEVEL
				// label, name/id, value, value list
				$dropdownItems = array
				(
					array('Grade Level', 'grades', $grades, $gradeValueListItems),
				);
				require 'php/form-dropdown-output.php';

				// PLATFORM, SUBJECT, TOPIC, LANGUAGE, SCAFFOLDING
				/*
				$fields = array
				(
					array('Grade Level'		, 'grades'			, $grades			, 'text', false	, ''),
					array('Platforms'		, 'platforms'		, $platforms		, 'textarea', false	, ''),
					array('Subjects'		, 'subjects'		, $subjects			, 'textarea', false	, ''),
					array('Language List'	, 'languageList'	, $languageList		, 'textarea', false	, ''),
					array('Language Notes'	, 'languageNotes'	, $languageNotes	, 'textarea', false	, ''),
					array('Scaffolding List', 'scaffoldingList'	, $scaffoldingList	, 'textarea', false	, ''),
				);
				require 'php/form-fields-output.php';
				*/
				
				// CHECKBOXES
				// label, input name, set value, set item array
				$platformCheckboxSet 	= array('Platforms'		, 'platforms'	, $platforms		, $platformValueListItems);
				$subjectCheckboxSet 	= array('Subjects'		, 'subjects'	, $subjects			, $subjectValueListItems);
				$topicCheckboxSet 		= array('Topics'		, 'topics'		, $topicsOrig		, $topicValueListItems);
				$languageCheckboxSet	= array('Languages'		, 'languages'	, $languageText		, $languageValueListItems);
				$scaffoldingCheckboxSet = array('Scaffolding'	, 'scaffolding'	, $scaffoldingText	, $scaffoldingValueListItems);
				$checkboxSets = array($platformCheckboxSet, $subjectCheckboxSet, $topicCheckboxSet, $languageCheckboxSet, $scaffoldingCheckboxSet);
				require 'php/form-checkbox-output.php';
				
				//echo $platformValueListItems.' ('.count($platformValueListItems).')<br/>';
				
				// LANGUAGE NOTES
				$fields = array
				(
					array('Language Notes'	, 'languageNotes'	, $languageNotes	, 'textarea', false	, '')
				);
				require 'php/form-fields-output.php';
				echo '<br/>';
				
				// LINKS
				$fields = array
				(
					array('iTunes Link'	, 'linkItunes'	, $linkItunes	, 'text', false	, ''),
					array('Android Link', 'linkAndroid'	, $linkAndroid	, 'text', false	, ''),
					array('Kindle Link'	, 'linkAmazon'	, $linkAmazon	, 'text', false	, ''),
					array('Steam Link'	, 'linkSteam'	, $linkSteam	, 'text', false	, ''),
					array('Video Link'	, 'linkVideo'	, $linkVideo	, 'text', false	, ''),
				);
				require 'php/form-fields-output.php';
				
				?>
			</div><!-- /.product-details -->

		</div><!-- /#review-details -->

		<!-- IMAGE GALLERY -->
		<div class = "<?php echo $reviewMediaClass;?>" id = "review-media"><?php if($editType == 'edit') { require_once 'php/review-images.php'; } ?></div>

		<!-- WRITE REVIEW HEADING -->
		<div class = "review-heading bottom-10">Review</div>

		<!-- REVIEW -->
		<div class = "editorial-review">
			<textarea name = "review" id = "reviewText" rows = "10" cols = "50" placeholder = "Write your review..."><?php echo $reviewText;?></textarea>
		</div><!-- /.editorial-review -->

		<!-- NOTES -->
		<div class = "editorial-notes">
			<textarea name = "notes" id = "reviewNotes" rows = "10" cols = "30" placeholder = "Add notes..."><?php echo $editorialNotes;?></textarea>
		</div><!-- /.editorial-notes -->

		<!-- STANDARD RATING HEADING -->
		<div class = "review-heading bottom-10">Standard Rating</div>
		<?php
		$rubricUsed = 'Standard';
		$getSelectedRubric	= true;			// this boolean tells 'php/find-rubrics.php' to lookup a single rubric instead of all rubrics
		$primaryRubric 		= true;			// this boolean tells 'php/get-rubrics' to output the individual qa after the name/score line
		require 'php/find-rubrics.php';		// this file looks up either one rubric or all rubrics and gets their qa, storing them in an array
		require 'php/rating-qa-standard.php'; // outputs separate qa set for standard rubric evaluation
		?>
		
		<!-- EDITOR'S CHOICE, ETHICAL -->
		<div class = "text-20 full-width center top-10 bottom-10">
			<div class = "inline right-20">Awards:</div>
			<div class = "inline right-5">
				<input type = "checkbox" name = "edchoice" id="awards_edchoice" 	value = "edchoice" 
					<?php if($edChoice == true) { echo 'checked '; } ?> 	onchange = "checkboxUpdate('awards_edchoice', 'edchoice', 'awards')"
				/>
			</div><!-- /.inline right-5 -->
			<div class = "inline right-10">Editor's Choice</div>
			<div class = "inline right-5">
				<input type = "checkbox" name = "ethical" id="awards_ethical" 		value = "ethical" 
					<?php if($ethical == true) { echo 'checked '; } ?>		onchange = "checkboxUpdate('awards_ethical', 'ethical', 'awards')"
				/>
			</div><!-- /.inline right-5 -->
			<div class = "inline">Ethical</div>
			<div class = "hide"><input type = "hidden" name = "awards" 	id = "awards" 	value = "<?php echo $awardsValue;?>" /></div>
		</div><!-- /.row bottom-10-->
		
	</div><!-- /#editorial-form -->
	
	<!-- ADDITIONAL RUBRICS RATING HEADING -->
	<div class = "review-heading bottom-10">Additional Rubric Rating</div>
	<?php 
	//echo '$rubricsText: '.$rubricsText.'<br/>'; echo '$rubricsTextArray: '.$rubricsTextArray.'<br/>'; echo '$numRubricsSelected: '.$numRubricsSelected.'<br/>';
	$editorialRubric = $rubricsTextArray[0]; // load the first rubric in the form
	require_once 'php/get-rubric-saved.php'; 	// process rubric selection forms
	//echo '$rubricUsed: '.$rubricUsed.'<br/>'; echo '$ctrRubric: '.$ctrRubric.'<br/>';
	require_once 'php/rubric-controls.php'; 	// this file contains all of the rubric evaluation tool content 
	?>
	
	<!-- SUBMISSION BUTTONS -->
	<div class = "top-10" id = "submission-btns-container">
		<?php
		if($editType == 'new') { $editBtnsClass = 'hide'; }
		if($editType == 'edit'){ $newBtnsClass = 'hide'; }
		?>
		<!-- BTNS FOR EDITING EXISTING RECORD -->
		<div id = "update-btns-edit" class = "<?php echo $editBtnsClass;?>">
			<div class = "inline right-5"><button type = "button" onclick = "editorialSubmit()">Update Record</button></div>
			<div class = "inline"><button type = "button" onclick = "editorialRevert('<?php echo $reviewID;?>')">Discard Changes</button></div>
		</div><!-- /#update-btns-edit .$editBtnsClass -->
		
		<!-- BTNS FOR ENTERING NEW RECORD -->
		<div id = "update-btns-new" class = "<?php echo $newBtnsClass;?>">
			<div class = "inline right-5"><button type = "button" onclick = "editorialSubmit()">Enter Product Record</button></div>
			<div class = "inline"><button type = "button" onclick = "editorialDiscard('<?php echo $lastSearchReviews;?>')">Discard</button></div>
		</div><!-- /#update-btns-new .$newBtnsClass -->
		
	</div><!-- /.top-10 #submission-btns-container -->

</div><!-- /.review-container -->