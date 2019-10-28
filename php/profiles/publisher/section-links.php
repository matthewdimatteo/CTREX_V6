<?php
/*
php/profiles/publisher/section-links.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the content of the 'Description' tab of the Publisher Profile page
It is included dynamically in 'php/profiles/profile-sections.php'
*/

$sectionItems = array(); 	// declare array of section items for private (editable) profile
$possibleItems = array(); 	// declare array of possible section items to display on public profile if there is a value

// EMBED LINKS IN FIELD LABELS IF SPECIFIED
$linkItems = array('Website', 'Logo', 'Facebook', 'Twitter', 'LinkedIn', 'Instagram', 'Pinterest', 'YouTube', 'Video');
foreach($linkItems as $linkItem)
{
	$linkLabel			= $linkItem;				// the default field label value, as defined in the $linkItems array above
	$linkVarName		= 'link'.$linkItem; 		// the variable name for the link defined in 'php/fields.php'
	$linkParsedVarName 	= $linkVarName.'Parsed'; 	// the variable name for the parsed link
	$linkLabelVarName	= $linkVarName.'Label'; 	// the variable name for the field label
	$link 				= $$linkVarName;			// assign the $link value the value of what $linkVarName was calculated to be
	$linkParsed 		= $$linkParsedVarName;		// do the same for the parsed link variable value
	if($link != NULL) 	{ $$linkLabelVarName = '<a href = "http://'.$linkParsed.'" target = "_blank">'.$linkLabel.'</a>'; } // embed the link in the label
	else 				{ $$linkLabelVarName = $linkLabel; } // if no link, make the label the default value
	$linkArray = array($$linkLabelVarName, $linkVarName, 'true', 'text', ''); // format link item array for output by 'php/section-items.php'
	array_push($sectionItems	, $linkArray); // add to array of editable section items
	array_push($possibleItems	, $linkArray); // add to array of possible section items
}

// SECTION CONTAINER
echo '<div id = "links-info" class = "profile-section-content">';
	
// EDIT MODE
if($inputMode == 'private')
{
	// SECTION HEADER
	echo '<div class = "profile-section-header">Social Media Links (Public)</div>'; // /.profile-section-header

	// FORM START
	echo '<form name = "profile-update-form-publisher-links" method = "POST" action = "profile-update.php">';

		// INPUT FIELDS
		require 'php/profiles/section-items.php'; // outputs the items in the $sectionItems array
		
		// FEATURED VIDEO
		if($linkVideo != NULL)
		{
			$videoLinks = videoLink($linkVideo);
			$videoURL = $videoLinks[0];
			echo '<div class = "profile-iframe"><iframe src = "'.$videoURL.'" ></iframe></div>';
		}

		// HIDDEN INPUTS
		echo '<input type = "hidden" name = "type" 	value = "publisher" />';
		echo '<input type = "hidden" name = "section" value = "links" />';

		// SUBMIT BTN
		echo '<div class = "profile-section-submit-btn">';
			echo '<input type = "submit" name = "update-links-info" value = "Update this information" />';
		echo '</div>'; // /.profile-section-submit-btn

	echo '</form>'; // FORM END
} // end if($inputMode == 'private')
	
// PUBLIC PROFILE
else
{
	$sectionItems = array(); // re-declare $sectionItems array and only include items from $possibleItems array that have values
	foreach($possibleItems as $item)
	{
		$varName = $item[1];
		$value = $$varName;
		if($value != NULL) { array_push($sectionItems, $item); }
	}
	require 'php/profiles/section-items.php'; // outputs the items in the $sectionItems array
	
	// FEATURED VIDEO
	if($linkVideo != NULL)
	{
		$videoLinks = videoLink($linkVideo);
		$videoURL = $videoLinks[0];
		echo '<div class = "profile-iframe"><iframe src = "'.$videoURL.'" ></iframe></div>';
	}
} // end else public

echo '</div>'; // /#links-info .profile-section-content
?>