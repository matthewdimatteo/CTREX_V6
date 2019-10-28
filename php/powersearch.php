<?php
/*
powersearch.php
By Matthew DiMatteo, Children's Technology Review

This snippet contains the html for outputting the 'power search' menu, a set of dropdowns with different search categories
The four categories are Ages/Grades, Platforms, Subjects, and Topics
The contents for each dropdown are defined in arrays in the snippet 'sidebar-options.php'
The content for Topics is fetched from the 'categorygroups' table in the CSR file
All other arrays are constructed manually, though a dynamic, data-driven approach would be similarly feasible
*/

// the following definitions are used in both the dynamic and static versions
$ageOptions = $ageRangeOptions;

// define default values for element classes, option values and labels
$ageDivClass 			= 'dropdown-div';
$ageSelectClass 		= 'dropdown-select';
$ageSelectedLabel 		= 'Ages';

$platformDivClass 		= 'dropdown-div';
$platformSelectClass 	= 'dropdown-select';
$platformSelectedLabel 	= 'Platforms';

$subjectDivClass 		= 'dropdown-div';
$subjectSelectClass 	= 'dropdown-select';
$subjectSelectedLabel 	= 'Subjects';

$topicDivClass 			= 'dropdown-div';
$topicSelectClass 		= 'dropdown-select';
$topicSelectedLabel 	= 'Topics';

// if a search term is specified for any of the powersearch items, set class and option values to display as active
if($searchReviewsAge != NULL)
{
	$ageDivClass 			.= '-active';
	$ageSelectClass			.= '-active';
	$ageSelectedValue 		= $searchReviewsAge;
	$ageSelectedLabel 		= $searchReviewsAgeLabel;
	$ageOptionClear			= '<option value = "">Clear</option>';
}
if($searchReviewsPlatform != NULL)
{
	$platformDivClass 		.= '-active';
	$platformSelectClass	.= '-active';
	$platformSelectedValue 	= $searchReviewsPlatform;
	$platformSelectedLabel 	= $searchReviewsPlatform;
	$platformOptionClear	= '<option value = "">Clear</option>';
}
if($searchReviewsSubject != NULL)
{
	$subjectDivClass 		.= '-active';
	$subjectSelectClass		.= '-active';
	$subjectSelectedValue 	= $searchReviewsSubject;
	$subjectSelectedLabel 	= $searchReviewsSubject;
	$subjectOptionClear		= '<option value = "">Clear</option>';
}
if($searchReviewsTopic != NULL)
{
	$topicDivClass 			.= '-active';
	$topicSelectClass		.= '-active';
	$topicSelectedValue 	= $searchReviewsTopic;
	$topicSelectedLabel 	= $searchReviewsTopicLabel;
	$topicOptionClear		= '<option value = "">Clear</option>';
}
?>

<!-- AND/OR TOGGLE -->
<div id = "and-or-container" class = "powersearch-margin" title = "Select AND to combine criteria. Select OR to search by criteria separately.">
    <div class = "and-or-row">
    	<div class = "and-or-btn"><input type = "radio" name = "and-or" id = "powersearch-and" onchange = "powersearchAnd()" /></div>
        <div class = "and-or-label">And</div>
    </div>
    <div class = "and-or-row">
    	<div class = "and-or-btn"><input type = "radio" name = "and-or" id = "powersearch-or" checked onchange = "powersearchOr()" /></div>
        <div class = "and-or-label">Or</div>
    </div>
</div><!-- /#and-or-container -->

<?php
/*
Below is a dynamic approach to outputting the html for the powersearch
Each item consists of a <select> element within a <div> element for the dropdown bg and a <div> for the containing column
Element ids, css class names, and js functions follow a pattern where the only differing component of the string is the particular item
The array of options to use is calculated using a dynamic variable name ($$) to reference the corresponding array defined in 'sidebar-options.php'
An added complexity is that certain powersearch items utilize optgroups, either for the entirety of the options, or in addition to a set of options
In order to include this complexity within the output loop, each item in the array $powersearchItems is given parameters for $isOptgroup and $hasOptgroup
As of the initial construction of this method, 'subjects' utilizes an optgroup in addition to a set of standard options, so $hasOptgroup is true in its case
'topics' is constructed entirely of optgroups, and so $isOptgroup is true in its case
Additionally, 'Ages/Grades' contains a second set of standard options for grade level, defined in the $gradeLevelOptionsArray, hence the fourth parameter

NOTE: The php code here is contained separately in a snippet 'powersearch-dynamic.php'
A static version (hard-coded) is kept in the snippet 'powersearch-static.php'
*/

/* 
This defines the powersearch items to display, including the optgroup parameters
Each item follows the pattern of: array(item , isOptGroup , hasOptgroup, second-item)
The second item passes the array of options directly instead of calculating the array's variable name
*/
//	array(item	, isOptGroup, hasOptgroup, second-item)
$powersearchItems = array
(
	array('age'		, false	, false , $gradeLevelOptions),
	array('platform', false	, false),
	array('subject'	, false	, true),
	array('topic'	, true	, false)
);

/*
Within the foreach loop, string calculations for element classes, js functions, labels, and the variable name of the corresponding array are defined
For example, the variable name for the 'platforms' item options is $platformOptions
This value is accessed by defining the $optionsArrayVar to be the item string 'platform' and the static suffix 'Options'
The dynamic variable $optionsArray then is set to $$optionsArrayVar to access the value of whatever $optionsArrayVar is set to, in this case, $platformOptions
*/
foreach($powersearchItems as $powersearchItem)
{
	// get the parameters for each item
	$item 				= $powersearchItem[0];
	$isOptgroup 		= $powersearchItem[1];
	$hasOptgroup 		= $powersearchItem[2];
	$secondItem			= $powersearchItem[3];
	
	/* 
	the element classes toggle between inactive and active
	the variable names for each item are defined conditionally above, based on whether there is a selection
	*/
	$divClassVar 		= $item.'DivClass';			$divClass 		= $$divClassVar;
	$selectClassVar 	= $item.'SelectClass';		$selectClass 	= $$selectClassVar;
	$selectedValueVar	= $item.'SelectedValue';	$selectedValue 	= $$selectedValueVar;
	$selectedLabelVar	= $item.'SelectedLabel';	$selectedLabel 	= $$selectedLabelVar;
	$optionClearVar		= $item.'OptionClear';		$optionClear 	= $$optionClearVar;
	$onchangeFunction	= 'powersearch(\''.$item.'\')';
	
	// these are the arrays containing the set of options, including values and labels, as defined in 'sidebar-options.php'
	$optionsArrayVar	= $item.'Options';			$optionsArray	= $$optionsArrayVar;
	$optgroupsArrayVar	= $item.'Optgroups';		$optgroupsArray	= $$optgroupsArrayVar;
	
	echo '<div id = "powersearch-col-'.$item.'" class = "powersearch-col">';
		echo '<div id = "powersearch-div-'.$item.'" class = "'.$divClass.'">';
		
			/* 
			the select element contains the actual form input
			its id must be unique so as to map its value to the corresponding hidden search form input via js
			*/
			echo '<select id = "powersearch-'.$item.'" name = "'.$item.'" onchange = "'.$onchangeFunction.'" class = "'.$selectClass.'">';
				
				// each item includes a default option which reads the selected option or a placeholder if no selection
				echo '<option value = "'.$selectedValue.'">'.$selectedLabel.'</option>';
				
				// each item includes an <option value = "">Clear</option> which is set to an empty string when there is no current selection
				echo $optionClear;
				
				// if the entire item is constructed with optgroups, each optgroup and its contained options is outputted using nested foreach loops
				if($isOptgroup == true)
				{	
					foreach($optionsArray as $optgroup)
					{
						$label	= $optgroup[0];
						echo '<optgroup label = "'.$label.'">';
							$options = $optgroup[1];
							foreach($options as $option)
							{
								$optionValue = $option[0];
								$optionLabel = $option[1];
								echo '<option value = "'.$optionValue.'">'.$optionLabel.'</option>';
							}
						echo '</optgroup>';
					} // end foreach $optgroup
				} // end if $isOptgroup
				
				// this is the default case, where the item contains only a set of <option> elements
				else
				{
					foreach($optionsArray as $option)
					{
						$optionValue 		= $option[1];
						$optionPlusCount 	= substr_count($optionValue, '+');
						$optionValue 		= str_replace('+', ' ', $optionValue, $optionPlusCount);
						$optionLabel		= $option[3];
						echo '<option value = "'.$optionValue.'">'.$optionLabel.'</option>';
					}
				} // end if else ! $isOptgroup
				
				// if the item has a set of optgroups in addition to its standard options, those optgroups and their options are outputted afterwards
				if($hasOptgroup == true)
				{
					foreach($optgroupsArray as $optgroup)
					{
						$optgroupLabel = $optgroup[0];
						$optgroupItems = $optgroup[1];
						echo '<optgroup label = "'.$optgroupLabel.'">';
							foreach($optgroupItems as $item)
							{
								echo '<option value = "'.$item.'">'.$item.'</option>';
							}
						echo '</optgroup>';
					} // end foreach $optgroup
				} // end if $hasOptgroup
				
				// if the item has a second item, it is outputted afterwards
				if($secondItem != NULL)
				{
					foreach($secondItem as $option)
					{
						$optionValue 		= $option[1];
						$optionPlusCount 	= substr_count($optionValue, '+');
						$optionValue 		= str_replace('+', ' ', $optionValue, $optionPlusCount);
						$optionLabel		= $option[3];
						echo '<option value = "'.$optionValue.'">'.$optionLabel.'</option>';
					} // end foreach $secondItem
				} // end if $secondItem
				
			echo '</select>'; // /.powersearch-select
		echo '</div>'; // /.powersearch-div
	echo '</div>'; // /.powersearch-col
} // end foreach $powersearchItem
?>

<!-- RIGHT MARGIN (to balance and/or controls in left margin) -->
<div class = "powersearch-margin" id = "and-or-offset">
</div><!-- /.powersearch-margin -->