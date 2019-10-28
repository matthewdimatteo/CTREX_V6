<?php
/*
php/content/content-award.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the Award page 'award.php'
It is included dynamically in the file 'php/document.php'
*/

// PROCESS FORM SUBMISSION
if(isset($_GET['type']))
{
	// GET PARAMETERS
	$awardType 	= test_input($_GET['type']);
	$awardYear 	= test_input($_GET['year']);
	
	// BOLOGNA
	if($awardType == 'bologna')
	{
		// LOOKUP RECORD
		$findAward = $fmbologna->newFindCommand($fmbolognaLayout);
		$findAward->addFindCriterion('year', '=='.$awardYear);
		$result = $findAward->execute();
		if(FileMaker::isError($result)) { echo 'Error: '.$result->getMessage(); exit(); }
		$record = $result->getFirstRecord();
		
		$fields = $bolognaFields; 	// tells 'php/get-field.php' to use $bolognaFields array (defined in 'php/fields.php')
		require 'php/get-field.php';// get field values from database and assign to dynamically named variables (as specified in 'php/fields.php')
		
		// DETERMINE PAGE TITLE
		if($bolognaYear != NULL) 	{ $pageTitle = $bolognaYear.' BolognaRagazzi Digital Award - CTREX'; }
		else						{ $pageTitle = 'BolognaRagazzi Digital Award - CTREX'; }
		
	} // end if bologna
	
	// KAPI
	else if($awardType == 'kapi' or $awardType == 'kapis')
	{
		// LOOKUP RECORD
		$findAward = $fmkapi->newFindCommand($fmkapiLayout);
		$findAward->addFindCriterion('year', '=='.$awardYear);
		$result = $findAward->execute();
		if(FileMaker::isError($result)) { echo 'Error: '.$result->getMessage(); exit(); }
		$record = $result->getFirstRecord();
		
		$fields = $kapisFields; 	// tells 'php/get-field.php' to use $kapisFields array (defined in 'php/fields.php')
		require 'php/get-field.php';// get field values from database and assign to dynamically named variables (as specified in 'php/fields.php')
		
		// DETERMINE PAGE TITLE
		if($kapiYear != NULL) 		{ $pageTitle = $kapiYear.' KAPi Award - CTREX'; }
		else						{ $pageTitle = 'KAPi Award - CTREX'; }
	} // end else if kapi
	
	// SET PAGE TITLE
	echo '<script>setPageTitle(\''.$pageTitle.'\');</script>';

	// store the "At a Glance" and list of jurors repeating field values in an array to be outputted as bullet points
	// getListItems() function defined in 'php/functions.php'
	if($atAGlance != NULL) 	{ $atAGlanceArray 	= getListItems($record, 'atAGlance', 12); }
	if($jurorsList != NULL) { $jurorsListArray 	= getListItems($record, 'jurorsList', 15); }

	// APPEND HTTP TO EXTERNAL LINKS - function convertURL($url) defined in 'php/functions.php'
	if($introImgURL != NULL) 		{ $introImgURL = convertURL($introImgURL); }
	if($winnersImgURL != NULL) 		{ $winnersImgURL = convertURL($winnersImgURL); }
	if($mentionsImgURL != NULL) 	{ $mentionsImgURL = convertURL($mentionsImgURL); }
	if($shortListImgURL != NULL) 	{ $shortListImgURL = convertURL($shortListImgURL); }
	if($jurorsImgURL != NULL) 		{ $jurorsImgURL = convertURL($jurorsImgURL); }
	if($conclusionImgURL != NULL) 	{ $conclusionImgURL = convertURL($conclusionImgURL); }
	if($pdfURL != NULL)				{ $pdfURL = convertURL($pdfURL); }

	// GET RELATED TITLES
	if($numTitles > 0)
	{
		// declare arrays to store each group of titles
		$allTitlesArray = array();
		$winners1Array 	= array();
		$winners2Array 	= array();
		$mentions1Array	= array();
		$mentions2Array	= array();
		$shortListArray	= array();
		
		// handle which fields to get based on award type
		if($awardType == 'bologna') 							
		{ 
			$typeField 			= 'CSR::bolognaType';
			$descriptionField 	= 'CSR::bolognaDescription';
			$categoryField		= 'CSR::Bologna Category';
			$yearField 			= 'CSR::bolognaYear';
		} // end if bologna
		else if ($awardType == 'kapi' or $awardType == 'kapis') 
		{
			$typeField 			= 'CSR::kapiType';
			$descriptionField 	= 'CSR::kapiDescription';
			$categoryField		= 'CSR::kapiAward';
			$yearField 			= 'CSR::kapiYear';
		} // end else if kapi
		
		// get the related set of titles from the database and store in arrays
		$titles = $record->getRelatedSet('CSR');
		foreach($titles as $title)
		{
			$titleType 			= $title->getField($typeField);
			$titleName 			= $title->getField('CSR::Title');
			$titleReviewID 		= $title->getField('CSR::reviewnumber');
			$titleReviewLink 	= 'review.php?id='.$titleReviewID;
			$titleCompany		= $title->getField('CSR::Company');
			$titleCompanyLink	= $title->getField('CSR::websiteParsed');
			$titleCountry		= $title->getField('CSR::bolognaCountry');
			$titleDescription	= $title->getField($descriptionField);
			$titleImg 			= $title->getField('CSR::thumbnail');
			$titleImgData		= $title->getField('CSR::thumbData');
			$titleItunes		= $title->getField('CSR::itunes code');
			$titleAndroid		= $title->getField('CSR::Android code');
			$titleAmazon		= $title->getField('CSR::amazon');
			$titleSteam			= $title->getField('CSR::steam code');
			$titleCategory		= $title->getField($categoryField);

			// array of individual title data
			$titleData			= array($titleType, $titleName, $titleReviewID, $titleReviewLink, $titleCompany, $titleCompanyLink, $titleCountry, $titleDescription, $titleImg, $titleImgData, $titleItunes, $titleAndroid, $titleAmazon, $titleSteam, $titleCategory);

			// store title data in array corresponding to its type (such as winner, mention, short-list)
			array_push($allTitlesArray, $titleData);

			if(substr_count($titleType, 'winner1') > 0) 	{ array_push($winners1Array, $titleData); }
			if(substr_count($titleType, 'winner2') > 0) 	{ array_push($winners2Array, $titleData); }
			if(substr_count($titleType, 'mention1') > 0)	{ array_push($mentions1Array, $titleData); }
			if(substr_count($titleType, 'mention2') > 0)	{ array_push($mentions2Array, $titleData); }
			if(substr_count($titleType, 'shortList') > 0)	{ array_push($shortListArray, $titleData); }

		} // end foreach title

		// count the size of each array to determine whether to output below
		$numWinners1 	= count($winners1Array);
		$numWinners2 	= count($winners2Array);
		$numMentions1 	= count($mentions1Array);
		$numMentions2 	= count($mentions2Array);
		$numShortList 	= count($shortListArray);
	} // end if titles

	// OUTPUT FORMATTED FIELD DATA ---------------------------------

	// PAGE CONTAINER
	echo '<div id = "award-page-container" class = "award-page-container">';

	// PAGE HEADER
	if($pageHeader != NULL) 	{ echo '<div class = "page-header">'.$pageHeader.'</div>'; }
	
	// JUROR PANEL
	if($juror == true and substr_count($jurorType, $awardType) > 0 and $awardYear == $year)
	{
		echo '<p><button type = "button" onclick = "openURL(\'juror-panel.php?type='.$awardType.'&year='.$awardYear.'\')">Open Juror\'s Panel</button></p>';
	}
	
	// LEAD IMAGE
	if($leadImg != NULL and $leadImgData != '?')
	{
		echo '<div class = "paragraph-60 center bottom-10">';
			if($leadImgURL != NULL) { echo '<a href = "'.$leadImgURL.'" target = "_blank">'; }
				echo '<img src = "php/img.php?-url='.urlencode($leadImg).'" >';
			if($leadImgURL != NULL) { echo '</a>'; }
			if($leadImgCaption != NULL) { echo '<div class = "block top-5 text-12">'.$leadImgCaption.'</div>'; }
		echo '</div>'; // /.paragraph-60 center bottom-10
	} // end if leadImg
	
	// INTRO
	if($introImg != NULL and $introImgData != '?') 	
	{
		$introImgExists 	= true;
		$introTextClass 	= 'inline width-70 award-title-text';
		$introImgClass 		= 'inline width-20 left-10 award-title-img';
	} // end if intro img
	else							
	{
		$introImageExists 	= '';
		$introTextClass 	= 'full-width';
		$introImgClass 		= 'hide';
	} // end else no intro img
	if($introHeader != NULL or $introText != NULL or $introImgExists == true)
	{
		echo '<div class = "paragraph left bottom-10" id = "intro">';
			echo '<div class = "'.$introTextClass.'">';
				if($introHeading != NULL) 	{ echo '<div class = "bold left bottom-10">'.$introHeading.'</div>'; }
				if($introText != NULL) 		{ echo '<p>'.parseLinksOld($introText).'</p>'; }
			echo '</div>'; // /.$introTextClass
			if($introImgExists == true)
			{
				echo '<div class = "'.$introImgClass.'">';
					if($introImgURL != NULL) { echo '<a href = "'.$introImgURL.'" target = "_blank">'; }
						echo '<img src = "php/img.php?-url='.urlencode($introImg).'" >';
					if($introImgURL != NULL) { echo '</a>'; }
					if($introImgCaption != NULL) { echo '<div class = "block top-5 text-12 show-1025-and-above">'.$introImgCaption.'</div>'; }
				echo '</div>'; // /.$introImgClass
			} // end if $introImgExists
		echo '</div>'; // /.paragraph left bottom-10 /#intro
	} // end if intro

	// DOWNLOAD AS PDF
	if($pdfURL != NULL)
	{
		echo '<div class = "paragraph left bottom-20" id = "pdf">';
			echo '<a href = "'.$pdfURL.'" target = "_blank" title = "Download this article as a PDF">Download this article as a PDF</a>';
		echo '</div>'; // /.paragraph left bottom-20 /#pdf
	} // end if $pdfURL

	// VIDEO
	if($videoLink != NULL)
	{
		echo '<div class = "paragraph-60 center bottom-20 award-iframe" id = "video">';
			echo '<iframe src = "'.$videoLink.'"></iframe>';
		echo '</div>'; // /.paragraph-60 center bottom-20 award-iframe /#video
	} // end if $videoLink

	// AT A GLANCE
	if( (count($atAGlanceArray) > 0) or ($atAGlanceDescription != NULL) )
	{
		echo '<div class = "paragraph left bottom-10" id = "at-a-glance">';
		if(count($atAGlanceArray) > 0)
		{
			echo '<div class = "bold left bottom-10">THE PRIZE AT A GLANCE</div>';
			echo '<ul>';
				foreach($atAGlanceArray as $aagItem) { if($aagItem != NULL) { echo '<li>'.$aagItem.'</li>'; } }
			echo '</ul>';
		} // end if $atAGlanceArray
		if($atAGlanceDescription != NULL) { echo '<p>'.parseLinksOld($atAGlanceDescription).'</p>'; }
		echo '</div>'; // /.paragraph left bottom-10 /#at-a-glance
	} // end if at a glance

	// WINNERS
	if($numWinners1 > 0 or $numWinners2 > 0 or $winnersExtra != NULL or $winners1Heading != NULL or $winners1Text != NULL or $winners2Heading != NULL or $winners2Text != NULL or $emergingPioneerName != NULL or $legendPioneerName != NULL or $lifetimePioneerName != NULL)
	{
		// DETERMINE CSS BASED ON WHETHER IMG EXISTS
		if($winnersImg != NULL and $winnersImgData != '?')
		{
			$winnersImgExists 	= true;
			$winnersTextClass 	= 'inline width-70 award-title-text';
			$winnersImgClass 	= 'inline width-20 left-10 award-title-img';
		} // end if winners img
		else
		{
			$winnersImageExists = '';
			$winnersTextClass 	= 'full-width';
			$winnersImgClass 	= 'hide'; 
		} // end else no winners img

		echo '<div class = "paragraph left bottom-10" id = "winners">';

			echo '<div class = "'.$winnersTextClass.'">';

				// WINNERS 1
				if($numWinners1 > 0)
				{

					echo '<div class = "paragraph left bottom-10" id = "winners1">';
						if($winners1Heading != NULL) 	{ echo '<div class = "bold left bottom-10">'.$winners1Heading.'</div>'; }
						if($winners1Text != NULL)		{ echo '<p>'.$winners1Text.'</p>'; }
						$titlesArray = $winners1Array;
						require 'php/award-title.php';
					echo '</div>'; // /.paragraph left bottom-10 /#winners1
				} // end if $numWinners1

				// WINNERS 2
				if($numWinners2 > 0)
				{
					echo '<div class = "paragraph left bottom-10" id = "winners2">';
						if($winners2Heading != NULL) 	{ echo '<div class = "bold left bottom-10">'.$winners2Heading.'</div>'; }
						if($winners2Text != NULL)		{ echo '<p>'.$winners2Text.'</p>'; }
						$titlesArray = $winners2Array;
						require 'php/award-title.php';
					echo '</div>'; // /.paragraph left bottom-10 /#winners2
				} // end if $numWinners1

				// EXTRA (TITLES NOT IN DATABASE)
				if($winnersExtra != NULL)
				{
					echo '<div class = "paragraph left bottom-10" id = "winners-extra">';
						echo nl2br($winnersExtra);
					echo '</div>'; // /.paragraph left bottom-10 /#winners-extra
				} // end if $winnersExtra
				
				// EMERGING PIONEER
				if($emergingPioneerName != NULL)
				{
					echo '<div class = "paragraph left bottom-10" id = "emerging-pioneer">';
						if($emergingPioneerImg != NULL and $emergingPioneerImgData != '?')
						{
							$epTextClass 	= 'inline width-80 award-title-text';
							$epImgClass 	= 'inline width-10 right-20 award-title-img';
						} // end if $emergingPioneerImg
						else
						{
							$epTextClass 	= 'full-width';
							$epImgClass 	= 'hide';
						} // end else no img
						if($emergingPioneerImg != NULL and $emergingPioneerImgData != '?')
						{
							echo '<div class = "'.$epImgClass.'">';
								echo '<img src = "php/img.php?-url='.urlencode($emergingPioneerImg).'" alt = "Image not available">';
							echo '</div>'; // /.$epImgClass
						} // end if emergingPioneerImg
						echo '<div class = "'.$epTextClass.'">';
							echo '<strong>Emerging Pioneer: </strong>'.$emergingPioneerName;
							if($emergingPioneerDescription != NULL) { echo '<br/>'.parseLinksOld($emergingPioneerDescription); }
						echo '</div>'; // /.$epTextClass
						
					echo '</div>'; // /.paragraph left bottom-10 /#emerging-pioneer
				} // end if $emergingPioneerName
				
				// LEGEND PIONEER
				if($legendPioneerName != NULL)
				{
					echo '<div class = "paragraph left bottom-10" id = "legend-pioneer">';
						if($legendPioneerImg != NULL and $legendPioneerImgData != '?')
						{
							$lpTextClass 	= 'inline width-80 award-title-text';
							$lpImgClass 	= 'inline width-10 right-20 award-title-img';
						} // end if $legendPioneerImg
						else
						{
							$lpTextClass 	= 'full-width';
							$lpImgClass 	= 'hide';
						} // end else no img
						if($legendPioneerImg != NULL and $legendPioneerImgData != '?')
						{
							echo '<div class = "'.$lpImgClass.'">';
								echo '<img src = "php/img.php?-url='.urlencode($legendPioneerImg).'" alt = "Image not available">';
							echo '</div>'; // /.$lpImgClass
						} // end if legendPioneerImg
						echo '<div class = "'.$lpTextClass.'">';
							echo '<strong>Legend Pioneer: </strong>'.$legendPioneerName;
							if($legendPioneerDescription != NULL) { echo '<br/>'.parseLinksOld($legendPioneerDescription); }
						echo '</div>'; // /.$lpTextClass
						
					echo '</div>'; // /.paragraph left bottom-10 /#legend-pioneer
				} // end if $legendPioneerName
				
				// LIFETIME PIONEER
				if($lifetimePioneerName != NULL)
				{
					echo '<div class = "paragraph left bottom-10" id = "lifetime-pioneer">';
						if($lifetimePioneerImg != NULL and $lifetimePioneerImgData != '?')
						{
							$lipTextClass 	= 'inline width-80 award-title-text';
							$lipImgClass 	= 'inline width-10 right-20 award-title-img';
						} // end if $lifetimePioneerImg
						else
						{
							$lipTextClass 	= 'full-width';
							$lipImgClass 	= 'hide';
						} // end else no img
						if($lifetimePioneerImg != NULL and $lifetimePioneerImgData != '?')
						{
							echo '<div class = "'.$lipImgClass.'">';
								echo '<img src = "php/img.php?-url='.urlencode($lifetimePioneerImg).'" alt = "Image not available">';
							echo '</div>'; // /.$lipImgClass
						} // end if lifetimePioneerImg
						echo '<div class = "'.$lipTextClass.'">';
							echo '<strong>Lifetime Pioneer: </strong>'.$lifetimePioneerName;
							if($lifetimePioneerDescription != NULL) { echo '<br/>'.parseLinksOld($lifetimePioneerDescription); }
						echo '</div>'; // /.$lipTextClass
						
					echo '</div>'; // /.paragraph left bottom-10 /#lifetime-pioneer
				} // end if $lifetimePioneerName

			echo '</div>'; // /.$winnersTextClass

			if($winnersImgExists == true)
			{
				echo '<div class = "'.$winnersImgClass.'">';
					if($winnersImgURL != NULL) { echo '<a href = "'.$winnersImgURL.'" target = "_blank">'; }
						echo '<img src = "php/img.php?-url='.urlencode($winnersImg).'" >';
					if($winnersImgURL != NULL) { echo '</a>'; }
					if($winnersImgCaption != NULL) { echo '<div class = "block top-5 text-12 show-1025-and-above">'.$winnersImgCaption.'</div>'; }
				echo '</div>'; // /.$winnersImgClass 
			} // end if $winnersImgExists

		echo '</div>'; // /.paragraph left bottom-10 /#winners

	} // end if $numWinners1 > 0 or $numWinners2 > 0 or $winnersExtra

	// MENTIONS
	if($numMentions1 > 0 or $numMentions2 > 0 or $mentionsExtra != NULL or $mentions1Heading != NULL or $mentions1Text != NULL or $mentions2Heading != NULL or $mentions2Text != NULL)
	{
		// DETERMINE CSS BASED ON WHETHER IMG EXISTS
		if($mentionsImg != NULL and $mentionsImgData != '?')
		{
			$mentionsImgExists 		= true;
			$mentionsTextClass 		= 'inline width-70 award-title-text';
			$mentionsImgClass 		= 'inline width-20 left-10 award-title-img';
		} // end if mentions img
		else
		{
			$mentionsImageExists 	= '';
			$mentionsTextClass 		= 'full-width';
			$mentionsImgClass 		= 'hide';
		} // end else no mentions img

		echo '<div class = "paragraph left bottom-10" id = "mentions">';

			echo '<div class = "'.$mentionsTextClass.'">';

				// MENTIONS 1
				if($numMentions1 > 0 or $mentions1Heading != NULL or $mentions1Text != NULL)
				{
					echo '<div class = "paragraph left bottom-10" id = "mentions1">';
						if($mentions1Heading != NULL) 	{ echo '<div class = "bold left bottom-10">'.$mentions1Heading.'</div>'; }
						if($mentions1Text != NULL)		{ echo '<p>'.$mentions1Text.'</p>'; }
						$titlesArray = $mentions1Array;
						require 'php/award-title.php';
					echo '</div>'; // /.paragraph left bottom-10 /#mentions1
				} // end if $numMentions1

				// MENTIONS 2
				if($numMentions2 > 0)
				{
					echo '<div class = "paragraph left bottom-10" id = "mentions2">';
						if($mentions2Heading != NULL) 	{ echo '<div class = "bold left bottom-10">'.$mentions2Heading.'</div>'; }
						if($mentions2Text != NULL)		{ echo '<p>'.$mentions2Text.'</p>'; }
						$titlesArray = $mentions2Array;
						require 'php/award-title.php';
					echo '</div>'; // /.paragraph left bottom-10 /#mentions2
				} // end if $numMentions2

				// EXTRA (TITLES NOT IN DATABASE)
				if($mentionsExtra != NULL)
				{
					echo '<div class = "paragraph left bottom-10" id = "mentions-extra">';
						echo nl2br($mentionsExtra);
					echo '</div>'; // /.paragraph left bottom-10 /#mentions-extra
				} // end if $mentionsExtra

			echo '</div>'; // /.$mentionsTextClass

			if($mentionsImgExists == true)
			{
				echo '<div class = "'.$mentionsImgClass.'">';
					if($mentionsImgURL != NULL) { echo '<a href = "'.$mentionsImgURL.'" target = "_blank">'; }
						echo '<img src = "php/img.php?-url='.urlencode($mentionsImg).'" >';
					if($mentionsImgURL != NULL) { echo '</a>'; }
					if($mentionsImgCaption != NULL) { echo '<div class = "top-5 block text-12 show-1025-and-above">'.$mentionsImgCaption.'</div>'; }
				echo '</div>'; // /.$mentionsImgClass 
			} // end if $mentionsImgExists

		echo '</div>'; // /.paragraph left bottom-10 /#mentions

	 } // end if $numMentions1 > 0 or $numMentions2 > 0 or $mentionsExtra

	// SHORT LIST
	if($numShortList > 0 or $shortListExtra != NULL)
	{
		// DETERMINE CSS BASED ON WHETHER IMG EXISTS
		if($shortListImg != NULL and $shortListImgData != '?')
		{
			$shortListImgExists 	= true;
			$shortListTextClass 	= 'inline width-70 award-title-text';
			$shortListImgClass 		= 'inline width-20 left-10 award-title-img';
		} // end if shortlist img
		else
		{
			$shortListImageExists 	= '';
			$shortListTextClass 	= 'full-width';
			$shortListImgClass 		= 'hide';
		} // end else no shortlist img

		echo '<div class = "paragraph left bottom-10" id = "short-list">';

			echo '<div class = "'.$shortListTextClass.'">';

				if($numShortList > 0)
				{
					echo '<div class = "paragraph left bottom-10">';
						if($shortListHeading != NULL) 	{ echo '<div class = "bold left bottom-10">'.$shortListHeading.'</div>'; }
						if($shortListText != NULL)		{ echo '<p>'.$shortListText.'</p>'; }
						$titlesArray = $shortListArray;
						require 'php/award-title.php';
					echo '</div>'; // /.paragraph left bottom-10 /#shortlist
				} // end if $numShortList > 0

				// EXTRA (TITLES NOT IN DATABASE)
				if($shortListExtra != NULL)
				{
					echo '<div class = "paragraph left bottom-10" id = "short-list-extra">';
						echo nl2br($shortListExtra);
					echo '</div>'; // /.paragraph left bottom-10 /#short-list-extra
				} // end if $shortListExtra

			echo '</div>'; // /.$mentionsTextClass

			if($shortListImgExists == true)
			{
				echo '<div class = "'.$shortListImgClass.'">';
					if($shortListImgURL != NULL) { echo '<a href = "'.$shortListImgURL.'" target = "_blank">'; }
						echo '<img src = "php/img.php?-url='.urlencode($shortListImg).'" >';
					if($shortListImgURL != NULL) { echo '</a>'; }
					if($shortListImgCaption != NULL) { echo '<div class = "block top-5 text-12 show-1025-and-above">'.$shortListImgCaption.'</div>'; }
				echo '</div>'; // /.$shortListImgClass 
			} // end if $shortListImgExists

		echo '</div>'; // /.paragraph left bottom-10 /#short-list

	} // end if $numShortList > 0

	// FULL LIST OF WORKS
	if($fullListLink != NULL)
	{
		echo '<div class = "paragraph left bottom-10" id = "full-list">';
			echo '<a href = "'.$fullListLink.'" target = "_blank" title = "View the full list of works entered">View the full list of works entered</a>';
		echo '</div>'; // /.paragraph left bottom-10 /#full-list
	} // end if $fullListLink
	
	// CTREX SEARCH LINK
	if($numTitles > 0)
	{
		$ctrexSearchLink = 'home.php?sort=abc&&order=asc&award='.$awardType.'&year='.$awardYear.'&page=1';
		echo '<div class = "paragraph left bottom-40" id = "ctrex-link">';
			echo '<a href = "'.$ctrexSearchLink.'" title = "View the titles featured in this year\'s award on CTREX">View list of entries on CTREX</a>';
		echo '</div>'; // /.paragraph left bottom-40 /#ctrex-link
	} // end if $numTitles > 0

	// JURORS
	if($jurorsImg != NULL and $jurorsImgData != '?')
	{
		$jurorsImgExists 	= true;
		$jurorsTextClass 	= 'inline width-70 award-title-text';
		$jurorsImgClass 	= 'inline width-20 left-10 award-title-img';
	} // end if jurors img
	else
	{
		$jurorsImageExists 	= '';
		$jurorsTextClass 	= 'full-width';
		$jurorsImgClass 	= 'hide';
	} // end else no jurors img
	if($jurorsHeader != NULL or $jurorsText != NULL or $jurorsImgExists == true)
	{
		echo '<div class = "paragraph left bottom-10" id = "jurors">';
			echo '<div class = "'.$jurorsTextClass.'">';
				if($jurorsHeading != NULL) 	{ echo '<div class = "bold left bottom-10">'.$jurorsHeading.'</div>'; }
				if($jurorsText != NULL) 	{ echo '<p>'.parseLinksOld($jurorsText).'</p>'; }
				if($jurorsListArray != NULL and count($jurorsListArray) > 0)
				{
					echo '<ul>';
						foreach($jurorsListArray as $jlItem) { if($jlItem != NULL) { echo '<li>'.$jlItem.'</li>'; } }
					echo '</ul>';
				} // end if $jurorsListArray
			echo '</div>'; // /.$jurorsTextClass
			if($jurorsImgExists == true)
			{
				echo '<div class = "'.$jurorsImgClass.'">';
					if($jurorsImgURL != NULL) { echo '<a href = "'.$jurorsImgURL.'" target = "_blank">'; }
						echo '<img src = "php/img.php?-url='.urlencode($jurorsImg).'" >';
					if($jurorsImgURL != NULL) { echo '</a>'; }
					if($jurorsImgCaption != NULL) { echo '<div class = "block top-5 text-12 show-1025-and-above">'.$jurorsImgCaption.'</div>'; }
				echo '</div>'; // /.$jurorsImgClass
			} // end if $jurorsImgExists
		echo '</div>'; // /.paragraph left bottom-10 /#jurors
	} // end if jurors

	// JURORS LINK
	if($jurorsLink != NULL)
	{
		echo '<div class = "paragraph left bottom-20" id = "jurors-link">';
			echo '<a href = "'.$jurorsLink.'" target = "_blank" title = "About the international jury">About the international jury</a>';
		echo '</div>'; // /.paragraph left bottom-20 /#jurors-link
	} // end if $jurorsLink

	// CONCLUSION
	if($conclusionImg != NULL and $conclusionImgData != '?')
	{
		$conclusionImgExists 	= true;
		$conclusionTextClass 	= 'inline width-70 award-title-text';
		$conclusionImgClass 	= 'inline width-20 left-10 award-title-img';
	} // end if conclusion img
	else											
	{
		$conclusionImageExists 	= '';
		$conclusionTextClass 	= 'full-width';
		$conclusionImgClass 	= 'hide';
	} // end else no conclusion img
	if($conclusionHeader != NULL or $conclusionText != NULL or $conclusionImgExists == true)
	{
		echo '<div class = "paragraph left bottom-10" id = "conclusion">';
			echo '<div class = "'.$conclusionTextClass.'">';
				if($conclusionHeading != NULL) 	{ echo '<div class = "bold left bottom-10">'.$conclusionHeading.'</div>'; }
				if($conclusionText != NULL) 	{ echo '<p>'.parseLinksOld($conclusionText).'</p>'; }
			echo '</div>'; // /.$conclusionTextClass
			if($conclusionImgExists == true)
			{
				echo '<div class = "'.$conclusionImgClass.'">';
					if($conclusionImgURL != NULL) { echo '<a href = "'.$conclusionImgURL.'" target = "_blank">'; }
						echo '<img src = "php/img.php?-url='.urlencode($conclusionImg).'" >';
					if($conclusionImgURL != NULL) { echo '</a>'; }
					if($conclusionImgCaption != NULL) { echo '<div class = "block top-5 text-12 show-1025-and-above">'.$conclusionImgCaption.'</div>'; }
				echo '</div>'; // /.$conclusionImgClass
			} // end if $conclusionImgExists
		echo '</div>'; // /.paragraph left bottom-10 /#conclusion
	} // end if conclusion

	// BOLOGNA CONTACT INFO
	if($awardType == 'bologna' and ($bolognaAddress != NULL or $bolognaPhone != NULL or $bolognaEmail != NULL))
	{
		echo '<div class = "paragraph left bottom-10" id = "contact">';
			if($bolognaAddress != NULL) { echo $bolognaAddress.'<br/>'; }
			if($bolognaPhone != NULL) 	{ echo $bolognaPhone.'<br/>'; }
			if($bolognaEmail != NULL) 	{ echo '<a href = "mailto:'.$bolognaEmail.'">'.$bolognaEmail.'</a><br/>'; }
		echo '</div>'; // /.paragraph left bottom-10 /#contact
	} // end if bologna contact info
	
	// KAPI CONTACT INFO
	if($awardType == 'kapi' and ($kapisAddress != NULL or $kapisPhone != NULL or $kapisEmail != NULL))
	{
		echo '<div class = "paragraph left bottom-10" id = "contact">';
			echo 'For further information:<br/><br/>';
			if($kapisAddress != NULL) 	{ echo $kapisAddress.'<br/>'; }
			if($kapisPhone != NULL) 	{ echo $kapisPhone.'<br/>'; }
			if($kapisEmail != NULL) 	{ echo 'Email: <a href = "mailto:'.$kapisEmail.'">'.$kapisEmail.'</a><br/>'; }
		echo '</div>'; // /.paragraph left bottom-10 /#contact
	} // end if kapi contact info
	
	// KAPI ABOUT RELATED ORGANIZATIONS
	if($awardType == 'kapi' or $awardType == 'kapis' and ($kapisAboutLDT != NULL or $kapisAboutCTR != NULL))
	{
		echo '<div class = "paragraph left bottom-10" id = "related-organizations">';
			if($kapisAboutLDT != NULL) { echo '<p><strong>About Living in Digital Times</strong><br/>'.parseLinksOld($kapisAboutLDT).'</p>'; }
			if($kapisAboutCTR != NULL) { echo '<p><strong>About Children\'s Technology Review</strong><br/>'.parseLinksOld($kapisAboutCTR).'</p>'; }
		echo '</div>'; // /.paragraph left bottom-10 /#related-organizations
	} // end if kapi related organization info
	
	echo '</div>'; // /#award-page-container .award-page-container
	
} // end if isset award

// IF FORM NOT SUBMITTED PROPERLY
else
{
	$redirect = 'awards.php';
	require 'php/redirect.php';
	exit();
} // end else form not submitted properly
?>