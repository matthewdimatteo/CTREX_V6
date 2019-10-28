<?php
/*
php/header-format.php
By Matthew DiMatteo, Children's Technology Review

This file defines variable values for data displayed in the header and is included at the start of the file 'php/header.php', which outputs the header

Certain variables such as $lastSearch and $profileURL (destinations for Back and Profile links) are defined in 'php/session.php'
Booleans defining the display of the logo are defined in 'php/settings.php'
*/

// BACK BTN ----------------------------------------------------------------
switch($lastSearchType)
{
  case 'reviews' 		: $backBtnLink = $lastSearchReviews; 		$backBtnLabel = '< Reviews';		break;
  case 'publishers' 	: $backBtnLink = $lastSearchPublishers; 	$backBtnLabel = '< Publishers'; 	break;
  case 'archive' 		: $backBtnLink = $lastSearchArchive; 		$backBtnLabel = '< Archive'; 		break;
  case 'experts'		: $backBtnLink = 'experts.php';				$backBtnLabel = '< Experts';		break;
  default				: $backBtnLink = $lastSearchReviews; 		$backBtnLabel = '< Reviews'; 		break;
} // end switch($lastSearchType)

if($thisPage == 'experts.php' and $backBtnLink == 'experts.php')
{
  $backBtnLink = $lastSearchReviews; 		$backBtnLabel = '< Reviews';
}

// if on publisher directory or archive page, make reviews the back btn
if(($pageType == 'search' and $searchType != 'reviews'))
{
  $backBtnLink = $lastSearchReviews; 		$backBtnLabel = '< Reviews';
}

// special case for print page
if($thisPage == 'print.php')
{ 
  $backBtnLink = 'home.php';
  if($thisQuery != NULL) { $backBtnLink .= '?'.$thisQuery; }
  $backBtnLabel = '< Home'; 
}

// special case for awards
if($thisPage == 'award.php')
{
  $backBtnLink = 'awards.php';
  $backBtnLabel = '< Awards';
}
			
// LOGO IMG SRC --------------------------------------------------------------
if($logoImg != NULL)	{ $imgSrc = 'php/img.php?-url='.urlencode($logoImg); } 
else					{ $imgSrc = 'images/ctrex-6-logo-idle.png'; }
$imgSrc 		= 'images/ctrex-white-cropped.png';
$imgSrcHover 	= 'images/ctrex-color-cropped.png';

// LOGIN HOVER TEXT ----------------------------------------------------------
$loginHoverText = 'Log in as a subscriber for unlimited access';			
$subscribeHoverText = 'As a CTREX subscriber, you can read full reviews, save searches and reviews to your profile, comment on reviews and evaluate products with your own ratings, and create your own rubrics for detailed evaluations. You also get the CTR monthly issue and weekly newsletter, with complete access to our archive.';
$usernameHoverText = 'Don\'t know your username? Try using the email address associated with your CTR Subscription. You can also email us at info@childrenstech.com or call us at 908-284-0404';

// TAGLINE ------------------------------------------------------------------
if($latestWeeklyPreview != NULL) { $tagline = $latestWeeklyPreviewLink; } else { $tagline = $logoTagline; }

// KEYWORD -------------------------------------------------------------------
if($pageType == 'search')
{
    // ON SEARCH PAGE - USE CURRENT SEARCH PARAM FOR KEYWORD
    switch($searchType)
    {
        case 'reviews' 		: $keywordValue = $searchReviewsKeyword; 	break;
        case 'publishers' 	: $keywordValue = $searchPublishersKeyword; break;
        case 'archive' 		: $keywordValue = $searchArchiveKeyword; 	break;
        default 			: $keywordValue = $searchReviewsKeyword; 	break;
    } // end switch
} // end if pageType == search
else
{
    // ON CONTENT PAGES - USE LAST KEYWORD FROM SESSION
    switch($searchType)
    {
        case 'reviews' 		: $keywordValue = $lastKeywordReviews; 		break;
        case 'publishers' 	: $keywordValue = $lastKeywordPublishers; 	break;
        case 'archive' 		: $keywordValue = $lastKeywordArchive; 		break;
        case 'experts'		: $keywordValue = $lastKeywordReviews; 		break;
        default 			: $keywordValue = $lastKeyword; 			break;
    } // end switch
} // end else pageType not search

// MAIN MENU -----------------------------------------------------------------
$allMenuItems = array(); // declare an array to store all menu items
if($profile == true) 	{ array_push($allMenuItems, array($profileURL, 'Manage Profile')); } // if user logged in with profile, make profile 1st menu item

// declare an array of all default menu items
$menuItems = array
(
	array($lastSearchReviews, 'Home'),
	array('about.php', 'About'),
	array($lastSearchArchive, 'Archive'),
	array('faq.php', 'Frequently Asked Questions'),
	
	array('sponsors.php', 'Support Our Mission'),
	array('subscribe.php', 'Subscriptions'),
	array('licenses.php', 'Site Licenses'),
	
);
foreach($menuItems as $menuItem) { array_push($allMenuItems, $menuItem); } // add the default menu items to the array of all menu items

// insert a renewal link if not logged in
if($publisher != true and $license != true) 
{ 
	if($expired == true or $subscriber == true) { $renewalLink = 'renew.php'; }
	else 										{ $renewalLink = 'login.php?target=renew&redirect=renew.php'; }
	array_push($allMenuItems, array($renewalLink, 'Renewals')); 
} 

// re-declare an array of remaining default menu items
$menuItems = array
(
	array('contact.php', 'Contact Us'),
	array('password.php', 'Recover a Password'),
	array('submit.php', 'Submit a Product'),
	array('credentials.php', 'Publisher Accounts'),
	
	array('publisher-rights.php', 'Publisher\'s Bill of Rights'),
	array($lastSearchPublishers, 'Publisher Directory'),
	array('awards.php', 'Award Programs'),
	array('experts.php', 'Expert Reviewers'),
	array('staff.php', 'Staff'),
	array('rubrics.php', 'Rubrics'),
	array('ratings.php', 'Rating Method'),
	array('philosophy.php', 'Our Philosophy'),
	array('workshops.php', 'Workshops and Consulting'),

	array('social-media.php', 'Social Media'),
	array('press.php', 'Press Resources'),
	array('editorial-calendar.php', 'Editorial Calendar'),
	array('editorial-guidelines.php', 'Editorial Guidelines'),
	array('from-the-editor.php', 'Editor\'s Page'),
	array('corrections.php', 'Corrections'),
	array('disclaimer.php', 'Disclaimer and Copyright'),
	
);
foreach($menuItems as $menuItem) { array_push($allMenuItems, $menuItem); } // add the remaining default menu items to the array of all menu items

// PROFILE MENU --------------------------------------------------------------
$profileMenuItems = array();
if($share == true) { $publicProfileLabel = 'View Public Profile'; } else { $publicProfileLabel = 'Preview Public Profile'; }

// MANAGE PROFILE (SUB OR PUB)
if($subscriber == true or $publisher == true) 
{ 
	array_push($profileMenuItems, array($profileURL				, 'Manage Profile'));
}

// PUBLISHER OPTIONS
if($publisher == true) 
{ 
	array_push($profileMenuItems, array($publicProfileURL		, 'View Public Profile'));
	array_push($profileMenuItems, array('home.php?publisher='.$publisherName.'&page=1', 'My Titles'));
	array_push($profileMenuItems, array('submit.php'			, 'Submit Products'));
}

// ORGANIZATION PROFILE (LICENSE PATRON OR SITE ADMIN)
if($siteAdmin == true or $license == true)
{
	array_push($profileMenuItems, array('profile.php?id='.$siteName.'&type=license&mode=public', 'View Organization Profile'));
}

// EXPERT/MODERATIOR OPTIONS
if($expert == true or $mod == true)
{
	array_push($profileMenuItems, array('editorial.php?type=new', 'Enter New Product Review'));
	array_push($profileMenuItems, array('home.php?filter[]=drafts-only&page=1'			, 'View CTR Drafts'));
	array_push($profileMenuItems, array('rubric-create.php'		, 'Create New Rubric'));
}

// STUDENT EDITOR OPTION
if($student == true or $juror == true)
{
	array_push($profileMenuItems, array('editorial.php?type=new', 'Enter New Product Review'));
}

// JUROR OPTIONS
if($juror == true)
{
	array_push($profileMenuItems, array('awards.php', 'Award Programs'));
	if(substr_count($jurorType, 'bologna') > 0 )	
	{
		array_push($profileMenuItems, array('bolognaragazzi.php' , 'BolognaRagazzi Home'));
		array_push($profileMenuItems, array('juror-panel.php?type=bologna&year='.$year, 'BolognaRagazzi '.$year.' Juror\'s Panel'));
	}
	if(substr_count($jurorType, 'kapi') > 0 )
	{
		array_push($profileMenuItems, array('kapis.php', 'KAPi Awards Home'));
		array_push($profileMenuItems, array('juror-panel.php?type=kapi&year='.$year, 'KAPi Awards  '.$year.' Juror\'s Panel'));
	}
} // end if $juror

// SAVED ITEMS
if($numSavedSearches > 0)
{
	array_push($profileMenuItems, array('savedsearches.php'		, 'Manage Saved Searches'));
}
if($numSavedBookmarks > 0)
{
	array_push($profileMenuItems, array('savedbookmarks.php'	, 'Manage Bookmarked Reviews'));
}
if($numSavedRubrics > 0)
{
	array_push($profileMenuItems, array('savedrubrics.php'		, 'Manage Saved Rubrics'));
}

// LOG OUT
if($login == true)
{
	array_push($profileMenuItems, array('logout.php'			, 'Log Out'));
}

?>