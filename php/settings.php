<?php
/*
php/settings.php
By Matthew DiMatteo, Children's Technology Review

This file accesses the 'dashboard' table in the 'CSR.fmp12' database to get values for certain settings for the CTREX site
The 'dashboard' table contains fields for site-wide settings that can be managed by CTR staff:
- The guest access level (velvet rope, normal, or free mode)
- Parameters for velvet rope acces (such as number of results per page, which items can be viewed)
- The logo and tagline to display in the header
- Messages to display beneath the header (including a promo message, free mode message, new feature message, and error message)
- Text and media resources for samples on the About page
- The price of a subscription ($19 or $60) and the text for the subscription form
- Content for certain pages, including About, Editorial Calendar/Guidelines, BRDA/KAPi Awards, Rating Method, and Publishers Bill of Rights

This file is included in the 'php/autoload.php' file, and the variables set here can be accessed anywhere in the site
This gives CTR staff dynamic control of the web content through the internal FileMaker databases

*/

// access the first dashboard record where settings are defined
$getDashboardSettings = $fmdashboard->newFindCommand($fmdashboardLayout);
$getDashboardSettings->addFindCriterion('recordnumber',"==".'1');
$dashboardResult = $getDashboardSettings->execute();
if (FileMaker::isError ($dashboardResult) ) { echo $dashboardResult->getMessage(); exit(); }
$dashboardRecord = $dashboardResult->getFirstRecord();

// get the published record count
$totalPublishedReviews = $dashboardRecord->getField('publishedCount');

// check the guest access level ------------------------------------------------------------------------
/*
$velvetRopeStatus 	= $dashboardRecord->getField('ironCurtainHard');
$freeModeStatus		= $dashboardRecord->getField('freeMode');

if($velvetRopeStatus == 'On') 	{ $velvetRopeStatus = true; } else { $velvetRopeStatus = false; }
if($freeModeStatus == 'On') 	{ $freeModeStatus 	= true; } else { $freeModeStatus = false; }
if($freeModeStatus == true) 	{ $velvetRopeStatus = false; } // if both selected, free mode takes precedence and overrides velvet rope
if($freeModeStatus == true)
{
	$guestAccess = 'Free Mode';
}
else if ($velvetRopeStatus == true)
{
	$guestAccess = 'Velvet Rope';
}
else
{
	$guestAccess = 'Default';
}
*/
// check the guest access level using new field --------------------------------------------------------
$guestAccess = $dashboardRecord->getField('guestAccess');
switch($guestAccess)
{
	case 'Velvet Rope' 	: $velvetRopeStatus = true; 	$freeModeStatus = false;	break;
	case 'Default' 		: $velvetRopeStatus = false; 	$freeModeStatus = false;	break;
	case '' 			: $velvetRopeStatus = false; 	$freeModeStatus = false;	break;
	case 'Free Mode' 	: $velvetRopeStatus = false; 	$freeModeStatus = true; 	break;
	default				: $velvetRopeStatus = false; 	$freeModeStatus = false;	break;
} // end switch($guestAccess)

// check whether in sponsored mode (free for guests, but not labeled as "Free Mode")
$sponsored = $dashboardRecord->getField('sponsored');
if($sponsored == 'On') { $sponsored = true; } else { $sponsored = false; }

// define velvet rope parameters
$numResults = 100;
$numResultsVelvet = 3;

$velvetMoreByPub	= false;
$velvetAppStore 	= false;
$velvetRatings 		= false;
$velvetFullReview 	= false;
$velvetPubProfile 	= false;

// get logo --------------------------------------------------------------------------------------------
$logoType 		= $dashboardRecord->getField('logoType');
$logoImg		= $dashboardRecord->getField('headerLogo');
$logoImgHover	= $dashboardRecord->getField('headerLogoHover');
$logoText		= $dashboardRecord->getField('headerText');
$logoTagline	= $dashboardRecord->getField('tagline');

// get promo messages ----------------------------------------------------------------------------------
$promoMessage 			= $dashboardRecord->getField('promoLinkText');
$freeModeMessage		= $dashboardRecord->getField('freeModeLoggedIn');
$freeModeMessage 		= nl2br($freeModeMessage);
$freeModeMessage 		= str_replace('*', '&#9733', $freeModeMessage);
$freeModeMessageLogin	= $dashboardRecord->getField('freeModeMessageLogin');

// get new feature message
$newFeatureShow		= $dashboardRecord->getField('newFeatureShow');
if($newFeatureShow == 'On') { $newFeatureShow = true; } else { $newFeatureShow = false; }
//$newFeatureShow = true; // debug override
$newFeatureHeader	= $dashboardRecord->getField('newFeatureHeader');
$newFeatureBody		= $dashboardRecord->getField('newFeatureBody');

// get error message
$errorMessageShow	= $dashboardRecord->getField('showErrorMessage');
if($errorMessageShow == 'Show') { $errorMessageShow = true; } else { $errorMessageShow = false; }
$errorMessageShow	= $dashboardRecord->getField('errormessage');

// get about text and disclaimer text
$aboutText					= $dashboardRecord->getField('aboutText');
$disclaimerText				= $dashboardRecord->getField('disclaimerText');

// get samples text -------------------------------------------------------------------------------------
$samplesHeader				= $dashboardRecord->getField('samplesHeader');
$samplesReviewsHeader		= $dashboardRecord->getField('splashReviewsHeaderLabel');
$samplesReviewsSubheader	= $dashboardRecord->getField('splashReviewsSubLabel');
$samplesMonthlyHeader		= $dashboardRecord->getField('splashMonthlyHeaderLabel');
$samplesMonthlySubheader	= $dashboardRecord->getField('splashMonthlySubLabel');
$samplesWeeklyHeader		= $dashboardRecord->getField('splashWeeklyHeaderLabel');
$samplesWeeklySubheader		= $dashboardRecord->getField('splashWeeklySubLabel');
$samplesWeeklyImage			= $dashboardRecord->getField('splashWeeklyThumb');

// samples text default values
if($samplesHeader == NULL) 			{ $samplesHeader 			= 'Sample what you get:'; }
if($samplesReviewsHeader == NULL) 	{ $samplesReviewsHeader 	= 'Full Review'; }
if($samplesReviewsSubheader == NULL){ $samplesReviewsSubheader	= '"Warts and all" critiques'; }
if($samplesMonthlyHeader == NULL) 	{ $samplesMonthlyHeader 	= 'Monthly Issue'; }
if($samplesMonthlySubheader == NULL){ $samplesMonthlySubheader 	= 'One PDF each month'; }
if($samplesWeeklyHeader == NULL) 	{ $samplesWeeklyHeader 		= 'Weekly Newsletter'; }
if($samplesWeeklySubheader == NULL) { $samplesWeeklySubheader 	= 'By email every Wednesday'; } 

// get subscription page text ------------------------------------------------------------------------------
$subscriptionPrice				= $dashboardRecord->getField('subscriptionPrice');
$subscriptionPageTitle			= $dashboardRecord->getField('subscriptionPageTitle');
$subscriptionBubbleHeader		= $dashboardRecord->getField('subscriptionBubbleHeader');
$subscriptionBubbleSubheader	= $dashboardRecord->getField('subscriptionBubbleSubheader');
$subscriptionBubbleText			= $dashboardRecord->getField('subscriptionBubbleCopy');
$subscriptionBtnLabel			= $dashboardRecord->getField('subscriptionBtnLabel');
$subscriptionFeaturesHeader		= $dashboardRecord->getField('subscriptionFeaturesHeader');

// subscription page default values
if($subscriptionPrice == NULL) 			{ $subscriptionPrice = 60; }
if($subscriptionPageTitle == NULL) 		{ $subscriptionPageTitle 		= 'Subscribe to CTR'; }
if($subscriptionBtnLabel == NULL) 		{ $subscriptionBtnLabel 		= $proBtnLabel; }
if($subscriptionFeaturesHeader == NULL) { $subscriptionFeaturesHeader 	= 'Included in your subscription:'; }

// set authorize.net order form to load corresponding items based on price
if($subscriptionPrice == 19) 			
{ 
	$subscribeLinkID 	= 'd8be7918-42b9-41b7-b35a-c147d8d68942'; 	$subscribeBtnLabel = 'Subscribe ($19.99)'; 	
	$renewLinkID		= $subscribeLinkID;							$renewBtnLabel = $subscribeBtnLabel;
	
}
else if($subscriptionPrice == 60) 	
{ 
	$subscribeLinkID 	= 'be7a6741-d8c4-4a53-9038-45660a989b5a'; 	$subscribeBtnLabel = 'Subscribe ($60)';	
	$renewLinkID 		= 'f021e91f-0880-4ced-8f29-4f7c43d46b67'; 	$renewBtnLabel = '+1 Year ($50)';	
}
else 						
{ 
	$subscribeLinkID 	= 'be7a6741-d8c4-4a53-9038-45660a989b5a'; 	$subscribeBtnLabel = 'Subscribe ($60)';
	$renewLinkID 		= 'f021e91f-0880-4ced-8f29-4f7c43d46b67'; 	$renewBtnLabel = '+1 Year ($50)';		
}

// get latest weekly -----------------------------------------------------------------------------------------
$findLatestWeekly = $fmweekly->newFindCommand($fmweeklyLayout);
$findLatestWeekly->addFindCriterion('active', "*");
$findLatestWeekly->addSortRule('archiveID', 1, FILEMAKER_SORT_DESCEND);
$latestWeeklyResult 	= $findLatestWeekly->execute();
if(FileMaker::isError ($latestWeeklyResult) ) { echo 'error: '.$latestWeeklyResult->getMessage(); exit(); }

$latestWeeklyRecord 	= $latestWeeklyResult->getFirstRecord();

$latestWeeklyID 		= $latestWeeklyRecord->getField('archiveID');

// LATEST WEEKLY LINK
$latestWeeklyLink		= 'weekly.php?id='.$latestWeeklyID;
$latestWeeklyFullLink	= 'fullweekly.php?id='.$latestWeeklyID;

$latestWeeklyDate 		= $latestWeeklyRecord->getField('weeklyDate');
$latestWeeklySubject 	= $latestWeeklyRecord->getField('subjectNotes');
$latestWeeklyIntro		= $latestWeeklyRecord->getField('intro');

$latestWeeklySubjectLength = 100;

if($latestWeeklySubject != NULL) 		{ $latestWeeklyPreview = $latestWeeklySubject; }
else if ($latestWeeklyIntro != NULL) 	{ $latestWeeklyPreview = substr($latestWeeklyIntro, 0, $latestWeeklySubjectLength); }
else if ($latestWeeklyDate != NULL)		{ $latestWeeklyPreview = $latestWeeklyDate; }
else									{ $latestWeeklyPreview = 'CTR Weekly'; }
$latestWeeklyPreviewLink = '<a href = "'.$latestWeeklyLink.'" title = "Read the latest CTR Weekly Newsletter: '.$latestWeeklySubject.'">'.$latestWeeklyPreview.'... Read More</a>';
$latestWeeklyReviewCount= $latestWeeklyRecord->getField('numTitles');

if($latestWeeklyReviewCount > 0)
{
	$latestWeeklyReviewList = '';
	$latestWeeklyReviews = $latestWeeklyRecord->getRelatedSet('CSR');

	foreach($latestWeeklyReviews as $latestWeeklyReview)
	{
		$latestWeeklyReviewTitle 	= $latestWeeklyReview->getField('CSR::Title');
		$latestWeeklyReviewID 		= $latestWeeklyReview->getField('CSR::reviewnumber');
		$latestWeeklyReviewLink		= 'review.php?id='.$latestWeeklyReviewID;
		$latestWeeklyReviewList 	.= '<a href = "'.$latestWeeklyReviewLink.'">'.$latestWeeklyReviewTitle.'</a><br/>';
	} // end foreach

} // end if($latestWeeklyReviewCount > 0)

// SAMPLE REVIEW, MONTHLY, WEEKLY IDs
$sampleReviewID = $dashboardRecord->getField('sampleReviewID');
$sampleMonthlyID= $dashboardRecord->getField('sampleMonthlyID');
$sampleWeeklyID = $dashboardRecord->getField('sampleWeeklyID');

// hover text
$relSortBtnHover 		= $dashboardRecord->getField('relSortHover');
$relSortDropdownHover 	= $dashboardRecord->getField('relSortResultsHover');

// get dynamic text ($dynamicText bool set in page file before including 'php/autoload.php')
if($dynamicText == true)
{
	$findText = $fmtext->newFindCommand($fmtextLayout);
	$findText->addFindCriterion('pageName', '=='.$thisPage);
	$textResult = $findText->execute();
	if(FileMaker::isError($textResult)) { echo 'error: '.$textResult->getMessage(); exit(); }
	$record = $textResult->getFirstRecord();
	require 'php/get-text.php'; // get the field values from the database
} // end if $dynamicText

// PUBLISHERS BILL OF RIGHTS
if($thisPage == 'publisher-rights.php')
{
	$publisherRightsHeader	= $dashboardRecord->getField('publisherRightsHeader');
	if($publisherRightsHeader == NULL) { $publisherRightsHeader = 'Publishers Bill of Rights'; }
	$publisherRightsIntro 	= $dashboardRecord->getField('publisherRightsIntro');
	$publisherRightsImg 	= $dashboardRecord->getField('publisherRightsImg');

	// get repetitions from publisher rights list and store in array
	$publisherRightsList 	= $dashboardRecord->getField('publisherRightsList');
	if($publisherRightsList != NULL)
	{
		$publisherRightsArray = array();
		$numReps = 12;
		for($prr = 0; $prr <= $numReps; $prr++)
		{
			$thisRep = $dashboardRecord->getField('publisherRightsList', $prr);
			if($thisRep != NULL) { array_push($publisherRightsArray, $thisRep); }
		} // end for
	} // end if $publisherRightsList

	// get repetitions from reviewer rights list and store in array
	$reviewerRightsList 	= $dashboardRecord->getField('publisherRightsReviewerRights');
	if($reviewerRightsList != NULL)
	{
		$reviewerRightsArray = array();
		$numReps = 12;
		for($rrr = 0; $rrr <= $numReps; $rrr++)
		{
			$thisRep = $dashboardRecord->getField('publisherRightsReviewerRights', $rrr);
			if($thisRep != NULL) { array_push($reviewerRightsArray, $thisRep); }
		} // end for
	} // end if $reviewerRightsList
} // end if $thisPage == 'publisher-rights.php'

// AWARDS MAIN PAGE
if($thisPage == 'awards.php')
{
	$awardsHeader				= $dashboardRecord->getField('awardsHeader');
	$awardsSubheader			= $dashboardRecord->getField('awardsSubheader');
	$bolognaPreviewHeader		= $dashboardRecord->getField('bolognaPreviewHeader');
	$bolognaPreviewText			= $dashboardRecord->getField('bolognaPreviewText');
	$bolognaPreviewImg			= $dashboardRecord->getField('bolognaPreviewImg');
	$kapisPreviewHeader			= $dashboardRecord->getField('kapisPreviewHeader');
	$kapisPreviewText			= $dashboardRecord->getField('kapisPreviewText');
	$kapisPreviewImg			= $dashboardRecord->getField('kapisPreviewImg');
	
	// DEFAULTS
	if($awardsHeader == NULL) 			{ $awardsHeader 		= 'Awards'; }
	if($bolognaPreviewHeader == NULL) 	{ $bolognaPreviewHeader = 'BolognaRagazzi Digital Award'; }
	if($kapisPreviewHeader == NULL) 	{ $kapisPreviewHeader 	= 'KAPi Awards'; }
} // end if $thisPage == 'awards.php'

// BOLOGNA MAIN PAGE
if($thisPage == 'bolognaragazzi.php' or $thisPage == 'award.php')
{
	$bolognaHeader 		= $dashboardRecord->getField('bolognaHeader');
	if($bolognaHeader == NULL) { $bolognaHeader = 'BolognaRagazzi Digital Award'; } // default header if null
	$bolognaSubheader 	= $dashboardRecord->getField('bolognaSubheader');
	$bolognaDeadline	= $dashboardRecord->getField('bolognaDeadline');
	$bolognaLink		= $dashboardRecord->getField('bolognaLink');
	$bolognaText		= $dashboardRecord->getField('bolognaText');
	$bolognaAddress		= $dashboardRecord->getField('bolognaAddress');
	$bolognaPhone		= $dashboardRecord->getField('bolognaPhone');
	$bolognaEmail		= $dashboardRecord->getField('bolognaEmail');
	$numBolognaImgs		= 0;
	$bolognaImg1		= $dashboardRecord->getField('bolognaImg1');
	$bolognaImg2		= $dashboardRecord->getField('bolognaImg2');
	$bolognaImg3		= $dashboardRecord->getField('bolognaImg3');
	if($bolognaImg1 != NULL) { $numBolognaImgs += 1; }
	if($bolognaImg2 != NULL) { $numBolognaImgs += 1; }
	if($bolognaImg3 != NULL) { $numBolognaImgs += 1; }
} // end if $thisPage == 'bolognaragazzi.php'

// KAPIS MAIN PAGE
if($thisPage == 'kapis.php' or $thisPage == 'award.php')
{
	$kapisHeader 		= $dashboardRecord->getField('kapisHeader');
	if($kapisHeader == NULL) { $kapisHeader = 'KAPi Awards'; } // default header if null
	$kapisSubheader 	= $dashboardRecord->getField('kapisSubheader');
	$kapisDeadline		= $dashboardRecord->getField('kapisDeadline');
	$kapisLink			= $dashboardRecord->getField('kapisLink');
	$kapisText			= $dashboardRecord->getField('kapisText');
	$kapisAddress		= $dashboardRecord->getField('kapisAddress');
	$kapisPhone			= $dashboardRecord->getField('kapisPhone');
	$kapisEmail			= $dashboardRecord->getField('kapisEmail');
	$numKapisImgs		= 0;
	$kapisImg1			= $dashboardRecord->getField('kapisImg1');
	$kapisImg2			= $dashboardRecord->getField('kapisImg2');
	$kapisImg3			= $dashboardRecord->getField('kapisImg3');
	if($kapisImg1 != NULL) { $numKapisImgs += 1; }
	if($kapisImg2 != NULL) { $numKapisImgs += 1; }
	if($kapisImg3 != NULL) { $numKapisImgs += 1; }
	$kapisAboutLDT		= $dashboardRecord->getField('kapisAboutLDT');
	$kapisAboutCTR		= $dashboardRecord->getField('kapisAboutCTR');
} // end if $thisPage == 'kapis.php'

// ABOUT THE RATINGS
if($thisPage == 'ratings.php')
{
	$ratingsHeader 			= $dashboardRecord->getField('aboutRatingsHeader');
	$ratingsSubheader 		= $dashboardRecord->getField('aboutRatingsSubheader');
	
	$ratingsIntroText 		= $dashboardRecord->getField('aboutRatingsIntroText');
	$ratingsIntroImg 		= $dashboardRecord->getField('aboutRatingsIntroImg');
	$ratingsIntroImgData 	= $dashboardRecord->getField('aboutRatingsIntroImgData');
	$ratingsIntroImgCaption = $dashboardRecord->getField('aboutRatingsIntroImgCaption');
	$ratingsIntroImgURL 	= $dashboardRecord->getField('aboutRatingsIntroImgURL');
	if($ratingsIntroImgURL) { $ratingsIntroImgURL = convertURL($ratingsIntroImgURL); }
	if($ratingsIntroImg != NULL and $ratingsIntroImgData != '?') 	{ $ratingsIntroImgExists = true; } 	else { $ratingsIntroImgExists = ''; }
	
	$ratingsNotesHeader		= $dashboardRecord->getField('aboutRatingsNotesHeader');
	$ratingsNotesText 		= $dashboardRecord->getField('aboutRatingsNotesText');
	$ratingsNotesItems 		= getListItems($dashboardRecord, 'aboutRatingsNotesItems', 20);
	$ratingsNotesImg 		= $dashboardRecord->getField('aboutRatingsNotesImg');
	$ratingsNotesImgData 	= $dashboardRecord->getField('aboutRatingsNotesImgData');
	$ratingsNotesImgCaption = $dashboardRecord->getField('aboutRatingsNotesImgCaption');
	$ratingsNotesImgURL 	= $dashboardRecord->getField('aboutRatingsNotesImgURL');
	if($ratingsNotesImgURL) { $ratingsNotesImgURL = convertURL($ratingsNotesImgURL); }
	if($ratingsNotesImg != NULL and $ratingsNotesImgData != '?') 	{ $ratingsNotesImgExists = true; } 	else { $ratingsNotesImgExists = ''; }
	
	$ratingsVideoURL 		= $dashboardRecord->getField('aboutRatingsVideoURL');
	$ratingsVideoLabel 		= $dashboardRecord->getField('aboutRatingsVideoLabel');
	
	$ratingsArticlesHeader 			= $dashboardRecord->getField('aboutRatingsArticlesHeader');
	$ratingsArticlesSubheaders 		= getListItems($dashboardRecord, 'aboutRatingsArticlesSubheaders', 5);
	$ratingsArticlesLinks	 		= getListItems($dashboardRecord, 'aboutRatingsArticlesLinks', 5);
	$ratingsArticlesDescriptions	= getListItems($dashboardRecord, 'aboutRatingsArticlesDescriptions', 5);
	
	$ratingsStrongText 		= $dashboardRecord->getField('aboutRatingsStrongText');
	$ratingsStrongImg 		= $dashboardRecord->getField('aboutRatingsStrongImg');
	$ratingsStrongImgData 	= $dashboardRecord->getField('aboutRatingsStrongImgData');
	$ratingsStrongImgCaption= $dashboardRecord->getField('aboutRatingsStrongImgCaption');
	$ratingsStrongImgURL 	= $dashboardRecord->getField('aboutRatingsStrongImgURL');
	if($ratingsStrongImgURL) { $ratingsStrongImgURL = convertURL($ratingsStrongImgURL); }
	if($ratingsStrongImg != NULL and $ratingsStrongImgData != '?') 	{ $ratingsStrongImgExists = true; } else { $ratingsStrongImgExists = ''; }
	
	$ratingsInstrumentHeader= $dashboardRecord->getField('aboutRatingsInstrumentHeader');
	$ratingsInstrumentKey	= $dashboardRecord->getField('aboutRatingsInstrumentKey');
	
	$ratingsInstrumentQA1Header 		= $dashboardRecord->getField('aboutRatingsInstrumentQA1Header');
	$ratingsInstrumentQA1Description 	= $dashboardRecord->getField('aboutRatingsInstrumentQA1Description');
	$ratingsInstrumentQA1Items 			= getListItems($dashboardRecord, 'aboutRatingsInstrumentQA1Items', 15);
	
	$ratingsInstrumentQA2Header 		= $dashboardRecord->getField('aboutRatingsInstrumentQA2Header');
	$ratingsInstrumentQA2Description 	= $dashboardRecord->getField('aboutRatingsInstrumentQA2Description');
	$ratingsInstrumentQA2Items 			= getListItems($dashboardRecord, 'aboutRatingsInstrumentQA2Items', 15);
	
	$ratingsInstrumentQA3Header 		= $dashboardRecord->getField('aboutRatingsInstrumentQA3Header');
	$ratingsInstrumentQA3Description 	= $dashboardRecord->getField('aboutRatingsInstrumentQA3Description');
	$ratingsInstrumentQA3Items 			= getListItems($dashboardRecord, 'aboutRatingsInstrumentQA3Items', 15);
	
	$ratingsInstrumentQA4Header 		= $dashboardRecord->getField('aboutRatingsInstrumentQA4Header');
	$ratingsInstrumentQA4Description 	= $dashboardRecord->getField('aboutRatingsInstrumentQA4Description');
	$ratingsInstrumentQA4Items 			= getListItems($dashboardRecord, 'aboutRatingsInstrumentQA4Items', 15);
	
	$ratingsInstrumentQA5Header 		= $dashboardRecord->getField('aboutRatingsInstrumentQA5Header');
	$ratingsInstrumentQA5Description 	= $dashboardRecord->getField('aboutRatingsInstrumentQA5Description');
	$ratingsInstrumentQA5Items 			= getListItems($dashboardRecord, 'aboutRatingsInstrumentQA5Items', 15);
	
	$ratingsInstrumentQA6Header 		= $dashboardRecord->getField('aboutRatingsInstrumentQA6Header');
	$ratingsInstrumentQA6Description 	= $dashboardRecord->getField('aboutRatingsInstrumentQA6Description');
	
	$ratingsProcedureHeader		= $dashboardRecord->getField('aboutRatingsProcedureHeader');
	$ratingsProcedureText 		= $dashboardRecord->getField('aboutRatingsProcedureText');
	
	$ratingsCTREXUserHeader		= $dashboardRecord->getField('aboutRatingsCTREXUserHeader');
	$ratingsCTREXUserDescription= $dashboardRecord->getField('aboutRatingsCTREXUserDescription');
	$ratingsCTREXUserItems	 	= getListItems($dashboardRecord, 'aboutRatingsCTREXUserItems', 5);
	
} // end if $thisPage == 'ratings.php'

// EDITORIAL CALENDAR
if($thisPage == 'editorial-calendar.php')
{
	$edCalHeader 			= $dashboardRecord->getField('editorialCalendarHeader');
	$edCalSubheader 		= $dashboardRecord->getField('editorialCalendarSubheader');
	$edCalIntroText 		= $dashboardRecord->getField('editorialCalendarIntroText');
	$edCalMonth01 			= $dashboardRecord->getField('editorialCalendar01');
	$edCalMonth02 			= $dashboardRecord->getField('editorialCalendar02');
	$edCalMonth03 			= $dashboardRecord->getField('editorialCalendar03');
	$edCalMonth04 			= $dashboardRecord->getField('editorialCalendar04');
	$edCalMonth05 			= $dashboardRecord->getField('editorialCalendar05');
	$edCalMonth06 			= $dashboardRecord->getField('editorialCalendar06');
	$edCalMonth07 			= $dashboardRecord->getField('editorialCalendar07');
	$edCalMonth08 			= $dashboardRecord->getField('editorialCalendar08');
	$edCalMonth09 			= $dashboardRecord->getField('editorialCalendar09');
	$edCalMonth10 			= $dashboardRecord->getField('editorialCalendar10');
	$edCalMonth11 			= $dashboardRecord->getField('editorialCalendar11');
	$edCalMonth12 			= $dashboardRecord->getField('editorialCalendar12');
	$edCalMonths = array
	(
		array('JANUARY'		, $edCalMonth01),
		array('FEBRUARY'	, $edCalMonth02),
		array('MARCH'		, $edCalMonth03),
		array('APRIL'		, $edCalMonth04),
		array('MAY'			, $edCalMonth05),
		array('JUNE'		, $edCalMonth06),
		array('JULY'		, $edCalMonth07),
		array('AUGUST'		, $edCalMonth08),
		array('SEPTEMBER'	, $edCalMonth09),		
		array('OCTOBER'		, $edCalMonth10),
		array('NOVEMBER'	, $edCalMonth11),
		array('DECEMBER'	, $edCalMonth12)
	);
	$edCalConclusionText 	= $dashboardRecord->getField('editorialCalendarConclusionText');
} // end if $thisPage == 'editorial-calendar'

// EDITORIAL GUIDELINES
if($thisPage == 'editorial-guidelines.php')
{
	$edGuidelinesHeader 		= $dashboardRecord->getField('editorialGuidelinesHeader');
	$edGuidelinesSubheader 		= $dashboardRecord->getField('editorialGuidelinesSubheader');
	$edGuidelinesIntroText 		= $dashboardRecord->getField('editorialGuidelinesIntroText');
	
	$edGuidelinesBiasHeader 	= $dashboardRecord->getField('editorialGuidelinesBiasHeader');
	$edGuidelinesBiasText 		= $dashboardRecord->getField('editorialGuidelinesBiasText');
	$edGuidelinesBiasItems	 	= getListItems($dashboardRecord, 'editorialGuidelinesBiasItems', 6);
	$numBiasItems 				= count($edGuidelinesBiasItems);
	
	$edGuidelinesGiftsHeader 	= $dashboardRecord->getField('editorialGuidelinesGiftsHeader');
	$edGuidelinesGiftsText 		= $dashboardRecord->getField('editorialGuidelinesGiftsText');
	$edGuidelinesGiftsItems	 	= getListItems($dashboardRecord, 'editorialGuidelinesGiftsItems', 6);
	$numGiftsItems				= count($edGuidelinesGiftsItems);
	
	$edGuidelinesPRHeader 		= $dashboardRecord->getField('editorialGuidelinesPRHeader');
	$edGuidelinesPRText 		= $dashboardRecord->getField('editorialGuidelinesPRText');
	$edGuidelinesPRItems	 	= getListItems($dashboardRecord, 'editorialGuidelinesPRItems', 6);
	$numPRItems					= count($edGuidelinesPRItems);
	
	$edGuidelinesConsultingHeader 	= $dashboardRecord->getField('editorialGuidelinesConsultingHeader');
	$edGuidelinesConsultingText 	= $dashboardRecord->getField('editorialGuidelinesConsultingText');
	$edGuidelinesConsultingItems	= getListItems($dashboardRecord, 'editorialGuidelinesConsultingItems', 6);
	$numConsultingItems				= count($edGuidelinesConsultingItems);
} // end if $thisPage == 'editorial-guidelines'

// STUDENT DISCOUNTS
if($thisPage == 'student.php')
{
	$studentDiscountText = $dashboardRecord->getField('studentDiscountText');
	if($studentDiscountText == NULL)
	{
		$studentDiscountText = 'Graduate and undergraduate students are entitled to CTREX subscriptions at a discounted rate of $9.99/yr (normally $60/year).<br/>
		Enter a valid .edu email address to receive a promo code you can enter <a href = "promocode.php" title = "Promo code entry page">here</a> to access the secure order form.';
	} // end if $studentDiscountText == NULL
	else { $studentDiscountText = nl2br($studentDiscountText); }
} // end if $thisPage == 'student.php'

// FROM THE EDITOR
if($thisPage == 'from-the-editor.php')
{
	// HEADER, SUBHEADER, INTRO
	$feHeader 			= $dashboardRecord->getField('fromEditorHeader');
	if($feHeader == NULL) { $feHeader = 'From the Editor'; }
	$feSubheader		= $dashboardRecord->getField('fromEditorSubheader');
	$feIntro			= $dashboardRecord->getField('fromEditorIntro');
	
	// EDITOR IMG
	$feEditorImg		= $dashboardRecord->getField('fromEditorImg');
	$feEditorImgData	= $dashboardRecord->getField('fromEditorImgData');
	$feEditorImgURL		= $dashboardRecord->getField('fromEditorImgURL');
	$feEditorImgCaption	= $dashboardRecord->getField('fromEditorImgCaption');
	
	// OVERVIEW BULLET POINTS
	$feOverview	= getListItems($dashboardRecord, 'fromEditorOverview', 12);
	
	// FREE ISSUE
	$feFreeIssue 		= $dashboardRecord->getField('fromEditorFreeIssue');
	$feFreeIssueText 	= $dashboardRecord->getField('fromEditorFreeIssueText');
	$feFreeIssueURL 	= $dashboardRecord->getField('fromEditorFreeIssueURL');
	
	// CONCLUSION
	$feConclusion		= $dashboardRecord->getField('fromEditorConclusion');
	
	// SIGNATURE
	$feSigImg			= $dashboardRecord->getField('fromEditorSigImg');
	$feSigImgData		= $dashboardRecord->getField('fromEditorSigImgData');
	$feSigImgURL		= $dashboardRecord->getField('fromEditorSigImgURL');
	$feSigText			= $dashboardRecord->getField('fromEditorSigText');
	
	// FOOTNOTES
	$feFootnotes		= $dashboardRecord->getField('fromEditorFootnotes');
	
	// CREATIVE COMMONS
	$feCCImg			= $dashboardRecord->getField('fromEditorCCImg');
	$feCCImgData		= $dashboardRecord->getField('fromEditorCCImgData');
	$feCCImgURL			= $dashboardRecord->getField('fromEditorCCImgURL');
	$feCCText			= $dashboardRecord->getField('fromEditorCCText');
	
} // end if $thisPage == 'from-the-editor.php'

// STAFF
if($thisPage == 'staff.php')
{
	// HEADER, INTRO
	$staffHeader	= $dashboardRecord->getField('staffHeader');
	if($staffHeader == NULL) { $staffHeader = 'Staff'; }
	$staffIntro		= $dashboardRecord->getField('staffIntro');
	
	// EDITOR
	$staffEditorActive = $dashboardRecord->getField('staffEditorActive');
	if($staffEditorActive != NULL)
	{
		$staffEditorName		= $dashboardRecord->getField('staffEditorName');
		$staffEditorBio			= $dashboardRecord->getField('staffEditorBio');
		$staffEditorImg			= $dashboardRecord->getField('staffEditorImg');
		$staffEditorImgData		= $dashboardRecord->getField('staffEditorImgData');
		$staffEditorImgURL		= $dashboardRecord->getField('staffEditorImgURL');
		$staffEditorImgCaption	= $dashboardRecord->getField('staffEditorImgCaption');
	} // end if $staffEditorActive
	
	// DIRECTOR OF PUBLISHING
	$staffCodeActive = $dashboardRecord->getField('staffCodeActive');
	if($staffCodeActive != NULL)
	{
		$staffCodeName			= $dashboardRecord->getField('staffCodeName');
		$staffCodeBio			= $dashboardRecord->getField('staffCodeBio');
		$staffCodeImg			= $dashboardRecord->getField('staffCodeImg');
		$staffCodeImgData		= $dashboardRecord->getField('staffCodeImgData');
		$staffCodeImgURL		= $dashboardRecord->getField('staffCodeImgURL');
		$staffCodeImgCaption	= $dashboardRecord->getField('staffCodeImgCaption');
	} // end if $staffCodeActive
	
	// CIRCULATION MANAGER
	$staffCircActive = $dashboardRecord->getField('staffCircActive');
	if($staffCircActive != NULL)
	{
		$staffCircName			= $dashboardRecord->getField('staffCircName');
		$staffCircBio			= $dashboardRecord->getField('staffCircBio');
		$staffCircImg			= $dashboardRecord->getField('staffCircImg');
		$staffCircImgData		= $dashboardRecord->getField('staffCircImgData');
		$staffCircImgURL		= $dashboardRecord->getField('staffCircImgURL');
		$staffCircImgCaption	= $dashboardRecord->getField('staffCircImgCaption');
	} // end if $staffCircActive
	
	// TREASURER
	$staffTreasurerActive = $dashboardRecord->getField('staffTreasurerActive');
	if($staffTreasurerActive != NULL)
	{
		$staffTreasurerName			= $dashboardRecord->getField('staffTreasurerName');
		$staffTreasurerBio			= $dashboardRecord->getField('staffTreasurerBio');
		$staffTreasurerImg			= $dashboardRecord->getField('staffTreasurerImg');
		$staffTreasurerImgData		= $dashboardRecord->getField('staffTreasurerImgData');
		$staffTreasurerImgURL		= $dashboardRecord->getField('staffTreasurerImgURL');
		$staffTreasurerImgCaption	= $dashboardRecord->getField('staffTreasurerImgCaption');
	} // end if $staffTreasurerActive
	
} // end if $thisPage == 'staff.php'

// FAQ
if($thisPage == 'faq.php')
{
	// HEADER, SUBHEADER
	$faqHeader		= $dashboardRecord->getField('faqHeader');
	if($faqHeader == NULL) { $faqHeader = 'FAQ'; }
	$faqSubheader	= $dashboardRecord->getField('faqSubheader');
	
	// IMG
	$faqImg			= $dashboardRecord->getField('faqImg');
	$faqImgData		= $dashboardRecord->getField('faqImgData');
	$faqImgURL		= $dashboardRecord->getField('faqImgURL');
	$faqImgCaption	= $dashboardRecord->getField('faqImgCaption');
	
	// Q & A ITEMS
	$faqQuestions	= getListItems($dashboardRecord, 'faqQs', 20);
	$faqAnswers		= getListItems($dashboardRecord, 'faqAs', 20);
	
	// CONCLUSION
	$faqConclusion	= $dashboardRecord->getField('faqConclusion');
	
} // end if $thisPage == 'faq.php'

// PHILOSOPHY
if($thisPage == 'philosophy.php')
{
	$philosophyHeader 	= $dashboardRecord->getField('philosophyHeader');
	if($philosophyHeader == NULL) { $philosophyHeader = 'Philosophy'; }
	$philosophyText		= $dashboardRecord->getField('philosophyText');
} // end if $thisPage == 'philosophy.php'

// DISCLOSURES
if($thisPage == 'disclosures.php')
{
	$disclosuresHeader 				= $dashboardRecord->getField('disclosuresHeader');
	$disclosuresIntro 				= $dashboardRecord->getField('disclosuresIntro');
	$disclosuresIncomeItems 		= getListItems($dashboardRecord, 'disclosuresIncomeItems', 10);
	$disclosuresIncomeDescriptions 	= getListItems($dashboardRecord, 'disclosuresIncomeDescriptions', 10);
	$disclosuresRelHeader 			= $dashboardRecord->getField('disclosuresRelHeader');
	$disclosuresRelItems 			= getListItems($dashboardRecord, 'disclosuresRelItems', 5);
	$disclosuresConclusion 			= $dashboardRecord->getField('disclosuresConclusion');
	$disclosuresDateModified 		= $dashboardRecord->getField('disclosuresDateModified');
} // end if $thisPage == 'disclosures.php'

// SPONSORS
if($thisPage == 'sponsors.php')
{
	$sponsorsHeader = $dashboardRecord->getField('sponsorsHeader');
	$sponsorsText 	= $dashboardRecord->getField('sponsorsText');
	if($sponsorsHeader == NULL) { $sponsorsHeader = 'Support Our Mission'; }
	if($sponsorsText == NULL)	{ $sponsorsText = 'CTREX Sponsors Page: Under Construction'; }
	$showSponsors	= $dashboardRecord->getField('showSponsors');
} // end if $thisPage == 'sponsors.php'

// SUPPORTERS
if($thisPage == 'supporters.php')
{
	$showSupporters = $dashboardRecord->getField('showSupporters');
} // end f $thisPage == 'supporters.php'

// EXPERTS
if($thisPage == 'experts.php')
{
	$showExperts 	= $dashboardRecord->getField('showExperts');
	$showStudents 	= $dashboardRecord->getField('showStudents');
	$showJurorsBRDA = $dashboardRecord->getField('showJurorsBRDA');
	$showJurorsKAPI = $dashboardRecord->getField('showJurorsKAPI');
} // end if $thisPage == 'experts.php'
?>