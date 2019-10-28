<?php
/*
php/content/content-ratings.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the About the Ratings page 'ratings.php'
It is included dynamically in the file 'php/document.php'
Variable values are defined in the file 'php/settings.php'
*/

// PAGE HEADER, SUBHEADER
if($ratingsHeader != NULL) 		{ echo '<div class = "page-header">'.$ratingsHeader.'</div>'; }
if($ratingsSubheader != NULL) 	{ echo '<div class = "subheader">'.$ratingsSubheader.'</div>'; }

// INTRO
if($ratingsIntroText != NULL or $ratingsIntroImgExists)
{
	if($ratingsIntroImgExists)
	{
		$ratingsIntroTextClass 	= 'inline width-70 right-10 award-title-text';
		$ratingsIntroImgClass 	= 'inline width-20 award-title-img';
	} // end if $ratingsIntroImgExists
	
	echo '<div class = "paragraph left bottom-10" id = "intro">';
		echo '<div class = "'.$ratingsIntroTextClass.'">';
			if($ratingsIntroText != NULL) 		{ echo '<p>'.parseLinksOld($ratingsIntroText).'</p>'; }
		echo '</div>'; // /.$ratingsIntroTextClass
		if($ratingsIntroImgExists == true)
		{
			echo '<div class = "'.$ratingsIntroImgClass.'">';
				if($ratingsIntroImgURL != NULL) { echo '<a href = "'.$ratingsIntroImgURL.'" target = "_blank">'; }
					echo '<img src = "php/img.php?-url='.urlencode($ratingsIntroImg).'" >';
				if($ratingsIntroImgURL != NULL) { echo '</a>'; }
				if($ratingsIntroImgCaption != NULL) { echo '<div class = "block top-5 text-12 show-1025-and-above">'.$ratingsIntroImgCaption.'</div>'; }
			echo '</div>'; // /.$ratingsIntroImgClass
		} // end if $ratingsIntroImgExists
	echo '</div>'; // /.paragraph left bottom-10 /#intro
} // end if intro

// NOTES
if($ratingsNotesHeader != NULL or $ratingsNotesText != NULL or $ratingsNotesItems != NULL or $ratingsNotesImgExists)
{
	if($ratingsNotesImgExists)
	{
		$ratingsNotesTextClass 	= 'inline width-80 right-10 award-title-text';
		$ratingsNotesImgClass 	= 'inline width-10 award-title-img';
	} // end if $ratingsNotesImgExists
	
	echo '<div class = "paragraph left bottom-10" id = "notes">';
		echo '<div class = "'.$ratingsNotesTextClass.'">';
			if($ratingsNotesHeader != NULL) 	{ echo '<div class = "bold left bottom-10">'.$ratingsNotesHeader.'</div>'; }
			if($ratingsNotesText != NULL) 		{ echo '<p>'.parseLinksOld($ratingsNotesText).'</p>'; }
			if($ratingsNotesItems != NULL)
			{
				echo '<ul>';
				for($n = 0; $n <= count($ratingsNotesItems); $n++)
				{ 
					if($ratingsNotesItems[$n] != NULL) { echo '<li>'.parseLinksOld($ratingsNotesItems[$n]).'</li>'; }
				} // end for
				echo '</ul>';
			} // end if $ratingsNotesItems
		echo '</div>'; // /.$ratingsNotesTextClass
		if($ratingsNotesImgExists == true)
		{
			echo '<div class = "'.$ratingsNotesImgClass.'">';
				if($ratingsNotesImgURL != NULL) { echo '<a href = "'.$ratingsNotesImgURL.'" target = "_blank">'; }
					echo '<img src = "php/img.php?-url='.urlencode($ratingsNotesImg).'" >';
				if($ratingsNotesImgURL != NULL) { echo '</a>'; }
				if($ratingsNotesImgCaption != NULL) { echo '<div class = "block top-5 text-12 show-1025-and-above">'.$ratingsNotesImgCaption.'</div>'; }
			echo '</div>'; // /.$ratingsNotesImgClass
		} // end if $ratingsNotesImgExists
	echo '</div>'; // /.paragraph left bottom-10 /#notes
} // end if notes

// VIDEO
if($ratingsVideoURL != NULL)
{
	echo '<div class = "paragraph-60 left bottom-30 award-iframe" id = "video">';
		//echo '<div class = "width-60 ">';
			if($ratingsVideoLabel != NULL) { echo '<div class = "text-12 italic">'.$ratingsVideoLabel.'</div>'; }
			echo '<iframe src = "'.$ratingsVideoURL.'"></iframe>';
		//echo '</div>'; // /.width-60 award-iframe
	echo '</div>'; ///.paragraph left bottom-30 /#video
} // end if video

// ARTICLES
if($ratingsArticlesHeader != NULL or $ratingsArticlesSubheaders != NULL or $ratingsArticlesLinks != NULL or $ratingsArticlesDescriptions != NULL)
{
	echo '<div class = "paragraph left bottom-10" id = "articles">';
		if($ratingsArticlesHeader != NULL) 	{ echo '<div class = "bold left bottom-10">'.$ratingsArticlesHeader.'</div>'; }
		// count the number of items in the arrays (these should all be equal)
		$numArticlesSubheaders 	= count($ratingsArticlesSubheaders);
		$numArticlesLinks 		= count($ratingsArticlesLinks);
		$numArticlesDescriptions= count($ratingsArticlesDescriptions);
		$numArticles = max($numArticlesSubheaders, $numArticlesLinks, $numArticlesDescriptions); // set the number of articles as the highest value
		for($a = 0; $a <= $numArticles; $a++)
		{
			if($ratingsArticlesSubheaders[$a] != NULL or $ratingsArticlesLinks[$a] != NULL or $ratingsArticlesDescriptions[$a] != NULL)
			{
				echo '<p>';
					// SUBHEADER
					if($ratingsArticlesSubheaders[$a] != NULL)
					{ 
						echo '<div class = "text-14 bold italic">'.$ratingsArticlesSubheaders[$a].'</div>';
					} // end if subheader
					// LINK
					if($ratingsArticlesLinks[$a] != NULL)
					{ 
						echo '<div class = "text-14 italic"><a href = "'.$ratingsArticlesLinks[$a].'" target = "_blank">'.$ratingsArticlesLinks[$a].'</a></div>';
					} // end if link
					// DESCRIPTION
					if($ratingsArticlesDescriptions[$a] != NULL)
					{
						echo '<div class = "text-14 italic">'.$ratingsArticlesDescriptions[$a].'</div>'; 
					} // end if description
				echo '</p>';
			} // end if content
		} // end for
	echo '</div>'; // /.paragraph left bottom-10 /#articles
} // end if articles

// STRONG
if($ratingsStrongText != NULL)
{
	echo '<div class = "paragraph left bottom-20" id = "strong">';
		echo parseLinksOld($ratingsStrongText);
	echo '</div>'; // /.paragraph left bottom-20 /#strong
} // end if strong text

if($ratingsStrongImgExists == true)
{
	echo '<div class = "paragraph center bottom-40" id = "strong-img">';
		echo '<div class = "width-50 inline"><img src = "php/img.php?-url='.urlencode($ratingsStrongImg).'"></div>';
		if($ratingsStrongImgCaption != NULL) { echo '<div class = "text-12">'.$ratingsStrongImgCaption.'</div>'; }
	echo '</div>'; // /.paragraph center bottom-40 /#strong-img
} // end if strong img

// INSTRUMENT
if($ratingsInstrumentHeader != NULL or $ratingsInstrumentKey != NULL)
{
	echo '<div class = "paragraph left bottom-40" id = "instrument">';
		if($ratingsInstrumentHeader != NULL) 	{ echo '<div class = "bold left bottom-10">'.$ratingsInstrumentHeader.'</div>'; }
		if($ratingsInstrumentKey != NULL) 		{ echo parseLinksOld($ratingsInstrumentKey); }
	echo '</div>'; // /.paragraph left bottom-40 /#instrument
} // end if instrument

// QA 1
if($ratingsInstrumentQA1Header != NULL or $ratingsInstrumentQA1Description != NULL or count($ratingsInstrumentQA1Items) > 0)
{
	echo '<div class = "paragraph left bottom-40" id = "instrument-qa-1">';
		if($ratingsInstrumentQA1Header != NULL) 		{ echo '<div class = "bold left bottom-10">'.$ratingsInstrumentQA1Header.'</div>'; }
		if($ratingsInstrumentQA1Description != NULL) 	{ echo parseLinksOld($ratingsInstrumentQA1Description); }
		if(count($ratingsInstrumentQA1Items) > 0)
		{
			echo '<div>N  SE  A  NA</div>';
			for($qa = 0; $qa <= count($ratingsInstrumentQA1Items); $qa++)
			{
				if($ratingsInstrumentQA1Items[$qa] != NULL) { echo '<div>__ __ __ __ '.$ratingsInstrumentQA1Items[$qa].'</div>'; }
			} // end for
		} // end if items > 0
	echo '</div>'; // /.paragraph left bottom-40 /#instrument-qa-1
} // end QA1

// QA 2
if($ratingsInstrumentQA2Header != NULL or $ratingsInstrumentQA2Description != NULL or count($ratingsInstrumentQA2Items) > 0)
{
	echo '<div class = "paragraph left bottom-40" id = "instrument-qa-2">';
		if($ratingsInstrumentQA2Header != NULL) 		{ echo '<div class = "bold left bottom-10">'.$ratingsInstrumentQA2Header.'</div>'; }
		if($ratingsInstrumentQA2Description != NULL) 	{ echo parseLinksOld($ratingsInstrumentQA2Description); }
		if(count($ratingsInstrumentQA2Items) > 0)
		{
			echo '<div>N  SE  A  NA</div>';
			for($qa = 0; $qa <= count($ratingsInstrumentQA2Items); $qa++)
			{
				if($ratingsInstrumentQA2Items[$qa] != NULL) { echo '<div>__ __ __ __ '.$ratingsInstrumentQA2Items[$qa].'</div>'; }
			} // end for
		} // end if items > 0
	echo '</div>'; // /.paragraph left bottom-40 /#instrument-qa-2
} // end QA2

// QA 3
if($ratingsInstrumentQA1Header != NULL or $ratingsInstrumentQA1Description != NULL or count($ratingsInstrumentQA1Items) > 0)
{
	echo '<div class = "paragraph left bottom-40" id = "instrument-qa-3">';
		if($ratingsInstrumentQA3Header != NULL) 		{ echo '<div class = "bold left bottom-10">'.$ratingsInstrumentQA3Header.'</div>'; }
		if($ratingsInstrumentQA3Description != NULL) 	{ echo parseLinksOld($ratingsInstrumentQA3Description); }
		if(count($ratingsInstrumentQA3Items) > 0)
		{
			echo '<div>N  SE  A  NA</div>';
			for($qa = 0; $qa <= count($ratingsInstrumentQA3Items); $qa++)
			{
				if($ratingsInstrumentQA3Items[$qa] != NULL) { echo '<div>__ __ __ __ '.$ratingsInstrumentQA3Items[$qa].'</div>'; }
			} // end for
		} // end if items > 0
	echo '</div>'; // /.paragraph left bottom-40 /#instrument-qa-3
} // end QA3

// QA 4
if($ratingsInstrumentQA4Header != NULL or $ratingsInstrumentQA4Description != NULL or count($ratingsInstrumentQA4Items) > 0)
{
	echo '<div class = "paragraph left bottom-40" id = "instrument-qa-4">';
		if($ratingsInstrumentQA4Header != NULL) 		{ echo '<div class = "bold left bottom-10">'.$ratingsInstrumentQA4Header.'</div>'; }
		if($ratingsInstrumentQA4Description != NULL) 	{ echo parseLinksOld($ratingsInstrumentQA4Description); }
		if(count($ratingsInstrumentQA4Items) > 0)
		{
			echo '<div>N  SE  A  NA</div>';
			for($qa = 0; $qa <= count($ratingsInstrumentQA4Items); $qa++)
			{
				if($ratingsInstrumentQA4Items[$qa] != NULL) { echo '<div>__ __ __ __ '.$ratingsInstrumentQA4Items[$qa].'</div>'; }
			} // end for
		} // end if items > 0
	echo '</div>'; // /.paragraph left bottom-40 /#instrument-qa-4
} // end QA4

// QA 5
if($ratingsInstrumentQA1Header != NULL or $ratingsInstrumentQA1Description != NULL or count($ratingsInstrumentQA1Items) > 0)
{
	echo '<div class = "paragraph left bottom-40" id = "instrument-qa-5">';
		if($ratingsInstrumentQA5Header != NULL) 		{ echo '<div class = "bold left bottom-10">'.$ratingsInstrumentQA5Header.'</div>'; }
		if($ratingsInstrumentQA5Description != NULL) 	{ echo parseLinksOld($ratingsInstrumentQA5Description); }
		if(count($ratingsInstrumentQA5Items) > 0)
		{
			echo '<div>N  SE  A  NA</div>';
			for($qa = 0; $qa <= count($ratingsInstrumentQA5Items); $qa++)
			{
				if($ratingsInstrumentQA5Items[$qa] != NULL) { echo '<div>__ __ __ __ '.$ratingsInstrumentQA5Items[$qa].'</div>'; }
			} // end for
		} // end if items > 0
	echo '</div>'; // /.paragraph left bottom-40 /#instrument-qa-5
} // end QA5

// QA 6
if($ratingsInstrumentQA6Header != NULL or $ratingsInstrumentQA6Description != NULL)
{
	echo '<div class = "paragraph left bottom-40" id = "instrument-qa-6">';
		if($ratingsInstrumentQA6Header != NULL) 		{ echo '<div class = "bold left bottom-10">'.$ratingsInstrumentQA6Header.'</div>'; }
		if($ratingsInstrumentQA6Description != NULL) 	{ echo parseLinksOld($ratingsInstrumentQA6Description); }
		
		// 1-10 markers
		echo '<div class = "show-769-and-above">';
			echo '<div class = "width-50">';	for($r = 1; $r <= 10; $r++) { echo '<div class = "inline width-5">__</div>'; } echo '</div>';
			echo '<div class = "width-50">'; 	for($r = 1; $r <= 10; $r++) { echo '<div class = "inline width-5">'.$r.'</div>'; } echo '</div>';
		echo '</div>'; // /.show-769-and-above
		
		// mobile version
		echo '<div class = "show-only-480">';
			echo '<div class = "full-width">';	for($r = 1; $r <= 10; $r++) { echo '<div class = "inline width-10">__</div>'; } echo '</div>';
			echo '<div class = "full-width">'; 	for($r = 1; $r <= 10; $r++) { echo '<div class = "inline width-10">'.$r.'</div>'; } echo '</div>';
		echo '</div>'; // /.show-only-480
		
	echo '</div>'; // /.paragraph left bottom-40 /#instrument-qa-6
} // end QA6

// PROCEDURE
if($ratingsProcedureHeader != NULL or $ratingsProcedureText != NULL)
{
	echo '<div class = "paragraph left bottom-10" id = "procedure">';
		if($ratingsProcedureHeader != NULL) { echo '<div class = "bold left bottom-10">'.$ratingsProcedureHeader.'</div>'; }
		if($ratingsProcedureText != NULL) 	{ echo '<p>'.parseLinksOld($ratingsProcedureText).'</p>'; }
	echo '</div>'; // /.paragraph left bottom-10 /#procedure
} // end if procedure

// CTREX USER RATINGS
if($ratingsCTREXUserHeader != NULL or $ratingsCTREXUserDescription != NULL or count($ratingsCTREXUserItems) > 0)
{
	echo '<div class = "paragraph left bottom-10" id = "ctrex-user">';
		if($ratingsCTREXUserHeader != NULL) 		{ echo '<div class = "bold left bottom-10">'.$ratingsCTREXUserHeader.'</div>'; }
		if($ratingsCTREXUserDescription != NULL) 	{ echo '<p>'.parseLinksOld($ratingsCTREXUserDescription).'</p>'; }
		if(count($ratingsCTREXUserItems) > 0)
		{
			echo '<ul>';
			for($c = 0; $c <= count($ratingsCTREXUserItems); $c++)
			{
				if($ratingsCTREXUserItems[$c] != NULL) { echo '<li>'.$ratingsCTREXUserItems[$c].'</li>'; }
			} // end for
			echo '</ul>';
		} // end if items
	echo '</div>'; // /.paragraph left bottom-10 /#ctrex-user
} // end if procedure

?>