<!--
php/review-share.php
By Matthew DiMatteo, Children's Technology Review

This file outputs a toggleable set of share buttons on the review and archive pages
The css class variables are calculated in 'php/review-format.php' for the review page and 'php/result-item-archive-info' for the issue and weekly pages
Certain items are conditionally included or calculated below depending on which page this file is included in
-->

<!-- SHARE TOGGLE -->
<div class = "<?php echo $reviewShareToggleClass;?>" id = "review-share-toggle">
	<div id = "review-share-show" onclick = "showItem('review-share-show', 'review-share-hide', 'review-share-container')">
		<div class = "review-share-item text-btn">Share</div>
		<div class = "review-share-item"><img src = "images/share.png"/></div>
	</div>
	<div id = "review-share-hide" onclick = "hideItem('review-share-show', 'review-share-hide', 'review-share-container')">
		<div class = "review-share-item text-btn">Share</div>
		<div class = "review-share-item"><img src = "images/share.png"/></div>
	</div>			
</div><!-- /#review-share-toggle -->

<!-- SHARE -->
<div class = "hide" id = "review-share-container">
	<div class = "review-share" id = "review-share">
		<?php
		require_once 'php/review-share-js.php'; // custom js functions from Twitter and Facebook for sharing link
		$reviewShareItems = array(); // declare an array of share items
		if($pageType == 'review')
		{
			require_once 'php/save-item-forms.php';			// includes save bookmark form
			require_once 'php/result-item-bookmark.php'; 	// determines hover text, img src, btn function
			
			// set hover text for MARC export item
			$marcHoverText		= 'Export this review in MARC format';
			if($subscriber == true){ $marcHoverText	= $marcHoverText; } else { $marcHoverText = 'Login as a subscriber to '.lcfirst($marcHoverText); }
			
			// append bookmark item to the array of share items only on the review page
			array_push($reviewShareItems, array('bookmark', $bookmarkIcon, 'function', $bookmarkFunction, $bookmarkHover));
			
			$permalinkURL = $fullreviewLink;
		} // end if $pageType == review
		else { $permalinkURL = $thisURL; }

		$shareLinkFacebook = 'https://www.facebook.com/sharer/sharer.php?sdk=joey&u=https://reviews.childrenstech.com/ctr/'.$thisURL.'&display=popup&ref=plugin&src=share_button';
		$shareLinkTwitter = 'https://twitter.com/share';
		
		// share items to include on both review and archive pages
		// array(id, image, function, hover text)
		$otherShareItems = array
		(
			
			array('email'		, 'images/email.png'		, 'link'	, 'mailto:'								, 'Email a link to this review'),
			array('facebook'	, 'images/facebook32.png'	, 'link'	, $shareLinkFacebook					, 'Share this review on Facebook'),
			array('twitter'		, 'images/twitter32.png'	, 'link'	, $shareLinkTwitter						, 'Share this review on Twitter'),
			array('print'		, 'images/print32.png'		, 'function', 'printPage()'							, 'Print this page'),
		);
		
		// add each of these share items to the array of all share items 
		foreach($otherShareItems as $otherShareItem) { array_push($reviewShareItems, $otherShareItem); }
		
		// on the review page only, add the marc export item to the array
		if($pageType == 'review') 
		{ array_push($reviewShareItems, array('export', 'images/export52.png', 'link', 'export.php?type=marc&format=csv&id='.$reviewnumber, $marcHoverText));}
		
		// add the permalink item to the end of the array
		array_push($reviewShareItems, array('permalink', 'images/permalink.png', 'function', 'highlight(\'review-permalink\')', 'Copy permalink to clipboard'));
		
		// output each share item
		foreach($reviewShareItems as $shareItem)
		{
			$shareItemID		= $shareItem[0];
			$shareItemImg		= $shareItem[1];
			$shareItemType		= $shareItem[2];
			$shareItemTarget 	= $shareItem[3];
			$shareItemHoverText	= $shareItem[4];
			echo '<div class = "review-share-item" id = "review-share-item-'.$shareItemID.'" title = "'.$shareItemHoverText.'">';
				if($shareItemType == 'link') 		{ echo '<a href = "'.$shareItemTarget.'" target = "_blank">'; }
				echo '<img src = "'.$shareItemImg.'" alt = "'.$shareItemID.'"';
					if($shareItemType == 'function') 	{ echo 'onclick = "'.$shareItemTarget.'"'; }
					echo ' />';
				if($shareItemType == 'link') 		{ echo '</a>'; }
			echo '</div>';
		}
		?>
		<div class = "review-share-item" id = "review-permalink-container">
			<input class = "review-permalink" readonly id = "review-permalink" onfocus = "highlight('review-permalink')" 
				value = "http://reviews.childrenstech.com/ctr/<?php echo $permalinkURL;?>" />
		</div>
	</div><!-- /#review-share -->
</div><!-- /#review-share-container -->