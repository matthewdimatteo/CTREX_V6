<?php
/*
php/profiles/content-profile-publisher.php
By Matthew DiMatteo, Children's Technology Review

This file displays a publisherer profile using a tab control for different groups of data
It is included in the file 'php/content-profile.php'

For subscriber profiles, refer to 'php/profiles/content-profile-subscriber.php'
For site license organizational profiles, refer to 'php/profiles/content-profile-license.php'
*/

// GET FIELD VALUES
require_once 'php/get-pub.php'; // get field values from 'Producers.fmp12' database

// determine what to show for private vs. public
switch($inputMode)
{
		// PRIVATE
	case 'private' 	: 
		$previewClass 	= 'block';
		$previewLabel 	= 'View Public Profile';
		$previewLink 	= 'profile.php?id='.$userID.'&type=publisher&mode=public';
		
		// specify an array of items for the tab control
		$sections = array
		(
			array('about'		, 'About'),
			array('account'		, 'Account'),
			array('industry'	, 'Insider'),
			array('submissions'	, 'Submissions'),
			array('titles'		, 'Titles*'),
			array('description'	, 'Description*'),
			array('links'		, 'Links*'),
			array('contact'		, 'Contact*'),
		);
		break;
	
	// PUBLIC
	case 'public'	:
		if($userID == $inputID)
		{
			$previewClass = 'block';
			$previewLabel = 'Return to Edit Mode';
			$previewLink = 'profile.php?id='.$inputID.'&type=publisher&mode=private';
			$previewNoteClass = 'hide';
		}
		else
		{
			$previewClass = 'hide';
			$previewLabel = '';
			$previewLink = '';
			$previewNoteClass = 'text-12';
		}
		$sections = array();
		if($numTitlesReviewed > 0)	{ array_push($sections, array('titles'		, 'Titles'));}
		if($description != NULL) 	{ array_push($sections, array('description'	, 'Description')); }
		if($numLinks >0) 			{ array_push($sections, array('links'		, 'Links')); }
		if($hasContactInfo == true)	{ array_push($sections, array('contact'		, 'Contact')); }
		break;
} // end switch($inputMode)

// ADD COMPANY NAME TO PAGE TITLE
if($companyName != NULL)
{
	if($pageTitle == NULL) { $pageTitle = 'CTREX Profile'; }
	$pageTitle .= ' - '.$companyName;
	echo '<script>setPageTitle(\''.$pageTitle.'\');</script>';
} // end if $companyName
?>

<!-- PAGE CONTAINER -->
<div id = "profile-container-publisher">

	<!-- PREVIEW PUBLIC-->
	<div id = "preview-public-container" class = "<?php echo $previewClass;?>">
		<div class = "profile-options profile-edit-mode">
			<?php if($inputMode == 'private') { echo '[Edit Mode]'; } ?> <a href = "<?php echo $previewLink;?>"><?php echo $previewLabel;?></a>
		</div><!-- /.profile-options -->
	</div><!-- /#preview-public-container -->
		
	<?php
	// LOGO
	if($linkLogo != NULL)
	{
		echo '<div class = "inline profile-pub-logo"><img src = "http://'.$linkLogo.'" /></div>'; // display logo as left col
		echo '<div class = "inline profile-pub-heading">'; // start a col for center heading
	}
	?>
	<!-- PAGE HEADER -->
	<div class = "profile-header">CTREX Publisher Profile: <?php echo $companyName;?></div><!-- /.profile-header -->

	<!-- COMPANY LINKS -->
	<div class = "profile-options">
		<?php
		if($linkWebsite != NULL) 
		{ 
			echo '<div class = "inline left-20 right-20">';
				echo '<a href = "http://'.$linkWebsite.'" target = "_blank">View the publisher\'s website</a>';
			echo '</div>'; // /.inline
		}
		if($numTitlesReviewed > 0)
		{
			echo '<div class = "inline left-20 right-20">';
				echo '<a href = "'.$moreTitlesURL.'" title = "See all product reviews for titles by this publisher">See all titles reviewed</a>';
			echo '</div>'; // /.inline
		}
		if($userID == $inputID)
		{
			echo '<div class = "inline left-20 right-20">';
				echo '<a href = "submit.php" title = "Submit products for review">Submit products for review</a>';
			echo '</div>'; // /.inline
		}
		?>
	</div><!-- /.profile-options -->
	<?php
	// LOGO OFFSET PADDING
	if($linkLogo != NULL)
	{
		echo '</div>'; // close the center col
		echo '<div class = "inline profile-pub-logo"></div>'; // right-col padding to offset left col logo 
	}
	?>
	
	<!-- PUBLIC/PRIVATE NOTE -->
	<div class = "<?php echo $previewNoteClass;?>">
		<em>*Denotes content that will appear on <a href = "<?php echo $previewLink;?>">public profile</a></em>
	</div><!-- /.$previewNoteClass -->
		
	<!-- TAB CONTROL -->
	<?php require_once 'php/profiles/profile-sections.php'; // outputs each section as a tab ?>
	
</div><!-- /#profile-container-publisher -->