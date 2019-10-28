<?php
/*
sidebar-options.php
By Matthew DiMatteo, Children's Technology Review

This file is included in the 'autoload.php' file
It defines the links and labels for the left sidebar on search pages, which contain quick links for different categories
The $ageRangeOptions, $gradeLevelOptions, $platformOptions, $subjectOptions, and $topicOptions arrays are also used in the 'power search' feature
For more info on the 'power search', refer to the 'powersearch.php' file
*/

// SEARCH FILTERS
$filterOptions = array
(
	array('current'		, '$filterCurrent'		, 'Current'),
	array('awards'		, '$filterAwards'		, 'Editor\'s Choice'),
	array('rated'		, '$filterRated'		, 'Rated'),
	array('free'		, '$filterFree'			, 'Free'),
	array('feature'		, '$filterFeature'		, 'Feature Review'),
	array('newrelease'	, '$filterNewrelease'	, 'New Release'),
	array('videos'		, '$filterVideos'		, 'Videos'),
	array('images'		, '$filterImages'		, 'Images'),
	array('comments'	, '$filterComments'		, 'Comments')
);

// POWERSEARCH/SIDEBAR LINKS
//	array(searchInput	, searchParam		, quickfindParam		, label)
$ageRangeOptions = array
(
	array('age'			, 'B'				, 'Baby'				, 'Baby'),
	array('age'			, 'T'				, 'Toddler'				, 'Toddler'),
	array('age'			, 'P'				, 'Preschool'			, 'Preschool'),
	array('age'			, 'K'				, 'Kindergarten'		, 'Kindergarten'),
	array('age'			, 'E'				, 'Early+Elementary'	, 'Early Elementary'),
	array('age'			, 'U'				, 'Upper+Elementary'	, 'Upper Elementary'),
	array('age'			, 'M'				, 'Middle/High+School'	, 'Middle/High School')
);
$gradeLevelOptions = array
(
	array('age'			, 'P'				, 'Preschool'		, 'Preschool'),
	array('age'			, 'K'				, 'Kindergarten'	, 'Kindergarten'),
	array('age'			, '1'				, '1st+Grade'		, '1st Grade'),
	array('age'			, '2'				, '2nd+Grade'		, '2nd Grade'),
	array('age'			, '3'				, '3rd+Grade'		, '3rd Grade'),
	array('age'			, '4'				, '4th+Grade'		, '4th Grade'),
	array('age'			, '5'				, '5th+Grade'		, '5th Grade'),
	array('age'			, '6'				, '6th+Grade'		, '6th Grade'),
	array('age'			, '7'				, '7th+Grade'		, '7th Grade'),
	array('age'			, '8'				, '8th+Grade'		, '8th Grade'),
	array('age'			, '9'				, '9th+Grade'		, '9th Grade'),
	array('age'			, 'S'				, 'Sophomore'		, 'Sophomore'),
	array('age'			, 'Jr'				, 'Junior'			, 'Junior'),
	array('age'			, 'Sr'				, 'Senior'			, 'Senior')
);
$platformOptions = array
(
	array('platform'	, 'iPad' 			, 'iPad'			, 'iPad'),
	array('platform'	, 'Android'			, 'Android'			, 'Android'),
	array('platform'	, 'Kindle' 			, 'Kindle'			, 'Kindle'),
	array('platform'	, 'Apple+TV' 		, 'Apple+TV'		, 'Apple TV'),
	array('platform'	, 'Mac'				, 'Mac'				, 'Mac'),
	array('platform'	, 'Windows'			, 'Windows'			, 'Windows'),
	array('platform'	, 'Steam'			, 'Steam'			, 'Steam'),
	array('platform'	, 'Internet'		, 'Internet'		, 'Internet'),
	array('platform'	, 'Nintendo+Switch'	, 'Nintendo+Switch'	, 'Nintendo Switch'),
	array('platform'	, 'Wii' 			, 'Nintendo+Wii'	, 'Nintendo Wii'),
	array('platform'	, 'Nintendo+3DS'	, 'Nintendo+3DS'	, 'Nintendo 3DS'),
	array('platform'	, 'Nintendo+DS'		, 'Nintendo+DS'		, 'Nintendo DS'),
	array('platform'	, 'Playstation+4' 	, 'Playstation+4'	, 'Sony PS4'),
	array('platform'	, 'Playstation+3' 	, 'Playstation+3'	, 'Sony PS3'),
	array('platform'	, 'Xbox+One' 		, 'Xbox+One'		, 'Xbox One'),
	array('platform'	, 'Xbox+360' 		, 'Xbox+360'		, 'Xbox 360'),
	array('platform'	, 'Xbox+Kinect' 	, 'Xbox+Kinect'		, 'Xbox Kinect'),
	array('platform'	, 'Smart+Toy' 		, 'Smart+Toy'		, 'Smart Toy'),
);
$subjectOptions = array
(
	array('subject'		, 'Art'				, 'Art'				, 'Art'),
	array('subject'		, 'Creativity'		, 'Creativity'		, 'Creativity'),
	array('subject'		, 'Health'			, 'Health'			, 'Health'),
	array('subject'		, 'History'			, 'History'			, 'History'),
	array('subject'		, 'Logic'			, 'Logic'			, 'Logic'),
	array('subject'		, 'Math'			, 'Math'			, 'Math'),
	array('subject'		, 'Music'			, 'Music'			, 'Music'),
	array('subject'		, 'Peripheral'		, 'Peripheral'		, 'Peripheral'),
	array('subject'		, 'Photography'		, 'Photography'		, 'Photography'),
	array('subject'		, 'Physical'		, 'PE'				, 'PE'),
	array('subject'		, 'Programming'		, 'Programming'		, 'Programming'),
	array('subject'		, 'Reading'			, 'Reading'			, 'Reading'),
	array('subject'		, 'Science'			, 'Science'			, 'Science'),
	array('subject'		, 'Spanish'			, 'Spanish'			, 'Spanish'),
	array('subject'		, 'Utility'			, 'Utility'			, 'Utility'),
);
$subjectOptgroups = array
(
	array
	(
		'Language Topics', array
		(
			'Decoding', 'French', 'Handwriting', 'Phonics', 'Letter Recognition', 'Reading', 'Spanish', 'Storytelling', 'Writing'
		)
	),
	array
	(
		'Math Topics', array
		(
			'Addition', 'Time', 'Drill', 'Fractions', 'Geometry', 'Logic', 'Math Facts', 'Multiplication', 'Programming', 'Seriation', 'Shapes'
		)
	),
	array
	(
		'Music Topics', array
		(
			'Pitch', 'Instruments', 'Karaoke', 'Notation', 'Orchestra', 'Singing'
		)
	),
	array
	(
		'Science Topics', array
		(
			'Animals', 'Astronomy', 'Chemistry', 'Dinosaurs', 'Ecology', 'Experiments', 'Geology', 'Insects', 'Light', 'Physics', 'Plants', 'Planets'
		)
	),
	array
	(
		'Creativity Topics', array
		(
			'Drawing', 'Sketching', 'Singing', 'Pitch', 'Music'
		)
	),
	array
	(
		'Geography Topics', array
		(
			'Capitals, Continents', 'Earth Science', 'Maps'
		)
	),
	array
	(
		'PE Topics', array
		(
			'Exercise', 'Dance', 'Fine Motor'
		)
	)
);
$topicOptions = array();
$t = -1;
$st = -1;
$specialTopicOptions = array(); // array for sidebar (no optgroups)
$findTopics = $fmtopics->newFindCommand('categorygroups');
$findTopics->addFindCriterion('status', "=*active*");
$findTopics->addSortRule('order', 1, FILEMAKER_SORT_ASCEND);
$topicsResult = $findTopics->execute();
if (FileMaker::isError ($topicsResult) ) { echo $topicsResult->getMessage(); }
$topicGroups = $topicsResult->getRecords();
foreach($topicGroups as $topicGroup)
{
	$t += 1;
	$optgroup 	= $topicGroup->getField('optgroup');
	$numTopics 	= $topicGroup->getField('numCategories');
	$topics 	= $topicGroup->getRelatedSet('categories');
	if($numTopics > 0)
	{
		$topicsArray = array(); // array for powersearch (within optgroups)
		$ta = -1;
		foreach($topics as $topic)
		{
			$ta += 1;
			$st += 1;
			$status 	= $topic->getField('categories::status');	
			$value 		= $topic->getField('categories::value');	
			$label 		= $topic->getField('categories::name');	
			$numTagged	= $topic->getField('categories::numTagged');
			if($status == 'active' and $numTagged > 0) 
			{ 
				$topicsArray[$ta] = array($value, $label); // array for powersearch (within optgroups)
				$specialTopicOptions[$st] = array('category', $value, $value, $label); // array for sidebar (no optgroups)
			}
		} // end foreach $topics
	} // end if $numTopics > 0
	$topicOptions[$t] = array($optgroup, $topicsArray);
} // end foreach $topicGroups

// HUB LINKS
$familiesOptions = array
(
	array('platform'	, 'iPad'			, 'iPad'			, 'iPad'),
	array('platform'	, 'Android'			, 'Android'			, 'Android'),
	array('platform'	, 'Kindle' 			, 'Kindle'			, 'Kindle'),
	array('platform'	, 'Apple+TV' 		, 'Apple+TV'		, 'Apple TV'),
	array('platform'	, 'Nintendo+Switch'	, 'Nintendo+Switch', 'Nintendo Switch'),
	array('platform'	, 'Playstation+4' 	, 'Playstation+4'	, 'Sony PS4'),
	array('platform'	, 'Xbox+One' 		, 'Xbox+One'		, 'Xbox One')
);
$librariesOptions = array
(
	array('category'	, 'Library+Apps'	, 'Library+Apps'	, 'Library Apps'),
	array('category'	, 'Library+Toys'	, 'Library+Toys'	, 'Library Toys'),
	array('category'	, 'Library+Video+Games', 'Library+Video+Games', 'Library Videogames'),
	array('subject'		, 'Reading'			, 'Reading'			, 'Reading'),
	array('category'	, 'Early+Reading'	, 'Early+Reading'	, 'Early Reading'),
	array('category'	, 'isFiction'		, 'Fiction'			, 'Fiction'),
	array('category'	, 'NonFiction'		, 'NonFiction'		, 'NonFiction')
);
$schoolsOptions = array
(
	array('category'	, 'STEM'			, 'STEM'			, 'STEM'),
	array('category'	, 'Coding'			, 'Coding'			, 'Coding'),
	array('category'	, 'Maker'			, 'Maker'			, 'Maker'),
	array('category'	, 'Montessori'		, 'Montessori'		, 'Montessori'),
	array('category'	, 'Early+Reading'	, 'Early+Reading'	, 'Early Reading'),
	array('category'	, 'Early+Math'		, 'Early+Math'		, 'Early Math')
);
$eceOptions = array
(
	array('category'	, 'ECE'				, 'ECE'				, 'Top ECE Picks'),
	array('age'			, 'B'				, 'Baby'			, 'Baby'),
	array('age'			, 'T'				, 'Toddler'			, 'Toddler'),
	array('age'			, 'P'				, 'Preschool'		, 'Preschool'),
	array('age'			, 'K'				, 'Kindergarten'	, 'Kindergarten'),
	array('category'	, 'Starter'			, 'Starter+Apps'	, 'Starter Apps'),
	array('category'	, 'Early+Reading'	, 'Early+Reading'	, 'Early Reading'),
	array('category'	, 'Early+Math'		, 'Early+Math'		, 'Early Math')
);

$directoryOptions = array
(
	array('publishers'	, '', 'submit.php'				, 'Submit Products'),
	array('publishers'	, '', 'credentials.php'			, 'Publisher Accounts'),
	array('publishers'	, '', 'ratings.php'				, 'Rating Method'),
	array('publishers'	, '', 'publisher-rights.php'	, 'Bill of Rights'),
	array('publishers'	, '', 'http://dustormagic.com'	, 'Dust or Magic'),
	array('publishers'	, '', 'bolognaragazzi.php'		, 'Bologna Ragazzi'),
	array('publishers'	, '', 'kapis.php'				, 'KAPi Awards'),
	array('publishers'	, '', 'corrections.php'			, 'Corrections'),
	array('publishers'	, '', 'disclaimer.php'			, 'Disclaimer')
);
$publisherOptions = array
(
	array('publishers'	, '', $lastSearchPublishers, 'Publisher Directory')
);
foreach($directoryOptions as $directoryOption)
{
	array_push($publisherOptions, $directoryOption);
}
?>