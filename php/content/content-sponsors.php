<?php
/*
php/content/content-sponsors.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the sponsors page
*/

// add hyperlink to contact page
$sponsorsText = str_replace('contact us', '<a href = "contact.php">contact us</a>', $sponsorsText);
?>

<!-- PAGE CONTAINER -->
<div id = "sponsors-page-container">

<!-- PAGE HEADER -->
<div class = "page-header"><?php echo $sponsorsHeader;?></div>

<!-- PAGE BODY -->
<div id = "sponsors-text" class = "paragraph center text-18 top-10 bottom-30"><?php echo nl2br($sponsorsText);?></div>

<?php
echo '<div class = "paragraph center text-24 bottom-20">';

    // LOOKUP PRODUCERS RECORDS MARKED AS SPONSORS ($showSponsors defined in 'php/settings.php' - based on dashboard::showSponsors in 'CSR.fmp12')
    if($showSponsors != NULL)
    {
        $findSponsors = $fmpubs->newFindCommand($fmpubsLayout);						// initialize the find command
        $findSponsors->addFindCriterion('sponsor', "*");							// add find criteria
        $findSponsors->addSortRule('Company Name', 1, FILEMAKER_SORT_ASCEND);  		// add sort rules
        $findSponsors->addSortRule('Contact Last Name', 2, FILEMAKER_SORT_ASCEND); 	// add sort rules
        $findSponsors->addSortRule('Contact First Name', 3, FILEMAKER_SORT_ASCEND); // add sort rules
        $resultSponsors = $findSponsors->execute(); 								// execute the command
        if (FileMaker::isError ($resultSponsors) ) { echo 'Error looking up sponsors: '.$resultSponsors->getMessage(); exit(); } 	// handle errors
        $sponsorRecords = $resultSponsors->getRecords();							// get the records
        $numSponsors = $resultSponsors->getFoundSetCount();							// get the number of records found
		
		// OUTPUT LIST
        foreach($sponsorRecords as $record)
        {
			require 'php/get-pub.php'; // get field values and assign to variables
            echo '<div>';
				if($linkWebsite != NULL) { echo '<a href = "http://'.$linkWebsiteParsed.'" target = "_blank">'; }
					echo $companyName;
				if($linkWebsite != NULL) { echo '</a>'; }
			echo '</div>';
        } // end foreach
        echo '<div class = "top-10 text-24"><a href = "contact.php">Contact us</a> to become a sponsor and join this list.</div>';

    } // end if $showSponsors
	
	// BE THE FIRST
    else { echo 'Be the first - <a href = "contact.php">Contact Us</a>.'; } // end else no sponsors

    // DEBUG SPONSORS
	//$sponsorDebug = true;
	if($sponsorDebug == true)
	{
        $sponsorsDebugArray = array
        (
            array('Test Sponsor 1', 'Contact FName, Contact LName, 9/6/2019'),
            array('Test Sponsor 2', 'Contact FName, Contact LName, 9/7/2019'),
            array('Test Sponsor 3', 'Contact FName, Contact LName, 9/9/2019'),
        );
        $numDebugSponsors = count($sponsorsDebugArray);

        // LIST OF DEBUG SPONSORS
        if($numDebugSponsors > 0)
        {

            foreach($sponsorsDebugArray as $thisSponsor)
            {
                $thisSponsorCompany = $thisSponsor[0];
                $thisSponsorFName 	= $thisSponsor[1];
                $thisSponsorLName 	= $thisSponsor[2];
                $thisSponsordate 	= $thisSponsor[3];
                echo '<div>'.$thisSponsorCompany.'</div>';
            } // end foreach
            echo '<div class = "top-10 text-20"><a href = "contact.php">Contact us</a> to become a sponsor and join this list.</div>';
        } // end if $numDebugSponsors > 0
		
		// BE THE FIRST
    	else { echo 'Be the first - <a href = "contact.php">Contact Us</a>.'; } // end else no sponsors
	} // end if $sponsorDebug == true
    
echo '</div>'; // /.paragraph center bottom-20

// CONTACT INFO
echo '<div class = "text-18 bottom-30">';
	require_once 'php/contact-info.php';
echo '</div>';
?>

<!-- INDIVIDUAL SUPPORTERS -->
<div class = "text-24 bottom-20">For individuals interested in supporting CTREX:</div>
<div class = "paragraph center">
	<?php require_once 'php/supporter-forms.php';?></br>
	Individual supporters are listed on our <a href = "supporters.php">Supporters Page</a>.
</div>

</div><!-- /#sponsors-page-container -->