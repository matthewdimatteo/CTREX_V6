<?php
/*
php/profiles/profile-update-commit.php
By Matthew DiMatteo, Children's Technology Review

This file performs the database commit for a subscriber or publisher profile update
The file 'profile-update.php' defines an array of $fields specified in 'php/profiles/section-fields.php'
*/

// echo '$inputType: '.$inputType.'<br/>'; echo '$inputSection: '.$inputSection.'<br/>';

// check that $fields array (defined in 'profile-update.php' to reference array in 'php/profiles/section-fields.php') has values
if($fields != NULL)
{
	// get the input field values and set the database record's fields with those values
	$inputValues 	= array();
	$i = -1;
	//echo '<table>';
	foreach($fields as $field)
	{
		$inputFieldName 	= $field[0];
		$databaseFieldName 	= $field[1];
		$inputVarName 	= 'input'.ucfirst($inputFieldName);
		$$inputVarName 	= test_input($_POST[$inputFieldName]);
		$inputVarValue 	= $$inputVarName;
		$recordVarName 	= 'record'.ucfirst($inputFieldName);
		$$recordVarName = $record->getField($databaseFieldName);
		$recordVarValue = $$recordVarName;
		$i += 1;
		$inputValues[$i] = array($inputVarName, $inputVarValue, $databaseFieldName, $recordVarName, $recordVarValue);
		/*
		// DEBUG OUTPUT
		//echo $i.'. '.$inputVarName.': '.$inputVarValue.' --> '.$databaseFieldName.' ('.$recordVarName.': '.$recordVarValue.')<br/>';
		echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$inputFieldName.'</td>';
			echo '<td>$'.$inputVarName.'</td>';
			echo '<td>'.$inputVarValue.'</td>';
			echo '<td>'.$databaseFieldName.'</td>';
			echo '<td>$'.$recordVarName.'</td>';
			echo '<td>'.$recordVarValue.'</td>';
		echo '</tr>';
		//echo '<tr><td>'.$inputFieldName.'</td><td>'.$databaseFieldName.'</td></tr>';
		*/
		$record->setField($databaseFieldName, $inputVarValue);
	} // end foreach $field
	//echo '</table>'; 
	// exit(); // debug exit

	// define the redirect destination
	$redirect = 'profile.php?id='.$userID.'&type='.$inputType.'&mode=private';

	// commit the record edits
	$result= $record->commit();
	if ( FileMaker::isError ($result) ) 
	{ 
		echo 'error on commit ('.$inputSection.' section)<br/>'; echo $result->getMessage(); 
		echo '<br/><a href = "'.$redirect.'">Return to Profile</a>'; exit();
		require_once 'php/redirect.php'; exit();
	} // end if error
	
	// return to user profile
	require_once 'php/redirect.php'; exit();
} // end if $fields
?>