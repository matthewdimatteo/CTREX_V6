<?php 
/*
php/content/content-staff.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the Staff page
It is included dynamically in the file 'php/document.php'
Variable values are defined in 'php/settings.php'
*/

// HEADER, INTRO
if($staffHeader != NULL) 	{ echo '<div class = "page-header">'.$staffHeader.'</div>'; }
if($staffIntro != NULL)		{ echo '<div class = "paragraph left bottom-10" id = "intro">'.parseLinksOld($staffIntro).'</div>'; }

// EDITOR
if($staffEditorActive != NULL)
{
	// FORMAT CONTENT BASED ON WHETHER IMG EXISTS
	if($staffEditorImg != NULL and $staffEditorImgData != '?')
	{
		$staffEditorImgExists 	= true;
		$staffEditorTextClass 	= 'inline width-75 award-title-text';
		$staffEditorImgClass 	= 'inline width-15 left-10 award-title-img';
	} // end if editor img
	else							
	{
		$staffEditorImageExists = '';
		$staffEditorTextClass 	= 'full-width';
		$staffEditorImgClass 	= 'hide';
	} // end else no editor img
	
	// OUTPUT CONTENT - EDITOR
	if($staffEditorName != NULL or $staffEditorBio != NULL or $staffEditorImageExists == true)
	{
		echo '<div class = "paragraph left bottom-10" id = "editor">';
			echo '<div class = "'.$staffEditorTextClass.'">';
				if($staffEditorName != NULL) 	{ echo '<strong>'.$staffEditorName.'</strong> '; }
				if($staffEditorBio != NULL)		{ echo lcfirst(parseLinksOld($staffEditorBio)); }
			echo '</div>'; // /.$staffEditorTextClass
			if($staffEditorImgExists == true)
			{
				echo '<div class = "'.$staffEditorImgClass.'">';
					if($staffEditorImgURL != NULL) { echo '<a href = "'.$staffEditorImgURL.'" target = "_blank">'; }
						echo '<img src = "php/img.php?-url='.urlencode($staffEditorImg).'">';
					if($staffEditorImgURL != NULL) { echo '</a>'; }
				echo '</div>'; // /.$staffEditorImgClass
			} // end if $staffEditorImgExists
		echo '</div>'; // /.paragraph left bottom-10 /#editor
	} // end if content - editor
	
} // end if $staffEditorActive

// DIRECTOR OF PUBLISHING
if($staffCodeActive != NULL)
{
	// FORMAT CONTENT BASED ON WHETHER IMG EXISTS
	if($staffCodeImg != NULL and $staffCodeImgData != '?')
	{
		$staffCodeImgExists 	= true;
		$staffCodeTextClass 	= 'inline width-75 award-title-text';
		$staffCodeImgClass 		= 'inline width-15 left-10 award-title-img';
	} // end if code img
	else							
	{
		$staffCodeImageExists 	= '';
		$staffCodeTextClass 	= 'full-width';
		$staffCodeImgClass 		= 'hide';
	} // end else no code img
	
	// OUTPUT CONTENT - DIRECTOR OF PUBLISHING
	if($staffCodeName != NULL or $staffCodeBio != NULL or $staffCodeImageExists == true)
	{
		echo '<div class = "paragraph left bottom-10" id = "director-of-publishing">';
			echo '<div class = "'.$staffCodeTextClass.'">';
				if($staffCodeName != NULL) 	{ echo '<strong>'.$staffCodeName.'</strong> '; }
				if($staffCodeBio != NULL)		{ echo lcfirst(parseLinksOld($staffCodeBio)); }
			echo '</div>'; // /.$staffCodeTextClass
			if($staffCodeImgExists == true)
			{
				echo '<div class = "'.$staffCodeImgClass.'">';
					if($staffCodeImgURL != NULL) { echo '<a href = "'.$staffCodeImgURL.'" target = "_blank">'; }
						echo '<img src = "php/img.php?-url='.urlencode($staffCodeImg).'">';
					if($staffCodeImgURL != NULL) { echo '</a>'; }
				echo '</div>'; // /.$staffCodeImgClass
			} // end if $staffCodeImgExists
		echo '</div>'; // /.paragraph left bottom-10 /#director-of-publishing
	} // end if content - director of publishing
	
} // end if $staffCodeActive

// CIRCULATION MANAGER
if($staffCircActive != NULL)
{
	// FORMAT CONTENT BASED ON WHETHER IMG EXISTS
	if($staffCircImg != NULL and $staffCircImgData != '?')
	{
		$staffCircImgExists 	= true;
		$staffCircTextClass 	= 'inline width-75 award-title-text';
		$staffCircImgClass 		= 'inline width-15 left-10 award-title-img';
	} // end if circ img
	else							
	{
		$staffCircImageExists 	= '';
		$staffCircTextClass 	= 'full-width';
		$staffCircImgClass 		= 'hide';
	} // end else no circ img
	
	// OUTPUT CONTENT - CIRCULATION MANAGER
	if($staffCircName != NULL or $staffCircBio != NULL or $staffCircImageExists == true)
	{
		echo '<div class = "paragraph left bottom-10" id = "circulation-manager">';
			echo '<div class = "'.$staffCircTextClass.'">';
				if($staffCircName != NULL) 	{ echo '<strong>'.$staffCircName.'</strong> '; }
				if($staffCircBio != NULL)		{ echo lcfirst(parseLinksOld($staffCircBio)); }
			echo '</div>'; // /.$staffCircTextClass
			if($staffCircImgExists == true)
			{
				echo '<div class = "'.$staffCircImgClass.'">';
					if($staffCircImgURL != NULL) { echo '<a href = "'.$staffCircImgURL.'" target = "_blank">'; }
						echo '<img src = "php/img.php?-url='.urlenCirc($staffCircImg).'">';
					if($staffCircImgURL != NULL) { echo '</a>'; }
				echo '</div>'; // /.$staffCircImgClass
			} // end if $staffCircImgExists
		echo '</div>'; // /.paragraph left bottom-10 /#circulation manager
	} // end if content - circulation manager
	
} // end if $staffCircActive

// TREASURER
if($staffTreasurerActive != NULL)
{
	// FORMAT CONTENT BASED ON WHETHER IMG EXISTS
	if($staffTreasurerImg != NULL and $staffTreasurerImgData != '?')
	{
		$staffTreasurerImgExists 	= true;
		$staffTreasurerTextClass 	= 'inline width-75 award-title-text';
		$staffTreasurerImgClass 	= 'inline width-15 left-10 award-title-img';
	} // end if treasurer img
	else							
	{
		$staffTreasurerImageExists 	= '';
		$staffTreasurerTextClass 	= 'full-width';
		$staffTreasurerImgClass 	= 'hide';
	} // end else no treasurer img
	
	// OUTPUT CONTENT - TREASURER
	if($staffTreasurerName != NULL or $staffTreasurerBio != NULL or $staffTreasurerImageExists == true)
	{
		echo '<div class = "paragraph left bottom-10" id = "treasurer">';
			echo '<div class = "'.$staffTreasurerTextClass.'">';
				if($staffTreasurerName != NULL) 	{ echo '<strong>'.$staffTreasurerName.'</strong> '; }
				if($staffTreasurerBio != NULL)		{ echo lcfirst(parseLinksOld($staffTreasurerBio)); }
			echo '</div>'; // /.$staffTreasurerTextClass
			if($staffTreasurerImgExists == true)
			{
				echo '<div class = "'.$staffTreasurerImgClass.'">';
					if($staffTreasurerImgURL != NULL) { echo '<a href = "'.$staffTreasurerImgURL.'" target = "_blank">'; }
						echo '<img src = "php/img.php?-url='.urlenTreasurer($staffTreasurerImg).'">';
					if($staffTreasurerImgURL != NULL) { echo '</a>'; }
				echo '</div>'; // /.$staffTreasurerImgClass
			} // end if $staffTreasurerImgExists
		echo '</div>'; // /.paragraph left bottom-10 /#Treasurer
	} // end if content - Treasurer
	
} // end if $staffTreasurerActive
?>