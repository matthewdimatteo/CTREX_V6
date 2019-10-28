<?php
/*
connect.php
By Matthew DiMatteo, Children's Technology Review

This file is included in the 'autoload.php' file
It defines the protocol for connecting to the FileMaker databases used in this CWP solution
The code below utilize the FM PHP API to define objects for querying each table used in this solution
*/

// This is the set of credentials for the account in each database used for CWP
$username = 'webctr';
$password = 'webctrpassword';

// DEFINE OBJECTS FOR QUERYING EACH TABLE ---------------------------------

// CSR.fmp12 		[dashboard]		- for guest access mode, promo messages, logo (see 'settings.php')
$fmdashboard = & new FileMaker();
$fmdashboard->setProperty('database', 'CSR');
$fmdashboard->setProperty('username', $username);
$fmdashboard->setProperty('password', $password);
$fmdashboardLayout = 'dashboard-master';
$layoutdashboard = $fmdashboard->getLayout($fmdashboardLayout);

// CSR.fmp12 		[text]		- for text dumps
$fmtext = & new FileMaker();
$fmtext->setProperty('database', 'CSR');
$fmtext->setProperty('username', $username);
$fmtext->setProperty('password', $password);
$fmtextLayout = 'text';
$layouttext = $fmtext->getLayout($fmtextLayout);

// CSR.fmp12 		[messages]		- for CTREX notifications
$fmmessages = & new FileMaker();
$fmmessages->setProperty('database', 'CSR');
$fmmessages->setProperty('username', $username);
$fmmessages->setProperty('password', $password);
$fmmessagesLayout = 'messages';
$layoutmessages = $fmmessages->getLayout($fmmessagesLayout);

// CSR.fmp12 		[CSR]			- for reviews (search pages, review page)
$fmreviews = & new FileMaker();
$fmreviews->setProperty('database', 'CSR');
$fmreviews->setProperty('username', $username);
$fmreviews->setProperty('password', $password);
$fmreviewsLayout = 'php-csr';
$layoutreviews = $fmreviews->getLayout($fmreviewsLayout);

// CSR.fmp12		[comments]		- for comments
$fmcomments = & new FileMaker();
$fmcomments->setProperty('database', 'CSR');
$fmcomments->setProperty('username', $username);
$fmcomments->setProperty('password', $password);
$fmcommentsLayout = 'comments';
$layoutcomments = $fmcomments->getLayout($fmcommentsLayout);

// CSR.fmp12 		[expertreviews]	- for expert reviews
$fmexpreviews = & new FileMaker();
$fmexpreviews->setProperty('database', 'CSR');
$fmexpreviews->setProperty('username', $username);
$fmexpreviews->setProperty('password', $password);
$fmexpreviewsLayout = 'expertreviews';
$layoutexpreviews = $fmexpreviews->getLayout($fmexpreviewsLayout);

// CSR.fmp12		[rubrics]		- for rubrics
$fmrubrics = & new FileMaker();
$fmrubrics->setProperty('database', 'CSR');
$fmrubrics->setProperty('username', $username);
$fmrubrics->setProperty('password', $password);
$fmrubricsLayout = 'rubrics';
$layoutrubrics = $fmrubrics->getLayout($fmrubricsLayout);

// CSR.fmp12		[rubrics]		- for selected rubric as search terms
$fmrubric = & new FileMaker();
$fmrubric->setProperty('database', 'CSR');
$fmrubric->setProperty('username', $username);
$fmrubric->setProperty('password', $password);
$fmrubricLayout = 'rubrics';
$layoutrubric = $fmrubric->getLayout($fmrubricLayout);

// CSR.fmp12		[qa]		- for quality attributes
$fmqa = & new FileMaker();
$fmqa->setProperty('database', 'CSR');
$fmqa->setProperty('username', $username);
$fmqa->setProperty('password', $password);
$fmqaLayout = 'Quality Attributes';
$layoutqa = $fmqa->getLayout($fmqaLayout);

// subbies.fmp12 	[subs]			- for subscriber records (profile pages, login process)
$fmsubs = & new FileMaker();
$fmsubs->setProperty('database', 'subbies');
$fmsubs->setProperty('username', $username);
$fmsubs->setProperty('password', $password);
$fmsubsLayout = 'subbies';
$layoutsubs = $fmsubs->getLayout($fmsubsLayout);

// subbies.fmp12 	[orgs]			- for site license organizations (portal pages)
$fmorgs = & new FileMaker();
$fmorgs->setProperty('database', 'subbies');
$fmorgs->setProperty('username', $username);
$fmorgs->setProperty('password', $password);
$fmorgsLayout = 'SITE ORGS';
$layoutorgs = $fmorgs->getLayout($fmorgsLayout);

// Producers.fmp12	[Producers]		- for publishers (publisher profile pages, login process)
$fmpubs = & new FileMaker();
$fmpubs->setProperty('database', 'Producers');
$fmpubs->setProperty('username', $username);
$fmpubs->setProperty('password', $password);
$fmpubsLayout = 'php-publishers';
$layoutpubs = $fmpubs->getLayout($fmpubsLayout);

// CSR.fmp12		[views]			- for logging pageviews
$fmviews = & new FileMaker();
$fmviews->setProperty('database', 'CSR');
$fmviews->setProperty('username', $username);
$fmviews->setProperty('password', $password);
$fmviewsLayout = 'views';
$layoutviews = $fmviews->getLayout($fmviewsLayout);

// CSR.fmp12		[blacklist]		- for blacklisted IPs
$fmblacklist = & new FileMaker();
$fmblacklist->setProperty('database', 'CSR');
$fmblacklist->setProperty('username', $username);
$fmblacklist->setProperty('password', $password);
$fmblacklistLayout = 'blacklist';
$layoutblacklist = $fmblacklist->getLayout($fmblacklistLayout);

// subbies.fmp12	[faves]			- for processing user saved searches, bookmarks, rubrics, collections
$fmfaves = & new FileMaker();
$fmfaves->setProperty('database', 'subbies');
$fmfaves->setProperty('username', $username);
$fmfaves->setProperty('password', $password);
$fmfavesLayout = 'faves';
$layoutfaves = $fmfaves->getLayout($fmfavesLayout);

// subbies.fmp12	[savedsearches]			- for processing user saved searches
$fmsavedsearches = & new FileMaker();
$fmsavedsearches->setProperty('database', 'subbies');
$fmsavedsearches->setProperty('username', $username);
$fmsavedsearches->setProperty('password', $password);
$fmsavedsearchesLayout = 'savedsearches';
$layoutsavedsearches = $fmsavedsearches->getLayout($fmsavedsearchesLayout);

// subbies.fmp12	[savedbookmarks]		- for processing user saved bookmarks
$fmsavedbookmarks = & new FileMaker();
$fmsavedbookmarks->setProperty('database', 'subbies');
$fmsavedbookmarks->setProperty('username', $username);
$fmsavedbookmarks->setProperty('password', $password);
$fmsavedbookmarksLayout = 'savedbookmarks';
$layoutsavedbookmarks = $fmsavedbookmarks->getLayout($fmsavedbookmarksLayout);

// subbies.fmp12	[folders]			- for processing user bookmark folders
$fmbookmarkfolders = & new FileMaker();
$fmbookmarkfolders->setProperty('database', 'subbies');
$fmbookmarkfolders->setProperty('username', $username);
$fmbookmarkfolders->setProperty('password', $password);
$fmbookmarkfoldersLayout = 'bookmark-folders';
$layoutbookmarkfolders = $fmbookmarkfolders->getLayout($fmbookmarkfoldersLayout);

// subbies.fmp12	[savedrubrics]		- for processing user saved rubrics
$fmsavedrubrics = & new FileMaker();
$fmsavedrubrics->setProperty('database', 'subbies');
$fmsavedrubrics->setProperty('username', $username);
$fmsavedrubrics->setProperty('password', $password);
$fmsavedrubricsLayout = 'savedrubrics';
$layoutsavedrubrics = $fmsavedrubrics->getLayout($fmsavedrubricsLayout);

// CSR.fmp12		[categories]	- for loading topic groups and topics for powersearch menu
$fmtopics = & new FileMaker();
$fmtopics->setProperty('database', 'CSR');
$fmtopics->setProperty('username', $username);
$fmtopics->setProperty('password', $password);
$fmtopicsLayout = 'categorygroups';
$layouttopics = $fmtopics->getLayout($fmtopicsLayout);

// CSR.fmp12		[categories]	- for loading descriptions of selected topic
$fmtopic = & new FileMaker();
$fmtopic->setProperty('database', 'CSR');
$fmtopic->setProperty('username', $username);
$fmtopic->setProperty('password', $password);
$fmtopicLayout = 'categories-detail';
$layouttopic = $fmtopic->getLayout($fmtopicLayout);

// subbies.fmp12	[promocodes]	- for checking promocodes
$fmpromo = & new FileMaker();
$fmpromo->setProperty('database', 'subbies');
$fmpromo->setProperty('username', $username);
$fmpromo->setProperty('password', $password);
$fmpromoLayout = 'promocodes';
$layoutpromo = $fmpromo->getLayout($fmpromoLayout);

// CSR.fmp12		[features]	- for displaying subscription features text
$fmfeatures = & new FileMaker();
$fmfeatures->setProperty('database', 'CSR');
$fmfeatures->setProperty('username', $username);
$fmfeatures->setProperty('password', $password);
$fmfeaturesLayout = 'features';
$layoutfeatures = $fmfeatures->getLayout($fmfeaturesLayout);

// CSR.fmp12		[CSR]	- for displaying sample reviews
$fmsamples = & new FileMaker();
$fmsamples->setProperty('database', 'CSR');
$fmsamples->setProperty('username', $username);
$fmsamples->setProperty('password', $password);
$fmsamplesLayout = 'php-find-sample';
$layoutsamples = $fmsamples->getLayout($fmsamplesLayout);

// CSR.fmp12		[issues]	- for displaying sample monthly issues
$fmissues = & new FileMaker();
$fmissues->setProperty('database', 'CSR');
$fmissues->setProperty('username', $username);
$fmissues->setProperty('password', $password);
$fmissuesLayout = 'ISSUE DETAILS';
$layoutissues = $fmissues->getLayout($fmissuesLayout);

// subbies.fmp12	[monthly]	- for displaying archived monthlies
$fmmonthly = & new FileMaker();
$fmmonthly->setProperty('database', 'subbies');
$fmmonthly->setProperty('username', $username);
$fmmonthly->setProperty('password', $password);
$fmmonthlyLayout = 'archive-monthly';
$layoutmonthly = $fmmonthly->getLayout($fmmonthlyLayout);

// subbies.fmp12	[weekly]	- for displaying archived weeklies
$fmweekly = & new FileMaker();
$fmweekly->setProperty('database', 'subbies');
$fmweekly->setProperty('username', $username);
$fmweekly->setProperty('password', $password);
$fmweeklyLayout = 'archive-weekly';
$layoutweekly = $fmweekly->getLayout($fmweeklyLayout);

// CSR.fmp12		[articles]	- for displaying links to medium.com articles
$fmarticles = & new FileMaker();
$fmarticles->setProperty('database', 'CSR');
$fmarticles->setProperty('username', $username);
$fmarticles->setProperty('password', $password);
$fmarticlesLayout = 'articles';
$layoutarticles = $fmarticles->getLayout($fmarticlesLayout);

// CSR.fmp12		[corrections]- for corrections
$fmcorrections = & new FileMaker();
$fmcorrections->setProperty('database', 'CSR');
$fmcorrections->setProperty('username', $username);
$fmcorrections->setProperty('password', $password);
$fmcorrectionsLayout = 'corrections';
$layoutcorrections = $fmcorrections->getLayout($fmcorrectionsLayout);

// CSR.fmp12		[bologna]- for bologna awards
$fmbologna = & new FileMaker();
$fmbologna->setProperty('database', 'CSR');
$fmbologna->setProperty('username', $username);
$fmbologna->setProperty('password', $password);
$fmbolognaLayout = 'bologna';
$layoutbologna = $fmbologna->getLayout($fmbolognaLayout);

// CSR.fmp12		[kapi]- for kapi awards
$fmkapi = & new FileMaker();
$fmkapi->setProperty('database', 'CSR');
$fmkapi->setProperty('username', $username);
$fmkapi->setProperty('password', $password);
$fmkapiLayout = 'kapi';
$layoutkapi = $fmkapi->getLayout($fmkapiLayout);

?>