<?php
/*
php/profiles/license/section-admins.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the content of the 'Administrators' tab of the Organization Profile page
It is included dynamically in 'php/profiles/profile-sections.php'
*/

// SECTION CONTAINER
echo '<div id = "admins-info" class = "profile-section-contact">';

	// SECTION HEADER - ORGANIZATION ADMINISTRATORS
	echo '<div class = "profile-section-header">Organization Administrators</div>'; // /.profile-section-header
	
	if($numActiveAdmins > 0)
	{
		echo '<div class = "paragraph-70 center">';
		foreach($activeAdminsList as $admin)
		{
			$adminFirstName 	= $admin[0];
			$adminLastName 		= $admin[1];
			$adminJobTitle 		= $admin[2];
			$adminEmail	 		= $admin[3];
			$adminFullName = formatFullName($adminFirstName, $adminLastName);
			$adminActive		= $admin[4];
			echo $adminFullName; if($adminJobTitle != NULL) { echo ', '.$adminJobTitle; } echo '<br/>';
			if($adminEmail != NULL) { echo '<a href = "mailto:'.$adminEmail.'">'.$adminEmail.'</a><br/>'; } 
			echo '<br/>';
		} // end foreach
		echo '</div>';
	} // end if $numActiveAdmins > 0
	else
	{
		echo '<p>No active administrators listed</p>';
	} // end else 0 active admins
	if($inputMode == 'private') { echo '<div class = "paragraph-70 center"><a href = "contact.php">Contact us to update this information</a></div>'; }
	
echo '</div>'; // /#admins-info .profile-section-contact
?>