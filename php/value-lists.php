<?php
/*
php/value-lists.php
By Matthew DiMatteo, Children's Technology Review

This file defines arrays of value lists for checkbox sets to be outputted by the file 'php/form-checkbox-output.php'
The order for array items is (label, value)
The file 'php/form-checkbox-output.php' sets an id value for each checkbox item to be the value with spaces converted to underscores

Note: Ideally, these values would be defined as tables in a database and drawn from there, to allow for automatic updates
As is, any modification of value lists in the database would require this file to be manually updated to reflect changes
*/

// this function returns a value list array, cleaned of its "-" dividers and blank spaces
function getFMValueListItems($databaseName, $layoutName, $fieldObjectName)
{
	$fmobject = & new FileMaker();
	$fmobject->setProperty('database', $databaseName);
	$fmobject->setProperty('username', 'webctr');
	$fmobject->setProperty('password', 'webctrpassword');
	$layoutObject = $fmobject->getLayout($layoutName);
	
	$fieldObject = $layoutObject->getField($fieldObjectName);
	$valueList = $fieldObject->getValueList();
	$valueListItems = array();
	foreach($valueList as $valueListItem) { if($valueListItem != NULL and $valueListItem != '-') { array_push($valueListItems, $valueListItem); } }
	return($valueListItems);
} // /function getFMValueListItems

// get value lists for CSR fields
$gradeValueListItems		= getFMValueListItems('CSR', 'php-csr', 'Grade Level');
$platformValueListItems 	= getFMValueListItems('CSR', 'php-csr', 'Platform');
$subjectValueListItems		= getFMValueListItems('CSR', 'php-csr', 'Teaches');
$topicValueListItems		= getFMValueListItems('CSR', 'php-csr', 'recommendations');
$languageValueListItems		= getFMValueListItems('CSR', 'php-csr', 'Language List');
$scaffoldingValueListItems	= getFMValueListItems('CSR', 'php-csr', 'Scaffolding List');
$issueValueListItems		= getFMValueListItems('CSR', 'php-csr', 'issueAbbr');
$weeklyValueListItems		= getFMValueListItems('CSR', 'php-csr', 'weekly');

/*
// PLATFORM
$platformCheckboxItems = array
(
	array('iPad', 'iPad'),
	array('iPhone', 'iPhone'),
	array('Apple TV', 'Apple TV'),
	array('Android', 'Android'),
	array('Kindle', 'Kindle'),
	array('Nintendo DS', 'Nintendo DS'),
	array('Nintendo Switch', 'Nintendo Switch'),
	array('Vita', 'Vita'),
	array('Windows', 'Windows'),
	array('Mac OSX', 'Mac OSX'),
	array('Chrome', 'Chrome'),
	array('Internet Site', 'Internet Site'),
	array('Steam', 'Steam'),
	array('Playstation 4', 'Playstation 4'),
	array('Wii', 'Wii'),
	array('Wii U', 'Wii U'),
	array('Xbox 360', 'Xbox 360'),
	array('Xbox One', 'Xbox One'),
	array('Xbox Kinect', 'Xbox Kinect'),
	array('LeapPad', 'LeapPad'),
	array('TV', 'TV'),
	array('Smart Toy', 'Smart Toy'),
	array('Apple Watch', 'Apple Watch'),
	array('Vive', 'Vive'),
	array('PSVR', 'PSVR'),
	array('Oculus Rift', 'Oculus Rift'),
	array('Windows VR', 'Windows VR'),
);

// SUBJECT
$subjectCheckboxItems = array
(
	array('Language', 'Language'),
	array('reading', 'reading'),
	array('upper/lower case', 'upper/lower case'),
	array('auditory discrimination', ''),
	array('letter recognition', ''),
	array('handwriting', ''),
	array('spelling', ''),
	array('typing', ''),
	array('following directions', ''),
	array('letter formation', ''),
	array('decoding', ''),
	array('phonetic analysis', ''),
	array('seeing auditory text in print', ''),
	array('listening to ones own language', ''),
	array('storytelling', ''),
	array('poetry', ''),
	array('comprehension', ''),
	array('making recordings', ''),
	array('spelling', ''),
	array('text to speech', ''),

	array('Logic', ''),
	array('deductive reasoning', ''),
	array('inductive reasoning', ''),
	array('memory', ''),
	array('spatial reasoning', ''),
	array('problem solving', ''),
	array('holding attributes in mind', ''),
	array('classifying', ''),
	array('patterns', ''),

	array('Mathematics', ''),
	array('counting', ''),
	array('numeral recognition', ''),
	array('classifying', ''),
	array('seriating', ''),
	array('comparing quantities', ''),
	array('basic math facts', ''),
	array('mental math', ''),
	array('addition', ''),
	array('subtraction', ''),
	array('multiplication', ''),
	array('division', ''),
	array('measuring', ''),
	array('using time concepts', ''),
	array('graphing', ''),
	array('programming', ''),
	array('interpreting data', ''),

	array('Science', ''),
	array('observing', ''),
	array('similarities and differences', ''),
	array('making a hypothesis', ''),
	array('scientific vocabulary', ''),
	array('using intruments', ''),
	array('making collections', ''),
	array('taking things apart', ''),
	array('perspectives', ''),
	array('health', ''),
	array('maintaining life', ''),
	array('ecosystems', ''),

	array('Music', ''),
	array('creating music', ''),
	array('music theory', ''),
	array('audio discrimination', ''),
	array('rhythm', ''),
	array('notation', ''),
	
	array('Art/Creativity', ''),
	array('drawing', ''),
	array('building', ''),
	array('mixing colors', ''),
	array('publishing', ''),
	array('editing video', ''),
	
	array('Physical Education', ''),
	array('fine motor', ''),
	array('gross motor', ''),
	array('rhythm', ''),
	array('coordination', ''), 
	array('sports', ''),
	array('racing', ''),
	array('baseball', ''),
	array('basketball', ''),
	array('hockey', ''),
	array('football', ''),
	array('rugby', ''),
	array('track and field', ''),

	array('Utility', ''),
	array('classroom tools', ''),
	array('graphic arts', ''),
	array('Internet', ''),
	array('home planning', ''),

	array('Foreign Language', ''),
	array('Spanish', ''),
	array('French', ''),
	array('German', ''),

	array('Motivation', ''),
	array('planning', ''),
	array('organizing activities', ''),
	array('reviewing', ''),
	array('evaluating', ''),
	array('synthesis', ''),

	array('Social', ''),
	array('religion', ''),
	array('working cooperatively', ''),
	array('working competitavely', ''),
	array('sharing resources', ''),
	array('interpersonal problem solving', ''),
	array('intrapersonal problem solving', ''),

	array('Social Studies', ''),
	array('US history', ''),
	array('colonial history', ''),
	array('ancient history', ''),
	array('geography', ''),
	array('maps', ''),
	array('earth science', ''),

	array('Economics', ''),
	array('balancing a budget', ''),
	array('managing resources', ''),
);

// RECOMMENDATIONS
$recommendationCheckboxItems = array
(
	array('AllTimeBestApps', ''),
	array('Pioneer', ''),
	array('BestAndroid', ''),
	array('Augmented Reality', ''),
	array('Virtual Reality', ''),
	array('Health', ''),
	array('Holiday', ''),
	array('Halloween', ''),
	array('Summer Learning', ''),
	array('Back to School', ''),
	array('Transportation', ''),
	array('Horses', ''),
	array('Money', ''),
	array('Pets', ''),
	array('Montessori', ''),
	array('Coding', ''),
	array('Library Video Games', ''),
	array('Library Apps', ''),
	array('Library Toys', ''),
	array('KAPi', ''),
	array('BRDP', ''),
	array('Fiction', ''),
	array('NonFiction', ''),
	array('Camera', ''),
	array('WOSU', ''),
	array('STEM', ''),
	array('Maker', ''),
	array('Robots', ''),
	array('Art', ''),
	array('Astronomy', ''),
	array('Early Math', ''),
	array('Math', ''),
	array('Starter', ''),
	array('Early Reading', ''),
	array('Reading Skills', ''),
	array('Handwriting', ''),
	array('Music', ''),
	array('Geography', ''),
	array('History', ''),
	array('Science', ''),
	array('Biology', ''),
	array('Ecology', ''),
	array('Creativity', ''),
	array('Logic', ''),
	array('Geometry', ''),
	array('ESL', ''),
	array('Social', ''),
	array('Tablets', ''),
	array('Coop', ''),
	array('Road Trip', ''),
);

// LANGUAGES
$languageCheckboxItems = array
(
	array('English', ''),
	array('UK English', ''),
	array('Dutch', ''),
	array('Spanish', ''),
	array('Italian', ''),
	array('French', ''),
	array('German', ''),
	array('Japanese', ''),
	array('Mandarin Chinese', ''),
	array('Hindi', ''),
	array('Bengali', ''),
	array('Portuguese', ''),
	array('Russian', ''),
	array('Korean', ''),
	array('Turkish', ''),
	array('Arabic', ''),
	array('Finnish', ''),
	array('Swedish', ''),
	array('Polish', ''),
);

// SCAFFOLDING
$scaffoldingCheckboxItems = array
(
	array('no scaffolding', ''),
	array('word highlighting', ''),
	array('touch and hear words', ''),
	array('touch and hear sentences', ''),
	array('item labels', ''),
	array('rebus support', ''),
	array('record your own narration', ''),
	array('adjustable reading level', ''),
	array('font size', ''),
	array('font control', ''),
	array('dynamic language toggling', ''),
);
*/
?>