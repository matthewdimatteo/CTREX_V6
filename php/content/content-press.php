<!--
php/content/content-press.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the press page 'press.php' of the site, containing resources for members of the press
It is included dynamically in 'press.php' by the file 'php/document.php'
-->

<!-- PAGE CONTAINER -->
<div id = "press-page-container">

	<!-- PAGE HEADER -->
	<div class = "page-header">Press and Media Resources</div>
	
	<!-- EDITORIAL LINKS -->
    <div id = "editorial-links" class = "bottom-20"> 
	<?php
	// link label, link url, new tab
	$editorialLinks = array
	(
		array('CTR in the News','https://www.google.com/webhp?hl=en&source=hp&btnG=Google+Search&gws_rd=ssl#hl=en&tbm=nws&q=%22children%27s+technology+review%22', true),
		array('Editorial Calendar'	, 'editorial-calendar.php'		, false),
		array('Editorial Guidelines', 'editorial-guidelines.php' 	, false),
		array('Disclaimer'			, 'disclaimer.php'				, false)
	);
	foreach($editorialLinks as $editorialLink)
	{
		$edLinkLabel 	= $editorialLink[0];
		$edLinkURL 		= $editorialLink[1];
		$edLinkBlank	= $editorialLink[2];
		echo '<div class = "inline left-10 right-10">';
			echo '<button type = "button" ';
			if($edLinkBlank == true) 	{ echo 'onclick = "openBlank(\''.$edLinkURL.'\')"'; }
			else 						{ echo 'onclick = "openURL(\''.$edLinkURL.'\')"'; }
			echo '>'.$edLinkLabel.'</button>';
		echo '</div>'; // /.inline left-10 right-10
	}
	?>
    </div><!-- /#editorial-links -->
	
	<!-- SOCIAL MEDIA ICONS -->
	<div class = "bottom-20"><?php require_once 'php/social-icons.php'; ?></div><!-- /#social-media-icons -->
	
	<!-- ABOUT CTR -->
    <div class = "subheader"><a href = "http://childrenstech.com/about" target = "_blank">About Children's Technology Review</a></div>
    
    <div class = "paragraph">
    	
		<!-- SAMPLE ISSUE -->
    	<div class = "archive-item-image">
            <a href = "http://childrenstech.com/files/2015/01/CTR-Jan15-issue1781.pdf" target = "_blank" title = "View a sample issue (pdf)">
                <img src = "http://childrenstech.com/files/2015/01/jan15s.jpg" class = "issue-thumb">
            </a>
        </div><!-- /.archive-item-image-->
        
		<!-- DESCRIPTION -->
        <div id = "press-page-description" class = "inline width-80 left">
            Children’s Technology Review (CTR) is a continually updated rubric-driven survey of commercial children’s digital media products, for birth to 15-years.  It is designed to start an educational conversation about commercial interactive media products; with the underlying admission that there is no perfect rating system. Designed for teachers, librarians, publishers and parents, CTR is sold as a <a href = "subscribe.php" >subscription</a>, and is delivered both weekly and monthly to subscribers, who are granted unlimited access to the <a href = "home.php">CTREX review database</a>.
        </div><!-- inline width-80 left -->
        
    </div><!-- /.paragraph -->
	
	<!-- CONTACT FORM -->
	<div class = "top-20"><?php require_once 'php/contact-form.php'; ?></div>

</div><!-- /#press-page-container -->