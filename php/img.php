<?php
//require_once 'fmview.php';
require_once 'FileMaker.php';
//require_once 'error.php';

//$cgi = new CGI();

$fmImage = & new FileMaker();
$fmImage->setProperty('database', 'CSR');
$fmImage->setProperty('username', 'webctr');
$fmImage->setProperty('password', 'webctrpassword');
//ExitOnError($fmImage);

if (isset($_GET['-url']))
{
	$url = $_GET['-url'];
	$url = substr($url, 0, strpos($url, "?"));
	$url = substr($url, strrpos($url, ".") + 1);
	if($url == "jpg")		{ header('Content-type: image/jpeg'); }
	else if($url == "gif")	{ header('Content-type: image/gif'); }
	else 					{ header('Content-type: application/octet-stream'); }
	echo $fmImage->getContainerData($_GET['-url']);
} // end if
if (FileMaker::isError ($fmImage) ) { echo $fmImage->getMessage(); }
?>