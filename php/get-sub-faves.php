<?php		
if($numFaves > 0)
{
	$savedSearches 	= array();
	$savedBookmarks = array();
	$savedRubrics 	= array();
	$nSearches = -1;
	$nBookmarks = -1;
	$nRubrics = -1;
	$faves = $record->getRelatedSet($fmfaveslayout);
	foreach($faves as $fave)
	{
		if($numSavedSearches > 0)
		{
			$url 			= $fave->getField('faves::url');
			$feedback 		= $fave->getField('faves::feedback');
			$searchnumber	= $fave->getField('faves::id');

			if($url != NULL) 
			{ 	
				$nSearches += 1; 
				$savedSearches[$nSearches] = array($url, $feedback, $searchnumber);
			}
		} // end if ($numSavedSearches > 0 )

		if($numSavedBookmarks > 0)
		{
			$reviewnumber 	= $fave->getField('faves::reviewnumber');
			$reviewlink		= 'review.php?id='.$reviewnumber;
			$reviewtitle	= $fave->getField('faves::reviewtitle');
			$faveID			= $fave->getField('faves::id');
			$bookmarkTagID		= $fave->getField('faves::tagID');
			$bookmarkTagName	= $fave->getField('tags::tag');

			if($reviewnumber != NULL)
			{
				$nBookmarks += 1;
				$savedBookmarks[$nBookmarks] = array($reviewnumber, $reviewlink, $reviewtitle, $faveID, $bookmarkTagID, $bookmarkTagName);
			}
		} // end if($numBookmarkedReviews > 0)

		if($numSavedRubrics > 0)
		{
			$savedRubricName	= $fave->getField('faves::rubricName');
			$savedRubricQA		= $fave->getField('faves::rubricQA');
			$savedRubricID		= $fave->getField('faves::id');
			$savedRubricDescription	= $fave->getField('faves::rubricDescription');

			if($savedRubricName != NULL)
			{
				$nRubrics += 1;
				$savedRubrics[$nRubrics] = array($savedRubricName, $savedRubricQA, $savedRubricID, $savedRubricDescription);	
			}

		} // end if($numSavedRubrics > 0)

	} // end foreach
} // end if($numFaves > 0)

if($numSavedTags > 0)
{
	$savedTags = array();
	$nTags = -1;
	$tags = $record->getRelatedSet('tagsSub');
	foreach($tags as $tag)
	{
		$nTags += 1;
		$tagName 	= $tag->getField('tagsSub::tag');
		$tagID 		= $tag->getField('tagsSub::id');
		$taggedBookmarks = $tag->getField('tagsSub::numBookmarks');
		$savedTags[$nTags] = array($tagName, $tagID, $taggedBookmarks);
	}
} // end if($numTags > 0)

if($numSavedCollections > 0)
{
	$savedCollections = array();
	$nCollections = -1;
	$collections = $record->getRelatedSet('collections');
	foreach($collections as $collection)
	{
		$nCollections += 1;
		$collectionID	= $collection->getField('collections::id');
		$collectionName = $collection->getField('collections::name');
		$collectionItemCount = $collection->getField('collections::numItems');
		$savedCollections[$nCollections] = array($collectionID, $collectionName, $collectionItemCount);
	}
} // end if($numCollections > 0)

if($numSavedCollectionItems > 0)
{
	$savedCollectionItems = array();
	$nCollectionItems = -1;
	$collectionitems = $record->getRelatedSet('collectionitems');
	foreach($collectionitems as $collectionitem)
	{
		$nCollectionItems += 1;
		$itemID 		= $collectionitem->getField('collectionitems::itemID');
		$collectionID 	= $collectionitem->getField('collectionitems::collectionID');
		$reviewID 		= $collectionitem->getField('collectionitems::reviewID');
		$title 			= $collectionitem->getField('CSRcollectionitem::Title');
		$savedCollectionItems[$nCollectionItems] = array($itemID, $collectionID, $reviewID, $title);
	}
} // end if($numCollectionItems > 0)

?>