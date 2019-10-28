<!--
php/content/content-articles.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the articles page
It is included dynamically in the file 'php/document.php'
-->

<!-- PAGE HEADER -->
<div class = "page-header">CTR Article Archive</div>

<!-- NOTE: OUTGOING LINKS -->
<div class = "text-14 italic bottom-20">Note: The following are outgoing links to <a href = "https://medium.com" target = "_blank">medium.com</a></div>

<!-- RESULTS FEED -->
<div class = "paragraph center">
<?php
$findArticles = $fmarticles->newFindCommand($fmarticlesLayout);
$findArticles->addFindCriterion('url', '*');
$findArticles->addSortRule('recordID', 1, FILEMAKER_SORT_DESCEND);
$result = $findArticles->execute();
if(FileMaker::isError($result)) { echo 'Error: '.$result->getMessage(); exit(); }
$records = $result->getRecords();
$articleN = 0;
foreach($records as $record)
{
	$articleN += 1;
	if($velvetRope != true or $articleN <= 3)
	{
		$url = $record->getField('url');
		$title = $record->getField('title');
		if($title == NULL) { $title = $url; }
		echo '<div class = "text-24"><a href = "'.$url.'" title = "View the article on medium.com" target = "blank">'.$title.'</a></div>';
	} // end if($velvetRope != true or $articleN <= 3)
} // end foreach $record
?>
</div><!-- /.paragraph center -->