<?php
/*
php/dynamic-content.php
By Matthew DiMatteo, Children's Technology Review

This file outputs page content using a database-driven approach:
- The 'CSR.fmp12' file's 'text' table contains fields to store content and configure its formatting
- Each record represents a page

To output content for a page using this method:
- Make sure that the filename of the .php file for the page matches the value of the 'text::pageName' field
- In the .php file for the page, before 'php/autoload.php' is included, declare $dynamicText = true;
- In the content file for the page, include this file ('php/dynamic-content.php')

The file 'php/settings.php' is configured to query the 'CSR.fmp12' file's 'text' table to get the record's field values
- The variables referenced in this file are determined in that file

*/

// SET PAGE TITLE
if($textPageTitle != NULL) 		{ echo '<script>setPageTitle(\''.$textPageTitle.'\');</script>'; } // set page title based on field value

// OUTPUT PAGE HEADER, SUBHEADER
if($textPageHeader != NULL) 	{ echo '<div class = "page-header">'.$textPageHeader.'</div>'; }
if($textPageSubheader != NULL) 	{ echo '<div class = "subheader">'.$textPageSubheader.'</div>'; }

// OUTPUT SECTIONS, IMAGES

// SECTION 1
if($textSection1 != NULL or $textImage1 != NULL)
{ 
	if($textImage1 != NULL and $textImage1Pos == 'before')
	{ echo '<div class = "'.$textImage1Class.'"><img src = "php/img.php?-url='.urlencode($textImage1).'"/></div>'; }
	if($textSection1 != NULL) 	{ echo '<div class = "'.$textSection1Class.'">'.parseLinks($textSection1).'</div>'; }
	if($textImage1 != NULL and $textImage1Pos == 'after')
	{ echo '<div class = "'.$textImage1Class.'"><img src = "php/img.php?-url='.urlencode($textImage1).'"/></div>'; }
	echo '<br/><br/>';
} // end if($textSection1 != NULL or $textImage1 != NULL)

// SECTION 2
if($textSection2 != NULL or $textImage2 != NULL)
{ 
	if($textImage2 != NULL and $textImage2Pos == 'before')
	{ echo '<div class = "'.$textImage2Class.'"><img src = "php/img.php?-url='.urlencode($textImage2).'"/></div>'; }
	if($textSection2 != NULL)	{ echo '<div class = "'.$textSection2Class.'">'.parseLinks($textSection2).'</div>'; }
	if($textImage2 != NULL and $textImage2Pos == 'after')
	{ echo '<div class = "'.$textImage2Class.'"><img src = "php/img.php?-url='.urlencode($textImage2).'"/></div>'; }
	echo '<br/><br/>';
} // end if($textSection2 != NULL or $textImage2 != NULL)

// SECTION 3
if($textSection3 != NULL or $textImage3 != NULL)
{ 
	if($textImage3 != NULL and $textImage3Pos == 'before')
	{ echo '<div class = "'.$textImage3Class.'"><img src = "php/img.php?-url='.urlencode($textImage3).'"/></div>'; }
	if($textSection3 != NULL)	{ echo '<div class = "'.$textSection3Class.'">'.parseLinks($textSection3).'</div>'; }
	if($textImage3 != NULL and $textImage3Pos == 'after')
	{ echo '<div class = "'.$textImage3Class.'"><img src = "php/img.php?-url='.urlencode($textImage3).'"/></div>'; }
	echo '<br/><br/>';
} // end if($textSection3 != NULL or $textImage3 != NULL)

// SECTION 4
if($textSection4 != NULL or $textImage4 != NULL)
{ 
	if($textImage4 != NULL and $textImage4Pos == 'before')
	{ echo '<div class = "'.$textImage4Class.'"><img src = "php/img.php?-url='.urlencode($textImage4).'"/></div>'; }
	if($textSection4 != NULL)	{ echo '<div class = "'.$textSection4Class.'">'.parseLinks($textSection4).'</div>'; }
	if($textImage4 != NULL and $textImage4Pos == 'after')
	{ echo '<div class = "'.$textImage4Class.'"><img src = "php/img.php?-url='.urlencode($textImage4).'"/></div>'; }
	echo '<br/><br/>';
} // end if($textSection4 != NULL or $textImage4 != NULL)
?>