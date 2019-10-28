<!--
php/profiles/profile-sections.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the tab control menu and sections for a profile page's content
The $sections array is defined in each profile content file (such as 'php/profiles/content-profile-subscribers.php')

The JavaScript function showProfileSection(index, count) is defined in 'js/scripts.js'
It takes the $index value as a parameter to display whichever section was selected and the $count (number of sections) to hide all others

The $sectionFile string is calculated based on the $id value
Each tab's content should have a corresponding file in the directory for the type of user profile (such as php/profiles/subscriber/section-name.php)
-->

<!-- HIDDEN INPUT WITH # OF SECTIONS -->
<?php $numSections = count($sections); if($inputMode == 'public') { $numSections = 0; } ?>
<div class = "hide"><input type = "hidden" id = "num-profile-sections" value = "<?php echo $numSections;?>" /></div>

<!-- TAB CONTROL MENU -->
<div class = "profile-tab-menu-container">
	<?php
	$index = -1;
	$count = count($sections);
	foreach($sections as $section)
	{
		$index += 1;
		$id 	= $section[0];
		$label 	= $section[1];
		echo '<div class = "profile-tab-menu-item">';
			echo '<div class = "profile-tab-menu-btn" 	id = "tab-btn-'.$index.'" onclick = "showProfileSection('.$index.', '.$count.')">'.$label.'</div>';
			echo '<div class = "profile-tab-menu-label" id = "tab-label-'.$index.'">'.$label.'</div>';
		echo '</div>'; // /.profile-tab-menu-item
	}
	?>
</div><!-- /.profile-tab-menu-container -->

<!-- CONTENT SECTIONS -->
<div class = "profile-section-container">
	<?php
	$index = -1;
	foreach($sections as $section)
	{
		$index += 1;
		$id 			= $section[0];
		$label 			= $section[1];
		$sectionFile	= 'php/profiles/'.$inputType.'/section-'.$id.'.php';
		echo '<div class = "profile-section" id = "profile-section-'.$index.'">';
			//echo $label.'<br/>require_once '.$sectionFile;
			require_once $sectionFile;
		echo '</div>';
	}
	?>
</div><!-- /.profile-section-container -->