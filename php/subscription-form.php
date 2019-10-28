<?php
/*
php/subscription-form.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the subscription form, including a pricing bubble and features list
It is included in the files 'php/content/content-subscribe.php' and 'php/content/content-login.php' for display on the subscribe and login pages

The copy for the bubble and features is defined in the 'CSR.fmp12' database's 'dashboard' table
The file 'php/settings.php' gets the values from the fields in this table for display in this file
*/

$hoverText = 'Proceed to secure order form';
?>

<!-- SUBSCRIBE BUBBLE -->
<div class = "page-header" id = "enter"><?php echo $subscriptionPageTitle;?></div>
<div class = "subscribe-bubble">
	<form id = "subscription-form" name = "subscription-form" method = "POST" action = "https://Simplecheckout.authorize.net/payment/CatalogPayment.aspx" target = "_blank">
		<input type = "hidden" name = "LinkId" value ="<?php echo $subscribeLinkID;?>" />
		<div class = "subscribe-bubble-header" title = "<?php echo $hoverText;?>" onclick = "submitForm('subscription-form')">
			<?php echo $subscriptionBubbleHeader;?>
		</div><!-- /#subscribe-bubble-header -->
		<div class = "subscribe-bubble-subheader"><?php echo $subscriptionBubbleSubheader;?></div>
		<div class = "subscribe-bubble-details"><?php echo $subscriptionBubbleText;?></div>
		
		<!-- BUTN FOR 769+ -->
		<div class = "subscribe-bubble-btn show-769-and-above">
			<input type = "submit" value = "<?php echo $subscriptionBtnLabel;?>" title = "<?php echo $hoverText;?>" />
		</div>
		
		<!-- BTN FOR 480 -->
		<div class = "subscribe-bubble-btn show-only-480">
			<div><input type = "submit" value = "Subscription Form" title = "<?php echo $hoverText;?>" /></div>
			<div class = "text-12">Requires Credit Card</div>
		</div>
		
	</form><!-- /#subscription-form -->
	<?php if($promocodeFormInstances < 1) { echo '<br/>'; require 'php/promo-form.php'; } ?>
</div><!-- /.subscribe-bubble -->

<!-- include samples content between bubble and fine print -->
<?php require_once 'php/samples.php';?>
<br/>
<br/>

<!-- SUBSCRIPTION FEATURES LIST -->
<div class = "paragraph-container">
	<div class = "page-header"><?php echo $subscriptionFeaturesHeader;?></div>
	<div id = "subscription-features" class = "paragraph-60 left">
		<ul>
			<?php
				$findFeatures = $fmfeatures->newFindCommand($fmfeaturesLayout);
				$findFeatures->addFindCriterion('copyType', "==features-listitem");
				$findFeatures->addFindCriterion('status', "*");
				$findFeatures->addSortRule('order', 1, FILEMAKER_SORT_ASCEND);
				$featuresResult = $findFeatures->execute();
				if (FileMaker::isError ($featuresResult) ) { echo $featuresResult->getMessage(); exit(); }
				$featuresRecords = $featuresResult->getRecords();
				foreach($featuresRecords as $feature)
				{
					$featureDescription 	= $feature->getField('description');
					$featureLink			= $feature->getField('link');
					echo '<li>';
						if($featureLink != NULL) { echo '<a href = "'.$featureLink.'">'; }
						echo $featureDescription;
						if($featureLink != NULL) { echo '</a>'; }
					echo '</li>';	
				}
				echo '<br>';
				$findFeatures = $fmfeatures->newFindCommand('features');
				$findFeatures->addFindCriterion('copyType', "==footnote-listitem");
				$findFeatures->addFindCriterion('status', "*");
				$findFeatures->addSortRule('order', 1, FILEMAKER_SORT_ASCEND);
				$featuresResult = $findFeatures->execute();
				if (FileMaker::isError ($featuresResult) ) { echo $featuresResult->getMessage(); exit(); }
				$featuresRecords = $featuresResult->getRecords();
				foreach($featuresRecords as $feature)
				{
					$featureDescription 	= $feature->getField('description');
					$featureLink			= $feature->getField('link');
					echo '<li>';
						if($featureLink != NULL) { echo '<a href = "'.$featureLink.'">'; }
						echo $featureDescription;
						if($featureLink != NULL) { echo '</a>'; }
					echo '</li>';	
				}
			?>     
		</ul>
	</div><!-- /.paragraph #subscription-features -->
	<div>Thanks for supporting our work.</div>
</div><!-- /.paragraph-container -->