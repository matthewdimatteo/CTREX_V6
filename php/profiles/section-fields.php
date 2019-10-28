<?php
/*
php/profiles/section-fields.php
By Matthew DiMatteo, Children's Technology Review

This file defines arrays containing the field names for each section of the subscriber profile
Each array item contains both the form input field name and the database field name

This file is included in 'profile-update.php'
*/

// SUBSCRIBER FIELDS --------------------------------------------
// DECLARE AN ARRAY OF THE INPUT FIELDS FOR EACH SECTION
// array(input/var name, database field name)
$fieldsPrivacy = 
array
(
	array('share' , 'share')
);
$fieldsSubscription = 
 array
(
	array('email'		, 'EMail'),
	array('screenName'	, 'screenName'),
	array('username'	, 'ctrexUsername'), 
	array('password'	, 'ctrexPassword')
);
$fieldsLicense = array
(
	array('ipRange'				, 'orgs::ipRange'), 
	array('fte'					, 'orgs::fteSize'),
	array('siteEmail'			, 'orgs::email'),
	array('siteAddressStreet'	, 'orgs::addressStreet'),
	array('siteAddressCity'		, 'orgs::addressCity'),
	array('siteAddressState'	, 'orgs::addressState'),
	array('siteAddressZip'		, 'orgs::addressZip'),
	array('siteAddressCountry'	, 'orgs::addressCountry'),
	array('sitePhone1'			, 'orgs::phone1'),
	array('sitePhone2'			, 'orgs::phone2'),
	array('siteFax'				, 'orgs::fax')
);
$fieldsContactPrivate = array
(
	array('fname'			, 'Contact First Name'),
	array('lname'			, 'Contact Last Name'), 
	array('email'			, 'EMail'),
	array('addressStreet'	, 'Address'),
	array('addressCity'		, 'City'),
	array('addressState'	, 'State'),
	array('addressZip'		, 'Zip'),
	array('addressCountry'	, 'Country'),
	array('phone1'			, 'PhoneOne'),
	array('phone2'			, 'PhoneTwo'),
	array('fax'				, 'Fax')
);
$fieldsContactPublic = array
(
	array('organization'	, 'Company Name'),
	array('jobTitle'		, 'Contact Title'),
	array('publicEmail'		, 'publicEmail'),
	array('publicPhone'		, 'publicPhone'),
	array('publicWebsite'	, 'publicWebsite'),
	array('publicFacebook'	, 'publicFacebook'),
	array('publicTwitter'	, 'publicTwitter'),
	array('publicYouTube'	, 'publicYouTube'),
	array('publicInstagram'	, 'publicInstagram'),
	array('publicPinterest'	, 'publicPinterest'),
	array('publicLinkedIn'	, 'publicLinkedIn')
);
$fieldsBio = array
(
	array('bio'	, 'bio')
);
$fieldsExpert = array
(
	array('expertSpecialty'	, 'expertSpecialty'),
	array('expertBias'		, 'expertBias'),
	array('sendProductsTo'	, 'sendProductsTo')
);

// SUBSCRIBER FIELDS --------------------------------------------
// DECLARE AN ARRAY OF THE INPUT FIELDS FOR EACH SECTION
// array(input/var name, database field name)
$fieldsAccount = array
(
	array('ctrexPassword'	, 'password')
);
$fieldsIndustry = array
(
	array('contactFname'		, 'Contact First Name'),
	array('contactLname'		, 'Contact Last Name'),
	array('contactTitle'		, 'Contact Title'),
	array('contactEmail'		, 'EMail')
);
$fieldsDescription = array
(
	array('description'			, 'description')
);
$fieldsLinks = array
(
	array('linkLogo'			, 'logoURL'),
	array('linkWebsite'			, 'Web site'),
	array('linkFacebook'		, 'facebookLink'),
	array('linkTwitter'			, 'twitterLink'),
	array('linkLinkedIn'		, 'linkedInLink'),
	array('linkInstagram'		, 'instagramLink'),
	array('linkPinterest'		, 'pinterestLink'),
	array('linkYouTube'			, 'youtubeLink'),
	array('linkVideo'			, 'featuredVideo')
);
$fieldsPubContact = array
(
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
	array('publicEmail5Type'	, 'publicEmail5Type')
);
?>