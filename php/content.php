<!--
content.php
By Matthew DiMatteo, Children's Technology Review

This file is included in the 'document.php' file
It uses global variables specified in 'document.php' and based on parameters specified in the file for each page to determine the css class for the content
and the string for the file containing the content for each particular page

$contentFile is s string following a pattern where the filename always begins with 'content-' and ends with the name of the corresponding page
For example, the $contentFile for the page 'home.php' would be 'content-home.php'
If there is no file in the php directory corresponding to this string calculation, an error occurs
-->
<div id = "content">
<div class = "<?php echo $pageClass;?>">
<?php
$contentFile = 'php/content/content-'.$thisPage;

// custom conditions for full access pages
if($thisPage == 'fullreview.php') 	{ $contentFile = 'php/content/content-review.php'; }
if($thisPage == 'fullissue.php')	{ $contentFile = 'php/content/content-issue.php'; }
if($thisPage == 'fullweekly.php')	{ $contentFile = 'php/content/content-weekly.php'; }

require_once $contentFile;
?>
</div><!-- /.$pageClass -->
</div><!-- /#content -->