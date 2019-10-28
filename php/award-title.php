<?php
/*
php/award-title.php
By Matthew DiMatteo, Children's Technology Review

This file outputs a related title for a BolognaRagazzi or KAPi award. It is included in the file 'php/content/content-award.php'
The $titlesArray value must be specified before including this file.
*/
if($titlesArray != NULL)
{
	foreach($titlesArray as $thisTitle)
	{
		$titleType			= $thisTitle[0];
		$titleName 			= $thisTitle[1];
		$titleReviewID		= $thisTitle[2];
		$titleReviewLink	= $thisTitle[3];
		$titleCompany		= $thisTitle[4];
		$titleCompanyLink	= $thisTitle[5];
		$titleCountry		= $thisTitle[6];
		$titleDescription	= $thisTitle[7];
		$titleImg			= $thisTitle[8];
		$titleImgData		= $thisTitle[9];
		$titleItunes		= $thisTitle[10];
		$titleAndroid		= $thisTitle[11];
		$titleAmazon		= $thisTitle[12];
		$titleSteam			= $thisTitle[13];
		$titleCategory		= $thisTitle[14];
		
		if($titleImg != NULL and $titleImgData != '?')
		{
			$titleHasImage = true;
			$titleImgClass = 'inline width-10 right-20 award-title-img';
			$titleTextClass = 'inline width-80 award-title-text';
		} // end if $titleImg
		else
		{
			$titleHasImage = '';
			$titleImgClass = 'hide';
			$titleTextClass = 'full-width';
		} // end else no image
		
		// OUTPUT TITLE BLOCK
		echo '<div class = "bottom-20">';
		
			if($titleHasImage == true)
			{
				echo '<div class = "'.$titleImgClass.'">';
					echo '<a href = "'.$titleReviewLink.'" title = "Read our review of '.$titleName.'">'; 
						echo '<img src = "php/img.php?-url='.urlencode($titleImg).'" alt = "Image not available" />';
					echo '</a>';
				echo '</div>'; // /.$titleImgClass
			} // end if $titleHasmage

			echo '<div class = "'.$titleTextClass.'">';
				if($titleCategory != NULL and ($awardType == 'kapi' or $awardType == 'kapis')) { echo '<strong>'.$titleCategory.': </strong>'; }
				if($titleReviewLink != NULL and $titleName != NULL) 	{ echo '<a href = "'.$titleReviewLink.'" title = "Read our review of '.$titleName.'">'; }
				if($titleName != NULL) 									{ echo $titleName; }
				if($titleReviewLink != NULL and $titleName != NULL)  	{ echo '</a>'; }
				if($titleCategory != NULL and $awardType == 'bologna') 	{ echo ' ('.$titleCategory.')'; }
				if($titleName != NULL and $titleCompany != NULL) 		{ echo ' by '; }

				if($titleCompany != NULL and $titleCompanyLink != NULL)	{ echo '<a href = "http://'.$titleCompanyLink.'" target = "_blank" title = "Visit the company website">'; }
				if($titleCompany != NULL)								{ echo $titleCompany; }
				if($titleCompany != NULL and $titleCompanyLink != NULL)	{ echo '</a>'; }
				if($titleCompany != NULL and $titleCountry != NULL)		{ echo ' - '; }
				if($titleCountry != NULL)								{ echo $titleCountry; }

																		  echo '<br/>';
				if($titleDescription != NULL)							{ echo ucfirst(nl2br($titleDescription)).' '; }
				if($titleItunes != NULL)								{ echo '<a href = "'.$titleItunes.'" target = "_blank" title = "View in app store">iOS</a>'; }
				if($titleItunes != NULL and $titleAndroid != NULL)		{ echo ', '; }
				if($titleAndroid != NULL)								{ echo '<a href = "'.$titleAndroid.'" target = "_blank" title = "View in app store">Android</a>'; }
				if($titleAmazon != NULL and ($titleItunes != NULL or $titleAndroid != NULL)) { echo ', '; }
				if($titleAmazon != NULL)								{ echo '<a href = "'.$titleAmazon.'" target = "_blank" title = "View in app store">Amazon</a>'; }
				if($titleSteam != NULL and ($titleItunes != NULL or $titleAndroid != NULL or $titleAmazon != NULL)) { echo ', '; }
				if($titleSteam != NULL)									{ echo '<a href = "'.$titleSteam.'" target = "_blank" title = "View in app store">Steam</a>'; }
			echo '</div>'; // /.$titleTextClass
		echo '</div>'; // /.bottom-10
	} // foreach winners1
} // end if $titlesArray
?>