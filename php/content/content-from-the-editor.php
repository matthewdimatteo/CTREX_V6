<?php 
/*
php/content/content-from-the-editor.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the From the Editor page
It is included dynamically in the file 'php/document.php'
Variable values are defined in 'php/settings.php'
*/

// HEADER, SUBHEADER
if($feHeader != NULL) 		{ echo '<div class = "page-header">'.$feHeader.'</div>'; }
if($feSubheader != NULL) 	{ echo '<div class = "subheader">'.$feSubheader.'</div>'; }

// FORMAT CONTENT BASED ON WHETHER IMG EXISTS
if($feEditorImg != NULL and $feEditorImgData != '?') 	
{
	$introImgExists 	= true;
	$introTextClass 	= 'inline width-75 award-title-text';
	$introImgClass 		= 'inline width-15 left-10 award-title-img';
} // end if intro img
else							
{
	$introImageExists 	= '';
	$introTextClass 	= 'full-width';
	$introImgClass 		= 'hide';
} // end else no intro img

// INTRO, OVERVIEW, EDITOR IMG
if($feIntro != NULL or $introImgExists == true)
{
	echo '<div class = "paragraph left bottom-10" id = "intro">';
		echo '<div class = "'.$introTextClass.'">';
		
			// INTRO
			if($feIntro != NULL) { echo '<p>'.parseLinksOld($feIntro).'</p>'; }
			
			// OVERVIEW BULLETED LIST
			if(count($feOverview) > 0)
			{
				echo '<ul>';
				foreach($feOverview as $feOverviewItem)
				{
					if($feOverviewItem != NULL) { echo '<li>'.parseLinksOld($feOverviewItem).'</li>'; }
				} // end foreach $feOverviewItem
				echo '</ul>';
			} // end if $feOverview
			
		echo '</div>'; // /.$introTextClass
		
		// EDITOR IMG
		if($introImgExists == true)
		{
			echo '<div class = "'.$introImgClass.'">';
				if($feEditorImgURL != NULL) { echo '<a href = "'.$feEditorImgURL.'" target = "_blank">'; }
					echo '<img src = "php/img.php?-url='.urlencode($feEditorImg).'">';
				if($feEditorImgURL != NULL) { echo '</a>'; }
				if($feEditorImgCaption != NULL) { echo '<div class = "block top-5 text-12 show-1025-and-above">'.$feEditorImgCaption.'</div>'; }
			echo '</div>'; // /.$introImgClass
		} // end if $introImgExists
	echo '</div>'; // /.paragraph left bottom-10 /#intro
} // end if intro

// FREE ISSUE
if($feFreeIssueText != NULL and $feFreeIssue != NULL and $feFreeIssueURL != NULL)
{
	echo '<div class = "paragraph left bottom-10" id = "free-issue">';
		echo $feFreeIssueText.' <a href = "'.$feFreeIssueURL.'" target = "_blank">'.$feFreeIssue.'</a><br/><br/>';
		require 'php/issue-covers.php';
	echo '</div>'; // /.paragraph left bottom-10 /#free-issue
} // end if $freFreeIssue

// CONCLUSION, SIG
if($feConclusion != NULL or ($feSigImg != NULL and $feSigImgData != '?') or $feSigText != NULL)
{
	echo '<div class = "paragraph left bottom-10" id = "conclusion">';
		if($feConclusion != NULL) { echo '<p>'.parseLinksOld($feConclusion).'</p>'; }
		if($feSigImg != NULL and $feSigImgData != '?') 
		{ 
			echo '<p>';
				if($feSigImgURL != NULL) { echo '<a href = "'.$feSigImgURL.'" target = "_blank">'; }
					echo '<div class = "width-10"><img src = "php/img.php?-url='.urlencode($feSigImg).'"></div>';
				if($feSigImgURL != NULL) { echo '</a>'; }
			echo '</p>'; 
		} // end if $feSigImg
		if($feSigText != NULL) { echo '<p>'.parseLinksOld($feSigText).'</p>'; }
	echo '</div>'; // /.paragraph left bottom-10 /#conclusion
} // end if content

// FOOTNOTES
if($feFootnotes != NULL)
{
	echo '<div class = "paragraph left bottom-10 italic" id = "footnotes">';
		echo parseLinksOld($feFootnotes);
	echo '</div>'; // /.paragraph left bottom-10 italic /#footnotes
} // end if $feFootnotes

// CREATIVE COMMONS LICENSE
if($feCCText != NULL or ($feCCImg != NULL and $feCCImgData != '?'))
{
	echo '<div class = "paragraph left bottom-10" id = "creative-commons">';
		if($feCCImgURL != NULL) { echo '<a href = "'.$feCCImgURL.'" target = "_blank">'; }
			if($feCCImg != NULL and $feCCImgData != '?') { echo '<div class = "width-10"><img src = "php/img.php?-url='.urlencode($feCCImg).'"></div>'; }
		if($feCCImgURL != NULL) { echo '</a>'; }
		if($feCCText != NULL) { echo '<p>'.parseLinksOld($feCCText).'</p>'; }
	echo '</div>'; // /.paragraph left bottom-10 /#creative-commons
} // end if CC
?>