<?php
/*
php/content/content-experts.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the experts page 'experts.php', which displays a list of CTR Expert Reviewers and links to the profile of each
The $expertRecords containing the data for the experts is produced in 'php/find-experts.php'
*/
$paragraphClass = 'paragraph-70'; // use the same class for both the 'about' and the list
require_once 'php/find-experts.php';
?>

<!-- PAGE CONTAINER -->
<div id = "experts-page-container">

	<!-- PAGE HEADER -->
	<div class = "page-header">CTR Expert Reviewers [BETA]</div>

	<!-- VIEW TOGGLE -->
	<?php require_once 'php/view-toggle.php'; ?>

	<!-- ABOUT CTR EXPERT REVIEWERS -->
	<div class = "<?php echo $paragraphClass;?> left bottom-10" id = "experts-info">
		<p>
		CTR Expert Reviewers are a small team of individuals who have been chosen to provide opinion on the latest products. There are different types of experts. Some have demonstrated a mastery about a specific content area like music or math; others may come from an education or technology point of view. Each is described in their bio.
		</p>
		<p>If you are interested in applying to become an expert, please <a href = "contact.php">contact us</a>.</p>
		<p>Here are the current Expert Reviewers:</p>
	</div><!-- /#experts-info -->

	<!-- EXPERTS LIST -->
	<div id = "list-container" class = "block">
	<div id = "experts-list" class = "<?php echo $paragraphClass;?>">
		<?php
		// EXPERTS LIST
		if($numExperts > 0)
		{
			$array = $expertRecords; 
			require 'php/expert-items.php';
		} // end if $numExperts > 0
		
		// STUDENTS LIST
		if($numStudents > 0)
		{
			echo '<br/>';
			echo '<div class = "page-header">Student Reviewers:</div>';
			$array = $studentRecordsArray;
			require 'php/expert-items.php';
		} // end if $numStudents > 0
		
		// BOLOGNA JURORS LIST
		if($numBolognaJurors > 0)
		{
			echo '<br/>';
			echo '<div class = "page-header"><a href = "bolognaragazzi.php" title = "Learn more about the award">BolognaRagazzi Digital Award Jurors</a>:</div>';
			$array = $bolognaJurorRecordsArray;
			require 'php/expert-items.php';
		} // end if $numBolognaJurors > 0
		
		// KAPI JURORS LIST
		if($numKapiJurors > 0)
		{
			echo '<br/>';
			echo '<div class = "page-header"><a href = "kapis.php" title = "Learn more about the award">KAPi Award Jurors</a>:</div>';
			$array = $kapiJurorRecordsArray;
			require 'php/expert-items.php';
		} // end if $numKapiJurors > 0
		?>
	</div><!-- #experts-list -->
	</div><!-- #list-container -->

	<!-- GRID VIEW -->
	<div id = "grid-container" class = "hide">
	<div id = "experts-grid" class = "paragraph-90">
		<?php
		// EXPERTS (GRID)
		if($numExperts > 0)
		{
			$array = $expertRecords;
            $numRows = $expertRows;
			require 'php/expert-items-grid.php';
		} // end if $numExperts > 0
		
		// STUDENT REVIEWERS (GRID)
		if($numStudents > 0)
		{
			echo '<br/>';
			echo '<div class = "page-header">Student Reviewers:</div>';
			$array 		= $studentRecordsArray;
			$numRows 	= $studentRows;
			require 'php/expert-items-grid.php';
		} // end if $numStudents > 0
		
		// BOLOGNA JURORS (GRID)
		if($numBolognaJurors > 0)
		{
			echo '<br/>';
			echo '<div class = "page-header"><a href = "bolognaragazzi.php" title = "Learn more about the award">BolognaRagazzi Digital Award Jurors</a>:</div>';
			$array 		= $bolognaJurorRecordsArray;
			$numRows 	= $bolognaJurorRows;
			require 'php/expert-items-grid.php';
		} // end if $numBolognaJurors > 0
		
		// KAPI JURORS (GRID)
		if($numKapiJurors > 0)
		{
			echo '<br/>';
			echo '<div class = "page-header"><a href = "kapis.php" title = "Learn more about the award">KAPi Award Jurors</a>:</div>';
			$array 		= $kapiJurorRecordsArray;
			$numRows 	= $kapiJurorRows;
			require 'php/expert-items-grid.php';
		} // end if $numKapiJurors > 0
		?>
	</div><!-- /#experts-grid -->
	</div><!-- /#grid-container -->

	<a href = "#" class = "no-print">Back to top</a>

</div><!-- /#experts-page-container -->