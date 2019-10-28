<!--
php/profiles/subscriber/section-about.php
By Matthew DiMatteo, Children's Technology Review

This file contains the content for the 'About' section of the private (editable subscriber profile)
It is one of multiple files for each profile section

Each of these files must follow the filename convention:
'section-' followed by the string used to define a section in the $sections array in php/profiles/content-profile-subscriber.php
-->

<div class = "paragraph-container">
	<div class = "paragraph-90 left" id = "about-info">
		This is your <strong>CTREX Profile Page</strong>, a dashboard for you to manage information associated with your CTREX subscription.<br/>
		<br/>
		Use the tab control to view different information. To make any corrections, modify those fields and select 'Update'. 
		If you need help or have questions, <a href = "contact.php">contact us</a>.<br>
		<br>
		You are currently viewing your profile in <strong>Edit Mode</strong>. <strong>Only you have access to this feature</strong>.<br/><br/>
		<?php
		// IF EXPERT - indicate that public profile is shared by default
		if($expert == true)
		{
			echo 'As a <strong>CTR <a href = "experts.php">Expert Reviewer</a/></strong>, a <strong><a href = "'.$previewLink.'">public version of your profile</a> is visible by default</strong>. ';
			echo 'Select the link above to view it.';
		} // end if expert
		
		// ELSE IF NOT EXPERT - include message about toggling public profile visibility
		else
		{
			echo 'You can <strong>share a <a href = "'.$previewLink.'">public (read-only) version of your profile</a></strong> with others by selecting the <strong>\'Share\'</strong> option. ';
			echo '<br/><strong>By leaving this option off, your profile remains entirely private.</strong>';
		} // end if not expert
		?>
	</div><!-- /.paragraph-90 left #about-info -->
</div><!-- /.paragraph-container -->