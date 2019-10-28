<?php
/*
php/get-text.php
By Matthew DiMatteo, Children's Technology Review

This file gets the field values for a record in the 'text' table in the 'CSR.fmp12' database file
These values are used to provide data-driven web content

This file is included in the file 'php/settings.php'
*/

$fields = $dynamicTextFields; 	// tell 'php/get-field.php' which array of fields to use (declared in 'php/fields.php')
require 'php/get-field.php'; 	// get database fields and assign to dynamic variables

// format section classes
$defaultSectionW 		= '90';
$defaultSectionAlign 	= 'left';

if($textSection1 != NULL)
{
	if($textSection1W == NULL) 		{ $textSection1W 		= $defaultSectionW; }
	if($textSection1Align == NULL) 	{ $textSection1Align 	= $defaultSectionAlign; }
	$textSection1Class	= 'paragraph-'.$textSection1W.' '.$textSection1Align;
} // end if $textSection1

if($textSection2 != NULL)
{
	if($textSection2W == NULL) 		{ $textSection2W 		= $defaultSectionW; }
	if($textSection2Align == NULL) 	{ $textSection2Align 	= $defaultSectionAlign; }
	$textSection2Class	= 'paragraph-'.$textSection2W.' '.$textSection2Align;
} // end if $textSection2

if($textSection3 != NULL)
{
	if($textSection3W == NULL) 		{ $textSection3W 		= $defaultSectionW; }
	if($textSection3Align == NULL) 	{ $textSection3Align 	= $defaultSectionAlign; }
	$textSection3Class	= 'paragraph-'.$textSection3W.' '.$textSection3Align;
} // end if $textSection3

if($textSection4 != NULL)
{
	if($textSection4W == NULL) 		{ $textSection4W 		= $defaultSectionW; }
	if($textSection4Align == NULL) 	{ $textSection4Align 	= $defaultSectionAlign; }
	$textSection4Class	= 'paragraph-'.$textSection4W.' '.$textSection4Align;
} // end if $textSection4

// format image classes
$defaultImgW 	= '20';
$defaultImgPos 	= 'before';

if($textImage1 != NULL)
{
	if($textImage1W == NULL) 		{ $textImage1W 		= $defaultImgW; }
	if($textImage1Pos == NULL) 		{ $textImage1Pos 	= $defaultImgPos; }
	$textImage1Class	= 'inline '.$textImage1W.' center left-10 right-10';
} // end if $textImage1

if($textImage2 != NULL)
{
	if($textImage2W == NULL) 		{ $textImage2W 		= $defaultImgW; }
	if($textImage2Pos == NULL) 		{ $textImage2Pos 	= $defaultImgPos; }
	$textImage2Class	= 'inline '.$textImage2W.' center left-10 right-10';
} // end if $textImage2

if($textImage3 != NULL)
{
	if($textImage3W == NULL) 		{ $textImage3W 		= $defaultImgW; }
	if($textImage3Pos == NULL) 		{ $textImage3Pos 	= $defaultImgPos; }
	$textImage3Class	= 'inline '.$textImage3W.' center left-10 right-10';
} // end if $textImage3

if($textImage4 != NULL)
{
	if($textImage4W == NULL) 		{ $textImage4W 		= $defaultImgW; }
	if($textImage4Pos == NULL) 		{ $textImage4Pos 	= $defaultImgPos; }
	$textImage4Class	= 'inline '.$textImage4W.' center left-10 right-10';
} // end if $textImage1
?>