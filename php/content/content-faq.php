<?php 
/*
php/content/content-faq.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the FAQ page
It is included dynamically in the file 'php/document.php'
Variable values are defined in 'php/settings.php'
*/

// HEADER, SUBHEADER
if($faqHeader != NULL) 		{ echo '<div class = "page-header">'.$faqHeader.'</div>'; }
if($faqSubheader != NULL) 	{ echo '<div class = "subheader">'.$faqSubheader.'</div>'; }

// FORMAT CONTENT BASED ON WHETHER IMG EXISTS
if($faqImg != NULL and $faqImgData != '?') 	
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

// Q & A, IMG
if(count($faqQuestions) > 0 or count($faqAnswers) > 0 or $introImgExists == true)
{
	echo '<div class = "paragraph left bottom-10" id = "q-and-a">';
		echo '<div class = "'.$introTextClass.'">';
		
			// NUMBERED LIST
			if(count($faqQuestions) > 0 or count($faqAnswers) > 0)
			{
				echo '<ol>';
				for($i = 0; $i < count($faqQuestions); $i++)
				{
					if($faqQuestions[$i] != NULL or $faqAnswers[$i] != NULL)
					{ 
						echo '<li>';
							if($faqQuestions[$i] != NULL) 	{ echo '<strong>'.$faqQuestions[$i].'</strong> '; }
							if($faqAnswers[$i] != NULL)		{ echo ucfirst(parseLinksOld($faqAnswers[$i])); }
						echo '</li>';
					} // end if Q & A
				} // end for
				echo '</ol>';
			} // end if Q & A
			
		echo '</div>'; // /.$introTextClass
		
		// EDITOR IMG
		if($introImgExists == true)
		{
			echo '<div class = "'.$introImgClass.'">';
				if($faqImgURL != NULL) { echo '<a href = "'.$faqImgURL.'" target = "_blank">'; }
					echo '<img src = "php/img.php?-url='.urlencode($faqImg).'">';
				if($faqImgURL != NULL) { echo '</a>'; }
				if($faqImgCaption != NULL) { echo '<div class = "block top-5 text-12 show-1025-and-above">'.$faqImgCaption.'</div>'; }
			echo '</div>'; // /.$introImgClass
		} // end if $introImgExists
	echo '</div>'; // /.paragraph left bottom-10 /#q-and-a
} // end if Q & A

// CONCLUSION
if($faqConclusion != NULL)
{
	echo '<div class = "paragraph left bottom-10" id = "conclusion">';
		echo parseLinksOld($faqConclusion);
	echo '</div>'; // /.paragraph left bottom-10 /#conclusion
} // end if $faqConclusion
?>