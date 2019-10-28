<?php
/*
php/company-links.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the links to a publisher's website, CTREX profile, and more titles
It is included in the files 'php/result-item.php' and 'php/review-title.php'
*/

// CHECK RELATED PRODUCERS RECORDS FOR NON-DUPLICATES TO GET TRUE COMPANY ID
if($numProducers > 0)
{
	$relatedFields = $relatedProducerFields;
	
	foreach($producers as $relatedRecord)
	{
		require 'php/get-field-related.php';
		if($dup == NULL) { $trueCompanyID = $companyID; }
	}
	$companyID = $trueCompanyID;
}
else { $companyID = '';}


// COMPANY LINKS
echo '<div class = "company-links text-14" id = "company-links-'.$recordN.'">';

	// WEBSITE
	if($publisherWebsite != NULL)
	{
		echo '<div class = "inline right-10">';
			echo '<a href = "http://'.$publisherWebsite.'" target = "_blank" title = "View the website for '.$company.'">Website</a>';
		echo '</div>';
	}

	// CTREX PROFILE, MORE TITLES
	if($companyID != NULL)
	{
		// URL and hover text for Publisher Profile
		$publisherProfileURL = 'profile.php?id='.$companyID.'&type=publisher&mode=public';
		$publisherProfileHover = 'View the CTREX Profile for '.$company;

		// URL and hover text for More Titles
		$moreTitlesURL = 'home.php?publisher='.$company.'&page=1';
		$moreTitlesHover = 'See other CTREX reviews for titles by '.$company;

		// velvet rope overrides
		if($velvetRope == true)
		{
			$publisherProfileURL = 'login.php?target=publisher-profile&redirect='.urlencode($publisherProfileURL);
			$publisherProfileHover = 'Log in as a subscriber to '.lcfirst($publisherProfileHover);
			$moreTitlesURL = 'login.php?target=more-titles&redirect='.urlencode($moreTitlesURL);
			$moreTitlesHover = 'Log in as a subscriber to '.lcfirst($moreTitlesHover);
		}

		// overrides for publisher viewing own products (bool set in 'php/find-reviews.php')
		if($publisherAccess == true)
		{
			$publisherProfileURL = $profileURL; // from 'php/session.php'
		}

		// CTREX PROFILE
		echo '<div class = "inline right-10">';
			echo '<a href = "'.$publisherProfileURL.'" title = "'.$publisherProfileHover.'">CTREX Profile</a>';
		echo '</div>';

		// MORE TITLES
		echo '<div class = "inline right-10">';
			echo '<a href = "'.$moreTitlesURL.'" title = "'.$moreTitlesHover.'">More Titles</a>';
		echo '</div>';
	}
echo '</div>'; // /.company-links #company-links-$recordN
/*
echo '$companyID: '.$companyID.'<br/>';
echo '$numProducers: '.$numProducers.'<br/>';
echo '$producers: '.$producers.'<br/>';
*/
?>