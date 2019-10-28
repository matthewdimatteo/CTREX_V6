<?php
/*
php/content/content-rubric-create.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the rubric creation page, included dynamically in 'php/content.php'
*/

// LOOKUP ALL AVAILABLE QUALITY ATTRIBUTES AND STORE IN AN ARRAY
$findQA = $fmqa->newFindCommand($fmqaLayout);
$findQA->addFindCriterion('active', "*");
$findQA->addSortRule('name', 1, FILEMAKER_SORT_ASCEND);
$result = $findQA->execute();
if(FileMaker::isError($result)) { echo 'Error:<br/>'.$result->getMessage(); exit(); }
$records = $result->getRecords();
$allQA = array(); // declare an array to store qa data
foreach($records as $record)
{
	$qaName 	= $record->getField('name');
	$qaField	= $record->getField('ratingField');
	array_push($allQA, array($qaName, $qaField)); // add this qa to the array of all qa
} // end foreach record

// PROCESS SAVED RUBRIC SELECTION FORM/LOAD FROM PROFILE
require_once 'php/get-rubric-saved.php'; // load saved rubric
/*
echo '$selectedQAData: '.$selectedQAData.'<br/>';
echo '$selectedQANames: '.$selectedQANames.'<br/>';
echo '$numdQA: '.$numQA.'<br/>'; // for some reason, this value is 1 after a reset even with above arrays null
echo '$numQA: '.$numQA.'<br/>';
*/

// CONFIRMATION OF SAVED RUBRIC
require_once 'php/save-item-confirmation.php';

// PAGE HEADER, SUBHEADER WITH DESCRIPTION
require_once 'php/rubrics-header.php';
?>

<!-- CHECKBOX CONTAINER HEADER, SUBHEADER -->
<div class = "rubric-create-header-col-left"><a href = "rubrics.php">&#60; CTR Rubrics</a></div>
<div class = "rubric-create-header-col-center">Create Your Rubric</div>
<div class = "rubric-create-header-col-right"></div>

<!-- QA CHECKBOX CONTAINER -->
<div class = "qa-checkbox-container">

<div class = "subheader">
	<div class = "show-769-and-above">Select the Quality Attributes to include in your rubric:</div>
	<div class = "show-only-480">Select Quality Attributes:</div>
</div>

<!-- FORM START -->
<form name = "rubric-creation-form" method = "POST" action = "rubric-process.php">
	<input type = "hidden" name = "checkboxes" value = "checkboxes" />

	<!-- HIDDEN INPUTS FOR EDITING AN EXISTING RUBRIC -->
	<input type = "hidden" name = "rubricID" 			value = "<?php echo $profileRubricID;?>" />
	<input type = "hidden" name = "rubricName" 			value = "<?php echo $profileRubricName;?>" />
	<input type = "hidden" name = "rubricDescription" 	value = "<?php echo $profileRubricDescription;?>" />

	<?php
	// DISPLAY THE QA IN COLUMNS DYNAMICALLY
	$qaCount = count($allQA);
	$qaCols = 4;
	$qaRows = ceil($qaCount / $qaCols);
	$rowStart = 0 - $qaRows;
	for($col = 0; $col < $qaCols; $col ++)
	{
		echo '<div class = "qa-checkbox-col">';
			$rowStart += $qaRows; $rowEnd = $rowStart + $qaRows;
			if($rowEnd > $qaCount) { $rowEnd = $qaCount; }
			for($i = $rowStart; $i < $rowEnd; $i++)
			{
				$optionName 	= $allQA[$i][0];
				$optionField 	= $allQA[$i][1];
				$optionNameStrLen = strlen($optionName);
				$optionNameMax = 50;
				$optionNameText = trimText($optionName, $optionNameMax);
				$qaCheckboxClass = 'qa-checkbox-row-a';
				if($optionNameStrLen > 20) { $qaCheckboxClass = 'qa-checkbox-row-b'; }
				if($optionNameStrLen > 30) { $qaCheckboxClass = 'qa-checkbox-row-c'; }
				if($optionNameStrLen > 40) { $qaCheckboxClass = 'qa-checkbox-row-d'; }
				if($optionNameStrLen > 50) { $qaCheckboxClass = 'qa-checkbox-row-e'; }
				if($optionNameStrLen > 60) { $qaCheckboxClass = 'qa-checkbox-row-f'; }
				echo '<div class = "'.$qaCheckboxClass.'">';
				echo '<input type = "checkbox" name = "checkbox-qa[]" id = "'.$optionName.'" value = "'.$optionField.'" ';	
					if(in_array($optionField, $selectedQAFields)) { echo 'checked'; }
				echo '/>'.$optionNameText.'</div>';
			} // end for rows
		echo '</div>'; // /.qa-checkbox-col
	} // end for cols
	
	// determine css class for generate and reset btns - only show reset btn if there is a rubric generated
	if($selectedQAData != NULL)
	{
		$generateBtnClass 	= 'inline right-10';
		$resetBtnClass		= 'inline right-10';
	}
	else
	{
		$generateBtnClass 	= 'full-width block';
		$resetBtnClass		= 'hide';
	}
	?>
	<!-- GENERATE/RESET BTNS -->
	<div class = "full-width center top-5 bottom-5">
		<div class = "<?php echo $generateBtnClass;?>"><input type = "submit" name = "submit-rubric" value = "Generate Rubric" /></div>
		<div class = "<?php echo $resetBtnClass;?>">
			<button type = "button" onclick = "document.getElementById('reset-rubric-form').submit();">Reset Rubric</button>
		</div><!-- /.$resetBtnClass-->
	</div><!-- /.full-width center top-5 bottom-5 -->
</form><!-- FORM END -->

</div><!-- /.qa-checkbox container -->

<!-- HIDDEN RESET FORM - the page 'rubric-process.php' clears $_SESSION values for generated rubric data if reset isset -->
<div class = "hide">
	<form name = "reset-rubric-form" id = "reset-rubric-form" method = "POST" action = "rubric-process.php" class = "hide">
		<input type = "hidden" name = "reset" id = "reset-rubric-btn" value = "reset" />
	</form>
</div><!-- /.hide -->

<!-- FOOTNOTE -->
<div class = "center">Is there a Quality Attribute you would like to use that is not available? <a href = "contact.php">Contact us</a> with suggestions.</div>

<?php

// if number of saved rubrics > 0, display a dropdown with each
if($numSavedRubrics > 0)
{
	echo '<div class = "subheader top-20">';
		echo 'Select a saved rubric to edit:'; 
	echo '</div>';
	$showSavedRubrics = true; // set this boolean to true to tell 'php/rubric-select.php' show saved rubrics
	require 'php/rubric-select.php';
}

// OUTPUT EVALUATION FORM WITH EACH QA CONTROL
if($selectedQAData != NULL)
{
	require_once 'php/rubric-output.php'; // outputs the evaluation form
	echo '<div class = "top-20">';
	// FOR SUBSCRIBERS, SHOW SAVE RUBRIC FORM
	if($subscriber == true)
	{
		// create a string of all QA names to be set as a hidden input value on the form that saves the rubric to the user's profile
		$qaNameString = '';
		$qaNameN = 0;
		foreach($selectedQANames as $thisQAName)
		{
			$qaNameString .= $thisQAName;
			$qaNameN += 1;
			if($qaNameN < $numQA) { $qaNameString .= ', '; }
		} // end foreach qa name
		
		$qaFieldString = '';
		$qaFieldN = 0;
		foreach($selectedQAFields as $thisQAField)
		{
			$qaFieldString .= $thisQAField;
			$qaFieldN += 1;
			if($qaFieldN < $numQA) { $qaFieldString .= ', '; }
		} // end foreach qa name
		
		// IF USING A SAVED RUBRIC
		//if($savedRubricID != NULL) { $qaNameString = $savedRubricQA; }
		
		// display the save rubric form
		echo '<div class = "subheader">Save this rubric to your profile:</div>';
		//echo $qaNameString.'<br/>';
		//echo $qaFieldString.'<br/>';
		echo '<form name = "save-rubric-form" id = "save-rubric-form" method = "POST" action = "saverubric.php">';
			echo '<input type = "hidden"	name = "save-rubric-id" 		value = "'.$savedRubricID.'"/>';
			echo '<input type = "hidden" 	name = "save-rubric-qa-names" 	value = "'.$qaNameString.'"/>';
			echo '<input type = "hidden" 	name = "save-rubric-qa-fields" 	value = "'.$qaFieldString.'"/>';
			echo '<input type = "hidden" 	name = "save-rubric-type" id = "save-rubric-type">'; 	// tell save-rubric.php to add new record or update existing
			echo '<input type = "hidden" 	name = "save-rubric-redirect" 	value = "'.$thisURL.'"/>';// tell save-rubric.php to return to this page
			echo '<div class = "row">';
				echo '<div class = "field-label">Rubric Name:</div>';
				echo '<div class = "field-container"><input type = "text" name = "save-rubric-name" value = "'.$savedRubricName.'" required/></div>';
				echo '<div class = "field-note"></div>';
			echo '</div>'; // /.row
			echo '<div class = "row">';
				echo '<div class = "field-label">Description:</div>';
				echo '<div class = "field-container">';
					echo '<textarea name = "save-rubric-description" rows = "4" placeholder = "Add a description (optional)">'.$savedRubricDescription.'</textarea>';
				echo '</div>';
				echo '<div class = "field-note"></div>';
			echo '</div>'; // /.row
			
			echo '<div class = "top-10">';
				echo '<div class = "row">';
					echo '<div class = "field-label"></div>';
					echo '<div class = "field-container">';
						echo '<button type = "button" onclick = "saveRubric(\'add\')">Save as New Rubric</button>';
					echo'</div>';
					echo '<div class = "field-note"></div>';
				echo '</div>'; // /.row
			echo '</div>'; // /.top-10
			
			// IF USING A SAVED RUBRIC, SHOW 2nd OPTION TO UPDATE EXISTING RUBRIC
			if($savedRubricID != NULL)
			{
			echo '<div class = "top-10">';
				echo '<div class = "row">';
					echo '<div class = "field-label"></div>';
					echo '<div class = "field-container">';
						echo '<button type = "button" onclick = "saveRubric(\'update\')">Update Existing Rubric</button>';
					echo '</div>';
					echo '<div class = "field-note"></div>';
				echo '</div>'; // /.row
			echo '</div>'; // /.top-10
			} // end if saved rubric
			
		echo '</form>';
		
	} // end if $subscriber
	
	// FOR GUESTS, SHOW BUTTON PROMPT TO LOG IN TO SAVE RUBRICS
	else
	{
		// display a button prompting guests to log in to save rubrics
		$loginRedirect = 'login.php?target=save-rubric&redirect='.urlencode($thisURL);
		echo '<button type = "button" onclick = "openURL(\''.$loginRedirect.'\')">Log in as a subscriber to save this rubric to your profile</button>';
	}
	echo '</div>'; // .top-20
} // end if $numQA > 0
?>