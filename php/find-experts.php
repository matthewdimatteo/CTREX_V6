<?php
/*
php/find-experts.php
By Matthew DiMatteo, Children's Technology Review

This file performs the find command to lookup CTR Expert Reviewers for the experts page
Each expert has a record in the 'subbies.fmp12' database with the 'subs::expert' field marked

This file creates an array of records and their data to be output in both a list and grid view

$showExperts and $showStudents are defined in 'php/settings.php' from the dashboard fields showExperts and showStudents
- these values must be configured in the database to "Show" if there are records of that type to be found
- this is to prevent a null error
- summary fields are too slow to process

*/

// LOOKUP EXPERT REVIEWERS ($showExperts defined in 'php/settings.php' - based on dashboard::showExperts in 'CSR.fmp12')
if($showExperts != NULL)
{
	// PERFORM FIND COMMAND - EXPERT REVIEWERS
    $findExperts = $fmsubs->newFindCommand($fmsubsLayout); 						// initialize the find command
    $findExperts->addFindCriterion('expert', "*"); 								// add find criteria
    $findExperts->addSortRule('Contact Last Name', 1, FILEMAKER_SORT_ASCEND);  	// add sort rules
    $findExperts->addSortRule('Contact First Name', 2, FILEMAKER_SORT_ASCEND); 	// add sort rules
    $result = $findExperts->execute(); 											// execute the command
    if (FileMaker::isError ($result) ) { echo 'Error looking up expert reviewers: '.$result->getMessage(); exit(); } 	// handle errors
    $records = $result->getRecords(); 											// get the records
    $numExperts = $result->getFoundSetCount(); 									// get the number of records found
    $numCols = 4;																// specify the number of columns for grid view
    $expertRows = ceil($numExperts / $numCols); 								// determine the number of rows to output for grid view

    // STORE RECORDS IN AN ARRAY FOR MULTIPLE VIEW MODE OUTPUTS
    $expertRecords = array(); 				// declare array to hold expert record data
    $e = -1; 								// counter
    $fields = $expertFields; 				// tell 'php/get-field.php' to use the $expertFields (defined in 'php/fields.php')
    foreach($records as $record)
    {
        require 'php/get-field.php'; 		// get field values from the database
        $e += 1; 							// increment the counter
        $expertRecords[$e] = $fieldValues; 	// assign record data to item in new array
    } // end foreach

} // end if $showExperts

// LOOKUP STUDENT REVIEWERS ($showStudents defined in 'php/settings.php' - based on dashboard::showStudents in 'CSR.fmp12')
if($showStudents != NULL)
{
    // PERFORM FIND COMMAND - STUDENT REVIEWERS
    $findStudents = $fmsubs->newFindCommand($fmsubsLayout);							// initialize the find command
    $findStudents->addFindCriterion('student', "*");								// add find criteria
    $findStudents->addSortRule('Contact Last Name', 1, FILEMAKER_SORT_ASCEND);  	// add sort rules
    $findStudents->addSortRule('Contact First Name', 2, FILEMAKER_SORT_ASCEND); 	// add sort rules
    $resultStudents = $findStudents->execute(); 									// execute the command
	if (FileMaker::isError ($resultStudents) ) { echo 'Error looking up student reviewers: '.$resultStudents->getMessage(); exit(); } 	// handle errors
    $studentRecords = $resultStudents->getRecords();								// get the records
    $numStudents = $resultStudents->getFoundSetCount();								// get the number of records found
    $studentRows = ceil($numStudents / $numCols);									// determine the number of rows to output for grid view

    // STORE RECORDS IN AN ARRAY FOR MULTIPLE VIEW MODE OUTPUTS
    $studentRecordsArray = array();					// declare array to hold student record data
    $s = -1;										// counter
    $fields = $expertFields;						// tell 'php/get-field.php' to use the $expertFields (defined in 'php/fields.php')
    foreach($studentRecords as $record)
    {
        require 'php/get-field.php';				// get field values from the database
        $s += 1;									// increment the counter
        $studentRecordsArray[$s] = $fieldValues;	// assign record data to item in new array
    } // end foreach
} // end if $showStudents

// LOOKUP BOLOGNA JURORS ($showJurorsBRDA defined in 'php/settings.php' - based on dashboard::showJurorsBRDA in 'CSR.fmp12')
if($showJurorsBRDA != NULL)
{
	// PERFORM FIND COMMAND - BOLOGNA JURORS
    $findBolognaJurors = $fmsubs->newFindCommand($fmsubsLayout);					// initialize the find command
    $findBolognaJurors->addFindCriterion('juror', "*");								// add find criteria
	$findBolognaJurors->addFindCriterion('jurorType', "bologna");					// add find criteria
	$findBolognaJurors->addSortRule('Contact Last Name', 1, FILEMAKER_SORT_ASCEND); // add sort rules
    $findBolognaJurors->addSortRule('Contact First Name', 2, FILEMAKER_SORT_ASCEND);// add sort rules
    $resultBolognaJurors = $findBolognaJurors->execute(); 							// execute the command
	if (FileMaker::isError ($resultBolognaJurors) ) { echo 'Error looking up BRDA jurors: '.$resultBolognaJurors->getMessage(); exit(); } 	// handle errors
    $bolognaJurorRecords = $resultBolognaJurors->getRecords();						// get the records
    $numBolognaJurors = $resultBolognaJurors->getFoundSetCount();					// get the number of records found
    $bolognaJurorRows = ceil($numBolognaJurors / $numCols);							// determine the number of rows to output for grid view

    // STORE RECORDS IN AN ARRAY FOR MULTIPLE VIEW MODE OUTPUTS
    $bolognaJurorRecordsArray = array();				// declare array to hold juror record data
    $b = -1;											// counter
    $fields = $expertFields;							// tell 'php/get-field.php' to use the $expertFields (defined in 'php/fields.php')
    foreach($bolognaJurorRecords as $record)
    {
        require 'php/get-field.php';					// get field values from the database
        $b += 1;										// increment the counter
        $bolognaJurorRecordsArray[$b] = $fieldValues;	// assign record data to item in new array
    } // end foreach

} // end if $showJurorsBRDA

// LOOKUP KAPI JURORS ($showJurorsKAPI defined in 'php/settings.php' - based on dashboard::showJurorsKAPI in 'CSR.fmp12')
if($showJurorsKAPI != NULL)
{
	// PERFORM FIND COMMAND - KAPI JURORS
    $findKapiJurors = $fmsubs->newFindCommand($fmsubsLayout);					// initialize the find command
    $findKapiJurors->addFindCriterion('juror', "*");							// add find criteria
	$findKapiJurors->addFindCriterion('jurorType', "kapi");						// add find criteria
	$findKapiJurors->addSortRule('Contact Last Name', 1, FILEMAKER_SORT_ASCEND); // add sort rules
    $findKapiJurors->addSortRule('Contact First Name', 2, FILEMAKER_SORT_ASCEND);// add sort rules
    $resultKapiJurors = $findKapiJurors->execute(); 							// execute the command
	if (FileMaker::isError ($resultKapiJurors) ) { echo 'Error looking up KAPi jurors: '.$resultKapiJurors->getMessage(); exit(); } 	// handle errors
    $kapiJurorRecords = $resultKapiJurors->getRecords();						// get the records
    $numKapiJurors = $resultKapiJurors->getFoundSetCount();						// get the number of records found
    $kapiJurorRows = ceil($numKapiJurors / $numCols);							// determine the number of rows to output for grid view

    // STORE RECORDS IN AN ARRAY FOR MULTIPLE VIEW MODE OUTPUTS
    $kapiJurorRecordsArray = array();				// declare array to hold juror record data
    $k = -1;										// counter
    $fields = $expertFields;						// tell 'php/get-field.php' to use the $expertFields (defined in 'php/fields.php')
    foreach($kapiJurorRecords as $record)
    {
        require 'php/get-field.php';				// get field values from the database
        $k += 1;									// increment the counter
        $kapiJurorRecordsArray[$k] = $fieldValues;	// assign record data to item in new array
    } // end foreach
} // end if $showJurorsKAPI

// store the experts page as a search so that user can return to it from expert profiles
$_SESSION['lastSearchType'] = 'experts';
//$_SESSION['lastSearch'] 	= $thisURL;
?>