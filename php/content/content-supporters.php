<!--
php/content/content-supporters.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the supporters page
-->

<!-- PAGE HEADER -->
<div class = "page-header">CTREX Supporters</div>
<!--<div class = "subheader">Coming Soon</div>-->

<!-- INFO -->
<div id = "supporters-info" class = "paragraph text-18 center bottom-10">
	<p>CTR subscribers are shareholders in our work. Paid subscriptions keep us free from ads, affiliate links, or social agendas.</p>
	<p>We rely on each subscriber to support the reviews - more subscribers means more income so we can cover more products.</p>
</div><!-- /.paragraph center bottom-20 -->



<?php
// ORDER FORM BTNS -->
require_once 'php/supporter-forms.php';
?>


<div id = "supporters-sponsors-link" class = "text-20 bold top-40 bottom-30">
	For organizations interested in supporting CTREX as sponsors, please visit our <a href = "sponsors.php">Sponsors Page</a>.
</div>

<?php
// LIST OF SUPPORTERS  ($showSupporters defined in 'php/settings.php' - based on dashboard::showSupporters in 'CSR.fmp12')
if($showSupporters != NULL)
{
	$findSupporters = $fmsubs->newFindCommand($fmsubsLayout);						// initialize the find command
    $findSupporters->addFindCriterion('supporter', "*");							// add find criteria
    $findSupporters->addSortRule('Contact Last Name', 1, FILEMAKER_SORT_ASCEND);  	// add sort rules
    $findSupporters->addSortRule('Contact First Name', 2, FILEMAKER_SORT_ASCEND); 	// add sort rules
    $resultSupporters = $findSupporters->execute(); 								// execute the command
	if (FileMaker::isError ($resultSupporters) ) { echo 'Error looking up supporters: '.$resultSupporters->getMessage(); exit(); } 	// handle errors
    $supporterRecords = $resultSupporters->getRecords();							// get the records
    $numSupporters = $resultSupporters->getFoundSetCount();							// get the number of records found
	
	// STORE RECORDS IN AN ARRAY FOR MULTIPLE VIEW MODE OUTPUTS
    $supporterRecordsArray = array();				// declare array to hold supporter record data
    $s = -1;										// counter
    $fields = $expertFields;						// tell 'php/get-field.php' to use the $expertFields (defined in 'php/fields.php')
    foreach($supporterRecords as $record)
    {
        require 'php/get-field.php';				// get field values from the database
        $s += 1;									// increment the counter
        $supporterRecordsArray[$s] = $fieldValues;	// assign record data to item in new array
    } // end foreach
	
	// OUTPUT LIST OF SUPPORTERS
	echo '<div class = "page-header">Individual Supporters:</div>';
	$array = $supporterRecordsArray;
	echo '<div class = "paragraph-70 bottom-10">';
		require 'php/supporter-items.php';
	echo '</div>';
} // end if $showSupporters
?>

<!-- HOME -->
<div class = "text-18"><a href = "<?php echo $lastSearchReviews;?>">Home</a></div>