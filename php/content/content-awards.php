<?php
/*
php/content/content-awards.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the Awards page 'awards.php'
It is included dynamically in the file 'php/document.php'
Variable values for page content are defined in the file 'php/settings.php'
*/

// PAGE CONTAINER
echo '<div id = "awards-page-container" class = "award-page-container">';

// PAGE HEADER, SUBHEADER
if($awardsHeader != NULL) 		{ echo '<div class = "page-header">'.$awardsHeader.'</div>'; }
if($awardsSubheader != NULL) 	{ echo '<div class = "subheader">'.$awardsSubheader.'</div>'; }

// DETERMINE WHETHER CONTENT EXISTS
if($bolognaPreviewHeader != NULL 	or $bolognaPreviewText != NULL 	or $bolognaPreviewImg != NULL) 	{ $bolognaContent = true; } else { $bolognaContent = ''; }
if($kapisPreviewHeader != NULL 		or $kapisPreviewText != NULL 	or $kapisPreviewImg != NULL) 	{ $kapisContent = true; } 	else { $kapisContent = ''; }

// DETERMINE CSS CLASSES TO USE BASED ON WHETHER CONTENT EXISTS
if($bolognaContent == true and $kapisContent == true) 		{ $bolognaClass = 'inline width-45 awards-col'; 	$kapisClass = 'inline width-45 awards-col'; }
else if($bolognaContent == true and $kapisContent != true)	{ $bolognaClass = 'paragraph'; 						$kapisClass = 'hide'; }
else if($bolognaContent != true and $kapisContent == true)	{ $bolognaClass = 'hide'; 							$kapisClass = 'paragraph'; }

// BOLOGNA PREVIEW
if($bolognaContent == true)
{
	if($bolognaPreviewImg != NULL) 	{ $bolognaImgClass = 'inline width-30 awards-img'; 	$bolognaTextClass = 'inline width-60 left left-20 awards-text'; }
	else							{ $bolognaImgClass = 'hide'; 						$bolognaTextClass = 'paragraph left'; }
	echo '<div class = "'.$bolognaClass.'">';
		if($bolognaPreviewHeader != NULL) 	
		{
			echo '<div class = "subheader"><a href = "bolognaragazzi.php">'.$bolognaPreviewHeader.'</a></div>';
		}
		if($bolognaPreviewImg != NULL) 		
		{
			echo '<div class = "'.$bolognaImgClass.'"><a href = "bolognaragazzi.php"><img src="php/img.php?-url='.urlencode($bolognaPreviewImg).'"></a></div>';
		}
		if($bolognaPreviewText != NULL) 	
		{
			echo '<div class = "'.$bolognaTextClass.'">'.$bolognaPreviewText.' <a href = "bolognaragazzi.php">Read More</a></div>';
		}
	echo '</div>'; // /.$bolognaClass
} // end if $bolognaContent

// KAPIS PREVIEW
if($kapisContent == true)
{
	if($kapisPreviewImg != NULL) 	{ $kapisImgClass = 'inline width-30 awards-img'; 	$kapisTextClass = 'inline width-60 left left-20 awards-text'; }
	else							{ $kapisImgClass = 'hide'; 							$kapisTextClass = 'paragraph left'; }
	echo '<div class = "'.$kapisClass.'">';
		if($kapisPreviewHeader != NULL) 	
		{
			echo '<div class = "subheader"><a href = "kapis.php">'.$kapisPreviewHeader.'</a></div>';
		}
		if($kapisPreviewImg != NULL) 		
		{
			echo '<div class = "'.$kapisImgClass.'"><a href = "kapis.php"><img src = "php/img.php?-url='.urlencode($kapisPreviewImg).'"></a></div>';
		}
		if($kapisPreviewText != NULL) 		
		{
			echo '<div class = "'.$kapisTextClass.'">'.$kapisPreviewText.' <a href = "kapis.php">Read More</a></div>';
		}
	echo '</div>'; // /.$bolognaClass
} // end if $bolognaContent

echo '</div>'; // /#awards-page-container .award-page-container
?>