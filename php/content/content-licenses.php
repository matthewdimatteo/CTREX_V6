<?php
/*
php/content/content-licenses.php
By Matthew DiMatteo, Children's Technology Review

This is the content file for the Site License page 'licenses.php'
*/
require_once 'php/license-tiers.php'; 		// contains values for the tier table
require_once 'php/license-calc-get.php';	// get cost calculator values from $_SESSION storage
?>
<div class = "page-header">Site License Cost Estimator</div>
<div id = "site-license-page-content" class = "full-width center">

	<!-- DESCRIPTION -->
	<div class = "inline left halves" id = "site-license-description">
		<p>
		Site Licensing is available for schools or libraries to provide their users password-free access to the <a href = "home.php">CTREX Database</a> through a custom URL or IP Filtering. <a href = "license-faq.php">For more info, read our FAQ</a>.
		</p>
		<p>
		You can specify multiple Site Administrators for your organization. Each will receive their own user profile, which includes an Admin Panel to manage contact information for the organization.
		</p>
		<p>
		Pricing is tiered based on the number of admin accounts and patron terminals.
		</p>
		<p>
		Enter the number of administrator accounts you need and the number of patron terminals for your organization and estimate your cost using the tool below:
		</p>
	</div><!-- /.inline left halves #site-license-description -->
	
	<!-- TIER TABLE, COST CALCULATOR -->
	<div class = "inline left halves" id = "tier-table-container">
	
		<!-- TIER TABLE -->
		<table id = "tier-table">
			<tr class = "bold"><td>Amount</td><td>Cost/Admin</td><td>Cost/Terminal</td></tr>
			<?php
			$t = -1;
			$n = 0;
			foreach($tiers as $tierItem)
			{
				$t += 1;
				$n += 1;
				$tierLabel 		= $tiers[$t][0];
				$adminTierRate 	= $tiers[$t][1];
				$patronTierRate = $tiers[$t][2];
				echo '<tr><td>'.$tierLabel.'</td><td>$'.$adminTierRate.' ea.</td><td>$'.$patronTierRate.' ea.</td></tr>';
			}	
			?>
		</table>
		
		<?php require_once 'php/license-calc-form.php';?>
		
		<!-- FOOTNOTE -->
		<div class = "row top-20">
			<strong>* For orders over 1000, <a href = "contact.php">contact us</a> to get a quote:</strong><br/>
			Email us at <a href = "mailto:info@childrenstech.com">info@childrenstech.com</a> or call 908-284-0404
		</div>
		
	</div><!-- /.inline left halves #tier-table-container -->
</div><!-- /.full width center #site-license-page-content -->