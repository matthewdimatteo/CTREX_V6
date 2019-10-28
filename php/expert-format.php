<?php
/*
php/expert-format.php
By Matthew DiMatteo, Children's Technology Review

This file formats the record data for each expert record on the experts page
It is included within the for loops that output the data in both grid and list views
*/
$item = $expert; // tell 'php/get-vars.php' which $item to use
require 'php/get-vars.php'; // assign dynamic variables

// format information
$expertProfileURL 	= 'profile.php?id='.$expertID.'&type=subscriber&mode=public';
$expertFullName		= $expertFname.' '.$expertLname;

// title line
$expertTitleLine	= $expertTitle;
if($expertTitle != NULL and $expertCompany != NULL) { $expertTitleLine .= ', '; }
$expertTitleLine .= $expertCompany;

// bio preview
$numBioPreviewChars = 300;
$bioPreview 		= substr($expertBio, 0, $numBioPreviewChars);
if(strlen($expertBio) > $numBioPreviewChars) { $bioPreview .= '...'; }
?>