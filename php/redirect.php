<?php
/*
php/redirect.php
By Matthew DiMatteo, Children's Technology Review

This file performs a redirect using the meta tag below
When including this file, specify a $redirect value beforehand to direct to a particular page - by default, this value is set to the home page
A $pageTitle value can also be specified beforehand, defaulting to 'Processing...' if not specified
*/
if($redirect == NULL)	{ $redirect = 'home.php'; }
if($pageTitle == NULL) 	{ $pageTitle = 'Processing...'; }
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
<meta http-equiv="refresh" content="0;url=<?php echo $redirect;?>">

<!-- FAVICON -->
<link rel = "icon" href = "images/favicon.ico" type = "image/x-icon">

<!-- CSS -->
<link href="css/main.css" 	rel="stylesheet" type="text/css">

<!-- PAGE TITLE -->
<title><?php echo $pageTitle;?></title>

</head>

<!-- BODY -->
<body>
</body>
</html>