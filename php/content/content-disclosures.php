<?php
/*
php/content/content-disclosures.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the disclosures page
It is included dynamically in the file 'php/document.php'
*/

// PAGE HEADER
if($disclosuresHeader != NULL) 	{ echo '<div class = "page-header">'.$disclosuresHeader.'</div>'; }

// PAGE BODY
echo '<div class = "paragraph left bottom-10">';

	// INTRO
	if($disclosuresIntro != NULL) { echo '<p>'.parseLinksOld($disclosuresIntro).'</p>'; }
	
	// SOURCES OF INCOME
	if(count($disclosuresIncomeItems > 0))
	{
		echo '<p>';
		for($i = 0; $i <= count($disclosuresIncomeItems); $i++)
		{
			$incomeItem 		= $disclosuresIncomeItems[$i];
			$incomeDescription 	= $disclosuresIncomeDescriptions[$i];
			if($incomeItem != NULL)
			{
				echo '<strong>'.$incomeItem.'</strong>';
				if($incomeDescription != NULL) { echo parseLinksOld($incomeDescription); }
				echo '<br/>';
			} // end if $incomeItem
		} // end for
		echo '</p>';
	} // end if $disclosuresIncomeItems
	
	// ADVERTISING AND SPONSORSHIP RELATIONSHIPS
	if($disclosuresRelHeader == NULL)
	{
		$disclosuresRelHeader = 'ADVERTISING AND SPONSORSHIP RELATIONSHIPS<br/></br>In order to be a sponsor or underwriter (e.g., for research), the business partner must meet the following conditions:';
	} // end if !$disclosuresRelHeader
	if(count($disclosuresRelItems) > 0)
	{
		echo '<ul>';
		for($i = 0; $i <= count($disclosuresRelItems); $i++)
		{
			$thisRelItem = $disclosuredRelItems[$i];
			if($thisRelItem != NULL) { echo '<li>'.parseLinksOld($thisRelItem).'</li>'; }
		} // end for
		echo '</ul>';
	} // end if $disclosuresRelItems
	
	// CONCLUSION, DATE MODIFIED
	if($disclosuresConclusion != NULL) 		{ echo '<p>'.parseLinksOld($disclosuresConclusion).'</p>'; }
	if($disclosuresDateModified != NULL) 	{ echo 'Last update: '.$disclosuresDateModified; }
echo '</div>'; // /.paragraph left bottom-10
?>