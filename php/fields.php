<?php
// REVIEW FIELDS
$reviewFields = array
(
	array('thumbdata', 'thumbData'),
	array('thumbnail', 'thumbnail'),
	array('imgCount', 'imgCount'),
	
	array('reviewnumber', 'reviewnumber'),
	array('dateEntered', 'Date of Review'),
	array('title', 'Title'),
	
	array('published', 'published'),
	
	array('numProducers', 'numProducers'),
	array('company', 'Company'),
	array('producer', 'Producers::Company Name'),
	array('copyright', 'Copyright Date'),
	array('publisherWebsite', 'websiteParsed'),
	
	array('price', 'Price'),
	array('platforms', 'platform text'),
	array('filesize', 'fileSize'),
	
	array('ages', 'Age Range'),
	array('grades', 'Grade Level'),
	array('subjects', 'teaches text'),
	array('topics', 'recommendations text'),
	
	array('languageList', 'Language List'),
	array('languageText', 'Language Text'),
	array('languageNotes', 'Language Notes'),
	array('scaffoldingList', 'Scaffolding List'),
	array('scaffoldingText', 'Scaffolding Text'),
	
	array('reviewType', 'Feature review'),
	array('weekly', 'weekly'),
	array('issue', 'issueAbbr'),
	array('entered', 'Date of Review'),
	
	array('author', 'author'),
	array('authorID', 'subsScreenName::globalID'),
	array('authorName', 'subsScreenName::fullName'),
	array('authorShare', 'subsScreenName::share'),
	
	array('editor', 'edited'),
	array('editorID', 'subsEditor::globalID'),
	array('editorName', 'subsEditor::fullName'),
	array('editorShare', 'subsEditor::share'),
	
	array('reviewText', 'Web Site Comments Field'),
	array('editorialNotes', 'clipboard'),
	
	array('rubricUsed', 'rubric'),
	array('rubricsSelected', 'rubrics'),
	array('rubricsText', 'rubricsText'),
	array('numRubricsSelected', 'rubricsCount'),
	
	array('numberOverallRating', 'standardStars'),
	array('ptsPossible', 'rubricWeightTotal'),
	array('standardScore', 'standardScore'),
	array('rubricScore', 'rubricScore'),
	array('rubricStars', 'rubricStars'),
	array('edChoice', 'edChoice'),
	array('ethical', 'ethical'),
	
	array('linkItunes', 'itunes code'),
	array('linkAndroid', 'Android code'),
	array('linkAmazon', 'amazon'),
	array('linkSteam', 'steam code'),
	array('linkVideo', 'video'),
	
	array('commentCount', 'commentCount'),
	array('commentCountText', 'commentCountText'),
	array('expertReviewCount', 'expertReviewCount'),
	
	array('bolognaYear', 'bolognaYear'),
	array('bolognaType', 'bolognaType'),
	array('bolognaGenre', 'bolognacategory'),
	
	array('kapiYear', 'kapiYear'),
	array('kapiType', 'kapiType'),
	array('kapiAward', 'kapiAward'),
);

// get the full images 1-3 for the review page
if($pageType == 'review' or $pageType == 'zoom' or $pageType == 'editorial')
{
	array_push($reviewFields, array('image1'	, 'Sample Screen'));
	array_push($reviewFields, array('image1Data', 'imgData'));
	array_push($reviewFields, array('image2'	, 'sample screen2'));
	array_push($reviewFields, array('image2Data', 'img2Data'));
	array_push($reviewFields, array('image3'	, 'Image3'));
	array_push($reviewFields, array('image3Data', 'img3Data'));
}
$relatedProducerFields = array
(
	array('producer', 'Producers::Company Name'),
	array('dup', 'Producers::dup'),
	array('companyID', 'Producers::recordID'),
);

$relatedCommentFields = array
(
	array('postID'					, 'comments::commentID'),
	array('postDate'				, 'comments::date'),
	array('postTime'				, 'comments::time'),
	
	array('postAuthorUsertype'		, 'comments::usertype'),
	array('postAuthorDisplayName'	, 'comments::displayName'),
	array('postAuthorUserID'		, 'comments::userID'),
	array('postAuthorPublisherID'	, 'comments::publisherID'),
	array('postAuthorSiteName'		, 'comments::siteName'),
	array('postAuthorOrgName'		, 'comments::orgName'),
	array('postAuthorShare'			, 'comments::profileShare'),
	
	array('postComment'				, 'comments::comment'),
	array('postRating'				, 'comments::rating'),
	array('postRubric'				, 'comments::rubric'),	
	array('postRubricType'			, 'comments::rubricType'),
	array('postRubricID'			, 'comments::rubricID')
);

$relatedExpertReviewFields = array
(
	array('postID'					, 'expertreviews::expertReviewID'),
	array('postDate'				, 'expertreviews::submissionDate'),
	array('postTime'				, 'expertreviews::submissionTime'),
	
	array('postAuthorUsertype'		, 'expertreviews::authorType'),
	array('postAuthorUserID'		, 'expertreviews::reviewerID'),
	array('postAuthorUsername'		, 'expertreviews::reviewerUsername'),
	array('postAuthorFullName'		, 'expertreviews::reviewerName'),
	array('postAuthorScreenName'	, 'expertreviews::reviewerScreenName'),
	array('postAuthorScreenNameD'	, 'expertreviews::reviewerScreenNameDefault'),
	
	array('postComment'				, 'expertreviews::review'),
	array('postRating'				, 'expertreviews::rating'),
	array('postRubric'				, 'expertreviews::rubric'),
	array('postRubricType'			, 'expertreviews::rubricType'),
	array('postRubricID'			, 'expertreviews::rubricID')
);

// SUBSCRIBER FIELDS
$subscriberFields = array
(
	array('recordID'		, 'globalID'), 
	
	array('screenNameD'		, 'screenNameDefault'), 
	array('screenName'		, 'screenName'),
	array('share'			, 'share'), 
	
	array('temp'			, 'temp'), 
	array('mod'				, 'moderator'), 
	array('expert'			, 'expert'), 
	array('student'			, 'student'),
	array('juror'			, 'juror'),
	array('jurorType'		, 'jurorType'),
	array('jurorNumber'		, 'jurorNumber'),
	array('recordExpert'	, 'expert'),
	array('siteAdmin'		, 'siteAdmin'),
	
	array('ctrexUsername'	, 'ctrexUsername'), 
	array('password'		, 'ctrexPassword'), 
	array('startDate'		, 'startDate'), 
	array('expDate'			, 'expDate'), 
	
	array('fname'			, 'Contact First Name'),
	array('lname'			, 'Contact Last Name'), 
	array('fullName'		, 'fullName'),
	array('email'			, 'EMail'),
	array('addressStreet'	, 'Address'),
	array('addressCity'		, 'City'),
	array('addressState'	, 'State'),
	array('addressZip'		, 'Zip'),
	array('addressCountry'	, 'Country'),
	array('phone1'			, 'PhoneOne'),
	array('phone2'			, 'PhoneTwo'),
	array('fax'				, 'Fax'),
	
	array('organization'	, 'Company Name'),
	array('jobTitle'		, 'Contact Title'),
	array('publicEmail'		, 'publicEmail'),
	array('publicPhone'		, 'publicPhone'),
	array('publicWebsite'	, 'publicWebsiteParsed'),
	array('publicFacebook'	, 'publicFacebookParsed'),
	array('publicTwitter'	, 'publicTwitterParsed'),
	array('publicYouTube'	, 'publicYouTubeParsed'),
	array('publicInstagram'	, 'publicInstagramParsed'),
	array('publicPinterest'	, 'publicPinterestParsed'),
	array('publicLinkedIn'	, 'publicLinkedInParsed'),
	
	array('sendProductsTo'	, 'sendProductsTo'),
	array('expertSpecialty'	, 'expertSpecialty'),
	array('expertBias'		, 'expertBias'),
	
	array('bio'				, 'bio'),
	array('bio2'			, 'bio2'),
	array('photo'			, 'photo'),
	array('photoW'			, 'photoW'),
	array('photoH'			, 'photoH'),
	
	array('numSavedSearches'	, 'countSavedSearches'),
	array('numSavedBookmarks'	, 'countSavedBookmarks'),
	array('numSavedRubrics'		, 'countSavedRubrics'),
	array('numBookmarkFolders'	, 'countFolders'),
	array('numSavedTags'		, 'numTags'),
	array('numSavedCollections'	, 'numCollections'),
	array('numSavedCollectionItems', 'numCollectionItems'),
	
	array('numExpertReviews', 'numExpertReviews'),
	array('numCSRreviews'	, 'numCSRreviews'),
	
	array('siteName'			, 'orgs::siteName'),
	array('siteOrg'				, 'orgs::orgName'),
	array('siteStatus'			, 'orgs::licenseStatus'),
	array('siteStartDate'		, 'orgs::startDate'),
	array('siteExpDate'			, 'orgs::expDate'),
	array('portal'				, 'orgs::portalURL'),
	array('portalParsed'		, 'orgs::portalParsed'),
	array('ipRange'				, 'orgs::ipRange'), 
	array('fte'					, 'orgs::fteSize'),
	array('siteViewCount'		, 'orgs::patronViewCount'),
	array('siteEmail'			, 'orgs::email'),
	array('siteAddressStreet'	, 'orgs::addressStreet'),
	array('siteAddressCity'		, 'orgs::addressCity'),
	array('siteAddressState'	, 'orgs::addressState'),
	array('siteAddressZip'		, 'orgs::addressZip'),
	array('siteAddressCountry'	, 'orgs::addressCountry'),
	array('sitePhone1'			, 'orgs::phone1'),
	array('sitePhone2'			, 'orgs::phone2'),
	array('siteFax'				, 'orgs::fax'),
	
);

// LICENSE FIELDS
$licenseFields = array
(
	array('siteName'			, 'siteName'),
	array('siteOrg'				, 'orgName'),
	array('siteStatus'			, 'licenseStatus'),
	array('siteStartDate'		, 'startDate'),
	array('siteExpDate'			, 'expDate'),
	array('portal'				, 'portalURL'),
	array('portalParsed'		, 'portalParsed'),
	array('ipRange'				, 'siteIP'), 
	array('fte'					, 'fteSize'),
	array('siteViewCount'		, 'patronViewCount'),
	array('siteEmail'			, 'email'),
	array('siteAddressStreet'	, 'addressStreet'),
	array('siteAddressCity'		, 'addressCity'),
	array('siteAddressState'	, 'addressState'),
	array('siteAddressZip'		, 'addressZip'),
	array('siteAddressCountry'	, 'addressCountry'),
	array('sitePhone1'			, 'phone1'),
	array('sitePhone2'			, 'phone2'),
	array('siteFax'				, 'fax'),
	array('numAdmins'			, 'numAdmins')
);

// EXPERT FIELDS
$expertFields = array
(
	array('expertBio'		, 'bio'),
	array('expertSpecialty'	, 'expertSpecialty'),
	array('expertBias'		, 'expertBias'),
	array('sendProductsTo'	, 'sendProductsTo'),
	array('expertPhoto'		, 'photo'),
	array('expertPhotoW'	, 'photoW'),
	array('expertPhotoH'	, 'photoH'),
	array('expertFname'		, 'Contact First Name'),
	array('expertLname'		, 'Contact Last Name'),
	array('expertTitle'		, 'Contact Title'),
	array('expertCompany'	, 'Company Name'),
	array('expertUsername'	,	'ctrexUsername'),
	array('expertID'		, 'globalID')
);

// RUBRIC/QA FIELDS
$rubricFields 	= array
(
	array('rubric'		, 'rubric'),
	array('qaName'		, 'qa::name'),
	array('qaType'		, 'qa::type'),
	array('qaDescriptor', 'qa::descriptor'),
	array('qaField'		, 'qa::ratingField'),
	array('qaWeight'	, 'qa::ratingWeight'),
);
$relatedQAFields = array
(
	array('qaName'		, 'qa::name'),
	array('qaType'		, 'qa::type'),
	array('qaDescriptor', 'qa::descriptor'),
	array('qaField'		, 'qa::ratingField'),
	array('qaWeight'	, 'qa::ratingWeight'),
);
$qaFields 		= array
(
	array('qaName'		, 'name'),
	array('qaType'		, 'type'),
	array('qaDescriptor', 'descriptor'),
	array('qaField'		, 'ratingField'),
	array('qaWeight'	, 'ratingWeight'),
);

// RELATED SETS
$subscriberRelatedSets = array
(
	array('orgs'	, $licenseFields)
);
$rubricRelatedSets = array('qa', $qaFields);

// PUBLISHER FIELDS
$publisherFields = array
(
	array('companyID'			, 'recordID'),
	array('companyName'			, 'Company Name'),
	array('ctrexUsername'		, 'username'),
	array('ctrexPassword'		, 'password'),
	array('share'				, 'share'),
	array('contactFname'		, 'Contact First Name'),
	array('contactLname'		, 'Contact Last Name'),
	array('contactTitle'		, 'Contact Title'),
	array('contactEmail'		, 'EMail'),
	array('dateEntered'			, 'date created'),
	array('numTitlesReviewed'	, 'publishedCount'),
	array('numTitlesSubmitted'	, 'titleCount'),
	array('description'			, 'description'),
	array('linkLogo'			, 'logoURL'),
	array('linkLogoParsed'		, 'logoURLParsed'),
	array('linkWebsite'			, 'Web site'),
	array('linkWebsiteParsed'	, 'websiteParsed'),
	array('linkFacebook'		, 'facebookLink'),
	array('linkFacebookParsed'	, 'facebookParsed'),
	array('linkTwitter'			, 'twitterLink'),
	array('linkTwitterParsed'	, 'twitterParsed'),
	array('linkLinkedIn'		, 'linkedInLink'),
	array('linkLinkedInParsed'	, 'linkedInParsed'),
	array('linkInstagram'		, 'instagramLink'),
	array('linkInstagramParsed'	, 'instagramParsed'),
	array('linkPinterest'		, 'pinterestLink'),
	array('linkPinterestParsed'	, 'pinterestParsed'),
	array('linkYouTube'			, 'youtubeLink'),
	array('linkYouTubeParsed'	, 'youtubeParsed'),
	array('linkVideo'			, 'featuredVideo'),
	array('addressStreet'		, 'Address'),
	array('addressCity'			, 'City'),
	array('addressState'		, 'State'),
	array('addressZip'			, 'Zip'),
	array('addressCountry'		, 'Country'),
	array('phone1'				, 'PhoneOne'),
	array('phone2'				, 'PhoneTwo'),
	array('fax'					, 'Fax'),
	array('publicEmail1'		, 'publicEmail1'),
	array('publicEmail1Type'	, 'publicEmail1Type'),
	array('publicEmail2'		, 'publicEmail2'),
	array('publicEmail2Type'	, 'publicEmail2Type'),
	array('publicEmail3'		, 'publicEmail3'),
	array('publicEmail3Type'	, 'publicEmail3Type'),
	array('publicEmail4'		, 'publicEmail4'),
	array('publicEmail4Type'	, 'publicEmail4Type'),
	array('publicEmail5'		, 'publicEmail5'),
	array('publicEmail5Type'	, 'publicEmail5Type'),
);

$relatedTitleFields = array
(
	array('title'		, 'CSR::Title'),
	array('titleID'		, 'CSR::reviewnumber'),
	array('permalink'	, 'CSR::permalink'),
	array('published'	, 'CSR::published'),
	array('copyright'	, 'CSR::Copyright'),
	array('dateEntered'	, 'CSR::Date of Review'),
);
$relatedTitleFieldsArchive = array
(
	array('title'		, 'CSR::Title'),
	array('titleID'		, 'CSR::reviewnumber'),
	array('permalink'	, 'CSR::permalink'),
	array('published'	, 'CSR::published'),
	array('copyright'	, 'CSR::Copyright'),
	array('dateEntered'	, 'CSR::Date of Review'),
	array('titleImg'	, 'CSR::Sample Screen'),
	array('titleImgData', 'CSR::imgData'),
	array('edChoice'	, 'CSR::edChoice'),
	array('weeklySummary', 'CSR::weeklySummary'),
);

$monthlyFields = array
(
	array('archiveID'		, 'archiveID'),
	array('archiveDate'		, 'issueDateText'),
	array('monthlyAbbr'		, 'issueDateAbbr'),
	array('subject'			, 'subjectNotes'),
	array('volume'			, 'volume'),
	array('number'			, 'number'),
	array('issue'			, 'issueNumber'),
	array('intro'			, 'intro'),
	array('conclusion'		, 'conclusion'),
	array('linkPDF'			, 'issues::linkPDF'),
	array('linkPreview'		, 'issues::linkPreview'),
	array('linkThumb'		, 'issues::linkThumb'),
	array('linkLarge'		, 'issues::linkLarge'),
	array('linkSquare'		, 'issues::linkSquare'),
	array('numTitles'		, 'numTitles'),
);
$weeklyFields = array
(
	array('archiveID'		, 'archiveID'),
	array('archiveDate'		, 'weeklyDate'),
	array('weeklyMDY'		, 'weeklyMDY'),
	array('weeklyParam'		, 'weeklyParam'),
	array('subject'			, 'subjectNotes'),
	array('intro'			, 'intro'),
	array('conclusion'		, 'conclusion'),
	array('numTitles'		, 'numTitles'),
);
$articleFields = array
(
	array('title'	, 'title'),
	array('url'		, 'url')
);
$bookmarkFields = array
(
	array('bookmarkID'		, 'recordID'),
	
	array('folderID'		, 'folderID'),
	array('folderName'		, 'folderForBookmark::name'),
	
	array('collectionID'	, 'collectionID'),
	array('collectionName'	, 'collectionForBookmark::name'),
	
	array('ownerID'			, 'userID'),
	array('ownerUsername'	, 'subs::ctrexUsername'),
	
	array('reviewnumber'	, 'reviewID'),
	array('title'			, 'CSRbookmark::Title'),
	array('thumbdata'		, 'CSRbookmark::thumbData'),
	array('thumbnail'		, 'CSRbookmark::thumbnail'),
	array('dateEntered'		, 'CSRbookmark::Date of Review'),
	array('copyright'		, 'CSRbookmark::Copyright Date'),
	array('company'			, 'CSRbookmark::Company'),
	array('producer'		, 'CSRbookmark::producer'),
	array('companyID'		, 'CSRbookmark::producerID'),
	array('publisherWebsite', 'CSRbookmark::websiteParsed'),
	array('price'			, 'CSRbookmark::Price'),
	array('filesize'		, 'CSRbookmark::fileSize'),
	array('platforms'		, 'CSRbookmark::platform text'),
	array('subjects'		, 'CSRbookmark::teaches text'),
	array('languages'		, 'CSRbookmark::Language Text'),
	array('languageNotes'	, 'CSRbookmark::Language Notes'),
	array('scaffolding'		, 'CSRbookmark::Scaffolding Text'),
	array('ages'			, 'CSRbookmark::Age Range'),
	array('grades'			, 'CSRbookmark::Grade Level'),
	array('score'			, 'CSRbookmark::rubricScore'),
	array('rubricsSelected'	, 'CSRbookmark::rubrics'),
	array('rubricsText'		, 'CSRbookmark::rubricsText'),
	array('numRubricsSelected', 'CSRbookmark::rubricsCount'),
	array('edChoice'		, 'CSRbookmark::edChoice'),
	array('ethical'			, 'CSRbookmark::ethical'),
);
$dynamicTextFields = array
(
	array('textPageTitle'		, 'pageTitle'),
	array('textPageHeader'		, 'pageHeader'),
	array('textPageSubheader'	, 'pageSubheader'),
	
	array('textSection1'		, 'section01'),
	array('textSection1W'		, 'section01W'),
	array('textSection1Align'	, 'section01Align'),
	array('textImage1'			, 'image1'),
	array('textImage1W'			, 'image1W'),
	array('textImage1H'			, 'image1H'),
	array('textImage1Pos'		, 'image1Pos'),
	
	array('textSection2'		, 'section02'),
	array('textSection2W'		, 'section02W'),
	array('textSection2Align'	, 'section02Align'),
	array('textImage2'			, 'image2'),
	array('textImage2W'			, 'image2W'),
	array('textImage2H'			, 'image2H'),
	array('textImage2Pos'		, 'image2Pos'),
	
	array('textSection3'		, 'section03'),
	array('textSection3W'		, 'section03W'),
	array('textSection3Align'	, 'section03Align'),
	array('textImage3'			, 'image3'),
	array('textImage3W'			, 'image3W'),
	array('textImage3H'			, 'image3H'),
	array('textImage3Pos'		, 'image3Pos'),
	
	array('textSection4'		, 'section04'),
	array('textSection4W'		, 'section04W'),
	array('textSection4Align'	, 'section04Align'),
	array('textImage4'			, 'image4'),
	array('textImage4W'			, 'image4W'),
	array('textImage4H'			, 'image4H'),
	array('textImage4Pos'		, 'image4Pos'),
);
$bolognaFields = array
(
	array('bolognaYear'			, 'year'),
	array('pageHeader' 			, 'heading'),

	array('pdf'					, 'pdf'),
	array('pdfURL'				, 'pdfURL'),
	array('videoLink'			, 'videoLink'),
	array('fullListLink'		, 'fullListLink'),
	array('jurorsLink'			, 'jurorsLink'),
	
	array('leadImg'				, 'leadImg'),
	array('leadImgData'			, 'leadImgData'),
	array('leadImgURL'			, 'leadImgURL'),
	array('leadImgCaption'		, 'leadImgCaption'),
	
	array('introHeading'		, 'introHeading'),
	array('introText'			, 'introText'),
	array('introImg'			, 'introImg'),
	array('introImgData'		, 'introImgData'),
	array('introImgURL'			, 'introImgURL'),
	array('introImgCaption'		, 'introImgCaption'),
	
	array('atAGlance'			, 'atAGlance'),

	array('numTitles'			, 'numTitles'),
	
	array('winners1Heading'		, 'winnersHeading'),
	array('winners1Text'		, 'winnersDescription'),
	array('winners2Heading'		, 'winners2Heading'),
	array('winners2Text'		, 'winners2Description'),
	array('winnersImg'			, 'winnersImg'),
	array('winnersImgData'		, 'winnersImgData'),
	array('winnersImgURL'		, 'winnersImgURL'),
	array('winnersImgCaption'	, 'winnersImgCaption'),
	array('winnersExtra'		, 'winnersExtra'),

	array('mentions1Heading'	, 'mentionsHeading'),
	array('mentions1Text'		, 'mentionsDescription'),
	array('mentions2Heading'	, 'mentions2Heading'),
	array('mentions2Text'		, 'mentions2Description'),
	array('mentionsImg'			, 'mentionsImg'),
	array('mentionsImgData'		, 'mentionsImgData'),
	array('mentionsImgURL'		, 'mentionsImgURL'),
	array('mentionsImgCaption'	, 'mentionsImgCaption'),
	array('mentionsExtra'		, 'mentionsExtra'),

	array('shortListHeading'	, 'shortListHeading'),
	array('shortListText'		, 'shortListDescription'),
	array('shortListImg'		, 'shortListImg'),
	array('shortListImgData'	, 'shortListImgData'),
	array('shortListImgURL'		, 'shortListImgURL'),
	array('shortListImgCaption'	, 'shortListImgCaption'),
	array('shortListExtra'		, 'shortListExtra'),

	array('jurorsHeading'		, 'jurorsHeading'),
	array('jurorsText'			, 'jurorsDescription'),
	array('jurorsImg'			, 'jurorsImg'),
	array('jurorsImgData'		, 'jurorsImgData'),
	array('jurorsImgURL'		, 'jurorsImgURL'),
	array('jurorsImgCaption'	, 'jurorsImgCaption'),

	array('conclusionHeading'	, 'conclusionHeading'),
	array('conclusionText'		, 'conclusionText'),
	array('conclusionImg'		, 'conclusionImg'),
	array('conclusionImgData'	, 'conclusionImgData'),
	array('conclusionImgURL'	, 'conclusionImgURL'),
	array('conclusionImgCaption', 'conclusionImgCaption'),
);

$kapisFields = array
(
	array('kapiYear'			, 'year'),
	array('pageHeader' 			, 'heading'),
	
	array('pdfURL'				, 'pdfURL'),
	array('videoLink'			, 'videoLink'),
	array('fullListLink'		, 'fullListLink'),
	array('jurorsLink'			, 'jurorsLink'),
	
	array('leadImg'				, 'leadImg'),
	array('leadImgData'			, 'leadImgData'),
	array('leadImgURL'			, 'leadImgURL'),
	array('leadImgCaption'		, 'leadImgCaption'),
	
	array('introHeading'		, 'introHeading'),
	array('introText'			, 'introText'),
	array('introImg'			, 'introImg'),
	array('introImgData'		, 'introImgData'),
	array('introImgURL'			, 'introImgURL'),
	array('introImgCaption'		, 'introImgCaption'),

	array('numTitles'			, 'numTitles'),
	
	array('winners1Heading'		, 'winnersHeading'),
	array('winners1Text'		, 'winnersDescription'),
	array('winnersImg'			, 'winnersImg'),
	array('winnersImgData'		, 'winnersImgData'),
	array('winnersImgURL'		, 'winnersImgURL'),
	array('winnersImgCaption'	, 'winnersImgCaption'),
	array('winnersExtra'		, 'winnersExtra'),
	
	array('emergingPioneerName'			, 'emergingPioneerName'),
	array('emergingPioneerDescription'	, 'emergingPioneerDescription'),
	array('emergingPioneerImg'			, 'emergingPioneerImg'),
	array('emergingPioneerImgData'		, 'emergingPioneerImgData'),
	array('emergingPioneerImgURL'		, 'emergingPioneerImgURL'),
	array('emergingPioneerImgCaption'	, 'emergingPioneerImgCaption'),
	
	array('legendPioneerName'			, 'legendPioneerName'),
	array('legendPioneerDescription'	, 'legendPioneerDescription'),
	array('legendPioneerImg'			, 'legendPioneerImg'),
	array('legendPioneerImgData'		, 'legendPioneerImgData'),
	array('legendPioneerImgURL'			, 'legendPioneerImgURL'),
	array('legendPioneerImgCaption'		, 'legendPioneerImgCaption'),
	
	array('lifetimePioneerName'			, 'lifetimePioneerName'),
	array('lifetimePioneerDescription'	, 'lifetimePioneerDescription'),
	array('lifetimePioneerImg'			, 'lifetimePioneerImg'),
	array('lifetimePioneerImgData'		, 'lifetimePioneerImgData'),
	array('lifetimePioneerImgURL'		, 'lifetimePioneerImgURL'),
	array('lifetimePioneerImgCaption'	, 'lifetimePioneerImgCaption'),

	array('mentions1Heading'	, 'mentionsHeading'),
	array('mentions1Text'		, 'mentionsDescription'),
	array('mentionsImg'			, 'mentionsImg'),
	array('mentionsImgData'		, 'mentionsImgData'),
	array('mentionsImgURL'		, 'mentionsImgURL'),
	array('mentionsImgCaption'	, 'mentionsImgCaption'),
	array('mentionsExtra'		, 'mentionsExtra'),

	array('jurorsHeading'		, 'jurorsHeading'),
	array('jurorsText'			, 'jurorsDescription'),
	array('jurorsList'			, 'jurorsList'),
	array('jurorsImg'			, 'jurorsImg'),
	array('jurorsImgData'		, 'jurorsImgData'),
	array('jurorsImgURL'		, 'jurorsImgURL'),
	array('jurorsImgCaption'	, 'jurorsImgCaption'),

	array('conclusionHeading'	, 'conclusionHeading'),
	array('conclusionText'		, 'conclusionText'),
	array('conclusionImg'		, 'conclusionImg'),
	array('conclusionImgData'	, 'conclusionImgData'),
	array('conclusionImgURL'	, 'conclusionImgURL'),
	array('conclusionImgCaption', 'conclusionImgCaption'),
);
?>