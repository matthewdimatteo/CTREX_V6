<?php
/*
content-profile-license.php
By Matthew DiMatteo, Children's Technology Review

This file displays a site license organization profile using a tab control for different groups of data
It is included in the file 'content-profile.php'

For subscriber profiles, refer to 'content-profile-subscriber.php'
For publisher profiles, refer to 'content-profile-publisher.php'
*/

// get the field values from the 'subbies.fmp12' database file
require_once 'php/get-license.php';

// specify an array of items for the tab control
$sections = array
(
	array('contact', 'Contact'),
	array('admins', 'Admins')
);
if($siteAdmin == true and $siteName == $inputID and $inputMode == 'private') { array_push($sections, array('usage', 'Usage')); }//usage report tab for site admin

?>

<!-- PAGE HEADER -->
<div class = "profile-header"><?php echo $siteOrg;?>'s CTREX Profile</div><!-- /.profile-header -->
	
<?php
// EDIT CONTROLS FOR SITE ADMIN
if($siteAdmin == true and $siteName == $inputID)
{
	if($inputMode == 'private')
	{
		$previewLink = 'profile.php?id='.$inputID.'&type=license&mode=public';
		$previewLabel = 'View as Public';
		echo '<div class = "profile-options profile-edit-mode">[Edit Mode]</div>';
	}
	else if($inputMode == 'public')
	{
		$previewLink = 'profile.php?id='.$inputID.'&type=license&mode=private';
		$previewLabel = 'Edit Profile';
	}
	echo '<div class = "profile-options"><a href = "'.$previewLink.'">'.$previewLabel.'</a></div>';
} // end if $siteAdmin
?>

<!-- SECTIONS -->
<div id = "profile-container-license"><?php require_once 'php/profiles/profile-sections.php';?></div><!-- /#profile-container-license -->

<?php
// ADD ORGANIZATION NAME TO PAGE TITLE
//if($siteOrg != NULL)
//{
	if($pageTitle == NULL) { $pageTitle = 'CTREX Profile'; }
	$pageTitle .= ' - '.$siteOrg;
	echo '<script>setPageTitle(\''.$pageTitle.'\');</script>';
//} // end if $siteOrg
?>