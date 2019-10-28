<!--
php/rubrics-header.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the flex-rubric description at the top of rubric pages
It is included in 'php/content/content-rubrics.php' and 'php/content/content-rubric-create.php' for display on the rubric evaluation and creation pages
-->

<?php
if($reviewID != NULL) 	{ $rubricsPageHeader = 'Flex-Rubric Evaluation'; }
else					{ $rubricsPageHeader = 'The CTR Flex-Rubric';	}
?>

<!-- PAGE HEADER -->
<div id = "rubrics-page-header" class = "rubrics-heading bottom-10"><?php echo $rubricsPageHeader; ?></div>

<!-- PAGE SUBHEADER - TOGGLE FLEX-RUBRIC DESCRIPTION -->
<div id = "rubrics-page-subheader" class = "subheader bottom-10">
	<div class = "inline">CTR's tool for evaluating interactive media using an adaptable set of criteria</div>
	<div class = "inline pointer">
		<div id = "show-flex-description" 
			onclick = "showItem('show-flex-description', 'hide-flex-description', 'flex-description')">&#9660;
		</div>
		<div class = "hide" id = "hide-flex-description" 
			onclick = "hideItem('show-flex-description', 'hide-flex-description', 'flex-description')">&#9650;
		</div><!-- /.hide #hide-flex-description -->
	</div><!-- /.inline pointer -->
</div><!-- /.subheader -->

<!-- TOGGLEABLE DESCRIPTION -->
<div id = "flex-description" class = "hide">
<div class = "flex-info">

	<!-- DESCRIPTION -->
	<div class = "paragraph left bottom-10">
		The Flex Rubric is CTR's tool for evaluating interactive media using an adaptable set of criteria. Because a single set of criteria may not apply to all types of products, CTR has created an array of rubrics comprised of custom-picked Quality Attributes designed to fit various genres. These Quality Attributes can be weighted by the reviewer depending on the perceived importance of each criterion in any particular case. Publishers and CTR Subscribers can evaluate products with the Flex Rubric on CTREX to share their own opinions and become a part of the exchange. <?php if ($thisPage != 'rubric-create.php') { echo 'A <a href = "rubric-create.php" class = "btn-text-16px">custom rubric creation tool</a> is also available to rate products using up to ten Quality Attributes.'; } ?>
	</div><!-- /.paragraph -->
	
	<!-- LINK TO ALTERNATE RUBRIC PAGE -->
	<div class = "center text-20">
		<?php
		// on the rubric evaluation page (rubrics.php), display a link to the rubric creation page ('rubric-create.php'), and vice-versa
		if($thisPage == 'rubrics.php') 				{ $altRubricPageLink = 'rubric-create.php'; $altRubricPageLabel = 'Create your own rubric'; }
		else if($thisPage == 'rubric-create.php') 	{ $altRubricPageLink = 'rubrics.php'; 		$altRubricPageLabel = 'View CTR Rubrics'; }
		echo '<a href = "'.$altRubricPageLink.'">'.$altRubricPageLabel.'</a>';
		?>
	</div><!-- /.center text-20 -->

</div><!-- /.flex-info -->	
</div><!-- /.hide #flex-description -->