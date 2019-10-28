<?php
/*
php/get-pub.php
By Matthew DiMatteo, Children's Technology Review

This file gets the field values for a publisher record in the database 'Producers.fmp12'
It is included in the file 'php/profiles/content-profile-publisher.php' and 'php/find-publishers.php'

*/
$fields = $publisherFields; // tells 'php/get-field.php' which array of fields to use (defined in 'php/fields.php')
foreach($fields as $field) { require 'php/get-field.php'; } // get all of the field values and assign to variables

// determine whether industry contact is displayed on public profile
if($share == 'Share' or $share == 'share') 	{ $share = true; } 	else { $share = false; }
array_push($fieldValues, array('share', $share));

// determine url for more titles
$moreTitlesURL = 'home.php?publisher='.$companyName.'&page=1';
if($numTitlesReviewed == NULL) 	{ $numTitlesReviewed 	= 0; }
if($numTitlesSubmitted == NULL) { $numTitlesSubmitted 	= 0; }
$numTitlesPending = $numTitlesSubmitted - $numTitlesReviewed; // calculate the number of submissions that have not been reviewed
array_push($fieldValues, array('moreTitlesURL'		, $moreTitlesURL));
array_push($fieldValues, array('numTitlesReviewed'	, $numTitlesReviewed));
array_push($fieldValues, array('numTitlesSubmitted'	, $numTitlesSubmitted));
array_push($fieldValues, array('numTitlesPending'	, $numTitlesPending));

// get related CSR records (titles reviewed)
$titlesReviewedArray 	= array(); // declare array to store titles reviewed
$titlesSubmittedArray 	= array(); // declare array to store titles submitted
if($numTitlesSubmitted > 0)
{
	$titlesSubmitted = $record->getRelatedSet('CSR');
	$relatedTitleN = 0;
	foreach($titlesSubmitted as $thisTitle)
	{
		$titleID	= $thisTitle->getField('CSR::reviewnumber');
		$titleName 	= $thisTitle->getField('CSR::Title');
		$copyright	= $thisTitle->getField('CSR::Copyright Date');
		$entered	= $thisTitle->getField('CSR::Date of Review');
		$published	= $thisTitle->getField('CSR::published');
		if($published != NULL) { $published = true; } else { $published = false; }
		
		// get the thumbnail of the first title for display in publisher directory
		if($published == true)
		{
			$relatedTitleN += 1;
			if($relatedTitleN == 1)
			{
				$firstImg 		= $thisTitle->getField('CSR::thumbnail');
				$firstImgData	= $thisTitle->getField('CSR::thumbData');
				$firstTitle		= $titleName;
				$firstTitleID	= $titleID;
				$firstTitleLink	= 'review.php?id='.$firstTitleID;
			} // end if n == 1
		} // end if $published
		
		// if CSR record is published, add to array of reviewed titles; otherwise add to array of submissions
		if($published == true) 	{ array_push($titlesReviewedArray	, array($titleID, $titleName, $copyright, $entered, $published)); }
		else					{ array_push($titlesSubmittedArray	, array($titleID, $titleName, $copyright, $entered, $published)); } 
		
	} // end foreach
} // end if $numTitlesSubmitted > 0

array_push($fieldValues, array('firstImg'		, $firstImg));
array_push($fieldValues, array('firstImgData'	, $firstImgData));
array_push($fieldValues, array('firstTitle'		, $firstTitle));
array_push($fieldValues, array('firstTitleLink'	, $firstTitleLink));

array_push($fieldValues, array('titlesReviewedArray'	, $titlesReviewedArray));
array_push($fieldValues, array('titlesSubmittedArray'	, $titlesSubmittedArray));

// DETERMINE WHETHER THERE ARE LINKS TO DISPLAY
$numLinks = 0;
if($linkWebsite != NULL) 	{ $numLinks += 1; }
if($linkTwitter != NULL) 	{ $numLinks += 1; }
if($linkFacebook != NULL) 	{ $numLinks += 1; }
if($linkYouTube != NULL) 	{ $numLinks += 1; }
array_push($fieldValues, array('numLinks', $numLinks));

// DETERMINE WHETHER THERE ARE CONTACT INFO FIELDS TO DISPLAY
$hasContactInfo = false;
if($addressStreet != NULL) 	{ $hasContactInfo = true; }
if($addressCity != NULL) 	{ $hasContactInfo = true; }
if($addressState != NULL) 	{ $hasContactInfo = true; }
if($addressZip != NULL) 	{ $hasContactInfo = true; }
if($addressCountry != NULL) { $hasContactInfo = true; }
if($phone1 != NULL) 		{ $hasContactInfo = true; }
if($phone2 != NULL) 		{ $hasContactInfo = true; }
if($fax != NULL) 			{ $hasContactInfo = true; }
if($publicEmail1 != NULL) 	{ $hasContactInfo = true; }
if($publicEmail2 != NULL) 	{ $hasContactInfo = true; }
if($publicEmail3 != NULL) 	{ $hasContactInfo = true; }
if($publicEmail4 != NULL) 	{ $hasContactInfo = true; }
if($publicEmail5 != NULL) 	{ $hasContactInfo = true; }
array_push($fieldValues, array('hasContactInfo', $hasContactInfo));

// FORMAT ADDRESS AND CONTACT FULL NAME
if($hasContactInfo == true) { $publisherAddress = formatAddressNoBr($addressStreet, $addressCity, $addressState, $addressZip, $addressCountry); }
$publisherContact = formatFullName($contactFname, $contactLname);
array_push($fieldValues, array('publisherAddress', $publisherAddress));
array_push($fieldValues, array('publisherContact', $publisherContact));

// SAVE PUBLISHER INFO (FIELDS USED FOR PRODUCT SUBMISSION FORM) IN SESSION STORAGE
$_SESSION['publisher-info-name'] 	= $publisherName;
$_SESSION['publisher-info-website']	= $linkWebsite;
$_SESSION['publisher-info-address'] = $publisherAddress;
$_SESSION['publisher-info-contact'] = $publisherContact;
$_SESSION['publisher-info-email'] 	= $contactEmail;
$_SESSION['publisher-info-phone'] 	= $phone1;
$_SESSION['publisher-info-fax'] 	= $fax;
$_SESSION['publisher-info-facebook']= $linkFacebook;
$_SESSION['publisher-info-twitter'] = $linkTwitter;
$_SESSION['publisher-info-youtube'] = $linkYouTube;
			
?>