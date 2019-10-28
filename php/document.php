<?php
/*
document.php
By Matthew DiMatteo, Children's Technology Review

This file is included in the file 'autoload.php'
It contains the html document structure for each page in the directory (not including redirect pages)
It defines certain global variables based on the parameters set on each particular page, includes all meta tags, favicon, css, and js
Separate files for the site header, footer, and content for each page are also included in this file
*/
if($pageTitle == NULL) 	{ $pageTitle = 'CTREX'; }
if($pageType != NULL) 	{ $pageClass = 'content'; } 
$pageClass 	= 'template-'.$pageType; // determines CSS class to use for page content

if($pageType != 'search') 	{ $searchType = $lastSearchType; } // use last search type (set in find files)
if($searchType == NULL) 	{ $searchType = 'reviews'; }
$searchformFile = 'php/search-form-'.$searchType.'.php';
if($searchType == 'experts') { $searchformFile = 'php/search-form-reviews.php'; } // custom override to search reviews from experts page/profiles
$findFile 		= 'php/find-'.$searchType.'.php';
?>

<!-- HTML -->
<!doctype html>
<html>

<!-- HEAD -->
<head>

<!-- META -->
<meta charset="UTF-8">
<meta name = "description" content = "Objective reviews of children's apps, toys, games, and other interactive media"/>
<meta name="google-site-verification" content="QifxFlcb5iOlsJFTJF2jL-h3lpo12RQeFuOyK6aak8k" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- FAVICON -->
<link rel = "icon" href = "images/favicon.ico" type = "image/x-icon">

<!-- CSS -->
<link href="css/main.css" 			rel="stylesheet" type="text/css"><!-- primary CSS rules -->
<link href="css/screen-1025.css" 	rel="stylesheet" type="text/css"><!-- RWD rules for tablet landscape -->
<link href="css/screen-769.css" 	rel="stylesheet" type="text/css"><!-- RWD rules for tablet portrait -->
<link href="css/screen-480.css" 	rel="stylesheet" type="text/css"><!-- RWD rules for mobile portrait -->
<link href="css/print.css" 			rel="stylesheet" type="text/css"><!-- print CSS rules -->

<!-- PAGE TITLE -->
<title><?php echo $pageTitle;?></title>

<!-- JAVASCRIPT -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src = "js/scripts.js"></script>
</head>

<!-- BODY -->
<body 
<?php 
if($onload != NULL) 		{ echo 'onload = "'.$onload.'"'; } 
if($beforeUnload != NULL) 	{ echo 'onbeforeunload = "'.$beforeUnload.'"'; }
?>>
<div id = "main">
<?php
if($pageType == 'search') 	{ require_once $findFile; }
require_once $searchformFile;
if($pageType != 'zoom') 	{ require_once 'php/header.php'; }
require_once 'php/debug-output.php'; // display variable values in debugging mode
require_once 'php/content.php';
require_once 'php/footer.php'; 
?>
</div><!-- /#main -->
</body>
</html>