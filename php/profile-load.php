<?php
if($pageTitle == NULL) 	{ $pageTitle = 'CTREX'; }
if($pageType != NULL) 	{ $pageClass = 'content'; } 
$pageClass 	= 'template-'.$pageType; // determines CSS class to use for page content
if($searchType == NULL) { $searchType = 'reviews'; }
$searchformFile = 'php/search-form-'.$searchType.'.php';
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
<link href="css/main.css" 	rel="stylesheet" type="text/css">

<!-- PAGE TITLE -->
<title><?php echo $pageTitle;?></title>

<!-- JAVASCRIPT -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src = "js/scripts.js"></script>
</head>

<!-- BODY -->
<body <?php if($onload != NULL) { echo 'onload = "'.$onload.'"'; } ?>>
<div id = "main">
<?php
require_once $searchformFile;
require_once 'php/header.php';
if($debug == true) { require_once 'nav-debug.php'; }
require_once 'php/content.php';
require_once 'php/footer.php'; 
?>
</div><!-- /#main -->
</body>
</html>
</html>