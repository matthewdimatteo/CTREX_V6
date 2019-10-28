<?php
/*
php/content/content-editorial-calendar.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the Editorial Calendar page
It is included dynamically in 'editorial-calendar.php' by the file 'php/document.php'
Variable values are defined in the file 'php/settings.php'
*/

// PAGE HEADER, SUBHEADER
if($edCalHeader != NULL) 	{ echo '<div class = "page-header">'.$edCalHeader.'</div>'; }
if($edCalSubheader != NULL) { echo '<div class = "subheader">'.$edCalSubheader.'</div>'; }

echo '<div class = "paragraph left">';

	// INTRO
	if($edCalIntroText != NULL) { echo '<p>'.$edCalIntroText.'</p>'; }
	
	// MONTHLY TRENDS/TOPICS:
	if(count($edCalMonths) > 0)
	{
		foreach($edCalMonths as $edCalMonth)
		{
			$monthName = $edCalMonth[0];
			$monthText = $edCalMonth[1];
			echo '<p><strong>'.$monthName.'</strong> '.$monthText.'</p>';
		} // end foreach $edCalMonth
	} // end if $edCalMonths
	
	// CONCLUSION
	if($edCalConclusionText != NULL) { echo '<p>'.$edCalConclusionText.' Please <a href = "contact.php">contact us</a> if you have any questions about specific coverage.</p>'; }
	
	// ISSUE COVER THUMB GRID
	require 'php/issue-covers.php';

echo '</div>'; // /.paragraph left
?>

<!-- STATIC VERSION
<div class = "page-header">Editorial Calendar</div>
<div class = "subheader">We are often asked for an Editorial Calendar...</div>

<div class = "paragraph left">
	<p>
		Because we don’t have advertisers, we are less bound to specific themes, or the need to create issues around pre-defined topics.   Cover stories come from the apps or people we review. 
	</p>
	<p>Here are the general monthly trends:</p>
	
	<p><strong>JANUARY</strong> KAPi Awards; Best Children's Apps of the Year; Editor's Choice Selections</p>
	<p><strong>FEBRUARY</strong> Best children’s eBooks preview; Editor’s Choice Selections</p>
	<p><strong>MARCH</strong> Technology Toy Preview (results and analysis from Toy Fair); Editor’s Choice Selections</p>
	
	<p><strong>APRIL</strong> Announcing the BolognaRagazzi Digital Prize winners; Editor’s Choice Selections</p>
	<p><strong>MAY</strong> Editor’s Choice Selections</p>
	<p><strong>JUNE</strong> E3; Video Game news;  Editor’s Choice Selections</p>
	
	<p><strong>JULY</strong> Editor’s Choice Selections</p>
	<p><strong>AUGUST</strong> Editor’s Choice Selections; Back to school</p>
	<p><strong>SEPTEMBER</strong> Editor’s Choice Selections</p>
	
	<p><strong>OCTOBER</strong> Editor’s Choice Selections</p>
	<p><strong>NOVEMBER</strong> Holiday buyer’s guide; Editor’s Choice Selections</p>
	<p><strong>DECEMBER</strong> Tablets and hardware; Editor’s Choice Selections</p>
	
	<p>All new editorial contributions are due 15 days before the first of the month. Please <a href = "contact.php">contact us</a> if you have any questions about specific coverage.</p>
	
	<div id = "issue-cover-thumbs">
		<?php
		
		?>
	</div>
	
</div>
-->