<?php
/*
php/social-icons.php
By Matthew DiMatteo, Children's Technology Review

This file defines an array of social media icons and links, outputting each
It is included in 'php/content/content-press.php' and 'php/content/content-social-media.php' for inclusion on the Press and Social Media pages
*/

// image location, link url, hover text
$socialMediaLinks = array
(
	array('wordpress32.png'	, 'http://childrenstech.com/blog/archives/category/news', 'See our latest news'),
	array('facebook32.png'	, 'https://www.facebook.com/childtech', 'Find us on Facebook'),
	array('twitter32.png'	, 'https://twitter.com/childtech', 'Find us on Twitter'),
	array('youtube32.png'	, 'https://www.youtube.com/user/childrenstech/videos', 'Find us on YouTube'),
	array('android32.png'	, 'https://play.google.com/store/apps/collection/promotion_familysafe_30017a3_ExpertPicks_CTR_Home', 'View our Editor\'s Choice picks for Android apps on Google Play'),
	array('google32.png'	, 'https://www.google.com/webhp?hl=en&source=hp&btnG=Google+Search&gws_rd=ssl#hl=en&tbm=nws&q=%22children%27s+technology+review%22', 'See our latest Google News results'),
);
foreach($socialMediaLinks as $socialMediaLink)
{
	$smLinkImg 		= $socialMediaLink[0];
	$smLinkURL 		= $socialMediaLink[1];
	$smLinkHover	= $socialMediaLink[2];
	echo '<div class = "inline left-5 right-5">';
		echo '<a href = "'.$smLinkURL.'" target = "_blank" title = "'.$smLinkHover.'"><img src = "images/'.$smLinkImg.'"/></a>';
	echo '</div>'; // /.inline left-10 right-10
}
?>